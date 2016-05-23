<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Site_IconsSpec extends ObjectBehavior
{
	function it_is_initializable() {

		$this->shouldHaveType( 'Mi11er\Utility\Site_Icons' );
	}
}
