<!DOCTYPE html>
<html>
	<head>
		<title>Biothys Manager - Connection</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	</head>
	<body> 

		<div class="container connect">
			<div>
				<?php echo($tf->getText(6));?> : <a href="../controller/setLanguage.php?lng=EN&next=<?php echo($_SERVER["REQUEST_URI"]);?>">EN</a> / <a href="../controller/setLanguage.php?lng=FR&next=<?php echo($_SERVER["REQUEST_URI"]);?>">FR</a> / <a href="../controller/setLanguage.php?lng=GER&next=<?php echo($_SERVER["REQUEST_URI"]);?>">GER</a> / <a href="../controller/setLanguage.php?lng=ES&next=<?php echo($_SERVER["REQUEST_URI"]);?>">ES</a>
			</div>
			<div class="jumbotron">
				<h1><?php echo($tf->getText(2));?></h1>
				<form method="get" action="connection.php" class="">
					<div class="form-group">
						<label for="" class="control-label"><?php echo($tf->getText(3));?></label>
						<input type="text" name="login" class="form-control" id="" placeholder="Login"/>
					</div>
					<div class="form-group">
						<label for="" class="control-label"><?php echo($tf->getText(4));?></label>
						<input type="password" name="password" class="form-control" id="" placeholder="Password"/>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary"><?php echo($tf->getText(5));?></button>
					</div>
				</form>
				<?php 
					if(isset($_SESSION["error"])){
						try {
							$error = unserialize($_SESSION["error"]);
							$error->print_error();
							unset($_SESSION["error"]);
						} catch(Exception $e){
							$_SESSION["error"]->print_error();
							unset($_SESSION["error"]);
						}
					}
				?>
			</div>
		</div>


		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>