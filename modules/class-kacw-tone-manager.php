<?php
if (!defined('ABSPATH')) exit;

class KACW_Tone_Manager
{

  public function format($text, $tone)
  {

    switch ($tone) {

      case 'casual':
        return "Write in a casual and friendly tone:\n\n" . $text;

      case 'seo':
        return "Write SEO optimized content with keywords:\n\n" . $text;

      case 'persuasive':
        return "Write persuasive and engaging content:\n\n" . $text;

      default:
        return "Write in a professional tone:\n\n" . $text;
    }
  }
}
