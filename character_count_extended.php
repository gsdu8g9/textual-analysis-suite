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

//define('FILE_MATCH', 'ccxx-\d');
define('FILE_MATCH', 'stele');

if ($handle = opendir(INPUT))
{
    while (false !== ($entry = readdir($handle)))
    {
        
        if ($entry != "." && $entry != ".." and preg_match('/' . FILE_MATCH . '/', $entry))
        //if ($entry != "." && $entry != ".." and preg_match ( '/ccxx-[123]-clean/', $entry ))
        //if ($entry != "." && $entry != ".." and preg_match ( '/lxv-/', $entry ))
        {
            echo 'Checking: ' . $entry . "\n";
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
//                $_tmp_count [$verse] = count_chars($matches [2]);
//                echo $matches [2] ."\n";
//                echo print_r(count_chars_unicode($matches [2]), true) . "\n";exit;
                $_tmp_count [$verse] =  count_chars_unicode($matches [2], true);
            }
        }
    }
}

$character_count = array();
$character_count ['normal'] = array();
$character_count ['samecase'] = array();
//echo print_r($_tmp_count, true) . "\n";exit;
$total_count = array('normal' => 0, 'samecase' => 0);

foreach ($_tmp_count as $verse => $_count_array)
{
    foreach ($_count_array as $chr_int => $val)
    {

//        if (true or preg_match('/[A-Za-z0-9]/', chr($chr_int)))
        if( true and ! preg_match('/\s+/',$chr_int) and removeSilly($chr_int))
        {
            if (!isset($character_count ['normal'] [$chr_int]))
            {
                $character_count ['normal'] [$chr_int] = 0;
            }

            $character_count ['normal'] [$chr_int] = $character_count ['normal'] [$chr_int] + $val;

            $total_count['normal'] = $total_count['normal']  + $val;
            
            if (!isset($character_count ['samecase'] [strtolower($chr_int)]))
            {
                $character_count ['samecase'] [strtolower($chr_int)] = 0;
            }

            $character_count ['samecase'] [strtolower($chr_int)] = $character_count ['samecase'] [strtolower($chr_int)] + $val;
            
            $total_count['samecase'] = $total_count['samecase']  + $val;
        }
    }
}


define('SEP', '|');
echo 'Clean case' . "\n\n";
ksort($character_count['samecase']);
foreach ($character_count['samecase'] as $character => $value)
{
    displayOuput($character, $value, $total_count['samecase']);
}

echo "\n\n" . 'Original case' . "\n\n";
ksort($character_count['normal']);
foreach ($character_count['normal'] as $character => $value)
{
    displayOuput($character, $value, $total_count['normal']);
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

function removeSilly($chr)
{
    if($chr == '[' or $chr == ']')
    {
        return false;
    }
    
    if($chr == '(' or $chr == ')')
    {
        return false;
    }
    
    return true;
}

function displayOuput($chr, $cnt, $total)
{
    echo sprintf('%5s', $chr);
    echo SEP;
    echo sprintf('%8s', number_format(($cnt / $total) * 100, 2) . "%");
    echo SEP ;
    echo `factor $cnt | sed 's/:/|/'`;
}
/*
 * 
 * 
 *   
        if( ! ctype_punct($chr_int) and ctype_graph($chr_int))
        {
            echo $chr_int;
        }
        if( false and ! ctype_punct($chr_int) and ctype_graph($chr_int))
 */

function count_chars_unicode($str, $x = false) {
    $tmp = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($tmp as $c) {
        $chr[$c] = isset($chr[$c]) ? $chr[$c] + 1 : 1;
    }
    return is_bool($x)
        ? ($x ? $chr : count($chr))
        : $chr[$x];
}

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
