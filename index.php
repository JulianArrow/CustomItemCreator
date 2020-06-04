<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.0.0
 */
session_start();
 
require_once('const.inc.php');
require_once('dbconfig.inc.php');
require_once('php-libs/TemplateHelper.class.php');
require_once('php-libs/HTMLUtil.class.php');

new TemplateHelper('/tpl', '.tpl.php', str_replace('\\', '/', __DIR__));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>HavocWow - Custom-Item Form</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<?php
		HTMLUtil::includeScript('jquery', '3rdParty/', '.min.js');
		HTMLUtil::includeScript('popper', '3rdParty/', '.min.js');
		HTMLUtil::includeScript('bootstrap', '3rdParty/', '.min.js');
		HTMLUtil::includeStyle('bootstrap', '3rdParty/', '.min.css');
		HTMLUtil::includeScript('script');
		HTMLUtil::includeStyle('style');
		?>
	</head>
	<body>
		<!-- Modals -->
		<div class="modal fade" id="displayItemEntryModal" tabindex="-1" role="dialog" aria-labelledby="displayItemEntryModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="displayItemEntryModalLabel">Display Item Entry</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Search for the name of an item in our <a href="https://havoc-wow.com/armory">armory</a> and look at the link. If the link is "https://havoc-wow.com/item/1/156105" 156105 is the number to put into this field.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="characterIdModal" tabindex="-1" role="dialog" aria-labelledby="characterIdModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="displayItemEntryModalLabel">Character Id</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Search for the name of the character you got the item-base and want the custom-item on in our <a href="https://havoc-wow.com/armory">armory</a> and look at the link. If the link is "https://havoc-wow.com/character/1/56567" 56567 is the number to put into this field.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="keepItemBaseModal" tabindex="-1" role="dialog" aria-labelledby="keepItemBaseModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="keepItemBaseModalLabel">Keep item-base</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>If you don't check this the item-base gets removed after you got the custom-item.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="itemBaseModal" tabindex="-1" role="dialog" aria-labelledby="itemBaseModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="itemBaseModalLabel">Item-base</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>The item-base may be any donor or vip item available on the webstore or ingame. Weapons and gear farmed in instances are not customizable. The items beginning with a star (*) are the vip items you bought from the ingame vendor. Webstore vip items are without that *. Attention: You may need a new patch-z (downloadable on our Discord server) to use some of your skills.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="customIdModal" tabindex="-1" role="dialog" aria-labelledby="customIdModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="customIdModalLabel">Custom Id</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Search for the name of your existing custom item in our <a href="https://havoc-wow.com/armory">armory</a> and look at the link. If the link is "https://havoc-wow.com/item/1/156105" 156105 is the number to put into this field. After typing in the id click the blue button to confirm the id and make the stats be changeable.</p>
					</div>
				</div>
			</div>
		</div>
		<!-- Modals end -->
		
		<div id="ajaxContainer"></div>
		<div id="content">
			<ul class="nav nav-pills nav-fill flex-column flex-sm-row">
				<li class="flex-sm-fill text-sm-center nav-item">
					<a class="nav-link<?=!isset($_GET['page'])?' active btn-dark':' text-light'?>" href="index.php">Frequently Asked Questions</a>
				</li>
				<li class="flex-sm-fill text-sm-center nav-item">
					<a class="nav-link<?=(isset($_GET['page']) && $_GET['page'] == 'create')?' active btn-dark':' text-light'?>" href="index.php?page=create">Create a new custom-item</a>
				</li>
				<li class="flex-sm-fill text-sm-center nav-item">
					<a class="nav-link<?=(isset($_GET['page']) && $_GET['page'] == 'edit')?' active btn-dark':' text-light'?>" href="index.php?page=edit">Edit an existing custom-item</a>
				</li>
				<li class="flex-sm-fill text-sm-center nav-item">
					<a class="nav-link text-light" href="https://docs.google.com/forms/d/17musG6o4Jbh9-uhhLcNqwfsNHBoZice1tBk2qYym6A4/viewform">Give us feedback!</a>
				</li>
				<li class="flex-sm-fill text-sm-center nav-item">
					<a class="nav-link text-light" href="<?php
					if(!isset($_SESSION['']['id']) || !is_numeric($_SESSION['']['id'])) {
						echo 'https://havoc-wow.com/login">You need to log in'; 
					} else {
						$result = $website->select('account_data', ['id' => $_SESSION['']['id']], 1, 'dp');
						echo 'https://havoc-wow.com/ucp">You\'re logged in (DP: <span id="dp">'.$result['dp'].'</span>)';
					}
					?></a>
				</li>
			</ul>
			<div id="tab-content">
				<?php
				if (!isset($_GET['page']))
					TemplateHelper::getTpl('faq');
				elseif(isset($_GET['page']) && $_GET['page'] == 'create')
					TemplateHelper::getTpl('form-create');
				elseif(isset($_GET['page']) && $_GET['page'] == 'edit')
					TemplateHelper::getTpl('form-edit');
				?>
			</div>
		</div>
		<?php
		if (isset($_GET['page']) && ($_GET['page'] == 'create' || $_GET['page'] == 'edit')) 
			TemplateHelper::getTpl('javascript');
		?>
	</body>
</html>