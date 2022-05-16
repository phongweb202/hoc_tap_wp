<?php
if ( !maia_woocommerce_activated() ) return;

if (!function_exists('maia_tbay_get_woocommerce_mini_cart')) {
    function maia_tbay_get_woocommerce_mini_cart($args = array())
    {
        $args = wp_parse_args(
            $args,
            array(
                'icon_mini_cart'                => [
                    'value' => 'tb-icon tb-icon-bag-happy',
                ],
                'show_title_mini_cart'          => '',
                'title_mini_cart'               => esc_html__('Shopping cart', 'maia'),
                'title_dropdown_mini_cart'      => esc_html__('Shopping cart', 'maia'),
                'price_mini_cart'               => '',
            )
        );

        $position = apply_filters('maia_cart_position', 10, 2);
 
        $mark = '';
        if (!empty($position)) {
            $mark = '-';
        }

        wc_get_template('cart/mini-cart-button'.$mark.$position.'.php', array('args' => $args)) ;
    }
}

if (!function_exists('maia_tbay_woocommerce_get_cookie_display_mode')) {
    function maia_tbay_woocommerce_get_cookie_display_mode()
    {
        $woo_mode = maia_tbay_get_config('product_display_mode', 'grid');

        if (isset($_COOKIE['maia_display_mode']) && $_COOKIE['maia_display_mode'] == 'grid') {
            $woo_mode = 'grid';
        } elseif (isset($_COOKIE['maia_display_mode']) && $_COOKIE['maia_display_mode'] == 'grid2') {
            $woo_mode = 'grid2';
        } elseif (isset($_COOKIE['maia_display_mode']) && $_COOKIE['maia_display_mode'] == 'list') {
            $woo_mode = 'list';
        }

        return $woo_mode;
    }
}

if (!function_exists('maia_tbay_woocommerce_get_display_mode')) {
    function maia_tbay_woocommerce_get_display_mode()
    {
        $woo_mode = maia_tbay_woocommerce_get_cookie_display_mode();

        if (isset($_GET['display_mode']) && $_GET['display_mode'] == 'grid') {
            $woo_mode = 'grid';
        } elseif (isset($_GET['display_mode']) && $_GET['display_mode'] == 'list') {
            $woo_mode = 'list';
        }

        if (!is_shop() && !is_product_category() && !is_product_tag()) {
            $woo_mode = 'grid';
        }


        return $woo_mode;
    }
}


/*Check not child categories*/
if (!function_exists('maia_is_check_not_child_categories')) {
    function maia_is_check_not_child_categories()
    {
        if (is_product_category()) {
            $cat   = get_queried_object();
            $cat_id     = $cat->term_id;

            $args2 = array(
                'taxonomy'     => 'product_cat',
                'parent'       => $cat_id,
            );

            $sub_cats = get_categories($args2);
            if (!$sub_cats) {
                return true;
            }
        }

        return false;
    }
}

/*Check not product in categories*/
if (!function_exists('maia_is_check_hidden_filter')) {
    function maia_is_check_hidden_filter()
    {
        if (is_product_category()) {
            $checkchild_cat     =  maia_is_check_not_child_categories();

            if (!$checkchild_cat &&  'subcategories' === get_option('woocommerce_category_archive_display')) {
                return true;
            }
        }

        return false;
    }
}


// get layout configs
if (!function_exists('maia_tbay_get_woocommerce_layout_configs')) {
    function maia_tbay_get_woocommerce_layout_configs() {
        if(function_exists('dokan_is_store_page') && dokan_is_store_page() ) {
            return;
        }

        if (!is_product()) {
            $page = 'product_archive_sidebar';
        } else {
            $page = 'product_single_sidebar';
        }

        $sidebar = maia_tbay_get_config($page);


        if (!is_singular('product')) {
            $product_archive_layout  =   (isset($_GET['product_archive_layout'])) ? $_GET['product_archive_layout'] : maia_tbay_get_config('product_archive_layout', 'shop-left');


            if (maia_woo_is_wcmp_vendor_store()) {
                $sidebar = 'wc-marketplace-store';

                if (!is_active_sidebar($sidebar)) {
                    $configs['main'] = array( 'class' => 'archive-full' );
                }
            }

            if (function_exists('dokan_is_store_page') && dokan_is_store_page() && dokan_get_option('enable_theme_store_sidebar', 'dokan_appearance', 'off') === 'off') {
                $product_archive_layout = 'full-width';
            }

            if (isset($product_archive_layout)) {
                switch ($product_archive_layout) {
                    case 'shop-left':
                        $configs['sidebar'] = array( 'id'  => $sidebar, 'class' => 'tbay-sidebar-shop col-12 col-xl-3'  );
                        $configs['main']    = array( 'class'    => 'col-12 col-xl-9' );
                        break;
                    case 'shop-right':
                        $configs['sidebar'] = array( 'id' => $sidebar,  'class' => 'tbay-sidebar-shop col-12 col-xl-3' );
                        $configs['main']    = array( 'class'    => 'col-12 col-xl-9' );
                        break;
                    default:
                        $configs['main']    = array( 'class' => 'archive-full' );
                        $configs['sidebar'] = array( 'id'  => $sidebar, 'class' => 'sidebar-desktop'  );
                        break;
                }

                if (($product_archive_layout === 'shop-left' ||  $product_archive_layout === 'shop-right') && (empty($configs['sidebar']['id']) || !is_active_sidebar($configs['sidebar']['id']))) {
                    $configs['main'] = array( 'class' => 'archive-full' );
                }
            }
        } else {
            $product_single_layout  =   (isset($_GET['product_single_layout']))   ?   $_GET['product_single_layout'] :  maia_get_single_select_layout();
            $class_main = '';
            $class_sidebar = '';
            if ($product_single_layout == 'left-main' || $product_single_layout == 'main-right') {
                $class_main = 'col-12 col-xl-9';
                $class_sidebar = 'col-12 col-xl-3';

                $sidebar = maia_tbay_get_config('product_single_sidebar', 'product-single');
            }
            if (isset($product_single_layout)) {
                switch ($product_single_layout) {
                    case 'vertical':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'vertical';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'horizontal':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'left-main':
                        $configs['sidebar']         = array( 'id'  => $sidebar, 'class' => $class_sidebar  );
                        $configs['main']            = array( 'class' => $class_main );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'main-right':
                        $configs['sidebar']         = array( 'id'  => $sidebar, 'class' => $class_sidebar  );
                        $configs['main']            = array( 'class' => $class_main );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['breadscrumb']     = 'color';
                        break;
                    default:
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['breadscrumb']     = 'color';
                        break;
                }

                if (($product_single_layout === 'left-main' ||  $product_single_layout === 'main-right') && (empty($configs['sidebar']['id']) || !is_active_sidebar($configs['sidebar']['id']))) {
                    $configs['main'] = array( 'class' => 'archive-full' );
                }
            }
        }

        return $configs;
    }
}

if (!function_exists('maia_class_wrapper_start')) {
    function maia_class_wrapper_start()
    {
        $configs['content']                 = 'content';
        $configs['main']                    = 'main-wrapper ';

        $sidebar_configs                    = maia_tbay_get_woocommerce_layout_configs();
        $configs['content']                 = maia_add_cssclass($configs['content'], $sidebar_configs['main']['class']);

        if (!is_product()) {
            $configs['content']  = maia_add_cssclass($configs['content'], 'archive-shop');
            $class_main         =  (isset($_GET['product_archive_layout'])) ? $_GET['product_archive_layout'] : maia_tbay_get_config('product_archive_layout', 'shop-left');


            $configs['main']  = maia_add_cssclass($configs['main'], $class_main);
        } elseif (is_product()) {
            $configs['content']  = maia_add_cssclass($configs['content'], 'singular-shop');

            $class_main         =  (isset($_GET['product_single_layout']))   ?   $_GET['product_single_layout'] :  maia_tbay_get_config('product_single_layout', 'horizontal');


            $configs['main']  = maia_add_cssclass($configs['main'], $class_main);
        }

        return $configs;
    }
}

//get value fillter
if (! function_exists('maia_woocommerce_get_fillter')) {
    function maia_woocommerce_get_fillter($name, $default)
    {
        if (isset($_GET[$name])) :
            return $_GET[$name]; else :
            return $default;
        endif;
    }
}

//Count product of category

if (! function_exists('maia_get_product_count_of_category')) {
    function maia_get_product_count_of_category($cat_id)
    {
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => -1,
            'tax_query'             => array(
                array(
                    'taxonomy'      => 'product_cat',
                    'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                    'terms'         => $cat_id,
                    'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                ),
                array(
                    'taxonomy'      => 'product_visibility',
                    'field'         => 'slug',
                    'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                    'operator'      => 'NOT IN'
                )
            )
        );
        $loop = new WP_Query($args);

        return $loop->found_posts;
    }
}

//Count product of tag

if (! function_exists('maia_get_product_count_of_tags')) {
    function maia_get_product_count_of_tags($tag_id)
    {
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => -1,
            'tax_query'             => array(
                array(
                    'taxonomy'      => 'product_tag',
                    'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                    'terms'         => $tag_id,
                    'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                ),
                array(
                    'taxonomy'      => 'product_visibility',
                    'field'         => 'slug',
                    'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                    'operator'      => 'NOT IN'
                )
            )
        );
        $loop = new WP_Query($args);

        return $loop->found_posts;
    }
}


/*Remove filter*/
if (! function_exists('maia_woocommerce_sub_categories')) {
    /**
     * Output the start of a product loop. By default this is a UL.
     *
     * @param bool $echo Should echo?.
     * @return string
     */
    function maia_woocommerce_sub_categories($echo = true)
    {
        ob_start();

        wc_set_loop_prop('loop', 0);
        
        $loop_start = apply_filters('maia_woocommerce_sub_categories', ob_get_clean());

        if ($echo) {
            echo trim($loop_start); // WPCS: XSS ok.
        } else {
            return $loop_start;
        }
    }

    function woocommerce_maybe_show_product_subcategories($loop_html = '')
    {
        return $loop_html;
    }
    add_filter('woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories');
}


if (! function_exists('maia_is_product_variable_sale')) {
    function maia_is_product_variable_sale()
    {
        global $product;

        $class =  '';
        if ($product->is_type('variable') && $product->is_on_sale()) {
            $class = 'tbay-variable-sale';
        }
        
        return $class;
    }
}

if (! function_exists('maia_woo_content_class')) {
    function maia_woo_content_class($class = '')
    {
        $sidebar_configs = maia_tbay_get_woocommerce_layout_configs();

        if (!(isset($sidebar_configs['right']) && is_active_sidebar($sidebar_configs['right']['sidebar'])) && !(isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar']))) {
            $class .= ' col-12';
        }
        
        return $class;
    }
}

if (! function_exists('maia_wc_wrapper_class')) {
    function maia_wc_wrapper_class($class = '')
    {
        $content_class = maia_woo_content_class($class);
        
        return apply_filters('maia_wc_wrapper_class', $content_class);
    }
}


if (!function_exists('maia_find_matching_product_variation')) {
    function maia_find_matching_product_variation($product, $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (strpos($key, 'attribute_') === 0) {
                continue;
            }

            unset($attributes[ $key ]);
            $attributes[ sprintf('attribute_%s', $key) ] = $value;
        }

        if (class_exists('WC_Data_Store')) {
            $data_store = WC_Data_Store::load('product');
            return $data_store->find_matching_product_variation($product, $attributes);
        } else {
            return $product->get_matching_variation($attributes);
        }
    }
}

if (! function_exists('maia_get_default_attributes')) {
    function maia_get_default_attributes($product)
    {
        if (method_exists($product, 'get_default_attributes')) {
            return $product->get_default_attributes();
        } else {
            return $product->get_variation_default_attributes();
        }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Compare button
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('maia_the_yith_compare')) {
    function maia_the_yith_compare($product_id)
    {
        if (class_exists('YITH_Woocompare')) { ?>
            <?php
                $action_add = 'yith-woocompare-add-product';
                $url_args = array(
                    'action' => $action_add,
                    'id' => $product_id
                );
            ?>
            <div class="yith-compare">
                <a href="<?php echo esc_url(wp_nonce_url(add_query_arg($url_args), $action_add)); ?>" title="<?php esc_attr_e('Compare', 'maia'); ?>" class="compare" data-product_id="<?php echo esc_attr($product_id); ?>">
                    <span><?php esc_html_e('Add to compare', 'maia'); ?></span>
                </a>
            </div>
        <?php }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * WishList button
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('maia_the_yith_wishlist')) {
    function maia_the_yith_wishlist()
    {
        if (!class_exists('YITH_WCWL')) {
            return;
        }

        $enabled_on_loop = 'yes' == get_option('yith_wcwl_show_on_loop', 'no');

        if (!class_exists('YITH_WCWL_Shortcode') || $enabled_on_loop) {
            return;
        }

        $active         = maia_tbay_get_config('enable_wishlist_mobile', false);
        
        $class_mobile   = ($active) ? 'shown-mobile' : '';

        echo '<div class="button-wishlist '. esc_attr($class_mobile) .'" title="'. esc_attr__('Wishlist', 'maia') . '">'.YITH_WCWL_Shortcode::add_to_wishlist(array()).'</div>';
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Flash Sale
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('maia_tbay_class_flash_sale')) {
    function maia_tbay_class_flash_sale($flash_sales)
    {
        global $product;

        if (isset($flash_sales) && $flash_sales) {
            $class_sale    = (!$product->is_on_sale()) ? 'tbay-not-flash-sale' : '';
            return $class_sale;
        }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Item Deal ended Flash Sale
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('maia_tbay_item_deal_ended_flash_sale')) {
    function maia_tbay_item_deal_ended_flash_sale($flash_sales, $end_date)
    {
        global $product;
    
        $today      = strtotime("today");


        if ($today > $end_date) {
            return;
        }

        $output = '';
        if (isset($flash_sales) && $flash_sales && !$product->is_on_sale()) {
            $output .= '<div class="item-deal-ended">';
            $output .= '<span>'. esc_html__('Deal ended', 'maia') .'</span>';
            $output .= '</div>';
        }
        echo trim($output);
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * The Count Down Flash Sale
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('maia_tbay_label_flash_sale')) {
    function maia_tbay_label_flash_sale()
    {
        if ( !maia_tbay_get_config('enable_text_time_coutdown', false) ) {
            $dates = array(
                'days' => '',
                'hours' => '',
                'mins' => '',
                'secs' => '',
            );
        } else {
            $dates = array(
                'days' => apply_filters('maia_tbay_countdown_flash_sale_day', '<span class="label">'. esc_html__('days', 'maia') .'</span>'),
                'hours' => apply_filters('maia_tbay_countdown_flash_sale_hour', '<span class="label">'. esc_html__('hours', 'maia') .'</span>'),
                'mins' => apply_filters('maia_tbay_countdown_flash_sale_mins', '<span class="label">'. esc_html__('mins', 'maia') .'</span>'),
                'secs' => apply_filters('maia_tbay_countdown_flash_sale_secs', '<span class="label">'. esc_html__('secs', 'maia') .'</span>'),

            );
        }
        return $dates;
    }
}
if (!function_exists('maia_tbay_countdown_flash_sale')) {
    function maia_tbay_countdown_flash_sale($time_sale = '', $date_title = '', $date_title_ended = '', $strtotime = false)
    {
        wp_enqueue_script('jquery-countdowntimer');
        $_id        = maia_tbay_random_key();

        $today      = strtotime("today");
       
        $dates = maia_tbay_label_flash_sale();
        $days = $dates['days'];
        $hours = $dates['hours'];
        $mins = $dates['mins'];
        $secs = $dates['secs'];
        if ($strtotime) {
            $time_sale = strtotime($time_sale);
        } ?>
        <?php if (!empty($time_sale)) : ?>
            <div class="flash-sales-date">
                <?php if (($today <= $time_sale)): ?>
                    <?php if (isset($date_title) && !empty($date_title)) :  ?>
                        <div class="date-title"><?php echo trim($date_title); ?></div>
                    <?php endif; ?>
                    <div class="time">
                        <div class="tbay-countdown scroll-init" id="tbay-flash-sale-<?php echo esc_attr($_id); ?>" data-time="timmer"
                             data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>" data-days="<?php echo esc_attr($days); ?>" data-hours="<?php echo esc_attr($hours); ?>" data-mins="<?php echo esc_attr($mins); ?>" data-secs="<?php echo esc_attr($secs); ?>" >
                        </div>
                    </div>
                <?php else: ?>
                    
                <?php if (isset($date_title_ended) && !empty($date_title_ended)) :  ?>
                    <div class="date-title"><?php echo trim($date_title_ended); ?></div>
                <?php endif; ?>
            <?php endif; ?> 
            </div> 
        <?php endif; ?> 
        <?php
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Count Down Flash Sale
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('maia_tbay_stock_flash_sale')) {
    function maia_tbay_stock_flash_sale($flash_sales = '')
    {
        global $product;

        if ($flash_sales && $product->get_manage_stock()) : ?>
            <div class="stock-flash-sale stock">
                <?php
                $total_sales        = $product->get_total_sales();
        $stock_quantity     = $product->get_stock_quantity();
                
        $total_quantity   = (int)$total_sales + (int)$stock_quantity;

        $divi_total_quantity = ($total_quantity !== 0) ? $total_quantity : 1;

        $sold             = (int)$total_sales / (int)$divi_total_quantity;
        $percentsold      = $sold*100; ?>
                <span class="tb-sold"><?php echo esc_html__('Sold', 'maia'); ?>: <span class="sold"><?php echo esc_html($total_sales) ?></span><span class="total">/<?php echo esc_html($total_quantity) ?></span></span>
                <div class="progress">
                    <div class="progress-bar active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($percentsold); ?>%">
                    </div>
                </div>
            </div>
        <?php endif;
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * Product name
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('maia_the_product_name')) {
    function maia_the_product_name()
    {
        $active         = maia_tbay_get_config('enable_one_name_mobile', false);

        $class_mobile   = ($active) ? 'full_name' : ''; ?>
        
        <h3 class="name <?php echo esc_attr($class_mobile); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php
    }
}

if (! function_exists('maia_woo_is_wcmp_vendor_store')) {
    function maia_woo_is_wcmp_vendor_store()
    {
        if (! class_exists('WCMp')) {
            return false;
        }

        global $WCMp;
        if (empty($WCMp)) {
            return false;
        }

        if (is_tax($WCMp->taxonomy->taxonomy_name)) {
            return true;
        }

        return false;
    }
}

/**
 * Check is vendor page
 *
 * @return bool
 */
if (! function_exists('maia_woo_is_vendor_page')) {
    function maia_woo_is_vendor_page()
    {
        if (function_exists('dokan_is_store_page') && dokan_is_store_page()) {
            return true;
        }

        if (class_exists('WCV_Vendors') && method_exists('WCV_Vendors', 'is_vendor_page')) {
            return WCV_Vendors::is_vendor_page();
        }

        if (maia_woo_is_wcmp_vendor_store()) {
            return true;
        }

        if (function_exists('wcfm_is_store_page') && wcfm_is_store_page()) {
            return true;
        }

        return false;
    }
}


/**
 * Check is vendor page
 *
 * @return bool
 */


if (! function_exists('maia_custom_product_get_rating_html')) {
    function maia_custom_product_get_rating_html($html, $rating, $count)
    {
        global $product;

        $output = '';

        $review_count = $product->get_review_count();

        if (empty($review_count)) {
            $review_count = 0;
        }

        $class = (empty($review_count)) ? 'no-rate' : '';

        $output .='<div class="rating '. esc_attr($class) .'">';
        $output .= $html;
        $output .= '<div class="count"><span>'. $review_count .'</span></div>';
        $output .= '</div>';

        echo trim($output);
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * Mini cart Button
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('maia_tbay_minicart_button')) {
    function maia_tbay_minicart_button($icon, $enable_text, $text, $enable_price)
    {
        global $woocommerce; ?>

        <span class="cart-icon">

            <?php if (!empty($icon['value'])) : ?>
                <i class="<?php echo esc_attr($icon['value']); ?>"></i>
            <?php endif; ?>
            <span class="mini-cart-items">
               <?php echo sprintf('%d', $woocommerce->cart->cart_contents_count); ?>
            </span>
        </span>

        <?php if ((($enable_text === 'yes') && !empty($text)) || ($enable_price === 'yes')) { ?>
            <span class="text-cart">

            <?php if (($enable_text === 'yes') && !empty($text)) : ?>
                <span><?php echo trim($text); ?></span>
            <?php endif; ?>

            <?php if ($enable_price === 'yes') : ?>
                <span class="subtotal"><?php echo WC()->cart->get_cart_subtotal();?></span>
            <?php endif; ?>

        </span>

        <?php }
    }
}

/*product time countdown*/
if (!function_exists('maia_woo_product_time_countdown')) {
    function maia_woo_product_time_countdown($countdown = false, $countdown_title = '')
    {
        global $product;

        if (!$countdown) {
            return;
        }

        wp_enqueue_script('jquery-countdowntimer');
        $time_sale = get_post_meta($product->get_id(), '_sale_price_dates_to', true);
        $_id = maia_tbay_random_key();
        $dates = maia_tbay_label_flash_sale();
        $days = $dates['days'];
        $hours = $dates['hours'];
        $mins = $dates['mins'];
        $secs = $dates['secs']; ?>
        <?php if ($time_sale): ?>
            <div class="time">
                <div class="timming">
                    <?php if (isset($countdown_title) && !empty($countdown_title)) :  ?>
                        <div class="date-title"><?php echo trim($countdown_title); ?></div>
                    <?php endif; ?>
                    <div class="tbay-countdown scroll-init" id="tbay-flash-sale-<?php echo esc_attr($_id); ?>" data-time="timmer" data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>" data-days="<?php echo esc_attr($days); ?>" data-hours="<?php echo esc_attr($hours); ?>" data-mins="<?php echo esc_attr($mins); ?>" data-secs="<?php echo esc_attr($secs); ?>" >
                    </div>
                </div>
            </div> 
        <?php endif; ?> 
        <?php
    }
}
if (!function_exists('maia_woo_product_time_countdown_stock')) {
    function maia_woo_product_time_countdown_stock($countdown = false)
    {
        global $product;
        if (!$countdown) {
            return;
        }

        if ($product->get_manage_stock()) {?>
            <div class="stock">
                <?php
                    $total_sales    = $product->get_total_sales();
                    $stock_quantity   = $product->get_stock_quantity();

                    if ($stock_quantity >= 0) {
                        $total_quantity   = (int)$total_sales + (int)$stock_quantity;
                        $sold         = (int)$total_sales / (int)$total_quantity;
                        $percentsold    = $sold*100;
                    }
                 ?>
              
                <?php if (isset($percentsold)) { ?>
                    <div class="progress">
                        <div class="progress-bar active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($percentsold); ?>%">
                        </div>
                    </div>
                <?php } ?>
                <?php if ($stock_quantity >= 0) { ?>
                    <span class="tb-sold"><?php esc_html_e('Sold', 'maia'); ?> : <span class="sold"><?php echo esc_html($total_sales) ?></span><span class="total">/<?php echo esc_html($total_quantity) ?></span></span>
                <?php } ?>
            </div>
        <?php }
    }
}

if (! function_exists('maia_get_single_select_layout')) {
    function maia_get_single_select_layout()
    {
        $custom = get_post_meta(get_the_ID(), '_maia_single_layout_select', true);

        return empty($custom) ? maia_tbay_get_config('product_single_layout') : $custom;
    }
}

if (!function_exists('maia_tbay_minicart')) {
    function maia_tbay_minicart()
    {
        $template = apply_filters('maia_tbay_minicart_version', '');
        get_template_part('woocommerce/cart/mini-cart-button', $template);
    }
}


/**
* Function For Multi Layouts Single Product
*/
//-----------------------------------------------------
/**
 * Override Output the product tabs.
 *
 * @subpackage  Product/Tabs
 */
if (!function_exists('maia_override_woocommerce_output_product_data_tabs')) {
    function woocommerce_output_product_data_tabs()
    {
        $tabs_layout   =  apply_filters('maia_woo_tabs_style_single_product', 10, 2);
        if (wp_is_mobile() && maia_tbay_get_config('enable_tabs_mobile', false)) {
            wc_get_template('single-product/tabs/tabs-mobile.php');
            return;
        }

        if ($tabs_layout !== 'fulltext') {
            add_filter('woocommerce_product_description_heading', '__return_empty_string', 10, 1);
            add_filter('maia_woocommerce_product_more_product_heading', '__return_empty_string', 10, 1);
        }


        if (isset($tabs_layout)) {
            if ($tabs_layout == 'tabs') {
                wc_get_template('single-product/tabs/tabs.php');
            } else {
                wc_get_template('single-product/tabs/tabs-'.$tabs_layout.'.php');
            }
        }
    }
}


if (!function_exists('maia_tbay_display_custom_tab_builder')) {
    function maia_tbay_display_custom_tab_builder($tabs)
    {
        global $tabs_builder;
        $tabs_builder = true;
        $args = array(
      'name'        => $tabs,
      'post_type'   => 'tbay_customtab',
      'post_status' => 'publish',
      'numberposts' => 1
    );

        $tabs = array();

        $posts = get_posts($args);
        foreach ($posts as $post) {
            $tabs['title'] = $post->post_title;
            $tabs['content'] = do_shortcode($post->post_content);
            return $tabs;
        }
        $tabs_builder = false;
    }
}

if (! function_exists('maia_get_product_categories')) {
    function maia_get_product_categories()
    {
        $category = get_terms(
            array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($category)) {
            foreach ($category as $category) {
                $results[$category->slug] = $category->name.' ('.$category->count.') ';
            }
        }
        return $results;
    }
}

if (!function_exists('maia_get_thumbnail_gallery_item')) {
    function maia_get_thumbnail_gallery_item()
    {
        return apply_filters('maia_get_thumbnail_gallery_item', 'flex-control-nav.flex-control-thumbs li');
    }
}

if (!function_exists('maia_get_gallery_item_class')) {
    function maia_get_gallery_item_class()
    {
        return apply_filters('maia_get_gallery_item_class', "woocommerce-product-gallery__image");
    }
}

if (! function_exists('maia_video_type_by_url')) {
    /**
     * Retrieve the type of video, by url
     *
     * @param string $url The video's url
     *
     * @return mixed A string format like this: "type:ID". Return FALSE, if the url isn't a valid video url.
     *
     * @since 1.1.0
     */
    function maia_video_type_by_url($url)
    {
        $parsed = parse_url(esc_url($url));

        switch ($parsed['host']) {

            case 'www.youtube.com':
            case    'youtu.be':
                $id = maia_get_yt_video_id($url);

                return "youtube:$id";

            case 'vimeo.com':
            case 'player.vimeo.com':
                preg_match('/.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/', $url, $matches);
                $id = $matches[5];

                return "vimeo:$id";

            default:
                return apply_filters('maia_woocommerce_featured_video_type', false, $url);

        }
    }
}
if (! function_exists('maia_get_yt_video_id')) {
    /**
     * Retrieve the id video from youtube url
     *
     * @param string $url The video's url
     *
     * @return string The youtube id video
     *
     * @since 1.1.0
     */
    function maia_get_yt_video_id($url)
    {
        $pattern =
            '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x';
        $result  = preg_match($pattern, $url, $matches);
        if (false !== $result) {
            return $matches[1];
        }

        return false;
    }
}

if (! function_exists('maia_get_product_menu_bar')) {
    function maia_get_product_menu_bar()
    {
        $menu_bar   = maia_tbay_get_config('enable_sticky_menu_bar', false);

        if (isset($_GET['sticky_menu_bar'])) {
            $menu_bar = $_GET['sticky_menu_bar'];
        }

        return $menu_bar;
    }
    add_filter('maia_woo_product_menu_bar', 'maia_get_product_menu_bar');
}


/*cart fragments*/
if (! function_exists('maia_added_cart_fragments')) {
    function maia_added_cart_fragments($fragments)
    {
        ob_start();
        $cart = WC()->instance()->cart;
        $fragments['.mini-cart-items'] = '<span class="mini-cart-items">'.$cart->get_cart_contents_count().'</span>';
        $fragments['.subtotal'] = '<span class="subtotal">'.$cart->get_cart_subtotal().'</span>';
        return $fragments;
    }
    add_filter('woocommerce_add_to_cart_fragments', 'maia_added_cart_fragments');
}

// Quantity mode
if ( ! function_exists( 'maia_woocommerce_quantity_mode_active' ) ) {
    function maia_woocommerce_quantity_mode_active() {
        $catalog_mode = maia_catalog_mode_active();

        if( $catalog_mode ) return false;

        $active = maia_tbay_get_config('enable_woocommerce_quantity_mode', false);

        $active = (isset($_GET['quantity_mode'])) ? $_GET['quantity_mode'] : $active;

        return $active;
    }
}

if ( ! function_exists( 'maia_quantity_field_archive' ) ) {
    function maia_quantity_field_archive( ) {

        global $product;
        if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
            woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
        }

    }
}

if ( ! function_exists( 'maia_quantity_swatches_pro_field_archive' ) ) {
    function maia_quantity_swatches_pro_field_archive( ) {

        global $product;
        if ( maia_is_quantity_field_archive() ) {
            woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
        }

    }
}

if ( ! function_exists( 'maia_is_quantity_field_archive' ) ) {
    function maia_is_quantity_field_archive( ) {
        global $product;

        if( $product && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
            $max_value = $product->get_max_purchase_quantity();
            $min_value = $product->get_min_purchase_quantity();

            if( $max_value && $min_value === $max_value ) {
                return false;     
            }
            
            return true;
        } else {
            return false;
        }
    }
}

if ( ! function_exists( 'maia_woocommerce_quantity_mode_add_class' ) ) {
    add_filter( 'woocommerce_post_class', 'maia_woocommerce_quantity_mode_add_class', 10, 2 );
    function maia_woocommerce_quantity_mode_add_class( $classes ){
        if( !maia_woocommerce_quantity_mode_active() ) return $classes;
        
        $classes[] = 'product-quantity-mode';

        return $classes;
    }
}


if ( ! function_exists( 'maia_variation_swatches_pro_group_button' ) ) {
    function maia_variation_swatches_pro_group_button() {
        if( !maia_is_woo_variation_swatches_pro() ) return;

        $class_active = '';

        if( maia_woocommerce_quantity_mode_active() ) {
            $class_active .= 'quantity-group-btn';

            if( maia_is_quantity_field_archive() ) {
                $class_active .= ' active';
            }
        } else { 
            $class_active .= 'woo-swatches-pro-btn';
        }

        echo '<div class="'. esc_attr($class_active) .'">';

            if( maia_woocommerce_quantity_mode_active() ) {
                maia_quantity_swatches_pro_field_archive();
            }

            woocommerce_template_loop_add_to_cart();
        echo '</div>';
    }
}

if ( ! function_exists( 'maia_woocommerce_quantity_mode_group_button' ) ) {
    function maia_woocommerce_quantity_mode_group_button() {
        if( !maia_woocommerce_quantity_mode_active() || maia_is_woo_variation_swatches_pro() ) return;

        global $product;
        if(  maia_is_quantity_field_archive() &&  $product->is_type( 'simple' ) ) {
            $class_active = 'active';
        } else {
            $class_active = '';
        } 

        echo '<div class="quantity-group-btn '. esc_attr($class_active) .'">';
            if( maia_is_quantity_field_archive() && $product->is_type( 'simple' ) ) {
                maia_quantity_field_archive();
            }
            woocommerce_template_loop_add_to_cart();
        echo '</div>';
    }
}  

if ( ! function_exists( 'maia_woocommerce_add_quantity_mode_list' ) ) {
    function maia_woocommerce_add_quantity_mode_list() {
        if( maia_is_woo_variation_swatches_pro() || maia_woocommerce_quantity_mode_active() ) {
            add_action('woocommerce_after_shop_loop_item', 'maia_variation_swatches_pro_group_button', 20);
            add_action('woocommerce_after_shop_loop_item', 'maia_woocommerce_quantity_mode_group_button', 20);
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
        }
    }
}

if ( ! function_exists( 'maia_woocommerce_quantity_mode_remove_add_to_cart' ) ) {
    function maia_woocommerce_quantity_mode_remove_add_to_cart() {
        if( maia_is_woo_variation_swatches_pro() || maia_woocommerce_quantity_mode_active() ) {
            remove_action( 'maia_woocommerce_group_buttons', 'woocommerce_template_loop_add_to_cart', 10 ); 
        }
    }
    add_action( 'maia_tbay_after_shop_loop_item_title', 'maia_woocommerce_quantity_mode_remove_add_to_cart', 10 ); 
}

if (! function_exists('maia_woocommerce_cart_item_name')) {
    function maia_woocommerce_cart_item_name($name, $cart_item, $cart_item_key)
    {
        if ( !maia_tbay_get_config('show_checkout_image', true) || !is_checkout()) {
            return $name;
        }

        $_product       = $cart_item['data'];
        $thumbnail      = $_product->get_image('maia_photo_reviews_thumbnail_image');

        $output = $thumbnail;
        $output .= $name;

        return $output;
    }
    add_filter('woocommerce_cart_item_name', 'maia_woocommerce_cart_item_name', 10, 3);
}

if (! function_exists('maia_woocommerce_get_product_category')) {
    function maia_woocommerce_get_product_category()
    {
        global $product;
        echo wc_get_product_category_list($product->get_id(), ', ', '<span class="item-product-cate">', '</span>');
    }
}

if (!function_exists('maia_tbay_woocommerce_full_width_product_archives')) {
    function maia_tbay_woocommerce_full_width_product_archives($active)
    {
        $active = (isset($_GET['product_archive_layout'])) ? $_GET['product_archive_layout'] : maia_tbay_get_config('product_archive_layout', 'full-width');

        if ($active === 'full-width') {
            $active = true;
        } else {
            $active = false;
        }

        return $active;
    }
    add_filter('maia_woo_width_product_archives', 'maia_tbay_woocommerce_full_width_product_archives');
}


if (!function_exists('maia_add_image_sizes_wvs')) {
    function maia_add_image_sizes_wvs($image_subsizes)
    {
        $item = 'woocommerce_thumbnail';
        $size = wc_get_image_size($item);
    
        $title  = ucwords(str_ireplace(array( '-', '_' ), ' ', $item));
        $width  = $size[ 'width' ];
        $height = $size[ 'height' ];
        
        $image_subsizes[ $item ] = sprintf('%s (%d &times; %d)', $title, $width, $height);
    
        return $image_subsizes;
    }
    
    add_filter('wvs_get_all_image_sizes', 'maia_add_image_sizes_wvs', 10, 1);
}


if (!function_exists('maia_get_mobile_form_cart_style')) {
    function maia_get_mobile_form_cart_style()
    {
        $ouput = (!empty(maia_tbay_get_config('mobile_form_cart_style', 'default'))) ? maia_tbay_get_config('mobile_form_cart_style', 'default') : 'default';
    
        return $ouput;
    }
}


if (!function_exists('maia_open_woocommerce_catalog_ordering')) {
    function maia_open_woocommerce_catalog_ordering()
    {
        if( !maia_is_show_woo_catalog_ordering() ) return;

        echo '<div class="tbay-ordering"><span>'. esc_html__('Sort by:', 'maia') .'</span>';
    }
    add_action('woocommerce_before_shop_loop', 'maia_open_woocommerce_catalog_ordering', 29);
}

if (!function_exists('maia_close_woocommerce_catalog_ordering')) {
    function maia_close_woocommerce_catalog_ordering()
    {
        if( !maia_is_show_woo_catalog_ordering() ) return;
        
        echo '</div>';
    }
    add_action('woocommerce_before_shop_loop', 'maia_close_woocommerce_catalog_ordering', 31);
}

if (!function_exists('maia_remove_add_to_cart_list_product')) {
    function maia_remove_add_to_cart_list_product()
    {
        remove_action('maia_woocommerce_group_buttons', 'woocommerce_template_loop_add_to_cart', 40, 1);
    }
    add_action('maia_woocommerce_before_shop_list_item', 'maia_remove_add_to_cart_list_product', 10);
}


if (! function_exists('maia_compatible_checkout_order')) {
    function maia_compatible_checkout_order()
    {
        $active = false;

        if (class_exists('WooCommerce_Germanized')) {
            $active = true;
        }

        return $active;
    }
}

/*Get display product nav*/
if ( !function_exists('maia_tbay_woocommerce_product_nav_display_mode') ) {
    function maia_tbay_woocommerce_product_nav_display_mode($mode) {
        $mode = 'icon';

        $mode = (isset($_GET['display_nav_mode'])) ? $_GET['display_nav_mode'] : $mode;

        return $mode;
    }
    add_filter( 'maia_woo_nav_display_mode', 'maia_tbay_woocommerce_product_nav_display_mode' );
}

/*Product nav icon*/
if ( !function_exists('maia_woo_product_nav_icon') ) {
    function maia_woo_product_nav_icon(){
          if ( maia_tbay_get_config('show_product_nav', false) ) {
  
              $display_mode = apply_filters( 'maia_woo_nav_display_mode', 10,2 );
  
              $output = '';
  
              if( !is_singular( 'product' ) || (isset($display_mode) && $display_mode == 'image') ) return;
  
              $prev = get_previous_post();
              $next = get_next_post();
  
              $output .= '<div class="product-nav-icon pull-right">';  
              $output .= '<div class="link-icons">';
              $output .= maia_render_product_nav_icon($prev, 'left');
              $output .= maia_render_product_nav_icon($next, 'right');
              $output .= '</div>';
  
              $output .= '</div>';
  
              return $output;
          }
    }
}
if ( !function_exists('maia_render_product_nav_icon') ) {
    function maia_render_product_nav_icon($post, $position){
        if($post){
            $product = wc_get_product($post->ID);
            $output = '';
            $img = '';
            if(has_post_thumbnail($post)){
                $img = get_the_post_thumbnail($post, 'woocommerce_gallery_thumbnail');
            }
            $link = get_permalink($post);
  
            $output .= "<div class='". esc_attr( $position ) ."-icon icon-wrapper'>";
              $output .= "<div class='text'>";
  
                  $output .= ($position == 'left') ? "<a class='img-link left' href=". esc_url($link) ."><span class='product-btn-icon'></span>". esc_html__('Previous', 'maia') . "</a>" :'';                  
  
                  $output .= ($position == 'right') ? "<a class='img-link right' href=". esc_url($link) .">". esc_html__('Next', 'maia') . "<span class='product-btn-icon'></span></a>" :'';  
  
  
              $output .= "</div>";
              $output .= "<div class='image psnav'>";
              $output .= ($position == 'left') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';  
              $output .= "<div class='product_single_nav_inner single_nav'>". maia_product_nav_inner_title_price($post, $product, $link) ."</div>";
              $output .= ($position == 'right') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';   
              $output .= "</div>";
            $output .= "</div>";
  
            return $output;
        }
    }
}

if ( !function_exists('maia_product_nav_inner_title_price') ) {
    function maia_product_nav_inner_title_price($post, $product, $link){
  
        $ouput = "<a href=". esc_url($link) .">";
        $ouput .= "<span class='name-pr'>". esc_html($post->post_title) ."</span>";
  
        $is_catalog = ( get_post_meta( $product->get_id(), '_catalog', true) == 'yes' ) ? 'yes' : '';
  
        if( $is_catalog !== 'yes' ) {
          $ouput .=  "<span class='price'>" . $product->get_price_html() . "</span>";
        }
  
        $ouput .=  "</a>";
  
        return $ouput;
    }
}

if ( ! function_exists( 'maia_get_query_products' ) ) {
    function maia_get_query_products($categories = array(), $cat_operator = '', $product_type = 'newest', $limit = '', $orderby = '', $order = '')
    {
        $atts = [
            'limit' => $limit,
            'orderby' => $orderby,
            'order' => $order
        ];
        
        if (!empty($categories)) {
            if (!is_array($categories)) {
                $atts['category'] = $categories;
            } else {
                $atts['category'] = implode(', ', $categories);
                $atts['cat_operator'] = $cat_operator;
            }
        }
        
        $type = 'products';

        $shortcode = new WC_Shortcode_Products($atts, $type);
        $args = $shortcode->get_query_args();
        
        $args = maia_get_attribute_query_product_type($args, $product_type);
        return new WP_Query($args);
    }
}

if ( ! function_exists( 'maia_get_attribute_query_product_type' ) ) {
    function maia_get_attribute_query_product_type($args, $product_type)
    {
        switch ($product_type) {
            case 'best_selling':
                $args['meta_key']   = 'total_sales';
                $args['order']          = 'desc';
                $args['orderby']    = 'meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                break;

            case 'featured':
                $args['ignore_sticky_posts']    = 1;
                $args['meta_query']             = array();
                $args['tax_query'][]              = array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN'
                    )
                );
                break;

            case 'top_rated':
                $args['meta_key']       = '_wc_average_rating';
                $args['orderby']        = 'meta_value_num';
                $args['order']          = 'desc';
                break;

            case 'newest':
                $args['meta_query'] = array();
                break;

            case 'random_product':
                $args['orderby']    = 'rand';
                $args['meta_query'] = array();
                break;

            case 'deals':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                $args['meta_query'] = array();
                $args['meta_query'][] =  array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'OR',
                        array(
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array(
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                    ),
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    ),
                );
                break;

            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                break;
        }

        if( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $args['meta_query'][] =  array(
                'relation' => 'AND',
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            );
        }

        $args['tax_query'][] = array(
            'relation' => 'AND',
            array(
               'taxonomy' =>   'product_visibility',
                'field'    =>   'slug',
                'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                'operator' =>   'NOT IN',
            )
        );

        return $args;
    }
}

if (! function_exists('maia_order_by_query')) {
    function maia_order_by_query($orderby, $order) {
        // it is always better to use WP_Query but not here
        $WC_Query_class = new WC_Query();

        switch ($orderby) {
            case 'id':
                $args['orderby'] = 'ID';
                break;
            case 'menu_order':
                $args['orderby'] = 'menu_order title';
                break;
            case 'title':
                $args['orderby'] = 'title';
                $args['order']   = ('DESC' === $order) ? 'DESC' : 'ASC';
                break;
            case 'relevance':
                $args['orderby'] = 'relevance';
                $args['order']   = 'DESC';
                break;
            case 'rand':
                $args['orderby'] = 'rand'; // @codingStandardsIgnoreLine
                break;
            case 'date':
                $args['orderby'] = 'date ID';
                $args['order']   = ('ASC' === $order) ? 'ASC' : 'DESC';
                break;
            case 'price':
            case 'price-desc':
                $callback = 'DESC' === $order ? 'order_by_price_desc_post_clauses' : 'order_by_price_asc_post_clauses';
                add_filter('posts_clauses', array( $WC_Query_class, $callback ));
                break;
            case 'popularity':
                add_filter('posts_clauses', array( $WC_Query_class, 'order_by_popularity_post_clauses' ));
                break;
            case 'rating':
                add_filter('posts_clauses', array( $WC_Query_class, 'order_by_rating_post_clauses' ));
                break;
        }
    }
}


if ( ! function_exists( 'maia_elementor_products_ajax_template' ) ) {
	function maia_elementor_products_ajax_template( $settings ) {
 
        extract($settings); 
   
        $loop = maia_get_query_products($categories, $cat_operator, $product_type, $limit, $orderby, $order);

        if ( preg_match('/\\\\/m', $attr_row) ) {
            $attr_row = preg_replace('/\\\\/m', '', $attr_row);
        }
		ob_start();

        if( $loop->have_posts() ) :

            wc_get_template('layout-products/layout-products.php', array( 'loop' => $loop, 'product_style' => $product_style, 'attr_row' => $attr_row));

        endif;

        wc_reset_loop();
		wp_reset_postdata();

        return [
            'html' => ob_get_clean(),
        ];
	}
}
if ( ! function_exists( 'maia_change_woocommerce_button_proceed_to_checkout' ) ) {
    function maia_change_woocommerce_button_proceed_to_checkout() { 
        remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
        add_action( 'maia_woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 10 );
    }
    add_action('woocommerce_before_cart','maia_change_woocommerce_button_proceed_to_checkout', 20);
}

if ( ! function_exists( 'maia_change_woocommerce_cross_sell_display' ) ) {
    function maia_change_woocommerce_cross_sell_display() { 
        remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
        add_action( 'maia_woocommerce_cross_sell_display', 'woocommerce_cross_sell_display', 10 );
    }
    add_action('woocommerce_before_cart','maia_change_woocommerce_cross_sell_display', 20);
}
 