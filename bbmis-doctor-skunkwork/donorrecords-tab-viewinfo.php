<?php
include("connections.php");
$clientid = $_GET['id'];
// echo $clientid;
$viewrecord = mysqli_query($connections, " SELECT tc.strClientFirstName, tc.strClientMiddleName, tc.strClientLastName, tc.stfClientSex, tc.strClientContact, tc.datClientBirthday, bt.stfBloodType, bt.stfBloodTypeRhesus, strUserImageDir FROM tblclient tc JOIN tblbloodtype bt ON tc.intBloodTypeId = bt.intBloodTypeId JOIN tbluser u ON u.intUserId = tc.intUserId WHERE tc.intClientId = '$clientid' ");
$row = mysqli_fetch_assoc($viewrecord);
$clientfirstname = $row["strClientFirstName"];
$clientmiddlename = $row["strClientMiddleName"];
$clientlastname = $row["strClientLastName"];
$clientbirthday = $row["datClientBirthday"];
$clientsex = $row["stfClientSex"];
$clientcontact = $row["strClientContact"];
$bloodtype = $row["stfBloodType"];
$bloodrhesus = $row["stfBloodTypeRhesus"];
$image = $row["strUserImageDir"];

$donationidqry = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$clientid' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

if(mysqli_num_rows($donationidqry) > 0){
while($donation = mysqli_fetch_assoc($donationidqry)){
 $donation_id = $donation["intDonationId"];
}}

$lastdonation = mysqli_query($connections,"SELECT d.intDonationId, m.dtmExamTaken, d.stfDonationRemarks
FROM tbldonation d
JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
 WHERE d.intClientId = '$clientid'
 AND d.intDonationId = '$donation_id'");

if(mysqli_num_rows($lastdonation) > 0){
 while($donation2 = mysqli_fetch_assoc($lastdonation)){
  $lastdonationdate = $donation2["dtmExamTaken"];
 }
}else{
  $lastdonationdate = "None";
}

$timesdonatedqry = mysqli_query($connections,"SELECT COUNT(intDonationId) AS count FROM tbldonation WHERE intClientId = '$clientid' AND stfDonationRemarks = 'Complete' AND stfDonationStatus = 'Able'");
if(mysqli_num_rows($timesdonatedqry) > 0){
 while($donation3 = mysqli_fetch_assoc($timesdonatedqry)){
  $donationfreq = $donation3["count"];
 }
}else{
  $lastdonationdate = "None";
}

$timesrejectedmedqry = mysqli_query($connections,"SELECT COUNT(DISTINCT(d.intDonationId)) AS count FROM tblmedicalexam m JOIN tbldonation d ON m.intDonationId = d.intDonationId WHERE intClientId = '$clientid' AND stfAnswerRemarks = 'Wrong'");
if(mysqli_num_rows($timesrejectedmedqry) > 0){
 while($donation4 = mysqli_fetch_assoc($timesrejectedmedqry)){
  $donationrejmed = $donation4["count"];
 }
}else{
  $donationrejmed = "None";
}

$timesrejectedphysqry = mysqli_query($connections,"SELECT COUNT(DISTINCT(d.intDonationId)) AS count FROM tblphysicalexam p JOIN tbldonation d ON p.intDonationId = d.intDonationId WHERE intClientId = '$clientid' AND stfClientPhysicalExamRemarks = 'Failed'");
if(mysqli_num_rows($timesrejectedphysqry) > 0){
 while($donation5 = mysqli_fetch_assoc($timesrejectedphysqry)){
  $donationrejphy = $donation5["count"];
 }
}else{
  $donationrejphy = "None";
}

$timesrejectedinitqry = mysqli_query($connections,"SELECT COUNT(DISTINCT(d.intDonationId)) AS count FROM tblinitialscreening i JOIN tbldonation d ON i.intDonationId = d.intDonationId WHERE intClientId = '$clientid' AND stfClientInitialScreeningRemarks	 = 'Failed'");
if(mysqli_num_rows($timesrejectedinitqry) > 0){
 while($donation6 = mysqli_fetch_assoc($timesrejectedinitqry)){
  $donationrejinit = $donation6["count"];
 }
}else{
  $donationrejinit = "None";
}

$timesrejectedseroqry = mysqli_query($connections,"SELECT COUNT(DISTINCT(d.intDonationId)) AS count FROM tblserologicalscreening s JOIN tbldonation d ON s.intDonationId = d.intDonationId WHERE intClientId = '$clientid' AND stfDonorSerologicalScreeningRemarks = 'Failed'");
if(mysqli_num_rows($timesrejectedseroqry) > 0){
 while($donation7 = mysqli_fetch_assoc($timesrejectedseroqry)){
  $donationrejsero = $donation7["count"];
 }
}else{
  $donationrejsero = "None";
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bs4/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/fontawesome-all.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 fixed-top offset-md-2 header">
        <button type="button" class="btn float-right text-white text-center" style="background-color: rgb(234,72,127); margin-top: 3px; width: 65px; height: 30px;">Logout</button>
        <!-- notification -->
        <div class="dropdown show">
          <a href="#" class="float-right mr-3 text-white dropdown-toggle" id="notifications" style="margin-top: 10px;" data-toggle="dropdown">
            <span class="badge badge-pill count" style="border-radius:10px;"></span>
            <i class="fas fa-bell"></i>
          </a>
          <div class="dropdown-menu" aria-labelledby="notifications">

          </div>
        </div>
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Storage</h5>
      </div>
      <!-- SIDE NAVIGATION -->

      <div class="col-md-2 sidebar container-fluid">
        <div class="system-title">
          <img class="float-left" src="images/logoinwhite.png" alt="logo" style="width: 75px;">
          <h4 class="float-left mt-2" style="color:rgb(250,250,250); font-family: 'Nunito-Regular'">Re-Feel</h4>
        </div>
        <img src="images/ablirdp.jpg" class="img-fluid" alt="donor image" style="width:45px; border-radius:60px; margin-top:10px;"> <span class="ml-2 donorname">Admin</span>
        <!-- <p class=""></p> -->
        <hr>
        <div class="nav flex-column" id ="sidebar">
          <h6 class="collapsibleheader" data-toggle="collapse" data-target="#home-tabs" aria-expanded="false" aria-controls="home-tabs">Home</h6>
          <div class="collapse show" id="home-tabs">
            <a href="graphs-tab.php" class="nav-link nav-item " id="graphstab"><i class="fas fa-chart-line mr-1"></i> Graphs</a>
            <a href="donorlist-tab.php" class="nav-link nav-item" id="donorlisttab"><i class="fas fa-list mr-1"></i> Donor List</a>
          </div>
          <h6 class="collapsibleheader" id="collapsibleheader" data-toggle="collapse" data-target="#maintenance-tabs" aria-expanded="false" aria-controls="maintenance-tabs">Maintenance</h6>
          <div class="collapse show" id="maintenance-tabs">
            <a href="bloodtype-tab.php" class="nav-link nav-item" id="bloodtypetab"><img src="" alt=""> Blood Type</a>
            <a href="bloodcomponent-tab.php" class="nav-link nav-item" id="bloodcomponenttab"><img src="css/glyphicon/si-glyph-blood-bag.svg" style="width:20px;"> Blood Component</a>
            <a href="disease-tab.php" class="nav-link nav-item" id="diseasetab"><img src="css/glyphicon/si-glyph-heart-delete.svg" style="width:17px;"> Disease</a>
            <a href="donoreditrequests-tab.php" class="nav-link nav-item" id="donoreditrequeststab"><img src="css/glyphicon/si-glyph-document-checked.svg" style="width: 17px" alt=""> Donor Edit Requests</a>
            <a href="survey-tab.php" class="nav-link nav-item" id="surveytab"><i class="fas fa-file-alt mr-1"></i> Survey</a>
            <a href="category-tab.php" class="nav-link nav-item" id="surveycategorytab"><i class="far fa-file-alt"></i> Survey Category</a>
            <a href="storage-tab.php" class="nav-link nav-item" id="storagetab"><i class="fas fa-box-open"></i> Storage</a>
            <a href="staff-tab.php" class="nav-link nav-item" id="stafftab"><i class="fas fa-user-cog mr-1"></i> Staff</a>
            <a href="donor-tab.php" class="nav-link nav-item" id="donortab"><i class="fas fa-user-cog mr-1"></i> Donor</a>
          </div>
          <h6 class="collapsibleheader" data-toggle="collapse" data-target="#transaction-tabs" aria-expanded="false" aria-controls="transaction-tabs">Transaction</h6>
          <div class="collapse show" id="transaction-tabs">
            <a href="donorrecords-tab.php" class="nav-link nav-item" id="donorrecordstab"><i class="fas fa-file-medical-alt mr-1"></i> Donor Records</a>
            <a href="bloodinventory-tab.php" class="nav-link nav-item" id="bloodinventorytab"><i class="fas fa-first-aid mr-1"></i> Blood Inventory</a>
          </div>
        </div>
      </div>
      <!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <button type="button" class="btn" onclick='location.href="donorrecords-tab.php"'><i class="fas fa-long-arrow-alt-left" ></i> Back to records</button>
          <div class="row">
            <!-- client info -->
            <div class="container-fluid col-md-4" id="client_info" style="margin-top: 10px; margin-bottom: 10px; box-shadow: 0 0 1px 0 #d1d1d1; padding: 15px;">
              <label class="labeldonordiv">Name: </label>
              <label id='client_fullname'><?php echo $clientfirstname . " " . $clientmiddlename . " " . $clientlastname ?></label><br>
              <label class="labeldonordiv">Birthday:  </label>
              <label id='client_bday'><?php echo $clientbirthday ?></label><br>
              <label class="labeldonordiv">Sex: </label>
              <label id='client_sex'><?php echo $clientsex ?> </label><br>
              <label class="labeldonordiv">Contact: </label>
              <label id='client_contact'> <?php echo $clientcontact ?> </label><br>
              <label class="labeldonordiv">Blood Type: </label>
              <label id="client_bloodtype"> <?php echo $bloodtype . " " . $bloodrhesus ?> </label>
            </div>
            <!-- client donation info -->
            <div class="col-md-4 container-fluid" style="margin-top: 10px; margin-bottom: 10px; box-shadow: 0 0 1px 0 #d1d1d1; padding: 15px;">
              <label class="labeldonordiv" for="lastdonation">Last Donation: <?php echo $lastdonationdate ?></label>
              <label id="lastdonation"></label><br>
              <label class="labeldonordiv" for="timesdonated">Times Donated: <?php echo $donationfreq ?></label>
              <label id="timesdonated"></label><br>
              <label class="labeldonordiv">Times Rejected:</label><br>
              <label class="mr-3" id="timesrejectedinsurvey">Survey: <?php echo $donationrejmed ?> </label>
              <label class="mr-3" id="timesrejectedphys">Physical Exam: <?php echo $donationrejphy ?> </label>
              <label class="mr-3" id="timesrejectedinit">Initial Screening: <?php echo $donationrejinit ?> </label>
              <label class="mr-3" id="timesrejectedsero">Serological Screening: <?php echo $donationrejsero ?> </label>
            </div>
            <!-- client image -->
            <div class="col-md-4 container-fluid" style="margin-top: 10px; margin-bottom: 10px; box-shadow: 0 0 1px 0 #d1d1d1; padding: 15px;">
              <img src = "">
            </div>
            <div class="col-md-3" style="margin: 10px 0 10px 0;">

            </div>
            <div class="col-md-12">
              <h4 class="labeldonordiv" id="title"></h4>
            </div>
            <div class="col-md-12" id="divview_records">
              <table id="tbl_viewdonation" class="table table-striped table-bordered text-center" style="width: 100%">
                <thead>
                  <tr>
                    <th>Donation ID</th>
                    <th>Donation Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
  <script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="js/realtime-connection.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    fetch_donation();

    function fetch_donation(){
      var clientid = <?php echo $clientid ?>;
      console.log(clientid);
      //initialize active blood component table
      var dataTable = $('#tbl_viewdonation').DataTable({
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
          url : "people-related/fetch_donationrecord.php",
          type: "POST",
          data:{clientid:clientid}
        },
        "language" : {
          "emptyTable" : "No donation record to show"
        }
      });
    }
  });
  </script>
</body>
</html>
