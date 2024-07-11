@extends('layouts.adminnav')

@section('content')
<div class="main-content">

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
<div class="row alert-row-top">
  <div class="col-md-4"></div>
    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-header alert-head-background">{{ __('MLHUD - Session Expired') }} </div>
        <div class="card-body">    
          <img src="{{ asset('images/unauthenticated.png') }}" class="alert-image-size">
          <p class="card-text alert-message-top">Your reset password link  session is expired. Please re-initiate your reset password request. .</p>
          <a href="{{ route('home') }} " class="btn btn-success">Ok</a>
        </div>
      </div>
  </div>
</div>
</div>
  </section>
</div>
@endsection