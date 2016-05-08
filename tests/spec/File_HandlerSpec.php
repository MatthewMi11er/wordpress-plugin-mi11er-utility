<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mi11er\Utility\Wp_Interface;

class File_HandlerSpec extends ObjectBehavior
{
	function let( Wp_Interface $wp ) {
		\spec\Mi11er\Utility\Wp_Mock_Registry::instance($wp)->define('Mi11er\Utility','add_action');
		\spec\Mi11er\Utility\Wp_Mock_Registry::instance()->define('Mi11er\Utility','add_filter');
				$wp->add_action(Argument::cetera())->willReturn('test');
				$wp->add_filter(Argument::cetera())->willReturn('test');
	}

	function it_is_initializable() {
		$this->shouldHaveType( 'Mi11er\Utility\File_Handler' );
	}

	function it_registers_filters_and_actions(Wp_Interface $wp ) {
		
		$this->setup();
		$this->setup();
		$this->get_registered_filters()->shouldHaveCount( 3 );
		$this->get_registered_actions()->shouldHaveCount( 1 );
	}

	function it_gets_activiated() {
		$this->activate()->shouldReturn( true );
	}

	function if_filters_redirect_canonical() {
		//$this->redirect_canonical_filter
	}
}
