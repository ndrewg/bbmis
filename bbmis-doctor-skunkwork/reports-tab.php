<?php
include("connections.php");

/*$reports_remaining = mysqli_query($connections,  " SELECT bt.intBloodTypeId,stfBloodType,stfBloodTypeRhesus,COUNT(intBloodBagId) AS 'count_remaining'
FROM tblbloodtype bt
JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId WHERE stfIsBloodBagExpired ='No' AND intBloodDispatchmentId = '1' GROUP BY bt.intBloodTypeId ");*/
$reports_wastage = mysqli_query($connections, " SELECT bt.intBloodTypeId,stfBloodType,stfBloodTypeRhesus,COUNT(intBloodBagId) AS 'count_wastage'
FROM tblbloodtype bt
JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId WHERE stfIsBloodBagExpired ='Yes'AND stfTransfusionsuccess = 'No' GROUP BY bt.intBloodTypeId, YEAR(dtmDateStored)");
$reports_daily = mysqli_query($connections, " SELECT DATE_FORMAT(dtmDateStored, '%W') AS 'Day', COUNT(intBloodBagId) AS 'Blood Bag Count',stfBloodType
FROM tblbloodbag bb JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
WHERE DATE_FORMAT(dtmDateStored, '%Y') = DATE_FORMAT(NOW(), '%Y')
AND DATE_FORMAT(dtmDateStored, '%m') = DATE_FORMAT(NOW(), '%m')
GROUP BY 3");

$weekly_count = mysqli_query($connections, "SELECT stfBloodType, COUNT(intBloodBagId) AS 'Weekly Count'
  FROM tblbloodbag bb
  JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
  WHERE DATE_FORMAT(dtmDateStored, '%Y') = DATE_FORMAT(NOW(), '%Y')
  AND DATE_FORMAT(dtmDateStored, '%m') = DATE_FORMAT(NOW(), '%m')
  AND DATE_FORMAT(dtmDateStored, '%U') = DATE_FORMAT(NOW(), '%U')
  GROUP BY 1
");

$reports_monthly = mysqli_query($connections,"SELECT DATE_FORMAT(dtmDateStored, '%M %Y') AS 'Month Year', COUNT(intBloodBagId) AS 'Blood Bag Count',stfBloodType
FROM tblbloodbag bb JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
GROUP BY 3
ORDER BY 1 ASC");
$reports_yearly = mysqli_query($connections,"SELECT DATE_FORMAT(dtmDateStored, '%Y') AS 'Year', COUNT(intBloodBagId) AS 'Blood Bag Count',stfBloodType
FROM tblbloodbag bb JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
GROUP BY 3
ORDER BY 1 ASC");
$bloodbagpertype = mysqli_query($connections,"SELECT bt.stfBloodType AS 'Blood Type', COUNT(bb.intBloodTypeId) AS 'Blood Bag Count'
FROM tblbloodtype bt
JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId
WHERE stfIsBloodBagExpired = 'No'
GROUP BY 1");
$donorpertype = mysqli_query($connections,"SELECT bt.stfBloodType AS 'Blood Type', COUNT(c.intBloodTypeId) AS 'Donor Count'
FROM tblbloodtype bt
JOIN tblclient c ON bt.intBloodTypeId = c.intBloodTypeId
WHERE stfClientType = 'Donor'
GROUP BY 1");
$bloodcomponentfailedcount = mysqli_query($connections,"SELECT DATE_FORMAT(dtmDateScreened, '%M %Y') AS 'Month Year' , bc.strBloodComponent, COUNT(*) AS 'Failed Client Count'
FROM tblbloodcomponent bc
JOIN tblinitialscreening ins ON bc.intBloodComponentId = ins.intBloodComponentId
WHERE ins.strBloodComponentRemarks = 'Failed'
GROUP BY 2");
$bloodcomponentfailedlist = mysqli_query($connections,"SELECT DATE_FORMAT(dtmDateScreened, '%M %Y') AS 'Month Year', strBloodComponent, CONCAT(c.strClientFirstName, ' ', c.strClientLastName) AS 'Client Full Name'
FROM tblclient c
JOIN tbldonation d ON c.intClientId = d.intClientId
JOIN tblinitialscreening ins ON d.intDonationId = ins.intDonationId
JOIN tblbloodcomponent bc ON ins.intBloodComponentId = bc.intBloodComponentId
WHERE ins.strBloodComponentRemarks = 'Failed'
GROUP BY 3");
$blooddiseasefailedcount = mysqli_query($connections,"SELECT DATE_FORMAT(dtmDateScreened, '%M %Y') AS 'Month Year', d.strDisease, COUNT(*) AS 'Failed Client Count'
FROM tbldisease d
JOIN tblserologicalscreening ss ON d.intDiseaseId = ss.intDiseaseId
WHERE ss.strDiseaseRemarks = 'Failed'
GROUP BY 2");
$blooddiseasefailedlist = mysqli_query($connections,"SELECT DATE_FORMAT(dtmDateScreened, '%M %Y') AS 'Month Year',strDisease,CONCAT(c.strClientFirstName, ' ', c.strClientLastName) AS 'Client Full Name'
FROM tblclient c
JOIN tbldonation d ON c.intClientId = d.intClientId
JOIN tblserologicalscreening ss ON d.intDonationId = ss.intDonationId
JOIN tbldisease di ON di.intDiseaseId = ss.intDiseaseId
WHERE ss.strDiseaseRemarks = 'Failed'
GROUP BY 3");
$donorcountperage = mysqli_query($connections,"SELECT TIMESTAMPDIFF(YEAR, datClientBirthday, NOW()) AS 'Client Age', COUNT(*) AS 'Client Count'
FROM tblclient
GROUP BY 1
ORDER BY 1 ASC");
$donorcountpersex = mysqli_query($connections,"SELECT stfClientSex AS 'Client Sex', COUNT(*) AS 'Client Count'
FROM tblclient
GROUP BY 1");
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
       <?php
        include "fetchEmpAcc.php";
        include "employeeNavbar.php";
       ?>
      <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Reports</h5>
    </div>
    <!-- SIDE NAVIGATION -->
    <?php
      include "employeeSidebar.php";
    ?>
    <!-- END OF SIDE NAVIGATION -->
    <div class="col-md-10 offset-md-2">
      <div class="content-container">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <button type="button" class="btn btn-outline-danger float-right mb-5" id="btn_genpdf"><i class="fas fa-print"></i> Generate pdf</button>
            </div>
            <!-- <div class="col-md-4 card card-body text-center mx-auto">
              <h4>Remaining blood bag count</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Blood Type</th>
                    <th>Rhesus</th>
                    <th>Remaining Count</th>
                  </tr>
                </thead>
              <?php
              if (mysqli_num_rows($reports_remaining) > 0 ){
              $output = "";
              while ($row = mysqli_fetch_assoc($reports_remaining)) {
                $blood_type = $row["stfBloodType"];
                $rhesus = $row["stfBloodTypeRhesus"];
                $remaining = $row["count_remaining"];
                $output .=
                "
                <tbody>
                <tr>
                <td>$blood_type</td>
                <td>$rhesus</td>
                <td>$remaining</td>
                </tr>
                </tbody>
                ";
              }
              $output .= "
              </table>
              ";
              echo $output;
            }
            else if (mysqli_num_rows($reports_remaining) == 0){
              $output =
              "<tr>
                <td></td>
                <td>No records</td>
                <td></td>
              </tr>
              </table>";
              echo $output;
            }
               ?>
            </div> -->
            <div class="col-md-4 card card-body text-center mx-auto mt-3">
              <h4>Remaining Blood Bag Count Per Blood Type</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Blood Type</th>
                    <th>Blood Bag Count</th>
                  </tr>
                </thead>
                <?php
                if (mysqli_num_rows($bloodbagpertype) > 0){
                  $output = "";
                  while($row = mysqli_fetch_assoc($bloodbagpertype)){
                    $day = $row["Blood Type"];
                    $bloodbagamount = $row["Blood Bag Count"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$day</td>
                    <td>$bloodbagamount</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($bloodbagpertype) == 0){
                  $output =
                  "
                  <tr>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto">
              <h4>Weekly count of blood bag</h4>
              <table class="table text-center">
                <thead>
                  <tr>
                    <th>Blood Type</th>
                    <th>Count</th>
                  </tr>
                </thead>
                <?php
                if(mysqli_num_rows($weekly_count) > 0){
                  $output ="";
                  while($row = mysqli_fetch_assoc($weekly_count)){
                    $bloodtype = $row["stfBloodType"];
                    $count = $row["Weekly Count"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$bloodtype</td>
                    <td>$count</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($weekly_count) == 0) {
                  $output =
                  "<tr>
                  <td>No records</td>
                  <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto">
              <h4>Wastage Report</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Blood Type</th>
                    <th>Rhesus</th>
                    <th>Remaining Count</th>
                  </tr>
                </thead>
               <?php
               if (mysqli_num_rows($reports_wastage) > 0){
                 $output = "";
                 while($row = mysqli_fetch_assoc($reports_wastage)){
                 $blood_type = $row["stfBloodType"];
                 $rhesus = $row["stfBloodTypeRhesus"];
                 $wastage = $row["count_wastage"];
                 $output .=
                 "
                 <tbody>
                 <tr>
                 <td>$blood_type</td>
                 <td>$rhesus</td>
                 <td>$wastage</td>
                 </tr>
                 </tbody>
                 ";
                 }
                 $output .=
                 "</table>";
                 echo $output;
               }
               else if (mysqli_num_rows($reports_wastage) == 0) {
                $output =
                 "
                 <tr>
                   <td></td>
                   <td>No records</td>
                   <td></td>
                 </tr>
                 </table>";
                 echo $output;
               }
                ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto">
              <h4>Daily Blood Extraction</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Day</th>
                    <th>Blood Bag Count</th>
                    <th>Blood Type </th>
                  </tr>
                </thead>
                <?php
                if (mysqli_num_rows($reports_daily) > 0){
                  $output = "";
                  while($row = mysqli_fetch_assoc($reports_daily)){
                    $day = $row["Day"];
                    $bloodbagamount1 = $row["Blood Bag Count"];
                    $bloodType = $row["stfBloodType"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$day</td>
                    <td>$bloodbagamount1</td>
                    <td>$bloodType</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($reports_daily) == 0){
                  $output =
                  "
                  <tr>
                    <td></td>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto mt-3">
              <h4>Monthly Blood Extraction</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Month Year</th>
                    <th>Blood Bag Count</th>
                    <th>Blood Type </th>
                  </tr>
                </thead>
                <?php
                if (mysqli_num_rows($reports_monthly) > 0){
                  $output = "";
                  while($row = mysqli_fetch_assoc($reports_monthly)){
                    $month_year = $row["Month Year"];
                    $bloodbagamount2 = $row["Blood Bag Count"];
                    $bloodType = $row["stfBloodType"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$month_year</td>
                    <td>$bloodbagamount2</td>
                    <td>$bloodType</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($reports_monthly) == 0){
                  $output =
                  "
                  <tr>
                    <td></td>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto mt-3">
              <h4>Yearly Blood Extraction</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Year</th>
                    <th>Blood Bag Count</th>
                    <th>Blood Type </th>
                  </tr>
                </thead>
                <?php
                if(mysqli_num_rows($reports_yearly) > 0){
                  $output = "";
                  while($row = mysqli_fetch_assoc($reports_yearly)){
                    $day = $row["Year"];
                    $bloodbagamount = $row["Blood Bag Count"];
                    $bloodType = $row["stfBloodType"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$day</td>
                    <td>$bloodbagamount</td>
                    <td>$bloodType</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($reports_yearly) == 0){
                  $output =
                  "
                  <tr>
                    <td></td>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto mt-3">
              <h4>Donor Count Per Blood Type</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Blood Type</th>
                    <th>Donor Count</th>
                  </tr>
                </thead>
                <?php
                if (mysqli_num_rows($donorpertype) > 0) {
                  $output = "";
                  while($row = mysqli_fetch_assoc($donorpertype)){
                    $day = $row["Blood Type"];
                      $bloodbagamount = $row["Donor Count"];
                      $output .=
                      "
                      <tbody>
                      <tr>
                      <td>$day</td>
                      <td>$bloodbagamount</td>
                      </tr>
                      </tbody>
                      ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($donorpertype) == 0 ){
                  $output =
                  "
                  <tr>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto mt-3">
              <h4>Count of donor fail per Component</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Month Year</th>
                    <th>Blood Component</th>
                    <th>Failed Client Count</th>
                  </tr>
                </thead>
                <?php
                if (mysqli_num_rows($bloodcomponentfailedcount) > 0){
                  $output = "";
                  while($row = mysqli_fetch_assoc($bloodcomponentfailedcount)){
                    $monthyear = $row["Month Year"];
                    $day = $row["strBloodComponent"];
                    $bloodbagamount = $row["Failed Client Count"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$monthyear</td>
                    <td>$day</td>
                    <td>$bloodbagamount</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($bloodcomponentfailedcount) == 0){
                  $output =
                  "
                  <tr>
                    <td></td>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto mt-3">
              <h4>List of donor fail per Component</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Month Year</th>
                    <th>Blood Component</th>
                    <th>Failed Client Name</th>
                  </tr>
                </thead>
                <?php
                if (mysqli_num_rows($bloodcomponentfailedlist) > 0){
                  $output = "";
                  while($row = mysqli_fetch_assoc($bloodcomponentfailedlist)){
                    $monthyear = $row["Month Year"];
                    $day = $row["strBloodComponent"];
                    $bloodbagamount = $row["Client Full Name"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$monthyear</td>
                    <td>$day</td>
                    <td>$bloodbagamount</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($bloodcomponentfailedlist) == 0 ){
                  $output =
                  "
                  <tr>
                    <td></td>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto mt-3">
              <h4>Count of donor fail per Disease</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Month Year</th>
                    <th>Disease</th>
                    <th>Failed Client Count</th>
                  </tr>
                </thead>
                <?php
                if (mysqli_num_rows($blooddiseasefailedcount) > 0){
                  $output = "";
                  while($row=mysqli_fetch_assoc($blooddiseasefailedcount)){
                    $monthyear = $row["Month Year"];
                    $day = $row["strDisease"];
                    $bloodbagamount = $row["Failed Client Count"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$monthyear</td>
                    <td>$day</td>
                    <td>$bloodbagamount</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($blooddiseasefailedcount) == 0){
                  $output =
                  "
                  <tr>
                    <td></td>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto mt-3">
              <h4>List of donor fail per Disease</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Month Year</th>
                    <th>Disease</th>
                    <th>Failed Client Count</th>
                  </tr>
                </thead>
                <?php
                if (mysqli_num_rows($blooddiseasefailedlist) > 0){
                  $output = "";
                  while($row = mysqli_fetch_assoc($blooddiseasefailedlist)){
                    $monthyear = $row["Month Year"];
                    $day = $row["strDisease"];
                    $bloodbagamount = $row["client Full Name"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$monthyear</td>
                    <td>$day</td>
                    <td>$bloodbagamount</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($blooddiseasefailedlist) == 0 ){
                  $output =
                  "
                  <tr>
                    <td></td>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto mt-3">
              <h4>Count of Client per Age</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Client Age</th>
                    <th>Client Count</th>
                  </tr>
                </thead>
                <?php
                if (mysqli_num_rows($donorcountperage) > 0){
                  $output = "";
                  while($row = mysqli_fetch_assoc($donorcountperage)){
                    $monthyear = $row["Client Age"];
                    $day = $row["Client Count"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$monthyear</td>
                    <td>$day</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($donorcountperage) == 0){
                  $output =
                  "
                  <tr>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
            <div class="col-md-4 card card-body text-center mx-auto mt-3">
              <h4>Count of Client per Sex</h4>
              <table class='table text-center'>
                <thead>
                  <tr>
                    <th>Client Sex</th>
                    <th>Client Count</th>
                  </tr>
                </thead>
                <?php
                if (mysqli_num_rows($donorcountpersex) > 0){
                  $output = "";
                  while($row = mysqli_fetch_assoc($donorcountpersex)){
                    $monthyear = $row["Client Sex"];
                    $day = $row["Client Count"];
                    $output .=
                    "
                    <tbody>
                    <tr>
                    <td>$monthyear</td>
                    <td>$day</td>
                    </tr>
                    </tbody>
                    ";
                  }
                  $output .= "</table>";
                  echo $output;
                }
                else if (mysqli_num_rows($donorcountpersex) == 0 ){
                  $output =
                  "
                  <tr>
                    <td>No records</td>
                    <td></td>
                  </tr>
                  </table>
                  ";
                  echo $output;
                }
                 ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
<script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/notification.js"></script>
<script type="text/javascript">
  $("#reportstab").addClass("active");
  $(document).on("click","#btn_genpdf", function(e){
    window.location.href = "genReportsPdf.php";
  });
</script>
</body>
</html>
