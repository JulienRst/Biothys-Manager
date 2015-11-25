<?php

	require_once "product.php";
	require_once "database.php";

	class order {

		private $id;
		private $number;
		private $date;
		private $customer_name;
		private $products;
		private $pdo;
		private $price;
		private $transport_price;
		private $mail;
		private $countrycode;
		private $customer_id;

		public function __construct($number,$date,$customer_name,$id){
			$this->number = $number;
			$this->date = $date;
			$this->customer_name = $customer_name;
			$this->price = 0;
			$this->transport_price = 0;
			$this->products = array();
			$this->customer_id = $id;
		}

		function markAsESRectific(){
			foreach($this->products as $product){
				$product->setName("[AVOIR]".$product->getName());
			}
		}

		public function setMail($mail){
			$this->mail = $mail;
		}

		public function setCC($cc){
			$this->countrycode = $cc;
		}

		public function addProduct($product){
			$transportDesignation = array('transpor','delivery','frais de port');
			$isTransport = false;
			foreach($transportDesignation as $designation){
				if(strpos(strtolower($product->getName()),$designation) !== false){
					$isTransport = true;
					$product->setName("[TRANSPORT]".$product->getName());
				}
			}
			if($isTransport){
				$this->transport_price += $product->getPrice() * $product->getQuantity();
			} else {
				$this->price += $product->getPrice() * $product->getQuantity();
			}
			array_push($this->products,$product);
		}

		public function getId(){return $this->id;}
		public function getNumber(){return $this->number;}
		public function getDate(){return $this->date;}
		public function getCustomer_name(){return utf8_encode($this->customer_name);}
		public function getProducts(){return $this->products;}
		public function getPrice(){return $this->price;}
		public function getTransportPrice(){return $this->transport_price;}
		public function getCC(){return $this->countrycode;}
		public function getMail(){return $this->mail;}
		public function getCustomer_id(){return $this->customer_id;}
	}
?>