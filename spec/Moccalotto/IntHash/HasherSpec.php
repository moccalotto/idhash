<?php

namespace spec\Moccalotto\IntHash;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Moccalotto\IntHash\StringKey;

class HasherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(new StringKey('fubar'));
        $this->shouldHaveType('Moccalotto\IntHash\Hasher');
    }

    function it_can_encode_an_integer()
    {
        $this->beConstructedWith(new StringKey('fubar'));
        $this->intToHash(666)->shouldBe('ufuau');
        $this->intToHash(1024)->shouldBe('uafrr');
    }

    function it_can_decode_an_encoded_integer()
    {
        $this->beConstructedWith(new StringKey('fubar'));
        $this->hashToInt('ufuau')->shouldBe(666);
        $this->hashToInt('uafrr')->shouldBe(1024);
    }
}
