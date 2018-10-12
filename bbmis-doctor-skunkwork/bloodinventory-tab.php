<?php
include("connections.php");
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
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/jquery-confirm.min.css">
  <link rel="stylesheet" href="css/waves.min.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 fixed-top offset-md-2 header">
        <?php
        include "fetchEmpAcc.php";
        include "employeeNavbar.php";
        ?>
        <h5 class="tab-title">Inventory</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
      include "employeeSidebar.php";
      ?>
      <!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container pb-5 animated fadeIn fast" >
          <h4 class="mb-3 nunito">Storage</h4>
          <div class="button-container" >
            <?php
            $fetch_allstorage = mysqli_query($connections, " SELECT * FROM tblstorage ts JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId ");
            $output =
            "
            <div class='row'>
            ";
            if (mysqli_num_rows($fetch_allstorage) > 0) {
              while($row = mysqli_fetch_assoc($fetch_allstorage)){
                $storage_id = $row["intStorageId"];
                $storage_name = $row["strStorageName"];
                $storage_type = $row["strStorageType"];
                $output .=
                "
                <div class='col-md-4'>
                <button type='button' onclick='window.location.href=\"bloodinventory-tab-selectedstorage.php?storage_id=$storage_id\"' class='btn btn-lg btn-block storage-buttons mt-2' id=$storage_id><i class='fas fa-box-open'></i> $storage_name<br><small>$storage_type</small></button>
                </div>
                ";
              }
              $output .= "</div>";
              echo $output;
            }
            else {
              echo "No active storage";
            }
            ?>
          </div>
          <button type="button" class="btn btn-outline-danger float-right" id="btn_addbloodbag" data-toggle="modal" data-target="#modal_addbloodbag"><i class="fas fa-plus"></i> Add Blood Bag</button>
          <button type="button" class="btn btn-outline-danger float-right mr-2" id="btn_importbloodbags" data-toggle="modal" data-target="#modal_importbloodbag"><i class="fas fa-plus"></i> Import Blood Bags</button>
        </div>
        <div class="content-container animated fadeIn fast" style="margin-top: -20px">
          <h4 class="mb-3 nunito">Released Blood Bags</h4>
          <div class="container-fluid" id="tbl_releasedbloodbags">

          </div>
        </div>
        <div class="content-container animated fadeIn fast" style="margin-top: -20px">
          <h4 class="nunito mb-3">Rotten Blood Bag</h4>
          <div class="container-fluid" id="tbl_rottenbloodbags">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end of page content -->
<!-- modal declaration -->
<!-- add blood bag modal -->
<div class="modal fade" id="modal_addbloodbag" role="dialog" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addbloodheader">Add Blood Bag</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form method="post" id="addbloodbag" name="addbloodbag">
            <div class="form-group">
              <label for="bloodserial">Blood Bag Serial</label>
              <input type="text" class="form-control" placeholder="Enter serial number" id="bloodserial" name="bloodserial" required>
            </div>
          <!--  <div class="form-group">
              <label for="bloodvolume">Volume</label>
              <select class="form-control" name="bloodvolume" id="bloodvolume" required="required">
                <option value="450cc">450 cubic centimeter</option>
                <option value="250cc">250 cubic centimeter</option>
              </select>
            </div>-->
            <div class="form-group">
              <label for="chosenStorage">Choose a Storage</label>
              <select class="form-control" name="chosenStorage" id="chosenStorage" required>
              <?php

              $fetch_storage = mysqli_query($connections, " SELECT intStorageId,intStorageCapacity,strStorageName FROM tblstorage WHERE intStorageTypeId = 1 AND stfStorageStatus = 'Active'");

              if(mysqli_num_rows($fetch_storage) > 0 ){
                while($row = mysqli_fetch_assoc($fetch_storage)){
                  $storageid = $row["intStorageId"];
                  $storagename = $row["strStorageName"];
                  $storagecapacity = $row["intStorageCapacity"];

                  $check_ifmayspacepa = mysqli_query($connections,"SELECT COUNT(intBloodBagId) AS bloodcount FROM tblbloodbag bb JOIN tblstorage s ON bb.intStorageId = s.intStorageId WHERE intBloodDispatchmentId = '1' AND stfIsBloodBagExpired = 'No' AND intStorageTypeId = 2 AND s.intStorageId = $storageid");

                  while ($row2 = mysqli_fetch_assoc($check_ifmayspacepa)) {
                    $quantity = $row2["bloodcount"];
                  }

                  if($quantity < $storagecapacity){
                  ?>
                  <option value="<?php echo $storageid ?>"><?php echo $storagename ?></option>
                  <?php
                }

                }
              }
              ?>
            </select>
            </div>

            <div class="form-group">
              <label for="chosenPreservative">Choose a Preservative</label>
              <select class="form-control" name="chosenPreservative" id="chosenPreservative" required>
              <?php

              $fetch_preservative = mysqli_query($connections, " SELECT intPreservativeId, txtPreservative, intPreservativeLifespan FROM tblpreservatives WHERE stfPreservativeStatus = 'Active'");

              if(mysqli_num_rows($fetch_preservative) > 0 ){
                while($pres = mysqli_fetch_assoc($fetch_preservative)){
                  $preservativeid = $pres["intPreservativeId"];
                  $preservative = $pres["txtPreservative"];
                  $preservativelifespan = $pres["intPreservativeLifespan"];

                  ?>

                  <option value="<?php echo $preservativeid ?>"><?php echo $preservative.' = '.$preservativelifespan.' days' ?></option>

                  <?php
                }
              }
              ?>
            </select>
            </div>

            <div class="form-group">
              <label for="bloodtype">Blood Type :</label>

              <label id='bloodtype'>
              </div>
              <div class="form-group">
                <label for="blooddonor">Donor</label>
                <input type="text" class="form-control" placeholder="Enter the first name of the donor" id="blooddonor" name="donorname" autocomplete="off" required>
                <div class="result"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" name="savebloodbag">
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end modal add blood bag -->
  <!-- import data thru csv file -->
  <div class="modal fade" id="modal_importbloodbag" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Import Blood Bags</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form method="post" name="form_importbloodbag">
          <div class="modal-body">
            <div class="form-group">
              <label></label>
              <input type="file" class="form-controle-file" id="bloodbagcsv" name="bloodbagcsv">
              <small class="form-text text-muted">
                Only .csv files are allowed. Other type of spreadsheet files is not accepted
              </small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
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
  <script type="text/javascript" src="js/inventory-tab.js"></script>
  <script type="text/javascript" src="js/waves.min.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    //add active class to current tab
    $('#bloodinventorytab').addClass("active");

    //functions
    fetchreleasedbloodbags();
    fetchrottenbloodbags();
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
    // fetch released bloodbags
    function fetchreleasedbloodbags(){
      $.ajax({
        url: "blood-related/fetch_releasedbloodbags.php",
        success: function(data){
          $('#tbl_releasedbloodbags').html(data);
        },
        complete: function(){
          setTimeout(fetchreleasedbloodbags,5000);
        }
      });
    }

    function fetchrottenbloodbags(){
      $.ajax({
        url: "blood-related/fetch_expiredbloodbag.php",
        success: function(data){
          $('#tbl_rottenbloodbags').html(data);
        },
        complete: function(){
          setTimeout(fetchrottenbloodbags,5000);
        }
      });
    }
  });

  $(document).on("submit", "form[name='addbloodbag']", function(e){
    e.preventDefault();
    var formdata = $(this).serialize();
    var confirm_input = confirm("Are you sure?");
    console.log(formdata);

    if(confirm_input == true)
    {
      $.ajax({
        url: "blood-related/insert_bloodbagrecord.php",
        method: "POST",
        data: {formdata,formdata},
        success: function(data){
          console.log(data);
          if (data == '1'){
            alert('Insert Succesful.');
            console.log(data);
            $(".modal-body input").val("");
            $(".modal-body select").val("");
            $('#addbloodmodal').modal("hide");
            $('#bloodtype').text("");
          }
          else if (data == '2'){
            alert('Donor has undefined bloodtype. Please update his/her record.');
          }
          else if (data == '3'){
            alert('Please check the donor serialno because there is already a bloodbag with the same serial.');
          }
          else if(data == '4'){
            alert('Please check the donor name, Because the donor already has a blood bag in the record.');
          }
          else if(data == '5'){
            alert('Donor not found. Please register the donor first.');
          }
          else if(data == '6'){
            alert('Donor has no current transaction');
          }
          else if(data == '7'){
            alert('Donor has no Blood Volume');
          }
          else if(data == '8'){
            alert('Cannot insert to storage. Storage Full.');
          }
          else if(data == '9'){
            alert('Please fill out all the fields.');
          }
          else if(data =='10') {
            alert('Storage full!');
          }
        }//success
      });
    }//end of if confirm_input
    else{
      alert("Confirmation Cancelled.");
      return false;
    }
  });

  $(document).on("keyup", "#blooddonor", function(e){
    /* Get input value on change */
    var inputVal = $(this).val();
    var resultDropdown = $(this).siblings(".result");

    console.log(inputVal);
    if(inputVal.length){
      $.get("blood-related/backend-search.php", {term: inputVal}).done(function(data){
        // Display the returned data in browser
        resultDropdown.html(data);
      });
    } else{
      resultDropdown.empty();
    }
  });

  $(document).on("click", ".result p", function(){
    $(this).parents("#modal_addbloodbag").find('#blooddonor').val($(this).text());
    var donor = $(this).text();
    $(this).parent(".result").empty();

    $.ajax({
      url:"blood-related/fetch_donorbloodtype.php",
      type:"POST",
      data:'donor=' + donor,
      dataType: "json",
      success: function(data){
        console.log(data);
        $('#bloodtype').text(data.stfBloodType);
        $('#bloodtype').append(" ");
        $('#bloodtype').append(data.stfBloodTypeRhesus);
        console.log(data.stfBloodType);
      }
    });
  });
  $(document).on("submit", "form[name='form_importbloodbag']", function(e){
    e.preventDefault();
    // var form = $("form[name='form_importbloodbag']")[0];
    // var formdata = new FormData(this);
    $.ajax({
      type: "POST",
      url: "blood-related/import_bloodbagrecords.php",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(data){
        console.log(data);
      }
    });
  });
  //file validation
  $(document).on("change", "#bloodbagcsv", function(){
    var file = this.files[0];
    console.log(file);
    var csvfile = file.type;
    var match= ["application/vnd.ms-excel"];
    if(!((csvfile==match[0]) || (csvfile==match[1]) || (csvfile==match[2]))){
      swal('','Please select a valid csv file','warning');
      $("#bloodbagcsv").val('');
      return false;
    }
  });
  </script>
</body>
</html>
