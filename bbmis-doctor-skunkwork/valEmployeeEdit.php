<?php
	include("connections.php");
	parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
  $varId = $params["hidden_id"];
	$varFname = $params["txtFname"];
	$varMname = $params["txtMname"];
	$varLname = $params["txtLname"];
	$varPos = $params["optPos"];
  $varstat = $params["optstat"];

  if($varId && $varFname && $varLname && $varPos && $varstat){
    mysqli_query($connections,"UPDATE tblemployee
      SET strEmployeeFirstName = '$varFname',strEmployeeMiddleName = '$varMname',strEmployeeLastName = '$varLname',stfEmployeeType = '$varPos',stfEmployeeStatus = '$varstat'
      WHERE intEmployeeId = '$varId'");
      //echo "<script type='text/javascript'>alert('Edit Succesful');</script>";
      //echo "<script type='text/javascript'>window.location.href = 'staff-tab.php';</script>";
      echo 1;
  }else{
    //echo "<script type='text/javascript'>alert('Incomplete data');</script>";
    //echo "<script type='text/javascript'>window.location.href = 'staff-tab.php';</script>";
    echo 2;
  }


?>
