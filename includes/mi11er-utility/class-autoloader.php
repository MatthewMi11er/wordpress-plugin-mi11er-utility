<?php
/**
 * Autoloader
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

/**
 * Autoloader for Mi11er\Utility Classes
 */
class Autoloader
{
	/**
	 * Loads the file for the requested class
	 *
	 * @param string $classname The class to load.
	 */
	public static function autoloader( $classname ) {
		// We only do stuff for our namespace.
		if ( 0 !== strpos( $classname, __NAMESPACE__ ) ) {
			return;
		}
		// Remove the prefix.
		$classname = substr( $classname, strlen( __NAMESPACE__ ) );

		// Replace backslashes and underscores with DIRECTORY_SEPARATOR and dash. Make lower case.
		$classname = strtolower( str_replace( '_', '-', str_replace( '\\', DIRECTORY_SEPARATOR, $classname ) ) );

		// Prefix the file name and round out the path.
		$classname = __DIR__ . substr_replace( $classname, DIRECTORY_SEPARATOR . 'class-', (int) strrpos( $classname, DIRECTORY_SEPARATOR ), 1 ) . '.php';

		// If the path is a file, we require it becuase it contains the class we want.
		if ( is_file( $path ) ) {
			require_once $path;
		}
	}
}

spl_autoload_register( __NAMESPACE__ .'\Autoloader::autoloader' );
