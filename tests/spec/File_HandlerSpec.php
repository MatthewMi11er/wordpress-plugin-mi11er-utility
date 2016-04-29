<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mi11er\Utility\Wp_Interface;

class File_HandlerSpec extends ObjectBehavior
{
	function let( Wp_Interface $wp ) {
		$this->beConstructedWith( $wp );
	}

	function it_is_initializable() {
		$this->shouldHaveType( 'Mi11er\Utility\File_Handler' );
	}

	function it_registers_filters_and_actions() {
		$this->setup();
		$this->setup();
		$this->get_registered_filters()->shouldHaveCount( 3 );
		$this->get_registered_actions()->shouldHaveCount( 1 );
	}

	function it_gets_activiated() {
		$this->activate()->shouldReturn( true );
	}

	function if_filters_redirect_canonical() {
		$this->redirect_canonical_filter
	}
}
