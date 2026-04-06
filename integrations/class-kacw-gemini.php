<?php
if (!defined('ABSPATH')) exit;

class KACW_Gemini
{
  public function generate($prompt)
  {

    $api_key = get_option('kacw_gemini_key');

    // FALLBACK
    if (!$api_key) {
      return $this->demo_output($prompt, 'Gemini');
    }

    $response = wp_remote_post(
      "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$api_key}",
      [
        'headers' => ['Content-Type' => 'application/json'],
        'body' => json_encode([
          'contents' => [
            [
              'parts' => [
                ['text' => $prompt]
              ]
            ]
          ]
        ])
      ]
    );

    if (is_wp_error($response)) {
      return 'Gemini API Error';
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    return $body['candidates'][0]['content']['parts'][0]['text'] ?? 'No response';
  }

  // demo_output
  private function demo_output($prompt, $provider)
  {
    return "⚠ {$provider} API key not found.\n\nDemo Output:\n\nThis is a sample response for:\n{$prompt}";
  }
}
