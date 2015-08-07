<?php 

	require_once('../model/company.php');

	$company = new company($_GET["id"]);

	if(count($company->getDelivery_addresses()) != 0){
		foreach($company->getDelivery_addresses() as $da){
			echo('<div>'.$da->printAddress().'</div>');
		}
	} else {
		echo('<p>No delivery address for now</p>');
	}

	echo('
		<button rel="'.$company->getId().'" class="btn btn-success add_delivery_address">Add a delivery address</button>
	');

	echo('<br/><br/>');
?>