<?php

	class textFinder {

		public $json;
		public $text;
		public $language;

		public function __construct(){
			if(!isset($_SESSION)){
				session_start();
			}
			//Open the JSON
			$this->json = file_get_contents("../assets/text.json");
			$this->text = json_decode($this->json, true);

			$this->text = $this->text["text"];

			if(isset($_SESSION['lng'])){
				if($_SESSION['lng'] != ""){
					$this->language = $_SESSION['lng'];
				} else {
					$this->language = "EN";
				}
			} else {
				$this->language = "EN";
			}
		}

		public function getText($id){
			$item = $this->text[$id][$this->language];
			if($item != ""){
				return $item;
			} else {
				return $this->text[$id]["EN"];
			}
		}


	}
	if(!isset($tf)){
		$tf = new textFinder();
	}
	
?>