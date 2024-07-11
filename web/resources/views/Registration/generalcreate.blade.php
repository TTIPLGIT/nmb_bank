<div class="modal fade" id="addModal">
	<div class="modal-dialog modal-lg">


		<div class="modal-content">
			<form action="{{ route('Registration.store') }}" method="POST" id="create_form" class="" onsubmit="return validateForm()" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="modal-header mh">
					<h4 class="modal-title">Add Personal Information</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="form-control" id="user_id" name="user_id" value="">
					<input type="hidden" class="form-control" id="user_details" name="user_details" value="general">
					<!-- 
					<div class="row">

						<div class="col-md-4">
							<div class="form-group">
								<label>First Name:<span class="error-star" style="color:red;">*</span></label>
								<input type="text" class="form-control default" id="fname" name="fname">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Last Name:<span class="error-star" style="color:red;">*</span></label>
								<input type="text" class="form-control default" id="lname" name="lname">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Gender:<span class="error-star" style="color:red;">*</span></label>
								<div class="gender">
									<div>
										<input type="radio" class="" id="Male" name="gender" value="Male"><label for="Male"> Male</label>
									</div>
									<div>
										<input type="radio" class="" id="Female" name="gender" value="Female"><label for="Female"> Female</label>
									</div>

								</div>
							</div>
						</div>
					</div> -->
					<!-- <h style="color:black"><b>Address:</b></h> -->
					<div class="row">

						<div class="col-md-12">
							<div class="form-group">

								<label>Address Line :<span class="error-star" style="color:red;">*</span></label>
								<textarea rows="20" placeholder="Enter the Address" class="form-control default clear_text" id="Address_line1" name="Address_line1" autocomplete="off"></textarea>
							</div>
						</div>
						<!-- </div>
						
	z						<div class="row"> -->
						<div class="col-md-4">
							<div class="form-group">
								<label>District:<span class="error-star" style="color:red;">*</span></label>
								<select class="form-control default" id="district" name="district">
									<option value="">Select-District</option>

								</select>

							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Constituency: </label>
								<select class="form-control default" id="constituency" name="constituency">
									<option value="">Select-Constituency</option>

								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">

								<label>Village:</label>
								<select class="form-control default" id="village" name="village">
									<option value="">Select-Village</option>

								</select>
							</div>
						</div>
					</div>


					<!-- <div class="row">

						<div class="col-md-8">
							<div class="form-group">
								<label>Land Classification:<span class="error-star" style="color:red;">*</span></label>
								<div class="gender">
									<div>
										<input type="radio" class="" id="al" name="lvc" value="AgricultureLand"><label for="al"> Agriculture Land</label>
									</div>
									<div>
										<input type="radio" class="" id="rel" name="lvc" value="RealEstateLand"><label for="rel"> Real Estate Land</label>
									</div>

									<div>
										<input type="radio" class="" id="pl" name="lvc" value="PlantationLand"><label for="pl">Plantation Land</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Role Classification:<span class="error-star" style="color:red;">*</span></label>
								<div class="gender">
									<div>
										<input type="radio" class="" id="val" name="role_c" value="Valuer"><label for="val"> Valuer</label>
									</div>
									<div>
										<input type="radio" class="" id="sur" name="role_c" value="Surveyour"><label for="sur"> Surveyour</label>
									</div>

									<div>
										<input type="radio" class="" id="asr" name="role_c" value="Assessor"><label for="asr"> Assessor</label>
									</div>
								</div>
							</div>
						</div>
					</div> -->


					<div class="form-group">

						<label class="fw-light" for="nin" style="margin-left: 20px;">Choose an NIN (or) Passport<span class="error-star" style="color:red;">*</span></label>
						<div class="col d-flex justify-content-between">
							<div class="col-12 d-flex align-items-baseline ml-4" style="gap:10px">
								<input type="radio" id="nin" name="document_type" onchange="toggleNINDetails(this,'NIN (National Identification Number):','NIN Document:')" value="nin" class="nin">
								<label class="fw-light" for="nin">NIN</label>
								<input type="radio" id="passport" name="document_type" onchange="toggleNINDetails(this,'Passport Number:','Passport Document:')" value="passport" class="passport">
								<label for="passport">Passport</label>
							</div>
						</div>

					</div>

					<div class="row d-none" id="proff_cont">
						<div class="col-6">
							<div class="form-group">
								<label class="proff_label" id="id_number">NIN (National Identification Number):<span class="error-star" style="color:red;">*</span></label>
								<input type="text" class="form-control default" maxlength="14" oninput="this.value = this.value.replace(/[^a-zA-Z0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="nin_input" name="nin_input" autocomplete="off">
							</div>
						</div>

						<div class="col-6">
							<div class="form-group">
								<label class="proff_label" id="id_document">NIN Document:<span class="error-star" style="color:red;">*</span></label>
								<input class="form-control mb-0" type="file" id="nin_file" name="nin_file" value="" accept=".pdf, .png," autocomplete="off">
								<strong style="color: red;">Following files could be uploaded pdf, png</strong>
							</div>
						</div>
					</div>



				</div>







				<div class="row">
					<div class="col-lg-12 text-center">

						<button class="btn btn-success btn-space form_submit_handle" type="button" onclick="gencre()" id="savebutton">Submit</button>
						<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">


					</div>
				</div>
		</div>

		</form>


	</div>
</div>
</div>

<!-- <script>
	function validateForm() {
alert("jiji");
let f_name = document.forms["create_form"]["fname"].value;
alert(f_name);
if (f_name == null) {
  bootbox.alert({
	title: "General details creation",
	centerVertical: true,
	message: "Please enter first name",
  });
  return false;
}



}
</script> -->


<!-- Deepika -->


<!-- Add the following code inside your modal dialog -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
	$(document).ready(function() {
		$.ajax({
			url: "{{ url('district_list') }}",
			type: 'GET',
			data: {
				_token: '{{csrf_token()}}'
			},
			success: function(data) {
				$('#district option:first').nextAll().remove(); // Remove options after the first option

				for (const row of data) {
					const single_option = `<option value="${row.id}">${row.district_name}</option>`
					$('#district option:first').after(single_option);
				}



			}
		});
	});
	$(document).on('change', '#district', function() {
		var district_id = $(this).val();
		$.ajax({
			url: "{{ url('constituency_list') }}",
			type: 'GET',
			data: {
				id: district_id,
				_token: '{{csrf_token()}}'
			},
			success: function(data) {
				console.log(data);
				$('#constituency option:first').nextAll().remove(); // Remove options after the first option

				for (const row of data) {
					const single_option = `<option value="${row.id}">${row.constituency_name}</option>`
					$('#constituency option:first').after(single_option);
				}



			}
		});

	})

	$(document).on('change', '#constituency', function() {
		var constituency_id = $(this).val();
		$.ajax({
			url: "{{ url('village_list') }}",
			type: 'GET',
			data: {
				id: constituency_id,
				_token: '{{csrf_token()}}'
			},
			success: function(data) {
				console.log(data);
				$('#village option:first').nextAll().remove(); // Remove options after the first option

				for (const row of data) {
					const single_option = `<option value="${row.id}">${row.village_name}</option>`
					$('#village option:first').after(single_option);
				}



			}
		});

	})
</script>

<script>
	$(document).ready(function() {
		$('#addModal').on('hidden.bs.modal', function()

			{
				$(this).find('form')[0].reset();
			});
	});


	function gencre() {



		var add = $("#Address_line1").val();
		if (add == '') {
			swal.fire("Please Enter the Address", "", "error");
			return false;
		}

		var dist = $("#district").val();
		if (dist == '') {
			swal.fire("Please Select the District", "", "error");
			return false;
		}



		var nin = $("#nin").val();
		if (nin == '') {
			swal.fire("Please Enter the NIN", "", "error")
			return false;
		}

		var nin = $("#ninf").val();
		if (nin == '') {
			swal.fire("Please Upload the NIN FILE", "", "error")
			return false;
		} else {
			var nin_input = $('#nin_input').val();
			if (nin_input == "") {
				swal.fire("Please Fill all the Details", "", "error")
				return false;
			}
			var nin_file = $('#nin_file').val();
			if (nin_file == "") {
				swal.fire("Please Fill all the Details", "", "error")
				return false;
			}
			preventSubmitButton('form_submit_handle');
			document.getElementById('create_form').submit();
		}

	}
</script>
<script>
	function toggleNINDetails(radio, id_number, proff) {

		$('#proff_cont').removeClass('d-none');
		$('#id_number').text(id_number);
		$('#id_document').text(proff);
		// alert(id_number);
		if (proff == "NIN Document:") {
			$('#nin_input').attr('placeholder', "Enter the NIN Number");
		} else {
			$('#nin_input').attr('placeholder', "Enter the Passport Number");
		}
	}
</script>