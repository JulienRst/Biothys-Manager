<?php

	require_once('../model/product.php');

	$product = new product();

	foreach($_GET as $key => $value){
		if($key != "next"){
			$nkey = "set".ucfirst($key);
			$product->$nkey($value);
		}
	}

	$product->addToDatabase();

	header('location:'.$_GET['next']);
?>