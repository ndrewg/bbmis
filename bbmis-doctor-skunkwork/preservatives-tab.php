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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Preservatives</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
				include "employeeSidebar.php";
			?>
			<!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <div class="container-fluid" style="padding-bottom: 40px">
            <!-- <div class="row"> -->
              <!-- <div class="col-md-6"> -->
                <h4 class="nunito mb-3">Active Preservatives</h4>
                <table id='tbl_activepreservative' class="table table-striped table-bordered text-center" style="width: 100%">
                  <thead>
                    <tr>
                      <th>Preservative Name</th>
                      <th>Lifespan</th>
                      <th>Fresh</th>
                      <th>Neutral</th>
                      <th>Critical</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              <!-- </div> -->
              <!-- <div class="col-md-6"> -->
              <!-- </div> -->
            <!-- </div> -->
            <button type='button' class='btn btn-outline-danger float-right mt-3' data-toggle='modal' data-target='#addpreservativeModal'><i class="fas fa-plus"></i> Add Preservative</button>
          </div>
        </div>
        <div class="content-container" style="margin-top: -20px">
          <h4 class="nunito mb-3">Inactive Preservatives</h4>
          <table id='tbl_inactivepreservative' class="table table-striped table-bordered text-center" style="width: 100%">
            <thead>
              <tr>
                <th>Preservative Name</th>
                <th>Lifespan</th>
                <th>Fresh</th>
                <th>Neutral</th>
                <th>Critical</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- end of page content -->
  <!-- modal declaration -->
  <!--Add Preservative Modal-->
  <div class="modal fade" id="addpreservativeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addnewpreservativeTitle">Add Preservative</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="addnewpreservative.php" name="form_addnewpreservative">
          <div class="modal-body">
            <div class="form-group">
              <label for="newpreservativeName">Preservative Name</label>
              <input type="text" class="form-control" id='newpreservativeName' name ='newpreservativeName' required>
            </div>
            <div class="form-group">
              <label for="newpreservativeLifespan">Preservative Lifespan</label>
              <input type="number" class="form-control" id='newpreservativeLifespan' name ='newpreservativeLifespan' min="1" max="99"  required>
            </div>
            <div class="form-group">
              <label for="newpreservativeFresh">Fresh Level</label>
              <input type="number" class="form-control" id='newpreservativeFresh' name ='newpreservativeFresh' min="1" max="99" required>

            </div>
            <div class="form-group">
              <label for="newpreservativeMedium">Neutral Level</label>
              <input type="number" class="form-control" id='newpreservativeMedium' name ='newpreservativeMedium' min="1" max="99" required>

            </div>
            <div class="form-group">
              <label for="newpreservativeCritical">Critical Level</label>
              <input type="number" class="form-control" id='newpreservativeCritical' name ='newpreservativeCritical' min="1" max="99" required>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="text" class="btn btn-primary" id="btnsavenewpreservative" >Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--Edit Preservative Modal-->
  <div class="modal fade" id="editpreservativeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editnewpreservativeTitle">Edit Blood Coponent</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="editpreservative.php" name="form_editpreservative">
          <div class="modal-body">
            <div class="form-group">
              <label for="editpreservativeName">Preservative Name</label>
              <input type="hidden" name = "preservative_ID" id = "preservative_ID">
              <input type="text" class="form-control" id='editpreservativeName' name ='editpreservativeName' required>
            </div>
            <div class="form-group">
              <label for="editpreservativeLifespan">Preservative Lifespan</label>
              <input type="number" class="form-control" id='editpreservativeLifespan' name ='editpreservativeLifespan' min="1" max="99" required>
            </div>
            <div class="form-group">
              <label for="editpreservativeFresh">Fresh Level</label>
              <input type="number" class="form-control" id='editpreservativeFresh' name ='editpreservativeFresh' min="1" max="99" required>

            </div>
            <div class="form-group">
              <label for="editpreservativeMedium">Neutral Level</label>
              <input type="number" class="form-control" id='editpreservativeMedium' name ='editpreservativeMedium' min="1" max="99" required>

            </div>
            <div class="form-group">
              <label for="editpreservativeCritical">Critical Level</label>
              <input type="number" class="form-control" id='editpreservativeCritical' name ='editpreservativeCritical' min="1" max="99" required>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnsaveeditpreservative" >Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--view details-->
<div class="modal fade" id="viewpreservativeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewnewpreservativeTitle">Preservative</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action ="deletecomponent.php" name="form_viewpreservative">
				<div class="modal-body">
					<div class="form-group">
						<label for="editpreservativeName">Preservative Name</label>
						<input type="hidden" name = "viewpreservative_ID" id = "viewpreservative_ID">
						<input type="text" class="form-control" id='viewpreservativeName' name ='viewpreservativeName' readonly>
					</div>
          <div class="form-group">
            <label for="viewpreservativeLifespan">Preservative Lifespan</label>
            <input type="number" class="form-control" id='viewpreservativeLifespan' name ='viewpreservativeLifespan' readonly>
          </div>
          <div class="form-group">
            <label for="viewpreservativeFresh">Fresh Level</label>
            <input type="number" class="form-control" id='viewpreservativeFresh' name ='viewpreservativeFresh' readonly>
          </div>
          <div class="form-group">
            <label for="viewpreservativeMedium">Neutral Level</label>
            <input type="number" class="form-control" id='viewpreservativeMedium' name ='viewpreservativeMedium' readonly>
          </div>
          <div class="form-group">
            <label for="viewpreservativeCritical">Critical Level</label>
            <input type="number" class="form-control" id='viewpreservativeCritical' name ='viewpreservativeCritical' readonly>
          </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btnsavedeletepreservative">Disable</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- enable Preservative -->
<div class="modal fade" id="viewpreservativeModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewnewpreservativeTitle">Preservative</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action ="enablecomponent.php" name="form_viewpreservative_enable">
				<div class="modal-body">
					<div class="form-group">
						<label for="editpreservativeName">Preservative Name</label>
						<input type="hidden" name = "viewpreservative_ID_enable" id = "viewpreservative_ID_enable">
						<input type="text" class="form-control" id='viewpreservativeName_enable' name ='viewpreservativeName_enable' readonly>
					</div>
          <div class="form-group">
            <label for="viewpreservativeLifespan_enable">Preservative Lifespan</label>
            <input type="number" class="form-control" id='viewpreservativeLifespan_enable' name ='viewpreservativeLifespan_enable' readonly>
          </div>
          <div class="form-group">
            <label for="viewpreservativeFresh_enable">Fresh Level</label>
            <input type="number" class="form-control" id='viewpreservativeFresh_enable' name ='viewpreservativeFresh_enable' readonly>
          </div>
          <div class="form-group">
            <label for="viewpreservativeMedium_enable">Neutral Level</label>
            <input type="number" class="form-control" id='viewpreservativeMedium_enable' name ='viewpreservativeMedium_enable' readonly>
          </div>
          <div class="form-group">
            <label for="viewpreservativeCritical_enable">Critical Level</label>
            <input type="number" class="form-control" id='viewpreservativeCritical_enable' name ='viewpreservativeCritical_enable' readonly>
          </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btnsaveenablepreservative">Enable</button>
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
  <script type="text/javascript" src="js/waves.min.js"></script>
  <script type="text/javascript" src="js/preservatives-tab.js"></script>
  <script type="text/javascript">
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
