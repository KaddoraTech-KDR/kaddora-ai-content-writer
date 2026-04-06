<?php
if (!defined('ABSPATH')) exit;

class KACW_Admin_Menu
{
  public function init()
  {
    add_action('admin_menu', [$this, 'register_menu']);
    add_action('admin_init', [$this, 'register_settings']);
  }

  /**
   * ----------------------------------------
   * REGISTER SETTINGS (ONLY THIS NEEDED)
   * ----------------------------------------
   */
  public function register_settings()
  {
    register_setting(
      'kacw_settings_group',
      'kacw_ai_provider',
      [
        'sanitize_callback' => 'sanitize_text_field'
      ]
    );

    register_setting(
      'kacw_settings_group',
      'kacw_openai_key',
      [
        'sanitize_callback' => 'sanitize_text_field'
      ]
    );

    register_setting(
      'kacw_settings_group',
      'kacw_gemini_key',
      [
        'sanitize_callback' => 'sanitize_text_field'
      ]
    );

    register_setting(
      'kacw_settings_group',
      'kacw_anthropic_key',
      [
        'sanitize_callback' => 'sanitize_text_field'
      ]
    );
  }

  // register_menu
  public function register_menu()
  {
    // Main Menu (Dashboard auto create hota hai)
    add_menu_page(
      __('Kaddora AI Writer', 'kacw'),
      __('Kaddora AI', 'kacw'),
      'manage_options',
      'kacw-dashboard',
      [$this, 'dashboard_page'],
      'dashicons-edit',
      3
    );

    // Submenus 
    $this->add_submenu('Generator', 'kacw-generator', 'generator_page');
    $this->add_submenu('Templates', 'kacw-templates', 'templates_page');
    $this->add_submenu('Automation', 'kacw-automation', 'automation_page');
    $this->add_submenu('History', 'kacw-history', 'history_page');
    $this->add_submenu('SEO Assistant', 'kacw-seo', 'seo_page');
    $this->add_submenu('Settings', 'kacw-settings', 'settings_page');
    $this->add_submenu('Logs', 'kacw-logs', 'logs_page');
  }

  /**
   * ----------------------------------------
   * REUSABLE SUBMENU BUILDER
   * ----------------------------------------
   */
  private function add_submenu($title, $slug, $method)
  {
    add_submenu_page(
      'kacw-dashboard',
      __($title, 'kacw'),
      __($title, 'kacw'),
      'manage_options',
      $slug,
      [$this, $method]
    );
  }

  /**
   * ----------------------------------------
   * PAGE RENDER METHODS
   * ----------------------------------------
   */

  // dashboard_page
  public function dashboard_page()
  {
    $this->render('dashboard');
  }

  // generator_page
  public function generator_page()
  {
    $this->render('generator');
  }

  // templates_page
  public function templates_page()
  {
    $this->render('templates');
  }

  // automation_page
  public function automation_page()
  {
    $this->render('automation');
  }

  // history_page
  public function history_page()
  {
    $this->render('history');
  }

  // seo_page
  public function seo_page()
  {
    $this->render('seo-assistant');
  }

  // settings_page
  public function settings_page()
  {
    $this->render('settings');
  }

  // logs_page
  public function logs_page()
  {
    $this->render('logs');
  }

  /**
   * ----------------------------------------
   * VIEW LOADER (SAFE + CLEAN)
   * ----------------------------------------
   */
  private function render($view)
  {
    $file = KACW_PATH . "admin/views/{$view}.php";

    if (file_exists($file)) {
      include $file;
    } else {
      echo '<div class="wrap"><h1>' . esc_html__('View not found:', 'kacw') . ' ' . esc_html($view) . '</h1></div>';
    }
  }
}
