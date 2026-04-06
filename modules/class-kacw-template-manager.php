<?php
if (!defined('ABSPATH')) exit;

class KACW_Template_Manager
{

  public function get_templates()
  {

    global $wpdb;

    return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}kacw_templates ORDER BY id DESC");
  }

  public function save($title, $prompt)
  {

    global $wpdb;

    return $wpdb->insert($wpdb->prefix . 'kacw_templates', [
      'title'  => $title,
      'prompt' => $prompt
    ]);
  }
}
