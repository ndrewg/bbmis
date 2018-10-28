<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bs4/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/fontawesome-all.css">
  <link rel="stylesheet" href="css/jquery-confirm.min.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/waves.min.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- header -->
      <div class="col-md-10 fixed-top offset-md-2 header">
        <?php
					include "fetchEmpAcc.php";
					include "employeeNavbar.php";
				?>
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Donor Records</h5>
      </div>
      <!-- end header -->
      <!-- SIDE NAVIGATION -->
			<?php
				include "employeeSidebar.php";
        $datenow = date('Y-m-d');
        $datenow_1 = new DateTime($datenow);

			?>
			<!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
          <div class="content-container animated fadeIn fast">
            <h4 style="font-family: 'Nunito-Regular'">Available Donors</h4>
            <!-- SHOW CLIENTS THAT ANSWERED THE INTERVIEW SHEET -->
            <div id="div_donorrecords">
              <table id="tbl_donorrecords" class="table table-striped table-bordered" style="width: 100%;">
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
            <!-- display client's info -->
            <div id="div_donorinfo" style="display:none;">
              <button type="button" class="btn" id='btn-backtorecords' onclick="location.href='donorrecords-tab.php'"> <i class="fas fa-long-arrow-alt-left"></i> Back to records</button><br><br>
              <label class="labeldonordiv">Name: </label>
              <label id='cname'></label><br>
              <label class="labeldonordiv">Birthday: </label>
              <label id='cbday'></label><br>
              <label class="labeldonordiv">Sex: </label>
              <label id='csex'></label><br>
              <label class="labeldonordiv">Contact: </label>
              <label id='ccontact'></label><br>
              <label class="labeldonordiv">Civil Status: </label>
              <label id='ccivstat'></label><br>
              <label class="labeldonordiv">Occupation: </label>
              <label id='coccupation'></label>
            </div>
          </div>
          <!-- ADDING CLIENT'S PHYSICAL EXAM RESULTS -->
          <div id="div_donoraddphysical" class="" style="display: none; margin-top: -20px">
            <h4 style="font-family: 'Roboto-Regular'; margin-bottom: 20px;"><span class="badge badge-pill badge-dark mr-3">2</span>Physical Exam</h4><hr>
            <form method="post" name ="adddonorphysrecord" action="savedonorphysexam.php">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="date_phys">Date Screened</label>
                    <input type="date" name="date_phys" value=<?php echo $datenow ?> required>
                  </div>
                </div>
                <div class="col-md-5">
                  <!-- <div class="form-group"> -->
                    <label for="donorweight">Weight</label>
                    <div class="input-group">
                      <input type="number" class="form-control" id='donorweight' name="donorweight" required>
                      <div class="input-group-append">
                        <div class="input-group-text">kg</div>
                      </div>
                    </div>
                    <input type ="hidden" name ="clientId_phys" id ="clientId_phys">
                  <!-- </div> -->
                </div>
                <div class="col-md-5">
                  <label for="donorbloodpressure_systole">Blood Pressure</label>
                  <!-- <div class="form-group"> -->
                    <!-- <div class="row"> -->
                      <div class="input-group">
                        <input type="number" class="form-control col-md-4" id='donorbloodpressure_systole' name="donorbloodpressure_systole" required>
                        <input type="number" class="form-control col-md-4" id='donorbloodpressure_diastole' name="donorbloodpressure_diastole" required>
                        <div class="input-group-append">
                          <div class="input-group-text">mmHg</div>
                        </div>
                      </div>
                    <!-- </div> -->
                  <!-- </div> -->
                </div>
                <div class="col-md-5">
                  <!-- <div class="form-group"> -->
                    <label for="donorpulserate">Pulse Rate</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id='donorpulserate' name="donorpulserate" required>
                      <div class="input-group-append">
                        <div class="input-group-text">per minute</div>
                      </div>
                    </div>
                  <!-- </div> -->
                </div>
                <div class="col-md-5">
                  <!-- <div class="form-group"> -->
                    <label for="donortemperature">Temperature</label>
                    <div class="input-group">
                      <input type="number" class="form-control" id='donortemperature' name='donortemperature' required>
                      <div class="input-group-append">
                        <div class="input-group-text">°C</div>
                      </div>
                    </div>
                  <!-- </div> -->
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="donorgenapp">General Appearance</label>
                    <input type="text" class="form-control" id='donorgenapp' name="donorgenapp" required>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="donorheent">Head, Ears, Eyes, Nose & Throat (HEENT)</label>
                    <input type="text" class="form-control" id='donorheent' name="donorheent" required>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="donorheartlungs">Heart and Lungs</label>
                    <input type="text" class="form-control" id='donorheartlungs' name="donorheartlungs" required>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="examremarks">Exam Remarks</label>
                    <select class="form-control" id='examremarks' name="examremarks" required>
                      <option selected disabled>Select Exam Remarks</option>
                      <option value="Accepted">Accepted</option>
                      <option value="Temporarily Deferred">Temporarily Deferred</option>
                      <option value="Permanently Deferred">Permanently Deferred</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-9" id = "amount" style="display : none;">
                  <div class="form-group">
                    <label for="bloodamount">Amount of Blood</label>
                    <input type="radio" name="bloodamount" value = "250cc" id = "bloodamount" >250cc
                    <input type="radio" name="bloodamount" value = "450cc" id = "bloodamount">450cc
                  </div>
                </div>
                <div class="col-md-9" id = "reason"  style="display : none;">
                  <div class="form-group">
                    <label for="reasonfordeferal">Reason for Defferal</label>
                    <input type="text" name="reasonfordeferal" id = "reasonfordeferal" class="form-control">
                    <label for="instruction">Instructions</label>
                    <input type="text" name="instruction" id = "instruction" class="form-control">
                  </div>
                </div>

                <!--<div class="col-md-9">
                <div class="form-group">
                <label for="donorstatus">Pass or Fail</label>
                <select name="donorstatus" id="donorstatus" class="form-control">
                <option value="Passed">Passed</option>
                <option value="Failed">Failed</option>
              </select>
            </div>
          </div>-->
          <div class="col-md-12">
            <button type="submit" class="btn btn-success ml-1 float-right" id='donorphysrecord_save'>Save</button>
            <button type="button" class="btn float-right" id='btnclearphys'>Clear</button>
          </div>
        </div>
      </form>
    </div>
    <!-- end of client physical exam results -->
    <!-- add client initial screening results -->
    <div id="div_donoraddinitial" style="display:none; margin-top: -20px">
      <h4 style="font-family: 'Roboto-Regular'; margin-bottom: 20px;"><span class="badge badge-pill badge-dark mr-3">3</span>Initial Screening</h4><hr>
      <form method="POST" name = "adddonorinitexam" action="savedonorinitexam.php">
        <input type="hidden" id="clientId_init" name ="clientId_init">
        <div class="col-md-5">
          <div class="form-group">
            <label for="date_init">Date Screened</label>
            <input type="date" name="date_init" value=<?php echo $datenow ?> required>
          </div>
        </div>
        <table class = "table table-striped">
          <thead>
            <tr>
              <th>Blood Component</th>
              <th>Result</th>
              <th>Remarks</th>
              <th>Screener</th>
              <th>Verifier</th>

            </tr>
          </thead>
          <tbody>
            <?php
            include("connections.php");

            $fetch_components = mysqli_query($connections,"SELECT * FROM tblbloodcomponent WHERE stfBloodComponentStatus = 'Active'");

            if(mysqli_num_rows($fetch_components)>0)
            {
              while ($row = mysqli_fetch_assoc($fetch_components)){
                $bloodcomponentid = $row['intBloodComponentId'];
                $componentname = $row['strBloodComponent'];
                ?>
                <input type="hidden" value="<?php echo $bloodcomponentid; ?>" name ='hidden_ID'>
                <tr>
                  <td><?php echo $componentname; ?></td>
                  <td>  <input type="text" class="form-control" placeholder="Enter Result" name = "BC_result<?php echo $bloodcomponentid; ?>" id = "BC_result<?php echo $bloodcomponentid; ?>" required> </td>
                  <td>
                    <label class="radio-inline"><input type="radio" name="BC_remarks<?php echo $bloodcomponentid; ?>" id="BC_remarks<?php echo $bloodcomponentid; ?>" value="Passed" required>Passed</label>
                    <label class="radio-inline"><input type="radio" name="BC_remarks<?php echo $bloodcomponentid; ?>" id="optradio<?php echo $bloodcomponentid; ?>" value="Failed" required>Failed</label>
                  </td>
                  <td>
                    <select class="form-control" name="BC_screener<?php echo $bloodcomponentid; ?>" id="BC_screener<?php echo $bloodcomponentid; ?>" required>
                      <?php
                      include("connections.php");

                      $fetch_staff = mysqli_query($connections, " SELECT CONCAT(strEmployeeFirstName,' ',strEmployeeMiddleName,' ',strEmployeeLastName) AS 'Fullname'
                                                                  FROM tblemployee WHERE stfEmployeeStatus = 'Active'
                                                                  ");

                      if(mysqli_num_rows($fetch_staff) > 0 ){
                        while($row = mysqli_fetch_assoc($fetch_staff)){
                          $fullname = $row["Fullname"];

                          ?>
                          <option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>
                          <?php
                        }

                        }

                      ?>
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="BC_verifier<?php echo $bloodcomponentid; ?>" id="BC_verifier<?php echo $bloodcomponentid; ?>" required>
                      <?php
                      include("connections.php");

                      $fetch_staff = mysqli_query($connections, " SELECT CONCAT(strEmployeeFirstName,' ',strEmployeeMiddleName,' ',strEmployeeLastName) AS 'Fullname'
                                                                  FROM tblemployee WHERE stfEmployeeStatus = 'Active'
                                                                  ");

                      if(mysqli_num_rows($fetch_staff) > 0 ){
                        while($row = mysqli_fetch_assoc($fetch_staff)){
                          $fullname = $row["Fullname"];

                          ?>
                          <option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>
                          <?php
                        }

                        }

                      ?>
                    </select>
                  </td>

                </tr>
                <?php
              }
            }
            ?>
          </tbody>
        </table>
        <button type="submit" class="btn btn-success ml-1 float-right" id='donorinitrecord_save'>Save</button>
      </form>
    </div>
    <!-- end of add initial screening results -->
    <!-- add serological screening -->
    <div id="div_donoraddserological" style="display: none; padding-bottom: 60px; margin-top: -20px">
      <h4 style="font-family: 'Roboto-Regular'; margin-bottom: 20px;"><span class="badge badge-pill badge-dark mr-3">4</span>Serological Screening</h4><hr>
      <form method="POST" name = "adddonorseroexam" action="savedonorseroexam.php">
        <input type="hidden" id="clientId_sero" name ="clientId_sero">
        <div class="col-md-5">
          <div class="form-group">
            <label for="date_sero">Date Screened</label>
            <input type="date" name="date_sero" value=<?php echo $datenow ?> required>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <label for="date_sero">Blood Bag</label>
            <input type="text" id ="bloodbag_underquarantine" class = "form-control" name = "bloodbag_underquarantine" readonly required>
          </div>
        </div>
        <table class = "table table-striped">
          <thead>
            <tr>
              <th>Disease</th>
              <th>Result</th>
              <th>Screener</th>
              <th>Verifier</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include("connections.php");

            $fetch_disease = mysqli_query($connections,"SELECT * FROM tbldisease WHERE stfDiseaseStatus = 'Active'");
            $fetch_diseasecount = mysqli_query($connections,"SELECT COUNT(intDiseaseId) AS diseasecount FROM tbldisease WHERE stfDiseaseStatus = 'Active'");

              while($row = mysqli_fetch_assoc($fetch_diseasecount)){
                $diseasecount = $row['diseasecount'];
              }

            if(mysqli_num_rows($fetch_disease)>0)
            {
              while ($row = mysqli_fetch_assoc($fetch_disease)){
                $diseaseid = $row['intDiseaseId'];
                $diseasename = $row['strDisease'];

                ?>
                <input type ="hidden" value="<?php echo $diseaseid ?>" name ='hidden_ID' id='hidden_ID'>
                <input type ="hidden" value="<?php echo $diseasecount ?>" id ='hidden_count'>
                <tr>
                  <td><?php echo $diseasename; ?></td>
                  <td>  <input type="number" step = 'any' class="form-control d_remarks" placeholder="Enter Remarks" name = "D_remarks<?php echo $diseaseid; ?>" id = "<?php echo $diseaseid; ?>"  required> </td>
                  <td>
                    <select class="form-control" name="D_screener<?php echo $diseaseid; ?>" id="D_screener<?php echo $diseaseid; ?>" required>
                      <?php
                      include("connections.php");

                      $fetch_staff = mysqli_query($connections, " SELECT CONCAT(strEmployeeFirstName,' ',strEmployeeMiddleName,' ',strEmployeeLastName) AS 'Fullname'
                                                                  FROM tblemployee WHERE stfEmployeeStatus = 'Active'
                                                                  ");

                      if(mysqli_num_rows($fetch_staff) > 0 ){
                        while($row = mysqli_fetch_assoc($fetch_staff)){
                          $fullname = $row["Fullname"];

                          ?>
                          <option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>
                          <?php
                        }

                        }

                      ?>
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="D_verifier<?php echo $diseaseid; ?>" id="D_verifier<?php echo $diseaseid; ?>" required>
                      <?php
                      include("connections.php");

                      $fetch_staff = mysqli_query($connections, " SELECT CONCAT(strEmployeeFirstName,' ',strEmployeeMiddleName,' ',strEmployeeLastName) AS 'Fullname'
                                                                  FROM tblemployee WHERE stfEmployeeStatus = 'Active'
                                                                  ");

                      if(mysqli_num_rows($fetch_staff) > 0 ){
                        while($row = mysqli_fetch_assoc($fetch_staff)){
                          $fullname = $row["Fullname"];

                          ?>
                          <option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>
                          <?php
                        }

                        }

                      ?>
                    </select>
                  </td>
                  <!--<td>
                    <label class="radio-inline"><input type="radio" name="optradiosero<?php echo $diseaseid; ?>" id="optradiosero<?php echo $diseaseid; ?>" value="Passed" required>Negative</label>
                    <label class="radio-inline"><input type="radio" name="optradiosero<?php echo $diseaseid; ?>" id="optradiosero<?php echo $diseaseid; ?>" value="Failed" required>Positive</label>
                  </td>-->
                  <td>
                    <button type = "button" class ="btn btn-danger" disabled style="display:none;" id = "remarkspositive<?php echo $diseaseid; ?>" >POSITIVE</button>
                    <button type = "button" class ="btn btn-success" disabled style="display:none;" id = "remarksnegative<?php echo $diseaseid; ?>" >NEGATIVE</button>
                  </td>
                </tr>
                <?php
              }
            }
            ?>
          </tbody>
        </table>
        <!--<input type="text" class="form-control" placeholder="Enter Phlebotomist" name = "D_phlebotomist" id = "D_phlebotomist" required>-->
        <label for="D_phlebotomist">Phlebotomist</label>
        <select class="form-control" name="D_phlebotomist" id="D_phlebotomist" required>
          <?php
          include("connections.php");

          $fetch_staff = mysqli_query($connections, " SELECT CONCAT(strEmployeeFirstName,' ',strEmployeeMiddleName,' ',strEmployeeLastName) AS 'Fullname'
                                                      FROM tblemployee WHERE stfEmployeeStatus = 'Active'
                                                      ");

          if(mysqli_num_rows($fetch_staff) > 0 ){
            while($row = mysqli_fetch_assoc($fetch_staff)){
              $fullname = $row["Fullname"];

              ?>
              <option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>
              <?php
            }

            }

          ?>
        </select>
        <button type="submit" class="btn btn-success mt-2 float-right" id='donorserorecord_save'>Save</button>
      </form>
    </div>
    <!-- end add serological -->
  </div>
</div>
</div>
</div>
<!-- end of page content -->
<!-- modal declaration -->
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
              <input type="text" class="form-control" id='clientfname' name ='clientfname' >
            </div>
            <div class="form-group">
              <label for="clientminit">Middle Name</label>
              <input type="text" class="form-control" id='clientminit' name ='clientminit'>
            </div>
            <div class="form-group">
              <label for="clientlname">Last Name</label>
              <input type="text" class="form-control" id='clientlname' name ='clientlname'>
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
              <select class ='form-control' name='clientsex' id = 'clientsex' disabled>
                <option value='Male'>Male</option>
                <option value='Male'>Female</option>
              </select>
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
                    <option value="<?php echo $blood_typeid ?>"><?php echo $blood_type . " " . $rhesus ?></option>
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
              <label for="clientbday">Birthday</label>
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

<div class="modal fade" id="chooseStorageModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form name ='change_storageForm' id = 'change_storageForm' method='post'>
              <div class="form-group">
                <label for="bloodbag_underquarantine2">Underquarantined Blood</label>
                <input type="text" id ="bloodbag_underquarantine2" class = "form-control" name = "bloodbag_underquarantine2" readonly required>
              </div>

                <div class="form-group">
                  <label for="chosenStorage">Choose a Storage</label>
                <select class="form-control" name="chosenStorage" id="chosenStorage" required>
                  <?php
                  include("connections.php");

                  $fetch_storage = mysqli_query($connections, " SELECT intStorageId,intStorageCapacity,strStorageName FROM tblstorage WHERE intStorageTypeId = 2");

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
      </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-success" id="submit_changestorage">Save</button>
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
<script type="text/javascript" src="js/donorrecords-tab.js"></script>
<script type="text/javascript" src="js/waves.min.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/notification.js"></script>
<script type="text/javascript">
//add active class to current tab
$('#donorrecordstab').addClass("active");

$(document).ready(function(){
fetch_table();
check_expiringbloodbags();
check_seroremarks();

function check_seroremarks(){
/*  var i;
  var diseasecount = $("#hidden_count").val();
  for( i = 1; i <= diseasecount; i++){
      console.log(i);
    $("#D_remarks"+i).change(function(){
      var input = $("#D_remarks"+i).val();
      console.log(i);
    });
  }*/
  $(".d_remarks").change(function(){
    var diseasecount = $(this).attr("id");
    var input = parseFloat($(this).val());
    console.log(input);

if(input <= 1.0 && input >= 0.1){
$("#remarkspositive"+diseasecount).hide();
$("#remarksnegative"+diseasecount).show();
}else{
$("#remarkspositive"+diseasecount).show();
$("#remarksnegative"+diseasecount).hide();
}

  });

}

function check_expiringbloodbags(){
  $.ajax({
    type: "POST",
    url: "blood-related/check_expiringbloodbags.php",
    complete: function(){
      setTimeout(check_expiringbloodbags, 60000);
    }
  });
}
//setTimeout(fetch_table, 5000);
  function fetch_table(){
  var dataTable = $('#tbl_donorrecords').DataTable({
    "processing" : false,
    "serverSide" : true,
    "ajax" : {
      url: "people-related/fetch_donorrecords.php",
      type: "POST",
    /*  complete: function() {
            setTimeout(dataTable.ajax.reload(), 5000);
          }*/
    }

  });
  setInterval(function() {
dataTable.ajax.reload()
}, 60000 );
}


});
</script>
</body>
</html>
