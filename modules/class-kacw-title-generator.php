<?php
if (!defined('ABSPATH')) exit;

class KACW_Title_Generator
{

  public function generate($topic)
  {

    $prompt = "Generate 5 catchy SEO titles for: {$topic}";

    $engine = new KACW_AI_Engine();

    return $engine->generate($prompt);
  }
}
