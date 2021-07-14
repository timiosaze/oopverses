<?php
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1); 
	error_reporting(E_ALL); 
	include "app/init.php";
	ob_start();
	Session::start();
	
?>
<?php 

	//Check if User has been logged in and redirect
	if(Session::get_login() == null && Session::get_id() == null){

	} else {
		$address = "fav-verses.php?user_id=" . urlencode(Session::get_id()) .  "&page=1";
		header("Location: " . $address);
	}

 ?>
<?php 
	
	if(isset($_POST['submit'])){
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);

		//METHOD TO VERIFY
		$user = new User();
		$user_found = $user->verify_user($email, $password);
		if($user_found){
			foreach($user_found as $user){
				Session::set_login($user->username);
				Session::set_id($user->id);
			}
			$address = "fav-verses.php?user_id=" . urlencode(Session::get_id()) . "&page=1";
			header("Location: " . $address);
			die();
		} else {
			Session::set('error_message', 'Login details not correct');
		}

	}

 ?>
<?php include "includes/header.php"; ?>
<body>
	<?php include "includes/navbar.php"; ?>
	<section class="auth-pages">
		<div class="project-name">
			<p>Favorite Verses</p>			
		</div>
		<form action="" class="form" method="post">
			<p class="form-title">
				Sign In
			</p>
			<?php include_once "includes/alerts.php"; ?>
			<div class="mb-3">
			  <input type="email" class="form-control" id="formGroupExampleInput" placeholder="Email" name="email">
			</div>
			<div class="mb-3">
			  <input type="password" class="form-control" id="formGroupExampleInput2" placeholder="Password" name="password">
			</div>
			<div class="col-12">
				<button type="submit" class="btn btn-danger float-end" name="submit">Log In</button>
			</div>
			<div class="clearfix"></div>
			
		</form>
	</section>
	<?php include "includes/footer.php"; ?>