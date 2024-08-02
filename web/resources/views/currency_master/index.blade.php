@extends('layouts.admin_nav')
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
<div class="main-content">





  <section class="section">

    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">List of Currency</h4>
    </div>
    {{ Breadcrumbs::render('currency_master.index') }}
    <div class="section-body mt-2">
      @for ($i = 0; $i < count($screen_permission); $i++) 
      @php $a=$screen_permission[$i]->permission; @endphp
        @if($a == 'Create')
        <a type="button" value="Cancel" class="btn btn-labeled btn-info" title="create" data-toggle="modal" data-target="#addModal" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Add Currency</span></a>
        @else
        <style>
          .section {
            margin-top: 20px;
          }
        </style>
        @endif
        @endfor

        <div class="row">

          <div class="col-12">

            <div class="mt-0">

              <div class="card-body" id="card_header">
                <div class="row">


                </div>
                @if (session('success'))

                <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                <script type="text/javascript">
                  window.onload = function() {
                    var message = $('#session_data').val();
                    swal({
                      title: "Success",
                      text: message,
                      type: "success",
                    });

                  }
                </script>
                @elseif(session('error'))

                <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
                <script type="text/javascript">
                  window.onload = function() {
                    var message = $('#session_data1').val();
                    swal({
                      title: "Info",
                      text: message,
                      type: "info",
                    });

                  }
                </script>
                @endif



                <div class="table-wrapper">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="align">
                      <thead>
                        <tr>
                          <th>Sl. No.</th>
                          <th>Currency</th>
                          <th>Currency Code</th>
                          <th>Description</th>
                          <th>Action</th>


                        </tr>
                      </thead>
                      <tbody>

                        @foreach($currency as $data)

                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$data->currency_name }}</td>
                          <td>{{$data->currency_code}}</td>
                          <td>{{$data->currency_description}}</td>
                          <td>
                            <form action="{{ route('currency_master.destroy',$data->id) }}" method="POST">
                              @php $id= Crypt::encrypt($data->id); @endphp
                              @for ($i = 0; $i < count($screen_permission); $i++) @php $a=$screen_permission[$i]->permission; @endphp
                                @if($a == 'Edit')
                                <a class="btn btn-link" href="{{ route('currency_master.edit',$data->id) }}" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{$data->id}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                @elseif($a == 'Delete')
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this Currency ?');" class="btn btn-link" style="color:red"><i class="far fa-trash-alt"></i></button>
                                @endif
                                @endfor
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
  </section>
</div>
</div>


@include('layouts.footer')

@include('currency_master.create')
@include('currency_master.edit')
@include('layouts.script')
@endsection