<!DOCTYPE html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



@extends('layouts.adminnav')

@section('content')
<head>
  <link href="{{ asset('assets/css/mediaquery.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
  .bgimg1 {
    background: #c7c4ff;
    width: 100% !important;
    max-width: 100% !important;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
    height: 83vh;
  }

  .form-signin .btn {
    font-size: 80%;
    border-radius: 8px;
    letter-spacing: .1rem;
    font-weight: bold;
    padding: 8px;
    transition: all 0.2s;
    width: 100% !important;
  }

  .error {
    color: red;
  }

  .header {
    height: 110px;
    width: 100%;
    margin-left: 0px !important;
    background: #26268d !important;
  }

  .footer {
    background: #26268d !important;
  }

  .text-line {
    background-color: white;
    color: #eeeeee;
    outline: none;
    outline-style: none;
    outline-offset: 0;
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom: solid #d9d9d9 1px;
    padding: 3px 10px;
  }
 
.dropdown-container
{
  width: 35px !important;
  overflow-y: inherit !important;
}

  h1 {
    float: left !important;
    font-weight: 300 !important;
    text-decoration: underline !important;
    font: 20px Arial, sans-serif !important;
    padding: 15px 15px !important;
  }

  u {

    text-decoration: underline 4px solid !important;
    text-decoration-color: orange !important;
    text-underline-position: under !important;
  }


  p {
    font-size: 12px !important;
    color: black !important;
    font-weight: 500 !important;
  }

  #question {
    font-size: 15px !important;
    color: black !important;
    font-weight: 500 !important;


  }

  #answer {
    font-size: 15px !important;
    color: #737373 !important;
    padding: 0px 65px;
  }

  html,
  body {
    background-color: #f2f2f2 !important;
  }


  .collapsible {
    background-color: white;
    color: black;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none !important;
    font-size: 15px;
  }

  .active,
  .collapsible:hover {
    background-color: white;
  }


  .content {
    padding: 0 18px;
    display: none;
    overflow: hidden;
    color: black;
    background-color: white;
  }

  .main-content {
    min-height: 487px !important;
  }

  th {
    color: #602e9e !important;
    background-color: white !important;
    border-color: white !important;
  }

  table,
  td {
    border-color: white !important;

  }

  /* .sorting_asc{
   display:none !important;
} */

  .faqsearch {
    color: black !important;
  }

  #name {
    font-size: 18px !important;
  }


  #q_faq {
    padding: 0px 30px !important;
  }

  #a_faq {
    padding: 0px 40px !important;
    color: #666666 !important;
  }

  #m_faq {
    font-size: 18px !important;
    font-weight: 800 !important;
  }

  .fixed-header {
    width: 100%;
    background: #602e9e !important;
    padding: 10px 0;
    color: #fff !important;
  }

  .fixed-header {
    top: 0;
  }

  #footer {
    color: white !important;
    position: fixed;
    padding: 10px 10px 0px 10px;
    bottom: 0;
    width: 100%;
    /* Height of the footer*/
    height: 40px;
    background: #602e9e !important;
  }

  .container {
    width: 80%;
    margin: 0 auto;
    /* Center the DIV horizontally */
  }

  nav a {
    color: #fff;
    text-decoration: none;
    padding: 7px 25px !important;
    display: inline-block;
  }


  h2,
  h5 {
    font-size: 22px !important;
    text-align: center !important;
  }

  #box {
    border-color: #602e9e !important;
  }

  .col-lg-3 {
    margin-bottom: 0px !important;
  }

  .navigation .inner-navigation li .menu-link.circle {
    line-height: 2.8em !important;
    padding: 14px 18px;
    border-radius: 50%;
  }

  .containernew {
    padding-left: 0px !important;
  }

  .navbar {
   
    padding: 0px !important;
  }

  .index {
    position: absolute;
    z-index: 0 !important;
    
  }
  .bg-light{
    background-color: #f8f9fa !important;
  }



</style>
</head>



<nav class="navbar index bg-light" style="border:2px solid #602e9e !important; margin-top: 48px; height:max-content;position:absolute">
  <div class="col-md-4" style="
    margin: 0;
    padding: 0;
"><img class="img-fluid" style="width: 85%;" src="{{ asset('images/faq.png') }}"></div>


  <div class="col-lg-4">



    <h2><b style="font-size: 18px;">What do you need help with ?</b></h2>
    <div class="input-group">
      <input type="search" class="form-control rounded" id="module_name" name="module_name" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
      <button type="button" onclick="searchIt()" style="background: #ffc002 !important; color:black !important;font-weight: bold;" class="btn btn-primary"><i class="fa fa-fw  fa-search"></i></button>
    </div>



  </div>


  <div class="col-lg-4">



  </div>
  <!-- <div class="col-lg-2" >

    <a type="button" href="{{url('https://www.bimacc.org/')}}"  style=" font-size:18px !important; padding:15px !important; text-align:center !important;  color: #602e9e !important; border-radius:25px;"   title="Bimacc-official link"><i class="fas fa-home"></i><b>Home</b></a>
    </div> -->


</nav>
<div class="main-content" style="margin-top:50px;">



  <div class="container con">
    <div class="row">
      <div class="col-lg-12 margin-tb">

      </div>
    </div>
    <div class="card" style="margin-top:50px; margin-bottom:90px !important;">



      <div class="card-body">
      
        <fieldset>
          <div class="row">
          <h1 class="faq"><b><u>Frequently Asked Questions on MLHUD</u></b></h1>
            <div class="col-lg-12">


              <div id="faq_id">

                @foreach($one_row as $data)
                <button type="button" class="collapsible">
                  <p id="name"><b> {{$loop->iteration}}){{ $data['module_name'] }}</b></p>
                </button>


                <div class="faq_profile content">
                  @if($rows != '')

                  @foreach ($rows as $key => $faqdata)
                  @if($data['id'] == $faqdata['module_id'])
                  <p id="question"><span class="faq_question"><b> Q{{$loop->iteration}}.{{$faqdata['question']}}</b></span></p>
                  <p id="answer"><span style="color: #666666 !important;"> {{$faqdata['answer']}}</span></p>
                  @endif
                  @endforeach
                  @endif
                </div>

                <div class="text-line">
                </div>
                @endforeach

              </div>

              <div class="faqsearch" id="search_id">
              </div>

              <div class="alert text-center" id="alert_message">
                <p> NO DATA FOUND </p>
              </div>
            </div>
          </div>

        </fieldset>
      </div>
      </table>
    </div>

  </div>
  @include('footer')
</div>



<script>
  var reset = document.querySelector('#reset');
  if (reset) {
    reset.addEventListener('click', () => {
      grecaptcha.reset()
    });
  }
</script>
<!-- <script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script> -->
<script>
  $(document).ready(function() {
    $('#alert_message').hide();
  });
</script>
<script>
  var coll = document.getElementsByClassName("collapsible");
  var i;

  for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var content = this.nextElementSibling;
      if (content.style.display === "block") {
        content.style.display = "none";
      } else {
        content.style.display = "block";
      }
    });
  }
</script>
<script>
  $(document).ready(function() {
    $('#alert_message').hide();
  });
</script>


<script type="text/javascript">
  var optionsdata = '';

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function searchIt() {

    $('img').show();

    var module_name = $('#module_name').val();





    $.ajax({
      url: "{{route('que_search')}}",
      type: 'POST',
      data: {
        module_name: module_name,
        _token: '{{csrf_token()}}'
      },
      dataType: "json",
      async: false,
      error: function() {
        alert('Something is wrong');
      },
      success: function(data) {

        console.log(data);



        $('#faq_id').hide();


        var search_faq = data.Data.rows;
        //  var faqs_search = data['fa_search'];


        if (search_faq == null || search_faq == "") {
          $('#alert_message').show();
        } else if (search_faq != null || search_faq != "") {
          $('#alert_message').hide();
        }


        var optionsdata = '';

        var propOwn = Object.getOwnPropertyNames(data.Data.rows);
        console.log(propOwn.length); // 1


        for (var i = 0; i < propOwn.length; i++) {

          var module_name = data.Data.rows[i].module_name;
          // var question = search_faq[i]['question'];
          // var answer = search_faq[i]['answer'];
          var mod_id = data.Data.rows[i].id;

          var j = i + 1;
          console.log(module_name);
          optionsdata += "<button type='button'  class='collapsible'><b><p id='name'>" + j + "." + module_name + "</p></b></button><div class='content'> ";

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: "{{route('ans_search')}}",
            type: 'POST',
            data: {
              mod_id: mod_id,
              _token: '{{csrf_token()}}'
            },
            dataType: "json",
            async: false,
            error: function() {
              alert('Something is wrong');
            },
            success: function(data) {

              //  console.log(data);

              var faqs_search = Object.getOwnPropertyNames(data.Data.rows);
              console.log(faqs_search.length); // 1





              for (var z = 0; z < faqs_search.length; z++) {
                var question = data.Data.rows[z].question;
                var answer = data.Data.rows[z].answer;
                var m_id = data.Data.rows[z].module_id;


                console.log(answer);
                var x = z + 1;



                optionsdata += "<p id='q_faq'>Q" + x + "." + question + "</p><p id='a_faq'>" + answer + "</p>";

              }
              optionsdata += "</div>";

              // console.log(optionsdata);
              $('.collapsible').remove();
              $('.content').remove();

              $('.faqsearch').html(optionsdata);


              var coll = document.getElementsByClassName("collapsible");
              var i;

              for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                  this.classList.toggle("active");
                  var content = this.nextElementSibling;
                  if (content.style.display === "block") {
                    content.style.display = "none";
                  } else {
                    content.style.display = "block";
                  }
                });
              }
            }

          });
        }

        // var stageoption = ddd.concat(optionsdata);








      }
    });


  };
</script>
@endsection