<?php
	
	require_once('../model/link_order_product.php');
	$lop = new link_order_product($_GET["id_link_order"]);
	//on fetch les infos
	$id_order = $lop->getId_order();
	$quantity = $_GET["quantity"];
	$price = $_GET["price"];
	$ref_batch = $_GET["ref_batch"];
	if(isset($_GET["parameter"])){
		$id_parameter = $_GET["parameter"];
	}
	$id_product = $_GET["id_product"];

	$quantity_tbd = $_GET["amount_to_be_delivered"];
	$quantity_ad = $_GET["amount_already_delivered"];

	//On monte sur l'objet
	$lop->setAmount($quantity);
	if(isset($_GET["parameter"])){
		$lop->setId_parameter($id_parameter);
	}
	$lop->setPrice_bis($price);
	$lop->setId_product($id_product);
	$lop->setRef_batch($ref_batch);
	$lop->setAmount_already_delivered($quantity_ad);
	$lop->setAmount_to_be_delivered($quantity_tbd);


	//On update en db
	$lop->setToDatabase();


	//On redirige
	header('location:../controller/viewOrder.php?id='.$id_order);

?>