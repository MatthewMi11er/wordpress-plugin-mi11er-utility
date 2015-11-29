<?php
/**
 * PHPUnit Bootstrap file.
 * @package mi11er-utility/tests
 */

	$_tests_dir = dirname( __DIR__ ) . DIRECTORY_SEPARATOR . '.build' . DIRECTORY_SEPARATOR . 'wordpress-tests' . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'phpunit' . DIRECTORY_SEPARATOR . 'includes';

require_once $_tests_dir . DIRECTORY_SEPARATOR . 'functions.php';

/**
 * Load the plugin here since it's not in the normal directory.
 */
function _manually_load_plugin() {
	require dirname( __DIR__ )  . DIRECTORY_SEPARATOR . 'mi11er-utility.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . DIRECTORY_SEPARATOR . 'bootstrap.php';
