<?php

	class database {

		// private $servername = "127.0.0.1";
		// private $username = "root";
		// private $password = "";
		// private $dbname = "db320967";

		private $servername = 'mysql5.biothys-office.com';
		private $dbname = 'db320967';
		private $username = 'db320967';
		private $password = 'bioobi123';

		public function getPdo(){
			try {
				$bdd = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);

				/* set the PDO error mode to exception
				* 
				* ATTR_ERRMODE : Les exceptions non attrappées deviennent des erreurs fatales.
				* ERRMODE_EXCEPTION :  "contourner" le point critique de votre code, vous montrer rapidement le problème rencontré
				* et structure notre gestionnaire d'erreur*/

				$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				/*Test de connexion établie*/

			} catch(PDOException $e){
				echo "Connection failed: " . $e->getMessage(). "<br/>";
				die();
			}

			return $bdd;
		}
	}
?>