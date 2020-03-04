@extends('layouts.app')

@section('content')
  <div class="container pt-5 mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Welcome</div>

          <div class="card-body">
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Put some text to analyze</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
