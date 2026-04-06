<?php
if (!defined('ABSPATH')) exit;

class KACW_Anthropic
{

  public function generate($prompt)
  {

    $api_key = get_option('kacw_anthropic_key');

    if (!$api_key) {
      return $this->demo_output($prompt, 'Anthropic');
    }

    $response = wp_remote_post(
      "https://api.anthropic.com/v1/messages",
      [
        'headers' => [
          'x-api-key' => $api_key,
          'anthropic-version' => '2023-06-01',
          'content-type' => 'application/json'
        ],
        'body' => json_encode([
          "model" => "claude-3-haiku-20240307",
          "max_tokens" => 1000,
          "messages" => [
            ["role" => "user", "content" => $prompt]
          ]
        ])
      ]
    );

    if (is_wp_error($response)) {
      return 'Anthropic API Error';
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    return $body['content'][0]['text'] ?? 'No response';
  }

  // hardcode
  private function demo_output($prompt, $provider)
  {
    return "⚠ {$provider} API key missing.\n\nDemo Output:\n\nGenerated sample for:\n{$prompt}";
  }
}
  