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
                                    <a href="<?php echo site_url('admin/database/archive'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                        <span class="icon mr-3"><i class="fa fa-archive"></i></span>Backup/Restore
                                    </a>
                                    <a href="<?php echo site_url('admin/database/query/'.$table); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="icon mr-3"><i class="fa fa-binoculars"></i></span><?php echo ucfirst($table); ?>
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo current_url(); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-plus-square-o"></i></span>Insert into <?php echo $table; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-70">

                        <div class="card">
                            <div class="card-body">

                                <?php

                                    for ($j = 0; $j < $query->columnCount(); $j++) {
                                        $col = $query->getColumnMeta($j);

                                        // If the column is not null make the field required
                                        if (in_array('not_null', $col['flags']) == TRUE) {
                                            $required = ' required';
                                        }
                                        else {
                                            $required = '';
                                        }

                                        echo '<div class="form-group">
                                              <label class="form-label">'.$col['name'].'</label>';

                                        // Column is a primary key
                                        if (in_array('primary_key', $col['flags']) == TRUE) {
                                            echo '<input type="text" class="form-control" name="'.$col['name'].'" form="table-form" value="'.$auto_increment.'" maxlength="'.$col['len'].'" required>';
                                        }
                                        // Column is a foreign key or key|index
                                        else if (in_array('multiple_key', $col['flags']) == TRUE) {
                                            $ref_table = $this->database->referenced_table($col['table'], $col['name']);
                                            if (!empty($ref_table)) {
                                                $ref_table_query = $this->database->query("SELECT ".$col['name']." FROM ".$database.'.'.$ref_table);

                                                echo '<select class="custom-select" name="'.$col['name'].'" form="table-form">'.
                                                     '<option value="none"></option>';

                                                while ($ref = $ref_table_query->fetch()) {
                                                    echo '<option value="'.$ref->{$col['name']}.'">'.$ref->{$col['name']}.'</option>';
                                                }

                                                echo '</select>';
                                            }
                                            else {
                                                // Column is type INT or LONG
                                                if ($col['native_type'] == 'INT' || $col['native_type'] == 'LONG') {
                                                    echo '<input type="number" class="form-control" name="'.$col['name'].'" form="table-form"'.$required.'>';
                                                }
                                                // All other column data types
                                                else {
                                                    echo '<input type="text" class="form-control" name="'.$col['name'].'" form="table-form" maxlength="'.$col['len'].'"'.$required.'>';
                                                }
                                            }
                                        }
                                        // Column is type BLOB
                                        else if ($col['native_type'] == 'BLOB') {
                                            echo '<textarea class="form-control" rows="8" name="'.$col['name'].'" form="table-form"></textarea>';
                                        }
                                        // Column is type DATE
                                        else if ($col['native_type'] == 'DATE') {
                                            echo '<input type="date" class="form-control" name="'.$col['name'].'" form="table-form"'.$required.'>';
                                        }
                                        // Column is type DATETIME
                                        else if ($col['native_type'] == 'DATETIME') {
                                            echo '<input type="datetime-local" class="form-control" name="'.$col['name'].'" form="table-form"'.$required.'>';
                                        }
                                        // Column is type INT or LONG
                                        else if ($col['native_type'] == 'INT' || $col['native_type'] == 'LONG') {
                                            echo '<input type="number" class="form-control" name="'.$col['name'].'" form="table-form"'.$required.'>';
                                        }
                                        // Column is type FLOAT
                                        else if ($col['native_type'] == 'FLOAT') {
                                            echo '<input type="number" step="0.001" class="form-control" name="'.$col['name'].'" form="table-form"'.$required.'>';
                                        }
                                        // All other column data types
                                        else {
                                            echo '<input type="text" class="form-control" name="'.$col['name'].'" form="table-form" maxlength="'.$col['len'].'"'.$required.'>';
                                        }

                                        echo '</div>';
                                    }

                                ?>

                            </div>

                            <form action="<?php echo site_url('admin/database/insert_query/'.$table); ?>" method="post" id="table-form">
                                <div class="text-right mr-5 mt-3 pb-5">
                                    <button type="submit" class="btn btn-primary save-btn spinner">Save</button>&nbsp;
                                    <a href="<?php echo site_url('admin/database'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
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

</body>
</html>
