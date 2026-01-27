@extends('layouts.adminnav')

@section('content')
<div class="main-content">
    @php $isLocked = ($certificate_templates['status'] ?? '') == 'Active'; @endphp
    {{ Breadcrumbs::render('certificate_template.edit', $certificate_templates['certificate_templates_id']) }}
    @if (session('fail'))
    <div class="alert alert-danger">
        {{ session('fail') }}
    </div>
    @endif
    <section class="section">
        <div class="section-body mt-1">
            <h5 style="color:darkblue">
                {{!empty($certificate_template_details) && count($certificate_template_details) ? 'Edit Certificate Template Details' : 'Add Certificate Template Details' }}
            </h5>

            <form method="POST" action="{{ route('certificate_template.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($certificate_template_details))
                @method('POST')
                @endif
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Draft" {{ ($certificate_templates['status'] ?? '')=='Draft'?'selected':'' }}>Draft</option>
                            <option value="Approved" {{ ($certificate_templates['status'] ?? '')=='Approved'?'selected':'' }}>Approved</option>
                            <option value="Active" {{ ($certificate_templates['status'] ?? '')=='Active'?'selected':'' }}>Active</option>
                            <option value="Inactive" {{ ($certificate_templates['status'] ?? '')=='Inactive'?'selected':'' }}>Inactive</option>
                            <option value="Archived" {{ ($certificate_templates['status'] ?? '')=='Archived'?'selected':'' }}>Archived</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Version</label>
                        <input type="text" class="form-control"
                            value="{{ $certificate_templates['version'] ?? 1 }}" readonly>
                    </div>
                </div>

                <div id="entryWrapper">
                    @php
                    $entries = !empty($certificate_template_details) && count($certificate_template_details) > 0
                    ? $certificate_template_details
                    : [['name' => '', 'title' => '', 'signature_path' => '', 'certificate_template_signatories_id' =>
                    '']];
                    @endphp


                    <input type="hidden" name="certificate_templates_id"
                        value="{{ $certificate_templates['certificate_templates_id'] ?? '' }}">

                    @foreach($entries as $entry)
                    <div class="row entry-block mb-3">
                        <input type="hidden" name="certificate_template_signatories_id[]"
                            value="{{ $entry['certificate_template_signatories_id'] ?? '' }}">

                        <div class="col-md-4">
                            <label>Name</label>
                            <input type="text" name="name[]" class="form-control" placeholder="Name"
                                value="{{ $entry['name'] ?? '' }}" required>
                        </div>

                        <div class="col-md-4">
                            <label>Designation</label>
                            <input type="text" name="designation[]" class="form-control" placeholder="Designation"
                                value="{{ $entry['title'] ?? '' }}" required>
                        </div>

                        <div class="col-md-3">
                            <label>Signature</label>

                            <input type="file" name="signature[]" class="form-control"
                                {{ !empty($entry['signature_path']) ? '' : 'required' }}>

                            @if(!empty($entry['signature_path']))
                            {{-- Display current image --}}
                            <small class="text-muted">Current: {{ basename($entry['signature_path']) }}</small><br>
                            <img src="{{ config('setting.api_url') . $entry['signature_path'] }}" width="100"
                                class="mt-1 rounded border">

                            {{-- Preserve old file path in hidden input --}}
                            <input type="hidden" name="existing_signature[]" value="{{ $entry['signature_path'] }}">
                            @endif
                        </div>

                        <div class="col-md-3">
                            <label>Logo</label>

                            <input type="file" name="logo[]" class="form-control"
                                {{ !empty($entry['logo']) ? '' : 'required' }}>

                            @if(!empty($certificate_templates['logo']))
                            {{-- Display current image --}}
                            <small class="text-muted">Current: {{ basename($certificate_templates['logo']) }}</small><br>
                            <img src="{{ config('setting.api_url') . $certificate_templates['logo'] }}" width="100"
                                class="mt-1 rounded border">

                            {{-- Preserve old file path in hidden input --}}
                            <input type="hidden" name="existing_logo[]" value="{{ $certificate_templates['logo'] }}">
                            @endif
                        </div>



                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-remove"
                                style="{{ count($entries) > 1 ? '' : 'display:none' }}">X</button>
                        </div>
                    </div>
                    @endforeach
                </div>


                <button type="button" class="btn btn-info mb-3" id="addMore">Add Details</button>
                <br>
                <div class="row text-center">
                    <div class="col-md-12">
                        <!-- <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('certificate_template.index') }}" class="btn btn-danger">Cancel</a> -->

                        @if(($certificate_templates['status'] ?? 'Draft') == 'Draft')
                        <button class="btn btn-success">Save Draft</button>
                        <button name="action" value="submit_for_approval" class="btn btn-primary">Submit for Approval</button>
                        @endif

                        @if(($certificate_templates['status'] ?? '') == 'Approved')
                        <button name="action" value="activate" class="btn btn-success">Activate</button>
                        @endif

                        @if(($certificate_templates['status'] ?? '') == 'Active')
                        <button name="action" value="archive" class="btn btn-warning">Archive</button>
                        @endif

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