<?php

	require_once('../model/extraction.php');
	require_once('../model/company.php');


	$data = $_GET["address"];
	$data = json_decode($data,true);

	$extraction = new extraction();

	$results = $extraction->get('company');

	foreach ($results as $company) {
		echo('<div class="ctn-addresses">');
		echo('<div class="ctn-address">');
		echo('<p>'.$company->printText().'<p>');
		echo('</div>');
		echo('<button class=" btn btn-primary sendCompany" rel="'.$data["idFor"].'" alt="'.$company->getId().'"class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>');
		echo('</div>');
	}


?>