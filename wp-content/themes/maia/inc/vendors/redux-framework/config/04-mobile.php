<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

/** Mobile Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-smartphone-iphone',
        'title' => esc_html__('Mobile', 'maia'),
	)
);


// Mobile Header settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Header', 'maia'),
        'fields' => array(
            array(
                'id' => 'mobile_header',
                'type' => 'switch',
                'title' => esc_html__('Enable Mobile Header', 'maia'),
                'subtitle'  => esc_html__('Only off when use Header Elementor Pro on mobile ', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'mobile-logo',
                'type' => 'media',
                'required' => array('mobile_header','=', true),
                'title' => esc_html__('Upload Logo', 'maia'),
                'subtitle' => esc_html__('Image File (.png or .gif)', 'maia'),
            ),
            array(
                'id'        => 'logo_img_width_mobile',
                'type'      => 'slider',
                'required' => array('mobile_header','=', true),
                'title'     => esc_html__('Logo maximum width (px)', 'maia'),
                "default"   => 69,
                "min"       => 50,
                "step"      => 1,
                "max"       => 600,
            ),
            array(
                'id'             => 'logo_mobile_padding',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'required' => array('mobile_header','=', true),
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Logo Padding', 'maia'),
                'desc'           => esc_html__('Add more spacing around logo.', 'maia'),
                'default'            => array(
                    'padding-top'     => '',
                    'padding-right'   => '',
                    'padding-bottom'  => '',
                    'padding-left'    => '',
                    'units'          => 'px',
                ),
            ),
            array(
                'id'        => 'always_display_logo',
                'type'      => 'switch',
                'required' => array('mobile_header','=', true),
                'title'     => esc_html__('Always Display Logo', 'maia'),
                'subtitle'      => esc_html__('Logo displays on all pages (page title is disabled)', 'maia'),
                'default'   => false
            ),
           
            array(
                'id'        => 'menu_mobile_search',
                'type'      => 'switch',
                'required'  => array('mobile_header','=', true),
                'title'     => esc_html__('Always Display Search', 'maia'),
                'subtitle'  => esc_html__('Search displays on all pages', 'maia'),
                'class' =>   'tbay-search-mb-all-page',
                'default'   => false
            ),
            
            array(
                'id'        => 'hidden_header_el_pro_mobile',
                'type'      => 'switch',
                'title'     => esc_html__('Hide Header Elementor Pro', 'maia'),
                'subtitle'  => esc_html__('Hide Header Elementor Pro on mobile', 'maia'),
                'default'   => true
            ),
        )
	)
);


// Mobile Footer settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Footer', 'maia'),
        'fields' => array(
            array(
                'id' => 'mobile_footer',
                'type' => 'switch',
                'title' => esc_html__('Enable Desktop Footer', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'mobile_footer_collapse',
                'type' => 'switch',
                'required' => array('mobile_footer','=', true),
                'title' => esc_html__('Collapse widgets on mobile', 'maia'),
                'subtitle'  => esc_html__('Widgets added to the footer will be collapsed by default and opened when you click on their titles.', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'mobile_back_to_top',
                'type' => 'switch',
                'title' => esc_html__('Enable "Back to Top" Button', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'mobile_footer_icon',
                'type' => 'switch',
                'title' => esc_html__('Enable Mobile Footer', 'maia'),
                'default' => true
            ),
            array(
                'id'          => 'mobile_footer_slides',
                'type'        => 'slides',
                'title'       => esc_html__('Config List Menu Icon', 'maia'),
                'subtitle' => esc_html__('Enter icon name of fonts: ', 'maia') . '<a href="//fontawesome.com/icons?m=free/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">Simple Line Icons</a>, <a href="//fonts.thembay.com/material-design-iconic/" target="_blank">Material Design Iconic</a></br></br><b>'. esc_html__('List default URLs:', 'maia') . '</b></br></br><span class="des-label">'. esc_html__('Home page:', 'maia') .'</span><b class="df-url">{{home}}</b></br><span class="des-label">'. esc_html__('Shop page:', 'maia') .'</span><b class="df-url">{{shop}}</b></br><span class="des-label">'. esc_html__('My account page:', 'maia') .'</span><b class="df-url">{{account}}</b></br><span class="des-label">'. esc_html__('Cart page:', 'maia') .'</span><b class="df-url">{{cart}}</b></br><span class="des-label">'. esc_html__('Checkout page:', 'maia') .'</span><b class="df-url">{{checkout}}</b></br><span class="des-label">'. esc_html__('Wishlist page:', 'maia') .'</span><b class="df-url">{{wishlist}}</b></br></br>'. esc_html__('Watch video tutorial: ', 'maia') . '<a href="//youtu.be/d7b6dIzV-YI/" target="_blank">here</a>',
                'class' =>   'tbay-redux-slides',
                'show' => array(
                    'title' => true,
                    'description' => true,
                    'url' => true,
                ),
                'content_title' => esc_html__('Menu', 'maia'),
                'required' => array('mobile_footer_icon','=', true),
                'placeholder'   => array(
                    'title'      => esc_html__('Title', 'maia'),
                    'description' => esc_html__('Enter icon name', 'maia'),
                    'url'       => esc_html__('Link', 'maia'),
                ),
            ),
        )
	)
);


// Mobile Search settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Search', 'maia'),
        'fields' => array(
            array(
                'id'=>'mobile_search_type',
                'type' => 'button_set',
                'title' => esc_html__('Search Result', 'maia'),
                'options' => array(
                    'post' => esc_html__('Post', 'maia'),
                    'product' => esc_html__('Product', 'maia')
                ),
                'default' => 'product'
            ),
            array(
                'id' => 'mobile_autocomplete_search',
                'type' => 'switch',
                'title' => esc_html__('Auto-complete Search?', 'maia'),
                'default' => 1
            ),
            array(
                'id'       => 'mobile_search_placeholder',
                'type'     => 'text',
                'title'    => esc_html__('Placeholder', 'maia'),
                'default'  => esc_html__('Search in 20.000+ products...', 'maia'),
            ),
            array(
                'id' => 'mobile_enable_search_category',
                'type' => 'switch',
                'title' => esc_html__('Enable Search in Categories', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'mobile_show_search_product_subtitle',
                'type' => 'switch',
                'title' => esc_html__('Show Subtitle of Search Result', 'maia'),
                'required' => array(array('mobile_autocomplete_search', '=', '1'), array('mobile_search_type', '=', 'product')),
                'default' => false
            ), 
            array(
                'id' => 'mobile_show_search_product_image',
                'type' => 'switch',
                'title' => esc_html__('Show Image of Search Result', 'maia'),
                'required' => array('mobile_autocomplete_search', '=', '1'),
                'default' => 1
            ),
            array(
                'id' => 'mobile_show_search_product_price',
                'type' => 'switch',
                'title' => esc_html__('Show Price of Search Result', 'maia'),
                'required' => array(array('mobile_autocomplete_search', '=', '1'), array('mobile_search_type', '=', 'product')),
                'default' => true
            ),
            array(
                'id' => 'mobile_search_min_chars',
                'type'  => 'slider',
                'required' => array('mobile_autocomplete_search', '=', '1'),
                'title' => esc_html__('Search Minimum Characters', 'maia'),
                'default' => 2,
                'min'   => 1,
                'step'  => 1,
                'max'   => 6,
            ),
            array(
                'id' => 'mobile_search_max_number_results',
                'type'  => 'slider',
                'required' => array('mobile_autocomplete_search', '=', '1'),
                'title' => esc_html__('Number of Search Results', 'maia'),
                'desc'  => esc_html__('Max number of results show in Mobile', 'maia'),
                'default' => 5,
                'min'   => 2,
                'step'  => 1,
                'max'   => 20,
            ),
        )
	)
);


// Mobile Menu settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Menu Mobile', 'maia'),
        'fields' => array(
            array(
                'id'       => 'menu_mobile_select',
                'type'     => 'select',
                'data'     => 'menus',
                'title'    => esc_html__('Main Menu Mobile', 'maia'),
                'desc'     => esc_html__('Select the menu you want to display.', 'maia'),
                'default' => 69
            ),
            array(
                'id' => 'enable_mmenu_langue',
                'type' => 'switch',
                'title' => esc_html__('Enable Custom Language', 'maia'),
                'desc'  => esc_html__('If you use WPML will appear here', 'maia'),
                'default' => true
            ),
            array(
                'id' => 'enable_mmenu_currency',
                'type' => 'switch',
                'title' => esc_html__('Enable Currency', 'maia'),
                'default' => true
            ),
        )
	)
);


// Mobile WooCommerce settings
Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Mobile WooCommerce', 'maia'),
        'fields' => array(
            array(
                'id' => 'mobile_product_number',
                'type' => 'image_select',
                'title' => esc_html__('Product Column in Shop page', 'maia'),
                'options' => array(
                    'one' => array(
                        'title' => esc_html__('One Column', 'maia'),
                        'img'   => MAIA_ASSETS_IMAGES . '/mobile/one_column.jpg'
                    ),
                    'two' => array(
                        'title' => esc_html__('Two Columns', 'maia'),
                        'img'   => MAIA_ASSETS_IMAGES . '/mobile/two_columns.jpg'
                    ),
                ),
                'default' => 'two'
            ),
            array(
                'id' => 'enable_add_cart_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show "Add to Cart" Button', 'maia'),
                'subtitle' => esc_html__('On Home and page Shop', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'enable_wishlist_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show "Wishlist" Button', 'maia'),
                'subtitle' => esc_html__('Enable or disable in Home and Shop page', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'enable_one_name_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show Full Product Name', 'maia'),
                'subtitle' => esc_html__('Enable or disable in Home and Shop page', 'maia'),
                'default' => false
            ),
            array(
                'id' => 'mobile_form_cart_style',
                'type' => 'select',
                'title' => esc_html__('Add To Cart Form Type', 'maia'),
                'subtitle' => esc_html__('On Page Single Product', 'maia'),
                'options' => array(
                    'default' => esc_html__('Default', 'maia'),
                    'popup' => esc_html__('Popup', 'maia')
                ),
                'default' => 'popup'
            ),
            array(
                'id' => 'enable_quantity_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show Quantity', 'maia'),
                'subtitle' => esc_html__('On Page Single Product', 'maia'),
                'required' => array('mobile_form_cart_style','=', 'default'),
                'default' => false
            ),
            array(
                'id' => 'enable_tabs_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show Sidebar Tabs', 'maia'),
                'subtitle' => esc_html__('On Page Single Product', 'maia'),
                'default' => true
            ),
        )
	)
);