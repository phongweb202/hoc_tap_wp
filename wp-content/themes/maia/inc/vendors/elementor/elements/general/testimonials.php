<?php

if (! defined('ABSPATH') || function_exists('Maia_Elementor_Testimonials')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Maia_Elementor_Testimonials extends Maia_Elementor_Carousel_Base
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
        return 'tbay-testimonials';
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
        return esc_html__('Maia Testimonials', 'maia');
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
        return 'eicon-testimonial';
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
            'layout_style',
            [
                'label'     => esc_html__('Layout Style', 'maia'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'style1',
                'options'   => [
                    'style1'    => esc_html__('Style 1', 'maia'),
                    'style2'    => esc_html__('Style 2', 'maia'),
                    'style3'    => esc_html__('Style 3', 'maia'),
                ],
            ]
        );

        $repeater = $this->register_testimonials_repeater();

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__('Testimonials Items', 'maia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $this->register_set_testimonial_default(),
                'testimonials_field' => '{{{ testimonials_image }}}',
            ]
        );

        $this->end_controls_section();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    private function register_testimonials_repeater()
    {
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'testimonial_image',
            [
                'label' => esc_html__('Choose Image: Avatar', 'maia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        
        $repeater->add_control(
            'title_excerpt',
            [
                'label' => esc_html__('Excerpt', 'maia'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $repeater->add_control(
            'testimonial_excerpt',
            [
                'label' => esc_html__('Description', 'maia'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
        $repeater->add_control(
            'testimonial_subtitle',
            [
                'label' => esc_html__('Sub-title', 'maia'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
        
        $repeater->add_control(
            'testimonial_name',
            [
                'label' => esc_html__('Name', 'maia'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'testimonial_sub_name',
            [
                'label' => esc_html__('Sub Name', 'maia'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        return $repeater;
    }

    private function register_set_testimonial_default()
    {
        $defaults = [
            [
                
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                
                'testimonial_name' => esc_html__('Name 1', 'maia'),
                'testimonial_sub_name' => esc_html__('Sub name 1', 'maia'),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'maia'),
                'testimonial_subtitle' => esc_html__('This is text sub-title', 'maia'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                
                'testimonial_name' => esc_html__('Name 2', 'maia'),
                'testimonial_sub_name' => esc_html__('Sub name 2', 'maia'),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'maia'),
                'testimonial_subtitle' => esc_html__('This is text sub-title', 'maia'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                
                'testimonial_name' => esc_html__('Name 3', 'maia'),
                'testimonial_sub_name' => esc_html__('Sub name 3', 'maia'),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'maia'),
                'testimonial_subtitle' => esc_html__('This is text sub-title', 'maia'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                
                'testimonial_name' => esc_html__('Name 4', 'maia'),
                'testimonial_sub_name' => esc_html__('Sub name 4', 'maia'),
                'testimonial_excerpt' => 'Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque',
                'testimonial_subtitle' => esc_html__('This is text sub-title', 'maia'),
            ],
        ];

        return $defaults;
    }

    protected function render_item_style1($item)
    {
        ?> 
        <div class="testimonials-body"> 
                <div class="testimonial-meta">
                    <div class="testimonials-info-wrapper d-flex">
                        <div class="flex-shrink-0">
                            <?php echo trim($this->get_widget_field_img($item['testimonial_image'])); ?>
                        </div>
                        <div class="testimonial-rating"></div>
                    </div>
                    <?php $this->render_item_excerpt($item); ?>
                    <?php $this->render_item_subtitle($item); ?>
                    <div class="testimonials-info">
                        <div class="testimonials-info-right">
                            <?php  
                                $this->render_item_name($item); 
                                $this->render_item_sub_name($item);
                            ?>
                        </div>
                    </div>
                    
                </div>
                
                <?php
                ?>
                <?php
            ?>
        </div>
        <?php
    }
    

    protected function render_item_style2($item)
    {
        ?> 
        <div class="testimonials-body"> 
            <div class="testimonial-meta">
                <div class="testimonials-info-wrapper">
                    <div class="testimonials-info">
                        <?php echo trim($this->get_widget_field_img($item['testimonial_image'])); ?>
                    </div>
                    <?php $this->render_item_excerpt($item); ?>

                    <div class="testimonial-rating"></div>

                    <div class="testimonials-name-sub">
                        <?php  
                            $this->render_item_name($item); 
                            $this->render_item_sub_name($item);
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <?php
    }

    protected function render_item_style3($item)
    {
        ?> 
        <div class="testimonials-body"> 
            <div class="testimonial-meta">
                <div class="testimonials-info-wrapper">
                    <div class="testimonials-info d-flex">
                        <div class="flex-shrink-0">
                            <?php echo trim($this->get_widget_field_img($item['testimonial_image'])); ?>
                        </div>
                        <div class="testimonials-info-right flex-grow-1 ms-3">
                            <?php  
                                $this->render_item_name($item); 
                                $this->render_item_sub_name($item);
                            ?>
                        </div>
                    </div>

                    <div class="testimonial-rating"></div>
                </div>
                <?php $this->render_item_excerpt($item); ?>
            </div>
        </div>
        <?php
    }
    

    private function render_item_name($item)
    {
        $testimonial_name  = $item['testimonial_name'];
        if (isset($testimonial_name) && !empty($testimonial_name)) {
            ?>
                <span class="name"><?php echo trim($testimonial_name); ?></span>
            <?php
        }
    }
    private function render_item_sub_name($item)
    {
        $testimonial_sub_name  = $item['testimonial_sub_name'];

        if (isset($testimonial_sub_name) && !empty($testimonial_sub_name)) {
            ?>
                <span class="sub-name"><?php echo trim($testimonial_sub_name) ?></span>
            <?php
        }
    }
    private function render_item_excerpt($item)
    {
        $testimonial_excerpt  = $item['testimonial_excerpt'];

        if ( isset($testimonial_excerpt) && !empty($testimonial_excerpt) ) {
            ?>  
                <div class="excerpt"><?php echo trim($testimonial_excerpt) ?></div>
            <?php
        }
    }

    private function render_item_subtitle($item)
    {
        $testimonial_subtitle  = $item['testimonial_subtitle'];

        if ( isset($testimonial_subtitle) && !empty($testimonial_subtitle) ) {
            ?>  
                <div class="subtitle"><?php echo trim($testimonial_subtitle) ?></div>
            <?php
        }
    }
}
$widgets_manager->register(new Maia_Elementor_Testimonials());
