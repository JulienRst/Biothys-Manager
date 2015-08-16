<?php
	$json = file_get_contents('http://127.0.0.1/extraction/controller/getInvoiceMonth.php?dateDeb=01-01-14&dateEnd=31-08-15','true');
	$obj = json_decode($json);
	var_dump($obj);
?>