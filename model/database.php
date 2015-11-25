<?php

	/*class database {

		private $servername = "localhost";
		private $username = "root";
		private $password = "";
		private $dbname = "biothys";

		public function getPdo(){
			try {
				$bdd = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);

				/* set the PDO error mode to exception
				* 
				* ATTR_ERRMODE : Les exceptions non attrappées deviennent des erreurs fatales.
				* ERRMODE_EXCEPTION :  "contourner" le point critique de votre code, vous montrer rapidement le problème rencontré
				* et structure notre gestionnaire d'erreur*/

				/*$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				/*Test de connexion établie*/

			/*} catch(PDOException $e){
				echo "Connection failed: " . $e->getMessage(). "<br/>";
				die();
			}

			return $bdd;
		}
	}*/
 
	class database {
		/**
		* Instance de la classe PDO
		*
		* @var PDO
		* @access private
		*/ 
		public $PDOInstance = null;

		/**
		* Instance de la classe SPDO
		*
		* @var SPDO
		* @access private
		* @static
		*/ 
		private static $instance = null;

		/**
		* Constante: nom d'utilisateur de la bdd
		*
		* @var string
		*/
		const DEFAULT_SQL_USER = 'root';
		// const DEFAULT_SQL_USER = 'biothysmibgeldor';

		/**
		* Constante: hôte de la bdd
		*
		* @var string
		*/
		const DEFAULT_SQL_HOST = 'localhost';
		// const DEFAULT_SQL_HOST = 'biothysmibgeldor.mysql.db';

		/**
		* Constante: hôte de la bdd
		*
		* @var string
		*/
		const DEFAULT_SQL_PASS = '';
		// const DEFAULT_SQL_PASS = 'Biothys77';

		/**
		* Constante: nom de la bdd
		*
		* @var string
		*/
		//const DEFAULT_SQL_DTB = 'biothysmibgeldor';
		const DEFAULT_SQL_DTB = 'julienroqalpha';

		/**
		* Constructeur
		*
		* @param void
		* @return void
		* @see PDO::__construct()
		* @access private
		*/
		private function __construct(){
			$this->PDOInstance = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));    
		}

		/**
		* Crée et retourne l'objet SPDO
		*
		* @access public
		* @static
		* @param void
		* @return SPDO $instance
		*/
		public static function getInstance(){  
			if(is_null(self::$instance)){
				self::$instance = new database();
			}
			return self::$instance;
		}

		/**
		* Exécute une requête SQL avec PDO
		*
		* @param string $query La requête SQL
		* @return PDOStatement Retourne l'objet PDOStatement
		*/
		public function query($query){
			return $this->PDOInstance->query($query);
		}
	}
?>