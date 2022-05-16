<?php
/**
 * Templates Name: Elementor
 * Widget: Instagram Feed
 */
extract($settings);

$_id = maia_tbay_random_key();
$this->settings_layout();

$this->add_render_attribute('item', 'class', 'item');

$this->add_render_attribute('row', 'data-layout', $layout_type);

$this->add_render_attribute('row', 'data-title', $heading_title);

$this->add_render_attribute('row', 'data-subtitle', $heading_subtitle);

$row = $this->get_render_attribute_string('row');

$users = maia_sb_instagram_get_user_account_data();
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php echo do_shortcode('[instagram-feed user="' . $users . '" tb-atts="yes" '. $row .' ]'); ?>
</div>