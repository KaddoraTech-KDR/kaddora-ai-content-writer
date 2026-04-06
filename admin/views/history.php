<?php if (!defined('ABSPATH')) exit;

global $wpdb;

$table = $wpdb->prefix . 'kacw_history';

$rows = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC LIMIT 20");
?>

<div class="wrap kacw-history">

  <div class="kacw-header">
    <h1>Content History</h1>
    <p>View and manage your previously generated AI content.</p>
  </div>

  <div class="kacw-card">
    <div class="kacw-card-inner">
      <div class="kacw-table-wrap">
        <table class="widefat striped kacw-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Prompt</th>
              <th>Content</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            <?php if ($rows): ?>
              <?php foreach ($rows as $row): ?>
                <tr id="kacw-row-<?php echo $row->id; ?>">
                  <td><?php echo $row->id; ?></td>
                  <td class="kacw-prompt"><?php echo esc_html($row->prompt); ?></td>
                  <td class="kacw-content"><?php echo esc_html(KACW_Helper::limit_text($row->content, 20)); ?></td>
                  <td><?php echo $row->created_at; ?></td>

                  <td>
                    <button
                      class="button kacw-delete-history"
                      data-id="<?php echo $row->id; ?>">
                      Delete
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="kacw-empty">No history found</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>