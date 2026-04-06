<?php

/**
 * Plugin Name: Kaddora AI Content Writer
 * Plugin URI: https://kaddora.com
 * Description: AI-powered content generator with SEO, automation, templates, and integrations.
 * Version: 1.0.0
 * Author: Kaddora
 * Author URI: https://kaddora.com
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kacw
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) exit;

/**
 * --------------------------------------------------------
 * DEFINE CONSTANTS
 * --------------------------------------------------------
 */
define('KACW_VERSION', '1.0.0');
define('KACW_PATH', plugin_dir_path(__FILE__));
define('KACW_URL', plugin_dir_url(__FILE__));
define('KACW_BASENAME', plugin_basename(__FILE__));

/**
 * --------------------------------------------------------
 * SAFE REQUIRE FUNCTION (Future-proof)
 * --------------------------------------------------------
 */
if (!function_exists('kacw_require')) {
  function kacw_require($file)
  {
    $path = KACW_PATH . $file;

    if (file_exists($path)) {
      require_once $path;
    } else {
      error_log("KACW Missing File: " . $path);
    }
  }
}

/**
 * --------------------------------------------------------
 * SAFE CLASS CHECK
 * --------------------------------------------------------
 */
if (!function_exists('kacw_class_exists')) {
  function kacw_class_exists($class)
  {
    if (!class_exists($class)) {
      error_log("KACW Missing Class: " . $class);
      return false;
    }
    return true;
  }
}

/**
 * --------------------------------------------------------
 * SAFE METHOD CALL
 * --------------------------------------------------------
 */
if (!function_exists('kacw_call')) {
  function kacw_call($object, $method)
  {
    if (is_object($object) && method_exists($object, $method)) {
      return $object->$method();
    }

    error_log("KACW Missing Method: " . get_class($object) . "::" . $method);
    return null;
  }
}

/**
 * --------------------------------------------------------
 * AUTO LOAD CORE FILES
 * (Future scalable - just add file name)
 * --------------------------------------------------------
 */
function kacw_load_core_files()
{
  $files = [
    // Includes
    'includes/class-kacw-i18n.php',
    'includes/class-kacw-loader.php',
    'includes/class-kacw-activator.php',
    'includes/class-kacw-deactivator.php',
    'includes/class-kacw-helper.php',
    'includes/class-kacw-security.php',
    'includes/class-kacw-logger.php',
    'includes/class-kacw-ajax.php',
    'includes/class-kacw-rest-api.php',
    'includes/class-kacw-cron.php',

    // Admin
    'admin/class-kacw-admin.php',
    'admin/class-kacw-admin-menu.php',
    'admin/class-kacw-admin-assets.php',

    // Public
    'public/class-kacw-public.php',
    'public/class-kacw-shortcodes.php',

    // Modules
    'modules/class-kacw-ai-engine.php',
    'modules/class-kacw-content-generator.php',
    'modules/class-kacw-outline-generator.php',
    'modules/class-kacw-title-generator.php',
    'modules/class-kacw-content-rewriter.php',
    'modules/class-kacw-tone-manager.php',
    'modules/class-kacw-keyword-assistant.php',
    'modules/class-kacw-seo-optimizer.php',
    'modules/class-kacw-analytics.php',
    'modules/class-kacw-automation-manager.php',
    'modules/class-kacw-template-manager.php',
    'modules/class-kacw-history-manager.php',
    'modules/class-kacw-faq-generator.php',
    'modules/class-kacw-multi-generator.php',
    'modules/class-kacw-seo-helper.php',

    // Database
    'database/class-kacw-db.php',
    'database/class-kacw-history-table.php',
    'database/class-kacw-logs-table.php',
    'database/class-kacw-templates-table.php',
    'database/class-kacw-automation-table.php',

    // Integrations
    'integrations/class-kacw-openai.php',
    'integrations/class-kacw-gemini.php',
    'integrations/class-kacw-anthropic.php',
    'integrations/class-kacw-rankmath.php',
    'integrations/class-kacw-yoast.php',
    'integrations/class-kacw-woocommerce.php',
  ];

  foreach ($files as $file) {
    kacw_require($file);
  }
}

/**
 * --------------------------------------------------------
 * ACTIVATE / DEACTIVATE HOOKS
 * --------------------------------------------------------
 */
register_activation_hook(__FILE__, function () {
  kacw_require('includes/class-kacw-activator.php');

  if (kacw_class_exists('KACW_Activator')) {
    $activator = new KACW_Activator();
    kacw_call($activator, 'run');
  }
});

register_deactivation_hook(__FILE__, function () {
  kacw_require('includes/class-kacw-deactivator.php');

  if (kacw_class_exists('KACW_Deactivator')) {
    $deactivator = new KACW_Deactivator();
    kacw_call($deactivator, 'run');
  }
});

/**
 * --------------------------------------------------------
 * INIT PLUGIN
 * --------------------------------------------------------
 */
function kacw_run()
{
  static $ran = false;

  if ($ran) return; // 🔥 MOST IMPORTANT LINE
  $ran = true;

  kacw_load_core_files();

  if (kacw_class_exists('KACW_i18n')) {
    $i18n = new KACW_i18n();
    kacw_call($i18n, 'load_textdomain');
  }

  if (!kacw_class_exists('KACW_Loader')) return;

  $loader = new KACW_Loader();
  kacw_call($loader, 'run');
}

add_action('plugins_loaded', 'kacw_run');
