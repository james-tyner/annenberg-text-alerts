@extends('layouts.base')

@section('content')
  <div class="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel mb-5">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img id="logo" src="http://interactives.uscannenbergmedia.com/media/FB%20horizontal%20lockup.png" alt="USC Annenberg Media">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/alerts') }}">Alerts</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/history') }}">History</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/subscribers') }}">Subscribers</a>
            </li>
            @if (Auth::user()->super)
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/users') }}">Manage users</a>
              </li>
            @endif
            <li class="nav-item">
              {{-- <a class="nav-link" href="{{ url('/logout') }}">Log out</a> --}}
              <div class="dropdown nav-item">
                <a class="nav-link dropdown-toggle border-left" id="accountMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{Auth::user()->fname}}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountMenuButton">
                  <a class="dropdown-item nav-link" href="{{url('/users/profile')}}">Edit profile</a>
                  <a class="dropdown-item nav-link" href="{{ url('/logout') }}">Log out</a>
                </div>
              </div>
            </li>
          </ul>
        </div>
    </nav>

    <main>
      @yield('page')
    </main>
  </div>

@endsection
