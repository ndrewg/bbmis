<?php 
include("../connections.php");

if($_POST["bloodtype"]){
	$bloodtype = $_POST["bloodtype"];

	$sort_bloodbagbybloodtype = mysqli_query($connections, " SELECT * FROM tblbloodbag tbb JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId WHERE stfBloodType = '$bloodtype' ");

	if(mysqli_num_rows($sort_bloodbagbybloodtype) > 0 ){
		$output = "";
		while($row = mysqli_fetch_assoc($sort_bloodbagbybloodtype)) {
			$serialno = $row["strBloodBagSerialNo"];
			$output .= "$serialno";
		}
		echo $output;
	}
}
?>