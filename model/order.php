<?php

	require_once('database.php');
	require_once('company.php');
	require_once('employee.php');
	require_once('address.php');


	class order {

		private $id;
		private $id_company;
		private $company;
		private $id_employee;
		private $employee;
		private $id_delivery_address;
		private $delivery_address;
		private $billing_period_bis;
		private $date_issuing;
		private $date_received;
		private $date_entry;
		private $date_shipment;
		private $date_receipt;
		private $date_billing;
		private $line_product;

		private $pdo;

		public function __construct($id = 0){

			$this->pdo = database::getInstance();

			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
				$this->company = new company($this->id_company);
				$this->employee = new employee($this->id_employee);
				$this->delivery_address = new address($this->id_delivery_address);
				$this->line_product = array();
			}
		}

		public function getLineProduct(){
			$stmt = $this->pdo->PDOInstance->prepare("SELECT id FROM link_order_product WHERE id_order = :id");
			$stmt->bindParam(':id',$this->id);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model order :".$e->getMessage());
			}

			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach($stmt as $line_product){
				$line_product = new link_order_product($line_product["id"]);
				array_push($this->line_product, $line_product);
			}

		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM `order` WHERE id = :id");
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
			$stmt = $this->pdo->PDOInstance->prepare("INSERT INTO `order`(id_company,id_employee,billing_period_bis,date_issuing,date_received,date_entry) VALUES(:id_company,:id_employee,:billing_period_bis,:date_issuing,:date_received,:date_entry)");
			$stmt->bindParam(':id_company',$this->id_company);
			$stmt->bindParam(':id_employee',$this->id_employee);
			$stmt->bindParam(':billing_period_bis',$this->billing_period_bis);
			$stmt->bindParam(':date_issuing',$this->date_issuing);
			$stmt->bindParam(':date_received',$this->date_received);
			$stmt->bindParam(':date_entry',$this->date_entry);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model order :'.$e->getMessage());
			}

			return $this->pdo->PDOInstance->lastInsertId();
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM `order` WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model order :'.$e->getMessage());
			}
			$actual_order = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_order as $key => $value){
				if($actual_order[$key] != $this->$key){
					$stmt = $this->pdo->PDOInstance->prepare("UPDATE `order` SET $key = :value WHERE id = :id");
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

		public function printTR(){
			echo('<tr>');
				echo('<td>'.$this->id.'</td>');
				echo('<td>'.$this->company->getName().'</td>');
				echo('<td>'.$this->employee->getSurname().' '.$this->employee->getName().'</td>');
				echo('<td>'.$this->delivery_address->printAddress().'</td>');
				if($this->billing_period_bis != NULL){
					echo('<td>'.$this->billing_period_bis.'</td>');
				} else {
					echo('<td>'.$this->company->getNormal_billing_period().'</td>');
				}
				$tableDate = array("date_issuing" => $this->date_issuing,
								   "date_received" => $this->date_received,
								   "date_entry" => $this->date_entry,
								   "date_shipment" => $this->date_shipment,
								   "date_entry" => $this->date_entry,
								   "date_billing" => $this->date_billing);
				foreach($tableDate as $date){
					if($date == 0){
						echo('<td>not yet specified</td>');
					} else {
						echo('<td>'.date('d-m-y',$date).'</td>');
					}
				}				
				echo('<td><a href="viewOrder.php?id='.$this->id.'"><button><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>');
			echo('</tr>');
		}

		public function eraseOfDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare('DELETE FROM `order` WHERE id = :id');
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
		public function getBilling_period_bis(){return $this->billing_period_bis;}
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
		public function setBilling_period_bis($new){$this->billing_period_bis = $new;}
		public function setDate_issuing($new){$this->date_issuing = $new;}
		public function setDate_received($new){$this->date_received = $new;}
		public function setDate_entry($new){$this->date_entry = $new;}
		public function setDate_shipment($new){$this->date_shipment = $new;}
		public function setDate_receipt($new){$this->date_receipt = $new;}
		public function setDate_billing($new){$this->date_billing = $new;}
		public function setLine_product($new){$this->line_product = $new;}
	}
?>