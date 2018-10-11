<!DOCTYPE html>
<html>
	<head>
		<link rel="icon" href="assets/images/blood.ico">
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="assets/css/bs-override.css" type="text/css">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ReFeel - Donor Dashboard</title>
	</head>
	<?php
		include "checkSession.php";
		include "fetchClientAcc.php";
	?>
	<body>
		<!-- Navigation bar -->
		<?php
			include "clientNavBar.php";
		?>
		
		<div class="container pt-4">
			<div class="card mb-4" style="border-radius: 25px">
				<div class="card-header bg-danger text-white text-center p-2" style="border-radius: 25px 25px 0px 0px; cursor: pointer;" data-toggle="collapse" href="#divDonRec" role="button" aria-expanded="false" aria-controls="collapseExample">
					Donation Record
				</div>
				<div class="card-body" id="divDonRec">
					<?php
						include "fetchClientDonations.php";
					?>
					<!--
					<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-center">
							<li class="page-item disabled">
								<a class="page-link" href="#" tabindex="-1">Previous</a>
							</li>
							<li class="page-item"><a class="page-link text-danger" href="#">1</a></li>
							<li class="page-item"><a class="page-link text-danger" href="#">2</a></li>
							<li class="page-item"><a class="page-link text-danger" href="#">3</a></li>
							<li class="page-item">
								<a class="page-link text-danger" href="#">Next</a>
							</li>
						</ul>
					</nav>
					-->
				</div>
				<div class="card-footer text-center p-2" style="border-radius: 0px 0px 25px 25px">
					Total Donations: <?php echo $varDonations;?>
				</div>
			</div>
			<!--div class="card mb-4" style="border-radius: 25px 25px 0px 0px">
				<div class="card-header bg-danger text-white text-center p-2" style="border-radius: 25px 25px 0px 0px; cursor: pointer;" data-toggle="collapse" href="#collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
					Events and Stuff
				</div>
				<div class="card-body text-center" id="collapse">
					<?php
						// include "fetchEvents.php";
					?>
				</div>
			</div-->
		</div>
	</body>
	<script src="assets/jquery/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</html>