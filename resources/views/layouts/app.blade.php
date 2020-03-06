<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>

  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
  </style>
</head>
<body>
<div id="app">
  <nav class="navbar">
    <div class="d-flex justify-content-start">
      <a class="navbar-brand pt-4 pl-4" href="{{ url('/') }}">
        <img src="{{ asset('image/Logo.png') }}" height="45px">
      </a>
    </div>
    <div class="d-flex justify-content-end">
      @auth
        <div>
          <a href="{{ route('logout') }}"
             onclick="event.preventDefault();
         document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      @endauth
    </div>
  </nav>

  <div class="container">
    @yield('content')
  </div>
</div>
</body>
</html>
