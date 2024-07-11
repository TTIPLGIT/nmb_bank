@extends('layouts.adminnav')

@section('content')
<style>
    #tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;

        padding: 0;
        list-style: none;
        font-size: 16px !important;

    }

    #tabs li {
        float: left;
        margin: 0 .5em 0 0;

    }

    .fa-exchange {
        color: white !important;
        width: max-content !important;
    }

    #tabs a {
        color: #000000 !important;
        position: relative;
        background: white;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        padding: .4em 1.5em;
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #bac1c5;
    }

    #tabs a:focus {
        outline: 0;
    }

    #tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: inherit;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #addition-tab::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: inherit;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #current a,
    #tabs #current a::after {
        background: #265077;
        z-index: 3;
        color: white !important;

    }

    body,
    .main-footer {
        background: white !important;
    }

    #content {
        /* background: #e9fffc; */
        padding: 2em;
        position: relative;
        z-index: 1;
        border-radius: 0 5px 5px 5px;
        /* box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        border-style: outset; */
        box-shadow: -4px 4px 4px rgb(0 0 0 / 50%), inset 1px 0px 0px rgb(255 255 255 / 40%);

    }

    .navv {
        -ms-flex-preferred-size: 0;
        flex-basis: none !important;
        -ms-flex-positive: 1;
        -webkit-box-flex: 1;
        flex-grow: 0 !important;
    }

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

    .ad {
        background-color: #2725a4 !important;
    }
</style>


<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">


                <form action="" method="POST" id="approval_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" required id="approve_details" name="approve_details" value="approve">
                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist" style="background-image: none;">

                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b> Firm Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>

                        </ul>
                    </div>
                    <!-- Tab panes -->

                    <div id="content">
                        <div id="tab1">
                            <section class="section">
                                <div class="section-body mt-1">

                                    @foreach($rows['data'] as $key=>$rows2)


                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Firm Name <span style="color: red;font-size: 16px;">*</span></label>
                                                <input class="form-control" type="text" id="firm_name" name="firm_name" value="{{$rows2['firm_name']}}" disabled autocomplete="off">

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"> Description </label>
                                                <textarea class="form-control" type="text" id="description" name="description" disabled autocomplete="off">{{$rows2['description']}}</textarea>
                                            </div>
                                        </div>




                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">URSB<span style="color: red;font-size: 16px;">*</span></label>
                                                <span class="file_color d-flex align-items-baseline" id="document" name="" value="" accept=".pdf, .doc, .png," disabled autocomplete="off"><b>{{$rows2['certificate_name']}}</b>
                                                    <div class="form-group">
                                                        <div class="dropdown show">
                                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" title="URSB" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                ...
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <a class="dropdown-item cert" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$rows2['certificate_path']}}/{{$rows2['certificate_name']}}')">View</a>

                                                                <a type="button" class="dropdown-item cert" title="Download Documents" href="{{$rows2['certificate_path']}}/{{$rows2['certificate_name']}}" download>Download</a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Proof Of Location<span style="color: red;font-size: 16px;">*</span></label>
                                                <span class="file_color d-flex align-items-baseline" id="document" name="" value="" accept=".pdf, .doc, .png," disabled autocomplete="off"><b>{{$rows2['location_proof']}}</b>
                                                    <div class="form-group">
                                                        <div class="dropdown show">
                                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" title="Proof Of Location" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                ...
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <a class="dropdown-item cert" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$rows2['location_proofpath']}}/{{$rows2['location_proof']}}')">View</a>

                                                                <a type="button" class="dropdown-item cert" title="Download Documents" href="{{$rows2['location_proofpath']}}/{{$rows2['location_proof']}}" download>Download</a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>

                                        @foreach($rows['data2'] as $key=>$rows)

                                        <div class="row list_partners">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">List Of Partners Name<span style="color: red;font-size: 16px;">*</span></label>
                                                    <select name="partner" id="partner" class="form-control" disabled>
                                                        <option value="{{$rows['partner_id']}}" selected>{{$rows['name']}}</option>
                                                    </select>
                                                    <span class="span_message" id="selectfirmerror"></span>
                                                </div>
                                            </div>





                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Valid Practising Certificate<span style="color: red;font-size: 16px;">*</span></label>
                                                    <span class="file_color d-flex align-items-baseline" id="document" name="" value="" accept=".pdf, .doc, .png," disabled autocomplete="off"><b>{{$rows['validpractisingcertificate_name']}}</b>
                                                        <div class="form-group">
                                                            <div class="dropdown show">
                                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" title="Valid Practising Certificate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    ...
                                                                </a>

                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <a class="dropdown-item cert" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$rows['validpractisingcertificate_path']}}/{{$rows['validpractisingcertificate_name']}}')">View</a>
                                                                    <a type="button" class="dropdown-item cert" title="Download Documents" href="{{$rows['validpractisingcertificate_path']}}{{$rows['validpractisingcertificate_name']}}" download>Download</a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Particulars Directors<span style="color: red;font-size: 16px;">*</span></label>
                                                    <span class="file_color d-flex align-items-baseline" id="document" name="" value="" accept=".pdf, .doc, .png," disabled autocomplete="off"><b>{{$rows['particulardirectorscertificate_name']}}</b>
                                                        <div class="form-group">
                                                            <div class="dropdown show">
                                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" title="Particulars Directors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    ...
                                                                </a>

                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <a class="dropdown-item cert" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$rows['particulardirectorscertificate_path']}}/{{$rows['particulardirectorscertificate_name']}}')">View</a>
                                                                    <a type="button" class="dropdown-item cert" title="Download Documents" href="{{$rows['particulardirectorscertificate_path']}}{{$rows['particulardirectorscertificate_name']}}" download>Download</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            @endforeach



                                        </div>
                                        @if($rows2['status']==1 || $rows2['status']==2)
                                        <div class="form-group">
                                            <div id="previousnotes" style="margin: 20px;">
                                                <div id="editor"></div>
                                                <div class="form-group scroll_flow_class" style="display: contents;">

                                                    <div class="form-outline">
                                                        <div class="card-header">
                                                            <label class="form-label" for="textAreaExample" style="font-size: 23px;">Comments</label>
                                                            <textarea name="messages" style="color:white" class="form-control" id="cgvapprove" name="approve" rows="6" disabled>{{$rows2['comments']}}</textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        @elseif($rows2['status']==0)
                                        <div class="form-group">
                                            <div id="previousnotes" style="margin: 20px;">
                                                <div id="editor"></div>
                                                <div class="form-group scroll_flow_class" style="display: contents;">

                                                    <div class="form-outline">
                                                        <div class="card-header">
                                                            <label class="form-label" for="textAreaExample" style="font-size: 23px;">Comments</label>
                                                            <textarea name="messages" style="color:white" class="form-control" id="cgvapprove" name="approve" rows="6"></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        @endif

                                        <input type="hidden" class="form-control" required id="id" name="id" value="{{$rows2['id']}}">

                                        <div style="display:flex; justify-content:center; align-items:baseline; width:100%">

                                            @if($rows2['status']==1 || $rows2['status']==2)
                                            <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                                            @elseif($rows2['status']!=1)
                                            <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>

                                            <a class="btn btn-labeled btn-info" onclick="form_action(`{{route('firm_approveupdate')}}`);" title="Update" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px !important; margin-left: 15px;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-up"></i></span>Approve</a>
                                            <a type="submit" onclick="form_action(`{{route('firm_rejectupdate')}}`);" id="update" class="btn btn-labeled btn-info" title="next" style="background: blue !important; border-color:blue !important; color:white !important; margin-top:15px !important; margin-left: 15px;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></i></span>Reject</a>

                                        </div>
                                        @else
                                        @endif





                                    </div>
                                    @endforeach
                                    <div id="dynamic_fielddip"></div>
                                    <input type="hidden" name="attachment_countdip" id="attachment_countdip" value="0">
                                </div>





                            </section>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@if($rows2['status']==1 || $rows2['status']==2)
<script>
    $(document).ready(function() {

        tinymce.init({
            selector: 'textarea#cgvapprove',
            height: 180,
            menubar: 'table',
            branding: false,
            plugins: 'table',
            readonly: 1,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help' + 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        // event.preventDefault()
    });

    function form_action(form_action) {


        $('#approval_form').attr('action', form_action);
        $('#approval_form').submit();

    }
</script>
@elseif($rows2['status']==0)
<script>
    $(document).ready(function() {

        tinymce.init({
            selector: 'textarea#cgvapprove',
            height: 180,
            menubar: 'table',
            branding: false,
            plugins: 'table',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help' + 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        // event.preventDefault()
    });

    function form_action(form_action) {


        $('#approval_form').attr('action', form_action);
        $('#approval_form').submit();

    }
</script>
@endif




<script>
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








@include('Registration.formmodal')


@endsection