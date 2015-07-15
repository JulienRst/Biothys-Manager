<?php

	require_once('../model/group_products.php');

	$group_products = new group_products();
	if($_GET["name"] != ""){
		$group_products->setName($_GET["name"]);
		$group_products->addToDatabase();
	}
	
	header('location:'.$_GET["next"]);
?>