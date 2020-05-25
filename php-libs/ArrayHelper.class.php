<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.0.1
 */
 
class ArrayHelper
{
	public static function removeNumericalKeys(&$array)
	{
		
		for ($i = 0;$i <= max(array_keys($array));$i++) {
			if (isset($array[$i]))
				unset($array[$i]);
		}
	}
	
	public static function clearArray(&$array, $whitelist)
	{
		$whitelist = array_flip($whitelist);
		$array = array_intersect_key($array, $whitelist);
	}
}
