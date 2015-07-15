<?php

	include_once('database.php');

	class order {

		private $id;
		private $id_company;
		private $id_employee;
		private $id_delivery_address;
		private $biling_period_bis;
		private $date_issuing;
		private $date_received;
		private $date_entry;
		private $date_shipment;
		private $date_receipt;
		private $date_billing;
		private $line_product;

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
			$stmt_get = $this->pdo->prepare("SELECT * FROM order WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model order :".$e->getMessage());
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
			$stmt = $this->pdo->prepare("INSERT INTO order(id_company,id_employee,id_delivery_address,biling_period_bis,date_issuing,date_received,date_entry,date_shipment,date_receipt,date_billing) VALUES(:id_company,:id_employee,:id_delivery_address,:biling_period_bis,:date_issuing,:date_received,:date_entry,:date_shipment,:date_receipt,:date_billing)");
			$stmt->bindParam(':id_company',$this->id_company);
			$stmt->bindParam(':id_employee',$this->id_employee);
			$stmt->bindParam(':id_delivery_address',$this->id_delivery_address);
			$stmt->bindParam(':biling_period_bis',$this->biling_period_bis);
			$stmt->bindParam(':date_issuing',$this->date_issuing);
			$stmt->bindParam(':date_received',$this->date_received);
			$stmt->bindParam(':date_entry',$this->date_entry);
			$stmt->bindParam(':date_shipment',$this->date_shipment);
			$stmt->bindParam(':date_receipt',$this->date_receipt);
			$stmt->bindParam(':date_billing',$this->date_billing);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model order :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM order WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model order :'.$e->getMessage());
			}
			$actual_order = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_order as $key => $value){
				if($actual_order[$key] != $this->$key){
					$stmt = $this->pdo->prepare("UPDATE order SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model order :'.$e->getMessage());
					}
				}
			}
		}
		public function eraseOfDatabase(){
			$stmt = $this->pdo->prepare('DELETE FROM order WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model order :'.$e->getMessage());
			}
		}

		public function getId(){return $this->id;}
		public function getId_company(){return $this->id_company;}
		public function getId_employee(){return $this->id_employee;}
		public function getId_delivery_address(){return $this->id_delivery_address;}
		public function getBiling_period_bis(){return $this->biling_period_bis;}
		public function getDate_issuing(){return $this->date_issuing;}
		public function getDate_received(){return $this->date_received;}
		public function getDate_entry(){return $this->date_entry;}
		public function getDate_shipment(){return $this->date_shipment;}
		public function getDate_receipt(){return $this->date_receipt;}
		public function getDate_billing(){return $this->date_billing;}
		public function getLine_product(){return $this->line_product;}

		public function setId($new){$this->id = $new;}
		public function setId_company($new){$this->id_company = $new;}
		public function setId_employee($new){$this->id_employee = $new;}
		public function setId_delivery_address($new){$this->id_delivery_address = $new;}
		public function setBiling_period_bis($new){$this->biling_period_bis = $new;}
		public function setDate_issuing($new){$this->date_issuing = $new;}
		public function setDate_received($new){$this->date_received = $new;}
		public function setDate_entry($new){$this->date_entry = $new;}
		public function setDate_shipment($new){$this->date_shipment = $new;}
		public function setDate_receipt($new){$this->date_receipt = $new;}
		public function setDate_billing($new){$this->date_billing = $new;}
		public function setLine_product($new){$this->line_product = $new;}
	}
?>