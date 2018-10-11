<?php
	include "connections.php";
	session_start();
	if(isset($_SESSION["sessEmpId"]))	{
		session_unset();
	}
?>
