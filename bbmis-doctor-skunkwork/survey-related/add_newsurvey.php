<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../bs4/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- header -->
      <div class="col-md-10 fixed-top offset-md-2 header">
        <button type="button" class="btn float-right text-white text-center" style="background-color: rgb(234,72,127); margin-top: 3px; width: 65px; height: 30px;">Logout</button>
        <!-- notification -->
        <div class="dropdown show">
          <a href="#" class="float-right mr-3 text-white dropdown-toggle" id="notifications" style="margin-top: 10px;" data-toggle="dropdown">
            <span class="badge badge-pill count" style="border-radius:10px;"></span>
            <i class="fas fa-bell"></i>
          </a>
          <div class="dropdown-menu" aria-labelledby="notifications">
            <a class="dropdown-item" href="#">duh</a>
            <a class="dropdown-item" href="#">hello</a>
            <a class="dropdown-item" href="#">b0s</a>
          </div>
        </div>
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Survey</h5>
      </div>
      <!-- end header -->
      <!-- SIDE NAVIGATION -->
      <div class="col-md-2 sidebar container-fluid">
        <div class="system-title">
          <h3 style="color:rgb(250,250,250);">logohere</h3>
        </div>
        <img src="../images/ablirdp.jpg" class="img-fluid" alt="donor image" style="width:45px; border-radius:60px; margin-top:10px;"> <span class="ml-2 donorname">Atty Gadon</span>
        <!-- <p class=""></p> -->
        <hr>
        <div class="nav flex-column">
          <h6 class="collapsibleheader" data-toggle="collapse" data-target="#home-tabs" aria-expanded="false" aria-controls="home-tabs">Home</h6>
          <div class="collapse.show" id="home-tabs">
            <a href="../graphs-tab.php" class="nav-link nav-item" id="graphstab"><i class="fas fa-chart-line mr-1"></i> Graphs</a>
            <a href="../donorlist-tab.php" class="nav-link nav-item" id="donorlisttab"><i class="fas fa-list mr-1"></i> Donor List</a>
          </div>
          <h6 class="collapsibleheader" data-toggle="collapse" data-target="#maintenance-tabs" aria-expanded="false" aria-controls="maintenance-tabs">Maintenance</h6>
          <div class="collapse.show" id="maintenance-tabs">
            <a href="../staff-tab.php" class="nav-link nav-item" id="stafftab"><i class="fas fa-user-cog mr-1"></i> Staff</a>
            <a href="../survey-tab.php" class="nav-link nav-item active" id="surveytab"><i class="fas fa-file-alt mr-1"></i> Survey</a>
            <a href="../disease-tab.php" class="nav-link nav-item" id="diseasetab"><img src="../css/glyphicon/si-glyph-heart-delete.svg" style="width:21px;"> Disease</a>
            <a href="../bloodcomponent-tab.php" class="nav-link nav-item mr-2" id="bloodcomponenttab"><img src="../css/glyphicon/si-glyph-blood-bag.svg" style="width:22px;">Blood Component</a>
            <a href="../category-tab.php" class="nav-link nav-item "><img src="" alt=""> Survey Category</a>
            <a href="../bloodtype-tab.php" class="nav-link nav-item"><img src="" alt=""> Blood Type</a>
            <a href="../storage-tab.php" class="nav-link nav-item"><img src="" alt=""> Storage</a>
            <a href="../donoreditrequests-tab.php" class="nav-link nav-item"><img src="" alt=""> Donor Edit Requests</a>
          </div>
          <h6 class="collapsibleheader" data-toggle="collapse" data-target="#transaction-tabs" aria-expanded="false" aria-controls="transaction-tabs">Transaction</h6>
          <div class="collapse.show" id="transaction-tabs">
            <a href="../bloodinventory-tab.php" class="nav-link nav-item" id="bloodinventorytab"><i class="fas fa-first-aid mr-1"></i> Blood Inventory</a>
            <a href="../donorrecords-tab.php" class="nav-link nav-item" id="donorrecordstab"><i class="fas fa-file-medical-alt mr-1"></i> Donor Records</a>
          </div>
        </div>
      </div>
      <!-- end side navigation -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <div id = "items">
            <div class="form-group">
              <label for="question_text">Question :</label>
              <input type="text" class = "form-control" placeholder="Insert Question Here" id ="question_text">
            </div>
            <div class="form-row">
              <div class="col">
                <label for="questiontype">Question Type:</label>
                <select id = "questiontype" name="questiontype" class = "form-control">
                  <option value = "Yn">Yes Or no</option>
                  <option value = "YnDate">Yes Or no & Date</option>
                  <option value = "YnQua">Yes Or no & Qua</option>
                  <option value = "YnStr">Yes Or no & Str</option>
                  <option value = "YnDateQua">Yes Or no & Date & Quantity</option>
                  <option value = "YnDateStr">Yes Or no & Date & String</option>
                  <option value = "YnQuaStr">Yes Or no & Quantity & String</option>
                  <option value = "YnDateQuaStr">Yes Or no & Date & Quatity & String</option>
                  <option value = "Date">Date</option>
                  <option value = "DateQua">Date & Quantity</option>
                  <option value = "DateStr">Date & String</option>
                  <option value = "DateQuaStr">Date & Quantity & String</option>
                  <option value = "Qua">Quantity</option>
                  <option value = "QuaStr">Quantity & String</option>
                  <option value = "Str">String</option>
                </select>
              </div>

              <div class="col">
                <label for="questioncategory">Question Category:</label>
                <select id = "questioncategory" name = questioncategory class = "form-control">
                  <?php
                  include("../connections.php");

                  $getcategories = mysqli_query($connections,"SELECT * FROM tblquestioncategory WHERE stfQuestionCategoryStatus = 'Active'");
                  while($row = mysqli_fetch_assoc($getcategories)){
                    $category = $row["stfQuestionCategory"];
                    $categoryid = $row["intQuestionCategoryId"]
                    ?>
                    <option value = "<?php echo $categoryid;?>"><?php echo $categoryid."  ".$category;?> </option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>

          </br>
          <button id ="submit_item" class = "btn btn-primary">Add Question</button>
        </div>
        <!-- +++++ -->
        <div id = "survey_items">

          <form method="post" name="save_questions">
            <h4 class="mt-3" style="font-family: 'Nunito-Regular'">Survey Form</h4>
            <table id = "table_questions" class='table table-bordered text-center'>
              <thead>
                <tr>
                  <th>Select</th>
                  <th>Question</th>
                  <th>Question Category</th>
                  <th>Question Type</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
            <button type="button" class="delete-row">Delete Row</button>
            <button type="button" id = "save">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../bs4/assets/js/vendor/popper.min.js"></script>
<script type="text/javascript" src="../bs4/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/dataTables.bootstrap4.min.js"></script>
<!-- <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="js/responsive.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="../js/survey-tab.js"></script>
</body>
</html>
