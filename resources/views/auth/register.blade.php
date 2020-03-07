@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content-center">
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="form-group justify-content-center d-flex">
        <p class="heading-text text-uppercase">Register</p>
      </div>
      <div class="form-group">
        <label class="label-text">Name</label>
        <input type="text" class="form-control input-text-box @error('name') is-invalid @enderror" name="name">
      </div>
      <div class="form-group">
        <label class="label-text">Email</label>
        <input type="email" class="form-control input-text-box @error('email') is-invalid @enderror" name="email">
      </div>
      <div class="form-group">
        <label class="label-text">Password</label>
        <input type="password" class="form-control input-text-box @error('password') is-invalid @enderror"
               name="password">
        @error('password')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label class="label-text">Confirm Password</label>
        <input type="password" class="form-control input-text-box @error('password_confirmation') is-invalid @enderror"
               name="password_confirmation">
      </div>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn input-button">Register</button>
      </div>
      <div class="d-flex justify-content-center mt-3">
        <small class="small-text">
          Already have an account? <a
            href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']) }}">Login
            here</a>
        </small>
      </div>
    </form>
  </div>
@endsection
