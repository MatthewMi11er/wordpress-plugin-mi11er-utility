<?php
/**
 * Custom DateTime
 *
 * @package    Mi11er\Utility
 */

namespace Mi11er\Utility;

/**
 * Extends the builtin DateTime class with addtional features
 */
class Date_Time extends \DateTime
{
	/**
	 * FORMATERS:
	 * These cannot be combined with other format strings
	 */
	const AP_DATE       = 1;
	const AP_TIME       = 2;
	const AP_DATE_TIME  = 3;

	/**
	 * A string to compare to.
	 *
	 * @var string|DateTime
	 */
	protected $compare;
	/**
	 * The constructor
	 *
	 * @param string                    $time The time.
	 * @param \DateTimeZone             $timezone The timezone.
	 * @param string|\DateTimeInterface $compare A date to use for comparing.
	 */
	public function __construct( $time = 'now', $timezone = null, $compare = 'now' ) {
		$this->compare = $compare instanceof \DateTimeInterface ? $compare : new \DateTime( $compare );
		parent::__construct( $time, $timezone );
	}

	/**
	 * Returns the formated Date and/or Time.
	 *
	 * @param string|int $format The formatter.
	 * @return Date_Time
	 */
	public function format( $format ) {
		if ( ! is_int( $format ) ) {
			return parent::format( $format );
		}

		if ( ( self::AP_DATE_TIME & $format ) === self::AP_DATE_TIME ) {
			return $this->ap_date() . ' at ' . $this->ap_time( false );
		}
		if ( (self::AP_DATE & $format) === self::AP_DATE ) {
			return $this->ap_date();
		}
		if ( (self::AP_TIME & $format) === self::AP_TIME ) {
			return $this->ap_time();
		}
		return '';
	}

	/**
	 * Returns the ap formated date
	 *
	 * @return string
	 */
	protected function ap_date() {
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
		if ( $this->diff()->days === 0 ) {
			return 'today';
		}

		if ( $this->diff()->days < 7 ) {
			return parent::format( 'l' );
		}

			$date = $ap_months[ parent::format( 'm' ) ] . ' '. parent::format( 'j' );

		if ( parent::format( 'Y' ) === $this->compare->format( 'Y' ) ) {
			return $date;
		}

			return $date . ', ' . parent::format( 'Y' );
	}

	/**
	 * Returns the ap formated time
	 *
	 * @return string
	 */
	protected function ap_time() {
		$hour = parent::format( 'g' );
		$minute = parent::format( 'i' );
		$meridian = 'am' === parent::format( 'a' ) ? 'a.m.' : 'p.m.';
		if ( '00' === $minute ) {
			if ( '12' === $hour ) {
				return 'a.m.' === $meridian ? 'midnight' : 'noon';
			}
			return $hour . ' ' . $meridian;
		}
		return $hour . ':' . $minute . ' ' . $meridian;
	}

	/**
	 * Return difference between $this and $compare
	 *
	 * @param Datetime|String $compare The date to compare to.
	 * @param bool            $absolute Should the interval be forced to be positive.
	 * @return DateInterval
	 */
	public function diff( $compare = null, $absolute = false ) {
		if ( null === $compare ) {
			$compare = $this->compare;
		}
		return parent::diff( $compare, $absolute );
	}
}
