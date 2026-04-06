<?php
if (!defined('ABSPATH')) exit;

class KACW_SEO_Helper
{
  public function init() {}

  /**
   * Generate SEO Title
   */
  public function generate_title($content)
  {

    if (!kacw_class_exists('KACW_AI_Engine')) return '';

    $engine = new KACW_AI_Engine();

    return $engine->generate("Generate SEO title for:\n\n" . $content);
  }

  /**
   * Generate Meta Description
   */
  public function generate_description($content)
  {

    if (!kacw_class_exists('KACW_AI_Engine')) return '';

    $engine = new KACW_AI_Engine();

    return $engine->generate("Generate meta description (160 chars) for:\n\n" . $content);
  }

  /**
   * Apply SEO to post
   */
  public function apply_seo($post_id, $content)
  {

    $title = $this->generate_title($content);
    $desc  = $this->generate_description($content);

    // RankMath
    if (kacw_class_exists('KACW_RankMath')) {
      (new KACW_RankMath())->save_meta($post_id, $title, $desc);
    }

    // Yoast
    if (kacw_class_exists('KACW_Yoast')) {
      (new KACW_Yoast())->save_meta($post_id, $title, $desc);
    }
  }
}
