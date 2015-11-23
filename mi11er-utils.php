<?php
/**
 * Plugin Name: Blogger Redirect
 * Plugin URI:
 * Description: Redirects old blogger urls
 * Author:
 * Author URI:
 * Version: 0.9.4
 * License:
 * License URI:
 * @package mi11er_utils
 */

namespace Mi11er\Utils;

// In case someone integrates this plugin in a theme or calling this directly
if (class_exists( 'Mi11er\Utils\Init' ) || !defined( 'ABSPATH' ) ) {
	return;
}

// Init the plugin
require_once __DIR__ . DIRECTORY_SEPERATOR . 'includes' . DIRECTORY_SEPERATOR . 'mi11er-utils' . DIRECTORY_SEPERATOR . 'class-autoloader.php';
$mi11er_utils = new Init();

