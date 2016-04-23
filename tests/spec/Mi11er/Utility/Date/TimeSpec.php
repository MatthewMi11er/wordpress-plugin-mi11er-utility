<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Date_TimeSpec extends ObjectBehavior
{

	function it_is_initializable() {

		$this->shouldHaveType( 'Mi11er\Utility\Date_Time' );
	}

	function it_can_return_an_ap_style_date() {
		$this->beConstructedWith( '2008-10-07',null,'2008-10-07' );

		$this->format( 1 )->shouldReturn( 'today' );

		$this->modify( '+2 day' );
		$this->format( 1 )->shouldReturn( 'Thursday' );

		$this->modify( '-4 day' );
		$this->format( 1 )->shouldReturn( 'Sunday' );

		$this->modify( '-1 month' );
		$this->format( 1 )->shouldReturn( 'Sept. 5' );

		$this->modify( '-1 year' );
		$this->format( 1 )->shouldReturn( 'Sept. 5, 2007' );
	}

	function it_can_return_an_ap_style_time() {
		$this->beConstructedWith( '12:00' );
		$this->format( 2 )->shouldReturn( 'noon' );

		$this->modify( '-12 hours' );
		$this->format( 2 )->shouldReturn( 'midnight' );

		$this->modify( '+3 hours' );
		$this->format( 2 )->shouldReturn( '3 a.m.' );

		$this->setTime( 18, 11 );
		$this->format( 2 )->shouldReturn( '6:11 p.m.' );
	}

	function it_can_return_an_ap_style_date_time() {
		$this->beConstructedWith( '2005-08-07 18:11:31',null,'2008-08-07 18:11:31' );
		$this->format( 3 )->shouldReturn( 'Aug. 7, 2005 at 6:11 p.m.' );
	}

	function it_can_still_return_other_date_formats() {
		$this->beConstructedWith( '2005-08-07 18:11:31' );
		$this->format( 'Y-m-d H:i:s' )->shouldReturn( '2005-08-07 18:11:31' );
		$this->format( 8 )->shouldReturn( '' );
	}
}
