<?php

namespace Moccalotto\IdHash;

use Moccalotto\IdHash\Contracts\KeyFactory;
use DomainException;

/**
 * Class for creating a randomized StringKey.
 */
class RandomKeyFactory implements KeyFactory
{
    /**
     * @var string
     */
    const DEFAULT_KEYSPACE = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    protected $keyspace;

    /**
     * Remove duplicate characters from a given string
     *
     * @param string $string
     * @return string
     */
    protected function removeDuplicateCharacters($string)
    {
        return implode(
            array_unique(
                str_split($string)
            )
        );
    }

    /**
     * Constructor
     *
     * @param string $keyspace The letters in the keyspace.
     */
    public function __construct($keyspace = null)
    {
        if (null === $keyspace) {
            $keyspace = static::DEFAULT_KEYSPACE;
        }

        if (strlen($keyspace) < 2) {
            throw new DomainException('The input keyspace must have a length of at least 2');
        }

        $this->keyspace = $this->removeDuplicateCharacters($keyspace);
    }

    /**
     * Get a pseudo-randomized StringKey
     *
     * @return StringKey
     */
    public function key()
    {
        $keyspace = $this->keyspace;

        while ($keyspace === $this->keyspace) {
            $keyspace = str_shuffle($keyspace);
        }

        return new StringKey($keyspace);
    }
}
