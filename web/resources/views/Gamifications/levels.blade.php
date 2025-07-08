@extends('layouts.adminnav')

@section('content')
<style type="text/css">
    .dt-buttons.btn-group {
        display: none !important;
    }

    .mystyle {
        border: 2px solid red;
    }
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <section class="section">
                <div class="section-body">{{ Breadcrumbs::render('final_assesment') }}

                    <div class="d-flex justify-content-start  ml-3 mb-3">
                        <a href="{{ route('level_add_page') }}" class="btn btn-success " style="margin-right:100px">Level <i class="fa fa-plus"
                                aria-hidden="true"></i></a>
                    </div>

                    <div class="row">

                        <div class="col-12">

                            <div class="card">

                                <div class="card-body">
                                    <h4 style="color:black; text-align: center;">Levels</h4>
                                    <div class="row">
                                        <!-- <div class="col-lg-12 text-center">
          <h4 style="color:darkblue;">Folder List</h4>
        </div> -->

                                    </div>
                                    @if (session('success'))


                                    @elseif(session('error'))


                                    @endif

                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No.</th>
                                                        <th>Level Number</th>
                                                        <th>Level Name</th>
                                                        <th>Minimum Point</th>
                                                        <th>Maximum Point</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($levels as $level)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{ $level['level_number'] }}</td>
                                                        <td>{{ $level['level_name'] }}</td>
                                                        <td>{{ $level['min_point'] }}</td>
                                                        <td>{{ $level['max_point'] }}</td>
                                                        <td> <a class="btn btn-link" title="Edit" type="GET" id="gcb"
                                                               
                                                                data-toggle="modal" data-target="#addModal4"><i
                                                                    class="fas fa-pencil-alt"
                                                                    style="color: blue !important"></i></a>
                                                            <a class="btn btn-link" type="show"
                                                               
                                                                title="Show" id="gcb" href="" data-toggle="modal"
                                                                data-target="#addModal4"><i class="fas fa-eye"
                                                                    style="color:green"></i></a>


                                                            <a type="button" title="Delete"
                                                               
                                                                class="btn btn-link"><i class="far fa-trash-alt"
                                                                    style="color:red"></i></a>
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
        </div>
    </section>



</div>
</section>
</div>





@endsection