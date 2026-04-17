@extends('layouts.adminnav')

@section('content')
<div class="main-content">
    <h5 class="text-center" style="color:darkblue">Create Custom Field</h5>
    {{ Breadcrumbs::render('custom_filed_create') }}
    <section class="section">
        <div class="section-body mt-1">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('custom_filed_store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Field Label :<span style="color: red;">*</span></label>
                                            <input class="form-control" type="text" name="field_label"
                                                placeholder="Enter Field Label" required>
                                            @error('field_label')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Field Name :<span style="color: red;">*</span></label>
                                            <input class="form-control" type="text" name="field_name"
                                                placeholder="Enter Field Name" required>
                                            @error('field_name')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Field Type : <span style="color: red;">*</span></label>
                                            <select class="form-control" name="field_type" id="field_type" required>
                                                <option value=""> ---Select--- </option>
                                                <option value="text">Text</option>
                                                <option value="email">Email</option>
                                                <option value="number">Number</option>
                                                <option value="date">Date</option>
                                                <option value="dropdown">Dropdown</option>
                                                <!-- <option value="checkbox">Checkbox</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="display:none;" id="options_section">
                                        <div class="form-group">
                                            <label>Dropdown Options (Comma separated) : <span
                                                    style="color: red;">*</span></label>
                                            <input class="form-control" type="text" name="field_options"
                                                placeholder="Enter Field Name">
                                            @error('field_options')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Required Field :</label>
                                            <input type="hidden" name="is_required" value="0">
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="is_required" id="is_required" value="1">
                                                <label class="form-check-label" for="is_required">
                                                    Yes / No
                                                </label>
                                            </div>

                                            @error('is_required')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> -->
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <button class="btn btn-success" type="submit">Submit</button>
                                        <a class="btn btn-danger" href="{{ route('custom_filed') }}">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.getElementById('field_type').addEventListener('change', function() {
    if (this.value === 'dropdown') {
        document.getElementById('options_section').style.display = 'block';
    } else {
        document.getElementById('options_section').style.display = 'none';
    }
});
</script>
@endsection