<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.1.0
 */
 
class TextHelper 
{
	public static function generateText($pool, $length, $useStandardPools = true)
	{
		$standardPools = [
			'lowercaseletters' => 'abcdefghijklmnopqrstuvwxyz',
			'uppercaseletters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
			'letters' => 'abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
			'numbers' => '0123456789',
			'alphanumeric' => '0123456789'.'abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
		];
		if (array_key_exists($pool, $standardPools) && $useStandardPools === true) {
			$pool = $standardPools[$pool];
		}
		$text = '';
		for ($i = 0;$i < $length;$i++) {
			$randomNumber = rand(0, strlen($pool)-1);
			$text .= substr($pool, $randomNumber, 1);
		}
		
		return $text;
	}
	
	public static function encodeRand($str, $seed = 1234567) {
        mt_srand($seed);
        $out = array();
        for ($x=0, $l=strlen($str); $x<$l; $x++) {
            $out[$x] = (ord($str[$x]) * 3) + mt_rand(350, 16000);
        }
         
        mt_srand();
        return implode('-', $out);
    }
     
    public static function decodeRand($str, $seed = 1234567) {
        mt_srand($seed);
        $blocks = explode('-', $str);
        $out = array();
        foreach ($blocks as $block) {
            $ord = (intval($block) - mt_rand(350, 16000)) / 3;
            $out[] = chr($ord);
        }
         
        mt_srand();
        return implode('', $out);
    }
	
	public static function encrypt($string, $key) {
		return TextHelper::encodeRand($string);
	}
	
	public static function decrypt($string, $key) {
		return TextHelper::decodeRand($string);
	}
}
