<?php
/**
 * Interface for Mi11er\Utility plugins
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

interface Plugin_Interface
{
	/**
	 * The constructor
	 *
	 * @param Wp_Interface $wp Interface to the Wordpress system.
	 */
	public function __construct( Wp_Interface $wp );

	/**
	 * Run whatever is needed for plugin setup
	 */
	public function setup();

	/**
	 * Run whatever is needed ofr plugin activation
	 */
	public function activate();

	/**
	 * Returns an array of the actions that were registered.
	 *
	 * @return arary
	 */
	public function get_registered_actions();

	/**
	 * Returns an array of the filters that were registered.
	 *
	 * @return arary
	 */
	public function get_registered_filters();
}
