<?php
if (! defined('ABSPATH') || !maia_woocommerce_activated()) {
    exit;
}

if (! class_exists('Maia_Shop_WooCommerce')) :


    class Maia_Shop_WooCommerce
    {
        public static $instance;

        public static function getInstance()
        {
            if (! isset(self::$instance) && ! (self::$instance instanceof Maia_Shop_WooCommerce)) {
                self::$instance = new Maia_Shop_WooCommerce();
            }

            return self::$instance;
        }


        /**
         * Setup class.
         *
         * @since 1.0
         *
         */
        public function __construct()
        {
            add_action('woocommerce_archive_description', array( $this, 'shop_category_image'), 2);
            add_action('woocommerce_before_main_content', array( $this, 'shop_remove_des_image'), 20);

            /*Shop page*/
            add_action('woocommerce_before_shop_loop', array( $this, 'shop_display_modes'), 40);
            add_action('woocommerce_before_shop_loop', array( $this, 'shop_filter_before'), 3);
            add_action('woocommerce_before_shop_loop', array( $this, 'content_shop_filter_before'), 15);
            add_action('woocommerce_before_shop_loop', array( $this, 'content_shop_filter_after'), 70);
            add_action('woocommerce_before_shop_loop', array( $this, 'shop_filter_after'), 70);

            
            /*Filter Sidebar*/
            add_action('woocommerce_before_shop_loop', array( $this, 'button_filter_sidebar_html'), 20);

            /*Vendor Dokan page*/
            if (class_exists('WeDevs_Dokan')) {
                add_action('dokan_store_profile_frame_after', array( $this, 'shop_filter_before'), 3);
                add_action('dokan_store_profile_frame_after', array( $this, 'content_shop_filter_before'), 15);
                add_action('dokan_store_profile_frame_after', array( $this, 'content_shop_filter_after'), 70);
                add_action('dokan_store_profile_frame_after', array( $this, 'shop_filter_after'), 70);
            }

            add_filter('loop_shop_per_page', array( $this, 'shop_per_page'), 10);
            add_filter('loop_shop_columns', array( $this, 'shop_columns'), 10);


            /*display image mode*/
            add_filter('maia_woo_display_image_mode', array( $this, 'get_display_image_mode'), 10, 1);

            add_action('woocommerce_before_shop_loop_item_title', array( $this, 'the_display_image_mode'), 10);

            /*swatches*/
            add_action('maia_tbay_variable_product', array( $this, 'the_woocommerce_variable'), 20);
            add_action('maia_woo_list_after_short_description', array( $this, 'the_woocommerce_variable'), 5);
            add_action('maia_woo_before_shop_loop_item_caption', array( $this, 'grid_variable_swatches_pro'), 10);
            add_action('maia_woo_list_after_short_description', array( $this, 'list_variable_swatches_pro'), 5);

            add_action('maia_woocommerce_before_shop_list_item', array( $this, 'remove_variable_on_list'), 10);

            /*Shop Query*/
            add_action('woocommerce_product_query', array( $this, 'product_per_page_query'), 10, 2);

            /*Product Archive Sidebar Top*/
            add_action('maia_woo_template_main_before', array( $this, 'shop_product_top_archive'), 5);

            /*Product Archive Sidebar Bottom*/
            add_action('woocommerce_after_main_container', array( $this, 'shop_product_bottom_archive'), 99);
            

            add_filter('maia_woocommerce_sub_categories', array( $this, 'show_product_subcategories'), 10, 1);


            add_filter('woocommerce_show_page_title', array( $this, 'remove_title_product_archives_active'), 10, 1);

            add_filter('maia_woo_config_display_mode', array( $this, 'display_modes_active'), 10, 1);

            /*The YITH BRAND*/
            add_action('maia_woo_show_brands', array( $this, 'the_brands_the_name'), 5);
            add_action('maia_woo_before_shop_list_caption', array( $this, 'the_brands_the_name'), 10);
            
            add_action('woocommerce_before_single_product_summary', array( $this, 'excerpt_product_variable'), 10);
            
            /* sold */
            add_action('maia_woo_list_sold', array( $this, 'maia_tbay_total_sales'), 5);
        }

        public function remove_variable_on_list()
        {
            remove_action('maia_tbay_after_shop_loop_item_title', array( $this, 'the_woocommerce_variable'), 20);
        }

        public function shop_display_modes()
        {
            $active  = apply_filters('maia_woo_config_display_mode', 10, 2);
            
            if (!$active || !wc_get_loop_prop('is_paginated') || (!woocommerce_products_will_display() && !maia_woo_is_vendor_page())) {
                return;
            }
            
            $woo_mode      = maia_tbay_woocommerce_get_display_mode();

            $grid = ($woo_mode == 'grid') ? 'active' : '';
            $list = ($woo_mode == 'list') ? 'active' : '';
            ?>
	        <div class="display-mode-warpper">
                <a href="javascript:void(0);" id="display-mode-list" class="display-mode-btn list <?php echo esc_attr($list); ?>" title="<?php esc_attr_e('List', 'maia'); ?>" ><i class="tb-icon tb-icon-task-square"></i></a>
	            <a href="javascript:void(0);" id="display-mode-grid" class="display-mode-btn <?php echo esc_attr($grid); ?>" title="<?php esc_attr_e('Grid', 'maia'); ?>" ><i class="tb-icon tb-icon-grid-2"></i></a>
	        </div>

	        <?php
        }

        
        public function is_check_woocommerce_show_sidebar()
        {
            $active = false;

            if (maia_woo_is_vendor_page()) {
                $active = true;
            } else {
                if (is_product_category() || is_product_tag() || is_product_taxonomy() || is_shop()) {
                    $page = 'product_archive_sidebar';
        
                    $sidebar = maia_tbay_get_config($page);
                    if (is_active_sidebar($sidebar)) {
                        $active = true;
                    }
                }
            }
    
            if (is_product()) {
                $active = false;
            }
    
    
            return $active;
        }

        public function button_filter_sidebar_html()
        {
            if (!$this->is_check_woocommerce_show_sidebar()) {
                return;
            }
            if (maia_woo_is_wcmp_vendor_store()) {
                $sidebar = 'wc-marketplace-store';

                if (!is_active_sidebar($sidebar)) {
                    return; 
                }
            }

            $product_archive_layout  =   (isset($_GET['product_archive_layout'])) ? $_GET['product_archive_layout'] : maia_tbay_get_config('product_archive_layout', 'shop-left');

            $filter_class = ($product_archive_layout !== 'full-width') ? ' d-xl-none' : '';
 
            echo '<div class="filter-btn-wrapper'. esc_attr($filter_class) .'"><button id="button-filter-btn" class="button-filter-btn hidden-lg hidden-md" type="submit"><i class="tb-icon tb-icon-filter" aria-hidden="true"></i>'. esc_html__('Filter', 'maia') .'</button></div>';
            echo '<div id="filter-close"></div>';
        }
        
        public function shop_filter_before()
        {
            $notproducts =  (maia_is_check_hidden_filter()) ? ' hidden' : '';

            echo '<div class="tbay-filter'. esc_attr($notproducts) . '">';
        }

        public function shop_filter_after()
        {
            echo '</div>';
        }
        
        public function content_shop_filter_before()
        {
            $class = ($this->is_check_woocommerce_show_sidebar()) ? 'filter-vendor' : '';

            echo '<div class="main-filter d-flex justify-content-end '. esc_attr($class) .'">';
        }

        public function content_shop_filter_after()
        {
            echo '</div>';
        }

        public function shop_product_top_sidebar()
        {
            $sidebar_configs = maia_tbay_get_woocommerce_layout_configs();

            if (!is_product()  && isset($sidebar_configs['product_top_sidebar']) && $sidebar_configs['product_top_sidebar']) {
                ?>

	            <?php if (is_active_sidebar('product-top-sidebar')) : ?>
	                <div class="product-top-sidebar">
	                    <div class="container">
	                        <div class="content">
	                            <?php dynamic_sidebar('product-top-sidebar'); ?>
	                        </div>
	                    </div>
	                </div>
	            <?php endif;
            }
        }

        public function shop_per_page()
        {
            if (isset($_GET['product_per_page']) && is_numeric($_GET['product_per_page'])) {
                $value = $_GET['product_per_page'];
            } else {
                $value = maia_tbay_get_config('number_products_per_page', 12);
            }

            if (is_numeric($value) && $value) {
                $number = absint($value);
            }
            return $number;
        }

        public function shop_columns()
        {
            if (isset($_GET['product_columns']) && is_numeric($_GET['product_columns'])) {
                $value = $_GET['product_columns'];
            } else {
                $value = maia_tbay_get_config('product_columns', 4);
            }

            if (in_array($value, array(1, 2, 3, 4, 5, 6))) {
                $number = $value;
            }

            return $number;
        }
    

        public function get_display_image_mode($mode)
        {
            $mode = maia_tbay_get_config('product_display_image_mode', 'one');

            $mode = (isset($_GET['display_image_mode'])) ? $_GET['display_image_mode'] : $mode;

            if (wp_is_mobile()) {
                $mode = 'one';
            }

            return $mode;
        }

        public function the_display_image_mode()
        {
            $images_mode   = apply_filters('maia_woo_display_image_mode', 10, 2);

            if (wp_is_mobile()) {
                $images_mode = 'one';
            }

            switch ($images_mode) {
                case 'one':
                    echo woocommerce_get_product_thumbnail();
                    break;

                case 'two':
                    echo maia_tbay_woocommerce_get_two_product_thumbnail();
                    break;
                    
                default:
                    echo woocommerce_get_product_thumbnail();
                    break;
            }
        }
        public function excerpt_product_variable()
        {
            global $product;
            if ($product->is_type('variable')) {
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
                add_action('woocommerce_before_single_variation', 'woocommerce_template_single_excerpt', 10);
            }
        }

        public function woo_remove_product_tabs($tabs)
        {
            unset($tabs['description']);
            unset($tabs['additional_information']);

            return $tabs;
        }

        
        

        /*stock*/
        public function maia_tbay_total_sales()
        {
            global $product;
            $total_sales        = $product->get_total_sales(); ?>
				<div class="sold"><?php esc_html_e(' Sold: ', 'maia'); ?><span class="sold-total"><?php echo esc_html($total_sales) ?></span></div>
			<?php
        }
        public function the_woocommerce_variable()
        {
            global $product;

            $active = apply_filters('maia_enable_variation_selector', 10, 2);

            if ($product->is_type('variable') && class_exists('Woo_Variation_Swatches') && $active) {
                ?>
	            	<?php echo maia_swatches_list(); ?>
	            <?php
            }
        }

        public function grid_variable_swatches_pro()
        {
            if (maia_is_woo_variation_swatches_pro()) {
                add_action('maia_woo_after_shop_loop_item_caption', 'wvs_pro_archive_variation_template', 10);
            }
        }

        public function list_variable_swatches_pro()
        {
            if (maia_is_woo_variation_swatches_pro()) {
                add_action('maia_woo_list_after_short_description', 'wvs_pro_archive_variation_template', 20);
            }
        }
        
        public function shop_category_image()
        {
            $active = apply_filters('maia_woo_pro_des_image', 10, 2);

            if (!$active) {
                return;
            }

            if (is_product_category() && !is_search()) {
                global $wp_query;
                $cat = $wp_query->get_queried_object();
                $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                $image = wp_get_attachment_url($thumbnail_id);
                if ($image) {
                    echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($cat->name) . '" />';
                }
            }
        }

        public function shop_remove_des_image()
        {
            $active = apply_filters('maia_woo_pro_des_image', 10, 2);
            
    
            if (!$active) {
                remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
                remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
            }
        }

        public function product_per_page_query($q)
        {
            $default            = maia_tbay_get_config('number_products_per_page');
            $product_per_page   = maia_woocommerce_get_fillter('product_per_page', $default);
            if (function_exists('woocommerce_products_will_display') && $q->is_main_query()) :
                $q->set('posts_per_page', $product_per_page);
            endif;
        }

        public function shop_product_top_archive()
        {
            if (is_shop()) {
                $sidebar_id = 'product-top-archive';

                if (is_active_sidebar($sidebar_id)) { ?> 
	                <aside id="sidebar-top-archive" class="sidebar top-archive-content">
	                	<?php dynamic_sidebar($sidebar_id); ?>
	            	</aside>
	            <?php }
            }
        }

        public function shop_product_bottom_archive()
        {
            if (!is_product() && !is_search()) {
                $sidebar_id = 'product-bottom-archive';

                if (is_active_sidebar($sidebar_id)) { ?> 
	                <aside id="sidebar-bottom-archive" class="sidebar bottom-archive-content">
	                	<?php dynamic_sidebar($sidebar_id); ?>
	            	</aside>
	            <?php }
            }
        }


        public function show_product_subcategories($loop_html = '')
        {
            if (wc_get_loop_prop('is_shortcode') && ! WC_Template_Loader::in_content_filter()) {
                return $loop_html;
            }

            $display_type = woocommerce_get_loop_display_mode();

            // If displaying categories, append to the loop.
            if ('subcategories' === $display_type || 'both' === $display_type) {
                ob_start();
                woocommerce_output_product_categories(array(
                    'parent_id' => is_product_category() ? get_queried_object_id() : 0,
                ));
                $loop_html .= ob_get_clean();

                if ('subcategories' === $display_type) {
                    wc_set_loop_prop('total', 0);

                    // This removes pagination and products from display for themes not using wc_get_loop_prop in their product loops.  @todo Remove in future major version.
                    global $wp_query;

                    if ($wp_query->is_main_query()) {
                        $wp_query->post_count    = 0;
                        $wp_query->max_num_pages = 0;
                    }
                }
            }

            return $loop_html;
        }

        public function title_product_archives_active()
        {
            $active = maia_tbay_get_config('title_product_archives', false);

            $active = (isset($_GET['title_product_archives'])) ? (boolean)$_GET['title_product_archives'] : (boolean)$active;

            return $active;
        }

        public function remove_title_product_archives_active()
        {
            $active = $this->title_product_archives_active();

            $active = (is_search()) ? true : $active;

            return $active;
        }


        public function display_modes_active()
        {
            $active = maia_tbay_get_config('enable_display_mode', true);

            $active = (isset($_GET['enable_display_mode'])) ? (boolean)$_GET['enable_display_mode'] : (boolean)$active;

            return $active;
        }


        public function the_brands_the_name()
        {
            if (!maia_tbay_get_config('enable_brand', false)) {
                return;
            }

            $brand = '';
            if (class_exists('YITH_WCBR')) {
                global $product;

                $terms = wp_get_post_terms($product->get_id(), 'yith_product_brand');

                if ($terms && defined('YITH_WCBR') && YITH_WCBR) {
                    $brand  .= '<ul class="show-brand">';
                    $space = ',';
                    $numItems = count($terms);
                    $i = 0;
                    foreach ($terms as $term) {
                        if (++$i === $numItems) {
                            $space ='';
                        };
                        $name = $term->name;
                        $url = get_term_link($term->slug, 'yith_product_brand');

                        $brand  .= '<li><a href="'. esc_url($url) .'">'. esc_html($name) .$space.'</a></li>';
                    }

                    $brand  .= '</ul>';
                }
            }

            echo  trim($brand);
        }
    }
endif;


if (!function_exists('maia_shop_wooCommerce')) {
    function maia_shop_wooCommerce()
    {
        return Maia_Shop_WooCommerce::getInstance();
    }
    maia_shop_wooCommerce();
}
