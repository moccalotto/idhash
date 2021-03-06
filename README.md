# IdHash
[![Build Status](https://travis-ci.org/moccalotto/idhash.svg)](https://travis-ci.org/moccalotto/idhash)

A reversible (integer) ID obfuscator

Create hashes like the ones used by imgur, pastebin, youtube, etc.

Default keyspace is the standard base62 keyspace.

## Installation

To add this package as a local, per-project dependency to your project, simply add a dependency on
 `moccalotto/idhash` to your project's `composer.json` file like so:

```json
{
    "require": {
        "moccalotto/idhash": "~0.9"
    }
}
```

Alternatively simply call `composer require moccalotto/idhash`



```php
<?php

use Moccalotto\IdHash\IntHasher;
use Moccalotto\IdHash\StringKey;
use Moccalotto\IdHash\RandomKeyFactory;

require 'vendor/autoload.php';

// you can generate a randomized base62 key by running bin/random_key
$keyspace = '8w2JUNlFLxfuCXbjkOmBizsWHG9Ep5n4Pd70yZg63vAerQVTMIRhS1DKqocaYt';

// Create a key shuffler
// This is roughly the same as $key = str_shuffle($keyspace),
// but it guarantees that the output keyspace is different from the input keyspace
// It also ensures that we squash duplicate characters
$key_generator = new RandomKeyFactory($keyspace);

// generate a random key
$key = $key_generator->key();

// initialize a new IntHasher
$IntHasher = new IntHasher($key);

// generate new input value
$input_int = mt_rand();

// encode the integer into a hash
$hash_str = $IntHasher->intToHash($input_int);

// decode the hash into an integer
$output_int = $IntHasher->hashToInt($hash_str);

// print the process values to screen
printf('The generated key:  %s%s', $key->keyString(), PHP_EOL);
printf('Number to encode:   %d%s', $input_int, PHP_EOL);
printf('The encoded hash:   %s%s', $hash_str, PHP_EOL);
printf('Decoded number:     %s%s', $output_int, PHP_EOL);
printf('Success:            %s%s', $input_int === $output_int ? 'Yes' : 'NO!', PHP_EOL);

die($input_int !== $output_int);
```
