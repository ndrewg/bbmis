<?php
include("connections.php");
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
       <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Inventory</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
				include "employeeSidebar.php";
			?>
			<!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <div class="row">
            <div class="col-md-12 border-bottom border-top pt-2 pb-2">
              <h3 class="nunito">Blood Bags</h3>
              <div class="form-inline">
                <label class="mr-2">Sort by</label>
                <form method="post" name="frm_sortbloodbags">
                  <select class="form-control mr-1" name="sel_bloodtype" id="sel_bloodtype">
                    <option selected disabled>Blood Type</option>
                    <?php
                    $fetch_bloodtypes = mysqli_query($connections, " SELECT DISTINCT(stfBloodType) FROM tblbloodtype WHERE intBloodTypeId <> 1 AND stfBloodTypeStatus = 'Active' ");
                    while($row = mysqli_fetch_assoc($fetch_bloodtypes)){
                    	$bloodtype = $row["stfBloodType"];
                    ?>
                    <option value="<?php echo $bloodtype?>"><?php echo $bloodtype ?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <select class="form-control mr-1" name="sel_storagetype" id="sel_storagetype">
                    <option selected disabled>Storage Type</option>
                    <?php
                    $fetch_storagetypes = mysqli_query($connections, " SELECT strStorageType FROM tblstoragetype");
                    while($row = mysqli_fetch_assoc($fetch_storagetypes)){
                      $storagetype = $row["strStorageType"];
                      ?>
                      <option value="<?php echo $storagetype ?>"><?php echo $storagetype ?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <select class="form-control mr-1" name="sel_amount" id="sel_amount">
                    <option selected disabled>Amount</option>
                    <?php
                    $fetch_bloodvolume = mysqli_query($connections, " SELECT * FROM tblbloodvolume WHERE stfBloodVolumeStatus = 'Active' ");
                    while($row = mysqli_fetch_assoc($fetch_bloodvolume)){
                      $volume = $row["intBloodVolume"];
                     ?>
                     <option value="<?php echo $volume ?>"><?php echo $volume ?>cc</option>
                     <?php
                    }
                    ?>
                  </select>
                </form>
              </div>
              <button type="button" name="btn_sort" id="btn_sort" class="btn btn-outline-danger float-right"><i class="fas fa-print"></i> Generate Reports</button>
            </div>
          </div>
          <div id="div_sortedbloodbags">

          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
  <script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/waves.min.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript">
  $(document).on("change","#sel_bloodtype", function(e){
    bloodtype = $(this).val();
    console.log(bloodtype);
    $.ajax({
      type: "POST",
      url: "blood-related/fetch_sortedbloodbags.php",
      data: "bloodtype=" + bloodtype,
      success: function(data){
        console.log(data);
        $('#div_sortedbloodbags').html(data);
      }
    });
  });
  $(document).on("change","#sel_storagetype", function(e){
    storagetype = $(this).val();
    console.log(storagetype);
  });
  $(document).on("change","#sel_amount", function(e){
    amount = $(this).val();
    console.log(amount);
  });
  </script>
</body>
</html>
