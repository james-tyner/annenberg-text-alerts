@extends('layouts.app')

@section('pagetitle') Users @endsection

@section('page')

<button class="btn btn-success float-right mr-3">Add new</button>

<h1>@yield('pagetitle')</h1>

<div id="users-page" class="mt-5">
  {{-- <div v-if="validationErrors" v-html="validationErrors" class="text-danger mt-2 mb-2"></div> --}}

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
                  <button class="btn btn-sm btn-success">Accept</button>
                  <button class="btn btn-sm btn-danger">Deny</button>
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
              <select>
                <option value="0" {{ ($user->super == 0 ? "selected":"") }}>Regular</option>
                <option value="1" {{ ($user->super == 1 ? "selected":"") }}>Super</option>
              </select>
            </td>
            <td>
              <button class="btn btn-sm btn-primary">Reset Password</button>
              <button class="btn btn-sm btn-danger">Delete</button>
            </td>
          @endif
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection
