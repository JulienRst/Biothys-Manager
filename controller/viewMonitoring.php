<?php
	require_once('checkSession.php');

	$display = false;
	$extraction = new extraction();

	$actualYears = date('y');
	$actualMonth = date('m');

	$debDateYear = '01-01-'.$actualYears;
	$endDateYear = '31-12-'.$actualYears;

	$debDateMonth = '01-'.$actualMonth.'-'.$actualYears;
	$endDateMonth = date('t-m-y',strtotime($actualYears.'-'.$actualMonth.'-'.'31'));

	$ordersYear = $extraction->getOrdersWithDate($debDateYear,$endDateYear);
	$ordersMonth = $extraction->getOrdersWithDate($debDateMonth,$endDateMonth);

	//Calcul of year turnover

	$yearTurnover = 0;
	foreach($ordersYear as $order){
		$yearTurnover += $order->getPrice();
	}
	$yearTurnover = number_format($yearTurnover,2,',',' ');

	//Calcul of month turnover

	$monthTurnover = 0;
	foreach($ordersMonth as $order){
		$monthTurnover += $order->getPrice();
	}
	$monthTurnover = number_format($monthTurnover,2,',',' ');

	//Calcul of the period if set

	if(isset($_GET["dateDeb"]) && $_GET["dateDeb"] != "" && isset($_GET["dateEnd"]) && $_GET["dateEnd"] != ""){
		echo('<h2>');

		//Check if the period is in the new or the old Biothys
		$dateMigration = "15-08-15";
		$tsdateMigration = DateTime::createFromFormat('j-m-y', $dateMigration)->getTimestamp();


		$display = true;
		$deb = $_GET["dateDeb"];
		$end = $_GET["dateEnd"];

		$startDate = DateTime::createFromFormat('j-m-y', $deb)->getTimestamp();
		$endDate = DateTime::createFromFormat('j-m-y', $end)->getTimestamp();

		$displayOld = false;

		if($startDate < $tsdateMigration){
			$displayOld = true;
			$json = file_get_contents('http://127.0.0.1/extraction/controller/getInvoiceMonth.php?dateDeb='.$deb.'&dateEnd='.$dateMigration,'true');
			$ancientInvoice = json_decode($json,'true');
		}

		$startMonth = date('m',$startDate);
		$startYear = date('y',$startDate);

		$nb_month = abs((date('Y', $endDate) - date('Y', $startDate))*12 + (date('m', $endDate) - date('m', $startDate)))+1;
		$columns = array();

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
			
			$orders = $extraction->getOrdersWithDate($deb_a,$end_a);

			$columns[$key] = $orders;
		}

		//Préparation du tableu final 

			//Get line final score
		$final_line = array();
		if(isset($ancientInvoice)){
			foreach($ancientInvoice["GER"] as $date => $amount){
				$final_line[$date] = $amount;
			}
		}
		

		foreach($columns as $date => $orders){
			foreach($orders as $order){
				if(!isset($final_line[$date])){
					$final_line[$date] = $order->getPrice();
				} else {
					$final_line[$date] += $order->getPrice();
				}
			}
		}
		

		function search($id,$company){
			$mag = false;
			foreach($company as $i => $item){
				if($item->getId() == $id){
					$mag = $i;
				}
			}
			return $mag;
		}
		echo("</h2>");

		$companies = array();

		foreach($columns as $date => $orders){
			foreach($orders as $order){
				$tag = search($order->getId_company(),$companies);
				if($tag !== false){
					$companies[$tag]->addOrderMonth($date,$order);
				} else {
					$new_company = new company($order->getId_company());
					$new_company->addOrderMonth($date,$order);
					array_push($companies,$new_company);
				}
			}
		}

		function searchCountry($tag,$country){
			$mag = false;
			foreach($country as $i => $item){
				if($item->getCountry() == $tag){
					$mag = $i;
				}
			}
			return $mag;
		}
		//final line country

		$tab_country_company = array();
		$companies_pays = $companies;
		foreach($companies_pays as $company){
			$tag = searchCountry($company->getNationality(),$tab_country_company);
			if($tag !== false){
				array_push($tab_country_company[$company->getNationality()],$company);
			} else {
				$tab_country_company[$company->getNationality()] = array($company);
			}
		}
		echo('<h2>');
		$final_line_country = array();
		foreach($tab_country_company as $tag => $country){
			foreach($country as $company){
				foreach($company->getOrdersMonth() as $key => $price){
					if(!isset($final_line_country[$tag][$key])){
						$final_line_country[$tag][$key] = $price;
					} else {
						$final_line_country[$tag][$key] += $price;
					}
				}
			}
		}
		echo('</h2>');

		// Get command who doesn't have been paid

		$ordersToGetPaid = $extraction->getOrdersToGetPaid();	

		// Get Product by date etc... 

		$group_products = $extraction->getProductsFromOrders($deb_a,$end_a); 

		//group_product["group"]["country"]["date"]{["name"]["quantity"]["pricetotal"]}
	}
	
	include('../view/monitoring.php');

?>