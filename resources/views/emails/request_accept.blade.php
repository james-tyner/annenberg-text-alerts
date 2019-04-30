<!DOCTYPE html>
    <html lang="en-US">
    	<head>
    		<meta charset="utf-8">
    	</head>
    	<body>
    		<h2>Test Email</h2>
        <p>Hey {{ $userName }}, your request to create an account to send text alerts at Annenberg Media was approved.

        <h3>There are two things you need to do now:</h3>
        <ol>
          <li>1. Reset your account password</a></li>
          <li>2. Add your phone number to your account so you can send and receive test alerts</li>
        </ol>

        <a href="{{ $setupLink }}"><div>Set up your account</div></a>

    	</body>
    </html>
