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
<form id="create" action="submit.php" method="post">
	<div class="accordion" id="accordionContent">
		<div class="card text-white bg-dark">
			<div class="card-header" id="headingOne">
				<h5 class="mb-0">
					<button class="btn btn-link text-light" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					Step 1: Choose item-base, display ID, name and description
					</button>
				</h5>
			</div>
			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionContent">
				<div class="card-body container">
					<div class="row">
						<div class="col-md">
							<div class="form-group" id="base-information">
								<!-- Item Base -->
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text">Item-base</span>
										<button class="btn btn-info" type="button" data-toggle="modal" data-target="#itemBaseModal">?</button>
									</div>
									<select class="custom-select custom-select-sm" name="item-base">
										<option value="none" selected>Choose the item-base...</option>
										<?php
											foreach ($cItems as $cItem) {
												echo '<option value="'.$cItem['entry'].'">'.$cItem['name'].'</option>'."\n";
											}
										?>
									</select>
									<input type="hidden" value="0" name="handed-token" id="handed">
								</div>
								<input type="hidden" value="0" name="keep-item-token" id="keep-item">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="keep-item-checkbox">
									<label class="custom-control-label" for="keep-item-checkbox"><small>Keep the item-base (<span class="prize"><?=keepItem['prize']?></span>&nbsp;DP)</small></label>
								
									<button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#keepItemBaseModal">?</button>
								</div>
								<!-- Display ID -->
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text">Display Item Entry</span>
										<button class="btn btn-info" type="button" data-toggle="modal" data-target="#displayItemEntryModal">?</button>
									</div>
									<input class="form-control" type="number" name="display-id" id="display-id" placeholder="Display Item Entry" required>
								</div>
								<!-- Character ID -->
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text">Character ID</span>
										<button class="btn btn-info" type="button" data-toggle="modal" data-target="#characterIdModal">?</button>
									</div>
									<input class="form-control" type="number" name="character-id" id="character-id" placeholder="Character ID" required>
								</div>
								<!-- Name -->
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text">Name</span>
									</div>
									<select class="custom-select custom-select-sm" name="name-color">
										<?php
										$i = 0 ;
										foreach (colors as $name => $code) {
											echo '<option value="'.$name.'"';
											if ($i++ == 0) echo ' selected';
											echo '>'.ucfirst($name).'</option>';
										}
										?>
									</select>
									<input class="form-control" type="text" name="name" placeholder="Name of your custom item" required>
								</div>
							</div>
						</div>
						<div class="col-md">
							<div class="form-group" id="description-group">
								<!-- Description -->
								<div class="custom-control custom-checkbox" id="use-description-checkbox">
									<input type="checkbox" class="custom-control-input" name="use-description" id="use-description">
									<label class="custom-control-label" for="use-description"><small>Use a custom description on your item</small></label>
								</div>
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text">Description</span>
									</div>
									<select class="custom-select custom-select-sm" name="descr-color" id="descr-color" disabled>
										<?php
										$i = 0 ;
										foreach (colors as $name => $code) {
											echo '<option value="'.$name.'"';
											if ($i++ == 0) echo ' selected';
											echo '>'.ucfirst($name).'</option>';
										}
										?>
									</select>
								</div>
								<textarea class="form-control" id="description" name="description" placeholder="Description of your custom item" rows="3" disabled></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card text-white bg-dark">
			<div class="card-header" id="headingTwo">
				<h5 class="mb-0">
					<button class="btn btn-link text-light collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
					Step 2: Add primary and common secondary stats (optional)
					</button>
				</h5>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionContent">
				<div class="card-body container">
					<div class="row">
						<?php
						require_once('tpl/step-two.tpl.php');
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="card text-white bg-dark">
			<div class="card-header" id="headingThree">
				<h5 class="mb-0">
					<button class="btn btn-link text-light collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
					Step 3: Add other stats and make the item accountbound (optional)
					</button>
				</h5>
			</div>
			<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionContent">
				<div class="card-body container">
					<div class="row">
						<?php
						require_once('tpl/step-three.tpl.php');
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="card text-white bg-dark">
			<div class="card-header" id="headingFour">
				<h5 class="mb-0">
					<button class="btn btn-link text-light collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
					Step 4: Extended options (optional)
					</button>
				</h5>
			</div>
			<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionContent">
				<div class="card-body container">
					<?php
					require_once('tpl/step-four.tpl.php');
					?>
				</div>
			</div>
		</div>
	</div>
	<input type="submit" value="Create" class="btn btn-dark" id="submitButton" name="submitButton" disabled>
	
</form>
<?php
require_once('tpl/costs.tpl.php');
?>