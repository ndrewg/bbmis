<?php

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
      $datenow = date('Y-m-d');
    ?>
    <!-- END OF SIDE NAVIGATION -->
    <div class="col-md-10 offset-md-2">
      <div class="content-container">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group float-right">
                <form id = "daterange" name = "daterange">
                <label>From:</label>
                <input type = "date" name="from_range" id = "from_range" class = "form-control-inline" value="<?php echo $datenow ?>">
                <label class="ml-3">To:</label>
                <input type="date" name="to_range" id="to_range" class="form-control-inline" value="<?php echo $datenow ?>">
                <button type "button" class ="btn form-control-inline">Go</button>
                </form>
              </div>
            </div>
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
                </thead>-->
                <div id ="reports" class="row">
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
<script type="text/javascript" src="js/notification.js"></script>
<script type="text/javascript">
  $("#reportstab").addClass("active");
  $(document).on("click","#btn_genpdf", function(e){
    window.location.href = "genReportsPdf.php";
  });

var formdata = $("form[name='daterange']").serialize();
console.log(formdata);
  $.ajax({
    url: "fetch_reports.php",
    type: "POST",
    data:{formdata:formdata},
    success:function(data){
      $("#reports").html(data);
    }
  });

  $(document).on("submit","form[name='daterange']",function(e){
    e.preventDefault();
    var formdata = $("form[name='daterange']").serialize();
    $.ajax({
      url: "fetch_reports.php",
      type: "POST",
      data:{formdata:formdata},
      success:function(data){
        console.log(data);
        $("#reports").html(data);
      }
    });
  });
</script>
</body>
</html>
