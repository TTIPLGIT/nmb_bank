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
    /* font-weight: bold; */
  }

  .customIcons {
    width: 10%;
  }

  .downward {
    display: inline-flex;
    align-items: center;
  }
</style>

<style>
  .section {
    margin-top: 20px;
  }
</style>
<div class="main-content">
  {{ Breadcrumbs::render('instruction.index') }}
  <section class="section">
    <div class="row d-flex justify-content-between">
      @if(strpos($permission[0]['permissions'], 'Create') !== false)
      <div class="col-md-3">
        <a type="button" href="{{ url('initiation/create') }}" value="" class="btn btn-labeled btn-success" title="Initiate" style="border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Initiation</span></a>
      </div>
      @endif
      <div class="col-md-3 ">
        <select class="form-control default sort-select" id="sort-select" name="sort-select">

          <option value="1" data-target="all">All</option>
          <option value="0" data-target="0">Pending</option>
          <option value="2" data-target="2">InReview</option>
          <option value="4" data-target="4">Rejected</option>
          <option value="3" data-target="3">Received</option>

        </select>
      </div>
    </div>


    <div class="section-body mt-2">

      <div class="row">

        <div class="col-12">

          <div class="mt-0">

            <div class="card-body" id="card_header">
              <div class="col-lg-12 text-center">
                <h4>Instruction List view</h4>
              </div>

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
                  swal({
                    title: "Success",
                    text: message,
                    icon: "success",
                  });


                }
              </script>
              @endif

              <div class="table-wrapper">
                <div class="table-responsive">
                  @if($alter_name->alter_name == config('setting.ROLE_NAME.governmentStakeHolder'))
                  @include('GovernmentInstruction.tables.stakeholder')
                  @elseif($alter_name->alter_name == config('setting.ROLE_NAME.professional_member'))
                  @if($alter_name->role_designation == 'CGV')
                  @include('GovernmentInstruction.tables.cgv')
                  @elseif($alter_name->role_designation == 'AC')
                  @include('GovernmentInstruction.tables.ac')
                  @elseif($alter_name->role_designation == 'PGV')
                  @include('GovernmentInstruction.tables.pgv')
                  @elseif($alter_name->role_designation == 'SGV')
                  @include('GovernmentInstruction.tables.sgv')
                  @elseif($alter_name->role_designation == 'GV')
                  @include('GovernmentInstruction.tables.gv')
                  @endif
                  @else
                  @include('GovernmentInstruction.tables.gv')
                  @endif
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
    $("#sort-select").on("change", function() {
      var selectedValue = $(this).val();

      if (selectedValue === "all") {
        // Show all rows if "All" is selected
        $("tbody tr").show();
      } else {
        // Hide all rows and then show the selected ones
        $("tbody tr").hide();
        $("tbody .status-" + selectedValue).closest('tr').show();
      }
      $('#align').DataTable({


        "lengthMenu": [
          [10, 50, 100, 250, -1],
          [10, 50, 100, 250, "All"]
        ], // page length options

        dom: 'lBfrtip',
        destroy: true,


      });
    });
  });
</script>
<script>
  $(document).ready(function() {


    let url = new URL(window.location.href)
    let message = url.searchParams.get("message");
    if (message != null) {
      window.history.pushState("object or string", "Title", "/gtapprove");

      swal.fire({
        title: "Success",
        text: "Rejected Successfully",
        icon: "success",
      });
    }

  })
</script>
@if(isset($rows['trakerData']) && $rows['trakerData'] != [])
@foreach($rows['tableData'] as $row)
@php
$currentTraker = $rows['trakerData'][$row['id']];
$modalID = $loop->iteration;
$userTaskData = [];
@endphp
@if(isset($rows['userTaskData'][$row['id']]))
@php $userTaskData = $rows['userTaskData'][$row['id']]; @endphp
@endif
@include('GovernmentInstruction.Models.coc')
@endforeach
@endif
@include('Registration.formmodal')
<script>
  const getproposaldocument = (id) => {
    var id = (id);

    $.ajax({
      url: "{{url('view_proposal_documents')}}",
      type: 'post',
      data: {
        id: id,
        _token: '{{csrf_token()}}'
      },
      error: function() {},
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
  $(document).on('click', '.fileView', function() {
    const fileName = $(this).data('file');
    getproposaldocument(fileName);
  })
</script>

@endsection