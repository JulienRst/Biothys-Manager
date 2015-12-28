<?php
    require('../model/company.php');


	$item = new customer();

    //AJOUT DU CUSTOMER DANS LA BDD AVEC POUR ENTREPRISE CELLE DE DEPART

	if($_GET){
		foreach($_GET as $key => $value){
			if($key != "next" && $key != "class"){
				$nattr = "set".ucfirst($key);
				$item->$nattr($value);
			}
		}
	}

    $id_customer = $item->addToDatabase();

    //MODIFICATION DE L'ENTREPRISE

    $id_company = $_GET['id_company'];

    $nc = new company($id_company);
    $nc->setId_contact($id_customer);
    $nc->setToDatabase();
    header('location:../controller/viewCompany.php?id='.$id_company);
    exit();
?>
