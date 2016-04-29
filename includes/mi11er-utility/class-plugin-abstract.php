<?php
/**
 * Abstract Class for Mi11er\Utility plugins
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

/**
 * Abstract Class for Mi11er\Utility plugins
 */
abstract class Plugin_Abstract implements Plugin_Interface
{
	/**
	 * Registered Filters
	 *
	 * @var array $registered_filters
	 */
	protected $registered_filters = [];

	/**
	 * Registered Actions
	 *
	 * @var array $registered_actions
	 */
	protected $registered_actions = [];

	/**
	 * The Wordpess Interface
	 *
	 * @var Wp_Interface $wp
	 */
	protected $wp;

	/**
	 * The constructor
	 *
	 * @param Wp_Interface $wp Interface to the Wordpress system.
	 */
	final public function __construct( Wp_Interface $wp ) {
		$this->wp = $wp;
	}

	/**
	 * Returns an array of the actions that were registered.
	 *
	 * @return arary
	 */
	final public function get_registered_actions() {
		return $this->registered_actions;
	}

	/**
	 * Returns an array of the filters that were registered.
	 *
	 * @return arary
	 */
	final public function get_registered_filters() {
		return $this->registered_filters;
	}

	/**
	 * Run whatever is needed for plugin activation.
	 *
	 * Override this in the implmenting class if it needs to make
	 * changes on activiation.
	 */
	public function activate() {
		return true;
	}
}
