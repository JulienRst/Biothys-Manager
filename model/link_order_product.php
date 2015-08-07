<?php

	include_once('database.php');
	require_once('parameter.php');
	require_once('product.php');

	class link_order_product {

		private $id;
		private $id_product;
		private $id_parameter;
		private $parameter;
		private $id_order;
		private $amount;
		private $price_bis;
		private $product;
		private $ref;
		private $ref_batch;

		private $pdo;

		public function __construct($id = 0){

			$this->pdo = database::getInstance();

			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
			}
		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM link_order_product WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model link_order_product :".$e->getMessage());
			}

			if($stmt_get->rowcount() != 0){
				$stmt_get = $stmt_get->fetch(PDO::FETCH_ASSOC);
				foreach($stmt_get as $key => $value){
					$this->$key = $value;
				}

				$this->product = new product($this->id_product);
				$this->ref = $this->product->getRef();
				$this->parameter = new parameter($this->id_parameter);
				$this->updateRef();
				return true;
			} else {
				return false;
			}
		}

		public function addToDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare("INSERT INTO link_order_product(id_product,id_parameter,id_order,ref_batch,amount,price_bis) VALUES(:id_product,:id_parameter,:id_order,:ref_batch,:amount,:price_bis)");
			$stmt->bindParam(':id_product',$this->id_product);
			$stmt->bindParam(':id_parameter',$this->id_parameter);
			$stmt->bindParam(':id_order',$this->id_order);
			$stmt->bindParam(':ref_batch',$this->ref_batch);
			$stmt->bindParam(':amount',$this->amount);
			$stmt->bindParam(':price_bis',$this->price_bis);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model link_order_product :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM link_order_product WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model link_order_product :'.$e->getMessage());
			}
			$actual_link_order_product = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_link_order_product as $key => $value){
				if($actual_link_order_product[$key] != $this->$key){
					$stmt = $this->pdo->prepare("UPDATE link_order_product SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model link_order_product :'.$e->getMessage());
					}
				}
			}
		}
		public function eraseOfDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare('DELETE FROM link_order_product WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model link_order_product :'.$e->getMessage());
			}
		}

		public function updateRef(){
			if($this->id_parameter != NULL){
				$this->ref = $this->product->getRef().$this->parameter->getRef();
			}
		}

		public function getId(){return $this->id;}
		public function getId_product(){return $this->id_product;}
		public function getId_parameter(){return $this->id_parameter;}
		public function getParameter(){return $this->parameter;}
		public function getId_order(){return $this->id_order;}
		public function getAmount(){return $this->amount;}
		public function getPrice_bis(){return $this->price_bis;}
		public function getProduct(){return $this->product;}
		public function getRef(){return $this->ref;}
		public function getRef_batch(){return $this->ref_batch;}

		public function setId($new){$this->id = $new;}
		public function setId_product($new){$this->id_product = $new;}
		public function setId_parameter($new){$this->id_parameter = $new;}
		public function setId_order($new){$this->id_order = $new;}
		public function setAmount($new){$this->amount = $new;}
		public function setPrice_bis($new){$this->price_bis = $new;}
		public function setProduct($new){$this->product = $new;}
		public function setRef($new){$this->ref = $new;}
		public function setRef_batch($new){$this->ref_batch = $new;}
	}
?>