<?php
    if( maia_checkout_optimized() ) return;
    /**
     * maia_before_topbar_mobile hook
     */
    do_action('maia_before_footer_mobile');
    $mobile_footer_slides = maia_tbay_get_config('mobile_footer_slides');
?>



<?php
    if ($mobile_footer_slides && !empty($mobile_footer_slides)) {
        ?>
            <div class="footer-device-mobile d-xl-none clearfix">
            <?php
                /**
                * maia_before_footer_mobile hook
                */
                do_action('maia_before_footer_mobile');

        /**
        * Hook: maia_footer_mobile_content.
        *
        * @hooked maia_the_custom_list_menu_icon - 10
        */

        do_action('maia_footer_mobile_content');

        /**
        * maia_after_footer_mobile hook
        */
        do_action('maia_after_footer_mobile'); ?>
            </div>
        <?php
    }
?>

