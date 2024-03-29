<div class="col-lg">
	<div class="form-group" id="penetration">
		<!-- Armor Penetration -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Armor Penetration (<span class="prize"><?=stats['44']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="armor-pen-plus" disabled>+ <span class="amount"><?=stats['44']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="armor-pen" readonly>
			<input type="hidden" value="0" name="armor-pen-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="armor-pen-minus" disabled>-</button>
			</div>
		</div>
		<!-- Spell Penetration -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Spell Penetration (<span class="prize"><?=stats['47']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="spell-pen-plus" disabled>+ <span class="amount"><?=stats['47']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="spell-pen" readonly>
			<input type="hidden" value="0" name="spell-pen-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="spell-pen-minus" disabled>-</button>
			</div>
		</div>
	</div>
	<div class="form-group" id="weapon">
		<!-- Weapon Speed -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Weapon Speed (<span class="prize"><?=stats['B']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="weapon-spe-plus" disabled>+ <span class="amount"><?=stats['B']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="weapon-spe" readonly>
			<input type="hidden" value="0" name="weapon-spe-token">
			<div class="input-group-append">
				<button class="btn btn-secondary" type="button" id="weapon-spe-minus" disabled>- <span class="amount"><?=stats['B']['amount']?></span></button>
			</div>
		</div>
		<!-- Weapon Damage -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Weapon Damage (<span class="prize"><?=stats['A']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="weapon-dmg-plus" disabled>+ <span class="amount"><?=stats['A']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="weapon-dmg" readonly>
			<input type="hidden" value="0" name="weapon-dmg-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="weapon-dmg-minus" disabled>-</button>
			</div>
		</div>
	</div>
	<div class="form-group" id="resilience-stat">
		<!-- Resilience -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Resilience (<span class="prize"><?=stats['35']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="resilience-plus" disabled>+ <span class="amount"><?=stats['35']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="resilience" readonly>
			<input type="hidden" value="0" name="resilience-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="resilience-minus" disabled>-</button>
			</div>
		</div>
	</div>
	<div class="form-group" id="power">
		<!-- Attack Power -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Attack Power (<span class="prize"><?=stats['38']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="attack-power-plus" disabled>+ <span class="amount"><?=stats['38']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="attack-power" readonly>
			<input type="hidden" value="0" name="attack-power-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="attack-power-minus" disabled>-</button>
			</div>
		</div>
		<!-- Spell Power -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Spell Power (<span class="prize"><?=stats['45']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="spell-power-plus" disabled>+ <span class="amount"><?=stats['45']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="spell-power" readonly>
			<input type="hidden" value="0" name="spell-power-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="spell-power-minus" disabled>-</button>
			</div>
		</div>
	</div>
</div>
<div class="col-lg">
	<div class="form-group" id="expertise-stats">
		<!-- Expertise -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Expertise (<span class="prize"><?=stats['37']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="expertise-plus" disabled>+ <span class="amount"><?=stats['37']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="expertise" readonly>
			<input type="hidden" value="0" name="expertise-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="expertise-minus" disabled>-</button>
			</div>
		</div>
	</div>
	<div class="form-group" id="armor-stats">
		<!-- Armor -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Armor (<span class="prize"><?=stats['F']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="armor-plus" disabled>+ <span class="amount"><?=stats['F']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="armor" readonly>
			<input type="hidden" value="0" name="armor-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="armor-minus" disabled>-</button>
			</div>
		</div>
	</div>
	<div class="form-group" id="magic-resistance">
		<!-- Magic Resistance -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Magic Resistance (<span class="prize"><?=stats['G']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="magic-res-plus" disabled>+ <span class="amount"><?=stats['G']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="magic-res" readonly>
			<input type="hidden" value="0" name="magic-res-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="magic-res-minus" disabled>-</button>
			</div>
		</div>
	</div>
	<div class="form-group" id="gem-slots">
		<!-- Regular Gem Slot -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Regular Gem Slots (<span class="prize"><?=stats['C']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="reg-gem-plus" disabled>+ <span class="amount"><?=stats['C']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="reg-gem" readonly>
			<input type="hidden" value="0" name="reg-gem-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="reg-gem-minus" disabled>-</button>
			</div>
		</div>
		<!-- Meta Gem Slot -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Meta Gem Slots (<span class="prize"><?=stats['D']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="meta-gem-plus" disabled>+ <span class="amount"><?=stats['D']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="meta-gem" readonly>
			<input type="hidden" value="0" name="meta-gem-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="meta-gem-minus" disabled>-</button>
			</div>
		</div>
	</div>
</div>