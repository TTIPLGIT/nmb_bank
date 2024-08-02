@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }

    .no-arrow {
        -moz-appearance: textfield;
    }

    /* .no-arrow::-webkit-inner-spin-button {
        display: none;
    } */

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

    a.btn.btn-success.btn-lg.question {
        /* float: right; */
        margin-bottom: 15px;
    }

    .card.longquestion {
        padding: 15px;
    }

    .wordquestion {
        display: flex;
    }

    h4.modal-title.long {

        text-align: center;
        padding: 20px;
        font-size: 25px;

    }

    h4.modal-title.mcq {
        text-align: center;
        padding: 20px;
        font-size: 25px;
    }

    h4.modal-title.short {
        text-align: center;
        padding: 20px;
        font-size: 25px;
    }

    h4.modal-title.true {
        text-align: center;
        padding: 20px;
        font-size: 25px;
    }

    .container.edit.longquestion {
        padding: 17px;
    }

    form.longqustionsform {

        margin: 15px;
        margin-right: 0px;
        margin-left: 37px;
    }

    .btn>i {
        margin-left: 14px !important;
        /* background-color: darkolivegreen; */
    }

    @media only screen and (max-width: 425px) {
        .col-sm-2.addquizmodal {
            margin-bottom: 12px;
        }

        textarea#quistion {
            width: 100%;
        }

        textarea#quistions2 {
            width: 100%;
        }

        textarea#quistion11 {
            width: 100%;
        }
    }

    @media only screen and (max-width: 1024px) {
        .btn.btn-lg {
            padding: 10px 9px;
            font-size: 12px;
        }
    }

    .btn.btn-lg {
        padding: 10px 10px;
        font-size: 12px;
    }
</style>


<style>
    #counselorerroredit {
        color: red;
    }

    #supervisorerroredit {
        color: red;
    }
    .dropdown-container
    {
        margin-top: 0px !important;
    }
</style>



<div class="main-content main_contentspace">
    <div class="row justify-content-center">

        <div class="col-lg-12 col-md-12">
            <div class="">{{ Breadcrumbs::render('member_list') }}

                <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                    @csrf



            </div>


            <div id="content">


                <section class="section">


                    <div class="section-body mt-0">

                        <!-- <div class="col-12"> -->
                        <div class="row">

                            <div class="col-md-7"></div>

                            <div class="col-md-2">
                                <a type="button" style="font-size:15px;" class="btn btn-success btn-lg question" title="Create" href="" data-toggle="modal" data-target="#addModal">Add Member <span><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                            </div>
                            <div class="col-md-3">
                                <a type="button" style="font-size:15px;" class="btn btn-success btn-lg question" title="Create" href="" data-toggle="modal" data-target="#addModal1">Add Bulk Member <span><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                            </div>
                        </div>

                    </div>
                </section>

            </div>

            <section class="section5" id="memberlist">
                <div class="section-body mt-1">
                    <div class="row">
                        <div class="col-12">
                            <h3 style="margin-top:10px;text-align:center;">Member List</h3>
                            <div class="card mt-0">
                                <div class="card-body">

                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Type</th>
                                                        <th>Name </th>
                                                        <th>ISU/Reg No</th>
                                                        <th>Email </th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #cfe0e8;">

                                                    @foreach($rows['rows'] as $data)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        @if($data['type'] =="sv")
                                                        <td>Surveyors</td>
                                                        @elseif($data['type'] =="vl")
                                                        <td>Valuers</td>
                                                        @endif
                                                        <td>{{$data['name']}}</td>
                                                        <td>{{$data['isu_reg_number']}}</td>
                                                        <td>{{$data['email']}}</td>
                                                        <td>

                                                            <a class="" title="Edit" id="gcb" data-toggle="modal" data-target="#addModal4" onclick="fetch_update({{$data['id']}},'edit')"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                            <a class="btn btn-link" onclick="fetch_update({{$data['id']}},'member_show')" title="Show" id="gcb" href="" data-toggle="modal" data-target="#addModalmember"><i class="fas fa-eye" style="color:green"></i></a>
                                                            <a type="button" title="Delete" onclick="member_delete(<?php echo $data['id'] ?>)" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></a>


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



                </div>

            </section>



            </form>
        </div>

    </div>

</div>
</div>


<script>
    $(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var minDate = year + '-' + month + '-' + day;

        $('#txtDate').attr('min', minDate);
    });
</script>
<!-- addquestion function -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header mh">
                <h4 class="modal-title">Add Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <!-- Long question -->

            <div class="card longquestion" id="">
                <h4 class="modal-title long">Add Member</h4>
                <form method="POST" id="member_form" action="{{route('memberlist_store')}}" name="add_member" enctype="multipart/form-data" class="reset">
                    @csrf


                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="name" name="name">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Type:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control default" id="type" name="type">
                                    <option value="">---Select Member Type---</option>
                                    <option value="sv">Surveyors</option>
                                    <option value="vl">Valuers</option>


                                </select>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>



                    <div id="vl" style="display:none !important;">


                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Class:<span class="error-star" style="color:red;">*</span></label>
                                    <select class="form-control default" id="mclass" name="mclass">
                                        <option value="">---Select Class---</option>
                                        <option value="fellow">Fellow</option>
                                        <option value="P/M">P/M</option>
                                        <option value="technician">Technician</option>
                                        <option value="P/A">P/A</option>
                                        <option value="Hon.Member">Hon. Member</option>
                                        <option value="graduate">Graduate</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Chapter:<span class="error-star" style="color:red;">*</span></label>
                                    <input type="text" class="form-control default" id="chapter" name="chapter">
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label id="reg_isu_No">ISU/Reg No:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="isu_reg_number" name="isu_reg_number">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Qualifications:</label>
                                <input type="text" class="form-control default" id="qualification" name="qualification">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Gender:</label>
                                <select class="form-control default" id="gender" name="gender">
                                    <option value="">---Select Gender---</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Phone:</label>
                                <input type="text" class="form-control default" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Email:<span class="error-star" style="color:red;">*</span></label>
                                <input type="email" class="form-control default" id="email" name="email">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Address:</label>
                                <textarea class="form-control default" id="address" name="address"></textarea>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Location:</label>
                                <textarea class="form-control default" id="location" name="location"></textarea>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <a class="btn btn-success btn-space" onclick="gencre()" id="">Submit</a>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end -->
            <!-- Mcq -->




            <!-- end -->
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
<div class="modal fade" id="addModal1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header mh">
                <h4 class="modal-title">Add Bulk Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <!-- Long question -->

            <div class="card longquestion" id="">

                <div class="row">
                    <div class="col-md-6">
                        <h4 class="modal-title long">Add Bulk Member</h4>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4">



                        <button type="button" style="float:right;font-size: 14px; margin-top: -10px; text-align: center;border-radius: 3px;" data-toggle="modal" data-target="#exampleModal" class="btn btn-warning"> Download Template </button>
                    </div>
                </div>
                <form method="POST" action="{{route('memberbulk_store')}}" name="add_member" enctype="multipart/form-data" class="reset" id="memberbulk_store">
                    @csrf

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Member Upload:<span class="error-star" style="color:red;">*</span></label>

                                <input type="file" id="fileUpload" class="form-control" style="margin: 0px;padding: 5px" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                <input type="hidden" name="excel_row" id="excel_row12" class="">
                                <input type="hidden" name="jsonData" id="jsonData" class="">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>



                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="button" class="btn btn-success" id="upload" onclick="upload_bulk()">Upload</button>
                            <a href="{{ route('member_list') }}" class="btn btn-danger" style="border-radius: 3px;"> Cancel</a>

                        </div>
                    </div>
                </form>
            </div>

            <!-- end -->
            <!-- Mcq -->




            <!-- end -->
        </div>
    </div>
</div>

<div class="modal fade" id="addModalmember">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="" id="show_member" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Show Member</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #f8fffb !important;">
                    <input type="hidden" class="form-control" id="idshow" name="id">

                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Name:</label>
                                <input type="text" class="form-control default" id="nameshow" name="nameshow">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Type:</label>
                                <input type="text" class="form-control default typeshow" id="typeshow" name="typeshow">
                            </div>
                        </div>



                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ISU/Reg No:</label>
                                <input type="text" class="form-control default" id="isu_reg_numbershow" name="isu_reg_numbershow">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Qualifications:</label>
                                <input max="200" class="form-control default" id="qualificationshow" name="qualificationshow">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender:</label>
                                <input type="text" class="form-control default" id="gendershow" name="gendershow">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Phone:</label>
                                <input max="200" class="form-control default" id="phoneshow" name="phoneshow">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="text" class="form-control default" id="emailshow" name="emailshow">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Address:</label>
                                <input max="200" class="form-control default" id="addressshow" name="addressshow">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Location:</label>
                                <input type="text" class="form-control default" id="locationshow" name="locationshow">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class:</label>
                                <input type="text" class="form-control default" id="classshow" name="classshow">
                            </div>
                        </div>


                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Chapter:</label>
                                <input type="text" class="form-control default" id="chaptershow" name="chaptershow">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<div class="modal fade" id="addModal4">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" action="{{route('elearning.member_update',1)}}" id="edit_form" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="id" class="id" id="id">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Member</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>


                <div class=" container edit  longquestion">
                    <h4 class="modal-title long">Edit Member</h4>


                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="nameedit" name="nameedit">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Type:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control typeshow" name="typeedit" id="typeedit" onchange="data(event);">
                                    <option>---Select Type---</option>
                                    <option value="sv">Surveyor </option>
                                    <option value="vl">Valuers</option>
                                </select>
                            </div>
                        </div>



                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ISU/Reg No:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="isu_reg_numberedit" name="isu_reg_numberedit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Qualifications:<span class="error-star" style="color:red;">*</span></label>
                                <input max="200" class="form-control default" id="qualificationedit" name="qualificationedit">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6" id="yesedit">
                            <div class="form-group">
                                <label>Gender:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="genderedit" id="genderedit" onchange="data(event);">
                                    <option>---Select Gender---</option>
                                    <option value="male">Male </option>
                                    <option value="female">Female</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Phone:<span class="error-star" style="color:red;">*</span></label>
                                <input max="200" class="form-control default" id="phoneedit" name="phoneedit">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="emailedit" name="emailedit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Address:<span class="error-star" style="color:red;">*</span></label>
                                <input max="200" class="form-control default" id="addressedit" name="addressedit">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Location:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="locationedit" name="locationedit">
                            </div>
                        </div>

                        <div class="col-md-6" id="yesedit">
                            <div class="form-group">
                                <label>Class:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control default" id="classedit" name="classedit" onchange="data(event);">
                                    <option value="">---Select Class---</option>
                                    <option value="fellow">Fellow</option>
                                    <option value="P/M">P/M</option>
                                    <option value="technician">Technician</option>
                                    <option value="P/A">P/A</option>
                                    <option value="Hon.Member">Hon. Member</option>
                                    <option value="graduate">Graduate</option>
                                </select>

                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Chapter:</label>
                                    <input type="text" class="form-control default" id="chapteredit" name="chapteredit">
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- <h style="color:black"><b>Address:</b></h> -->


                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space savebutton" type="submit" onclick="gencre11('edit')" id="savebutton">Update</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-yellow">
                <h5 class="modal-title" id="formModal">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body md">
                <ul class="arrow">
                    <li>Do not add / delete/ modify any columns</li>
                    <li>Do not rename the excel file</li>
                    <li>Do not attach any image files</li>
                    <li>No macros & Pivot tables are allowed</li>

                </ul>
            </div>
            <div class="text-center">
                <a href="{{ ('/member_creation_bulk.xlsx') }}" class="btn btn-warning" id="exampleModalclose"> <span class="icon-name" style="position: relative; bottom: 4px;">OK</span></a>
            </div>
            <br>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
    function data(e) {
        // alert(e);
        if (e.target.id == "genderedit") {
            if (e.target.value == "male") {

                $('#yesedit').val('display', 'block');

            }

        } else if (e.target.id == "genderedit") {
            if (e.target.value == "female") {

                $('#yesedit').val('display', 'block');
            }
        }

        if (e.target.id == "typeedit") {
            if (e.target.value == "sv") {

                $('#yesedit1').val('display', 'block');

            }

        } else if (e.target.id == "typeedit") {
            if (e.target.value == "vl") {

                $('#yesedit1').val('display', 'block');
            }
        }

        if (e.target.id == "classedit") {
            if (e.target.value == "fellow") {

                $('#yesedit2').val('display', 'block');

            }

        } else if (e.target.id == "classedit") {
            if (e.target.value == "P/M") {

                $('#yesedit2').val('display', 'block');
            }
        } else if (e.target.id == "classedit") {
            if (e.target.value == "technician") {

                $('#yesedit2').val('display', 'block');
            }
        } else if (e.target.id == "classedit") {
            if (e.target.value == "P/A") {

                $('#yesedit2').val('display', 'block');
            }
        } else if (e.target.id == "classedit") {
            if (e.target.value == "Hon.Member") {

                $('#yesedit2').val('display', 'block');
            }
        } else if (e.target.id == "classedit") {
            if (e.target.value == "graduate") {

                $('#yesedit2').val('display', 'block');
            }
        }

    }
</script>

<script>
    function gencre() {


        var name = $("#name").val();
        if (name == '') {
            swal.fire("Please Enter the Name", "", "error");
            return false;
        }

        var type = $("#type").val();
        if (type == '') {
            swal.fire("Please Enter the Member Type", "", "error");
            return false;
        }

        if (type == 'vl') {
            var classn = $("#class").val();
            if (classn == '') {
                swal.fire("Please Enter the Class", "", "error");
                return false;
            }
            var chapter = $("#chapter").val();
            if (chapter == '') {
                swal.fire("Please Enter the Chapter", "", "error");
                return false;
            }
        }


        var isu_reg_number = $("#isu_reg_number").val();
        if (isu_reg_number == '') {
            swal.fire("Please Enter the ISU/Reg Number", "", "error")
            return false;
        }

        var email = $("#email").val();
        if (email == '') {
            swal.fire("Please Enter the Email", "", "error");
            return false;
        }
        document.getElementById('member_form').submit();


    }


    $('#type').on('change', function() {
        //fetch_courseupdate_new();
        $('#vl').css('display', 'none');
        $('#sv').css('display', 'none');

        if ($(this).val() === 'vl') {
            $('#vl').css('display', 'block');
        }
        if ($(this).val() === 'sv') {
            $('#sv').css('display', 'block');
        }

    });

    $(document).on('change', '#type', function() {
        if ($(this).val() == "sv") {
            $('#reg_isu_No').text("Reg No:*");
        } else {
            $('#reg_isu_No').text("ISU No:*");
        }
    })
</script>



<script>
    function member_delete(id) {
        //alert(class_id);

        Swal.fire({
            title: "Are you you want to delete the Member?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('member_delete') }}",
                    type: 'POST',
                    data: {
                        id: id,

                        _token: '{{csrf_token()}}'
                    },
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function(data) {

                        if (result.value) {
                            Swal.fire("Success!", "Member Deleted Successfully!", "success").then((result) => {

                                location.replace(`/member_list`);

                            })
                        }

                    }

                });
            }
        })


    }
</script>

<script>
    function fetch_update(id, type) {


        $.ajax({
            url: "{{ url('/member/fetch') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                // correct_choices = data.rows[0]['correct_choices'].split(',');

                console.log(data);

                if (type == "member_show") {

                    $('#nameshow').val(data.rows[0]['name']);

                    if (data.rows[0]['type'] == "sv") {
                        $('.typeshow').val('Surveyors', true)

                    } else if (data.rows[0]['type'] == "vl") {
                        $('.typeshow').val('Valuers', true)

                    }

                    $('#classshow').val(data.rows[0]['mclass']);
                    $('#chaptershow').val(data.rows[0]['chapter']);
                    $('#isu_reg_numbershow').val(data.rows[0]['isu_reg_number']);
                    $('#qualificationshow').val(data.rows[0]['qualification']);
                    $('#gendershow').val(data.rows[0]['gender']);
                    $('#phoneshow').val(data.rows[0]['phone']);
                    $('#emailshow').val(data.rows[0]['email']);
                    $('#addressshow').val(data.rows[0]['address']);
                    $('#locationshow').val(data.rows[0]['location']);

                    $('#idshow').val(data.rows[0]['id']);

                    $('#nameshow').prop('disabled', true);
                    $('#typeshow').prop('disabled', true);
                    $('#classshow').prop('disabled', true);
                    $('#chaptershow').prop('disabled', true);
                    $('#isu_reg_numbershow').prop('disabled', true);
                    $('#qualificationshow').prop('disabled', true);
                    $('#gendershow').prop('disabled', true);
                    $('#phoneshow').prop('disabled', true);
                    $('#emailshow').prop('disabled', true);
                    $('#addressshow').prop('disabled', true);
                    $('#locationshow').prop('disabled', true);

                    $('#idshow').attr('Action', '');
                } else if (type == "edit") {

                    $('#nameedit').val(data.rows[0]['name']);


                    $('#typeedit').val(data.rows[0]['type']);
                    if (data.rows[0]['type'] == 'sv') {
                        $('#yesedit1').show();

                    } else if (data.rows[0]['type'] == 'vl') {
                        $('#yesedit1').show();
                    }
                    $('#classedit').val(data.rows[0]['mclass']);
                    $('#chapteredit').val(data.rows[0]['chapter']);
                    if (data.rows[0]['mclass'] == 'fellow') {
                        $('#yesedit2').show();

                    } else if (data.rows[0]['mclass'] == 'P/M') {
                        $('#yesedit2').show();
                    } else if (data.rows[0]['mclass'] == 'technician') {
                        $('#yesedit2').show();
                    } else if (data.rows[0]['mclass'] == 'P/A') {
                        $('#yesedit2').show();
                    } else if (data.rows[0]['mclass'] == 'Hon.Member') {
                        $('#yesedit2').show();
                    } else if (data.rows[0]['mclass'] == 'graduate') {
                        $('#yesedit2').show();
                    }
                    $('#isu_reg_numberedit').val(data.rows[0]['isu_reg_number']);
                    $('#qualificationedit').val(data.rows[0]['qualification']);

                    $('#genderedit').val(data.rows[0]['gender']);
                    if (data.rows[0]['gender'] == 'male') {
                        $('#yesedit').show();

                    } else if (data.rows[0]['gender'] == 'female') {
                        $('#yesedit').show();
                    }
                    $('#phoneedit').val(data.rows[0]['phone']);
                    $('#emailedit').val(data.rows[0]['email']);
                    $('#addressedit').val(data.rows[0]['address']);
                    $('#locationedit').val(data.rows[0]['location']);

                    $('#id').val(data.rows[0]['id']);


                }

            }
        });

    }
</script>



<script type="text/javascript">
    $("#exampleModalclose").click(function() {
        $('#exampleModal').modal('toggle');
        $("#exampleModal").hide();
    });
</script>



<script type="text/javascript">
    $('#upload').click(function(e) {
        e.preventDefault();

        var fileUpload = $('#fileUpload').val();

        if (fileUpload == '') {
            swal.fire("Please Upload a File", "", "error");

            return false;
        }
    });
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>


<script type="text/javascript">
    function upload_bulk() {

        $('#upload').hide();
        var fileUpload = document.getElementById("fileUpload");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
        var file = fileUpload.files[0];
        var filename = file.name;
        console.log(filename);
        if (filename == "member_creation_bulk.xlsx") {
            if (regex.test(fileUpload.value.toLowerCase())) {
                if (typeof(FileReader) != "undefined") {
                    var reader = new FileReader();
                    if (reader.readAsBinaryString) {
                        reader.onload = function(e) {
                            ProcessExcel(e.target.result);
                        };
                        reader.readAsBinaryString(fileUpload.files[0]);
                    } else {
                        reader.onload = function(e) {
                            var data = "";
                            var bytes = new Uint8Array(e.target.result);
                            for (var i = 0; i < bytes.byteLength; i++) {
                                data += String.fromCharCode(bytes[i]);
                            }
                            ProcessExcel(data);
                        };
                        reader.readAsArrayBuffer(fileUpload.files[0]);
                    }
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid Excel file.");
            }
        } else {
            swal.fire({
                title: "Error",
                text: "Please Upload Valid File!",
                type: "error",
                confirmButtonText: "OK"
            });
        }
    };

    function ProcessExcel(data) {
        var workbook = XLSX.read(data, {
            type: 'binary'
        });
        var firstSheet = workbook.SheetNames[0];
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
        console.log(excelRows);
        $("#excel_row12").val(excelRows.length);
        var newcount = excelRows.length;
        $("#table-edit").show();
        $("#texthide").hide();
        $("#fileUpload").prop("disabled", true);

        let jsonObject = JSON.stringify(excelRows);
        document.getElementById('jsonData').value = jsonObject;
        console.log('test', jsonObject);

        for (var i = 0; i < newcount; i++) {

            var name = excelRows[i].name;
            if (name == undefined) {
                name = '';

            }

            var type = excelRows[i].type;
            if (type == undefined) {
                type = '';

            }

            var mclass = excelRows[i].mclass;
            if (mclass == undefined) {
                mclass = '';

            }

            var isu_reg_number = excelRows[i].isu_reg_number;
            if (isu_reg_number == undefined) {
                isu_reg_number = '';

            }

            var qualification = excelRows[i].qualification;
            if (qualification == undefined) {
                qualification = '';

            }

            var address = excelRows[i].address;
            if (address == undefined) {
                address = '';

            }
            var email = excelRows[i].email;
            if (email == undefined) {
                email = '';

            }

            var phone = excelRows[i].phone;
            if (phone == undefined) {
                phone = '';

            }

            var location = excelRows[i].location;
            if (location == undefined) {
                location = '';

            }

            var gender = excelRows[i].gender;
            if (gender == undefined) {
                gender = '';

            }




            // $('#datatable').DataTable().row.add([
            //     '<input type="text" name="name[]" id="name' + i + '" class="form-control vendor1" value ="' + name + '">', '<input type="text" name="type[]" id="type' + i + '" class="form-control" value ="' + type + '">', '<input type="text" name="mclass[]" id="mclass' + i + '" class="form-control" value ="' + class + '">', '<input type="text" name="isu_reg_number[]" id="isu_reg_number' + i + '" class="form-control" value ="' + isu_reg_number + '">', '<input type="text" name="qualification[]" id="qualification' + i + '" class="form-control vendor1" value ="' + qualification + '">', '<input type="text" name="address[]" id="address' + i + '" class="form-control" value ="' + address + '">', '<input type="text" name="email[]" id="email' + i + '" class="form-control" value ="' + email + '">', '<input type="text" name="phone[]" id="phone' + i + '" class="form-control" value ="' + phone + '">', '<input type="text" name="location[]" id="location' + i + '" class="form-control" value ="' + location + '">', '<input type="text" name="gender[]" id="gender' + i + '" class="form-control" value ="' + gender + '">'
            // ]).draw();
        }
        // memberbulk_store
        document.getElementById('memberbulk_store').submit();
    };


    $("#savebtn").click(function(e) {
        e.preventDefault();

        swal.fire({
                title: "Success",
                text: "Data Inserted Successfully",
                type: "success"
            },
            function() {

            }
        );


    });
</script>


<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "scrollY": "500px",
            "scrollCollapse": true,
            "paging": false,
            "filter": false,
            "bSort": false,
        });
    });

    var selectedFile;
    document
        .getElementById("fileUpload")
        .addEventListener("change", function(event) {
            selectedFile = event.target.files[0];
        });
    document
        .getElementById("uploadExcel")
        .addEventListener("click", function() {

            $('#uploadExcel').prop('disabled', true);

            if (selectedFile) {
                console.log("Hi...");
                var fileReader = new FileReader();
                fileReader.onload = function(event) {
                    var data = event.target.result;

                    var workbook = XLSX.read(data, {
                        type: "binary"
                    });
                    workbook.SheetNames.forEach(sheet => {
                        let rowObject = XLSX.utils.sheet_to_row_object_array(
                            workbook.Sheets[sheet]
                        );
                        let jsonObject = JSON.stringify(rowObject);
                        // document.getElementById("jsonData").innerHTML = jsonObject;


                        console.log('test', jsonObject);

                        var newcount = $("#excel_row12").val();

                        var i = 0;
                        for (i; i < newcount; i++) {

                            var name = document.getElementById("name" + i).value;
                            var name1 = document.getElementById("name" + i);
                            // alert(screen_role_id);
                            if (name == "") {


                                name1.classList.add("mystyle");
                                swal({
                                        title: "Alert",
                                        text: "Please Enter Member Name",
                                        type: "error",
                                        confirmButtonText: "OK"
                                    },
                                    function(isConfirm) {
                                        if (isConfirm) {
                                            window.location.href = '{{ route("member_list") }}';

                                        } else {

                                        }
                                    });
                                return false;
                            } else {
                                name1.classList.remove("mystyle");
                            }




                            var type = document.getElementById("type" + i).value;
                            var type1 = document.getElementById("type" + i);
                            // alert(screen_role_id);
                            if (type != "") {

                                if (!/^[0-9]+$/.test(type)) {
                                    type1.classList.add("mystyle");
                                    swal({
                                            title: "Alert",
                                            text: "Please Enter Member Type!",
                                            type: "error",
                                            confirmButtonText: "OK"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = '{{ route("member_list") }}';

                                            } else {

                                            }
                                        });
                                    return false;
                                } else {
                                    type1.classList.remove("mystyle");
                                }

                            } else {
                                type1.classList.remove("mystyle");
                            }


                            var class12 = document.getElementById("mclass" + i).value;
                            var class1 = document.getElementById("mclass" + i);
                            // alert(screen_role_id);
                            if (class12 != "") {

                                if (!/^[0-9]+$/.test(class12)) {
                                    class1.classList.add("mystyle");
                                    swal({
                                            title: "Alert",
                                            text: "Please Enter Class!",
                                            type: "error",
                                            confirmButtonText: "OK"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = '{{ route("member_list") }}';

                                            } else {

                                            }
                                        });
                                    return false;
                                } else {
                                    class1.classList.remove("mystyle");
                                }

                            } else {
                                class1.classList.remove("mystyle");
                            }


                            var isu_reg_number = document.getElementById("isu_reg_number" + i).value;
                            var isu_reg_number1 = document.getElementById("isu_reg_number1" + i);

                            if (isu_reg_number1 != "") {

                                if (!/^[0-9]+$/.test(isu_reg_number)) {
                                    isu_reg_number1.classList.add("mystyle");
                                    swal({
                                            title: "Alert",
                                            text: "Please Enter ISU/Reg Id!",
                                            type: "error",
                                            confirmButtonText: "OK"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = '{{ route("member_list") }}';

                                            } else {

                                            }
                                        });
                                    return false;
                                } else {
                                    isu_reg_number1.classList.remove("mystyle");
                                }

                            } else {
                                isu_reg_number1.classList.remove("mystyle");
                            }


                            var qualification = document.getElementById("qualification" + i).value;
                            var qualification1 = document.getElementById("qualification" + i);

                            if (qualification1 != "") {

                                if (!/^[0-9]+$/.test(qualification)) {
                                    qualification1.classList.add("mystyle");
                                    swal({
                                            title: "Alert",
                                            text: "Please Enter Qualification!",
                                            type: "error",
                                            confirmButtonText: "OK"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = '{{ route("member_list") }}';

                                            } else {

                                            }
                                        });
                                    return false;
                                } else {
                                    qualification1.classList.remove("mystyle");
                                }

                            } else {
                                qualification.classList.remove("mystyle");
                            }



                            var address = document.getElementById("address" + i).value;
                            var address1 = document.getElementById("address" + i);

                            if (address1 != "") {

                                if (!/^[0-9]+$/.test(address)) {
                                    address1.classList.add("mystyle");
                                    swal({
                                            title: "Alert",
                                            text: "Please Enter Address!",
                                            type: "error",
                                            confirmButtonText: "OK"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = '{{ route("member_list") }}';

                                            } else {

                                            }
                                        });
                                    return false;
                                } else {
                                    address1.classList.remove("mystyle");
                                }

                            } else {
                                address1.classList.remove("mystyle");
                            }

                            var email = document.getElementById("email" + i).value;
                            var email1 = document.getElementById("email" + i);
                            // alert(screen_role_id);
                            if (email == "") {


                                email1.classList.add("mystyle");
                                swal({
                                        title: "Alert",
                                        text: "Please Enter Email",
                                        type: "error",
                                        confirmButtonText: "OK"
                                    },
                                    function(isConfirm) {
                                        if (isConfirm) {
                                            window.location.href = '{{ route("member_list") }}';

                                        } else {

                                        }
                                    });
                                return false;
                            } else {
                                email1.classList.remove("mystyle");
                            }

                            var email_id = document.getElementById("email" + i).value;
                            var emailfilter = /^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
                            var email = document.getElementById("email" + i)
                            console.log(email_id);
                            email.classList.remove("mystyle");
                            var email1 = emailfilter.test(email.value);
                            if (email1 == false) {
                                email.classList.add("mystyle");
                                swal({
                                        title: "Error",
                                        text: "Please Fill Valid Email Address!",
                                        type: "error",
                                        confirmButtonText: "OK"
                                    },
                                    function(isConfirm) {
                                        if (isConfirm) {
                                            window.location.href = '{{ route("member_list") }}';

                                        } else {

                                        }
                                    });


                                return false;
                            }


                            var phone = document.getElementById("phone" + i).value;
                            var phone1 = document.getElementById("phone" + i);

                            if (phone1 != "") {

                                if (!/^[0-9]+$/.test(address)) {
                                    phone1.classList.add("mystyle");
                                    swal({
                                            title: "Alert",
                                            text: "Please Enter Phone!",
                                            type: "error",
                                            confirmButtonText: "OK"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = '{{ route("member_list") }}';

                                            } else {

                                            }
                                        });
                                    return false;
                                } else {
                                    phone1.classList.remove("mystyle");
                                }

                            } else {
                                phone1.classList.remove("mystyle");
                            }



                            var location = document.getElementById("location" + i).value;
                            var location1 = document.getElementById("location" + i);

                            if (location1 != "") {

                                if (!/^[0-9]+$/.test(address)) {
                                    location1.classList.add("mystyle");
                                    swal({
                                            title: "Alert",
                                            text: "Please Enter Location!",
                                            type: "error",
                                            confirmButtonText: "OK"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = '{{ route("member_list") }}';

                                            } else {

                                            }
                                        });
                                    return false;
                                } else {
                                    location1.classList.remove("mystyle");
                                }

                            } else {
                                location1.classList.remove("mystyle");
                            }


                            var gender = document.getElementById("gender" + i).value;
                            var gender1 = document.getElementById("gender" + i);

                            if (location1 != "") {

                                if (!/^[0-9]+$/.test(address)) {
                                    gender1.classList.add("mystyle");
                                    swal({
                                            title: "Alert",
                                            text: "Please Enter Gender!",
                                            type: "error",
                                            confirmButtonText: "OK"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = '{{ route("member_list") }}';

                                            } else {

                                            }
                                        });
                                    return false;
                                } else {
                                    gender1.classList.remove("mystyle");
                                }

                            } else {
                                gender1.classList.remove("mystyle");
                            }



                        }





                    });
                };
                fileReader.readAsBinaryString(selectedFile);
            }
        });
</script>


@endsection;