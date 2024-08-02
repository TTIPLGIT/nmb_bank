@extends('layouts.adminnav')
@section('content')
<style>
  * {
    margin: 0;
    padding: 0;
  }


  .container {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #eee;
  }



  .icons-spin {
    /* position:absolute; */
    /* top:-100px; */
    color: #000;
    animation: anim 1s forwards;
  }

  @keyframes anim {
    0% {
      top: 0px;
      transform: rotate(0deg);
    }

    20% {
      top: -10px;
      color: #000;
    }

    50% {
      top: -48px;

    }

    60% {
      top: -30px;
    }

    100% {
      transform: rotate(360deg);
      top: 20px;
      color: yellow;
    }
  }

  .icons-spin1 {
    /* position:absolute; */
    /* top:-100px; */
    color: #000;
    animation: anim 1s forwards;
  }

  @keyframes anim {
    0% {
      top: 0px;
      transform: rotate(0deg);
    }

    20% {
      top: -10px;
      color: #000;
    }

    50% {
      top: -48px;

    }

    60% {
      top: -30px;
    }

    100% {
      transform: rotate(360deg);
      top: 20px;
      color: yellow;
    }
  }

  input[type=checkbox] {
    display: inline-block;
  }

  .no-arrow {
    -moz-appearance: textfield;
  }

  .no-arrow::-webkit-inner-spin-button {
    display: none;
  }

  .no-arrow::-webkit-outer-spin-button,
  .no-arrow::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .nav-tabs {
    background-color: #0068a7 !important;
    border-radius: 29px !important;
    padding: 1px !important;

  }

  .nav-item.active {
    background-image: linear-gradient(to right, #2a675a, #2a675a, #2a675a, #2a675a, #2a675a);
    border-radius: 31px !important;
    height: 100% !important;
  }

  .nav-link.active {
    background-image: linear-gradient(to right, #2a675a, #2a675a, #2a675a, #2a675a, #2a675a);
    border-radius: 31px !important;
    height: 100% !important;
  }

  :root {
    --borderWidth: 5px;
    --height: 24px;
    --width: 12px;
    --borderColor: #78b13f;
  }




  .nav-justified {
    display: flex !important;
    align-items: center !important;
  }

  .gender {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
  }

  .egc {
    display: flex;
    border: 1px solid #350756;
    padding: 8px 25px 8px 8px;
    align-items: center;

    justify-content: space-between;
  }

  .dq {
    font-size: 16px;
    width: 80%;
    font-weight: 600;
  }

  .answer {
    width: 15%;
    display: flex;
    color: #04092e !important;
    justify-content: space-around;
  }

  .questions {
    color: #000c62 !important
  }

  input[type='radio']:checked:after {
    background-color: #34395e !important;
  }

  input[type='radio']:after {
    background-color: #34395e !important;
  }

  /* radiocss */
  .switch-field {
    display: flex;


  }

  .switch-field input {
    position: absolute !important;
    clip: rect(0, 0, 0, 0);
    height: 1px;
    width: 1px;
    border: 0;
    overflow: hidden;
  }

  .switch-field label {
    background-color: #e4e4e4;
    color: rgba(0, 0, 0, 0.6);
    font-size: 14px;
    line-height: 1;
    text-align: center;
    padding: 8px 16px;
    margin-right: -1px;
    border: 1px solid rgba(0, 0, 0, 0.2);
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
    transition: all 0.1s ease-in-out;
  }

  .switch-field label:hover {
    cursor: pointer;
  }

  .switch-field input:checked+label {
    background-color: #a5dc86;
    box-shadow: none;
  }

  .switch-field label:first-of-type {
    border-radius: 4px 0 0 4px;
  }

  .switch-field label:last-of-type {
    border-radius: 0 4px 4px 0;
  }

  /* endcss */
  .vl {
    border-left: 1px solid #350756;
    height: 40px;
  }

  .close {
    color: red;
    opacity: 1;
  }

  .close:hover {

    color: red;

  }

  a:hover,
  a:focus {
    text-decoration: none;
    outline: none;
  }

  .danger {
    background-color: #ffdddd;
    border-left: 6px solid #f44336;
  }

  #align {
    border-collapse: collapse !important;
  }

  table.dataTable.no-footer {
    border-bottom: .5px solid #002266 !important;
  }

  thead th {
    height: 5px;
    border-bottom: solid 1px #ddd;
    font-weight: bold;
  }

  .fa fa-star {
    transition: all 5s ease;
  }
</style>

<div class="main-content">
  @if (session('success'))

  <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data').val();
      swal({
        title: "Success",
        text: message,
        type: "success",
      });

    }
  </script>
  @elseif(session('error'))

  <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data1').val();
      swal({
        title: "Info",
        text: message,
        type: "info",
      });

    }
  </script>
  @endif

  <section class="section">
    @if(strpos($screen_permission['permissions'], 'Create') !== false)


    <div class="d-flex flex-row justify-content-between">
      <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" data-toggle="modal" data-target="#addeligModal"><i class="fa fa-star" style="color: yellow;"></i> Rate a Valuer</a>
    </div>
    @endif

    <div class="section-body mt-2">
      <style>
        .section {
          margin-top: 20px;
        }
      </style>
      <div class="row">

        <div class="col-12">

          <div class="mt-0">

            <div class="card-body" id="card_header">
              <div class="row">

                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">List of Valuers Ratings</h4>
                </div>
              </div>
              @if (session('success'))

              <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
              <script type="text/javascript">
                window.onload = function() {
                  var message = $('#session_data').val();
                  swal({
                    title: "Success",
                    text: message,
                    type: "success",
                  });

                }
              </script>
              @elseif(session('error'))

              <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
              <script type="text/javascript">
                window.onload = function() {
                  var message = $('#session_data1').val();
                  swal({
                    title: "Info",
                    text: message,
                    type: "info",
                  });

                }
              </script>
              @endif



              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>Valuator ID</th>
                        <th>Valuator Name</th>
                        <th>Address</th>
                        <th>Ratings</th>
                        <th>Action</th>

                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows['rows1'] as $data)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data['valuer_code']}}</td>
                        <td>{{$data['name']}}</td>
                        <td>{{$data['Address_line1']}}</td>
                        <td>
                          @for($i=1;$i<=$data['count'];$i++) <i class="fa fa-star" style="color:yellow;font-size:20px;"></i>
                            @endfor
                            @for($i=1;$i<=5-$data['count'];$i++) <i style="font-size:20px;color:darkgrey" class="fa fa-star"></i>
                              @endfor
                        </td>
                        <td>
                          <a class="btn btn-link" title="show" href=""><i class="fas fa-eye" style="color:green"></i></a>
                        </td>
                      </tr>
                      <input type="hidden" id="count" value="{{$data['count']}}">
                      @endforeach
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>
<div class="modal fade" id="addeligModal" style="height:100% !important">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <form action="{{ route('ratings_create') }}" method="POST" id="create_form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-header mh">
          <h4 class="modal-title">Give a Ratting</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body" style=" background-color: #f8fffb;">
          <div class="row" style="display:flex; align-items: self-end;">
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Users</label>
                <select name="user_id" id="user_id" class="form-control">
                  <option value="">Select User</option>

                  @foreach($rows['rows'] as $key=>$row)

                  <option value="{{ $row['id'] }}">{{$row['name']}} ({{$row['valuer_code']}})</option>

                  @endforeach

                </select>
              </div>
            </div>
          </div>
          <div id="icons" class="row icons" style="font-size:-webkit-xxx-large; visibility:hidden;">
            <div class="row">
              <h4>Rattings*</h4>
            </div>
            <i id="starone" style="color:lightgrey;" class="fa fa-star"></i>
            <i id="startwo" style="color:lightgrey;" class="fa fa-star startwo"></i>
            <i id="starthree" style="color:lightgrey;" class="fa fa-star"></i>
            <i id="starfour" style="color:lightgrey;" class="fa fa-star"></i>
            <i id="starfive" style="color:lightgrey;" class="fa fa-star"></i>
          </div>
          <input type="hidden" class="form-control" required id="user_details" name="user_details" value="eligibleq">
          <label style="font-size: 16px !important; color:DarkSlateBlue;">The Ratings are Based on The Answers you Give:<span class="error-star" style="color:red;">*</span></label>

          @foreach($rows['rating_question'] as $data)
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="egc">
                  <div class="dq"><span class="questions">{{$loop->iteration}}. {{$data['question']}}:</span></div>
                  <div class="vl"></div>
                  <div class="switch-field">
                    <input type="hidden" id="qid{{$loop->iteration}}" name="q[{{$loop->iteration}}][qid]" value="{{$data['id']}}">
                    <input type="radio" id="radio-one{{$loop->iteration}}" name="q[{{$loop->iteration}}][qans]" value="yes">
                    <label for="radio-one{{$loop->iteration}}">Yes</label>
                    <input type="radio" id="radio-two{{$loop->iteration}}" name="q[{{$loop->iteration}}][qans]" value="no" checked />
                    <label for="radio-two{{$loop->iteration}}">No</label>
                  </div>
                </div>
              </div>
            </div>
          </div>


          @endforeach


          <div class="row">
            <div class="col-lg-12 text-center">

              <button type="submit" class="btn btn-success btn-space" id="savebutton">Save</button>
              <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">


            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
<script type="text/javascript">
  let a = document.querySelectorAll("#radio-one1, #radio-two1").forEach((a) => {
    a.addEventListener("click", function(e) {
      let id = this.getAttribute('id');
      if (id == "radio-one1") {
        document.getElementById("icons").style.visibility = "visible";
        var element1 = document.querySelector("#starone");

        element1.classList.add("icons-spin");

      }
      if (id == "radio-two1") {

        var element11 = document.querySelector("#starone");
        element11.classList.remove("icons-spin");


      }
    });
  });
  let b = document.querySelectorAll("#radio-one2, #radio-two2").forEach((b) => {
    b.addEventListener("click", function(e) {
      let id = this.getAttribute('id');
      if (id == "radio-one2") {
        var element2 = document.querySelector("#startwo");
        element2.classList.add("icons-spin");

      }
      if (id == "radio-two2") {
        var element22 = document.querySelector("#startwo");
        element22.classList.remove("icons-spin");


      }
    });
  });
  let c = document.querySelectorAll("#radio-one3, #radio-two3").forEach((c) => {
    c.addEventListener("click", function(e) {
      let id = this.getAttribute('id');
      if (id == "radio-one3") {
        var element3 = document.querySelector("#starthree");
        element3.classList.add("icons-spin");

      }
      if (id == "radio-two3") {

        var element33 = document.querySelector("#starthree");
        element33.classList.remove("icons-spin");


      }
    });
  });
  let d = document.querySelectorAll("#radio-one4, #radio-two4").forEach((d) => {
    d.addEventListener("click", function(e) {
      let id = this.getAttribute('id');
      if (id == "radio-one4") {
        var element4 = document.querySelector("#starfour");
        element4.classList.add("icons-spin");

      }
      if (id == "radio-two4") {
        var element44 = document.querySelector("#starfour");
        element44.classList.remove("icons-spin");


      }
    });
  });
  let e = document.querySelectorAll("#radio-one5, #radio-two5").forEach((e) => {
    e.addEventListener("click", function(e) {
      let id = this.getAttribute('id');
      if (id == "radio-one5") {
        var element5 = document.querySelector("#starfive");

        element5.classList.add("icons-spin");

      }
      if (id == "radio-two5") {

        var element55 = document.querySelector("#starfive");
        element55.classList.remove("icons-spin");


      }
    });
  });
</script>
@endsection