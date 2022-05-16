<?php

if (! defined('ABSPATH') || function_exists('Maia_Elementor_Product_Category')) {
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
class Maia_Elementor_Product_Category extends Maia_Elementor_Carousel_Base
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
        return 'tbay-product-category';
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
        return esc_html__('Maia Product Category', 'maia');
    }

    public function get_categories()
    {
        return [ 'maia-elements', 'woocommerce-elements'];
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
        return 'eicon-product-categories';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    public function get_script_depends()
    {
        return ['slick', 'maia-custom-slick'];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'product', 'products', 'category' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('Product Category', 'maia'),
            ]
        );
        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of products', 'maia'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Number of products to show ( -1 = all )', 'maia'),
                'default' => 6,
                'min'  => -1
            ]
        );
    

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'maia'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->register_woocommerce_order();
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

        $categories = $this->get_product_categories();

        $this->add_control(
            'category',
            [
                'label'     => esc_html__('Category', 'maia'),
                'type'      => Controls_Manager::SELECT,
                'default'   => array_keys($categories)[0],
                'options'   => $categories,
            ]
        );
        $this->add_control(
            'product_type',
            [
                'label' => esc_html__('Product Type', 'maia'),
                'type' => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => $this->get_product_type(),
            ]
        );
        $this->add_control(
            'product_style',
            [
                'label' => esc_html__('Product Style', 'maia'),
                'type' => Controls_Manager::SELECT,
                'default' => 'v1',
                'options' => $this->get_template_product(),
                'prefix_class' => 'elementor-product-'
            ]
        );

        $this->register_button();
        $this->end_controls_section();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    protected function register_button()
    {
        $this->add_control(
            'show_all',
            [
                'label'     => esc_html__('Display Show All', 'maia'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control(
            'position_show_all',
            [
                'label'     => esc_html__('Position', 'maia'),
                'type'      => Controls_Manager::SELECT,
                'options' => [
                    'top' => esc_html__('Top', 'maia'),
                    'bottom' => esc_html__('Bottom', 'maia'),
                ],
                'default' => 'bottom',
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'text_show_all',
            [
                'label'     => esc_html__('Text Button', 'maia'),
                'default'   => esc_html__('View all products', 'maia'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'icon_show_all',
            [
                'label'     => esc_html__('Icon Button', 'maia'),
                'type'      => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-arrow-right',
                    'library' => 'tbay-custom',
                ],
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
    }
    
    public function render_item_button()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $category = get_term_by('slug', $category, 'product_cat');
        $url_category =  get_term_link($category);
        if (isset($text_show_all) && !empty($text_show_all)) {?>
            <a href="<?php echo esc_url($url_category)?>" class="show-all"><?php echo trim($text_show_all) ?>
                <?php
                    $this->render_item_icon($icon_show_all);
                ?>
                
            </a>
            <?php
        }
    }

    protected function render_element_heading_2()
    {
        $heading_title = $heading_title_tag = $heading_subtitle = '';
        $settings = $this->get_settings_for_display();
        extract($settings);
        $url_show_all = get_permalink(wc_get_page_id('shop'));
        $check_show_all_top = $settings['show_all'] === 'yes' && $settings['position_show_all'] === 'top' && (!empty($settings['text_show_all']) || !empty($settings['icon_show_all']['value']));

        if ($check_show_all_top || !empty($heading_subtitle) || !empty($heading_title)) {
            ?>
                <div class="wrapper-title-heading">
                    <?php
                        if (!empty($heading_subtitle) || !empty($heading_title)) : ?>
                            <<?php echo trim($heading_title_tag); ?> class="heading-tbay-title">
                                <?php if (!empty($heading_title)) : ?>
                                    <span class="title"><?php echo trim($heading_title); ?></span>
                                <?php endif; ?>	    	
                                <?php if (!empty($heading_subtitle)) : ?>
                                    <span class="subtitle"><?php echo trim($heading_subtitle); ?></span>
                                <?php endif; ?>
                            </<?php echo trim($heading_title_tag); ?>>
                        <?php endif;
                
            if ($check_show_all_top) {
                ?> <a href="<?php echo esc_url($url_show_all) ?>" class="show-all"><?php echo trim($settings['text_show_all']) ?>
                                <?php if (!empty($settings['icon_show_all']['value'])) {
                    echo '<i class="'. esc_attr($settings['icon_show_all']['value']) .'"></i>';
                } ?>
                            </a> <?php
            } ?>
                </div>
            <?php
        }
    }
}
$widgets_manager->register(new Maia_Elementor_Product_Category());
