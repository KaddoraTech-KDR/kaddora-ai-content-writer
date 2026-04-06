<?php if (!defined('ABSPATH')) exit;

global $wpdb;
$table = $wpdb->prefix . 'kacw_templates';
$rows = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");
?>

<?php if (!defined('ABSPATH')) exit;

global $wpdb;
$table = $wpdb->prefix . 'kacw_templates';
$rows = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");
?>

<div class="kacw-dashboard">

  <!-- HEADER -->
  <div class="kacw-header">
    <h1>Templates</h1>
    <p>Create and manage reusable AI templates</p>
  </div>

  <!-- ADD TEMPLATE CARD -->
  <div class="kacw-card">
    <div class="kacw-card-inner">

      <h3>Add New Template</h3>

      <div class="kacw-field">
        <label>Template Title</label>
        <input type="text" id="kacw-temp-title" placeholder="Enter template title">
      </div>

      <div class="kacw-field" style="margin-top:15px;">
        <label>Template Prompt</label>
        <textarea id="kacw-temp-prompt" placeholder="Write your template prompt..."></textarea>
      </div>

      <div class="kacw-actions">
        <button class="button button-primary" id="kacw-save-template">
          Save Template
        </button>
      </div>

    </div>
  </div>

  <!-- LIST CARD -->
  <div class="kacw-card">
    <div class="kacw-card-inner">

      <h3>Saved Templates</h3>

      <div class="kacw-table-wrap">

        <table class="kacw-table striped">
          <thead>
            <tr>
              <th>Title</th>
              <th>Prompt</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            <?php if ($rows): ?>
              <?php foreach ($rows as $row): ?>
                <tr>
                  <td class="kacw-title">
                    <?php echo esc_html($row->title); ?>
                  </td>

                  <td class="kacw-content">
                    <?php echo esc_html(wp_trim_words($row->prompt, 15)); ?>
                  </td>

                  <td>
                    <button class="button kacw-use-template"
                      data-prompt="<?php echo esc_attr($row->prompt); ?>">
                      Use
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="3" class="kacw-empty">
                  No templates found
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>

      </div>

    </div>
  </div>

</div>