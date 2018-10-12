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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Blood Component</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
        include "employeeSidebar.php";
      ?>

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
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
<script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/notification.js"></script>
<!-- <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="js/responsive.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="js/survey-tab.js"></script>
</body>
</html>
