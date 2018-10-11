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
      <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Queries</h5>
    </div>
    <!-- SIDE NAVIGATION -->
    <?php
      include "employeeSidebar.php";
    ?>
    <!-- END OF SIDE NAVIGATION -->

    <div class="col-md-10 offset-md-2">
      <div class="content-container">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class = "form-group col-md-3">
                <label for="choose_bloodtype">Blood Type</label>
                <select class = 'form-control' name = "choose_bloodtype" id = "choose_bloodtype">
                  <option selected disabled value = ''>Select blood type</option>
                  <?php
                  include("connections.php");

                  $fetch_bloodtype = mysqli_query($connections, " SELECT * FROM tblbloodtype WHERE stfBloodTypeStatus = 'Active'");

                  if(mysqli_num_rows($fetch_bloodtype) > 0 ){
                    while($row = mysqli_fetch_assoc($fetch_bloodtype)){
                      $blood_typeid = $row["intBloodTypeId"];
                      $blood_type = $row["stfBloodType"];
                      $rhesus = $row["stfBloodTypeRhesus"];
                      ?>
                      <option value="<?php echo $blood_typeid ?>"><?php echo $blood_type." ".$rhesus ?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class = "form-group col-md-3">
                <label for="choose_storage">Blood Storage</label>
                <select class = 'form-control' name = "choose_storage" id = "choose_storage">
                  <option selected disabled value = ''>Select storage</option>
                  <?php
                  include("connections.php");

                  $fetch_storage = mysqli_query($connections, " SELECT * FROM tblstorage WHERE stfStorageStatus = 'Active'");

                  if(mysqli_num_rows($fetch_storage) > 0 ){
                    while($row2 = mysqli_fetch_assoc($fetch_storage)){
                      $storageid = $row2["intStorageId"];
                      $storage = $row2["strStorageName"];

                      ?>
                      <option value="<?php echo $storageid ?>"><?php echo $storage ?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class = "form-group col-md-3">
                <label for="choose_volume">Blood Volume</label>
                <select class = 'form-control' name = "choose_volume" id = "choose_volume">
                  <option selected disabled value = ''>Select blood volume</option>
                  <?php
                  include("connections.php");

                  $fetch_volume = mysqli_query($connections, " SELECT * FROM tblbloodvolume WHERE stfBloodVolumeStatus = 'Active'");

                  if(mysqli_num_rows($fetch_volume) > 0 ){
                    while($row3 = mysqli_fetch_assoc($fetch_volume)){
                      $volumeId = $row3["intBloodVolumeId"];
                      $volume = $row3["intBloodVolume"];

                      ?>
                      <option value="<?php echo $volumeId ?>"><?php echo $volume ?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class = "form-group col-md-3">
                <label for="choose_preservative">Preservative</label>
                <select class = 'form-control' name = "choose_preservative" id = "choose_preservative">
                  <option selected disabled value = ''>Select preservative</option>
                  <?php
                  include("connections.php");

                  $fetch_preservative = mysqli_query($connections, " SELECT * FROM tblpreservatives WHERE stfPreservativeStatus = 'Active'");

                  if(mysqli_num_rows($fetch_preservative) > 0 ){
                    while($row4 = mysqli_fetch_assoc($fetch_preservative)){
                      $preservativeId = $row4["intPreservativeId"];
                      $preservative = $row4["txtPreservative"];

                      ?>
                      <option value="<?php echo $preservativeId ?>"><?php echo $preservative ?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <button type="button" class = 'btn btn-outline-danger float-right' id = 'executequery'>Go</button>
          </div>
        </div>
      </div>
    </div>

    <!--<div class="col-md-10 offset-md-2">
      <div class="content-container">
        <h2 class="border-bottom">Blood Bag</h2>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-bordered text-center" style="width:100%" id = "tblquery">
              <thead>
                <tr>
                  <th>Blood bag Serial</th>
                  <th>Blood Type</th>
                  <th>Blood Volume</th>
                  <th>Blood Storage</th>
                  <th>Preservative</th>
                  <th>Days in Storage</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>-->

    <div class="col-md-10 offset-md-2">
      <div class="content-container">
        <h2 class="border-bottom">Blood Bag</h2>
        <div class="row">
          <div class="col-md-12">
            <div id ='tblquery'>
              
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
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/bloodcomponent-tab.js"></script>
<script type="text/javascript" src="js/notification.js"></script>
<script type="text/javascript" src="js/waves.min.js"></script>
<script type="text/javascript" src="js/queries-tab.js"></script>
</body>
</html>
