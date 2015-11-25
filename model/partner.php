<?php

	require_once('database.php');
	require_once('../controller/getText.php');

	class partner {

		private $id;
		private $country;
		private $ref;
		private $tf;

		private $pdo;

		public function __construct($id = 0){

			$this->pdo = database::getInstance();
			$this->tf = new textFinder();
			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
			}
		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM partner WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model partner :".$e->getMessage());
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
			$stmt = $this->pdo->PDOInstance->prepare("INSERT INTO partner(country,ref) VALUES(:country,:ref)");
			$stmt->bindParam(':country',$this->country);
			$stmt->bindParam(':ref',$this->ref);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model partner :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM partner WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model partner :'.$e->getMessage());
			}
			$actual_partner = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_partner as $key => $value){
				if($actual_partner[$key] != $this->$key){
					$stmt = $this->pdo->PDOInstance->prepare("UPDATE partner SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model partner :'.$e->getMessage());
					}
				}
			}
		}
		public function eraseOfDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare('DELETE FROM partner WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model partner :'.$e->getMessage());
			}
		}

		public function printTR(){
			echo('<tr>');
			echo('<td>'.$this->country.'</td>');
			echo('<td>'.$this->ref.'</td>');
			echo('<td><a href="../controller/viewPartner.php?id='.$this->id.'"><button class="btn btn-primary"><span class=\'glyphicon glyphicon-cog\' aria-hidden=\'true\'></span></button></a></td>');
			echo('</tr>');
		}

		public function printToModify($next){
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="next" value="'.$next.'">
				<div class="form-group">
					<label for="country">'.$this->tf->getText(84).'</label>
					<input name="country" type="text" class="form-control" value="'.$this->country.'">
				</div>
				<div class="form-group">
					<label for="ref">'.$this->tf->getText(59).'</label>
					<input name="ref" type="number" class="form-control" value="'.$this->ref.'">
				</div>
			');
		}
		public function getId(){return $this->id;}
		public function getCountry(){return $this->country;}
		public function getRef(){return $this->ref;}

		public function setId($new){$this->id = $new;}
		public function setCountry($new){$this->country = $new;}
		public function setRef($new){$this->ref = $new;}
	}
?>