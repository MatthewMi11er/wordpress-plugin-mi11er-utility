<?php
/**
 * Mi11er\Utility Manage Actions
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

/**
 * It's Action Time.
 */
final class Actions
{
	/**
	 * Register All the primary Action hooks for the puglin
	 */
	public function register_hooks() {

			add_action( 'wp_head',            __NAMESPACE__ . '\Site_Icons::the_icon_links' );
			add_action( 'customize_register', __NAMESPACE__ . '\Site_Icons::customize_register', 11 );

	}
}
