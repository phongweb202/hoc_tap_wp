<?php

if (! defined('ABSPATH') || function_exists('Maia_Elementor_Instagram_Feed')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Maia_Elementor_Instagram_Feed extends Maia_Elementor_Carousel_Base
{
    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'tbay-instagram-feed';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Maia Instagram Feed', 'maia');
    }

    public function get_script_depends()
    {
        return [ 'maia-custom-slick', 'slick' ];
    }
 
    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-gallery-justified';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'maia'),
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'maia'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'maia'),
                    'carousel'  => esc_html__('Carousel', 'maia'),
                ],
            ]
        );

        $this->add_control(
            'heading_settings',
            [
                'label' => esc_html__('Settings', 'maia'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => false,
                'type' => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(__('Number of Photos <a href="%s" target="_blank">here</a>', 'maia'), admin_url('?page=sb-instagram-feed&tab=customize#layout')),
            ]
        );


        $this->add_control(
            'photo_size',
            [
                'label' => false,
                'type' => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(__('Image Resolution <a href="%s" target="_blank">here</a>', 'maia'), admin_url('?page=sb-instagram-feed&tab=customize#photos')),
            ]
        );

        $this->add_control(
            'header',
            [
                'label' => false,
                'type' => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(__('Header <a href="%s" target="_blank">here</a>', 'maia'), admin_url('?page=sb-instagram-feed&tab=customize#headeroptions')),
            ]
        );

        $this->add_control(
            'load_more',
            [
                'label' => false,
                'type' => Controls_Manager::RAW_HTML,
                'condition' => [
                    'layout_type' => 'grid'
                ],
                'raw'             => sprintf(__('Load More Button <a href="%s" target="_blank">here</a> </br> Only show on layout grid', 'maia'), admin_url('?page=sb-instagram-feed&tab=customize#loadmore')),
            ]
        );

        $this->add_control(
            'follow',
            [
                'label' => false,
                'type' => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(__('Follow <a href="%s" target="_blank">here</a>', 'maia'), admin_url('?page=sb-instagram-feed&tab=customize#follow')),
            ]
        );

        $this->end_controls_section();

        $this->register_controls_load_more();
        $this->register_controls_item_style();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    protected function register_controls_load_more()
    {
        $this->start_controls_section(
            'section_load_more',
            [
                'label' => esc_html__('Load More', 'maia'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'load_more_typography',
                'selector' => '{{WRAPPER}} #sbi_load .sbi_btn_text',
            ]
        );

        $this->add_responsive_control(
            'load_more_style_margin',
            [
                'label' => esc_html__('Margin', 'maia'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} #sbi_load' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_style_padding',
            [
                'label' => esc_html__('Padding', 'maia'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} #sbi_load' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_style_bg',
            [
                'label' => esc_html__('Background', 'maia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #sb_instagram #sbi_load .sbi_load_btn' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_controls_item_style()
    {
        $this->start_controls_section(
            'section_item_style',
            [
                'label' => esc_html__('Item', 'maia'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_spacing',
            [
                'label'     => esc_html__('Space Between', 'maia'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} #sb_instagram.sbi_col_4 #sbi_images .sbi_item'   => 'padding-left: {{SIZE}}{{UNIT}} !important; padding-right: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} #sb_instagram.sbi_col_4 #sbi_images'         => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}}; width: calc(100% + {{SIZE}}{{UNIT}} + {{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
$widgets_manager->register(new Maia_Elementor_Instagram_Feed());
