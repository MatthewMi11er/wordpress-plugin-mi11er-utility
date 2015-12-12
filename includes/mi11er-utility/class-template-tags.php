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
		array_key_exists( self::$_tags, $tag ) || throw new BadFunctionCallException;
		return call_user_func_array( self::$_tags[ $tag ], $arguments );
	}

	/**
	 * Add a callable tag.
	 *
	 * @param string   $tag The name of the tag.
	 * @param callable $function The callback.
	 *
	 * @return bool Was the tag set sucessfully
	 */
	public static function add_tag( $tag, $function ) {
		! array_key_exists( self::$_tags, $tag ) ) || is_callable( $function ) || return false;

		self::$_tags[ $tag ] = $function;
		return true;
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
}
