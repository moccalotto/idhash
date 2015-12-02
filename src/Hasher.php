<?php

namespace Moccalotto\IdHash;

use Moccalotto\IdHash\Contracts\Key;

/**
 * Integer Hasher class
 */
class Hasher
{
    /**
     * The base key string.
     *
     * @var string
     */
    protected $key;

    /**
     * The number of bytes in $key.
     *
     * @var int
     */
    protected $keyLength;

    /**
     * @param string $key
     */
    public function __construct(Key $key)
    {
        $this->key = $key->keyString();
        $this->keyLength = $key->keyLength();
    }

    /**
     * Encode an integer to a hash.
     *
     * @param int $number
     *
     * @return string
     */
    public function intToHash($number)
    {
        $q = (int) $number;
        $size = $this->keyLength;
        $space = $this->key;
        $result = '';

        while ($q > 0) {
            $remainder = $q % $size;
            $q = floor($q / $size);
            $result = $space[$remainder] . $result;
        }

        return $result;
    }

    /**
     * Decode a hash to an integer.
     *
     * @param string $hash
     *
     * @return int
     */
    public function hashToInt($hash)
    {
        $size = $this->keyLength;
        $space = $this->key;
        $limit = strlen($hash);
        $result = 0;

        for ($i = 0; $i < $limit; ++$i) {
            $result = $size * $result + strpos($space, $hash[$i]);
        }

        return $result;
    }
}
