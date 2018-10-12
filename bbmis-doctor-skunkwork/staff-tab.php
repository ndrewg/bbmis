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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Staff</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
      include "employeeSidebar.php";
      ?>
      <!-- END OF SIDE NAVIGATION -->
      <!-- MAIN CONTENT -->
      <div class="col-md-10 offset-md-2 mb-5">
        <div class="content-container" >
          <h4 style="font-family: 'Nunito-Regular'">Current Staff</h4>
          <div class="container-fluid" style="padding-bottom: 40px;">
            <table id="tbl_staff" class="table table-striped table-bordered text-center" style="width: 100%">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Employee Type</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
            <button type="button" class="btn btn-outline-danger float-right mt-3" data-toggle="modal" data-target="#modalSignUp"><i class="fas fa-user-plus"></i> Add Staff</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end content -->
  <!-- modals -->
  <div class="modal fade" id="modalSignUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Employee Sign Up</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="valEmployeeSignUp.php" method="POST" id="" enctype="multipart/form-data">

            <p class="text-muted"><small><strong>PERSONAL INFORMATION</strong></small></p>
            <hr style="margin-top: -15px;" />

            <div class="row">
              <!-- Name -->
              <div class="form-group col-4">
                <label for="lblFirstName" class="col-form-label">First Name</label>
                <span style="color: red;">*</span>
                <input type="text" class="form-control" id="lblFirstName" name="txtFname" required="required" />
              </div>
              <div class="form-group col-4">
                <label for="lblMiddleName" class="col-form-label">Middle Name (if any)</label>
                <input type="text" class="form-control" id="lblMiddleName" name="txtMname" />
              </div>
              <div class="form-group col-4">
                <label for="lblLastName" class="col-form-label">Last Name</label>
                <span style="color: red;">*</span>
                <input type="text" class="form-control" id="lblLastName" name="txtLname" required="required" />
              </div>
            </div>

            <div class="form-group">
              <label for="fileimg" class="col-form-label">Picture</label>
              <span style="color: red">*</span>
              <input type="file" class="form-control" name="fileimg" id="fileimg" required="required" />
               <img id="imageprev" style = "width:200px;height:200px" src="#" alt="your image" />
            </div>

            <div id = "uploaded_image"></div>

            <div class="form-group col-6">
              <label for="lblPos" class="col-form-label">Position</label>
              <span style="color: red;">*</span>
              <select class="form-control" name="optPos" required="required">
                <option value="Staff">Staff</option>
                <option value="Doctor">Doctor</option>
              </select>
            </div>

            <p class="text-muted"><small><strong>ACCOUNT CREDENTIALS</strong></small></p>
            <hr style="margin-top: -15px;" />

            <!-- Username -->
            <div class="form-group">
              <label for="lblUn" class="col-form-label">Username</label>
              <span style="color: red">*</span>
              <input type="text" class="form-control" name="txtUn" required="required">
            </div>

            <!-- Password -->
            <div class="form-group">
              <label for="lblPw" class="col-form-label">Password</label>
              <span style="color: red">*</span>
              <input type="password" class="form-control" name="txtPw" required="required">
            </div>

            <div class="modal-footer">
              <span style="color: red">Fields with asterisk(*) are required.</span>
              <button type="submit" class="btn btn-outline-danger">Sign Up</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!----------------------------------------------------------------------------------------------------------------------------------->
  <div class="modal fade" id="editstaffinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editdonorinfo">Edit Staff Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-close="Close"> <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form action="valEmployeeEdit.php" method="POST" id="" enctype="multipart/form-data" name ='editemployee'>

              <p class="text-muted"><small><strong>PERSONAL INFORMATION</strong></small></p>
              <hr style="margin-top: -15px;" />

              <div class="row">
                <!-- Name -->
                <input type = "hidden" name="hidden_id" id="hidden_id">
                <div class="form-group col-4">
                  <label for="lblFirstName" class="col-form-label">First Name</label>
                  <span style="color: red;">*</span>
                  <input type="text" class="form-control" id="edit_lblFirstName" name="txtFname" required="required" />
                </div>
                <div class="form-group col-4">
                  <label for="lblMiddleName" class="col-form-label">Middle Name (if any)</label>
                  <input type="text" class="form-control" id="edit_lblMiddleName" name="txtMname" />
                </div>
                <div class="form-group col-4">
                  <label for="lblLastName" class="col-form-label">Last Name</label>
                  <span style="color: red;">*</span>
                  <input type="text" class="form-control" id="edit_lblLastName" name="txtLname" required="required" />
                </div>
                <div class="form-group col-6">
                  <label for="view_username" class="col-form-label">Username</label>
                  <input type="text" class="form-control" id="view_username" name="view_username" readonly />
                </div>
                <div class="form-group col-6">
                  <label for="view_password" class="col-form-label">Password</label>
                  <input type="text" class="form-control" id="view_password" name="view_password" readonly/>
                </div>
                <div class="form-group col-6">
                  <label for="lblLastName" class="col-form-label">Image</label>
                  <span style="color: red;">*</span>
                  <input type="file" class="form-control" id="edit_image" name="edit_image"  />
                  <img id="imageprev2" style = "width:200px;height:200px" src="#" alt="your image" />
                </div>
              </div>

              <div class="form-group col-6">
                <label for="lblPos" class="col-form-label">Position</label>
                <span style="color: red;">*</span>
                <select class="form-control" name="optPos" id="edit_optPos" required="required">
                  <option value="Staff">Staff</option>
                  <option value="Doctor">Doctor</option>
                </select>
              </div>

              <div class="form-group col-6">
                <label for="lblPos" class="col-form-label">Status</label>
                <span style="color: red;">*</span>
                <select class="form-control" name="optstat" id="edit_optstat" required="required">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>

              <div class="modal-footer">
                <span style="color: red">Fields with asterisk(*) are required.</span>
                <button type="submit" class="btn btn-outline-danger">Save</button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>

  <!--<div id = "uploadedimageModal" class = "modal" role ="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Image Crop and Upload</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class = "modal-body">
          <div class ="row">

            <div class = "col-md-8 text-center">
              <div id ="image_demo" style="width:350px; margin-top:30px;"></div>
            </div>

            <div class ="col-md-4" style="padding-top:30px;">
              <br/>
              <br/>
              <br/>
              <button class ="btn btn-success crop_image">Crop and Upload Image</button>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>-->

  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
  <script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="js/realtime-connection.js"></script>
  <script type="text/javascript" src="js/staff-tab.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <script type="text/javascript">
  //add active class to current tab
  $('#stafftab').addClass("active");
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
