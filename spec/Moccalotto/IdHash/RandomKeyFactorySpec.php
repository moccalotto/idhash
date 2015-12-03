<?php

namespace spec\Moccalotto\IdHash;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RandomKeyFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Moccalotto\IdHash\RandomKeyFactory');
        $this->shouldImplement('Moccalotto\IdHash\Contracts\KeyFactory');
    }

    public function it_generates_keys_of_correct_type()
    {
        $this->shouldImplement('Moccalotto\IdHash\Contracts\KeyFactory');
        $this->key()->shouldHaveType('Moccalotto\IdHash\StringKey');
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

    public function it_is_initializable_with_custom_alphabet()
    {
        $this->beConstructedWith('abc');
        $this->shouldHaveType('Moccalotto\IdHash\RandomKeyFactory');
        $this->key()->keyString()->shouldHaveCharsFrom('abc');
    }

    public function it_has_sane_default_alphabet()
    {
        $this->key()->keyString()->shouldHaveCharsFrom('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    }

    public function it_randomizes_alphabet()
    {
        $this->key()->keyString()->shouldNotBe('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    }

    public function it_removes_duplicate_characters_from_alphabet()
    {
        $this->beConstructedWith('aaabbbccc');
        $this->key()->keyString()->shouldNotHaveCharsFrom('aaabbbccc');
        $this->key()->keyString()->shouldHaveCharsFrom('abc');
    }


    public function getMatchers()
    {
        return [
            'haveCharsFrom' => function ($subject, $string) {
                if (strlen($subject) !== strlen($string)) {
                    return false;
                }
                foreach (str_split($string) as $char) {
                    if (strpos($subject, $char) === false) {
                        return false;
                    }
                }
                return true;
            },
        ];
    }
}
