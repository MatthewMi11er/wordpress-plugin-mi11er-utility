<?php
/**
 * Mi11er\Utility plugin initalization
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

/**
 * Plugin Intialization
 */
class Init
{
	/**
	 * Constructor
	 * Force setup through the init function.
	 */
	protected function __construct(){}

	/**
	 * Initalize the plugin; setup hooks; etc.
	 *
	 * @return Mi11er\Utils\Init
	 */
	public static function init() {
		$init = new Init();
		return $init->register_hooks();
	}

	/**
	 * Register All the primary hooks for the puglin
	 */
	public function register_hooks() {
		return $this->register_filters()->register_actions();
	}

	/**
	 * Register All the primary filter hooks.
	 */
	public function register_filters() {
		return $this;
	}

	/**
	 * Register All the primary action hooks.
	 */
	public function register_filters() {
		add_action( 'wp_head', array( $this, __NAMESPACE__ . '\Favicons::the_favicon_links' ) );

		return $this;
	}
}
