<?php
/**
 * Handle Miscellaneous Files
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

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
		add_filter( 'redirect_canonical',        [ $this, 'redirect_canonical_filter' ],     10, 2 );
		add_filter( 'template_include',          [ $this, 'template_include_filter' ],       10, 1 );
		add_filter( 'the_posts',                 [ $this, 'the_posts_filter' ],              1,  2 );
	}

	/**
	 * Run whatever is needed ofr plugin activation
	 */
	public function activate() {
		return;
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
	public function redirect_canonical_filter( $redirect_url, $requested_url ) {
		// Check if we're dealing stuff we care about and optionally prevent addtion of trailing slash.
		if ( false !== $this->get_config() && $this->get_config()['prevent_slash'] ) {
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
	 * Callback for the `the_posts` filter hook
	 *
	 * @see https://gist.github.com/cubehouse/3839159
	 * @see http://davejesch.com/2012/12/creating-virtual-pages-in-wordpress/
	 * @see https://www.gowp.com/blog/inserting-custom-posts-loop/
	 * @see http://stackoverflow.com/questions/14459921/how-to-add-new-post-without-adding-to-database-wordpress
	 * @param array    $posts The array of retrieved posts.
	 * @param WP_Query $wp_query The WP_Query instance (passed by reference).
	 * @return array
	 */
	public function the_posts_filter( $posts, $wp_query ) {
		$file_config = $this->get_config();
		if ( false !== $file_config && $wp_query->is_main_query() && ! is_admin() ) {
			$default_post = [
				'post_author'    => 1,
				'post_name'      => $file_config['file'],
				'guid'           => esc_url( home_url( '/' . $file_config['file'] ) ),
				'post_title'     => $file_config['file'],
				'post_content'   => '',
				'ID'             => -1 * ( unpack( 'N2', sha1( $file_config['file'], true ) )[1] & 0x0FFFFFFF ), // Hopefully unqiue enough.
				'post_type'      => 'page',
				'post_status'    => 'static',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'comment_count'  => 0,
				'post_date'      => current_time( 'mysql' ),
				'post_date_gmt'  => current_time( 'mysql', 1 ),
			];
			$post = (object) array_merge( $default_post, $file_config['post'] );
			$posts = [ $post ];

			$wp_query->is_page     = true;
			$wp_query->is_singular = true;
			$wp_query->is_home     = false;
			$wp_query->is_archive  = false;
			$wp_query->is_category = false;
			unset( $wp_query->query['error'] );
			$wp_query->query_vars['error'] = '';
			$wp_query->is_404      = false;
		}
		return $posts;
	}

	/**
	 * ================Helpers
	 */

	/**
	 * Add a configure for a new file to handle
	 *
	 * @param string $file          The name of the file to handle.
	 * @param string $rewrite       The rewrite rule to add for the file.
	 * @param string $template      The template that should handle the file.
	 * @param bool   $prevent_slash Whether we should stop rewrite_canonical from adding a slash.
	 * @param array  $post          Post data (real or imagined) that we want to use to replace wp_query.
	 */
	public function add_config( $file, $rewrite, $template, $prevent_slash = true, $post = [] ) {
		$this->_files[] = [
			'file'          => $file,
			'rewrite'       => $rewrite,
			'template'      => $template,
			'prevent_slash' => $prevent_slash,
			'post'          => $post,
		];
	}

	/**
	 * Return the configuration if a file we care about was requested.
	 *
	 * @return mixed
	 */
	public function get_config() {
		$file_key = get_query_var( 'mu_file_handler', false );
		if ( false !== $file_key && array_key_exists( $file_key, $this->_files ) ) {
			return $this->_files[ $file_key ];
		}

		return false;
	}
}
