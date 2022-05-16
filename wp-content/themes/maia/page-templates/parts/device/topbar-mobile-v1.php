<?php
    if( maia_checkout_optimized() ) return;
    $class_top_bar 	=  '';

    $always_display_logo 			= maia_tbay_get_config('always_display_logo', true);
    if (!$always_display_logo && !maia_catalog_mode_active() && maia_woocommerce_activated() && (is_product() || is_cart() || is_checkout())) {
        $class_top_bar .= ' active-home-icon';
    }
?>
<div class="topbar-device-mobile d-xl-none clearfix <?php echo esc_attr($class_top_bar); ?>">

	<?php
        /**
        * maia_before_header_mobile hook
        */
        do_action('maia_before_header_mobile');

        /**
        * Hook: maia_header_mobile_content.
        *
        * @hooked maia_the_button_mobile_menu - 5
        * @hooked maia_the_logo_mobile - 10
        * @hooked maia_the_title_page_mobile - 10
        */

        do_action('maia_header_mobile_content');

        /**
        * maia_after_header_mobile hook

        * @hooked maia_the_search_header_mobile - 5
        */
        
        do_action('maia_after_header_mobile');
    ?>
</div>