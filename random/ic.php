<?php

$vin = 'vptzmdrttzysubxaykkwcjmgjmgpwreqeoiivppalrujtlrzpchljftupucywvsyiuuwufirtaxagfpaxzxjqnhbfjvqibxzpotciiaxahmevmmagyczpjxvtndyeuknulvvpbrptygzilbkeppyetvmgpxuknulvjhzdtgrgapygzrptymevppaxygkxwlvtiawlrdmipweqbhpqgngioirnxwhfvvawpjkglxamjewbwpvvmafnlojalh';
$sub = 'wmzfxtdhzfngfwxwnwxjevxdmzoxfkvxdmzowmkwmkfgzzexenfzpjotkebmnelozlfjpbzkofxwvjefxfwfjpfngfwxwnwxeszyzobdhkxewzawvmkokvwzopjoklxppzozewvxdmzowzawvmkokvwzoxwlxppzofpojtvkzfkovxdmzoxewmkwwmzvxdmzokhdmkgzwxfejwfxtdhbwmzkhdmkgzwfmxpwzlxwxfvjtdhzwzhbrntghzl';

$text = preg_split('//u', $vin, -1, PREG_SPLIT_NO_EMPTY);


// $text = $sub;

$alpha = 26;

$counts = array();
$totcount = 0;

for($i = 0; $i < $alpha ; $i++)
  {
    $counts[$i] = 0;
  }

foreach($text as $char)
  {
    $counts[ord($char) - 97]++;
    $totcount++;
  } 


$sum = 0;

for($i = 0; $i < $alpha; $i++)
  {
    $sum = $sum + $counts[$i] * ($counts[$i] -1 );
  }

$ic = $sum / ($totcount * ($totcount -1 ));

echo $ic . "\n";



?>