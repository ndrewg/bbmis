<?php
include("../connections.php");

if($_POST["clientid"]){
    $clientid = $_POST["clientid"];
    settype($clientid, "int");

    $getlatestdonationIDquery = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$clientid' ORDER BY intDonationId DESC");

    if(mysqli_num_rows($getlatestdonationIDquery) > 0){
    while ($row2 = mysqli_fetch_assoc($getlatestdonationIDquery)) {
      $latestdonationID = $row2["intDonationId"];
    }

    $viewrecord = mysqli_query($connections, " SELECT td.strDiseaseName, tss.strSerologicalScreeningRemarks FROM tblserologicalscreening tss JOIN tbldisease td ON td.intDiseaseId = tss.intDiseaseId
    WHERE intDonationId = '$latestdonationID'");

    $output =
    "
    <table class='table table-bordered mt-5 text-center' style='width:100%'>
      <thead>
        <tr>
          <th>Disease Name</th>
          <th>Results</th>
        </tr>
      </thead>

    ";
    while($row = mysqli_fetch_assoc($viewrecord)){
      $diseasename = $row["strDiseaseName"];
      $screeningremarks = $row["strSerologicalScreeningRemarks"];

      $output .=
      "
      <tbody>
        <tr>
          <td>$diseasename</td>
          <td>$screeningremarks</td>
        </tr>
      </tbody>
      ";
    }
    $output .= "</table>";
    echo $output;
}
}
else {
  echo "No Record to show";
}


 ?>
