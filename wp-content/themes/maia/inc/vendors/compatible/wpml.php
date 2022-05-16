<?php

if (! function_exists('maia_add_language_to_menu_storage_key')) {
    function maia_add_language_to_menu_storage_key( $storage_key )
    {
      global $sitepress;

      return $storage_key . '-' . $sitepress->get_current_language();
    }
}
add_filter( 'maia_menu_storage_key', 'maia_add_language_to_menu_storage_key', 10, 1 );