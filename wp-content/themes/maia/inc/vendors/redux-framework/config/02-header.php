<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

/** Header Settings **/
Redux::set_section(
	$opt_name,
	array(
		'icon' => 'zmdi zmdi-view-web',
		'title' => esc_html__('Header', 'maia'),
		'fields' => array(
			array(
				'id' => 'header_type',
				'type' => 'select',
				'title' => esc_html__('Select Header Layout', 'maia'),
				'options' => maia_tbay_get_header_layouts(),
				'default' => 'header_default'
			),
			array(
				'id' => 'media-logo',
				'type' => 'media',
				'title' => esc_html__('Upload Logo', 'maia'),
				'required' => array('header_type','=','header_default'),
				'subtitle' => esc_html__('Image File (.png or .gif)', 'maia'),
			),
			array(
				'id' => 'header_located_on_slider',
				'type' => 'switch',
				'title' => esc_html__('Header Located On Slider', 'maia'),
				'subtitle' => esc_html__('Only home-page','maia'),
				'default' => true,
			), 
		)
	) 
); 