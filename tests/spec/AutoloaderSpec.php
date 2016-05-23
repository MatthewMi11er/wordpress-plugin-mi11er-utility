<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AutoloaderSpec extends ObjectBehavior
{
	function it_is_initializable() {
		$this->shouldHaveType( 'Mi11er\Utility\Autoloader' );
	}

	function it_conditionally_loads_a_class_file() {
		$this::autoloader( 'Mi11er\Utility\Autoloader' )->shouldReturn( true );
		$this::autoloader( 'Mi11er\Utility\Face_Class' )->shouldReturn( false );
		$this::autoloader( 'Not\Our\Namespace\Class' )->shouldReturn( false );
	}
}
