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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Survey</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
      include "employeeSidebar.php";
      ?>
      <!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container" style="padding-bottom: 50px">
          <div id = "survey-list">
            <?php
            include("connections.php");

            $fetchsurveys = mysqli_query($connections,"SELECT DISTINCT(decQuestionVersion), boolVersionInUse
            FROM tblquestion GROUP BY decQuestionVersion ORDER BY decQuestionVersion ASC");
            ?>
            <h4 class="nunito">Available Surveys</h4>
            <table class='table table-bordered mt-5 text-center' id='tblsurvey'>
              <thead>
                <tr>
                  <th>Survey Version</th>
                  <th>In Use</th>
                  <th>Action</th>
                </tr>
              </thead>
              <?php
              while ($row = mysqli_fetch_assoc($fetchsurveys)) {
                $version = $row["decQuestionVersion"];
                $inuse = $row["boolVersionInUse"];

                if($inuse == '1'){
                  $inusetext = "Yes";
                }
                elseif ($inuse == '0') {
                  $inusetext = "No";
                }

                ?>
                <tbody>
                  <tr>
                    <td><?php echo $version; ?></td>
                    <td><?php echo $inusetext; ?></td>
                    <td><a href ="fetch_survey.php?selected=<?php echo $version; ?>"><button type='button' class='btn'  name = 'check_survey'>View</button></a></td>
                  </tr>
                </tbody>
              <?php }
              ?>
            </table>
          </div>
          <a href ="add_newsurvey.php"><button type = 'button' class='btn btn-outline-danger float-right mt-1' id = "make_survey" style="margin-top: -10px">Make a new Survey</button></a>
        </div>
        <!-- end -->

      </div>
    </div>
  </div>
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
  <script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="js/realtime-connection.js"></script>
  <script type="text/javascript" src="js/survey-tab.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <script type="text/javascript">
  //add active class to current tab
  $('#surveytab').addClass("active");
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
  </script>
</body>
</html>
