<?php
include("../connections.php");
$clientid = $_POST['clientid'];
$requestData = $_REQUEST;
$columns = array('d.intDonationId',
		'm.dtmExamTaken','d.stfDonationRemarks'
	 	);

	$query = "SELECT DISTINCT(d.intDonationId), m.dtmExamTaken, d.stfDonationRemarks
 FROM tbldonation d
 JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
";

	// datatable column index  => database column name

if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
	 $query .= "
 		 WHERE d.intClientId = '$clientid' AND (d.intDonationId LIKE '%".$requestData['search']['value']."%') GROUP BY d.intDonationId  
 		";
}

if(isset($_POST["order"]))
{
	$query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
  ';
}
else
{

 	$query .= ' ORDER BY d.intDonationId ASC ';
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
//  }

	$sub_array = array();

	$sub_array[] = '<div class="update" data-id="'.$row["intDonationId"].'" 	data-column="intDonationId">' . $row["intDonationId"] . '</div>';

	$sub_array[] = '<div class="update" data-id="'.$row["intDonationId"].'" 	data-column="dtmExamTaken">' . $row["dtmExamTaken"] . '</div>';


	 $sub_array[] =
	 	'
	<a class="btn btn-default btn-sm ml-2 btn_viewrec" data-id="'.$row["intDonationId"].'" href="donordonation_view.php?id='.$row["intDonationId"].'&stat='.$row["stfDonationRemarks"].'">View</a>
	 	'; //<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

	$data[] = $sub_array;
}


function get_all_data($connections)
{
	$clientid = $_POST['clientid'];
 $query = "SELECT DISTINCT(d.intDonationId), m.dtmExamTaken, d.stfDonationRemarks
FROM tbldonation d
JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
	WHERE d.intClientId = '$clientid'
	GROUP BY d.intDonationId
";
 $result = mysqli_query($connections, $query);
 return mysqli_num_rows($result);
}

$output = array(
 //"draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connections),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data,
 "query" => $query
);

echo json_encode($output);  // send data as json format


 ?>
