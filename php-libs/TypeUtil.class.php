<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.0.1
 */

class TypeUtil
{
	public static function checkType($variable, $type)
	{
		switch ($type) {
			case 'alphanumeric':
				if (preg_match('/^[a-zA-Z0-9]+$/', $variable))
					return true;
				break;
			case 'positivenumber':
				if (preg_match('/^[0-9]+$/', $variable) && (int)$variable > 0)
					return true;
				break;
		}
		return false;
	}
}
