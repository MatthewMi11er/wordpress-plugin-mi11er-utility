<?php
/**
 * Addtional Filters
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

/**
 * This class provides addtional filters that don't have a better place to live
 */
class Filters implements Plugin_Interface
{

	/**
	 * The Wordpess Interface
	 *
	 * @var Wp_Interface $wp
	 */
	protected $wp;

	/**
	 * Registered Filters
	 *
	 * @var array $registered_filters
	 */
	protected $registered_filters = [];

	/**
	 * The constructor
	 *
	 * @param Wp_Interface $wp Interface to the Wordpress system.
	 */
	public function __construct( Wp_Interface $wp ) {
		$this->wp = $wp;
	}

	/**
	 * Run whatever is needed for plugin setup
	 */
	public function setup() {
		if ( ! empty( $this->registered_filters ) ) {
			return;
		}
		$this->registered_filters = [
			[ 'https_local_ssl_verify', [ $this, 'https_local_ssl_verify_filter' ], 10, 1 ],
			[ 'is_email',               [ $this, 'is_email_filter' ],               10, 3 ],
			[ 'redirect_canonical',     [ $this, 'redirect_canonical_filter' ],      0, 2 ],
		];
		foreach ( $this->registered_filters as $filter ) {
			call_user_func_array( [ $this->wp, 'add_filter' ],$filter );
		}
	}

	/**
	 * Returns the registered_filters;
	 *
	 * @return array
	 */
	public function get_registered_filters() {
		return $this->registered_filters;
	}
	/**
	 * Run whatever is needed for plugin activation.
	 */
	public function activate() {
		return;
	}

	/**
	 * Filter https_local_ssl_verify
	 *
	 * @param boolean $the_value The value set by pervious filters.
	 * @return boolean False when in development environment.
	 */
	public function https_local_ssl_verify_filter( $the_value ) {
		if ( WP_ENV === 'development' ) {
			$the_value = false;
		}
		return $the_value;
	}

	/**
	 * Callback for the 'is_email' filter
	 *
	 * Use built in PHP vilters for better RFC compliance.
	 *
	 * @param bool   $is_email Whether the email address has passed the is_email() checks. Default false.
	 * @param string $email    The email address being checked.
	 * @param string $context  Context under which the email was tested.
	 *
	 * @return string|bool Either false or the valid email address.
	 */
	public function is_email_filter( $is_email, $email, $context ) {
		return filter_var( $email, FILTER_VALIDATE_EMAIL );
	}

	/**
	 * Callback for the `redirect_canonical` filter hook
	 *
	 * This allows us to disable worpress' guess the url
	 * feature. A better solution might be forthcoming if the
	 * patch at {@link https://core.trac.wordpress.org/ticket/16557} gets
	 * into core.
	 *
	 * @param string $redirect_url  The redirect URL.
	 * @param string $requested_url The requested URL.
	 *
	 * @return bool|string
	 */
	public function redirect_canonical_filter( $redirect_url, $requested_url ) {
		/**
		 * Filter if we want to remove the 404 redirect guess.
		 *
		 * @param bool $prevent_guess Prevent the guess or not.
		 */
		if ( is_404() && apply_filters( 'mu_prevent_wordpress_url_guess_redirect', true ) ) {
			return false;
		}
		return $redirect_url;
	}
}
