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
                        <h3 class="page-title mb-2 mt-4"><?php echo $database; ?></h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <?php if ($user->user_role == "administrator"): ?>
                                    <a href="<?php echo site_url('admin/database'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-sitemap"></i></span>All Tables
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo site_url('admin/database/saved_query'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-hdd-o"></i></span>Saved Queries
                                </a>
                                <?php if ($user->user_role == "administrator"): ?>
                                    <a href="<?php echo site_url('admin/database/sql'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-terminal"></i></span>SQL Query
                                    </a>
                                    <a href="<?php echo site_url('admin/database/archive'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-archive"></i></span>Backup/Restore
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($ref_table)): ?>
                                    <a href="<?php echo site_url('admin/database/saved_query/'.$id); ?>" class="list-group-item list-group-item-action d-flex align-items-center mt-3">
                                        <span class="icon mr-3"><i class="fa fa-binoculars"></i></span><?php echo ucfirst($table) . ' / ' . ucfirst($ref_table); ?>
                                    </a>
                                    <a href="<?php echo current_url(); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                        <span class="icon mr-3"><i class="fa fa-pencil"></i></span>Edit <?php echo $primary_key . ' ' . $pkey_val; ?>
                                    </a>
                                <?php elseif (segment(3) == 'saved_query'): ?>
                                    <a href="<?php echo site_url('admin/database/saved_query/'.$id); ?>" class="list-group-item list-group-item-action d-flex align-items-center mt-3">
                                        <span class="icon mr-3"><i class="fa fa-binoculars"></i></span><?php echo ucfirst($table); ?>
                                    </a>
                                    <a href="<?php echo current_url(); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                        <span class="icon mr-3"><i class="fa fa-pencil"></i></span>Edit <?php echo ucfirst($primary_key) . ' ' . $pkey_val; ?>
                                    </a>
                                <?php elseif (segment(3) == 'edit_saved_query'): ?>
                                    <a href="<?php echo site_url('admin/database/saved_query'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mt-3">
                                        <span class="icon mr-3"><i class="fa fa-binoculars"></i></span><?php echo ucfirst($table); ?>
                                    </a>
                                    <a href="<?php echo current_url(); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                        <span class="icon mr-3"><i class="fa fa-pencil"></i></span>Edit <?php echo $primary_key . ' ' . $pkey_val; ?>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo site_url('admin/database/query/'.$table); ?>" class="list-group-item list-group-item-action d-flex align-items-center mt-3">
                                        <span class="icon mr-3"><i class="fa fa-binoculars"></i></span><?php echo ucfirst($table); ?>
                                    </a>
                                    <a href="<?php echo current_url(); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                        <span class="icon mr-3"><i class="fa fa-pencil"></i></span>Edit <?php echo $primary_key . ' ' . $pkey_val; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card mt-70">

                            <div class="card-body">

                                <?php

                                    if (!empty($ref_table) && isset($ref_query)) {
                                        $this->database->display_ref_table($ref_query);
                                        echo '<br /><hr /><br />';
                                    }

                                    $this->database->display_table($query);

                                ?>

                            </div>

                            <?php if (segment(3) == 'edit_saved_query'): ?>
                                <form action="<?php echo site_url('admin/database/edit_saved_query/'.$table.'/'.$primary_key.'/'.$pkey_val); ?>" method="post" id="table-form">
                                    <div class="text-right mr-5 mt-3 pb-5">
                                        <button type="submit" class="btn btn-primary save-btn spinner">Save</button>&nbsp;
                                        <a href="<?php echo site_url('admin/database/saved_query'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
                                    </div>
                                </form>
                            <?php elseif (segment(3) == 'saved_query'): ?>
                                <form action="<?php echo site_url('admin/database/saved_query/'.$id.'/'.$pkey_val); ?>" method="post" id="table-form">
                                    <div class="text-right mr-5 mt-3 pb-5">
                                        <button type="submit" class="btn btn-primary save-btn spinner">Save</button>&nbsp;
                                        <a href="<?php echo site_url('admin/database/saved_query'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
                                    </div>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo site_url('admin/database/edit_query/'.$table.'/'.$primary_key.'/'.$pkey_val); ?>" method="post" id="table-form">
                                    <div class="text-right mr-5 mt-3 pb-5">
                                        <button type="submit" class="btn btn-primary save-btn spinner">Save</button>&nbsp;
                                        <a href="<?php echo site_url('admin/database'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
                                    </div>
                                </form>
                            <?php endif; ?>

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

</body>
</html>
