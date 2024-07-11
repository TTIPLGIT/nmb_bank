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

            <div class="col-lg-12 text-center">

                <h4>Special Request for GT</h4>
            </div>

            <div class="" style="height:100%; padding: 15px">
                {{ Breadcrumbs::render('RequestGt.index') }}


                <form method="POST" id="gt_requestform" enctype="multipart/form-data" onsubmit="return false">
                    @csrf
                    <!-- Tab panes -->
                    <div id="content">


                        <section class="section">

                            <div class="section-body mt-0">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="card mt-0">
                                            <div class="card-body">
                                                <div class="table-wrapper">
                                                    <div class="table-responsive">
                                                        <table class="table table-stripped" id="align7">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sl.No</th>
                                                                    <th>GT Name</th>
                                                                    <th>Requested Date</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($rows as $row)
                                                                    <tr>

                                                                        <td>{{$loop->iteration}}</td>
                                                                        <td class="align-middle">{{$row['name']}}</td>
                                                                        <td class="align-middle">{{$row['created_at']}}</td>
                                                                        <th class="align-middle"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></th>
                                                                        @php $encrypted_id = Crypt::encrypt($row['user_id']); @endphp
                                                                        <td><a type="button" href="/request/approve?en_id={{$encrypted_id}}" title="Approve or Reject" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>
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






                    </div>


                </form>
            </div>

        </div>

    </div>
</div>


@endsection