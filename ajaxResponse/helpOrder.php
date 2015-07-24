<?php

	require_once('../model/extraction.php');
	require_once('../model/'.$_GET["class"].'.php');

	$extraction = new extraction();

	$needle = strtolower($_GET["needle"]);

	$results = $extraction->searchFor($_GET["class"],$needle);

	$json = array();
	if($_GET["class"] == "company"){
		foreach($results as $result){
			$item = array("id" => $result->getId(),"text" => $result->printText(),"billing_period_bis" => $result->getNormal_billing_period());
			array_push($json,$item);
		}
	} else {
		foreach($results as $result){
			$item = array("id" => $result->getId(),"text" => $result->printText());
			array_push($json,$item);
		}
	}
	

	$json = json_encode($json,JSON_FORCE_OBJECT);
	echo($json);
?>