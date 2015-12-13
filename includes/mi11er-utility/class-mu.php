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
	 * Registery
	 * @var array.
	 */
	protected $_registery = [];

	/**
	 * Plugins
	 * @var array.
	 */
	protected $_plugins = [
		'Site_Icons',
	];

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
	 * Magic method for checking the existence of a certain custom field.
	 *
	 * @param string $key Key to check the set status for.
	 *
	 * @return bool
	 */
	public function __isset( $key ) {
		return isset( $this->data[ $key ] );
	}

	/**
	 * Magic method for getting Miller Utility variables.
	 *
	 * @param string $key Key to return the value for.
	 *
	 * @return mixed
	 */
	public function __get( $key ) {
		if ( 0 === strpos( $key, 'plugin_' ) ) {
			return $this->_get_plugin( $key );
		}

		return isset( $this->_registery[ $key ] ) ? $this->_registery[ $key ] : null;
	}

	/**
	 * Main Miller Utility Instance
	 *
	 * I think this is what you call a signleton. I'm still not sure this is the best way.
	 *
	 * @return Mi11er\Utility\Mu The one and only.
	 */
	public static function instance() {
		static $instance = null;

		// Set things up if this is the begining.
		if ( null === $instance ) {
			$instance = new Mu();

			// Do stuff.
			$instance->setup_plugins();
		}
		return $instance;
	}

	/**
	 * Get the plugin teplate directory
	 * @return string
	 */
	public function get_template_directory() {
		return dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'templates';
	}
	/**
	 * Setup the distinct areas of this plugins.
	 */
	protected function setup_plugins() {
		foreach ( $this->_plugins as $plugin_name ) {
			$plugin_name = strtolower( 'plugin_' . $plugin_name );
			if ( apply_filters( 'mu_enable_' . $plugin_name, true ) ) {
				$this->$plugin_name->setup();
			}
		}
	}

	/**
	 * Get the plugin object. Inistalize if not set.
	 *
	 * @param string $key Key to return the value for.
	 *
	 * @return Mi11er\Utility\Plugin_Interface
	 */
	public function _get_plugin( $key ) {
		if ( isset( $this->$key ) ) {
			return $this->_registery[ $key ];
		}

		$plugin = ucwords( substr( $key, 7 ), '_' );
		if ( in_array( $plugin, $this->_plugins ) && apply_filters( 'mu_enable_' . $plugin, true ) ) {
			$plugin_class = __NAMESPACE__ . '\\' . $plugin;
			return new $plugin_class;
		}

		return null;
	}
}
