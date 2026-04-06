<?php
if (!defined('ABSPATH')) exit;

class KACW_Shortcodes
{

  public function init()
  {
    add_shortcode('kacw_generator', [$this, 'render_generator']);
  }

  /**
   * 🔥 RENDER GENERATOR UI
   */
  public function render_generator()
  {

    ob_start();

    $file = KACW_PATH . 'public/templates/content-form.php';

    if (file_exists($file)) {
      include $file;
    } else {
      echo "<p>Template not found</p>";
    }

    return ob_get_clean();
  }
}
