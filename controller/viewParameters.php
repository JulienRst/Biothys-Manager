<?php
	require_once('../model/parameter.php');
	require_once('../model/extraction.php');

	$extraction = new extraction();

	$parameters = $extraction->get("parameter");

	function compare($a,$b){
		return intval($a->getRef()) - intval($b->getRef());
	}

	usort($parameters,"compare");

	include('../view/parameters.php');

?>