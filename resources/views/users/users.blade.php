@extends('layouts.app')

@section('pagetitle') Users @endsection

@section('page')

<a class="btn btn-success float-right mr-3" href="/users/add">Add new</a>

<h1>@yield('pagetitle')</h1>

@if($userMessage)
  <p class="mt-2">{{$userMessage}}</p>
@endif

@if(session('userMessage'))
  <p class="mt-2 text-success">{{session('userMessage')}}</p>
@endif

<div id="users-page" class="mt-5">
  @if(Auth::user()->super)
    <div id="user-requests" class="border-bottom mb-2">
      <h2>User requests</h2>
      @if($requests && sizeof($requests) > 0)

        <p>These people would like permission to create an account and send text alerts.</p>

        <table class="table table-sm table-responsive-sm">
          <thead>
            <tr>
              <th scope="col">First name</th>
              <th scope="col">Last name</th>
              <th scope="col">Email</th>
              <th scope="col"><!-- Accept or deny --></th>
            </tr>
          </thead>
          <tbody>
            @foreach($requests as $request)
              <tr>
                <td>{{$request->fname}}</td>
                <td>{{$request->lname}}</td>
                <td>{{$request->email}}</td>
                <td>
                  <form class="d-inline-flex" method="post" action="/users/request/accept">
                    @csrf
                    <input type="hidden" name="request_fname" value="{{$request->fname}}">
                    <input type="hidden" name="request_lname" value="{{$request->lname}}">
                    <input type="hidden" name="request_email" value="{{$request->email}}">
                    <button class="btn btn-sm btn-outline-success" type="submit">Accept</button>
                  </form>

                  <form class="d-inline-flex" method="post" action="/users/request/deny">
                    @csrf
                    <input type="hidden" name="request_fname" value="{{$request->fname}}">
                    <input type="hidden" name="request_lname" value="{{$request->lname}}">
                    <input type="hidden" name="request_email" value="{{$request->email}}">
                    <input type="hidden" name="denier" value="{{Auth::user()->fname . ' ' . Auth::user()->lname}}">
                    <button class="btn btn-sm btn-outline-danger" type="submit">Deny</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      @else

        <p>There are no pending user requests.</p>

      @endif
    </div>

    <h2 class="mt-5">Users</h2>
  @endif

  <table class="table table-striped table-responsive-sm">
    <thead>
      <tr>
        <th scope="col">First name</th>
        <th scope="col">Last name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        @if(Auth::user()->super)
          <th scope-"col">User level</th>
          <th scope="col"><!-- Delete and reset password --></th>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
        <tr>
          <td>{{$user->fname}}</td>
          <td>{{$user->lname}}</td>
          <td>{{$user->email}}</td>
          <td>{{$user->phone}}</td>
          @if(Auth::user()->super)
            <td>
              <form class="d-inline-flex" action="/users/superness" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <select onchange="this.form.submit()" class="form-control form-control-sm" name="super">
                  <option value="0" {{ ($user->super == 0 ? "selected":"") }}>Regular</option>
                  <option value="1" {{ ($user->super == 1 ? "selected":"") }}>Super</option>
                </select>
              </form>
            </td>
            <td>
              <form class="d-inline-flex" action="/users/reset" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <button class="btn btn-sm btn-outline-primary" type="submit">Reset Password</button>
              </form>
              <form class="d-inline-flex" action="/users/delete" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
              </form>
            </td>
          @endif
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection
