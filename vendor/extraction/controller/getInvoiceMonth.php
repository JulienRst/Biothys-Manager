<?php

	require_once('../model/extraction.php');

	if(isset($_GET["dateDeb"]) && (isset($_GET["dateEnd"]))){
		$extraction = new extraction($_GET["dateDeb"],$_GET["dateEnd"]);
		
		$deb = $_GET["dateDeb"];
		$end = $_GET["dateEnd"];

		$startDate = DateTime::createFromFormat('j-m-y', $deb)->getTimestamp();
		$endDate = DateTime::createFromFormat('j-m-y', $end)->getTimestamp();

		$startMonth = date('m',$startDate);
		$startYear = date('y',$startDate);

		$nb_month = abs((date('Y', $endDate) - date('Y', $startDate))*12 + (date('m', $endDate) - date('m', $startDate)))+1;
		$columns = array("GER" => array(), "ESP" => array());

		for($i=0;$i<$nb_month;$i++){
			$month = ($startMonth -1 + $i)%12 + 1;
			if($month < 10){$month = '0'.$month;}

			$year = intval(strval(($startMonth -1 +$i)/12)) + $startYear;
			$key = $month.'-'.$year;
			if($i == 0){
				$deb_a = $deb;
				$end_a = date('t-m-y',$startDate);
			} else if($i == $nb_month -1){
				$deb_a = '01-'.$key;
				$end_a = $end;
			} else {
				$deb_a = '01-'.$key;
				$end_a = date('t',strtotime('01-'.$key)).'-'.$key;
			}

			$invoice_ger = $extraction->extractOrder("GER",$deb_a,$end_a);
			$invoice_es = $extraction->extractOrder("ESP",$deb_a,$end_a);

			$columns["GER"][$key] = $invoice_ger;
			$columns["ESP"][$key] = $invoice_es;
		}

		echo(json_encode($columns));
	}

?>