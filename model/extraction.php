<?php

	require_once('database.php');
	require_once('group_products.php');
	require_once('product.php');
	require_once('parameter.php');
	require_once('partner.php');

	class extraction {

		private $pdo;

		public function __construct(){
			$this->pdo = database::getInstance();
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

		public function getOrders($id = NULL){
			if($id){
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` WHERE id= :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM `order` as o");
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