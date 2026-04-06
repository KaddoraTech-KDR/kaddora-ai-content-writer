<?php if (!defined('ABSPATH')) exit;

global $wpdb;
$table = $wpdb->prefix . 'kacw_automation';
$rows = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");
?>

<div class="wrap kacw-automation">

  <div class="kacw-header">
    <h1>Automation</h1>
    <p>Create and manage automated AI content tasks.</p>
  </div>

  <!-- ADD AUTOMATION -->
  <div class="kacw-card">
    <div class="kacw-card-inner">

      <h3>Add Automation</h3>

      <div class="kacw-auto-form">

        <div class="kacw-field">
          <label>Title</label>
          <input type="text" id="kacw-auto-title" placeholder="Enter title">
        </div>

        <div class="kacw-field">
          <label>Prompt</label>
          <textarea id="kacw-auto-prompt" placeholder="Enter prompt..."></textarea>
        </div>

        <div class="kacw-actions">
          <button class="button button-primary" id="kacw-save-automation">
            Save Automation
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- TASK LIST -->
  <div class="kacw-card">
    <div class="kacw-card-inner">

      <h3>Automation Tasks</h3>

      <div class="kacw-table-wrap">

        <table class="widefat striped kacw-table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Prompt</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
            <?php if ($rows): ?>
              <?php foreach ($rows as $row): ?>
                <tr>
                  <td class="kacw-title"><?php echo esc_html($row->title); ?></td>
                  <td class="kacw-content"><?php echo esc_html(wp_trim_words($row->prompt, 15)); ?></td>
                  <td>
                    <span class="kacw-status <?php echo esc_attr($row->status); ?>">
                      <?php echo esc_html($row->status); ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="3" class="kacw-empty">No tasks found</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>