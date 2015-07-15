<?php

	include_once('database.php');
	include_once('extraction.php');

	class product {

		private $id;
		private $ref;
		private $name;
		private $description;
		private $cost;
		private $price;
		private $unit;
		private $id_group;

		private $pdo;

		public function __construct($id = 0){

			$database = new database();
			$this->pdo = $database->getPdo();

			$this->id = $id;
			$this->name = '';
			$this->description = '';
			$this->cost = 0;
			$this->price = 0;
			$this->unit = '';
			$this->id_group = 0;
			if($id != 0){
				$this->getFromDatabase();
			}
		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM product WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model product :'.$e->getMessage());
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
			$stmt = $this->pdo->prepare("INSERT INTO product(ref,id_group,name,description,unit,cost,price) VALUES(:ref,:id_group,:name,:description,:unit,:cost,:price)");
			$stmt->bindParam(':ref',$this->ref);
			$stmt->bindParam(':id_group',$this->id_group);
			$stmt->bindParam(':name',$this->name);
			$stmt->bindParam(':description',$this->description);
			$stmt->bindParam(':unit',$this->unit);
			$stmt->bindParam(':cost',$this->cost);
			$stmt->bindParam(':price',$this->price);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model product :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->prepare("SELECT * FROM product WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model product :'.$e->getMessage());
			}
			$actual_product = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_product as $key => $value){
				if($actual_product[$key] != $this->$key){
					$stmt = $this->pdo->prepare("UPDATE product SET $key = :value WHERE id= :id");
					$stmt->bindParam(':value',$this->$key);
					$stmt->bindParam(':id',$this->id);
					try {
						$stmt->execute();
					} catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model product :'.$e->getMessage());
					}
				}
			}

		}

		public function eraseOfDatabase(){
			$stmt = $this->pdo->prepare('DELETE FROM product WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model product :'.$e->getMessage());
			}
		}

		public function printTR(){
			echo('<tr><td>'.$this->ref.'</td>
			<td>'.$this->name.'</td>
			<td>'.$this->description.'</td>
			<td>'.$this->price.' / '.$this->unit.'</td>
			<td><a href="../controller/viewProduct.php?id='.$this->id.'"><button class=\'modif_product\'><span class=\'glyphicon glyphicon-cog\' aria-hidden=\'true\'></span></button></a></td></tr>');
		}

		public function printToModify($next){
			$extraction = new extraction();
			$groups = $extraction->getGroup();
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
				<div class="form-group">
					<label for="description">Description</label>
					<input name="description" type="text" class="form-control" value="'.$this->description.'">
				</div>
				<div class="form-group">
					<label for="id_group">Group</label>
					<select name="id_group" class="form-control">
					');
						foreach($groups as $group){
							if($this->id_group == $group->getId()){
								echo('<option selected="selected" value="'.$group->getId().'">'.$group->getName().'</option>');
							} else {
								echo('<option value="'.$group->getId().'">'.$group->getName().'</option>');
							}
						}
					echo('
					</select>
				</div>
				<div class="form-group">
					<label for="description">Unit</label>
					<input name="unit" type="text" class="form-control" value="'.$this->unit.'">
				</div>
				<div class="form-group">
					<label for="description">Cost</label>
					<input name="cost" type="number" class="form-control" value="'.$this->cost.'">
				</div>
				<div class="form-group">
					<label for="description">Price</label>
					<input name="price" type="number" class="form-control" value="'.$this->price.'">
				</div>
				');
		}


		public function getId(){return $this->id;}
		public function getRef(){return $this->ref;}
		public function getName(){return $this->name;}
		public function getDescription(){return $this->description;}
		public function getCost(){return $this->cost;}
		public function getPrice(){return $this->price;}
		public function getUnit(){return $this->unit;}
		public function getId_group(){return $this->id_group;}

		public function setId($new){$this->id = $new;}
		public function setRef($new){$this->ref = $new;}
		public function setName($new){$this->name = $new;}
		public function setDescription($new){$this->description = $new;}
		public function setCost($new){$this->cost = $new;}
		public function setPrice($new){$this->price = $new;}
		public function setUnit($new){$this->unit = $new;}
		public function setId_group($new){$this->id_group = $new;}
	}
?>