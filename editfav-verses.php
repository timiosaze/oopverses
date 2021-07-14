<?php
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1); 
	error_reporting(E_ALL); 
	include "app/init.php";
	ob_start();
	Session::start();
?>
<?php 
	if(isset($_GET['user_id']) && !empty($_GET['user_id']) AND isset($_GET['id']) && !empty($_GET['id'])){
		if(Session::get_id() == $_GET['user_id']){
			$user_id = $_GET['user_id'];
			$id = $_GET['id'];
		} else {
			header("Location: index.php");
		}
	} else {
			header("Location: index.php");
	}
	if(isset($_POST['update'])){
		$required = array('verse', 'content');
		$blank = false;
		foreach($required as $field){
			if(empty($_POST[$field])){
				$blank = true;
			}
		}
		
		if($blank == true){
			Session::set('error_message', 'Fields must not be blank');
		} else {
			$verse = trim($_POST['verse']);
			$content = trim($_POST['content']);

			$the_verse = new Verses();
			$the_verse->id = $id;
			$the_verse->user_id = $user_id;
			$the_verse->verse = $verse;
			$the_verse->content = $content;

			if($the_verse->update()){
				$address = "fav-verses.php?user_id=" . urlencode(Session::get_id()) . "";
				header("Location: " . $address);
				Session::set('success_message', 'Verse successfully updated');
				die();
			} else {
				Session::set('error_message', 'Verse not updated');
			}


		}
	}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Favorite Verses</title>
	<link rel="stylesheet" href="assets/bootstrap5.0.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/styles/stylesheet.css">
</head>
<body>
	<?php include "includes/navbar.php"; ?>
	<div class="container-fluid">
		<section class="myfav">
			<p class="title">Edit Favorite Verse</p>
			<form action="" class="fav-form" method="post">
				<?php include_once "includes/alerts.php"; ?>
				<?php 
					if(isset($_GET['user_id']) && !empty($_GET['user_id']) AND isset($_GET['user_id']) && !empty($_GET['user_id'])){
						if(Session::get_id() == $_GET['user_id']){
							$user_id = $_GET['user_id'];
							$id = $_GET['id'];
						} else {
							header("Location: index.php");
						}
					} else {
							header("Location: index.php");
					}
					$the_verse = new Verses();
					$vers = $the_verse->find_verse_by_id($id, $user_id);
				 ?>
				<div class="mb-3">
				  <input type="text" class="form-control" id="exampleFormControlInput1" name="verse" value="<?php echo $vers->verse; ?>">
				</div>
				<div class="mb-3">
				  <textarea class="form-control" id="exampleFormControlTextarea1" rows="4" name="content"><?php echo $vers->content; ?> </textarea>
				</div>
				<button type="submit" class="btn btn-danger float-end" name="update">Update</button>
				<div class="clearfix"></div>
			</form>
		</section>
	</div>
	
	<script src="assets/script/jquery-3.6.0.min.js"></script>
	<script src="assets/bootstrap5.0.2/js/bootstrap.min.js"></script>
	<script src="assets/script/scripts.js"></script>
</body>
</html>