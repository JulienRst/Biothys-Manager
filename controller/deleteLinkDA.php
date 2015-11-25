<?php
	require_once('../model/link_company_delivery_address.php');
	require_once('../model/database.php');

	$id_a = $_GET["idA"];
	$id_c = $_GET["idC"];

	$pdo = database::getInstance();
	$pdo = $pdo->PDOInstance;

	$stmt = $pdo->prepare('SELECT id FROM link_company_delivery_address WHERE id_company = :idc and id_address = :ida');
	$stmt->bindParam(':idc',$id_c);
	$stmt->bindParam(':ida',$id_a);

	$stmt->execute();

	$result = $stmt->fetch();
	$idLDA = $result['id'];

	$lda = new link_company_delivery_address($idLDA);

	$lda->eraseOfDatabase();

	header('location:../controller/viewCompany.php?id='.$id_c);
	exit();
?>