<?php

namespace spec\Moccalotto\IdHash;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StringKeySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('fubar');
        $this->shouldHaveType('Moccalotto\IdHash\StringKey');
    }

    function it_contains_the_correct_chars()
    {
        $this->beConstructedWith('fubar');
        $this->keyString()->shouldBe('fubar');
    }

    function it_detects_correct_key_length()
    {
        $this->beConstructedWith('fubar');
        $this->keyLength()->shouldBe(5);
    }
}
