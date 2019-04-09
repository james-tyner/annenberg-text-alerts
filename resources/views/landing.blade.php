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
      <h1>Catchy words</h1>
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
