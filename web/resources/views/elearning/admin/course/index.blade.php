@extends('layouts.adminnav')

@section('content')
<style>
.nav-tabs-custom {
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.nav-tabs-custom .nav-tabs {
    border-bottom: none;
    background: #f5f5f5;
    border-radius: 5px 5px 0 0;
}

.nav-tabs-custom .nav-tabs li a {
    padding: 12px 20px;
    font-weight: 600;
    color: #555;
    border: none;
}

.nav-tabs-custom .nav-tabs li.active a {
    background: #0068a7;
    color: #fff;
    border-radius: 5px 5px 0 0;
}

.tab-content {
    padding: 20px;
    background: #fff;
    border-radius: 0 0 5px 5px;
}

.action-buttons {
    margin-bottom: 20px;
}

.table-responsive {
    overflow-x: auto;
}

.select2-container {
    width: 100% !important;
}

.badge-expiring {
    background-color: #ffc107;
    color: #000;
}

.badge-active {
    background-color: #28a745;
    color: #fff;
}
</style>

<div class="main-content main_contentspace">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" value="{{ session('success') }}">
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: "Success",
            text: document.getElementById('session_data').value,
            icon: "success",
        });
    });
    </script>
    @endif

    @if (session('error'))
    <input type="hidden" name="session_data" id="session_data" value="{{ session('error') }}">
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: "Error",
            text: document.getElementById('session_data').value,
            icon: "error",
        });
    });
    </script>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            {{ Breadcrumbs::render('list_course') }}

            <!-- Tabs Navigation -->
            <div class="nav-tabs-custom">


                <div class="tab-content">
                    <!-- Courses Tab -->
                    <div class="tab-pane fade show active" id="courses" role="tabpanel">
                        @include('elearning.admin.course.partials.courses-list')
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2-multi').select2({
        width: '100%',
        placeholder: 'Select options'
    });

    // Save active tab state
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        localStorage.setItem('activeCourseTab', $(e.target).attr('href'));
    });

    var activeTab = localStorage.getItem('activeCourseTab');
    if (activeTab && activeTab !== '#courses') {
        $('#courseTabs a[href="' + activeTab + '"]').tab('show');
    }
});
</script>
@endsection