<?php
if (!defined('ABSPATH')) exit;

class KACW_Admin_Assets
{

  public function init()
  {
    add_action('admin_enqueue_scripts', [$this, 'enqueue']);
  }

  public function enqueue($hook)
  {

    // Only load on KACW pages
    if (strpos($hook, 'kacw') === false) return;

    // CSS
    wp_enqueue_style(
      'kacw-admin-css',
      KACW_URL . 'assets/css/admin.css',
      [],
      KACW_VERSION
    );

    // JS
    wp_enqueue_script(
      'kacw-admin-js',
      KACW_URL . 'assets/js/admin.js',
      ['jquery'],
      KACW_VERSION,
      true
    );

    // AJAX
    wp_localize_script('kacw-admin-js', 'kacw_ajax', [
      'ajax_url' => admin_url('admin-ajax.php'),
      'nonce'    => wp_create_nonce('kacw_nonce')
    ]);

    // Generator JS (reuse)
    wp_enqueue_script(
      'kacw-generator',
      KACW_URL . 'assets/js/generator.js',
      ['jquery'],
      KACW_VERSION,
      true
    );

    wp_localize_script('kacw-generator', 'kacw_ajax', [
      'ajax_url' => admin_url('admin-ajax.php'),
      'nonce'    => wp_create_nonce('kacw_nonce')
    ]);

    // chart
    wp_enqueue_script(
      'chart-js',
      'https://cdn.jsdelivr.net/npm/chart.js',
      [],
      null,
      true
    );

    if (kacw_class_exists('KACW_Analytics')) {

      $analytics = new KACW_Analytics();
      $stats = $analytics->daily_stats();

      $labels = [];
      $data   = [];

      foreach ($stats as $row) {
        $labels[] = $row->day;
        $data[]   = $row->total;
      }

      wp_localize_script('kacw-admin-js', 'kacw_chart', [
        'labels' => array_reverse($labels),
        'data'   => array_reverse($data)
      ]);
    }
  }
}
