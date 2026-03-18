@extends('layouts.adminnav')

@section('content')

<head>

</head>
<style type="text/css">
    .dt-buttons.btn-group {
        display: none !important;
    }

    .mystyle {
        border: 2px solid red;
    }
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>

<div class="main-content" style="padding-left: 220PX;">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin-left:1rem">
                        <div class="card-body">

                            <h5>Filter the Details <i class="fas fa-filter"></i></h5>
                            <div class="container">
                                <form id="searchForm" class="row g-3 align-items-end">

                                    <div class="col-md-4">
                                        <label for="role_id" class="form-label">Role</label>
                                        <select id="role_id" class="form-control" onchange="filterDesignations()">
                                            <option value="">--- Select Role ---</option>
                                            @foreach($rows['roles'] as $role)
                                            <option value="{{ $role['role_id'] }}">{{ $role['role_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="designation_id" class="form-label">Designation</label>
                                        <select id="designation_id" class="form-control" onchange="filterUsers()">
                                            <option value="">--- Select Designation ---</option>
                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="user_id" class="form-label">Users</label>
                                        <select id="user_id" class="form-control">
                                            <option value="">--- Select Users ---</option>
                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="course_id" class="form-label">Course</label>
                                        <select id="course_id" class="form-control">
                                            <option value="">--- Select Course ---</option>
                                            @foreach($rows['courses'] as $course)
                                            <option value="{{ $course['course_id'] }}">{{ $course['course_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="from_date" class="form-label">From Date</label>
                                        <input type="date" class="form-control" id="from_date">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="to_date" class="form-label">To Date</label>
                                        <input type="date" class="form-control" id="to_date">
                                    </div>

                                    <div class="col-12 text-center mt-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-search"></i> Search Details
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row pt-3" id="usersTableContainer" style="display: none;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 style="color:black; text-align: center;">Users List</h4>

                            <div class="mb-3 text-left">
                                <button id="exportExcel" class="btn btn-success">Excel</button>
                                <button id="exportPDF" class="btn btn-success">PDF</button>
                            </div>

                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="align1">
                                        <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>User Name</th>
                                                <th>Course Name</th>
                                                <th>From Date</th>
                                                <th>End Date</th>
                                                <th>Percentage</th>
                                                <th>Hours</th>
                                            </tr>
                                        </thead>
                                        <tbody id="attendanceTableBody"></tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>

<script>
    var allDesignations = @json($rows['designation']);
    var allUsers = @json($rows['users']);
    var allCourses = @json($rows['courses']);
    var allValues = @json($rows['values']);
    console.log(allValues);

    function filterDesignations(selectedDesignation = '') {
        const roleId = $('#role_id').val();
        const designationSelect = $('#designation_id');
        const userSelect = $('#user_id');

        designationSelect.html('<option value="">--- Select Designation ---</option>');
        userSelect.html('<option value="">--- Select Users ---</option>');

        if (roleId) {
            allDesignations
                .filter(d => d.role_id == roleId)
                .forEach(d => designationSelect.append(`<option value="${d.designation_id}">${d.designation_name}</option>`));
        }

        if (selectedDesignation) {
            $('#designation_id').val(selectedDesignation);
            filterUsers();
        }
    }


    function filterUsers(selectedUser = '') {
        const designationId = $('#designation_id').val();
        const userSelect = $('#user_id');

        userSelect.html('<option value="">--- Select Users ---</option>');

        if (designationId) {
            allUsers
                .filter(u => u.designation_id == designationId)
                .forEach(u => userSelect.append(`<option value="${u.id}">${u.name}</option>`));
        }

        if (selectedUser) {
            $('#user_id').val(selectedUser);
        }
    }

    $('#from_date').on('change', function() {
        const fromDate = $(this).val();
        const today = new Date().toISOString().split('T')[0];

        $('#to_date').attr('min', fromDate);
        $('#to_date').val('');
    });

    function formatHours(decimalHours) {
        if (decimalHours === null || decimalHours === undefined) return '';

        decimalHours = Math.abs(decimalHours); // remove negative sign

        const hours = Math.floor(decimalHours);
        const minutes = Math.round((decimalHours - hours) * 60);

        return hours + 'h ' + minutes + 'm';
    }

    function formatDateTime(dateStr) {

        if (!dateStr) return '';
        const date = new Date(dateStr + ' UTC');

        const istDate = new Date(
            date.toLocaleString("en-US", {
                timeZone: "Asia/Kolkata"
            })
        );

        const year = istDate.getFullYear();
        const month = String(istDate.getMonth() + 1).padStart(2, '0');
        const day = String(istDate.getDate()).padStart(2, '0');

        const hours = String(istDate.getHours()).padStart(2, '0');
        const minutes = String(istDate.getMinutes()).padStart(2, '0');
        const seconds = String(istDate.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    function calculateHours(start, end) {

        if (!start || !end) return '-';

        const startDate = new Date(start + ' UTC');
        const endDate = new Date(end + ' UTC');

        const diffMs = endDate - startDate;

        if (diffMs <= 0) return '-';

        const totalMinutes = Math.floor(diffMs / (1000 * 60));
        const hours = Math.floor(totalMinutes / 60);
        const minutes = totalMinutes % 60;

        return `${hours}h ${minutes}m`;
    }

    $('#searchForm').on('submit', function(e) {
        e.preventDefault();

        const roleId = $('#role_id').val();
        const designationId = $('#designation_id').val();
        const userId = $('#user_id').val();
        const courseId = $('#course_id').val();
        const fromDate = $('#from_date').val();
        const toDate = $('#to_date').val();

        if (!roleId && !designationId && !userId && !courseId && !fromDate && !toDate) {
            Swal.fire({
                icon: 'error',
                title: 'Please select atleast one filter to view datas',
                confirmButtonColor: '#7367f0',
                confirmButtonText: 'OK'
            });
            return;
        }

        let html = '';
        let sl = 1;

        for (let uId in allValues) {
            let userCourses = allValues[uId];

            if (userId && userId != uId) continue;

            let filteredCourses = {};
            for (let cId in userCourses) {
                if (courseId && courseId != cId) continue;

                const filteredRecords = userCourses[cId].filter(record => {
                    if (roleId && record.role_id != roleId) return false;
                    if (designationId && record.designation_id != designationId) return false;

                    const start = new Date(record.start_time);
                    const end = new Date(record.end_time);
                    if ((fromDate && start < new Date(fromDate)) || (toDate && end > new Date(toDate))) return false;

                    return true;
                });

                if (filteredRecords.length > 0) filteredCourses[cId] = filteredRecords;
            }

            let totalUserRows = Object.values(filteredCourses).reduce((a, b) => a + b.length, 0);
            if (totalUserRows === 0) continue;

            let firstUser = true;
            for (let cId in filteredCourses) {
                let courseRecords = filteredCourses[cId];
                let firstCourse = true;

                courseRecords.forEach(record => {
                    html += '<tr>';
                    if (firstUser) {
                        html += `<td rowspan="${totalUserRows}">${sl++}</td>`;
                        html += `<td rowspan="${totalUserRows}">${record.user_name}</td>`;
                        firstUser = false;
                    }
                    if (firstCourse) {
                        html += `<td rowspan="${courseRecords.length}">${record.course_name}</td>`;
                        firstCourse = false;
                    }
                    html += `<td>${formatDateTime(record.start_time)}</td>`;
                    html += `<td>${formatDateTime(record.end_time)}</td>`;
                    html += `<td>${(!record.percentage || record.percentage == 0) ? '-' : record.percentage}</td>`;
                    html += `<td>${calculateHours(record.start_time,record.end_time)}</td>`;
                    html += '</tr>';
                });
            }
        }

        if (html === '') {
            html = '<tr><td colspan="7" class="text-center">No data found</td></tr>';
        }

        $('#attendanceTableBody').html(html);
        $('#usersTableContainer').show();

        $('#role_id').val(roleId);
        filterDesignations(designationId);
        filterUsers(userId);
        $('#course_id').val(courseId);
        $('#from_date').val(fromDate);
        $('#to_date').val(toDate);

    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.0/jspdf.plugin.autotable.min.js"></script>


<script>
    $('#exportExcel').on('click', function() {
        let table = document.getElementById("align1");
        let wb = XLSX.utils.table_to_book(table, {
            sheet: "Attendance Tracking",
            raw: true
        });


        let ws = wb.Sheets["Attendance Tracking"];
        let range = XLSX.utils.decode_range(ws['!ref']);
        let colWidths = [];

        for (let C = range.s.c; C <= range.e.c; ++C) {
            let maxLen = 10;
            for (let R = range.s.r; R <= range.e.r; ++R) {
                let cellAddress = XLSX.utils.encode_cell({
                    r: R,
                    c: C
                });
                let cell = ws[cellAddress];
                if (cell && cell.v) {
                    let len = cell.v.toString().length;
                    if (len > maxLen) maxLen = len;
                }
            }
            colWidths.push({
                wch: maxLen + 2
            });
        }

        ws['!cols'] = colWidths;

        XLSX.writeFile(wb, "Attendance Tracking.xlsx");
    });
    $('#exportPDF').on('click', function() {
        const doc = new window.jspdf.jsPDF('l', 'pt', 'a4');

        doc.setFontSize(14);

        const pageWidth = doc.internal.pageSize.getWidth();
        const title = "Attendance Tracking";
        const textWidth = doc.getTextWidth(title);
        const x = (pageWidth - textWidth) / 2;
        doc.text(title, x, 40);
        doc.autoTable({
            html: '#align1',
            startY: 60,
            theme: 'grid',
            styles: {
                fontSize: 10,
                cellPadding: 5
            },
            headStyles: {
                fillColor: [22, 160, 133]
            }
        });

        doc.save("Attendance Tracking.pdf");
    });
</script>

@endsection