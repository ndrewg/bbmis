<div class="col-md-2 sidebar container-fluid d-none d-sm-none d-md-block ">
  <div class="system-title">
    <img class="float-left" src="images/logoinwhite.png" alt="logo" style="width: 75px;">
    <h4 class="float-left mt-2" style="color:rgb(250,250,250); font-family: 'Nunito-Regular'">Re-Feel</h4>
  </div>

  <div class='container-fluid pt-3'>
    <div class='container text-center'>
      <img src='../img/<?php echo $varImg ?>' class="img-fluid" alt="donor image" style="width:45px; border-radius:60px; margin-top:10px; vertical-align: center;">
    </div>
    <div class='container text-center'>
      <div class='container'>

        <?php
        echo 'Welcome, ' . $varFname . '!';
        ?>

      </div>
      <div class='container'>
        <b>
          <?php
          echo $varRole;
          ?>
        </b>
      </div>
    </div>
  </div>
  <!-- <p class=""></p> -->
  <hr>
  <div class="nav flex-column" id ="sidebar">
    <h6 class="collapsibleheader" data-toggle="collapse" data-target="#home-tabs" aria-expanded="false" aria-controls="home-tabs">Home</h6>
    <div class="collapse show" id="home-tabs">
      <a href="graphs-tab.php" class="nav-link nav-item " id="graphstab"><i class="fas fa-chart-line mr-1"></i> Graphs</a>
      <a href="donorlist-tab.php" class="nav-link nav-item" id="donorlisttab"><i class="fas fa-list mr-1"></i> Donor List</a>
    </div>
    <h6 class="collapsibleheader" id="collapsibleheader" data-toggle="collapse" data-target="#maintenance-tabs" aria-expanded="false" aria-controls="maintenance-tabs">Maintenance</h6>
    <div class="collapse show" id="maintenance-tabs">
      <a href="bloodtype-tab.php" class="nav-link nav-item" id="bloodtypetab"><i class="fas fa-heartbeat"></i> Blood Type</a>
      <a href="bloodcomponent-tab.php" class="nav-link nav-item" id="bloodcomponenttab"><img src="css/glyphicon/si-glyph-blood-bag.svg" style="width:20px;"> Blood Component</a>
      <a href="preservatives-tab.php" class="nav-link nav-item" id="preservativetab"><img src="css/glyphicon/si-glyph-blood-bag.svg" style="width:20px;"> Preservative</a>
      <a href="disease-tab.php" class="nav-link nav-item" id="diseasetab"><img src="css/glyphicon/si-glyph-heart-delete.svg" style="width:17px;"> Disease</a>
      <a href="donoreditrequests-tab.php" class="nav-link nav-item" id="donoreditrequeststab"><img src="css/glyphicon/si-glyph-document-checked.svg" style="width: 17px" alt=""> Donor Edit Requests</a>
      <a href="survey-tab.php" class="nav-link nav-item" id="surveytab"><i class="fas fa-file-alt mr-1"></i> Survey</a>
      <a href="category-tab.php" class="nav-link nav-item" id="surveycategorytab"><i class="far fa-file-alt"></i> Survey Category</a>
      <a href="storage-tab.php" class="nav-link nav-item" id="storagetab"><i class="fas fa-box-open"></i> Storage</a>
      <a href="staff-tab.php" class="nav-link nav-item" id="stafftab"><i class="fas fa-user-cog mr-1"></i> Staff</a>
      <a href="donor-tab.php" class="nav-link nav-item" id="donortab"><i class="fas fa-user-cog mr-1"></i> Donor</a>
    </div>
    <h6 class="collapsibleheader" data-toggle="collapse" data-target="#transaction-tabs" aria-expanded="false" aria-controls="transaction-tabs">Transaction</h6>
    <div class="collapse show" id="transaction-tabs">
      <a href="donorrecords-tab.php" class="nav-link nav-item" id="donorrecordstab"><i class="fas fa-file-medical-alt mr-1"></i> Donor Records</a>
      <a href="bloodinventory-tab.php" class="nav-link nav-item" id="bloodinventorytab"><i class="fas fa-first-aid mr-1"></i> Blood Inventory</a>
    </div>
    <a href="queries-tab.php" class="nav-link nav-item" id="queriestab"><i class="fas fa-search-plus"></i> Queries</a>
    <a href="reports-tab.php" class="nav-link nav-item" id="reportstab"><i class="fas fa-file-medical"></i> Reports</a>
    <!-- <h6 class="collapsibleheader" data-toggle="collapse" data-target="#queriesreports-tabs" aria-expanded="false" aria-controls="queriesreports-tabs">Queries and Reports</h6> -->
    <!-- <div class="collapse show" id="queriesreports-tabs">
      <a href="donorrecordsreports-tab.php" class="nav-link nav-item" id="donorrecordsreportstab"><i class="fas fa-file-medical-alt mr-1"></i> Donor</a>
      <a href="bloodinventoryreports-tab.php" class="nav-link nav-item" id="bloodinventoryreportstab"><i class="fas fa-first-aid mr-1"></i> Blood Inventory</a>
    </div> -->
  </div>

</div>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
// $(document).ready(function(){
  var employee_type = "<?php echo $varRole; ?>";

  if (employee_type == 'Staff'){
    $('#bloodtypetab').hide();
    $('#bloodcomponenttab').hide();
    $('#diseasetab').hide();
    $('#donoreditrequeststab').hide();
    $('#surveytab').hide();
    $('#surveycategorytab').hide();
    $('#storagetab').hide();
    $('#stafftab').hide();
    $('#collapsibleheader').hide();
    $('#maintenance-tab').hide();
  }
// });
</script>
