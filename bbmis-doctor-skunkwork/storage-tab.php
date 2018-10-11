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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Storage</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
      include "employeeSidebar.php";
      ?>
      <!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <h4 style="font-family: 'Nunito-Regular'">Active Storage</h4>
          <div class="container-fluid pb-4">
            <table id="tbl_activestorage" class="table table-striped table-bordered text-center" style="width: 100%">
              <thead>
                <tr>
                  <th>Storage Name</th>
                  <th>Storage Type</th>
                  <th>Capacity</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
            <button type="button" class="btn btn-outline-danger float-right mt-2" data-toggle="modal" data-target="#addBloodStorageModal"><i class="fas fa-plus"></i> Add Storage</button>
          </div>
        </div>
        <div class="content-container" style="margin-top: -15px">
          <h4 style="font-family:'Nunito-Regular'">Disabled Blood Storages</h4>
          <div class="container-fluid">
            <table id="tbl_inactivestorage" class="table table-striped table-bordered text-center" style="width: 100%">
              <thead>
                <tr>
                  <th>Storage Name</th>
                  <th>Storage Type</th>
                  <th>Capacity</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end content -->
  <!-- modals -->
  <!--Add Storage Modal-->
  <div class="modal fade" id="addBloodStorageModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addnewbloodstorageTitle">Add Blood Storage</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="addnewbloodstorage.php" name="form_addnewbloodstorage">
          <div class="modal-body">
            <div class="form-group">
              <label for="newBloodStorageName">Storage Name</label>
              <input type="text" class="form-control" id='newBloodStorageName' name ='newBloodStorageName' required>
            </div>
            <div class="form-group">
              <label>Storage Type</label>
              <select class="form-control" name="sel_storagetype">
                <option selected disabled>Select storage type</option>
              <?php
              $fetch_storagetype = mysqli_query($connections, " SELECT * FROM tblstoragetype ");

              if(mysqli_num_rows($fetch_storagetype) > 0){
                while ($row = mysqli_fetch_assoc($fetch_storagetype)) {
                  $storagetype = $row["strStorageType"];
                  ?>
                <?php
                echo "<option value='".$storagetype."'>$storagetype</option>";
                 ?>
              <?php
            }
          }
               ?>
             </select>

            </div>
            <div class="form-group">
              <label for="newBloodStorageCapacity">Storage Capacity</label>
              <input type="number" class="form-control" id='newBloodStorageCapacity' name ='newBloodStorageCapacity' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnsavenewbloodstorage">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--Edit Storage Modal-->
  <div class="modal fade" id="editBloodStorageModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editnewbloodstorageTitle">Edit Blood Storage</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="blood-related/editstorage.php" name="form_editbloodstorage">
          <div class="modal-body">
            <div class="form-group">
              <label for="editBloodStorageName">Blood Storage Name</label>
              <input type="hidden" name = "bloodstorage_ID" id = "bloodstorage_ID">
              <input type="text" class="form-control" id='editBloodStorageName' name ='editBloodStorageName' required>
            </div>
            <div class="form-group">
              <label for="editBloodStorageCapacity">Blood Storage Capacity</label>
              <input type="number" class="form-control" id='editBloodStorageCapacity' name ='editBloodStorageCapacity' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnsaveeditstorage">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--View Details-->
  <div class="modal fade" id="viewBloodStorageModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editnewbloodstorageTitle">Blood Storage</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="deletestorage.php" name="form_viewbloodstorage">
          <div class="modal-body">
            <div class="form-group">
              <label for="editBloodStorageName">Blood Storage Name</label>
              <input type="hidden" name = "viewbloodstorage_ID" id = "viewbloodstorage_ID">
              <input type="text" class="form-control" id='viewBloodStorageName' name ='viewBloodStorageName' readonly>
            </div>
            <div class="form-group">
              <label for="editBloodStorageCapacity">Blood Storage Capacity</label>
              <input type="number" class="form-control" id='viewBloodStorageCapacity' name ='viewBloodStorageCapacity'readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnsavedeletestorage" >Disable</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end -->
  <div class="modal fade" id="viewBloodStorageModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewBloodStorageModal_enable">Blood Storage</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="enablestorage.php" name="form_viewbloodstorage_enable">
          <div class="modal-body">
            <div class="form-group">
              <label for="editBloodStorageName">Blood Storage Name</label>
              <input type="hidden" name = "viewbloodstorage_ID_enable" id = "viewbloodstorage_ID_enable">
              <input type="text" class="form-control" id='viewBloodStorageName_enable' name ='viewBloodStorageName_enable' readonly>
            </div>
            <div class="form-group">
              <label for="editBloodStorageCapacity">Blood Storage Capacity</label>
              <input type="number" class="form-control" id='viewBloodStorageCapacity_enable' name ='viewBloodStorageCapacity_enable'readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" name="delete" class="btn btn-danger" id="btn_deletestorage">Delete</button>
            <button type="submit" class="btn btn-primary" id="btnsaveenablestorage" >Enable</button>
          </div>
        </form>
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
  <script type="text/javascript" src="js/storage-tab.js"></script>
  <script type="text/javascript">
  //add active class to current tab
  $('#storagetab').addClass("active");

  $(document).ready(function(){
    savenewstorage();
    editstorage();
    viewstorage();
    viewstorage_enable();
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

    function savenewstorage(){
      $("form[name='form_addnewbloodstorage']").on('submit',function(e){
        e.preventDefault();
        // var confirm_input = confirm("Are you sure?");
        var formdata = $("form[name='form_addnewbloodstorage']").serialize();

        swal({
          title: "Are you sure?",
          text: "You are about to add a new storage",
          icon: "info",
          buttons: true
        })
        .then((willApprove) => {
          if (willApprove) {
            $.ajax({
              type: "POST",
              url: "storage-related/add_newstorage.php",
              data: {formdata, formdata},
              success: function(data){
                console.log(data);
                if (data == "1"){
                  swal({
                    title: "",
                    text: "Storage added",
                    icon: "success",
                    buttons: {text: "Okay"},
                  })
                  .then((willApprove) => {
                    if (willApprove) {
                      $("#addBloodStorageModal .modal-body input").val("");
                      $("#addBloodStorageModal").modal("hide");
                      window.location.href = "storage-tab.php";
                    }
                  });
                }
                else if (data == "2") {
                  swal("","Storage already exists, Please check the disabled storages too.","warning");
                }
                else if (data == "3"){
                  swal("","Please select storage type","error");
                }
                else if (data == "4"){
                  swal("","Please set storage capacity", "error");
                }
                else if (data == "5"){
                  swal("","something wrong","error");
                }
              }
            });
          }
          else {
            swal("","Cancelled");
          }
        });
      });
    }

    function editstorage(){
      $('#editBloodStorageModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        alert(rowid);
        $.ajax({
          type: "POST",
          url: 'storage-related/fetch_storagedetails.php',
          data: 'rowid=' + rowid,
          dataType: "json",
          success: function(data){
            $('#bloodstorage_ID').val(data.intStorageId);
            $('#editBloodStorageName').val(data.strStorageName);
            $('#editBloodStorageCapacity').val(data.intStorageCapacity);
            console.log(data);
          }

        });
      });
    }

    function viewstorage(){
      $('#viewBloodStorageModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        alert(rowid);
        $.ajax({
          type: "POST",
          url: 'storage-related/fetch_storagedetails.php',
          data: 'rowid=' + rowid,
          dataType: "json",
          success: function(data){
            $('#viewbloodstorage_ID').val(data.intStorageId);
            $('#viewBloodStorageName').val(data.strStorageName);
            $('#viewBloodStorageCapacity').val(data.intStorageCapacity);
            console.log(data);
          }

        });
      });
    }

    function viewstorage_enable(){
      $('#viewBloodStorageModal_enable').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        alert(rowid);
        $.ajax({
          type: "POST",
          url: 'storage-related/fetch_storagedetails.php',
          data: 'rowid=' + rowid,
          dataType: "json",
          success: function(data){
            $('#viewbloodstorage_ID_enable').val(data.intStorageId);
            $('#viewBloodStorageName_enable').val(data.strStorageName);
            $('#viewBloodStorageCapacity_enable').val(data.intStorageCapacity);
            console.log(data);
          }

        });
      });
    }

    $("#btnsavedeletestorage").click(function(e){
      e.preventDefault();
      var id = $("#viewbloodstorage_ID").val();
      swal({
        title: "Are you sure?",
        text: "You are about to disable this storage",
        icon: "warning",
        buttons: true,
      })
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: "storage-related/disable_storage.php",
            data: {id:id},
            success: function (data){
              if (data == '1'){
                swal("Can't disable storage","Storage has blood bags in it! Move it to another storage first", "warning");
              }
              else if (data == '2'){
                swal({
                  title: "Success!",
                  text: "Storage is now disabled",
                  icon: "success",
                  buttons: {text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    window.location.href= "storage-tab.php";
                  }
                });
              }
            }
          });
        }
        else {
          swal("","Cancelled");
        }
      });
    });

    $("#btnsaveenablestorage").click(function(e){
      e.preventDefault();
      var id = $("#viewbloodstorage_ID_enable").val();
      var confirm_enable = confirm("Are you sure?");
      if(confirm_enable == true){
        $.ajax({
          type: "POST",
          url: 'storage-related/enable_storage.php',
          data: {id:id},
          success:function(data){
            alert("Storage has been enabled");
            window.location.href = "storage-tab.php";
          }
        });
      }
      else{
        alert("Confirmation Cancelled");
        return false;
      }
    });
  });

  //actual deletion of storage
  $(document).on("click", "#btn_deletestorage", function(e){
    e.preventDefault();

    var storage_id = $("#viewbloodstorage_ID_enable").val();
    swal({
      title: "Are you sure?",
      text: "You are about to delete this storage. You will not be able to enable this storage ever",
      icon: "warning",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove){
        $.ajax({
          type: "POST",
          url: "storage-related/delete_storage.php",
          data: "storage_id=" + storage_id,
          success: function(data){
            swal({
              title: "",
              text: "Storage is deleted",
              icon: "success",
              buttons: {text:"Okay"}
            })
            .then((willApprove)=>{
              if (willApprove) {
                window.location.href = "storage-tab.php";
              }
            });
          }
        });
      }
      else {
        swal("","Cancelled");
      }
    });
  });

  $(document).on("submit", "form[name='form_editbloodstorage']", function(e){
    e.preventDefault();
    let formdata = $(this).serialize();

    swal({
      title: "Are you sure?",
      text: "You are about to edit this storage's details",
      icon: "warning",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: "storage-related/edit_storage.php",
          data: {formdata : formdata},
          success: function (data) {
            if (data == "1"){
              swal({
                title: "",
                text: "Storage successfully edited",
                icon: "success",
                buttons: {text: "Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "storage-tab.php";
                  $('#editBloodStorageModal').modal('hide');
                  $("#ediBloodStorageModal .modal-body input").val("");
                }
              });
            }
            else if (data == "2"){
              swal("","The storage name you entered already exists!","error");
            }
            else if (data == "3"){
              swal("","Storage name is not edited", "error");
            }
            else if (data == "4"){
              swal("","Entered capacity is lower than total blood bags in the storage. Enter higher!","error");
            }
            else if (data == "5"){
              swal("", "Entered capacity is equal to the number of blood bags in the storage. Enter higher!", "error");
            }
          }
        });
      }
      else {
        swal("","Confirmation cancelled");
      }
    });
  });
</script>
</body>
</html>
