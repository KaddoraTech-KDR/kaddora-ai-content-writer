<?php if (!defined('ABSPATH')) exit;

$logs = '';

if (kacw_class_exists('KACW_Logger')) {
  $logs = KACW_Logger::get_logs();
}
?>

<div class="wrap kacw-logs">

  <div class="kacw-header">
    <h1>Logs Viewer</h1>
    <p>Monitor system activity and debug issues in real-time.</p>
  </div>

  <div class="kacw-card">
    <div class="kacw-card-inner">

      <div class="kacw-logs-actions">
        <button class="button kacw-clear-btn" id="kacw-clear-logs">
          Clear Logs
        </button>
      </div>

      <div class="kacw-terminal">
        <pre class="kacw-log-output"><?php echo esc_html($logs); ?></pre>
      </div>

    </div>
  </div>

</div>