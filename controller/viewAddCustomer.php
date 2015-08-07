<?php
	require_once('checkSession.php');
	require_once('../model/customer.php');

	$customer = new customer();

	include('../view/addCustomer.php');

?>