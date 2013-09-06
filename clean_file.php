<?php

define ( 'DEBUG', true );

if (! isset ( $argv [1] ))
{
    echo "You need to provide a filename on the command line\n";
    exit ();
}

if (! is_file ( $argv [1] ))
{
    echo "You need to provide a filename on the command line that is an actual file\n";
    exit ();
}

$contents = file_get_contents ( $argv [1] );

$line_ar = file ( $argv [1] );

$word_display = array ();

$verse = 0;

foreach ( $line_ar as $line )
{
    
    $line = trim ( $line );
    
    if (preg_match ( '/^\d+\./', $line ))
    {
        if (DEBUG)
        {
            echo "\n";
        }
        $verse = preg_replace ( '/\./', '', $line );
    }
    else
    {
        $words = makeWords ( $line );
        
        foreach ( $words as $word )
        {
            $clean_word = preg_replace ( '/\W+/', '', $word );
            
            if (! isset ( $word_display [strtolower ( $clean_word )] ))
            {
                $word_display [strtolower ( $clean_word )] = array ();
            }
            
            $_tmp = array ('verse' => $verse, 'word' => $word );
            
            $word_display [strtolower ( $clean_word )] [] = $_tmp;
        }
    
    }
    if (DEBUG)
    {
        echo $line . ' ';
    }

}

if (DEBUG)
{
    echo "\n\n";
}

if (false or ! DEBUG )
{
    
    ksort ( $word_display );
    
    foreach ( $word_display as $word => $instances )
    {
        echo sprintf ( '%20s', ucwords ( $word ) ) . ": ";
        
        $display = array ();
        
        foreach ( $instances as $_tmp )
        {
            
            if (preg_match ( '/^[A-Z]/', $_tmp ['word'] ))
            {
                $display [] = 'v' . $_tmp ['verse'] . '!';
            }
            else
            {
                $display [] = 'v' . $_tmp ['verse'];
            }
        
        }
        echo implode ( ', ', $display ) . "\n";
    
    }
    
    if (DEBUG)
    {
        echo print_r ( $word_display, true );
    }
}

exit ();

function makeWords($line)
{
    $words = explode ( ' ', $line );
    
    return $words;
}