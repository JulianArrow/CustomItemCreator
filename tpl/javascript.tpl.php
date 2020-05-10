<?php
/**
 * @package Custom Item Form by Julian Pfeil
 * @copyright Julian Pfeil
 * @author Julian Pfeil
 *
 * @version 1.0.0
 */

$cItem_json = file_get_contents('cItems.json');
$cItems = json_decode($cItem_json, true);
 ?>
<script type="text/javascript">
ids = [<?php
$i = 0;
foreach(stats as $id => $stat) {
	if ($stat['type'] != 'accountbound') {
		echo '\''.$stat['type'].'\'';
		if(++$i !== count(stats)) {
			echo ',';
		}
	}
}    
?>];

mainStatCap =<?=mainStatCap?>;
hasteCap = <?=hasteCap?>;
weaponDamageCap = <?=weaponDamageCap?>;
weaponSpeed2hCap = <?=weaponSpeed2hCap?>;
weaponSpeedCap = <?=weaponSpeedCap?>;
resilienceCap = <?=resilienceCap?>;
magicResCap = <?=magicResCap?>;

$(document).ready(function() {
	<?php
	if (isset($_GET['page']) && $_GET['page'] == 'create') {
	?>
	$("[name=item-base]").change(function () {
		if ($(this).val() == 'none') {
			disabStats();
			noStats();
		} else {
			enabStats();
			nullStats();
		}
		switch ($("[name=item-base]").val()) {
		<?php
		foreach ($cItems as $cItem) {
			echo 'case \''.$cItem['entry'].'\':';
			foreach ($cItem['stats'] as $statKey => $stat) {
				echo 'stat(\''.$statKey.'\', '.$stat.');';
			}
			echo 'break;';
		}
		?>
		}
		checkSubmitButton();
	});
	<?php
	} elseif (isset($_GET['page']) && $_GET['page'] == 'edit') {
	?>
	enabStats();
	nullStats();
	<?php
	}
	?>
	register();
});
</script>