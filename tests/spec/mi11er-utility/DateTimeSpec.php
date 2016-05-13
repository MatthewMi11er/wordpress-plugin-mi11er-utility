<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mi11er\Utility\Date_Time_Formatter_Interface;

class Date_TimeSpec extends ObjectBehavior
{

	function it_is_initializable() {

		$this->shouldHaveType( 'Mi11er\Utility\Date_Time' );
		$this->shouldHaveType( '\DateTime' );
		$this->shouldHaveType( '\DateTimeInterface' );
	}

	function it_can_format_itself_with_a_php_format_string() {
		$this->beConstructedWith( '2008-10-08' );
		$this->format( 'Y-m-d' )->shouldReturn( '2008-10-07' );
	}

	function it_can_format_itself_with_a_custom_formatter( Date_Time_Formatter_Interface $formatter ) {
		$this->beConstructedWith( '12:00' );
		$formatter->format( $this )->willReturn( 'noon' );
		$this->format( $formatter )->shouldReturn( 'noon' );
	}
}
