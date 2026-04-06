<?php
if (!defined('ABSPATH')) exit;

class KACW_Loader
{
  private $modules = [];

  public function run()
  {
    $this->init_core();
    $this->init_modules();
    $this->init_integrations();
  }

  /**
   * --------------------------------------------------------
   * CORE SYSTEM INIT
   * --------------------------------------------------------
   */
  private function init_core()
  {

    $core_classes = [
      'KACW_Admin',
      'KACW_Admin_Assets',
      'KACW_Public',
      'KACW_Shortcodes',
      'KACW_Ajax',
      'KACW_REST_API',
      'KACW_Cron',
      'KACW_DB',
    ];

    foreach ($core_classes as $class) {

      if (!kacw_class_exists($class)) continue;

      $instance = new $class();

      $this->safe_init($instance);
    }
  }

  /**
   * --------------------------------------------------------
   * MODULES INIT (AUTO SCALABLE)
   * --------------------------------------------------------
   */
  private function init_modules()
  {

    $module_classes = [
      'KACW_AI_Engine',
      'KACW_Content_Generator',
      'KACW_Outline_Generator',
      'KACW_Title_Generator',
      'KACW_Content_Rewriter',
      'KACW_Tone_Manager',
      'KACW_SEO_Optimizer',
      'KACW_Analytics',
      'KACW_Automation_Manager',
      'KACW_Template_Manager',
      'KACW_History_Manager',
      'KACW_FAQ_Generator',
      'KACW_Multi_Generator',
      'KACW_SEO_Helper',
    ];

    foreach ($module_classes as $class) {

      if (!kacw_class_exists($class)) continue;

      $instance = new $class();

      $this->modules[$class] = $instance;

      $this->safe_init($instance);
    }
  }

  /**
   * --------------------------------------------------------
   * INTEGRATIONS INIT
   * --------------------------------------------------------
   */
  private function init_integrations()
  {

    $integrations = [
      'KACW_OpenAI',
      'KACW_Gemini',
      'KACW_Anthropic',
      'KACW_RankMath',
      'KACW_Yoast',
      'KACW_WooCommerce',
    ];

    foreach ($integrations as $class) {

      if (!kacw_class_exists($class)) continue;

      $instance = new $class();

      $this->safe_init($instance);
    }
  }

  /**
   * --------------------------------------------------------
   * SAFE INIT METHOD
   * --------------------------------------------------------
   */
  private function safe_init($instance)
  {

    if (method_exists($instance, 'init')) {
      try {
        $instance->init();
      } catch (Exception $e) {
        error_log('KACW Init Error: ' . $e->getMessage());
      }
    }
  }

  /**
   * --------------------------------------------------------
   * GET MODULE (Future use)
   * --------------------------------------------------------
   */
  public function get($module)
  {
    return $this->modules[$module] ?? null;
  }
}
