<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <link rel="stylesheet" 
          href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
          <title>Talentra</title>
          <link rel="icon" href="{{asset('css/talentra-image.jpg')}}" sizes="40x40">
        <!-- Fonts -->
        <link href="{{ asset('css/login.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/mediaquery.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">
    *{
        line-height: 2.1em;
    }
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
.error{
  color: red;
}.header {
    height: 110px;
    width: 100%;
    margin-left: 0px !important;
    background-image: linear-gradient(to right, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d);

}
.footer{
    background: #26268d !important;
}
html ,body{
   background-color: #f2f2f2 !important;
   margin-left: 0px !important;
}

*{
    font-family:sans-serif
}

</style>
    </head>
    
    <body>
  <div class="header row" style="display:flex; align-items:center;" >      
  <div class="col-3 col-sm-3" > <!-- <a href="{{url('/')}}"><picture><source media="(max-width:558px)" srcset="{{asset('assets/images/a.png')}}"> -->
  <img class="policy_logo" style="width: 80% !important; display: block; margin: 0px !important; padding: 0px !important; text-align: center; align-items: center;" src="{{asset('asset/image/Talentra-1.svg')}}" alt="logo"></a></div>
  <div class="col-9 col-sm-9" style="justify-content: center; display: flex;align-items: center;">
  <h2 class="policy_txt" style="color:#FFF;font-weight: 900; font-family: sans-serif!important; margin-bottom: 0px !important;">TTIPL - Learning Management System</h2></div>
  </div>  

    <div class="container">
      <div class="row"> 
        <div class="col-md-12 m-7 mt-2">
         

                   
                  <div>{!! $rows[0]['policycontent'] !!}</div>
    </div>
  </div>
</div>
 @include('footer')
    </body>
</html>
<script>
    var reset = document.querySelector('#reset');
    if (reset) {
        reset.addEventListener('click', () => {
            grecaptcha.reset()
        });
    }
</script>
