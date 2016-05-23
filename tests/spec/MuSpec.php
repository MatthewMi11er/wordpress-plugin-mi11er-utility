<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MuSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Mi11er\Utility\Mu');
    }
}
