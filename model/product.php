<?php

	require_once('database.php');
	require_once('extraction.php');
	require_once('group_products.php');

	class product {

		private $id;
		private $ref;
		private $name;
		private $description;
		private $cost;
		private $price;
		private $unit;
		private $id_group;
		private $group_product;

		private $pdo;

		public function __construct($id = 0){

			$this->pdo = database::getInstance();
			$this->tf = new textFinder();
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
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM product WHERE id = :id");
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
				$this->group_product = new group_products($this->id_group);
				return true;
			} else {
				return false;
			}
		}

		public function addToDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare("INSERT INTO product(ref,id_group,name,description,unit,cost,price) VALUES(:ref,:id_group,:name,:description,:unit,:cost,:price)");
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
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM product WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model product :'.$e->getMessage());
			}
			$actual_product = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_product as $key => $value){
				if($actual_product[$key] != $this->$key){
					$stmt = $this->pdo->PDOInstance->prepare("UPDATE product SET $key = :value WHERE id= :id");
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
			$stmt = $this->pdo->PDOInstance->prepare('DELETE FROM product WHERE id = :id');
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
					<label for="ref">'.$this->tf->getText(59).'</label>
					<input name="ref" type="number" class="form-control" value="'.$this->ref.'">
				</div>
				<div class="form-group">
					<label for="name">'.$this->tf->getText(25).'</label>
					<input name="name" type="text" class="form-control" value="'.$this->name.'">
				</div>
				<div class="form-group">
					<label for="description">'.$this->tf->getText(42).'</label>
					<input name="description" type="text" class="form-control" value="'.$this->description.'">
				</div>
				<div class="form-group">
					<label for="id_group">'.$this->tf->getText(34).'</label>
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
					<label for="description">'.$this->tf->getText(89).'</label>
					<input name="unit" type="text" class="form-control" value="'.$this->unit.'">
				</div>
				<div class="form-group">
					<label for="description">'.$this->tf->getText(90).'</label>
					<input name="cost" type="text" class="form-control" value="'.$this->cost.'">
				</div>
				<div class="form-group">
					<label for="description">'.$this->tf->getText(75).'</label>
					<input name="price" type="text" class="form-control" value="'.$this->price.'">
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
		public function getGroup_product(){return $this->group_product;}

		public function getNameDes(){return $this->name.' '.$this->description;}

		public function setId($new){$this->id = $new;}
		public function setRef($new){$this->ref = $new;}
		public function setName($new){$this->name = $new;}
		public function setDescription($new){$this->description = $new;}
		public function setCost($new){$this->cost = $new;}
		public function setPrice($new){$this->price = $new;}
		public function setUnit($new){$this->unit = $new;}
		public function setId_group($new){$this->id_group = $new;}
		public function setGroup_product($new){$this->group_product = $new;}
	}
?>