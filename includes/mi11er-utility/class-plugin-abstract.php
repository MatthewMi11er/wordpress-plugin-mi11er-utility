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
	 * Namespace for wordpress core functions
	 * Used for testing callable functions.
	 *
	 * @var string $wp_core_namepace
	 */
	protected $wp_core_namespace = '';

	/**
	 * The constructor
	 */
	final public function __construct() {
		if( ! defined( 'ABSPATH' ) ) {
			$this->wp_core_namespace = __NAMESPACE__;
		}
		return;
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
