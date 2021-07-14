<?php
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1); 
	error_reporting(E_ALL); 
	include "app/init.php";
	ob_start();
	Session::start();

?>
<?php 
	//Check if there is a user_id sent
	if(isset($_GET['user_id']) && !empty($_GET['user_id'])){
		$user_id = $_GET['user_id'];
	} else {
		header("Location: index.php");
	}
 ?>
<?php 
	//Check if User has logged in
	if(Session::get_login() != null){

	} else {
		header("Location: index.php");
		die();
	}
 ?>
 <?php if(isset($_GET['del_id']) && !empty($_GET['del_id']) AND isset($_GET['user_id']) && !empty($_GET['user_id'])){
 		if(Session::get_id() == $_GET['user_id']){
 			$del_id = $_GET['del_id'];
 			$user_id = $_GET['user_id'];

 			$verse = new Verses();
 			if($verse->delete($del_id,$user_id)){
 				Session::set('success_message', 'Verse successfully deleted');
 			} else {
 				Session::set('error_message', 'Verse not deleted');
 			}

	 	} else {
	 		header("Location: index.php");
	 	}
	 }

 ?>
<?php 
	if(isset($_POST['submit'])){

		if(isset($_POST['verse']) && !empty($_POST['content']) AND isset($_POST['content']) && !empty($_POST['content'])) {
			$verses = new Verses();
			$verses->verse = $_POST['verse'];
			$verses->content = $_POST['content'];
			$verses->user_id = $user_id;

			if($verses->create()){
				Session::set('success_message', 'Verse created successfully');
			}

		} else {
			Session::set('error_message', 'No field must be blank');
		}

	}
 ?>
<?php include "includes/header.php"; ?>
<body>
	<?php include "includes/navbar.php"; ?>
	<div class="container-fluid">
		<section class="myfav">
			<p class="title">Favorite Verse</p>
			<form action="" class="fav-form" method="post">
				<?php include_once "includes/alerts.php"; ?>
				<div class="mb-3">
				  <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Verse" name="verse">
				</div>
				<div class="mb-3">
				  <textarea class="form-control" id="exampleFormControlTextarea1" rows="4" placeholder="Content" name="content"></textarea>
				</div>
				<button type="submit" class="btn btn-danger float-end" name="submit">Save</button>
				<div class="clearfix"></div>
			</form>
		</section>
	</div>
	<div class="container-fluid">
		<section class="myfav">
			<p class="verses">Verses <span class="no-verses float-end">
				<?php 
					$verses = new Verses();
					echo $verses->count($user_id); 
				?>
				</span>
			</p>
			<div class="clearfix"></div>
			<ul>
				<?php 
					$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
					$items_per_page = 3;
					$paginate = new Paginate($page, $items_per_page, $verses->count($user_id));
					$sql = "SELECT * FROM verses WHERE ";
					$sql .= "user_id = $user_id ";
					$sql .= "LIMIT {$items_per_page} ";
					$sql .= "OFFSET {$paginate->offset()} ";
					
					$the_verses = $verses->find_by_query($sql);


				 ?>
				<?php foreach ($the_verses as $verse): ?>
				<li>
					<div class="verse-content">
						<div>
							<p class="verse"><?php echo $verse->verse; ?></p>
						</div>
						<div>
							<p class="content"><?php echo $verse->content; ?></p>
						</div>
					</div>
					<div class="verse-actions">
						<div class="container-fluid">
							<div class="row">
								<div class="col text-center">
									<?php $edit_address = "editfav-verses.php?user_id=" . urlencode($verse->user_id) . "&id=" . urlencode($verse->id); ?>
									<a href=<?php echo $edit_address; ?>>Edit</a>
								</div>
								<div class="col text-center">
									<form id="delete-verse" action="post">
										<a href="fav-verses.php?del_id=<?php echo $verse->id; ?>&user_id=<?php echo $verse->user_id; ?>" onclick="document.getElementById('delete-verse').submit();">Delete</a>
									</form>
								</div>
							</div>
						</div>
					</div>
				</li>
				
				<?php endforeach; ?>

			</ul>
		</section>
		<section class="myfav">
			<div class="pagination row">
				<?php 
					 include "includes/pagination.php";
				 ?>
				
			</div>
		</section>
	</div>
	<?php include "includes/footer.php"; ?>