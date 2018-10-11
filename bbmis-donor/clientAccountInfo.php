<div class="modal fade" id="modalAccInfo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style='border-radius: 30px 30px 25px 25px;'>
			<div class="modal-header bg-danger" style='border-radius: 25px 25px 0px 0px;'>
				<i class="fa fa-phone p-2" style="color: white;"></i>
				<h5 class="modal-title text-white" style=" vertical-align: middle;">Personal Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class='text-white'>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" id="frmClientAccInfo">
					<!-- Occupation -->
					<div class="form-group">
						<label for="lblContNo" class="col-form-label">Username</label>
						<input type="text" class="form-control" name="txtNewContNo" value="<?php echo $varContNo;?>" required="required" />
					</div>
					<div class="form-group">
						<label for="lblEmail" class="col-form-label">Password</label>
						<input type="text" class="form-control" name="txtNewEmail" value="<?php echo $varEmail;?>" required="required" />
					</div>
					<div class="form-group">
						<label for="lblEmail" class="col-form-label">Confirm Password</label>
						<input type="text" class="form-control" name="txtNewEmail" value="<?php echo $varEmail;?>" required="required" />
					</div>
					
					<div class="modal-footer pb-1">
						<input type='hidden' name='btnAct' value='Account' />
						<input type='submit' value='Update' id='btnAcc' class='btn btn-outline-danger' />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$("#btnAcc").click(function(e)	{
		$("#frmClientAccInfo").submit(function(e){
			e.preventDefault();
			var formdata = $(this).serialize();
			console.log(formdata);
			
			swal({
				title: 'Notice.',
				text: 'Are you sure you want to update your account information?',
				icon: 'info',
				buttons: ['No', 'Update'],
			}).then((willRequest) => {
				if(willRequest)	{
					$.ajax	({
						url:"updateClientAcc.php",
						type:"POST",
						data:{formdata:formdata},
						success:function(data)	{
							console.log(data);
							if(data == '4')	{
								swal({
									title: 'Got it!',
									text: 'Your account information has been updated.',
									icon: 'success'
								}).then(() => {
									$("#modalAccInfo").modal('hide');
									window.location.href = 'clientProfile.php'
								});
							}
						}
					});
				}
				else	{
					swal('Okay.', 'Nothing is changed.', 'success');
				}
			});
		});
	});
</script>