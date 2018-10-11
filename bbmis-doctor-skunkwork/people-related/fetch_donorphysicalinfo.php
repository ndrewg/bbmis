<?php
include("../connections.php");

if ($_POST["clientid"]){
  $clientid = $_POST['clientid'];
  settype($clientid, "int");


          $getlatestdonationIDquery = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$clientid' ORDER BY intDonationId DESC LIMIT 2 OFFSET 0");

          if(mysqli_num_rows($getlatestdonationIDquery) > 0){
          while ($row2 = mysqli_fetch_assoc($getlatestdonationIDquery)) {
            $latestdonationID = $row2["intDonationId"];
          }

          $output =
          "
          <table class='table table-bordered mt-5' style='width:100%'>
            <thead>
              <tr>
                <th width = 5%>Weight</th>
                <th width = 5%>Blood Pressure</th>
                <th width = 5%>Pulse Rate</th>
                <th width = 5%>Temperature</th>
                <th width = 20%>General Appearance</th>
                <th width = 20%>HEENT</th>
                <th width = 20%>HeartNLungs</th>
              </tr>
            </thead>
            <tbody>";

  $viewrecord = mysqli_query($connections, " SELECT * FROM tblphysicalexam WHERE intDonationId = $latestdonationID ");

  while($row = mysqli_fetch_assoc($viewrecord)){
  $weigth = $row['decClientWeight'];
  $bloodpressure = $row['strClientBloodPressure'];
  $pulserate = $row['strClientPulseRate'];
  $temperature = $row['decClientTemperature'];
  $genapp = $row['txtClientGenAppearance'];
  $heent = $row['txtClientHEENT'];
  $heartnlungs = $row['txtClientHeartLungs'];

  $output .=
  "

      <tr>
        <td>$weigth</td>
        <td>$bloodpressure</td>
        <td>$pulserate</td>
        <td>$temperature</td>
        <td>$genapp</td>
        <td>$heent</td>
        <td>$heartnlungs</td>
      </tr>

  ";
}
$output .="
</tbody>
</table>";
  echo $output;
}
else{
  echo "No available records";
}
}

 ?>
