<?php
		include("connections.php");
	//parse_str($_POST["formdata"], $params);
	$varUn = $_REQUEST["txtUn"];
	$varPw = $_REQUEST["txtPw"];
	$varFname = $_REQUEST["txtFname"];
	$varMname = $_REQUEST["txtMname"];
	$varLname = $_REQUEST["txtLname"];
	$varContNo = $_REQUEST["txtContNo"];
	$varSex = $_REQUEST["optSex"];
	$varCvlStat = $_REQUEST["optCvlStat"];
	$varBm = $_REQUEST["txtBm"];
	$varBd = $_REQUEST["txtBd"];
	$varBy = $_REQUEST["txtBy"];
	$varOcc = $_REQUEST["txtOcc"];


	if($_SERVER["REQUEST_METHOD"] == "POST")	{
		//Parang walang kwenta tong codes, required na sya nung sa form pa lang.
		if(empty($varUn) || empty($varPw))	{
			echo "<script type='text/javascript'>alert('Fields are required!')</script>";
			echo "<script type='text/javascript'>window.location.href = 'home.php'</script>";
		}

		else	{
			//parse_str($_POST["formdata"], $params);
			$varFname = ucwords(strtolower(ltrim(rtrim($_REQUEST["txtFname"]))));
			$varMname = ucwords(strtolower(ltrim(rtrim($_REQUEST["txtMname"]))));
			$varLname = ucwords(strtolower(ltrim(rtrim($_REQUEST["txtLname"]))));
			$varContNo = ltrim(rtrim($_REQUEST["txtContNo"]));
			$varSex = $_REQUEST["optSex"];
			$varCvlStat = $_REQUEST["optCvlStat"];
			$varBm = $_REQUEST["txtBm"];
			$varBd = $_REQUEST["txtBd"];
			$varBy = $_REQUEST["txtBy"];
			$varOcc = ucwords(strtolower(ltrim(rtrim($_REQUEST["txtOcc"]))));
			$varUn = strtolower(ltrim(rtrim($_REQUEST["txtUn"])));
			$varPw = $_REQUEST["txtPw"];
		}
	}

	$file = $_FILES ['fileimg'];
	$fileName = $_FILES['fileimg']['name'];/*kukunin yung file name*/
	$fileTmpName = $_FILES['fileimg']['tmp_name'];/*kukunin yung temporary destination na pinupuntahan ng file bago i upload*/
	$fileSize = $_FILES['fileimg']['size'];/*kukunin file size*/
	$fileError = $_FILES['fileimg']['error'];/*integer to pag 0 ibig sabihin succesful parang ganun*/
	$fileType = $_FILES['fileimg']['type'];/*kukunin file type*/

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg','jpeg','png');
	if (in_array($fileActualExt, $allowed)) { /*ichicheck kung allowed ba yung file type */
		if($fileError === 0){
			if($fileSize < 1000000){
				$fileNameNew = uniqid('', true).".".$fileActualExt;/*gagawin niyang integer na unique*/

				$fileDestination = 'images/profileImg/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);/*yung unang paramter kung saan galing which is yung temporary location, yung second parameter kung saan ililipat*/
				//header("Location:donor-tab.php");

			}
			else{
				echo "<script type='text/javascript'>alert('Your file is too big!');</script>";
			}

		}
		else{
			echo "<script type='text/javascript'>alert('there was an error uploading the file!');</script>";
		}
	}
	else{
		echo "<script type='text/javascript'>alert('You cannot upload files of this type!');</script>";
	}

	if($varUn && $varPw)	{
		$qryCheckUser = mysqli_query($connections, "
		SELECT *
		FROM tbluser
		WHERE strUserName = '$varUn'");

		// Checks and returns rows of the username entered
		$qryCheckUserOcc = mysqli_num_rows($qryCheckUser);

		// If username has no matched in the records
		if($qryCheckUserOcc <= 0)	{
			$qryAddUser = mysqli_query($connections, "
			INSERT INTO tbluser(strUserName, strUserPassword, strUserImageDir)
			VALUES('$varUn', '$varPw','$fileNameNew')");

			if($qryAddUser)	{
				$qryCheckUserNew = mysqli_query($connections, "
				SELECT *
				FROM tbluser
				WHERE strUserName = '$varUn'");
				while($row = mysqli_fetch_assoc($qryCheckUserNew))	{
					$varDbId = $row["intUserId"];
					// echo "<script type='text/javascript'>alert('$varDbId')</script>";
					// echo "<script type='text/javascript'>alert('$row')</script>";
				}
			}
			else	{
				//echo "1";
				echo "<script type='text/javascript'>alert('Haha di pasok')</script>";
			}

			if($varFname && $varLname && $varContNo && $varSex && $varCvlStat && $varBm && $varBd && $varBy && $varOcc)	{
				if($varDbId == 0)	{
					//echo "2";
					echo "<script type='text/javascript'>alert('Yowza.')</script>";
				}
				else	{
					$qryAddClient = mysqli_query($connections, "
					INSERT INTO tblclient(intUserId, strClientFirstName, strClientMiddleName, strClientLastName, strClientContact, stfClientSex, stfClientCivilStatus, datClientBirthday, strClientOccupation)
					VALUES('$varDbId', '$varFname', '$varMname', '$varLname', '$varContNo', '$varSex', '$varCvlStat', '$varBy/$varBm/$varBd', '$varOcc')");

					if($qryAddClient)	{
						//echo "3";
						echo "<script type='text/javascript'>alert('Donor registered successfully!.')</script>";
					 echo "<script type='text/javascript'>window.location.href = 'donor-tab.php'</script>";
					}
				}
			}
		}

		else	{
			//echo "4";
			echo "<script type='text/javascript'>alert('Account has already registered. Please try again.');</script>";
			echo "<script type='text/javascript'>window.location.href = 'donor-tab.php'</script>";
		}
	}
?>
