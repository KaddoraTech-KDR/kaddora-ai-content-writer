<?php
if (!defined('WP_UNINSTALL_PLUGIN')) exit;

// Remove options
delete_option('kacw_ai_provider');
delete_option('kacw_openai_key');
delete_option('kacw_gemini_key');
delete_option('kacw_anthropic_key');

// Optional: remove tables
global $wpdb;

$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}kacw_history");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}kacw_templates");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}kacw_automation");
