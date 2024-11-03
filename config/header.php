
<style>
	.app-header {

    background: #3F7791;
	}

</style>

<div class="app-header d-flex align-items-center">

	<!-- Toggle buttons start -->
	<div class="d-flex">
		<button class="btn btn-outline-success toggle-sidebar" id="toggle-sidebar">
			<i class="icon-menu"></i>
		</button>
		<button class="btn btn-outline-danger pin-sidebar" id="pin-sidebar">
			<i class="icon-menu"></i>
		</button>
	</div>
	<!-- Toggle buttons end -->

	<!-- App brand sm start -->
	<!-- <div class="app-brand-sm d-md-none d-sm-block">
	<a href="home.php">
		<img src="#" >
	</a>
</div> -->
	<!-- App brand sm end -->

	<!-- Search container start -->

	<!-- Search container end -->

	<!-- App header actions start -->
	<div class="header-actions">
		<div class="d-md-flex d-none gap-2 mt-2">

			
			<div class="dropdown ms-3">
				<a class="dropdown-toggle d-flex align-items-center" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">

				<img src="<?php echo (!empty($user['profile_picture'])) ? 'user_images/' . $user['profile_picture'] : 'user_images/profile.jpg'; ?>" class="img-3x m-2 ms-0 rounded-5" alt="user image" />
					<div class="d-flex flex-column">

						<span style="color: #fff;"><?php echo $user['first_name'] . ' ' . $user['lastname']; ?></span>

					</div>
				</a>

			</div>
		</div>

	</div>
	<!-- App header actions end -->

</div>