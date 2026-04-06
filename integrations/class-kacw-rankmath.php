<?php
if (!defined('ABSPATH')) exit;

class KACW_RankMath
{

  /**
   * Check plugin active
   */
  public function is_active()
  {
    return defined('RANK_MATH_VERSION');
  }

  /**
   * Save SEO Meta
   */
  public function save_meta($post_id, $title, $description)
  {

    if (!$this->is_active()) return;

    update_post_meta($post_id, 'rank_math_title', sanitize_text_field($title));
    update_post_meta($post_id, 'rank_math_description', sanitize_textarea_field($description));
  }
}
