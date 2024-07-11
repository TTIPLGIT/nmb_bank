@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }
    div#align1_length {
        position: relative;
        top: 35px;
    }
    div#align1_filter {
    float: right;
}
div#align3_length {
        position: relative;
        top: 35px;
    }
    div#align3_filter {
    float: right;
}
div#align4_length {
        position: relative;
        top: 35px;
    }
    div#align4_filter {
    float: right;
}
div#align_length {
    position: relative;
    top: 30px;
}
div#align_filter {
    float: right;
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

    a.btn.btn-success.btn-lg.question {
        /* float: right; */
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
</style>



<div class="main-content main_contentspace">
    <div class="row justify-content-center">

        <div class="col-lg-12 col-md-12">
            <div class="" style="">{{ Breadcrumbs::render('adminquiz') }}

                <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                    @csrf

                    <div class="tile registration_tab" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">


                    </div>
                    <!-- Tab panes -->



            </div>


            <div id="content">


                <section class="section">


                    <div class="section-body mt-0">

                        <!-- <div class="col-12"> -->
                        <div class="row">
                        <div class="col-sm-3 ">
                                <select class="form-control default" id="result1" name="result1">
                                    <option value="">Quiz Type</option>
                                    <option value="LongQuestionlist">Long Question</option>
                                    <option value="MCQlist">Multiple Choice Question(MCQ)</option>
                                    <option value="ShortAnswerlist">Short Answer</option>
                                    <option value="True/Falselist">True/False</option>
                                </select>
                            </div>
                            <div class="col-sm-2 addquizmodal">
                                <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="" data-toggle="modal" data-target="#addModal1">Add Quiz <span><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                            </div>
                            <div class="col-sm-4 "></div>
                           
                            <div class="col-sm-3">
                                <a type="button" style="font-size:15px;" class="btn btn-success btn-lg question" title="Create" href="" data-toggle="modal" data-target="#addModal">Add Question <span><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                            </div>
                        </div>

                    </div>
                </section>

            </div>




            <section class="section5">
                <div class="section-body mt-1">
                    <div class="row">
                        <div class="col-12">
                            <h3 style="margin-top:10px;text-align:center;">Quiz</h3>
                            <div class="card mt-0">
                                <div class="card-body">

                                    <!-- @if ($message = Session::get('success'))
                                        <div class="alert alert-success alert-block">
                                            <button type="button" class="close" data-dismiss="alert">�</button>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif

                                        @if ($message = Session::get('error'))
                                        <div class="alert alert-success alert-block">
                                            <button type="button" class="close" data-dismiss="alert">�</button>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif -->
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align0">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>quiz Name</th>
                                                        <th>quiz Question</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #cfe0e8;">


                                                    <tr>
                                                    <td>1</td>
                                                                    <td>Importance of survyor</td>
                                                                    <td>What are survyor?</td>
                                                                   
                                                                    
                                                        <input type="hidden" class="ceduid" id="eduid" value="">


                                                        <td>



                                                            </form>
                                                            <form id="destroygen" method="POST">

                                                                <a class="" title="Edit" id="gcb" href="" data-toggle="modal" data-target="#addModalquiz"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show"><i class="fas fa-eye" style="color:green"></i></a>
                                                                @method('put')
                                                                @csrf

                                                                <button type="submit" title="Delete" onclick="delete1()" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>
                                                            </form>

                                                        </td>

                                                    </tr>

                                                    <input type="hidden" class="ceduid" id="eduid" value="0">

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




            <section class="section" id="longquestionlist" style="display:none">


                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 style="margin-top:10px;text-align:center;">Long Question</h2>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table  table-bordered table-striped" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>question Name</th>
                                                        <th>question</th>
                                                        <th>keyword</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>1</td>
                                                                    <td>Importance of survyor</td>
                                                                    <td>What are survyor?</td>
                                                                    <td> Survyor</td>
                                                                    <td>     


                                                            <form id="destroygen" method="POST">

                                                                <a class="" title="Edit" id="gcb" href="" data-toggle="modal" data-target="#addModal3"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show"><i class="fas fa-eye" style="color:green"></i></a>
                                                                @method('put')
                                                                @csrf

                                                                <button type="submit" title="Delete" onclick="delete1()" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>
                                                            </form>
                                                        </td>

                                                    </tr>


                                                    <input type="hidden" class="cfn" id="fn" value="0">

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





            <section class="section" id="mcqlist" style="display:none">


                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-12">

                            <h3 style="margin-top:10px;text-align:center;">MCQ</h3>
                            <div class="card mt-0">

                                <div class="card-body">
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>choice</th>
                                                        <th>correct choice</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                    <td>1</td>
                                                                    <td>survyor</td>
                                                                    <td>survyor</td>
                                                                    
                                                                    <td>

                                                        


                                                            <form id="destroygen" method="POST">

                                                                <a class="" title="Edit" id="gcb" href="" data-toggle="modal" data-target="#addModaledit"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show"><i class="fas fa-eye" style="color:green"></i></a>
                                                                @method('put')
                                                                @csrf

                                                                <button type="submit" title="Delete" onclick="delete1()" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>
                                                            </form>
                                                        </td>

                                                    </tr>


                                                    <input type="hidden" class="cfn" id="fn" value="0">

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




            <section class="section" id="shortanswerlist" style="display:none">


                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-12">
                            <h3 style="margin-top:10px;text-align:center;">Short Question</h3>

                            <div class="card mt-0">
                                <div class="card-body">
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align3">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>question Name</th>
                                                        <th>question</th>
                                                        <th>keyword</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                    <td>1</td>
                                                                    <td>Importance of survyor</td>
                                                                    <td>What are survyor?</td>
                                                                    <td> Survyor</td>
                                                                    

                                                        <td>


                                                            <form id="destroygen" method="POST">

                                                                <a class="" title="Edit" id="gcb" href="" data-toggle="modal" data-target="#addModaledit11"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show"><i class="fas fa-eye" style="color:green"></i></a>
                                                                @method('put')
                                                                @csrf

                                                                <button type="submit" title="Delete" onclick="delete1()" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>
                                                            </form>
                                                        </td>

                                                    </tr>


                                                    <input type="hidden" class="cfn" id="fn" value="0">

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

            <section class="section" id="truelist" style="display:none">
                <div class="section-body mt-1">
                    <div class="row">
                        <div class="col-12">
                            <h3 style="margin-top:10px;text-align:center;">True/False</h3>
                            <div class="card mt-0">


                                <div class="card-body">

                                    <!-- @if ($message = Session::get('success'))
                                                                    <div class="alert alert-success alert-block">
                                                                        <button type="button" class="close" data-dismiss="alert">�</button>
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                    @endif

                                                                    @if ($message = Session::get('error'))
                                                                    <div class="alert alert-success alert-block">
                                                                        <button type="button" class="close" data-dismiss="alert">�</button>
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                    @endif -->
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align4">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>question Name </th>
                                                        <th>Answer</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <tr>
                                                                    <td>1</td>
                                                                    <td>What are survyor?</td>
                                                                    <td>false</td>
                                                                    
                                                                
                                                        <input type="hidden" class="ceduid" id="eduid" value="">
                                                        <td>
                                                            </form>
                                                            <form id="destroygen" method="POST">

                                                                <a class="" title="Edit" id="gcb" href="" data-toggle="modal" data-target="#addModaltrue"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show"><i class="fas fa-eye" style="color:green"></i></a>
                                                                @method('put')
                                                                @csrf

                                                                <button type="submit" title="Delete" onclick="delete1()" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>
                                                            </form>

                                                        </td>

                                                    </tr>

                                                    <input type="hidden" class="ceduid" id="eduid" value="0">

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

<!-- addquestion function -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="create_form" onsubmit="return validateForm()" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Add Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #f8fffb !important;">
                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <!-- <label>District:<span class="error-star" style="color:red;">*</span></label> -->
                                <select class="form-control default" id="result" name="result">
                                    <option value="">Question Type</option>
                                    <option value="Long Question">Long Question</option>
                                    <option value="MCQ">Multiple Choice Question(MCQ)</option>
                                    <option value="ShortAnswer">Short Answer</option>
                                    <option value="True/False">True/False</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>



                </div>

            </form>

            <!-- Long question -->

            <div class="card longquestion" id="longquestion" style="display:none">
                <h4 class="modal-title long">Long Question:</h4>
                <form method="post" action="" enctype="multipart/form-data">

                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="qname" name="qname">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label><br>
                                <textarea id="quistion" name="quistion" rows="4" cols="81"></textarea>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->

                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Keywords:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default" id="keyword" name="keyword">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>

                                    <div class="action_container" width="50px">
                                        <button class="success" type="button" onclick="create_tr('table_body')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-md-1"></div>

                    </div>

                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="points" name="points">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre()" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end -->
            <!-- Mcq -->

            <div class="card longquestion" id="mcq" style="display:none">
                <h4 class="modal-title mcq">Multiple Choice Question(MCQ):</h4>
                <form method="POST">

                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="qname" name="qname">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label><br>
                                <textarea id="quistion" name="quistion" rows="4" cols="81"></textarea>

                           </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Choices:<span class="error-star" style="color:red;">*</span></label>



                                <table class="_table">

                                    <tbody id="table_body1">
                                        <tr>

                                            <td>
                                                <input type="text" class="form-control default" id="keywords" name="keywords">
                                            </td>
                                            <div class="action_container1" width="50px">
                                                <button class="success" type="button" onclick="create_tr('table_body1')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                            <td>
                                                <div class="action_container">
                                                    <button class="danger" onclick="remove_tr(this)">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </div>

                                            </td>


                                        </tr>

                                    </tbody>


                                </table>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Correct Choices:<span class="error-star" style="color:red;">*</span></label>


                                <table class="_table">

                                    <tbody id="table_body2">
                                        <tr>

                                            <td>
                                                <input type="text" class="form-control default" id="keywords" name="keywords">
                                            </td>
                                            <div class="action_container2" width="50px">
                                                <button class="success" type="button" onclick="create_tr('table_body2')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                            <td>
                                                <div class="action_container">
                                                    <button class="danger" onclick="remove_tr(this)">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </div>

                                            </td>


                                        </tr>

                                    </tbody>


                                </table>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="points" name="points">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre()" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
            <!-- end -->
            <!-- Short answer -->

            <div class="card longquestion" id="shortanswer" style="display:none">
                <h4 class="modal-title short">Short Answer:</h4>
                <form method="POST">

                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="qnames1" name="qnames1">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label><br>
                                <textarea id="quistions2" name="quistions2" rows="4" cols="81"></textarea>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Keywords:<span class="error-star" style="color:red;">*</span></label>

                                <table class="_table">

                                    <tbody id="table_body3">
                                        <tr>

                                            <td>
                                                <input type="text" class="form-control default" id="keyword1" name="keyword1">
                                            </td>
                                            <div class="action_container3" width="50px">
                                                <button class="success" type="button" onclick="create_tr('table_body3')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                            <td>
                                                <div class="action_container">
                                                    <button class="danger" onclick="remove_tr(this)">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </div>

                                            </td>


                                        </tr>

                                    </tbody>


                                </table>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="points" name="points">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre()" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end -->
            <!-- true/false -->

            <div class="card longquestion" id="true" style="display:none">
                <h4 class="modal-title true">True/false:</h4>
                <form method="POST">

                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="qname22" name="qname22">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label><br>
                                <textarea id="quistion11" name="quistion11" rows="4" cols="81"></textarea>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Answer:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="answer" name="answer">

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="points1" name="points1">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre()" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end -->
        </div>
    </div>
</div>


<style>
    tr:first-child .danger {
        display: none;
    }

    .container {
        max-width: 900px;
        width: 100%;
        background-color: #fff;
        margin: auto;
        padding: 15px;
        box-shadow: 0 2px 20px #0001, 0 1px 6px #0001;
        border-radius: 5px;
        overflow-x: auto;
    }

    .action_container1 {
        float: right;
        position: relative;
        left: 60px;
        top: 40px;
        z-index: 999;
    }

    .action_container2 {
        float: right;
        position: relative;
        left: 60px;
        top: 40px;
        z-index: 999;
    }

    .action_container3 {
        float: right;
        position: relative;
        left: 60px;
        top: 40px;
        z-index: 999;
    }

    ._table {
        width: 100%;
        border-collapse: collapse;
    }

    ._table :is(th, td) {}

    /* form field design start */
    .form_control {
        border: 1px solid #0002;
        background-color: transparent;
        outline: none;
        padding: 8px 12px;
        font-family: 1.2rem;
        width: 100%;
        color: #333;
        font-family: Arial, Helvetica, sans-serif;
        transition: 0.3s ease-in-out;
    }

    .form_control::placeholder {
        color: inherit;
        opacity: 0.5;
    }

    .form_control:is(:focus, :hover) {
        box-shadow: inset 0 1px 6px #0002;
    }

    /* form field design end */


    .success {
        background-color: #24b96f !important;
    }

    .warning {
        background-color: #ebba33 !important;
    }

    .primary {
        background-color: #259dff !important;
    }

    .secondery {
        background-color: #00bcd4 !important;
    }

    .danger {
        background-color: #ff5722 !important;
    }

    .action_container {}

    .action_container>* {
        border: none;
        outline: none;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        padding: 8px 14px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    .action_container1>* {
        border: none;
        outline: none;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        padding: 8px 14px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    .action_container2>* {
        border: none;
        outline: none;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        padding: 8px 14px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    .action_container3>* {
        border: none;
        outline: none;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        padding: 8px 14px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }
</style>

<script>
    function create_tr(table_id) {
        let table_body = document.getElementById(table_id),
            first_tr = table_body.firstElementChild
        tr_clone = first_tr.cloneNode(true);

        table_body.append(tr_clone);

        clean_first_tr(table_body.firstElementChild);
    }

    function clean_first_tr(firstTr) {
        let children = firstTr.children;

        children = Array.isArray(children) ? children : Object.values(children);
        children.forEach(x => {
            if (x !== firstTr.lastElementChild) {
                x.firstElementChild.value = '';
            }
        });
    }



    function remove_tr(This) {
        if (This.closest('tbody').childElementCount == 1) {
            alert("You Don't have Permission to Delete This ?");
        } else {
            This.closest('tr').remove();
        }
    }
</script>

<script>
    function create_tr(table_id) {
        let table_body1 = document.getElementById(table_id),
            first_tr = table_body1.firstElementChild
        tr_clone = first_tr.cloneNode(true);

        table_body1.append(tr_clone);

        clean_first_tr(table_body1.firstElementChild);
    }

    function clean_first_tr(firstTr) {
        let children = firstTr.children;

        children = Array.isArray(children) ? children : Object.values(children);
        children.forEach(x => {
            if (x !== firstTr.lastElementChild) {
                x.firstElementChild.value = '';
            }
        });
    }



    function remove_tr(This) {
        if (This.closest('tbody').childElementCount == 1) {
            alert("You Don't have Permission to Delete This ?");
        } else {
            This.closest('tr').remove();
        }
    }
</script>


<script>
    function create_tr(table_id) {
        let table_body3 = document.getElementById(table_id),
            first_tr = table_body3.firstElementChild
        tr_clone = first_tr.cloneNode(true);

        table_body3.append(tr_clone);

        clean_first_tr(table_body3.firstElementChild);
    }

    function clean_first_tr(firstTr) {
        let children = firstTr.children;

        children = Array.isArray(children) ? children : Object.values(children);
        children.forEach(x => {
            if (x !== firstTr.lastElementChild) {
                x.firstElementChild.value = '';
            }
        });
    }



    function remove_tr(This) {
        if (This.closest('tbody').childElementCount == 1) {
            alert("You Don't have Permission to Delete This ?");
        } else {
            This.closest('tr').remove();
        }
    }
</script>


<script>
    function create_tr(table_id) {
        let table_body2 = document.getElementById(table_id),
            first_tr = table_body2.firstElementChild
        tr_clone = first_tr.cloneNode(true);

        table_body2.append(tr_clone);

        clean_first_tr(table_body2.firstElementChild);
    }

    function clean_first_tr(firstTr) {
        let children = firstTr.children;

        children = Array.isArray(children) ? children : Object.values(children);
        children.forEach(x => {
            if (x !== firstTr.lastElementChild) {
                x.firstElementChild.value = '';
            }
        });
    }



    function remove_tr(This) {
        if (This.closest('tbody').childElementCount == 1) {
            alert("You Don't have Permission to Delete This ?");
        } else {
            This.closest('tr').remove();
        }
    }
</script>

<script>
    $('#result').on('change', function() {
        $('#longquestion').css('display', 'none');
        $('#mcq').css('display', 'none');
        $('#shortanswer').css('display', 'none');
        $('#true').css('display', 'none');

        if ($(this).val() === 'Long Question') {
            $('#longquestion').css('display', 'block');
        }
        if ($(this).val() === 'MCQ') {
            $('#mcq').css('display', 'block');
        }
        if ($(this).val() === 'ShortAnswer') {
            $('#shortanswer').css('display', 'block');
        }
        if ($(this).val() === 'True/False') {
            $('#true').css('display', 'block');
        }
    });
</script>

<script>
    $('#result1').on('change', function() {
        $('#longquestionlist').css('display', 'none');
        $('#mcqlist').css('display', 'none');
        $('#shortanswerlist').css('display', 'none');
        $('#truelist').css('display', 'none');

        if ($(this).val() === 'LongQuestionlist') {
            $('#longquestionlist').css('display', 'block');
        }
        if ($(this).val() === 'MCQlist') {
            $('#mcqlist').css('display', 'block');
        }
        if ($(this).val() === 'ShortAnswerlist') {
            $('#shortanswerlist').css('display', 'block');
        }
        if ($(this).val() === 'True/Falselist') {
            $('#truelist').css('display', 'block');
        }
    });
</script>

<!-- Deepika -->
<script>
    function gencre() {
        var f_name = $("#fname").val();
        if (f_name == '') {
            swal("Please Enter the Firstname", "", "error");
            return false;
        }
        var l_name = $("#lname").val();
        if (l_name == '') {
            swal("Please Enter the Lastname", "", "error");
            return false;
        }

        var male = document.getElementById('Male');
        var female = document.getElementById('Female');

        if (male.checked == false && female.checked == false) {
            swal("Please Enter the Gender", "", "error");
            return false;
        }

        var add = $("#Address_line1").val();
        if (add == '') {
            swal("Please Enter the Address", "", "error");
            return false;
        }

        var dist = $("#district").val();
        if (dist == '') {
            swal("Please Select the District", "", "error");
            return false;
        }

        var cons = $("#constituency").val();
        if (cons == '') {
            swal("Please Select the Constituency", "", "error")
            return false;
        }

        var vill = $("#village").val();
        if (vill == '') {
            swal("Please Select the Village", "", "error")
            return false;
        }

        var agri = document.getElementById('al');
        var real = document.getElementById('rel');
        var plan = document.getElementById('pl')

        if (al.checked == false && rel.checked == false && pl.checked == false) {
            swal("Please Enter the Land Classification", "", "error");
            return false;
        }


        var valu = document.getElementById('val');
        var surv = document.getElementById('sur');
        var asso = document.getElementById('asr')

        if (val.checked == false && sur.checked == false && asr.checked == false) {
            swal("Please Enter the Role Classification", "", "error");
            return false;
        }

        var nin = $("#nin").val();
        if (nin == '') {
            swal("Please Enter the NIN", "", "error")
            return false;
        }

        var nin = $("#ninf").val();
        if (nin == '') {
            swal("Please Upload the NIN FILE", "", "error")
            return false;
        }

        var pass = $("#passport").val();
        if (pass == '') {
            swal("Please Enter the Passport Number", "", "error")
            return false;
        }

        var port = $("#ppf").val();
        if (port == '') {
            swal("Please Upload the PassPort FILE", "", "error")
            return false;
        } else {
            document.getElementById('create_form').submit();
        }

    }
</script>
<!-- end create -->
<!-- addquiz function -->
<div class="modal fade" id="addModal1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="create_form" onsubmit="return validateForm()" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Add Quiz</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #f8fffb !important;">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="fname" name="fname">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Question:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="lname" name="lname">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre()" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>





<!-- Deepika -->
<script>
    function gencre() {
        var f_name = $("#fname").val();
        if (f_name == '') {
            swal("Please Enter the Firstname", "", "error");
            return false;
        }
        var l_name = $("#lname").val();
        if (l_name == '') {
            swal("Please Enter the Lastname", "", "error");
            return false;
        }

        var male = document.getElementById('Male');
        var female = document.getElementById('Female');

        if (male.checked == false && female.checked == false) {
            swal("Please Enter the Gender", "", "error");
            return false;
        }

        var add = $("#Address_line1").val();
        if (add == '') {
            swal("Please Enter the Address", "", "error");
            return false;
        }

        var dist = $("#district").val();
        if (dist == '') {
            swal("Please Select the District", "", "error");
            return false;
        }

        var cons = $("#constituency").val();
        if (cons == '') {
            swal("Please Select the Constituency", "", "error")
            return false;
        }

        var vill = $("#village").val();
        if (vill == '') {
            swal("Please Select the Village", "", "error")
            return false;
        }

        var agri = document.getElementById('al');
        var real = document.getElementById('rel');
        var plan = document.getElementById('pl')

        if (al.checked == false && rel.checked == false && pl.checked == false) {
            swal("Please Enter the Land Classification", "", "error");
            return false;
        }


        var valu = document.getElementById('val');
        var surv = document.getElementById('sur');
        var asso = document.getElementById('asr')

        if (val.checked == false && sur.checked == false && asr.checked == false) {
            swal("Please Enter the Role Classification", "", "error");
            return false;
        }

        var nin = $("#nin").val();
        if (nin == '') {
            swal("Please Enter the NIN", "", "error")
            return false;
        }

        var nin = $("#ninf").val();
        if (nin == '') {
            swal("Please Upload the NIN FILE", "", "error")
            return false;
        }

        var pass = $("#passport").val();
        if (pass == '') {
            swal("Please Enter the Passport Number", "", "error")
            return false;
        }

        var port = $("#ppf").val();
        if (port == '') {
            swal("Please Upload the PassPort FILE", "", "error")
            return false;
        } else {
            document.getElementById('create_form').submit();
        }

    }
</script>






<!-- end create -->
<!-- edit function -->
<div class="modal fade" id="addModal3">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="create_form" onsubmit="return validateForm()" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Long Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <!-- <div class="modal-body" style="background-color: #f8fffb !important;">


                

                </div> -->

            </form>

            <!-- Long question -->

            <div class=" container edit  longquestion">
                <h4 class="modal-title long">Long Question:</h4>
                <form method="POST" class="longqustionsform">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" value="What are survyor?" id=qname6" name="qname6">
                            </div>
                        </div>

                      
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <textarea id="quistion" name="quistion" value="How to Set Width Ranges for Your CSS Media Queries?" rows="4" cols="41"></textarea>

                            </div>
                        </div>
                    </div>

                    <div class="check_tab">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Keywords:<span class="error-star" style="color:red;">*</span></label>
                                    <div class="wordquestion">
                                        <input type="text" class="form-control default" value=" Set Width Ranges " id="keyword" value="1" name="keyword">

                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                    <input type="text" class="form-control default" value="3" id="points" name="points">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-success btn-space" type="button" onclick="gencre()" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end long-->
        </div>
    </div>
</div>
<!-- edit -->
<!-- Edit mcq -->

<div class="modal fade" id="addModaledit">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="create_form" onsubmit="return validateForm()" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit MCQ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

            </form>

            <!-- Mcq -->
            <div class="card longquestion">
                <h4 class="modal-title mcq">Multiple Choice Question:</h4>
                <form method="POST">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" Value="question1" id="quistions3" name="qustions3">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <textarea id="quistion" name="quistion" value=" How to Set Width Ranges for Your CSS Media Queries?" rows="4" cols="41"></textarea>

                            </div>
                        </div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Choices:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="keywords" value="lravel" name="keywords">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Correct Choices:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" value="php" id="keywords" name="keywords">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" value="5" id="points" name="points">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre()" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
            <!-- end -->

        </div>
    </div>
</div>
<!-- end  -->
<!-- editshort Answer -->
<div class="modal fade" id="addModaledit11">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="create_form" onsubmit="return validateForm()" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit short Answer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

            </form>

            <!-- short answer -->
            <div class="card longquestion">
                <h4 class="modal-title short">Short Answer:</h4>
                <form method="POST">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" value="question2" id="qnames1" name="qnames1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <textarea id="quistions2" name="quistions2" value=" How to Set Width Ranges for Your CSS Media Queries?" rows="4" cols="41"></textarea>

                            </div>
                        </div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Keywords:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" value="laravel" id="keyword1" name="keyword1">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" value="2" id="points" name="points">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre()" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
            <!-- end -->

        </div>
    </div>
</div>
<!-- edit end -->

<!-- Edit True/False -->
<div class="modal fade" id="addModaltrue">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="create_form" onsubmit="return validateForm()" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit True/False</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

            </form>

            <!-- short answer -->
            <div class=" card longquestion">
                <h4 class="modal-title true">True/false:</h4>
                <form method="POST">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" value="true/false question1" id="qname22" name="qname22">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <textarea id="quistion11" name="quistion11" rows="4" cols="41"></textarea>

                            </div>
                        </div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Answer:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" value="true" id="answer" name="answer">

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" value="4" id="points1" name="points1">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre()" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
            <!-- end -->

        </div>
    </div>
</div>
<!-- end -->


<!-- edit quiz -->
<div class="modal fade" id="addModalquiz">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="create_form" onsubmit="return validateForm()" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Quiz</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #f8fffb !important;">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" value="Knowledge quiz" class="form-control default" id="fname" name="fname">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Question:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" value="what is the use of sql?" id="lname" name="lname">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre()" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>
<!-- end -->





@endsection