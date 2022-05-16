<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;


/** Custom CSS/JS Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-code-setting',
        'title' => esc_html__('Custom CSS/JS', 'maia'),
	)
);

Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Custom CSS', 'maia'),
        'fields' => array(
            array(
                'title' => esc_html__('Global Custom CSS', 'maia'),
                'id' => 'custom_css',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
            array(
                'title' => esc_html__('Custom CSS for desktop', 'maia'),
                'id' => 'css_desktop',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
            array(
                'title' => esc_html__('Custom CSS for tablet', 'maia'),
                'id' => 'css_tablet',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
            array(
                'title' => esc_html__('Custom CSS for mobile landscape', 'maia'),
                'id' => 'css_wide_mobile',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
            array(
                'title' => esc_html__('Custom CSS for mobile', 'maia'),
                'id' => 'css_mobile',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
        )
	)
);

Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Custom Js', 'maia'),
        'fields' => array(
            array(
                'title' => esc_html__('Header JavaScript Code', 'maia'),
                'subtitle' => '<em>'.esc_html__('Paste your custom JS code here. The code will be added to the header of your site.', 'maia').'<em>',
                'id' => 'header_js',
                'type' => 'ace_editor',
                'mode' => 'javascript',
            ),
            
            array(
                'title' => esc_html__('Footer JavaScript Code', 'maia'),
                'subtitle' => '<em>'.esc_html__('Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.', 'maia').'<em>',
                'id' => 'footer_js',
                'type' => 'ace_editor',
                'mode' => 'javascript',
            ),
        )
	)
);