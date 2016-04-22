<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AutoloaderSpec extends ObjectBehavior
{
	function it_is_initializable() {
		$this->beConstructedWith( 'Mi11er\Utility\Autoloader' );
		$this->shouldHaveType( 'Mi11er\Utility\Autoloader' );
	}

	function it_checks_the_class_name_space_true() {
		$this->beConstructedWith( 'Mi11er\Utility\Autoloader' );
		$this->is_own_namespace()->shouldReturn(true);
	}

	function it_checks_the_class_name_space_false() {
		$this->beConstructedWith( 'Some\other\namespace\class' );
		$this->is_own_namespace()->shouldReturn(false);
	}

	function it_calculates_the_path() {
		$this->beConstructedWith( 'Mi11er\Utility\Autoloader' );
		$this->path()->shouldReturn( dirname( dirname( dirname( dirname( __DIR__ ) ) ) ) . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, [ 'includes', 'mi11er-utility', 'class-autoloader.php'] ) );
	}

	function it_loads_the_path_true() {
		$this->beConstructedWith( 'Mi11er\Utility\Autoloader' );
		$this->load()->shouldReturn( true );
	}
	
	function it_loads_the_path_false() {
		$this->beConstructedWith( 'Mi11er\Utility\Fake_Class' );
		$this->load()->shouldReturn( false );
	}
}
