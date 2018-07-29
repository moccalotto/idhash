<?php

namespace Moccalotto\IdHash;

use RuntimeException;
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
     * @param Key $key
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
        $q = bcadd((string) $number, '0', 0); // turn number into a bcmath compatible number
        $size = $this->keyLength;
        $space = $this->key;
        $result = '';

        while (bccomp($q, '0') === 1) {
            $remainder = (int) bcmod($q, (string) $size);
            $q = bcdiv($q, (string) $size); // automatic floor
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
        $result = '0';

        for ($i = 0; $i < $limit; ++$i) {
            $pos = strpos($space, $hash[$i]);

            /** @var string $pos */
            if ($pos === false) {
                throw new RuntimeException(sprintf(
                    'Invalid hash entity at pos %d (%s) not found in keyspace',
                    $i,
                    $hash[$i]
                ));
            }

            $result = bcadd(
                bcmul(
                    (string) $size,
                    $result
                ),
                (string) $pos
            );
        }

        return $result;
    }
}
