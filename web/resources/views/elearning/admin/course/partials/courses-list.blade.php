<div>
    <div class="action-buttons">
        <a href="{{ route('admin.course.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i> Add Course
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="courses-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Course Name</th>
                    <th>Category</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->course_name }}</td>
                    <td>{{ $data->catagory_name ?? 'N/A' }}</td>

                    <!-- <td>
                        @php
                        $expiryDate = !empty($data->course_expiry_period) ?
                        \Carbon\Carbon::parse($data->course_expiry_period) : null;
                        $twoMonthsBefore = $expiryDate ? $expiryDate->copy()->subMonths(2) : null;
                        $today = \Carbon\Carbon::today();
                        $needsAttention = ($data->certificate_expiry == 1 && $expiryDate &&
                        $today->gte($twoMonthsBefore));
                        @endphp

                    </td> -->
                    <td>
                        @php
                        $showHandleButton = false;
                        $showReplacedMessage = false;
                        $replacementMessage = '';

                        $expiryDate = !empty($data->course_expiry_period) ?
                        \Carbon\Carbon::parse($data->course_expiry_period) : null;
                        $twoMonthsBefore = $expiryDate ?
                        $expiryDate->copy()->subMonths(2) : null;
                        $today = \Carbon\Carbon::today();


                        $courseIsReplaced =
                        collect(($courses))->contains(function
                        ($c) use
                        ($data) {
                        return $c->expired_course_id == $data->course_id;
                        });

                        if ($data->certificate_expiry == 1) {
                        if ($courseIsReplaced) {
                        $showReplacedMessage = true;
                        $replacementMessage = 'This course has been replaced with a
                        new or copied course.';
                        } elseif (is_null($data->expired_course_id) && $expiryDate
                        && $today->gte($twoMonthsBefore)) {
                        $showHandleButton = true;
                        }
                        }
                        @endphp





                        <!-- <a class="" title="Edit" id="gcb" href="" data-toggle="modal" data-target="#addModal3" onclick="fetch_courseupdate_new({{$data->course_id}},'edit')"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a> -->
                        <a class="btn btn-link" title="Edit"
                            href="{{ route('admin_course_edit', \Crypt::encrypt($data->course_id)) }}">
                            <i class="fas fa-pencil-alt" style="color:blue"></i></a>
                        <a class="btn btn-link" title="show"
                            href="{{ route('admin_course_show', \Crypt::encrypt($data->course_id)) }}">
                            <i class="fas fa-eye" style="color:green"></i></a>

                        <a type="button" title="Delete" onclick="course_delete(<?php echo $data->course_id ?>)"
                            class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></a>
                        @if($showHandleButton)
                        <a class="btn btn-link" title="Handle Expired Course"
                            onclick="handleExpiredCourse({{ $data->course_id }})">
                            <i class="fas fa-exclamation-circle" style="color:orange"></i>
                        </a>
                        @elseif($showReplacedMessage)
                        <a class="btn btn-link" title="Course Replaced"
                            onclick="showReplacementMessage({{ $data->course_id }})">
                            <i class="fas fa-info-circle" style="color:gray"></i>
                        </a>
                        @endif



                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No courses found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function showAddCourseModal() {

    $('#expired_course_id').val('');
    $('#certificateFields').hide();
    $('#expiryDateField').hide();
    $('#addCourseModal').modal('show');
}

function handleExpiredCourse(course_id) {
    Swal.fire({
        title: 'Expired Certificate Course Detected',
        icon: 'warning',
        html: `
            <ul style="text-align: left;">
                <li>If content changes annually, <b>create a new course</b>.</li>
                <li>If the same content is reused, <b>Copy & reassign the existing course for maintaining existing data</b>.</li>
            </ul>
        `,
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Create New Course',
        denyButtonText: `Copy & Reassign Existing`,
        cancelButtonText: 'Close',
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to create course page with expired course ID as parameter
            window.location.href = "{{ route('admin.course.create') }}?expired_course_id=" + course_id;
        } else if (result.isDenied) {
            // Redirect to reassign logic
            Swal.fire({
                title: "Copy Course Options",
                html: `
                    <div style="text-align: left;">
                        <label style="margin-bottom: 6px;">Certificate Expiry: <span style="color:red">*</span></label><br>
                        <input type="radio" class="btn-check" name="certificate_expiry" value="1"
                            id="certificate_expiryyes" autocomplete="off">
                        <label class="btn btn-outline-primary mb-2" for="certificate_expiryyes">Yes</label>
                        <input type="radio" class="btn-check" name="certificate_expiry" value="2"
                            id="certificate_expiryno" autocomplete="off">
                        <label class="btn btn-outline-primary mb-2" for="certificate_expiryno">No</label>
                        <div id="expiry_date_container" style="display:none; margin-top:10px;">
                            <label for="expiry_date">Expiry Date: <span style="color:red">*</span></label>
                            <input type="date" id="expiry_date" class="swal2-input" style="width: 100%;" />
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Copy Course',
                cancelButtonText: 'Cancel',
                didOpen: () => {
                    const dateContainer = document.getElementById('expiry_date_container');
                    document.querySelectorAll('input[name="certificate_expiry"]').forEach((
                        radio) => {
                        radio.addEventListener('change', function() {
                            if (this.value === "1") {
                                dateContainer.style.display = 'block';
                            } else {
                                dateContainer.style.display = 'none';
                                document.getElementById('expiry_date').value = '';
                            }
                        });
                    });
                },
                preConfirm: () => {
                    const selected = document.querySelector(
                        'input[name="certificate_expiry"]:checked');
                    const expiryDate = document.getElementById('expiry_date').value;

                    if (!selected) {
                        Swal.showValidationMessage(
                            "Please select 'Yes' or 'No' for Certificate Expiry");
                        return false;
                    }

                    if (selected.value === "1" && !expiryDate) {
                        Swal.showValidationMessage(
                            "Please enter an expiry date when 'Yes' is selected");
                        return false;
                    }

                    return {
                        certificate_expiry: selected.value,
                        course_expiry_period: selected.value === "1" ? expiryDate : null
                    };
                }
            }).then((result) => {
                if (!result.isConfirmed) return;

                const formData = result.value;

                $.ajax({
                    url: "{{ route('course_copy') }}",
                    type: 'POST',
                    data: {
                        course_id: course_id,
                        certificate_expiry: formData.certificate_expiry,
                        course_expiry_period: formData.course_expiry_period,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.data == 0) {
                            Swal.fire("Info", data.message_cus, "info");
                        } else {
                            Swal.fire("Success", "Course copied successfully!", "success")
                                .then(() => {
                                    location.href = `/admincourse`;
                                });
                        }
                    },
                    error: function() {
                        Swal.fire("Error", "Something went wrong", "error");
                    }
                });
            });
        }
    });
}
</script>