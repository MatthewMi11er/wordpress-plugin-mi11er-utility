<?php
/**
 * Format wordpess post dates and times to AP_STYLE
 *
 * @package    Mi11er_Utility
 */

namespace Mi11er\Utility;

/**
 * This class provides various wordpress filters to format date and time according
 * to the AP Style Guid.
 * Ref: https://wordpress.org/plugins/ap-style-dates-and-times/
 */
class Ap_Style implements Plugin_Interface
{

	/**
	 * Format Strings
	 */
	const AP_STYLE = 'AP_STYLE';
	const DATE_FORMAT = 'Y|m|j';
	const TIME_FORMAT = 'H|g|i|a';

	/**
	 * Use 'today' when the post date is the current date
	 *
	 * Though technically not an AP Style rule, many publications use the word 'today' when it's the current date.
	 */
	const USE_TODAY = true;

	/**
	 * If you're using 'today', would you like it capitalized?
	 *
	 * Depending on where you place the date in your template, you may want the word capitalized.
	 */
	const CAPITALIZE_TODAY = true;

	/**
	 * Display the year in the date if it matches the current year?
	 *
	 * According to AP Style, when using a date that is within the current year, the actual year is not needed in the date.
	 * However, you may want to include it in the interest of clarity.
	 */
	const USE_YEAR = false;

	/**
	 * Capitalize 'noon' and 'midnight' when printing the time?
	 *
	 * Depending on where you place the time in you template, you may want the words capitalized.
	 */
	const CAPITALIZE_NOON = true;

	/**
	 * Run whatever is needed for plugin setup
	 */
	public function setup() {
		add_filter( 'get_the_date',          [ $this, 'get_the_date_filter' ],          10, 3 );
		add_filter( 'get_the_time',          [ $this, 'get_the_time_filter' ],          10, 3 );
		add_filter( 'get_the_modified_date', [ $this, 'get_the_modified_date_filter' ], 10, 2 );
		add_filter( 'get_the_modified_time', [ $this, 'get_the_modified_time_filter' ], 10, 2 );
	}

	/**
	 * Run whatever is needed for plugin activation.
	 */
	public function activate() {
		return;
	}

	/**
	 * Determine the month and return the AP Style abbreviation
	 *
	 * @param string $m The month string.
	 */
	protected function _month_string( $m ) {
		$ap_months = [
			'01' => 'Jan.',
			'02' => 'Feb.',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'Aug.',
			'09' => 'Sept.',
			'10' => 'Oct.',
			'11' => 'Nov.',
			'12' => 'Dec.',
		];
		if ( ! array_key_exists( $m, $ap_months ) ) {
			$m = '01';
		}
		return $ap_months[ $m ];
	}

	/**
	 * Determine whether the date is within the current year and return it
	 *
	 * @param string $y The year string.
	 */
	protected function _year_string( $y ) {

		if ( date( 'Y' ) !== $y || self::USE_YEAR ) {
			return $y;
		}
		return '';
	}

	/**
	 * Determine Capitalization
	 *
	 * @param string $the_value The value to check.
	 */
	protected function _capitalization( $the_value ) {

		if ( ( ( 'noon' === $the_value || 'midnight' === $the_value ) && self::CAPITALIZE_NOON ) || ( 'today' === $the_value && self::CAPITALIZE_TODAY ) ) {
			return ucfirst( $the_value );
		}
		return $the_value;
	}

	/**
	 * Format the date
	 *
	 * @param string $the_date The date to format.
	 */
	protected function _format_date( $the_date ) {

		$date_parts = explode( '|', $the_date );

		$month = $this->_month_string( $date_parts[1] );
		$year = $this->_year_string( $date_parts[0] );
		$year = ( '' === $year ) ? '' : ', ' . $year;

		// Determine whether the date is the current date and set the final output.
		if ( date( self::DATE_FORMAT ) === $the_date && self::USE_TODAY ) {
			return $this->_capitalization( 'today' );
		}
		return $month . ' ' . $date_parts[2] . $year;
	}

	/**
	 * Format the time
	 *
	 * @param string $the_time The time to format.
	 */
	protected function _format_time( $the_time ) {

		$time_parts = explode( '|', $the_time );

		// Reformat to noon and midnight.
		if ( '00:00' === $time_parts[0] . ':' . $time_parts[2] ) {
			return $this->_capitalization( 'noon' );
		} else if ( '12:00' === $time_parts[0] . ':' . $time_parts[2] ) {
			return $this->_capitalization( 'midnight' );
		}

		// Format am and pm to AP Style abbreviations.
		if ( 'am' === $time_parts[3] ) {
			$meridian = 'a.m.';
		} else {
			$meridian = 'p.m.';
		}

		// Eliminate trailing zeroes from times at the top of the hour and set final output.
		if ( '00' === $date_parts[2] ) {
			return $date_parts[1] . ' ' . $meridian;
		}

		return $time_parts[1] . ':' . $time_parts[2] . ' ' .$meridian;
	}

	/**
	 * Get the date of the post
	 *
	 * @param string  $the_date The date of the post.
	 * @param string  $d The date format.
	 * @param WP_POST $post The current post.
	 */
	public function get_the_date_filter( $the_date, $d = '', $post = null ) {

		if ( self::AP_STYLE !== $d ) {
			return $the_date;
		}

		$post = get_post( $post );

		if ( ! $post ) {
			return false;
		}

		return $this->_format_date( mysql2date( self::DATE_FORMAT, $post->post_date ) );
	}

	/**
	 * Get the time of the post
	 *
	 * @param string  $the_time The time of the post.
	 * @param string  $d The time format.
	 * @param WP_POST $post The current post.
	 */
	public function get_the_time_filter( $the_time, $d = '', $post = null ) {

		if ( self::AP_STYLE !== $d ) {
			return $the_time;
		}

		$post = get_post( $post );

		if ( ! $post ) {
			return false;
		}

		return $this->_format_time( get_post_time( self::TIME_FORMAT, false, $post, true ) );
	}

	/**
	 * Get the modified date of the post
	 *
	 * @param string $the_date The date to filter.
	 * @param string $d The date format.
	 */
	function get_the_modified_date_filter( $the_date, $d = '' ) {

		if ( self::AP_STYLE !== $d ) {
			return $the_date;
		}

		return $this->_format_date( get_post_modified_time( self::DATE_FORMAT, null, null, true ) );
	}

	/**
	 * Get the modified time of the post
	 *
	 * @param string $the_time The Time to filter.
	 * @param string $d The time format.
	 */
	function get_the_modified_time_filter( $the_time, $d = '' ) {

		if ( self::AP_STYLE !== $d ) {
			return $the_time;
		}

		return $this->_format_time( get_post_modified_time( self::TIME_FORMAT, null, null, true ) );
	}
}
