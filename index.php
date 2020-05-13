<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.0.0
 */
 
require_once('const.inc.php');
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
		HTMLUtil::includeScript('jquery', '3rdParty/', '.slim.min.js');
		HTMLUtil::includeScript('popper', '3rdParty/', '.min.js');
		HTMLUtil::includeScript('bootstrap', '3rdParty/', '.min.js');
		HTMLUtil::includeStyle('bootstrap', '3rdParty/', '.min.css');
		HTMLUtil::includeScript('script');
		HTMLUtil::includeStyle('style');
		?>
	</head>
	<body>
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