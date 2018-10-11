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
          <h4 style="font-family: 'Nunito-Regular'">Current Donors</h4>
          <div class="container-fluid" style="padding-bottom: 40px;">
            <table id="tbl_donor" class="table table-striped table-bordered text-center" style="width: 100%">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
            <button type="button" class="btn btn-outline-danger float-right mt-3" data-toggle="modal" data-target="#modalSignUp"><i class="fas fa-user-plus"></i> Add Donor</button>
          </div>
        </div>
      </div>

      <div class="col-md-10 offset-md-2 mb-5">
        <div class="content-container" >
          <h4 style="font-family: 'Nunito-Regular'">Banned Donors</h4>
          <div class="container-fluid" style="padding-bottom: 40px;">
            <table id="tbl_banneddonor" class="table table-striped table-bordered text-center" style="width: 100%">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
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
  <div class="modal fade" id="modalSignUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Applicant Register</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="valClientSignup.php" method="POST" id = "client_signup" enctype="multipart/form-data">

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

					<!-- Contact No. -->
					<div class="form-group">
						<label for="lblContactNo" class="col-form-label">Contact No.</label>
						<span style="color: red;">*</span>
						<input type="text" class="form-control" id="lblContactNo" name="txtContNo" required="required" />
					</div>

					<div class="row">

						<!-- Sex -->
						<div class="form-group col-6">
							<label for="lblSex" class="col-form-label">Sex</label>
							<span style="color: red;">*</span>
							<select class="form-control" name="optSex" required="required">
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</div>

						<!-- Civil Status -->
						<div class="form-group col-6">
							<label for="lblCvlStat" class="col-form-label">Civil Status</label>
							<span style="color: red;">*</span>
							<select class="form-control" name="optCvlStat" required="required">
								<option value="Single">Single</option>
								<option value="Married">Married</option>
								<option value="Divorced">Divorced</option>
								<option value="Separated">Separated</option>
								<option value="Widowed">Widowed</option>
							</select>
						</div>
					</div>

					<!-- Birthdate -->
					<div class="row">
						<div class="form-group col-4">
							<label for="lblBdate" class="col-form-label">Birthmonth</label>
							<span style="color: red;">*</span>
							<select class="form-control" name="txtBm" required="required">

							<!-- Fetch months -->
							<?php
								for($m=1; $m<=12; $m++) {
									$month = date("F", mktime(0,0,0,$m, 1, date("Y")));
									echo "<option value='$m'>$month</option>";
								}
							?>

							</select>
						</div>

						<div class="form-group col-4">
							<label for="lblBdate" class="col-form-label">Birthday</label>
							<span style="color: red;">*</span>
							<select class="form-control" name="txtBd" required="required">";

								<option value=1>1</option>
								<option value=2>2</option>
								<option value=3>3</option>
								<option value=4>4</option>
								<option value=5>5</option>
								<option value=6>6</option>
								<option value=7>7</option>
								<option value=8>8</option>
								<option value=9>9</option>
								<option value=10>10</option>
								<option value=11>11</option>
								<option value=12>12</option>
								<option value=13>13</option>
								<option value=14>14</option>
								<option value=15>15</option>
								<option value=16>16</option>
								<option value=17>17</option>
								<option value=18>18</option>
								<option value=19>19</option>
								<option value=20>20</option>
								<option value=21>21</option>
								<option value=22>22</option>
								<option value=23>23</option>
								<option value=24>24</option>
								<option value=25>25</option>
								<option value=26>26</option>
								<option value=27>27</option>
								<option value=28>28</option>
								<option value=29>29</option>
								<option value=30>30</option>
								<option value=31>31</option>
							</select>
						</div>

						<div class="form-group col-4">
							<label for="lblBdate" class="col-form-label">Birthyear</label>
							<span style="color: red;">*</span>
							<select class="form-control" name="txtBy" required="required">

							<?php
								$curYear = date("Y");
								for($y=($curYear-($curYear-18)); $y<=($curYear-($curYear-60)); $y++)	{
									$z = $curYear-$y;
									echo "<option value='$z'>$z</option>";
								}
							?>

							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="lblOcc" class="col-form-label">Occupation</label>
						<span style="color: red">*</span>
						<input type="text" class="form-control" name="txtOcc" required="required" />
					</div>

					<div class="form-group">
						<label for="fileimg" class="col-form-label">Picture</label>
						<span style="color: red">*</span>
						<input type="file" class="form-control" name="fileimg" id="fileimg" required="required" />
            <img id="imageprev" style = "width:200px;height:200px" src="#" alt="your image" />
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
						<button type="submit" class="btn btn-outline-danger">Register</button>
					</div>
				</form>
        </div>
      </div>
    </div>
  </div>
<!----------------------------------------------------------------------------------------------------------------------------------->
<div class="modal fade" id="editdonorinfo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editdonorinfo">Edit Donor Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-close="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="edit_donorrecord.php" method="post" name="editdonor">
            <div class="form-group">
              <input type = "hidden" id ='clientId' name ='clientId'>
              <label for="clientfname">First Name</label>
              <input type="text" class="form-control" id='clientfname' disabled>
            </div>
            <div class="form-group">
              <label for="clientminit">Middle Name</label>
              <input type="text" class="form-control" id='clientminit' disabled>
            </div>
            <div class="form-group">
              <label for="clientlname">Last Name</label>
              <input type="text" class="form-control" id='clientlname' disabled>
            </div>
            <div class="form-group">
              <label for="clientocc">Occupation</label>
              <input type="text" class="form-control" id='clientocc' name ='clientocc'>
            </div>
            <div class="form-group">
              <label for="clientcontact">Contact</label>
              <input type="number" class="form-control" id='clientcontact' name="clientcontact">
            </div>
            <div class="form-group">
              <label for="clientsex">Sex</label>
              <input type="text" class="form-control" id='clientsex' disabled>
            </div>
            <div class="form-group">
              <label for="clientbloodtype">Blood Type</label>
              <select class="form-control" name="clientbloodtype" id="clientbloodtype">
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
            <div class="form-group">
              <label for="clientcivstat">Civil Status</label>
              <select name="clientcivstat" class="form-control" id="clientcivstat">
                <option value="Married">Married</option>
                <option value="Widowed">Widowed</option>
                <option value="Separated">Separated</option>
                <option value="Divorced">Divorced</option>
                <option value="Single">Single</option>
              </select>
            </div>
            <div class="form-group">
              <label for="clientbday">Age</label>
              <input type="text" class="form-control" id='clientbday' disabled>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-seconday" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" id="submit_editdonor">Save</button>
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
  <script type="text/javascript" src="js/donor-tab.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <script type="text/javascript" src="js/croppie.js"></script>
  <script type="text/javascript">
  //add active class to current tab
    $('#donortab').addClass("active");
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
