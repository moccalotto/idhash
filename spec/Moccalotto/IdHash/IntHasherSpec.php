<?php

namespace spec\Moccalotto\IdHash;

use PhpSpec\ObjectBehavior;
use Moccalotto\IdHash\StringKey;

class IntHasherSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new StringKey('fubar'));
        $this->shouldHaveType('Moccalotto\IdHash\IntHasher');
    }

    public function it_can_encode_an_integer()
    {
        $this->beConstructedWith(new StringKey('fubar'));
        $this->intToHash(666)->shouldBe('ufuau');
        $this->intToHash(1024)->shouldBe('uafrr');
    }

    public function it_can_decode_an_encoded_integer()
    {
        $this->beConstructedWith(new StringKey('fubar'));
        $this->hashToInt('ufuau')->shouldBe(666);
        $this->hashToInt('uafrr')->shouldBe(1024);
    }
}
