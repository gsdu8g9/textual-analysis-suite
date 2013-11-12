<?php

require_once("VigenereCipherClass.php");
// test 1
$text = 'attackatdawn';
$key = 'lemon';

$Vigenere = new Vigenere($key);
$enctext =  $Vigenere->encrypt($text,$key);

$plaintext = $Vigenere->decrypt($enctext,$key);

echo $text.' = '.$enctext.' = '.$plaintext.'<br />';

?>
