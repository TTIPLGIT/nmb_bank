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
        <div class="card-header alert-head-background">MLHUD - {{ $alertTitle }}</div>
        <div class="card-body">    
          <img src="{{ asset('images/success-message.png') }}" class="alert-image-size">
          <p class="card-text alert-message-top">{{ $message }}</p>
          <a href="{{ route('home') }} " class="btn btn-success">Ok</a>
        </div>
      </div>
  </div>
</div>
    </div>
  </section>
</div>
@endsection