<?php

/*

adb forward tcp:50000 tcp:50000

 */


// Converts DMS ( Degrees / minutes / seconds ) 
// to decimal format longitude / latitude
function DMStoDEC($dms, $longlat){

	if($longlat == 'lattitude'){
		$deg = substr($dms, 0, 2);
		$min = substr($dms, 2, 8);
		$sec = '';
	}
	if($longlat == 'longitude'){
		$deg = substr($dms, 0, 3);
		$min = substr($dms, 3, 8);
		$sec='';
	}
	

    return $deg+((($min*60)+($sec))/3600);
}   

//Set timezone
date_default_timezone_set('Australia/Perth');

//Connect to GPS
$gps = fsockopen('localhost', 50000);

//Read data from GPS
while($gps)
{
  $buffer = fgets($gps);
  if(substr($buffer, 0, 6)=='$GPRMC')
    {
      echo $buffer."\n";
	
      $gprmc = explode(',',$buffer);
      $data['timestamp'] = strtotime('now');
      $data['sat_status'] = $gprmc[2];

      $data['lattitude_dms'] = $gprmc[3];
      $data['lattitude_decimal'] = DMStoDEC($gprmc[3],'lattitude');
      $data['lattitude_direction'] = $gprmc[4];
		
      $data['longitude_dms'] = $gprmc[5];
      $data['longitude_decimal'] = DMStoDEC($gprmc[5],'longitude');
      $data['longitude_direction'] = $gprmc[6];
		
      $data['speed_knots'] = $gprmc[7];

      $data['bearing'] = $gprmc[8];
		
      $data['google_map'] = 'http://maps.google.com/maps?q='.$data['lattitude_decimal'].','.$data['longitude_decimal'].'+(PHP Decoded)&iwloc=A';
	
      print_r($data);
      echo "\n\n";
      fclose($gps);
      break;
    }
}