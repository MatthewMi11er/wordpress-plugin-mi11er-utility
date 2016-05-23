<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class File_HandlerSpec extends ObjectBehavior
{
	function it_is_initializable() {

		$this->shouldHaveType( 'Mi11er\Utility\File_Handler' );
	}
}
