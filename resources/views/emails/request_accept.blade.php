@extends('layouts.base_email')

@section('content')

  <div id="content">
    <h2>You’re in!</h2>
    <p class="greeting">Hey {{ $userName }},</p>

    <p>Your request to create an account to send text alerts at Annenberg Media was approved.</p>

    <h3>There are two things you need to do now:</h3>
    <ol>
      <li>Reset your account password</a></li>
      <li>Add your phone number to your account so you can be included on test alerts</li>
    </ol>

    <a class="button" href="{{ $setupLink }}"><div>Set up your account</div></a>

    <div id="footer">
      <small>Or copy and paste this into your browser: <a href="{{$setupLink}}">{{$setupLink}}</a></small>
    </div>
  </div>

@endsection
