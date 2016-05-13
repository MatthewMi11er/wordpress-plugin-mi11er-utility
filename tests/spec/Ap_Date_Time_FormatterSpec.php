<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use DateTime as Php_Date_Time;
use Mi11er\Utility\Ap_Date_Time_Formatter;

class Ap_Date_Time_FormatterSpec extends ObjectBehavior
{


	function it_is_initializable( $format, Php_Date_Time $compare_date ) {
		$format = Ap_Date_Time_Formatter::DATE;
		$this->beConstructedWith( $format, $compare_date );
		$this->shouldHaveType( 'Mi11er\Utility\Ap_Date_Time_Formatter' );
		$this->shouldHaveType( 'Mi11er\Utility\Date_Time_Formatter_Interface' );
	}

	function it_can_return_an_ap_style_date( $format, Php_Date_Time $compare_date ) {
		$format = Ap_Date_Time_Formatter::DATE;
		$compare_date = new Php_Date_Time( '2008-10-07' );
		$date = new Php_Date_Time( '2008-10-07' );
		$this->beConstructedWith( $format, $compare_date );

		$this->format( $date )->shouldReturn( 'today' );

		$compare_date->modify( '+2 day' );
		$this->format( $date )->shouldReturn( 'Tuesday' );

		$compare_date->modify( '-4 day' );
		$this->format( $date )->shouldReturn( 'Tuesday' );

		$compare_date->modify( '-1 month' );
		$this->format( $date )->shouldReturn( 'Oct. 7' );

		$compare_date->modify( '-1 year' );
		$this->format( $date )->shouldReturn( 'Oct. 7, 2008' );
	}

	function it_can_return_an_ap_style_time( $format, Php_Date_Time $compare_date ) {
		$format = Ap_Date_Time_Formatter::TIME;
		$compare_date = new Php_Date_Time();
		$date = new Php_Date_Time( '12:00' );

		$this->beConstructedWith( $format, $compare_date );

		$this->format( $date )->shouldReturn( 'noon' );

		$date->modify( '-12 hours' );
		$this->format( $date )->shouldReturn( 'midnight' );

		$date->modify( '+3 hours' );
		$this->format( $date )->shouldReturn( '3 a.m.' );

		$date->setTime( 18, 11 );
		$this->format( $date )->shouldReturn( '6:11 p.m.' );
	}

	function it_can_return_an_ap_style_date_time() {
		$format = Ap_Date_Time_Formatter::DATE_TIME;
		$compare_date = new Php_Date_Time( '2008-08-07 18:11:31' );
		$date = new Php_Date_Time( '2005-08-07 18:11:31' );

		$this->beConstructedWith( $format, $compare_date );

		$this->format( $date )->shouldReturn( 'Aug. 7, 2005 at 6:11 p.m.' );
	}

	function it_throws_and_exception_on_an_invalid_format() {
		$format = 'INVALID';
		$compare_date = new Php_Date_Time( '2008-08-07 18:11:31' );
		$date = new Php_Date_Time( '2005-08-07 18:11:31' );
				$this->beConstructedWith( $format, $compare_date );
				$this->shouldThrow( 'Mi11er\Utility\Exception\Date_Time\Invalid_Format_Exception' )->duringformat( $date );
	}
}
