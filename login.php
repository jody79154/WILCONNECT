<!DOCTYPE html>
<html>
    <head>
	    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	
	<body>
	    <div class="main-container">
		    <form class="form-content" action="includes/loginhandler.inc.php" method="POST">
			    <div class="header">
				    <h3>WIL-CONNECT</h3>
				</div>
				<span id="error" name="error"></span>
				<br/>
				<div class="input-group">
					<input type="text" name="email" id="email" placeholder=""/>
					<label for="email">Email:</label>
				</div>
				<div class="input-group">
					<input type="password" name="password" id="password" placeholder=" "/>
					<label for="password">Password</label>
				</div>
				<div class="remember">
					<input type="checkbox" name="rememberMe" id="rememberMe" placeholder=" "/>
					<label for="rememberMe" class="rememberMe">Remember me</label>
				    <p class="forgot-para">
				        <a href="forgotpassword.php" class="forgot-pass">Forgot Password?</a>
				    </p>
				</div>
				<button type="submit" name="login" id="login">Log in</button>
				<p class="signup-txt">Need an account? <a href="register.php" class="signup">Sign Up</a></p>
			</form>
		</div>
	</body>
</html>
