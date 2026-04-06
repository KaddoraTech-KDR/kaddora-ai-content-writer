<?php
if (!defined('ABSPATH')) exit;

class KACW_Logger
{
  private static $file;

  /**
   * INIT
   */
  private static function setup()
  {
    if (!self::$file) {
      self::$file = KACW_PATH . 'logs/log.txt';
    }
  }

  /**
   * WRITE LOG
   */
  public static function log($message)
  {
    self::setup();

    $time = date('Y-m-d H:i:s');

    $log = "[{$time}] " . $message . PHP_EOL;

    file_put_contents(self::$file, $log, FILE_APPEND);
  }

  /**
   * GET LOGS
   */
  public static function get_logs()
  {
    self::setup();

    if (!file_exists(self::$file)) return '';

    return file_get_contents(self::$file);
  }

  /**
   * CLEAR LOGS (FIXED)
   */
  public static function clear_logs()
  {
    self::setup();

    if (file_exists(self::$file)) {
      file_put_contents(self::$file, '');
    }
  }
}
