<?php

namespace Moccalotto\IdHash;

use LogicException;
use InvalidArgumentException;
use Moccalotto\IdHash\StringKey;
use Moccalotto\IdHash\Contracts\Key;

/**
 * Facade for the IntHasher class.
 */
class IdHash
{
    /**
     * Default (singleton-style) key.
     *
     * @var Key
     */
    protected static $defaultKey;

    /**
     * Normalize a key.
     *
     * - An instance of Key will not be converted.
     * - A string will be converted to a StringKey.
     * - Other values will cause an InvalidArgumentException
     *
     * @param string|Key $key
     * @return Key
     *
     * @throws InvalidArgumentException if $key is not string or Key
     */
    protected static function normalizeStringKey($key)
    {
        if (is_string($key)) {
            $key = new StringKey($key);
        }

        if (!$key instanceof Key) {
            throw new InvalidArgumentException(sprintf(
                '$key must be a string or an instance of %s',
                Key::class
            ));
        }

        return $key;
    }

    /**
     * Create a hasher with a given key
     *
     * @param string|Key $key
     *
     * @return IntHasher
     */
    public static function with($key)
    {
        return new IntHasher(static::normalizeStringKey($key));
    }

    /**
     * Set the default key (singleton-style)
     *
     * @param string|Key $key
     */
    public static function defaultKey($key)
    {
        static::$defaultKey = static::normalizeStringKey($key);
    }

    /**
     * Use the default key to encode an integer into a hash.
     *
     * @param int|string $number
     *
     * @return string
     */
    public static function intToHash($number)
    {
        if (empty(static::$defaultKey)) {
            throw new LogicException('You have not yet initialized the default key');
        }
        return static::with(static::$defaultKey)->intToHash($number);
    }

    /**
     * Use default key to decode a hash into a number.
     *
     * @param string $hash
     *
     * @return string a string containing the number - the number may be too large for integers.
     */
    public static function hashToInt($hash)
    {
        if (empty(static::$defaultKey)) {
            throw new LogicException('You have not yet initialized the default key');
        }
        return static::with(static::$defaultKey)->hashToInt($hash);
    }
}
