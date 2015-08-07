<?php
	require_once('checkSession.php');
	require_once('../model/product.php');


	$product = new product();


	include('../view/addProduct.php');
?>