<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Template_TagsSpec extends ObjectBehavior
{
	function it_is_initializable() {

		$this->shouldHaveType( 'Mi11er\Utility\Template_Tags' );
	}
}
