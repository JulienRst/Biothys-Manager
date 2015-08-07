<?php
	require_once("../model/order.php");

	$order = new order($_GET["id"]);
	$bpb = $_GET["bpb"];

	$order->setBilling_period_bis($bpb);
	$order->setToDatabase();

	echo(json_encode(array("success" => true)));
?>