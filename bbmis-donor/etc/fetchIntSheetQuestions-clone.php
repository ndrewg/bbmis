<?php
	include("connection.php");
	
	$qryFetchLatestMedEx = mysqli_query($conn, "SELECT DISTINCT(`strMedicalExamCode`), dtmExamChecked FROM tblmedicalexam WHERE intClientId = $varDbId ORDER BY strMedicalExamCode DESC LIMIT 1 OFFSET 0");
	while($rowLatestMedEx = mysqli_fetch_assoc($qryFetchLatestMedEx))	{
		$varMedEx = $rowLatestMedEx["strMedicalExamCode"];
		$varDatChecked = $rowLatestMedEx["dtmExamChecked"];
	}
	
	$qryFetchSurveyStats = mysqli_query($conn, "SELECT DISTINCT(`stfClientMedicalExamStatus`) FROM tblmedicalexam WHERE intClientId = $varDbId AND strMedicalExamCode = '$varMedEx'");
	
	$varRowCount = 0;
	$varSurveyStats = array();
	
	while($rowSurveyStat = mysqli_fetch_assoc($qryFetchSurveyStats))	{
		$varSurveyStats[$varRowCount] = $rowSurveyStat["stfClientMedicalExamStatus"];
		$varRowCount++;
	}
	
	$varArrCount = count($varSurveyStats);
	
	if($varArrCount == 1)	{
		if(in_array('Unchecked', $varSurveyStats))	{
			echo "
				<h2 class='h2 my-sm-4'>You already answered the survey.</h2>
				<h4 class='h4 my-sm-4'>Your survey answers is not yet checked. Please wait.</h4>
			";
		}
	}
	
	else if($varArrCount > 1)	{
		if(in_array('Wrong', $varSurveyStats))	{
			echo "
				<h3 class='h3 my-sm-4'>Your medical exam has failed.</h3>
				<h5 class='h5 my-sm-4'>You can take the exam again after three(3) days.</h5>
			";
		}
	}
	
	else if($varArrCount == 0 || $varDatChecked == '0000-00-00')	{
		$varQueCount = 1;

		$qryDistQueCtg = mysqli_query($conn, "SELECT DISTINCT(qc.stfQuestionCategory) FROM tblquestion q JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId");
		$qryCountQueCtg = mysqli_num_rows($qryDistQueCtg);

		$qryCliSex = mysqli_query($conn, "SELECT stfClientSex FROM tblclient WHERE intClientId = $varDbId");
		while($rowCliSex = mysqli_fetch_assoc($qryCliSex))	{
			$varSex = $rowCliSex["stfClientSex"];
		}

		function typeYn($varQueId)	{
			echo "
					<div class='btn-group-toggle text-center w-100' data-toggle='buttons'>
						<label class='btn btn-outline-danger form-control col-5 mt-sm-4 mr-sm-4'>
							<input type='radio' name='txtYn$varQueId' id='btnYn$varQueId' value='Yes' autocomplete='off' required='required'>Oo
						</label>
						<label class='btn btn-outline-danger form-control col-5 mt-sm-4'>
							<input type='radio' name='txtYn$varQueId' id='btnYn$varQueId' value='No' autocomplete='off' required='required'>Hindi
						</label>
					</div>
			";
		}

		function typeDate($varQueId)	{
			echo "
					<div class='row'>
						<div class='form-group m-auto col-4 mt-sm-4'>
							<select class='form-control' name='txtBm$varQueId' placeholder='Month' required='required'>";

									for($m=1; $m<=12; $m++) {
										$month = date('F', mktime(0,0,0,$m, 1, date('Y')));
										echo "<option value='$m'>$month</option>'";
									}

			echo "
							</select>
						</div>
						<div class='form-group m-auto col-4 mt-sm-4'>
							<select class='form-control' name='txtBd$varQueId' required='required'>
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
							<select class='form-control m-auto mt-sm-4' name='txtBy$varQueId' required='required'>";
									$curYear = date('Y');
									for($y=0; $y<=($curYear-($curYear-60)); $y++)	{
										$z = $curYear-$y;
										echo "<option value='$z'>$z</option>";
									}
			echo "
							</select>
						</div>
					</div>
			";
		}

		function typeQua($varQueId)	{
			echo "
					<div class='row'>
						<div class='form-group m-auto col-8 mt-sm-4'>
							<input type='number' min='0' class='form-control' name='intQua$varQueId' required='required' />
						</div>
					</div>
			";
		}

		function typeStr($varQueId)	{
			echo "
					<div class='row'>
						<div class='form-group m-auto col-8 mt-sm-2'>
							<input type='text' class='form-control' name='txtStr$varQueId' required='required'/>
						</div>
					</div>
			";
		}

		for($x=0; $x<$qryCountQueCtg; $x++)	{
			$qryQueCtg = mysqli_query($conn, "SELECT DISTINCT(qc.stfQuestionCategory) FROM tblquestion q JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId LIMIT 1 OFFSET $x");
			while($rowCtg = mysqli_fetch_assoc($qryQueCtg))	{
				$varQueCtg = $rowCtg["stfQuestionCategory"];

				if($varSex == 'Male')	{
					if($varQueCtg == 'Female-exclusive')	{
						//break;
						continue;
					}
				}

				echo "
				<form action='getIntSheetAnswers.php' id='collapseExample' method='POST'>
					<div class='card-deck m-auto pt-4'>
						<div class='card'>
							<div class='card-header bg-danger text-white'>
								$varQueCtg
							</div>
				";


				$qryQue = mysqli_query($conn, "SELECT q.intQuestionId, q.txtQuestion, q.stfQuestionType	FROM tblquestion q JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId WHERE qc.stfQuestionCategory = '$varQueCtg' AND intQuestionVersion = 1;");

				while($rowQue = mysqli_fetch_assoc($qryQue))	{
					$varQueId = $rowQue["intQuestionId"];
					$varQue = $rowQue["txtQuestion"];
					$varQueType = $rowQue["stfQuestionType"];

					echo "
								<div class='card-body'>
									<div class='card p-4 m-auto'>
										$varQueCount. $varQue
					";

					$varQueCount++;

					if($varQueType == 'Yn')	{typeYn($varQueId);}
					else if($varQueType == 'YnDate')	{typeYn($varQueId); typeDate($varQueId); }
					else if($varQueType == 'YnQua')	{typeYn($varQueId); typeQua($varQueId); }
					else if($varQueType == 'YnStr')	{typeYn($varQueId); typeStr($varQueId); }
					else if($varQueType == 'YnDateQua')	{typeYn($varQueId); typeDate($varQueId); typeQua($varQueId); }
					else if($varQueType == 'YnDateStr')	{typeYn($varQueId); typeDate($varQueId); typeStr($varQueId); }
					else if($varQueType == 'YnQuaStr')	{typeYn($varQueId); typeQua($varQueId); typeStr($varQueId); }
					else if($varQueType == 'YnDateQuaStr')	{typeYn($varQueId); typeDate($varQueId); typeQua($varQueId); typeStr($varQueId); }
					else if($varQueType == 'Date')	{typeDate($varQueId); }
					else if($varQueType == 'DateQua')	{typeDate($varQueId); typeQua($varQueId); }
					else if($varQueType == 'DateStr')	{typeDate($varQueId); typeStr($varQueId); }
					else if($varQueType == 'DateQuaStr')	{typeDate($varQueId); typeQua($varQueId); typeStr($varQueId); }
					else if($varQueType == 'Qua')	{typeQua($varQueId); }
					else if($varQueType == 'QuaStr')	{typeQua($varQueId); typeStr($varQueId); }
					else if($varQueType == 'Str')	{typeStr($varQueId); }
					echo "
									</div>
								</div>
					";
				}
				echo "
							</div>
						</div>
						<br>
						<button input='submit' class='form-control btn btn-outline-danger m-auto btn-lg'>Submit Answers</button>
						<br>
						<br>
					</form>
				";
			}
		}
	}
?>