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

    #tabs a {

        position: relative;
        background: #ffffff;
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
        background: #ffffff;
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
        background: #ffffff;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .nav-justified {

        background-image: none;
    }

    #tabs #addition-tab::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #268f7f;
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

    .gender {
        display: flex;
        justify-content: space-evenly;
    }
</style>
<div class="main-content main_contentspace" style="position:absolute !important; z-index:-2!important">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">
                @foreach($rows['general'] as $data)
                @php $id=$data['user_id']; @endphp
                @endforeach
                {{ Breadcrumbs::render('Registration.edit',$id) }}
                <form action="{{ route('Registration.update',$id) }}" method="POST" id="generalupdate_form" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="general">
                    <div class="tile" id="tile-1" style="margin-top:10px !important;">
                        <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">
                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b> General</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Tab panes -->

                    @foreach($rows['general'] as $data)

                    <div id="content">
                        <div id="tab1">
                            <section class="section">
                                <div class="section-body mt-1">

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="general">

                                    <div class="row">

                                    </div>
                                    <h style="color:black"><b>Address:</b></h>
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">

                                                <label>Address Line :<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="Address_line1" name="Address_line1" value="{{$data['Address_line1']}}">
                                            </div>
                                        </div>
                                        <!-- </div>
                                                        
                                                            <div class="row"> -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>District:<span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="district_edit" name="district_edit">
                                                    <option value="{{$data['district']}}">{{$data['district_name']}}</option>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Constituency:</label>
                                                <select class="form-control default" required id="constituency" name="constituency">
                                                    <option value="">Select Constituency</option>
                                                    <option value="{{$data['constituency']}}" selected>{{$data['constituency_name']}}</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">

                                                <label>Village:</label>
                                                <select class="form-control default" required id="village" name="village">
                                                    <option value="">Select Village</option>
                                                    <option value="{{$data['village']}}" selected>{{$data['village_name']}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="fw-light" for="nin" style="margin-left: 20px;">Choose an NIN (or) Passport</label>
                                    <div class="col d-flex justify-content-between">
                                        <div class="col-12 d-flex align-items-baseline ml-4" style="gap:10px">
                                            <input type="radio" id="nin" name="document_type" onchange="toggleNINDetails(this,'NIN (National Identification Number):','NIN Document:','{{$data['document_type'] == 'nin' ? 'old_proof' : 'new_proof' }}')" value="nin" class="nin" {{$data['document_type'] == 'nin' ? "checked" : ""}}>
                                            <label class="fw-light" for="nin">NIN</label>
                                            <input type="radio" id="passport" name="document_type" onchange="toggleNINDetails(this,'PASSPORT_Number:','Passport Document:','{{$data['document_type'] == 'passport' ? 'old_proof' : 'new_proof' }}')" value="passport" class="passport" {{$data['document_type'] == 'passport' ? "checked" : ""}}>
                                            <label for="passport">Passport</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row old_proof proof_container" id="nin_doc">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{$data['document_type'] == 'nin' ? "NIN (National Identification Number)" : "passport"}}<span class="error-star" style="color:red;">*</span></label>

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control default old_proof_value" maxlength="14" value="{{$data['nin']}}" oninput="this.value = this.value.replace(/[^a-zA-Z0-9.]/g, '').replace(/(\..*)\./g, '$1');" required id="nin" name="nin">
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label>{{$data['ninfn']}}</label>
                                                        <input type="hidden" name="oldninfn" value="{{$data['ninfn']}}">
                                                        <input type="hidden" name="oldninfp" value="{{$data['ninfp']}}">
                                                        <a type="button" class="btn btn-success " title="Download Documents" href="{{$data['ninfp']}}/{{$data['ninfn']}}" download><i class="fa fa-download" style="color:white!important"></i></a>
                                                        <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$data['ninfp']}}/{{$data['ninfn']}}')"><i class="fa fa-eye" style="color:white!important"></i></a>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-info " id="f1" title="change Documents" value="1" onclick="changefile1(this)"><i class="fa fa-exchange" id="fi1" style="color:white!important">Change file</i></button>
                                                    <input type="hidden" id="i1" name="f1" value="1">
                                                </div>
                                                <div class="col-md-6 mb-0" id="dninf1">
                                                    <div class="form-group mb-0">
                                                        <label><b>{{$data['document_type'] == 'nin' ? "NIN FILE" : "Passport FILE"}}</b><span class="error-star" style="color:red;">*</span></label>
                                                    </div>
                                                    <input class="form-control  mb-0 old_proof_file" type="file" accept=".pdf, .png," id="ninf" name="ninf" value="" autocomplete="off">
                                                    <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Passport -->
                                <div class="row new_proof d-none proof_container" id="passport_doc">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <div class="row">
                                                <div class="col-md-5" id="dninf">
                                                    <div class="form-group mb-0">
                                                        <label>{{$data['document_type'] == 'nin' ? "passport" : " NIN (National Identification Number)"}}<span class="error-star" style="color:red;">*</span></label>
                                                    </div>
                                                    <input type="text" class="form-control default new_proof_value" maxlength="14" value="" oninput="this.value = this.value.replace(/[^a-zA-Z0-9.]/g, '').replace(/(\..*)\./g, '$1');" required id="nin" name="nin_new">
                                                </div>
                                                <!-- <div class="form-group mb-0">
                                            <label>{{$data['document_type'] == 'nin' ? "NIN (National Identification Number)" : "passport"}}<span class="error-star" style="color:red;">*</span></label>
                                            </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control default" maxlength="14" oninput="this.value = this.value.replace(/[^a-zA-Z0-9.]/g, '').replace(/(\..*)\./g, '$1');" required id="nin" name="nin">
                                                </div> -->
                                                <div class="col-md-5" id="dninf1">
                                                    <div class="form-group mb-0">
                                                        <label>{{$data['document_type'] == 'nin' ? "passport File" : " NIN File"}}<span class="error-star" style="color:red;">*</span></label>
                                                    </div>
                                                    <input class="form-control  mb-0 new_proof_file" type="file" onchange="changef1_value()" accept=".pdf, .png," id="nin" name="ninf_new" value="" autocomplete="off">
                                                    <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                                </div>
                                            </div>

                                            <div class="row d-none">
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-info " id="f1" title="change Documents" value="1" onclick="changefile1(this)"><i class="fa fa-exchange" id="fi1" style="color:white!important">Change file</i></button>
                                                    <!-- <input type="hidden" id="i1" name="f1" value="1"> -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    @endforeach
                    <div style="display:flex; justify-content:center; width:100%">

                        <a type="button" class="btn btn-labeled btn-info" href="{{url('Registration')}}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                        <a id="updatebutton" onclick="gencre()" class="btn btn-labeled btn-info" title="Update" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px !important; margin-left: 15px;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
    const changef1_value = () => {
        $('#i1').val('0');
    }

    function gencre() {



        var add = $("#Address_line1").val();
        if (add == '') {
            swal.fire("Please Enter the Address", "", "error");
            return false;
        }

        var dist = $("#district_edit").val();
        if (dist == '') {
            swal.fire("Please Select the District", "", "error");
            return false;
        }



        var nin = $("input[name='nin']").val();
        if (nin == '') {
            swal.fire("Please Enter the NIN", "", "error")
            return false;
        }


        if (document.querySelector('#dninf1').style.display == "inline-block") {
            var nin = $("input[name='ninf']").val();
            if (nin == '') {
                swal.fire("Please Upload the NIN FILE", "", "error")
                return false;
            }
        }
        if (!$('.new_proof').hasClass('d-none')) {
            var nin = $("input[name='ninf']").val();
            if (nin == '') {
                swal.fire("Please Upload the NIN FILE", "", "error")
                return false;
            }

        }

        document.getElementById('generalupdate_form').submit();


    }
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('district_list') }}",
            type: 'GET',
            data: {
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                $('#district_edit option:first').nextAll().remove(); // Remove options after the first option

                for (const row of data) {
                    const single_option = `<option value="${row.id}">${row.district_name}</option>`
                    $('#district_edit option:first').after(single_option);
                }



            }
        });
    });
    $(document).on('change', '#district_edit', function() {
        var district_id = $(this).val();
        $.ajax({
            url: "{{ url('constituency_list') }}",
            type: 'GET',
            data: {
                id: district_id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                $('#constituency option:first').nextAll().remove(); // Remove options after the first option
                $('#village option:first').nextAll().remove(); // Remove options after the first option
                for (const row of data) {
                    const single_option = `<option value="${row.id}">${row.constituency_name}</option>`
                    $('#constituency option:first').after(single_option);
                }



            }
        });

    })

    $(document).on('change', '#constituency', function() {
        var constituency_id = $(this).val();
        $.ajax({
            url: "{{ url('village_list') }}",
            type: 'GET',
            data: {
                id: constituency_id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                $('#village option:first').nextAll().remove(); // Remove options after the first option

                for (const row of data) {
                    const single_option = `<option value="${row.id}">${row.village_name}</option>`
                    $('#village option:first').after(single_option);
                }



            }
        });

    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        document.getElementById('dninf1').style.display = "none";
        // document.getElementById('dninf2').style.display = "none";
        document.getElementById('ninf').removeAttribute('required');
        // document.getElementById('ppf').removeAttribute('required');

    });

    function submit() {

        document.getElementById('generalupdate_form').submit();
    }

    function changefile1(a) {

        var a = a.value;
        if (a == "1") {
            document.getElementById('ninf').setAttribute('required', 'required');
            document.getElementById('dninf1').style.display = "inline-block";
            document.getElementById('f1').value = "2";
            document.getElementById('i1').value = "0";
            document.getElementById('fi1').innerText = " Stay The Same";
        } else {
            document.getElementById('ninf').removeAttribute('required');
            document.getElementById('dninf1').style.display = "none";
            document.getElementById('f1').value = "1";
            document.getElementById('i1').value = "1";
            document.getElementById('fi1').innerText = " Change File";
        }
    };

    function changefile2(a) {

        var a = a.value;
        if (a == "1") {
            document.getElementById('ppf').setAttribute('required', 'required');
            document.getElementById('dninf2').style.display = "inline-block";
            document.getElementById('f2').value = "0";
            document.getElementById('i2').value = "0";
            document.getElementById('fi2').innerText = " Stay The Same";
        } else {
            document.getElementById('ppf').removeAttribute('required');
            document.getElementById('dninf2').style.display = "none";
            document.getElementById('f2').value = "1";
            document.getElementById('i2').value = "1";
            document.getElementById('fi2').innerText = " Change File";
        }
    };

    function getproposaldocument(id) {
        var id = (id);

        $.ajax({
            url: "{{url('view_proposal_documents')}}",
            type: 'post',
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            error: function() {},
            success: function(data) {
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
    function getproposaldocument(id) {

        var data = (id);
        $('#modalviewdiv').html('');
        $("#loading_gif").show();
        $("#loading_gif").hide();
        var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
        $('.removeclass').remove();
        var document = $('#template').append(proposaldocuments);

    };
</script>


<script>
    function toggleNINDetails(e, label, label2, proof_div) {
        if (proof_div == 'old_proof') {
            $('.old_proof_value').prop('name', 'nin');
            $('.new_proof_value').prop('name', 'nin_new');

            $('.old_proof_file').prop('name', 'ninf');
            $('.new_proof_file').prop('name', 'ninf_new');

        } else {
            $('.new_proof_value').prop('name', 'nin');
            $('.old_proof_value').prop('name', 'nin_new');

            $('.old_proof_file').prop('name', 'ninf_new');
            $('.new_proof_file').prop('name', 'ninf');
        }
        $('.proof_container').addClass('d-none');
        $(`.${proof_div}`).removeClass('d-none');
    }
    document.addEventListener("DOMContentLoaded", function() {
        const ninRadio = document.getElementById("nin");
        const passportRadio = document.getElementById("passport");
        const ninSection = document.getElementById("nin_doc");
        const passportSection = document.getElementById("passport_doc");
        const change_file = document.getElementById("change_file");
    });
</script>

@include('Registration.formmodal')
@endsection