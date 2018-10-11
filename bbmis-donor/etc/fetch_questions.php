<?php
include("connections.php");

if(isset($_POST["action"]))
{
	if($_POST["action"]== "fetch")
	{
    $view_questions_table = mysqli_query($connections,"SELECT intQuestionID,txtQuestion,intQuestionVersion,datQuestionAdded,strQuestionType,boolForSex FROM tblquestion");

		$output ="<form method = 'POST' action = 'survey/check_answers.php'>";
		$output .="<table>";

    while($row = mysqli_fetch_assoc($view_questions_table))
    {
      $intQuestionID = $row["intQuestionID"];
      $txtQuestion = $row["txtQuestion"];
      $intQuestionVersion = $row["intQuestionVersion"];
      $datQuestionAdded = $row["datQuestionAdded"];
      $strQuestionType = $row["strQuestionType"];
      $boolForSex = $row["boolForSex"];

//if yes or no lang
        if($strQuestionType == 'YN')
        {
        $output .= "

              <tr>
                <td>$intQuestionID</td>
                <td>$txtQuestion</td>
                <td>
									<input type='hidden' name='hiddenQuestion_ID' value='$intQuestionID' id = '$intQuestionID'>
									<input type = 'radio' name = 'answer_yn$intQuestionID' id = 'answer_yn$intQuestionID' value = '1'>YES
									<input type = 'radio' name = 'answer_yn$intQuestionID' id = 'answer_yn$intQuestionID' value = '0'>NO
								</td>
								<td>
									<input type ='hidden' name = 'answer_text$intQuestionID' value = 'NULL'>
								</td>
              </tr>

          ";
        }
//if mixed
				if($strQuestionType == 'Mixed')
				{
					$output .="

							<tr>
								<td>$intQuestionID</td>
								<td>$txtQuestion</td>
								<td>
									<input type='hidden' name='hiddenQuestion_ID' value='$intQuestionID' id = '$intQuestionID'>
									<input type = 'radio' name = 'answer_yn$intQuestionID'  id = 'answer_yn$intQuestionID' value = '1'>YES
									<input type = 'radio' name = 'answer_yn$intQuestionID'  id = 'answer_yn$intQuestionID' value = '0'>NO
								</td>
								<td>
									<input type = 'text' name = 'answer_text$intQuestionID'  id = 'answer_text$intQuestionID'>
								</td>
							</tr>

					";
				}
//if text lang
				 if($strQuestionType == 'String')
				 {
					 $output .="
					 <tr>
						 <td>$intQuestionID</td>
						 <td>$txtQuestion</td>

						 <td>
							 <input type = 'hidden' name = 'answer_yn$intQuestionID' id = 'answer_yn$intQuestionID' value = '0'>
							 <input type = 'hidden' name = 'answer_yn$intQuestionID' id = 'answer_yn$intQuestionID' value = '0'>
						 	 <input type = 'text' name = 'answer_text$intQuestionID'  id = 'answer_text$intQuestionID'>
						 </td>
					 </tr>
					 ";
				 }

/*$extra_js = <<<EXTRAJS
<script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"> </script>
<script>

	$(document).ready(function(){
		$("button[name = 'submit_answers']").click(function(){
			var question_id = $("input[type='hidden'][name = 'hiddenQuestion_ID']").attr("id");
			var answer_yn = $("#answer_yn"+ question_id).val();
			var answer_text = $("#answer_text"+ question_id).val();

			console.log("answer_yn");
		});
	});
	</script>
EXTRAJS;*/

/*$extra_js = <<<EXTRAJS
<script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"> </script>
<script>
$(document).ready(function(){
	$("button[name = 'submit_answers']").click(function(){
		var question_id = $("input[type='hidden'][name = 'hiddenQuestion_ID']").attr("id");
		var answer_yn = $("input[type='radio'][name ='answer_yn'+ question_id]:checked").val();
		var answer_text = $("input[type='radio'][name ='answer_yn'+ question_id]:checked").val();

		console.log("answer_yn");
	});
});
</script>
EXTRAJS;*/

}//end of while

$output .="</table>";
$output .= "<input type = 'submit' name = 'submit_answers'>";
$output .="</form>";

echo $output;

//echo $extra_js;
//echo "<a href = 'submit_answers.php?id=$urn_ID'><button>Submit</button></a>";
  }
}

?>
<script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"> </script>
<script>

/*$(document).ready(function(){
		$("button[name = 'submit_answers']").click(function(){
			var question_id = $("input[type='hidden'][name = 'hiddenQuestion_ID']").attr("id");
			var answer_yn = $("input[type='radio'][name ='answer_yn'+ question_id]:checked").val();
			var answer_text = $("input[type='radio'][name ='answer_yn'+ question_id]:checked").val();

			console.log(answer_yn);
		});
	});*/

/*$(document).ready(function(){
		var question_id = $("input[type='radio'][name = 'hiddenQuestion_ID']").attr("id");
	$("input[type='radio'][name ='answer_yn'+ question_id]:checked").click(function(){
			//var question_id = $(this).attr("id");
			var answer_yn = $("#answer_yn"+ question_id).val();
			var answer_text = $("#answer_text"+ question_id).val();

			console.log(answer_yn);

	});
});*/
</script>
