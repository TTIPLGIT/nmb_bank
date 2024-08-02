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

          .section {
            margin-top: 20px;
          }
 
</style>
<div class="main-content">



{{ Breadcrumbs::render('qmaster.index')}}

  <section class="section">

    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">List of Question</h4>
    </div>
    <div class="section-body mt-2">
     
        <a type="button" value="Cancel" class="btn btn-labeled btn-info " title="create" data-toggle="modal" data-target="#addModal" style="background: #54ca68 !important; border-color:#54ca68 !important; color:white !important;    margin-left: 13px !important;">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important" href="{{ route('qmaster.create') }}">Add Question</span></a>

      
      

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
                            <th>Questions</th>

                            <th>Action</th>


                          </tr>
                        </thead>
                        <tbody>
          
                        @foreach($rows['rows']['question_master'] as $key=>$row)
                          <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $row['question']}}</td>
                          
                            <td>
                              <form action="{{ route('qmaster.destroy', \Crypt::encrypt($row['id'])) }}" method="POST">
                              @csrf
                                  @method('DELETE')
                              <a class="btn btn-link" href="{{ route('qmaster.show',$row['id']) }}" title="show" data-toggle="modal" data-target="#showModal{{$row['id']}}" style="color:darkblue"><i class="fas fa-eye"></i></a>

                              <a class="btn btn-link" href="{{ route('qmaster.edit',$row['id']) }}" title="Edit" data-toggle="modal" data-target="#editModal{{$row['id']}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>

                                  <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this Currency ?');" class="btn btn-link" style="color:red"><i class="far fa-trash-alt"></i></button>
                                  
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




@include('Questionmaster.create')
@include('Questionmaster.edit')
@include('Questionmaster.show')
@endsection