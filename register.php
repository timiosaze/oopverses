<?php
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1); 
	error_reporting(E_ALL); 
	include "app/init.php";
	ob_start();
	Session::start();
	// echo "<pre>";
	// print_r($_SESSION);
	// echo "</pre>";
?>
<?php 
	
	if(isset($_POST['register'])){
		
		$username 		  = trim($_POST['username']);
		$password 		  = trim($_POST['password']);
		$email			  = trim($_POST['email']);
		$c_password 	  = trim($_POST['c_password']);

		if($password === $c_password){
			$user = new User();
			if($user->check_mail($email)){
				$hashed_password = password_hash($password, PASSWORD_BCRYPT, array("cost" => 10));
				$user->username = $username;
				$user->password = $hashed_password;
				$user->email = $email;

				if($user->create()){
					Session::set_login($user->username);
					Session::set_id($user->id);
					$address = "fav-verses.php?user_id=" . urlencode(Session::get_id()) . "&page=1";
					header("Location: " . $address);
					exit();
				} else {
					Session::set('error_message', 'User not registered, Try again');
				}
			} else {
				Session::set('error_message', 'Email has been taken');
			}

		} else {
			Session::set('error_message', 'Passwords dont match');
		}
	}


 ?>
<?php include "includes/header.php"; ?>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <div class="container">
	    <a class="navbar-brand" id="logo" href="#">FV</a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarNavDropdown">
	      <ul class="navbar-nav ms-auto">
	      	<?php if(Session::get_login()): ?>
	      	<li class="nav-item dropdown">
	          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            <?php echo Session::get_login(); ?>
	          </a>
	          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
	            <li><a class="dropdown-item" href="includes/logout.php">Log Out</a></li>
	          </ul>
	        </li>
	        <?php else: ?>
	        <li class="nav-item">
	          <a class="nav-link" aria-current="page" href="index.php">Login</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="register.php">Register</a>
	        </li>
	    	<?php endif ?>
	      </ul>
	    </div>
	  </div>
	</nav>
	<section class="auth-pages">
		<div class="project-name">
			<p>Favorite Verses</p>			
		</div>
		<form action="" class="form" method="post">
			<?php include_once "includes/alerts.php"; ?>
			<p class="form-title">
				Register
			</p>
			<div class="mb-3">
			  <input type="text" class="form-control" id="formGroupExampleInput"  name="username" placeholder="Username" required>
			</div>
			<div class="mb-3">
			  <input type="email" class="form-control" id="formGroupExampleInput" name="email" placeholder="Email" required>
			</div>
			<div class="mb-3">
			  <input type="password" class="form-control" id="formGroupExampleInput" name="password" placeholder="Password" required>
			</div>
			<div class="mb-3">
			  <input type="password" class="form-control" id="formGroupExampleInput2" name="c_password" placeholder="Confirm Password" required>
			</div>
			<div class="col-12">
				<button type="submit" class="btn btn-danger float-end" name="register">Register</button>
			</div>
			<div class="clearfix"></div>
		</form>
	</section>
	<?php include "includes/footer.php"; ?>