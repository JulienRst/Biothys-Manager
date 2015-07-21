<?php

	include_once('database.php');

	class group_company {

		private $id;
		private $ref;
		private $designation;

		private $pdo;

		public function __construct($id = 0){

			$this->pdo = database::getInstance();

			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
			}
		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM group_company WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model group_company :".$e->getMessage());
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
			$stmt = $this->pdo->PDOInstance->prepare("INSERT INTO group_company(ref,designation) VALUES(:ref,:designation)");
			$stmt->bindParam(':ref',$this->ref);
			$stmt->bindParam(':designation',$this->designation);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model group_company :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM group_company WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model group_company :'.$e->getMessage());
			}
			$actual_group_company = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_group_company as $key => $value){
				if($actual_group_company[$key] != $this->$key){
					$stmt = $this->pdo->prepare("UPDATE group_company SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model group_company :'.$e->getMessage());
					}
				}
			}
		}

		public function eraseOfDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare('DELETE FROM group_company WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model group_company :'.$e->getMessage());
			}
		}

		public function printText(){
			echo($this->ref.' : '.$this->designation);
		}

		public function printTR(){
			echo('<tr>');
			echo('<td>'.$this->ref.'</td>');
			echo('<td>'.$this->designation.'</td>');
			echo('<td><a href="../controller/viewGroupCompany.php?id='.$this->id.'"><button class=\'modif_product btn btn-primary\'><span class=\'glyphicon glyphicon-cog\' aria-hidden=\'true\'></span></button></a></td>');
			echo('</tr>');
		}

		public function printToModify($next){
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="class" value="group_company">
				<input type="hidden" name="next" value="'.$next.'">
				<div class="form-group">
					<label for="ref">Ref</label>
					<input name="ref" type="text" class="form-control" value="'.$this->ref.'">
				</div>
				<div class="form-group">
					<label for="name">Designation</label>
					<input name="designation" type="text" class="form-control" value="'.$this->designation.'">
				</div>
			');
		}

		public function getId(){return $this->id;}
		public function getRef(){return $this->ref;}
		public function getDesignation(){return $this->designation;}

		public function setId($new){$this->id = $new;}
		public function setRef($new){$this->ref = $new;}
		public function setDesignation($new){$this->designation = $new;}
	}
?>