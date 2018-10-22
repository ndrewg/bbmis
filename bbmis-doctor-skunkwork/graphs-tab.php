<?php
include("connections.php");
/*
fetch lifespan
$fetch_bloodstatus = mysqli_query($connections, " SELECT * FROM tblpreservatives ");
while($row = mysqli_fetch_assoc($fetch_bloodstatus)){
  $bloodbaglifespan = $row["intPreservativeLifespan"];
  $freshbloodbag = $row["intPreservativeFreshPercentage"];
  $mediumbloodbag = $row["intPreservativeNeutralPercentage"];
  $criticalbloodbag = $row["intPreservativeCriticalPercentage"];
}
settype($bloodbaglifespan, "int");
settype($freshbloodbag, "int");
settype($mediumbloodbag, "int");
settype($criticalbloodbag, "int");

$fresh_percentage = $freshbloodbag / 100;
$medium_percentage = $mediumbloodbag / 100;
$critical_percentage = $criticalbloodbag / 100;

$fresh_lifespan = $bloodbaglifespan * $fresh_percentage;
settype($fresh_lifespan, "int");
$medium_lifespan = $bloodbaglifespan * $medium_percentage;
settype($medium_lifespan, "int");
$critical_lifespan = $bloodbaglifespan * $critical_percentage;
settype($critical_lifespan, "int");
*/

//count blood bags per blood type
// type a count
$fetch_countofbloodbagtypea = mysqli_query($connections, " SELECT COUNT(tbb.intBloodBagId) AS 'bloodbagcount' FROM tblbloodtype tbt
JOIN tblbloodbag tbb ON tbt.intBloodTypeId = tbb.intBloodTypeId
JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
WHERE tbt.intBloodTypeId IN (SELECT intBloodTypeId FROM tblbloodtype WHERE stfBloodType = 'A') AND stfIsBloodBagExpired = 'No' AND stfIsBloodBagDiscarded = 'No' AND tbt.stfBloodType = 'A'  AND TIMESTAMPDIFF(DAY, dtmDateStored, NOW()) <= tp.intPreservativeLifespan ");
$row_countbloodbagtypea = mysqli_fetch_assoc($fetch_countofbloodbagtypea);
$countbloodbagtypea = $row_countbloodbagtypea["bloodbagcount"];
// type ab count
$fetch_countofbloodbagtypeab = mysqli_query($connections, " SELECT COUNT(tbb.intBloodBagId) AS 'bloodbagcount' FROM tblbloodtype tbt
JOIN tblbloodbag tbb ON tbt.intBloodTypeId = tbb.intBloodTypeId
JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
WHERE tbt.intBloodTypeId IN (SELECT intBloodTypeId FROM tblbloodtype WHERE stfBloodType = 'AB') AND stfIsBloodBagExpired = 'No' AND stfIsBloodBagDiscarded = 'No' AND tbt.stfBloodType = 'AB' AND TIMESTAMPDIFF(DAY, dtmDateStored, NOW()) <= tp.intPreservativeLifespan ");
$row_countbloodbagtypeab = mysqli_fetch_assoc($fetch_countofbloodbagtypeab);
$countbloodbagtypeab = $row_countbloodbagtypeab["bloodbagcount"];
// type b count
$fetch_countofbloodbagtypeb = mysqli_query($connections, " SELECT COUNT(tbb.intBloodBagId) AS 'bloodbagcount' FROM tblbloodtype tbt
JOIN tblbloodbag tbb ON tbt.intBloodTypeId = tbb.intBloodTypeId
JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
WHERE tbt.intBloodTypeId IN (SELECT intBloodTypeId FROM tblbloodtype WHERE stfBloodType = 'B') AND stfIsBloodBagExpired = 'No' AND stfIsBloodBagDiscarded = 'No' AND tbt.stfBloodType = 'B' AND TIMESTAMPDIFF(DAY, dtmDateStored, NOW()) <= tp.intPreservativeLifespan ");
$row_countbloodbagtypeb = mysqli_fetch_assoc($fetch_countofbloodbagtypeb);
$countbloodbagtypeb = $row_countbloodbagtypeb["bloodbagcount"];
// type o count
$fetch_countofbloodbagtypeo = mysqli_query($connections, " SELECT COUNT(tbb.intBloodBagId) AS 'bloodbagcount' FROM tblbloodtype tbt
JOIN tblbloodbag tbb ON tbt.intBloodTypeId = tbb.intBloodTypeId
JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
WHERE tbt.intBloodTypeId IN (SELECT intBloodTypeId FROM tblbloodtype WHERE stfBloodType = 'O') AND stfIsBloodBagExpired = 'No' AND stfIsBloodBagDiscarded = 'No' AND tbt.stfBloodType = 'O'  AND TIMESTAMPDIFF(DAY, dtmDateStored, NOW()) <= tp.intPreservativeLifespan");
$row_countbloodbagtypeo = mysqli_fetch_assoc($fetch_countofbloodbagtypeo);
$countbloodbagtypeo = $row_countbloodbagtypeo["bloodbagcount"];
//wastage report
$fetch_totalbloodbags = mysqli_query($connections, " SELECT COUNT(*) AS 'total_remainingbloodbags' FROM tblbloodbag tbb JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId WHERE stfIsBloodBagExpired = 'No' AND stfIsBloodBagDiscarded = 'No' AND TIMESTAMPDIFF(DAY, dtmDateStored, NOW()) <= tp.intPreservativeLifespan ");
$row_totalbloodbags = mysqli_fetch_assoc($fetch_totalbloodbags);
$total_bloodbags = $row_totalbloodbags["total_remainingbloodbags"];
$fetch_wastedbloodbags = mysqli_query($connections, " SELECT COUNT(*) AS 'Wasted Blood Bags'
FROM tblbloodbag tbb
JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
WHERE stfIsBloodBagExpired = 'Yes'
AND stfTransfusionSuccess = 'No' ");
$row_wastedbloodbags = mysqli_fetch_assoc($fetch_wastedbloodbags);
$wasted_bloodbags = $row_wastedbloodbags["Wasted Blood Bags"];
//donor count per blood type
// type a
$fetch_donorcounttypea = mysqli_query($connections, " SELECT bt.stfBloodType, COUNT(c.intClientId) AS 'Donor Count'
FROM tblbloodtype bt
JOIN tblclient c ON bt.intBloodTypeId = c.intBloodTypeId
WHERE c.stfClientType = 'Donor'
AND stfBloodType = 'A'
AND c.intClientId IN (
	SELECT d.intClientId
    FROM tbldonation d
) ");
$row_countdonortypea = mysqli_fetch_assoc($fetch_donorcounttypea);
$countdonortypea = $row_countdonortypea["Donor Count"];
// type ab
$fetch_donorcounttypeab = mysqli_query($connections, " SELECT bt.stfBloodType, COUNT(c.intClientId) AS 'Donor Count'
FROM tblbloodtype bt
JOIN tblclient c ON bt.intBloodTypeId = c.intBloodTypeId
WHERE c.stfClientType = 'Donor'
AND stfBloodType = 'AB'
AND c.intClientId IN (
	SELECT d.intClientId
    FROM tbldonation d
) ");
$row_countdonortypeab = mysqli_fetch_assoc($fetch_donorcounttypeab);
$countdonortypeab = $row_countdonortypeab["Donor Count"];
// type a
$fetch_donorcounttypeb = mysqli_query($connections, " SELECT bt.stfBloodType, COUNT(c.intClientId) AS 'Donor Count'
FROM tblbloodtype bt
JOIN tblclient c ON bt.intBloodTypeId = c.intBloodTypeId
WHERE c.stfClientType = 'Donor'
AND stfBloodType = 'B'
AND c.intClientId IN (
	SELECT d.intClientId
    FROM tbldonation d
) ");
$row_countdonortypeb = mysqli_fetch_assoc($fetch_donorcounttypeb);
$countdonortypeb = $row_countdonortypeb["Donor Count"];
// type a
$fetch_donorcounttypeo = mysqli_query($connections, " SELECT bt.stfBloodType, COUNT(c.intClientId) AS 'Donor Count'
FROM tblbloodtype bt
JOIN tblclient c ON bt.intBloodTypeId = c.intBloodTypeId
WHERE c.stfClientType = 'Donor'
AND stfBloodType = 'O'
AND c.intClientId IN (
	SELECT d.intClientId
    FROM tbldonation d
) ");
$row_countdonortypeo = mysqli_fetch_assoc($fetch_donorcounttypeo);
$countdonortypeo = $row_countdonortypeo["Donor Count"];
?>

<!DOCTYPE html>
<html>
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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Graphs</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
      include "employeeSidebar.php";
      ?>
      <!-- END OF SIDE NAVIGATION -->
      <!-- MAIN CONTENT -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <h4 class="nunito mb-3 col-md-12 border-top border-bottom pt-2 pb-2">Blood Related</h4>
                <div class="col-md-6">
                  <div class="card card-body">
                    <div class="row mb-4">
                      <div class="col-md-6">
                        <h5>Count of remaining blood bags</h5>
                      </div>
                    </div>
                    <canvas id="bloodbagcountperbloodtype"></canvas>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card card-body">
                    <div class="row mb-4">
                      <div class="col-md-6">
                        <h5>Wastage</h5>
                      </div>
                    </div>
                    <canvas id="wastage"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 mt-4">
              <div class="row">
                <h4 class="nunito col-md-12 border-top border-bottom pt-2 pb-2">Donor Related</h4>
                <div class="col-md-6 mx-auto">
                  <div class="card card-body">
                    <div class="row mb-4">
                      <div class="col-md-6">
                        <h5>Count of donors per blood type</h5>
                      </div>
                    </div>
                    <canvas id="donorcountperbloodtype"></canvas>
                  </div>
                </div>
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
  <script type="text/javascript" src="js/realtime-connection.js"></script>
  <script type="text/javascript" src="js/Chart.bundle.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <script type="text/javascript">
  //add active class to current tab
  $('#graphstab').addClass("active");
  $(function(){
    check_expiringbloodbags();

    function check_expiringbloodbags(){
      $.ajax({
        type: "POST",
        url: "blood-related/check_expiringbloodbags.php",
        complete: function(){
          setTimeout(check_expiringbloodbags, 60000);
        }
      });
    }
  });

  //CHART DECLARATION
  bloodbagcountperbloodtype();
  wastage();
  donorcountperbloodtype();

  function bloodbagcountperbloodtype(){
    var chart_bloodbagcountperbloodtype = document.getElementById("bloodbagcountperbloodtype").getContext('2d');
    var ch_bloodbagcountperbloodtype = new Chart(chart_bloodbagcountperbloodtype, {
      type: 'bar',
      data: {
        labels: ["A", "AB", "B", "O"],
        datasets: [{
          label: '# of Remaining Blood Bags',
          data: ["<?php echo $countbloodbagtypea ?>", "<?php echo $countbloodbagtypeab ?>", "<?php echo $countbloodbagtypeb ?>", "<?php echo $countbloodbagtypeo ?>"],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true
            }
          }]
        }
      }
    });
  }

  function wastage(){
    var chart_wastage = document.getElementById("wastage").getContext('2d');
    var ch_wastage = new Chart(chart_wastage, {
      type: 'pie',
      data: {
        labels: ["Remaining blood bags", "Wasted"],
        datasets: [{
          label: 'Wastage',
          data: [ <?php echo json_encode($total_bloodbags) ?>, <?php echo json_encode($wasted_bloodbags) ?> ],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      }
    });
  }

  function donorcountperbloodtype(){
    var chart_donorcountperbloodtype = document.getElementById("donorcountperbloodtype").getContext('2d');
    var ch_wastage = new Chart(chart_donorcountperbloodtype, {
      type: 'bar',
      data: {
        labels: ["A", "AB", "B", "O"],
        datasets: [{
          label: '# of Donors',
          data: [ "<?php echo $countdonortypea ?>", "<?php echo $countdonortypeab ?>","<?php echo $countdonortypeb ?>","<?php echo $countdonortypeo ?>", ],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true
            }
          }]
        }
      }
    });
  }
  </script>
</body>
</html>
