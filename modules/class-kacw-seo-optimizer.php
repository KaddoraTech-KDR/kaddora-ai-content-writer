<?php
if (!defined('ABSPATH')) exit;

class KACW_SEO_Optimizer
{

  public function init() {}

  /**
   * BASIC SEO ANALYSIS
   */
  public function analyze($content, $keyword = '')
  {

    $score = 0;
    $suggestions = [];

    // Word count
    $word_count = str_word_count(strip_tags($content));

    if ($word_count > 300) {
      $score += 20;
    } else {
      $suggestions[] = 'Content should be at least 300 words.';
    }

    // Keyword check
    if ($keyword) {

      $count = substr_count(strtolower($content), strtolower($keyword));

      if ($count > 2) {
        $score += 30;
      } else {
        $suggestions[] = 'Add focus keyword more times.';
      }
    }

    // Paragraph check
    if (substr_count($content, "\n") > 2) {
      $score += 20;
    } else {
      $suggestions[] = 'Use more paragraphs.';
    }

    // Readability (basic)
    if ($word_count > 600) {
      $score += 30;
    }

    return [
      'score' => $score,
      'suggestions' => $suggestions
    ];
  }

  /**
   * KEYWORD SUGGESTION (AI)
   */
  public function suggest_keywords($topic)
  {

    if (!kacw_class_exists('KACW_AI_Engine')) return [];

    $engine = new KACW_AI_Engine();

    $prompt = "Give 5 SEO keywords for: " . $topic;

    $result = $engine->generate($prompt);

    return explode("\n", $result);
  }
}
