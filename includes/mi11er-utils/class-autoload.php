<?php
/**
 * Autoloader
 * @package mi11er_utils
 */

namespace Mi11er\Utils;

/**
 * Autoloader for OFBF Classes
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
		$c = count( $parts );
		$path = __DIR__;
		for ( $i = 0; $i < $c -1; $i++ ) {
			$path .= DIRECTORY_SEPARATOR . $parts[ $i ];
		}
		$path .= DIRECTORY_SEPARATOR . 'class-' . $parts[ $c -1 ] . '.php';

		// If the path is a file, we require it becuase it contains the class we want.
		if ( is_file( $path ) ) {
			require_once $path;
		}
	}
}

spl_autoload_register( __NAMESPACE__ .'\Autoloader::autoloader' );
