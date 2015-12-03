<?php

namespace Moccalotto\IdHash\Contracts;

interface KeyFactory
{
    /**
     * Generate a new key
     *
     * @return Key
     */
    public function key();
}
