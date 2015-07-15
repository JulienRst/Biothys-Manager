<?php

	require_once('../model/group_products.php');
	try {
		$id = $_GET["id"];
	} catch (Exception $e){
		header('location:viewGroupProducts.php');
		exit();
	}

	$group_products = new group_products($id);

	$group_products->eraseOfDatabase();	

	header('location:viewGroupProducts.php');
	exit();



?>