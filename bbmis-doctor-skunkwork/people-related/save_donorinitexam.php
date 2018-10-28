<?php
include("../connections.php");

parse_str($_POST["formdata"], $params);
$date = $params["date_init"];
//$newdate = date_format($date,"Y/m/d");


$count_components = mysqli_query($connections,"SELECT COUNT(intBloodComponentId) AS Number_of_Components,decMaleLeastVal,decMaleMaxVal,decFemaleLeastVal,decFemaleMaxVal  FROM tblbloodcomponent WHERE stfBloodComponentStatus = 'Active'");

while ($row = mysqli_fetch_assoc($count_components)){
  $NumberOfComponents = $row["Number_of_Components"];
  $maleleast = $row['decMaleLeastVal'];
  $malemax = $row['decMaleMaxVal'];
  $femaleleast = $row['decFemaleLeastVal'];
  $femalemax = $row['decFemaleMaxVal'];
}

if ($date){
    for($i=1; $i<=$NumberOfComponents; $i++){
      $id = $params['clientId_init'];
      settype($id,'int');
      $result= $params["BC_result"."$i"];
      //$remarks = $params["BC_remarks"."$i"];
      $screener = $params["BC_screener"."$i"];
      $verifier = $params["BC_verifier"."$i"];
      $option = $params["optradio"."$i"];

//fetchlatestdonation-----------------------------------------------------------------
      $donationidqry = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' AND stfDonationRemarks = 'Incomplete' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

      while($donation = mysqli_fetch_assoc($donationidqry)){
       $donation_id = $donation["intDonationId"];
      }
//-------------------------------------------------------------------------------------
//fetchDonorSex-----------------------------------------------------------------
      $fetchDonorSex = mysqli_query($connections,"SELECT stfClientSex FROM tblclient WHERE intClientId = '$id'");

      while($donor = mysqli_fetch_assoc($fetchDonorSex)){
       $sex = $donor["stfClientSex"];
      }
//-------------------------------------------------------------------------------------



           mysqli_query($connections, "INSERT INTO tblinitialscreening(intDonationId,intBloodComponentId,strBloodComponentResult,strBloodComponentRemarks,strBloodComponentScreener,strBloodComponentVerifier,dtmDateScreened,stfClientInitialScreeningRemarks)
           VALUES ('$donation_id','$i','$result', '$remarks', '$screener', '$verifier', '$date', '$option')");
          }
  $checkiffalse = mysqli_query($connections,"SELECT * FROM tblinitialscreening WHERE dtmDateScreened = '$date' AND stfClientInitialScreeningRemarks= 'Failed' AND intDonationId = '$donation_id'");

  if(mysqli_num_rows($checkiffalse) == 0){
    echo 1;//if walang nagfalse/fail dun sa 4 na bloodcomponent
    mysqli_query($connections,"UPDATE tbldonation SET stfDonationStatus = 'Able'  WHERE intDonationId = '$donation_id'");
  }
  else if(mysqli_num_rows($checkiffalse) >= 1){
    mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$donation_id'");
    echo 2;//if may nagfail miski isa dun sa 4 na component
  }
}
else{
  echo 3;//if di kumpleto yung input
}

 ?>
