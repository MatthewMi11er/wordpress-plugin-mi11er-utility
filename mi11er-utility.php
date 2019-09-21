<?php
/**
 * Plugin Name: Mi11er Utility
 * Plugin URI:
 * Description: It does various helpful things.
 * Text Domain: mi11er-utility
 * Author:
 * Author URI:
 * Version: 0.2.0
 * License:
 * License URI:
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

// Bail if this file is not called by Wordpress.
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * If an autoloader isn't already setup, we need to do it.
 */
if ( ! class_exists( 'Mi11er\Utility\Mu' ) ) {
	if ( is_file( __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php' ) ) {
		require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
	}
	require_once __DIR__ . 'include/mi11er-utility/class-autoload.php';
}

/**
 * Return the plugin contoler
 * Causes it to initalize if not already
 *
 * @return Mi11er\Utility\Mu
 */
function mu() {
	return Mu::instance();
}

// This seems like a good time to kick things off.
$GLOBALS['mi11er-utility'] = mu();
