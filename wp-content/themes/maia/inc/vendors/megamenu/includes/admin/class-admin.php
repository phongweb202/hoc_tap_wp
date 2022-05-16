<?php

defined('ABSPATH') || exit();


class Maia_Admin_MegaMenu {

    public function __construct() {
        if( maia_elementor_activated() ) {
            $this->includes();
            add_action('admin_init', array($this, 'process_create_related'), 1);
        }
    }

    private function includes() {
        include_once get_template_directory() . '/inc/vendors/megamenu/includes/admin/class-admin-assets.php';
    }

    public function process_create_related($post_id) {
        if (isset($_GET['maia-menu-createable']) && isset($_GET['menu_id']) && absint($_GET['menu_id'])) {
            $menu_id = (int)$_GET['menu_id'];


            $related_id = maia_megamenu_get_post_related_menu($menu_id);

            if (!$related_id) {
                maia_megamenu_create_related_post($menu_id);
                $related_id = maia_megamenu_get_post_related_menu($menu_id);
            }

            if ($related_id && isset($_REQUEST['menu_id']) && is_admin()) {
                $url    = Elementor\Plugin::instance()->documents->get($related_id)->get_edit_url();
                $action = add_query_arg(array('maia-menu-editable' => 1), $url);

                wp_redirect($action);
                die;
            }
            exit();
        }
    }
}

new Maia_Admin_MegaMenu();
