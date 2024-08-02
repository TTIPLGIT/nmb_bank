<style>
	#counselorerror {
		color: red;
	}

	#supervisorerror {
		color: red;
	}

	.select2-container .select2-selection--single {
		height: 34px !important;
	}

	.select2-container--default .select2-selection--single {
		border: 1px solid #ccc !important;
		border-radius: 0px !important;
	}

	.select2-container {
		width: 100% !important;
	}

	.select2-dropdown .select2-dropdown--below {
		width: 100% !important;
	}
</style>


<div class="modal fade" id="addeligModal">
	<div class="modal-dialog modal-md">


		<div class="modal-content">

			<form action="{{ route('Registration.store') }}" method="POST" id="approval_form1" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="modal-header mh">
					<h4 class="modal-title">Select Supervision</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" style=" background-color: #f8fffb;">
					<input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
					<input type="hidden" class="form-control" required id="user_details" name="user_details" value="approvel_process">

					<div class="row">
						<div class="col-md-12">
							<div class="form-group d-flex flex-column">
								<label for="Counselor">Counsellor<span class="error-star" style="color:red;">*</span></label>
								<select name="counselor" id="counselor" class="form-control select2_unique">
									<option value="">Select Counsellor</option>
									@foreach($rows['counselor'] as $key=>$row)

									<option id="counselor_useradd_{{ $row['id'] }}" value="{{ $row['id'] }}">{{$row['name']}}</option>

									@endforeach

								</select>
								<span class="counselor" id="counselorerror"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="supervisor">Supervisor<span class="error-star" style="color:red;">*</span></label>
								<select name="supervisor" id="supervisor" class="form-control select2_unique">
									<option value="">Select Supervisor</option>
									@foreach($rows['supervisor'] as $key=>$row)

									<option id="supervisor_useradd_{{ $row['id'] }}" value="{{ $row['id'] }}">{{$row['name']}}</option>

									@endforeach
								</select>
								<span class="supervisor" id="supervisorerror"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 text-center">
							<button onclick="save(event)" class="btn btn-success btn-space form_submit_handle">Submit</button>
							<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
						</div>
					</div>
				</div>
			</form>
			<input type="hidden" class="pending" id="pending" value="{{$rows['pending'][0]['COUNT(id)']}}">
			<input type="hidden" class="approve" id="approve" value="{{$rows['approve'][0]['COUNT(id)']}}">
			<input type="hidden" class="reject" id="reject" value="{{$rows['reject'][0]['COUNT(id)']}}">
			<input type="hidden" class="no_response" id="no_response" value="{{$rows['no_response'][0]['COUNT(id)']}}">

		</div>
	</div>
</div>
<script>
	$('.select2_unique').select2();
</script>

<script>
	$(document).ready(function() {
		$('#addeligModal').on('hidden.bs.modal', function()

			{
				$(this).find('form')[0].reset();
			});
	});


	function save(e) {
		const counselor = document.getElementById("counselor");
		const supervisor = document.getElementById("supervisor");

		e.preventDefault();
		if (counselor.value == "") {
			document.getElementById("counselorerror").innerHTML = "**Please select the Counselor**";

		} else {
			document.getElementById("counselorerror").innerText = "";
		}


		if (supervisor.value == "") {
			document.getElementById("supervisorerror").innerHTML =
				"**Please select the Supervisor**";
			return;
		} else {
			document.getElementById("supervisorerror").innerText = "";
		}

		preventSubmitButton('form_submit_handle');
		$("#approval_form1").submit();
	}
	$(document).on('change', '#counselor', function() {
		$('#supervisor').children().removeAttr('disabled');
		var value = $(this).val();
		$(`#supervisor_useradd_${value}`).prop('disabled', true);
		selectReinitialize('select2_unique');
	});

	$(document).on('change', '#supervisor', function() {
		$('#counselor').children().removeAttr('disabled');
		var value = $(this).val();
		$(`#counselor_useradd_${value}`).prop('disabled', true);
		selectReinitialize('select2_unique');

	});
</script>