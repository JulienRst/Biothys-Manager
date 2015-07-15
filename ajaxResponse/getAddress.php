<?php

	require_once('../model/extraction.php');
	require_once('../model/address.php');

	$extraction = new extraction();

	$results = $extraction->searchForAddress(" ");

	$addresses = array();

	foreach ($results as $address) {
		echo('<div class="ctn-addresses">');
		echo('<div class="ctn-address">');
		echo('<p>'.$address->getLine().' '.$address->getComplement().'<br/>'.$address->getZip().' '.$address->getCity().'<br/>'.$address->getState().' '.$address->getCountry());
		echo('</div>');
		echo('<button class="sendAddress" rel="'.$_GET["idem"].'" alt="'.$address->getId().'"class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>');
		echo('</div>');
	}




?>