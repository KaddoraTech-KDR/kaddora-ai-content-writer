<?php
if (!defined('ABSPATH')) exit;

class KACW_History_Table
{

  public function create()
  {

    global $wpdb;

    $table = $wpdb->prefix . 'kacw_history';

    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
            id BIGINT AUTO_INCREMENT PRIMARY KEY,
            prompt TEXT,
            content LONGTEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) $charset;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }
}
