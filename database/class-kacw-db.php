<?php
if (!defined('ABSPATH')) exit;

class KACW_DB
{
  public function init()
  {
    $this->create_tables();
  }

  public function create_tables()
  {
    if (kacw_class_exists('KACW_History_Table')) {
      $history = new KACW_History_Table();
      kacw_call($history, 'create');
    }

    if (kacw_class_exists('KACW_Templates_Table')) {
      kacw_call(new KACW_Templates_Table(), 'create');
    }

    if (kacw_class_exists('KACW_Automation_Table')) {
      kacw_call(new KACW_Automation_Table(), 'create');
    }
  }
}
