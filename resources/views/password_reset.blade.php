<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Reset Password - Annenberg Media Text Alerts</title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Scripts -->
  {{-- Axios in here for sending form validation errors to Vue component --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.3/vue.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <nav>
    <a href="//uscannenbergmedia.com"><img id="logo" src="http://interactives.uscannenbergmedia.com/media/FB%20horizontal%20lockup.png" alt="USC Annenberg Media"></a>
  </nav>

  <main id="pwResetApp">
    <section id="description">
      <h1>Reset your password</h1>

      <div id="form-with-tabs">
        <div id="form-holder">
          <!-- SIGN UP FORM -->
          <form id="pw-reset-form" method="POST" action="{{route('doPWReset')}}">
            @csrf
            <div v-if="!successfulReset">
              <div class="form-group">
                <input type="hidden" name="token" value="{{$token}}"
                <label for="resetEmail">Enter a new password :</label>
                <input type="password" name="resetPassword" class="form-control" id="resetPassword">
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary">Reset password</button>
              </div>
            </form>
          </div>
        </div>
      </section>

      <figure id="homepage-graphic">
        <img src="https://scontent-lax3-2.xx.fbcdn.net/v/t39.8562-6/44612985_257609764945259_253729135791177728_n.jpg?_nc_cat=1&_nc_ht=scontent-lax3-2.xx&oh=9150a7f09462ad45024856efe9a4cf78&oe=5D388D3B">
      </figure>
    </main>

  </body>
  </html>
