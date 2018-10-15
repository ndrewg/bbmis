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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Blood Component</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
				include "employeeSidebar.php";
			?>
			<!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <div class="container-fluid" style="padding-bottom: 40px">
            <div class="row">
              <div class="col-md-6">
                <h4 class="nunito mb-3">Active Blood Component</h4>
                <table id='tbl_activebloodcomponent' class="table table-striped table-bordered text-center" style="width: 100%">
                  <thead>
                    <tr>
                      <th>Blood Component Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="col-md-6">
                <h4 class="nunito mb-3">Inactive Blood Component</h4>
                <table id='tbl_inactivebloodcomponent' class="table table-striped table-bordered text-center" style="width: 100%">
                  <thead>
                    <tr>
                      <th>Blood Component Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <button type='button' class='btn btn-outline-danger float-right mt-3' data-toggle='modal' data-target='#addBloodComponentModal'><i class="fas fa-plus"></i> Add Blood Component</button>
          </div>
        </div>
        <!-- <div class="content-container" style="margin-top: -10px">
        </div> -->
      </div>
    </div>
  </div>
  <!-- end of page content -->
  <!-- modal declaration -->
  <!--Add Blood Component Modal-->
  <div class="modal fade" id="addBloodComponentModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addnewbloodcomponentTitle">Add Blood Component</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="addnewbloodcomponent.php" name="form_addnewbloodcomponent">
          <div class="modal-body">
            <div class="form-group">
              <label for="newBloodComponentName">Blood Component Name</label>
              <input type="text" class="form-control" id='newBloodComponentName' name ='newBloodComponentName' required>
            </div>
            <div class="form-group">
              <label for="newBloodComponentDeferral">Blood Component Deferral</label>
              <input type="number" class="form-control" id='newBloodComponentDeferral' name ='newBloodComponentDeferral' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnsavenewbloodcomponent">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--Edit Blood Component Modal-->
  <div class="modal fade" id="editBloodComponentModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editnewbloodcomponentTitle">Edit Blood Coponent</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="editbloodcomponent.php" name="form_editbloodcomponent">
          <div class="modal-body">
            <div class="form-group">
              <label for="editBloodComponentName">Blood Component Name</label>
              <input type="hidden" name = "bloodcomp_ID" id = "bloodcomp_ID">
              <input type="text" class="form-control" id='editBloodComponentName' name ='editBloodComponentName' required>
            </div>
            <div class="form-group">
              <label for="editBloodComponentDeferral">Blood Component Deferral Day</label>
              <input type="number" class="form-control" id='editBloodComponentDeferral' name ='editBloodComponentDeferral' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnsaveeditbloodcomponent">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--view details-->
<div class="modal fade" id="viewBloodComponentModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewnewbloodcomponentTitle">Blood Component</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action ="deletecomponent.php" name="form_viewbloodcomponent">
				<div class="modal-body">
					<div class="form-group">
						<label for="editBloodComponentName">Blood Component Name</label>
						<input type="hidden" name = "viewbloodcomp_ID" id = "viewbloodcomp_ID">
						<input type="text" class="form-control" id='viewBloodComponentName' name ='viewBloodComponentName' readonly>
					</div>
          <div class="form-group">
            <label for="viewBloodComponentDeferral">Blood Component Deferral Day</label>
            <input type="number" class="form-control" id='viewBloodComponentDeferral' name ='viewBloodComponentDeferral' readonly>
          </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btnsavedeletebloodcomponent">Disable</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- enable blood component -->
<div class="modal fade" id="viewBloodComponentModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewnewbloodcomponentTitle">Blood Component</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action ="enablecomponent.php" name="form_viewbloodcomponent_enable">
				<div class="modal-body">
					<div class="form-group">
						<label for="editBloodComponentName">Blood Component Name</label>
						<input type="hidden" name = "viewbloodcomp_ID_enable" id = "viewbloodcomp_ID_enable">
						<input type="text" class="form-control" id='viewBloodComponentName_enable' name ='viewBloodComponentName_enable' readonly>
					</div>
          <div class="form-group">
            <label for="viewBloodComponentDeferral">Blood Component Deferral Day</label>
            <input type="number" class="form-control" id='viewBloodComponentDeferral_enable' name ='viewBloodComponentDeferral' readonly>
          </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btnsaveenablebloodcomponent">Enable</button>
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
  <script type="text/javascript" src="js/bloodcomponent-tab.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <!-- <script type="text/javascript" src="js/check_expiringbloodbags.js"></script> -->
  <script type="text/javascript" src="js/waves.min.js"></script>
  <script type="text/javascript">
  //add active class to current tab
  $('#bloodcomponenttab').addClass("active");
  $(document).ready(function(){
    //function declaration

    check_expiringbloodbags();
    //initialize ripple fx
    Waves.init();
    Waves.attach('.button');

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

  $(document).on("submit","form[name='form_addnewbloodcomponent']", function(e){
    e.preventDefault();
    // var confirm_input = confirm("Are you sure?");
    var formdata = $("form[name='form_addnewbloodcomponent']").serialize();

    swal({
      title: "Are you sure?",
      text: "You are about to add a blood component",
      icon: "info",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove){
        $.ajax({
          type: "POST",
          url: 'blood-related/add_newbloodcomponent.php',
          data: {formdata,formdata},
          success:function(data){
            console.log(data);
            if(data == 1){
              // alert("Blood Component Added");
              swal({
                title: "",
                text: "Blood Component Added",
                icon: "success",
                buttons: {text:"Close"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  $('#addBloodComponentModal').modal('hide');
                  $("#addBloodComponentModal .modal-body input").val("");
                  window.location.href = "bloodcomponent-tab.php";
                }
              });
              // $('#addBloodComponentModal').modal('hide');
              // $("#addBloodComponentModal .modal-body input").val("");
              // window.location.href = "bloodcomponent-tab.php";
              //$('#divdonoraddsero').show(600);
            }
            else if(data == 2){
              // swal("","The Blood Component You Entered Already Exists","info");
              swal({
                title: "",
                text: "The blood component you're trying to add already exists, Please check the disabled blood components too.",
                icon: "warning",
                buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                if(willApprove) {
                  window.location.href = "bloodcomponent-tab.php";
                }
              });
            }
            else if (data == 3) {
              // swal("","Blood Component is not saved","info");
              swal({
                title:"",
                text:"Blood Component is not saved!",
                icon:"error",
                buttons:{text:"OKAY"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "bloodcomponent-tab.php";
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

  $(document).on("show.bs.modal", "#editBloodComponentModal", function(e){
    var rowid = $(e.relatedTarget).data('id');
    // alert(rowid);
    $.ajax({
      type: "POST",
      url: 'blood-related/fetch_bloodcomponentdetails.php',
      data: 'rowid=' + rowid,
      dataType: "json",
      success: function(data){
        $('#bloodcomp_ID').val(data.intBloodComponentId);
        $('#editBloodComponentName').val(data.strBloodComponent);
        $('#editBloodComponentDeferral').val(data.intDeferralDay);
      }
    });
  });

  $(document).on("show.bs.modal", "#viewBloodComponentModal", function(e){
    var rowid = $(e.relatedTarget).data('id');
    // alert(rowid);
    $.ajax({
      type: "POST",
      url: 'blood-related/fetch_bloodcomponentdetails.php',
      data: 'rowid=' + rowid,
      dataType: "json",
      success: function(data){
        $('#viewbloodcomp_ID').val(data.intBloodComponentId);
        $('#viewBloodComponentName').val(data.strBloodComponent);
        $('#viewBloodComponentDeferral').val(data.intDeferralDay);
      }
    });
  });

  $(document).on("show.bs.modal", "#viewBloodComponentModal_enable", function(e){
    var rowid = $(e.relatedTarget).data('id');
    // alert(rowid);
    $.ajax({
      type: "POST",
      url: 'blood-related/fetch_bloodcomponentdetails.php',
      data: 'rowid=' + rowid,
      dataType: "json",
      success: function(data){
        $('#viewbloodcomp_ID_enable').val(data.intBloodComponentId);
        $('#viewBloodComponentName_enable').val(data.strBloodComponent);
        $('#viewBloodComponentDeferral_enable').val(data.intDeferralDay);
      }
    });
  });

  $(document).on("submit", "form[name='form_editbloodcomponent']", function(e){
    e.preventDefault();
    // var confirm_input = confirm("Are you sure?");

    var formdata = $("form[name='form_editbloodcomponent']").serialize();
    swal({
      title: "Are you sure?",
      text: "You are about to edit this blood component",
      icon: "warning",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: 'blood-related/edit_bloodcomponent.php',
          data: {formdata,formdata},
          success:function(data){
            if(data == 1){
              swal({
                title: "",
                text: "Blood Component Successfully edited",
                icon: "success",
                buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                $('#editBloodComponentModal').modal('hide');
                $("#editBloodComponentModal .modal-body input").val("");
                window.location.href = "bloodcomponent-tab.php";
              });
              // alert("Blood Component Succesfully Edited");
              //$('#divdonoraddsero').show(600);
            }
            else if(data == 2){
              swal({
                title: "",
                text: "The Blood Component you entered already exists!",
                icon: "error",
                buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "bloodcomponent-tab.php";
                }
              });
              // alert("The Blood Component You Entered Already Exists");
            }
            else if (data == 3) {
              swal({
                title: "",
                text: "Blood Component is not edited",
                icon: "error",
                buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "bloodcomponent-tab.php";
                }
              });
              // alert("Blood Component is not Edited");

            }
          }
        });
      }
      else {
        swal("","Cancelled","info");
      }
    });
  });

  $(document).on("click", "#btnsavedeletebloodcomponent", function(e){
    e.preventDefault();
    var id = $("#viewbloodcomp_ID").val();
    // var confirm_enable = confirm("Are you sure?");
    swal({
      title: "Are you sure",
      text: "You are about to disable this blood component",
      icon: "info",
      buttons: true,
    })
    .then((willApprove) =>{
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: 'blood-related/delete_bloodcomponent.php',
          data: {id:id},
          success:function(data){
            // alert("Blood Component has been enabled");
            if(data == "deleted"){
            swal({
              title: "",
              text: "Blood Component is now disabled!",
              icons: "success",
              buttons:{text:"Okay"},
            })
            .then((willApprove) => {
              if (willApprove) {
                window.location.href = "bloodcomponent-tab.php";
              }
            });
          }else{
            swal({
              title: "",
              text: "The blood component is not disabled because "+data+" record/s uses this.",
              icons: "error",
              buttons:{text:"Okay"},
            })
            .then((willApprove) => {
              if (willApprove) {
                window.location.href = "bloodcomponent-tab.php";
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

  $(document).on("click", "#btnsaveenablebloodcomponent", function(e){
    e.preventDefault();
    var id = $("#viewbloodcomp_ID_enable").val();
    // var confirm_enable = confirm("Are you sure?");
    swal({
      title: "Are you sure",
      text: "You are about to enable this blood component",
      icon: "info",
      buttons: true,
    })
    .then((willApprove) =>{
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: 'blood-related/enable_bloodcomponent.php',
          data: {id:id},
          success:function(data){
            // alert("Blood Component has been enabled");
            swal({
              title: "",
              text: "Blood Component is now enabled!",
              icons: "success",
              buttons:{text:"Okay"},
            })
            .then((willApprove) => {
              if (willApprove) {
                window.location.href = "bloodcomponent-tab.php";
              }
            });
          }
        });
      }
      else {
        swal("","Cancelled","info");
      }
    });
  });
  </script>
</body>
</html>
