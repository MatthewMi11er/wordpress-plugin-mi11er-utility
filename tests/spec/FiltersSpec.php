<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mi11er\Utility\Wp_Interface;

class FiltersSpec extends ObjectBehavior
{
	function let( Wp_Interface $wp ) {
		$this->beConstructedWith( $wp );
	}

	function it_is_initializable() {
		$this->shouldHaveType( 'Mi11er\Utility\Filters' );
	}

	function it_registers_filters() {
		$this->setup();
		$this->setup();
		$this->get_registered_filters()->shouldHaveCount( 3 );
	}
	
	function it_gets_activiated() {
		$this->activate()->shouldReturn( true );
	}
	
	function it_sets_the_https_local_ssl_verify_filter(Wp_Interface $wp) {
		$wp->WP_ENV = 'production';
		$this->https_local_ssl_verify_filter( true )->shouldReturn( true );
		$wp->WP_ENV = 'development';
		$this->https_local_ssl_verify_filter( true )->shouldReturn( false );
	}
}
