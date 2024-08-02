<style>
    .row.subscribtion {
    display: flex;
    justify-content: space-evenly;
    align-items: baseline;
}
</style>
<div class="modal fade" id="addpayment">
    <div class="modal-dialog modal-s" >


		<div class="modal-content">

         <form  action="" method="POST" id="create_form" enctype="multipart/form-data">
			{{ csrf_field() }}
				<div class="modal-header mh">						
					<h4 class="modal-title">Payment</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" style=" background-color: #f8fffb;">
				<input type="hidden" class="form-control" required id="user_id" name="user_id" value="">		
				<input type="hidden" class="form-control" required id="user_details" name="user_details" value="eligibleq">
                <div class="row" style="margin:10px ;">	
				            <label class="col-sm-4" style="font-size: 16px !important; color:DarkSlateBlue;">Name<span class="error-star" style="color:red;">*</span></label>

                            <input class="form-control col-sm-6" style="font-size: 16px !important; color:DarkSlateBlue;" name="name" id="name">
                </div>  
                <div class="row" style="margin:10px ;">
                    <label class="col-sm-4" style="font-size: 16px !important; color:DarkSlateBlue;">Plan<span class="error-star" style="color:red;">*</span></label>
                    <label  style="font-size: 16px !important; color:DarkSlateBlue;">
                        <input type="radio" name="exampleRadios" id="exampleRadios1" value="12 months" checked>
                        12 Months Plan
                    </label>
                </div>
                <div class="row" style="margin:10px ; margin-bottom: 10px;">
                <label class="col-sm-4" style="font-size: 16px !important; color:DarkSlateBlue;"> Subscription Amount</label>
                <input class="form-control col-sm-6" style="font-size: 16px !important; color:DarkSlateBlue;" name="p_name" value="1299 INR" id="p_price" readonly>
                </div>  
                
                
					<div class="row">	
						<div class="col-lg-12 text-center">				
                        <input type="hidden"class="form-control col-sm-8" style="font-size: 16px !important; color:DarkSlateBlue;" name="ren_date" id="ren_date" readonly>

							<button type="submit" class="btn btn-success btn-space"  id="savebutton">Pay</button>
							<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

						
						</div>
					</div>
				</div>
			</form>
			
    </div>
  </div>
</div>
