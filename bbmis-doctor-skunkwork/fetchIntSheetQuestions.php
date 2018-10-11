<!DOCTYPE html>
<html lang="en" dir="ltr">
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
      <div class="col-md-12 fixed-top header">
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
        <button type="button" class="btn mt-1 float-left text-white" style="background-color: rgb(234, 72, 127); margin-top: 13px;" onclick="location.href='donorrecords-tab.php'"><i class="fas fa-long-arrow-alt-left"></i> Back</button>
        <h5 class="float-left ml-3" style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:13px;'>Donor Records</h5>
      </div>
      <!-- end header -->
      <?php
				include("connections.php");
				$varDbId = $_GET["client_id"];
				$varCount = 1;
      ?>

      <div class="col-md-10 offset-md-1" style="margin-top: 48px">
        <form action="getIntSheetAnswers.php" id='collapseExample' method="POST">
          <input type = 'hidden' name = 'hidden_id' value ='<?php echo $varDbId; ?>'
          <?php
          $qryDistQueCtg = mysqli_query($connections, "SELECT DISTINCT(qc.intQuestionCategoryId) FROM tblquestion q JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId");
          $qryDistQueType = mysqli_query($connections, "SELECT DISTINCT(stfQuestionType) FROM tblquestion");

          $qryCountQueCtg = mysqli_num_rows($qryDistQueCtg);
          $qryCountQueType = mysqli_num_rows($qryDistQueType);

          $qryCliSex = mysqli_query($connections, "SELECT stfClientSex FROM tblclient WHERE intClientId = $varDbId");
          while($rowCliSex = mysqli_fetch_assoc($qryCliSex))	{
            $varSex = $rowCliSex["stfClientSex"];
          }
          function remarks($varQueId){
            ?>

            <div class='btn-group-toggle text-center w-100' data-toggle='buttons'>
            </br>
            <div class='text-left w-100' >
              <h5>Remarks : </h5>
            </div>
            <label class='btn btn-outline-danger form-control col-5 mt-sm-4 mr-sm-4'>
              <input type = 'radio' name = 'updatestatus<?php echo $varQueId;?>' id = 'updatestatus<?php echo $varQueId; ?>' value = 'Correct' required = 'required' >Correct
            </label>
          </br>
          <label class='btn btn-outline-danger form-control col-5 mt-sm-4 mr-sm-4'>
            <input type = 'radio' name = 'updatestatus<?php echo $varQueId;?>' id = 'updatestatus<?php echo $varQueId; ?>' value = 'Wrong' >Wrong
          </label>
        </div>
        <?php
      }

      function typeYn($varQueId)	{
        ?>

        <div class='btn-group-toggle text-center w-100' data-toggle='buttons'>
          <label class='btn btn-outline-danger form-control col-5 mt-sm-4 mr-sm-4'>
            <input type='radio' name='txtYn<?php echo $varQueId; ?>' id='btnYn<?php echo $varQueId; ?>' value='Yes' autocomplete='off' required='required'>Oo
          </label>
          <label class='btn btn-outline-danger form-control col-5 mt-sm-4'>
            <input type='radio' name='txtYn<?php echo $varQueId; ?>' id='btnYn<?php echo $varQueId; ?>' value='No' autocomplete='off' required='required'>Hindi
          </label>
        </div>
        <?php
      }

      function typeDate($varQueId)	{
        ?>
        <div class='row'>
          <div class='form-group m-auto col-4 mt-sm-4'>
            <select class='form-control' name='txtBm<?php echo $varQueId; ?>' placeholder='Month' >";
              <?php
              for($m=1; $m<=12; $m++) {
                $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                ?>
                <option value='<?php echo $m; ?>'><?php echo $month; ?></option>
                <?php
              }
              ?>
            </select>
          </div>
          <div class='form-group m-auto col-4 mt-sm-4'>
            <select class='form-control' name='txtBd<?php echo $varQueId; ?>' required='required'>
              <option value=1>1</option>
              <option value=2>2</option>
              <option value=3>3</option>
              <option value=4>4</option>
              <option value=5>5</option>
              <option value=6>6</option>
              <option value=7>7</option>
              <option value=8>8</option>
              <option value=9>9</option>
              <option value=10>10</option>
              <option value=11>11</option>
              <option value=12>12</option>
              <option value=13>13</option>
              <option value=14>14</option>
              <option value=15>15</option>
              <option value=16>16</option>
              <option value=17>17</option>
              <option value=18>18</option>
              <option value=19>19</option>
              <option value=20>20</option>
              <option value=21>21</option>
              <option value=22>22</option>
              <option value=23>23</option>
              <option value=24>24</option>
              <option value=25>25</option>
              <option value=26>26</option>
              <option value=27>27</option>
              <option value=28>28</option>
              <option value=29>29</option>
              <option value=30>30</option>
              <option value=31>31</option>
            </select>
          </div>
          <div class='form-group col-4'>
            <select class='form-control m-auto mt-sm-4' name='txtBy<?php echo $varQueId; ?>' required='required'>";
              <?php
              $curYear = date('Y');
              for($y=0; $y<=($curYear-($curYear-60)); $y++)	{
                $z = $curYear-$y;
                ?>
                <option value='<?php echo $z; ?>'><?php echo $z; ?></option>
                <?php
              }
              ?>
            </select>
          </div>
        </div>
        <?php
      }

      function typeQua($varQueId)	{
        ?>
        <div class='row'>
          <div class='form-group m-auto col-8 mt-sm-4'>
            <input type='number' min='0' class='form-control' value = '0' name='intQua<?php echo $varQueId; ?>'  />
          </div>
        </div>
        <?php
      }

      function typeStr($varQueId)	{
        ?>
        <div class='row'>
          <div class='form-group m-auto col-8 mt-sm-2'>
            <input type='text' class='form-control' name='txtStr<?php echo $varQueId; ?>' />
          </div>
        </div>
        <?php
      }

      for($x=0; $x<$qryCountQueCtg; $x++)	{
        $qryQueCtg = mysqli_query($connections, "SELECT DISTINCT(qc.intQuestionCategoryId),stfQuestionCategory FROM tblquestion q JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId LIMIT 1 OFFSET $x");
        while($rowCtg = mysqli_fetch_assoc($qryQueCtg))	{
          $varQueCtg = $rowCtg["stfQuestionCategory"];

          if($varSex == 'Male')	{
            if($varQueCtg == 'Female-exclusive')	{
              //break;
              continue;
            }
          }
          ?>
          <div class='card-deck m-auto pt-4'>
            <div class='card'>
              <div class='card-header bg-danger text-white'>
                <?php echo $varQueCtg; ?>
              </div>
              <?php
              $qryQue = mysqli_query($connections, "SELECT intQuestionId, txtQuestion, stfQuestionType FROM tblquestion q JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId WHERE stfQuestionCategory = '$varQueCtg' AND boolVersionInUse = '1'");

              while($rowQue = mysqli_fetch_assoc($qryQue))	{
                $varQueId = $rowQue["intQuestionId"];
                $varQue = $rowQue["txtQuestion"];
                $varQueType = $rowQue["stfQuestionType"];

                ?>
                <div class='card-body'>
                  <div class='card p-4 m-auto'>
                    <input type ='hidden' id = 'clientId_med' name = 'clientId_med'>
                    <?php echo $varCount; ?>.<?php echo $varQue; ?>
                    <?php
                    $varCount++;

                    if($varQueType == 'Yn')	{typeYn($varQueId); remarks($varQueId);}
                    else if($varQueType == 'YnDate')	{typeYn($varQueId); typeDate($varQueId);  remarks($varQueId);}
                    else if($varQueType == 'YnQua')	{typeYn($varQueId); typeQua($varQueId); remarks($varQueId);}
                    else if($varQueType == 'YnStr')	{typeYn($varQueId); typeStr($varQueId); remarks($varQueId);}
                    else if($varQueType == 'YnDateQua')	{typeYn($varQueId); typeDate($varQueId); typeQua($varQueId); remarks($varQueId);}
                    else if($varQueType == 'YnDateStr')	{typeYn($varQueId); typeDate($varQueId); typeStr($varQueId); remarks($varQueId);}
                    else if($varQueType == 'YnQuaStr')	{typeYn($varQueId); typeQua($varQueId); typeStr($varQueId); remarks($varQueId);}
                    else if($varQueType == 'YnDateQuaStr')	{typeYn($varQueId); typeDate($varQueId); typeQua($varQueId); typeStr($varQueId); remarks($varQueId);}
                    else if($varQueType == 'Date')	{typeDate($varQueId); remarks($varQueId);}
                    else if($varQueType == 'DateQua')	{typeDate($varQueId); typeQua($varQueId); remarks($varQueId);}
                    else if($varQueType == 'DateStr')	{typeDate($varQueId); typeStr($varQueId); remarks($varQueId);}
                    else if($varQueType == 'DateQuaStr')	{typeDate($varQueId); typeQua($varQueId); typeStr($varQueId); remarks($varQueId);}
                    else if($varQueType == 'Qua')	{typeQua($varQueId); remarks($varQueId);}
                    else if($varQueType == 'QuaStr')	{typeQua($varQueId); typeStr($varQueId); remarks($varQueId);}
                    else if($varQueType == 'Str')	{typeStr($varQueId); remarks($varQueId);}

                    ?>
                  </div>
                </div>
                <?php
              }
              ?>
            </div>
          </div>
          <?php
        }
      }
      ?>
      <br>
      <button input="submit" class="form-control btn btn-outline-danger m-auto btn-lg">Submit Answers</button>
      <br>
      <br>
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
<script type="text/javascript" src="js/waves.min.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/notification.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#collapseExample").submit(function(e){
    e.preventDefault();//para di siya lumipat ng link
    var formdata = $(this).serialize();//kukunin ko yung lahat ng laman ng form
    var confirm_inputs = confirm("Are you sure?");
    console.log(formdata);//tinitingnan ko sa console yung laman
    if(confirm_inputs == true){
      $.ajax({
        url: "getIntSheetAnswers.php",
        method: "POST",
        data: {formdata,formdata},
        success: function(data){
          console.log(data);
          window.location.href = 'donorrecords-tab.php';
        }
      });
    }  else{
      alert("Confirmation Cancelled");
      return false;
    }
  });

});
</script>
</body>
</html>
