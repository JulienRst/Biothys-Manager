<?php

	require_once('../model/order.php');
	require_once('../model/company.php');
	require_once('../model/extraction.php');
	require_once('getText.php');
	$order = new order($_GET['id']);
	$company = new company($order->getId_company());
	$receiving_address = new address($company->getId_receiving_address());

	// Génération du n° Document

		//[X : typedocument][XX : Year][X : country][XXXX : id commande]
		$typedocument = 8;
		$year = date('y');
		$country = 5;

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

	//

	if($country == 5){
		$tf->language = "GER";
	} else if($country == 6){
		$tf->language = "ES";
	}

	require_once('../vendor/fpdf17/fpdf.php');
	//Extends de class by fpdp itself
	class PDF extends FPDF {
		public $tf;
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
			foreach($data as $row)
			{ 
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
			//Header
			$this->Cell(10,6,$this->tf->getText(91),1,0,'L',true);
			$this->Cell(20,6,$this->tf->getText(74),1,0,'L',true);
			$this->Cell(12,6,$this->tf->getText(89),1,0,'L',true);
			$this->Cell(107,6,$this->tf->getText(71),1,0,'L',true);
			$this->Cell(18,6,$this->tf->getText(92),1,0,'R',true);
			$this->Cell(18,6,$this->tf->getText(75),1,0,'R',true);
			$this->Ln();

			//Body
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$fill = false;
			$this->SetFont('Arial','',9);
			$count = 1;

			if($order->getCustomer_order_id() != NULL && $order->getCustomer_order_id() != ""){
				$this->Cell(185,6,'>>> '.$order->getCustomer_order_id(),1,0,'C');
				$this->Ln();
			}

			foreach($order->getLine_product() as $lp){
				$xline = $this->getX();
				$yline = $this->getY();
				$marge = 42;
				$this->setX($xline + $marge);
				$this->MultiCell(107,6,$lp->getProduct()->getNameDes().' | '.$this->tf->getText(73).' : '.$lp->getRef_batch(),1,'L',$fill);
				$newy = $this->getY() - $yline;
				$this->setX($xline);
				$this->setY($yline);
				$this->Cell(10,$newy,$count,1,0,'L',$fill);
				$this->Cell(20,$newy,$lp->getAmount(),1,0,'L',$fill);
				$this->Cell(12,$newy,$lp->getProduct()->getUnit(),1,0,'L',$fill);
				$this->setX($this->getX() + 107);
				$this->Cell(18,$newy,$lp->getPrice_bis(),1,0,'R',$fill);
				$this->Cell(18,$newy,($lp->getPrice_bis() * $lp->getAmount()),1,0,'R',$fill);
				$fill = !$fill;
				$count ++;
				$this->Ln();
			}

			$this->SetFont('Arial','B',10);
			$this->Cell(167,6,$this->tf->getText(93),1,0,'R');
			$this->Cell(18,6,$order->getPrice(),1,0,'R');
			$this->Ln();
			//TVA
			$this->SetFont('Arial','I',8);
			$this->Cell(167,6,'TVA 19%',1,0,'R');
			//Ajouter condition sur la tva !
			$tva = 0;
			if($company->getUst_id() != "" && $company->getNationality() != "GER"){
				$this->Cell(18,6,$tva,1,0,'R');
			} else {
				$tva = round(19*$order->getPrice()/100,2);
				$this->Cell(18,6,$tva,1,0,'R');
			}
			$this->Ln();

			//Ajouter la condition ici aussi
			$this->SetFillColor(82,189,236);
			$this->SetTextColor(255);
			$this->SetFont('Arial','B',10);
			$this->Cell(167,6,$this->tf->getText(94),1,0,'R',true);
			$this->Cell(18,6,($order->getPrice() + $tva),1,0,'R',true);
			$this->Ln();
		}
	}

	//récupération des textes

	// /!\ Il faudra changer les textes en fonctions de langue que l'on rentre pour le client, mais la langue par défaut sera l'anglais /!\

	//Pour le moment on met les allemands

	$text_intro = "Sehr geehrte Damen und Herren, wir bedanken uns für Ihr Interesse und möchten Ihnen wie folgt anbieten:";
	$text_fin = "Zahlungsbedingungen: ".$order->getDelayForDelivery()." Tage netto \nDiesem Angebot liegen unsere allgemeinen Geschäftsbedingungen zugrunde. Wir halten uns bis 4 Wochen nach dem Ausstellungsdatum an das Angebot gebunden. Bitte beziehen Sie sich bei Ihrer Bestellung auf die Angebotsnummer in diesem Vorschlag. Nur so können wir Ihnen die hier angebotenen Preise einhalten. Alle Preise -sofern nicht anders ausgewiesen sind netto und ex works Werk Willstätt.";


	$pdf = new PDF();
	$pdf->tf = $tf;
	$pdf->AddPage();
	$pdf->Image('../assets/datas/model-pdf.png',0,0,$pdf->w,$pdf->h,'png');
	//Marge top
	$pdf->SetFont('Arial','U',6);
	$pdf->Cell(0,40,'',0,1);
	$pdf->Cell(0,5,utf8_decode('Biothys GmbH | Gewerbestr. 6 | D-77731 Willstätt'),0,1,'L',false);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,utf8_decode($company->getName()),0,1,'L',false);
	$pdf->Cell(0,5,utf8_decode($receiving_address->getLine().' '.$receiving_address->getComplement()),0,1,'L',false);
	$pdf->Cell(0,5,utf8_decode($receiving_address->getZip().' '.$receiving_address->getCity().' '.$receiving_address->getCountry()),0,1,'L',false);
	//Marge left
	$pdf->SetFont('Arial','B',20);
	$pdf->Cell(180,15,utf8_decode($tf->getText(67)),0,1,'R',false);
	//Marge top
	$pdf->Cell(0,10,'',0,1);
	//CellBorder//remplacer le ust-id quand il sera setup
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(185,21,'',1);
	$pdf->setX($pdf->GetX() - 185);
	$pdf->setY($pdf->GetY() + 2);
	$pdf->FirstTable(array(array(utf8_decode('n° :'),$id_document,date('d.m.y',$order->getDate_entry())),array('UST-ID :',$company->getUst_id(),$order->getEmployee()->getSurname().' '.$order->getEmployee()->getName()),array($tf->getText(95).' ID :',$company->getId(),'1/1')));
	$pdf->SetFont('Arial','',8);
	$pdf->setY($pdf->GetY() + 2);
	$pdf->MultiCell(100,3,utf8_decode($text_intro));
	$pdf->setY($pdf->GetY() + 2);
	$pdf->SecondTable($order);

	$pdf->setY($pdf->GetY() + 5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0);

	// Delivery Address
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(180,6,utf8_decode($tf->getText(47).' : '),0,1,'L',false);
	$pdf->SetFont('Arial','',8);
	$delivery_address = new address($order->getId_delivery_address());
	$pdf->Cell(0,5,utf8_decode($delivery_address->getLine().' '.$delivery_address->getComplement()),0,1,'L',false);
	$pdf->Cell(0,5,utf8_decode($delivery_address->getZip().' '.$delivery_address->getCity().' '.$delivery_address->getCountry()),0,1,'L',false);

	
	$pdf->setY($pdf->GetY() + 5);
	$pdf->MultiCell(150,3,utf8_decode($text_fin));
	$pdf->Output();

?>