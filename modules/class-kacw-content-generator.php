<?php
if (!defined('ABSPATH')) exit;

class KACW_Content_Generator
{

  public function init() {}

  /**
   * MAIN GENERATE METHOD
   */
  public function generate($topic, $tone = 'formal', $length = 'medium')
  {

    if (!kacw_class_exists('KACW_AI_Engine')) {
      return 'AI Engine missing';
    }

    $base_prompt = "Write a {$length} blog article about: {$topic}";

    // 🔥 Tone Manager
    if (kacw_class_exists('KACW_Tone_Manager')) {
      $tone_manager = new KACW_Tone_Manager();
      $prompt = $tone_manager->format($base_prompt, $tone);
    } else {
      $prompt = $base_prompt;
    }

    $engine = new KACW_AI_Engine();

    return $engine->generate($prompt);
  }

  /**
   * BUILD PROMPT
   */
  private function build_prompt($topic, $tone, $length)
  {

    return "Write a {$length} blog article in a {$tone} tone about: {$topic}";
  }
}
