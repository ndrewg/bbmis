<?php
include("../connections.php");

if ($_POST["clientid"]){
  $clientid = $_POST['clientid'];
  settype($clientid, "int");

$getlatestdonationIDquery = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$clientid' ORDER BY intDonationId DESC");

if(mysqli_num_rows($getlatestdonationIDquery) > 0){
while ($row2 = mysqli_fetch_assoc($getlatestdonationIDquery)) {
  $latestdonationID = $row2["intDonationId"];
}

  $viewrecord = mysqli_query($connections, " SELECT tbc.strBloodComponentName, ti.strBloodComponentResult,ti.stfClientInitialScreeningRemarks FROM tblinitialscreening ti JOIN tblbloodcomponent tbc ON tbc.intBloodComponentId = ti.intBloodComponentId WHERE intDonationId = '$latestdonationID' ");

  $output = "
  <table class='table table-bordered mt-5' style='width:100%'>
    <thead>
      <tr>
        <th>Blood Component</th>
        <th>Initial Screening Result</th>
        <th>Initial Screening Status</th>
      </tr>
    </thead>
  ";
  while( $row = mysqli_fetch_assoc($viewrecord)){
    $bloodcomponent = $row["strBloodComponentName"];
    $screeningresult = $row["strInitialScreeningResult"];
    $screeningstatus = $row["stfClientInitialScreeningStatus"];

    $output .=
    "
    <tbody>
      <tr>
        <td>$bloodcomponent</td>
        <td>$screeningresult</td>
        <td>$screeningstatus</td>
      </tr>
    </tbody>
    ";
  }
  $output .= "</table>";

echo $output;
}else {
  echo "No records to show";
}
 }

 ?>
