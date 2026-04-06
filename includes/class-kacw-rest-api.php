<?php
if (!defined('ABSPATH')) exit;

class KACW_REST_API
{

  public function init()
  {
    add_action('rest_api_init', [$this, 'register_routes']);
  }

  /**
   * REGISTER ROUTES
   */
  public function register_routes()
  {

    register_rest_route('kacw/v1', '/generate', [
      'methods'  => ['GET', 'POST'],
      'callback' => [$this, 'generate'],
      'permission_callback' => [$this, 'permission']
    ]);
  }

  /**
   * PERMISSION CHECK
   */
  public function permission($request)
  {

    // Simple API Key check (improve later)
    $api_key = $request->get_header('x-api-key');

    $saved_key = get_option('kacw_api_key');

    if (!$saved_key) return true; // allow if not set

    return $api_key === $saved_key;
  }

  /**
   * GENERATE VIA API
   */
  public function generate($request)
  {

    // $params = $request->get_json_params();

    // $prompt = isset($params['prompt']) ? sanitize_text_field($params['prompt']) : '';

    $params = $request->get_json_params();

    if (empty($params)) {
      $params = $request->get_body_params();
    }

    if (empty($params)) {
      $params = $request->get_query_params(); // 🔥 ADD THIS
    }

    $prompt = isset($params['prompt']) ? sanitize_text_field($params['prompt']) : '';


    if (!$prompt) {
      return new WP_REST_Response([
        'success' => false,
        'message' => 'Empty prompt'
      ], 400);
    }

    // Use module
    if (kacw_class_exists('KACW_Content_Generator')) {

      $module = new KACW_Content_Generator();
      $result = $module->generate($prompt);
    } else {

      $engine = new KACW_AI_Engine();
      $result = $engine->generate($prompt);
    }

    return new WP_REST_Response([
      'success' => true,
      'data' => $result
    ], 200);
  }
}
