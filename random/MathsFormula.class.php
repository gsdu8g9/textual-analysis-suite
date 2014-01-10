<?php


class MathsFormula
{
  public static function calculateHerons($a, $b, $c)
  {
    $s = self::semiperimeter($a, $b, $c);

    $_tmp = $s * ($s - $a) * ($s - $b) * ($s - $c);

    return sqrt($_tmp);
  }

/**

 */
  private static function semiperimeter($a, $b, $c)
  {
    return ($a + $b + $c) / 2;
  }


/**
   Work out the length of the third side of an isoslese triangle

square root of ( 2 x n squared x (1-cosA))
 */
  public function thirdSide($side_length, $angle_in_degrees)
  {
    $_tmp = 1 - cos(deg2rad($angle_in_radians)); // php returns this in radians

    return sqrt(2 * ($side_length * $side_length) * $_tmp);
  }

}


echo MathsFormula::calculateHerons(7, 4, 5) . "\n";

