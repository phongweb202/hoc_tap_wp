<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Maia_Elementor_Addons
{
    public function __construct()
    {
        $this->include_control_customize_widgets();
        $this->include_render_customize_widgets();

        add_action('elementor/elements/categories_registered', array( $this, 'add_category' ));

        add_action('elementor/widgets/register', array( $this, 'include_widgets' ));

        add_action('wp', [ $this, 'regeister_scripts_frontend' ]);

        // frontend
        // Register widget scripts
        add_action('elementor/frontend/after_register_scripts', [ $this, 'frontend_after_register_scripts' ]);
        add_action('elementor/frontend/after_enqueue_scripts', [ $this, 'frontend_after_enqueue_scripts' ]);

        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_icons'], 99);

        // editor
        add_action('elementor/editor/after_register_scripts', [ $this, 'editor_after_register_scripts' ]);
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'editor_after_enqueue_scripts']);

    
        add_action('widgets_init', array( $this, 'register_wp_widgets' ));

    }

    public function editor_after_register_scripts()
    {
        if (maia_is_remove_scripts()) {
            return;
        }

        $suffix = (maia_tbay_get_config('minified_js', false)) ? '.min' : MAIA_MIN_JS;
        // /*slick jquery*/
        wp_register_script('slick', MAIA_SCRIPTS . '/slick' . $suffix . '.js', array(), '1.0.0', true);
        wp_register_script('maia-custom-slick', MAIA_SCRIPTS . '/custom-slick' . $suffix . '.js', array( ), MAIA_THEME_VERSION, true);

        wp_register_script('maia-script', MAIA_SCRIPTS . '/functions' . $suffix . '.js', array(), MAIA_THEME_VERSION, true);
    
        wp_register_script('popper', MAIA_SCRIPTS . '/popper' . $suffix . '.js', array( ), '1.12.9', true);
        wp_register_script('bootstrap', MAIA_SCRIPTS . '/bootstrap' . $suffix . '.js', array( 'popper' ), '5.1', true);
          
        // Add before after image
        wp_register_script( 'before-after-image', MAIA_SCRIPTS . '/cndk.beforeafter' . $suffix . '.js', array('maia-script' ), '0.0.2', true ); 
        wp_register_style( 'before-after-image', MAIA_STYLES . '/cndk.beforeafter.css', array(), '0.0.2' );

        /*Treeview menu*/
        wp_register_script('jquery-treeview', MAIA_SCRIPTS . '/jquery.treeview' . $suffix . '.js', array( ), '1.4.0', true);

        wp_enqueue_script('waypoints', MAIA_SCRIPTS . '/jquery.waypoints' . $suffix . '.js', array(), '4.0.0', true);
       
        // Add js Sumoselect version 3.0.2
        wp_register_style('sumoselect', MAIA_STYLES . '/sumoselect.css', array(), '1.0.0', 'all');
        wp_register_script('jquery-sumoselect', MAIA_SCRIPTS . '/jquery.sumoselect' . $suffix . '.js', array(), '3.0.2', true);
    }

    public function frontend_after_enqueue_scripts()
    {
    }

    public function editor_after_enqueue_scripts()
    {
    }

    public function enqueue_editor_icons()
    {
        wp_enqueue_style('font-awesome', MAIA_STYLES . '/font-awesome.css', array(), '5.10.2');
        wp_enqueue_style('simple-line-icons', MAIA_STYLES . '/simple-line-icons.css', array(), '2.4.0');
        wp_enqueue_style('maia-font-tbay-custom', MAIA_STYLES . '/font-tbay-custom.css', array(), '1.0.0');
        wp_enqueue_style('material-design-iconic-font', MAIA_STYLES . '/material-design-iconic-font.css', false, '2.2.0');

        if (maia_elementor_is_edit_mode() || maia_elementor_preview_page() || maia_elementor_preview_mode()) {
            wp_enqueue_style('maia-elementor-editor', MAIA_STYLES . '/elementor-editor.css', array(), MAIA_THEME_VERSION);
        }
    }


    /**
     * @internal Used as a callback
     */
    public function frontend_after_register_scripts()
    {
        $this->editor_after_register_scripts();
    }


    public function register_wp_widgets()
    {
    }

    public function regeister_scripts_frontend()
    {
    }


    public function add_category()
    {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'maia-elements',
            array(
                'title' => esc_html__('Maia Elements', 'maia'),
                'icon'  => 'fa fa-plug',
            )
        );
    }

    /**
     * @param $widgets_manager Elementor\Widgets_Manager
     */
    public function include_widgets($widgets_manager)
    {
        $this->include_abstract_widgets($widgets_manager);
        $this->include_general_widgets($widgets_manager);
        $this->include_header_widgets($widgets_manager);
        $this->include_woocommerce_widgets($widgets_manager);
    }


    /**
     * Widgets General Theme
     */
    public function include_general_widgets($widgets_manager)
    {
        $elements = array(
            'template',
            'heading',
            'brands',
            'banner',
            'posts-grid',
            'our-team',
            'testimonials',
            'tab-introduction',
            'list-custom-fonts',
            'button',
            'menu-vertical',
            'before-after-image',
        );

        if (class_exists('MC4WP_MailChimp')) {
            array_push($elements, 'newsletter');
        }

        
        if (function_exists('sb_instagram_feed_init')) {
            array_push($elements, 'instagram-feed');
        }

        $elements = apply_filters('maia_general_elements_array', $elements);

        foreach ($elements as $file) {
            $path   = MAIA_ELEMENTOR .'/elements/general/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    /**
     * Widgets WooComerce Theme
     */
    public function include_woocommerce_widgets($widgets_manager)
    {
        if (!maia_woocommerce_activated()) {
            return;
        }

        $woo_elements = array(
            'products',
            'single-product-home',
            'product-category',
            'product-tabs',
            'woocommerce-tags',
            'custom-image-list-tags',
            'product-categories-tabs',
            'list-categories-product',
            'product-recently-viewed',
            'custom-image-list-categories',
            'product-flash-sales',
            'product-count-down',
            'product-list-tags'
        );

        $woo_elements = apply_filters('maia_woocommerce_elements_array', $woo_elements);

        foreach ($woo_elements as $file) {
            $path   = MAIA_ELEMENTOR .'/elements/woocommerce/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    /**
     * Widgets Header Theme
     */
    public function include_header_widgets($widgets_manager)
    {
        $elements = array(
            'site-logo',
            'nav-menu',
            'search-form',
            'canvas-menu-template',
            'search-canvas',
        );

        if (maia_woocommerce_activated()) {
            array_push($elements, 'account');

            if (!maia_catalog_mode_active()) {
                array_push($elements, 'mini-cart');
            }
        }

        if (class_exists('WOOCS_STARTER')) {
            array_push($elements, 'currency');
        }

        if (class_exists('YITH_WCWL')) {
            array_push($elements, 'wishlist');
        }

        if (class_exists('YITH_Woocompare')) {
            array_push($elements, 'compare');
        }

        if (defined('TBAY_ELEMENTOR_DEMO')) {
            array_push($elements, 'custom-language');
        }

        $elements = apply_filters('maia_header_elements_array', $elements);

        foreach ($elements as $file) {
            $path   = MAIA_ELEMENTOR .'/elements/header/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }


    /**
     * Widgets Abstract Theme
     */
    public function include_abstract_widgets($widgets_manager)
    {
        $abstracts = array(
            'image',
            'base',
            'responsive',
            'carousel',
        );

        $abstracts = apply_filters('maia_abstract_elements_array', $abstracts);

        foreach ($abstracts as $file) {
            $path   = MAIA_ELEMENTOR .'/abstract/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    public function include_control_customize_widgets()
    {
        $widgets = array(
            'sticky-header',
            'column',
            'settings-layout',
            'global-typography',
        );

        $widgets = apply_filters('maia_customize_elements_array', $widgets);
 
        foreach ($widgets as $file) {
            $control   = MAIA_ELEMENTOR .'/elements/customize/controls/' . $file . '.php';
            if (file_exists($control)) {
                require_once $control;
            }
        }
    }

    public function include_render_customize_widgets()
    {
        $widgets = array(
            'sticky-header',
        );

        $widgets = apply_filters('maia_customize_elements_array', $widgets);
 
        foreach ($widgets as $file) {
            $render    = MAIA_ELEMENTOR .'/elements/customize/render/' . $file . '.php';
            if (file_exists($render)) {
                require_once $render;
            }
        }
    }
    
}

new Maia_Elementor_Addons();
