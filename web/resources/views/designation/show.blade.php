@extends('layouts.adminnav')

@section('content')
<div class="main-content">
    {{ Breadcrumbs::render('designation.show', $designation['designation_id']) }}
    @if (session('fail'))
    <div class="alert alert-danger">
        {{ session('fail') }}
    </div>
    @endif
    <section class="section">
        <div class="section-body mt-1">
            <h5 style="color:darkblue">Show Designation</h5>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form method="POST" action="{{ route('designation.update', $designation['designation_id']) }}">
                                @csrf
                                @method('POST')
                                <input type='hidden' value={{$designation['designation_id']}} name="id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Role <span style="color: red;">*</span></label>
                                            <select class="form-control" name="role_id" disabled required>
                                                <option value="">Please Select Role</option>
                                                @foreach($roles as $role)
                                                <option value="{{ $role['role_id']}}" {{ $role['role_id'] == $designation['role_id'] ? 'selected' : '' }}>{{ $role['role_name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Designation <span style="color: red;">*</span></label>
                                            <input class="form-control" type="text" name="designation_name" readonly value="{{ $designation['designation_name'] }}" required>
                                            @error('designation')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Designation Description</label>
                                            <input class="form-control" type="text" readonly name="notes" value="{{ $designation['notes'] }}">
                                            @error('designation_description')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                      
                                        <a class="btn btn-danger" href="{{ route('designation.index') }}">Cancel</a>
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
@endsection