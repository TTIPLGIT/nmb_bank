@foreach($currency as $data)
<div class="modal fade" id="editmodulemodal{{$data->id}}">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form name="edit_form" action="{{ route('currency_master.update',$data->id) }}" method="POST" id="edit_currency_form{{$data->id}}">
        {{ csrf_field() }}
        @method('PUT')
        <div class="modal-header" style="background-color:DarkSlateBlue;">
          <h5 class="modal-title" id="#editModal">Edit Currency</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" required id="user_id" name="user_id" value="{{Auth::user()->id}}">
          <input type="hidden" class="form-control" required id="id" name="id" value="{{$data->id}}">
          <div class="row register-form">
                @include('mandatorynotes')
            <div class="col-md-12">
              <div class="form-group">
                <label><b>Currency:</b><span style="color: red">*</span></label>
                <input class="form-control{{ $errors->has('currency_name') ? ' is-invalid' : '' }}" type="text" name="currency_name" id="currency_name{{$data->id}}" value="{{$data->currency_name}}">
                @if ($errors->has('currency_name'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('currency_name') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label><b>Currency Code:</b><span style="color: red">*</span></label>
                <input class="form-control{{ $errors->has('currency_code') ? ' is-invalid' : '' }}" type="text" name="currency_code" id="currency_code{{$data->id}}" value="{{$data->currency_code}}">
                @if ($errors->has('currency_code'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('currency_code') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label><b>Description:</b><span style="color: red">*</span></label>
                <textarea class="form-control{{ $errors->has('currency_description') ? ' is-invalid' : '' }}" rows="10" cols="100" maxlength="500" id="currency_description{{$data->id}}" name="currency_description">{{$data->currency_description}}</textarea>
                @if ($errors->has('currency_description'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('currency_description') }}</strong>
                </span>
                @endif
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <div class="mx-auto">

              <a type="button" onclick="editbuttonclick('{{$data->id}}')" class="btn btn-labeled btn-succes" title="Update" style="background: green !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update</a>
              <a type="button" data-dismiss="modal" aria-label="Close" value="Cancel" class="btn btn-labeled btn-space" title="Cancel" style="background: red !important; border-color:red !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-remove"></i></span>Cancel</a>


            </div>
          </div>

      </form>

    </div>
  </div>
</div>
</div>

<script>
  function editbuttonclick(id) {

    var currency_name = $('#currency_name' + id).val();
    if (currency_name == '') {
      swal("Please Enter Currency! ", "", "error");
      return false;
    }

    var currency_code = $('#currency_code' + id).val();
    if (currency_code == '') {
      swal("Please Enter Currency Code! ", "", "error");
      return false;
    }
    var currency_description = $('#currency_description' + id).val();
    if (currency_description == '') {
      swal("Please Enter Currency Description ! ", "", "error");
      return false;
    }
    var id = (id);

    document.getElementById('edit_currency_form' + id).submit();
  }
</script>


@endforeach