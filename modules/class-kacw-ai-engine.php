<?php
if (!defined('ABSPATH')) exit;

class KACW_AI_Engine
{
  public function init() {}

  public function generate($prompt)
  {
    $provider = get_option('kacw_ai_provider', 'openai');

    switch ($provider) {

      case 'gemini':
        if (kacw_class_exists('KACW_Gemini')) {
          return (new KACW_Gemini())->generate($prompt);
        }
        break;

      case 'anthropic':
        if (kacw_class_exists('KACW_Anthropic')) {
          return (new KACW_Anthropic())->generate($prompt);
        }
        break;

      default:
        if (kacw_class_exists('KACW_OpenAI')) {
          return (new KACW_OpenAI())->generate($prompt);
        }
    }

    return "AI provider not available";
  }

  // openai
  private function openai($prompt)
  {

    if (!kacw_class_exists('KACW_OpenAI')) {
      return 'OpenAI class missing';
    }

    $api = new KACW_OpenAI();

    return $api->generate($prompt);
  }
}
