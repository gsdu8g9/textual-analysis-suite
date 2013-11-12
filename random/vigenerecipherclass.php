<?php
/**
 * @author  : Chern Kuan GOH
 * @link    : http://chernkuan.blogspot.com/
 * @email   : chernkuangoh@gmail.com
 * @name    : Vigenere Cipher Class
 * @version : 2
 * @since   : 19 Dec 2010
 *            24 Dec 2010
 *              - Added final to certain functions
 *              - Rename constructor to default constructor (__construct)
 *              - Minor changes to variable casting
 * @uses    : Implement Vigenere Cipher
 *
 */
class Vigenere {

    //=========================================================
    // FIELDS
    //=========================================================
    /* @param String $mVigTable Vigenere table characters */
    public static $mVigTable;
    /* @param String $mKey Vigenere key */
    public static $mKey;
    /* @param Int $mMod Modulus (length of Vigenere table string above) */
    public static $mMod;

    //=========================================================
    // CONSTRUCTOR
    //=========================================================
    /**
     * @param String $mKey Vigenere Key
     * @param String $mVigTable Optional Character Table (Vigenere table)
     */
    final public function __construct($rKey = false, $rVigTable = false)
    {
        //If table not given, create table
        self::$mVigTable = $rVigTable ? $rVigTable : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';

        //Length of table
        self::$mMod = strlen(self::$mVigTable);

        //If no key, generate key
        self::$mKey = $rKey ? $rKey : self::generateKey();
    }

    //=========================================================
    // GETTERS
    //=========================================================
    /**
     * @uses: Get Vignere Key
     * @return <String> Key
     */
    final public function getKey()
    {
        return self::$mKey;
    }

    /**
     * @uses: Get Index Position in table
     * @return <int>
     */
    private function getVignereIndex($iPos)
    {
        return strpos(self::$mVigTable, $iPos); // todo: catch chars not in table
    }

    /**
     * @uses: Get Vignere Character in the table
     * @return <String>
     */
    private function getVignereChar($rVignereIndex)
    {
        (int)$iVignereIndex = $rVignereIndex;
        // include negative positions
        $iVignereIndex=$iVignereIndex>=0 ? $iVignereIndex : strlen(self::$mVigTable)+$iVignereIndex;
        return self::$mVigTable{$iVignereIndex};
    }


    //=========================================================
    // METHODS
    //=========================================================
    /**
     * @uses: Generates a random Vigenere Key
     * @return <String>
     */
    final public function generateKey()
    {
        self::$mKey = '';
        for ($i = 0; $i < self::$mMod; $i++) {
            self::$mKey .= self::$mVigTable{rand(0, self::$mMod)};
        }
        return self::$mKey;
    }

    /**
     * @uses: Encrypt Text with a key
     * @param <String> $rText
     * @param <String> $rKey
     * @return<String> $sEncryptValue
     * @example: No. of alphabet = 26
     *           Ciphertext(i) = [Key(i) + PlainText(i)] (mod 26)
     */
    final public function encrypt($rText, $rKey)
    {
        $sEncryptValue = '';
        $sKey  = (String)$rKey;
        $sText = (String)$rText;

        for($i = 0; $i < strlen($sText); $i++)
        {
            (int)$iText  = self::getVignereIndex($sText[$i]);
            (int)$iKey   = self::getVignereIndex(self::charAt($sKey, $i));

            $iEncryptIndex = ($iText+$iKey)%(self::$mMod);
            $iEncryptIndex = self::EnsureKeyValid($iEncryptIndex);
            $sEncryptValue .= self::getVignereChar($iEncryptIndex);
        }
        return $sEncryptValue;
    }

    /**
     * @uses: Encrypt Text with a key
     * @param <String> $rText
     * @param <String> $rKey
     * @param <int>    $rMod
     * @return<String> $sEncryptValue
     * @example: No. of alphabet = 26
     *           Ciphertext(i) = [Key(i) + PlainText(i)] (mod 26)
     */
    final public function encrypt2($rText, $rKey, $rMod)
    {
        (String)$sEncryptValue  = '';
        $sKey  = (String)$rKey;
        $sText = (String)$rText;
        $iMod  = (int)$rMod;

        for($i = 0; $i < strlen($sText); $i++)
        {
            (int)$iText  = self::getVignereIndex($sText[$i]);
            (int)$iKey   = self::getVignereIndex(self::charAt($sKey, $i));

            $iEncryptIndex = ($iText+$iKey)%($iMod);
            $iEncryptIndex = self::EnsureKeyValid($iEncryptIndex);
            $sEncryptValue .= self::getVignereChar($iEncryptIndex);
        }
        return $sEncryptValue;
    }

    /**
     * @uses: Decrypt Text with the key used to encrypt
     * @param <String> $rText
     * @param <String> $rKey
     * @return<String> $sDecrytValue
     * @example: No. of alphabet = 26
     *           PlainText(i) = [Ciphertext(i)-Key(i)] (mod 26)
     */
    final public function decrypt($rText, $rKey)
    {
        (String)$sDecryptValue = '';
        $sKey  = (String)$rKey;
        $sText = (String)$rText;

        for($i = 0; $i < strlen($sText); $i++)
        {
            (int)$iText  = self::getVignereIndex($sText[$i]);
            (int)$iKey   = self::getVignereIndex(self::charAt($sKey, $i));

            $iDecryptIndex = ($iText-$iKey)%(self::$mMod);
            $iDecryptIndex  = self::EnsureKeyValid($iDecryptIndex);

            $sDecryptValue .= self::getVignereChar($iDecryptIndex);
        }
        return $sDecryptValue;
    }
    /**
     * @uses: Decrypt Text with the key used to encrypt
     * @param <String> $rText
     * @param <String> $rKey
     * @param <int>    $rMod
     * @return<String> $sDecrytValue
     * @example: No. of alphabet = 26
     *           PlainText(i) = [Ciphertext(i)-Key(i)] (mod 26)
     */
    final public function decrypt2($rText, $rKey, $rMod)
    {
        (String)$sDecryptValue  = '';
        $sKey  = (String)$rKey;
        $sText = (String)$rText;
        $iMod  = (int)$rMod;

        for($i = 0; $i < strlen($sText); $i++)
        {
            (int)$iText  = self::getVignereIndex($sText[$i]);
            (int)$iKey   = self::getVignereIndex(self::charAt($sKey, $i));


            $iDecryptIndex  = ($iText-$iKey)%($iMod);
            $iDecryptIndex  = self::EnsureKeyValid($iDecryptIndex);

            $sDecryptValue .= self::getVignereChar($iDecryptIndex);
        }
        return $sDecryptValue;
    }

    /**
     * @uses: Returns a Char at the string position
     * @param <String>  $rStr
     * @param <int>     $rPos
     * @return <String> $sStr{$iPos}
     * @example: $rStr = lemon, $iPos= 6, return $rStr{6} = e;
     */
    private function charAt($rStr, $rPos)
    {
        $iPos = (int)$rPos%strlen((String)$rStr);

        return $rStr{$iPos};
    }

    private function EnsureKeyValid($rIndex)
    {
        $iIndex = (int)$rIndex;
        return ($iIndex >= 0) ? $iIndex : (strlen(self::$mVigTable)+$iIndex);
    }

}


?>