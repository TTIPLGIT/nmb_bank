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
            <div class="card-header alert-head-background">MLHUD - Not Authorized</div>
            <div class="card-body">
              <img src="{{ asset('images/wrong.png') }}" class="alert-image-size">
              <p class="card-text alert-message-top">Your not authorized to do this operation.</p>
              <a href="/home" class="btn btn-primary">Ok</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection