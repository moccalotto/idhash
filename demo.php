<?php

use Moccalotto\IntHash\Hasher;
use Moccalotto\IntHash\StringKey;

require 'vendor/autoload.php';

// you can generate a randomized base62 key by running bin/random_key
$key = '8w2JUNlFLxfuCXbjkOmBizsWHG9Ep5n4Pd70yZg63vAerQVTMIRhS1DKqocaYt';

// initialize a new hasher
$hasher = new Hasher(new StringKey($key));

// generate new input value
$input_int = mt_rand();

// encode the integer into a hash
$hash_str = $hasher->intToHash($input_int);

// decode the hash into an integer
$output_int = $hasher->hashToInt($hash_str);

// print the process values to screen
printf('Number to encode:   %d%s', $input_int, PHP_EOL);
printf('The encoded hash:   %s%s', $hash_str, PHP_EOL);
printf('Decoded number:     %s%s', $output_int, PHP_EOL);
printf('Success:            %s%s', $input_int === $output_int ? 'Yes' : 'NO!', PHP_EOL);

die($input_int !== $output_int);
