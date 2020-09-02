<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('admin/components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/datatables/datatables.css'); ?>">
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

                    <div class="col-lg-2 pt-0">
                        <?php if ($file_type == 'media'): ?>
                        <h3 class="page-title mb-2 mt-4">Media</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="<?php echo site_url('admin/media'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-book"></i></span>Library
                                </a>
                                <a href="<?php echo site_url('admin/media/upload'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-plus-circle"></i></span>New Media
                                </a>
                            </div>
                        </div>
                        <?php else: ?>
                        <h3 class="page-title mb-2 mt-4">Pages</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="<?php echo site_url('admin/pages'); ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo (segment(2) == 'pages') ? "active" : ""; ?>">
                                    <span class="icon mr-3"><i class="fa fa-pencil-square"></i></span>Pages
                                </a>
                                <a href="<?php echo site_url('admin/templates'); ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo (segment(2) == 'templates') ? "active" : ""; ?>">
                                    <span class="icon mr-3"><i class="fa fa-address-card"></i></span>Templates
                                </a>
                                <a href="<?php echo site_url('admin/sections'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3 <?php echo (segment(2) == 'sections') ? "active" : ""; ?>">
                                    <span class="icon mr-3"><i class="fa fa-puzzle-piece"></i></span>Sections
                                </a>

                                <?php if (segment(2) == 'pages'): ?>
                                    <a href="<?php echo site_url('admin/pages/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Page
                                    </a>
                                <?php endif; ?>
                                <?php if (segment(2) == 'templates'): ?>
                                    <a href="<?php echo site_url('admin/templates/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Template
                                    </a>
                                <?php endif; ?>
                                <?php if (segment(2) == 'sections'): ?>
                                    <a href="<?php echo site_url('admin/sections/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Section
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>

                    <div class="col-lg-10 mt-70">

                        <div class="table-responsive">
                            <table id="edit-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-primary">
                                        <th></th>
                                        <?php if ($file_type == "media"): ?>
                                        <th>Image</th>
                                        <?php endif; ?>
                                        <th>Name</th>
                                        <th>Path</th>
                                        <th>Size</th>
                                        <th>Date</th>
                                        <?php if (segment(2) == "templates"): ?>
                                        <th>Type</th>
                                        <?php endif; ?>
                                        <?php if ($file_type != "templates"): ?>
                                        <th>Status</th>
                                        <?php endif; ?>
                                </thead>
                                <tbody>
                                    <?php foreach ($file_info as $file): ?>

                                        <?php
                                            if ($file_type == "templates") {
                                                $type = $this->page->get_section_name($file['relative_path'], TRUE);
                                                if ($type != 'pages') {
                                                    $path = site_url('admin/templates/edit/'.$type.'/'.$file['name']);
                                                }
                                                else {
                                                    $path = site_url('admin/templates/edit/templates/'.$file['name']);
                                                }
                                            }
                                            else if ($file_type == "sections") {
                                                $path = site_url('admin/sections/edit/'.$file['name']);
                                            }
                                            else {
                                                $path = site_url('admin/'.$file_type.'/edit/'.$file['name']);
                                            }
                                        ?>

                                        <tr>
                                            <td><div class="form-check"><input class="form-check-input delete-chk" name="delete[]" form="delete-form" type="checkbox" value="<?php echo $file['server_path']; ?>"></div></td>
                                            <?php if ($file_type == "media"): ?>
                                                <td><a href="<?php echo $path; ?>" class="text-dark table-link"><img class="media-thumbnail" src="<?php echo site_url('assets/img/uploads').'/'.$file['name']; ?>"></a></td>
                                            <?php endif; ?>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><?php echo $file['name']; ?></a></td>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><?php echo $file['relative_path']; ?></a></td>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><?php echo $file['size'].' bytes'; ?></a></td>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><?php echo format_timestamp($file['date']); ?></a></td>
                                            <?php if (segment(2) == "templates"): ?>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><?php echo $this->page->get_section_name($file['relative_path'], TRUE); ?></a></td>
                                            <?php endif ?>
                                            <?php if ($file_type != "templates"): ?>
                                            <td><a href="<?php echo $path; ?>" class="text-dark table-link"><?php echo $this->page->get_status($file['relative_path']); ?></a></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <form action="<?php echo site_url('admin/'.$file_type.'/delete'); ?>" method="post" id="delete-form">
                            <div class="text-left mt-3">
                                <?php if ($user->user_role == "administrator"): ?>
                                    <button type="submit" Onclick="return confirm_delete();" class="btn btn-primary delete-btn spinner" disabled>Delete</button>
                                <?php else: ?>
                                    <button type="button" Onclick="return confirm_delete();" class="btn btn-primary" disabled>Delete</button>
                                <?php endif; ?>
                            </div>
                        </form>

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
    <script src="<?php echo site_url('assets/vendor/datatables/datatables.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/toastr/toastr.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/admin/datatables.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/admin/toastr.js'); ?>" type="text/javascript"></script>

</body>
</html>
