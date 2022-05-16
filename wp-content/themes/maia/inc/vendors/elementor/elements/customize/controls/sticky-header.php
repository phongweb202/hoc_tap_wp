<?php
if (!function_exists('maia_section_sticky_header')) {
    function maia_section_sticky_header($widget)
    {
        if (get_post_type() !== 'tbay_custom_post') {
            return;
        }

        global $post;

        $block_type = get_post_meta($post->ID, 'tbay_block_type', true);

        if( $block_type !== 'type_header' ) {
            return;
        }


        $widget->start_controls_section(
            'sticky_header',
            array(
                'label' => esc_html__('Sticky Header', 'maia'),
                'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
            )
        );

        $widget->add_control(
            'enable_sticky_headers',
            array(
                'label'                 =>  esc_html__('Enable Sticky Headers', 'maia'),
                'type'                  => \Elementor\Controls_Manager::SWITCHER,
                'default'               => '',
                'return_value'          => 'yes',
            )
        );

        $widget->end_controls_section();
    }

    add_action('elementor/element/section/section_layout/before_section_start', 'maia_section_sticky_header', 10, 2);
}
