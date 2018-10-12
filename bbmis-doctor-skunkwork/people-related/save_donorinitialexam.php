<?php
include("../connections.php");
include("../checkSession.php");
parse_str(mysqli_real_escape_string($connections, $_POST["formdata"]), $params);
$date = $params["date_init"];
//$newdate = date_format($date,"Y/m/d");
$datenow = date('Y-m-d H:i:s');
$date_1 = new DateTime($date);
$datenow_1 = new DateTime($datenow);


$count_components = mysqli_query($connections,"SELECT COUNT(intBloodComponentId) AS Number_of_Components  FROM tblbloodcomponent WHERE stfBloodComponentStatus = 'Active'");

while ($row = mysqli_fetch_assoc($count_components)){
  $NumberOfComponents = $row["Number_of_Components"];
}
if($date_1 <= $datenow_1){
if ($date){
    for($i=1; $i<=$NumberOfComponents; $i++){
      $id = $params['clientId_init'];
      settype($id,'int');
      $result= $params["BC_result"."$i"];
      $remarks = $params["BC_remarks"."$i"];
      $screener = $params["BC_screener"."$i"];
      $verifier = $params["BC_verifier"."$i"];
    //  $option = $params["optradio"."$i"];

      $donationidqry = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' AND stfDonationRemarks = 'Incomplete' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

      while($donation = mysqli_fetch_assoc($donationidqry)){
       $donation_id = $donation["intDonationId"];
      }

    //$curdate = date("Y/m/d");
           mysqli_query($connections, "INSERT INTO tblinitialscreening(intDonationId,intBloodComponentId,strBloodComponentResult,strBloodComponentRemarks,strBloodComponentScreener,strIBloodComponentVerifier,dtmDateScreened)
           VALUES ('$donation_id','$i','$result', '$remarks', '$screener', '$verifier', '$date')");
          }
  $checkiffalse = mysqli_query($connections,"SELECT * FROM tblinitialscreening WHERE dtmDateScreened = '$date' AND strBloodComponentRemarks= 'Failed' AND intDonationId = '$donation_id'");

  if(mysqli_num_rows($checkiffalse) == 0){
  //  echo 1;//if walang nagfalse/fail dun sa 4 na bloodcomponent
    mysqli_query($connections,"UPDATE tblinitialscreening SET stfClientInitialScreeningRemarks = 'Passed' WHERE intDonationId = '$donation_id' AND dtmDateScreened = '$date' ");
    mysqli_query($connections,"UPDATE tbldonation SET stfDonationStatus = 'Able'  WHERE intDonationId = '$donation_id'");
    mysqli_query($connections,"UPDATE tblclient SET stfClientType = 'Donor'  WHERE intClientId = '$id'");
        $is_saved = mysqli_query($connections,"SELECT * FROM tblinitialscreening WHERE intDonationId = '$donation_id'");

        if(mysqli_num_rows($is_saved) > 0){//ICHECK KUNG NASAVE TALAGA
        echo '1';
      } elseif (mysqli_num_rows($is_saved) == 0) {
        echo '3';
      }

  }
  else if(mysqli_num_rows($checkiffalse) >= 1){
    mysqli_query($connections,"UPDATE tblinitialscreening SET stfClientInitialScreeningRemarks = 'Failed' WHERE intDonationId = '$donation_id' AND dtmDateScreened = '$date' ");
    mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$donation_id'");

        $is_saved = mysqli_query($connections,"SELECT * FROM tblinitialscreening WHERE intDonationId = '$donation_id'");

        if(mysqli_num_rows($is_saved) > 0){//ICHECK KUNG NASAVE TALAGA
          echo '2';//if may nagfail miski isa dun sa 4 na component
      } elseif (mysqli_num_rows($is_saved) == 0) {
        echo '3';
      }

  }
}
else{
  echo '3';//if di kumpleto yung input
}
}else{
  echo '4';
}

 ?>
