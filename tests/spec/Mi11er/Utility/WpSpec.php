<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WpSpec extends ObjectBehavior
{
	function it_is_initializable() {

		$this->shouldHaveType( 'Mi11er\Utility\Wp' );
				$this->shouldHaveType( 'Mi11er\Utility\Wp_Interface' );
	}
	function it_should_call_functions() {
		$this->is_int( 1 )->shouldReturn( true );
		$this->shouldThrow( '\BadFunctionCallException' )->duringnot_a_real_function();
	}
}
