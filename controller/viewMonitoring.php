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
			$json = file_get_contents('https://biothys-office.com/new/vendor/extraction/controller/getInvoiceMonth.php?dateDeb='.$deb.'&dateEnd='.$dateMigration,'true');
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

		// [country]{"company" =>[company]{"date" => [date]{"liquid + gel","equipement"},"somme_liquid_gel","somme_equipement"},"somme_liquid_gel","somme_equipement"}

		$tab_country_company = array();
		$tab_country_company["somme_liquid_gel"] = 0;
		$tab_country_company["somme_equipement"] = 0;
		$tab_country_company["country"] = array();
		$orders_for_country = $columns; //[date][orders]

		foreach($columns as $date => $orders){
			foreach($orders as $order){
				$company = $order->getCompany();
				$country = $company->getNationality();
				$date = date('m',$order->getDate_entry()).'/'.date('y',$order->getDate_entry());
				if(!isset($tab_country_company[$country]["company"][$company->getName()]["date"][$date])){
					$tab_country_company["country"][$country]["company"][$company->getName()]["date"][$date]["somme_liquid_gel"] = 0;
					$tab_country_company["country"][$country]["company"][$company->getName()]["date"][$date]["somme_equipement"] = 0;
				}

				foreach($order->getLine_product() as $line_product){
					$product = $line_product->getProduct();
					if($product->getId_Group() <= 4){
						$tab_country_company["country"][$country]["company"][$company->getName()]["date"][$date]["somme_liquid_gel"] += $line_product->getPrice_bis() * $line_product->getAmount();
					} else {
						$tab_country_company["country"][$country]["company"][$company->getName()]["date"][$date]["somme_equipement"] += $line_product->getPrice_bis() * $line_product->getAmount();
					}
				}//foreach : les lignes orders afin de checkez dans quelles catégories ils rentrent;
			}
		}
		//Somme pour les companies
		foreach($tab_country_company["country"] as $country){
			$country["somme_liquid_gel"] = 0;
			$country["somme_equipement"] = 0;
			foreach($country["company"] as $company){
				$company["somme_liquid_gel"] = 0;
				$company["somme_equipement"] = 0;
				foreach($company["date"] as $date){
					$company["somme_liquid_gel"] += $date["somme_liquid_gel"];
					$company["somme_equipement"] += $date["somme_equipement"];
				}
				$country["somme_liquid_gel"] += $company["somme_liquid_gel"];
				$country["somme_equipement"] += $company["somme_equipement"];
			}
			$tab_country_company["somme_liquid_gel"] += $country["somme_liquid_gel"];
			$tab_country_company["somme_equipement"] += $country["somme_equipement"];
		}


		// function searchCountry($tag,$country){
		// 	$mag = false;
		// 	foreach($country as $i => $item){
		// 		foreach($item as $j => $subitem){
		// 			if($i == $subitem->getNationality()){
		// 				$mag = $i;
		// 			}
		// 		}
		// 	}
		// 	return $mag;
		// }
		// //final line country

		// $tab_country_company = array();
		// $companies_pays = $companies;
		// foreach($companies_pays as $company){
		// 	$tag = searchCountry($company->getNationality(),$tab_country_company);
		// 	if($tag !== false){
		// 		array_push($tab_country_company[$company->getNationality()],$company);
		// 	} else {
		// 		$tab_country_company[$company->getNationality()] = array($company);
		// 	}
		// }
		// echo('<h2>');
		// $final_line_country = array();
		// foreach($tab_country_company as $tag => $country){
		// 	foreach($country as $company){
		// 		foreach($company->getOrdersMonth() as $key => $price){
		// 			if(!isset($final_line_country[$tag][$key])){
		// 				$final_line_country[$tag][$key] = $price;
		// 			} else {
		// 				$final_line_country[$tag][$key] += $price;
		// 			}
		// 		}
		// 	}
		// }
		//echo('</h2>');

		// Get command who doesn't have been paid

		$ordersToGetPaid = $extraction->getOrdersToGetPaid();

		// Get Product by date etc...

		$group_products = $extraction->getProductsFromOrders($deb_a,$end_a);

		//group_product["group"]["country"]["date"]{["name"]["quantity"]["pricetotal"]}

		$ordersFactured = $extraction->getOrdersFactured($deb_a,$end_a);
	}

	include('../view/monitoring.php');

?>
