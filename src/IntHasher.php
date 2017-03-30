<?php

namespace Moccalotto\IdHash;

use Moccalotto\IdHash\Contracts\Key;

/**
 * Integer IntHasher class.
 */
class IntHasher implements Contracts\IntHasher
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
     * Constructor.
     *
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
     * @param int|string $number
     *
     * @return string
     */
    public function intToHash($number)
    {
        $q = bcadd($number, 0, 0); // turn number into a bcmath compatible number
        $size = $this->keyLength;
        $space = $this->key;
        $result = '';

        while (bccomp($q, 0) === 1) {
            $remainder = bcmod($q, $size);
            $q = bcdiv($q, $size); // automatic floor
            $result = $space[$remainder] . $result;
        }

        return $result;
    }

    /**
     * Decode a hash to an integer.
     *
     * @param string $hash
     *
     * @return string The decoded number.
     *                Caveat: the number may be too large to be converted into an integer.
     *                Be sure to check the size of the number against PHP_INT_MAX if you
     *                want to do integer math on the number.
     */
    public function hashToInt($hash)
    {
        $size = $this->keyLength;
        $space = $this->key;
        $limit = strlen($hash);
        $result = 0;

        for ($i = 0; $i < $limit; ++$i) {
            $result = bcadd(
                bcmul($size, $result),
                strpos($space, $hash[$i])
            );
        }

        return $result;
    }
}
