<!DOCTYPE html>
<html>
	<head>
		<title>Biothys | Client</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/datepicker.css">
	</head>
	<body>
		<h1>Extraction des données de Biothys Office</h1>
		<form class="form-inline" method="get" action="../controller/viewBaseClient.php">	
			<div class="form-group">
				<label for="dateBegin">Début : </label>
				<input name="dateBegin" class="datepicker" data-date-format="yyyy-mm-dd">
			</div>
			<div class="form-group">
				<label for="dateEnd">Fin : </label>
				<input name="dateEnd" class="datepicker" data-date-format="yyyy-mm-dd">
			</div>
			<button class="btn btn-success" type="submit">Rechercher</button>
		</form>

		<?php 
				if($displayResult){

					echo('<h2>Biothys GmbH</h2>');
					echo('<table class="table table-striped table-bordered">');
					//HEADER
					echo('<tr><th>Client</th>');
					$nbColumn = 0;
					for($i=$debDateYear;$i<=$endDateYear;$i++){
						$indice = $i - $debDateYear;
						for($j=$jtab[$indice][0];$j<=$jtab[$indice][1];$j++){
							echo('<th>'.$i.'/'.$j.'</th>');
							$nbColumn ++;
						}
					}
					echo('<th>Total</th>');
					echo('</tr>');
					$tableResultat = array();
					$tableFinalResultat = array();
					for($i=0;$i<$nbColumn;$i++){
						$tableResultat[$i] = 0;
						$tableFinalResultat[$i] = 0;
					}
					foreach($clients as $client){
						$amountClient = 0;
						$tryhard = 0;
						echo('<tr>');
						echo('<td>'.$client->getName().'</td>');
						for($i=$debDateYear;$i<=$endDateYear;$i++){
							$indice = $i - $debDateYear;
							for($j=$jtab[$indice][0];$j<=$jtab[$indice][1];$j++){
								echo('<td>');
								$amount = 0;
								foreach($client->getOrders() as $order){
									$date = substr($order->getDate(),0,7);
									if($j < 10){
										$datecheck = $i."-0".$j;
									} else {
										$datecheck = $i."-".$j;
									}
									if($date == $datecheck){
										$amount += $order->getPrice();
									}
								}
								if($amount != 0) {
									echo(str_replace('.',',',$amount));
									$tableResultat[$tryhard] += $amount;
									$amountClient += $amount;
								}
								echo('</td>');
								
								$tryhard ++;
							}
						}
						echo('<td>'.str_replace('.',',',$amountClient).'</td></tr>');
					}
					echo('<tr><th>Total au mois</th>');
					$amountTotalPrime = 0;
					for($i=0;$i<$nbColumn;$i++){
						$tableFinalResultat[$i] += $tableResultat[$i];
						echo('<td>'.str_replace('.',',',$tableResultat[$i]).'</td>');
						$amountTotalPrime += $tableResultat[$i];
					}
					echo('<td>'.str_replace('.',',',$amountTotalPrime).'</td></tr>');
					for($i=0;$i<$nbColumn;$i++){
						$tableResultat[$i] = 0;
					}
					echo('</table>');
					echo('<h2>Biothys Spain (INVOICE)</h2>');
					echo('<table class="table table-striped table-bordered">');
					//HEADER
					echo('<tr><th>Client</th>');
					$nbColumn = 0;
					for($i=$debDateYear;$i<=$endDateYear;$i++){
						$indice = $i - $debDateYear;
						for($j=$jtab[$indice][0];$j<=$jtab[$indice][1];$j++){
							echo('<th>'.$i.'/'.$j.'</th>');
							$nbColumn ++;
						}
					}
					echo('<th>Total</th>');
					echo('</tr>');
					$tableResultat = array();
					for($i=0;$i<$nbColumn;$i++){
						$tableResultat[$i] = 0;
					}
					foreach($clientsES1 as $client){
						$amountClient = 0;
						$tryhard = 0;
						echo('<tr>');
						echo('<td>'.$client->getName().'</td>');
						for($i=$debDateYear;$i<=$endDateYear;$i++){
							$indice = $i - $debDateYear;
							for($j=$jtab[$indice][0];$j<=$jtab[$indice][1];$j++){
								echo('<td>');
								$amount = 0;
								foreach($client->getOrders() as $order){
									$date = substr($order->getDate(),0,7);
									if($j < 10){
										$datecheck = $i."-0".$j;
									} else {
										$datecheck = $i."-".$j;
									}
									if($date == $datecheck){
										$amount += $order->getPrice();
									}
								}
								if($amount != 0) {
									echo(str_replace('.',',',$amount));
									$tableResultat[$tryhard] += $amount; 
									$amountClient += $amount;
								}
								echo('</td>');
								$tryhard ++;
							}
						}
						echo('<td>'.str_replace('.',',',$amountClient).'</td></tr>');
					}
					echo('<tr><th>Total au mois</th>');
					$amountTotalPrime = 0;
					for($i=0;$i<$nbColumn;$i++){
						$tableFinalResultat[$i] +=$tableResultat[$i];
						echo('<td>'.str_replace('.',',',$tableResultat[$i]).'</td>');
						$amountTotalPrime += $tableResultat[$i];
					}
					for($i=0;$i<$nbColumn;$i++){
						$tableResultat[$i] = 0;
					}
					echo('<td>'.str_replace('.',',',$amountTotalPrime).'</td></tr>');
					echo('</table>');
					echo('<h2>Biothys Spain (RECTIFIC)</h2>');
					echo('<table class="table table-striped table-bordered">');
					//HEADER
					echo('<tr><th>Client</th>');
					$nbColumn = 0;
					for($i=$debDateYear;$i<=$endDateYear;$i++){
						$indice = $i - $debDateYear;
						for($j=$jtab[$indice][0];$j<=$jtab[$indice][1];$j++){
							echo('<th>'.$i.'/'.$j.'</th>');
							$nbColumn ++;
						}
					}
					echo('<th>Total</th>');
					echo('</tr>');
					$tableResultat = array();
					for($i=0;$i<$nbColumn;$i++){
						$tableResultat[$i] = 0;
					}
					foreach($clientsES2 as $client){
						$amountClient = 0;
						$tryhard = 0;
						echo('<tr>');
						echo('<td>'.$client->getName().'</td>');
						for($i=$debDateYear;$i<=$endDateYear;$i++){
							$indice = $i - $debDateYear;
							for($j=$jtab[$indice][0];$j<=$jtab[$indice][1];$j++){
								echo('<td>');
								$amount = 0;
								foreach($client->getOrders() as $order){
									$date = substr($order->getDate(),0,7);
									if($j < 10){
										$datecheck = $i."-0".$j;
									} else {
										$datecheck = $i."-".$j;
									}
									if($date == $datecheck){
										$amount += $order->getPrice();
									}
								}
								if($amount != 0) {
									echo(str_replace('.',',',$amount));
									$tableResultat[$tryhard] += $amount; 
									$amountClient += $amount;
								}
								echo('</td>');
								$tryhard ++;
							}
						}
						echo('<td>'.str_replace('.',',',$amountClient).'</td></tr>');
					}
					echo('<tr><th>Total au mois</th>');
					$amountTotalPrime = 0;
					for($i=0;$i<$nbColumn;$i++){
						$tableFinalResultat[$i] -=$tableResultat[$i];
						echo('<td>'.str_replace('.',',',($tableResultat[$i])).'</td>');
						$amountTotalPrime += $tableResultat[$i];
					}
					echo('<td>'.str_replace('.',',',$amountTotalPrime).'</td></tr>');
					echo('</table>');

					echo('<h2>Compte Final</h2>');
					echo('<table class="table table-striped">');
					echo('<tr>');
					for($i=$debDateYear;$i<=$endDateYear;$i++){
						$indice = $i - $debDateYear;
						for($j=$jtab[$indice][0];$j<=$jtab[$indice][1];$j++){
							echo('<th>'.$i.'/'.$j.'</th>');
						}
					}
					echo('</tr>');
					echo('<tr>');
					$amounttotal = 0;
					for($i=0;$i<$nbColumn;$i++){
						echo('<td>'.str_replace('.',',',$tableFinalResultat[$i]).'</td>');
						$amounttotal += $tableFinalResultat[$i];
					}
					echo('</tr>');
					echo('<tr><td>Montant final :<b>'.str_replace('.',',',$amounttotal).'</b></td></tr>');
					echo('</table>');
				}



		?>
			


		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap-datepicker.js"></script>
	</body>
</html>	