<script>
	let wd = document.querySelector("user_id");
	a.addEventListener("change", function(e) {
		//alert("wf");
	})
</script>
<div class="modal fade" id="addeligModal">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">

			<form action="{{ route('Registration.store') }}" method="POST" id="create_form" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="modal-header mh">
					<h4 class="modal-title">Give a Ratting</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" style=" background-color: #f8fffb;">
					<div class="row" style="display:flex; align-items: self-end;">
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Users</label>
								<select name="user_id" id="user_id" class="form-control">
									<option value="">Select User</option>

									@foreach($rows['rows1'] as $key=>$row)

									<option value="{{ $row['valuer_id'] }}" {{ $row['valuer_id']  ==$user_id ? 'selected':''}}>{{$row['name']}} ({{$row['valuer_code']}})</option>

									@endforeach
								</select>
							</div>
						</div>
					</div>
					<input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
					<input type="hidden" class="form-control" required id="user_details" name="user_details" value="eligibleq">
					<label style="font-size: 16px !important; color:DarkSlateBlue;">The Ratings are Based on The Answers you Give:<span class="error-star" style="color:red;">*</span></label>

					@foreach($rows['rating_question'] as $data)
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div class="egc">
									<div class="dq"><span class="questions">{{$loop->iteration}}. {{$data['question']}}:</span></div>
									<div class="vl"></div>
									<div class="switch-field">
										<input type="hidden" id="qid{{$loop->iteration}}" name="q[{{$loop->iteration}}][qid]" value="{{$data['id']}}">
										<input type="radio" id="radio-one{{$loop->iteration}}" name="q[{{$loop->iteration}}][qans]" value="yes">
										<label for="radio-one{{$loop->iteration}}">Yes</label>
										<input type="radio" id="radio-two{{$loop->iteration}}" name="q[{{$loop->iteration}}][qans]" value="no" checked />
										<label for="radio-two{{$loop->iteration}}">No</label>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="font-size:xx-large; visibility:hidden;">
						<i id="star{{$loop->iteration}}" class="fa fa-star"></i>
					</div>
					@endforeach
					<div class="row">
						<div class="col-lg-12 text-center">

							<button type="submit" class="btn btn-success btn-space" id="savebutton">Save</button>
							<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">


						</div>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>