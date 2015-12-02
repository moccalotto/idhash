<?php

namespace spec\Moccalotto\IntHash;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RandomizedKeySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Moccalotto\IntHash\RandomizedKey');
    }

    function it_is_initializable_with_custom_alphabet()
    {
        $this->beConstructedWith('abc');
        $this->shouldHaveType('Moccalotto\IntHash\RandomizedKey');
        $this->keyString()->shouldHaveCharsFrom('abc');
    }

    function it_has_sane_default_alphabet()
    {
        $this->keyString()->shouldHaveCharsFrom('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    }

    function it_randomizes_alphabet()
    {
        $this->keyString()->shouldNotBe('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    }

    function it_removes_duplicate_characters_from_alphabet()
    {
        $this->beConstructedWith('aaabbbccc');
        $this->keyString()->shouldNotHaveCharsFrom('aaabbbccc');
        $this->keyString()->shouldHaveCharsFrom('abc');
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
