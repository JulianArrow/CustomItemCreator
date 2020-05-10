<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.0.0
 */

class HTMLUtil
{
		public static function insertLink($href, $text)
		{
			echo '<a href="'.$href.'">'.$text.'</a>';
		}
		
		public static function includeStyle($fileName, $path = null, $fileExtension = null)
		{
			if ($path === null) {
				$path = '';
			}
			
			if ($fileExtension === null) {
				$fileExtension = '.css';
			}
			echo '<link rel="stylesheet" href="'.$path.$fileName.$fileExtension.'">';
		}
		
		public static function includeScript($fileName, $path = null, $fileExtension = null)
		{
			if ($path === null) {
				$path = '';
			}
			
			if ($fileExtension === null) {
				$fileExtension = '.js';
			}
			echo '<script type="text/javascript" src="'.$path.$fileName.$fileExtension.'"></script>';
		}
		
		public static function bootstrapAlert($text, $type = null)
		{
			if ($type === null) {
				$type = 'danger';
			}
			echo '<div style="margin: 4px 8px;" class="alert alert-'.$type.'" role="alert">'.$text.'</div>';
		}
}
