'use strict';

const ADDED_TO_CART_EVENT = "added_to_cart";
const PRODUCT_LIST_AJAX_SHOP_PAGE = "maia_products_list_ajax";
const PRODUCT_GRID_AJAX_SHOP_PAGE = "maia_products_grid_ajax";

class AjaxCart {
  constructor() {
    if (typeof maia_settings === "undefined") return;

    let _this = this;

    _this.ajaxCartPosition = maia_settings.cart_position;

    switch (_this.ajaxCartPosition) {
      case "popup":
        _this._initAjaxPopup();

        break;

      case "left":
        _this._initAjaxCartOffCanvas("left");

        break;

      case "right":
        _this._initAjaxCartOffCanvas("right");

        break;
    }

    _this._initEventRemoveProduct();

    _this._initEventMiniCartAjaxQuantity();
  }

  _initAjaxPopupContent(button) {
    var _this = this;

    if (button.closest('form.cart').find('input[name="maia_buy_now"]').length > 0 && button.closest('form.cart').find('input[name="maia_buy_now"]').val() === "1") return;
    let title = '';

    if (button.closest('form.cart').length > 0) {
      let form = button.closest('form.cart'),
          variation_id = $(form).find('input[name="variation_id"]').length ? parseInt($(form).find('input[name="variation_id"]').val()) : 0;
      if ($(form).find('input[name="data-type"]').length === 0) return;

      if (variation_id !== 0) {
        var urlAjax = maia_settings.wc_ajax_url.toString().replace('%%endpoint%%', 'maia_popup_variation_name');
        title = _this._initAjaxPopupVariationName(variation_id, urlAjax);
      } else {
        title = button.closest('.product').find('.product_title').html();
      }
    } else {
      title = button.closest('.product').find('.name  a').html();
    }

    if (typeof title === "undefined") return;

    _this._initAjaxPopupShow(title);
  }

  _initAjaxPopupShow(title) {
    let cart_popup = $('#tbay-cart-popup'),
        cart_popup_content = $('#tbay-cart-popup').find('.toast-body'),
        cart_notification = maia_settings.popup_cart_noti,
        string = '';
    string += maia_settings.popup_cart_icon;
    string += `<p>"${title}" ${cart_notification}</p>`;

    if (!wc_add_to_cart_params.is_cart) {
      string += `<a href="${wc_add_to_cart_params.cart_url}" title="${wc_add_to_cart_params.i18n_view_cart}">${wc_add_to_cart_params.i18n_view_cart}</a>`;
    }

    if (typeof string !== "undefined") {
      cart_popup_content.html(string);
    }

    cart_popup.toast('show');
  }

  _initAjaxPopupVariationName(variation_id, urlAjax) {
    var _this = this;

    $.ajax({
      url: urlAjax,
      data: {
        variation_id: variation_id,
        security: maia_settings.wp_popupvariationnamenonce
      },
      dataType: 'json',
      method: 'POST',
      success: function (data) {
        _this._initAjaxPopupShow(data);
      }
    });
  }

  _initAjaxPopup() {
    var _this = this;

    if (typeof wc_add_to_cart_params === 'undefined') {
      return false;
    }

    if (maia_settings.ajax_popup_quick) {
      jQuery(`.ajax_cart_popup`).on('click', '.ajax_add_to_cart, .single_add_to_cart_button', function (e) {
        let button = $(this);
        if (button.parent().hasClass('shop-now') && !button.parent().hasClass('ajax-single-cart')) return;

        _this._initAjaxPopupContent(button);
      });
    } else {
      jQuery(`.ajax_cart_popup, .single_add_to_cart_button`).on(ADDED_TO_CART_EVENT, function (ev, fragmentsJSON, cart_hash, button) {
        if (typeof fragmentsJSON == 'undefined') fragmentsJSON = JSON.parse(sessionStorage.getItem(wc_cart_fragments_params.fragment_name));

        _this._initAjaxPopupContent(button);
      });
    }
  }

  _initAjaxCartOffCanvas(position) {
    jQuery(`.ajax_cart_${position}`).on(ADDED_TO_CART_EVENT, function () {
      if (maia_settings.mobile) position = 'mobile';
      var Offcanvasopen = new bootstrap.Offcanvas(`#cart-offcanvas-${position}`);
      Offcanvasopen.show();
      $(document.body).trigger('wc_fragments_refreshed');
      jQuery.magnificPopup.close();
    });
  }

  _initEventRemoveProduct() {
    if (typeof wc_add_to_cart_params === 'undefined') {
      return false;
    }

    $(document).on('click', '.mini_cart_content a.remove', event => {
      this._onclickRemoveProduct(event);
    });
  }

  _onclickRemoveProduct(event) {
    event.preventDefault();
    var product_id = $(event.currentTarget).attr("data-product_id"),
        cart_item_key = $(event.currentTarget).attr("data-cart_item_key"),
        thisItem = $(event.currentTarget).closest('.widget_shopping_cart_content');

    this._callRemoveProductAjax(product_id, cart_item_key, thisItem, event);
  }

  _callRemoveProductAjax(product_id, cart_item_key, thisItem, event) {
    var urlAjax = maia_settings.wc_ajax_url.toString().replace('%%endpoint%%', 'maia_product_remove');
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: urlAjax,
      data: {
        product_id: product_id,
        cart_item_key: cart_item_key,
        security: maia_settings.wp_productremovenonce
      },
      beforeSend: function () {
        thisItem.find('.mini_cart_content').append('<div class="ajax-loader-wapper"><div class="ajax-loader"></div></div>').fadeTo("slow", 0.3);
      },
      success: response => {
        this._onRemoveSuccess(response, product_id);

        $(document.body).trigger('removed_from_cart');
      }
    });
  }

  _onRemoveSuccess(response, product_id) {
    if (!response || response.error) return;
    var fragments = response.fragments;

    if (fragments) {
      $.each(fragments, function (key, value) {
        $(key).replaceWith(value);
      });
    }

    $('.add_to_cart_button.added[data-product_id="' + product_id + '"]').removeClass("added").next('.wc-forward').remove();
  }

  _initEventMiniCartAjaxQuantity() {
    $('body').on('change', '.mini-cart-item .qty', function () {
      var urlAjax = maia_settings.wc_ajax_url.toString().replace('%%endpoint%%', 'maia_quantity_mini_cart'),
          input = $(this),
          wrap = $(input).parents('.mini_cart_content'),
          hash = $(input).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1"),
          max = parseFloat($(input).attr('max'));

      if (!max) {
        max = false;
      }

      var quantity = parseFloat($(input).val());

      if (max > 0 && quantity > max) {
        $(input).val(max);
        quantity = max;
      }

      $.ajax({
        url: urlAjax,
        type: 'POST',
        dataType: 'json',
        cache: false,
        data: {
          hash: hash,
          quantity: quantity,
          security: maia_settings.wp_minicartquantitynonce
        },
        beforeSend: function () {
          wrap.append('<div class="ajax-loader-wapper"><div class="ajax-loader"></div></div>').fadeTo("slow", 0.3);
        },
        success: function (data) {
          if (data && data.fragments) {
            $.each(data.fragments, function (key, value) {
              if ($(key).length) {
                $(key).replaceWith(value);
              }
            });

            if (typeof $supports_html5_storage !== 'undefined' && $supports_html5_storage) {
              sessionStorage.setItem(wc_cart_fragments_params.fragment_name, JSON.stringify(data.fragments));
              set_cart_hash(data.cart_hash);

              if (data.cart_hash) {
                set_cart_creation_timestamp();
              }
            }

            $(document.body).trigger('wc_fragments_refreshed');
          }
        }
      });
    });
  }

}

class WishList {
  constructor() {
    this._onChangeWishListItem();
  }

  _onChangeWishListItem() {
    jQuery(document).on('added_to_wishlist removed_from_wishlist', () => {
      var counter = jQuery('.count_wishlist').find('> span');
      if (counter.length === 0) return;
      var urlAjax = maia_settings.wc_ajax_url.toString().replace('%%endpoint%%', 'maia_update_wishlist_count');
      $.ajax({
        url: urlAjax,
        type: 'POST',
        data: {
          security: maia_settings.wp_wishlistcountnonce
        },
        dataType: 'json',
        success: function (data) {
          counter.html(data.count);
        },
        beforeSend: function () {
          counter.block({
            message: null,
            overlayCSS: {
              background: '#fff url(' + maia_settings.loader + ') no-repeat center',
              opacity: 0.5,
              cursor: 'none'
            }
          });
        },
        complete: function () {
          counter.unblock();
        }
      });
    });
  }

}

class ProductItem {
  _initAddButtonQuantity() {
    let input = $('.quantity input');
    input.each(function () {
      if ($(this).parent('.box').length) return;
      $(this).wrap('<span class="box"></span>');
      $(`<button class="minus" type="button" value="&nbsp;">${maia_settings.quantity_minus}</button>`).insertBefore($(this));
      $(`<button class="plus" type="button" value="&nbsp;">${maia_settings.quantity_plus}</button>`).insertAfter($(this));
    });
  }

  _initOnChangeQuantity(callback) {
    if (typeof maia_settings === "undefined") return;

    this._initAddButtonQuantity();

    $(document).off('click', '.plus, .minus').on('click', '.plus, .minus', function (event) {
      event.preventDefault();
      var qty = jQuery(this).closest('.quantity').find('.qty'),
          currentVal = parseFloat(qty.val()),
          max = $(qty).attr("max"),
          min = $(qty).attr("min"),
          step = $(qty).attr("step");
      currentVal = !currentVal || currentVal === '' || currentVal === 'NaN' ? 0 : currentVal;
      max = max === '' || max === 'NaN' ? '' : max;
      min = min === '' || min === 'NaN' ? 0 : min;
      step = step === 'any' || step === '' || step === undefined || parseFloat(step) === NaN ? 1 : step;

      if ($(this).is('.plus')) {
        if (max && (max == currentVal || currentVal > max)) {
          qty.val(max);
        } else {
          qty.val(currentVal + parseFloat(step));
        }
      } else {
        if (min && (min == currentVal || currentVal < min)) {
          qty.val(min);
        } else if (currentVal > 1) {
          qty.val(currentVal - parseFloat(step));
        }
      }

      if (callback && typeof callback == "function") {
        $(this).parent().find('input').trigger("change");
        callback();
      }
    });
  }

  _initSwatches() {
    if ($('.tbay-swatches-wrapper li a').length === 0) return;
    $('body').on('click', '.tbay-swatches-wrapper li a', function (event) {
      event.preventDefault();
      let $active = false;
      let $parent = $(this).closest('.product-block');
      var $image = $parent.find('.image img:eq(0)');

      if (!$(this).closest('ul').hasClass('active')) {
        $(this).closest('ul').addClass('active');
        $image.attr('data-old', $image.attr('src'));
      }

      if (!$(this).hasClass('selected')) {
        $(this).closest('ul').find('li a').each(function () {
          if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
          }
        });
        $(this).addClass('selected');
        $parent.addClass('product-swatched');
        $active = true;
      } else {
        $image.attr('src', $image.data('old'));
        $(this).removeClass('selected');
        $parent.removeClass('product-swatched');
      }

      if (!$active) return;

      if (typeof $(this).data('imageSrc') !== 'undefined') {
        $image.attr('src', $(this).data('imageSrc'));
      }

      if (typeof $(this).data('imageSrcset') !== 'undefined') {
        $image.attr('srcset', $(this).data('imageSrcset'));
      }

      if (typeof $(this).data('imageSizes') !== 'undefined') {
        $image.attr('sizes', $(this).data('imageSizes'));
      }
    });
  }

  _initQuantityMode() {
    if (typeof maia_settings === "undefined" || !maia_settings.quantity_mode) return;
    $(".woocommerce .products").on("click", ".quantity .qty", function () {
      return false;
    });
    $(".woocommerce .products").on("change input", ".quantity .qty", function () {
      var add_to_cart_button = $(this).parents(".product").find(".add_to_cart_button");
      add_to_cart_button.attr("data-quantity", $(this).val());
    });
    $(".woocommerce .products").on("keypress", ".quantity .qty", function (e) {
      if ((e.which || e.keyCode) === 13) {
        $(this).parents(".product").find(".add_to_cart_button").trigger("click");
      }
    });
  }

}

class Cart {
  constructor() {
    this._initEventChangeQuantity();

    this._init_shipping_free_notification();

    $(document.body).on('updated_wc_div', () => {
      this._initEventChangeQuantity();

      if (typeof wc_add_to_cart_variation_params !== 'undefined') {
        $('.variations_form').each(function () {
          $(this).wc_variation_form();
        });
      }
    });
    $(document.body).on('cart_page_refreshed', () => {
      this._initEventChangeQuantity();
    });
    $(document.body).on('tbay_display_mode', () => {
      this._initEventChangeQuantity();
    });
  }

  _initEventChangeQuantity() {
    if ($("body.woocommerce-cart [name='update_cart']").length === 0) {
      new ProductItem()._initOnChangeQuantity(() => {});
    } else {
      new ProductItem()._initOnChangeQuantity(() => {
        $('.woocommerce-cart-form :input[name="update_cart"]').prop('disabled', false);

        if (typeof maia_settings !== "undefined" && maia_settings.ajax_update_quantity) {
          $("[name='update_cart']").trigger('click');
        }
      });
    }
  }

  _init_shipping_free_notification() {
    if (jQuery('.tbay-total-condition').length > 0) {
      jQuery('.tbay-total-condition').each(function () {
        if (!jQuery(this).hasClass('tbay-active')) {
          jQuery(this).addClass('tbay-active');
          var per = jQuery(this).attr('data-per');
          jQuery(this).find('.tbay-total-condition-hint, .tbay-subtotal-condition').css({
            'width': per + '%'
          });
        }
      });
    }
  }

}

class Checkout {
  constructor() {
    this._toogleWoocommerceIcon();
  }

  _toogleWoocommerceIcon() {
    if ($('.woocommerce-info a').length < 1) {
      return;
    }

    $('.woocommerce-info a').click(function () {
      $(this).find('.icons').toggleClass('icon-arrow-down').toggleClass('icon-arrow-up');
    });
  }

}

class WooCommon {
  constructor() {
    this._tbayFixRemove();

    $(document.body).on('tbayFixRemove', () => {
      this._tbayFixRemove();
    });
  }

  _tbayFixRemove() {
    $('.tbay-gallery-varible .woocommerce-product-gallery__trigger').remove();
  }

}

class QuickView {
  constructor() {
    if (typeof maia_settings === "undefined") return;

    this._init_tbay_quick_view();
  }

  _init_tbay_quick_view() {
    var _this = this;

    $(document).off('click', 'a.qview-button').on('click', 'a.qview-button', function (e) {
      e.preventDefault();
      let self = $(this);
      self.parent().addClass('loading');
      let mainClass = self.attr('data-effect');
      let is_blocked = false,
          product_id = $(this).data('product_id'),
          url = maia_settings.wc_ajax_url.toString().replace('%%endpoint%%', 'maia_quickview_product') + '&product_id=' + product_id;

      if (typeof maia_settings.loader !== 'undefined') {
        is_blocked = true;
        self.block({
          message: null,
          overlayCSS: {
            background: '#fff url(' + maia_settings.loader + ') no-repeat center',
            opacity: 0.5,
            cursor: 'none'
          }
        });
      }

      _this._ajax_call(self, url, is_blocked, mainClass);

      e.stopPropagation();
    });
  }

  _ajax_call(self, url, is_blocked, mainClass) {
    $.get(url, function (data, status) {
      $.magnificPopup.open({
        removalDelay: 0,
        closeMarkup: '<button title="%title%" type="button" class="mfp-close"> ' + maia_settings.close + '</button>',
        callbacks: {
          beforeOpen: function () {
            this.st.mainClass = mainClass + ' maia-quickview';
          }
        },
        items: {
          src: data,
          type: 'inline'
        }
      });
      let qv_content = $("#tbay-quick-view-content");
      let form_variation = qv_content.find('.variations_form');

      if (typeof wc_add_to_cart_variation_params !== 'undefined') {
        form_variation.each(function () {
          $(this).wc_variation_form();
        });
      }

      if (typeof wc_single_product_params !== 'undefined') {
        qv_content.find('.woocommerce-product-gallery').each(function () {
          $(this).wc_product_gallery(wc_single_product_params);
        });
      }

      $(document.body).trigger('updated_wc_div');
      self.parent().removeClass('loading');

      if (is_blocked) {
        self.unblock();
      }

      $(document.body).trigger('tbay_quick_view');
    });
  }

}

class StickyBar {
  constructor() {
    if (typeof jQuery.fn.onePageNav === "undefined") return;

    this._productSingleOnepagenav();
  }

  _productSingleOnepagenav() {
    if ($('#sticky-menu-bar').length > 0) {
      let offset_adminbar = 0;

      if ($('#wpadminbar').length > 0) {
        offset_adminbar = $('#wpadminbar').outerHeight();
      }

      let offset = $('#sticky-menu-bar').outerHeight() + offset_adminbar;
      $('#sticky-menu-bar').onePageNav({
        currentClass: 'current',
        changeHash: false,
        scrollSpeed: 750,
        scrollThreshold: 0.5,
        scrollOffset: offset,
        filter: '',
        easing: 'swing',
        begin: function () {},
        end: function () {},
        scrollChange: function () {}
      });
    }

    var onepage = $('#sticky-menu-bar');

    if (onepage.length > 0) {
      var tbay_width = $(window).width();
      $('.tbay_header-template').removeClass('main-sticky-header');
      var btn_cart_offset = $('.single_add_to_cart_button').length > 0 ? $('.single_add_to_cart_button').offset().top : 0;
      var out_of_stock_offset = $('div.product .out-of-stock').length > 0 ? $('div.product .out-of-stock').offset().top : 0;

      if ($('.by-vendor-name-link').length > 0) {
        out_of_stock_offset = $('.by-vendor-name-link').offset().top;
      }

      var sum_height = $('.single_add_to_cart_button').length > 0 ? btn_cart_offset : out_of_stock_offset;

      this._checkScroll(tbay_width, sum_height, onepage);

      $(window).scroll(() => {
        this._checkScroll(tbay_width, sum_height, onepage);
      });
    }

    if (onepage.hasClass('active') && jQuery('#wpadminbar').length > 0) {
      onepage.css('top', $('#wpadminbar').height());
    }
  }

  _checkScroll(tbay_width, sum_height, onepage) {
    if (tbay_width >= 768) {
      var NextScroll = $(window).scrollTop();

      if (NextScroll > sum_height) {
        onepage.addClass('active');

        if (jQuery('#wpadminbar').length > 0) {
          onepage.css('top', $('#wpadminbar').height());
        }
      } else {
        onepage.removeClass('active');
      }
    } else {
      onepage.removeClass('active');
    }
  }

}

class DisplayMode {
  constructor() {
    if (typeof maia_settings === "undefined") return;

    this._initModeListShopPage();

    this._initModeGridShopPage();

    $(document.body).on('displayMode', () => {
      this._initModeListShopPage();

      this._initModeGridShopPage();
    });
  }

  _initModeListShopPage() {

    $('#display-mode-list').each(function (index) {
      $(this).click(function () {
        if ($(this).hasClass('active')) return;
        var event = $(this),
            urlAjax = maia_settings.wc_ajax_url.toString().replace('%%endpoint%%', PRODUCT_LIST_AJAX_SHOP_PAGE);
        $.ajax({
          url: urlAjax,
          data: {
            query: maia_settings.posts,
            security: maia_settings.wp_productslistnonce
          },
          dataType: 'json',
          method: 'POST',
          beforeSend: function (xhr) {
            event.closest('#tbay-main-content').find('.display-products').addClass('load-ajax');
          },
          success: function (data) {
            if (data) {
              event.parent().children().removeClass('active');
              event.addClass('active');
              event.closest('#tbay-main-content').find('.display-products > div').html(data);
              event.closest('#tbay-main-content').find('.display-products').fadeOut(0, function () {
                $(this).addClass('products-list').removeClass('products-grid grid').fadeIn(300);
              });

              if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                $('.variations_form').each(function () {
                  $(this).wc_variation_form().find('.variations select:eq(0)').trigger('change');
                });
              }

              $(document.body).trigger('tbay_display_mode');
              event.closest('#tbay-main-content').find('.display-products').removeClass('load-ajax');
              Cookies.set('maia_display_mode', 'list', {
                expires: 0.1,
                path: '/'
              });
            }
          }
        });
        return false;
      });
    });
  }

  _initModeGridShopPage() {

    $('#display-mode-grid').each(function (index) {
      $(this).click(function () {
        if ($(this).hasClass('active')) return;
        var event = $(this),
            urlAjax = maia_settings.wc_ajax_url.toString().replace('%%endpoint%%', PRODUCT_GRID_AJAX_SHOP_PAGE);
        let products = event.closest('#tbay-main-content').find('div.display-products');
        $.ajax({
          url: urlAjax,
          data: {
            query: maia_settings.posts,
            security: maia_settings.wp_productsgridnonce
          },
          dataType: 'json',
          method: 'POST',
          beforeSend: function (xhr) {
            event.closest('#tbay-main-content').find('.display-products').addClass('load-ajax');
          },
          success: function (data) {
            if (data) {
              event.parent().children().removeClass('active');
              event.addClass('active');
              event.closest('#tbay-main-content').find('.display-products > div').html(data);
              let products = event.closest('#tbay-main-content').find('div.display-products');
              products.fadeOut(0, function () {
                $(this).addClass('products-grid').removeClass('products-list').fadeIn(300);
              });

              if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                $('.variations_form').each(function () {
                  $(this).wc_variation_form().find('.variations select:eq(0)').trigger('change');
                });
              }

              $(document.body).trigger('tbay_display_mode');
              event.closest('#tbay-main-content').find('.display-products').removeClass('load-ajax');
              Cookies.set('maia_display_mode', 'grid', {
                expires: 0.1,
                path: '/'
              });
            }
          }
        });
        return false;
      });
    });
  }

}

class AjaxFilter {
  constructor() {
    this._intAjaxFilter();
  }

  _intAjaxFilter() {
    jQuery(document).on("woof_ajax_done", woof_ajax_done_handler);

    function woof_ajax_done_handler(e) {
      jQuery('.woocommerce-product-gallery').each(function () {
        jQuery(this).wc_product_gallery();
      });
      jQuery(document.body).trigger('tbayFixRemove');
      jQuery(document.body).trigger('displayMode');
      jQuery(document.body).trigger('ajax_sidebar_shop_mobile');

      if ($('body').hasClass('filter-mobile-active')) {
        $("body").removeClass('filter-mobile-active');
      }

      if (typeof tawcvs_variation_swatches_form !== 'undefined') {
        $('.variations_form').tawcvs_variation_swatches_form();
        $(document.body).trigger('tawcvs_initialized');
      }

      jQuery('.variations_form').each(function () {
        jQuery(this).wc_variation_form();
      });
    }
  }

}

class ShopProduct {
  constructor() {
    var _this = this;

    _this._SidebarShopMobile();

    $(document.body).on('ajax_sidebar_shop_mobile', () => {
      _this._SidebarShopMobile();

      $('.filter-btn-wrapper').removeClass('active');
      $("body").removeClass('filter-mobile-active');
    });
  }

  _SidebarShopMobile() {
    let btn_filter = $("#button-filter-btn"),
        btn_close = $("#filter-close,.close-side-widget");
    btn_filter.on("click", function (e) {
      $('.filter-btn-wrapper').addClass('active');
      $("body").addClass('filter-mobile-active');
    });
    btn_close.on("click", function (e) {
      $('.filter-btn-wrapper').removeClass('active');
      $("body").removeClass('filter-mobile-active');
    });
  }

}

class SingleProduct {
  constructor() {
    var _this = this;

    _this._intStickyMenuBar();

    _this._intNavImage();

    _this._intReviewPopup();

    _this._intShareMobile();

    _this._intTabsMobile();

    _this._initBuyNow();

    _this._initChangeImageVarible();

    _this._initOpenAttributeMobile();

    _this._initCloseAttributeMobile();

    _this._initCloseAttributeMobileWrapper();

    _this._initAddToCartClickMobile();

    _this._initBuyNowwClickMobile();

    _this._initAjaxSingleCart();

    jQuery(document.body).on('tbay_quick_view', () => {
      _this._initBuyNow();

      _this._initAjaxSingleCart();
    });
  }

  _intStickyMenuBar() {
    if (jQuery('#sticky-custom-add-to-cart').length === 0) return;
    $('body').on('click', '#sticky-custom-add-to-cart', function (event) {
      $('#shop-now .single_add_to_cart_button').click();
      event.stopPropagation();
    });
  }

  _intNavImage() {
    $(window).scroll(function () {
      let isActive = $(this).scrollTop() > 400;
      $('.product-nav').toggleClass('active', isActive);
    });
  }

  _intReviewPopup() {
    if ($('#list-review-images').length === 0) return;
    var container = [];
    $('#list-review-images').find('.review-item').each(function () {
      var $link = $(this).find('.review-link'),
          item = {
        src: $link.attr('href'),
        w: $link.data('width'),
        h: $link.data('height'),
        title: $link.children('.caption').html()
      };
      container.push(item);
    });
    $('#list-review-images > ul> li a').off('click').on('click', function (event) {
      event.preventDefault();
      var $pswp = $('.pswp')[0],
          options = {
        index: $(this).parents('.review-item').index(),
        showHideOpacity: true,
        closeOnVerticalDrag: false,
        mainClass: 'pswp-review-images'
      };
      var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
      gallery.init();
      event.stopPropagation();
    });
  }

  _intShareMobile() {
    let share = $('.woo-share-mobile'),
        close = $('.image-mains .show-mobile .woo-share-mobile .share-content .share-header .share-close i');
    share.find('button').click(function () {
      $(event.target).parents('.woo-share-mobile').toggleClass("open");
      $('body').toggleClass("overflow-y");
    });
    let win_share = $(window);
    let forcusshare = $('.woo-share-mobile button, .woo-share-mobile button i, .woo-share-mobile .content, .woo-share-mobile .share-title, .woo-share-mobile .share-close');
    win_share.on("click.Bst", function (event) {
      if (!share.hasClass('open')) return;

      if (forcusshare.has(event.target).length == 0 && !forcusshare.is(event.target)) {
        share.removeClass("open");
        $('body').removeClass("overflow-y");
      }
    });
    close.on("click", function () {
      share.removeClass("open");
      $('body').removeClass("overflow-y");
    });
  }

  _intTabsMobile() {
    let tabs = $('.woocommerce-tabs-sidebar'),
        click = tabs.find('.tabs-sidebar a'),
        close = tabs.find('.close-tab, #tab-sidebar-close'),
        body = $('body'),
        sidebar = $('.tabs-sidebar'),
        screen = window.matchMedia("(max-width: 1199px)");
    if (tabs.length === 0) return;
    click.on("click", function (e) {
      e.preventDefault();
      let tabid = $(this).data('tabid');
      sidebar.addClass('open');
      tabs.find('.wc-tab-sidebar').removeClass('open');
      $('#' + tabid).addClass('open');

      if (screen.matches) {
        body.addClass('overflow-y');
      }
    });
    close.on("click", function (e) {
      e.preventDefault();
      sidebar.removeClass('open');
      $(this).closest('.woocommerce-tabs-sidebar').find('.wc-tab-sidebar').removeClass('open');

      if (screen.matches) {
        body.removeClass('overflow-y');
      }
    });
  }

  _initBuyNow() {
    if ($('.tbay-buy-now').length === 0) return;
    $('body').on('click', '.tbay-buy-now', function (e) {
      e.preventDefault();
      let productform = $(this).closest('form.cart'),
          submit_btn = productform.find('[type="submit"]'),
          buy_now = productform.find('input[name="maia_buy_now"]'),
          is_disabled = submit_btn.is('.disabled');

      if (is_disabled) {
        submit_btn.trigger('click');
      } else {
        buy_now.val('1');
        productform.find('.single_add_to_cart_button').trigger('click');
      }
    });
    $(document.body).on('check_variations', function () {
      let btn_submit = $('form.variations_form').find('.single_add_to_cart_button');
      btn_submit.each(function (index) {
        let is_submit_disabled = $(this).is('.disabled');

        if (is_submit_disabled) {
          $(this).parent().find('.tbay-buy-now').addClass('disabled');
        } else {
          $(this).parent().find('.tbay-buy-now').removeClass('disabled');
        }
      });
    });
  }

  _initFeatureVideo() {
    if (typeof maia_settings === "undefined") return;
    let featured = $(document).find(maia_settings.img_class_container + '.tbay_featured_content');
    if (featured.length === 0) return;
    let featured_index = featured.index(),
        featured_gallery_thumbnail = $(maia_settings.thumbnail_gallery_class_element).get(featured_index);
    $(featured_gallery_thumbnail).addClass('tbay_featured_thumbnail');
  }

  _initChangeImageVarible() {
    let form = $(".information form.variations_form");
    if (form.length === 0) return;
    form.on('change', function () {
      var _this = $(this);

      var attribute_label = [];

      _this.find('.variations tr').each(function () {
        if (typeof $(this).find('select').val() !== "undefined") {
          attribute_label.push($(this).find('select option:selected').text());
        }
      });

      _this.parent().find('.mobile-attribute-list .value').empty().append(attribute_label.join('/ '));

      if (form.find('.single_variation_wrap .single_variation').is(':empty')) {
        form.find('.mobile-infor-wrapper .infor-body').empty().append(form.parent().children('.price').html()).wrapInner('<p class="price"></p>');
      } else if (!form.find('.single_variation_wrap .single_variation .woocommerce-variation-price').is(':empty')) {
        form.find('.mobile-infor-wrapper .infor-body').empty().append(form.find('.single_variation_wrap .single_variation').html());
      } else {
        form.find('.mobile-infor-wrapper .infor-body').empty().append(form.find('.single_variation_wrap .single_variation').html());
        form.find('.mobile-infor-wrapper .infor-body .woocommerce-variation-price').empty().append(form.parent().children('.price').html()).wrapInner('<p class="price"></p>');
      }
    });
    setTimeout(function () {
      jQuery(document.body).on('reset_data', () => {
        form.find('.mobile-infor-wrapper .infor-body .woocommerce-variation-availability').empty();
        form.find('.mobile-infor-wrapper .infor-body').empty().append(form.parent().children('.price').html()).wrapInner('<p class="price"></p>');
        return;
      });
      jQuery(document.body).on('woocommerce_gallery_init_zoom', () => {
        let src_image = $(".flex-control-thumbs").find('.flex-active').attr('src');
        $('.mobile-infor-wrapper img').attr('src', src_image);
      });
      jQuery(document.body).on('mobile_attribute_open', () => {
        if (form.find('.single_variation_wrap .single_variation').is(':empty')) {
          form.find('.mobile-infor-wrapper .infor-body').empty().append(form.parent().children('.price').html());
        } else if (!form.find('.single_variation_wrap .single_variation .woocommerce-variation-price').is(':empty')) {
          form.find('.mobile-infor-wrapper .infor-body').empty().append(form.find('.single_variation_wrap .single_variation').html());
        } else {
          form.find('.mobile-infor-wrapper .infor-body').empty().append(form.find('.single_variation_wrap .single_variation').html());
          form.find('.mobile-infor-wrapper .infor-body .woocommerce-variation-price').empty().append(form.parent().children('.price').html()).wrapInner('<p class="price"></p>');
        }
      });
    }, 1000);
  }

  _initOpenAttributeMobile() {
    let attribute = $("#attribute-open");
    if (attribute.length === 0) return;
    attribute.off().on('click', function () {
      $(this).parent().parent().find('form.cart').addClass('open open-btn-all');
    });
  }

  _initAddToCartClickMobile() {
    let addtocart = $("#tbay-click-addtocart");
    if (addtocart.length === 0) return;
    addtocart.off().on('click', function () {
      $(this).parent().parent().find('form.cart').addClass('open open-btn-addtocart');
    });
  }

  _initBuyNowwClickMobile() {
    let buy_now = $("#tbay-click-buy-now");
    if (buy_now.length === 0) return;
    buy_now.off().on('click', function () {
      $(this).parent().parent().find('form.cart').addClass('open open-btn-buynow');
    });
  }

  _initCloseAttributeMobile() {
    let close = $("#mobile-close-infor");
    if (close.length === 0) return;
    close.off().on('click', function () {
      $(this).parents('form.cart').removeClass('open');

      if ($(this).parents('form.cart').hasClass('open-btn-all')) {
        $(this).parents('form.cart').removeClass('open-btn-all');
      }

      if ($(this).parents('form.cart').hasClass('open-btn-buynow')) {
        $(this).parents('form.cart').removeClass('open-btn-buynow');
      }

      if ($(this).parents('form.cart').hasClass('open-btn-addtocart')) {
        $(this).parents('form.cart').removeClass('open-btn-addtocart');
      }
    });
  }

  _initCloseAttributeMobileWrapper() {
    let close = $("#mobile-close-infor-wrapper");
    if (close.length === 0) return;
    close.off().on('click', function () {
      $(this).parent().find('form.cart').removeClass('open');

      if ($(this).parent().find('form.cart').hasClass('open-btn-all')) {
        $(this).parent().find('form.cart').removeClass('open-btn-all');
      }

      if ($(this).parent().find('form.cart').hasClass('open-btn-buynow')) {
        $(this).parent().find('form.cart').removeClass('open-btn-buynow');
      }

      if ($(this).parent().find('form.cart').hasClass('open-btn-addtocart')) {
        $(this).parent().find('form.cart').removeClass('open-btn-addtocart');
      }
    });
  }

  _initAjaxSingleCart() {
    var _this = this;

    if ($('#shop-now').length > 0 && !$('#shop-now').hasClass('ajax-single-cart')) return;
    $('body').on('click', 'form.cart .single_add_to_cart_button', function () {
      if ($(this).closest('form.cart').find('input[name="maia_buy_now"]').length > 0 && $(this).closest('form.cart').find('input[name="maia_buy_now"]').val() === "1") return;

      var flag_adding = true,
          _this2 = $(this),
          form = $(_this2).parents('form.cart');

      $('body').trigger('maia_before_click_single_add_to_cart', [form]);
      let enable_ajax = $(form).find('input[name="maia-enable-addtocart-ajax"]');

      if ($(enable_ajax).length <= 0 || $(enable_ajax).val() !== '1') {
        flag_adding = false;
        return;
      } else {
        let disabled = $(_this2).hasClass('disabled') || $(_this2).hasClass('maia-ct-disabled') ? true : false,
            product_id = !disabled ? $(form).find('input[name="data-product_id"]').val() : false;

        if (product_id && !$(_this2).hasClass('loading')) {
          let type = $(form).find('input[name="data-type"]').val(),
              quantity = $(form).find('.quantity input[name="quantity"]').val(),
              variation_id = $(form).find('input[name="variation_id"]').length ? parseInt($(form).find('input[name="variation_id"]').val()) : 0,
              variation = {};

          if (type === 'variable' && !variation_id) {
            flag_adding = false;
            return false;
          } else {
            if (variation_id > 0 && $(form).find('.variations').length) {
              $(form).find('.variations').find('select').each(function () {
                variation[$(this).attr('name')] = $(this).val();
              });
            }
          }

          if (flag_adding) {
            _this._callAjaxSingleCart(_this2, product_id, quantity, type, variation_id, variation);
          }
        }

        return false;
      }
    });
  }

  _callAjaxSingleCart(_this, product_id, quantity, type, variation_id, variation) {
    var form = $(_this).parents('form.cart');
    if (type === 'grouped') return;

    if (typeof maia_settings !== 'undefined' && typeof maia_settings.wc_ajax_url !== 'undefined') {
      var urlAjax = maia_settings.wc_ajax_url.toString().replace('%%endpoint%%', 'maia_single_add_to_cart');
      var data = {
        product_id: product_id,
        quantity: quantity,
        product_type: type,
        variation_id: variation_id,
        variation: variation
      };

      if ($(form).length > 0) {
        if (type === 'simple') {
          $(form).find('.maia-custom-fields').append('<input type="hidden" name="add-to-cart" value="' + product_id + '" />');
        }

        data = $(form).serializeArray();
        $(form).find('.maia-custom-fields [name="add-to-cart"]').remove();
      }

      $.ajax({
        url: urlAjax,
        type: 'post',
        dataType: 'json',
        cache: false,
        data: data,
        beforeSend: function () {
          $(_this).removeClass('added');
          $(_this).removeClass('maia-added');
          $(_this).addClass('loading');
        },
        success: function (res) {
          if (!res.error) {
            if (typeof res.redirect !== 'undefined' && res.redirect) {
              window.location.href = res.redirect;
            } else {
              var fragments = res.fragments;

              if (fragments) {
                $.each(fragments, function (key, value) {
                  $(key).addClass('updating');
                  $(key).replaceWith(value);
                });

                if (!$(_this).hasClass('added')) {
                  $(_this).addClass('added');
                }

                if (!$(_this).hasClass('maia-added')) {
                  $(_this).addClass('maia-added');
                }
              }

              $(document.body).trigger('added_to_cart', [res.fragments, res.cart_hash, _this]);
            }
          } else {
            $(_this).removeClass('loading');
          }
        }
      });
    }

    return false;
  }

}

class ProductTabs {
  constructor() {
    if (typeof maia_settings === "undefined") return;

    this._initProductTabs();
  }

  _initProductTabs() {
    var process = false;
    $('.tbay-element-product-tabs.ajax-active').each(function () {
      var $this = $(this);
      $this.find('.product-tabs-title li a').off('click').on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            atts = $this.parent().parent().data('atts'),
            value = $this.data('value'),
            id = $this.attr('data-bs-target'),
            index = $this.index();

        if (process || $(id).hasClass('active-content')) {
          return;
        }

        process = true;
        var urlAjax = maia_settings.wc_ajax_url.toString().replace('%%endpoint%%', 'maia_products_tab_shortcode');
        $.ajax({
          url: urlAjax,
          data: {
            atts: atts,
            value: value,
            security: maia_settings.wp_productstabnonce
          },
          dataType: 'json',
          method: 'POST',
          beforeSend: function (xhr) {
            $(id).parent().addClass('load-ajax');
          },
          success: function (response) {
            if (response.success === true) {
              $(id).html(response.data.html);
              $(id).parent().find('.current').removeClass('current');
              $(id).parent().removeClass('load-ajax');
              $(id).addClass('active-content');
              $(id).addClass('current');
              $(document.body).trigger('tbay_carousel_slick');
              $(document.body).trigger('tbay_ajax_tabs_products');
            } else {
              console.log('loading html products tab ajax returns wrong data');
            }
          },
          error: function () {
            console.log('ajax error');
          },
          complete: function () {
            process = false;
          }
        });
      });
    });
  }

}

class ProductCategoriesTabs {
  constructor() {
    if (typeof maia_settings === "undefined") return;

    this._initProductCategoriesTabs();
  }

  _initProductCategoriesTabs() {
    var process = false;
    $('.tbay-element-product-categories-tabs.ajax-active').each(function () {
      var $this = $(this);
      $this.find('.product-categories-tabs-title li a').off('click').on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            atts = $this.parent().parent().data('atts'),
            value = $this.data('value'),
            id = $this.attr('data-bs-target'),
            index = $this.index();

        if (process || $(id).hasClass('active-content')) {
          return;
        }

        process = true;
        var urlAjax = maia_settings.wc_ajax_url.toString().replace('%%endpoint%%', 'maia_products_categories_tab_shortcode');
        $.ajax({
          url: urlAjax,
          data: {
            atts: atts,
            value: value,
            security: maia_settings.wp_productscategoriestabnonce
          },
          dataType: 'json',
          method: 'POST',
          beforeSend: function (xhr) {
            $(id).parent().addClass('load-ajax');
          },
          success: function (response) {
            if (response.success === true) {
              $(id).html(response.data.html);
              $(id).parent().find('.current').removeClass('current');
              $(id).parent().removeClass('load-ajax');
              $(id).addClass('active-content');
              $(id).addClass('current');
              $(document.body).trigger('tbay_carousel_slick');
              $(document.body).trigger('tbay_ajax_tabs_products');
            } else {
              console.log('loading html products categories tab ajax returns wrong data');
            }
          },
          error: function () {
            console.log('ajax error');
          },
          complete: function () {
            process = false;
          }
        });
      });
    });
  }

}

jQuery(document).ready(() => {
  var product_item = new ProductItem();

  product_item._initSwatches();

  product_item._initQuantityMode();

  jQuery(document.body).trigger('tawcvs_initialized');
  new AjaxCart(), new WishList(), new Cart(), new Checkout(), new WooCommon(), new QuickView(), new StickyBar(), new DisplayMode(), new ShopProduct(), new AjaxFilter(), new SingleProduct(), new ProductTabs(), new ProductCategoriesTabs();
});
setTimeout(function () {
  jQuery(document.body).on('wc_fragments_refreshed wc_fragments_loaded removed_from_cart', function () {
    var product_item = new ProductItem();

    product_item._initAddButtonQuantity();

    var cart = new Cart();

    cart._init_shipping_free_notification();
  });
}, 30);
jQuery(document).ready(function ($) {
  var singleproduct = new SingleProduct();

  singleproduct._initFeatureVideo();
});

var AddButtonQuantity = function ($scope, $) {
  var product_item = new ProductItem();

  product_item._initAddButtonQuantity();
};

jQuery(window).on('elementor/frontend/init', function () {
  if (elementorFrontend.isEditMode() && typeof maia_settings !== "undefined" && Array.isArray(maia_settings.elements_ready.products)) {
    jQuery.each(maia_settings.elements_ready.products, function (index, value) {
      elementorFrontend.hooks.addAction('frontend/element_ready/tbay-' + value + '.default', AddButtonQuantity);
    });
  }
});

var AjaxProductTabs = function ($scope, $) {
  new ProductTabs(), new ProductCategoriesTabs();
};

jQuery(window).on('elementor/frontend/init', function () {
  if (elementorFrontend.isEditMode() && typeof maia_settings !== "undefined" && elementorFrontend.isEditMode() && Array.isArray(maia_settings.elements_ready.ajax_tabs)) {
    jQuery.each(maia_settings.elements_ready.ajax_tabs, function (index, value) {
      elementorFrontend.hooks.addAction('frontend/element_ready/tbay-' + value + '.default', AjaxProductTabs);
    });
  }
});
