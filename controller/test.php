<?php
	require_once('../model/employee.php');

	$empl = new employee();

	echo($empl->cryptpassword('licornes02'));
?>