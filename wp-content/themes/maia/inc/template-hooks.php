<?php if (! defined('MAIA_THEME_DIR')) {
    exit('No direct script access allowed');
}
/**
 * Maia woocommerce Template Hooks
 *
 * Action/filter hooks used for Maia woocommerce functions/templates.
 *
 */


/**
 * Maia Header Mobile Content.
 *
 * @see maia_the_button_mobile_menu()
 * @see maia_the_logo_mobile()
 */
add_action('maia_header_mobile_content', 'maia_the_button_mobile_menu', 5);
add_action('maia_header_mobile_content', 'maia_the_icon_home_page_mobile', 10);
add_action('maia_header_mobile_content', 'maia_the_logo_mobile', 15);
add_action('maia_header_mobile_content', 'maia_the_icon_mini_cart_header_mobile', 20);


/**
 * Maia Header Mobile before content
 *
 * @see maia_the_hook_header_mobile_all_page
 */
add_action('maia_before_header_mobile', 'maia_the_hook_header_mobile_all_page', 5);

/**Page Cart**/
remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
