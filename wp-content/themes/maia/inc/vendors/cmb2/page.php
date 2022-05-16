<?php
if (!function_exists('maia_tbay_page_metaboxes')) {
    function maia_tbay_page_metaboxes(array $metaboxes)
    {
        $sidebars = maia_sidebars_array();

        $footers = array_merge(array('global' => esc_html__('Global Setting', 'maia')), maia_tbay_get_footer_layouts());
        $headers = array_merge(array('global' => esc_html__('Global Setting', 'maia')), maia_tbay_get_header_layouts());


        $prefix = 'tbay_page_';
        $fields = array(
            array(
                'name' => esc_html__('Select Layout', 'maia'),
                'id'   => $prefix.'layout',
                'type' => 'select',
                'options' => array(
                    'main' => esc_html__('Main Content Only', 'maia'),
                    'left-main' => esc_html__('Left Sidebar - Main Content', 'maia'),
                    'main-right' => esc_html__('Main Content - Right Sidebar', 'maia'),
                )
            ),
            array(
                'id' => $prefix.'left_sidebar',
                'type' => 'select',
                'name' => esc_html__('Left Sidebar', 'maia'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'right_sidebar',
                'type' => 'select',
                'name' => esc_html__('Right Sidebar', 'maia'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type' => 'select',
                'name' => esc_html__('Show Breadcrumb?', 'maia'),
                'options' => array(
                    'no' => esc_html__('No', 'maia'),
                    'yes' => esc_html__('Yes', 'maia')
                ),
                'default' => 'yes',
            ),
            array(
                'name' => esc_html__('Select Breadcrumbs Layout', 'maia'),
                'id'   => $prefix.'breadcrumbs_layout',
                'type' => 'select',
                'options' => array(
                    'image' => esc_html__('Background Image', 'maia'),
                    'color' => esc_html__('Background color', 'maia'),
                    'text' => esc_html__('Just text', 'maia')
                ),
                'default' => 'text',
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'colorpicker',
                'name' => esc_html__('Breadcrumb Background Color', 'maia')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',
                'type' => 'file',
                'name' => esc_html__('Breadcrumb Background Image', 'maia')
            ),
        );

        $after_array = array(
            array(
                'id' => $prefix.'header_type',
                'type' => 'select',
                'name' => esc_html__('Header Layout Type', 'maia'),
                'description' => esc_html__('Choose a header for your website.', 'maia'),
                'options' => $headers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'maia'),
                'description' => esc_html__('Choose a footer for your website.', 'maia'),
                'options' => $footers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'maia'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maia')
            )
        );
        $fields = array_merge($fields, $after_array);
        
        $metaboxes[$prefix . 'display_setting'] = array(
            'id'                        => $prefix . 'display_setting',
            'title'                     => esc_html__('Display Settings', 'maia'),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

        return $metaboxes;
    }
}
add_filter('cmb2_meta_boxes', 'maia_tbay_page_metaboxes');

if (!function_exists('maia_tbay_cmb2_style')) {
    function maia_tbay_cmb2_style()
    {
        wp_enqueue_style('maia-cmb2', MAIA_THEME_DIR . '/inc/vendors/cmb2/assets/cmb2.css', array(), '1.0');
    }
    add_action('admin_enqueue_scripts', 'maia_tbay_cmb2_style', 10);
}
