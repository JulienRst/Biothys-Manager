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
			<a href="viewAddProduct.php"><button class="btn btn-success"><?php echo($tf->getText(17));?></button></a>
			<br/>
			<br/>
			<div class="input-group">
				<input type="text" id="searchProducts" class="form-control">
				<span class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></span>
			</div>
			<?php 
				foreach($groups as $group){
					echo('<h2>'.$group->getName().'</h2>');
					echo('<table class="products table table-stripped">');
					foreach($group->getProducts() as $product){
						$product->printTR();
					}
					echo('</table>');
				}
			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>