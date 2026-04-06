<?php
if (!defined('ABSPATH')) exit;

class KACW_OpenAI
{

  public function generate($prompt)
  {

    $api_key = get_option('kacw_openai_key');

    // Fallback (if no API key)
    if (!$api_key) {
      return $this->demo_response($prompt);
    }

    $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
      'headers' => [
        'Authorization' => 'Bearer ' . $api_key,
        'Content-Type'  => 'application/json'
      ],
      'body' => json_encode([
        'model' => 'gpt-4o-mini',
        'messages' => [
          [
            'role' => 'user',
            'content' => $prompt
          ]
        ],
        'temperature' => 0.7
      ]),
      'timeout' => 30
    ]);

    // WP Error
    if (is_wp_error($response)) {

      if (kacw_class_exists('KACW_Logger')) {
        KACW_Logger::log('API Error: ' . $response->get_error_message());
      }

      return '⚠️ API connection failed. Please check your API key or internet.';
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    // Logger (as you asked)
    if (kacw_class_exists('KACW_Logger')) {
      KACW_Logger::log('OpenAI Response: ' . print_r($body, true));
    }

    // Invalid response
    if (!isset($body['choices'][0]['message']['content'])) {

      return '⚠️ AI could not generate content. Please try again.';
    }

    return $body['choices'][0]['message']['content'];
  }

  /**
   * DEMO RESPONSE (No API Key)
   */
  private function demo_response($prompt)
  {
    return "⚠️ API Key not found.\n\n"
      . "Here is a demo output for your prompt:\n\n"
      . "Title: Sample AI Generated Content\n\n"
      . "Content:\n"
      . "This is a sample article generated for the topic:\n\n"
      . "\"{$prompt}\"\n\n"
      . "To get real AI content, please add your OpenAI API key in Settings.";
  }
}
