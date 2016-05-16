<?php
/**
 * Plugin Name: Mi11er Utility
 * Plugin URI:
 * Description: It does various helpful things.
 * Text Domain: mi11er-utility
 * Author:
 * Author URI:
 * Version: 0.1.5
 * License:
 * License URI:
 *
 * @package Mi11er\Utility
 */

// In case someone integrates this plugin in a theme or calling this directly.
if ( ! defined( 'ABSPATH' ) || class_exists( 'Mi11er\Utility\Mu' ) ) {
	return;
}

// Initialize the composer autoloader. Only used in testing.
if ( is_file( __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php' ) ) {
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
}

// Initialize the plugin Autoloader.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'mi11er-utility' . DIRECTORY_SEPARATOR . 'class-autoloader.php';

/**
 * Return the plugin contoler
 * Causes it to initalize if not already
 *
 * @return Mi11er\Utility\Mu
 */
function mu() {
	return Mi11er\Utility\Mu::instance();
}

// This seems like a good time to kick things off.
$GLOBALS['mu'] = mu();
