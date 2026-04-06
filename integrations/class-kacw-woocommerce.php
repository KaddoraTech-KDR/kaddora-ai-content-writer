<?php
if (!defined('ABSPATH')) exit;

class KACW_WooCommerce
{

  public function is_active()
  {
    return class_exists('WooCommerce');
  }

  /**
   * Generate product description
   */
  public function generate_product_content($product_name)
  {

    if (!kacw_class_exists('KACW_AI_Engine')) return '';

    $engine = new KACW_AI_Engine();

    return $engine->generate("Write product description for: {$product_name}");
  }
}
