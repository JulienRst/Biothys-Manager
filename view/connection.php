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
			<div class="jumbotron">
				<h1>Connection to Biothys Manager</h1>
				<form method="get" action="connection.php" class="">
					<div class="form-group">
						<label for="" class="control-label">Login</label>
						<input type="text" name="login" class="form-control" id="" placeholder="Login"/>
					</div>
					<div class="form-group">
						<label for="" class="control-label">Password</label>
						<input type="password" name="password" class="form-control" id="" placeholder="Password"/>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Sign in</button>
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