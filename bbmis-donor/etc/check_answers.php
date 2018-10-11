<?php
	include("connections.php");
	$curdate = date("Y/m/d");

	if(isset($_POST["submit_answers"])){
	$check_version = mysqli_query($connections,"SELECT COUNT(intQuestionId) AS Number_of_Questions FROM tblquestion WHERE intQuestionVersion = '1' ");

		while ($row = mysqli_fetch_assoc($check_version)){
			$NumberOfQuestions = $row["Number_of_Questions"];
		}
		
		//echo $NumberOfQuestions;
		for($i = 1; $i <= $NumberOfQuestions; $i++)
		{
				$answer_demo_user = "1"; //session
				$answer = $_POST["answer_yn"."$i"];
				$answer_text = $_POST["answer_text"."$i"];
				echo $answer;
				echo $answer_text;

				if($curdate && $i && $answer_demo_user && $answer && $answer_text)
				{
					$insert_answer = mysqli_query($connections,"INSERT INTO tblmedicalexam(intDonorId, intQuestionId, datExamTaken, boolAnswer, txtAnswerAdd) VALUES('$answer_demo_user','$i', NOW(),'$answer','$answer_text')");
				}


				//echo $i;
			/*  $trial = "answer_yn"."$i";
				echo $trial;*/
		}
	}
?>