<?php

function pre_print_r($var){
  echo "<pre>";
	print_r($var);
	echo "</pre>";
}


function Bigrams($word){
    $ngrams = array();
    $len = strlen($word);
    for($i=0;$i+1<$len;$i++){
        $ngrams[$i]=$word[$i].$word[$i+1];
    }
    return $ngrams;
}
pre_print_r(Bigrams("abcdefg"));



function Trigrams($word){
    $ngrams = array();
    $len = strlen($word);
    for($i=0;$i+2<$len;$i++){
        $ngrams[$i]=$word[$i].$word[$i+1].$word[$i+2];
    }
    return $ngrams;
}
pre_print_r(Trigrams("abcdefg"));



function Ngrams($word,$n=3){
    $len=strlen($word);
    $ngram=array();

    for($i=0;$i+$n<=$len;$i++){
        $string="";
        for($j=0;$j<$n;$j++){ 
            $string.=$word[$j+$i]; 
        }
        $ngram[$i]=$string;
    }
        return $ngram;
}

pre_print_r(Ngrams("abcdefg",1));


//http://phpir.com/language-detection-with-n-grams/
function getNgrams($word, $n = 3) {
        $ngrams = array();
        $len = strlen($word);
        for($i = 0; $i < $len; $i++) {
                if($i > ($n - 2)) {
                        $ng = '';
                        for($j = $n-1; $j >= 0; $j--) {
                                $ng .= $word[$i-$j];
                        }
                        $ngrams[] = $ng;
                }
        }
        return $ngrams;
}
pre_print_r(getNgrams('this is a set of words and let us see what the n-grams are. and what are we doing about these words', 2));
