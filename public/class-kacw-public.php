<?php
if (!defined('ABSPATH')) exit;

class KACW_Public
{

  public function init()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
  }

  public function enqueue_assets()
  {

    if (!$this->is_shortcode_used()) return;

    // CSS
    wp_enqueue_style(
      'kacw-public-css',
      KACW_URL . 'assets/css/public.css',
      [],
      KACW_VERSION
    );

    // Generator JS
    wp_enqueue_script(
      'kacw-generator',
      KACW_URL . 'assets/js/generator.js',
      ['jquery'],
      KACW_VERSION,
      true
    );

    // AJAX
    wp_localize_script('kacw-generator', 'kacw_ajax', [
      'ajax_url' => admin_url('admin-ajax.php'),
      'nonce'    => wp_create_nonce('kacw_nonce')
    ]);
  }

  private function is_shortcode_used()
  {

    global $post;

    if (!$post) return false;

    return has_shortcode($post->post_content, 'kacw_generator');
  }
}
