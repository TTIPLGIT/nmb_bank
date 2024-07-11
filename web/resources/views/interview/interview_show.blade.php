@extends('layouts.adminnav')

@section('content')

<div class="main-content main_contentspace">
    <div class="row justify-content-center">

        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                Swal.fire({
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
        {{ Breadcrumbs::render('interview_process') }}

            <form method="POST" id="interview_form" enctype="multipart/form-data" onsubmit="return false">
                @csrf
                <div id="interview">
                    <section class="section">
                        <div class="section-body mt-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="table-wrapper">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="align">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl.No</th>
                                                                <th>Name</th>
                                                                <th>Sheduele Date</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($interview_show as $interview)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{$interview->name}}</td>
                                                                <td>{{$interview->scheduled_date}}</td>
                                                                @if($interview->status==0)
                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-warning waitingbadge">Scheduled</span></td>
                                                                @elseif($interview->status==1)
                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Selected</span></td>
                                                                @elseif($interview->status==2)
                                                                <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                @elseif($interview->status==3)
                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-warning waitingbadge">Hold</span></td>
                                                                @endif
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script>
    function Deletedata(user_id) {

        Swal.fire({
            title: "Are you Sure,you want to Delete the Interview Schedule Data?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/gt_interview_delete') }}",
                    type: 'GET',
                    data: {
                        'user_id': user_id,
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

                                location.replace(``);

                            })
                        }



                    }
                });
            }
        })




    }
</script>




@endsection