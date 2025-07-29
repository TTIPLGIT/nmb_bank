@extends('layouts.adminnav')

@section('content')
<style>
    .main-content {
        background: linear-gradient(to right, #000428, #004e92);
        color: BLACK;

    }

    .leaderboard-title {
        text-align: center;
        font-size: 2rem;
        font-weight: bold;
        color: white;
    }

    .podium {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 1.5rem;
        margin-bottom: 3rem;
        margin-top: 50px;
    }

    .user {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 1.5rem;
        margin-bottom: 3rem;
        margin-top: 50px;
        margin-right: 120px;
        margin-left: 20px;
    }


    .podium-card {
        background-color: #1a1a2e;
        padding: 1rem;
        border-radius: 20px;
        width: 180px;
        position: relative;
        color: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s;
    }

    .podium-card img {
        width: 80px;
        height: 80px;
        border-radius: 50px;
        border: 3px solid #ffffff;
        margin-bottom: 0.5rem;
    }

    .profile-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        margin-bottom: 0.5rem;
    }

    .crown {
        position: absolute;
        top: -65px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        z-index: 2;
        border-radius: 0 !important;
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    .position-badge {
        position: absolute;
        top: 0;
        left: 0;
        background: white;
        padding: 5px;
        border-bottom-right-radius: 10px;
    }

    .podium-card h6 {
        margin: 0.5rem 0 0.2rem;
        font-weight: 600;
    }

    .score {
        font-size: 14px;
        color: #ccc;
    }

    .position-badge img {
        width: 48px;
        height: 70px;
        background-color: transparent;
    }

    .first {
        height: 280px;
        top: 30px;
    }

    .second {
        height: 250px;
        top: 30px;
    }

    .third {
        height: 220px;
        top: 30px;
    }

    .userscard {
        height: 220px;
        position: absolute;
        top: 260px;
        margin-right: 40px;
        margin-left: 4px;
        border: 5px solid rgba(255, 215, 0, 0.6);
        border-radius: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }


    .podium-card h6 {
        margin-top: 0.5rem;
        color: #ffffff;
        font-size: 1rem;
    }



    .table-wrapper {
        background-color: #0c0c1f;
        border-radius: 1rem;
        padding: 1rem;
        max-width: 900px;
        margin: auto;
    }

    table.leaderboard-table {
        width: 100%;
        color: transparent;
        border-collapse: collapse;
    }

    table.leaderboard-table th {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #444;
    }

    table.leaderboard-table th {
        color: white;

    }

    table.leaderboard-table td {
        color: white;
    }

    .rank-icon {
        width: 20px;
    }

    .podium-card {
        transition: all 0.2s ease;
    }


    .podium-card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
        background: linear-gradient(to right, #000428, #004e92);
    }


    .leaderboard-table tr:hover {

        background: linear-gradient(to right, #000428, #004e92);
        color: black;
        cursor: pointer;
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
        background-color: rgba(255, 255, 255, 0.05);
    }


    .rank-badge {
        position: absolute;
        bottom: 10px;
        right: 50px;
        color: white;
        font-weight: bold;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 0 !important;
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }


    .custom-gap {
        gap: 1rem;
    }

    .modal-content {
        background-color: #004e92;
    }

    .dropdown-wrapper {

        color: white;

    }

    .dropdown-wrapper .form-label {
        color: #fff;
        font-weight: 600;
    }

    .form-select {
        /* background-color: #1e2a38; */
        color: #fff;
        padding: 8px 15px;
    }

    .gif-overlay {
        position: fixed;
        top: 50%;
        left: 60%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        pointer-events: none;
    }

    .gif-overlay img {
        width: 1200px;
        height: 539px;

    }

    .btn-active {
        background-color: #0d6efd !important;

        color: white !important;
        border-color: #0d6efd !important;
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div id="main-content">
                <div class="d-flex justify-content-center">
                    <div class="leaderboard-title d-flex align-items-center gap-2">
                        <img src="/images/leaderboard/leaderboard.png" style="height: 40px; width: 40px; margin-right:10px " alt="Crown" />
                        <span style="font-size: 28px; font-weight: bold; color: white;">Leaderboard</span>
                    </div>
                </div>
                <div class="container dropdown-wrapper">

                    <div class="card p-3" style="border: none;">

                        <div class="d-flex justify-content-end align-items-center flex-wrap gap-3 mt-3">


                            <button class="btn bg-white text-dark d-flex align-items-center" style="margin-right:10px;padding:10px"
                                data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-filter me-2"></i>
                            </button>


                            <div class="btn-group" role="group">
                                <button class="btn bg-white text-dark filter-btn" data-filter="ALL" style="margin-right:10px">ALL</button>
                                <button class="btn bg-white text-dark filter-btn" data-filter="WEEKLY" style="margin-right:10px">WEEKLY</button>
                                <button class="btn bg-white text-dark filter-btn" data-filter="MONTHLY">MONTHLY</button>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="row d-flex justify-content-center   ">



                    @if(session('show_gif'))
                    <div class="gif-overlay">
                        <img src="{{ asset('images/leaderboard/Celebrate.gif') }}" alt="Celebration" />
                    </div>

                    <script>
                        setTimeout(() => {
                            document.querySelector('.gif-overlay').style.display = 'none';
                        }, 3000);
                    </script>
                    @endif

                    @if(isset($currentUserRank) && session('role_type') !== 'Admin')
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 podium-card userscard text-center float-start"
                                style="cursor: pointer;"
                                data-toggle="modal"
                                data-target="#addModal4"
                                onclick="fetch_show({{ $user_id }}, 'show')">

                                <img src="/images/leaderboard/rank 2.jpg" alt="{{ $currentUserRank['name'] }}" class="profile-img" />

                                <div class="mt-3  fw-bold">
                                    🎉 Congratulations <span class="text-success">{{ $currentUserRank['name'] }}</span><br>
                                    You are ranked <span class="text-success">#{{ $currentUserRank['rank'] }}</span> with <span class="text-danger">{{ $currentUserRank['points'] }} pts</span>!
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif




                    <div class="podium d-flex justify-content-center">

                        @if(isset($rows['top3'][1]))
                        <div class="podium-card second position-relative text-center"
                            style="cursor: pointer; margin-left:4px"
                            data-toggle="modal"
                            data-target="#addModal4"
                            onclick="fetch_show({{ $user_id }}, 'show')">

                            <img src="/images/leaderboard/rank 2.jpg" alt="{{ $rows['top3'][1]->name }}" class="profile-img" />
                            <h6>{{ $rows['top3'][1]->name }}</h6>
                            <span class="score">{{ $rows['top3'][1]->total_points }}</span>
                            <img src="/images/leaderboard/2nd.png" alt="2nd" style="margin-bottom:-15px" class="rank-badge" />
                        </div>
                        @endif

                        @if(isset($rows['top3'][0]))
                        <div class="podium-card first position-relative text-center"
                            style="cursor: pointer;"
                            data-toggle="modal"
                            data-target="#addModal4"
                            onclick="fetch_show({{ $user_id }}, 'show')">

                            <img src="/images/leaderboard/crown.png" alt="Crown" class="crown" />
                            <img src="/images/leaderboard/rank 1.jpg" alt="{{ $rows['top3'][0]->name }}" class="profile-img" />
                            <h6>{{ $rows['top3'][0]->name }}</h6>
                            <span class="score">{{ $rows['top3'][0]->total_points }}</span>
                            <img src="/images/leaderboard/1st.png" alt="1st" class="rank-badge" />
                        </div>
                        @endif

                        @if(isset($rows['top3'][2]))
                        <div class="podium-card third position-relative text-center"
                            style="cursor: pointer;"
                            data-toggle="modal"
                            data-target="#addModal4"
                            onclick="fetch_show({{ $user_id }}, 'show')">

                            <img src="/images/leaderboard/rank 3.jpg" alt="{{ $rows['top3'][2]->name }}" class="profile-img" />
                            <h6>{{ $rows['top3'][2]->name }}</h6>
                            <span class="score">{{ $rows['top3'][2]->total_points }}</span>
                            <img src="/images/leaderboard/3rd.png" alt="3rd" style="margin-bottom:-15px" class="rank-badge" />
                        </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="table-wrapper">
                <table class="leaderboard-table">
                    <tr>
                        <th class="col-2">Rank</th>
                        <th class="col-8">Name</th>
                        <th class="col-2">Points</th>
                    </tr>

                    @foreach($rows['leaderboard']->skip(3) as $key => $value)
                    <tr>
                        <th>{{ $key + 4 }}</th>
                        <th>{{ $value->name }}</th>
                        <th>{{ $value->total_points }}</th>
                    </tr>
                    @endforeach
                </table>
            </div>

        </div>
</div>
</section>
</div>

</section>
</div>
<!-- Bootstrap 5 CSS (optional, if not already included) -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<!-- Bootstrap 5 JS Bundle (required for modal functionality) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->





<!-- Modal -->



<!-- filter modal -->


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content  border-0 p-4">

            <div class="card-body position-relative">


                <button type="button" style="color:red;  font-size: 24px;padding:20px; " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <form id="courseForm" method="GET" action="{{ route('leaderboard.filter') }}">


                    @csrf

                    <div class="row g-4 justify-content-center">
                        <div class="col-md-10">
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label fw-bold">Role:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="role" id="role_id"
                                        onchange="filterDesignations()">
                                        <option value="">---Select Role---</option>
                                        @foreach($rows['role'] as $values)
                                        <option value="{{ $values->role_id }}">{{ $values->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label fw-bold">Designation:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="designation" id="designation_id">
                                        <option value="">---Select Designation---</option>
                                        @foreach( $rows['designation'] as $values)

                                        <option value="{{ $values->designation_id }}">{{ $values->designation_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label fw-bold">Course:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="course_catagory" id="course_category_id" onchange="category()">
                                        <option value="">---Select Category---</option>
                                        @foreach( $rows['elearning_courses'] as $data)
                                        <option value="{{ $data->course_id }}">{{ $data->course_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="d-flex justify-content-center align-items-center gap-4 mt-4 mb-4" id="filterbuttons">
                                <button type="button" id="pointsbutton" class="btn border border-dark rounded-3 px-4 py-2 bg-white text-dark mr-4" style="display: none;">
                                    Points
                                </button>
                                <button type="button" id="hoursbutton" class="btn border border-dark rounded-3 px-4 py-2 bg-white text-dark" style="display: none;">
                                    Hours
                                </button>
                            </div>




                            <div class="modal-footer  border-top-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clearForm()">Clear</button>

                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<script>
    function fetch_show(user_id, type) {
        $.ajax({
            url: "{{ url('/level_show') }}",
            type: 'GET',


            data: {
                'user_id': user_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {

            }

        });
    }
</script>
<script>
    function category() {
        var selectedValue = document.getElementById('course_category_id').value;
        var pointsbuttons = document.getElementById('pointsbutton');
        var hoursbuttons = document.getElementById('hoursbutton');

        if (selectedValue !== "") {
            pointsbuttons.style.display = 'flex';
            hoursbuttons.style.display = 'flex';
        } else {
            buttonsDiv.style.display = 'none';
        }


    }

    function clearForm() {
        document.getElementById("courseForm").reset();

        document.getElementById("filterbuttons").style.display = 'none';
    }
    document.getElementById('pointsbutton').addEventListener('click', function() {
        this.classList.add('btn-active');
        document.getElementById('hoursbutton').classList.remove('btn-active');
    });

    document.getElementById('hoursbutton').addEventListener('click', function() {
        this.classList.add('btn-active');
        document.getElementById('pointsbutton').classList.remove('btn-active');
    }); 
</script>

<script>
    var allDesignations = @json($rows['designation']);

    function filterDesignations() {
        const roleId = document.getElementById('role_id').value;
        const designationSelect = document.getElementById('designation_id');

        designationSelect.innerHTML = ' <option value="">---Select Designation---</option>';

        const filteredDesignations = allDesignations.filter(d => d.role_id == roleId);

        filteredDesignations.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d.designation_id;
            opt.textContent = d.designation_name;
            designationSelect.appendChild(opt);
        });
    }
</script>

@endsection