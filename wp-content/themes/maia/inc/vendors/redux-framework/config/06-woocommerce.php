<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

$columns            = maia_settings_columns();
$aspect_ratio       = maia_settings_aspect_ratio();

/** WooCommerce Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-shopping-cart',
        'title' => esc_html__('WooCommerce Theme', 'maia'),
        'fields' => array(
            array(
                'title'    => esc_html__('Label Sale Format', 'maia'),
                'id'       => 'sale_tags',
                'type'     => 'radio',
                'options'  => array(
                    'Sale' => esc_html__('Sale', 'maia'),
                    'Save {percent-diff}%' => esc_html__('Save {percent-diff}% (e.g "Save 50%")', 'maia'),
                    'Save {symbol}{price-diff}' => esc_html__('Save {symbol}{price-diff} (e.g "Save $50")', 'maia'),
                    'custom' => esc_html__('Custom Format (e.g -50%, -$50)', 'maia')
                ),
                'default' => 'custom'
            ),
            array(
                'id'        => 'sale_tag_custom',
                'type'      => 'text',
                'title'     => esc_html__('Custom Format', 'maia'),
                'desc'      => esc_html__('{price-diff} inserts the dollar amount off.', 'maia'). '</br>'.
                               esc_html__('{percent-diff} inserts the percent reduction (rounded).', 'maia'). '</br>'.
                               esc_html__('{symbol} inserts the Default currency symbol.', 'maia'),
                'required'  => array('sale_tags','=', 'custom'),
                'default'   => '-{percent-diff}%'
            ),
            array(
                'id' => 'enable_label_featured',
                'type' => 'switch',
                'title' => esc_html__('Enable "Featured" Label', 'maia'),
                'default' => true
            ),
            array(
                'id'        => 'custom_label_featured',
                'type'      => 'text',
                'title'     => esc_html__('"Featured Label" Custom Text', 'maia'),
                'required'  => array('enable_label_featured','=', true),
                'default'   => esc_html__('Featured', 'maia')
            ),
            
            array(
                'id' => 'enable_brand',
                'type' => 'switch',
                'title' => esc_html__('Enable Brand Name', 'maia'),
                'subtitle' => esc_html__('Enable/Disable brand name on HomePage and Shop Page', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'enable_hide_sub_title_product',
                'type' => 'switch',
                'title' => esc_html__('Hide sub title product', 'maia'),
                'default' => false
            ),

            array(
                'id' => 'enable_text_time_coutdown',
                'type' => 'switch',
                'title' => esc_html__('Enable the text of Time Countdown', 'maia'),
                'default' => false
            ),
            
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'product_display_image_mode',
                'type' => 'image_select',
                'title' => esc_html__('Product Image Display Mode', 'maia'),
                'options' => array(
                    'one' => array(
                        'title' => esc_html__('Single Image', 'maia'),
                        'img' => MAIA_ASSETS_IMAGES . '/image_mode/single-image.png'
                    ),
                    'two' => array(
                        'title' => esc_html__('Double Images (Hover)', 'maia'),
                        'img' => MAIA_ASSETS_IMAGES . '/image_mode/display-hover.gif'
                    ),
                                                                        
                ),
                'default' => 'two'
            ),
            array(
                'id' => 'enable_quickview',
                'type' => 'switch',
                'title' => esc_html__('Enable Quick View', 'maia'),
                'default' => 1
            ),
            array(
                'id' => 'enable_woocommerce_catalog_mode',
                'type' => 'switch',
                'title' => esc_html__('Show WooCommerce Catalog Mode', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'enable_woocommerce_quantity_mode',
                'type' => 'switch',
                'title' => esc_html__('Enable WooCommerce Quantity Mode', 'maia'),
                'subtitle' => esc_html__('Enable/Disable show quantity on Home Page and Shop Page', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'ajax_update_quantity',
                'type' => 'switch',
                'title' => esc_html__('Quantity Ajax Auto-update', 'maia'),
                'subtitle' => esc_html__('Enable/Disable quantity ajax auto-update on page Cart', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'enable_variation_swatch',
                'type' => 'switch',
                'title' => esc_html__('Enable Product Variation Swatch', 'maia'),
                'subtitle' => esc_html__('Enable/Disable Product Variation Swatch on HomePage and Shop page', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'variation_swatch',
                'type' => 'select',
                'title' => esc_html__('Product Attribute', 'maia'),
                'options' => maia_tbay_get_variation_swatchs(),
                'default' => 'pa_size'
            ),
        )
	)
);


// woocommerce Cart settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Cart', 'maia'),
        'fields' => array(
            array(
                'id' => 'show_cart_free_shipping',
                'type' => 'switch',
                'title' => esc_html__('Enable Free Shipping on Cart and Mini-Cart', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'show_mini_cart_qty',
                'type' => 'switch',
                'title' => esc_html__('Enable Quantity on Mini-Cart', 'maia'),
                'default' => true
            ), 
             array(
                'id' => 'woo_mini_cart_position',
                'type' => 'select',
                'title' => esc_html__('Mini-Cart Position', 'maia'),
                'options' => array(
                    'left'       => esc_html__('Left', 'maia'),
                    'right'      => esc_html__('Right', 'maia'),
                    'popup'      => esc_html__('Popup', 'maia'),
                    'no-popup'   => esc_html__('None Popup', 'maia')
                ),
                'default' => 'popup'
            ),
        )
	)
);


// woocommerce Breadcrumb settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Breadcrumb Shop', 'maia'),
        'fields' => array(
            array(
                'id' => 'show_product_breadcrumb',
                'type' => 'switch',
                'title' => esc_html__('Enable Breadcrumb', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'product_breadcrumb_layout',
                'type' => 'image_select',
                'class'     => 'image-two',
                'compiler' => true,
                'title' => esc_html__('Breadcrumb Layout', 'maia'),
                'required' => array('show_product_breadcrumb','=',1),
                'options' => array(
                    'image' => array(
                        'title' => esc_html__('Background Image', 'maia'),
                        'img'   => MAIA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                    ),
                    'color' => array(
                        'title' => esc_html__('Background color', 'maia'),
                        'img'   => MAIA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                    ),
                    'text'=> array(
                        'title' => esc_html__('Text Only', 'maia'),
                        'img'   => MAIA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                    ),
                ),
                'default' => 'color'
            ),
            array(
                'title' => esc_html__('Breadcrumb Background Color', 'maia'),
                'subtitle' => '<em>'.esc_html__('The Breadcrumb background color of the site.', 'maia').'</em>',
                'id' => 'woo_breadcrumb_color',
                'required' => array('product_breadcrumb_layout','=',array('default','color')),
                'type' => 'color',
                'default' => '#f4f9fc',
                'transparent' => false,
            ),
            array(
                'id' => 'woo_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumb Background', 'maia'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your Breadcrumb.', 'maia'),
                'required' => array('product_breadcrumb_layout','=','image'),
                'default'  => array(
                    'url'=> MAIA_IMAGES .'/breadcrumbs-woo.jpg'
                ),
            ),
        )
	)
);


// woocommerce Breadcrumb settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Breadcrumb Single Product', 'maia'),
        'fields' => array(
            array(
                'id' => 'show_single_product_breadcrumb',
                'type' => 'switch',
                'title' => esc_html__('Enable Breadcrumb', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'show_product_nav',
                'type' => 'switch', 
                'title' => esc_html__('Enable Product Navigator', 'maia'),
                'required' => array('show_single_product_breadcrumb','=',1),
                'default' => true
            ),    
            array(
                'id' => 'single_product_breadcrumb_layout',
                'type' => 'image_select',
                'class'     => 'image-two',
                'compiler' => true,
                'title' => esc_html__('Breadcrumb Layout', 'maia'),
                'required' => array('show_single_product_breadcrumb','=',1),
                'options' => array(
                    'image' => array(
                        'title' => esc_html__('Background Image', 'maia'),
                        'img'   => MAIA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                    ),
                    'color' => array(
                        'title' => esc_html__('Background color', 'maia'),
                        'img'   => MAIA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                    ),
                    'text'=> array(
                        'title' => esc_html__('Text Only', 'maia'),
                        'img'   => MAIA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                    ),
                ),
                'default' => 'color'
            ),
            array(
                'title' => esc_html__('Breadcrumb Background Color', 'maia'),
                'subtitle' => '<em>'.esc_html__('The Breadcrumb background color of the site.', 'maia').'</em>',
                'id' => 'woo_single_breadcrumb_color',
                'required' => array('single_product_breadcrumb_layout','=',array('default','color')),
                'type' => 'color',
                'default' => '#f4f9fc',
                'transparent' => false,
            ),
            array(
                'id' => 'woo_single_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumb Background', 'maia'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your Breadcrumb.', 'maia'),
                'required' => array('single_product_breadcrumb_layout','=','image'),
                'default'  => array(
                    'url'=> MAIA_IMAGES .'/breadcrumbs-woo.jpg'
                ),
            ),
        )
	)
);


// WooCommerce Archive settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Shop', 'maia'),
        'fields' => array(
            array(
                'id' => 'product_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Shop Layout', 'maia'),
                'options' => array(
                    'shop-left' => array(
                        'title' => esc_html__('Left Sidebar', 'maia'),
                        'img' => MAIA_ASSETS_IMAGES . '/product_archives/shop_left_sidebar.jpg'
                    ),
                    'shop-right' => array(
                        'title' => esc_html__('Right Sidebar', 'maia'),
                        'img' => MAIA_ASSETS_IMAGES . '/product_archives/shop_right_sidebar.jpg'
                    ),
                    'full-width' => array(
                        'title' => esc_html__('No Sidebar', 'maia'),
                        'img' => MAIA_ASSETS_IMAGES . '/product_archives/shop_no_sidebar.jpg'
                    ),
                ),
                'default' => 'shop-left'
            ),
            array(
                'id' => 'product_archive_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Sidebar', 'maia'),
                'data'      => 'sidebars',
                'default' => 'product-archive'
            ),
            array(
                'id' => 'enable_display_mode',
                'type' => 'switch',
                'title' => esc_html__('Enable Products Display Mode', 'maia'),
                'subtitle' => esc_html__('Enable/Disable Display Mode', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'product_display_mode',
                'type' => 'button_set',
                'title' => esc_html__('Products Display Mode', 'maia'),
                'required' => array('enable_display_mode','=',1),
                'options' => array(
                    'grid' => esc_html__('Grid', 'maia'),
                    'list' => esc_html__('List', 'maia')
                ),
                'default' => 'grid'
            ),
            array(
                'id' => 'title_product_archives',
                'type' => 'switch',
                'title' => esc_html__('Show Title of Categories', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'pro_des_image_product_archives',
                'type' => 'switch',
                'title' => esc_html__('Show Description, Image of Categories', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'number_products_per_page',
                'type' => 'slider',
                'title' => esc_html__('Number of Products Per Page', 'maia'),
                'default' => 12,
                'min' => 1,
                'step' => 1,
                'max' => 100,
            ),
            array(
                'id' => 'product_columns',
                'type' => 'select',
                'title' => esc_html__('Product Columns', 'maia'),
                'options' => $columns,
                'default' => 4
            ),
        )
	)
);


// WooCommerce Single Product settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Single Product', 'maia'),
        'fields' => array(
            array(
                'id' => 'product_single_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Select Single Product Layout', 'maia'),
                'options' => array(
                    'vertical' => array(
                        'title' => esc_html__('Image Vertical', 'maia'),
                        'img' => MAIA_ASSETS_IMAGES . '/product_single/verical_thumbnail.jpg'
                    ),
                    'horizontal' => array(
                        'title' => esc_html__('Image Horizontal', 'maia'),
                        'img' => MAIA_ASSETS_IMAGES . '/product_single/horizontal_thumbnail.jpg'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'maia'),
                        'img' => MAIA_ASSETS_IMAGES . '/product_single/left_main_sidebar.jpg'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'maia'),
                        'img' => MAIA_ASSETS_IMAGES . '/product_single/main_right_sidebar.jpg'
                    ),
                ),
                'default' => 'horizontal'
            ),
            array(
                'id' => 'product_single_sidebar',
                'type' => 'select',
                'required' => array('product_single_layout','=',array('left-main','main-right')),
                'title' => esc_html__('Single Product Sidebar', 'maia'),
                'data'      => 'sidebars',
                'default' => 'product-single'
            ),
        )
	)
);


// WooCommerce Single Product Advanced Options settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Single Product Advanced Options', 'maia'),
        'fields' => array(
            array(
                'id' => 'enable_ajax_single_add_to_cart',
                'type' => 'switch',
                'title' => esc_html__('Enable/Disable Ajax add to cart', 'maia'),
                'subtitle' => esc_html__('Only simple variable products are supported ajax', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'enable_total_sales',
                'type' => 'switch',
                'title' => esc_html__('Enable Total Sales', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'enable_buy_now',
                'type' => 'switch',
                'title' => esc_html__('Enable Buy Now', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'redirect_buy_now',
                'required' => array('enable_buy_now','=',true),
                'type' => 'button_set',
                'title' => esc_html__('Redirect to page after Buy Now', 'maia'),
                'options' => array(
                        'cart'          => 'Page Cart',
                        'checkout'      => 'Page CheckOut',
                ),
                'default' => 'cart'
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'style_single_tabs_style',
                'type' => 'button_set',
                'title' => esc_html__('Tab Mode', 'maia'),
                'options' => array(
                        'fulltext'          => 'Full Text',
                        'tabs'          => 'Tabs',
                        'accordion'        => 'Accordion',
                ),
                'default' => 'fulltext'
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),  
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'enable_sticky_menu_bar',
                'type' => 'switch',
                'title' => esc_html__('Sticky Menu Bar', 'maia'),
                'subtitle' => esc_html__('Enable/disable Sticky Menu Bar', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'enable_zoom_image',
                'type' => 'switch',
                'title' => esc_html__('Zoom inner image', 'maia'),
                'subtitle' => esc_html__('Enable/disable Zoom inner Image', 'maia'),
                'default' => false
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'video_aspect_ratio',
                'type' => 'select',
                'title' => esc_html__('Featured Video Aspect Ratio', 'maia'),
                'subtitle' => esc_html__('Choose the aspect ratio for your video', 'maia'),
                'options' => $aspect_ratio,
                'default' => '16_9'
            ),
            array(
                'id'      => 'video_position',
                'title'    => esc_html__('Featured Video Position', 'maia'),
                'type'    => 'select',
                'default' => 'last',
                'options' => array(
                    'last' => esc_html__('The last product gallery', 'maia'),
                    'first' => esc_html__('The first product gallery', 'maia'),
                ),
            ),
            array(
                'id'   => 'opt-divide',
                'class' => 'big-divide',
                'type' => 'divide'
            ),
            array(
                'id' => 'enable_product_social_share',
                'type' => 'switch',
                'title' => esc_html__('Social Share', 'maia'),
                'subtitle' => esc_html__('Enable/disable Social Share', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'enable_product_review_tab',
                'type' => 'switch',
                'title' => esc_html__('Product Review Tab', 'maia'),
                'subtitle' => esc_html__('Enable/disable Review Tab', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'enable_product_releated',
                'type' => 'switch',
                'title' => esc_html__('Products Releated', 'maia'),
                'subtitle' => esc_html__('Enable/disable Products Releated', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'enable_product_upsells',
                'type' => 'switch',
                'title' => esc_html__('Products upsells', 'maia'),
                'subtitle' => esc_html__('Enable/disable Products upsells', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'enable_product_countdown',
                'type' => 'switch',
                'title' => esc_html__('Display Countdown time ', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'number_product_thumbnail',
                'type'  => 'slider',
                'title' => esc_html__('Number Images Thumbnail to show', 'maia'),
                'default' => 4,
                'min'   => 2,
                'step'  => 1,
                'max'   => 5,
            ),
            array(
                'id' => 'number_product_releated',
                'type' => 'slider',
                'title' => esc_html__('Number of related products to show', 'maia'),
                'default' => 8,
                'min' => 1,
                'step' => 1,
                'max' => 20,
            ),
            array(
                'id' => 'releated_product_columns',
                'type' => 'select',
                'title' => esc_html__('Releated Products Columns', 'maia'),
                'options' => $columns,
                'default' => 4
            ),
            array(
                'id'       => 'html_before_add_to_cart_btn',
                'type'     => 'textarea',
                'title'    => esc_html__('HTML before Add To Cart button (Global)', 'maia'),
                'desc'     => esc_html__('Enter HTML and shortcodes that will show before Add to cart selections.', 'maia'),
            ),
            array(
                'id'       => 'html_after_add_to_cart_btn',
                'type'     => 'textarea',
                'title'    => esc_html__('HTML after Add To Cart button (Global)', 'maia'),
                'desc'     => esc_html__('Enter HTML and shortcodes that will show after Add to cart button.', 'maia'),
            ),
            array(
                'id'       => 'html_before_inner_product_summary',
                'type'     => 'textarea',
                'title'    => esc_html__('HTML before Inner Product Summary', 'maia'),
                'desc'     => esc_html__('Enter HTML and shortcodes that will show before Product Summary selections.', 'maia'),
            ),
            array(
                'id'       => 'html_after_inner_product_summary',
                'type'     => 'textarea',
                'title'    => esc_html__('HTML after Inner Product Summary', 'maia'),
                'desc'     => esc_html__('Enter HTML and shortcodes that will show after Product Summary selections.', 'maia'),
            ),
        )
	)
);


// woocommerce Other Page settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Other page', 'maia'),
        'fields' => array(
            array(
                'id' => 'show_woocommerce_password_strength',
                'type' => 'switch',
                'title' => esc_html__('Show Password Strength Meter', 'maia'),
                'subtitle' => esc_html__('Enable or disable in page My Account', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'show_checkout_image',
                'type' => 'switch',
                'title' => esc_html__('Show Image Product', 'maia'),
                'subtitle'  => esc_html__('Enable or disable "Image Product" in page Checkout', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'show_checkout_optimized',
                'type' => 'switch',
                'title' => esc_html__('Checkout Optimized', 'maia'),
                'subtitle'  => esc_html__('Remove "Header" and "Footer" in page Checkout', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'checkout_logo',
                'type' => 'media',
                'required' => array('show_checkout_optimized','=', true),
                'title' => esc_html__('Upload Logo in page Checkout', 'maia'),
                'subtitle' => esc_html__('Image File (.png or .gif)', 'maia'),
            ),
            array(
                'id'        => 'checkout_img_width',
                'type'      => 'slider',
                'required' => array('show_checkout_optimized','=', true),
                'title'     => esc_html__('Logo maximum width (px)', 'maia'),
                "default"   => 120,
                "min"       => 50,
                "step"      => 1,
                "max"       => 600,
            ),
        )
	)
);

if (!function_exists('maia_settings_multi_vendor_fields')) {
    function maia_settings_multi_vendor_fields( $columns )
    {
        $wcmp_array = $fields_dokan = array();

        if (class_exists('WCMp')) {
            $wcmp_array = array(
                'id'        => 'show_vendor_name_wcmp',
                'type'      => 'info',
                'title'     => esc_html__('Enable Vendor Name Only WCMP Vendor', 'maia'),
                'subtitle'  => sprintf(__('Go to the <a href="%s" target="_blank">Setting</a> Enable "Sold by" for WCMP Vendor', 'maia'), admin_url('admin.php?page=wcmp-setting-admin')),
            );
        }

        $fields = array(
            array(
                'id' => 'show_vendor_name',
                'type' => 'switch',
                'title' => esc_html__('Enable Vendor Name', 'maia'),
                'subtitle' => esc_html__('Enable/Disable Vendor Name on HomePage and Shop page only works for Dokan, WCMP Vendor', 'maia'),
                'default' => true
            ),
            $wcmp_array
        );


        if (class_exists('WeDevs_Dokan')) {
            $fields_dokan = array(
                array(
                    'id'   => 'divide_vendor_1',
                    'class' => 'big-divide',
                    'type' => 'divide'
                ),
                array(
                    'id' => 'show_info_vendor_tab',
                    'type' => 'switch',
                    'title' => esc_html__('Enable Tab Info Vendor Dokan', 'maia'),
                    'subtitle' => esc_html__('Enable/Disable tab Info Vendor on Product Detail Dokan', 'maia'),
                    'default' => true
                ),
                array(
                    'id'        => 'show_seller_tab',
                    'type'      => 'info',
                    'title'     => esc_html__('Enable/Disable Tab Products Seller', 'maia'),
                    'subtitle'  => sprintf(__('Go to the <a href="%s" target="_blank">Setting</a> of each Seller to Enable/Disable this tab of Dokan Vendor.', 'maia'), home_url('dashboard/settings/store/')),
                ),
                array(
                    'id' => 'seller_tab_per_page',
                    'type' => 'slider',
                    'title' => esc_html__('Dokan Number of Products Seller Tab', 'maia'),
                    'default' => 4,
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                ),
                array(
                    'id' => 'seller_tab_columns',
                    'type' => 'select',
                    'title' => esc_html__('Dokan Product Columns Seller Tab', 'maia'),
                    'options' => $columns,
                    'default' => 4
                ),
            );
        }
        

        $fields = array_merge($fields, $fields_dokan);

        return $fields;
    }
}

if( maia_woo_is_active_vendor() ) {
    Redux::set_section(
        $opt_name,
        array(
            'subsection' => true,
            'title' => esc_html__('Multi-vendor', 'maia'),
            'fields' => maia_settings_multi_vendor_fields($columns)
        )
    );
}