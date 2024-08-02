@extends('layouts.adminnav')

@section('content')
<div class="row">

    <div class="main-content module_space">    
        <!-- Main Content -->
        <section class="section">
            <div class="section-body mt-1">
                <h5 class="heading_align" style="color:darkblue">Modules Show</h5>
                <div class="row">
                {{ Breadcrumbs::render('uam_modules.show',$rows[0]['module_id']) }} 

                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Parent Module Name</label>
                                            <select class="form-control" name="parent_module_id" disabled="">
                                                <option value="">--- Select Parent Module Name ---</option>
                                                @foreach($rows as $key=>$row)
                                                <option value="{{ $row['module_id']}}" {{ $row['module_id'] ==  $one_row[0]['parent_module_id'] ? 'selected':'' }}>{{ $row['module_name'] }}</option>
                                                @endforeach
                                                

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Module Category <span style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" name="module_type" disabled="">
                                                <option value="">Select Category</option>
                                                @foreach($one_row as $one_rows)
                                                <option value="01" {{ $one_rows['module_type'] ==  "01" ? 'selected':'' }}>Module</option>
                                                <option value="02" {{ $one_rows['module_type'] ==  "02" ? 'selected':'' }}>Sub Module</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Module Name <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="module_name" name="module_name" placeholder="Enter Module Name" value="{{ $one_row[0]['module_name'] }}" disabled="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Icon Class Name <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="class_name" name="class_name" placeholder="Enter Class Name" value="{{$one_row[0]['class_name']}}" disabled="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Display Order </label>
                                            <input class="form-control" type="text" id="display_order" name="display_order" placeholder="Enter Display Order" value="{{ $one_row[0]['display_order'] }}" disabled="">
                                        </div>
                                    </div>

                                    <input class="form-control" type="hidden" id="module_id" name="module_id" placeholder="Enter Module Name" value="{{ $one_row[0]['module_id'] }}">
                                </div>

                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <a class="btn btn-danger" href="{{ route('uam_modules.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;

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


@endsection