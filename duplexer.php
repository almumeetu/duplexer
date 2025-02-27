<?php
/**
 * Plugin Name: DupleXer - WordPress Post Duplicator
 * Plugin URI:  https://wordpress.org/plugins/duplexer/
 * Description: A simple WordPress plugin to duplicate posts, pages, and WooCommerce products.
 * Version:     1.0.0
 * Author:      Al Mumeetu Saikat
 * Author URI:  https://almumeetu.github.io/My-Portfolio/
 * License:     GPL2
 * Text Domain: duplexer
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin path
define('DUPLEXER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('DUPLEXER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once DUPLEXER_PLUGIN_PATH . 'includes/class-duplicator.php';
require_once DUPLEXER_PLUGIN_PATH . 'includes/class-admin-hooks.php';

// Initialize the plugin
function duplexer_init() {
    new DupleXer_Admin_Hooks();
}
add_action('plugins_loaded', 'duplexer_init');
