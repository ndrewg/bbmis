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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Edit Requests</h5>
      </div>
      <!-- SIDE NAVIGATION -->
			<?php
				include "employeeSidebar.php";
			?>
			<!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <?php
          include("connections.php");

          $viewrequests = mysqli_query($connections,"SELECT *
            FROM tblrequest
            WHERE stfRequestStatus = 'Requested' AND stfUpdateStatus = 'Not Updated' AND stfRequestFeedback = 'Unnotified' ");

            if(mysqli_num_rows($viewrequests) > 0){
              ?>
              <h4 class="nunito">Donor Edit Requests</h4>
              <table class='table table-bordered mt-5 text-center'>
                <thead>
                  <tr>
                    <th>Request ID</th>
                    <th>Client Name</th>
                    <th>Date Requested</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <?php
                while($row = mysqli_fetch_assoc($viewrequests)){
                  $reqId = $row["intClientReqId"];
                  $clientId = $row["intClientId"];
                  $changes = $row["txtChanges"];
                  $date_requested = $row["dtmDateRequested"];

                  $getClientName = mysqli_query($connections,"SELECT CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) AS Fullname FROM tblclient WHERE intClientId = '$clientId'");
                  while($row2 = mysqli_fetch_assoc($getClientName)){
                    $fullname = $row2["Fullname"];
                  }
                  ?>
                  <tr>
                    <td><?php echo $reqId; ?></td>
                    <td><?php echo $fullname; ?></td>
                    <td><?php echo $date_requested; ?></td>
                    <td><button type='button' name = 'viewRequest' class='btn' data-toggle='modal' data-target='#viewRequestModal'
                      data-id='<?php echo $reqId; ?>'>View Details</button></td>
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </table>
              <?php
            }else{
              ?>
              <h4>No Requests to Show</h4>
              <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <!-- end content -->
    <!-- modals -->
    <!-- view request modal -->
    <div class="modal fade" id="viewRequestModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewnewsurveycategoryTitle_enable">Edit Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action ="enable_category.php" name="form_viewsurveycategory_enable">
            <div class="modal-body">
              <div class="form-group">
                <label for="viewhiddenRequestId">Request ID</label>
                <input type="hidden" name = "viewhiddenRequestId" id = "viewhiddenRequestId">
                <input type="text" class="form-control" id='viewRequestId' name ='viewRequestId' readonly>
              </div>
              <div class="form-group">
                <label for="viewDonorName">Donor Name</label>
                <input type="text" class="form-control" id='viewDonorName' name ='viewDonorName' readonly>
              </div>
              <div class="form-group">
                <label for="viewDateRequested">Date Requested</label>
                <input type="text" class="form-control" id='viewDateRequested' name ='viewDateRequested' readonly>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" id="acceptrequest">Grant</button>
              <button type="button" class="btn btn-danger" id="rejectrequest">Reject</button>
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
    <script type="text/javascript">
    //add active class to current tab
    $('#donoreditrequeststab').addClass("active");

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

    $(document).on("show.bs.modal", "#viewRequestModal", function(e){
      var rowid = $(e.relatedTarget).data('id');
      alert(rowid);
      $.ajax({
        type: "POST",
        url: 'people-related/fetch_request.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#viewRequestId').val(data.intClientReqId);
          $('#viewDonorName').val(data.Fullname);
          $('#viewDateRequested').val(data.dtmDateRequested);
        }
      });
    });

    $(document).on("click", "#acceptrequest", function(e){
      var reqId = $('#viewRequestId').val();
      var confirm_input = confirm("Are you sure you?");
      if(confirm_input == true){
        $.ajax({
          type: "POST",
          url: 'people-related/accept_request.php',
          data: 'reqId=' + reqId,
          success: function(data){
            alert("Edit Granted");
            window.location.href = "donoreditrequests-tab.php";
          }
        });
      }
      else{
        alert("Confirmation Cancelled");
        return false;
      }
    });

    $(document).on("click", "#rejectrequest", function(e){
      var reqId = $('#viewRequestId').val();
      var confirm_input = confirm("Are you sure you?");
      if(confirm_input == true){
        $.ajax({
          type: "POST",
          url: 'people-related/reject_request.php',
          data: 'reqId=' + reqId,
          success: function(data){
            alert("Edit Rejected");
            window.location.href = "donoreditrequests-tab.php";
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
