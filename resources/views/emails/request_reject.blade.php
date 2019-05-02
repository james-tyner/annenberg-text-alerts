@extends('layouts.base_email')

@section('content')

    <div id="content">
      <h2>Your account request was denied</h2>
      
      <p>Sorry, {{$denier}} denied your request to create an account to send text alerts at Annenberg Media.

      <p>Please follow up with them if you have any questions.</p>

    </div>

@endsection
