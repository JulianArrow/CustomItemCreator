<?php
header("Content-Type: application/javascript");

require_once('dbconfig.inc.php');
require_once('const.inc.php');
require_once('php-libs/ArrayHelper.class.php');

$customEntry = (int) $_GET['entry'];
if ($world->exists(cItemTable['tableName'], [cItemTable['entryColumn'] => $customEntry]))
	$result = $world->select('item_template', ['entry' => $customEntry], 1, cItemsColumns);
else
	die('');

function statConvert($id) {
	if (array_key_exists($id, stats)) {
		return stats[$id]['type'];
	} else {
		return false;
	}
}

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
?>
function onLoadCustomFunction () {
	nullStats();
	<?php
		foreach ($result['stats'] as $statKey => $stat) {
			echo 'incr(\''.$statKey.'\', '.$stat.');';
		}
		if ($result['class'] == 2 && in_array($result['subclass'], [0, 4, 7, 13, 15]))
			echo '$("[name=handed-token]").val(1);';
		elseif ($result['class'] == 2 && in_array($result['subclass'], [1, 2, 3, 5, 6, 8, 9, 10, 11, 12, 14, 16, 17, 18, 19, 20]))
			echo '$("[name=handed-token]").val(2);';
		else
			echo '$("[name=handed-token]").val(0);';
		echo '$("[name=class-token]").val('.$result['class'].');
			$("[name=subclass-token]").val('.$result['subclass'].');
			$("[name=inventory-type-token]").val('.$result['InventoryType'].');';
		
		if ($result['Quality'] == 7)
			echo '$("#accountbound-checkbox").prop(\'checked\', true); $("#accountbound-checkbox").prop(\'disabled\', true);';
	?>
	checkChangeableTypes();
	enabStats();
	if ($("[name=handed-token]").val() == 0) {
		$("#weapon").css('display', 'none');
	} else {
		$("#weapon").css('display', 'block');;
	}
	checkSubmitButton();
}
