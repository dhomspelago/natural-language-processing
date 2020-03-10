@extends('layouts.app')

@section('content')
  <div class="custom-wrapper">
    <div class="d-flex justify-content-center">
      <p class="heading-text text-uppercase">Natural Language Processing</p>
    </div>
    <div class="content">
      <div class="d-flex justify-content-center mb-3">
        <textarea name="text" class="text-area w-100" rows="10"></textarea>
      </div>
      <div class="d-flex justify-content-center mb-3">
        <div>
          <label for="type" class="label-text">Select Type:</label>
          <select name="type" class="type">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
      </div>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn input-button">Analyze</button>
      </div>
    </div>
  </div>
@endsection
