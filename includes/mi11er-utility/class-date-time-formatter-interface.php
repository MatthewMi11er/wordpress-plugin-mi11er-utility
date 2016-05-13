<?php
/**
 * Interface for Mi11er\Utility Date_Time_Formatter
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

use DateTimeInterface as Php_Date_Time_Interface;

interface Date_Time_Formatter_Interface
{

	/**
	 * Return the formatted Date/Time
	 *
	 * @param Php_Date_Time_Interface $date_time The date/time to format.
	 * @return string
	 */
	public function format( Php_Date_Time_Interface $date_time );
}
