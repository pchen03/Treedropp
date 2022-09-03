<?php

include('phpDatabase/databaseConnect.php');
include('phpDatabase/checkLogin.php');
include('phpDatabase/check_email_available.php');
include('phpDatabase/check_username_availability.php');


if (isset($_POST['signupButton'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$repassword = $_POST['verifyPassword'];

	//check if username is available
	if (!database::query('SELECT ID FROM users WHERE email=:email', array(':email' => $email))) {
		//check for valid email
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

			if (strlen($password) >= 1 && strlen($password) <= 60) {
				if ($password == $repassword) {
					database::query('INSERT INTO users VALUES ( \'\', :email, :Password, \'0 \',  \'0 \' )', array(':email' => $email, ':Password' => password_hash($password, PASSWORD_BCRYPT)));
					echo '<script type="text/javascript">';
					echo '$("#emailTaken").html("user created");$("#emailTaken").removeClass(\'hidden\')';
					echo '</script>';
					header("Location: login.php");
				} else {
					echo '<script type="text/javascript">';
					echo '$("#verifyNote").html("Passwords do not match");$("#verifyNote").removeClass(\'hidden\')';
					echo '</script>';
				}
			} else {
				echo '<script type="text/javascript">';
				echo '$("#emailTaken").html("insecure Password");$("#emailTaken").removeClass(\'hidden\')';
				echo '</script>';
			}
		} else {
			echo '<script type="text/javascript">';
			echo '$("#emailTaken").html("invalid email");$("#emailTaken").removeClass(\'hidden\')';
			echo '</script>';
		}
	} else {
		echo '<script type="text/javascript">';
		echo '$("#emailTaken").html("Email Already In Use");$("#emailTaken").removeClass(\'hidden\')';
		echo '</script>';
	}
}

?>

<html lang="en">

<head>
	<title>TreeDropp Register</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/TreeDroppLogo.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginvendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginFonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginFonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginvendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginvendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginvendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginvendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginvendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/loginUtil.css">
	<link rel="stylesheet" type="text/css" href="css/loginMain.css">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/registerBackground.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="register.php" method="POST">
					<!-- <span class="login100-form-logo">
						<img src="images/icons/TreeDroppLogo.png" width="100%" height="100%" />
					</span> -->

					<span class=" login100-form-title p-b-34 p-t-27">
						<img src="images/icons/TreeDroppText.png" style="margin-left:10%" width="80%" height="100%" />
						Register
					</span>

					<div class="wrap-input100 validate-input" data-validate="Enter Email">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" id="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Retype password">
						<input class="input100" type="password" id="verifyPassword" name="verifyPassword" placeholder="Retype Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					<span id="verifyNote" class="hidden" style="color:#addce0;transition:opacity 0.4s;">Passwords don't match</span>
					<br>
					<span id="emailTaken" class="hidden" style="color:#addce0;transition:opacity 0.4s;">Email Already In Use</span>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="signupButton">
							Register
						</button>
					</div>

					<div class="text-center p-t-90" style="color:white">
						<br>
						Already Registered?
						<a style="color:#50ac52;font-weight:900;" href="login.php">
							Login
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<script src="loginvendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="loginvendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="loginvendor/bootstrap/js/popper.js"></script>
	<script src="loginvendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="loginvendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="loginvendor/daterangepicker/moment.min.js"></script>
	<script src="loginvendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="loginvendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="loginjs/main.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#verifyPassword').keyup(function() {
				if ($(this).val() == $('#password').val()) {
					$('#verifyNote').addClass('hidden');
				} else {
					$('#verifyNote').removeClass('hidden');
				}
			});
			$('#password').keyup(function() {
				if ($(this).val() == $('#verifyPassword').val()) {
					$('#verifyNote').addClass('hidden');
				} else {
					$('#verifyNote').removeClass('hidden');
				}
			});

			//email verification    
			$('#email').keyup(function() {

				var email = $('#email').val();
				jQuery.ajax({
					url: 'phpDatabase/check_email_available.php',
					method: 'POST',
					data: {
						"passEmail": email
					},
					success: function(data) {
						//alert('Successfully called' + 'data');
						$("#emailTaken").html(data);
						$("#emailTaken").removeClass('hidden')
						//alert(data)
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
						alert(thrownError);
					}
				});


			});
			$('#username').keyup(function() {

				var username = $('#username').val();
				jQuery.ajax({
					url: 'phpLogin/check_username_availability.php',
					method: 'POST',
					data: {
						"username": username
					},
					success: function(data) {
						//alert('Successfully called' + 'data');
						$("#usernameTaken").html(data);
						$("#usernameTaken").removeClass('hidden')
						//alert(data)
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
						alert(thrownError);
					}
				});
			});
		});
	</script>

</body>

</html>