<?php

	require_once('../model/extraction.php');
	require_once('../model/customer.php');

	$extraction = new extraction();

	$customers = $extraction->getCustomers();

	include('../view/customers.php');

?>