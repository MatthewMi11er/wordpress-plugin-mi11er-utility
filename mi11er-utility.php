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
if ( class_exists( 'Mi11er\Utility\Init' ) || ! defined( 'ABSPATH' ) ) {
	return;
}

// Initialize the plugin.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'mi11er-utility' . DIRECTORY_SEPARATOR . 'class-autoloader.php';
$mi11er_utility = new Init();

