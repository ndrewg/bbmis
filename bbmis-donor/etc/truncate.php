<?php
	include "../connection.php";
	
	$qryEmpty1 = mysqli_query($conn, "
		TRUNCATE tbldonation;
	");
	
	$qryEmpty2 = mysqli_query($conn, "
		TRUNCATE tblmedicalexam;
	");
	
	$qryEmpty3 = mysqli_query($conn, "
		TRUNCATE tblphysicalexam;
	");
	
	$qryEmpty4 = mysqli_query($conn, "
		TRUNCATE tblinitialscreening;
	");
	
	$qryEmpty5 = mysqli_query($conn, "
		TRUNCATE tblserologicalscreening;
	");
	
	$qryEmpty6 = mysqli_query($conn, "
		TRUNCATE tblrequest;
	");
	
	
	if($qryEmpty1 && $qryEmpty2 && $qryEmpty3 && $qryEmpty4 && $qryEmpty5 && $qryEmpty6)	{
		echo 3;
	}
	
	else	{
		echo 'kups';
	}
?>