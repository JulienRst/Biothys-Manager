<?php
	require_once('../model/address.php');
	require_once('../model/employee.php');
	$address = new address();

	foreach($_GET as $key => $value){
		if($key != "next" && $key != "idem"){
			$nkey = "set".ucfirst($key);
			$address->$nkey($value);
		}
	}
	$address->addToDatabase();
	$employee = new employee($_GET["idem"]);
	$employee->setId_address($address->getId());
	$employee->setToDatabase();
	echo(json_encode(array('id' => $address->getId(),'address' => $address->printAddress())));

?>