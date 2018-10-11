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
				<h5 style='color:rgb(250,250,250); font-family:"Nunito-Regular"; margin-top:10px;'>Blood Component</h5>
			</div>
			<!-- SIDE NAVIGATION -->
			<?php
				include "employeeSidebar.php";
			?>

			<!-- END OF SIDE NAVIGATION -->
			<div class="col-md-10 offset-md-2">
				<div class="content-container">
					<?php
					include("connections.php");

					if($_GET['rowid']){
						$surveycode = $_GET['rowid'];

						$unchecked_surveys = mysqli_query($connections, "SELECT
							intMedicalExamId,m.intQuestionId,intDonationId,stfAnswerYn,datAnswerDate,intAnswerQuantity,strAnswerString,q.txtQuestion
							FROM tblmedicalexam m JOIN tblquestion q ON m.intQuestionId = q.intQuestionId
							WHERE stfAnswerRemarks = 'Unchecked'
							AND dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 4 DAY) AND NOW()
							AND intDonationId = '$surveycode'");
							$getdonorid = mysqli_query($connections,"SELECT intClientId FROM tbldonation WHERE intDonationId = '$surveycode'");
							while ($row2 = mysqli_fetch_assoc($getdonorid)) {
								$client = $row2["intClientId"];
							}

							if(mysqli_num_rows($unchecked_surveys) > 0){
								?>

								<form name = 'submit_update' method = 'POST' action = 'save_update_survey.php'>

									<table class='table table-bordered mt-5 text-center' id='tbldonorsurvey'>
										<thead>
											<tr>
												<th>Donation Id</th>
												<th>Question</th>
												<th>Answer: Yes or No</th>
												<th>Answer: Date</th>
												<th>Answer: Quantity</th>
												<th>Answer: String</th>
												<th>Action</th>
											</tr>
										</thead>

										<?php
										while ($row = mysqli_fetch_assoc($unchecked_surveys)) {
											$id = $row["intQuestionId"];
											//$client = $row["intClientId"];
											$examcode = $row["intDonationId"];
											$question = $row["txtQuestion"];
											$yn = $row["stfAnswerYn"];
											$date = $row["datAnswerDate"];
											$quantity = $row["intAnswerQuantity"];
											$string = $row["strAnswerString"];
											?>

											<tbody>
												<tr>
													<td><?php echo $examcode; ?></td>
													<td><?php echo $question; ?></td>
													<td><?php echo $yn; ?></td>
													<td><?php echo $date; ?></td>
													<td><?php echo $quantity; ?></td>
													<td><?php echo $string; ?></td>
													<td>
														<input type = 'radio' name = 'updatestatus<?php echo $id;?>' id = 'updatestatus<?php echo $id; ?>' value = 'Correct' required = 'required' >Correct</br>
														<input type = 'radio' name = 'updatestatus<?php echo $id;?>' id = 'updatestatus<?php echo $id; ?>' value = 'Wrong' >Wrong
													</td>
												</tr>
											</tbody>
											<?php
										}
										?>

									</table>
									<input type="hidden" name="hiddenclientid" value="<?php echo $client;?>" required>
									<input type="hidden" name="hiddenexamcode" value="<?php echo $examcode;?>" required>
									<Button type='submit' class='btn btn-success ml-1 right' id='updatesurvey_save'>Submit</button>
								</form>

								<?php
							}

						}
						?>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
		<script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
		<!-- <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
		<script type="text/javascript" src="js/responsive.bootstrap4.min.js"></script> -->
		<script type="text/javascript">
		$(function(){
			$("form[name ='submit_update']").on('submit',function(e){
				e.preventDefault();
				var formdata = $("form[name ='submit_update']").serialize();
				var confirmbutton = confirm("Are you sure?");
				console.log(formdata);
				if(confirmbutton == true)
				{
					$.ajax({
						url:"survey-related/save_update_survey.php",
						method:"POST",
						data:{formdata,formdata},
						success: function(data){
							alert("Survey has been checked");
							window.location.href = "donorlist-tab.php";
							console.log(data);
						}
					});
				}
				else {
					alert("Confirmation Cancelled");
					return false;
				}
			});
		});

		</script>
	</body>
	</html>
