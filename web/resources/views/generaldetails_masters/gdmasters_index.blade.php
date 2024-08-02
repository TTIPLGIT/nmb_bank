@extends('layouts.adminnav')
@section('content')
<style>
    a:hover,
    a:focus {
        text-decoration: none;
        outline: none;
    }

    .danger {
        background-color: #ffdddd;
        border-left: 6px solid #f44336;
    }

    #align {
        border-collapse: collapse !important;
    }

    table.dataTable.no-footer {
        border-bottom: .5px solid #002266 !important;
    }

    thead th {
        height: 5px;
        border-bottom: solid 1px #ddd;
        font-weight: bold;
    }
</style>
<!-- <script>
$(document).ready(function() {
    $('#align2').DataTable();
});
</script> -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<div class="main-content main_contentspace">
    <div class="row justify-content-center">
        @if (session('success'))

        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                swal.fire({
                    title: "Success",
                    text: message,
                    icon: "success",
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
                    icon: "info",
                });

            }
        </script>
        @endif

        <div class="col-lg-12 col-md-12">

            <div class="row" style="display: flex;justify-content: space-between;">
                <div class="col-sm-3">
                    <a type="button" style="font-size:15px;margin: 0px 0px 0px 0px;" class="btn btn-success btn-lg question" title="Create" onclick="address_view();">Add<span><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                </div>
                <div class="col-sm-3 ">
                    <select class="form-control default" id="address_list1" name="address_list1">

                        <option value="District">District</option>
                        <option value="Constituency">Constituency</option>
                        <option value="Village">village</option>
                    </select>
                </div>
            </div>

            <section class="section" id="master" style="display:none">


                <div class="section-body mt-0">
                    @if (session('success'))

                    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                    <script type="text/javascript">
                        window.onload = function() {
                            var message = $('#session_data').val();
                            swal.fire({
                                title: "Success",
                                text: message,
                                icon: "success",
                                type: "success",
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
                                icon: "info",
                                type: "info",
                            });

                        }
                    </script>
                    @endif


                </div>
            </section>

            <section class="section" id="districtlist">
                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">
                                    <h2 style="text-align:center;">Masters of District</h2>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table  table-bordered table-striped" id="align2">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Name of district</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @foreach($rows['row'] as $data)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data['district_name']}}</td>
                                                        <td>
                                                            <a class="" title="Edit" id="gcb" href="" data-toggle="modal" data-target="#editdistrictModal" onclick="gdconstituency_fetch({{$data['id']}},'district_edit')"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                            <a class="" title="show" data-toggle="modal" data-target="#showdistrictModal" onclick="gdconstituency_fetch({{$data['id']}},'district_show')"><i class="fas fa-eye" style="color:green"></i></a>
                                                            <button type="submit" title="Delete" onclick="gdconstituency_delete({{$data['id']}},'district_delete')" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>

                                                            @csrf


                                                        </td>

                                                    </tr>


                                                    <input type="hidden" class="cfn" id="fn" value="0">
                                                </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </section>




            <section class="section" id="Constituencylist">
                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">
                                    <h2 style="text-align:center;">Masters of Constituency</h2>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table  table-bordered table-striped" id="align">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Name of District</th>
                                                        <th>Name of Constituency</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rows['rows'] as $data)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data['district_name']}}</td>
                                                        <td>{{$data['constituency_name']}}</td>


                                                        <td>
                                                            <a class="" title="Edit" id="gcb" href="" data-toggle="modal" data-target="#editconsituencyModal" onclick="gdconstituencydist_fetch({{$data['id']}},'constituency_edit')"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                            <a class="" title="show" data-toggle="modal" data-target="#showconsituencyModal" onclick="gdconstituencydist_fetch({{$data['id']}},'constituency_show')"><i class="fas fa-eye" style="color:green"></i></a>
                                                            <button type="submit" title="Delete" onclick="gdconstituency_delete({{$data['id']}},'constituency_delete')" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>

                                                            @csrf


                                                        </td>

                                                    </tr>

                                                </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>




            <section class="section" id="villagelist">
                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">
                                    <h2 style="text-align:center;">Masters of Village</h2>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table  table-bordered table-striped" id="new_align">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Name of Constituency</th>
                                                        <th>Name of Village</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @foreach($rows['gd_village'] as $data)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data['constituency_name']}}</td>
                                                        <td>{{$data['village_name']}}</td>

                                                        <td>
                                                            <a class="" title="Edit" id="gcb" href="" data-toggle="modal" data-target="#addModaltrueedit" onclick="gdconstituency_fetch({{$data['id']}},'edit')"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                            <a class="" title="show" data-toggle="modal" data-target="#addModaltrueshow" onclick="gdconstituency_fetch({{$data['id']}},'show')"><i class="fas fa-eye" style="color:green"></i></a>
                                                            <button type="submit" title="Delete" onclick="gdconstituency_delete({{$data['id']}},'village_delete')" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>

                                                            @csrf
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                @endforeach
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

    </div>

</div>


<div class="modal fade" id="adddistrictModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">

            <div class="modal-header mh">
                <h4 class="modal-title">Add District</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="{{route('gdmastersdistrict_store')}}" method="post" id="gd_district" class="reset">
                {{ csrf_field() }}
                <input name="stakeholder_id" type="hidden" value="">
                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">District Name<span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="district_name" name="district_name" placeholder="Enter District Name" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <a class="btn btn-success btn-space" type="button" onclick="district_name()" id="savedetails">Submit</a>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addconsituencyModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">
            <div class="modal-header mh">
                <h4 class="modal-title">Add Constituency</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>


            <form action="{{route('gdmastersconstituency_store')}}" method="post" id="gd_constituency" class="reset">
                {{ csrf_field() }}

                <input name="stakeholder_id" type="hidden" value="">
                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="District Name">District Name<span class="error-star" style="color:red;">*</span></label>
                                <select name="district_id" id="district_id" class="form-control">
                                    <option value="">District_name</option>
                                    @foreach($rows['gd_district'] as $key=>$row)

                                    <option value="{{ $row['id'] }}">{{$row['district_name']}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Constituency Name <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="constituency_name" name="constituency_name" placeholder="Enter Constituency Name" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <a class="btn btn-success btn-space" type="button" id="savedetails" onclick="gd_valid();">Submit</a>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addvillageModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">
            <div class="modal-header mh">
                <h4 class="modal-title">Add Village</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>


            <form action="{{route('gdmastersvillage_store')}}" method="post" id="gd_village" class="reset">
                {{ csrf_field() }}

                <input name="stakeholder_id" type="hidden" value="">
                <div class="section-body mt-1">
                    <div class="row">



                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Constituency Name">Constituency Name<span class="error-star" style="color:red;">*</span></label>
                                <select name="constituency" id="constituency" class="form-control">
                                    <option value="">Constituency Name</option>
                                    @foreach($rows['rows2'] as $key=>$row)

                                    <option value="{{ $row['id'] }}">{{$row['constituency_name']}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Village Name <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="village_name" name="village_name" placeholder="Enter Village Name" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <a class="btn btn-success btn-space" type="button" onclick="village_name()" id="savedetails">Submit</a>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- #Edit Modal -->
<div class="modal fade" id="editdistrictModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">

            <div class="modal-header mh">
                <h4 class="modal-title">Add District</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="{{route('district_update')}}" method="post" id="edit_dist" class="reset">
                {{ csrf_field() }}
                <input name="eid" type="hidden" id="eid" value="">
                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">District Name<span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="district_name_edit" name="district_name_edit" placeholder="Enter District Name" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <a class="btn btn-success btn-space" type="button" onclick="district_update()" id="savedetails">Update</a>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- #Show Modal -->


<div class="modal fade" id="showdistrictModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">

            <div class="modal-header mh">
                <h4 class="modal-title">Add District</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="" method="post" id="gd_district_show" class="reset">
                {{ csrf_field() }}
                <input name="eidshow" type="hidden" id="eidshow" value="">
                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">District Name<span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="district_name_show" name="district_name_show" placeholder="Enter District Name" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Constituency Edit -->

<div class="modal fade" id="editconsituencyModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">
            <div class="modal-header mh">
                <h4 class="modal-title">Add Constituency</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>


            <form action="{{route('gdmastersconstituency_store')}}" method="post" id="gd_constituency" class="reset">
                {{ csrf_field() }}

                <input name="stakeholder_id" type="hidden" value="">
                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="District Name">District Name<span class="error-star" style="color:red;">*</span></label>
                                <select name="district_id" id="district_edit_id" class="form-control">
                                    <option value="">District_name</option>
                                    @foreach($rows['gd_district'] as $key=>$row)

                                    <option value="{{ $row['id'] }}">{{$row['district_name']}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Constituency Name <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="constituency_id_edit" name="constituency_name" placeholder="Enter Constituency Name" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <a class="btn btn-success btn-space" type="button" id="savedetails" onclick="gd_valid();">Update</a>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Constituency Show -->

<div class="modal fade" id="showconsituencyModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">
            <div class="modal-header mh">
                <h4 class="modal-title">Add Constituency</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>


            <form action="{{route('gdmastersconstituency_store')}}" method="post" id="gd_constituency" class="reset">
                {{ csrf_field() }}

                <input name="stakeholder_id" type="hidden" value="">
                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="District Name">District Name<span class="error-star" style="color:red;">*</span></label>
                                <select name="district_id" id="district_id" class="form-control">
                                    <option value="">District_name</option>
                                    @foreach($rows['gd_district'] as $key=>$row)

                                    <option value="{{ $row['id'] }}">{{$row['district_name']}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Constituency Name <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="constituency_name" name="constituency_name" placeholder="Enter Constituency Name" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <a class="btn btn-success btn-space" type="button" id="savedetails" onclick="gd_valid();">Submit</a>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
    $('#address_list1').on('change', function() {


        if ($(this).val() === 'District') {
            $('#districtlist').css('display', 'block');
            $('#Constituencylist').css('display', 'none');
            $('#villagelist').css('display', 'none');

        }
        if ($(this).val() === 'Constituency') {
            $('#Constituencylist').css('display', 'block');
            $('#districtlist').css('display', 'none');
            $('#villagelist').css('display', 'none');

        }
        if ($(this).val() === 'Village') {

            $('#Constituencylist').css('display', 'none');
            $('#districtlist').css('display', 'none');
            $('#villagelist').css('display', 'block');
        }
    });
</script>

<script>
    $(document).ready(function() {

        $('#districtlist').css('display', 'block');
        $('#Constituencylist').css('display', 'none');
        $('#villagelist').css('display', 'none');

    })
</script>


<script>
    function address_view() {
        var result = document.querySelector('#address_list1').value;
        if (result == "District") {
            $("#adddistrictModal").modal("show");
            // $("#adddistrictModal").css('display', 'block');
            $("#addconsituencyModal").modal("hide");
            $("#addvillageModal").modal("hide");

        } else if (result == "Constituency") {
            $("#addconsituencyModal").modal("show");
            $("#adddistrictModal").modal("hide");
            $("#addvillageModal").modal("hide");
        } else if (result == "Village") {
            $("#addvillageModal").modal("show");
            $("#addconsituencyModal").modal("hide");
            $("#adddistrictModal").modal("hide");
        }

    }
</script>

<script>
    function gd_valid() {
        document.getElementById('gd_constituency').submit();
    }

    function district_name() {
        document.getElementById('gd_district').submit();
    }

    function village_name() {
        document.getElementById('gd_village').submit();
    }
</script>

<script>
    function gdconstituency_fetch(id, type) {



        $.ajax({
            url: "{{ url('/district/fetch') }}",
            type: 'GET',
            data: {
                'id': id,
                'type': type,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                console.log(data);
                if (type == "district_edit") {
                    $('#district_name_edit').val(data.rows[0]['district_name']);
                    $('#eid').val(data.rows[0]['id']);

                } else if (type == "district_show") {
                    $('#district_name_show').val(data.rows[0]['district_name']);
                    $('#eidshow').val(data.rows[0]['id']);

                    $('#district_name_show').prop('disabled', true);
                    $('#eidshow').attr('Action', '');


                }


            }
        });

    }


    function gdconstituencydist_fetch(id, type) {
        alert(id);
        $.ajax({
            url: "{{ url('/constituency/fetch') }}",
            type: 'GET',
            data: {
                'id': id,
                'type': type,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                console.log(data);
                if (type == "constituency_edit") {
                    $('#district_edit_id').val(data.rows[0]['district_name']);
                    $('#constituency_id_edit').val(data.rows[0]['constituency_name']);
                    $('#eid').val(data.rows[0]['id']);

                } else if (type == "district_show") {
                    $('#district_name_show').val(data.rows[0]['district_name']);
                    $('#eidshow').val(data.rows[0]['id']);

                    $('#district_name_show').prop('disabled', true);
                    $('#eidshow').attr('Action', '');


                }


            }
        });

    }
</script>














<script>
    function gdconstituency_delete(id, constituency_id, tabletype) {

        Swal.fire({
            title: "Are you Sure,you want to Delete the District?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/gd_district_delete') }}",
                    type: 'GET',
                    data: {
                        'id': id,
                        'constituency_id': constituency_id,
                        'tabletype': tabletype,
                        _token: '{{csrf_token()}}'

                    },


                    success: function(data) {
                        console.log(data);
                        //exit();
                        if (data['data'] == 0) {
                            Swal.fire("Info!", data['message_cus'], "info", data['message_cus'])
                            return false
                        }

                        if (result.value) {
                            Swal.fire("Success!", data['message_cus'], "success").then((result) => {

                                location.replace(`/general_masters`);

                            })
                        }



                    }
                });
            }
        })




    }
</script>

<script>
    function district_update() {

        var district = $("#district_name_edit").val();
        if (district == '') {
            swal.fire("Please Enter the district", "", "error")
            return false;
        } else {
            document.getElementById('edit_dist').submit();
        }

    }
</script>




@endsection