<?php

	require_once('../model/product.php');
	try {
		$id = $_GET["id"];
	} catch (Exception $e){
		header('location:viewProducts.php');
		exit();
	}

	$product = new product($id);

	$product->eraseOfDatabase();	

	header('location:viewProducts.php');
	exit();



?>