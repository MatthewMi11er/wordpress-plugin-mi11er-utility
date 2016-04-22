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
	 * The class name
	 *
	 * @var $class_name
	 */
	protected $class_name;

	/**
	 * The constructor
	 *
	 * @param string $class_name The name of the class we want to autoload.
	 */
	public function __construct( $class_name ) {
		$this->class_name = $class_name;
	}

	/**
	 * Loads the file for the requested class
	 *
	 * @param string $class_name The class to load.
	 */
	public static function autoloader( $class_name ) {
		$autoloader = new self( $class_name );

		if ( ! $autoloader->is_own_namespace() ) {
			return;
		}

		// Remove the prefix.
		$classname = substr( $classname, strlen( __NAMESPACE__ ) );

		$this->load();
	}

	/**
	 * Check if the class is one this autoloader handles
	 *
	 * @return bool
	 */
	public function is_own_namespace() {
		if ( 0 !== strpos( $this->class_name, __NAMESPACE__ ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Loads the class file
	 *
	 * @return bool Was the class file loaded.
	 */
	public function load() {
		$path = $this->path();

		// If the path is a file, we require it becuase it contains the class we want.
		if ( is_file( $path ) ) {
			require_once $path;
			return true;
		}
		return false;
	}

	/**
	 * Returns the calculated path to the class file.
	 *
	 * @return string The path.
	 */
	public function path() {
		// Remove the prefix.
		$path = substr( $this->class_name, strlen( __NAMESPACE__ ) );

		// Replace backslashes and underscores with DIRECTORY_SEPARATOR and dash. Make lower case.
		$path = strtolower( str_replace( '_', '-', str_replace( '\\', DIRECTORY_SEPARATOR, $path ) ) );

		// Prefix the file name and round out the path.
		return __DIR__ . substr_replace( $path, DIRECTORY_SEPARATOR . 'class-', (int) strrpos( $path, DIRECTORY_SEPARATOR ), 1 ) . '.php';
	}
}

spl_autoload_register( __NAMESPACE__ .'\Autoloader::autoloader' );
