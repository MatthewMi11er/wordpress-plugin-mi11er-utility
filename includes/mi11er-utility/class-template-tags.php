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
	 *
	 * @var array
	 */
	protected static $_tags = [];

	/**
	 * Call a Tag
	 *
	 * @throws \BadFunctionCallException If the tag wasn't defined.
	 *
	 * @param string $tag The name of the tag to call.
	 * @param array  $arguments The arguments passed to the tag.
	 *
	 * @return mixed
	 */
	public static function __callStatic( $tag, $arguments ) {
		if ( ! array_key_exists( $tag, self::$_tags ) ) {
			throw new \BadFunctionCallException( $tag . ' not defined' );
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
	 * Get the plugin teplate directory
	 *
	 * @return string
	 */
	public static function get_mu_template_directory() {
		return dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'templates';
	}

	/**
	 * Get the request URL
	 *
	 * @return null|array An array of the various request URL Parts
	 */
	public static function get_the_request_url() {
		// Deterimine if wordpress root is in a subdir.
		$home_path = wp_parse_url( home_url() )['path'];
		if ( ! is_string( $home_path ) ) {
			$home_path = '/';
		} else if ( '/' !== $home_path ) {
			user_trailingslashit( $home_path );
		}

		$request_uri = filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL );

		// Request URI not set; Bail.
		if ( null === $request_uri ) {
			return null;
		}

		return wp_parse_url( home_url( preg_replace( '~^' . preg_quote( $home_path, '~' ) . '~', '', $request_uri ) ) );
	}

	/**
	 * Returns the Website Root Directory. Calculated from
	 * `ABSPATH` and `home`/`siteurl` options.
	 * Works similar to Wordpress get_home_path but better(?).
	 *
	 * @return string Website Root with trailing slash.
	 */
	public static function get_the_root_directory() {
		$home    = set_url_scheme( get_option( 'home', '' ), 'http' );
		$siteurl = set_url_scheme( get_option( 'siteurl', '' ), 'http' );
		if ( '' === $home  || 0 === strcasecmp( $home, $siteurl ) ) {
			return ABSPATH;
		}

		$wp_path_rel_to_home = trailingslashit( str_ireplace( $home, '', $siteurl ) ); /* $siteurl - $home */
		$pos = strripos( str_replace( '\\', '/', ABSPATH ), $wp_path_rel_to_home );
		return trailingslashit( substr( ABSPATH, 0, $pos ) );
	}

	/**
	 * Retrieve home URL with proper trailing slash.
	 *
	 * @param string      $path   Path relative to home URL.
	 * @param string|null $scheme Scheme to apply.
	 *
	 * @return string Home URL with optional path, appropriately slashed if not.
	 */
	public static function home_url( $path = '', $scheme = null ) {
		$home_url = home_url( $path, $scheme );
		if ( ! empty( $path ) ) {
			return $home_url;
		}
		$home_path = wp_parse_url( $home_url )['path'];
		if ( '/' === $home_path ) { // Home at site root, already slashed.
			return $home_url;
		}
		if ( is_null( $home_path ) ) { // Home at site root, always slash.
			return trailingslashit( $home_url );
		}
		if ( is_string( $home_path ) ) { // Home in subdirectory, slash if permalink structure has slash.
			return user_trailingslashit( $home_url );
		}
		return $home_url;
	}

	/**
	 * Echos the home url for the current site with optional path appended.
	 *
	 * @param  string $path   Optional. Path relative to the home url. Default empty.
	 * @param  string $scheme Optional. Scheme to give the home url context. Accepts
	 *                        'http', 'https', or 'relative'. Default null.
	 */
	public static function the_home_url( $path = '', $scheme = null ) {
		echo esc_url( self::home_url( $path, $scheme ) );
	}

	/**
	 * Print theme directory URI, with optional path appended.
	 *
	 * @param  string $path   Optional. Path relative to the template direcotry uri. Default empty.
	 * @param  string $scheme Optional. Scheme to give the home url context. Accepts
	 *                        'http', 'https', or 'relative'. Default null.
	 */
	public static function the_template_directory_uri( $path = '', $scheme = null ) {
		if ( ! is_string( $path ) ) {
			$path = '';
		}
		echo esc_url( set_url_scheme( trailingslashit( get_template_directory_uri() ) . ltrim( $path, '/' ), $scheme ) );
	}

	/**
	 * ================ Formaters
	 */

	/**
	 * Convert to title-case.
	 *
	 * @see https://github.com/MatthewMi11er/php-to-title-case
	 * @param string $title The string title to convert.
	 *
	 * @return string
	 */
	public static function to_title_case( $title ) {
		/**
		 * Remove HTML like tags and entities
		 */
		$elements = '/<(code|var)[^>]*>.*?<\/\1>|<[^>]+>|&\S+;/';
		preg_match_all( $elements, $title, $found_elements, PREG_OFFSET_CAPTURE );
		$title = preg_replace( $elements, '', $title );

		/**
		 * These are words that generally should not be capitalized in the title.
		 */
		$small_words = '/^(a|an|and|as|at|but|by|en|for|if|in|nor|of|on|or|per|the|to|vs?\.?|via)$/iu';

		$title_cased = preg_replace_callback('/[A-Za-z0-9\xC0-\xFF]+[^\s-]*/u', function( $matches ) use ( $title, $small_words ) {
			static $start_at = 0;
			// Find where the match starts in our $title.
			$offset = mb_strpos( $title, $matches[0], $start_at, 'UTF-8' );
			// Move the pointer for the next match.
			$start_at = $offset + mb_strlen( $matches[0],'UTF-8' );
			if ( $offset > 0 && $offset + mb_strlen( $matches[0], 'UTF-8' ) !== mb_strlen( $title, 'UTF-8' )
				&& preg_match( $small_words, $matches[0] ) && ( $offset - 2 < 0 || mb_substr( $title, $offset - 2, 1 , 'UTF-8' ) !== ':' )
				&& ( mb_substr( $title, $offset + mb_strlen( $matches[0], 'UTF-8' ), 1 ) !== '-'
					|| $offset - 1 < 0 || mb_substr( $title, $offset - 1, 1, 'UTF-8' ) === '-' )
				&& ( $offset - 1 < 0 || ! preg_match( '/[^\s-]/', mb_substr( $title, $offset - 1, 1, 'UTF-8' ) ) ) ) {
				return mb_strtolower( $matches[0], 'UTF-8' );
			}
			if ( preg_match( '/[A-Z]|\../', mb_substr( $matches[0], 1, null, 'UTF-8' ) ) ) {
				return $matches[0];
			}
			return mb_strtoupper( mb_substr( $matches[0], 0, 1, 'UTF-8' ), 'UTF-8' ) . mb_substr( $matches[0], 1, null, 'UTF-8' );
		}, $title);

		/**
		 * Try to put the HTML tags and entities back where they belong
		 */
		foreach ( $found_elements[0] as $element ) {
			$title_cased = substr_replace( $title_cased, $element[0], $element[1], 0 );
		}
		return $title_cased;
	}
}
