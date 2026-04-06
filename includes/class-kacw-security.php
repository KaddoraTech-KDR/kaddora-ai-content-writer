<?php
if (!defined('ABSPATH')) exit;

class KACW_Security
{

  /**
   * VERIFY NONCE
   */
  public static function verify_nonce($nonce)
  {
    return isset($nonce) && wp_verify_nonce($nonce, 'kacw_nonce');
  }

  /**
   * SANITIZE TEXT
   */
  public static function clean_text($text)
  {
    return sanitize_text_field($text);
  }

  /**
   * SANITIZE TEXTAREA
   */
  public static function clean_textarea($text)
  {
    return sanitize_textarea_field($text);
  }

  /**
   * ESCAPE OUTPUT
   */
  public static function esc($text)
  {
    return esc_html($text);
  }
}
