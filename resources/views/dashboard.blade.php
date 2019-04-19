@extends('layouts.base')

@section('pagetitle') Welcome back, {{Auth::user()->fname}} @endsection

@section('content')

<nav>
  <a href="//uscannenbergmedia.com"><img id="logo" src="http://interactives.uscannenbergmedia.com/media/FB%20horizontal%20lockup.png" alt="USC Annenberg Media"></a>
</nav>

<main id="dashboard-main">
  <section id="description">
    <h1>@yield('pagetitle')</h1>

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
        <a class="nav-link" href="{{ url('/logout') }}">Log out</a>
      </li>
    </ul>

</section>

</main>

@endsection
