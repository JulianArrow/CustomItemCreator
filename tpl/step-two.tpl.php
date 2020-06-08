<div class="col-lg">
	<div class="form-group" id="primary-stats">
		<!-- Stamina -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Stamina (<span class="prize"><?=stats['7']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="stamina-plus" disabled>+ <span class="amount"><?=stats['7']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="stamina" readonly>
			<input type="hidden" value="0" name="stamina-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="stamina-minus" disabled>-</button>
			</div>
		</div>
		<!-- Strength -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Strength (<span class="prize"><?=stats['4']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="strength-plus" disabled>+ <span class="amount"><?=stats['4']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="strength" readonly>
			<input type="hidden" value="0" name="strength-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="strength-minus" disabled>-</button>
			</div>
		</div>
		<!-- Intellect -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Intellect (<span class="prize"><?=stats['5']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="intellect-plus" disabled>+ <span class="amount"><?=stats['5']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="intellect" readonly>
			<input type="hidden" value="0" name="intellect-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="intellect-minus" disabled>-</button>
			</div>
		</div>
		<!-- Agility -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Agility (<span class="prize"><?=stats['3']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="agility-plus" disabled>+ <span class="amount"><?=stats['3']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="agility" readonly>
			<input type="hidden" value="0" name="agility-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="agility-minus" disabled>-</button>
			</div>
		</div>
		<!-- Spirit -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Spirit (<span class="prize"><?=stats['6']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="spirit-plus" disabled>+ <span class="amount"><?=stats['6']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="spirit" readonly>
			<input type="hidden" value="0" name="spirit-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="spirit-minus" disabled>-</button>
			</div>
		</div>
	</div>
</div>
<div class="col-lg">
	<div class="form-group" id="secondary-stats">
		<!-- Haste -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Haste Rating (<span class="prize"><?=stats['36']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="haste-plus" disabled>+ <span class="amount"><?=stats['36']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="haste" readonly>
			<input type="hidden" value="0" name="haste-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="haste-minus" disabled>-</button>
			</div>
		</div>
		<!-- Parry -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Parry Rating (<span class="prize"><?=stats['14']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="parry-plus" disabled>+ <span class="amount"><?=stats['14']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="parry" readonly>
			<input type="hidden" value="0" name="parry-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="parry-minus" disabled>-</button>
			</div>
		</div>
		<!-- Hit -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Hit Rating (<span class="prize"><?=stats['31']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="hit-plus" disabled>+ <span class="amount"><?=stats['31']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="hit" readonly>
			<input type="hidden" value="0" name="hit-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="hit-minus" disabled>-</button>
			</div>
		</div>
		<!-- Critical -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Critical Strike Rating (<span class="prize"><?=stats['32']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="crit-plus" disabled>+ <span class="amount"><?=stats['32']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="crit" readonly>
			<input type="hidden" value="0" name="crit-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="crit-minus" disabled>-</button>
			</div>
		</div>
		<!-- Dodge -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Dodge Rating (<span class="prize"><?=stats['13']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="dodge-plus" disabled>+ <span class="amount"><?=stats['13']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="dodge" readonly>
			<input type="hidden" value="0" name="dodge-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="dodge-minus" disabled>-</button>
			</div>
		</div>
		<!-- Defense -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Defense Rating (<span class="prize"><?=stats['12']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="defense-plus" disabled>+ <span class="amount"><?=stats['12']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="defense" readonly>
			<input type="hidden" value="0" name="defense-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="defense-minus" disabled>-</button>
			</div>
		</div>
		<!-- Block -->
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Block Rating (<span class="prize"><?=stats['15']['prize']?></span>&nbsp;DP)</span>
				<button class="btn btn-secondary" type="button" id="block-plus" disabled>+ <span class="amount"><?=stats['15']['amount']?></span></button>
			</div>
			<input class="form-control" type="number" placeholder="No base set" id="block" readonly>
			<input type="hidden" value="0" name="block-token">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="button" id="block-minus" disabled>-</button>
			</div>
		</div>
	</div>
</div>