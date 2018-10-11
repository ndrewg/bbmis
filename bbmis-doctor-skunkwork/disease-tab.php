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
      <div class="col-md-10 fixed-top offset-md-2 header text-white">
        <?php
        include "fetchEmpAcc.php";
        include "employeeNavbar.php";
        ?>
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Disease</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
      include "employeeSidebar.php";
      ?>
      <!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2 mb-5">
        <!-- display active diseases -->
        <div class="content-container">
          <div class="container-fluid" style="padding-bottom: 40px">
            <div class="row">
              <div class="col-md-6">
                <h4 class="nunito mb-3">Monitored Active Diseases</h4>
                <table id='tbl_activedisease' class="table table-striped table-bordered text-center" style="width: 100%">
                  <thead>
                    <tr>
                      <th>Disease Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="col-md-6">
                <h4 class="nunito mb-3">Inactive Diseases</h4>
                <table id='tbl_inactivedisease' class="table table-striped table-bordered text-center">
                  <thead>
                    <tr>
                      <th>Disease Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <button type='button' class='btn btn-outline-danger float-right mt-3' data-toggle='modal' data-target='#addnewdiseaseModal' id='btntbl'><i class="fas fa-plus"></i> Add Disease</button>
          </div>
        </div>
        <!-- end -->
        <!-- display inactive disease -->
        <!-- <div class="content-container" style="margin-top: -10px">
        </div> -->
        <!-- end -->
      </div>
    </div>
  </div>
  <!-- end of page contents -->
  <!-- modal declaration -->
  <!-- add disease modal -->
  <!--Add Disease Modal-->
  <div class="modal fade" id="addnewdiseaseModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addnewdiseaseTitle">Add Disease</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="disease-related/addnewdisease.php" name="form_adddisease">
          <div class="modal-body">
            <div class="form-group">
              <label for="newDiseaseName">Disease Name</label>
              <input type="text" class="form-control" id='newDiseaseName' name ='newDiseaseName' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnsavenewdisease">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- edit disease modal -->
  <div class="modal fade" id="editDiseaseModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDiseaseTitle">Edit Disease</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="editdisease.php" name="form_editdisease">
          <div class="modal-body">
            <div class="form-group">
              <label for="editDiseaseName">Disease Name</label>
              <input type="hidden" name = "disease_ID" id = "disease_ID">
              <input type="text" class="form-control" id='editDiseaseName' name ='editDiseaseName' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnsaveeditdisease">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- view record -->
  <div class="modal fade" id="viewDiseaseModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewDiseaseTitle">Disease</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="deletedisease.php" name="form_viewdisease">
          <div class="modal-body">
            <div class="form-group">
              <label for="editDiseaseName">Disease Name</label>
              <input type="hidden" name = "viewdisease_ID" id = "viewdisease_ID">
              <input type="text" class="form-control" id='viewDiseaseName' name ='viewDiseaseName' readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnsavedeletedisease">Disable</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- enable disease modal -->
  <div class="modal fade" id="viewDiseaseModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewDiseaseTitle">Disease</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="enabledisease.php" name="form_viewdisease_enable">
          <div class="modal-body">
            <div class="form-group">
              <label for="editDiseaseName">Disease Name</label>
              <input type="hidden" name = "viewdisease_ID_enable" id = "viewdisease_ID_enable">
              <input type="text" class="form-control" id='viewDiseaseName_enable' name ='viewDiseaseName_enable' readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnsaveenabledisease">Enable</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end modal declaration -->
  <!-- plugins -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
  <script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="js/realtime-connection.js"></script>
  <script type="text/javascript" src="js/disease-tab.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <!-- some page scripts -->
  <script type="text/javascript">
  //add active class to current tab
  $('#diseasetab').addClass("active");

  $(document).ready(function(){
    // functions
    save_newdisease();
    edit_disease();
    save_editeddisease();
    view_disease();
    viewdisease_enable();
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

    function save_newdisease(){
      $("form[name='form_adddisease']").on('submit',function(e){
        e.preventDefault();
        // var confirm_input = confirm("Are you sure?");
        var formdata = $("form[name='form_adddisease']").serialize();
        swal({
          title: "Are you sure?",
          text: "You are about to add this disease",
          icon: "info",
          buttons:true,
        })
        .then((willApprove) => {
          if (willApprove) {
            $.ajax({
              type: "POST",
              url: 'disease-related/add_newdisease.php',
              data: {formdata,formdata},
              success:function(data){
                if(data == 1){
                  // alert("Blood Component Added");
                  swal({
                    title:"",
                    text: "Disease Added",
                    icon: "success",
                    buttons:{text:"Okay"},
                  })
                  .then((willApprove) => {
                    if (willApprove) {
                      $('#addnewdiseaseModal').modal('hide');
                      $("#addnewdiseaseModal .modal-body input").val("");
                      window.location.href = "disease-tab.php";
                    }
                  });
                  //$('#divdonoraddsero').show(600);
                }
                else if(data == 2){
                  swal({
                    title: "",
                    text: "The Disease you entered already exists, Please check the disabled diseases too.",
                    icon: "warning",
                    buttons:{text:"Okay"},
                  })
                  .then((willApprove) => {
                    if (willApprove) {
                      window.location.href = "disease-tab.php";
                    }
                  });
                }
                else if (data == 3) {
                  swal({
                    title: "",
                    text: "Disease is not saved",
                    icon: "error",
                    buttons:{text:"Okay"},
                  })
                  .then((willApprove) => {
                    if (willApprove) {
                      window.location.href = "disease-tab.php";
                    }
                  });
                }
              }
            });
          }
          else {
            swal("","Cancelled","info");
          }
        });
      });
    }

    function edit_disease(){
      $('#editDiseaseModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        // alert(rowid);
        $.ajax({
          type: "POST",
          url: 'disease-related/fetch_diseasedetails.php',
          data: 'rowid=' + rowid,
          dataType: "json",
          success: function(data){
            $('#disease_ID').val(data.intDiseaseId);
            $('#editDiseaseName').val(data.strDisease);
          }

        });
      });
    }

    function view_disease(){
      $('#viewDiseaseModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        // alert(rowid);
        $.ajax({
          type: "POST",
          url: 'disease-related/fetch_diseasedetails.php',
          data: 'rowid=' + rowid,
          dataType: "json",
          success: function(data){
            $('#viewdisease_ID').val(data.intDiseaseId);
            $('#viewDiseaseName').val(data.strDisease);
          }

        });
      });
    }

    function viewdisease_enable(){
      $('#viewDiseaseModal_enable').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        // alert(rowid);
        $.ajax({
          type: "POST",
          url: 'disease-related/fetch_diseasedetails.php',
          data: 'rowid=' + rowid,
          dataType: "json",
          success: function(data){
            $('#viewdisease_ID_enable').val(data.intDiseaseId);
            $('#viewDiseaseName_enable').val(data.strDisease);
          }

        });
      });
    }

    function save_editeddisease(){
      $("form[name='form_editdisease']").on('submit',function(e){
        e.preventDefault();
        // var confirm_input = confirm("Are you sure?");
        var formdata = $("form[name='form_editdisease']").serialize();
        console.log(formdata);
        swal({
          title: "Are you sure?",
          text: "You are about to edit this disease",
          icon: "info",
          buttons: true,
        })
        .then((willApprove) => {
          if (willApprove) {
            $.ajax({
              type: "POST",
              url: 'disease-related/edit_disease.php',
              data: {formdata,formdata},
              success:function(data){
                if(data == 1){
                  // alert("Disease Succesfully Edited");
                  swal({
                    title: "",
                    text: "Disease is successfully edited",
                    icon: "success",
                    buttons:{text:"Okay"},
                  })
                  .then((willApprove) => {
                    if (willApprove) {
                      $('#editDiseaseModal').modal('hide');
                      $("#editDiseaseModal .modal-body input").val("");
                      window.location.href = "disease-tab.php";
                    }
                  });
                  //$('#divdonoraddsero').show(600);
                }
                else if(data == 2){
                  swal({
                    title: "",
                    text: "The Disease you entered already exists!",
                    icon: "error",
                    buttons:{text:"Okay"},
                  })
                  .then((willApprove) => {
                    if (willApprove) {
                      window.location.href = "disease-tab.php";
                    }
                  });
                  // alert("The Disease You Entered Already Exists");
                }
                else if (data == 3) {
                  swal({
                    title: "",
                    text: "Disease is not edited",
                    icon: "error",
                    buttons:{text:"Okay"},
                  })
                  .then((willApprove) => {
                    if (willApprove) {
                      window.location.href = "disease-tab.php";
                    }
                  });
                  // alert("Disease is not Edited");
                }
              }
            });
          }
          else {
            swal("","Cancelled","info");
          }
        });
      });
    }

    $("#btnsavedeletedisease").click(function(e){
      e.preventDefault();
      var id = $("#viewdisease_ID").val();
      // var confirm_delete = confirm("Are you sure?");
      swal({
        title: "Are you sure?",
        text: "You are about to disable this disease",
        icon: "info",
        buttons:true,
      })
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: 'disease-related/disable_disease.php',
            data: {id:id},
            success:function(data){
              if(data == "deleted"){
              swal({
                title: "",
                text: "The disease is now disabled",
                icon: "success",
                buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "disease-tab.php";
                }
              });
            }else{
              swal({
                title: "",
                text: "The disease is not disabled because "+data+" record/s uses this.",
                icon: "error",
                buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "disease-tab.php";
                }
              });
            }
            }
          });
        }
        else {
          swal("","Cancelled","info");
        }
      });

    });

    $("#btnsaveenabledisease").click(function(e){
      e.preventDefault();
      var id = $("#viewdisease_ID_enable").val();
      // var confirm_enable = confirm("Are you sure?");
      swal({
        title: "Are you sure?",
        text: "You are about to enable this disease",
        icon: "info",
        buttons: true,
      })
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: 'disease-related/enable_disease.php',
            data: {id:id},
            success:function(data){
              swal({
                title:"",
                text: "Disease is now enabled",
                icon: "success",
                buttons:{text:"Okay"}
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "disease-tab.php";
                }
              });
              // alert("Disease has been enabled");
            }
          });
        }
        else {
          swal("","Cancelled","info");
        }
      });
    });
  });

  $('#sidebar a').click(function(){ $('a').removeClass("active"); $(this).addClass("active"); });

  </script>
</body>
</html>
