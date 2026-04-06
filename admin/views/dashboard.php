<?php if (!defined('ABSPATH')) exit; ?>

<?php
$total = 0;
$templates = 0;
$automation = 0;

// Analytics
if (kacw_class_exists('KACW_Analytics')) {
  $analytics = new KACW_Analytics();
  $total = $analytics->total_generations();
}

// Templates count (optional - if table exists)
global $wpdb;

$template_table = $wpdb->prefix . 'kacw_templates';
$automation_table = $wpdb->prefix . 'kacw_automation';

// Safe checks
if ($wpdb->get_var("SHOW TABLES LIKE '$template_table'") == $template_table) {
  $templates = (int) $wpdb->get_var("SELECT COUNT(*) FROM $template_table");
}

if ($wpdb->get_var("SHOW TABLES LIKE '$automation_table'") == $automation_table) {
  $automation = (int) $wpdb->get_var("SELECT COUNT(*) FROM $automation_table");
}
?>

<div class="wrap kacw-dashboard">

  <div class="kacw-header">
    <h1><?php _e('Kaddora AI Dashboard', 'kacw'); ?></h1>
    <p><?php _e('Welcome to your AI content control panel.', 'kacw'); ?></p>
  </div>

  <div class="kacw-cards">

    <!-- Total Generated -->
    <div class="kacw-card">
      <div class="kacw-card-inner">
        <h3>Content Generated</h3>
        <p class="kacw-stat"><?php echo esc_html($total); ?></p>
      </div>
    </div>

    <!-- Templates -->
    <div class="kacw-card">
      <div class="kacw-card-inner">
        <h3>Templates</h3>
        <p class="kacw-stat"><?php echo esc_html($templates); ?></p>
      </div>
    </div>

    <!-- Automation -->
    <div class="kacw-card">
      <div class="kacw-card-inner">
        <h3>Automation Tasks</h3>
        <p class="kacw-stat"><?php echo esc_html($automation); ?></p>
      </div>
    </div>

    <!-- AI Provider -->
    <div class="kacw-card">
      <div class="kacw-card-inner">
        <h3>AI Provider</h3>
        <p class="kacw-provider"><?php echo esc_html(get_option('kacw_ai_provider', 'openai')); ?></p>
      </div>
    </div>

  </div>

  <!-- CHART -->
  <div class="kacw-chart-wrap">
    <canvas id="kacwChart" height="100"></canvas>
  </div>

</div>