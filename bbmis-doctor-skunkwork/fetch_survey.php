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
      <!-- header -->
      <div class="col-md-10 fixed-top offset-md-2 header">
        <?php
         include "fetchEmpAcc.php";
         include "employeeNavbar.php";
        ?>
       <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Survey</h5>
     </div>
     <!-- SIDE NAVIGATION -->
     <?php
       include "employeeSidebar.php";
     ?>
     <!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <h4 style="font-family:'Nunito-Regular'">Survey Questions</h4>
          <div style="margin-top: -15px;">
            <?php
            include("connections.php");

            $selectedVer = $_GET["selected"];

            $questions = mysqli_query($connections,"SELECT *
              FROM tblquestion
              WHERE decQuestionVersion = $selectedVer");
              $first_id_qry = mysqli_query($connections,"SELECT intQuestionId FROM tblquestion WHERE decQuestionVersion = $selectedVer ORDER BY intQuestionId DESC LIMIT 1");

              while ($row2 = mysqli_fetch_assoc($first_id_qry)) {
                $first_id = $row2["intQuestionId"];
              }

              if(mysqli_num_rows($questions) > 0){

                ?>

                <form method = 'POST' action = 'editquestion.php' id = 'survey' name = 'survey'>
                  <table class='table table-bordered mt-5 text-center' id='tblsurvey'>
                    <input type="hidden" id='hiddensurveyversion' value='<?php echo $selectedVer;?>'>
                    <thead>
                      <tr>
                        <th>Question</th>
                        <th>Question Type</th>
                        <th>Question Category</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <?php
                    while($row = mysqli_fetch_assoc($questions)){
                      $id = $row["intQuestionId"];
                      $question = $row["txtQuestion"];
                      $type = $row["stfQuestionType"];
                      $categoryID = $row["intQuestionCategoryId"];

                      $getcategorystring = mysqli_query($connections,"SELECT stfQuestionCategory FROM tblquestioncategory WHERE intQuestionCategoryId = $categoryID");
                      while ($row3 = mysqli_fetch_assoc($getcategorystring)) {
                        $category = $row3["stfQuestionCategory"];
                      }

                      ?>

                      <tbody>
                        <tr id = '<?php echo $row['intQuestionId'];?>'>
                          <td><textarea class='form-control' value ='<?php echo $question; ?>' name='question<?php echo $id; ?>' id='question<?php echo $id; ?>' readonly><?php echo $question; ?></textarea></td>
                          <td><input type = 'text' value = '<?php echo $type; ?>' name = 'type<?php echo $id; ?>' id='type<?php echo $id; ?>' readonly></td>
                          <td><input type = 'text' value = '<?php echo $category; ?>' name = 'category<?php echo $id;?>' id='category<?php echo $id; ?>' readonly></td>
                          <td>
                            <button type='button' class='btn' data-toggle='modal' data-target='#editsurveyitem' data-id='<?php echo $row['intQuestionId'];?>'>Edit</button> <button type='button' class='btn btn-danger' data-id='<?php echo $row['intQuestionId'];?>'>Delete</button>
                          </td>
                        </tr>
                      </tbody>

                      <?php
                    }
                    ?>

                  </table>
                </form>

              </br></br>

              <?php
            }
            ?>
          </div>
          <div>
            <button type = 'button' class='btn btn-success float-right' id = 'add_question' data-toggle='modal' data-target='#addsurveyitem' style="margin-top: -20px">Add a Question</button>
            <button type = 'button' class='btn btn-success float-right mb-2' id = 'save_changes' style = 'display : none;'>Save Changes</button>
            <button type = 'button' class='btn btn-primary float-right mr-2' id = 'setasactive' style="margin-top: -20px;">Set Survey as Active</button>
          </div>
        </div>
        <!-- ======== -->
      </div>
    </div>
  </div>
  <!-- end of page content -->
  <!-- modal declaration -->
  <!-- edit survey question -->
  <div class="modal fade" id="editsurveyitem" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editQuestionTitle">Edit Question</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="container-fluid">
            <div class="form-group">
              <label for="editQuestion">Question</label>
              <input type="hidden" name = "question_id" id = "question_id">
              <input type="text" class="form-control" id='editQuestion' name ='editQuesion'>
            </div>
            <div class="form-group">
              <label for="editquestiontype">Question Type</label>
              <select id = "editquestiontype" name="editquestiontype" >
                <option selected disabled>Select Question Type</option>
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
            <div class="form-group">
              <label for="editquestioncategory">Question Category</label>
              <select id = "editquestioncategory" name = 'editquestioncategory'>
                <option selected disabled>Select Question Category</option>
                <?php
                //include("../connections.php");

                $getcategories = mysqli_query($connections,"SELECT * FROM tblquestioncategory WHERE stfQuestionCategoryStatus = 'Active'");
                while($row = mysqli_fetch_assoc($getcategories)){
                  $category = $row["stfQuestionCategory"];
                  ?>
                  <option value = "<?php echo $category;?>"><?php echo $category;?></option>
                  <?php
                }
                ?>
              </select>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btnsaveeditquestion">Confirm</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end of edit survey question -->
  <!--Add qustion to survey modal-->
  <div class="modal fade-lg" id="addsurveyitem" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addQuestionTitle">Add Question</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="text" placeholder="Insert Question Here" id ="add_question_text" class="form-control">

          <select id = "add_questiontype" name="add_questiontype">
            <option selected disabled>Select Question Type</option>
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

          <select id = "add_questioncategory" name = "add_questioncategory">
            <option selected disabled>Select Question Category</option>
            <?php
            //include("../connections.php");

            $getcategories = mysqli_query($connections,"SELECT * FROM tblquestioncategory WHERE stfQuestionCategoryStatus = 'Active'");
            while($row = mysqli_fetch_assoc($getcategories)){
              $category = $row["stfQuestionCategory"];
              ?>
              <option value = "<?php echo $category;?>"><?php echo $category;?></option>
              <?php
            }
            ?>
          </select>

          <button id ="add_submit_item">Add</button>
        </div>

        <div id = "add_survey_items">
          <table id = "add_table_questions">
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
          <button type="button" class="add_delete-row">Delete Row</button>
          <button type="button" id = "add_save">Add to Survey</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end of modal -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
  <script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <!-- <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="js/responsive.bootstrap4.min.js"></script> -->
  <!-- <script type="text/javascript" src="../js/fetchsurvey.js"></script> -->
  <script type="text/javascript">
  $(document).ready(function(){
    editsurvey();
    add_deleterow();
    addrow();
    saveeditedquestion();
    saveeditedsurvey();
    var tr_number_add = 0;
    var deleted_rows = 0;
    $('#surveytab').addClass("active");
    function editsurvey(){
      $('#editsurveyitem').on('show.bs.modal', function(e) {
        $("#save_changes").show();
        var rowid = $(e.relatedTarget).data('id');
        alert(rowid);
        var question = $('#question'+rowid).val();
        var type = $('#type'+rowid).val();
        var category = $('#category'+rowid).val();

        $('#question_id').val(rowid);
        $('#editQuestion').val(question);
        $('#editquestiontype').val(type);
        $('#editquestioncategory').val(category);
      });
    }
    function add_deleterow(){
      $(".add_delete-row").click(function(){
        $("#add_table_questions tbody").find('input[name="record"]').each(function(){
          if($(this).is(":checked")){
            $('#add_submit_item').attr("disabled", false);
            $(this).parents("tr").remove();
          }
        });
      });
    }
    //------------------------------------------------------------------------------------------------------------------------
    function addrow(){
      var rowid;

      $('#add_submit_item').click(function() {
        $(this).attr("disabled", true);
        var add_chosenType = $('#add_questiontype option:selected').val();
        var add_chosenCategory = $('#add_questioncategory option:selected').val();
        var add_question = $("#add_question_text").val();
        rowid = parseInt($('#tblsurvey tr:last').attr('id')) + 1;
        console.log(rowid);
        var add_total_row = "<tr><td><input type='checkbox' name='record'></td><td>" + "<input type ='text' id = 'question_add"+rowid+"' "+"value = '"+ add_question +"'>" + "</td><td>" + "<input type ='text' id = 'category_add"+rowid+"' "+"value = '" + add_chosenCategory +"'>" + "</td><td>" + "<input type ='text' id = 'type_add"+rowid+"' "+"value = '" + add_chosenType + "'>" + "</td></tr>";

        console.log(add_total_row);
        $("#add_table_questions tbody").append(add_total_row);
        $("#items input").val("");
      });

      //function addtoselectedsurvey(){

      $("#add_save").click(function(e){
        var rowCount = $('#add_table_questions tr').length;
        rowid = $('#tblsurvey tr:last').attr('id');
        var counter = parseInt(rowid) + (parseInt(rowCount) - 1);
        console.log(rowCount);
        console.log(rowid);
        console.log(counter);
        for(var i = parseInt(rowid) + 1; i <= counter; i++){
          var new_chosenType = $("#type_add"+i).val();
          var new_chosenCategory = $("#category_add"+i).val();
          var new_question = $("#question_add"+i).val();
          console.log(new_question+new_chosenType+new_chosenCategory);
          console.log(tr_number_add);

          var add_total_row =  "<tr id ='"+i+"'><td><textarea class='form-control' value ='"+new_question+"' name='question"+i+"' id='question"+i+"' readonly>"+new_question+"</textarea></td>"+"<td><input type = 'text' value = '"+new_chosenType+"' name = 'type"+i+"' id='type"+i+"' readonly></td>"+"<td><input type = 'text' value = '"+new_chosenCategory+"' name = 'category"+i+"' id='category"+i+"' readonly></td>"+
          "<td><button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editsurveyitem' data-id='"+i+"'>Edit</button> <button type='button' class='btn btn-danger' data-id='"+i+"'>Delete</button></td></tr>"

          console.log(add_total_row);
          //$("#tblsurvey :last-child").append(add_total_row);
          $("#save_changes").show();
          $('#tblsurvey tr:last').after(add_total_row);
          $('#add_questiontype').val("Select Question Type");
          $('#add_questioncategory').val("Select Question Category");
          $("#add_question_text").val("");

          $("#add_table_questions tbody").find('input[name="record"]').each(function(){
            //  if($(this).is(":checked")){
            $('#add_submit_item').attr("disabled", false);
            $(this).parents("tr").remove();

            //    }
          });
        }

      });
      //}
    }
    //------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------



    function saveeditedquestion(){
      $("#btnsaveeditquestion").click(function(e){
        e.preventDefault(e);
        var confirm_input = confirm("Are you sure?");
        var id = $('#question_id').val();
        var question = $('#editQuestion').val();
        var type = $('#editquestiontype').val();
        var category = $('#editquestioncategory').val();
        if (confirm_input == true){
          $('#question'+id).val(question);
          $('#type'+id).val(type);
          $('#category'+id).val(category);
          alert("Changes appended");
        }
        else{
          alert("Confirmation Cancelled");
          return false;
        }
      });
    }

    function saveeditedsurvey(){
      $("#save_changes").click(function(e){
        e.preventDefault;
        var formdata = $("form[name ='survey']").serialize();
        var selected = $('#hiddensurveyversion').val();
        var rowCount = $('#tblsurvey tr').length;
        var confirm_input = confirm("Are you sure?");
        rowCount = rowCount - 1;
        var allrows = rowCount+deleted_rows;
        console.log(formdata);
        console.log(allrows);
        if (confirm_input == true){
          $.ajax({
            url:"survey-related/edit_question.php",
            type:"POST",
            data:{formdata:formdata,
              selected:selected,
              allrows:allrows},
              dataType: "json",
              success:function(data){
                //console.log(data);
                alert("Changes had been saved the survey is named :"+data.decQuestionVersion);
                // console.log(data.intQuestionVersion);
                window.location.href = "survey-tab.php";
              },
              error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                alert(err.Message);
              }
            });
          }
          else{
            alert("Confirmation Cancelled");
            return false;
          }
        });
      }

      $('#tblsurvey tbody').on('click','.btn-danger',function(){
        var confirm_delete = confirm("Are you sure you want to delete?");

        if(confirm_delete == true){
          $("#save_changes").show();
          $(this).closest('tr').remove();
          deleted_rows = deleted_rows + 1;
          console.log(deleted_rows);
        }
        else{
          alert("Confirmation Cancelled");
          return false;
        }
      });

      $('#setasactive').click(function(){
        var survey = $("#hiddensurveyversion").val();
        var confirm_changes = confirm("Are you sure you want to change the survey to "+survey+"?");
        console.log("hi");
        if(confirm_changes == true){
          $.ajax({
            url:"survey-related/change_activesurvey.php",
            type:"POST",
            data:{survey:survey},
            success:function(data){
              console.log(data);
              alert("The survey in use is "+data);
              window.location.href = "survey-tab.php";
            }

          });
        }else{
          alert("Confirmation Cancelled");
          return false;
        }

      });

  /*    $("#tblsurvey tbody").sortable({
      connectWith: ".table tbody"
    }).disableSelection();*/


    });

    </script>
  </body>
  </html>
