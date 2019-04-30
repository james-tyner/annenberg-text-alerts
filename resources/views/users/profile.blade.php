@extends("layouts.app")

@section("pagetitle") Update your profile @endsection

@section("page")

<h1>@yield("pagetitle")</h1>

<div id="users-page" class="mt-3">
  <form id="profile-update-form" method="POST" action="{{url('/users/profile')}}">
    @csrf
    <div class="form-group form-row">
      <div class="col">
        <label for="fname">First name</label>
        <input type="text" name="fname" id="fname" class="form-control col" required value="{{old('fname') ? old('fname') : Auth::user()->fname}}">
        <small class="text-danger">{{$errors->first('fname')}}</small>
      </div>

      <div class="col">
        <label for="lname">Last name</label>
        <input type="text" name="lname" id="lname" class="form-control col" required value="{{old('lname') ? old('lname') : Auth::user()->lname}}">
        <small class="text-danger">{{$errors->first('lname')}}</small>
      </div>
    </div>

    <div class="form-group form-row">
      <div class="col-md-8">
        <label for="email">Email address</label>
        <input type="email" name="email" id="email" class="form-control" required value="{{old('email') ? old('email') : Auth::user()->email}}">
      </div>

      <div class="col-sm-4">
        <label for="phone">Phone number</label>
        <input type="phone" name="phone" id="phone" class="form-control" required value="{{old('phone') ? old('phone') : Auth::user()->phone}}">
        <small class="text-danger">{{$errors->first('phone')}}</small>
      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-success">Save changes</button>
    </div>
  </form>

  <h2 class="pt-3 mt-3 border-top">Update your password</h2>
  <form class="form mt-3" method="post" action="{{url('/users/profile/password')}}">
    @csrf
    @if(session('passwordError')) <p class="mt-2 mb-2 text-danger">{{session('passwordError')}}</p>@endif
    <div class="form-group form-row">
      <div class="col">
        <label for="fname">Current password</label>
        <input type="password" name="oldPassword" id="oldPassword" class="form-control col">
        <small class="text-danger">{{$errors->first('oldPassword')}}</small>
      </div>

      <div class="col">
        <label for="lname">New password</label>
        <input type="password" name="newPassword" id="newPassword" class="form-control col">
        <small class="text-danger">{{$errors->first('newPassword')}}</small>
      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">Change password</button>
    </div>
  </form>
</div>

@endsection
