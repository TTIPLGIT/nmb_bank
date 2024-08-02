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
<div class="main-content">{{ Breadcrumbs::render('valuerindex') }}





  <section class="section">

    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">Certification</h4>
    </div>
    <div class="section-body mt-2">



      <style>
        .section {
          margin-top: 20px;
        }
      </style>


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
                        <th>Name</th>
                        <th>Valuator Code</th>
                        <th>Status</th>
                        <th>Expiry date</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>


                      @foreach($rows['general'] as $data)

                      <div>
                        <!-- for other users -->
                      </div>


                      <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{$data['name']}}</td>
                        <td>{{$data['valuer_code']}}</td>
                        <td>{{$data['v_status']}}</td>
                        <td>12/11/2023</td>
                        <td>

                          <form action="{{route('approve_for_stake')}}" method="GET">
                            @csrf
                            @php $id =($data['user_id']); @endphp
                            <input type="hidden" name="valuer_id" class="celigqa" id="valuer_id" value="{{$data['valuer_id']}}">
                            <input type="hidden" name="v_user_id" class="celigqa" id="v_user_id" value="{{$data['user_id']}}">
                            <input type="hidden" name="user_id" class="celigqa" id="user_id" value="">
                            <!-- <a class="btn btn-link" title="Edit" href="{{route('Registration.edit','') }}" data-toggle="modal" data-target="#editeligeModal"><i class="fas fa-pencil-alt" style="color:darkblue"></i></a> -->
                            <a class="btn btn-link" href="#" title="Certificate View" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('/userdocuments/registration/valuercertification.pdf')"><i class="fa fa-certificate" style="font-size:x-large"></i></a>


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
<script>
  function getproposaldocument(id) {
    var id = (id);


    $.ajax({
      url: "{{url('view_proposal_documents')}}",
      type: 'post',
      data: {
        id: id,
        _token: '{{csrf_token()}}'
      },
      error: function() {
        alert('Something is wrong');
      },
      success: function(data) {
        console.log(data.length);
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
@include('Registration.formmodal')

@endsection