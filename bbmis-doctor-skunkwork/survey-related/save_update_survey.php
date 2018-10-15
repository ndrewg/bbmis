<?php
include("../connections.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$client_ID = $params["hiddenclientid"];
$examcode = $params["hiddenexamcode"];

$getclientsex = mysqli_query($connections,"SELECT * FROM tblclient WHERE intClientId = '$client_ID'");
while ($row = mysqli_fetch_assoc($getclientsex)) {
  $sex = $row['stfClientSex'];
}

$countfemalexclusive = mysqli_query($connections,"SELECT COUNT(intQuestionId) AS Number_of_Questions FROM tblquestion WHERE boolVersionInUse = '1' AND intQuestionCategoryId = '3'");
while($row = mysqli_fetch_assoc($countfemalexclusive)){
  $countofFE = $row['Number_of_Questions'];
}

$check_version = mysqli_query($connections,"SELECT COUNT(intQuestionId) AS Number_of_Questions, decQuestionVersion FROM tblquestion WHERE boolVersionInUse = '1' ");
while ($row = mysqli_fetch_assoc($check_version)){
  $NumberOfQuestions = $row["Number_of_Questions"];
  $inusedsurvey = $row["decQuestionVersion"];
}
$check_first_number = mysqli_query($connections,"SELECT intQuestionId FROM tblquestion WHERE decQuestionVersion = '$inusedsurvey' ORDER BY intQuestionId ASC LIMIT 1");

$donationidqry = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$client_ID' AND stfDonationRemarks = 'Incomplete' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

while($donation = mysqli_fetch_assoc($donationidqry)){
 $donation_id = $donation["intDonationId"];
}
  while ($row2 = mysqli_fetch_assoc($check_first_number)) {
    $first_number = $row2["intQuestionId"];
  }

settype($first_number,"int");
settype($NumberOfQuestions,"int");
settype($countofFE,"int");
$NumberOfQuestionsminusone = $NumberOfQuestions - 1;
$countofFEminusone = $countofFE - 1;
$NumberOfQuestionminusFE = $NumberOfQuestions - ($countofFE + 1 );
if($sex == 'Female'){

  for($i = $first_number; $i <= $first_number + $NumberOfQuestionsminusone; $i++)
  {

      $new_status = $params["updatestatus"."$i"];

				$update_answer = mysqli_query($connections,"UPDATE tblmedicalexam
                                                        SET stfAnswerRemarks = '$new_status' , dtmExamChecked = NOW()
                                                        WHERE
                                                       intDonationId = '$examcode'
                                                        AND intQuestionId = '$i'
                                                        ");

        if($new_status == 'Wrong'){
          	mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$donation_id'");
        }
echo $new_status;
  }
}else if($sex == 'Male'){
  for($i = $first_number; $i <= $first_number + $NumberOfQuestionminusFE; $i++)
  {

      $new_status = $params["updatestatus"."$i"];

				$update_answer = mysqli_query($connections,"UPDATE tblmedicalexam
                                                        SET stfAnswerRemarks = '$new_status' , dtmExamChecked = NOW()
                                                        WHERE
                                                       intDonationId = '$examcode'
                                                        AND intQuestionId = '$i'
                                                        ");

        if($new_status == 'Wrong'){
          	mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$donation_id'");
        }

}

}
?>
