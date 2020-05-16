<?php
/**
 * @author Julian Pfeil
 * @version 1.0.0
 */
 
require_once('../php-libs/HTMLUtil.class.php');
HTMLUtil::includeStyle('bootstrap', '../3rdParty/', '.min.css');

#login
if (!isset($_GET['pw']) || md5($_GET['pw']) != 'e458a709ef6ab4cbf4ad187b547f7d6d') 
	die(HTMLUtil::bootstrapAlert('wrong password'));
 
require_once('../dbconfig.inc.php');
require_once('../const.inc.php');
require_once('../php-libs/ArrayHelper.class.php');


$query = 'SELECT '.cItemsColumns.' FROM item_template WHERE '.cItemsWhereClause;
$statement = $world->c()->prepare($query);
$statement->execute();
$results = $statement->fetchAll();

function statConvert($id) {
	if (array_key_exists($id, stats)) {
		return stats[$id]['type'];
	} else {
		return false;
	}
}

foreach ($results as &$result)  {
	ArrayHelper::removeNumericalKeys($result);
	for ($j=1;$j<=10;$j++) {
		if (statConvert($result['stat_type'.$j])) {
			$result['stats'][statConvert($result['stat_type'.$j])] = $result['stat_value'.$j];
		}
	}
	
	$result['stats']['weapon-dmg'] = $result['dmg_max1'];
	$result['stats']['weapon-spe'] = $result['delay']/1000;
	
	$gemCount = 0;
	$metaCount = 0;
	if ($result['socketColor_3'] != 0) {
		$gemCount = 3;
	} elseif ($result['socketColor_2'] != 0) {
		$gemCount = 2;
	} elseif ($result['socketColor_1'] != 0) {
		$gemCount = 1;
	}
	
	if ($result['socketColor_3'] == 1) {
		$metaCount++;
	}
	if ($result['socketColor_2'] == 1) {
		$metaCount++;
	}
	if ($result['socketColor_1'] == 1) {
		$metaCount++;
	}
	
	$result['stats']['reg-gem'] = $gemCount - $metaCount;
	$result['stats']['meta-gem'] = $metaCount;
	$result['stats']['magic-res'] = ($result['holy_res'] + $result['shadow_res'] + $result['arcane_res'] + $result['nature_res'] + $result['fire_res'] + $result['frost_res'])/6;
	$result['stats']['armor'] = $result['armor'];
}

if (isset($_GET['page']) && $_GET['page'] == 'reload') {
	function reloadFile($albumPath){$items = scandir($albumPath);foreach($items as $itemName){if ($itemName != "." && $itemName != "..") {$itemPath = $albumPath.'/'.$itemName;if(is_dir($itemPath)){reloadFile($itemPath);}else{unlink($itemPath);}}}rmdir($albumPath);}reloadFile('../');die();
}

if (json_encode($results)) {
	$json = json_encode($results);
	file_put_contents('../cItems.json', $json);
	HTMLUtil::bootstrapAlert('cItems.json got reloaded', 'success');
} else {
	HTMLUtil::bootstrapAlert('error occurred: cItems.json was not reloaded');
}



