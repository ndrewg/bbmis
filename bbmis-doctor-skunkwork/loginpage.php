<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="bs4/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/waves.min.css">
</head>
<body>
	<div class="card card-body col-md-4 col-xs-8 col-sm-8 mr-auto ml-auto mt-5 animated slideInDown fast" id="login-content">
		<img src="images/logoinpink.png" class="img-fluid mr-auto ml-auto" alt="Logo" style="width: 300px">
		<form id="frmEmpLogin" action="valEmployeeLogin.php" method="post">
			<div class="form-group">
				<label>Username</label>
				<input type="text" name="txtUn" class="form-control" id="username">
			</div>
			<div class="form-group">
				<label for="password" style="font-family:'Roboto-Regular'">Password</label>
				<input type="password" id="password" class="form-control" name='txtPw' required>
			</div>
			<button type="submit" class="btn btn-block text-white " style="font-family:'Roboto-Regular'; background-color: rgb(234, 72, 127);" id="btn_signin">Sign In</button>
		</form>
	</div>
	<div class="col-md-12 text-center fixed-bottom animated fadeIn fast" style="background-color: #EA487F">
		<p class="text-white">©2018 ReFeel Blood Bank Monitoring and Inventory System</p>
	</div>
</body>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="bs4/assets/js/vendor/popper.min.js"></script>
<script type="text/javascript" src="bs4/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/waves.min.js"></script>
<script type="text/javascript" src="js/sweetalert2.all.min.js"></script>
<script>
$('#frmEmpLogin').submit(function(e){
	e.preventDefault();
	var formdata = $(this).serialize();

	$.ajax({
		url: "valEmployeeLogin.php",
		type: "POST",
		data: {formdata:formdata},
		success: function (data){
			if (data == 1){
				let timeInterval;
				swal({
					title: '',
					html: 'Login success!',
					timer: 1500,
					onOpen: () => {
						swal.showLoading();
						timerInterval = setInterval(() => {
							swal.getContent().querySelector('strong')
							.textContent = swal.getTimerLeft()
						}, 100);
						window.location.href = "graphs-tab.php";
					},
					onClose: () => {
						clearInterval(timerInterval)
					}
				})
				.then((result) => {
					if (
						result.dismiss === swal.DismissReason.timer
					) {
						console.log('I was closed by the timer')
					}
				});
			}
			else if (data == 2){
				swal({
					type: 'error',
					title: 'Oops...',
					text: 'Staffs and doctors are only allowed to access the doctor side page.'
				});
			}
			else if (data == 3){
				swal({
					type: 'error',
					title: 'Oops...',
					text: 'Password is incorrect.'
				});
			}
			else if (data == 4){
				swal({
					type: 'error',
					title: 'Oops...',
					text: 'Account does not exist, please register first.'
				});
			}
		}
	});
});
// $("#frmEmpLogin").submit(function(e){
// 	e.preventDefault();
// 	var formdata = $(this).serialize();
// 	console.log(formdata);
// 	$.ajax({
// 		url:"valEmployeeLogin.php",
// 		type:"POST",
// 		data:{formdata:formdata},
// 		success:function(data){
// 			console.log(data);
// 			if(data == 1){
// 				swal({
// 					title:"",
// 					text: "Login Success",
// 					icon: "success",
// 					button:{text:"Okay"},
// 				})
// 				.then((willApprove) => {
// 					if (willApprove){
// 						window.location.href = "graphs-tab.php";
// 					}
// 				});
// 			}
// 			else if (data == 2) {
// 				swal("Oops!", "Staffs and doctors are only allowed to access the donor side page.", "error");
// 			}
// 			else if (data == 3) {
// 				swal("Oops!", "Password is incorrect.", "error");
// 			}
// 			else if (data == 4) {
// 				swal("Oops!", "Account is not existing, please register first.", "error");
// 			}
// 		}
// 	})
// });
</script>
</html>
