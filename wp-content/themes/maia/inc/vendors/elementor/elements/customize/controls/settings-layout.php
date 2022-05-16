<?php
if (!function_exists('maia_settings_layout_section_advanced')) {
    function maia_settings_layout_section_advanced($widget, $args)
    {
        $widget->update_responsive_control(
            'container_width',
            [
                'default' => [
                    'size' => '1356',
                ],
                'description' => esc_html__('Sets the default width of the content area (Default: 1356)', 'maia'),
                'selectors' => [
					'.elementor-section.elementor-section-boxed > .elementor-container' => 'max-width: {{SIZE}}{{UNIT}}',
				],
            ]
        );
        
        $widget->update_control(
            'page_title_selector',
            [
                'default' => 'h1.page-title',
                'placeholder' => 'h1.page-title',
                'description' => esc_html__('Elementor lets you hide the page title. This works for themes that have "h1.page-title" selector. If your theme\'s selector is different, please enter it above.', 'maia'),
            ]
        );
    }

    add_action('elementor/element/kit/section_settings-layout/before_section_end', 'maia_settings_layout_section_advanced', 10, 2);
}
