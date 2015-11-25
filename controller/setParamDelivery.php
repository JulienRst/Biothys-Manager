<?php

	require_once('../model/order.php');

	$order = new order($_GET["id"]);

	$param_delivery = json_decode($order->getParam_delivery(),true);

	foreach($_GET as $key => $value){
		if($key != "id"){
			$param_delivery[$key] = $value;
		}
	}

	$param_delivery = json_encode($param_delivery);

	$order->setParam_delivery($param_delivery);
	$order->setToDatabase();

	header('location:../controller/viewOrder.php?id='.$_GET["id"]);
	exit();
?>