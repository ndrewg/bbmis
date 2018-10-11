<!DOCTYPE html>
<html>
<head>
	<link href="bs4\dist\css\bootstrap.min.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/fontawesome-all.css">
  <link rel="stylesheet" href="css/jquery-confirm.min.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/waves.min.css">
</head>
	<body>
		<div class="col-md-12 header">
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
		<div class="container-fluid mt-4">
			<?php
				include("connections.php");

				$varQueCount = 1;
				$varDbId = 1;

				$qryDistQueCtg = mysqli_query($connections, "
				SELECT DISTINCT(qc.stfQuestionCategory)
				FROM tblquestion q
				JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
				");
				
				$qryCountQueCtg = mysqli_num_rows($qryDistQueCtg);

				$qryCliSex = mysqli_query($connections, "SELECT stfClientSex FROM tblclient WHERE intClientId = $varDbId");
				while($rowCliSex = mysqli_fetch_assoc($qryCliSex))	{
					$varSex = $rowCliSex["stfClientSex"];
				}

				function typeYn($varQueId)	{
					echo "
							<div class='row'>
								<div class='btn-group-toggle text-center w-100 form-group mb-sm-3' data-toggle='buttons'>
									<label id='btnYn$varQueId' class='btn btn-outline-danger form-control col-4 mr-sm-2' value='Yes'>
										<input type='radio' name='txtYn$varQueId' value='Yes' autocomplete='off' required='required' />Oo
									</label>
									<label id='btnYn$varQueId' class='btn btn-outline-danger form-control col-4' value='No'>
										<input type='radio' name='txtYn$varQueId' value='No' autocomplete='off' required='required' />Hindi
									</label>
								</div>
							</div>
					";
				}

				function typeDate($varQueId)	{
					echo "
							<div class='row'>
								<div class='form-group col-4'>
									<select class='form-control' name='optDm$varQueId' placeholder='Month'>
									<option value='00'>Month</option>';
									";

											for($m=1; $m<=12; $m++) {
												$month = date("F", mktime(0,0,0,$m, 1, date("Y")));
												echo "<option value='$m'>$month</option>'";
											}

					echo "
									</select>
								</div>
								<div class='form-group col-4'>
									<select class='form-control' name='optDd$varQueId'>
										<option value='00'>Day</option>
										";
									for($d=1; $d<=31; $d++)	{
										echo "
											<option value='$d'>$d</option>
										";
									}

					echo "
									</select>
								</div>
								<div class='form-group col-4'>
									<select class='form-control' name='optDy$varQueId'>
									<option value='0000'>Year</option>;
									";
											$curYear = date("Y");
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
								<div class='form-group m-auto mb-sm-3'>
									<input type='number' min='0' class='form-control' name='intQua$varQueId' value=0 />
								</div>
							</div>
					";
				}

				function typeStr($varQueId)	{
					echo "
							<div class='row'>
								<div class='form-group m-auto'>
									<input type='text' class='form-control' name='txtStr$varQueId'/>
								</div>
							</div>
					";
				}
				
				for($x=0; $x<$qryCountQueCtg; $x++)	{
					$qryQueCtg = mysqli_query($connections, "
						SELECT DISTINCT(qc.stfQuestionCategory)
						FROM tblquestion q
						JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
						WHERE decQuestionVersion = (
								SELECT DISTINCT(q1.decQuestionVersion)
								FROM tblquestion q1
								WHERE boolVersionInUse = '1'
							)
						LIMIT 1 OFFSET $x
					");
					
					while($rowCtg = mysqli_fetch_assoc($qryQueCtg))	{
						$varQueCtg = $rowCtg["stfQuestionCategory"];

						if($varSex == 'Male')	{
							if($varQueCtg == 'Female-exclusive')	{
								//break;
								continue;
							}
						}

						echo "
							<table class='table table-bordered table-hover'>
								<tr>
									<td class='bg-danger text-white text-center' colspan='3'>
										$varQueCtg
									</td>
								</tr>
						";
						
						$qryQue = mysqli_query($connections, "
							SELECT q.intQuestionId, q.txtQuestion, q.stfQuestionType
							FROM tblquestion q
							JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
							WHERE qc.stfQuestionCategory = '$varQueCtg'
							AND decQuestionVersion = (
								SELECT DISTINCT(q1.decQuestionVersion)
								FROM tblquestion q1
								WHERE boolVersionInUse = '1'
							)
						");

						while($rowQue = mysqli_fetch_assoc($qryQue))	{
							$varQueId = $rowQue["intQuestionId"];
							$varQue = $rowQue["txtQuestion"];
							$varQueType = $rowQue["stfQuestionType"];

							echo "
								<tr>
									<td class='align-middle text-center' style='width: 10%;'>
										$varQueCount.
									</td>
									<td class='align-middle' style='width: 45%;'>
										$varQue
									</td>
									<td class='align-middle' style='width: 55%;'>
							";

							$varQueCount++;

							if($varQueType == "Yn")	{typeYn($varQueId);}
							else if($varQueType == "YnDate")	{typeYn($varQueId); typeDate($varQueId); }
							else if($varQueType == "YnQua")	{typeYn($varQueId); typeQua($varQueId); }
							else if($varQueType == "YnStr")	{typeYn($varQueId); typeStr($varQueId); }
							else if($varQueType == "YnDateQua")	{typeYn($varQueId); typeDate($varQueId); typeQua($varQueId); }
							else if($varQueType == "YnDateStr")	{typeYn($varQueId); typeDate($varQueId); typeStr($varQueId); }
							else if($varQueType == "YnQuaStr")	{typeYn($varQueId); typeQua($varQueId); typeStr($varQueId); }
							else if($varQueType == "YnDateQuaStr")	{typeYn($varQueId); typeDate($varQueId); typeQua($varQueId); typeStr($varQueId); }
							else if($varQueType == "Date")	{typeDate($varQueId); }
							else if($varQueType == "DateQua")	{typeDate($varQueId); typeQua($varQueId); }
							else if($varQueType == "DateStr")	{typeDate($varQueId); typeStr($varQueId); }
							else if($varQueType == "DateQuaStr")	{typeDate($varQueId); typeQua($varQueId); typeStr($varQueId); }
							else if($varQueType == "Qua")	{typeQua($varQueId); }
							else if($varQueType == "QuaStr")	{typeQua($varQueId); typeStr($varQueId); }
							else if($varQueType == "Str")	{typeStr($varQueId); }
							echo "
									</td>
								</tr>
							";
						}
						echo "
							</table>
						";
					}
				}
			?>
		</div>
	</body>
</html>