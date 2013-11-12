<?php
#Include the class
require_once 'classVigenere.php';

#Istance theclass
$cVigenere = new classVigenere('THISismykey');
?>
<style>
    pre {
        border: 1px solid gray;
        background-color: #F9F9F9;
    }
</style>
<h1>classVigenere</h1>
<p>
    I'll try to encrypt the string 'You want to be an american idiot nanananaaaaaaanananananana'.<br/>
    Here is the code i used for this page:
    <pre>
        <code>
        &lt;?php
            #Include the class
            require_once 'classVigenere.php';

            #Istance theclass
            $cVigenere = new classVigenere('THISismykey');
            
            #Print the table to see how this class encrypt your text
            $cVigenere-&gt;printTable();

            echo "&lt;br/&gt;&lt;br/&gt;";
            
            #Encode my text
            $encoded_text = $cVigenere-&gt;encrypt('You want to be an american idiot nanananaaaaaaanananananana');

            echo 'Encrypted text -&gt; '. $encoded_text;
            echo "&lt;br/&gt;&lt;br/&gt;";
            
            #Decode my text
            echo 'Decrypted text -&gt; '. $cVigenere-&gt;decrypt($encoded_text);
        ?&gt;
        </code>
    </pre>
    First, i print the encryption table: 
</p>
<?php

#Print the table to see how this class encrypt your text
$cVigenere->printTable();

echo "<br/><br/>";
?>
<p>
    Now, i encrypt the string 'You want to be an american idiot nanananaaaaaaanananananana'
</p>
<?php
#Encode my text
$encoded_text = $cVigenere->encrypt('You want to be an american idiot nanananaaaaaaanananananana');

echo 'Encrypted text -> '. $encoded_text;
echo "<br/><br/>";
?>
<p>
    And now, i decrypt the encoded text '<?php echo $encoded_text; ?>'.
</p>
<?php
#Decode my text
echo 'Decrypted text -> '. $cVigenere->decrypt($encoded_text);

?>