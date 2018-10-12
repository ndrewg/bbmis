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
        <h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Donor List</h5>
      </div>
      <!-- SIDE NAVIGATION -->
      <?php
				include "employeeSidebar.php";
			?>
			<!-- END OF SIDE NAVIGATION -->
      <div class="col-md-10 offset-md-2">
        <div class="content-container">
          <h4 style="font-family:'Nunito-Regular'">Unchecked Surveys</h4>
          <div id="tabledonorsurveylist">

          </div>
        </div>
        <div class="content-container" style="margin-top: -20px">
          <h4 style="font-family:'Nunito-Regular'">Expected Donors</h4>
          <div id="tblexpecteddonor">

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
  <script type="text/javascript" src="js/realtime-connection.js"></script>
  <script type="text/javascript" src="js/notification.js"></script>
  <script type="text/javascript">
  //add active class to current tab
  $('#donorlisttab').addClass("active");
  $(document).ready(function(){
    ajax_searchdonor();
    showdonor_list();
    ajax_showsurveys();
    ajax_showexpected();
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

    function showdonor_list(){
      $.ajax({
        url:"people-related/search_donorlist.php",
        method:"GET",
        //data:{formdata,formdata},
        success: function(data){
          if (data == 1){
            alert('form was not submitted');
            console.log(formdata);
          }
          else {
            // console.log(formdata);
            $("#tabledonorlist").html(data);
          }
        },
        complete: function() {
          // Schedule the next request when the current one's complete
          setTimeout(showdonor_list, 5000);
        }
      });
    }

    function ajax_searchdonor(){
      $("form[name = 'submitname']").submit(function(){
        //  $("#searchdonor").keydown(function(){
        var formdata = $("form[name = 'submitname']").serialize();
        $.ajax({
          url:"people-related/search_donorlist.php",
          method:"POST",
          data:{formdata,formdata},
          success: function(data){
            if (data == 1){
              alert('form was not submitted');
              console.log(formdata);
            }
            else {
              // console.log(formdata);
              $("#tabledonorlist").html(data);
            }
          }
        });
      });
    }

    function ajax_showsurveys() {
      $.ajax({
        url: 'survey-related/show_uncheckedsurvey.php',
        success: function(data) {
          $("#tabledonorsurveylist").html(data);
        },
        complete: function() {
          // Schedule the next request when the current one's complete
          setTimeout(ajax_showsurveys, 5000);
        }
      });
    }

    function ajax_showexpected() {
      $.ajax({
        url: 'people-related/show_expecteddonor.php',
        success: function(data) {
          $("#tblexpecteddonor").html(data);
        },
        complete: function() {
          // Schedule the next request when the current one's complete
          setTimeout(ajax_showexpected, 5000);
        }
      });
    }


    //$('.btnchecksurvey').click(function(e){
    //  var rowid = $(this).attr("data-id");
    /*$.ajax({
    type: "POST",
    url: 'donor-related/fetchdonorsurveyanswers.php',
    data: {rowid : rowid},
    success:function(data){*/
    //console.log(data);
    //  $('#row_id').val(rowid);
    //$('#donorsurvey').html(data);
    //$('#divsearch').hide(600);
    //$("#tabledonorlist").hide(600);
    //$("#tabledonorsurveylist").hide(600);
    //$('#divchecksurvey').show(600);

    /*  }
  });*/
  //});

  $("#updatesurvey_save").click(function(e){
    console.log("hi");
  });



});

</script>
</body>
</html>
