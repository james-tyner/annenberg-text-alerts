@extends('layouts.base_email')

@section('content')

  <div id="content">
    <h2>Resetting your password</h2>
    <p class="greeting">Hey {{ $userName }},</p>

    <p>Here’s your password reset link.</p>
    <a class="button" href="{{ $resetLink }}"><div>Reset Password</div></a>

    <div id="footer">
      <small>Or copy and paste this into your browser: <a href="{{$resetLink}}">{{$resetLink}}</a></small>
    </div>
  </div>

@endsection
