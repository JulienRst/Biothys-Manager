<?php

	require_once('../model/order.php');
	$id_o = $_GET["id"];

	$o = new order($id_o);

	$o->readyToInvoice();

	header('location:viewOrder.php?id='.$id_o);
	exit();

?>