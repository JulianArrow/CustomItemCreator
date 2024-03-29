﻿<?php
/**
 * @package Custom Item Form by Julian Pfeil
 * @copyright Julian Pfeil
 * @author Julian Pfeil
 *
 * @version 1.0.0
 */
session_start();

require_once('php-libs/HTMLUtil.class.php');

/* if (!isset($_POST['submitButton']) && !isset($_REQUEST['account_id'])) 
	die(HTMLUtil::bootstrapAlert('You did not submit the form correctly!')); */

require_once('dbconfig.inc.php');
require_once('const.inc.php');
require_once('php-libs/TypeUtil.class.php');
require_once('php-libs/ArrayHelper.class.php');
require_once('php-libs/SOAPHelper.class.php');
require_once('php-libs/TextHelper.class.php');

HTMLUtil::includeStyle('bootstrap', '3rdParty/', '.min.css');

#login
if (!isset($_SESSION['']['id']) || !is_numeric($_SESSION['']['id'])) 
	die(HTMLUtil::bootstrapAlert('You need to log in through the cms!'));
else
	$id = (int)$_SESSION['']['id'];

#base-entry
if (isset($_POST['item-base']) && TypeUtil::checkType($_POST['item-base'], 'positivenumber'))
	$baseEntry = (int)$_POST['item-base'];
elseif (isset($_POST['custom-id']) && TypeUtil::checkType($_POST['custom-id'], 'positivenumber'))
	$baseEntry = (int)$_POST['custom-id'];
else
	die(HTMLUtil::bootstrapAlert('item-base must be numeric and bigger than 0'));

#base-exist
if ($world->exists('item_template', ['entry' => $baseEntry])) {
	if (isset($_GET['page'])) {
		if ($world->exists(cItemTable['tableName'], [cItemTable['entryColumn'] => $baseEntry]))
			$baseItem = $world->select('item_template', ['entry' => $baseEntry], 1);
		else
			die(HTMLUtil::bootstrapAlert('item-base is not a custom-item.'));
	} else {
		$query = 'SELECT EXISTS(SELECT 1 FROM `item_template` WHERE ('.cItemsWhereClause.') AND `entry` = :entry LIMIT 1)';
		$statement = $world->c()->prepare($query);
		$statement->execute(['entry' => $baseEntry]);
		if ($statement->fetchColumn()) 
			$exists = true;
		else
			$exists = false;
		
		if ($exists)
			$baseItem = $world->select('item_template', ['entry' => $baseEntry], 1);
		else
			die(HTMLUtil::bootstrapAlert('item-base is not a customizable item.'));
	}
} else
	die(HTMLUtil::bootstrapAlert('item-base is not existing.'));

#display-id
if (!isset($_GET['page']) || isset($_POST['use-display-id'])) {
	if (isset($_POST['display-id']) && TypeUtil::checkType($_POST['display-id'], 'positivenumber')) 
		$displayEntry = (int)$_POST['display-id'];
	else
		die(HTMLUtil::bootstrapAlert('display-id must be numeric and bigger than 0.'));
}

#display-id-exist
if ((!isset($_GET['page']) || isset($_POST['use-display-id'])) && !$world->exists('item_template', ['entry' => $displayEntry]))
	die(HTMLUtil::bootstrapAlert('display is not existing.'));

#display-id-class
if (!isset($_GET['page']) || isset($_POST['use-display-id'])) {
	$displayItem = $world->select('item_template', ['entry' => $displayEntry], 1, 'class, displayid');
	if ($displayItem['class'] != $baseItem['class'])
		die(HTMLUtil::bootstrapAlert('display-item and item-base are not of the same class.'));
	$displayId = $displayItem['displayid'];
}

#color-exist
if (!isset($_GET['page']) || isset($_POST['use-name'])) {
	if (isset($_POST['name-color']) && array_key_exists($_POST['name-color'], colors))
		$nameColor = '|cff'.colors[$_POST['name-color']];
	else
		die(HTMLUtil::bootstrapAlert('name-color is not existing.'));
}

#name-valid 
if ((!isset($_GET['page']) || isset($_POST['use-name'])) && isset($_POST['name'])  && preg_match('/^[a-zA-Z0-9 \'?!.,]{1,100}$/', $_POST['name']))
	$name = $_POST['name'];
elseif ((!isset($_GET['page']) || isset($_POST['use-name'])) && (!isset($_POST['name']) || !preg_match('/^[a-zA-Z0-9 \'?!.,]{1,100}$/', $_POST['name'])))
	die(HTMLUtil::bootstrapAlert('item-name may only contain: a-zA-Z0-9 \'?!.,'));

#token-validate
$costs = 0;
$addStats = [];
foreach(stats as $key => $stat) {
	if (!isset($_POST[$stat['type'].'-token']) || !is_numeric($_POST[$stat['type'].'-token']) || ((int)$_POST[$stat['type'].'-token'] < 0 && $stat['type'] != 'weapon-spe')) {
		die(HTMLUtil::bootstrapAlert('token-value must be numeric and 0 or bigger.'));
	} else {
		$count = abs((int)$_POST[$stat['type'].'-token']);
		if ($count > 0) {
			$costs += $count*stats[$key]['prize'];
			$addStats[$key] = (int)$_POST[$stat['type'].'-token']*stats[$key]['amount'];
		}
	}
}

#character-id
if (TypeUtil::checkType($_POST['character-id'], 'positivenumber')) 
	$characterId = (int)$_POST['character-id'];
else
	die(HTMLUtil::bootstrapAlert('character-id must be numeric and bigger than 0.'));

#base-item-own
if (!isset($_GET['page']) && !$character->exists('item_instance', ['owner_guid' => $characterId, 'itemEntry' => $baseItem['entry']]))
		die(HTMLUtil::bootstrapAlert('you need to own the item on that character.'));

#keep-item
if (!isset($_GET['page']) && isset($_POST['keep-item-token']) && TypeUtil::checkType($_POST['keep-item-token'], 'positivenumber') && (int)$_POST['keep-item-token'] == 1) {
	$costs += keepItem['prize'];
	$keepItemBool = 1;
} elseif (!isset($_GET['page'])) {
	$keepItemBool = 0;
}

#costs-validate
if ($costs < 1) {
	die(HTMLUtil::bootstrapAlert('you need to spend at least 1 dp.'));
}

#dp
if (!$website->exists('account_data', ['dp' => ['>=', $costs], 'id' => $id]))
	die(HTMLUtil::bootstrapAlert('not enough dp.'));

#character-account
if (!$character->exists('characters', ['guid' => $characterId, 'account' => $id]))
	die(HTMLUtil::bootstrapAlert('character needs to be on your account.'));

#custom-item-own
if (isset($_GET['page']) && !$character->exists('item_instance', ['owner_guid' => $characterId, 'itemEntry' => $baseItem['entry']]))
	die(HTMLUtil::bootstrapAlert('you need to own the item on that character.'));

#descr-valid
if (isset($_POST['use-description']) && isset($_POST['description'])) {
	if (preg_match('/^[a-zA-Z0-9 \'?!.,]{1,100}$/', $_POST['description'])) 
		$description = $_POST['description'];
	else
		die(HTMLUtil::bootstrapAlert('description may only contain and not more than 100: a-zA-Z0-9 \'?!.,'));

	if (array_key_exists($_POST['descr-color'], colors))
		$descrColor = '|cff'.colors[$_POST['descr-color']];
	else
		die(HTMLUtil::bootstrapAlert('description-color is not existing.'));
}

#check-entry
if (!isset($_GET['page'])) {
	$query = 'SELECT entry FROM item_template ORDER BY entry DESC LIMIT 1';
	$statement = $world->c()->prepare($query);
	$statement->execute();
	$result = $statement->fetch();
	if ((int)$result['entry'] < entryMin) {
		$entry = entryMin;
	} else {
		$entry = (int)$result['entry'] + 1;
	}
}

#create-item
$stayAddStats = $addStats;
$custom = $baseItem;
$custom['StatsCount'] = 10;
if (isset($addStats['A'])) {
	$custom['dmg_min1'] = (int)$custom['dmg_min1'] + (int)$addStats['A'];
	$custom['dmg_max1'] = (int)$custom['dmg_max1'] + (int)$addStats['A'];
	if ((int)$custom['dmg_max1'] > weaponDamageCap)
		die(HTMLUtil::bootstrapAlert('weapon-damage-max must not be over '.weaponDamageCap));
	unset($addStats['A']);
}
if (isset($addStats['B'])) {
	$custom['delay'] = (int)$custom['delay'] + floatval($addStats['B'])*1000;
	if ($custom['InventoryType'] == 13)
		if ($custom['delay'] > weaponSpeedCap*1000)
			die(HTMLUtil::bootstrapAlert('weapon-speed must not be over '.weaponSpeedCap));
	elseif ($custom['InventoryType'] == 17)
		if ($custom['delay'] > weaponSpeed2hCap*1000)
			die(HTMLUtil::bootstrapAlert('weapon-speed must not be over '.weaponSpeed2hCap));
	else 
		$custom['delay'] = 0;
	unset($addStats['B']);
}
$gemCount = 0;
if ($custom['socketColor_3'] != 0) {
	$gemCount = 3;
} elseif ($custom['socketColor_2'] != 0) {
	$gemCount = 2;
} elseif ($custom['socketColor_1'] != 0) {
	$gemCount = 1;
}
if (isset($addStats['C']) || isset ($addStats['D'])) {
	if (!isset($addStats['C']))
		$addStats['C'] = 0;
	if (!isset($addStats['D']))
		$addStats['D'] = 0;
	if (((int)$addStats['C'] + (int)$addStats['D'] + $gemCount) > 3)
		die(HTMLUtil::bootstrapAlert('only 3 sockets allowed'));
	if ($gemCount == 2) {
		if ($addStats['C'] > 0)
			$custom['socketColor_3'] = 2;
		else 
			$custom['socketColor_3'] = 1;
	} elseif ($gemCount == 1) {
		if ($addStats['C'] > 0) {
			if ($addStats['C'] == 2) {
				$custom['socketColor_3'] = 2;
				$custom['socketColor_2'] = 2;
			} else {
				if ($addStats['D'] > 0)
					$custom['socketColor_3'] = 1;
				$custom['socketColor_2'] = 2;
			}
		} else {
			if ($addStats['D'] == 2)
				$custom['socketColor_3'] = 1;
			$custom['socketColor_2'] = 1;
		}
	} else {
		if ($addStats['C'] > 0) {
			if ($addStats['C'] == 3) {
				$custom['socketColor_3'] = 2;
				$custom['socketColor_2'] = 2;
				$custom['socketColor_1'] = 2;
			} elseif ($addStats['C'] == 2) {
				$custom['socketColor_3'] = 2;
				$custom['socketColor_2'] = 2;
				$custom['socketColor_1'] = 1;
			} else {
				if ($addStats['D'] == 2)
					$custom['socketColor_3'] = 1;
				if ($addStats['D'] > 0)
					$custom['socketColor_2'] = 1;
				$custom['socketColor_1'] = 2;
			}
		} elseif ($addStats['D'] > 0) {
			if ($addStats['D'] == 3)
				$custom['socketColor_3'] = 1;
			if ($addStats['D'] > 1)
				$custom['socketColor_2'] = 1;
			$custom['socketColor_1'] = 1;
		}
	}
	if (isset($addStats['C'])) unset($addStats['C']);
	if (isset($addStats['D'])) unset($addStats['D']);
}
if (isset($addStats['E'])) {
	if ((int)$custom['Quality'] == 7)
		die(HTMLUtil::bootstrapAlert('your custom-item is already accountbound'));
	$custom['Flags'] = (int)$custom['Flags'] + 134217728;
	$custom['Quality'] = 7;
	unset($addStats['E']);
}
if (isset($addStats['F'])) {
	$custom['armor'] = (int)$custom['armor'] + $addStats['F'];
	unset($addStats['F']);
}
if (isset($addStats['G'])) {
	$custom['holy_res'] = (int)$custom['holy_res'] + $addStats['G'];
	$custom['shadow_res'] = (int)$custom['shadow_res'] + $addStats['G'];
	$custom['nature_res'] = (int)$custom['nature_res'] + $addStats['G'];
	$custom['arcane_res'] = (int)$custom['arcane_res'] + $addStats['G'];
	$custom['fire_res'] = (int)$custom['fire_res'] + $addStats['G'];
	$custom['frost_res'] = (int)$custom['frost_res'] + $addStats['G'];
	if ((int)$custom['nature_res'] > magicResCap || (int)$custom['arcane_res'] > magicResCap || (int)$custom['shadow_res'] > magicResCap || (int)$custom['holy_res'] > magicResCap || (int)$custom['frost_res'] > magicResCap || (int)$custom['fire_res'] > magicResCap)
		die(HTMLUtil::bootstrapAlert('your magic-res must not be over '.magicResCap));
	unset($addStats['G']);
}

if (isset($_POST['cloth-token']) && $_POST['cloth-token'] > 0) {
	if ($custom['AllowableClass'] == -1 && $custom['class'] == 4 && $custom['subclass'] == 1)
		die(HTMLUtil::bootstrapAlert('your custom-item is already without restrictions'));
	if (!in_array($custom['InventoryType'], [1, 3, 5, 6, 7, 8, 9, 10]))
		die(HTMLUtil::bootstrapAlert('your custom-item is no armor'));
	$custom['Material'] = 7;
	$custom['AllowableClass'] = -1;
	$custom['class'] = 4;
	$custom['subclass'] = 1;
}

if (isset($_POST['item-type']) && $_POST['item-type'] != '') {
	$itemType = $_POST['item-type'];
	$inventoryType = $custom['InventoryType'];
	switch ($itemType)
	{
	case 'head':
		if (!in_array($inventoryType, [1, 3, 5, 6, 7, 8, 9, 10]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 1;
		break;
	case 'neck':
		if (!in_array($inventoryType, [2, 11, 12, 16]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 2;
		$custom['subclass'] = 0;
		break;
	case 'shoulder':
		if (!in_array($inventoryType, [1, 3, 5, 6, 7, 8, 9, 10]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 3;
		break;
	case 'shirt':
		if (!in_array([4, 19], $inventoryType))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 4;
		$custom['subclass'] = 0;
		break;
	case 'chest':
		if (!in_array($inventoryType, [1, 3, 5, 6, 7, 8, 9, 10]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 5;
		break;
	case 'waist':
		if (!in_array($inventoryType, [1, 3, 5, 6, 7, 8, 9, 10]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 6;
		break;
	case 'legs':
		if (!in_array($inventoryType, [1, 3, 5, 6, 7, 8, 9, 10]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 7;
		break;
	case 'feet':
		if (!in_array($inventoryType, [1, 3, 5, 6, 7, 8, 9, 10]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 8;
		break;
	case 'wrists':
		if (!in_array($inventoryType, [1, 3, 5, 6, 7, 8, 9, 10]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 9;
		break;
	case 'hands':
		if (!in_array($inventoryType, [1, 3, 5, 6, 7, 8, 9, 10]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 10;
		break;
	case 'finger':
		if (!in_array($inventoryType, [2, 11, 12, 16]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 11;
		$custom['subclass'] = 0;
		break;
	case 'trinket':
		if (!in_array($inventoryType, [2, 11, 12, 16]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 12;
		$custom['subclass'] = 0;
		break;
	case 'back':
		if (!in_array($inventoryType, [2, 11, 12, 16]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 16;
		$custom['subclass'] = 0;
		break;
	case 'tabard':
		if (!in_array($inventoryType, [4, 19]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['InventoryType'] = 19;
		$custom['subclass'] = 0;
		break;
	case 'libram':
		if ($inventoryType != 28)
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 7;
		break;
	case 'sigil':
		if ($inventoryType != 28)
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 10;
		break;
	case 'idol':
		if ($inventoryType != 28)
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 8;
		break;
	case 'totem':
		if ($inventoryType != 28)
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 9;
		break;
	case 'thrown':
		if (!in_array($inventoryType, [15, 25, 26]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 16;
		$custom['InventoryType'] = 25;
		break;
	case 'bow':
		if (!in_array($inventoryType, [15, 25, 26]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 2;
		$custom['InventoryType'] = 15;
		break;
	case 'wand':
		if (!in_array($inventoryType, [15, 25, 26]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 19;
		$custom['InventoryType'] = 26;
		break;
	case 'ohaxe':
		if (!in_array($inventoryType, [13, 17]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		if ($custom['delay'] > weaponSpeedCap*1000)
			die(HTMLUtil::bootstrapAlert('weapon-speed must not be over '.weaponSpeedCap.' when changing to one handed'));
		$custom['subclass'] = 0;
		$custom['InventoryType'] = 13;
		break;
	case 'thaxe':
		if (!in_array($inventoryType, [13, 17]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 1;
		$custom['InventoryType'] = 17;
		break;
	case 'ohmace':
		if (!in_array($inventoryType, [13, 17]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		if ($custom['delay'] > weaponSpeedCap*1000)
			die(HTMLUtil::bootstrapAlert('weapon-speed must not be over '.weaponSpeedCap.' when changing to one handed'));
		$custom['subclass'] = 4;
		$custom['InventoryType'] = 13;
		break;
	case 'thmace':
		if (!in_array($inventoryType, [13, 17]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 5;
		$custom['InventoryType'] = 17;
		break;
	case 'ohsword':
		if (!in_array($inventoryType, [13, 17]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		if ($custom['delay'] > weaponSpeedCap*1000)
			die(HTMLUtil::bootstrapAlert('weapon-speed must not be over '.weaponSpeedCap.' when changing to one handed'));
		$custom['subclass'] = 7;
		$custom['InventoryType'] = 13;
		break;
	case 'thsword':
		if (!in_array($inventoryType, [13, 17]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 8;
		$custom['InventoryType'] = 17;
		break;
	case 'polearm':
		if (!in_array($inventoryType, [13, 17]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 6;
		$custom['InventoryType'] = 17;
		break;
	case 'staff':
		if (!in_array($inventoryType, [13, 17]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		$custom['subclass'] = 10;
		$custom['InventoryType'] = 17;
		break;
	case 'dagger':
		if (!in_array($inventoryType, [13, 17]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		if ($custom['delay'] > weaponSpeedCap*1000)
			die(HTMLUtil::bootstrapAlert('weapon-speed must not be over '.weaponSpeedCap.' when changing to one handed'));
		$custom['subclass'] = 15;
		$custom['InventoryType'] = 13;
		break;
	case 'fist':
		if (!in_array($inventoryType, [13, 17]))
			die(HTMLUtil::bootstrapAlert('something went wrong with the item-type changes'));
		if ($custom['delay'] > weaponSpeedCap*1000)
			die(HTMLUtil::bootstrapAlert('weapon-speed must not be over '.weaponSpeedCap.' when changing to one handed'));
		$custom['subclass'] = 13;
		$custom['InventoryType'] = 13;
		break;
	}
}

#mergeStats
$mergeStatsCount = (int) $_POST['merge-token'];
$mainStats = ['stamina', 'strength', 'intellect', 'agility', 'spirit', 'attack-power', 'spell-power'];
$secStats = ['haste', 'parry', 'hit', 'crit', 'dodge', 'defense', 'block', 'armor-pen', 'spell-pen', 'resilience', 'attack-power', 'spell-power', 'expertise'];
$stayMergeStats = [];

for ($i=1;$i<=$mergeStatsCount;$i++) {
	if (isset($_POST['mergeSelect'.$i]) && !empty($_POST['mergeSelect'.$i]) && isset($_POST['mergeSelectB'.$i]) && !empty($_POST['mergeSelectB'.$i]) && isset($_POST['statInput'.$i]) && (int)$_POST['statInput'.$i] > 0) {
		if (in_array($_POST['mergeSelect'.$i], $mainStats)) {
			if (!in_array($_POST['mergeSelectB'.$i], $mainStats))
				die(HTMLUtil::bootstrapAlert('Two stats you selected are not compatible'));
			
			foreach(stats as $key => $stat) {
				$amount = $stat['amount'];
				$prize = $stat['prize'];
				if ($stat['type'] == $_POST['mergeSelect'.$i]) {
					foreach(stats as $keyB => $statB) {
						$amountB = $statB['amount'];
						$prizeB = $statB['prize'];
						if ($statB['type'] == $_POST['mergeSelectB'.$i]) {
							$newAmount = floor((int)$_POST['statInput'.$i]*($amountB/$amount)*($prize/$prizeB));
							if (!isset($addStats[$key]))
								$addStats[$key] = 0;
							$addStats[$key] -= (int)$_POST['statInput'.$i];
							if (!isset($addStats[$keyB]))
								$addStats[$keyB] = 0;
							$addStats[$keyB] += $newAmount;
							$stayMergeStats[$keyB] = $newAmount;
						}
					}
				}
			}
		} elseif (in_array($_POST['mergeSelect'.$i], $secStats)) {
			if (!in_array($_POST['mergeSelectB'.$i], $secStats))
				die(HTMLUtil::bootstrapAlert('Two stats you selected are not compatible'));
			
			foreach(stats as $key => $stat) {
				$amount = $stat['amount'];
				$prize = $stat['prize'];
				if ($stat['type'] == $_POST['mergeSelect'.$i]) {
					foreach(stats as $keyB => $statB) {
						$amountB = $statB['amount'];
						$prizeB = $statB['prize'];
						if ($statB['type'] == $_POST['mergeSelectB'.$i]) {
							$newAmount = floor((int)$_POST['statInput'.$i]*($amountB/$amount)*($prize/$prizeB));
							if (!isset($addStats[$key]))
								$addStats[$key] = 0;
							$addStats[$key] -= (int)$_POST['statInput'.$i];
							if (!isset($addStats[$keyB]))
								$addStats[$keyB] = 0;
							$addStats[$keyB] += $newAmount;
							$stayMergeStats[$keyB] = $newAmount;
						}
					}
				}
			}
		} else
			die(HTMLUtil::bootstrapAlert('A stat you selected is not mergeable'));
	}
}

#transferStats
$dbStatTypes = [];
for ($i=1;$i<=10;$i++) {
	if (!isset($dbStatTypes[$custom['stat_type'.$i]]))
		$dbStatTypes[$custom['stat_type'.$i]] = 0;
	$dbStatTypes[$custom['stat_type'.$i]] += $custom['stat_value'.$i];
	if ($dbStatTypes[$custom['stat_type'.$i]] > statValueMax)
		die(HTMLUtil::bootstrapAlert('Stat-value can not get over '.statValueMax));
}
unset($dbStatTypes[0]);
$newStats = $dbStatTypes + $addStats;

$c = 1;
foreach ($newStats as $key => $newStat) {
	if (array_key_exists($key, $dbStatTypes) && array_key_exists($key, $addStats)) {
		$newStats[$key] = (int)$newStats[$key] + (int)$addStats[$key];
	}
	
	if ($newStats[$key] == 0) 
		$statType = 0;
	elseif ($newStats[$key] > 0)
		$statType = $key;
	else
		die(HTMLUtil::bootstrapAlert('You can\'t go under 0 of a stat'));
	
	$custom['stat_type'.$c] = $statType;
	$custom['stat_value'.$c++] = $newStats[$key];
}

$newStatsInt = [];
foreach ($newStats as $key => $newStat) {
	if (is_numeric($key)) 
		$newStatsInt[$key] = $newStat;
}
if (count($newStatsInt) > 10)
	die(HTMLUtil::bootstrapAlert('Max 10 different stats allowed'));


#checkCaps
if ((isset($newStats[3]) && $newStats[3] > mainStatCap) || (isset($newStats[4]) && $newStats[4] > mainStatCap) || (isset($newStats[5]) && $newStats[5] > mainStatCap) || (isset($newStats[6]) && $newStats[6] > mainStatCap) || (isset($newStats[7]) && $newStats[7] > mainStatCap)) 
	die(HTMLUtil::bootstrapAlert('main-stat-cap is '.mainStatCap));
if (isset($newStats[35]) && $newStats[35] > resilienceCap) 
	die(HTMLUtil::bootstrapAlert('resilience-cap is '.resilienceCap));
if (isset($newStats[36]) && $newStats[36] > hasteCap) 
	die(HTMLUtil::bootstrapAlert('haste-cap is '.hasteCap));
for (;$c<=10;$c++) {
	$custom['stat_type'.$c] = 0;
	$custom['stat_value'.$c] = 0;
}
$custom['comment'] = 'CUSTOM (Item Creator)';
if (isset($name))
	$custom['name'] = $nameColor.$name;
if (isset($displayId))
	$custom['displayid'] = $displayId;
if (isset($description))
	$custom['description'] = $descrColor.$description;
if (!isset($_GET['page'])) {
	$custom['entry'] = $entry;
	ArrayHelper::removeNumericalKeys($custom);
	$columnString = '`'.implode('`, `', array_keys($custom)).'`';
	$valueString = ':'.implode(', :', array_keys($custom));
	$query = 'INSERT INTO `item_template` ('.$columnString.') VALUES ('.$valueString.')';
	$world->insert(cItemTable['tableName'], [cItemTable['entryColumn'] => $entry]);
		
	$characterName = $character->select('characters', ['guid' => $characterId], 1, 'name')['name'];
} else {
	$whitelist = ['entry', 'name', 'comment', 'class', 'subclass', 'Material', 'AllowableClass', 'InventoryType', 'displayid', 'Quality', 'Flags', 'stat_type1', 'stat_value1', 'stat_type2', 'stat_value2', 'stat_type3', 'stat_value3', 'stat_type4', 'stat_value4', 'stat_type5', 'stat_value5', 'stat_type6', 'stat_value6', 'stat_type7', 'stat_value7', 'stat_type8', 'stat_value8', 'stat_type9', 'stat_value9', 'stat_type10', 'stat_value10', 'dmg_min1', 'dmg_max1', 'armor', 'holy_res', 'fire_res', 'frost_res', 'nature_res', 'shadow_res', 'arcane_res', 'description', 'delay', 'socketColor_1', 'socketColor_2', 'socketColor_3'];
	ArrayHelper::clearArray($custom, $whitelist);
	$query = "UPDATE item_template SET name = :name, comment = :comment, class = :class, subclass = :subclass, Material = :Material, AllowableClass = :AllowableClass, InventoryType = :InventoryType, displayid = :displayid, Quality = :Quality, Flags = :Flags, stat_type1 = :stat_type1, stat_value1 = :stat_value1, stat_type2 = :stat_type2, stat_value2 = :stat_value2, stat_type3 = :stat_type3, stat_value3 = :stat_value3, stat_type4 = :stat_type4, stat_value4 = :stat_value4, stat_type5 = :stat_type5, stat_value5 = :stat_value5, stat_type6 = :stat_type6, stat_value6 = :stat_value6, stat_type7 = :stat_type7, stat_value7 = :stat_value7, stat_type8 = :stat_type8, stat_value8 = :stat_value8, stat_type9 = :stat_type9, stat_value9 = :stat_value9, stat_type10 = :stat_type10, stat_value10 = :stat_value10, dmg_min1 = :dmg_min1, dmg_max1 = :dmg_max1, armor = :armor, holy_res = :holy_res, shadow_res = :shadow_res, arcane_res = :arcane_res, nature_res = :nature_res, fire_res = :fire_res, frost_res = :frost_res, delay = :delay, description = :description, socketColor_1 = :socketColor_1, socketColor_2 = :socketColor_2, socketColor_3 = :socketColor_3 WHERE entry = :entry";
}

$statement = $world->c()->prepare($query);
$statement->execute($custom);

require_once('soapconfig.inc.php');
$soap = new SOAPHelper($soapUser, $soapPassword, $soapHost, $soapPort);
$soap->command(itemReloadCmd);
if (!isset($_GET['page']))
	$soap->command('.send items '.$characterName.' "Your custom-item arrived!" "Hey '.$characterName.', this is your new custom-item! The staff wishs you a nice day and have fun!" '.$custom['entry']);

$statement = $website->c()->prepare("UPDATE account_data SET dp = dp - :costs WHERE id = :id");
$statement->execute(['id' => $id, 'costs' => $costs]);

if (!isset($_GET['page'])) {
	if ($keepItemBool == 0) {
		$character->delete('item_instance', ['owner_guid' => $characterId, 'itemEntry' => $baseItem['entry']], 1);
	}
	$stayAddStats = $stayAddStats + ['keep-item' => $keepItemBool];
}

$time = time();
$website->insert('custom_form_log', [
	'account_id' => $id, 
	'character_id' => $characterId, 
	'weapon_entry' => $custom['entry'], 
	'costs' => $costs, 
	'name' => $custom['name'], 
	'date' => $time, 
	'description' => $custom['description'], 
	'added' => print_r($stayAddStats, true), 
	'merged' => print_r($stayMergeStats, true)
]);
if (!isset($_GET['page']))
	HTMLUtil::bootstrapAlert('Your weapon was probably successfully created! Your custom-item entry is: '.$custom['entry'], 'success');
else
	HTMLUtil::bootstrapAlert('Your weapon was probably successfully edited! Your custom-item entry is: '.$custom['entry'], 'success');
