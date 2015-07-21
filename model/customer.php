<?php

	include_once('database.php');
	require_once('company.php');

	class customer {

		private $id;
		private $id_company;
		private $company_name;
		private $name;
		private $mail;
		private $nationality;
		private $phone_number;
		private $id_address;
		private $address;

		private $pdo;

		public function __construct($id = 0){

			$this->pdo = database::getInstance();

			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
				$this->address = new address($this->id_address);
				$stmt = $this->pdo->PDOInstance->prepare("SELECT name FROM company WHERE id = :id");
				$stmt->bindParam(':id',$this->id_company);
				try {
					$stmt->execute();
				} catch(Exception $e){
					echo("Problem at ".$e->getLine()." from model customer :".$e->getMessage());
				}
				$stmt = $stmt->fetch(PDO::FETCH_ASSOC);
				$this->company_name = $stmt["name"];
			}
		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM customer WHERE id = :id");
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
			$this->id_company = -1;
			$this->id_address = -1;
			$stmt = $this->pdo->PDOInstance->prepare("INSERT INTO customer(id_company,name,mail,nationality,phone_number,id_address) VALUES (:id_company,:name,:mail,:nationality,:phone_number,:id_address)");
				
			$stmt->bindParam(':id_company',$this->id_company);
			$stmt->bindParam(':name',$this->name);
			$stmt->bindParam(':mail',$this->mail);
			$stmt->bindParam(':nationality',$this->nationality);
			$stmt->bindParam(':phone_number',$this->phone_number);
			$stmt->bindParam(':id_address',$this->id_address);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model customer :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM customer WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model customer :'.$e->getMessage());
			}
			$actual_customer = $stmt_get->fetch(PDO::FETCH_ASSOC);


			foreach($actual_customer as $key => $value){

				echo($actual_customer[$key].'<br/>');

				if($actual_customer[$key] != $this->$key && $this->$key != "" && $key != null){
					$stmt = $this->pdo->PDOInstance->prepare("UPDATE customer SET $key = :value WHERE id = :id");
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

		public function printTR(){
			echo('<tr>');

			$c = new company($this->id_company);
			$company = $c->getName();

			echo('<td>'.$this->name.'</td>');
			echo('<td>'.$company.'</td>');
			echo('<td>'.$this->nationality.'</td>');
			echo('<td>'.$this->mail.'</td>');
			echo('<td>'.$this->phone_number.'</td>');
			echo('<td><a href="../controller/viewCustomer.php?id='.$this->id.'"><button class=""><span class=\'glyphicon glyphicon-cog\' aria-hidden=\'true\'></span></button></a></td>');
			echo('</tr>');
		}

		public function printText(){
			echo($this->name.'<br/>'.$this->mail.'<br/>'.$this->phone_number);
		}

		public function printLink(){
			echo('<a href="../controller/viewCustomer.php?id='.$this->id.'">'.$this->name.'</a>');
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

		public function printToAdd($next){
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="next" value="'.$next.'">
				<div class="form-group">
					<label for="name">Name</label>
					<input name="name" type="text" class="form-control" value="'.$this->name.'">
				</div>
				<div class="form-group">
					<label for="nationality">Nationality</label>
					<input name="nationality" type="text" class="form-control" value="'.$this->nationality.'">
				</div>
				<div class="form-group">
					<label for="mail">Mail</label>
					<input name="mail" type="mail" class="form-control" value="'.$this->mail.'">
				</div>
				<div class="form-group">
					<label for="phone_number">Phone number</label>
					<input name="phone_number" type="text" class="form-control" value="'.$this->phone_number.'">
				</div>
			');
		}

		public function printToModify($next){
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="next" value="'.$next.'">
				<div class="form-group">
					<label for="name">Name</label>
					<input name="name" type="text" class="form-control" value="'.$this->name.'">
				</div>
				<div class="form-group">
					<label for="nationality">Nationality</label>
					<input name="nationality" type="text" class="form-control" value="'.$this->nationality.'">
				</div>
				<div class="form-group">
					<label for="phone_number">Phone number</label>
					<input name="phone_number" type="text" class="form-control" value="'.$this->phone_number.'">
				</div>
				<div class="form-group">
					<label for="mail">Mail</label>
					<input name="mail" type="mail" class="form-control" value="'.$this->mail.'">
				</div>
				<div class="form-group">
					<label for="id_company">Company (add or set the address with the button bellow not the textarea)</label>
					<input type="text" id="company" class="form-control" value="'.$this->company_name.'">
					<input name="id_company" type="hidden" class="form-control" value="'.$this->id_company.'">
					<button id="getCompany" alt="customer" step="company" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
				</div>
				<div class="form-group">
					<label for="id_address">Address (add or set the address with the button bellow not the textarea)</label>
					<input type="text" id="address" class="form-control" value="'.str_replace('<br/>',' ',$this->address->printAddress()).'">
					<input name="id_address" type="hidden" class="form-control" value="'.$this->id_address.'">
					<button id="addAddress" alt="customer" step="address" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></a>
					<button id="setAddress" alt="customer" step="address" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button></a>
					<button id="getAddress" alt="customer" step="address" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
				</div>
			');
		}

		public function getId(){return $this->id;}
		public function getId_company(){return $this->id_company;}
		public function getName(){return $this->name;}
		public function getMail(){return $this->mail;}
		public function getNationality(){return $this->nationality;}
		public function getPhone_number(){return $this->phone_number;}
		public function getId_address(){return $this->id_address;}
		public function getAddress(){return $this->address;}

		public function setId($new){$this->id = $new;}
		public function setId_company($new){$this->id_company = $new;}
		public function setName($new){$this->name = $new;}
		public function setMail($new){$this->mail = $new;}
		public function setNationality($new){$this->nationality = $new;}
		public function setPhone_number($new){$this->phone_number = $new;}
		public function setId_address($new){$this->id_address = $new;}
		public function setAddress($new){$this->address = $new;}
	}
?>