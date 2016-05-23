<?php
/**
 * PHPUnit Bootstrap file.
 *
 * @package Mi11er\Utility\Tests
 */

namespace Mi11er\Utility\Tests;

echo 'Welcome to the Mi11er-Uitilty WordPress Plugin Test Suite' . PHP_EOL . PHP_EOL;

/**
 * Relative Path to the pugin file.
 */
const PLUGIN_IDENTIFIER = 'mi11er-utility/mi11er-utility.php';

$GLOBALS['wp_tests_options'] = [
    'active_plugins' => [ PLUGIN_IDENTIFIER ],
];

/**
 * Bootstrap Wordpress
 */
if (defined('PHPUNIT_MI11ER_UTILITY_TESTSUITE') && is_string(getenv('WP_TEST_DIR'))) {
    require implode(DIRECTORY_SEPARATOR, [ getenv('WP_TEST_DIR'), 'tests', 'phpunit', 'includes', 'bootstrap.php' ]);
}
