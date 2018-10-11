<?php
include("../connections.php");

$fetch_preservativerange = mysqli_query($connections, " SELECT * FROM tblpreservatives");
while($row = mysqli_fetch_assoc($fetch_preservativerange)){
  $status_fresh = $row["intPreservativeFreshPercentage"];
  $status_medium = $row["intPreservativeNeutralPercentage"];
  $status_critical = $row["intPreservativeCriticalPercentage"];
}
$medicalexamQry = mysqli_query($connections,"SELECT * FROM tblmedicalexam WHERE intDonationId = '10'");
if(mysqli_num_rows($medicalexamQry) > 0){
  while($row = mysqli_fetch_assoc($medicalexamQry)){
    $questionId = $row["intQuestionId"];
    $answerYN = $row["stfAnswerYn"];
    $answerDate = $row["datAnswerDate"];
    $answerQuan = $row["intAnswerQuantity"];
    $answerstr = $row["strAnswerString"];
    $remarks = $row["stfAnswerRemarks"];
    print_r ($questionId);
    print_r ($answerYN);
    print_r ($answerDate);
    print_r ($answerQuan);
    print_r ($answerstr);
    print_r ($remarks);
  }
}

// var_dump($status_fresh);
// var_dump($status_medium);
// var_dump($status_critical);
//
// settype($status_fresh, "int");
// settype($status_medium, "int");
// settype($status_critical, "int");
// var_dump($status_fresh);
// var_dump($status_medium);
// var_dump($status_critical);


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form method="post" name="dummy_form">
      <input type="text" name="dummytext" value="">
      <button type="submit" name="button">search</button>
    </form>
    <div id="result">

    </div>
  </body>
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript">
    $(document).on("submit", "form[name='dummy_form']", function(e){
      let formdata = $(this).serialize()
      $.ajax({
        type:"POST",
        url:"dummy_query.php",
        data: {formdata: formdata},
        success: function(data){
          $('#result').html(data);
        }
      });
    });
  </script>
</html>
