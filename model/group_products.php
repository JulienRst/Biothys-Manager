<?php

	include_once('database.php');

	class group_products {

		private $id;
		private $name;
		private $products;

		private $pdo;

		public function __construct($id = 0){

			$database = new database();
			$this->pdo = $database->getPdo();

			$this->products = array();

			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
			}
		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM group_product WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model group_product :".$e->getMessage());
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
			$stmt = $this->pdo->prepare("INSERT INTO group_product(name) VALUES(:name)");
			$stmt->bindParam(':name',$this->name);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model group_product :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM group_product WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model group_product :'.$e->getMessage());
			}
			$actual_group_product = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_group_product as $key => $value){
				if($actual_group_product[$key] != $this->$key){
					$stmt = $this->pdo->prepare("UPDATE group_product SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model group_product :'.$e->getMessage());
					}
				}
			}
		}
		public function eraseOfDatabase(){
			$stmt = $this->pdo->prepare('DELETE FROM group_product WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model group_product :'.$e->getMessage());
			}
		}

		public function addProduct($product){
			array_push($this->products,$product);
		}

		public function printToModify($next){
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="next" value="'.$next.'">
				<div class="form-group">
					<label for="name">Name</label>
					<input name="name" type="text" class="form-control" value="'.$this->name.'">
				</div>
			');
		}

		public function getId(){return $this->id;}
		public function getName(){return $this->name;}
		public function getProducts(){return $this->products;}

		public function setId($new){$this->id = $new;}
		public function setName($new){$this->name = $new;}
		public function setProducts($new){$this->products = $new;}

	}
?>