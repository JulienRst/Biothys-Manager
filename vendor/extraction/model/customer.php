<?php
	require_once('database.php');

	class customer {
		private $id;
		private $name;
		private $mail;
		private $nbOrders;
		private $totalCommande;
		private $orders;
		private $amount;
		private $cc;

		public function __construct($name){
			$this->name = $name;
			$this->orders = array();
			$this->totalCommande = 0;
			$this->nbOrders = 0;
		}


		public function addOrder($order){

			$this->totalCommande += $order->getPrice();
			$this->nbOrders ++;
			array_push($this->orders, $order);
		}

		public function getId(){return $this->id;}
		public function getName(){return $this->name;}
		public function getOrders(){return $this->orders;}
		public function getAmount(){return $this->amount;}
		public function getNbOrders(){return $this->nbOrders;}
		public function getMail(){return $this->mail;}
		public function getCC(){return $this->cc;}

		public function markAsRectific(){
			$this->name = "[AVOIR]".$this->name;
		}

		public function setCC($cc){
			$this->cc = $cc;
		}

		public function calcAmount(){
			foreach ($this->orders as $order) {
				$this->amount += $order->getPrice();
			}
		}

		public function setId($new){$this->id = $new;}

		public function setMail($mail){
			$this->mail = $mail;
		}

	}
?>