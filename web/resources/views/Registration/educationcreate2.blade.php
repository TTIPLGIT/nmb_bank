<div class="modal fade" id="eduaddModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content">

            <form action="{{ route('Registration.store') }}" method="POST" id="educreate_form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header" style="background-color:DarkSlateBlue;">
                    <h4 class="modal-title"> Education Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="overflow:scroll !important;">
                    <div class="education1">
                        <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                        <input type="hidden" class="form-control" required id="user_details" name="user_details" value="educate">


                        <input type="hidden" name="attachment_countug" id="attachment_countug" value="0">
                        <input type="hidden" name="attachment_countpg" id="attachment_countpg" value="0">
                        <input type="hidden" name="attachment_countdip" id="attachment_countdip" value="0">
                        <input type="hidden" name="attachment_countphd" id="attachment_countphd" value="0">
                        <input type="hidden" name="user_id" id="user_id" value="0">
                        <div class="buttonedu">
                            <button type="button" name="addug" id="addug" class="btn btn-primary">Add Under Graduation</button>
                            <button type="button" name="adddip" id="adddip" class="btn btn-primary">Add Diploma</button>
                            <button type="button" name="addpg" id="addpg" class="btn btn-primary">Add Post Graduation</button>
                        </div>
                        <div id="dynamic_fieldug"></div>
                        <div id="dynamic_fieldpg"></div>
                        <div id="dynamic_fielddip"></div>
                        <div id="dynamic_fieldphd"></div>
                        <div class="row">
                            <div class="col-lg-12 text-center">

                                <button type="submit" class="btn btn-success btn-space" id="savebutton">Save</button>
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">


                            </div>
                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>