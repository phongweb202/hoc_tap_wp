<?php

if (! defined('ABSPATH') || function_exists('Maia_Elementor_Heading')) {
    exit; // Exit if accessed directly.
}
/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Maia_Elementor_Heading extends Maia_Elementor_Widget_Base
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
        return 'tbay-heading';
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
        return esc_html__('Maia Heading', 'maia');
    }

    public function get_keywords()
    {
        return ['heading', 'title', 'text'];
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
        return 'eicon-t-letter';
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
        $this->register_controls_heading(array(), true);

        $this->update_control(
            'heading_title',
            [
                'default' => esc_html__('Title', 'maia'),
            ]
        );
    }
}
$widgets_manager->register(new Maia_Elementor_Heading());
