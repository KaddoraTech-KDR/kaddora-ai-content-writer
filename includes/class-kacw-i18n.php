<?php
if (!defined("ABSPATH")) exit;

class KACW_i18n
{
  public function load_textdomain()
  {
    load_plugin_textdomain(
      'kacw',
      false,
      dirname(plugin_basename(__FILE__)) . '/../languages/'
    );
  }
}
