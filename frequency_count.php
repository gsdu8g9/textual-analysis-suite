<?php
include_once('lib/TextExtract.class');

define('DEBUG', false);
define('INPUT', 'input');
define('HTML', true);
define('THRESHHOLD', 6);


$files = array();

if ($handle = opendir(INPUT))
{
    while (false !== ($entry = readdir($handle)))
    {
        if ($entry != "." && $entry != ".." and preg_match('/lxv-1-clean/', $entry))
        {
            $files [] = $entry;
        }
    }
    closedir($handle);
}

asort($files);


$lxv_string = '';

/**


 **/
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
	      $lxv_string = $lxv_string . $matches[2];
            }
        }
    }
}


echo $lxv_string . "\n";
$frequency_array = array();

$string = TextExtract::firstLetters($lxv_string, true);

$frequency_array = TextExtract::characterFrequency($string, false, false, false);

echo print_r($frequency_array, true) . "\n";


// now we want to draw it with scaling

$_tmp = array();

$alpha = 26;

for($i = 0; $i < $alpha; $i++)
  {
    $_tmp[strtoupper(chr($i + 97))] = 0;
  }


foreach($frequency_array['chars'] as $_chr => $_cnt)
  {
    $_tmp[$_chr] = number_format($_cnt / $frequency_array['total'], 5);
  }

echo print_r($_tmp, true) . "\n";

$rs = imagecreatetruecolor(800, 640);

$bg_c = imagecolorallocate($rs, 255, 255, 255);
$tx_c = imagecolorallocate($rs, 0, 0, 0);


imagefill($rs, 1, 1, $bg_c);

$position = 0;
$step = 29;
$width = 25;
$start = 20;
$height_y = 580;
$y_start = 20;

$max = max($_tmp);

$_value = $max * $height_y;

$scale = floor($height_y / $_value);

if( $scale < 1)
  {
    $scale = 1;
  }


foreach($_tmp as $_chr => $value)
  {
    $x1 = $start + ($position * $step);
    $x2 = $x1 + $width;
    $y1 = $height_y; // $y_start;
    $y2 = $y1 - ( ( $height_y * $value) * $scale);
    //    $y2 = $y1 + ( $height_y * $value );

    imagefilledrectangle($rs, $x1, $y1, $x2, $y2, $tx_c);

    imagestring($rs, 1, $x1 + ($width / 2) , $y1 + 10, $_chr, $tx_c);
    
    imagestringup($rs, 1, $x1 + ($width / 2) , 635, number_format($value * 100, 2) . '%', $tx_c);

    $position++;
  }

imagejpeg($rs, 'freq.jpg');
imagedestroy($rs);






