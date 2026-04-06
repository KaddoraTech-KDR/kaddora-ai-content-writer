<?php
if (!defined('ABSPATH')) exit;

class KACW_Cron
{

  public function init()
  {
    add_action('kacw_cron_hook', [$this, 'run_tasks']);
  }

  public function run_tasks()
  {

    global $wpdb;

    $table = $wpdb->prefix . 'kacw_automation';

    // Get active tasks
    $tasks = $wpdb->get_results("SELECT * FROM $table WHERE status='active'");

    if (!$tasks) return;

    foreach ($tasks as $task) {

      if (!kacw_class_exists('KACW_AI_Engine')) continue;

      $engine = new KACW_AI_Engine();

      $result = $engine->generate($task->prompt);

      // Save to history
      $wpdb->insert($wpdb->prefix . 'kacw_history', [
        'prompt'  => $task->prompt,
        'content' => $result
      ]);
    }
  }
}
