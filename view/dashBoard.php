<!DOCTYPE html>
<html>
	<head>
		<title>Biothys Manager - Index</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	</head>
	<body> 
		<?php include('../view/nav.php'); ?>
		<div class="container">
			<?php include('../view/header.php'); ?>
				<form method="get" action="viewDashBoard.php">
				<div class="inline">
					<div class="form-group block">
						<label for="dateDeb">Date début :</label>
						<input name="dateDeb" class="datepicker form-control short" value="<?php if(isset($_GET['dateDeb'])){echo($_GET['dateDeb']);} ?>">
					</div>
					<div class="form-group block">
						<label for="dateEnd">Date fin :</label>
						<input name="dateEnd" class="datepicker form-control short" value="<?php if(isset($_GET['dateEnd'])){echo($_GET['dateEnd']);} ?>">
					</div>
					<input type="submit" class="btn btn-primary">
				</div>
			</form>
			<div>
			<?php 
				if($display){
			?>
				<div class="dropdown-primo">
					Vous avez fais <?php echo($count); ?> commandes pour un Chiffre d'Affaire de <?php echo($ca);?> €
					<span rel="dropdown-secondo" class="drop glyphicon glyphicon-menu-down" aria-hidden="true"></span>
					<div class="sub-drop" alt="dropdown-secondo">
						<div>
							<div class="dropdown-primo">
								Client 1
								<span rel="dropdown-tercio" class="drop glyphicon glyphicon-menu-down" aria-hidden="true"></span>
								<div class="sub-drop" alt="dropdown-tercio">
									<div>
										Facture 1
									</div>
									<div>
										Facture 2
									</div>
								</div>
							</div>
						</div>
						<div>
							Client 2
						</div>
					</div>
				</div>
			<?php
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