<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg" >


		<div class="modal-content">

    <form  action="{{route('qmaster.store')}}" method="POST" id="create_form" enctype="multipart/form-data">
    @csrf
					<div class="modal-header"style="background-color:DarkSlateBlue;">						
						<h4 class="modal-title">Add Personal Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
				<div class="modal-body" style="background-color: #edfcff !important;">
						
		
					<div class="row">
					
						<div class="col-md-12">
							<div class="form-group">
								<label>Question:<span class="error-star" style="color:red;">*</span></label>
								<input type="text" class="form-control default"  required id="question" name="question">
							</div>
						</div>

					</div>



                        

					
                  
					
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