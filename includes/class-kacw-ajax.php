<?php
if (!defined('ABSPATH')) exit;

class KACW_Ajax
{

  public function init()
  {
    add_action('wp_ajax_kacw_save_template', [$this, 'save_template']);

    add_action('wp_ajax_kacw_seo_analyze', [$this, 'seo_analyze']);
    add_action('wp_ajax_kacw_keyword_suggest', [$this, 'keyword_suggest']);

    add_action('wp_ajax_kacw_save_automation', [$this, 'save_automation']);

    add_action('wp_ajax_kacw_clear_logs', [$this, 'clear_logs']);

    add_action('wp_ajax_kacw_generate', [$this, 'generate']);
    add_action('wp_ajax_nopriv_kacw_generate', [$this, 'generate']);

    add_action('wp_ajax_kacw_generate_all', [$this, 'generate_all']);

    add_action('wp_ajax_kacw_generate_title', [$this, 'generate_title']);

    add_action('wp_ajax_kacw_generate_outline', [$this, 'generate_outline']);

    add_action('wp_ajax_kacw_delete_history', [$this, 'delete_history']);
  }

  // delete_history
  public function delete_history()
  {
    if (!KACW_Security::verify_nonce($_POST['nonce'] ?? '')) {
      wp_send_json_error('Invalid request');
    }

    if (!current_user_can('manage_options')) {
      wp_send_json_error('No permission');
    }

    $id = intval($_POST['id']);

    if (!$id) {
      wp_send_json_error('Invalid ID');
    }

    global $wpdb;

    $table = $wpdb->prefix . 'kacw_history';

    $deleted = $wpdb->delete($table, ['id' => $id], ['%d']);

    if ($deleted) {
      wp_send_json_success('Deleted');
    } else {
      wp_send_json_error('Delete failed');
    }
  }

  // generate_outline
  public function generate_outline()
  {

    $topic = sanitize_text_field($_POST['topic']);

    $obj = new KACW_Outline_Generator();

    $result = $obj->generate($topic);

    wp_send_json_success($result);
  }

  // generate_title
  public function generate_title()
  {
    $topic = sanitize_text_field($_POST['topic']);

    if (!kacw_class_exists('KACW_Title_Generator')) {
      wp_send_json_error('Missing module');
    }

    $obj = new KACW_Title_Generator();

    $result = $obj->generate($topic);

    wp_send_json_success($result);
  }

  // generate_all
  public function generate_all()
  {
    $topic = sanitize_text_field($_POST['topic']);

    if (!kacw_class_exists('KACW_Multi_Generator')) {
      wp_send_json_error('Module missing');
    }

    $multi = new KACW_Multi_Generator();

    $result = $multi->generate_all($topic);

    wp_send_json_success($result);
  }

  // generate
  public function generate()
  {
    if (!KACW_Security::verify_nonce($_POST['nonce'] ?? '')) {
      wp_send_json_error('Invalid request');
    }

    $prompt = KACW_Security::clean_textarea($_POST['prompt'] ?? '');

    if (!$prompt) {
      wp_send_json_error('Empty prompt');
    }

    try {
      // Generate
      if (kacw_class_exists('KACW_Content_Generator')) {
        $result = (new KACW_Content_Generator())->generate($prompt);
      } else {
        $result = (new KACW_AI_Engine())->generate($prompt);
      }

      // Save history
      $this->save_history($prompt, $result);

      // Create post
      $post_id = wp_insert_post([
        'post_title'   => wp_trim_words($prompt, 6),
        'post_content' => $result,
        'post_status'  => 'draft'
      ]);

      // Apply SEO
      if ($post_id && kacw_class_exists('KACW_SEO_Helper')) {
        (new KACW_SEO_Helper())->apply_seo($post_id, $result);
      }

      wp_send_json_success($result);
    } catch (Exception $e) {

      if (kacw_class_exists('KACW_Logger')) {
        KACW_Logger::log($e->getMessage());
      }

      wp_send_json_error('Something went wrong');
    }
  }

  // clear_logs
  public function clear_logs()
  {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'kacw_nonce')) {
      wp_send_json_error('Invalid nonce');
    }

    if (!current_user_can('manage_options')) {
      wp_send_json_error('No permission');
    }

    if (kacw_class_exists('KACW_Logger')) {
      KACW_Logger::clear_logs();
    }

    wp_send_json_success('Logs cleared');
  }

  // save_automation
  public function save_automation()
  {

    if (!current_user_can('manage_options')) {
      wp_send_json_error('No permission');
    }

    $title  = sanitize_text_field($_POST['title']);
    $prompt = sanitize_textarea_field($_POST['prompt']);

    if (!$title || !$prompt) {
      wp_send_json_error('Empty fields');
    }

    global $wpdb;

    $wpdb->insert($wpdb->prefix . 'kacw_automation', [
      'title'  => $title,
      'prompt' => $prompt
    ]);

    wp_send_json_success('Automation saved');
  }

  // keyword_suggest
  public function keyword_suggest()
  {

    if (!current_user_can('manage_options')) {
      wp_send_json_error('No permission');
    }

    $topic = sanitize_text_field($_POST['topic']);

    $seo = new KACW_SEO_Optimizer();

    $keywords = $seo->suggest_keywords($topic);

    wp_send_json_success($keywords);
  }

  // seo_analyze
  public function seo_analyze()
  {

    if (!current_user_can('manage_options')) {
      wp_send_json_error('No permission');
    }

    $content = sanitize_textarea_field($_POST['content']);
    $keyword = sanitize_text_field($_POST['keyword']);

    if (!kacw_class_exists('KACW_SEO_Optimizer')) {
      wp_send_json_error('SEO module missing');
    }

    $seo = new KACW_SEO_Optimizer();

    $result = $seo->analyze($content, $keyword);

    wp_send_json_success($result);
  }

  // save_template
  public function save_template()
  {

    if (!current_user_can('manage_options')) {
      wp_send_json_error('No permission');
    }

    $title  = sanitize_text_field($_POST['title']);
    $prompt = sanitize_textarea_field($_POST['prompt']);

    if (!$title || !$prompt) {
      wp_send_json_error('Empty fields');
    }

    global $wpdb;

    $table = $wpdb->prefix . 'kacw_templates';

    $wpdb->insert(
      $table,
      [
        'title'  => $title,
        'prompt' => $prompt
      ],
      ['%s', '%s']
    );

    wp_send_json_success('Template saved');
  }

  // save_history
  private function save_history($prompt, $content)
  {

    global $wpdb;

    $table = $wpdb->prefix . 'kacw_history';

    $wpdb->insert(
      $table,
      [
        'prompt'  => $prompt,
        'content' => $content
      ],
      ['%s', '%s']
    );
  }
}
