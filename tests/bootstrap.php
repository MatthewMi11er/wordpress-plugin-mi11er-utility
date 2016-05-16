<?php
/**
 * PHPUnit Bootstrap file.
 *
 * @package Mi11er\Utility\Tests
 */

namespace Mi11er\Utility\Tests;

defined( 'PHPUNIT_COMPOSER_INSTALL' ) || exit;

/**
 * Relative Path to the pugin file.
 */
const PLUGIN_IDENTIFIER = 'mi11er-utility/mi11er-utility.php';

/**
 * To pre-activate this or other plugins use:
 *   $GLOBALS[ 'wp_tests_options' ] = array(
 *     'active_plugins' => array(
 *       UNIT_TEST_PLUGIN_IDENTIFIER
 *     ),
 *   );
 * Careful this uses a pre_option filter.
 */

/**
 * Activates the plugin
 */
function activate_plugin() {
	if ( ! is_plugin_active( PLUGIN_IDENTIFIER ) ) {
		\activate_plugin( PLUGIN_IDENTIFIER, '', false, false );
	}
}

/**
 * Deactivates the plugin
 */
function deactivate_plugin() {
	if ( is_plugin_active( PLUGIN_IDENTIFIER ) ) {
		deactivate_plugins( PLUGIN_IDENTIFIER );
	}
}

/**
 * Bootstrap Wordpress
 */
require_once dirname( __DIR__ ) . DIRECTORY_SEPARATOR . '.build' . DIRECTORY_SEPARATOR . 'wordpress-tests' . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'phpunit' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'bootstrap.php';

activate_plugin();
