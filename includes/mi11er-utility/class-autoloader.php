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
		// Remove the prefix and the first slash.
		$classname = substr( $classname, strlen( __NAMESPACE__ ) + 1 );

		// Split out the namespace parts and classname.
		$parts = explode( '\\', strtolower( str_replace( '_', '-', $classname ) ) );

		// Turn the parts into a path relative to this files dir.
		end( $parts );
		$key = key( $parts );
		$parts[ $key ] = 'class-' . $parts[ $key ] . '.php';
		
		$path = __DIR__ . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, $parts );

		// If the path is a file, we require it becuase it contains the class we want.
		if ( is_file( $path ) ) {
			require_once $path;
		}
	}
}

spl_autoload_register( __NAMESPACE__ .'\Autoloader::autoloader' );
