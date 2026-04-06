<?php
if (!defined('ABSPATH')) exit;

class KACW_Multi_Generator
{

  public function init() {}

  public function generate_all($topic)
  {

    $result = [];

    // Title
    if (kacw_class_exists('KACW_Title_Generator')) {
      $title = new KACW_Title_Generator();
      $result['titles'] = $title->generate($topic);
    }

    // Outline
    if (kacw_class_exists('KACW_Outline_Generator')) {
      $outline = new KACW_Outline_Generator();
      $result['outline'] = $outline->generate($topic);
    }

    // Content
    if (kacw_class_exists('KACW_Content_Generator')) {
      $content = new KACW_Content_Generator();
      $result['content'] = $content->generate($topic);
    }

    return $result;
  }
}
