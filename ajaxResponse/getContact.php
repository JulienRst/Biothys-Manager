<?php

	require_once('../model/extraction.php');
	require_once('../model/customer.php');


	$data = $_GET["address"];
	$data = json_decode($data,true);

	$extraction = new extraction();

	$results = $extraction->getCustomersFromCompany($data["idFor"]);

	foreach ($results as $customer) {
		echo('<div class="ctn-addresses">');
		echo('<div class="ctn-address">');
		echo('<p>'.$customer->printText().'<p>');
		echo('</div>');
		echo('<button class=" btn btn-primary sendContact" rel="'.$data["idFor"].'" alt="'.$customer->getId().'"class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>');
		echo('</div>');
	}


?>