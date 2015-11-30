<?php

namespace Moccalotto\IntHash\Contracts;

interface Key
{
    /**
     * Get the hash key as a string
     * @return string
     */
    public function keyString();

    /**
     * Get the number of characters in the key
     * @return integer
     */
    public function keyLength();
}
