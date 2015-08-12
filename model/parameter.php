<?php

	include_once('database.php');

	class parameter {

		private $id;
		private $name;
		private $ref;
		private $type;

		private $pdo;

		public function __construct($id = 0){

			$this->pdo = database::getInstance();

			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
			}

		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM parameter WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model parameter :".$e->getMessage());
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
			$stmt = $this->pdo->PDOInstance->prepare("INSERT INTO parameter(name,ref) VALUES(:name,:ref)");
			$stmt->bindParam(':name',$this->name);
			$stmt->bindParam(':ref',$this->ref);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model parameter :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM parameter WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model parameter :'.$e->getMessage());
			}
			$actual_parameter = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_parameter as $key => $value){
				if($actual_parameter[$key] != $this->$key){
					$stmt = $this->pdo->PDOInstance->prepare("UPDATE parameter SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model parameter :'.$e->getMessage());
					}
				}
			}
		}
		public function eraseOfDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare('DELETE FROM parameter WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model parameter :'.$e->getMessage());
			}
		}

		public function printTR(){
			echo('<tr>');
				echo('<td>'.$this->ref.'</td>');
				echo('<td>'.$this->type.'</td>');
				echo('<td>'.$this->name.'</td>');
				echo('<td><a href="viewParameter.php?id='.$this->id.'"><button><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>');
			echo('</tr>');
		}

		public function printToModify($next){
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="next" value="'.$next.'">
				<div class="form-group">
					<label for="ref">'.$this->tf->getText(59).'</label>
					<input name="ref" type="number" class="form-control" value="'.$this->ref.'">
				</div>
				<div class="form-group">
					<label for="type">'.$this->tf->getText(28).'</label>
					<input name="type" type="number" class="form-control" value="'.$this->type.'">
				</div>
				<div class="form-group">
					<label for="name">'.$this->tf->getText(25).'</label>
					<input name="name" type="text" class="form-control" value="'.$this->name.'">
				</div>
			');
		}

		public function getId(){return $this->id;}
		public function getName(){return $this->name;}
		public function getRef(){return $this->ref;}
		public function getType(){return $this->type;}

		public function setId($new){$this->id = $new;}
		public function setName($new){$this->name = $new;}
		public function setRef($new){$this->ref = $new;}
		public function setType($new){$this->type = $new;}
	}
?>