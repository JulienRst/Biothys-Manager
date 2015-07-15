<?php

	require_once('database.php');
	require_once('../model/group_products.php');
	require_once('../model/product.php');

	class extraction {

		private $pdo;

		public function __construct(){
			$database = new database();
			$this->pdo = $database->getPdo();
		}

		public function getProductByGroup($id = NULL){
			if($id){
				$stmt = $this->pdo->prepare("SELECT * FROM product as p WHERE p.group_id = :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->prepare("SELECT * FROM product as p");
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

		public function getGroup($id = NULL){
			if($id){
				$stmt = $this->pdo->prepare("SELECT * FROM group_product WHERE id= :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->prepare("SELECT * FROM group_product");
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
				array_push($result,$group_);
			}

			return $result;
		}

		public function getEmployee($id = NULL){
			if($id){
				$stmt = $this->pdo->prepare("SELECT * FROM employee WHERE id= :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->prepare("SELECT * FROM employee");
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

		public function getRight_group($id = NULL){
			if($id){
				$stmt = $this->pdo->prepare("SELECT * FROM right_group WHERE id= :id");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->prepare("SELECT * FROM right_group");
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

		public function searchForAddress($string){
			if($string != ""){
				$string = "%".$string."%";
				$stmt = $this->pdo->prepare("SELECT * FROM address WHERE country LIKE :country or zip LIKE :zip or line LIKE :line or city LIKE :city");

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
					$address_ = new address();
					foreach($address as $key => $value){
						$attribute = "set".ucfirst($key);
						$address_->$attribute($value);
					}
					array_push($result,$address_);
				}

				return $result;
				}
		}

		public function getPerfumes($id = NULL){
			if($id){
				$stmt = $this->pdo->prepare("SELECT * FROM perfume WHERE id= :id ORDER BY ref");
				$stmt->bindParam(':id',$id);
			} else {
				$stmt = $this->pdo->prepare("SELECT * FROM perfume ORDER BY ref");
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

	}


?>