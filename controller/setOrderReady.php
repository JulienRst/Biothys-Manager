<?php

	require_once('../model/order.php');
	$for = $_GET["for"];
	$vari = "set".ucfirst($for);

	$order = new order($_GET["id"]);
	$order->$vari($_GET["val"]);

	$order->setToDatabase();
?>