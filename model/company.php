<?php

	include_once('database.php');

	class company {

		private $id;
		private $id_group_company;
		private $id_contact;
		private $id_billing_address;
		private $id_receiving_address;
		private $name;
		private $nationality;
		private $description;
		private $normal_billing_period;
		private $phone_number;

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
			$stmt_get = $this->pdo->prepare("SELECT * FROM company WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model company :".$e->getMessage());
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
			$stmt = $this->pdo->prepare("INSERT INTO company(id_group_company,id_contact,id_billing_address,id_receiving_address,name,nationality,description,normal_billing_period,phone_number) VALUES(:id_group_company,:id_contact,:id_billing_address,:id_receiving_address,:name,:nationality,:description,:normal_billing_period,:phone_number)");
			$stmt->bindParam(':id_group_company',$this->id_group_company);
			$stmt->bindParam(':id_contact',$this->id_contact);
			$stmt->bindParam(':id_billing_address',$this->id_billing_address);
			$stmt->bindParam(':id_receiving_address',$this->id_receiving_address);
			$stmt->bindParam(':name',$this->name);
			$stmt->bindParam(':nationality',$this->nationality);
			$stmt->bindParam(':description',$this->description);
			$stmt->bindParam(':normal_billing_period',$this->normal_billing_period);
			$stmt->bindParam(':phone_number',$this->phone_number);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model company :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM company WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model company :'.$e->getMessage());
			}
			$actual_company = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_company as $key => $value){
				if($actual_company[$key] != $this->$key){
					$stmt = $this->pdo->prepare("UPDATE company SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model company :'.$e->getMessage());
					}
				}
			}
		}
		public function eraseOfDatabase(){
			$stmt = $this->pdo->prepare('DELETE FROM company WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model company :'.$e->getMessage());
			}
		}

		public function getId(){return $this->id;}
		public function getId_group_company(){return $this->id_group_company;}
		public function getId_contact(){return $this->id_contact;}
		public function getId_billing_address(){return $this->id_billing_address;}
		public function getId_receiving_address(){return $this->id_receiving_address;}
		public function getName(){return $this->name;}
		public function getNationality(){return $this->nationality;}
		public function getDescription(){return $this->description;}
		public function getNormal_billing_period(){return $this->normal_billing_period;}
		public function getPhone_number(){return $this->phone_number;}

		public function setId($new){$this->id = $new;}
		public function setId_group_company($new){$this->id_group_company = $new;}
		public function setId_contact($new){$this->id_contact = $new;}
		public function setId_billing_address($new){$this->id_billing_address = $new;}
		public function setId_receiving_address($new){$this->id_receiving_address = $new;}
		public function setName($new){$this->name = $new;}
		public function setNationality($new){$this->nationality = $new;}
		public function setDescription($new){$this->description = $new;}
		public function setNormal_billing_period($new){$this->normal_billing_period = $new;}
		public function setPhone_number($new){$this->phone_number = $new;}
	}

?>