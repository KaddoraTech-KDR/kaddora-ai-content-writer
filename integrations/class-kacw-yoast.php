<?php
if (!defined('ABSPATH')) exit;

class KACW_Yoast
{
  // is_active
  public function is_active()
  {
    return defined('WPSEO_VERSION');
  }

  // save_meta
  public function save_meta($post_id, $title, $description)
  {

    if (!$this->is_active()) return;

    update_post_meta($post_id, '_yoast_wpseo_title', sanitize_text_field($title));
    update_post_meta($post_id, '_yoast_wpseo_metadesc', sanitize_textarea_field($description));
  }
}
