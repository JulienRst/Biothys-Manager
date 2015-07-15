<?php

	require_once('../model/address.php');
	$address = new address($_GET["id"]);

	foreach($_GET as $key => $value){
		if($key != "next"){
			$nkey = "set".ucfirst($key);
			$address->$nkey($value);
		}
	}
	$address->setToDatabase();
	echo(json_encode(array('id' => $address->getId(),'address' => $address->printAddress())));
?>