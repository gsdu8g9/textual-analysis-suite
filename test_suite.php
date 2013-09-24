<?php

include_once('lib/TextExtract.class');

define('DEBUG', false);
define('INPUT', 'input');
define('HTML', true);
define('THRESHHOLD', 6);



$string = "This is my string, now let Us test to see what it Does";


echo print_r(TextExtract::characterFrequency($string, false), true) . "\n";

echo TextExtract::capitals($string) . "\n";
echo TextExtract::firstLetters($string) . "\n";
echo TextExtract::firstLetters($string, false) . "\n";


