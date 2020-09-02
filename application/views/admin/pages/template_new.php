<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('admin/components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
	<link rel="stylesheet" href="<?php echo site_url('assets/css/admin/admin.css'); ?>">
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
                        <h3 class="page-title mb-2 mt-4">Pages</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="<?php echo site_url('admin/pages'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-pencil-square"></i></span>Pages
                                </a>
                                <a href="<?php echo site_url('admin/templates'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-address-card"></i></span>Templates
                                </a>
                                <a href="<?php echo site_url('admin/sections'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                    <span class="icon mr-3"><i class="fa fa-puzzle-piece"></i></span>Sections
                                </a>
                                <a href="<?php echo site_url('admin/templates/insert'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Template
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-35">
                        <div class="card">

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" id="post_title" class="form-control" name="page_name">
                                </div>

                                <br />

                                <div class="form-group">
                                    <label class="form-label">File Name</label>
                                    <input type="text" id="post_slug" class="form-control" name="page_filename" form="page-form" value="" readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">File Type</label>
                                    <select class="custom-select" id="page_type" name="page_type" form="page-form">
                                        <option value="templates" selected>Page</option>
                                        <option value="sections">Section</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Section</label>
                                    <select class="custom-select" id="page_section" name="section" form="page-form">
                                        <?php foreach ($sections as $name => $path): ?>
                                        <option value="<?= $name; ?>"><?= ucfirst($name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="alert alert-warning mt-3" id="alert_section">
                                    Upload the blocks thumbnail image for this section to: <?php echo path('admin_thumbnails'); ?> <br>
                                    Give the image the same name as the section and be sure its in jpg format.
                                </div>

                                <p class="text-danger"><?php echo $this->form_validation->validation_errors(); ?></p>
                            </div>

                            <form action="<?php echo site_url('admin/templates/insert'); ?>" method="post" id="page-form">
                                <div class="text-right mr-5 mt-3 pb-5">
                                    <button type="submit" class="btn btn-primary save-btn spinner">Create Template</button>&nbsp;
                                    <a href="<?php echo site_url('admin'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
            <!-- End Page Content -->

		</div>
		<!-- End Main Content -->

        <!-- Footer -->
        <?php $this->view('admin/components/common/footer', $data); ?>
        <!-- End Footer -->

    </div>
    <!-- End Wrapper -->

    <!-- Base Javascript -->
    <?php $this->view('admin/components/common/javascript', $data); ?>

</body>
</html>
