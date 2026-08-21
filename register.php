
<!DOCTYPE html>
<html>
    <head>
	    <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>SignUp</title>
		<link rel="stylesheet" href="css/style.css"/>
	</head>
	
	<body>
	    <div class="main-container">
		    <form class="form-content" action="includes/registerhandler.inc.php" method="POST">
			    <h2>WIL-CONNECT</h2>
				<p class="header-txt">__UNLOCKING OPPORTUNITIES | BUILDING FUTURES__</p>
				<br/>
				<span id="error" name="error">Error</span>
				
				<div class="input-group">
					<input type="text" name="fullName" id="fullName" placeholder=""/>
					<label for="name">Full Name: </label>
				</div>
				<div class="input-group">
				    <select name="role" id="role">
				        <option value="" selected disabled>Lecturer, Recruiter, Student</option>
                        <option value="lecturer">Lecturer</option>
                        <option value="recruiter">Recruiter</option>
                        <option value="student">Student</option>
				    </select>
				</div>

				<div class="input-group">
				    <select name="company" id="company">
				        <option value="" selected disabled>AWS, IBM, Oracle, CISCO, CIMA</option>
                        <option value="AWS">AWS</option>
                        <option value="IBM">IBM</option>
                        <option value="Oracle">Oracle</option>
                        <option value="Cisco">CISCO</option>
                        <option value="CIMA">CIMA</option>
				    </select>
				</div>
				
				<div class="input-group">
					<input type="text" name="email" id="email" placeholder=""/>
					<label for="email">Email</label>
				</div>
				<div class="input-group">
					<input type="password" name="password" id="password" placeholder=""/>
					<label for="password">Password</label>
				</div>
				<div class="input-group">
					<input type="password" name="confirmPassword" id="confirmPassword" placeholder=""/>
					<label for="confirmPassword">Confirm Password</label>
				</div>
				<button type="submit" name="register" id="register">Register</button>
				<p class="signup-txt">Already have an account? <a href="login.php">Login</a></p>
			</form>
		</div>
		
		<script>
		    //grabbing the html elements
        const company = document.getElementById('company');
        const role = document.getElementById('role');

        //when page first loads location is hidden by default
        company.style.display = 'none';

        role.addEventListener('change', function() {
            if (this.value === 'recruiter') {
                company.style.display = 'block';
            } else {
                company.style.display = 'none';
            }
        });
		</script>
	</body>
</html>

