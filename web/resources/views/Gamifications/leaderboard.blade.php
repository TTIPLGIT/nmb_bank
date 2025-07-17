@extends('layouts.adminnav')

@section('content')
<style>
    #main-content {
        background: linear-gradient(to right, #000428, #004e92);
        padding: 2rem 0;
        color: white;
        margin-left: 10px;
        margin-right: 30px;
    }

    .leaderboard-title {
        text-align: center;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 2rem;
        color: #ffffff;
    }

    .podium {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .podium-card {
        position: relative;
        width: 200px;
        /* Or your card width */
        padding: 1rem;
        background: #1a1a2e;
        border-radius: 15px;
        text-align: center;
        color: white;
    }

    .podium-card img {
        width: 80px;
        height: 80px;
        border-radius: 50px;
        border: 3px solid #ffffff;
        margin-bottom: 0.5rem;
    }

    .crown-img {
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
        background-color: rgba(255, 255, 255, 0.05);

    }

    .leaderboard-table tr:hover {

        background: linear-gradient(to right, #000428, #004e92);
        color: black;
        cursor: pointer;
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
        background-color: rgba(255, 255, 255, 0.05);
    }

    .badge-rank {
        position: absolute;
        top: 1px;
        left: 1px;
        background-color: #007bff;
        color: white;
        font-weight: bold;
        width: 32px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;

    }
</style>

</style>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div id="main-content">
                <div class="leaderboard-title">Leaderboard</div>

                <div class="podium">
                    <div class="podium-card second position-relative">
                        <div class="badge-rank">2</div>

                        <img src="/images/leaderboard/rank 2.jpg" alt="Participant" />
                        <h6>Sri</h6>
                        <span class="time-label">1120</span>
                    </div>


                    <div class="podium-card first position-relative"
                        style="cursor: pointer;"
                        data-toggle="modal"
                        data-target="#addModal4">
                        <div class="badge-rank">1</div>
                        <img src="/images/leaderboard/crown.png" alt="Crown" class="crown-img">
                        <img src="/images/leaderboard/rank 1.jpg">
                        <h6>Veera</h6>
                        <span class="time-label">1200</span>
                    </div>



                    <div class="podium-card third position-relative">
                        <!-- <div class="position-badge">
                            <img src="/images/leaderboard/1.png" alt="Medal" />
                        </div> -->
                        <div class="badge-rank">3</div>
                        <img src="/images/leaderboard/rank 3.jpg">
                        <h6>Tharun</h6>
                        <span class="time-label">890</span>
                    </div>
                </div>


                <div class="table-wrapper">
                    <table class="leaderboard-table">

                        <tr>
                            <th class="col-2">Rank</th>
                            <th class="col-8">Name</th>
                            <th class="col-2">Points</th>
                        </tr>

                        <tr>
                            <th class="col-2">5</th>
                            <th class="col-8">YASHWANTH</th>
                            <th class="col-2">8349</th>
                        </tr>
                        <tr>
                            <th class="col-2">6</th>
                            <th class="col-8">YAS</th>
                            <th class="col-2">849</th>
                        </tr>
                        <tr>
                            <th class="col-2">7</th>
                            <th class="col-8">WANTH</th>
                            <th class="col-2">8349</th>
                        </tr>


                    </table>
                </div>

            </div>
        </div>
    </section>
</div>

</section>
</div>
<!-- Bootstrap 5 CSS (optional, if not already included) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS Bundle (required for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button>

<!-- Modal -->


<div class="modal fade" id="addModal4">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="card-body">

                <button type="button" style="color:red;padding:20px" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                @csrf
                <input type="hidden" id="user_id" name="user_id">
                <h4 style="color:black;text-align:center;margin-bottom:20px" id="sub_title_name">User Details</h4>


                <div class="col-12 mb-5 d-flex justify-content-center gap-2">
                    <a class="btn btn-danger" style="color:white;" href="{{ route('leaderboard') }}">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection