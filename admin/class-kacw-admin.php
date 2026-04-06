<?php
if (!defined('ABSPATH')) exit;

class KACW_Admin
{
  public function init()
  {
    // Load menu
    if (kacw_class_exists('KACW_Admin_Menu')) {
      $menu = new KACW_Admin_Menu();
      $menu->init();
    }

    // Load assets
    if (kacw_class_exists('KACW_Admin_Assets')) {
      $assets = new KACW_Admin_Assets();
      $assets->init();
    }
  }
}
