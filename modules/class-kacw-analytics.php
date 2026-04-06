<?php
if (!defined('ABSPATH')) exit;

class KACW_Analytics
{

  public function init() {}

  /**
   * 🔥 TOTAL COUNT
   */
  public function total_generations()
  {
    global $wpdb;

    $table = $wpdb->prefix . 'kacw_history';

    return (int) $wpdb->get_var("SELECT COUNT(*) FROM $table");
  }

  /**
   * DAILY DATA (last 7 days)
   */
  public function daily_stats()
  {
    global $wpdb;

    $table = $wpdb->prefix . 'kacw_history';

    return $wpdb->get_results("
            SELECT DATE(created_at) as day, COUNT(*) as total
            FROM $table
            GROUP BY day
            ORDER BY day DESC
            LIMIT 7
        ");
  }
}
