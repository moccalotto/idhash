<?php

namespace Moccalotto\IntHash;

/**
 * Class for creating a randomized IntHash key.
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

        $this->key = str_shuffle(
            $this->removeDuplicateCharacters($actual_key)
        );
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