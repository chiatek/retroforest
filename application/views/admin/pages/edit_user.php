<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('admin/components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
	<link rel="stylesheet" href="<?php echo site_url('assets/css/admin/admin.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/toastr/toastr.min.css'); ?>">
</head>

<body>

    <!-- Wrapper -->
	<div class="wrapper">

        <!-- Navbar -->
        <?php $this->view('admin/components/common/navbar', $data); ?>
        <!-- End Navbar -->

        <!-- Main Content -->
        <div class="content my-3 my-md-5">

            <!-- Page Content -->
            <div class="container">

                <div class="row no-gutters overflow-hidden">
                    <div class="col-md-3 pt-0">
                        <h3 class="page-title mb-2 mt-4">Users</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <?php if ($user->user_role == "administrator"): ?>
                                <a href="<?php echo site_url('admin/users'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-users"></i></span>All Users
                                </a>
                                <a href="<?php echo site_url('admin/users/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-user-plus"></i></span>New User
                                </a>
                                <?php endif; ?>
                                <a href="<?= site_url('admin/users/profile'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-user"></i></span>My Profile
                                </a>
                            </div>
                        </div>

                        <h3 class="page-title mb-2 mt-4">Edit User</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="#account" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-user-o"></i></span>Account
                                </a>
                                <a href="#information" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-info-circle"></i></span>Information
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 mt-35">
                        <div class="card tab-content">

                            <div class="tab-pane fade show active" id="account">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">User ID</label>
                                        <input type="text" class="form-control mb-1" name="user_id" value="<?php echo $row->user_id; ?>" disabled>
                                        <input type="hidden" name="user_id" form="user-form" value="<?php echo $row->user_id; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control mb-1" name="user_username" value="<?php echo $row->user_username; ?>" disabled>
                                        <input type="hidden" name="user_username" form="user-form" value="<?php echo $row->user_username; ?>" />
                                        <a href="<?php echo site_url('admin/users/reset_password/'.$row->user_id); ?>" class="small">Reset password</a>
                                        <?php if ($error == 0): ?>
                                            <div class="alert alert-warning mt-3">
                                                The password for user <i><?php echo $row->user_username ?></i> has been changed. The new password has been emailed to <i><?= $row->user_email ?></i>.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="user_name" form="user-form" value="<?php echo $row->user_name; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" class="form-control mb-1" name="user_email" form="user-form" value="<?php echo $row->user_email; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Company</label>
                                        <input type="text" class="form-control" name="user_company" form="user-form" value="<?php echo $row->user_company; ?>">
                                    </div>

                                    <p class="text-danger"><?php echo $this->form_validation->validation_errors(); ?></p>
                                </div>

                                <hr class="border-light m-0">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Role</label>
                                        <select class="custom-select" name="user_role" form="user-form">
                                            <option value="administrator" <?php echo ($row->user_role == 'administrator') ? "selected" : ""; ?>>Administrator</option>
                                            <option value="author" <?php echo ($row->user_role == 'author') ? "selected" : ""; ?>>Author</option>
                                            <option value="user" <?php echo ($row->user_role == 'user') ? "selected" : ""; ?>>User</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <select class="custom-select" name="user_status" form="user-form">
                                            <option value="active" <?php echo ($row->user_status == 'active') ? "selected" : ""; ?>>Active</option>
                                            <option value="banned" <?php echo ($row->user_status == 'banned') ? "selected" : ""; ?>>Banned</option>
                                            <option value="deleted" <?php echo ($row->user_status == 'deleted') ? "selected" : ""; ?>>Deleted</option>
                                        </select>
                                    </div>
									<div class="form-group">
										<label class="form-label">Avatar</label>
                                        <input type="text" class="form-control" name="user_avatar" form="user-form" value="<?php echo $row->user_avatar; ?>">
									</div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="information">
                                <div class="card-body">
                                    <h6 class="mb-4">Social links</h6>
                                    <div class="form-group">
                                        <label class="form-label">Twitter</label>
                                        <input type="text" class="form-control" name="user_twitter" form="user-form" value="<?php echo $row->user_twitter; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Facebook</label>
                                        <input type="text" class="form-control" name="user_facebook" form="user-form" value="<?php echo $row->user_facebook; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">YouTube</label>
                                        <input type="text" class="form-control" name="user_youtube" form="user-form" value="<?php echo $row->user_youtube; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">LinkedIn</label>
                                        <input type="text" class="form-control" name="user_linkedin" form="user-form" value="<?php echo $row->user_linkedin; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Instagram</label>
                                        <input type="text" class="form-control" name="user_instagram" form="user-form" value="<?php echo $row->user_instagram; ?>">
                                    </div>
                                </div>

                                <hr class="border-light m-0">

                                <div class="card-body">
                                    <h6 class="mb-4">Personal info</h6>
                                    <div class="form-group">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control" name="user_bio" form="user-form" rows="5"><?php echo $row->user_bio; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Birthday</label>
                                        <input type="date" class="form-control" name="user_birthday" form="user-form" value="<?php echo $row->user_birthday; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Country</label>
                                        <input type="text" class="form-control" name="user_country" form="user-form" value="<?php echo $row->user_country; ?>">
                                    </div>
                                </div>

                                <hr class="border-light m-0">

                                <div class="card-body">
                                    <h6 class="mb-4">Contacts</h6>
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="user_phone" form="user-form" value="<?php echo $row->user_phone; ?>">
                                    </div>
                                </div>
                            </div>

                            <form action="<?php echo site_url('admin/users/edit/'.$pkey_val); ?>" method="post" id="user-form">
                                <div class="text-right mr-5 mt-3 pb-5">
                                    <button type="submit" class="btn btn-primary save-btn spinner">Save changes</button>&nbsp;
                                    <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>
            <!-- End Page Content -->

		</div>
		<!-- End Main Content -->

        <!-- Toastr -->
        <?php $this->view('admin/components/common/toastr'); ?>
        <!-- End Toastr -->

        <!-- Footer -->
        <?php $this->view('admin/components/common/footer', $data); ?>
        <!-- End Footer -->

    </div>
    <!-- End Wrapper -->

    <!-- Base Javascript -->
    <?php $this->view('admin/components/common/javascript', $data); ?>
    <!-- Additinal Javascript -->
    <script src="<?php echo site_url('assets/vendor/toastr/toastr.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/admin/toastr.js'); ?>" type="text/javascript"></script>

</body>
</html>
