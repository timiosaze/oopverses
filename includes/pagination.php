<?php if($paginate->page_total() > 1){ ?>
	<?php if($paginate->has_previous()){ ?>
		<div class="prev col text-center">
			<?php $address_prev = "fav-verses.php?user_id=" . urlencode(Session::get_id()) . "&page={$paginate->previous()}"; ?>
			<a href="<?php echo $address_prev; ?>" class="btn btn-sm btn-outline-danger">Prev</a>
		</div>
	<?php } ?>
	<?php if($paginate->has_next()){ ?>
		<div class="next col text-center">
			<?php $address_next = "fav-verses.php?user_id=" . urlencode(Session::get_id()) . "&page={$paginate->next()}"; ?>
			<a href="<?php echo $address_next; ?>" class="btn btn-sm btn-outline-danger">Next</a>
		</div>
	<?php } } ?>	
