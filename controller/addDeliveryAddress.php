<?php
	
	require_once('../model/address.php');
	require_once('../model/link_company_delivery_address.php');

	//Création et ajout de l'adresse dans la base de données

	if($_GET){
		$naddress = new address();
		foreach($_GET as $key => $value){
			if($key != "id_company"){
				$nattr = "set".ucfirst($key);
				$naddress->$nattr($value);
			}
		}

		$naddress->addToDatabase();
		$id_address = $naddress->getId();
		$id_company = $_GET["id_company"];

		$nlcda = new link_company_delivery_address();
		$nlcda->setId_company($id_company);
		$nlcda->setId_address($id_address);
		$nlcda->addToDatabase();
	}


?>