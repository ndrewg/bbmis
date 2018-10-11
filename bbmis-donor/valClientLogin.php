<?php
	include "connection.php";
	parse_str($_POST["formdata"], $params);
	$varUn = $params["txtUn"];
	$varPw = $params["txtPw"];

	/* Validation */
	if($_SERVER["REQUEST_METHOD"] == "POST")	{
		if(empty($varUn) || empty($varPw))	{
			echo "<script type='text/javascript'>alert('Username and password required!')</script>";
			
		}
		else	{
			parse_str($_POST["formdata"], $params);
			$varUn = $params["txtUn"];
			$varPw = $params["txtPw"];
		}
	}

	/* Username and Password has value */
	if($varUn && $varPw)	{
		$qryCheckUser = mysqli_query($conn, "
		SELECT *
		FROM tbluser
		WHERE strUserName = '$varUn'");

		// Checks and returns rows of the username entered
		$qryCheckUserOcc = mysqli_num_rows($qryCheckUser);

		// If username has a record
		if($qryCheckUserOcc > 0)	{
			// If password matched to username's account
			while($row = mysqli_fetch_assoc($qryCheckUser))	{
				$varUserId = $row["intUserId"];
				$varUserPw = $row["strUserPassword"];

				if($varUserPw == $varPw)	{
					$qryJoinView1 = mysqli_query($conn, "
					SELECT c.stfClientType
					FROM tblclient c
					JOIN tbluser u ON c.intUserId = u.intUserId
					WHERE u.intUserId = '$varUserId'
					AND c.intUserId = '$varUserId'");
					
					while($row = mysqli_fetch_assoc($qryJoinView1))	{
						$varRole = $row["stfClientType"];
					}

					if($varRole == "Donor" || $varRole == "Applicant")	{
						session_start();
						$_SESSION["sessId"] = $varUserId;
						//Client type is equal to Donor or Applicant. Successful login. Session added.
						echo 1;
					}

					else	{
						//Client type is not Donor or Applicant.
						echo 2;
					}
				}

				else	{
					//Password does not match.
					echo 3;
				}
			}
		}
		else	{
			//The account is not yet registered.
			echo 4;
		}
	}
?>
