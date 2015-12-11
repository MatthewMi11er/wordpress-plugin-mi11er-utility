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
final class Mu
{
	/**
	 * The Actions Class
	 * @var Mi11er\Utility\Actions Action Handler.
	 */
	protected $_actions = null;

	/**
	 * The Filters Class
	 * @var Mi11er\Utility\Actions Filters Handler.
	 */
	protected $_filters = null;

	/**
	 * A empty constructor. Nothing should be done here.
	 */
	private function __construct() {
		// Do nothing here.
		return;
	}

	/**
	 * The object shouldn't be cloned.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Oh no you didn&#8217;t!', 'mi11er-utility' ), '4.3' );
	}

	/**
	 * The object shouldn't be unsearlized
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Oh no you didn&#8217;t!', 'mi11er-utility' ), '4.3' );
	}

	/**
	 * Main Miller Utility Instance
	 *
	 * This is what you call a signleton. I'm still not sure this is the best way.
	 *
	 * @return Mi11er\Utility\Mu The one and only.
	 */
	public static function instance() {
		static $instance = null;

		// Set things up if this is the begining.
		if ( null === $instance ) { )
			$instance = new Mu;

			// Do stuff.
			$instanace->register_actions();
			$instanace->register_filters();

			/*
			$instance->constants();
			$instance->setup_globals();
			$instance->legacy_constants();
			$instance->includes();
			$instance->setup_actions();
				*/
		}
		return $instance;
	}

	/**
	 * Register All the primary action hooks.
	 */
	protected function register_actions() {
		if ( null === $this->_actions ) {
			$this->_actions = new Actions();
			$this->_actions->register_hooks();
		}
	}

	/**
	 * Register All the primary filter hooks.
	 */
	public function register_filters() {
		if ( null === $this->_filters ) {
			$this->_filters = new Filters();
			$this->_filters->register_hooks();
		}
	}
}
