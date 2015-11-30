<?php

namespace Moccalotto\IntHash;

use DomainException;

/**
 * Class for creating a IntHash key from a string
 */
class StringKey implements Contracts\Key
{
    /**
     * @var string
     */
    protected $key;

    /**
     * Detect duplicate characters in a given string
     *
     * @param string $string
     * @return bool
     */
    protected function hasDuplicateChars($string)
    {
        $string_array = str_split($string);
        $unique_array = array_unique($string_array);

        return count($string_array) !== count($unique_array);
    }

    /**
     * Constructor
     *
     * @param string $key The letters in the keyspace.
     * @throws DomainException if the input key contains duplicate characters.
     */
    public function __construct($key)
    {
        if ($this->hasDuplicateChars($key)) {
            throw new DomainException('The input key contains duplicate characters');
        }
        $this->key = $key;
    }

    /**
     * Get the hash key as a string
     *
     * @return string
     */
    public function keyString()
    {
        return $this->key;
    }

    /**
     * Get the number of characters in the key
     *
     * @return integer
     */
    public function keylength()
    {
        return strlen($this->key);
    }
}