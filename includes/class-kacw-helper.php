<?php
if (!defined("ABSPATH")) exit;

class KACW_Helper
{
  /**
   * Generate API Key
   */
  public static function generate_api_key()
  {
    return wp_generate_password(32, false);
  }

  public static function limit_text($text, $limit = 100)
  {
    return wp_trim_words($text, $limit);
  }
}
