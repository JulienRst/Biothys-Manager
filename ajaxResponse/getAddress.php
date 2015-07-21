<?php

	require_once('../model/extraction.php');
	require_once('../model/address.php');

	$extraction = new extraction();

	$data = $_GET["address"];
	$data = json_decode($data,true);

	$results = $extraction->searchForAddress(" ");

	foreach ($results as $address) {
		echo('<div class="ctn-addresses">');
		echo('<div class="ctn-address">');
		echo('<p>'.$address->getLine().' '.$address->getComplement().'<br/>'.$address->getZip().' '.$address->getCity().'<br/>'.$address->getState().' '.$address->getCountry());
		echo('</div>');
		echo('<button class=" btn btn-primary sendAddress" rel="'.$data["idFor"].'" alt="'.$address->getId().'"class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>');
		echo('</div>');
	}




?>