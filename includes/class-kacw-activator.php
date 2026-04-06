<?php
if (!defined('ABSPATH')) exit;

class KACW_Activator
{

  public function run()
  {

    // Create DB tables
    if (kacw_class_exists('KACW_DB')) {
      $db = new KACW_DB();
      kacw_call($db, 'create_tables');
    }

    // Default options
    add_option('kacw_version', KACW_VERSION);
    add_option('kacw_ai_provider', 'openai');

    update_option('kacw_ai_provider', 'openai');
    // or gemini / anthropic

    // API Key
    if (!get_option('kacw_api_key')) {
      update_option('kacw_api_key', wp_generate_password(32, false));
    }

    // Cron setup
    if (!wp_next_scheduled('kacw_cron_hook')) {
      wp_schedule_event(time(), 'hourly', 'kacw_cron_hook');
    }
  }
}
