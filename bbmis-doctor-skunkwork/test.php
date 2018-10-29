<?php
	include "connections.php";

	// $varRangeFrom = date_format(date_create($_GET['from_range']), 'F d, Y');
	// $varRangeTo =  date_format(date_create($_GET['to_range']), 'F d, Y');
	$varRangeFrom = $_GET['from_range'];
	$varRangeTo = $_GET['to_range'];
	
	echo "From: " . $varRangeFrom;
	echo "<br>";
	echo "To: " . $varRangeTo;
	
	// echo "<table>";
	
	// $qryDaily = mysqli_query($connections, "
		// SELECT DATE_FORMAT(dtmDateStored, '%M %d, %Y')
		// FROM tblbloodbag
		// WHERE dtmDateStored BETWEEN '$varRangeFrom' AND '$varRangeTo'
		// GROUP BY 1
	// ");
	
	// while($rowDaily = mysqli_fetch_assoc($qryDaily))	{
		
	// }
	
	// echo "</table>";
	
	//Fetch used Blood Types.
	$qryFetchBloodTypes = mysqli_query($connections, "
		SELECT DISTINCT(stfBloodType)
		FROM tblbloodtype
		WHERE stfBloodType <> 'Undefined'
	");
	$arrBloodTypes = array();
	while($rowBloodType = mysqli_fetch_assoc($qryFetchBloodTypes))	{
		array_push($arrBloodTypes, $rowBloodType["stfBloodType"]);
	}
	
	for($x=0; $x<sizeof($arrBloodTypes); $x++)	{
		// $pdf -> SetX(0.5);
		// $pdf -> Cell(7.5, 0.3, $arrBloddTypes[$x], 1, 1, 'C', true);
	}
?>