<div class="modal fade" id="approvalSubmission">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card">
                <div class="card-header h4 font-weight-bold">
                    Task Submission
                </div>

                <div class="card-body">
                    <form action="{{route('instruction.task.store')}}" method="POST" id="approvalSubmittionForm" enctype="multipart/form-data">
                        @CSRF
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Counselor">Task Name</label>
                                    <input type="text" class="form-control" name="instructionNameModal" id="instructionNameModal" value="" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Counselor">Task Description</label>
                                    <textarea style="height: 122px !important;" class="form-control" name="instructionDescriptionModal" id="instructionDescriptionModal" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row mb-2 existingFileName d-none">
                                    <div class="col-12 pl-0">
                                        <label for="Counselor" class="custom-form-control">File Name</label>

                                    </div>
                                    <div class="col">
                                        <span id="fileName"></span>
                                        <a class="btn btn-primary" data-toggle="modal" data-target="#templates" data-file='' id="fileView"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a class="btn btn-primary changeFile" id="changeFile"><img class="custom-icon" src="{{asset('assets/images/file-edit-svgrepo-com.svg')}}" /></a>
                                    </div>
                                </div>
                                <div class="form-group newFileName">
                                    <label for="Counselor">File Upload<span class="error-star" style="color:red;" >*</span></label>
                                    <input type="file" class="form-control" name="instructionFileUpload" id="instructionFileUpload" required>
                                    <a class="btn btn-primary changeFile" id="changeFile">X</a>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Counselor">Comments<span class="error-star" style="color:red;">*</span></label>
                                    <textarea class="form-control" placeholder="Enter Comments" name="instructionComments" id="instructionComments"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="taskIdModal" id="taskIdModal">
                            <input type="hidden" name="instructionId" id="instructionId">
                            <input type="hidden" name="taskIsSave" id="taskIsSave">

                            <div class="col-12 d-flex justify-content-around align-items-center">
                                <a type="button" class="btn btn-labeled btn-info back_button" onclick="$('#approvalSubmission').modal('hide');" title="Back">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back
                                </a>
                                <a id="taskSave" class="btn btn-labeled btn-info approve_button" title="Save">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-up"></i></span>
                                    <span class="formButton">Save</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>