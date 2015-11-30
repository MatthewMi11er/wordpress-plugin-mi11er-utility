<?php
/**
 * Plugin Name: Mi11er Utility
 * Plugin URI:
 * Description: It does various helpful things.
 * Author:
 * Author URI:
 * Version:
 * License:
 * License URI:
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

// In case someone integrates this plugin in a theme or calling this directly.
if ( class_exists( __NAMESPACE__.'\Mu' ) || ! defined( 'ABSPATH' ) ) {
	return;
}

// Initialize the composer autoloader.
is_file( __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php' ) && require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Initialize the plugin Autoloader.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'mi11er-utility' . DIRECTORY_SEPARATOR . 'class-autoloader.php';

/**
 * Initalize the pluging and return a reference.
 *
 * Am I a Singlton?
 * Am I a registry?
 * Am I the best practice?
 * I don't know. I am what I am.
 *
 * @return Mi11er\Utility\Mu
 */
function mu() {
	static $mi11er_utility = null;

	if ( is_null( $mi11er_utility ) ) {
		$mi11er_utility = new Mu();
		$mi11er_utility->init();
	}
	return $mi11er_utility;
}

// This seems like a good time to kick things off.
mu();

