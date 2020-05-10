function incr (id, amount) {
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
		if ($("#" + id + "-minus").prop('disabled') === false) 
			disab(id + '-minus');
	});
}

function nullCosts() {
	$("#costs > span").text(0);
}

function nullStats () {
	ids.forEach(function(id) {
		$("#" + id).val('0');
	});
	enab('accountbound-checkbox');
	resetAbCheckbox();
	resetKeepCheckbox();
	nullTokens();
	nullCosts();
}

function noStats() {
	ids.forEach(function(id) {
		$("#" + id).val('');
	});
	disab('accountbound-checkbox');
	resetAbCheckbox();
	resetKeepCheckbox();
	nullTokens();
	nullCosts();
}

function resetAbCheckbox() {
	stat('accountbound', 0);
	$("#accountbound-checkbox").prop('checked', false);	
}

function resetKeepCheckbox() {
	stat('keep-item', 0);
	$("#keep-item-checkbox").prop('checked', false);	
}

function incrCosts (amount) {
	$("#costs > span").text(Number($("#costs > span").text()) + Number(amount));
}

function decrCosts (amount) {
	$("#costs > span").text(Number($("#costs > span").text()) - Number(amount));
}

function buy (id) {
	if ($("[name=" + id + "-token]").val() == 0) {
		enab(id + '-minus');
	}
	amount = $("#" + id + "-plus > .amount").text();
	incr(id, amount);
	incrToken(id);
	incrCosts(Number($(".input-group-prepend:has(#" + id + "-plus) > .input-group-text > .prize").text()));
	checkSubmitButton();
}

function notBuy (id) {
	amount = $("#" + id + "-plus > .amount").text();
	decr(id, amount);
	decrToken(id);
	decrCosts(Number($(".input-group-prepend:has(#" + id + "-plus) > .input-group-text > .prize").text()));
	if ($("[name=" + id + "-token]").val() == 0) {
		disab(id + '-minus');
	}
	checkSubmitButton();
}

function enabStats () {
	ids.forEach(function(id) {
		enab(id + '-plus');
		if ($("[name=" + id + "-token]").val() > 0) {
			enab(id + '-minus');
		}
	});
}

function disabStats () {
	ids.forEach(function(id) {
		disab(id + '-plus');
		if ($("[name=" + id + "-token]").val() > 0) {
			disab(id + '-minus');
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
				notBuy(id);
			}
		});
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
		if (Number($("#costs > span").text()) > 0 && $("[name=character-id]").val() != '' && $("[name=custom-id]").val() != '' && checkCaps()) {
			enab('submitButton');
		} else {
			disab('submitButton');
		}
	} else {
		if (Number($("#costs > span").text()) > 0 && $("[name=character-id]").val() != '' && $("[name=name]").val() != '' && checkCaps() && $("[name=display-id]").val() != '' && $("[name=character-id]").val() != '') {
			enab('submitButton');
		} else {
			disab('submitButton');
		}
	}
}

function checkCaps () {
	if (($("#stamina").val() > mainStatCap) || ($("#agility").val() > mainStatCap) || ($("#spirit").val() > mainStatCap) || ($("#intelligence").val() > mainStatCap) || ($("#strength").val() > mainStatCap)) {
		alert('main-stat-cap is ' + mainStatCap);
		return false;
	}
	if ($("#haste").val() > hasteCap) {		
		alert('haste-cap is ' + hasteCap);
		return false;
	}
	if ($("#weapon-dmg").val() > weaponDamageCap) {
		alert('weapon-damage-cap is ' + weaponDamageCap);
		return false;
	}
	if ($("#weapon-spe").val() > weaponSpeed2hCap) {
		alert('weapon-speed-cap for 2h is ' + weaponSpeed2hCap + ' and for 1h is ' + weaponSpeedCap);
		return false;
	}
	if ($("#resilience").val() > resilienceCap) {
		alert('resilience-cap is ' + resilienceCap);
		return false;
	}
	if ($("#magic-res").val() > magicResCap) {
		alert('magic-resistance-cap is ' + magicResCap);
		return false;
	}
	if (parseInt($("#reg-gem").val()) + parseInt($("#meta-gem").val()) > 3) {
		alert('max gem-socket-count is 3');
		return false;
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
	}
}