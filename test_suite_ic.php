<?php;

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


$string = TextExtract::firstLetters($lxv_string, true);

$string = 'MUSTC HANGE MEETI NGLOC ATION FROMB RIDGE TOUND ERPAS 
SSINC EENEM YAGEN TSARE BELIE VEDTO HAVEB EENAS SIGNE 
DTOWA TCHBR IDGES TOPME ETING TIMEU NCHAN GEDXX';

echo $string . "\n";

$string = 'Defend the east wall of the casWe also know the probabilities of characters occuring in normal english text. The chi-squared statistic uses counts, not probabilities. As a result we need to use the probabilities to calculate the expected count for each letter. If the letter E occurs with a proability of 0.127, we would expect it to occur 12.7 times in 100 characters. To calculate the expected count just multiply the probability by the length of the ciphertext. The cipher shown above is 162 characters, so we expect E to appear 162*0.127 = 20.57 times.tle';

echo print_r(TextExtract::chiSquared($string), true) . "\n";exit;

$ic = TextExtract::indexOfincidenceCoincidence($string);

echo $ic . "\n";


?>