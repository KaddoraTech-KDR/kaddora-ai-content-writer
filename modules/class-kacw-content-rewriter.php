<?php
if (!defined('ABSPATH')) exit;

class KACW_Content_Rewriter
{

  public function rewrite($content, $tone = 'professional')
  {

    $prompt = "Rewrite this content in a {$tone} tone:\n\n{$content}";

    $engine = new KACW_AI_Engine();

    return $engine->generate($prompt);
  }
}
