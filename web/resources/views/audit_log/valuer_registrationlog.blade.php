@extends('layouts.adminnav')

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">
            <div class="table-wrapper">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="align">
                      <thead>
                        <tr>
                          <th>Sl. No.</th>
                          <th>Audit Table Name</th>
                          <th>Audit Action</th>
                          <th>Description</th>
                          <th>Action date Time</th>


                        </tr>
                      </thead>
                      <tbody>
         
                      @foreach($rows['rows'] as $key=>$row)
                        <tr>
                          <td>{{ ++$key }}</td>
                          <td>{{ $row['audit_table_name']}}</td>
                          <td>{{ $row['audit_action']}}</td>
                          <td>{{ $row['description']}}</td>
                          <td>{{ $row['action_date_time']}}</td>

                          

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

@endsection
