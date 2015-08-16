<?php

	require_once('database.php');
	require_once('group_products.php');
	require_once('product.php');
	require_once('parameter.php');
	require_once('partner.php');
	require_once('order.php');

	class extraction {

		private $pdo;

		public function __construct(){
			$this->pdo = database::getInstance();
		}

		public function getOrdersToGetPaid(){
			$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` WHERE order.finish = 'no'");

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$results = array();

			foreach($orders as $line){
				$order = new order($line["id"]);
				if($order->getAlready_paid() < $order->getPrice()){
					array_push($results,$order);
				}
			}

			return $results;

		}

		public function getProductsFromOrders($deb_a,$end_a){

			$deb = DateTime::createFromFormat('d-m-y',$deb_a)->getTimestamp();
			$end = DateTime::createFromFormat('d-m-y',$end_a)->getTimestamp();

			$stmt = $this->pdo->PDOInstance->prepare("SELECT lop.amount, lop.price_bis, gp.name as gpname,c.nationality as cnationality, o.date_receipt as dr, p.name as pname FROM company as c, `order` as o, product as p, link_order_product as lop, group_product as gp WHERE o.id_company = c.id and o.date_receipt > :deb and o.date_receipt < :end and p.id_group = gp.id and lop.id_product = p.id and lop.id_order = o.id");
			$stmt->bindParam(':deb',$deb);
			$stmt->bindParam(':end',$end);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			//group_product["group"]["country"]["name"]["date"]{["quantity"]["pricetotal"]}

			$resulting = array();

			foreach($result as $line){
				$date = date('m',$line["dr"]).'/'.date('y',$line["dr"]);
				if(!isset($resulting[$line["gpname"]][$line["cnationality"]][$date][$line["pname"]])){
					$resulting[$line["gpname"]][$line["cnationality"]][$line["pname"]][$date]["quantity"] = $line["amount"]; 
					$resulting[$line["gpname"]][$line["cnationality"]][$line["pname"]][$date]["price"] = $line["price_bis"]; 
				} else {
					$resulting[$line["gpname"]][$line["cnationality"]][$line["pname"]][$date]["quantity"] += $line["amount"]; 
					$resulting[$line["gpname"]][$line["cnationality"]][$line["pname"]][$date]["price"] += $line["price_bis"]; 
				}
			}

			return $resulting;

		}

		public function getProductByGroup($id = NULL){
			if($id){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM product as p WHERE p.id_group = :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM product as p");
			}

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if($id){
				$result_group = $this->getGroup($id);
			} else {
				$result_group = $this->getGroup();
			}
			

			foreach ($result as $product) {
				$product_ = new product();
				$product_->setId($product["id"]);
				$product_->setRef($product["ref"]);
				$product_->setName($product["name"]);
				$product_->setDescription($product["description"]);
				$product_->setCost($product["cost"]);
				$product_->setPrice($product["price"]);
				$product_->setUnit($product["unit"]);
				$product_->setId_group($product["id_group"]);

				$indice = 0;
				foreach ($result_group as $group) {
					if($group->getId() == $product_->getId_group()){
						$result_group[$indice]->addProduct($product_);
					}
					$indice ++;
				}
			}

			return $result_group;
		}

		public function getOrderFromCompany($id_c){
			$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` WHERE id_company = :id ORDER BY date_entry DESC LIMIT 5");
			$stmt->bindParam(':id',$id_c);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("<h2>Problem at ".$e->getLine()." from model Extraction :".$e->getMessage().'</h2>');
			}
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$orders = array();
			foreach($result as $order){
				$norder = new order($order["id"]);
				array_push($orders,$norder);
			}

			return $orders;
		}

		public function getOrderFromEmployee($id_e){
			$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` WHERE id_employee = :id ORDER BY date_entry DESC LIMIT 5");
			$stmt->bindParam(':id',$id_e);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("<h2>Problem at ".$e->getLine()." from model Extraction :".$e->getMessage().'</h2>');
			}
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$orders = array();
			foreach($result as $order){
				$norder = new order($order["id"]);
				array_push($orders,$norder);
			}

			return $orders;
		}

		public function getOrdersFromEmployeeWithDate($id_e,$deb,$end){
			$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` WHERE id_employee = :id ORDER BY date_entry DESC LIMIT 5");
			$stmt->bindParam(':id',$id_e);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("<h2>Problem at ".$e->getLine()." from model Extraction :".$e->getMessage().'</h2>');
			}
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$orders = array();
			foreach($result as $order){
				$norder = new order($order["id"]);
				array_push($orders,$norder);
			}

			return $orders;
		}

		public function getOrdersWithDate($deb,$end){
			$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` WHERE date_receipt > :deb AND date_receipt < :end ORDER BY date_entry");
			
			// $date_shipment = DateTime::createFromFormat('!d-m-y', $_GET['date_shipment'])->getTimestamp();
			// $date_receipt = DateTime::createFromFormat('!d-m-y', $_GET['date_receipt'])->getTimestamp();


			$deb = DateTime::createFromFormat('d-m-y',$deb)->getTimestamp();
			$end = DateTime::createFromFormat('d-m-y',$end)->getTimestamp();
			
			$stmt->bindParam(':deb',$deb);
			$stmt->bindParam(':end',$end);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("<h2>Problem at ".$e->getLine()." from model Extraction :".$e->getMessage().'</h2>');
			}
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$orders = array();
			foreach($result as $order){
				$norder = new order($order["id"]);
				array_push($orders,$norder);
			}

			return $orders;
		}

		public function getParametersFromType($id_type){
			$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM parameter WHERE type = :id");
			$stmt->bindParam(':id',$id_type);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$parameters = array();

			foreach($result as $parameter){
				$nparameter = new parameter($parameter["id"]);
				array_push($parameters,$nparameter);
			}

			return $parameters;
		}

		public function getGroup($id = NULL){
			if($id){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM group_product WHERE id= :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM group_product");
			}

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($stmt as $group) {
				$group_ = new group_products();
				$group_->setId($group["id"]);
				$group_->setName($group["name"]);
				$group_->setType($group["type"]);
				array_push($result,$group_);
			}

			return $result;
		}

		public function getEmployee($id = NULL){
			if($id){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM employee WHERE id= :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM employee");
			}

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($stmt as $employee) {
				$employee_ = new employee();
				foreach($employee as $key => $value){
					$attribute = "set".ucfirst($key);
					$employee_->$attribute($value);
				}
				array_push($result,$employee_);
			}

			return $result;
		}

		public function getProductForOrder($needle){
			$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM product WHERE name like :name");
			$needle = '%'.$needle.'%';

			$stmt->bindParam(':name',$needle);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$result = array();

			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach($stmt as $product){
				$nproduct = new product($product["id"]);
				array_push($result,$nproduct);
			}

			return $result;
		}

		public function getRight_group($id = NULL){
			if($id){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM right_group WHERE id= :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM right_group");
			}
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($stmt as $rg) {
				$group = new right_group();
				foreach($rg as $key => $value){
					$attribute = "set".ucfirst($key);
					$group->$attribute($value);
				}
				array_push($result,$group);
			}

			return $result;
		}

		public function searchForAddress($string,$id = 0){
			if($string != ""){
				$string = "%".$string."%";
				if($id == 0){
					$stmt = $this->pdo->PDOInstance->prepare("SELECT address.id FROM address WHERE country LIKE :country or zip LIKE :zip or line LIKE :line or city LIKE :city");
				} else {
					$stmt = $this->pdo->PDOInstance->prepare("SELECT address.id FROM address,`order` as o,company,link_company_delivery_address WHERE o.id = :id and o.id_company = company.id and company.id = link_company_delivery_address.id_company and address.id = link_company_delivery_address.id_address and ( country LIKE :country or zip LIKE :zip or line LIKE :line or city LIKE :city )");
					$stmt->bindParam(':id',$id);
				}

				$stmt->bindParam(':country',$string);
				$stmt->bindParam(':zip',$string);
				$stmt->bindParam(':line',$string);
				$stmt->bindParam(':city',$string);

				try {
					$stmt->execute();
				} catch(Exception $e){
					echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
				}

				$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$result = array();

				foreach ($stmt as $address) {
					$address_ = new address($address["id"]);
					array_push($result,$address_);
				}

				return $result;				
			}
		}

		public function getPerfumes($id = NULL){
			if($id){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM perfume WHERE id= :id ORDER BY ref");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM perfume ORDER BY ref");
			}
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($stmt as $perfume) {
				$perfume_ = new perfume();
				foreach($perfume as $key => $value){
					$attribute = "set".ucfirst($key);
					$perfume_->$attribute($value);
				}
				array_push($result,$perfume_);
			}

			return $result;
		}

		public function getCustomers($id = NULL){
			if($id){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM customer WHERE id= :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM customer");
			}
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($stmt as $customer) {
				$customer_ = new customer();
				foreach($customer as $key => $value){
					$attribute = "set".ucfirst($key);
					$customer_->$attribute($value);
				}
				array_push($result,$customer_);
			}

			return $result;
		}

		public function getCompany($id = NULL){
			if($id){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM company WHERE id= :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM company");
			}
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach($stmt as $company){
				$ncompany = NULL;
				$ncompany = new company($company["id"]);
				echo('<br/><br/>');
				array_push($result, $ncompany);
			}

			return $result;
		}


		public function get($class,$id = NULL){
			if($id){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM $class WHERE id= :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->PDOInstance->prepare("SELECT * FROM $class");
			}
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}

			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($stmt as $entity) {
				$entity_ = new $class();
				foreach($entity as $key => $value){
					$attribute = "set".ucfirst($key);
					$entity_->$attribute($value);
				}
				array_push($result,$entity_);
			}

			return $result;
		}

		public function getCustomersFromCompany($idCompany){
			if($idCompany){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT name,mail,phone_number FROM customer as c WHERE c.id_company = :id");
				$stmt->bindParam(':id',$idCompany);
				try {
					$stmt->execute();
				} catch(Exception $e){
					echo("Problem at ".$e->getLine()." from model Extraction | GET CUSTOMERS FROM COMPANY :".$e->getMessage());
				}

				$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$result = array();

				foreach ($stmt as $customer) {
					$customer_ = new customer();
					foreach($customer as $key => $value){
						$attribute = "set".ucfirst($key);
						$customer_->$attribute($value);
					}
					array_push($result,$customer_);
				}

				return $result;
			}
		}

		public function searchFor($class,$needle){
			if($class == "employee"){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM $class WHERE name LIKE '%".$needle."%' OR surname LIKE '%".$needle."%' LIMIT 5");
			} else {
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM $class WHERE name LIKE '%".$needle."%' LIMIT 5");
			}
			
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}


			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$results = array();
			foreach ($stmt as $item) {
				$nitem = new $class($item["id"]);
				array_push($results,$nitem);
			}

			return $results;

		}

		public function getOrders($display){
			if($display == "all"){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` ORDER BY date_entry DESC");
			} else if($display == "toprepare"){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` WHERE ready = 'no' ORDER BY date_entry DESC");
			} else if($display == "toInvoice"){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` WHERE ready = 'yes' and date_receipt = 0 ORDER BY date_entry DESC");
			} else if($display == "toGetPaid"){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` WHERE ready = 'yes' and date_receipt != 0 and finish = 'no' ORDER BY date_entry DESC");
			} else if($display == "finished"){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` WHERE finish = 'yes' ORDER BY date_entry DESC");
			}
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model Extraction :".$e->getMessage());
			}
			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			

			$result = array();



			foreach($stmt as $order){
				$norder = NULL;
				$norder = new order($order["id"]);
				array_push($result, $norder);
			}

			return $result;
		}

	}


?>