<?php

	require_once('../model/group_products.php');

	$groupProduct = new group_products($_GET['id']);

	foreach($_GET as $key => $value){

		if($key != "next" && $value != ""){
			echo($key.' -> '.$value.'<br/>');
			$nkey = "set".ucfirst($key);
			echo($nkey.'<br/>');
			try {
				$groupProduct->$nkey($value);
			} catch(Exception $e){
				echo('shit');
			}
		}
	}

	$groupProduct->setToDatabase();
	header('location:'.$_GET['next']);

?>