<div class="modal fade" id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="profile">
					Admin Profile
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">

				<form method="POST" enctype="multipart/form-data">

					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Name</label>
						<div class="col-sm-8">
							<input type="text" id="fname" name="fname" class="form-control" placeholder="Full Name" required>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Username</label>
						<div class="col-sm-8">
							<input type="text" id="uname" name="uname" class="form-control" placeholder="Username" required>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Password</label>
						<div class="col-sm-8">
							<input type="text" id="pass" name="pass" class="form-control" placeholder="Password" required>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Contact #</label>
						<div class="col-sm-8">
							<input type="text" id="contact" name="contact" class="form-control" placeholder="Contact #" required>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Email</label>
						<div class="col-sm-8">
							<input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Role</label>
						<div class="col-sm-5">

							<select name="Role" id="Role" class="form-select" required>
								<?php echo getrole(); ?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Status</label>
						<div class="col-sm-5">

							<select name="status" id="status" class="form-select" required>
								<?php echo getstatus(); ?>
							</select>
						</div>
					</div>

					<div class="mb-3 row">
						<label for="formFile" class="col-sm-3 col-form-label text-center">Profile Picture</label>
						<div class="col-sm-8 ">
							<input class="form-control" id="profile" name="profile" type="file">
						</div>
					</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn " data-bs-dismiss="modal">
					Close
				</button>
				<button type="submit" id="save_user" name="save_user" class="btn btn-primary">
					Save
				</button>

			</div>
		</div>

		</form>
	</div>
</div>