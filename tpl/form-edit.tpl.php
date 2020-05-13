<?php
/**
 * @package Custom Item Form by Julian Pfeil
 * @copyright Julian Pfeil
 * @author Julian Pfeil
 *
 * @version 1.0.0
 */
 
require_once('php-libs/TextHelper.class.php');
require_once('dbconfig.inc.php');
?>
<form action="submit.php?page=edit" method="post">
	<div class="accordion" id="accordionContent">
		<div class="card text-white bg-dark">
			<div class="card-header" id="headingOne">
				<h5 class="mb-0">
					<button class="btn btn-link text-light" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					Step 1: Change display item enty, name and description
					</button>
				</h5>
			</div>
			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionContent">
				<div class="card-body container">
					<div class="row">
						<div class="col-sm">
							<div class="form-group" id="base-information">
								<!-- Custom Item ID -->
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text">Custom Item ID&nbsp;<a target="_blank" href="https://havoc-wow.com/armory">(armory)</a></span>
									</div>
									<input class="form-control" type="number" name="custom-id" placeholder="Custom Item ID" required>
								</div>
								<!-- Character ID -->
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text">Character ID&nbsp;<a target="_blank" href="https://havoc-wow.com/armory">(armory)</a></span>
									</div>
									<input class="form-control" type="number" name="character-id" placeholder="Character ID" required>
								</div>
								<!-- Display ID -->
								<div class="custom-control custom-checkbox" id="use-display-id-checkbox">
									<input type="checkbox" class="custom-control-input" name="use-display-id" id="use-display-id">
									<label class="custom-control-label" for="use-display-id"><small>Use a new display-id on your item</small></label>
								</div>
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text">Display Item Entry&nbsp;<a target="_blank" href="https://havoc-wow.com/armory">(armory)</a></span>
									</div>
									<input class="form-control" type="number" name="display-id" id="display-id" placeholder="Display Item Entry" disabled>
								</div>
								<!-- Name -->
								<div class="custom-control custom-checkbox" id="use-name-checkbox">
									<input type="checkbox" class="custom-control-input" name="use-name" id="use-name">
									<label class="custom-control-label" for="use-name"><small>Use a new name on your item</small></label>
								</div>
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text">Name</span>
									</div>
									<select class="custom-select custom-select-sm" id="name-color" name="name-color" disabled>
										<?php
										$i = 0 ;
										foreach (colors as $name => $code) {
											echo '<option value="'.$name.'"';
											if ($i++ == 0) echo ' selected';
											echo '>'.ucfirst($name).'</option>';
										}
										?>
									</select>
									<input class="form-control" type="text" id="name" name="name" placeholder="Name of your custom item" disabled>
								</div>
							</div>
						</div>
						<div class="col-sm">
							<div class="form-group" id="description-group">
								<!-- Description -->
								<div class="custom-control custom-checkbox" id="use-description-checkbox">
									<input type="checkbox" class="custom-control-input" name="use-description" id="use-description">
									<label class="custom-control-label" for="use-description"><small>Use a new custom description on your item</small></label>
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
					Step 2: Add primary and common secondary stats
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
					Step 3: Add other stats or make the item accountbound
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
	</div>
	<input type="submit" value="Edit" class="btn btn-dark" id="submitButton" name="submitButton" disabled>
	
</form>
<?php
require_once('tpl/costs.tpl.php');
?>