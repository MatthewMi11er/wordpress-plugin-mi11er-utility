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
			[ 'get_the_date',           [ $this, 'get_the_date_filter' ],           10, 3 ],
			[ 'get_the_time',           [ $this, 'get_the_time_filter' ],           10, 3 ],
			[ 'get_the_modified_date',  [ $this, 'get_the_modified_date_filter' ],  10, 2 ],
			[ 'get_the_modified_time',  [ $this, 'get_the_modified_time_filter' ],  10, 2 ],
			[ 'https_local_ssl_verify', [ $this, 'https_local_ssl_verify_filter' ], 10, 1 ],
			[ 'is_email',               [ $this, 'is_email_filter' ],               10, 2 ],
			[ 'redirect_canonical',     [ $this, 'redirect_canonical_filter' ],      0, 2 ],
		];
		foreach ( $this->registered_filters as $filter ) {
			call_user_func_array( [ $this->wp, 'add_filter' ], $filter );
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
		return true;
	}

	/**
	 * Callback for the 'get_the_date' filter
	 * Adds the AP_DATE Format
	 *
	 * @param string  $the_date The date of the post.
	 * @param string  $d The date format.
	 * @param WP_POST $post The current post.
	 */
	public function get_the_date_filter( $the_date, $d = '', $post = null ) {

		if ( Date_Time::AP_DATE !== $d ) {
			return $the_date;
		}

		$post = $this->wp->get_post( $post );

		if ( ! $post ) {
			return $the_date;
		}

		$date = new Date_Time( $post->post_date, null, $this->wp->current_time( 'timestamp' ) );

		return $date->format( Date_Time::AP_DATE );
	}

	/**
	 * Get the time of the post
	 *
	 * @param string  $the_time The time of the post.
	 * @param string  $d The time format.
	 * @param WP_POST $post The current post.
	 */
	public function get_the_time_filter( $the_time, $d = '', $post = null ) {

		if ( Date_Time::AP_TIME !== $d ) {
			return $the_time;
		}

		$post = $this->wp->get_post( $post );

		if ( ! $post ) {
			return $the_time;
		}

		$time = new Date_Time( $post->post_date, null, $this->wp->current_time( 'timestamp' ) );

		return $time->format( Date_Time::AP_TIME );
	}

	/**
	 * Get the modified date of the post
	 *
	 * @param string $the_date The date to filter.
	 * @param string $d The date format.
	 */
	function get_the_modified_date_filter( $the_date, $d = '' ) {

		if ( Date_Time::AP_DATE !== $d ) {
			return $the_date;
		}

		$date = new Date_Time( $this->wp->get_post_modified_time( 'Y-m-d\TH:i:sP', null, null, true ), null, $this->wp->current_time( 'timestamp' ) );
		return $date->format( Date_Time::AP_DATE );
	}

	/**
	 * Get the modified time of the post
	 *
	 * @param string $the_time The Time to filter.
	 * @param string $d The time format.
	 */
	function get_the_modified_time_filter( $the_time, $d = '' ) {

		if ( Date_Time::AP_TIME !== $d ) {
			return $the_time;
		}

		$time = new Date_Time( $this->wp->get_post_modified_time( 'Y-m-d\TH:i:sP', null, null, true ), null, $this->wp->current_time( 'timestamp' ) );
		return $time->format( Date_Time::AP_TIME );
	}

	/**
	 * Filter https_local_ssl_verify
	 *
	 * @param boolean $the_value The value set by pervious filters.
	 * @return boolean False when in development environment.
	 */
	public function https_local_ssl_verify_filter( $the_value ) {
		if ( isset( $this->wp ) && 'development' === $this->wp->WP_ENV ) {
			return false;
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
	 *
	 * @return string|bool Either false or the valid email address.
	 */
	public function is_email_filter( $is_email, $email ) {
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
	 *
	 * @return bool|string
	 */
	public function redirect_canonical_filter( $redirect_url ) {
		/**
		 * Filter if we want to remove the 404 redirect guess.
		 *
		 * @param bool $prevent_guess Prevent the guess or not.
		 */
		if ( $this->wp->is_404() && $this->wp->apply_filters( 'mu_prevent_wordpress_url_guess_redirect', true ) ) {
			return false;
		}
		return $redirect_url;
	}
}
