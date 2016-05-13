<?php
/**
 * Custom DateTime
 *
 * @package    Mi11er\Utility
 */

namespace Mi11er\Utility\Date_Time;

use DateTime as Php_Date_Time;
use DateTimeInterface as Php_Date_Time_Interface;

/**
 * Extends the builtin DateTime class with addtional features
 *
 * Features:
 * - AP Style formating
 *   {@see https://owl.english.purdue.edu/owl/resource/735/02/ }
 */
class Date_Time extends Php_Date_Time
{
	/**
	 * Returns the formated Date and/or Time.
	 *
	 * @param string|Date_Time_Formatter_Interface $format The formatter we want to use, or a php date format string.
	 * @return Date_Time
	 */
	public function format( $format ) {
		if ( $format instanceof Date_Time_Formatter_Interface ) {
			return $format->format( $this );
		}
		return parent::format( $format );
	}
}
