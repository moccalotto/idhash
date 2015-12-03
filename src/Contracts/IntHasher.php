<?php

namespace Moccalotto\IdHash\Contracts;

interface IntHasher
{
    /**
     * Encode an integer to a hash.
     *
     * @param int $number
     *
     * @return string
     */
    public function intToHash($number);

    /**
     * Decode a hash to an integer.
     *
     * @param string $hash
     *
     * @return int
     */
    public function hashToInt($hash);
}
