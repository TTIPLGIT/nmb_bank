  <div class="modal fade" id="addModal">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">

        <form action="{{ route('currency_master.store') }}" method="POST" id="currency_form">
          {{ csrf_field() }}

          <div class="modal-header" style="background-color:DarkSlateBlue;">
            <h5 class="modal-title" id="addModal">Add Currency</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"></span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" class="form-control" required id="user_id" name="user_id" value="{{Auth::user()->id}}">

            <div class="row register-form">
                  @include('mandatorynotes')
              <div class="col-md-12">
                <div class="form-group">
                  <label><b>Currency:</b><span style="color: red">*</span></label>
                  <input class="form-control" type="text" name="currency_name" id="currency_name">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label><b>Currency Code:</b><span style="color: red">*</span></label>
                  <input class="form-control" type="text" name="currency_code" id="currency_code">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label><b>Description:</b><span style="color: red">*</span></label>
                  <textarea class="form-control" rows="10" cols="100" maxlength="500" id="currency_description" name="currency_description"> </textarea>
                </div>
              </div>

            </div>

            <div class="modal-footer">
              <div class="mx-auto">
          
                <a type="button" onclick="save()" id="savebutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                  <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Save</a>
                <a type="button" data-dismiss="modal" aria-label="Close" value="Cancel" class="btn btn-labeled btn-space" title="Cancel" style="background: red !important; border-color:red !important; color:white !important">
                  <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-remove"></i></span>Cancel</a>


              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script>
    function save() {

      var currency_name = $('#currency_name').val();

      if (currency_name == '') {
        swal("Please Enter Currency! ", "", "error");
        return false;
      }

      var currency_code = $('#currency_code').val();

      if (currency_code == '') {
        swal("Please Enter Currency Code! ", "", "error");
        return false;
      }

      var currency_description = $('#currency_description').val();

      if (currency_description == '') {
        swal("Please Enter Currency Description ! ", "", "error");
        return false;
      }

      document.getElementById('currency_form').submit();
    }
  </script>