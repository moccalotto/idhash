<?php

namespace Moccalotto\IdHash;

/**
 * Class for creating a randomized IdHash key.
 */
class RandomizedKey implements Contracts\Key
{
    /**
     * @var string
     */
    protected $defaultKey = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    /**
     * @var string
     */
    protected $key;

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
     * @param string $base The letters in the keyspace.
     */
    public function __construct($base = null)
    {
        $actual_key = $base === null ? $this->defaultKey : $base;

        $key_candidate = '';
        do {
            $key_candidate = str_shuffle($actual_key);
        } while ($key_candidate == $actual_key);

        $this->key = $this->removeDuplicateCharacters($key_candidate);
    }

    /**
     * Get the hash key as a string
     * @return string
     */
    public function keyString()
    {
        return $this->key;
    }

    /**
     * Get the number of characters in the key
     * @return integer
     */
    public function keylength()
    {
        return strlen($this->key);
    }

    /**
     * Get a new randomized key based on the same key space as $this
     *
     * @return RandomizedKey
     */
    public function another()
    {
        return new RandomizedKey($this->key);
    }
}
