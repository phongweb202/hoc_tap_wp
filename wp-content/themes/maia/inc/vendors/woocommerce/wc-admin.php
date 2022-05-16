<?php

if (!maia_woocommerce_activated()) {
    return;
}

// First Register the Tab by hooking into the 'woocommerce_product_data_tabs' filter
if (! function_exists('maia_add_custom_product_data_tab')) {
    add_filter('woocommerce_product_data_tabs', 'maia_add_custom_product_data_tab', 80);
    function maia_add_custom_product_data_tab($product_data_tabs)
    {
        $product_data_tabs['maia-options-tab'] = array(
          'label' => esc_html__('Maia Options', 'maia'),
          'target' => 'maia_product_data',
          'class'     => array(),
          'priority' => 100,
      );
        return $product_data_tabs;
    }
}

if (! function_exists('maia_options_woocom_product_data_fields')) {
    // functions you can call to output text boxes, select boxes, etc.
    add_action('woocommerce_product_data_panels', 'maia_options_woocom_product_data_fields');

    function maia_options_woocom_product_data_fields()
    {
        global $post;

        // Note the 'id' attribute needs to match the 'target' parameter set above
    ?> <div id = 'maia_product_data'
    class = 'panel woocommerce_options_panel' > <?php
        ?> <div class ='options_group'> <?php
                    // Text Field
        woocommerce_wp_text_input(
            array(
            'id'          => '_subtitle',
            'label'       => esc_html__('Subtitle', 'maia'),
            'placeholder' => esc_html__('Subtitle....', 'maia'),
            'description' => esc_html__('Enter the subtitle.', 'maia')
          )
        );
        woocommerce_wp_text_input(
            array(
            'id' => '_maia_video_url',
            'label' => esc_html__('Featured Video URL', 'maia'),
            'placeholder' => esc_html__('Video URL', 'maia'),
            'desc_tip' => true,
            'description' => esc_html__('Enter the video url at https://vimeo.com/ or https://www.youtube.com/', 'maia')
          )
        );

        echo '</div><div class ="options_group">';
        woocommerce_wp_text_input(
            array(
                'id'            => '_maia_custom_tab_name',
                'label'         => esc_html__( 'Custom Tab Name', 'maia' ),
                'type'          => 'text',
            )
        );

        woocommerce_wp_textarea_input(
            array(
                'id'          => '_maia_custom_tab_content', 
                'desc_tip'      => true,
                'label'       => esc_html__( 'Custom Tab Content', 'maia' ),
                'description' => esc_html__( 'Enter an optional shortcode or cusom text', 'maia' ),
            )
        );

        woocommerce_wp_text_input(
            array(
            'id'                => '_maia_custom_tab_priority',
            'label'             => esc_html__('Custom Tab priority', 'maia'),
            'desc_tip'          => true,
            'type'              => 'number',
            'description' => esc_html__('Description – 10, </br>Additional information – 20, </br>Reviews – 30', 'maia'),
            'custom_attributes' => array(
                'step' => 'any',
            ),
            )
        );
        echo '</div>';

        ?> 
      </div>

    </div><?php
    }
}
// class hide sub title product
if (!function_exists('maia_tbay_woocommerce_hide_sub_title')) {
    function maia_tbay_woocommerce_hide_sub_title($active)
    {
        $active = maia_tbay_get_config('enable_hide_sub_title_product', false);

        $active = (isset($_GET['hide_sub_title'])) ? $_GET['hide_sub_title'] : $active;

        return $active;
    }
}
add_filter('maia_hide_sub_title', 'maia_tbay_woocommerce_hide_sub_title');

if (! function_exists('maia_woo_subtitle_field_save')) {
    function maia_woo_subtitle_field_save($post_id)
    {
        $subtitle = isset( $_POST['_subtitle'] ) ? wc_clean( wp_unslash( $_POST['_subtitle'] ) ) : '';
        if (isset($subtitle)) {
            update_post_meta($post_id, '_subtitle', esc_attr($subtitle));
        }
    }
    add_action('woocommerce_process_product_meta', 'maia_woo_subtitle_field_save');
}

if (! function_exists('maia_woo_get_subtitle')) {
    function maia_woo_get_subtitle()
    {
        if (apply_filters('maia_hide_sub_title', 10, 2)) {
            return;
        }
      
        global $product;

        $_subtitle = get_post_meta($product->get_id(), '_subtitle', true);
        if (!($_subtitle == null || $_subtitle == '')) {
            echo '<div class="tbay-subtitle">'. trim($_subtitle) .'</div>';
        }
    }

    add_action('maia_after_title_tbay_subtitle', 'maia_woo_get_subtitle', 0);
}

if (! function_exists('maia_options_woocom_save_proddata_custom_fields')) {
    /** Hook callback function to save custom fields information */
    function maia_options_woocom_save_proddata_custom_fields($product)
    {
        $video_url = isset($_POST['_maia_video_url']) ? wp_unslash($_POST['_maia_video_url']) : '';
        $old_value_url = $product->get_meta('_maia_video_url');

        if ($video_url !== $old_value_url) {
            $product->update_meta_data('_maia_video_url', $video_url);
            $img_id = '';
            if (! empty($video_url)) {
                $video_info = explode(':', maia_video_type_by_url($video_url));
                $img_id     = maia_save_video_thumbnail(array(
                        'host' => $video_info[0],
                        'id'   => $video_info[1]
                    ));
            }
            $product->update_meta_data('_maia_video_image_url', $img_id);
        }

        $tab_name        = isset( $_POST['_maia_custom_tab_name'] ) ? wc_clean( wp_unslash( $_POST['_maia_custom_tab_name'] ) ) : '';
        $old_tab_name    = $product->get_meta('_maia_custom_tab_name');
            
        $tab_content        = isset( $_POST['_maia_custom_tab_content'] ) ? wp_kses_post( wp_unslash( $_POST['_maia_custom_tab_content'] ) ) : '';
        $old_tab_content    = $product->get_meta('_maia_custom_tab_content');
      
        $tab_priority = isset( $_POST['_maia_custom_tab_priority'] ) ? wc_clean( wp_unslash( $_POST['_maia_custom_tab_priority'] ) ) : '';
        $old_tab_priority = $product->get_meta('_maia_custom_tab_priority');
      
        if ($tab_name !== $old_tab_name) {
            $product->update_meta_data('_maia_custom_tab_name', $tab_name);
        }

        if ($tab_content !== $old_tab_content) {
            $product->update_meta_data('_maia_custom_tab_content', $tab_content);
        }
      
        if ($tab_priority !== $old_tab_priority) {
            $product->update_meta_data('_maia_custom_tab_priority', $tab_priority);
        }
    }

    add_action('woocommerce_admin_process_product_object', 'maia_options_woocom_save_proddata_custom_fields', 20);
}


function maia_save_video_thumbnail($video_info)
{
    $name = isset($video_info['name']) ? $video_info['name'] : $video_info['id'];
    switch ($video_info['host']) {

    case 'vimeo':
      if (function_exists('simplexml_load_file')) {
          $img_url = 'http://vimeo.com/api/v2/video/' . $video_info['id'] . '.xml';
          $xml     = simplexml_load_file($img_url);

          $img_url = isset($xml->video->thumbnail_large) ? (string) $xml->video->thumbnail_large : '';

          if (! empty($img_url)) {
              $tmp = getimagesize($img_url);

              if (! is_wp_error($tmp)) {
                  $result = 'ok';
              }
          }
      }
      break;
    case 'youtube':
      $youtube_image_sizes = array(
        'maxresdefault',
        'hqdefault',
        'mqdefault',
        'sqdefault'
      );

      $youtube_url = 'https://img.youtube.com/vi/' . $video_info['id'] . '/';
      foreach ($youtube_image_sizes as $image_size) {
          $img_url      = $youtube_url . $image_size . '.jpg';
          $get_response = wp_remote_get($img_url);
          $result = $get_response['response']['code'] == '200' ? 'ok' : 'no';
          if ($result == 'ok') {
              break;
          }
      }

      break;
  }

    $img_id = '';

    if ('ok' === $result) {
        $img_id = maia_save_remote_image($img_url, $name);
    }

    return $img_id;
}

if (! function_exists('maia_save_remote_image')) {
    function maia_save_remote_image($url, $newfile_name = '')
    {
        $url = str_replace('https', 'http', $url);
        $tmp = download_url((string) $url);

        $file_array = array();
        preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', (string) $url, $matches);
        $file_name = basename($matches[0]);
        if ('' !== $newfile_name) {
            $file_name_info = explode('.', $file_name);
            $file_name      = $newfile_name . '.' . $file_name_info[1];
        }


        if (! function_exists('remove_accents')) {
            require_once(ABSPATH . 'wp-includes/formatting.php');
        }
        $file_name = sanitize_file_name(remove_accents($file_name));
        $file_name = str_replace('-', '_', $file_name);

        $file_array['name']     = $file_name;
        $file_array['tmp_name'] = $tmp;

        // If error storing temporarily, unlink
        if (is_wp_error($tmp)) {
            @unlink($file_array['tmp_name']);
            $file_array['tmp_name'] = '';
        }

        // do the validation and storage stuff
        return media_handle_sideload($file_array, 0);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Dropdown
 * ------------------------------------------------------------------------------------------------
 */
//Dropdown template
if (! function_exists('tbay_swatch_attribute_template')) {
    function tbay_swatch_attribute_template($post)
    {
        global $post;


        $attribute_post_id = get_post_meta($post->ID, '_maia_attribute_select');
        $attribute_post_id = isset($attribute_post_id[0]) ? $attribute_post_id[0] : ''; ?>

          <select name="maia_attribute_select" class="maia_attribute_taxonomy">
            <option value="" selected="selected"><?php esc_html_e('Global Setting', 'maia'); ?></option>

              <?php

                global $wc_product_attributes;

        // Array of defined attribute taxonomies.
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if (! empty($attribute_taxonomies)) {
            foreach ($attribute_taxonomies as $tax) {
                $attribute_taxonomy_name = wc_attribute_taxonomy_name($tax->attribute_name);
                $label                   = $tax->attribute_label ? $tax->attribute_label : $tax->attribute_name;

                echo '<option value="' . esc_attr($attribute_taxonomy_name) . '" '. selected($attribute_post_id, $attribute_taxonomy_name) .' >' . esc_html($label) . '</option>';
            }
        } ?>

          </select>

        <?php
    }
}


//Dropdown Save
if (! function_exists('maia_attribute_dropdown_save')) {
    add_action('woocommerce_process_product_meta', 'maia_attribute_dropdown_save', 30, 2);

    function maia_attribute_dropdown_save($post_id)
    {
        if (isset($_POST['maia_attribute_select'])) {
            update_post_meta($post_id, '_maia_attribute_select', $_POST['maia_attribute_select']);
        }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Dropdown
 * ------------------------------------------------------------------------------------------------
 */
//Dropdown Single layout template
if (! function_exists('tbay_single_select_single_layout_template')) {
    function tbay_single_select_single_layout_template($post)
    {
        global $post;


        $layout_post_id = get_post_meta($post->ID, '_maia_single_layout_select');
        $layout_post_id = isset($layout_post_id[0]) ? $layout_post_id[0] : ''; ?>

          <select name="maia_layout_select" class="maia_single_layout_taxonomy">
            <option value="" selected="selected"><?php esc_html_e('Global Setting', 'maia'); ?></option>

              <?php

                global $wc_product_attributes;



        // Array of defined attribute taxonomies.
        $attribute_taxonomies = wc_get_attribute_taxonomies();



        $layout_selects = apply_filters('maia_layout_select_filters', array(
                    'vertical'              => esc_html__('Image Vertical', 'maia'),
                    'horizontal'            => esc_html__('Image Horizontal', 'maia'),
                    'left-main'             => esc_html__('Left - Main Sidebar', 'maia'),
                    'main-right'            => esc_html__('Main - Right Sidebar', 'maia')
                  ));

        foreach ($layout_selects as $key => $select) {
            echo '<option value="' . esc_attr($key) . '" '. selected($layout_post_id, $key) .' >' . esc_html($select) . '</option>';
        } ?>

          </select>

        <?php
    }
}


//Dropdown Save
if (! function_exists('maia_single_select_dropdown_save')) {
    add_action('woocommerce_process_product_meta', 'maia_single_select_dropdown_save', 30, 2);

    function maia_single_select_dropdown_save($post_id)
    {
        if (isset($_POST['maia_layout_select'])) {
            update_post_meta($post_id, '_maia_single_layout_select', $_POST['maia_layout_select']);
        }
    }
}
