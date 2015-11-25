<?php 

	require_once('../model/company.php');

	$company = new company($_GET["id"]);

	if(count($company->getDelivery_addresses()) != 0){
		foreach($company->getDelivery_addresses() as $da){
			echo('<div class="inline">');
				echo('<div>'.$da->printAddress().'</div>');
				echo('<div class="block-button">');
					echo('<a href="deleteLinkDA.php?idA='.$da->getId().'&idC='.$company->getId().'"><button class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>');
				//echo('<a href="setLinkDA.php?idA='.$da->getId().'&idC='.$company->getId().'"><button class="btn btn-danger"></button></a>');
					echo('<br/>');
					echo('<button rel="'.$da->getId().'" alt="'.$company->getId().'" class="setDA btn btn-primary"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button>');
				echo('</div>');
			echo('</div>');
		}
	} else {
		echo('<p>No delivery address for now</p>');
	}

	echo('
		<br/><br/>
		<button rel="'.$company->getId().'" class="btn btn-success add_delivery_address">Add a delivery address</button>
	');

	echo('<br/><br/>');
?>