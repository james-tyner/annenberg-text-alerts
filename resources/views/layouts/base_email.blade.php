<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/emails.css') }}" rel="stylesheet">

</head>
<body>

  <div id="header">
    <img src="{{asset('FB horizontal lockup.png')}}" alt="USC Annenberg Media">
  </div>

  @yield("content")

</body>
</html>
