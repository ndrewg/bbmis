<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bs4/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/fontawesome-all.css">
  <link rel="stylesheet" href="css/jquery-confirm.min.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/waves.min.css">
</head>
<body>
  <div class="container-fluid">


<?php
include("connections.php");
$id = $_GET["id"];
$stat = $_GET["stat"];
/*$getlatestdonationIDquery = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

if(mysqli_num_rows($getlatestdonationIDquery) > 0){
while ($row2 = mysqli_fetch_assoc($getlatestdonationIDquery)) {
  $latestdonationID = $row2["intDonationId"];
}
}*/
 ?>
 <div class="content-container" >
   <div class="col-md-5">
     <div class="form-group">
       <label for="donorweight">Completion :</label>
       <input type="text" class="form-control" value = "The record is <?php echo $stat?>" readonly>
     </div>
   </div>
 </div>
<!--Medical Exam-->
<div class="content-container"style="margin-top: -20px">
 <?php
$medicalexamQry = mysqli_query($connections,"SELECT * FROM tblmedicalexam WHERE intDonationId = '$id'");
if(mysqli_num_rows($medicalexamQry) > 0){
  ?>
  <h3>Donor Medical Exam</h3>
  <table class='table table-bordered mt-5 text-center' id='tbldonorsurvey'>
    <thead>
      <tr>
        <th>Question</th>
        <th>Answer: Yes or No</th>
        <th>Answer: Date</th>
        <th>Answer: Quantity</th>
        <th>Answer: String</th>
        <th>Remarks</th>
      </tr>
    </thead>
  <?php
  while($medical = mysqli_fetch_assoc($medicalexamQry)){
    $questionId = $medical["intQuestionId"];
    $answerYN = $medical["stfAnswerYn"];
    $answerDate = $medical["datAnswerDate"];
    $answerQuan = $medical["intAnswerQuantity"];
    $answerstr = $medical["strAnswerString"];
    $remarks = $medical["stfAnswerRemarks"];

    $questionQry = mysqli_query($connections,"SELECT txtquestion FROM tblquestion WHERE intQuestionId = '$questionId'");
    while ($question = mysqli_fetch_assoc($questionQry)) {
      $txtquestion = $question["txtquestion"];
    }
    ?>
    <tr>
      <td><?php echo $txtquestion; ?></td>
      <td><?php echo $answerYN; ?></td>
      <td><?php echo $answerDate; ?></td>
      <td><?php echo $answerQuan; ?></td>
      <td><?php echo $answerstr; ?></td>
      <td><?php echo $remarks; ?></td>
    </tr>
 <?php
  }
   ?>
     </table>
     <br/>
     <br/>
     <br/>
   <?php
 }else{
   ?>
   <p>No Medical Exam record</p>
   <?php
 }
    ?>

</div>
 <!--Medical Exam-->

 <!--Physical Exam-->
 <div class="content-container"style="margin-top: -20px">
 <?php
$physicalexamQry = mysqli_query($connections,"SELECT * FROM tblphysicalexam WHERE intDonationId = '$id'");
if(mysqli_num_rows($physicalexamQry) > 0){
  ?>
  <h3>Donor Physical Exam</h3>

  <?php
  while($physical = mysqli_fetch_assoc($physicalexamQry)){
    $weight = $physical["decClientWeight"];
    $bp = $physical["strClientBloodPressure"];
    $pulserate = $physical["strClientPulseRate"];
    $temp = $physical["decClientTemperature"];
    $genapp = $physical["txtClientGenAppearance"];
    $heent = $physical["txtClientHEENT"];
    $heartnlungs = $physical["txtClientHeartLungs"];
    $m_remarks = $physical["stfMedicalStatRemarks"];
    $bloodvolume = $physical["intBloodVolumeId"];

    $deferralID = $physical["intDeferralId"];


if($m_remarks == "Accepted"){

    ?>
    <div class="col-md-5">
      <div class="form-group">
        <label for="donorweight">Weight</label>
        <input type="text" class="form-control" value = "<?php echo $weight?>" readonly>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <label for="donorbloodpressure">Blood Pressure</label>
        <input type="text" class="form-control" value = "<?php echo $bp?>" readonly>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <label for="donorpulserate">Pulse Rate</label>
        <input type="text" class="form-control" value = "<?php echo $pulserate?>" readonly>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <label for="donortemperature">Temperature</label>
        <input type="text" class="form-control" value = "<?php echo $temp?>" readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorgenapp">General Appearance</label>
        <input type="text" class="form-control" value = "<?php echo $genapp?>" readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorheent">Head, Ears, Eyes, Nose & Throat (HEENT)</label>
        <input type="text" class="form-control" value = "<?php echo $heent?>"  readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorheartlungs">Heart and Lungs</label>
        <input type="text" class="form-control" value = "<?php echo $heartnlungs?>" readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorheartlungs">Remarks</label>
        <input type="text" class="form-control" value = "<?php echo $m_remarks?>" readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorheartlungs">Blood Volume</label>
        <input type="text" class="form-control" value = "<?php echo $bloodvolume?>" readonly>
      </div>
    </div>
    <?php
  }else if($m_remarks == "Temporarily Deferred" || $m_remarks == "Permanently Deferred"){
    $deferralqry = mysqli_query($connections,"SELECT * FROM tbldeferral WHERE intDeferralId = '$deferralID'");
    if(mysqli_num_rows($deferralqry) >0){
      while($deferrals = mysqli_fetch_assoc($deferralqry)){
        $reason = $deferrals["txtDeferralReason"];
        $instruction =$deferrals["txtDeferralInstructions"];
      }
    }else{

    }
    ?>

    <div class="col-md-5">
      <div class="form-group">
        <label for="donorweight">Weight</label>
        <input type="text" class="form-control" value = "<?php echo $weight?>" readonly>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <label for="donorbloodpressure">Blood Pressure</label>
        <input type="text" class="form-control" value = "<?php echo $bp?>" readonly>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <label for="donorpulserate">Pulse Rate</label>
        <input type="text" class="form-control" value = "<?php echo $pulserate?>" readonly>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <label for="donortemperature">Temperature</label>
        <input type="text" class="form-control" value = "<?php echo $temp?>" readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorgenapp">General Appearance</label>
        <input type="text" class="form-control" value = "<?php echo $genapp?>" readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorheent">Head, Ears, Eyes, Nose & Throat (HEENT)</label>
        <input type="text" class="form-control" value = "<?php echo $heent?>"  readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorheartlungs">Heart and Lungs</label>
        <input type="text" class="form-control" value = "<?php echo $heartnlungs?>" readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorheartlungs">Remarks</label>
        <input type="text" class="form-control" value = "<?php echo $m_remarks?>" readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorheartlungs">Blood Volume</label>
        <input type="text" class="form-control" value = "<?php echo $bloodvolume?>" readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorheartlungs">Deferral reason</label>
        <input type="text" class="form-control" value = "<?php echo $reason?>" readonly>
      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="donorheartlungs">Deferral Instruction</label>
        <input type="text" class="form-control" value = "<?php echo $instruction?>" readonly>
      </div>
    </div>
    <?php
  }
  ?>

 <?php
  }
}else{
  ?>
  <p>No Physical Exam record</p>
  <?php
}
 ?>

</div>
 <!--Physical Exam-->

 <!--Initial Screening-->
 <div class="content-container"style="margin-top: -20px">
  <?php
 $initialQry = mysqli_query($connections,"SELECT * FROM tblinitialscreening WHERE intDonationId = '$id'");
 if(mysqli_num_rows($initialQry) > 0){
   ?>
   <h3>Donor Initial Screening</h3>
   <table class='table table-bordered mt-5 text-center' >
     <thead>
       <tr>
         <th>Blood Component</th>
         <th>Result</th>
         <th>Remarks</th>
         <th>Screener</th>
         <th>Verifier</th>

       </tr>
     </thead>
   <?php
   while($initial = mysqli_fetch_assoc($initialQry)){
     $componentid = $initial["intBloodComponentId"];
     $result = $initial["strBloodComponentResult"];
     $remarks = $initial["strBloodComponentRemarks"];
     $screener = $initial["strBloodComponentScreener"];
     $verifier = $initial["strIBloodComponentVerifier"];


     $componentnQry = mysqli_query($connections,"SELECT strBloodComponent FROM tblbloodcomponent WHERE intBloodComponentId = '$componentid'");
     while ($component = mysqli_fetch_assoc($componentnQry)) {
       $bloodcomponent = $component["strBloodComponent"];
     }
     ?>
     <tr>
       <td><?php echo $bloodcomponent; ?></td>
       <td><?php echo $result; ?></td>
       <td><?php echo $remarks; ?></td>
       <td><?php echo $screener; ?></td>
       <td><?php echo $verifier; ?></td>
     </tr>
  <?php
   }
    ?>
      </table>
      <br/>
      <br/>
      <br/>
    <?php
  }else{
    ?>
    <p>No Initial Screening record</p>
    <?php
  }
     ?>

 </div>
 <!--Initial Screening-->

<!--Serological Screening-->
<div class="content-container"style="margin-top: -20px">
 <?php
$serologicalQry = mysqli_query($connections,"SELECT * FROM tblserologicalscreening WHERE intDonationId = '$id'");
if(mysqli_num_rows($serologicalQry) > 0){
  ?>
  <h3>Donor Serological Screening</h3>
  <table class='table table-bordered mt-5 text-center' >
    <thead>
      <tr>
        <th>Disease</th>
        <th>Remarks</th>
        <th>Screener</th>
        <th>Verifier</th>
        <th>Pass/Fail</th>

      </tr>
    </thead>
  <?php
  while($serological = mysqli_fetch_assoc($serologicalQry)){
    $diseaseid = $serological["intDiseaseId"];
    $dremarks = $serological["strDiseaseRemarks"];
    $dscreener = $serological["strDiseaseScreener"];
    $dverifier = $serological["strDiseaseVerifier"];
    $dpass = $serological["stfDonorSerologicalScreeningRemarks"];


    $diseaseQry = mysqli_query($connections,"SELECT strDisease FROM tbldisease WHERE intDiseaseId = '$diseaseid'");
    while ($disease = mysqli_fetch_assoc($diseaseQry)) {
      $diseaseName = $disease["strDisease"];
    }
    ?>
    <tr>
      <td><?php echo $diseaseName; ?></td>
      <td><?php echo $dremarks; ?></td>
      <td><?php echo $dscreener; ?></td>
      <td><?php echo $dverifier; ?></td>
      <td><?php echo $dpass; ?></td>
    </tr>
 <?php
  }
   ?>
     </table>
     <br/>
     <br/>
     <br/>
   <?php
 }else{
   ?>
   <p>No Serological Screening record</p>
   <?php
 }
    ?>

</div>
<!--Serological Screening-->

</div>
</body>
</html>
