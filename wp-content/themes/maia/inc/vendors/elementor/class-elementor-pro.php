<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('elementor/theme/before_do_header', function () {
    $class = (maia_tbay_get_config('hidden_header_el_pro_mobile', true)) ? 'hidden-header' : '';

    echo '<div class="tbay-el-pro-wrapper '. esc_attr($class) .'"><div id="tbay-main-content" class="site">';
});

add_action('elementor/theme/after_do_header', function () {
    do_action('maia_before_theme_header');

    echo '<div class="site-content-contain"><div id="content" class="site-content">';
});

add_action('elementor/theme/before_do_footer', function () {
    echo '</div></div>';
});

add_action('elementor/theme/after_do_footer', function () {
    echo '</div>' . do_action('maia_end_wrapper') . '</div>';
});
