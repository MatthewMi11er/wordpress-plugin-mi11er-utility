<?php
/**
 * Mi11er\Utility plugin initalization
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

use Mi11er\Utility\Template_Tags as TT;

/**
 * Plugin Intialization
 */
final class Mu
{
	/**
	 * Registery
	 *
	 * @var array.
	 */
	protected $_registery = [];

	/**
	 * Plugins
	 *
	 * @var array.
	 */
	protected $_plugins = [
		'Ap_Style',
		'Author_Slug',
		'Filters',
		'File_Handler',
		'Redirect',
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
	 * Magic method for getting Mi11er Utility variables.
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
	 * Main Mi11er Utility Instance
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

			// Register Actions.
			add_action( 'init', [ $instance, 'init_action' ], 1 );

			// Activation.
			register_activation_hook( dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'mi11er-utility.php', [ $instance, 'activation' ] );
		}
		return $instance;
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
		if ( in_array( $plugin, $this->_plugins, true ) && apply_filters( 'mu_enable_' . $plugin, true ) ) {
			$plugin_class = __NAMESPACE__ . '\\' . $plugin;
			return new $plugin_class;
		}

		return null;
	}

	/**
	 * Do whatever is necessary for plugin activation
	 */
	public function activation() {
		foreach ( $this->_plugins as $plugin_name ) {
			$plugin_name = strtolower( 'plugin_' . $plugin_name );
			if ( apply_filters( 'mu_enable_' . $plugin_name, true ) ) {
				$this->$plugin_name->activate();
			}
		}
	}

	/**
	 * ================Actions
	 */

	/**
	 * Callback for the `init` action hook
	 */
	public function init_action() {
		load_plugin_textdomain( 'mi11er-utility', false, plugin_basename( dirname( dirname( __DIR__ ) ) ) . DIRECTORY_SEPARATOR . 'languages' );
	}
}
