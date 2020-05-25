function checkChangeableTypes (){
	var classType = $("[name=class-token]").val();
	var subclass = $("[name=subclass-token]").val();
	var inventoryType = Number($("[name=inventory-type-token]").val());
	if ([1, 3, 5, 6, 7, 8, 9, 10].includes(inventoryType)) {
		//armor
		$("#item-type > option:not(.armor)").hide();
		$("#item-type > option:not(.armor)").prop('disabled', true);
		$("#item-type > option.armor").show();
		$("#item-type > option.armor").prop('disabled', false);
	} else if ([4, 19].includes(inventoryType)) {
		//clothing
		$("#item-type > option:not(.clothing)").hide();
		$("#item-type > option:not(.clothing)").prop('disabled', true);
		$("#item-type > option.clothing").show();
		$("#item-type > option.clothing").prop('disabled', false);
	} else if ([2, 11, 12, 16].includes(inventoryType)) {
		//jewellery
		$("#item-type > option:not(.jewellery)").hide();
		$("#item-type > option:not(.jewellery)").prop('disabled', true);
		$("#item-type > option.jewellery").show();
		$("#item-type > option.jewellery").prop('disabled', false);
	} else if (inventoryType == 28) {
		//relic
		$("#item-type > option:not(.relic)").hide();
		$("#item-type > option:not(.relic)").prop('disabled', true);
		$("#item-type > option.relic").show();
		$("#item-type > option.relic").prop('disabled', false);
	} else if ([15, 25, 26].includes(inventoryType)) {
		//range
		$("#item-type > option:not(.range)").hide();
		$("#item-type > option:not(.range)").prop('disabled', true);
		$("#item-type > option.range").show();
		$("#item-type > option.range").prop('disabled', false);
	} else if ([13, 17].includes(inventoryType)) {
		//melee
		$("#item-type > option:not(.melee)").hide();
		$("#item-type > option:not(.melee)").prop('disabled', true);
		$("#item-type > option.melee").show();
		$("#item-type > option.melee").prop('disabled', false);
	} else {
		//everything else
		$("#item-type > option").hide();
		$("#item-type > option").prop('disabled', true);
	}
}

var error;

function errorOnForm (id) {
	$("[name=" + id + "]").addClass("is-invalid");
	error = id;
}

function errorOnFormReset () {
	$("[name=" + error + "]").removeClass("is-invalid");
	error = null;
}

var statsAdded = [];
var dontCountAsStats = ['meta-gem', 'reg-gem', 'weapon-dmg', 'weapon-spe', 'armor', 'magic-res'];

function checkStatsAdded () {
	$("#costs > #statsAdded").text(statsAdded.length);
}

function incr (id, amount) {
	if (amount > 0 && !statsAdded.includes(id) && !dontCountAsStats.includes(id)) {
		statsAdded.push(id);
		checkStatsAdded();
	}
	if ($("#" + id).val() === false) {
		$("#" + id).val(0);
	}
	$("#" + id).val(Number($("#" + id).val()) + Number(amount));
}

function decr (id, amount) {
	if ($("#" + id).val() === false) {
		$("#" + id).val(0);
	}
	$("#" + id).val(Number($("#" + id).val()) - Number(amount));
	
	if ($("#" + id).val() == 0 && statsAdded.includes(id) && !dontCountAsStats.includes(id)) {
		for(var i = statsAdded.length - 1; i >= 0; i--) {
			if(statsAdded[i] == id) {
				statsAdded.splice(i, 1);
			}
		}
		checkStatsAdded();
	}
}

function incrToken (id) {
	$("[name=" + id + "-token]").val(Number($("[name=" + id + "-token]").val()) + 1);
}

function decrToken (id) {
	$("[name=" + id + "-token]").val(Number($("[name=" + id + "-token]").val()) - 1);
}

function disab (id) {
	$("#" + id).prop('disabled', true);
}

function enab (id) {
	$("#" + id).prop('disabled', false);
}

function stat (id, amount) {
	$("#" + id).val(amount);
}

function nullTokens () {
	ids.forEach(function(id) {
		$("[name=" + id + "-token]").val('0');
		if ($("#" + id + "-minus").prop('disabled') === false && id != "weapon-spe") 
			disab(id + '-minus');
	});
}

function nullCosts() {
	$("#costs > #costsNumber").text(0);
}

function nullStats () {
	ids.forEach(function(id) {
		$("#" + id).val('0');
	});
	enab('accountbound-checkbox');
	enab('item-type');
	resetAbCheckbox();
	resetItemTypeSelect();
	resetKeepCheckbox();
	resetStatCount();
	nullTokens();
	nullCosts();
}

function noStats() {
	ids.forEach(function(id) {
		$("#" + id).val('');
	});
	disab('accountbound-checkbox');
	disab('item-type');
	resetAbCheckbox();
	resetItemTypeSelect();
	resetKeepCheckbox();
	resetStatCount();
	nullTokens();
	nullCosts();
}

function resetAbCheckbox() {
	stat('accountbound', 0);
	$("#accountbound-checkbox").prop('checked', false);	
}

function resetStatCount() {
	$("#costs > #statsAdded").text(0);
	statsAdded = [];
}

function resetItemTypeSelect() {
	stat('class', 0);
	stat('subclass', 0);
	  $("#item-type option[value='']").attr('selected', true);
}

function resetKeepCheckbox() {
	stat('keep-item', 0);
	$("#keep-item-checkbox").prop('checked', false);	
}

function incrCosts (amount) {
	$("#costs > #costsNumber").text(Number($("#costs > #costsNumber").text()) + Number(amount));
}

function decrCosts (amount) {
	$("#costs > #costsNumber").text(Number($("#costs > #costsNumber").text()) - Number(amount));
}

function buy (id) {
	if ($("[name=" + id + "-token]").val() == 0) {
		enab(id + '-minus');
	}
	amount = Number($("#" + id + "-plus > .amount").text());
	costs = Number($(".input-group-prepend:has(#" + id + "-plus) > .input-group-text > .prize").text());
	incr(id, amount);
	incrToken(id);
	incrCosts(costs);
	if (id == "weapon-spe" && $("[name=weapon-spe-token]").val() < 0)
		decrCosts(2*costs);
	checkSubmitButton();
	if (!checkCaps()) {
		checkCaps(true);
		notBuy(id);
	}
}

function buySpe () {
	amount = Number($("#weapon-spe-plus > .amount").text());
	costs = Number($(".input-group-prepend:has(#weapon-spe-plus) > .input-group-text > .prize").text());
	decr("weapon-spe", amount);
	decrToken("weapon-spe");
	if ($("[name=weapon-spe-token]").val() < 0) 
		incrCosts(costs);
	else
		decrCosts(costs);
	checkSubmitButton();
	if (!checkCaps()) {
		checkCaps(true);
	incr("weapon-spe", amount);
	incrToken("weapon-spe");
	decrCosts(costs);
	}
}

function notBuy (id) {
	amount = Number($("#" + id + "-plus > .amount").text());
	costs = Number($(".input-group-prepend:has(#" + id + "-plus) > .input-group-text > .prize").text());
	decr(id, amount);
	decrToken(id);
	decrCosts(costs);
	if ($("[name=" + id + "-token]").val() == 0 && id != "weapon-spe") {
		disab(id + '-minus');
	}
	checkSubmitButton();
}

function enabStats () {
	ids.forEach(function(id) {
		enab(id + '-plus');
		if ($("[name=" + id + "-token]").val() > 0 || id == "weapon-spe") {
			enab(id + '-minus');
		}
	});
}

function disabStats () {
	ids.forEach(function(id) {
		disab(id + '-plus');
		if ($("[name=" + id + "-token]").val() > 0 || id == "weapon-spe") {
			disab(id + '-minus');
		}
	});
}

function onLoadCustom () {
	var entry = $("[name=custom-id]").val();
	$.getScript( "onLoadCustom.js.php?entry=" + entry, function(data) {
		if (data == '') {
			if ($("[name=custom-id]").hasClass("is-valid"))
				$("[name=custom-id]").removeClass("is-valid");
			errorOnForm("custom-id");
			disabStats();
			noStats();
		} else {
			onLoadCustomFunction();
			errorOnFormReset();
			$("[name=custom-id]").addClass("is-valid");
		}
	});
}

function registerPlusButtons () {
	ids.forEach(function(id) {
		$("#" + id +"-plus").click(function () {
			if ($(this).prop('disabled') === false) {
				buy(id);
			}
		});
	});
}

function registerMinusButtons () {
	ids.forEach(function(id) {
		$("#" + id +"-minus").click(function () {
			if ($(this).prop('disabled') === false) {
				if (id != "weapon-spe")
					notBuy(id);
				else 
					buySpe();
			}
		});
	});
}

function registerOnLoadCustom () {
	$("#onLoadCustom").click(function () {
		onLoadCustom();
	});
}

function isCreateForm () {
	if ($("[name=display-id]").prop('required') === true) 
		return true;
	else 
		return false;
}

function checkSubmitButton () {
	if (!isCreateForm()) {
		if (Number($("#costs > #costsNumber").text()) > 0 && $("[name=character-id]").val() != '' && $("[name=custom-id]").val() != '' && checkCaps(true)) {
			enab('submitButton');
			return true;
		} else {
			disab('submitButton');
			return false;
		}
	} else {
		if (Number($("#costs > #costsNumber").text()) > 0 && $("[name=character-id]").val() != '' && $("[name=name]").val() != '' && checkCaps(true) && $("[name=display-id]").val() != '' && $("[name=character-id]").val() != '') {
			enab('submitButton');
			return true;
		} else {
			disab('submitButton');
			return false;
		}
	}
}

function checkCaps (alertMode = false) {
	if (($("#stamina").val() > mainStatCap) || ($("#agility").val() > mainStatCap) || ($("#spirit").val() > mainStatCap) || ($("#intellect").val() > mainStatCap) || ($("#strength").val() > mainStatCap)) {
		if (alertMode) {
			alert('main-stat-cap is ' + mainStatCap);
		} else {
			return false;
		}
	}
	if ($("#haste").val() > hasteCap) {		
		if (alertMode) {
			alert('haste-cap is ' + hasteCap);
		} else {
			return false;
		}
	}
	if ($("#weapon-dmg").val() > weaponDamageCap) {
		if (alertMode) {
			alert('weapon-damage-cap is ' + weaponDamageCap);
		} else {
			return false;
		}
	}
	if ($("#weapon-spe").val() > weaponSpeed2hCap && $("[name=handed-token]").val() == 2) {
		if (alertMode) {
			alert('weapon-speed-cap for 2h is ' + weaponSpeed2hCap);
		} else {
			return false;
		}
	}
	if ($("#weapon-spe").val() > weaponSpeedCap && $("[name=handed-token]").val() == 1) {
		if (alertMode) {
			alert('weapon-speed-cap for 1h is ' + weaponSpeedCap);
		} else {
			return false;
		}
	}
	if ($("#weapon-spe").val() < weaponSpeedMin && $("[name=handed-token]").val() > 0) {
		if (alertMode) {
			alert('weapon-speed-min is ' + weaponSpeedMin);
		} else {
			return false;
		}
	}
	if ($("#resilience").val() > resilienceCap) {
		if (alertMode) {
			alert('resilience-cap is ' + resilienceCap);
		} else {
			return false;
		}
	}
	if ($("#magic-res").val() > magicResCap) {
		if (alertMode) {
			alert('magic-resistance-cap is ' + magicResCap);
		} else {
			return false;
		}
	}
	if (parseInt($("#reg-gem").val()) + parseInt($("#meta-gem").val()) > 3) {
		if (alertMode) {
			alert('max gem-socket-count is 3');
		} else {
			return false;
		}
	}
	if ($("#costs > #statsAdded").text() > 10) {
		if (alertMode) {
			alert('max stat-count is 10');
		} else {
			return false;
		}
	}
	return true;
}

function registerButtons () {
	registerMinusButtons();
	registerPlusButtons();
}

function registerDescrCheckbox () {
	$("#use-description").change(function () {
		if ($(this).prop('checked') == true) {
			enab('descr-color');
			enab('description');
		} else {
			disab('descr-color');
			disab('description');
		}
	});
}

function registerNameCheckbox () {
	$("#use-name").change(function () {
		if ($(this).prop('checked') == true) {
			enab('name-color');
			enab('name');
		} else {
			disab('name-color');
			disab('name');
		}
	});
}

function registerDisplayIdCheckbox () {
	$("#use-display-id").change(function () {
		if ($(this).prop('checked') == true) {
			enab('display-id');
		} else {
			disab('display-id');
		}
	});
}

function registerAbCheckbox () {
	$("#accountbound-checkbox").change(function () {
		amount = $(".custom-control:has(#accountbound-checkbox) > .custom-control-label > small > .prize").text();
		if ($(this).prop('checked') == true) {
			incrToken('accountbound');
			incrCosts(amount);
		} else {
			decrToken('accountbound');
			decrCosts(amount);
		}
		checkSubmitButton();
	});
}
function registerKICheckbox () {
	$("#keep-item-checkbox").change(function () {
		amount = $(".custom-control:has(#keep-item-checkbox) > .custom-control-label > small > .prize").text();
		if ($(this).prop('checked') == true) {
			incrToken('keep-item');
			incrCosts(amount);
		} else {
			decrToken('keep-item');
			decrCosts(amount);
		}
	});
}

function registerRequiredFields () {
	if (isCreateForm()) {
		$("[name=name]").on('input',function () {
			checkSubmitButton();
		});
		$("[name=display-id]").on('input',function () {
			checkSubmitButton();
		});
		$("[name=character-id]").on('input',function () {
			checkSubmitButton();
		});
	} else {
		$("[name=character-id]").on('input',function () {
			checkSubmitButton();
		});
		$("[name=custom-id]").on('input',function () {
			checkSubmitButton();
		});
	}
}

function register () {
	if (isCreateForm()) {
		registerButtons();
		registerDescrCheckbox();
		registerAbCheckbox();
		registerKICheckbox();
		registerRequiredFields();
	} else {
		registerDescrCheckbox();
		registerNameCheckbox();
		registerDisplayIdCheckbox();
		registerRequiredFields();
		registerAbCheckbox();
		registerButtons();
		registerOnLoadCustom();
	}
}

function checkForErrorField (data) {
	if (data.search("alert-danger") > -1) {
		if (data.search("item-base") > -1 || data.search("own the item") > -1)
			errorOnForm("item-base");
		if (data.search("display") > -1)
			errorOnForm("display-id");
		if (data.search("name-color") > -1)
			errorOnForm("name-color");
		if (data.search("item-name") > -1)
			errorOnForm("name");
		if (data.search("character-id") > -1 || data.search("on your account") > -1)
			errorOnForm("character-id");
		if (data.search("item-name") > -1)
			errorOnForm("name");
		if (data.search("description may only") > -1)
			errorOnForm("description");
		if (data.search("description-color") > -1)
			errorOnForm("description-color");
	} else 
		errorOnFormReset();
		if ($("#ajaxContainer").text().search("success") > -1) {
			if (isCreateForm())
				$("#tab-content").remove();
			else {
				nullTokens();
				nullCosts();
				checkSubmitButton();
			}
		}
}