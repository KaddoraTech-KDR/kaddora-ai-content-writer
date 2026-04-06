<?php
if (!defined('ABSPATH')) exit;

class KACW_Automation_Manager
{

  public function run_tasks()
  {

    global $wpdb;

    $table = $wpdb->prefix . 'kacw_automation';

    $tasks = $wpdb->get_results("SELECT * FROM $table WHERE status='active'");

    if (!$tasks) return;

    foreach ($tasks as $task) {

      if (!kacw_class_exists('KACW_Content_Generator')) continue;

      $generator = new KACW_Content_Generator();

      $content = $generator->generate($task->prompt);

      // Save into history
      $wpdb->insert($wpdb->prefix . 'kacw_history', [
        'prompt'  => $task->prompt,
        'content' => $content
      ]);
    }
  }
}
