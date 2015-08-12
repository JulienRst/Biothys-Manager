<div class="header">
	<h1>Biothys Manager</h1>
	<h4><?php echo($tf->getText(0));?> : <?php echo(ucwords($employee->getSurname().' '.$employee->getName())); ?> <a href="../controller/disconnect.php"><button class="btn btn-danger"><?php echo($tf->getText(16));?></button></a> </h4>
	
	<?php

		$array_mission = array("view","add","set");
		$array_class = array("products","product","groupproducts","groupproduct","parameters","parameter","groupcompanies","groupcompany","companies","company","customers","customer","employees","employee","orders","order","partners","partner","index");
		$array_name = array("Product","Group Product","Parameter","Group Company","Company","Customer","Employee","Order","Partner","Index");

		$displayClass = "";
		$displayMission = "";

		$countClass = 0;
		foreach($array_class as $class){
			if(stripos($_SERVER['REQUEST_URI'],$class) != FALSE){
				$ind = round(($countClass / 2),0,PHP_ROUND_HALF_DOWN);
				$displayClass = $array_name[$ind];
				if($class[strlen($class) -1] == "s"){
					$displayClass .= "s";
				}
				if($class=="companies")
					$displayClass = "Companies";
				if($class=="groupcompanies")
					$displayClass = "Group Companies";
				break;
			}	
			$countClass ++;
		}

		foreach($array_mission as $mission){
			if(stripos($_SERVER['REQUEST_URI'],$mission) != FALSE){
				$displayMission = ucfirst($mission);
			}
		}
	?>
	<div>
		<?php echo($tf->getText(6));?>: <a href="../controller/setLanguage.php?lng=EN&next=<?php echo($_SERVER["REQUEST_URI"]);?>">EN</a> / <a href="../controller/setLanguage.php?lng=FR&next=<?php echo($_SERVER["REQUEST_URI"]);?>">FR</a> / <a href="../controller/setLanguage.php?lng=GER&next=<?php echo($_SERVER["REQUEST_URI"]);?>">GER</a> / <a href="../controller/setLanguage.php?lng=ES&next=<?php echo($_SERVER["REQUEST_URI"]);?>">ES</a>
	</div>


	<ol class="breadcrumb">
		<li>Biothys</li>
		<li><?php echo($displayClass); ?></li>
		<li><?php echo($displayMission); ?></li>
	</ol>
</div>