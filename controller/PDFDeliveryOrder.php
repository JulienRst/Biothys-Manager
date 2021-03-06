<?php
	session_start();
	//REQUIRE
	require_once('../model/order.php');
	require_once('../model/company.php');
	require_once('../model/extraction.php');
	require_once('../model/employee.php');
	require_once('getText.php');
	require_once('../vendor/fpdf17/fpdf.php');


	//Initialisation des objets à utiliser
	$employee = new employee($_SESSION["employee"]);
	$order = new order($_GET['id']);
	$param_delivery = json_decode($order->getParam_delivery(),true);
	$company = new company($order->getId_company());
	$receiving_address = new address($company->getId_receiving_address());
	$tf->language = "GER"; // à modifier
	//////////////////////////////////////////////
	$typedocument = 5; // Bon de livraison
	//////////////////////////////////////////////

	// Génération du n° Document

	function generateIdDoc($type,$company,$order){
		//[X : typedocument][XX : Year][X : country][XXXX : id commande]
		$year = date('y');
		$country = 5;
		$nb_bl = $_GET['nb'];
		$typedocument = $type;

		$country_company = $company->getNationality();
		$extraction = new extraction();
		$allPartners = $extraction->get('partner');
		$id_order = $order->getRef();
		$id_to_print = "";
		$count = strlen((string) $id_order);
		for($i=0;$i< 4-($count);$i++){
			$id_to_print .= "0";
		} 
		$id_to_print .= $id_order;
		foreach ($allPartners as $partner) {
			if($partner->getCountry() == $country_company){
				$country = $partner->getRef();
				break;
			}
		}
		//id commande à replacer par référence commande quand ce sera fait
		$id_document = $typedocument.$year.$country.$id_to_print;

		if($nb_bl != "" && $nb_bl != 0){
			$id_document.= '-'.$nb_bl;
		}


		return $id_document;
	}

		
	//Extends de class by fpdp itself
	//Permet de créer le premier tableau et le deuxième
	class PDF extends FPDF {
		// Chargement des données
		function LoadData($file){
			// Lecture des lignes du fichier
			$lines = file($file);
			$data = array();
			foreach($lines as $line)
				$data[] = explode(';',trim($line));
			return $data;
		}
		// Tableau simple
		function FirstTable($data){
			// Données
			foreach($data as $row){ 
				$count = 0;
				foreach($row as $col){
					if($count == 2){
						 $this->Cell(100,6,$col,0,0,'R');
					} else {
						 $this->Cell(40,6,$col,0,0,'L');
					}
					$count ++;
				}
				$this->Ln();
			}
		}


		function SecondTable($order){
			$company = new company($order->getId_company());
			$this->SetFillColor(82,189,236);
			$this->SetTextColor(255);
			$this->SetDrawColor(183,183,183);
			$this->SetLineWidth(.3);
			$this->SetFont('Arial','',10);
			////////////////////////////////////////////////////////
			//Header
			$this->Cell(10,6,'Pos',1,0,'L',true);
			$this->Cell(20,6,'Quantity',1,0,'L',true);
			$this->Cell(12,6,'Unity',1,0,'L',true);
			$this->Cell(103,6,'Product',1,0,'L',true);
			$this->Cell(40,6,'Quantity Delivered',1,0,'L',true);
			$this->Ln();

			////////////////////////////////////////////////////////
			//Ligne en plus
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$fill = false;
			$this->SetFont('Arial','',9);
			$count = 1;
			if($order->getCustomer_order_id() != NULL && $order->getCustomer_order_id() != ""){
				$this->Cell(185,6,'>>> '.utf8_decode($order->getCustomer_order_id()),1,0,'C');
				$this->Ln();
			}

			////////////////////////////////////////////////////////
			//Détails de la commande produit par produit
			foreach($order->getLine_product() as $lp){
				if($lp->getProduct()->getId_group() != 7){
					$xline = $this->getX();
					$yline = $this->getY();
					$marge = 42;
					$this->setX($xline + $marge);
					$chaineproduct = $lp->getProduct()->getNameDes();
					if($lp->getId_parameter() != ""){
						$parameter = $lp->getParameter();
						$chaineproduct = $chaineproduct." ".$parameter->getName();
					}
					if($lp->getRef_batch() != ""){
						$chaineproduct = $chaineproduct.' || '.$lp->getRef_batch();
					}
					$this->MultiCell(103,6,utf8_decode($chaineproduct),1,'L',$fill);
					$newy = $this->getY() - $yline;
					$this->setX($xline);
					$this->setY($yline);
					$this->Cell(10,$newy,$count,1,0,'L',$fill);
					$this->Cell(20,$newy,$lp->getAmount(),1,0,'L',$fill);
					$this->Cell(12,$newy,utf8_decode($lp->getProduct()->getUnit()),1,0,'L',$fill);
					$this->setX($xline + $marge + 103);
					$this->Cell(40,$newy,$lp->getAmount_to_be_delivered().' / '.$lp->getAmount(),1,0,'L',$fill);
					$fill = !$fill;
					$count ++;
					$this->Ln();
				}
			}
		}
	}

	//Déclaration des texte

	// /!\ A remplacer par des textes dans le TextFinder

	$text_intro = $tf->getText(107);
	$text_fin = $tf->getText(104).' '.$order->getDelayForDelivery().' '.$tf->getText(105);
	$text_fin2 = $tf->getText(106);

	// Déclaration des fonctions de générations du PDF

	//Ecriture du texte en cas de bon de livraison

	function writeParamDeliveryOrder(&$pdf,$param_delivery){
		$pdf->Cell(0,5,utf8_decode("Lieferung per / Livraison par / Delivery by: ".$param_delivery["DeliveryBy"]),0,1,'L',false);
		$pdf->Cell(0,5,utf8_decode("Bruttogewicht / Poids / Gross Weight: ".$param_delivery["GrossWeight"]),0,1,'L',false);
		$pdf->Cell(0,5,utf8_decode("Anzahlt Gebinde / Nombre d`emballages / Number of packages: ".$param_delivery["NbOfPackages"]),0,1,'L',false);
		$pdf->Cell(0,5,utf8_decode("Anzahl Paletten / Nombre de Palettes / Numer of Pallets: ".$param_delivery["NbOfPallets"]),0,1,'L',false);
		$pdf->Cell(0,5,utf8_decode("Abmessungen / Mesures / Measures: ".$param_delivery["Measures"]),0,1,'L',false);
	}

	//Création d'une nouvelle page

	function setNewPage(&$pdf,$order,&$table_first){
		$pdf->AddPage();
		$table_first[2][2][0] = (string)intval($table_first[2][2][0]) + 1;
		if($order->getIs_factorem() == "no"){
			$pdf->Image('../assets/datas/model-pdf.png',0,$pdf->GetY() -10,$pdf->w,$pdf->h,'png');
		} else {
			$pdf->Image('../assets/datas/model-pdf-nofactorem.png',0,$pdf->GetY() -10,$pdf->w,$pdf->h,'png');
		}
		$pdf->Cell(0,40,'',0,1); 
	}

	function checkIfDropPage(&$pdf,$order,&$table_first,$h){
		if($pdf->GetY() > $pdf->h - ($h + 30)){
			setNewPage($pdf,$order,$table_first);
			$pdf->SetFont('Arial','B',11);
			$pdf->SetTextColor(0);
			$pdf->Cell(185,21,'',1);
			$pdf->setX($pdf->GetX() - 185);
			$pdf->setY($pdf->GetY() + 2);
			$pdf->FirstTable($table_first);
			$pdf->setY($pdf->GetY() + 2);
		}
	}




	// Déclaration du pdf
	$pdf = new PDF();
	$pdf->AliasNbPages();
	
	

	//////////////////////////////////////////////////////////////////////////
	// Pause : Tableau d'information à afficher / calcul n°id
	$id_document = generateIdDoc($typedocument,$company,$order);
	$table_first = array(array(utf8_decode('n° :'),$id_document,date('d.m.Y',$order->getDate_shipment())),array('UST-ID :',$company->getUst_id(),utf8_decode($employee->getSurname().' '.$employee->getName())),array('Your ID :',$company->getId(),'0'.'/{nb}'));


	setNewPage($pdf,$order,$table_first);

	///////////////////////////////////////////////////////////////////////////
	// Premier Bloc : Info biothys
	// Nom du client + adresse
	$pdf->SetFont('Arial','U',6);
	$pdf->Cell(0,5,utf8_decode('Biothys GmbH | Gewerbestr. 6 | D-77731 Willstätt'),0,1,'L',false);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,utf8_decode($company->getName()),0,1,'L',false);
	//Bloc DO :
	$pdf->setY($pdf->GetY() + 2);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(180,6,utf8_decode('Delivery Address : '),0,1,'L',false);
	$pdf->SetFont('Arial','',8);
	$delivery_address = new address($order->getId_delivery_address());
	$pdf->Cell(0,5,utf8_decode($delivery_address->getLine().' '.$delivery_address->getComplement()),0,1,'L',false);
	$pdf->Cell(0,5,utf8_decode($delivery_address->getZip().' '.$delivery_address->getCity().' '.$delivery_address->getCountry()),0,1,'L',false);

	//$pdf->Cell(0,5,utf8_decode($receiving_address->getLine().' '.$receiving_address->getComplement()),0,1,'L',false);
	//$pdf->Cell(0,5,utf8_decode($receiving_address->getZip().' '.$receiving_address->getCity().' '.$receiving_address->getCountry()),0,1,'L',false);
	
	///////////////////////////////////////////////////////////////////////////
	//Deuxième Bloc : type de document
	$pdf->SetFont('Arial','B',20);
	$pdf->Cell(180,15,utf8_decode('Delivery Order'),0,1,'R',false);
	

	//////////////////////////////////////////////////////////////////////////
	//Troisième bloc : Afficher le tableau d'info générale sur la commande
	$pdf->Cell(0,10,'',0,1);

	//Création du cadre
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(185,21,'',1);
	$pdf->setX($pdf->GetX() - 185);
	$pdf->setY($pdf->GetY() + 2);
	
	//écriture du texte
	$pdf->FirstTable($table_first);

	//////////////////////////////////////////////////////////////////////////
	//Quatrième bloc : Texte d'intro
	$pdf->SetFont('Arial','',8);
	$pdf->setY($pdf->GetY() + 2);
	$pdf->MultiCell($pdf->w - 25,3,utf8_decode($text_intro));


	//////////////////////////////////////////////////////////////////////////
	//Cinquième bloc : Détails de la commande
	$pdf->setY($pdf->GetY() + 2);
	$pdf->SecondTable($order);

	checkIfDropPage($pdf,$order,$table_first,20);
	/////////////////////////////////////////////////////////////////////////
	

	checkIfDropPage($pdf,$order,$table_first,17);
	//Sixième bloc : Texte de fin

	$pdf->setY($pdf->GetY() + 5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0);
	$pdf->MultiCell($pdf->w - 25,3,utf8_decode($text_fin));
	$pdf->MultiCell($pdf->w - 25,3,utf8_decode($text_fin2));


	checkIfDropPage($pdf,$order,$table_first,40);
	//Septième bloc condition finale 
	$pdf->SetFont('Arial','',8);
	$pdf->setY($pdf->GetY() + 5);
	writeParamDeliveryOrder($pdf,$param_delivery);

	//////////////////////////////////////////////////////////////////////////
	//On sort le PDF avec le nom qui va bien
	$pdf->Output('DeliveryOrder'.$id_document.'_'.str_replace(' ','',$company->getName()).'.pdf','I');

?>