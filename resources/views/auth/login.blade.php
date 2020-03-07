@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content-center">
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="form-group justify-content-center d-flex">
        <p class="heading-text text-uppercase">Login</p>
      </div>
      <div class="form-group">
        <label class="label-text">Email</label>
        <input type="email" class="form-control input-text-box @error('email') is-invalid @enderror" name="email">
      </div>
      <div class="form-group">
        <label class="label-text">Password</label>
        <input type="password" class="form-control input-text-box @error('password') is-invalid @enderror" name="password">
        @error('password')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn input-button">Login</button>
      </div>
      <div class="d-flex justify-content-center mt-3">
        <small class="small-text">
          Haven't an account yet? <a
            href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']) }}">Register
            here</a>
        </small>
      </div>
    </form>
  </div>
@endsection
