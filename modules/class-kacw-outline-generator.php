<?php
if (!defined('ABSPATH')) exit;

class KACW_Outline_Generator
{

  public function generate($topic)
  {

    if (!kacw_class_exists('KACW_AI_Engine')) {
      return 'AI Engine missing';
    }

    $prompt = "Create a detailed blog outline for: {$topic}";

    $engine = new KACW_AI_Engine();

    return $engine->generate($prompt);
  }
}
