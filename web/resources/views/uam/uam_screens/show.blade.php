@extends('layouts.adminnav')

@section('content')
<div class="row">
  <div class="main-content module_space">

    <!-- Main Content -->
    <section class="section">

      {{ Breadcrumbs::render('uam_screens.show',$rows[0]['screen_id']) }}
      <div class="section-body mt-1">
        <h5 class="heading_align"  style="color:darkblue">Screens Show</h5>
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-body">


                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Screen Name <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control" type="text" id="screen_name" name="screen_name" placeholder="Enter Screen Name" value="{{ $rows[0]['screen_name'] }}" autocomplete="off" disabled="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Screen URL <span style="color: red;font-size: 16px;">*</span> </label>
                      <input class="form-control" type="text" id="screen_url" name="screen_url" placeholder="Enter Screen Name" value="{{ $rows[0]['screen_url'] }}" autocomplete="off" disabled="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Route URL <span style="color: red;font-size: 16px;">*</span> </label>
                      <input class="form-control" type="text" id="route_url" name="route_url" placeholder="Enter Route Name" value="{{ $rows[0]['route_url'] }}" autocomplete="off" disabled="">
                    </div>
                  </div>



                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Display Order </label>
                      <input class="form-control" type="text" id="display_order" name="display_order" placeholder="Enter Display Order" value="{{ $rows[0]['display_order'] }}" autocomplete="off" disabled="">
                    </div>
                  </div>





                  <div class="col-md-6">

                    <label class="control-label">Screen Permission <span style="color: red;font-size: 16px;">*</span> </label>
                    <div class="row">
                      @foreach($permissions as $key=>$permission)
                      <div class="col-md-3">
                        <div class="form-group">

                          <input type="checkbox" id="{{ $permission }}" name="screen_permission[]" value="{{$permission}}" disabled="">

                          <label for="{{ $permission}}"> {{ $permission }}</label>

                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>



                  <input class="form-control" type="hidden" id="screen_id" name="screen_id" placeholder="Enter Module Name" value="{{ $rows[0]['screen_id'] }}">
                </div>

                <div class="row text-center">
                  <div class="col-md-12">

                    <a class="btn btn-danger" href="{{ route('uam_screens.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;

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


<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
  $("#module_name").keypress(function(event) {
    var inputValue = event.charCode;
    if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) {
      event.preventDefault();
    }
  });
</script>
<script>
  function editbuttonclick(id) {

    var module_name = $('#module_name' + id).val();

    if (module_name == '') {
      swal("Please Enter Module Name ", "", "error");
      return false;
    }



    document.getElementById('edit_module_form' + id).submit();
  }
</script>
<script type="text/javascript">
  $(document).ready(function() {




    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $screen_id = $("#screen_id").val();

    // alert($screen_id);

    $.ajax({
      url: '{{ url(' / getscreenpermission ') }}',
      type: "POST",
      dataType: "json",
      data: {
        screen_id: $screen_id,
        _token: '{{csrf_token()}}'
      },
      success: function(data) {
        console.log(data);
        if (data.length == 0) {


        } else {
          for (i = 0; i < data.length; i++) {

            console.log(data[i].permission)
            document.getElementById(data[i].permission).checked = true;
            document.getElementById(data[i].permission).setAttribute('checked', 'checked');
          }

          var checkBox = document.getElementById("Work_flow");
          if (checkBox.checked == true) {

            $('#mycheckboxdiv').show();
          } else {
            $('#mycheckboxdiv').hide();
          }



        }
      },
      error: function(data) {
        console.log(data);
      }
    });





  });
</script>
<script>
  function edit_screens() {

    var screen_name = $('#screen_name').val();

    if (screen_name == '') {
      swal("Please Enter Screen Name ", "", "error");
      return false;
    }

    var screen_url = $('#screen_url').val();

    if (screen_url == '') {
      swal("Please Enter Screen URL ", "", "error");
      return false;
    }

    var route_url = $('#route_url').val();

    if (route_url == '') {
      swal("Please Enter Route URL ", "", "error");
      return false;
    }

    var class_name = $('#class_name').val();

    if (class_name == '') {
      swal("Please Enter class Name ", "", "error");
      return false;
    }
    var checkedCount = $("input[type=checkbox][name^=screen_permission]:checked").length;

    if (checkedCount == 0) {
      swal("Please Enter Screen permission ", "", "error");
      return false;
    }





    document.getElementById('uam_screens_edit').submit();
  }
</script>



@endsection