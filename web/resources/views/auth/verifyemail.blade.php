<div class="modal fade" id="addModal">
	<div class="modal-dialog modal-md">


		<div class="modal-content">

			<form action="" method="" id="create_form" enctype="multipart/form-data">
			
				<div class="modal-header mh">
					<h4 class="modal-title">Email Verification</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" style="background-color: #edfcff !important;">
<span id="error" ></span><br>
					<label>Enter OTP Number:<span class="error-star" style="color:red;">*</span></label>

					<div class="row">

						<div class="col-md-2">
							<div class="form-group">
								<input type="text" class="form-control default otp" required id="otp1" name="otp1" inputmode="numeric" oninput="formatNumber(event,'2')" maxlength="1">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" class="form-control default otp" required id="otp2" name="otp2" inputmode="numeric" oninput="formatNumber(event,'3')" maxlength="1">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" class="form-control default otp" required id="otp3" name="otp3" inputmode="numeric" oninput="formatNumber(event,'4')" maxlength="1">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" class="form-control default otp" required id="otp4" name="otp4" inputmode="numeric" oninput="formatNumber(event,'5')" maxlength="1">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" class="form-control default otp" required id="otp5" name="otp5" inputmode="numeric" oninput="formatNumber(event,'6')" maxlength="1">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" class="form-control default otp" required id="otp6" name="otp6" inputmode="numeric" oninput="formatNumber(event,'0')" maxlength="1">
							</div>
						</div>

					</div>




					<input type="hidden" id="voemail" name="email" value="">




					<div class="row">
						<div class="col-lg-12 text-center">
							<input type="hidden" id="vemail" name="email" value="">
					<button type="submit" class="btn btn-success btn-space" onclick="verifyotp()" id="verifyotpbtn">Verifiy</button>

							<button type="button" onclick="sendotp()" class="btn btn-info btn-space" id="resend" style="color:white">Send-OTP</button>

							<input type="reset" class="btn btn-danger">


						</div>
					</div>
				</div>
			</form>

		</div>

	</div>
</div>
</div>