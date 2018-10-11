<?php
	$qryFetchDonations = mysqli_query($conn, "
		SELECT MAX(me.dtmExamTaken) AS 'Exam Taken', ss.dtmDateScreened AS 'Date Screened', bv.intBloodVolume AS 'Amount Bled', ss.strPhlebotomist AS 'Phlebotomist', 'Volunteer'
		FROM tbldonation d
		JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
		JOIN tblphysicalexam pe ON me.intDonationId = pe.intDonationId
		JOIN tblbloodvolume bv ON pe.intBloodVolumeId = bv.intBloodVolumeId
		JOIN tblserologicalscreening ss ON pe.intDonationId = ss.intDonationId
		WHERE d.intDonationId = (
			SELECT d1.intDonationId
			FROM tbldonation d1
			WHERE d.intClientId = $varDbId
			LIMIT 1
		)
		GROUP BY d.intDonationId
		ORDER BY 1 DESC
	");
	
	$varDonations = mysqli_num_rows($qryFetchDonations);
	
	if(!isset($varDonations))	{
		$varDonations = 0;
	}
	
	// echo $varDonations;
	
	if($varDonations > 0)	{
		while($rowDonations = mysqli_fetch_assoc($qryFetchDonations))	{
			$varExamTaken = date_create($rowDonations["Exam Taken"]);
			$varExamTaken = date_format($varExamTaken, "F d, Y");
			if(isset($varDateScreened))	{
				$varDateScreened = date_format(date_create($rowDonations["Date Screened"]), "F d, Y");
			}
			else	{
				$varDateScreened = 'Unscreened';
			}
			$varBloodVolume = $rowDonations["Amount Bled"];
			$varPhlebotomist = $rowDonations["Phlebotomist"];
			$varDonationType = $rowDonations["Volunteer"];
		}
		
		echo "
			<div class='row text-white' style='border-radius: 25px 25px 0px 0px; word-wrap: break-word'>
				<div class='col-2 text-center p-3 bg-danger' style='border-radius: 25px 0 0 0;'>Exam Taken</div>
				<div class='col-2 text-center p-3 bg-danger'>Date Screened</div>
				<div class='col-2 text-center p-3 bg-danger'>Amount Bled <span title='Cubic Centimeter'>(cc)</span></div>
				<div class='col-2 text-center p-3 bg-danger'>Phlebotomist</div>
				<div class='col-2 text-center p-3 bg-danger'>Donation Type</div>
				<div class='col-2 text-center p-3 bg-danger' style='border-radius: 0 25px 0 0;'>Remarks</div>
			</div>
		";
		
		for($x=0; $x<$varDonations; $x++)	{
			echo "
				<div class='row'>
					<div class='col-2 text-center p-2 border border-top-0'>$varExamTaken</div>
					<div class='col-2 text-center p-2 border border-top-0'>$varDateScreened</div>
					<div class='col-2 text-center p-2 border border-top-0'>$varBloodVolume</div>
					<div class='col-2 text-center p-2 border border-top-0'>$varPhlebotomist</div>
					<div class='col-2 text-center p-2 border border-top-0'>$varDonationType</div>
					<div class='col-2 text-center p-2 border border-top-0'>Incomplete</div>
				</div>
			";
		}
	}
	
	else	{
		echo "
			<span>No donation records. <a href='clientIntSheet.php' class='text-danger'>Donate now!</a></span>
		";
	}
?>