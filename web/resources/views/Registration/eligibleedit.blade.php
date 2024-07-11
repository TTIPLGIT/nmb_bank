<div class="modal fade" id="uniqueModal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<form action="{{ route('approvereject') }}" method="POST" id="approve_edit" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="modal-header mh">
					<h4 class="modal-title">Select Supervision</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" style=" background-color: #f8fffb;">

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="Counselor">Counselor</label>
								@if($rows['counselor_edit'] !=[])
								<select name="counselor" id="counseloredit" class="form-control" value="{{$rows['counselor_edit'][0]['approval_persons_id']}}" disabled>
									<option value="{{$rows['counselor_edit'][0]['approval_persons_id']}}" selected>{{$rows['counselor_edit'][0]['name']}}</option>
								</select>
								<input type="hidden" name="counselor" value="">
								@else
								<select name="counselor" id="counseloredit" class="form-control">
									<option value="">Select Counsellor</option>
									@foreach($rows['counselor'] as $key=>$row)
									@if(isset($rows['supervisor_edit'][0]['approval_persons_id']) && $rows['supervisor_edit'][0]['approval_persons_id'] !=$row['id'] )


									<option id="counselor_user_{{ $row['id'] }}" value="{{ $row['id'] }}">{{$row['name']}}</option>
									@else
									<option id="counselor_user_{{ $row['id'] }}" value="{{ $row['id'] }}">{{$row['name']}}</option>

									@endif
									@endforeach

								</select>

								@endif
								<span class="counselor" id="counselorerroredit"></span>
							</div>
						</div>


						<div class="row">
							<div class="col-md-12">
								<div class="form-group">

									<label for="supervisor">Supervisor</label>
									@if($rows['supervisor_edit'] !=[])
									<select name="supervisor" id="supervisoredit" class="form-control" value="{{$rows['supervisor_edit'][0]['approval_persons_id']}}" disabled>
										<option value="{{$rows['supervisor_edit'][0]['approval_persons_id']}}" selected>{{$rows['supervisor_edit'][0]['name']}}</option>

									</select>
									<input type="hidden" name="supervisor" value="">
									@else
									<select name="supervisor" id="supervisoredit" class="form-control">
										<option value="">Select Supervisor</option>
										@foreach($rows['supervisor'] as $key=>$row)
										@if(isset($rows['counselor_edit'][0]['approval_persons_id']) && $rows['counselor_edit'][0]['approval_persons_id'] !=$row['id'] )

										<option id="supervisor_user_{{ $row['id'] }}" value="{{ $row['id'] }}">{{$row['name']}}</option>
										@else
										<option id="supervisor_user_{{ $row['id'] }}" value="{{ $row['id'] }}">{{$row['name']}}</option>
										@endif
										@endforeach

									</select>

									@endif
									<span class="supervisor" id="supervisorerroredit"></span>
								</div>
							</div>




							<div class="row">
								<div class="col-lg-12 text-center">

									<button onclick="update_counselor()" class="btn btn-success btn-space">Update</button>
									<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">


								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
		</form>
		<input type="hidden" class="pending" id="pending2" value="{{$rows['pending'][0]['COUNT(id)']}}">
		<input type="hidden" class="approve" id="approve2" value="{{$rows['approve'][0]['COUNT(id)']}}">
		<input type="hidden" class="reject" id="reject2" value="{{$rows['reject'][0]['COUNT(id)']}}">

	</div>
</div>


<div class="modal fade" id="respondModal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<form action="{{ route('approvereject') }}" method="POST" id="approve_edit_res" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="modal-header mh">
					<h4 class="modal-title">Select Supervision</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" style=" background-color: #f8fffb;">

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="Counselor">Counselor</label>
								@if($rows['counselor_edit'] !=[])
								<select name="counselor" id="counseloredit_res" class="form-control selectuniq" value="{{$rows['counselor_edit'][0]['approval_persons_id']}}" disabled>
									<option value="{{$rows['counselor_edit'][0]['approval_persons_id']}}" selected>{{$rows['counselor_edit'][0]['name']}}</option>
								</select>
								<input type="hidden" name="counselor" value="">
								@else
								<select name="counselor" id="counseloredit" class="form-control selectuniq">
									<option value="">Select Counselor</option>
									@foreach($rows['counselor'] as $key=>$row)
									@if(isset($rows['supervisor_edit'][0]['approval_persons_id']) && $rows['supervisor_edit'][0]['approval_persons_id'] !=$row['id'] )


									<option id="counselor_user_{{ $row['id'] }}" value="{{ $row['id'] }}">{{$row['name']}}</option>
									@else
									<option id="counselor_user_{{ $row['id'] }}" value="{{ $row['id'] }}" disabled>{{$row['name']}}</option>

									@endif
									@endforeach

								</select>

								@endif
								<span class="counselor" id="counselorerroredit"></span>
							</div>
						</div>


						<div class="row">
							<div class="col-md-12">
								<div class="form-group">

									<label for="supervisor">Supervisor</label>
									@if($rows['supervisor_edit'] !=[])
									<select name="supervisor" id="supervisoredit_res" class="form-control selectuniq" value="{{$rows['supervisor_edit'][0]['approval_persons_id']}}" disabled>
										<option value="{{$rows['supervisor_edit'][0]['approval_persons_id']}}" selected>{{$rows['supervisor_edit'][0]['name']}}</option>

									</select>
									<input type="hidden" name="supervisor" value="">
									@else
									<select name="supervisor" id="supervisoredit" class="form-control selectuniq">
										<option value="">Select Supervisor </option>
										@foreach($rows['supervisor'] as $key=>$row)
										@if(isset($rows['counselor_edit'][0]['approval_persons_id']) && $rows['counselor_edit'][0]['approval_persons_id'] !=$row['id'] )

										<option id="supervisor_user_{{ $row['id'] }}" value="{{ $row['id'] }}">{{$row['name']}}</option>
										@else
										<option id="supervisor_user_{{ $row['id'] }}" value="{{ $row['id'] }}" disabled>{{$row['name']}}</option>
										@endif
										@endforeach

									</select>

									@endif
									<span class="supervisor" id="supervisorerroredit"></span>
								</div>
							</div>




							<div class="row">
								<div class="col-lg-12 text-center">

									<button onclick="update_counselor_res()" class="btn btn-success btn-space">Update</button>
									<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">


								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
		</form>
		<input type="hidden" class="pending" id="pending2" value="{{$rows['pending'][0]['COUNT(id)']}}">
		<input type="hidden" class="approve" id="approve2" value="{{$rows['approve'][0]['COUNT(id)']}}">
		<input type="hidden" class="reject" id="reject2" value="{{$rows['reject'][0]['COUNT(id)']}}">
		<input type="hidden" class="no_response" id="no_response2" value="{{$rows['no_response'][0]['COUNT(id)']}}">
	</div>
</div>

<div class="modal fade" id="approveModal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form action="{{ route('changereject') }}" method="POST" id="approve_edit_new" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="modal-header mh">
					<h4 class="modal-title">Supervision Change Request</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" style=" background-color: #f8fffb;">
					<div class="row">
						<div class="errorNotes text-danger p-4">
							<p>
								<strong> Kindly NOTE:</strong>
								You can change the supervisors for two times. If you want to change more than two, that needs to be a special request and it must be approved by the admin.
							</p>
						</div>
						@if(isset($rows['counselor_edit'][0]['approval_persons_id']) && $rows['counselor_edit'][0]['approval_status'] != 'Pending')
						<div class="col-md-12">
							<div class="form-group">
								<label for="Counselor">Counselor</label>
								<select name="counselor_new" id="counseloredit_new" class="form-control selectuniq" value="{{$rows['counselor_edit'][0]['approval_persons_id']}}">
									<option value="" selected>Select counselor</option>
									@foreach($rows['counselor'] as $key=>$row)
									@if($rows['counselor_edit'][0]['approval_persons_id'] != $row['id'])
									<option id="counselor_useradd_{{ $row['id'] }}" value="{{ $row['id'] }}">{{$row['name']}}</option>
									@endif
									@endforeach
								</select>
								<span class="counselor" id="counselorerroredit_new"></span>
							</div>
						</div>
						@endif
						@if(isset($rows['supervisor_edit'][0]['approval_persons_id']) && $rows['supervisor_edit'][0]['approval_status'] != 'Pending')
						<div class="col-md-12">
							<div class="form-group">
								<label for="supervisor">Supervisor</label>
								<select name="supervisor_new" id="supervisoredit_new" class="form-control selectuniq" value="{{$rows['supervisor_edit'][0]['approval_persons_id']}}">
									<option value="" selected>Select Supervisor</option>
									@foreach($rows['supervisor'] as $key=>$row)
									@if($rows['supervisor_edit'][0]['approval_persons_id'] != $row['id'])
									<option id="supervisor_useradd_{{ $row['id'] }}" value="{{ $row['id'] }}">{{$row['name']}}</option>
									@endif

									@endforeach
								</select>
								<span class="supervisor" id="supervisorerroredit_new"></span>
							</div>
						</div>
						@endif
						<div class="col-md-12">
							<div class="form-group">
								<div id="previousnotes" style="margin: 20px;">
									<div id="editor"></div>
									<div class="form-group scroll_flow_class" style="display: contents;">
										<div class="form-outline">
											<div class="card-header">
												<label class="form-label" for="textAreaExample" style="font-size: 23px;">Reason For Change</label>
												<textarea name="messages" style="color:white" class="form-control" id="reason" name="reason" rows="6"></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 text-center">
								<a onclick="update_counselor_new()" class="btn btn-success btn-space">Update</a>
								<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
							</div>
						</div>

					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@if(!empty($rows['specialRequest']))
<div class="modal fade" id="viewResponse">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header mh">
				<h4 class="modal-title">Supervision Request Pending</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body" style=" background-color: #f8fffb;">
				<div class="row">
					<div class="errorNotes text-danger p-4">

						<p>
							<strong> Kindly NOTE:</strong>
							Your Request to Change the Supervisors are still in pending, if you have'nt get any Response from the Admin. You can request again after this Date ('DD-MM-YYYY').
						</p>
					</div>
					@php $approval_persons_ids =explode(',',$rows['specialRequest'][0]['approval_persons_id']) @endphp
					@if($approval_persons_ids[1] != 0)
					<div class="col-md-12">
						<div class="form-group">
							<label for="Counselor">Requested Counselor</label>
							<select name="counselor_new_view" id="" class="form-control" value="{{$rows['counselor_edit'][0]['approval_persons_id']}}">
								@foreach($rows['counselor'] as $key=>$row)
								@if(($approval_persons_ids[1] == $row['id']))
								<option value="{{$row['id']}}" selected>{{$row['name']}}</option>
								@endif
								@endforeach

							</select>

							<span class="counselor" id="counselorerroredit_new"></span>
						</div>
					</div>
					@endif
					@if($approval_persons_ids[0] != 0)
					<div class="col-md-12">
						<div class="form-group">
							<label for="supervisor">Requested Supervisor</label>
							<select name="supervisor_new_view" id="" class="form-control" value="{{$rows['supervisor_edit'][0]['approval_persons_id']}}">
								@foreach($rows['supervisor'] as $key=>$row)
								@if($approval_persons_ids[0] == $row['id'])
								<option value="{{$row['id']}}" selected>{{$row['name']}}</option>
								@endif
								@endforeach
							</select>

							<span class="supervisor" id="supervisorerroredit_new"></span>
						</div>
					</div>
					@endif

					<div class="row">
						<div class="col-lg-12 text-center">
							<input type="button" class="btn btn-danger" data-dismiss="modal" value="Back">
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>
@endif

<!-- Admin Role Request to admin -->

<!-- if ($role == '1') {
<div class="row">
	<div class="form-group">
		<div id="previousnotes" style="margin: 20px;">
			<div id="editor"></div>
			<div class="form-group scroll_flow_class" style="display: contents;">

				<div class="form-outline">
					<div class="card-header">
						<label class="form-label" for="textAreaExample" style="font-size: 23px;">Change Request Comments</label>
						<textarea name="messages" style="color:white" class="form-control" id="graduate_trainee" name="graduate_trainee" rows="6"></textarea>
					</div>
				</div>

			</div>

		</div>
	</div>
   </div>
} -->




</div>

<script>
	$('.selectuniq').select2();
</script>

<script>
	$(document).ready(function() {
		$('#uniqueModal').on('hidden.bs.modal', function()

			{
				$(this).find('form')[0].reset();
			});
	});

	$(document).ready(function() {
		$('#respondModal').on('hidden.bs.modal', function()

			{
				$(this).find('form')[0].reset();
			});
	});

	$(document).ready(function() {
		$('#approveModal').on('hidden.bs.modal', function()

			{
				$(this).find('form')[0].reset();
			});
	});



	function update_counselor_new() {

		const counselor = $('#counseloredit_new').val();
		const supervisor = $('#supervisoredit_new').val();
		var editor = tinymce.get('reason');
		if (counselor === "" && supervisor === "") {
			swal.fire({
				title: "Error",
				text: "Kinldy Select atleast any one Supervisors",
				icon: "error",
			});

			return false;
		}
		if (editor.getContent() === "") {
			swal.fire({
				title: "Error",
				text: "Kindly Enter the Comments.",
				icon: "error",
			});

			return false;
		}
		if (editor.getContent({
				format: 'text'
			}).split(" ").length < 1) {

			swal.fire({
				title: "Error",
				text: "Comments must have alteast five words.",
				icon: "error",
			});

			return false;
		}
		$("#approve_edit_new").submit();
	}

	function update_counselor() {
		$("#approve_edit").submit();
	}


	function update_counselor_res() {
		$("#approve_edit_res").submit();
	}

	$(document).on('change', '#counseloredit_new', function() {
		$('#supervisoredit_new').children().removeAttr('disabled');

		var value = $(this).val();
		$(`#supervisor_useradd_${value}`).prop('disabled', true);
		selectReinitialize('selectuniq');

	});

	$(document).on('change', '#supervisoredit_new', function() {
		$('#counseloredit_new').children().removeAttr('disabled');
		var value = $(this).val();
		$(`#counselor_useradd_${value}`).prop('disabled', true);
		selectReinitialize('selectuniq');

	});

	$(document).on('change', '#counseloredit_res', function() {
		$('#supervisoredit_res').children().removeAttr('disabled');

		var value = $(this).val();
		$(`#supervisor_user_${value}`).prop('disabled', true);
		selectReinitialize('selectuniq');

	});

	$(document).on('change', '#supervisoredit_res', function() {
		$('#counseloredit_res').children().removeAttr('disabled');
		var value = $(this).val();
		$(`#supervisor_user_${value}`).prop('disabled', true);
		selectReinitialize('selectuniq');

	});

	$(document).ready(function() {

		tinymce.init({
			selector: 'textarea#reason',
			height: 180,
			menubar: 'table',
			branding: false,
			// plugins: 'table',
			// toolbar: 'undo redo | formatselect | ' +
			//   'bold italic backcolor | alignleft aligncenter ' +
			//   'alignright alignjustify | bullist numlist outdent indent | ' +
			//   'removeformat | help' + 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
			content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
		});
		// event.preventDefault()
	});
</script>