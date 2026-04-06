<?php
if (!defined('ABSPATH')) exit;

class KACW_History_Manager
{

  public function get_all()
  {

    global $wpdb;

    return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}kacw_history ORDER BY id DESC LIMIT 50");
  }

  public function save($prompt, $content)
  {

    global $wpdb;

    return $wpdb->insert($wpdb->prefix . 'kacw_history', [
      'prompt'  => $prompt,
      'content' => $content
    ]);
  }
}
