<?php
if (!defined('ABSPATH')) exit;

class KACW_Automation_Table
{

  public function create()
  {

    global $wpdb;

    $table = $wpdb->prefix . 'kacw_automation';

    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
            id BIGINT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255),
            prompt TEXT,
            status VARCHAR(20) DEFAULT 'active',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) $charset;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }
}
