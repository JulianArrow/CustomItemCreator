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
weaponSpeedMin = <?=weaponSpeedMin?>;
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
		resetStatsMerge();
		switch ($("[name=item-base]").val()) {
		<?php
		foreach ($cItems as $cItem) {
			echo 'case \''.$cItem['entry'].'\':';
			foreach ($cItem['stats'] as $statKey => $stat) {
				echo 'incr(\''.$statKey.'\', '.$stat.');';
				if ($cItem['class'] == 2 && in_array($cItem['subclass'], [0, 4, 7, 13, 15]))
					echo '$("[name=handed-token]").val(1);';
				elseif ($cItem['class'] == 2 && in_array($cItem['subclass'], [1, 2, 3, 5, 6, 8, 9, 10, 11, 12, 14, 16, 17, 18, 19, 20]))
					echo '$("[name=handed-token]").val(2);';
				else
					echo '$("[name=handed-token]").val(0);';
				echo '$("[name=class-token]").val('.$cItem['class'].');
					$("[name=subclass-token]").val('.$cItem['subclass'].');
					$("[name=inventory-type-token]").val('.$cItem['InventoryType'].');';
			}
			echo 'break;';
		}
		?>
		}
		if ($(this).val() != 'none') {
			if ($("[name=handed-token]").val() == 0) 
				$("#weapon").hide();
			else
				$("#weapon").show();
	
			if (![1, 3, 5, 6, 7, 8, 9, 10].includes(Number($("[name=inventory-type-token]").val())))
				$("#cloth-control").hide();
			else
				$("#cloth-control").show();
		}
		checkSubmitButton();
		checkChangeableTypes();
		checkMergeableStats();
	});
	<?php
	} elseif (isset($_GET['page']) && $_GET['page'] == 'edit') {
	?>
	noStats();
	<?php
	}
	?>
	register();

	$("#create, #edit").submit(function(e) {
		e.preventDefault();

		var form = $(this);
		var url = form.attr('action');

		$.ajax({
			   type: "POST",
			   url: url,
			   data: form.serialize(),
			   beforeSend: function () {
				   $("html, body").animate({ scrollTop: 0 }, "fast");
				   $("#ajaxContainer").html("<br><div class=\"spinner-border mx-auto text-light\" style=\"display: block;\" role=\"status\"><span class=\"sr-only\">Loading...</span></div>");
			   },
			   success: function(data)
			   {
				   $("#ajaxContainer").html(data);
				   checkForErrorField(data);
			   }
			 });
	});
});
</script>