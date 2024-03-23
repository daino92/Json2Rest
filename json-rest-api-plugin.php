<?php
/*
Plugin Name: Json To Rest API Plugin
Description: A simple plugin to turn JSONs into REST service.
Version: 1.0
Author: Dionysis Kalepanagos
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants.
define('MY_JSON_REST_API_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MY_JSON_REST_API_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include additional PHP files.
require_once MY_JSON_REST_API_PLUGIN_DIR . 'includes/settings.php';
require_once MY_JSON_REST_API_PLUGIN_DIR . 'includes/rest-endpoint.php';
require_once MY_JSON_REST_API_PLUGIN_DIR . 'includes/helpers.php';

function enqueue_css_and_js_files() {
    $ajaxUrl = admin_url('admin-ajax.php');
    wp_register_script('admin', MY_JSON_REST_API_PLUGIN_URL . 'assets/js/admin.js');
    wp_localize_script('admin', 'ajax', array('ajaxUrl' => $ajaxUrl));
    wp_enqueue_script('admin');
    wp_enqueue_style('styles', MY_JSON_REST_API_PLUGIN_URL . 'assets/css/style.css', array(), '1.0', 'all');
}
add_action('admin_enqueue_scripts', 'enqueue_css_and_js_files');

function my_plugin_activate() {
    // Perform activation tasks if needed
}
register_activation_hook(__FILE__, 'my_plugin_activate');

function my_plugin_deactivate() {
    // Perform deactivation tasks if needed
}
register_deactivation_hook(__FILE__, 'my_plugin_deactivate');