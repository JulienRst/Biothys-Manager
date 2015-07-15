<?php

	include_once('database.php');

	class perfume {

		private $id;
		private $name;
		private $ref;

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
			$stmt_get = $this->pdo->prepare("SELECT * FROM perfume WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model perfume :".$e->getMessage());
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
			$stmt = $this->pdo->prepare("INSERT INTO perfume(name,ref) VALUES(:name,:ref)");
			$stmt->bindParam(':name',$this->name);
			$stmt->bindParam(':ref',$this->ref);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model perfume :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM perfume WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model perfume :'.$e->getMessage());
			}
			$actual_perfume = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_perfume as $key => $value){
				if($actual_perfume[$key] != $this->$key){
					$stmt = $this->pdo->prepare("UPDATE perfume SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model perfume :'.$e->getMessage());
					}
				}
			}
		}
		public function eraseOfDatabase(){
			$stmt = $this->pdo->prepare('DELETE FROM perfume WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model perfume :'.$e->getMessage());
			}
		}

		public function printTR(){
			echo('<tr>');
				echo('<td>'.$this->ref.'</td>');
				echo('<td>'.utf8_encode($this->name).'</td>');
				echo('<td><a href="viewPerfume.php?id='.$this->id.'"><button><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>');
			echo('</tr>');
		}

		public function printToModify($next){
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="next" value="'.$next.'">
				<div class="form-group">
					<label for="ref">Ref</label>
					<input name="ref" type="number" class="form-control" value="'.$this->ref.'">
				</div>
				<div class="form-group">
					<label for="name">Name</label>
					<input name="name" type="text" class="form-control" value="'.$this->name.'">
				</div>
			');
		}

		public function getId(){return $this->id;}
		public function getName(){return $this->name;}
		public function getRef(){return $this->ref;}

		public function setId($new){$this->id = $new;}
		public function setName($new){$this->name = $new;}
		public function setRef($new){$this->ref = $new;}
	}
?>