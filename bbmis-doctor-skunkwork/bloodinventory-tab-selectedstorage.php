<?php
include("connections.php");

if($_GET["storage_id"]){
  $storage_id = $_GET["storage_id"];

  $fetch_storagedetails = mysqli_query($connections, " SELECT * FROM tblstorage ts JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId WHERE intStorageId = $storage_id");
  while($row = mysqli_fetch_assoc($fetch_storagedetails)){
    $storage_name = $row["strStorageName"];
    $storage_type = $row["strStorageType"];
  }
  $countallbloodbags = mysqli_query($connections, " SELECT COUNT(strBloodBagSerialNo) as totalnum FROM tblbloodbag WHERE  DATEDIFF(NOW(), dtmDateStored) <= 35 AND intStorageId = $storage_id AND stfIsBloodBagExpired = 'No' AND intBloodTypeId <> 1 "); //count all blood bags
  $countstoragecapacity = mysqli_query($connections, " SELECT intStorageCapacity FROM tblstorage WHERE intStorageId = $storage_id "); // get the capacity of the storage
  $rowcountbb = mysqli_fetch_assoc($countallbloodbags);
  $rowcountcap = mysqli_fetch_assoc($countstoragecapacity);
  $totalbloodbags = $rowcountbb['totalnum'];
  $storagecap = $rowcountcap['intStorageCapacity'];
  settype($totalbloodbags, "int");
  settype($storagecap, "int");
  $criticallevel = $storagecap * .8;
  settype($criticallevel, "int");
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
        <div class="content-container">
          <button type="button" class="btn" onclick="location.href='bloodinventory-tab.php'"><i class="fas fa-long-arrow-alt-left"></i> Back to Storage</button>
          <!-- legend -->
          <div class="float-right mt-3">
            <ul class="float-right legend nunito">
              <li><span class="fresh"></span>Fresh</li>
              <li><span class="stillgood"></span>Still Good</li>
              <li><span class="almostrotten"></span>Almost Rotten</li>
              <li class="mr-3">Legend:</li>
            </ul>
          </div>
          <!-- end legend -->
          <div class="border-bottom mt-3">
            <h5 class="nunito"><?php echo $storage_name ?></h5>
            <p><small style="color:rgb(150,150,150)">Capacity: <strong id='total'></strong>/<?php echo $storagecap ?>  <strong id='warningmessage' style="color:red"></strong></small></p>
            <div class="container-fluid mt-3">
              <div class="row">
                <!-- blood type a -->
                <div class="div_bloodtypea col-md-12">
                  <!-- GET BLOOD BAGS THAT BELONG TO BLOOD GROUP A -->
                </div>
                <!-- blood type b -->
                <div class="div_bloodtypeb col-md-12 mt-4">
                  <!-- GET BLOOD BAGS THAT BELONG TO BLOOD GROUP B -->
                </div>
                <!-- blood type ab -->
                <div class="div_bloodtypeab col-md-12 mt-4">
                  <!-- GET BLOOD BAGS THAT BELONG TO BLOOD GROUP AB -->
                </div>
                <!-- blood type o -->
                <div class="div_bloodtypeo col-md-12 mt-4">
                  <!-- GET BLOOD BAGS THAT BELONG TO BLOOD GROUP O -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end of page content -->
  <!-- modal declaration -->
  <!-- blood bag details -->
  <div class="modal fade" id="modal_selectedstorage" tabindex="-1" role="dialog" aria-labelledby="Selected Storage" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Blood Bag Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="form-group">
              <label for="serialno">Serial Number: </label>
              <input type="text" class="form-control" id="serialno" readonly>
              <!-- <label id="serialno"></label><br> -->
            </div>
            <div class="form-group">
              <label for="bloodtype">Blood Type: </label>
              <input type="text" class="form-control" id="bloodtype" readonly>
              <!-- <label id="bloodtype"></label><br> -->
            </div>
            <div class="form-group">
              <label for="volume">Blood Volume (measured in cubic centimeter): </label>
              <input type="text" class="form-control" id="volume" readonly>
              <!-- <label id="volume"></label> -->
            </div>
            <div class="form-group">
              <label for="preservative">Preservative Used: </label>
              <input type="text" class="form-control" id="preservative" readonly>
            </div>
            <div class="form-group">
              <label for="daysinstorage">Days in Storage: </label>
              <input type="text" class="form-control" id="daysinstorage" readonly>
              <!-- <label id="daysremaining"></label><br> -->
            </div>
            <div class="form-group">
              <label for="daysremaining">Days Remaining: </label>
              <input type="text" class="form-control" id="daysremaining" readonly>
            </div>
            <div class="form-group">
              <label for="daysinstorage">Expected Date of Rot: </label>
              <input type="text" class="form-control" id="dateofexpiration" readonly>
              <!-- <label id="daysinstorage"></label><br> -->
            </div>
            <label for="donorfullname">Donor Name: </label>
            <input type="text" class="form-control" id="donorfullname" readonly>
            <input type="hidden" name="hidden_donorid">
            <input type="hidden" name="hidden_latestdonationid">
            <!-- <label id="donorfullname"></label><br> -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" id="btn_movetostocked" data-toggle="modal" data-target="#mdl_movetostocked"><i class="fas fa-layer-group"></i> Stock</button>
          <!-- move to quarantine -->
          <button type="button" class="btn" id="btn_movetoquarantine" data-toggle="modal" data-target="#mdl_movetoquarantine"><img src="css/glyphicon/si-glyph-shield-plus.svg" style="height: 22px; width:22px"> Quarantine</button>
          <!-- release blood bag -->
          <button type="button" class="btn" id="btn_release" data-toggle="modal" data-target="#modal_reasonfordispatchment"><img src="css/glyphicon/si-glyph-bag-remove.svg" style="height: 22px; width: 22px;"> Release</button>
          <!-- crossmatch = means this blood bag is compatible with the receiver -->
          <button type="button" class="btn" id="btn_movetocrossmatch" data-toggle="modal" data-target="#mdl_movetocrossmatch"><img src="css/glyphicon/si-glyph-person-checked.svg" style="height: 22px; width: 22px;"> Crossmatch</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end of blood bag details modal -->
  <!-- reason for release modal -->
  <div class="modal fade" id="modal_reasonfordispatchment" tabindex="-1" role="dialog" aria-labelledby="reasonfordispatchment" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reason for Releasing the Blood Bag</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" name="reasonfordispatchment">
            <div class="form-group">
              <input type="hidden" name="hiddenserial" id="hiddenserial">
            </div>
            <div class="form-check" id="div_forpatient">
              <input type="radio" class="form-check-input" name="rbtn_reason" id="forpatient" value="For Patient Use">
              <label for="forpatient" class="form-check-label">
                For Patient Use
              </label>
            </div>
            <div class="form-check" id="div_lab">
              <input type="radio" class="form-check-input" name="rbtn_reason" id="forlab" value="For laboratory Use">
              <label for="forlab" class="form-check-label">
                For Laboratory Use
              </label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" name="rbtn_reason" id="rbtn_otherreason">
              <label for="otherreason" class="form-check-label">
                Others
              </label>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="otherreason" id="otherreason" readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn" id="btn_actualrelease"><img src="css/glyphicon/si-glyph-bag-remove.svg" style="height: 22px; width: 22px;"> Release</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- end of reason for release modal -->
  <!-- move to quarantine -->
  <div class="modal fade" id="mdl_movetoquarantine" tabindex="-1" role="dialog" aria-labelledby="Quarantine" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Move to Quarantine</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Select Quarantine Storage</label><br>
            <form name="underq_hiddeninputs" method="post">
              <input type="hidden" name="hidden_underqserialno" id="hidden_underqserialno">
              <input type="hidden" name="hidden_storageid" id="hidden_storageid">
            </form>
            <?php
            $fetch_underquarantinestorages = mysqli_query($connections, " SELECT * FROM tblstorage ts JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId WHERE strStorageType = 'Under Quarantine' ");

            if (mysqli_num_rows($fetch_underquarantinestorages) > 0 ){
              $output = "";
              while($row = mysqli_fetch_assoc($fetch_underquarantinestorages)){
                $underqstg_name = $row["strStorageName"];
                $underqstg_id = $row["intStorageId"];

                $output = "
                <button type='button' class='btn p-3 btn_quarantinestg' data-id=$underqstg_id><i class='fa fa-box-open fa-5x'></i><br><strong>$underqstg_name</strong></button>
                ";
              }
              echo $output;
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end move to quarantine -->
  <!-- move to stocked storage  -->
  <div class="modal fade" id="mdl_movetostocked" tabindex="-1" role="dialog" aria-labelledby="Stocked" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Move to Stocked</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Select Stocked Storage</label><br>
            <form name="stocked_hiddeninputs" method="post">
              <input type="hidden" name="hidden_stockedserialno" id="hidden_stockedserialno">
              <input type="hidden" name="hidden_stockedstorageid" id="hidden_stockedstorageid">
            </form>
            <?php
            $fetch_stockedstorages = mysqli_query($connections, " SELECT * FROM tblstorage ts JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId WHERE strStorageType = 'Stocked' ");
            if (mysqli_num_rows($fetch_stockedstorages) > 0) {
              $output = "";
              while ($row = mysqli_fetch_assoc($fetch_stockedstorages)) {
                $stockedstg_name = $row["strStorageName"];
                $stockedstg_id = $row["intStorageId"];

                $output .= "
                <button type='button' class='btn p-3 btn_stockedstg' data-id=$stockedstg_id><i class='fas fa-box-open fa-5x'></i><br><strong>$stockedstg_name</strong></button>
                ";
              }
              echo $output;
            }
             ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end modal move to stocked -->
  <!-- move to crossmatch  -->
  <div class="modal fade" id="mdl_movetocrossmatch" tabindex="-1" role="dialog" aria-labelledby="Crossmatch" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Move to Crossmatch</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Select Crossmatch Storage</label><br>
            <form name="crossmatched_hiddeninputs" method="post">
              <input type="hidden" name="hidden_crossmatchedserialno" id="hidden_crossmatchedserialno">
              <input type="hidden" name="hidden_crossmatchedstorageid" id="hidden_crossmatchedstorageid">
            </form>
            <?php
            $fetch_crossmatchedstorages = mysqli_query($connections, " SELECT * FROM tblstorage ts JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId WHERE strStorageType = 'Crossmatched' ");

            if(mysqli_num_rows($fetch_crossmatchedstorages) > 0){
              $output = "";
              while($row = mysqli_fetch_assoc($fetch_crossmatchedstorages)){
                $crossmatchedstg_name = $row["strStorageName"];
                $crossmatchedstg_id = $row["intStorageId"];

                $output .= "
                <button type='button' class='btn p-3 btn_crossmatchedstg' data-id=$crossmatchedstg_id><i class='fas fa-box-open fa-5x'></i><br><strong>$crossmatchedstg_name</strong></button>
                ";
              }
              echo $output;
            }
             ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- scripts and plugins -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
  <script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/realtime-connection.js"></script>
  <script type="text/javascript" src="js/inventory-tab.js"></script>
  <script type="text/javascript" src="js/waves.min.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript">
  //add active class to current tab
  $('#bloodinventorytab').addClass("active");

  //initialize ripple fx
  Waves.attach('button');
  Waves.init();

  //execute functions on load
  $(document).ready(function(){
    let storage_id = <?php echo $storage_id ?>;
    let storage_type = "<?php echo $storage_type ?>";

    if(storage_type == 'Under Quarantine'){
      $('#btn_movetoquarantine').hide();
      $('#div_forpatient').hide();
      $('#div_lab').hide();
    }
    else if (storage_type == 'Stocked') {
      $('#btn_movetostocked').hide();
    }
    else if (storage_type == 'Crossmatched'){
      $('#btn_movetocrossmatch').hide();
    }

    fetchbloodbagtypea();
    fetchbloodbagtypeab();
    fetchbloodbagtypeb();
    fetchbloodbagtypeo();
    counttotalbloodbags();

    //fetch type a blood bags
    function fetchbloodbagtypea(){
      $.ajax({
        url: "blood-related/fetch_bloodbagtypea.php",
        type: "POST",
        data: "storage_id=" + storage_id,
        success: function (data){
          $('.div_bloodtypea').html(data);
        }
      });
    }
    function fetchbloodbagtypeab(){
      $.ajax({
        url: "blood-related/fetch_bloodbagtypeab.php",
        type: "POST",
        data: "storage_id=" + storage_id,
        success: function (data){
          $('.div_bloodtypeab').html(data);
        }
      });
    }
    function fetchbloodbagtypeb(){
      $.ajax({
        url: "blood-related/fetch_bloodbagtypeb.php",
        type: "POST",
        data: "storage_id=" + storage_id,
        success: function (data){
          $('.div_bloodtypeb').html(data);
        }
      });
    }
    function fetchbloodbagtypeo(){
      $.ajax({
        url: "blood-related/fetch_bloodbagtypeo.php",
        type: "POST",
        data: "storage_id=" + storage_id,
        success: function (data){
          $('.div_bloodtypeo').html(data);
        }
      });
    }
    // some maths
    function counttotalbloodbags() {
      var totalbloodbags = <?php echo $totalbloodbags ?>;
      var storagecap = <?php echo $storagecap ?>;
      var criticallevel = <?php echo $criticallevel ?>;
      console.log(storagecap);
      console.log(totalbloodbags);
      console.log(criticallevel);
      if (totalbloodbags >= criticallevel && totalbloodbags != storagecap){
        $('#total').css("color","red");
        $('#total').text(totalbloodbags);
        $('#warningmessage').text("Inventory almost full!");
      }
      else if (totalbloodbags == storagecap){
        $('#total').css("color","red");
        $('#total').text(totalbloodbags);
        $('#warningmessage').text("Inventory full!");
      }
      else {
        $('#total').text(totalbloodbags);
      }
    }
    setTimeout(counttotalbloodbags,5000);
  });
  // fetch blood bag info
  $(document).on('show.bs.modal', '#modal_selectedstorage', function (e) {
    var serialno = $(e.relatedTarget).data("id");
    console.log(serialno);

    $.ajax({
      method: "POST",
      url: "blood-related/fetch_bloodbaginfo.php",
      data: "serialno=" + serialno,
      dataType: "json",
      success: function (data) {
        console.log(data);
        $('#donorfullname').val(data.strClientFirstName + " " + data.strClientMiddleName + " " + data.strClientLastName);
        if (data.daysinstorage == "1") {
          $('#daysinstorage').val(data.daysinstorage + " " + "day");
        }
        else if (data.daysinstorage > "1"){
          $('#daysinstorage').val(data.daysinstorage + " " + "days");
        }
        else if (data.daysinstorage == "0") {
          $('#daysinstorage').val(data.daysinstorage);
        }
        if (data.daysremaining == "1"){
          $('#daysremaining').val(data.daysremaining + " " + "day");
        }
        else if (data.daysremaining > "1") {
          $('#daysremaining').val(data.daysremaining + " " + "days");
        }
        $('#preservative').val(data.txtPreservative);
        $('#dateofexpiration').val(data.dateofexpiration);
        $('#serialno').val(data.strBloodBagSerialNo);
        $('#bloodtype').val(data.stfBloodType + " " + data.stfBloodTypeRhesus);
        $('#volume').val(data.intBloodVolume + " cc");
      }
    });
  });
  //transfer id to hidden input
  $(document).on("click", "#btn_release", function(){
    var serialno = $('#serialno').val();
    $('#hiddenserial').val(serialno);
  });
  //enable text field if other reason is selected
  $('input[name="rbtn_reason"]').change(function(){
    $('#otherreason').val("").attr('readonly', true);
    if($("#rbtn_otherreason").is(":checked")){
      $('#otherreason').removeAttr("readonly");
      $('#otherreason').focus();
    }
  });
  // hide reason for dispatchment modal
  $(document).on('show.bs.modal', '#modal_reasonfordispatchment', function(){
    $("#modal_selectedstorage").modal("hide");
    // $.ajax({
    //   type: "POST",
    //   url:,
    //   success: function(data){
    //
    //   }
    // });
  });
  //release blood bag
  $(document).on("click", "#btn_actualrelease", function(e){
    e.preventDefault();
    var formdata = $('form[name="reasonfordispatchment"]').serialize();
    console.log(formdata);
    // alert(formdata);

    swal({
      title: "Are you sure?",
      text: "This blood bag will be removed from the storage. 20 minutes before rot",
      icon: "warning",
      buttons: true
    })
    .then ((willApprove) => {
      if (willApprove) {
        $.ajax({
          method: "POST",
          url: "blood-related/release_bloodbag.php",
          data: {formdata, formdata},
          success: function(data){
            console.log(data);
            if (data == '1'){
              // swal("","For other reasons");
              swal({
                title: "",
                text: "Reason: For other reasons",
                icon: "success",
                buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  location.reload();
                }
              });
              // $('#modal_reasonfordispatchment').modal('hide');
            }
            else if (data == '2'){
              // swal("","For patient or for lab");
              swal({
                title: "",
                text: "Reason: For patient or for laboratory purposes",
                icon: "success",
                buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  location.reload();
                }
              });
              // $('#modal_reasonfordispatchment').modal('hide');
            }
            else if (data == '3'){
              swal("","Please enter reason!","info");
            }
          }
        });
      }
      else {
        swal("", "No action done!", "info");
      }
    });
  });
  //hide blood bag info on move to quarantine modal show
  $(document).on("show.bs.modal", "#mdl_movetoquarantine", function(e){
    $('#modal_selectedstorage').modal('hide');
  });
  //pass serialno to hidden input
  $(document).on("click", "#btn_movetoquarantine", function(e) {
    let underq_serialno = $('#serialno').val();
    console.log(underq_serialno);
    $('#hidden_underqserialno').val(underq_serialno);
  });
  //move to quarantine
  $(document).on("click", ".btn_quarantinestg", function(){
    let storage_id = $(this).attr("data-id");
    console.log(storage_id);
    $('#hidden_storageid').val(storage_id);
    let formdata = $('form[name="underq_hiddeninputs"]').serialize();
    console.log(formdata);

    swal({
      title: "Are you sure?",
      text: "This blood bag will be moved back to the quarantine.",
      icon: "warning",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove) {
        $.ajax({
          method: "POST",
          url: "blood-related/move_bloodbagtoquarantine.php",
          data: {formdata: formdata},
          success: function(data) {
            console.log(data);
            if (data == "1"){
              swal({
                title: "",
                text: "Blood bag successfully moved to quarantine",
                icon: "success",
                buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  $('#mdl_movetoquarantine').modal('hide');
                  location.reload();
                }
              });
            }
            else if (data == "2"){
              swal("","Blood bag doesn't have serological record yet!","error");
            }
            else if (data == "3"){
              swal("","Chosen storage is full!", "error");
            }
          }
        });
      }
      else {
        swal("","Cancelled!");
      }
    });
  });
  //hide blood bag info on move to stocked modal show
  $(document).on("show.bs.modal", "#mdl_movetostocked", function(e){
    $('#modal_selectedstorage').modal('hide');
  });
  //pass serialno to hidden input
  $(document).on("click", "#btn_movetostocked", function(e) {
    let stocked_serialno = $('#serialno').val();
    console.log(stocked_serialno);
    $('#hidden_stockedserialno').val(stocked_serialno);
  });
  //move to stocked
  $(document).on("click", ".btn_stockedstg", function(e){
    let storage_id = $(this).attr("data-id");
    console.log(storage_id);
    $('#hidden_stockedstorageid').val(storage_id);
    let formdata = $('form[name="stocked_hiddeninputs"]').serialize();
    console.log(formdata);

    swal({
      title: "Are you sure?",
      text: "This blood bag will be moved to the stocks.",
      icon: "warning",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove) {
        $.ajax({
          method: "POST",
          url: "blood-related/move_bloodbagtostocked.php",
          data: {formdata: formdata},
          success: function(data) {
            console.log(data);
            if (data == "1"){
              swal({
                title: "",
                text: "Blood bag successfully moved to stocked",
                icon: "success",
                buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  $('#mdl_movetostocked').modal('hide');
                  location.reload();
                }
              });
            }
            else if (data == "2") {
              swal("","Blood bag doesn't have serological record yet!","error");
            }
            else if (data == "3"){
              swal("","Chosen storage is full!", "error");
            }
          }
        });
      }
      else {
        swal("","Cancelled!");
      }
    });
  });
  //hide blood bag info on move to crossmatch modal show
  $(document).on("show.bs.modal", "#mdl_movetocrossmatch", function(e){
    $('#modal_selectedstorage').modal('hide');
  });
  //pass serialno to hidden input
  $(document).on("click", "#btn_movetocrossmatch", function(e) {
    let crossmatched_serialno = $('#serialno').val();
    console.log(crossmatched_serialno);
    $('#hidden_crossmatchedserialno').val(crossmatched_serialno);
  });
  //move to crossmatched
  $(document).on("click", ".btn_crossmatchedstg", function(e){
    let storage_id = $(this).attr("data-id");
    console.log(storage_id);
    $('#hidden_crossmatchedstorageid').val(storage_id);
    let formdata = $('form[name="crossmatched_hiddeninputs"]').serialize();
    console.log(formdata);

    swal({
      title: "Are you sure?",
      text: "This blood bag will be moved to the crossmatched.",
      icon: "warning",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove) {
        $.ajax({
          method: "POST",
          url: "blood-related/move_bloodbagtocrossmatched.php",
          data: {formdata: formdata},
          success: function(data) {
            console.log(data);
            if (data == "1"){
              swal({
                title: "",
                text: "Blood bag successfully moved to crossmatched",
                icon: "success",
                buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  $('#mdl_movetocrossmatch').modal('hide');
                  location.reload();
                }
              });
            }
            else if (data == "2") {
              swal("","Blood bag doesn't have serological record yet!","error");
            }
            else if (data == "3"){
              swal("","Chosen storage is full!", "error");
            }
          }
        });
      }
      else {
        swal("","Cancelled!");
      }
    });
  });
</script>
</body>
</html>
