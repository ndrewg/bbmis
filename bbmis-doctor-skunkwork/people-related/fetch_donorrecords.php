<?php
include("../connections.php");
$requestData = $_REQUEST;
$columns = array(
		'strClientFirstName', 'strClientMiddleName', 'strClientLastName'
	 	);

	$query = "SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName FROM tblclient  ";

  // $getlatestdonationIDquery = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

	// datatable column index  => database column name

if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
	 $query .= "
 		WHERE stfClientCanDonate = 'Yes' AND (strClientFirstName LIKE '%".$requestData['search']['value']."%' OR strClientMiddleName LIKE '%".$requestData['search']['value']."%' OR strClientLastName LIKE '%".$requestData['search']['value']."%')
 		";
}

if(isset($_POST["order"]))
{
 $query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
 ';
}
else
{
 $query .= ' ORDER BY strClientFirstName ASC ';
}

$query1 = '';
if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$filter_row = mysqli_query($connections, $query);
$number_filter_row = mysqli_num_rows($filter_row);

$result = mysqli_query($connections, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result)) {  // preparing an array
  // $query_donors = " SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0  ";
	$id = $row["intClientId"];
	$getlatestdonationIDquery = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

	if(mysqli_num_rows($getlatestdonationIDquery) > 0){
	while ($row2 = mysqli_fetch_assoc($getlatestdonationIDquery)) {
		$latestdonationID = $row2["intDonationId"];
	}

	$getdeferaldays = mysqli_query($connections,"SELECT MAX(`intDeferralDay`) AS Deferaldays
																								FROM tblbloodcomponent tbc JOIN tblinitialscreening tis ON tbc.intBloodComponentId = tis.intBloodComponentId
																								WHERE strBloodComponentRemarks = 'Failed'
																								AND intDonationId = '$latestdonationID'");
	if(mysqli_num_rows($getdeferaldays) > 0){//if may fail na blood comp
		while ($row3 = mysqli_fetch_assoc($getdeferaldays)) {
			$deferaldays = $row3["Deferaldays"];
		}

	}else{//if walang nag fail
			$deferaldays = 0;
	}

		settype($deferaldays,"int");

$check_ifhasrecordwithinninetydays = mysqli_query($connections,"SELECT c.intClientId
																							FROM tblclient c
																							JOIN tbldonation d ON c.intClientId = d.intClientId
																							JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
																							JOIN tblphysicalexam pe ON me.intDonationId = pe.intDonationId
																							JOIN tblinitialscreening ins ON pe.intDonationId = ins.intDonationId
																							JOIN tblserologicalscreening ss ON ins.intDonationId = ss.intDonationId
																							WHERE c.intClientId = '$id'
																							AND d.stfDonationRemarks = 'Complete'
																							AND d.intDonationId = (SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0)
																							AND d.intDonationId IN (SELECT me.intDonationId FROM tblmedicalexam me)
																							AND d.intDonationId IN (SELECT pe.intDonationId FROM tblphysicalexam pe)
																							AND d.intDonationId IN (SELECT ins.intDonationId FROM tblinitialscreening ins)
																							AND d.intDonationId IN (SELECT ss.intDonationId FROM tblserologicalscreening ss)
																							AND me.dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()
																							AND pe.dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()
																							AND ins.dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()
																							AND ss.dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()");

 $failed_survey = mysqli_query($connections,"SELECT *
FROM tblmedicalexam
WHERE intDonationId = '$latestdonationID'
AND (stfAnswerRemarks = 'Unchecked' OR stfAnswerRemarks = 'Expired')
AND dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()");

/*$expired_survey = mysqli_query($connections,"SELECT *
																				 	FROM `tblmedicalexam`
																				 	WHERE intDonationId = '$latestdonationID'
																				 	AND `stfAnswerRemarks` = 'Expired'
																				 	AND `dtmExamTaken` BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()");*/
$unchecked_survey = mysqli_query($connections,"SELECT *
																				 FROM `tblmedicalexam`
																				 WHERE intDonationId = '$latestdonationID'
																				 AND `stfAnswerRemarks` = 'Unchecked'
																				 AND `dtmExamTaken` BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()");

 $failed_BC = mysqli_query($connections,"SELECT *
																					FROM `tblinitialscreening`
																					WHERE dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL $deferaldays DAY) AND NOW()
																					AND intDonationId = '$latestdonationID'
																					AND strBloodComponentRemarks = 'Failed'");

 /*$failed_hemo = mysqli_query($connections,"SELECT *
																					FROM `tblinitialscreening`
																					WHERE intDonationId = '$latestdonationID'
																					AND intBloodComponentId = '3'
																					AND `stfClientInitialScreeningRemarks` = 'Failed'
																					AND dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()");*/

$check_ifseroremaining = mysqli_query($connections,"SELECT *
																								FROM tbldonation
																								WHERE stfDonationRemarks = 'Incomplete'
																								AND intDonationId IN (SELECT intDonationId FROM tblphysicalexam WHERE intDonationId = '$latestdonationID')
																								AND intDonationId IN (SELECT intDonationId FROM tblinitialscreening WHERE intDonationId = '$latestdonationID')
																								AND intDonationId NOT IN (SELECT intDonationId FROM tblserologicalscreening WHERE intDonationId = '$latestdonationID')
																								AND intClientId = '$id' ");

$check_ifnoinit = mysqli_query($connections,"SELECT *
																								FROM tbldonation
																								WHERE stfDonationRemarks = 'Incomplete'
																								AND intDonationId IN (SELECT intDonationId FROM tblphysicalexam WHERE intDonationId = '$latestdonationID')
																								AND intDonationId NOT IN(SELECT intDonationId FROM tblinitialscreening WHERE intDonationId = '$latestdonationID')
																									AND intClientId = '$id'");

$check_ifnophys = mysqli_query($connections,"SELECT *
																								FROM tbldonation
																								WHERE stfDonationRemarks = 'Incomplete'
																								AND intDonationId IN (SELECT intDonationId FROM tblmedicalexam WHERE intDonationId = '$latestdonationID')
																								AND intDonationId NOT IN (SELECT intDonationId FROM tblphysicalexam WHERE intDonationId = '$latestdonationID')
																									AND intClientId = '$id'");

$checkifpwedenaulit = mysqli_query($connections,"SELECT *
																									FROM tbldonation
																									WHERE stfDonationRemarks = 'Complete'
																									AND intDonationId = '$latestdonationID'");

																									$sub_array = array();

																									$sub_array[0] = '<div class="update" data-id="'.$row["intClientId"].'" 	data-column="strClientFirstName">' . $row["strClientFirstName"] . '</div>';

																								  $sub_array[1] = '<div class="update" data-id="'.$row["intClientId"].'" 	data-column="strClientMiddleName">' . $row["strClientMiddleName"] . '</div>';

																								  $sub_array[2] = '<div class="update" data-id="'.$row["intClientId"].'" 	data-column="strClientLastName">' . $row["strClientLastName"] . '</div>';


 																								if(mysqli_num_rows($check_ifhasrecordwithinninetydays) == 0){
																									  if(mysqli_num_rows($failed_BC) == 0 AND mysqli_num_rows($failed_survey) == 0){
																											if(mysqli_num_rows($unchecked_survey) == 0){
																									    //  if(mysqli_num_rows($failed_hemo) == 0){
																									            if(mysqli_num_rows($check_ifnophys) > 0){

																									$sub_array[3] =
																										'
                                                    <button type="button" class="btn btn-primary btnAddphysical" data-id="'.$row["intClientId"].'">Add Physical Screening</button>
																										<button type="button" class="btn ml-2" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'">Edit</button> <a class="btn btn-default btn-sm ml-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="donorrecords-tab-viewinfo.php?id='.$row["intClientId"].'">View</a>
																										';
																									}
																									else if(mysqli_num_rows($check_ifnoinit) > 0){
																										$sub_array[3] =
																											'
																											<button type="button" class="btn btn-primary btnAddinitial" data-id="'.$row["intClientId"].'">Add Initial Screening</button><button type="button" class="btn ml-2" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'">Edit</button> <a class="btn btn-default btn-sm ml-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="donorrecords-tab-viewinfo.php?id='.$row["intClientId"].'">View</a>

																											';
																									}
																									else if(mysqli_num_rows($check_ifseroremaining) > 0 ){

																										$sub_array[3] =
																											'
																											<button type="button" class="btn btn-primary btnAddserological" data-id="'.$row["intClientId"].'">Add Serological Screening</button><button type="button" class="btn ml-2" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'">Edit</button> <a class="btn btn-default btn-sm ml-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="donorrecords-tab-viewinfo.php?id='.$row["intClientId"].'">View</a>

																											';

																									}
																									else if (mysqli_num_rows($checkifpwedenaulit) > 0){
																										$sub_array[3] =
																										'
																										<a href = "fetchIntSheetQuestions-table.php?client_id='.$row["intClientId"].'"><button type="button" class="btn btn-primary btnAddrecord" data-id="'.$row["intClientId"].'">Add record</button></a>
																								    <button type="button" class="btn ml-2" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'">Edit</button>
																								    <a class="btn btn-default btn-sm ml-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="donorrecords-tab-viewinfo.php?id='.$row["intClientId"].'">View</a>

																										';
																										}
																 //------------------------------------------------------------------------------------------------------------------------------------------------------------
																						/*	}else {
																								$sub_array[3] =
																									'
																									<button type="button" class="btn ml-2" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'">Edit</button> <a class="btn btn-default ml-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="donorrecords-tab-viewinfo.php?id=$clientid">View</a>

																									';
																							}*/
																						}else{
																							$sub_array[3] =
																							'
																							<a href = "fetch_donorsurveyanswers.php?rowid='.$latestdonationID.'" ><button type="button" class="btn btn-primary btnchecksurvey"  name = "check_survey">Check Survey</button></a>
																							<button type="button" class="btn ml-2" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'">Edit</button> <a class="btn btn-default ml-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="donorrecords-tab-viewinfo.php?id='.$row["intClientId"].'">View</a>

																							';
																						}
																						}else{////--------------------------------------------
																							$sub_array[3] =
																								'
																								<button type = "button" class ="btn btn-success" disabled>Record Complete</button>
																								<button type="button" class="btn ml-2" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'">Edit</button> <a class="btn btn-default ml-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="donorrecords-tab-viewinfo.php?id='.$row["intClientId"].'">View</a>

																								';
																						}
																					}else {
																						$sub_array[3] =
																							'
																							<button type = "button" class ="btn btn-success" disabled>Record Complete</button>
																							<button type="button" class="btn ml-2" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'">Edit</button> <a class="btn btn-default ml-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="donorrecords-tab-viewinfo.php?id='.$row["intClientId"].'">View</a>

																							';
																					}

																									$data[] = $sub_array;

}
else{

	$sub_array = array();

	$sub_array[0] = '<div class="update" data-id="'.$row["intClientId"].'" 	data-column="strClientFirstName">' . $row["strClientFirstName"] . '</div>';

  $sub_array[1] = '<div class="update" data-id="'.$row["intClientId"].'" 	data-column="strClientMiddleName">' . $row["strClientMiddleName"] . '</div>';

  $sub_array[2] = '<div class="update" data-id="'.$row["intClientId"].'" 	data-column="strClientLastName">' . $row["strClientLastName"] . '</div>';



	$sub_array[3] =
		'
		<a href = "fetchIntSheetQuestions-table.php?client_id='.$row["intClientId"].'"><button type="button" class="btn btn-primary btnAddrecord" data-id="'.$row["intClientId"].'">Add record</button></a>
    <button type="button" class="btn ml-2" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'">Edit</button>
    <a class="btn btn-default btn-sm ml-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="donorrecords-tab-viewinfo.php?id='.$row["intClientId"].'">View</a>

		';

	$data[] = $sub_array;
}//end of else

}


function get_all_data($connections)
{
 $query = "SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName FROM tblclient WHERE stfClientCanDonate = 'Yes' ";
 $result = mysqli_query($connections, $query);
 return mysqli_num_rows($result);
}

$output = array(
 //"draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connections),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);  // send data as json format


 ?>
