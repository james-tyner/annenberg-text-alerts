@extends("layouts.app")

@section("pagetitle") Add a new user @endsection

@section("page")

<h1>@yield("pagetitle")</h1>

<div id="users-page" class="mt-3">
  <form id="user-create-form" method="POST" action="{{url('/users/add')}}">
    @csrf
    <div class="form-group form-row">
      <div class="col">
        <label for="fname">First name</label>
        <input type="text" name="fname" id="fname" class="form-control col" required value="{{old('fname')}}">
        <small class="text-danger">{{$errors->first('fname')}}</small>
      </div>

      <div class="col">
        <label for="lname">Last name</label>
        <input type="text" name="lname" id="lname" class="form-control col" required value="{{old('lname')}}">
        <small class="text-danger">{{$errors->first('lname')}}</small>
      </div>
    </div>

    <div class="form-group form-row">
      <div class="col-md-8">
        <label for="email">Email address</label>
        <input type="email" name="email" id="email" class="form-control" required value="{{old('email')}}">
      </div>

      <div class="col-sm-4">
        <label for="phone">Phone number</label>
        <input type="phone" name="phone" id="phone" class="form-control" required value="{{old('phone')}}">
        <small class="text-danger">{{$errors->first('phone')}}</small>
      </div>
    </div>

    <div class="form-group">
      <label for="super">User level</label>
      <select id="super" name="super" class="form-control" value="{{old('super')}}">
        <option value="0">Regular</option>
        <option value="1">Super</option>
      </select>
      <small class="text-danger">{{$errors->first('super')}}</small>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-success">Save user</button>
    </div>
  </form>
</div>

@endsection
