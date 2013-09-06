<?php

define('DEBUG', false );
define('INPUT', 'input');
define('HTML', true);
define('THRESHHOLD', 6);



$ignore_array = array();

$ignore_array[] = 'and';
$ignore_array[] = 'a';
$ignore_array[] = 'an';
$ignore_array[] = 'are';
$ignore_array[] = 'as';
$ignore_array[] = 'be';
$ignore_array = array();


$capitals = array();
$characters = array();

$files = array();

if ($handle = opendir(INPUT)) 
{
    while (false !== ($entry = readdir($handle))) 
    {
        if ($entry != "." && $entry != "..") 
        {
            $files[] = $entry;
        }
    }
    closedir($handle);
}


asort($files);
$word_display = array ();
//LXV:I:1. I am the Heart; 
foreach($files as $file)
{
	$line_ar = file(INPUT . '/' . $file);

	foreach ( $line_ar as $line )
	{
		$line = trim ( $line );
		
		
		if (preg_match ( '/^([A-Z]+:[A-Z0]+:\d+)\.\s+(.+)/', $line, $matches ))
		{
			if( isset($matches[1]) and isset($matches[2]))
			{
				$verse = $matches[1];
				
				
				$capitals[$verse] = array('cap' => getCapitals($matches[2]), 'line' => $matches[2]);
				$characters[$verse] = array('chr' => getFirstLetters($matches[2]), 'line' => $matches[2]);
				
				$words = makeWords ( $matches[2] );
        
				foreach($words as $word)
				{
					$clean_word = preg_replace('/[^A-Za-z0-9-]/', '', $word);
					
					if( ! in_array($clean_word, $ignore_array) )
					{
					
						if( ! isset($word_display[strtolower($clean_word)]))
						{
							$word_display[strtolower($clean_word)] = array();
						}
						
						$_tmp = array('verse' => $verse, 'word' => $word);
						
						
						$word_display[strtolower($clean_word)][]  = $_tmp;
					}
				}
				
			}
			
		}

	}
}


ksort($word_display);


$letter = '';
$letter_current = '';

if (HTML )
{
	echo '<html><head><style TYPE="text/css"> ' . "\n";
	echo '/*DL, DT, DD TAGS LIST DATA*/
		dl {
		margin-bottom:50px;
	}
	 
	dl dt {
		background:#fff;
		color:#000;
		float:left;
		font-weight:bold;
		margin-right:10px;
		padding:5px; 
		width:250px;
	}
	 
	dl dd {
		margin:2px 0;
		margin-left: 265px;
		padding:5px 0;
	}';

	echo '</style></head></body>' . "\n\n";
	
	
	echo '<h1>Concordance</h1>' . "\n";
}



foreach($word_display as $word => $instances )
{

	$letter_current = substr(ucwords($word), 0, 1);
	
	if( $letter_current != $letter)
	{
		if( HTML )
		{
			echo "</dl>\n";
			echo '<h2>Character: ' . $letter_current . '</h2>' . "\n\n";
			
			echo "<dl>\n";
		}
		else
		{
			echo "\n\n" . '============= ' . $letter_current. '=============' . "\n\n";
		}
		$letter = $letter_current;
	}
	
	if( HTML )
		{
			$count = count($instances);
			
			if( $count > THRESHHOLD)
			{
				echo '<dt>' . ucwords($word). ' (' . $count . ')</dt>' . "\n";
			}
			else
			{
				echo '<dt>' . ucwords($word). '</dt>' . "\n";
			}
				
		}
	else
		{
			echo sprintf('%20s', ucwords($word)) . ": ";
		}
		
    
    $display = array();
    
    foreach($instances as $_tmp)
    {
        
		$string = $_tmp['verse'];
		
		
		
		
        
		
		if( preg_match('/!$/', $_tmp['word']))
        {
            $string =   $string . '!'; // store exclaimation marks
        }
		
		if( preg_match('/\?$/', $_tmp['word']))
        {
            $string =   $string . '?'; // store questions marks
        }
		
		if( preg_match('/^[A-Z]/', $_tmp['word']))
        {
			if( HTML )
			{
				$string =   '<strong>' . $string . '</strong>'; // bold uppercase (for now)
			}
			else
			{
				$string =   $string . '^'; // bold uppercase (for now)
			}
        }
        
        
		$display[] = $string;
    }
	if( HTML )
		{
			echo '<dd>' . implode(', ', $display). '</dd>' . "\n";
		}
		else
		{
			echo implode(', ', $display) . "\n";
		}
}

if (DEBUG)
{
    echo print_r($word_display, true);
}

if( HTML )
{
	echo "</dl>\n";
	echo '<h1>Word Analysis</h1>' . "\n";
	echo '<h2>Capitals</h2>' . "\n";
	echo "<dl>\n";
}

//ksort($capitals);
foreach($capitals as $verse => $line_array)
{
	if( HTML )
	{
		echo '<dt>' . $verse . '</dt>';
		echo '<dd>' . $line_array['cap'];
		//echo '  [[' . $line_array['line'] . ']]';


	echo  '</dd>';
	}
	else
	{
		echo  sprintf('%20s', ucwords($verse)) . ": " . $line_array['cap'] . ' [[' . $line_array['line']. ']]' . "\n";
	}

}

if( HTML )
{
	echo "</dl>\n";
	echo '<h2>First Letters</h2>' . "\n";
	echo "<dl>\n";
}


//ksort($characters);
foreach($characters as $verse => $line_array)
{
	if( HTML )
	{
		echo '<dt>' . $verse . '</dt>';
		echo '<dd>' . $line_array['chr'];
		//echo '  [[' . $line_array['line'] . ']]';


	echo  '</dd>';
	}
	else
	{
		echo  sprintf('%20s', ucwords($verse)) . ": " . $line_array['chr'] . ' [[' . $line_array['line']. ']]' . "\n";
	}

}

if( HTML )
{
	echo "</dl>\n";

}

exit ();

// ----------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------
//
// functions
//
// ----------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------

function getCapitals($line)
{
	return preg_replace('/[^A-Z]/', '', $line);
}
function getFirstLetters($line, $cap = true)
{
		
	preg_match_all("/(\S)\S*/i",$line,$array,PREG_PATTERN_ORDER);

	$return ='';	

	if( isset($array[1]))
	{
		$return =  implode('', $array[1]) . "\n";
	}

	if( $cap )
	{
		$return = strtoupper($return);
	}
	return $return;
	
}
function getCharacterCount($line)
{
	
}

function makeWords($line)
{
    $words = explode ( ' ', $line );
    
    return $words;
}