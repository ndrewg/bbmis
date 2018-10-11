<!DOCTYPE html>
<html>
	<head>
		<link rel="icon" href="assets/images/blood.ico">
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="assets/css/bs-override.css" type="text/css">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="assets/jquery/jquery-3.3.1.min.js" type="text/javascript"></script>
		<script src="assets/swal/sweetalert.min.js" type="text/javascript"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<title>ReFeel - Account</title>
	</head>
	<?php
		include "checkSession.php";
		include "fetchClientAcc.php";
	?>
	<body>
		<!-- Navigation bar -->
		<?php
			include "clientNavBar.php";
		?>
		
		<div class="container pt-4 w-50">
			<h4 class="display-4 text-center mb-sm-4">Account</h4>
			
			<p class="text-muted text-uppercase"><small><strong>Personal Information</strong></small></p>
			<hr style="margin-top: -15px;" />
			
			<div class="row">
				<div class="form-group col-4">
					<label for="lblFirstName" class="col-form-label">First Name</label>
					<input type="text" class="form-control" id="lblFirstName" value="<?php echo $varFname;?>" readonly="readonly" />
					
				</div>
				<div class="form-group col-4">
					<label for="lblMiddleName" class="col-form-label">Middle Name</label>
					<input type="text" class="form-control" id="lblMiddleName" value="<?php echo $varMname;?>" readonly="readonly" />
				</div>
				<div class="form-group col-4">
					<label for="lblLastName" class="col-form-label">Last Name</label>
					<input type="text" class="form-control" id="lblLastName" value="<?php echo $varLname;?>" readonly="readonly" />
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-6">
					<label for="lblSex" class="col-form-label">Sex</label>
					<input type="text" class="form-control" id="lblSex" value="<?php echo $varSex;?>" readonly="readonly" />
				</div>
				
				<div class="form-group col-6">
					<label for="lblCvlStat" class="col-form-label">Civil Status</label>
					<input type="text" class="form-control" id="lblCvlStat" value="<?php echo $varCvlStat;?>" readonly="readonly" />
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-6">
					<label for="lblBdate" class="col-form-label">Birthdate</label>
					<input type="text" class="form-control" id="lblBdate" value="<?php echo date_format(date_create($varBday), "F d, Y");?>" readonly="readonly" />
				</div>
				
				<div class="form-group col-6">
					<label for="lblOcc" class="col-form-label">Occupation</label>
					<input type="text" class="form-control" id="lblOcc" value="<?php echo $varOcc;?>" readonly="readonly" />
				</div>
			</div>
			
			<div class="modal-footer">
				<?php
					include "fetchUpdateBtn.php";
				?>
			</div>
		
			<br/>
			<p class="text-muted text-uppercase"><small><strong>Contact Information</strong></small></p>
			<hr style="margin-top: -15px;" />
			
			<div class="form-group">
				<label for="lblContactNo" class="col-form-label">Contact No.</label>
				<input type="text" class="form-control" id="lblContactNo" value="<?php echo $varContNo;?>" readonly="readonly" />
			</div>
			
			<div class="modal-footer">
				<button type="submit" class="btn btn-outline-danger" name="btnAct" value="Contact" id="btncont">Update</button>
			</div>
			
			<br/>
			<p class="text-muted text-uppercase"><small><strong>Account Credentials</strong></small></p>
			<hr style="margin-top: -15px;" />

			<div class="form-group">
				<label for="lblUn" class="col-form-label">Username</label>
				<input type="text" class="form-control" id="lblUn" value="<?php echo $varUn;?>" readonly="readonly" />
			</div>
			
			<div class="modal-footer">
				<button type="submit" class="btn btn-outline-danger" name="btnAct" value="Account" id="btnAccCred">Update</button>
			</div>
		</div>
	</body>
</html>