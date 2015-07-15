<?php

	include_once('database.php');

	class right_group {

		private $id;
		private $name;

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
			$stmt_get = $this->pdo->prepare("SELECT * FROM right_group WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model right_group :".$e->getMessage());
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
			$stmt = $this->pdo->prepare("INSERT INTO right_group(name) VALUES(:name)");
			$stmt->bindParam(':name',$this->name);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model right_group :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM right_group WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model right_group :'.$e->getMessage());
			}
			$actual_right_group = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_right_group as $key => $value){
				if($actual_right_group[$key] != $this->$key){
					$stmt = $this->pdo->prepare("UPDATE right_group SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model right_group :'.$e->getMessage());
					}
				}
			}
		}
		public function eraseOfDatabase(){
			$stmt = $this->pdo->prepare('DELETE FROM right_group WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model right_group :'.$e->getMessage());
			}
		}

		public function getId(){return $this->id;}
		public function getName(){return $this->name;}

		public function setId($new){$this->id = $new;}
		public function setName($new){$this->name = $new;}
	}
?>