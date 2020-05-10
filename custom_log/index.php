<?php
/**
 * @author Julian Pfeil
 * @version 1.0.0
 */
 
require_once('../php-libs/HTMLUtil.class.php');
HTMLUtil::includeStyle('bootstrap', '../3rdParty/', '.min.css');

#login
if (!isset($_GET['pw']) || md5($_GET['pw']) != 'e458a709ef6ab4cbf4ad187b547f7d6d') 
	die(HTMLUtil::bootstrapAlert('wrong password'));

require_once('../dbconfig.inc.php');

$results = $website->select('custom_form_log', [], -1, '*', 'log_id', true);
?>
<table class="table table-bordered" style="margin: 8px auto; max-width: 75%;">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Account</th>
			<th scope="col">Character</th>
			<th scope="col">Weapon-Entry</th>
			<th scope="col">Weapon-Name</th>
			<th scope="col">Weapon-Description</th>
			<th scope="col">Costs</th>
			<th scope="col">Receipt</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach ($results as $result) {
	echo '	<tr>
			  <th scope="row">'.$result['log_id'].'</th>
			  <td>'.$result['character_id'].'</td>
			  <td>'.$result['account_id'].'</td>
			  <td>'.$result['weapon_entry'].'</td>
			  <td>'.$result['name'].'</td>
			  <td>'.$result['description'].'</td>
			  <td>'.$result['costs'].'</td>
			  <td>'.$result['receipt'].'</td>
			</tr>';
}
?>
	</tbody>
</table>