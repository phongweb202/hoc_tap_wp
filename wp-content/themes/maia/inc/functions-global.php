<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Maia 1.0
 */
define('MAIA_THEME_VERSION', '1.0');

/**
 * ------------------------------------------------------------------------------------------------
 * Define constants.
 * ------------------------------------------------------------------------------------------------
 */
define('MAIA_THEME_DIR', get_template_directory_uri());
define('MAIA_THEMEROOT', get_template_directory());
define('MAIA_IMAGES', MAIA_THEME_DIR . '/images');
define('MAIA_SCRIPTS', MAIA_THEME_DIR . '/js');

define('MAIA_STYLES', MAIA_THEME_DIR . '/css');

define('MAIA_INC', 'inc');
define('MAIA_MERLIN', MAIA_INC . '/merlin');
define('MAIA_CLASSES', MAIA_INC . '/classes');
define('MAIA_VENDORS', MAIA_INC . '/vendors');
define('MAIA_CONFIG', MAIA_VENDORS . '/redux-framework/config');
define('MAIA_WOOCOMMERCE', MAIA_VENDORS . '/woocommerce');
define('MAIA_ELEMENTOR', MAIA_THEMEROOT . '/inc/vendors/elementor');
define('MAIA_ELEMENTOR_TEMPLATES', MAIA_THEMEROOT . '/elementor_templates');
define('MAIA_PAGE_TEMPLATES', MAIA_THEMEROOT . '/page-templates');
define('MAIA_WIDGETS', MAIA_INC . '/widgets');

define('MAIA_ASSETS', MAIA_THEME_DIR . '/inc/assets');
define('MAIA_ASSETS_IMAGES', MAIA_ASSETS    . '/images');

define('MAIA_MIN_JS', '');

if (! isset($content_width)) {
    $content_width = 660;
}

function maia_tbay_get_config($name, $default = '')
{
    global $maia_options;
    if (isset($maia_options[$name])) {
        return $maia_options[$name];
    }
    return $default;
}

function maia_tbay_get_global_config($name, $default = '')
{
    $options = get_option('maia_tbay_theme_options', array());
    if (isset($options[$name])) {
        return $options[$name];
    }
    return $default;
}
