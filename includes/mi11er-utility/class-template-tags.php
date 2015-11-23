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
	 * Echos the home url for the current site with optional path appended.
	 *
	 * @param  string $path   Optional. Path relative to the home url. Default empty.
	 * @param  string $scheme Optional. Scheme to give the home url context. Accepts
	 *                        'http', 'https', or 'relative'. Default null.
	 */
	public function the_home_url( $path = '', $scheme = null ) {
		echo esc_url( home_url( $path, $scheme ) );
	}
}
