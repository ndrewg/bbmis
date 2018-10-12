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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Survey Category</h5>
      </div>
      <!-- SIDE NAVIGATION -->
			<?php
				include "employeeSidebar.php";
			?>
		 <!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
          <div class="content-container" style="padding-bottom: 60px">
            <h4 style="font-family:'Nunito-Regular'">Active Categories</h4>
            <table id="tbl_activesurveycategory" class="table table-striped table-bordered text-center" style="width: 100%">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
            <!-- <div id ="surveycategory">
              <?php
              include("connections.php");

              $viewcategory = mysqli_query($connections,"SELECT *
                FROM tblquestioncategory
                WHERE stfQuestionCategoryStatus = 'Active' ");

                if(mysqli_num_rows($viewcategory) > 0){
                  ?>
                  <table class='table table-bordered text-center' id='tblcategory'>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Survey Category Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <?php
                    while($row = mysqli_fetch_assoc($viewcategory)){
                      $sc_id = $row["intQuestionCategoryId"];
                      $sc_name = $row["stfQuestionCategory"];
                      ?>
                      <tbody>
                        <tr>
                          <td><?php echo $sc_id; ?></td>
                          <td><?php echo $sc_name; ?></td>
                          <td>
                            <div class='btn-group'>
                              <button type='button' class='btn btn-success' data-toggle='modal' data-target='#editSurveyCategoryModal' data-id='<?php echo $sc_id; ?>' id='btntbl'>Edit</button>
                              <button type='button' name ='deletecategory' class='btn btn-default' data-toggle='modal' data-target='#viewSurveyCategoryModal' data-id='<?php echo $sc_id; ?>'>View Details</button>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                      <?php
                    }
                    ?>
                  </table>
                <?php } ?>
              </div> -->
              <button type='button' class='btn btn-outline-danger float-right mt-2' data-toggle='modal' data-target='#addSurveyCategoryModal'>Add Survey Category</button>
            </div>
            <div class="content-container" style="margin-top: -20px">
              <h4 style="font-family: 'Nunito-Regular'">Disabled Categories</h4>
              <table id="tbl_inactivesurveycategory" class="table table-bordered table-striped text-center" style="width: 100%">
                <thead>
                  <tr>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
              <!-- <?php
              include("connections.php");

              $viewcategory = mysqli_query($connections,"SELECT *
                FROM tblquestioncategory
                WHERE stfQuestionCategoryStatus = 'Inactive' ");

                if(mysqli_num_rows($viewcategory) > 0){
                  ?>
                  <table class='table table-bordered mt-5 text-center' id='tblcategory'>
                    <thead>
                      <tr style='background-color:#fa4251; color:#fff'>
                        <th>ID</th>
                        <th>Survey Category Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <?php
                    while($row = mysqli_fetch_assoc($viewcategory)){
                      $sc_id = $row["intQuestionCategoryId"];
                      $sc_name = $row["stfQuestionCategory"];
                      ?>
                      <tbody>
                        <tr>
                          <td><?php echo $sc_id; ?></td>
                          <td><?php echo $sc_name; ?></td>
                          <td><button type='button' name ='enablecategory' class='btn btn-default btn-sm ml-2' data-toggle='modal' data-target='#viewSurveyCategoryModal_enable' data-id='<?php echo $sc_id; ?>'>View Details</button></td>
                        </tr>
                      </tbody>
                      <?php
                    }
                    ?>
                  </table>
                <?php }
                ?> -->
              </div>
          </div>
        </div>
      </div>
      <!-- end of page content -->
      <!-- modal declaration -->
      <!-- add survey category modal -->
      <div class="modal fade" id="addSurveyCategoryModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addnewsurveycategoryTitle">Add Survey Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action ="addnewsurveycategory.php" name="form_addnewsurveycategory">
              <div class="modal-body">
                <div class="form-group">
                  <label for="newSurveyCategoryName">Survey Category Name</label>
                  <input type="text" class="form-control" id='newSurveyCategoryName' name ='newSurveyCategoryName' required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btnsavenewsurveycategory">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- edit survey category modal -->
      <div class="modal fade" id="editSurveyCategoryModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editnewsurveycategoryTitle">Edit Survey Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action ="editsurveycategory.php" name="form_editsurveycategory">
              <div class="modal-body">
                <div class="form-group">
                  <label for="editSurveyCategoryName">Survey Category Name</label>
                  <input type="hidden" name = "surveycategory_ID" id = "surveycategory_ID">
                  <input type="text" class="form-control" id='editSurveyCategoryName' name ='editSurveyCategoryName' required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btnsaveeditsurveycategory">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!--View Details-->
      <div class="modal fade" id="viewSurveyCategoryModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="viewnewsurveycategoryTitle">Survey Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action ="deletecategory.php" name="form_viewsurveycategory">
              <div class="modal-body">
                <div class="form-group">
                  <label for="viewSurveyCategoryName">Survey Category Name</label>
                  <input type="hidden" name = "viewsurveycategory_ID" id = "viewsurveycategory_ID">
                  <input type="text" class="form-control" id='viewSurveyCategoryName' name ='viewSurveyCategoryName' readonly>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btnsavedeletesurveycategory">Delete</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- enable category -->
      <div class="modal fade" id="viewSurveyCategoryModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="viewnewsurveycategoryTitle_enable">Survey Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action ="enablecategory.php" name="form_viewsurveycategory_enable">
              <div class="modal-body">
                <div class="form-group">
                  <label for="viewSurveyCategoryName">Survey Category Name</label>
                  <input type="hidden" name = "viewsurveycategory_ID_enable" id = "viewsurveycategory_ID_enable">
                  <input type="text" class="form-control" id='viewSurveyCategoryName_enable' name ='viewSurveyCategoryName_enable' readonly>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btnsaveenablesurveycategory">Enable</button>
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
      <script type="text/javascript" src="js/sweetalert.min.js"></script>
      <script type="text/javascript" src="js/realtime-connection.js"></script>
      <script type="text/javascript" src="js/notification.js"></script>
      <script type="text/javascript">
      //add active class to current tab
      $('#surveycategorytab').addClass("active");

      $(document).ready(function(){
        check_expiringbloodbags();
        fetch_activesurveycategory();
        fetch_inactivesurveycategory();

        function check_expiringbloodbags(){
          $.ajax({
            type: "POST",
            url: "blood-related/check_expiringbloodbags.php",
            complete: function(){
              setTimeout(check_expiringbloodbags, 60000);
            }
          });
        }

        function fetch_activesurveycategory(){
          var dataTable = $('#tbl_activesurveycategory').DataTable({
            "processing" : true,
            "serverSide" : true,
            "ajax" : {
              url : "survey-related/fetch_activesurveycategory.php",
              type: "POST"
            },
            "language" : {
              "emptyTable" : "No active category to show"
            }
          });
        }

        function fetch_inactivesurveycategory(){
          var dataTable = $('#tbl_inactivesurveycategory').DataTable({
            "processing" : true,
            "serverSide" : true,
            "ajax" : {
              url : "survey-related/fetch_inactivesurveycategory.php",
              type: "POST"
            },
            "language" : {
              "emptyTable" : "No inactive category to show"
            }
          });
        }
      });

      $(document).on("submit", "form[name='form_addnewsurveycategory']", function(e){
        e.preventDefault();
        var confirm_input = confirm("Are you sure?");
        var formdata = $("form[name='form_addnewsurveycategory']").serialize();

        if (confirm_input == true){
          $.ajax({
            type: "POST",
            url: 'survey-related/add_newsurveycategory.php',
            data: {formdata,formdata},
            success:function(data){
              if(data == 1){
                alert("Category Added");
                $('#addSurveyCategorytModal').modal('hide');
                $("#addSurveyCategory .modal-body input").val("");
                window.location.href = "category-tab.php";
                //$('#divdonoraddsero').show(600);
              }
              else if(data == 2){
                alert("The Survey Category You Entered Already Exists, Please check the disabled survey categories too.");
                window.location.href = "category-tab.php";
              }
              else if (data == 3) {
                alert("Survey Category is not saved");
                window.location.href = "category-tab.php";
              }
            }
          });
        }
        else{
          alert("Confirmation Cancelled");
          return false;
        }
      });

      $(document).on("show.bs.modal", "#editSurveyCategoryModal", function(e){
        var rowid = $(e.relatedTarget).data('id');
        //alert(rowid);
        $.ajax({
          type: "POST",
          url: 'survey-related/fetch_surveycategory.php',
          data: 'rowid=' + rowid,
          dataType: "json",
          success: function(data){
            $('#surveycategory_ID').val(data.intQuestionCategoryId);
            $('#editSurveyCategoryName').val(data.stfQuestionCategory);
          }
        });
      });

      $(document).on("show.bs.modal", "#viewSurveyCategoryModal", function(e){
        var rowid = $(e.relatedTarget).data('id');
        //alert(rowid);
        $.ajax({
          type: "POST",
          url: 'survey-related/fetch_surveycategory.php',
          data: 'rowid=' + rowid,
          dataType: "json",
          success: function(data){
            $('#viewsurveycategory_ID').val(data.intQuestionCategoryId);
            $('#viewSurveyCategoryName').val(data.stfQuestionCategory);
          }
        });
      });

      $(document).on("show.bs.modal","#viewSurveyCategoryModal_enable", function(e){
        var rowid = $(e.relatedTarget).data('id');
        //alert(rowid);
        $.ajax({
          type: "POST",
          url: 'survey-related/fetch_surveycategory.php',
          data: 'rowid=' + rowid,
          dataType: "json",
          success: function(data){
            $('#viewsurveycategory_ID_enable').val(data.intQuestionCategoryId);
            $('#viewSurveyCategoryName_enable').val(data.stfQuestionCategory);
          }
        });
      });

      $(document).on("submit", "form[name='form_editsurveycategory']", function(e){
        e.preventDefault();
        var confirm_input = confirm("Are you sure?");
        var formdata = $("form[name='form_editsurveycategory']").serialize();

        if (confirm_input == true){
          $.ajax({
            type: "POST",
            url: 'survey-related/edit_surveycategory.php',
            data: {formdata,formdata},
            success:function(data){
              if(data == 1){
                alert("Survey Category Succesfully Edited");
                $('#editSurveyCategoryModal').modal('hide');
                $("#editSurveyCategoryModal .modal-body input").val("");
                window.location.href = "category-tab.php";
                //$('#divdonoraddsero').show(600);
              }
              else if(data == 2){
                alert("The Survey Category You Entered Already Exists");
                window.location.href = "category-tab.php";
              }
              else if (data == 3) {
                alert("Survey Category is not Edited");
                window.location.href = "category-tab.php";
              }
            }
          });
        }
        else{
          alert("Confirmation Cancelled");
          return false;
        }
      });

      $(document).on("click","#btnsavedeletesurveycategory", function(e){
        e.preventDefault();
        var id = $("#viewsurveycategory_ID").val();
        swal({
          title: "Are you sure?",
          text: "You are about to disable this category",
          icon: "info",
          buttons: true,
        })
        //var confirm_delete = confirm("Are you sure?");
        //if(confirm_delete == true){
        .then((willApprove) => {
          if (willApprove) {
            $.ajax({
              type: "POST",
              url: 'survey-related/delete_category.php',
              data: {id:id},
              success:function(data){
                /*  alert("Category has been disabled");
                window.location.href = "category-tab.php";*/
                if(data == "deleted"){
                  swal({
                    title: "",
                    text: "The category is now disabled",
                    icon: "success",
                    buttons: {text:"Okay"},
                  })
                  .then((willApprove) => {
                    if (willApprove) {
                      window.location.href = "category-tab.php";
                    }
                  });
                }else{
                  swal({
                    title: "",
                    text: "The category is not disabled because "+data+" record/s uses this.",
                    icon: "error",
                    buttons: {text:"Okay"},
                  })
                  .then((willApprove) => {
                    if (willApprove) {
                      window.location.href = "category-tab.php";
                    }
                  });
                }
              }
            });
            /*}
            else{
            alert("Confirmation Cancelled");
            return false;
          }*/
        }
        else {
          swal("","Cancelled","info");
        }
      });
    });

    $(document).on("click", "#btnsaveenablesurveycategory", function(e){
      e.preventDefault();
      var id = $("#viewsurveycategory_ID_enable").val();
      var confirm_enable = confirm("Are you sure?");
      if(confirm_enable == true){
        $.ajax({
          type: "POST",
          url: 'survey-related/enable_category.php',
          data: {id:id},
          success:function(data){
            alert("Category has been enabled");
            window.location.href = "category-tab.php";
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
