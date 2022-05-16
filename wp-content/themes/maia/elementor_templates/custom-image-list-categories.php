<?php
/**
 * Templates Name: Elementor
 * Widget: Products Category
 */
$layout_type = $settings['layout_type'];
$attribute = '';
$this->settings_layout();
$this->add_render_attribute('item', 'class', 'item');
$this->add_render_attribute('item-cat', 'class', 'item-cat');
$url_show_all = get_permalink(wc_get_page_id('shop'));

?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php $this->render_element_heading_2(); ?>
    <div <?php echo trim($this->get_render_attribute_string('row')); ?> > 
        <?php foreach ($settings['custom_image_list_category'] as $index => $item) {
    $type = $item['type'];
    $item_setting_key = $this->get_repeater_setting_key('type', 'custom_image_list_category', $index);
    $this->add_render_attribute($item_setting_key, [
                    'class' => [ 'item', 'item-'.$type ],
                ]); ?>
                <div <?php echo trim($this->get_render_attribute_string($item_setting_key)); ?>>
                    <div <?php echo trim($this->get_render_attribute_string('item-cat')); ?>>
                        <?php $this->render_item_content($item, $attribute, $settings['display_count_category']); ?>
                    </div>
                </div>
            <?php
}
        ?>
    </div>

    <?php if ($settings['show_all'] === 'yes' && $settings['position_show_all'] === 'bottom' && (!empty($settings['text_show_all']) || !empty($settings['icon_show_all']['value']))) {
            ?> <a href="<?php echo esc_url($url_show_all) ?>" class="show-all"><?php echo trim($settings['text_show_all']) ?>
            <?php if (!empty($settings['icon_show_all']['value'])) {
                echo '<i class="'. esc_attr($settings['icon_show_all']['value']) .'"></i>';
            } ?>
        </a> <?php
        } ?>
</div>