<?php

namespace spec\Moccalotto\IdHash;

use PhpSpec\ObjectBehavior;

class StringKeySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith('fubar');
        $this->shouldHaveType('Moccalotto\IdHash\StringKey');
    }

    public function it_implements_necessary_interfaces()
    {
        $this->beConstructedWith('fubar');
        $this->shouldImplement('Moccalotto\IdHash\Contracts\Key');
    }

    public function it_requires_a_keyspace_of_length_2_or_more()
    {
        $this->beConstructedWith('');
        $this->shouldThrow('DomainException')->duringInstantiation();

        $this->beConstructedWith('1');
        $this->shouldThrow('DomainException')->duringInstantiation();

        $this->beConstructedWith('01');
        $this->shouldNotThrow('DomainException')->duringInstantiation();
    }

    public function it_contains_the_correct_chars()
    {
        $this->beConstructedWith('fubar');
        $this->keyString()->shouldBe('fubar');
    }

    public function it_detects_correct_key_length()
    {
        $this->beConstructedWith('fubar');
        $this->keyLength()->shouldBe(5);
    }
}
