<?php
include("../connections.php");

if(isset($_POST["bloodtype"])){
$blood_type = $_POST["bloodtype"];
}else{
$blood_type = "";
}

if(isset($_POST["storage"])){
$storage = $_POST["storage"];
}
else{
  $storage = "";
}

if(isset($_POST["volume"])){
$volume = $_POST["volume"];
}
else{
  $volume = "";
}

if(isset($_POST["preservative"])){
$preservative = $_POST["preservative"];
}
else{
  $preservative = "";
}

$requestData = $_REQUEST;
$columns = array('strBloodBagSerialNo','stfBloodType','stfBloodTypeRhesus','intBloodVolume','txtPreservative',
		'days'
	 	);

	$query = "SELECT bt.intBloodTypeId,stfBloodType,stfBloodTypeRhesus,intBloodVolume,strBloodBagSerialNo,strStorageName,txtPreservative,TIMESTAMPDIFF(day,dtmDateStored,NOW()) AS days
 FROM tblbloodtype bt
 JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId
 JOIN tblbloodvolume bv ON bb.intBloodVolumeId = bv.intBloodVolumeId
 JOIN tblstorage s ON bb.intStorageId = s.intStorageId
 JOIN tblpreservatives p ON bb.intPreservativeId = p.intPreservativeId";

	// datatable column index  => database column name

if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
	 $query .= "
 		 WHERE bt.intBloodTypeId = '$blood_type' AND s.intStorageId = '$storage'  AND bv.intBloodVolumeId = '$volume' AND p.intPreservativeId = '$preservative' AND (strBloodBagSerialNo LIKE '%".$requestData['search']['value']."%' OR stfBloodType LIKE '%".$requestData['search']['value']."%' OR intBloodVolume LIKE '%".$requestData['search']['value']."%' OR txtPreservative LIKE '%".$requestData['search']['value']."%')
 		";
}

if(isset($_POST["order"]))
{
 $query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
 ';
}
else
{
 $query .= '  ORDER BY strBloodBagSerialNo ASC ';
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

	$sub_array[] = '<div class="update" data-id="'.$row["intBloodTypeId"].'" 	data-column="strBloodBagSerialNo">' . $row["strBloodBagSerialNo"] . '</div>';

	$sub_array[] = '<div class="update" data-id="'.$row["intBloodTypeId"].'" 	data-column="stfBloodType">' . $row["stfBloodType"].' '.$row["stfBloodTypeRhesus"] . '</div>';

  $sub_array[] = '<div class="update" data-id="'.$row["intBloodTypeId"].'" 	data-column="intBloodVolume">' . $row["intBloodVolume"] . '</div>';

  $sub_array[] = '<div class="update" data-id="'.$row["intBloodTypeId"].'" 	data-column="strStorageName">' . $row["strStorageName"] . '</div>';

  $sub_array[] = '<div class="update" data-id="'.$row["intBloodTypeId"].'" 	data-column="txtPreservative">' . $row["txtPreservative"] . '</div>';

  $sub_array[] = '<div class="update" data-id="'.$row["intBloodTypeId"].'" 	data-column="days">' . $row["days"] . '</div>';



	$data[] = $sub_array;
}


function get_all_data($connections)
{
  if(isset($_POST["bloodtype"])){
  $blood_type = $_POST["bloodtype"];
}else{
  $blood_type = "";
}

  if(isset($_POST["storage"])){
  $storage = $_POST["storage"];
  }
  else{
    $storage = "";
  }

  if(isset($_POST["volume"])){
  $volume = $_POST["volume"];
  }
  else{
    $volume = "";
  }

  if(isset($_POST["preservative"])){
  $preservative = $_POST["preservative"];
  }
  else{
    $preservative = "";
  }

 $query = "SELECT bt.intBloodTypeId,stfBloodType,stfBloodTypeRhesus,intBloodVolume,strBloodBagSerialNo,strStorageName,txtPreservative,TIMESTAMPDIFF(day,dtmDateStored,NOW()) AS days
 FROM tblbloodtype bt
 JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId
 JOIN tblbloodvolume bv ON bb.intBloodVolumeId = bv.intBloodVolumeId
 JOIN tblstorage s ON bb.intStorageId = s.intStorageId
 JOIN tblpreservatives p ON bb.intPreservativeId = p.intPreservativeId
 WHERE bt.intBloodTypeId = '$blood_type' OR s.intStorageId = '$storage'  OR bv.intBloodVolumeId = '$volume' OR p.intPreservativeId = '$preservative'";
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
