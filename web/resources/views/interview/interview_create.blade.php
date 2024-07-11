<div class="modal fade" id="interviewmodal">
	<div class="modal-dialog modal-lg">


		<div class="modal-content">



			<form action="" method="POST" id="create_form" onsubmit="return validateForm()" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="modal-header mh">
					<h4 class="modal-title">Add Schedule Name</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" style="background-color: #f8fffb !important;">
					<input type="hidden" class="form-control" id="user_id" name="user_id" value="">
					<input type="hidden" class="form-control" id="user_details" name="user_details" value="general">
				
					<div class="row">

						
						<!-- </div>
z						<div class="row"> -->
						<div class="col-md-6">
							<div class="form-group">
								<label></label>
								<select class="form-control default" id="district" name="district">
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
									<option value=""></option>
								</select>

							</div>
						</div>



                        <div class="col-md-6">
							<div class="form-group">

								<label>Date<span class="error-star" style="color:red;">*</span></label>
								<input type="date" class="form-control default clear_text" id="" name="">
							</div>
						</div>


						
					</div>



					<div class="row">
						<div class="col-lg-12 text-center">

							<button class="btn btn-success btn-space" type="button" id="savebutton">Submit</button>
							<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">


						</div>
					</div>
				</div>

			</form>


		</div>
	</div>
</div>




<!-- Deepika -->


<!-- Add the following code inside your modal dialog -->

<script>

$(document).ready(function() {
        $('#interviewmodal').on('hidden.bs.modal', function()

            {
                $(this).find('form')[0].reset();
            });
    });


