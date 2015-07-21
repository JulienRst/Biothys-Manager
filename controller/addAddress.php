<?php
	$data = $_GET["address"];
	$data = json_decode($data,true);


	$idFor = $data['idFor'];
	$class = $data['for'];
	$step = $data['step'];

	require_once('../model/address.php');
	require_once('../model/'.$class.'.php');

	$address = new address();

	foreach($_GET as $key => $value){
		if($key != "next" && $key != "address"){
			$nkey = "set".ucfirst($key);
			$address->$nkey($value);
		}
	}
	$address->addToDatabase();

	$item = new $class($idFor);
	$method = "setId_".$step;
	$item->$method($address->getId());
	$item->setToDatabase();

	$result = array('idAddress' => $address->getId(),'address' => $address->printAddress());
	echo(json_encode($result));

?>