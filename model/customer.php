<?php

	include_once('database.php');

	class customer {

		private $id;
		private $id_company;
		private $name;
		private $mail;
		private $nationality;
		private $phone_number;
		private $id_address;

		private $pdo;

		public function __construct($id = 0){

			$database = new database();
			$this->pdo = $database->getPdo();

			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
			}

		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM customer WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model customer :".$e->getMessage());
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
			$stmt = $this->pdo->prepare("INSERT INTO customer(id_company,name,mail,nationality,phone_number,id_address) VALUES (:id_company,:name,:mail,:nationality,:phone_number,:id_address)");
				
			$stmt->bindParam(':id_company',$this->id_company,PDO::PARAM_INT);
			$stmt->bindParam(':name',$this->name,PDO::PARAM_STR);
			$stmt->bindParam(':mail',$this->mail,PDO::PARAM_STR);
			$stmt->bindParam(':nationality',$this->nationality,PDO::PARAM_STR);
			$stmt->bindParam(':phone_number',$this->phone_number,PDO::PARAM_STR);
			$stmt->bindParam(':id_address',$this->id_address,PDO::PARAM_INT);

			try {
				$stmt->execute();
			} catch(Exception $e){
				$stmt->debugDumpParams();
				echo("<br/><br/>");
				echo('Problem at '.$e->getLine().' from model customer :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM customer WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model customer :'.$e->getMessage());
			}
			$actual_customer = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_customer as $key => $value){
				if($actual_customer[$key] != $this->$key){
					$stmt = $this->pdo->preapre("UPDATE customer SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					} catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model customer :'.$e->getMessage());
					}
				}
			}
		}

		public function eraseOfDatabase(){ 
			$stmt = $this->pdo->prepare('DELETE FROM customer WHERE id = :id'); 
			$stmt->bindParam(':id',$this->id); 
			try { 
				$stmt->execute(); 
			} catch(Exception $e){ 
				echo('Problem at '.$e->getLine().' from model customer :'.$e->getMessage()); 
			} 
		}

		public function getId(){return $this->id;}
		public function getId_company(){return $this->id_company;}
		public function getName(){return $this->name;}
		public function getMail(){return $this->mail;}
		public function getNationality(){return $this->nationality;}
		public function getPhone_number(){return $this->phone_number;}
		public function getId_address(){return $this->id_address;}

		public function setId($new){$this->id = $new;}
		public function setId_company($new){$this->id_company = $new;}
		public function setName($new){$this->name = $new;}
		public function setMail($new){$this->mail = $new;}
		public function setNationality($new){$this->nationality = $new;}
		public function setPhone_number($new){$this->phone_number = $new;}
		public function setId_address($new){$this->id_address = $new;}
	}
?>