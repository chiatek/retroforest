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
                                    <a href="<?php echo site_url('admin/database/archive'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                        <span class="icon mr-3"><i class="fa fa-archive"></i></span>Backup/Restore
                                    </a>
                                    <a href="<?php echo current_url(); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                        <span class="icon mr-3"><i class="fa fa-folder-open-o"></i></span><?php echo ucfirst($table); ?>
                                    </a>
                                    <a href="<?php echo site_url('admin/database/insert_column/'.$table); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Column
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-10 mt-70">

                        <div class="table-responsive pt-5">
                            <table id="edit-table" class="table table-striped table-bordered">
                                <?php

                                    $key = '';

                                    if (isset($table)) {
                                        echo '<thead><tr class="table-primary"><th></th>';

                                        for ($i = 0; $i < $query->columnCount(); $i++) {
                                            $col = $query->getColumnMeta($i);

                                            echo '<th>' . $col['name'] . '</th>';
                                        }

                                        echo '</tr></thead><tbody>';

                                        for ($i = 0; $i < $query->rowCount(); $i++) {
                                            $row = $query->fetch(PDO::FETCH_ASSOC);

                                            echo '<tr>';

                                            for ($j = 0; $j < $query->columnCount(); $j++) {
                                                $col = $query->getColumnMeta($j);

                                                if (isset($row['column_name'])) {
                                                    $key = $row['column_name'];
                                                }

                                                if ($j == 0) {
                                                    echo '<td><div class="form-check"><input class="form-check-input delete-chk" name="delete[]" form="delete-form" type="checkbox" value="'.$key.'"></div></td>';
                                                }

                                                echo '<td><a href="'.site_url('admin/database/edit_column/'.$table.'/'.$key).'" class="text-dark table-link">'.$row[$col['name']].'</a></td>';
                                            }

                                            echo '</tr>';
                                        }

                                        echo '</tbody>';
                                    }
                                    else {
                                        show_error_404();
                                    }

                                ?>
                            </table>
                        </div>

                        <form action="<?php echo site_url('admin/database/delete/'.$table); ?>" method="post" id="delete-form">
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
