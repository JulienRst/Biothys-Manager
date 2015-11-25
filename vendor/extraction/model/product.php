<?php

	class product {

		private $name;
		private $price;
		private $quantity;

		public function __construct($name,$price,$quantity){
			$this->name = $name;
			$this->price = $price;
			$this->quantity = $quantity;
		}

		public function getName(){return utf8_encode($this->name);}
		public function getPrice(){return $this->price;}
		public function getQuantity(){return $this->quantity;}
		public function setName($newName){$this->name = $newName;}

	}
	
?>