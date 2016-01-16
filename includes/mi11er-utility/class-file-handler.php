<?php
/**
 * Handle Miscellaneous Files
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

use Mi11er\Utility\Template_Tags as TT;

/**
 * This class provides functions for routing requests that aren't standard posts or
 * custom post types (eg. theme php css handler.)
 */
class File_Handler implements Plugin_Interface
{
	/**
	 * List of files that this plugin will handle.
	 *
	 * @var array
	 */
	protected $_files = [];

	/**
	 * Run whatever is needed for plugin setup
	 */
	public function setup() {
		// Actions.
		add_action( 'init',                      [ $this, 'init_action' ],                   10 );

		// Filters.
		add_filter( 'redirect_canonical',        [ $this, 'redirect_canonical' ],            10, 2 );
		add_filter( 'template_include',          [ $this, 'template_include_filter' ],       10, 1 );
	}

	/**
	 * ================Actions
	 */

	/**
	 * Callback for the `init` action hook
	 * Fires after WordPress has finished loading but before any headers are sent.
	 *
	 * Most of WP is loaded at this stage, and the user is authenticated. WP continues
	 * to load on the init hook that follows (e.g. widgets), and many plugins instantiate
	 * themselves on it for all sorts of reasons (e.g. they need a user, a taxonomy, etc.).
	 *
	 * If you wish to plug an action once WP is loaded, use the wp_loaded hook below.
	 */
	public function init_action() {
		/**
		 * Fires on WordPress init, other themes and plugins to use this to handle their files.
		 *
		 * @param File_Handler $this File_Handler instance.
		 */
		do_action( 'mu_file_handler', $this );

		/**
		 * Add custom rewrite rules for the things we handle
		 */
		foreach ( $this->_files as $file_key => $file_config ) {
			add_rewrite_rule( $file_config['rewrite'], 'index.php?mu_file_handler=' . $file_key , 'top' );
		}
		add_rewrite_tag( '%mu_file_handler%', '([^&]+)' );
	}

	/**
	 * ================Filters
	 */

	/**
	 * Callback for the `redirect_canonical` filter hook
	 * Filter the canonical redirect URL.
	 *
	 * Returning false to this filter will cancel the redirect.
	 *
	 * @param string $redirect_url  The redirect URL.
	 * @param string $requested_url The requested URL.
	 *
	 * @return bool|string
	 */
	public function redirect_canonical( $redirect_url, $requested_url ) {
		// Check if we're dealing stuff we care about and optionally prevent addtion of trailing slash.
		if ( false !== $file_config = $this->get_config() && $file_config['prevent_slash'] ) {
			return false;
		}

		return $redirect_url;
	}

	/**
	 * Callback for the template_include filter hook
	 * Filter the path of the current template before including it.
	 *
	 * @param string $template The path of the template to include.
	 */
	public function template_include_filter( $template ) {
		// Check if we're dealing stuff care about.
		if ( false !== $file_config = $this->get_config() ) {
			return $file_config['template'];
		}
		return $template;
	}

	/**
	 * ================Helpers
	 */

	/**
	 * Add a configure for a new file to handle
	 *
	 * @param string $file          The name of the file to handle.
	 * @param string $rewrite       The rewrite rule to add for the file.
	 * @param bool   $prevent_slash Whether we should stop rewrite_canonical from adding a slash.
	 */
	public function add_config( $file, $rewrite, $prevent_slash = true ) {
		$this->_files[] = [
			'file'          => $file,
			'rewrite'       => $rewrite,
			'prevent_slash' => $prevent_slash,
		];
	}

	/**
	 * Return the configuration if a file we care about was requested.
	 *
	 * @return mixed
	 */
	public function get_config() {
		if ( array_key_exists( $file_key = get_query_var( 'mu_file_handler', false ), $this_->files ) ) {
			return $this->_files[ $file_key ];
		}

		return false;
	}
}
