<?php

	include_once('database.php');

	class address {

		private $id;
		private $country;
		private $state;
		private $zip;
		private $city;
		private $line;
		private $complement;

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
			$stmt_get = $this->pdo->prepare("SELECT * FROM address WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model address :".$e->getMessage());
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
			$stmt = $this->pdo->prepare("INSERT INTO address(country,state,zip,city,line,complement) VALUES(:country,:state,:zip,:city,:line,:complement)");
			$stmt->bindParam(':country',$this->country);
			$stmt->bindParam(':state',$this->state);
			$stmt->bindParam(':zip',$this->zip);
			$stmt->bindParam(':city',$this->city);
			$stmt->bindParam(':line',$this->line);
			$stmt->bindParam(':complement',$this->complement);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model address :'.$e->getMessage());
			}
			$this->id = $this->pdo->lastInsertId();
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM address WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model address :'.$e->getMessage());
			}
			$actual_address = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_address as $key => $value){
				if($actual_address[$key] != $this->$key && $key != "id"){
					$stmt = $this->pdo->prepare("UPDATE address SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model address :'.$e->getMessage());
					}
				}
			}
		}

		public function printAddress(){
			return($this->line.'<br>'.$this->complement.'<br>'.$this->zip.' '.$this->city.'<br>'.$this->state.' '.$this->country);
		}

		public function eraseOfDatabase(){
			$stmt = $this->pdo->prepare('DELETE FROM address WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model address :'.$e->getMessage());
			}
		}

		public function getId(){return $this->id;}
		public function getCountry(){return $this->country;}
		public function getState(){return $this->state;}
		public function getZip(){return $this->zip;}
		public function getCity(){return $this->city;}
		public function getLine(){return $this->line;}
		public function getComplement(){return $this->complement;}

		public function setId($new){$this->id = $new;}
		public function setCountry($new){$this->country = $new;}
		public function setState($new){$this->state = $new;}
		public function setZip($new){$this->zip = $new;}
		public function setCity($new){$this->city = $new;}
		public function setLine($new){$this->line = $new;}
		public function setComplement($new){$this->complement = $new;}
	}
?>