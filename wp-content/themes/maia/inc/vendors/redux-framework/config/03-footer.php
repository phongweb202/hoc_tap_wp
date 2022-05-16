<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

/** Footer Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-border-bottom',
        'title' => esc_html__('Footer', 'maia'),
        'fields' => array(
            array(
                'id' => 'footer_type',
                'type' => 'select',
                'title' => esc_html__('Select Footer Layout', 'maia'),
                'options' => maia_tbay_get_footer_layouts(),
                'default' => 'footer_default'
            ),
            array(
                'id' => 'copyright_text',
                'type' => 'editor',
                'title' => esc_html__('Copyright Text', 'maia'),
                'default' => esc_html__('Copyright  &#64; 2022 Maia Designed by ThemBay. All Rights Reserved.', 'maia'),
                'required' => array('footer_type','=','footer_default')
            ),
            array(
                'id' => 'back_to_top',
                'type' => 'switch',
                'title' => esc_html__('Enable "Back to Top" Button', 'maia'),
                'default' => true,
            ),
        )
	)
);