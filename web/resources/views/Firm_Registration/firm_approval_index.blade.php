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



<div class="main-content">
  <section class="section">{{ Breadcrumbs::render('Firm_approval_index') }}
    <div class="col-lg-12 text-center">
      <h4>Approval List view of Firm Registration</h4>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="mt-0">
            <div class="card-body" id="card_header">
              <div class="row">
              </div>
              @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            $(document).ready(function() {
                var message = $('#session_data').val();
                swal.fire({
                    title: "Success",
                    text: message,
                    icon: "success",
                });

            })
        </script>
        @elseif(session('error'))

        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
        <script type="text/javascript">
            $(document).ready(function() {
                var message = $('#session_data1').val();
                swal.fire({
                    title: "Info",
                    text: message,
                    icon: "info",
                });

            });
        </script>
        @endif
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>Firm Name</th>
                        <th>Description</th>
                        <th>Requested On</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows['firm_approval'] as $key=>$data)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data['firm_name']}}</td>
                        <td>{{$data['description']}}</td>
                        <td>{{date('d-m-Y H:i:s', strtotime($data['created_at']))}}</td>

                        @if($data['status']==0)
                        <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                        @elseif($data['status']==1)
                        <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                        @else
                        <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                        @endif

                        <form action="{{route('firm_show')}}" method="GET">
                          @csrf
                          <input type="hidden" class="show" id="id" name="id" value="{{$data['id']}}">
                          <td>
                            @if($data['status']==0 || $data['status']==2)
                            <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button>
                            @elseif($data['status']==1)
                            <a class="btn btn-link" title="show" href="{{ route('firm_show', ['id' => $data['id']]) }}"><i class="fas fa-eye" style="color:green"></i></a>
                          </td>
                             @endif

                        </form>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script>
  $(document).ready(function() {

    let url = new URL(window.location.href)
    let message = url.searchParams.get("message");
    if (message != null) {
      window.history.pushState("object or string", "Title", "/gtapprove");

      swal.fire({
        icon: "Success",
        title: "Success",
        text: "Rejected Successfully",
        type: "success",
      });
    }

  })
</script>




@endsection