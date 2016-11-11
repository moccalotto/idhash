<?php

use Moccalotto\IdHash\IdHash;
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


// generate new input value
$input_int = bcmul(mt_rand(2**60, 2**62), mt_rand());

// encode the integer into a hash
$hash_str = IdHash::with($key)->intToHash($input_int);

// decode the hash into an integer
$output_int = IdHash::with($key)->hashToInt($hash_str);

// print the process values to screen
printf('The generated key:  %s%s', $key->keyString(), PHP_EOL);
printf('Number to encode:   %s%s', $input_int, PHP_EOL);
printf('Decoded number:     %s%s', $output_int, PHP_EOL);
printf('The encoded hash:   %s%s', $hash_str, PHP_EOL);
printf('Success:            %s%s', $input_int === $output_int ? 'Yes' : 'NO!', PHP_EOL);

die($input_int !== $output_int);
