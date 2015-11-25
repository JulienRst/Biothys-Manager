<?php

	require_once 'database.php';
	require_once 'order.php';
	require_once 'product.php';
	require_once 'customer.php';

	class extraction {
		private $orders;
		private $pdo;
		private $dateBegin;
		private $dateEnd;
		private $finalPrice;
		private $finalTransportPrice;
		private $typeOfExtract;
		private $nbOfOrders;
		private $clients;

		function __construct($dateBegin,$dateEnd,$typeOfExtract = NULL){
			$this->dateBegin = $dateBegin;
			$this->dateEnd  = $dateEnd;
			$this->typeOfExtract = $typeOfExtract;
			$this->finalPrice = 0;
			$this->finalTransportPrice = 0;
			$database = new database();
			$this->pdo = $database->getPdo();
		}

		public function extract(){
			if($this->typeOfExtract != NULL){
				$stmt = $this->pdo->prepare("SELECT k.firma, kd.nummer, kd.datum, kdp.menge,kdp.einzelpreis,kdp.beschreibung FROM kontakte_dokumente_positionen as kdp, kontakte_dokumente as kd, kontakte as k WHERE kdp.dokument_id = kd.id and kd.kontakte_id = k.id and kdp.dokument_id IN (SELECT kd.id FROM kontakte as k,kontakte_dokumente as kd, einstellungen_dokumente_kontakte as edk WHERE k.id = kd.kontakte_id and kd.typ = edk.id and edk.kurzform = :type and kd.datum >= :beginDate and kd.datum <= :endDate ORDER BY kd.datum) ORDER BY kd.datum");
				$stmt->bindParam(':beginDate',$this->dateBegin);
				$stmt->bindParam(':endDate',$this->dateEnd);
				$stmt->bindParam(':type',$this->typeOfExtract);

				try {
					$stmt->execute();
				} catch(Exception $e){
					echo($e->getLine()." : ".$e->getMessage());
				}

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$this->orders = array();

				foreach($results as $product){
					$tag = $this->getIndex($product["nummer"]);
					if($tag != false){
						$new_product = new product($product["beschreibung"],$product["einzelpreis"],$product["menge"]);
						$this->orders[$tag]->addProduct($new_product);
					} else {
						$new_order = new order($product['nummer'],$product['datum'],$product['firma']);
						$new_product = new product($product["beschreibung"],$product["einzelpreis"],$product["menge"]);
						$new_order->addProduct($new_product);
						array_push($this->orders, $new_order);
					}
				}
				$this->updatePrice();

				return $this->orders;
			} else {
				return NULL;
			}
		}

		public function updatePrice(){
			foreach($this->orders as $order){
				$this->finalPrice += $order->getPrice();
				$this->finalTransportPrice += $order->getTransportPrice();
				$this->nbOfOrders ++;
			}
		}

		private function getIndex($number){
			$orders = $this->getOrders();
			if(count($orders) != 0){
				foreach($orders as $i => $order){
					if($order->getNumber() == $number){
						return $i;
					}
				}
			}
			return false;
		}

		private function getIndexofClient($name,$clients){
			if(count($clients) != 0){
				foreach($clients as $i => $client){
					if($client->getName() == $name){
						return $i;
					}
				}
			}
			return false;
		}

		function extractOrder($type,$deb,$end){
			if($type == "GER"){
				$deb =	date('Y-m-d',DateTime::createFromFormat('d-m-y',$deb)->getTimestamp());
				$end = 	date('Y-m-d',DateTime::createFromFormat('d-m-y',$end)->getTimestamp());
				$stmt = $this->pdo->prepare("SELECT kdp.menge,kdp.einzelpreis FROM kontakte_dokumente_positionen as kdp, kontakte_dokumente as kd WHERE kdp.einzelpreis IS NOT NULL and kdp.dokument_id = kd.id and kd.datum >= :dateBegin and kd.datum <= :dateEnd and typ = 7");
				$stmt->bindParam(':dateBegin',$deb);
				$stmt->bindParam(':dateEnd',$end);
				
				try {
					$stmt->execute();
				} catch(Exception $e){
					echo($e->getLine()." : ".$e->getMessage());
				}

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$count = 0;
				foreach($results as $item){
					$count += $item["menge"] * $item["einzelpreis"];
				}
				return $count;

			} if($type == "ESP"){

				$deb =	date('Y-m-d',DateTime::createFromFormat('d-m-y',$deb)->getTimestamp());
				$end = 	date('Y-m-d',DateTime::createFromFormat('d-m-y',$end)->getTimestamp());
				
				$stmt = $this->pdo->prepare("SELECT kdp.menge,kdp.einzelpreis FROM kontakte_dokumente_positionen as kdp, kontakte_dokumente as kd WHERE kdp.einzelpreis IS NOT NULL and kdp.dokument_id = kd.id and kd.datum >= :dateBegin and kd.datum <= :dateEnd and typ = 14");
				$stmt->bindParam(':dateBegin',$deb);
				$stmt->bindParam(':dateEnd',$end);
				
				try {
					$stmt->execute();
				} catch(Exception $e){
					echo($e->getLine()." : ".$e->getMessage());
				}

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$count = 0;
				foreach($results as $item){
					$count += $item["menge"] * $item["einzelpreis"];
				}

				$stmt = $this->pdo->prepare("SELECT kdp.menge,kdp.einzelpreis FROM kontakte_dokumente_positionen as kdp, kontakte_dokumente as kd WHERE kdp.einzelpreis IS NOT NULL and kdp.dokument_id = kd.id and kd.datum >= :dateBegin and kd.datum <= :dateEnd and typ = 18");
				$stmt->bindParam(':dateBegin',$deb);
				$stmt->bindParam(':dateEnd',$end);
				
				try {
					$stmt->execute();
				} catch(Exception $e){
					echo($e->getLine()." : ".$e->getMessage());
				}

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach($results as $item){
					$count -= $item["menge"] * $item["einzelpreis"];
				}

				return $count;
			}
		}

		function extractClient($type){
			$stmt = $this->pdo->prepare("SELECT k.firma, kd.nummer, kd.datum, kdp.menge,kdp.einzelpreis,kdp.beschreibung FROM kontakte_dokumente_positionen as kdp, kontakte_dokumente as kd, kontakte as k WHERE kdp.dokument_id = kd.id and kd.kontakte_id = k.id and kdp.dokument_id IN (SELECT kd.id FROM kontakte as k,kontakte_dokumente as kd, einstellungen_dokumente_kontakte as edk WHERE k.id = kd.kontakte_id and kd.typ = edk.id and edk.kurzform = :type and kd.datum >= :beginDate and kd.datum <= :endDate ORDER BY kd.datum) ORDER BY kd.datum");
			$stmt->bindParam(':beginDate',$this->dateBegin);
			$stmt->bindParam(':endDate',$this->dateEnd);
			$re = $type;
			$stmt->bindParam(':type',$re);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo($e->getLine()." : ".$e->getMessage());
			}

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$this->orders = array();

			foreach($results as $product){
				$tag = $this->getIndex($product["nummer"]);
				if($tag !== false){
					$new_product = new product($product["beschreibung"],$product["einzelpreis"],$product["menge"]);
					$this->orders[$tag]->addProduct($new_product);
				} else {
					$new_order = new order($product['nummer'],$product['datum'],$product['firma'],null);
					$new_product = new product($product["beschreibung"],$product["einzelpreis"],$product["menge"]);
					$new_order->addProduct($new_product);
					array_push($this->orders, $new_order);
				}
			}
			$this->updatePrice();
			$this->clients = array();

			foreach($this->orders as $order){
				if(strpos(strtolower($order->getCustomer_name()),strtolower("Biothys GmbH (Spain)")) == false){
					$tag = $this->getIndexofClient($order->getCustomer_name(),$this->clients);
					if($tag != false){
						$this->clients[$tag]->addOrder($order);
					} else {
						$new_customer = new customer($order->getCustomer_name());
						$new_customer->addOrder($order);
						array_push($this->clients, $new_customer);
					}
				}
			}
			return $this->clients;
		}

		function extractClientMail(){
			$stmt = $this->pdo->prepare("SELECT k.id,k.firma,k.email,k.land, kd.nummer,kdp.einzelpreis,kdp.menge FROM kontakte as k, kontakte_dokumente as kd, kontakte_dokumente_positionen as kdp WHERE k.land like '%%' and kdp.dokument_id = kd.id and kd.kontakte_id = k.id and kdp.dokument_id IN (SELECT kd.id FROM kontakte_dokumente as kd WHERE kd.typ = 7) ORDER BY k.land");
			try {
				$stmt->execute();
			} catch (Exception $e){
				echo($e->getLine()." : ".$e->getMessage());
			}

			$lineOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$this->orders = array();

			foreach ($lineOrders as $lineOrder) {
				$tag = $this->getIndex($lineOrder["nummer"]);
				if($tag !== false){
					$new_product = new product('',$lineOrder["einzelpreis"],$lineOrder["menge"]);
					$this->orders[$tag]->addProduct($new_product);
				} else {
					$new_order = new order($lineOrder['nummer'],'',$lineOrder['firma'],$lineOrder['id']);
					$new_order->setCC($lineOrder['land']);
					$new_order->setMail($lineOrder['email']);
					$new_product = new product('',$lineOrder["einzelpreis"],$lineOrder["menge"]);
					$new_order->addProduct($new_product);
					array_push($this->orders, $new_order);
				}
				$this->updatePrice();
			}

			$this->clients = array();

			foreach($this->orders as $order){
				if($order->getCC() != 0 && $order->getCC() != NULL){
					$tag = $this->getIndexofClient($order->getCustomer_name(),$this->clients);
					if($tag !== false){
						$this->clients[$tag]->addOrder($order);
					} else {
						$new_customer = new customer($order->getCustomer_name());
						$new_customer->addOrder($order);
						$new_customer->setId($order->getCustomer_id());
						$new_customer->setCC($order->getCC());
						$new_customer->setMail($order->getMail());
						array_push($this->clients, $new_customer);
					}
				}
			}

			foreach($this->clients as $client){
				$client->calcAmount();
			}

			return $this->clients;
		}

		public function getOrders(){return $this->orders;}
		public function getFinalPrice(){return $this->finalPrice;}
		public function getFinalTransportPrice(){return $this->finalTransportPrice;}
		public function addToFinalPrice($amount){$this->finalPrice += $amount;}
		public function getNbOfOrders(){return $this->nbOfOrders;}
	}

?>