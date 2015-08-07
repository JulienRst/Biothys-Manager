<?php

	require_once('database.php');

	class link_company_delivery_address {

		private $id;
		private $id_company;
		private $id_address;

		private $pdo;

		public function __construct($id = 0){

			$this->pdo = database::getInstance();

			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
			}
		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM link_company_delivery_address WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model link_company_delivery_address :".$e->getMessage());
			}

			if($stmt_get->rowcount() != 0){
				$stmt_get = $stmt_get->fetch(PDO::FETCH_ASSOC);
				foreach($stmt_get as $key => $value){
					$this->$key = $value;
				}
				return true;
			} else {
				return false;
			}
		}

		public function addToDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare("INSERT INTO link_company_delivery_address(id_company,id_address) VALUES(:id_company,:id_address)");
			$stmt->bindParam(':id_company',$this->id_company);
			$stmt->bindParam(':id_address',$this->id_address);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model link_company_delivery_address :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM link_company_delivery_address WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model link_company_delivery_address :'.$e->getMessage());
			}
			$actual_link_company_delivery_address = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_link_company_delivery_address as $key => $value){
				if($actual_link_company_delivery_address[$key] != $this->$key){
					$stmt = $this->pdo->PDOInstance->prepare("UPDATE link_company_delivery_address SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model link_company_delivery_address :'.$e->getMessage());
					}
				}
			}
		}
		public function eraseOfDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare('DELETE FROM link_company_delivery_address WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model link_company_delivery_address :'.$e->getMessage());
			}
		}

		public function getId(){return $this->id;}
		public function getId_company(){return $this->id_company;}
		public function getId_address(){return $this->id_address;}

		public function setId($new){$this->id = $new;}
		public function setId_company($new){$this->id_company = $new;}
		public function setId_address($new){$this->id_address = $new;}
}?>