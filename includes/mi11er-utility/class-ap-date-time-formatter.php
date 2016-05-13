<?php
/**
 * Custom DateTime
 *
 * @package    Mi11er\Utility
 */

namespace Mi11er\Utility;

use DateTimeInterface as Php_Date_Time_Interface;
use Mi11er\Utility\Exception\Date_Time\Invalid_Format_Exception;
/**
 * Extends the builtin DateTime class with addtional features
 *
 * Features:
 * - AP Style formating
 *   {@see https://owl.english.purdue.edu/owl/resource/735/02/ }
 */
class Ap_Date_Time_Formatter implements Date_Time_Formatter_Interface
{
	const DATE      = 'AP_DATE';
	const TIME      = 'AP_TIME';
	const DATE_TIME = 'AP_DATE_TIME';
	/**
	 * The Constructor
	 *
	 * @param string                  $format. One of the preset formats this formater returns.
	 * @param Php_Date_Time_Interface $compare_date A date to compare to for relative output.
	 */
	public function __construct( $format, Php_Date_Time_Interface $compare_date ) {
		$this->format = $format;
		$this->compare_date = $compare_date;
	}

	/**
	 * Returns the formated Date and/or Time.
	 *
	 * @param Php_Date_Time_Interface $date The date to format.
	 * @return string
	 */
	public function format( Php_Date_Time_Interface $date ) {
		$this->date = $date;
		if ( self::DATE === $this->format ) {
			return $this->ap_date();
		}
		if ( self::TIME === $this->format ) {
			return $this->ap_time();
		}
		if ( self::DATE_TIME === $this->format ) {
			return $this->ap_date() . ' at ' . $this->ap_time();
		}
		throw new Invalid_Format_Exception();
	}
	/**
	 * Returns the ap formated date
	 *
	 * @return string
	 */
	private function ap_date() {

			/**
			 * The AP Style only allows
			 * abreviation of some months
			 * and those that can must be abreaviated a
			 * certain way.
			 */
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
			if ( $this->date->diff( $this->compare_date )->days === 0 ) {
				return 'today';
			}
			if ( $this->date->diff( $this->compare_date, true )->days < 7 ) {
				return $this->date->format( 'l' );
			}

				$formated_date = $ap_months[ $this->date->format( 'm' ) ] . ' '. $this->date->format( 'j' );

			if ( $this->date->format( 'Y' ) === $this->compare_date->format( 'Y' ) ) {
				return $formated_date;
			}

				return $formated_date . ', ' . $this->date->format( 'Y' );
	}

		/**
		 * Returns the ap formated time
		 *
		 * @return string
		 */
	private function ap_time() {
		$hour = $this->date->format( 'g' );
		$minute = $this->date->format( 'i' );
		$meridian = 'am' === $this->date->format( 'a' ) ? 'a.m.' : 'p.m.';
		if ( '00' === $minute ) {
			if ( '12' === $hour ) {
				return 'a.m.' === ( $meridian ) ? 'midnight' : 'noon';
			}
			return $hour . ' ' . $meridian;
		}
		return $hour . ':' . $minute . ' ' . $meridian;
	}
}
