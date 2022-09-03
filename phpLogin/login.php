<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('phpDatabase/databaseConnect.php');
//determine what type of data user is loggin in with
//check if the fields are blank


//checks when the button is clicked
if (isset($_POST['login'])) {

	$password = $_POST['Password'];
	$email = $_POST['Email'];

	if (database::query('SELECT ID FROM users WHERE email=:Email', array(':Email' => $email))) {

		if (password_verify($password, database::query('SELECT password FROM users WHERE email =:Email', array(':Email' => $email))[0]['password'])) {

			//cookie save
			$cstrong = True;
			$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
			$user_id = database::query('SELECT ID FROM users WHERE email = :email', array(':email' => $email))[0]['ID'];
			database::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token' => sha1($token), ':user_id' => $user_id));

			// the second to last null should be chnange to true- indiates if conenction is available over any kind of connection
			setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', TRUE, NULL, TRUE);
			setcookie("SNID2", 'default',  time() + 60 * 60 * 24 * 3, '/', TRUE, NULL, TRUE);
			header("Location: index.php?userID=" . $user_id);
			exit();
		} else {
			echo '<script type="text/javascript">';
			echo '$("#loginResult").html("Incorrect Password");$("#loginResult").removeClass(\'hidden\')';
			echo '</script>';
		}
	} else {
		echo '<script type="text/javascript">';
		echo '$("#loginResult").html("Email not registered");$("#loginResult").removeClass(\'hidden\')';
		echo '</script>';
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>TreeDropp Login</title>
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
		<div class="container-login100" style="background-image: url('images/loginBackground.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="login.php" method="post">
					<span class="login100-form-logo">
						<img src="images/icons/TreeDroppLogo.png" width="100%" height="100%" />
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Login
					</span>

					<div class="wrap-input100 validate-input" data-validate="Enter Email">
						<input class="input100" type="text" name="Email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="Password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					<!-- 
					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div> -->
					<span class="hidden" id="loginResult" style="color:#fff; font-size:1rem"></span>

					<!-- <div class="container-login100-form-btn" style="background-color:white;">
						<input style="color:aqua" class="login100-form-btn" type="submit" name="login" value="Login">
					</div> -->
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="login">
							Login
						</button>
					</div>

					<div class="text-center p-t-90" style="color:white">
						<a class="txt1" href="#">
							Forgot Password?
						</a>
						<br>
						Not Registered?
						<a style="color:#50ac52;font-weight:900;" href="register.php">
							Signup Now
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="loginvendor/jquery/jquery-3.2.1.min.js"></script>

	<script src="loginvendor/animsition/js/animsition.min.js"></script>
	<script src="loginvendor/bootstrap/js/popper.js"></script>
	<script src="loginvendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="loginvendor/select2/select2.min.js"></script>
	<script src="loginvendor/daterangepicker/moment.min.js"></script>
	<script src="loginvendor/daterangepicker/daterangepicker.js"></script>
	<script src="loginvendor/countdowntime/countdowntime.js"></script>
	<script src="loginjs/main.js"></script>





</body>

</html>