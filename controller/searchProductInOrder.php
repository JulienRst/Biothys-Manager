<?php

	require_once('../model/extraction.php');
	require_once('../model/product.php');

	$extraction = new extraction();

	$needle = $_GET["needle"];

	$results = $extraction->getProductForOrder($needle);

	$json = array();


	foreach($results as $result){
		$group = $result->getGroup_product();
		if(count($group->getParameters()) != 0){
			$isParameter = true;
			$parameters = $group->getJSONParameters();
		} else {
			$isParameter = false;
			$parameters = null;
		}
		$item = array("id" => $result->getId(),"text" => $result->getName().' '.$result->getDescription(),"price" => $result->getPrice(),"isParameter" => $isParameter,"parameters" => $parameters);
		array_push($json,$item);
	}

	$json = json_encode($json,JSON_FORCE_OBJECT);
	echo($json);
?>