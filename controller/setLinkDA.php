<?php

	require_once('../model/address.php');

	$address = new address();
	foreach($_GET as $key => $value){
		if($key != "idA" && $key != "idC" && $value != ""){
			echo($key.' -> '.$value.'<br/>');
			$nkey = "set".ucfirst($key);
			echo($nkey.'<br/>');
			try {
				$address->$nkey($value);
			} catch(Exception $e){
				echo('shit');
			}
		}
	}

	$address->setId($_GET["idA"]);
	$address->setToDatabase();
	header('location:viewCompany.php?id='.$_GET["idC"]);
	exit();
?>