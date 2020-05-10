<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.0.1
 */
 
class TemplateHelper
{
	private static $tplPath;
	private static $tplExtension;
	private static $absolutePath;
	
	public function __construct($tplPath, $tplExtension, $absolutePath) 
	{
		TemplateHelper::$tplPath = $tplPath;
		TemplateHelper::$tplExtension = $tplExtension;
		TemplateHelper::$absolutePath = $absolutePath;
	}
	
	public static function getTpl($tplName, $prefix = null)
	{
		if ($prefix === null) {
			$prefix = '';
		}
		if (TemplateHelper::$tplPath === null || TemplateHelper::$tplExtension === null)
			return false;
		include_once(TemplateHelper::$absolutePath.'/'.TemplateHelper::$tplPath.'/'.$prefix.$tplName.TemplateHelper::$tplExtension);
	}
}
