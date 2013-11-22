<?php
  $showTable = false;
  if (isset($_POST['submitx'])) {
    $showTable = true;
    $ciphertext = strtoupper($_POST['ciphertext']);
    // compress out spaces
    $i = 0;
    $cols = 10; 
    $cells = 1; 
    $compressed = '';
    while ( $ciphertext[ $i ])
    {
        if (( $ciphertext[ $i ] >= 'A' ) && ( $ciphertext[ $i ] <= 'Z' ) ) {
            $compressed .= $ciphertext[ $i ];
        }
        $i++;
    }
    $inLen = strlen( $compressed );

    // text is now collected without spaces in $compressed
    $history=array_fill(0,99,0);
    for ($shift = 1; $shift < 100; $shift++ ) {

        // test coincidence at this shift
        $coinc = 0;
        for ( $i = 0; $compressed[ $i + $shift ]; $i++ ) {
            if ( $compressed[ $i ] == $compressed[ $i + $shift ] ) $coinc++;
        }
        $coef = 100.0 * $coinc / ( 3.85 * ($inLen - $shift));
        $history[ $shift ] = $coef;
    }
      for ( $keyLen = 1; $keyLen < 50; $keyLen++ ) {
        $freqSum = 0.0;
        $index = $keyLen;
        $count = 0;
        while ( $index < 100 ) {
            // step through the history array by stepsize = keyLen
            $freqSum += $history[ $index ];
            $count++;
            $index += $keyLen;
        }
        $freqSum = $freqSum / $count; // average of all the values
        $history[ $index ] = $freqSum; // put it back for later
    }
    }
?>