<!DOCTYPE html>
    <html lang="en-US">
    	<head>
    		<meta charset="utf-8">
    	</head>
    	<body>
    		<h2>Test Email</h2>
        <p>Hey {{ $userName }}, here’s your password reset link:</p>
        <a href="{{ $resetLink }}"><div>Reset Password</div></a>

        <small>Or copy and paste this into your browser:</small>
    		<small>{{ $resetLink }}</small>
    	</body>
    </html>
