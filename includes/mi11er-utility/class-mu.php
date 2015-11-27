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
	protected $_actions;
	
	protected $_filters;
	
	
	public function __construct(){
		$this->_actions = new Actions();
		$this->_filters = new Filters();
	}
	/**
	 * Initalize the plugin; setup hooks; etc.
	 */
	public function init() {
		$this->register_hooks();
	}

	/**
	 * Register All the primary hooks for the puglin
	 */
	public function register_hooks() {
		$this->_actions->register_hooks();
		$this->_filters->register_hooks();
	}

	/**
	 * Register All the primary filter hooks.
	 */
	public function register_filters() {
		add_filter( 'option_site_icon', __NAMESPACE__ . '\Site_Icons::option_site_icon_filter' );
		add_filter( 'do_parse_request', __NAMESPACE__ . '\Site_Icons::do_parse_request_filter', 10, 3 );
	}

	/**
	 * Register All the primary action hooks.
	 */
	public function register_actions() {
		add_action( 'wp_head',            __NAMESPACE__ . '\Site_Icons::the_icon_links' );
		add_action( 'customize_register', __NAMESPACE__ . '\Site_Icons::customize_register', 11 );
	}
}
