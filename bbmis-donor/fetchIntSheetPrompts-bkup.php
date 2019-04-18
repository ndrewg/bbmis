
	$qryCliSex = mysqli_query($conn, "
		SELECT stfClientSex
		FROM tblclient
		WHERE intClientId = $varDbId
	");
	$rowCliSex = mysqli_fetch_assoc($qryCliSex);
	$varCliSex = $rowCliSex["stfClientSex"];
	
	//Checks if the client has existing donation.
	$qryDonationCheck = mysqli_query($conn, "
		SELECT *
		FROM tbldonation
		WHERE intClientId = $varDbId
		ORDER BY intDonationId DESC
		LIMIT 1
	");
	
	while($rowDonationCheck = mysqli_fetch_assoc($qryDonationCheck))	{
		$varDonationId = $rowDonationCheck["intDonationId"];
		$varDonationStatus = $rowDonationCheck["stfDonationStatus"];
		$varDonationRem = $rowDonationCheck["stfDonationRemarks"];
	}
	
	if(isset($varDonationId))	{
		if($varDonationRem == 'Incomplete')	{
			//Checks the recent donation. Provides the date when the exam checked, date when 
			$qryRecentDonation = mysqli_query($conn, "
				SELECT DISTINCT(me.intDonationId), me.dtmExamChecked AS 'Date Checked', DATE_ADD(me.dtmExamChecked, INTERVAL 7 DAY) AS 'Date Available', NOW() AS 'Date Now'
				FROM tblclient c
				JOIN tbldonation d ON c.intClientId = d.intClientId
				JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
				WHERE c.intClientId = $varDbId
				AND me.intDonationId = (
					SELECT me1.intDonationId
					FROM tblmedicalexam me1
					WHERE c.intClientId = $varDbId
					ORDER BY me1.intDonationId DESC
					LIMIT 1
				)
			");
			
			while($rowRecentDonation = mysqli_fetch_assoc($qryRecentDonation))	{
				$varDonId = $rowRecentDonation["intDonationId"];
				$varDateChecked = $rowRecentDonation["Date Checked"];
				//$varDateAvailable = $rowRecentDonation["Date Available"];
				// $varDateNow = $rowRecentDonation["Date Now"];
			}
			
			if(isset($varDateChecked))	{
				if($varDateChecked == '0000-00-00 00:00:00')	{
					ntfUnchk();
				}
				
				else	{
					$qryAnswerRemarks = mysqli_query($conn, "
						SELECT DISTINCT(me.stfAnswerRemarks), COUNT(me.stfAnswerRemarks) AS 'Remarks Count'
						FROM tblclient c
						JOIN tbldonation d ON c.intClientId = d.intClientId
						JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
						WHERE c.intClientId = $varDbId
						AND me.intDonationId = (
								SELECT me1.intDonationId
								FROM tblmedicalexam me1
								WHERE c.intClientId = $varDbId
								ORDER BY me1.intDonationId DESC
								LIMIT 1 OFFSET 0
							)
						GROUP BY me.stfAnswerRemarks
					");
					
					$varAnswerRemarks = array();
					// $varCountAnswerRemarks = array();
					
					while($rowAnswerRemarks = mysqli_fetch_assoc($qryAnswerRemarks))	{
						$varAnswerRemarks[] = $rowAnswerRemarks["stfAnswerRemarks"];
						// $varCountAnswerRemarks[$varCount] = $rowAnswerRemarks["Remarks Count"];
						// $varCount++;
					}
					
					$varCountRows = mysqli_num_rows($qryAnswerRemarks);
					
					if($varCountRows > 1)	{
						//If there is a 'Wrong' remarks in all valid remarks of the exam.
						if(in_array('Wrong', $varAnswerRemarks))	{
							ntfFldME();
						}
						else	{
							//Error if there are foreign remark except the valid remarks.
							if($varCliSex == 'Male')	{
								ntfUnchk();
							}
							else if($varCliSex == 'Female')	{
								ntfErr();
							}
						}
					}
					
					else if($varCountRows == 1)	{
						if(in_array('Correct', $varAnswerRemarks))	{
							ntfSuc();
						}
						else if(in_array('Wrong', $varAnswerRemarks))	{
							ntfFldME();
						}
						else if(in_array('Unchecked', $varAnswerRemarks))	{
							ntfUnchk();
						}
						else if(in_array('Expired', $varAnswerRemarks))	{
							ntfAgnAvl();
						}
					}
				}
			}
		}

		else if($varDonationRem == 'Complete')	{
			if($varDonationStatus == 'Unable')	{
				$qryAnswerRemarks = mysqli_query($conn, "
					SELECT DISTINCT(me.stfAnswerRemarks), COUNT(me.stfAnswerRemarks) AS 'Remarks Count'
					FROM tblclient c
					JOIN tbldonation d ON c.intClientId = d.intClientId
					JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
					WHERE c.intClientId = $varDbId
					AND me.intDonationId = (
							SELECT me1.intDonationId
							FROM tblmedicalexam me1
							WHERE c.intClientId = $varDbId
							ORDER BY me1.intDonationId DESC
							LIMIT 1 OFFSET 0
						)
					GROUP BY me.stfAnswerRemarks
				");
				
				$varAnswerRemarks = array();
				// $varCountAnswerRemarks = array();
				
				while($rowAnswerRemarks = mysqli_fetch_assoc($qryAnswerRemarks))	{
					$varAnswerRemarks[] = $rowAnswerRemarks["stfAnswerRemarks"];
					// $varCountAnswerRemarks[$varCount] = $rowAnswerRemarks["Remarks Count"];
					// $varCount++;
				}
				
				if(in_array('Wrong', $varAnswerRemarks))	{
					ntfFldME();
				}
				
				else	{
					$qryPeIsRemarks = mysqli_query($conn, "
						SELECT DISTINCT(pe.stfClientPhysicalExamRemarks) AS 'PE', ins.stfClientInitialScreeningRemarks AS 'IS'
						FROM tbldonation d
						JOIN tblphysicalexam pe ON d.intDonationId = pe.intDonationId
						JOIN tblinitialscreening ins ON pe.intDonationId = ins.intDonationId
						WHERE d.intDonationId = (
							SELECT d1.intDonationId
							FROM tbldonation d1
							WHERE d1.intClientId = $varDbId
							ORDER BY 1 DESC
							LIMIT 1
						)
					");
					
					while($rowScreenRem = mysqli_fetch_assoc($qryPeIsRemarks))	{
						$varPhysRem = $rowScreenRem["PE"];
						$varInitRem = $rowScreenRem["IS"];
					}
					
					if(isset($varPhysRem))	{
						if($varPhysRem == 'Failed')	{
							ntfFldPE();
						}
						else if($varInitRem == 'Failed')	{
							$qryIsDefDays = mysqli_query($conn, "
								SELECT MAX(bc.intDeferralDay) AS 'Highest Deferral Day'
								FROM tblinitialscreening ins
								JOIN tblbloodcomponent bc ON ins.intBloodComponentId = bc.intBloodComponentId
								WHERE ins.intDonationId = (
									SELECT d1.intDonationId
									FROM tbldonation d1
									WHERE d1.intClientId = $varDbId
									ORDER BY 1 DESC
									LIMIT 1
								)
								AND ins.strBloodComponentRemarks = 'Failed'
							");
							while($rowDefDays = mysqli_fetch_assoc($qryIsDefDays))	{
								$varDefDays = $rowDefDays["Highest Deferral Day"];
							}
							
							$qryIsDefRange = mysqli_query($conn, "
								SELECT dtmDateScreened, DATE_ADD(dtmDateScreened, INTERVAL $varDefDays DAY) AS 'Date Available', NOW() AS 'Date Now'
								FROM tblinitialscreening ins
								JOIN tblbloodcomponent bc ON ins.intBloodComponentId = bc.intBloodComponentId
								WHERE ins.intDonationId = (
									SELECT d1.intDonationId
									FROM tbldonation d1
									WHERE d1.intClientId = $varDbId
									ORDER BY 1 DESC
									LIMIT 1
								)
								AND ins.strBloodComponentRemarks = 'Failed'
							");
							
							while($rowDefRange = mysqli_fetch_assoc($qryIsDefRange))	{
								$varDateScreened = $rowDefDays["dtmDateScreened"];
								$varDefDateAvl = $rowDefRange["Date Available"];
								$varDateNow = $rowDefRange["Date Now"];
							}
							
							echo date_format(date_create($varDefDateAvl), 'F d, Y H:iA');
							echo date_format(date_create($varDateNow), 'F d, Y H:iA');
							
							if($varDateNow < $varDefDateAvl)	{
								ntfFldIS($varDefDays, date_format(date_create($varDateScreened), 'F d, Y H:iA'), date_format(date_create($varDonDateAvl), 'F d, Y H:iA'));
							}
							else	{
								ntfAgn();
								// echo 'engk';
							}
						}
					}
					else {
						ntfAgn();
						echo 'engk';
					}
				}
			}
			else if($varDonationStatus == 'Able')	{
				$qrySsRemarks = mysqli_query($conn, "
					SELECT DISTINCT(ss.stfDonorSerologicalScreeningRemarks) AS 'SS'
					FROM tbldonation d
					JOIN tblphysicalexam pe ON d.intDonationId = pe.intDonationId
					JOIN tblinitialscreening ins ON pe.intDonationId = ins.intDonationId
					JOIN tblserologicalscreening ss ON ins.intDonationId = ss.intDonationId
					WHERE d.intDonationId = (
						SELECT d1.intDonationId
						FROM tbldonation d1
						WHERE d1.intClientId = $varDbId
						ORDER BY 1 DESC
						LIMIT 1
					)
				");
				
				$varSeroRem = array();
				$varCount = 0;
				
				while($rowScreenRem = mysqli_fetch_assoc($qrySsRemarks))	{
					$varSeroRem[$varCount] = $rowScreenRem["SS"];
					$varCount++;
				}
				
				$varCountRows = mysqli_num_rows($qrySsRemarks);
					
				if($varCountRows > 1)	{
					if(in_array('Failed', $varSeroRem))	{
						ntfFldSS();
					}
				}
				
				else if($varCountRows == 1)	{
					if(in_array('Passed', $varSeroRem))	{
						$qryDonComplete = mysqli_query($conn, "
							SELECT ss.dtmDateScreened, DATE_ADD(ss.dtmDateScreened, INTERVAL 90 DAY) AS 'Date Available', NOW() AS 'Date Now'
							FROM tblserologicalscreening ss
							JOIN tbldisease di ON ss.intDiseaseId = di.intDiseaseId
							WHERE ss.intDonationId = (
								SELECT d1.intDonationId
								FROM tbldonation d1
								WHERE d1.intClientId = $varDbId
								ORDER BY 1 DESC
								LIMIT 1
							)
						");
						
						while($rowDonComplete = mysqli_fetch_assoc($qryDonComplete))	{
							$varDateBled = $rowDonComplete["dtmDateScreened"];
							$varDonDateAvl = $rowDonComplete["Date Available"];
							$varDateNow = $rowDonComplete["Date Now"];
						}
						
						// echo date_format(date_create($varDonDateAvl), 'F d, Y H:iA');
						// echo date_format(date_create($varDateNow), 'F d, Y H:iA');
						
						
						if($varDateNow < $varDonDateAvl)	{
							ntfSucDon(date_format(date_create($varDateBled), 'F d, Y H:iA'), date_format(date_create($varDonDateAvl), 'F d, Y H:iA'));
						}
						else	{
							ntfAgn();
						}
					}
					else if(in_array('Failed', $varSeroRem))	{
						ntfFldSS();
					}
				}
			}
		}
	}
	else	{
		//First donation made by the client.
		ntfFrst();
	}