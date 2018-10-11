<?php
	include "connections.php";
	session_start();
	$varEmpId = $_SESSION["sessEmpId"];

	// echo $varDbId;

	$qryFetchEmpInfo = mysqli_query($connections, "
		SELECT strEmployeeFirstName, strEmployeeLastName, stfEmployeeType
		FROM tblemployee
		WHERE intEmployeeId = $varEmpId
	");
	while($rowEmpInfo = mysqli_fetch_assoc($qryFetchEmpInfo))	{
		$varFname = $rowEmpInfo["strEmployeeFirstName"];
		$varLname = $rowEmpInfo["strEmployeeLastName"];
		$varRole = $rowEmpInfo["stfEmployeeType"];
	}
?>
