<?php

if (!function_exists('maia_tbay_private_size_image_setup')) {
    function maia_tbay_private_size_image_setup()
    {
        if (maia_tbay_get_global_config('config_media', false)) {
            return;
        }

        // Post Thumbnails Size 
        set_post_thumbnail_size(480, 320, true); // Unlimited height, soft crop
        update_option('thumbnail_size_w', 480);
        update_option('thumbnail_size_h', 320);

        update_option('medium_size_w', 555);    
        update_option('medium_size_h', 333);

        update_option('large_size_w', 770);
        update_option('large_size_h', 462); 
    }
    add_action('after_setup_theme', 'maia_tbay_private_size_image_setup');
}
  