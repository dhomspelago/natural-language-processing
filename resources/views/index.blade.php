@extends('layouts.app')
@section('content')
  <!-- Header -->
  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5">Welcome to Natural Language Processing !</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <div class="form-row">
            <div class="col-md-12 d-flex justify-content-center">
              <div>
                <a class="btn btn-block btn-lg btn-primary" href="{{ route('register') }}">Sign up</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
@endsection

