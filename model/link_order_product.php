<?php

include_once('database.php');

class link_order_product {

	private $id;
	private $id_product;
	private $id_perfume;
	private $perfume;
	private $id_order;
	private $amount;
	private $price_bis;
	private $product;
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
		$stmt_get = $this->pdo->prepare("SELECT * FROM link_order_product WHERE id = :id");
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
			return true;
		} else {
			return false;
		}
	}

	public function addToDatabase(){
		$stmt = $this->pdo->prepare("INSERT INTO link_order_product(id_product,id_perfume,id_order,amount,price_bis) VALUES(:id_product,:id_perfume,:id_order,:amount,:price_bis)");
		$stmt->bindParam(':id_product',$this->id_product);
		$stmt->bindParam(':id_perfume',$this->id_perfume);
		$stmt->bindParam(':id_order',$this->id_order);
		$stmt->bindParam(':amount',$this->amount);
		$stmt->bindParam(':price_bis',$this->price_bis);
		try {
			$stmt->execute();
		} catch(Exception $e){
			echo('Problem at '.$e->getLine().' from model link_order_product :'.$e->getMessage());
		}
	}

	public function setToDatabase(){
		$stmt_get = $this->pdo->prepare("SELECT * FROM link_order_product WHERE id = :id");
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
		$stmt = $this->pdo->prepare('DELETE FROM link_order_product WHERE id = :id');
		$stmt->bindParam(':id',$this->id);

		try {
			$stmt->execute();
		} catch(Exception $e){
			echo('Problem at '.$e->getLine().' from model link_order_product :'.$e->getMessage());
		}
	}

	public function updateRef(){
		if($this->id_perfume != NULL){
			$this->ref = $this->product->getRef().$this->perfume->getRef();
		} else {
			$this->ref = $this->product->getRef()."000";
		}
	}

	public function getId(){return $this->id;}
	public function getId_product(){return $this->id_product;}
	public function getId_perfume(){return $this->id_perfume;}
	public function getId_order(){return $this->id_order;}
	public function getAmount(){return $this->amount;}
	public function getPrice_bis(){return $this->price_bis;}
	public function getProduct(){return $this->product;}
	public function getRef(){return $this->ref;}

	public function setId($new){$this->id = $new;}
	public function setId_product($new){$this->id_product = $new;}
	public function setId_perfume($new){$this->id_perfume = $new;}
	public function setId_order($new){$this->id_order = $new;}
	public function setAmount($new){$this->amount = $new;}
	public function setPrice_bis($new){$this->price_bis = $new;}
	public function setProduct($new){$this->product = $new;}
	public function setRef($new){$this->ref = $new;}
}
?>