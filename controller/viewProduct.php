<?php
	require_once('../model/error.php');
	require_once('../model/product.php');
	require_once('checkSession.php');

	if(isset($_GET["id"])){
		$product = new product($_GET["id"]);
		if($product == NULL){
			$error;
		}
	} else {
		$error;
	}

	include('../view/product.php');
?>