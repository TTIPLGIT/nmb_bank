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
<div class="main-content module_space">
  {{ Breadcrumbs::render('uam_modules.index') }}
  <section class="section">


    <div class="section-body mt-2">

      @if(strpos($screen_permission['permissions'], 'Create') !== false)
      <a type="button" style="font-size:15px;" class="btn btn-success btn-lg"
      href="{{ route('uam_modules.create') }}">Add Modules</a>
    @endif
      <div class="row">

        <div class="col-12">

          <div class="card">

            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4>List of Modules</h4>
                </div>

              </div>
              @if (session('success'))

          <input type="hidden" name="session_data" id="session_data" class="session_data"
          value="{{ session('success') }}">
          <script type="text/javascript">
          window.onload = function () {
            var message = $('#session_data').val();
            swal({
            title: "Success",
            text: message,
            type: "success",
            });

          }
          </script>
        @elseif(session('error'))

        <input type="hidden" name="session_data" id="session_data1" class="session_data"
        value="{{ session('error') }}">
        <script type="text/javascript">
        window.onload = function () {
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
                  <table class="table table-bordered align_button" id="align">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Parent Module Name</th>
                        <th>Module Name</th>
                        <th>Display Order</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key => $row)
              <tr>
              <td>{{ ++$key }}</td>

              @if($row['parent_module_name'] == null)
          <td>NA</td>
        @else
        <td>{{ $row['parent_module_name'] }}</td>
      @endif

              <td>{{ $row['module_name'] }}</td>
              <td>{{ $row['display_order'] }}</td>

              <td class="text-center">

                <form action="{{ route('uam_modules.destroy', \Crypt::encrypt($row['module_id'])) }}"
                method="POST">
                @if(strpos($screen_permission['permissions'], 'Show') !== false)
          <a class="btn btn-link"
            href="{{ route('uam_modules.show', \Crypt::encrypt($row['module_id'])) }}"><i
            class="fas fa-eye" style="color:blue"></i></a>
        @endif



                @if(strpos($screen_permission['permissions'], 'Edit') !== false)
          <a class="btn btn-link"
            href="{{ route('uam_modules.edit', \Crypt::encrypt($row['module_id'])) }}"><i
            class="fas fa-pencil-alt" style="color:darkblue"></i></a>
        @endif

                @csrf
                @method('DELETE')
                @if(strpos($screen_permission['permissions'], 'Delete') !== false)
          <a class="btn btn-link" title="Delete"
            onclick="return confirm('Are you sure you want to delete this data ?');"><i
            class="far fa-trash-alt" style="color:red"></i></a>
        @endif
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


<script>
  function myFunction(id) {

    swal({
      message: "Are You Sure to delete this data.",
      title: "Confirmation For Delete ?",
      centerVertical: true,
      buttons: {
        confirm: {
          label: 'Yes',
          className: 'btn-success'
        },
        cancel: {
          label: 'No',
          className: 'btn-danger'
        }
      },
      callback: function (result) {
        if (result == true) {
          var url = $('#' + id).val();
          window.location.href = url;
        }
      }
    });


  }
</script>



@endsection