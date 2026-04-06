<?php if (!defined('ABSPATH')) exit;

global $wpdb;
$table = $wpdb->prefix . 'kacw_templates';
$rows = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");
?>

<div class="wrap">

  <h1>Templates</h1>

  <!-- ADD TEMPLATE -->
  <h2>Add New Template</h2>

  <input type="text" id="kacw-temp-title" placeholder="Template Title" style="width:300px;">
  <br><br>

  <textarea id="kacw-temp-prompt" placeholder="Template Prompt..." style="width:100%; height:100px;"></textarea>

  <br><br>

  <button class="button button-primary" id="kacw-save-template">Save Template</button>

  <hr>

  <!-- LIST -->
  <h2>Saved Templates</h2>

  <table class="widefat striped">
    <thead>
      <tr>
        <th>Title</th>
        <th>Prompt</th>
        <th>Use</th>
      </tr>
    </thead>

    <tbody>
      <?php if ($rows): ?>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?php echo esc_html($row->title); ?></td>
            <td><?php echo esc_html(wp_trim_words($row->prompt, 15)); ?></td>
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
          <td colspan="3">No templates found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

</div>