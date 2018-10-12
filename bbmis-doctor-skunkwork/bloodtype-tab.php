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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Blood Type</h5>
      </div>
      <?php
      include "employeeSidebar.php";
      ?>
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <div class="container-fluid" style="padding-bottom: 40px">
            <div class="row">
              <div class="col-md-6">
                <h4 class="nunito mb-3">Active Blood Type</h4>
                <table id="tbl_activebloodtype" class="table table-striped table-bordered text-center" style="width:100%">
                  <thead>
                    <tr>
                      <th>Blood Type</th>
                      <th>Rhesus</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="col-md-6">
                <h4 class="nunito mb-3">Inactive Blood Type</h4>
                <table id="tbl_inactivebloodtype" class="table table-bordered table-striped text-center" style="width: 100%">
                  <thead>
                    <tr>
                      <th>Blood Type</th>
                      <th>Rhesus</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <button type="button" class="btn btn-outline-danger float-right mt-3" data-toggle="modal" data-target="#addBloodTypeModal"><i class="fas fa-plus"></i> Add Blood Type</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- end content -->
<!-- modals -->
<!--Add Blood type Modal-->
<div class="modal fade" id="addBloodTypeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addnewbloodcomponentTitle">Add Blood Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action ="addnewbloodtype.php" name="form_addnewbloodtype">
        <div class="modal-body">
          <div class="form-group">
            <label for="newBloodTypeName">Blood Type Name</label>
            <input type="text" class="form-control" id='newBloodTypeName' name ='newBloodTypeName' required>
          </div>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="newBloodComponentName">Blood Rhesus Name</label>
            <select class="form-control" id='newBloodRhesusName' name ='newBloodRhesusName' required>
              <option value = 'Positive'>Positive</option>
              <option value = 'Negative'>Negative</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btnsavenewbloodtype">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--Edit Blood type Modal-->
<div class="modal fade" id="editBloodTypeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editnewbloodcomponentTitle">Edit Type Coponent</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action ="editbloodType.php" name="form_editbloodType">
        <div class="modal-body">
          <div class="form-group">
            <label for="editBloodComponentName">Blood Type Name</label>
            <input type="hidden" name = "bloodtype_ID" id = "bloodtype_ID">
            <input type="text" class="form-control" id='editBloodTypeName' name ='editBloodTypeName' required>
          </div>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="editBloodComponentName">Blood Rhesus</label>
            <input type="hidden" name = "bloodrhesus_ID" id = "bloodrhesus_ID">
            <select class="form-control" id='editBloodTypeRhesus' name ='editBloodTypeRhesus' required>
              <option value = 'Positive'>Positive</option>
              <option value = 'Negative'>Negative</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btnsaveeditbloodtype">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--view details-->
<div class="modal fade" id="viewBloodTypeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewnewbloodcomponentTitle">Blood Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action ="deletebloodtype.php" name="form_viewbloodtype">
        <div class="modal-body">
          <div class="form-group">
            <label for="editBloodComponentName">Blood Type Name</label>
            <input type="hidden" name = "viewbloodtype_ID" id = "viewbloodtype_ID">
            <input type="text" class="form-control" id='viewBloodTypeName' name ='viewBloodTypeName' readonly>
          </div>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="editBloodComponentName">Blood Rhesus</label>
            <input type="hidden" name = "viewbloodrhesus_ID" id = "viewbloodrhesus_ID">
            <input type="text" class="form-control" id='viewBloodRhesusName' name ='viewBloodRhesusName' readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btnsavedeletebloodtype">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="viewBloodTypeModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewnewbloodcomponentTitle">Blood Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action ="enablebloodtype.php" name="form_viewbloodtype_enable">
        <div class="modal-body">
          <div class="form-group">
            <label for="editBloodComponentName">Blood Type Name</label>
            <input type="hidden" name = "viewbloodtype_ID_enable" id = "viewbloodtype_ID_enable">
            <input type="text" class="form-control" id='viewBloodTypeName_enable' name ='viewBloodTypeName_enable' readonly>
          </div>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="editBloodComponentName">Blood Rhesus</label>
            <input type="hidden" name = "viewbloodrhesus_ID_enable" id = "viewbloodrhesus_ID_enable">
            <input type="text" class="form-control" id='viewBloodRhesusName_enable' name ='viewBloodRhesusName_enable' readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btnsaveenablebloodtype">Enable</button>
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
<script type="text/javascript" src="js/waves.min.js"></script>
<script type="text/javascript" src="js/notification.js"></script>
<script type="text/javascript" src="js/bloodtype-tab.js"></script>
<script type="text/javascript">
//add active class to current tab
$('#bloodtypetab').addClass("active");

$(document).ready(function(){
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

$(document).on("submit", "form[name='form_addnewbloodtype']", function(e){
  e.preventDefault();
  var confirm_input = confirm("Are you sure?");
  var formdata = $("form[name='form_addnewbloodtype']").serialize();

  if (confirm_input == true){
    $.ajax({
      type: "POST",
      url: 'blood-related/add_newbloodtype.php',
      data: {formdata,formdata},
      success:function(data){
        if(data == 1){
          alert("Blood Type Added");
          $('#addBloodTypeModal').modal('hide');
          $("#addBloodTypeModal .modal-body input").val("");
          window.location.href = "bloodtype-tab.php";
          //$('#divdonoraddsero').show(600);
        }
        else if(data == 2){
          alert("The Blood Type Name You Entered Already Exists, Please check the disabled blood types too.");
        }
        else if (data == 3) {
          alert("Blood Type is not saved");
        }
      }
    });
  }
  else{
    alert("Confirmation Cancelled");
    return false;
  }
});

$(document).on("show.bs.modal", "#editBloodTypeModal", function(e){
  var rowid = $(e.relatedTarget).data('id');
  alert(rowid);
  $.ajax({
    type: "POST",
    url: 'blood-related/fetch_bloodtype.php',
    data: 'rowid=' + rowid,
    dataType: "json",
    success: function(data){
      $('#bloodtype_ID').val(data.intBloodTypeId);
      $('#editBloodTypeName').val(data.stfBloodType);
      $('#editBloodTypeRhesus').val(data.stfBloodTypeRhesus);
      console.log(data);
    }
  });
});

$(document).on("show.bs.modal","#viewBloodTypeModal", function(e){
  var rowid = $(e.relatedTarget).data('id');
  alert(rowid);
  $.ajax({
    type: "POST",
    url: 'blood-related/fetch_bloodtype.php',
    data: 'rowid=' + rowid,
    dataType: "json",
    success: function(data){
      $('#viewbloodtype_ID').val(data.intBloodTypeId);
      $('#viewBloodTypeName').val(data.stfBloodType);
      $('#viewBloodRhesusName').val(data.stfBloodTypeRhesus);
      console.log(data);
    }
  });
});

$(document).on("show.bs.modal", "#viewBloodTypeModal_enable", function(e){
  var rowid = $(e.relatedTarget).data('id');
  alert(rowid);
  $.ajax({
    type: "POST",
    url: 'blood-related/fetch_bloodtype.php',
    data: 'rowid=' + rowid,
    dataType: "json",
    success: function(data){
      $('#viewbloodtype_ID_enable').val(data.intBloodTypeId);
      $('#viewBloodTypeName_enable').val(data.stfBloodType);
      $('#viewBloodRhesusName_enable').val(data.stfBloodTypeRhesus);
      console.log(data);
    }
  });
});

$(document).on("submit", "form[name='form_editbloodType']", function(e){
  e.preventDefault();
  var confirm_input = confirm("Are you sure?");
  var formdata = $("form[name='form_editbloodType']").serialize();
  console.log(formdata);
  if (confirm_input == true){
    $.ajax({
      type: "POST",
      url: 'blood-related/edit_bloodtype.php',
      data: {formdata,formdata},
      success:function(data){
        if(data == 1){
          alert("Blood Type Succesfully Edited");
          $('#editBloodTypeModal').modal('hide');
          $("#editBloodTypeModal .modal-body input").val("");
          window.location.href = "bloodtype-tab.php";
          //$('#divdonoraddsero').show(600);
        }
        else if(data == 2){
          alert("The Blood Type Name You Entered Already Exists");
          window.location.href = "bloodtype-tab.php";
        }
        else if (data == 3) {
          alert("Blood Type Name is not Edited");
          window.location.href = "bloodtype-tab.php";
        }
      }
    });
  }
  else{
    alert("Confirmation Cancelled");
    return false;
  }
});

$(document).on("click", "#btnsavedeletebloodtype", function(e){
  e.preventDefault();
  var id = $("#viewbloodtype_ID").val();
  swal({
    title: "Are you sure?",
    text: "You are about to disable this blood type",
    icon: "info",
    buttons: true,
  })
  //var confirm_delete = confirm("Are you sure you want to disable?");
  //if(confirm_delete == true){
  .then((willApprove) => {
    if (willApprove) {
      $.ajax({
        type: "POST",
        url: 'blood-related/delete_bloodtype.php',
        data: {id:id},
        success:function(data){
          if(data == "deleted"){
            swal({
              title: "",
              text: "The blood type is now disabled",
              icon: "success",
              buttons: {text:"Okay"},
            })
            .then((willApprove) => {
              if (willApprove) {
                window.location.href = "bloodtype-tab.php";
              }
            });
          }else{
            swal({
              title: "",
              text: "The blood type is not disabled because "+data+" record/s uses this.",
              icon: "error",
              buttons: {text:"Okay"},
            })
            .then((willApprove) => {
              if (willApprove) {
                window.location.href = "bloodtype-tab.php";
              }
            });
          }
        }
      });
    }
    else {
      swal("","Cancelled","info");
    }
  });
});

$(document).on("click","#btnsaveenablebloodtype", function(e){
  e.preventDefault();
  var id = $("#viewbloodtype_ID_enable").val();
  var confirm_enable = confirm("Are you sure?");
  if(confirm_enable == true){
    $.ajax({
      type: "POST",
      url: 'blood-related/enable_bloodtype.php',
      data: {id:id},
      success:function(data){
        alert("Blood Type has been enabled");
        window.location.href = "bloodtype-tab.php";
      }
    });
  }
  else{
    alert("Confirmation Cancelled");
    return false;
  }
});
</script>
</body>
</html>
