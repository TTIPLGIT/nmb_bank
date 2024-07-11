<div class="modal fade" id="addeligModal2">
    <div class="modal-dialog modal-xl" >


		<div class="modal-content">

         <form  action="{{ route('Registration.update',$user_id) }}" method="POST" id="create_form" enctype="multipart/form-data">
			{{ csrf_field() }}
            @method('put')
				<div class="modal-header mh">						
					<h4 class="modal-title">Add Eligible Criteria</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" style=" background-color: #f8fffb;">
				<input type="hidden" class="form-control" required id="user_id" name="user_id" value="">		
				<input type="hidden" class="form-control" required id="user_details" name="user_details" value="eligibleq">
				<label style="font-size: 16px !important; color:DarkSlateBlue;"><b>A person shall be eligible to be an empanelled as Valuer/Assessor/Surveyor if he/she:</b><span class="error-star" style="color:red;">*</span></label>
					<div class="row">	
				<div class="col-lg-12 text-center">				
				
                   <button type="submit" class="btn btn-success btn-space"  id="savebutton">Save</button>
				   <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

				   
					</div>
					</div>
				</div>
			</form>
			
    </div>
  </div>
</div>