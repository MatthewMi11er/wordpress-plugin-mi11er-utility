<?php
/**
 * Template Tags
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

/**
 * Various Tags for templating
 */
class Template_Tags
{
	/**
	 * Tags that have been added
	 * @var array
	 */
	protected static $_tags = [];

	/**
	 * Call a Tag
	 *
	 * @throws BadFunctionCallException If the tag wasn't defined.
	 *
	 * @param string $tag The name of the tag to call.
	 * @param array  $arguments The arguments passed to the tag.
	 *
	 * @return mixed
	 */
	public static function __callStatic( $tag, $arguments ) {
		if ( ! array_key_exists( $tag, self::$_tags ) ) {
			throw new BadFunctionCallException( $tag . ' not defined' );
		}

		return call_user_func_array( self::$_tags[ $tag ], $arguments );
	}

	/**
	 * Add a callable tag.
	 *
	 * @throws \RuntimeException If the tag is already set.
	 * @throws \InvalidArgumentException If function is not callable.
	 *
	 * @param string   $tag The name of the tag.
	 * @param callable $function The callback.
	 */
	public static function add_tag( $tag, $function ) {
		if ( array_key_exists( $tag, self::$_tags ) ) {
			throw new \RuntimeException( 'Template Tag already defined' );
		}

		if ( ! is_callable( $function ) ) {
			throw new \InvalidArgumentException( 'Function for `'. $tag . '` tag must be callable' );
		}

		self::$_tags[ $tag ] = $function;
	}

	/**
	 * Echos the home url for the current site with optional path appended.
	 *
	 * @param  string $path   Optional. Path relative to the home url. Default empty.
	 * @param  string $scheme Optional. Scheme to give the home url context. Accepts
	 *                        'http', 'https', or 'relative'. Default null.
	 */
	public static function the_home_url( $path = '', $scheme = null ) {
		echo esc_url( home_url( $path, $scheme ) );
	}

	/**
	 * Get the plugin teplate directory
	 * @return string
	 */
	public static function get_mu_template_directory() {
		return dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'templates';
	}
}
