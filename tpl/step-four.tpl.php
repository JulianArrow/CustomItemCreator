<div class="row">
	<div class="col-sm">
		<div class="form-group" id="item-type-group">
			<input type="hidden" value="0" name="class-token">
			<input type="hidden" value="0" name="subclass-token">
			<input type="hidden" value="0" name="inventory-type-token">
			<select class="custom-select custom-select-sm" name="item-type" id="item-type" disabled>
				<option value="" selected>Change item-type (optional)</option>
				<option value="head" class="armor">Head</option>
				<option value="neck" class="jewellery">Neck</option>
				<option value="shoulder" class="armor">Shoulder</option>
				<option value="shirt" class="clothing">Shirt</option>
				<option value="chest" class="armor">Chest</option>
				<option value="waist" class="armor">Waist</option>
				<option value="legs" class="armor">Legs</option>
				<option value="feet" class="armor">Feet</option>
				<option value="wrists" class="armor">Wrists</option>
				<option value="hands" class="armor">Hands</option>
				<option value="finger" class="jewellery">Finger</option>
				<option value="trinket" class="jewellery">Trinket</option>
				<option value="back" class="jewellery">Back</option>
				<option value="tabard" class="clothing">Tabard</option>
				<option value="libram" class="relic">Libram</option>
				<option value="sigil" class="relic">Sigil</option>
				<option value="idol" class="relic">Idol</option>
				<option value="totem" class="relic">Totem</option>
				<option value="thrown" class="range">Thrown</option>
				<option value="bow" class="range">Bow</option>
				<option value="wand" class="range">Wand</option>
				<option value="ohaxe" class="melee">One handed Axe</option>
				<option value="thaxe" class="melee">Two handed Axe</option>
				<option value="ohmace" class="melee">One handed Mace</option>
				<option value="thmace" class="melee">Two handed Mace</option>
				<option value="ohsword" class="melee">One handed Sword</option>
				<option value="thsword" class="melee">Two handed Sword</option>
				<option value="polearm" class="melee">Polearm</option>
				<option value="staff" class="melee">Staff</option>
				<option value="dagger" class="melee">Dagger</option>
				<option value="fist" class="melee">Fist Weapon</option>
			</select>
		</div>
	</div>
	<div class="col-sm">
		<div class="form-group" id="accountbound-group">
			<input type="hidden" value="0" name="accountbound-token" id="accountbound">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="accountbound-checkbox" disabled>
				<label class="custom-control-label" for="accountbound-checkbox"><small>Make the custom item accountbound (<span class="prize"><?=stats['E']['prize']?></span>&nbsp;DP)</small></label>
			</div>
			
			<input type="hidden" value="0" name="cloth-token" id="cloth">
			<div class="custom-control custom-checkbox" id="cloth-control">
				<input type="checkbox" class="custom-control-input" id="cloth-checkbox" disabled>
				<label class="custom-control-label" for="cloth-checkbox"><small>Make the custom armor cloth and remove class restrictions</small></label>
			</div>
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-sm-12">
		<input type="hidden" value="1" name="merge-token" id="merge-count">
		<div class="form-group merge-group" data-number="1">
			<div class="row">
				<div class="col-sm">
					<select class="custom-select custom-select-sm mergeSelect" name="mergeSelect1" disabled>
						<option value="" selected>Select a stat...</option>
						<option value="stamina" class="mainStat">Stamina</option>
						<option value="strength" class="mainStat">Strength</option>
						<option value="intellect" class="mainStat">Intellect</option>
						<option value="agility" class="mainStat">Agility</option>
						<option value="spirit" class="mainStat">Spirit</option>
						<option value="haste" class="secStat">Haste Rating</option>
						<option value="parry" class="secStat">Parry Rating</option>
						<option value="hit" class="secStat">Hit Rating</option>
						<option value="crit" class="secStat">Critical Strike Rating</option>
						<option value="dodge" class="secStat">Dodge Rating</option>
						<option value="defense" class="secStat">Defense Rating</option>
						<option value="block" class="secStat">Block Rating</option>
						<option value="armor-pen" class="secStat">Armor Penetration</option>
						<option value="spell-pen" class="secStat">Spell Penetration</option>
						<option value="resilience" class="secStat">Resilience</option>
						<option value="attack-power" class="mainStat">Attack Power</option>
						<option value="spell-power" class="mainStat">Spell Power</option>
						<option value="expertise" class="secStat">Expertise</option>
					</select>
				</div>
				<div class="col-sm range-col">
					<input type="range" class="statInput" name="statInput1" id="statInput1" value="10" step="10" min="10" max="1000" oninput="statOutput1.value = statInput1.value" disabled>
					<br><output class="statOutput badge badge-primary" id="statOutput1">10</output>
					<span class="badge badge-info">&nbsp;&#11208;&nbsp;</span>
				</div>
				<div class="col-sm">
					<select class="custom-select custom-select-sm mergeSelectB" name="mergeSelectB1" disabled>
						<option value="" selected>Select a stat...</option>
						<option value="stamina" class="mainStat">Stamina</option>
						<option value="strength" class="mainStat">Strength</option>
						<option value="intellect" class="mainStat">Intellect</option>
						<option value="agility" class="mainStat">Agility</option>
						<option value="spirit" class="mainStat">Spirit</option>
						<option value="haste" class="secStat">Haste Rating</option>
						<option value="parry" class="secStat">Parry Rating</option>
						<option value="hit" class="secStat">Hit Rating</option>
						<option value="crit" class="secStat">Critical Strike Rating</option>
						<option value="dodge" class="secStat">Dodge Rating</option>
						<option value="defense" class="secStat">Defense Rating</option>
						<option value="block" class="secStat">Block Rating</option>
						<option value="armor-pen" class="secStat">Armor Penetration</option>
						<option value="spell-pen" class="secStat">Spell Penetration</option>
						<option value="resilience" class="secStat">Resilience</option>
						<option value="attack-power" class="mainStat">Attack Power</option>
						<option value="spell-power" class="mainStat">Spell Power</option>
						<option value="expertise" class="secStat">Expertise</option>
					</select>
				</div>
			</div>
		<hr>
		</div>
		<div class="row justify-content-sm-center" id="mergeStatCountButtons">
			<button type="button" class="btn btn-primary" id="addStat">+</button>
			&nbsp;&nbsp;
			<button type="button" class="btn btn-danger" id="removeStat">-</button>
		</div>
	</div>
</div>