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
		/**
		 * Setup hooks and subhooks.
		 * @see https://codex.wordpress.org/Plugin_API/Action_Reference
		 */

	}

	public function customize_register() {
		// __NAMESPACE__ . '\Site_Icons::customize_register', 11
	}

	public function wp_head() {
		// __NAMESPACE__ . '\Site_Icons::the_icon_links'
	}
}
