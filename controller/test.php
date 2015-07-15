<?php
	require_once('../model/address.php');
	require_once('../model/extraction.php');

	$extraction = new extraction();

	$result = $extraction->searchForAddress("Torcy");

	print_r($result);
	
?>