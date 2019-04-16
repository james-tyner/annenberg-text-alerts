<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Annenberg Media Text Alerts</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
      <nav>
        <img id="logo" src="http://interactives.uscannenbergmedia.com/media/FB%20horizontal%20lockup.png" alt="USC Annenberg Media">
      </nav>

      <main id="app">
        <section id="description">
          <h1>Catchy words</h1>
          <h5>Get the USC news that matters to you. Sign up for text alerts! We promise we’ll only text you when it’s important.</h5>

          <div id="form-with-tabs">
            <div id="tabs">
              <div class="tab" v-on:click="selected = 'signup'" :class="{'selected' : selected == 'signup'}">Sign up</div>
              <div class="tab" v-on:click="selected = 'unsubscribe'" :class="{'selected' : selected == 'unsubscribe'}">Unsubscribe</div>
              <div class="tab" v-on:click="selected = 'admin'" :class="{'selected' : selected == 'admin' || selected == 'request'}">Admin login</div>
            </div>
            <div id="form-holder">
              <!-- SIGN UP FORM -->
              <form id="signup-form" v-if="selected == 'signup'" method="POST" action="{{ route('subscribe') }}">
                @csrf
                <div class="form-group">
                  <label for="phoneNumber">Phone number</label>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text">+1</div>
                    </div>
                    <input type="tel" class="form-control {{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}" id="phoneNumber" name="phoneNumber" aria-describedby="phoneHelp" placeholder="">
                  </div>
                  <small id="phoneHelp" class="form-text text-muted">Your phone number won’t be used for anything except sending news alerts. If you text us back, we may engage in a conversation about the news.</small>
                  @if ($errors->has('phoneNumber'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('phoneNumber') }}</strong>
                      </span>
                  @endif
                </div>
                <div class="form-group">
                  <label for="optionalName">Name</label>
                  <input type="text" class="form-control {{ $errors->has('optionalName') ? ' is-invalid' : '' }}" id="optionalName" name="optionalName" placeholder="Tommy Trojan" aria-describedby="nameHelp">
                  <small id="nameHelp" class="form-text text-muted">Giving us your name is totally optional.</small>
                  @if ($errors->has('optionalName'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('optionalName') }}</strong>
                      </span>
                  @endif
                </div>
                <button type="submit" class="btn btn-success">Subscribe</button>
              </form>

              <!-- UNSUBSCRIBE FORM -->
              <form id="unsubscribe-form" v-if="selected == 'unsubscribe'" method="POST" action="{{ route('unsubscribe') }}">
                @csrf
                <div class="form-group">
                  <label for="phoneNumber">Enter the phone number you used to sign up:</label>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text">+1</div>
                    </div>
                    <input type="tel" class="form-control {{ $errors->has('unsubscribePhone') ? ' is-invalid' : '' }}" name="unsubscribePhone" id="unsubscribePhone" aria-describedby="unsubPhoneHelp" placeholder="">
                    @if ($errors->has('unsubscribePhone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('unsubscribePhone') }}</strong>
                        </span>
                    @endif
                  </div>
                  <small id="unsubPhoneHelp" class="form-text text-muted">You’ll get one last text confirming you unsubscribed.</small>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-danger">Unsubscribe</button>
                </div>
              </form>

              <!-- ADMIN LOGIN -->
              <form id="admin-login-form" v-if="selected == 'admin'" method="POST" action="{{route('login')}}">
                @csrf
                <div class="form-group">
                  <label for="adminEmail">Email</label>
                  <input type="email" class="form-control {{ $errors->has('adminEmail') ? ' is-invalid' : '' }}" id="adminEmail" value="{{ old('adminEmail') }}" required placeholder="ttrojan@usc.edu">
                  @if ($errors->has('adminEmail'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adminEmail') }}</strong>
                    </span>
                  @endif
                </div>


                <div class="form-group">
                  <label for="adminPass">Password</label>
                  <input type="password" class="form-control {{ $errors->has('adminPass') ? ' is-invalid' : '' }}" id="adminPass" required>
                  @if ($errors->has('adminPass'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adminPass') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-row">
                  <button type="submit" class="btn btn-success">Sign in</button>
                  <div class="form-check form-check-inline ml-2">
                    <input class="form-check-input" type="checkbox" value="remember" id="rememberMe" {{ old('rememberMe') ? 'checked' : '' }}>
                    <label class="form-check-label" for="rememberMe">
                      Keep me signed in
                    </label>
                  </div>
                </div>

                <div class="form-group mt-3">
                  @if (Route::has('password.request'))
                      <p><a href="{{ route('password.request') }}">
                          {{ __('Forgot your password?') }}
                      </a></p>
                  @endif
                  <p>If you don’t have a login, <a v-on:click="selected = 'request'">request one</a>. →</p>
                </div>
              </form>

              <!-- REQUEST ACCESS -->
              <form id="unsubscribe-form" v-if="selected == 'request'" method="POST" action="{{ route('request') }}">
                @csrf
                <div class="form-group">
                  <p><a v-on:click="selected = 'admin'">← Nevermind… I already have an account</a></p>
                </div>

                <div class="form-group">
                  <label for="requestFirst">First name</label>
                  <input type="text" class="form-control {{ $errors->has('requestFirst') ? ' is-invalid' : '' }}" id="requestFirst">
                  @if ($errors->has('requestEmail'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('requestFirst') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="requestLast">Last name</label>
                  <input type="text" class="form-control {{ $errors->has('requestLast') ? ' is-invalid' : '' }}" id="requestLast">
                  @if ($errors->has('requestEmail'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('requestLast') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="requestEmail">Email</label>
                  <input type="email" class="form-control {{ $errors->has('requestEmail') ? ' is-invalid' : '' }}" id="requestEmail" placeholder="ttrojan@usc.edu">
                  @if ($errors->has('requestEmail'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('adminEmail') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Request account</button>
                  <small class="form-text text-muted mt-2">You’ll be notified by email once an editor approves your request.</small>
                </div>
              </form>

            </div>
          </div>
        </section>

        <figure id="homepage-graphic">
          <img src="https://scontent-lax3-2.xx.fbcdn.net/v/t39.8562-6/44612985_257609764945259_253729135791177728_n.jpg?_nc_cat=1&_nc_ht=scontent-lax3-2.xx&oh=9150a7f09462ad45024856efe9a4cf78&oe=5D388D3B">
        </figure>
      </main>

            {{--
            @if (Route::has('login'))
                <ul class="nav">
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                        <a href="{{ url('/alerts') }}">Send an alert</a>
                        <a href="{{ url('/history') }}">History</a>
                        <a href="{{ url('/subscribers') }}">Subscribers</a>
                        @if ($superuser)
                          <a href="{{ url('/users') }}">Manage users</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </ul>
            @endif

            --}}

    </body>
</html>
