<?php
	include "connection.php";
	parse_str($_POST["formdata2"], $params2);

	$varFname = ucwords(strtolower(ltrim(rtrim($params2["txtFname"]))));
	$varMname = ucwords(strtolower(ltrim(rtrim($params2["txtMname"]))));
	$varLname = ucwords(strtolower(ltrim(rtrim($params2["txtLname"]))));
	$varContNo = ltrim(rtrim($params2["txtContNo"]));
	$varEmail = $params2["txtEmail"];
	$varSex = $params2["optSex"];
	$varCvlStat = $params2["optCvlStat"];
	$varBm = $params2["txtBm"];
	$varBd = $params2["txtBd"];
	$varBy = $params2["txtBy"];
	$varOcc = ucwords(strtolower(ltrim(rtrim($params2["txtOcc"]))));
	$varUn = strtolower(ltrim(rtrim($params2["txtUn"])));
	$varPw = $params2["txtPw"];


	if($varUn && $varPw)	{
		$qryCheckUser = mysqli_query($conn, "
			SELECT *
			FROM tbluser
			WHERE strUserName = '$varUn'
		");

		// Checks and returns rows of the username entered
		$qryCheckUserOcc = mysqli_num_rows($qryCheckUser);

		// If username has no matched in the records
		if($qryCheckUserOcc == 0)	{
			$qryAddUser = mysqli_query($conn, "
				INSERT INTO tbluser(strUserName, strUserPassword)
				VALUES('$varUn', '$varPw')
			");

			if($qryAddUser)	{
				//Fetch the recent UserId inserted.
				$qryCheckUserNew = mysqli_query($conn, "
					SELECT *
					FROM tbluser
					WHERE strUserName = '$varUn'
				");

				while($row = mysqli_fetch_assoc($qryCheckUserNew))	{
					$varDbId = $row["intUserId"];
				}
			}

			if($varFname && $varLname && $varContNo && $varSex && $varCvlStat && $varBm && $varBd && $varBy && $varOcc)	{
				$qryAddClient = mysqli_query($conn, "
				INSERT INTO tblclient(intUserId, strClientFirstName, strClientMiddleName, strClientLastName, strClientContact, stfClientSex, stfClientCivilStatus, datClientBirthday, strClientOccupation)
				VALUES('$varDbId', '$varFname', '$varMname', '$varLname', '$varContNo', '$varSex', '$varCvlStat', '$varBy/$varBm/$varBd', '$varOcc')");

				if($qryAddClient)	{
					// Success applicant signup.
					echo 1;
				}
			}
		}

		else	{
			// Account is already existing. Please signup again.
			echo 2;
		}
	}
?>
