<?php

define('DEBUG', false);
define('INPUT', 'input');
define('HTML', true);
define('THRESHHOLD', 6);

// count_chars


$ignore_array = array();

$ignore_array [] = 'and';
$ignore_array [] = 'a';
$ignore_array [] = 'an';
$ignore_array [] = 'are';
$ignore_array [] = 'as';
$ignore_array [] = 'be';
$ignore_array = array();

$capitals = array();
$characters = array();

$files = array();

if ($handle = opendir(INPUT))
{
    while (false !== ($entry = readdir($handle)))
    {
        if ($entry != "." && $entry != ".." and preg_match('/ccxx-alt-/', $entry))
        //if ($entry != "." && $entry != ".." and preg_match ( '/ccxx-[123]-clean/', $entry ))
        //if ($entry != "." && $entry != ".." and preg_match ( '/lxv-/', $entry ))
        {
            $files [] = $entry;
        }
    }
    closedir($handle);
}

asort($files);

$_tmp_count = array();

$word_display = array();
//LXV:I:1. I am the Heart; 
foreach ($files as $file)
{
    $line_ar = file(INPUT . '/' . $file);

    foreach ($line_ar as $line)
    {
        $line = trim($line);

        if (preg_match('/^([A-Z]+:[A-Z0]+:\d+)\.\s+(.+)/', $line, $matches))
        {
            if (isset($matches [1]) and isset($matches [2]))
            {
                $verse = $matches [1];

                // http://php.net/manual/en/function.count-chars.php
                $_tmp_count [$verse] = count_chars($matches [2]);
            }
        }
    }
}

$character_count = array();
$character_count ['normal'] = array();
$character_count ['samecase'] = array();

$total_count = array('normal' => 0, 'samecase' => 0);

foreach ($_tmp_count as $verse => $_count_array)
{
    foreach ($_count_array as $chr_int => $val)
    {

        //if (preg_match('/[A-Za-z0-9]/', chr($chr_int)))
        if (preg_match('/[A-Za-z0-9]/', chr($chr_int)))
        {
            if (!isset($character_count ['normal'] [chr($chr_int)]))
            {
                $character_count ['normal'] [chr($chr_int)] = 0;
            }

            $character_count ['normal'] [chr($chr_int)] = $character_count ['normal'] [chr($chr_int)] + $val;

            $total_count['normal']++;
            
            if (!isset($character_count ['samecase'] [strtolower(chr($chr_int))]))
            {
                $character_count ['samecase'] [strtolower(chr($chr_int))] = 0;
            }

            $character_count ['samecase'] [strtolower(chr($chr_int))] = $character_count ['samecase'] [strtolower(chr($chr_int))] + $val;
            
            $total_count['samecase']++;
        }
        else
        {
            echo 
        }
    }
}

echo 'Clean case' . "\n\n";
foreach ($character_count['samecase'] as $character => $value)
{
    echo $character . ":" . number_format(($value / $total_count['samecase']) * 100, 2) . "%:" . `factor $value`;
}

echo "\n\n" . 'Original case' . "\n\n";

foreach ($character_count['normal'] as $character => $value)
{
    echo $character . ":" . number_format(($value / $total_count['samecase']) * 100, 2) . "%:" . `factor $value`;
}

//echo print_r ( $character_count, true ) . "\n";
exit();

// ----------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------
//
// functions
//
// ----------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------


function getCapitals($line) {
    return preg_replace('/[^A-Z]/', '', $line);
}

function getFirstLetters($line, $cap = true) {

    preg_match_all("/(\S)\S*/i", $line, $array, PREG_PATTERN_ORDER);

    $return = '';

    if (isset($array [1]))
    {
        $return = implode('', $array [1]) . "\n";
    }

    if ($cap)
    {
        $return = strtoupper($return);
    }
    return $return;
}

function getCharacterCount($line) {
    
}

function makeWords($line) {
    $words = explode(' ', $line);

    return $words;
}
