@extends('layouts.adminnav')

@section('content')
<div class="main-content">

    @if (session('fail'))
    <div class="alert alert-danger">
        {{ session('fail') }}
    </div>
    @endif
    <section class="section">
        <div class="section-body mt-1">
            @php
            $status = $certificate_templates['status'] ?? 'Draft';
            @endphp

            <h4 class="">
                Certificate Lifecycle Management
            </h4>

            <p class="text-muted mb-2">
                Manage certificate templates through Draft, Approval, Activation, and Archival stages.
            </p>

            <!-- 🔹 Lifecycle Progress -->
            <ul class="list-inline mb-4">
                <li class="list-inline-item {{ $status=='Draft' ? 'font-weight-bold text-secondary' : '' }}">
                    Draft →
                </li>
                <li class="list-inline-item {{ $status=='Approved' ? 'font-weight-bold text-info' : '' }}">
                    Approved →
                </li>
                <li class="list-inline-item {{ $status=='Active' ? 'font-weight-bold text-success' : '' }}">
                    Active →
                </li>
                <li class="list-inline-item {{ $status=='Archived' ? 'font-weight-bold text-dark' : '' }}">
                    Archived
                </li>
            </ul>




            <form method="POST" action="{{ route('certificate_template.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($certificate_template_details))
                @method('POST')
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Status <span class="error-star" style="color:red;">*</span></label>
                                <select name="status" class="form-control"
                                    {{ in_array($status, ['Active','Archived']) ? 'disabled' : '' }}>
                                    <option value="Draft" {{ $status=='Draft'?'selected':'' }}>Draft</option>
                                    <option value="Approved" {{ $status=='Approved'?'selected':'' }}>Approved</option>
                                    <option value="Active" {{ $status=='Active'?'selected':'' }}>Active</option>
                                    <option value="Inactive" {{ $status=='Inactive'?'selected':'' }}>Inactive</option>
                                    <option value="Archived" {{ $status=='Archived'?'selected':'' }}>Archived</option>
                                </select>

                            </div>
                            <div class="col-md-4">
                                <label>Logo <span class="error-star" style="color:red;">*</span></label>

                                <input type="file" name="logo[]" class="form-control">
                                {{-- Preserve old file path in hidden input --}}
                                <input type="hidden" name="existing_logo[]" value="">
                            </div>

                        </div>
                        @php
                        $isLocked = in_array($status, ['Active','Archived']);
                        @endphp
                        <div id="entryWrapper">
                            <div class="row entry-block mb-3">
                                <input type="hidden" name="certificate_template_signatories_id[]"
                                    value="">

                                <div class="col-md-4">
                                    <label>Name <span class="error-star" style="color:red;">*</span></label>
                                    <input type="text" name="name[]" class="form-control" placeholder="Name"
                                        value="" required>
                                </div>

                                <div class="col-md-4">
                                    <label>Designation <span class="error-star" style="color:red;">*</span></label>
                                    <input type="text" name="designation[]" class="form-control" placeholder="Designation"
                                        value="" required>
                                </div>

                                <div class="col-md-3">
                                    <label>Signature <span class="error-star" style="color:red;">*</span></label>

                                    <input type="file" name="signature[]" class="form-control">


                                    {{-- Display current image --}}


                                    {{-- Preserve old file path in hidden input --}}
                                    <input type="hidden" name="existing_signature[]" value="">
                                </div>





                                <div class="col-md-1">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-remove"
                                        style="">X</button>
                                </div>
                            </div>
                        </div>


                        <button type="button" class="btn btn-info mb-3" id="addMore" {{ $isLocked ? 'disabled' : '' }}>Add Signatory</button>
                        <br>
                        <div class="row text-center">
                            <div class="col-md-12">

                                @if($status == 'Draft')
                                <button class="btn btn-secondary">
                                    Save as Draft
                                </button>
                                <button name="action" value="submit_for_approval" class="btn btn-primary">
                                    Submit for Approval
                                </button>
                                @endif

                                @if($status == 'Approved')
                                <button name="action" value="activate" class="btn btn-success">
                                    Activate Certificate
                                </button>
                                @endif

                                @if($status == 'Active')
                                <button name="action" value="archive" class="btn btn-warning">
                                    Archive Certificate
                                </button>
                                @endif

                                <a href="{{ route('certificate_template.index') }}" class="btn btn-danger">
                                    Cancel
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let entryCount = document.querySelectorAll('.entry-block').length;
        const maxEntries = 2;

        const addMoreBtn = document.getElementById('addMore');
        const wrapper = document.getElementById('entryWrapper');

        addMoreBtn.addEventListener('click', function() {
            if (entryCount >= maxEntries) return;

            const block = document.createElement('div');
            block.classList.add('row', 'entry-block', 'mb-3');

            block.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="name[]" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="designation[]" class="form-control" placeholder="Designation" required>
                </div>
                <div class="col-md-3">
                    <input type="file" name="signature[]" class="form-control" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-remove">X</button>
                </div>
            `;

            wrapper.appendChild(block);
            entryCount++;
            updateRemoveButtons();
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove')) {
                e.target.closest('.entry-block').remove();
                entryCount--;
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            document.querySelectorAll('.btn-remove').forEach(btn => {
                btn.style.display = (entryCount > 1) ? 'inline-block' : 'none';
            });
        }

        updateRemoveButtons();
    });
</script>