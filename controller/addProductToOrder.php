<?php

	require_once('../model/link_order_product.php');

	$id_order = $_GET["id_order"];
	$quantity = $_GET["quantity"];
	$price = $_GET["price"];
	$ref_batch = $_GET["ref_batch"];
	if(isset($_GET["parameter"])){
		$id_parameter = $_GET["parameter"];
	}
	$id_product = $_GET["id_product"];

	$lop = new link_order_product();

	$lop->setId_order($id_order);
	$lop->setAmount($quantity);
	if(isset($_GET["parameter"])){
		$lop->setId_parameter($id_parameter);
	}
	$lop->setPrice_bis($price);
	$lop->setId_product($id_product);
	$lop->setRef_batch($ref_batch);

	$lop->addToDatabase();

	header('location:../controller/viewOrder.php?id='.$id_order);

?>