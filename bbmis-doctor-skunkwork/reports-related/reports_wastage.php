<?php
include("../connections.php");
$requestData = $_REQUEST;
$columns = array('stfBloodType','stfBloodTypeRhesus',
		'count'
	 	);

	$query = "SELECT bt.intBloodTypeId,stfBloodType,stfBloodTypeRhesus,COUNT(intBloodBagId) AS count
 FROM tblbloodtype bt
 JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId";

	// datatable column index  => database column name

if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
	 $query .= "
 		WHERE stfIsBloodBagExpired ='Yes'AND stfTransfusionsuccess = 'No' AND (stfBloodType LIKE '%".$requestData['search']['value']."%' OR stfBloodTypeRhesus LIKE '%".$requestData['search']['value']."%')GROUP BY bt.intBloodTypeId
 		";
}

if(isset($_POST["order"]))
{
 $query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
 ';
}
else
{
 $query .= '  ORDER BY stfBloodType ASC ';
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
	$sub_array = array();

	$sub_array[] = '<div class="update" data-id="'.$row["intBloodTypeId"].'" 	data-column="strEmployeeFirstName">' . $row["stfBloodType"] . '</div>';

	$sub_array[] = '<div class="update" data-id="'.$row["intBloodTypeId"].'" 	data-column="strEmployeeMiddleName">' . $row["stfBloodTypeRhesus"] . '</div>';

  $sub_array[] = '<div class="update" data-id="'.$row["intBloodTypeId"].'" 	data-column="strEmployeeMiddleName">' . $row["count"] . '</div>';



	$data[] = $sub_array;
}


function get_all_data($connections)
{
 $query = "SELECT bt.intBloodTypeId,stfBloodType,stfBloodTypeRhesus,COUNT(intBloodBagId) AS count
FROM tblbloodtype bt
JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId
WHERE stfIsBloodBagExpired ='Yes'AND stfTransfusionsuccess = 'No'
GROUP BY bt.intBloodTypeId ";
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
