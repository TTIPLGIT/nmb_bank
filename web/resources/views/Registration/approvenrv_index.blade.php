@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }

    .no-arrow {
        -moz-appearance: textfield;
    }

    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .nav-tabs {
        background-color: #0068a7 !important;
        border-radius: 29px !important;
        padding: 1px !important;

    }

    .nav-item.active {
        background-image: linear-gradient(to right, #2a675a, #2a675a, #2a675a, #2a675a, #2a675a);
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-link.active {
        background-image: linear-gradient(to right, #2a675a, #2a675a, #2a675a, #2a675a, #2a675a);
        border-radius: 31px !important;
        height: 100% !important;
    }

    :root {
        --borderWidth: 5px;
        --height: 24px;
        --width: 12px;
        --borderColor: #78b13f;
    }




    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    .gender {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
    }

    .egc {
        display: flex;
        border: 1px solid #350756;
        padding: 8px 25px 8px 8px;
        align-items: center;

        justify-content: space-between;
    }

    .dq {
        font-size: 16px;
        width: 80%;
        font-weight: 600;
    }

    .answer {
        width: 15%;
        display: flex;
        color: #04092e !important;
        justify-content: space-around;
    }

    .questions {
        color: #000c62 !important
    }

    input[type='radio']:checked:after {
        background-color: #34395e !important;
    }

    input[type='radio']:after {
        background-color: #34395e !important;
    }

    /* radiocss */
    .switch-field {
        display: flex;


    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #a5dc86;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

    /* endcss */
    .vl {
        border-left: 1px solid #350756;
        height: 40px;
    }

    .close {
        color: red;
        opacity: 1;
    }

    .close:hover {

        color: red;

    }

    .note {
        background-image: linear-gradient(to right, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d);
    }



    .comments_view>p:before {
        content: "\2022";
        /* Unicode character for a bullet point */
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }

    .comments_view>p {
        text-transform: capitalize;
    }



    /* .margintop {
        margin-top: 32px;
    } */
</style>


<style>
    #counselorerroredit {
        color: red;
    }

    #supervisorerroredit {
        color: red;
    }
</style>


<div class="main-content main_contentspace">
    <div class="row justify-content-center">
        @if (session('success'))

        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                swal.fire({
                    title: "success",
                    text: message,
                    icon: "success", // Add this line to set the success icon
                });


            }
        </script>
        @elseif(session('error'))

        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data1').val();
                swal.fire({
                    title: "Info",
                    text: message,
                    icon: "success", // Add this line to set the success icon
                });


            }
        </script>
        @endif
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">{{ Breadcrumbs::render('nrv_approval.index') }}

                <form method="POST" id="approvenrv_form" enctype="multipart/form-data" onsubmit="return false">
                    @csrf


                    <div id="">
                        <section class="section">


                            <div class="section-body mt-0">

                                <div class="row">
                                    <div class="col-12">
                                        @if($rows['approved_certificate'] == [])
                                        <a type="button" style="font-size:15px;" class="btn btn-success btn-lg mb-2 mr-2" title="Create" id="" href="" data-toggle="modal" data-target="#Approve_modal_nrv">Approved Certification Upload<i class="fa fa-plus" aria-hidden="true"></i></a>

                                        @endif
                                        <div class="card mt-0">


                                            <div class="card-body">



                                                <div class="table-wrapper">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="align7">
                                                            <thead>

                                                                <tr>
                                                                    <th>Sl.No</th>
                                                                    <th>file Name</th>
                                                                    <th>Comments</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>

                                                                </tr>


                                                            </thead>
                                                            <tbody>
                                                                @foreach($rows['approved_certificate'] as $data)

                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    <td>{{$data['file_name']}}</td>
                                                                    @if($data['comments']==null)
                                                                    <td>-</td>
                                                                    @else
                                                                    <td> <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="eligcb" data-toggle="modal" data-target="#Approve_nrv_comments">Comment</a></td>
                                                                    @endif

                                                                    @if($data['status']==0)
                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                                                    @elseif($data['status']==1)
                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                                                                    @elseif($data['status']==2)
                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                    @endif



                                                                    <td style="width:max-content;">

                                                                        <form action="" method="POST">
                                                                            @if($data['status'] ==2 )
                                                                            <a class="btn btn-link" title="Edit" onclick="editnrv(<?php echo $data['user_id'] ?>)" title="Edit" id="" href="" data-toggle="modal" data-target="#Approve_nrv"><i class="fas fa-pencil-alt" style="color:darkblue"></i></a>
                                                                            @endif
                                                                            <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$data['file_path']}}/{{$data['file_name']}}')"><i class="fa fa-eye" style="color:white !important"></i></a>
                                                                        </form>

                                                                    </td>

                                                                </tr>
                                                                @endforeach
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="col-lg-12" id="registr">

                                    <form action="" method="POST">
                                        @csrf

                                        <div class="col-md-12 text-center">

                                            <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                            <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                            <input type="hidden" class="form-control" name="registration_status" value="Registered">
                                            <!-- <label style="color:black"><i><b>Please Click Submit to Complete Supplier Registration </b></i></label><br>
                                  
                                        <a type="button" id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-thumbs-up"></i></span>Submit</a> -->

                                        </div>
                                    </form>
                                </div>


                                <div class="col-md-12 text-center">

                                    <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" name="registration_status" value="Registered">







                                </div>
                            </div>


                        </section>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>







<script>
    $(document).ready(function() {
        $('#registration_form').on('hidden.bs.modal', function()

            {
                $(this).find('form')[0].reset();
            });
    });
</script>


<div class="modal fade" id="Approve_modal_nrv">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header mh">
                <h4 class="modal-title">Approved Certification Upload</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body" style="background-color: #f8fffb !important;">
                <form action="{{route('approvenrv_store')}}" method="post" enctype="multipart/form-data" id="approve_create">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">
                    <div class="row">

                        @csrf


                        <div class="col-md-12">
                            <div class="form-group">
                                <label>File<span class="error-star" style="color:red;">*</span></label>
                                <div class="row">

                                    <div class="col-md-12">
                                        <input class="form-control" type="file" id="file" name="approvedcertificate" value="" accept=".pdf, .png," autocomplete="off">
                                        <strong style="color: red;">Following files could be uploaded pdf,png</strong>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <a class="btn btn-success btn-space" onclick="approve_valid()" id="savebutton">Submit</a>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- <script>
onclick="approved()"
function approved()
{

    var file_upload = $("#file").val();

		if (file_upload == '') {
			swal("Please Upload the File ", "", "error");
		return false;
		}
        event.preventDefault();
        

}

</script> -->

<!-- Edit NRV Module -->



<div class="modal fade" id="Approve_nrv">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header mh">
                <h4 class="modal-title">Approved Certification Upload</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>



            <div class="modal-body" style="background-color: #f8fffb !important;">
                <form action="{{route('update_store')}}" method="post" id="update_store" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">
                    <div class="row">

                        @csrf


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div>
                                        <label><b>Previous File Name</b></label>
                                    </div>
                                    <input class="form-control" type="text" id="file_name" name="file_name" value="" accept=".pdf, .png," autocomplete="off">
                                    <strong style="color: red;">Following files could be uploaded pdf,png</strong>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">

                                    <div>
                                        <label><b>New File Upload</b><span class="error-star" style="color:red;">*</span></label>

                                    </div>

                                    <input class="form-control" type="file" id="file_update" name="approvedcertificate" value="" accept=".pdf, .png," autocomplete="off">
                                    <strong style="color: red;">Following files could be uploaded pdf,png</strong>


                                    <input type="hidden" name="filen" value="">
                                    <input type="hidden" name="filep" value="">
                                </div>
                            </div>

                        </div>


                        <div class="col-md-6">
                            <a type="button" id="Doc_dwlod" class="btn btn-success " title="Download Documents" href="" download><i class="fa fa-download" style="color:white!important"></i></a>
                            <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument()"><i class="fa fa-eye" style="color:white!important"></i></a>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <a class="btn btn-success btn-space" onclick="approve_valid_edit()" id="savebutton">Update</a>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>




            </div>

        </div>


    </div>

    </form>
</div>



<!-- View NRV Model  -->



<div class="modal fade" id="Approve_nrvshow">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header mh">
                <h4 class="modal-title">Approved Certification Upload</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>



            <div class="modal-body" style="background-color: #f8fffb !important;">
                <form action="" method="post" id="update_store" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">
                    <div class="row">

                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div>
                                        <label><b>File Name</b></label>
                                    </div>
                                    <input class="form-control" type="text" id="file_name" name="file_name" value="" accept=".pdf, .doc, .png," autocomplete="off">
                                    <strong style="color: red;">Following files could be uploaded pdf,png</strong>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                </div>
                            </div>

                        </div>

                    </div>

            </div>



        </div>

        </form>
    </div>

</div>
</div>
</div>

@if(isset($rows['approved_certificate'][0]))


<div class="modal fade" id="Approve_nrv_comments">
    <div class="modal-dialog modal-md ">
        <div class="modal-content">

            <div class="modal-header mh ">
                <h4 class="modal-title">Comments</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body" style="background-color: #f8fffb !important; padding:18px !important">
                <form action="" method="post" id="update_store" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">
                    <div class="col comments_view" style="line-height:0;">

                        @csrf

                        {!! $rows['approved_certificate'][0]['comments'] !!}
                    </div>
            </div>
        </div>
    </div>
    </form>
</div>
@endif

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script>
    function editnrv(id) {

        $.ajax({

            url: "{{ url('/approve/update') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                $('#file_name').val(data[0]['file_name']);
                var file = `${data[0].file_path}/${data[0].file_name}`;

                $('#Doc_dwlod').prop('href', file);


            }
        });

    }


    function getproposaldocument(id) {
        var id = (id);
        // alert(id);
        $.ajax({
            url: "{{url('view_proposal_documents')}}",
            type: 'post',
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                console.log(data.length);
                if (data.length > 0) {
                    $("#loading_gif").hide();
                    var proposaldocuments = "<div class='removeclass' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
                    $('.removeclass').remove();
                    var document = $('#template').append(proposaldocuments);

                }
            }
        });
    };
</script>

<script>
    $(document).ready(function() {
        $('#Approve_modal_nrv').on('hidden.bs.modal', function()

            {
                $(this).find('form')[0].reset();
            });
    });

    function getproposaldocument(id) {

        var data = (id);
        $('#modalviewdiv').html('');
        $("#loading_gif").show();
        console.log(id);

        $("#loading_gif").hide();
        var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
        $('.removeclass').remove();
        var document = $('#template').append(proposaldocuments);

    };
</script>




<script>
    $(document).ready(function() {
        $('#Approve_nrv').on('hidden.bs.modal', function()

            {
                $(this).find('form')[0].reset();
            });
    });

    function approve_valid() {
        var app = $("#file").val();
        if (app == '') {
            swal.fire("Please Upload the File", "", "error");
            return false;
        } else {
            document.getElementById('approve_create').submit();
        }

    }
</script>

<script>
    function approve_valid_edit(e) {
        if (document.getElementById("file_update").value == "") {
            event.preventDefault();
            swal.fire("Please Upload the File", "", "error");
            return false;
        } else {
            document.getElementById('update_store').submit();
        }

    }
</script>





@include('Registration.formmodal')

@endsection