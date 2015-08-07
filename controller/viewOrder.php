<?php
	require_once('checkSession.php');
	require_once('../model/order.php');

	$order = new order($_GET["id"]);
	$company = new company($order->getId_company());
	$employee_ = new employee($order->getId_employee());

	include('../view/order.php');

?>