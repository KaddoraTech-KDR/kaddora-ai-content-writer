<?php
if (!defined('ABSPATH')) exit;

class KACW_Deactivator
{

  public function run()
  {

    // Clear cron
    wp_clear_scheduled_hook('kacw_cron_hook');

    // Flush rewrite rules (safe)
    flush_rewrite_rules();
  }
}
