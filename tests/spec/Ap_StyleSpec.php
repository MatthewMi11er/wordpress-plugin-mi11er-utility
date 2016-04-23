<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mi11er\Utility\Wp_Interface;

class AP_StyleSpec extends ObjectBehavior
{
	function let( Wp_Interface $wp ) {
		$this->beConstructedWith( $wp );
	}
	function it_is_initializable() {

		$this->shouldHaveType( 'Mi11er\Utility\AP_Style' );
	}
}
