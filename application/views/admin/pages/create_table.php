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
                                    <a href="<?php echo site_url('admin/database/table'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                        <span class="icon mr-3"><i class="fa fa-plus"></i></span>New Table
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10 mt-70">

                        <div class="table-responsive">
                            <table id="edit-table" class="table table-striped table-bordered">

                                <thead>
                                    <tr class="table-light">
                                        <th>Column Name</th>
                                        <th>Data Type</th>
                                        <th>Length/Values</th>
                                        <th>Not Null</th>
                                        <th>Auto Increment</th>
                                        <th>Primary Key</th>
                                        <th>Unique</th>
                                        <th>Foreign Key</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php for ($i = 0; $i < $columns; $i++): ?>
                                    <tr class="table-light">
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="<?php echo 'column_name_'.$i; ?>" form="database-form" placeholder="<?php echo $i == 0 ? "primary key" : "" ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select class="custom-select" name="<?php echo 'column_type_'.$i; ?>" form="database-form">
                                                    <optgroup label="Numeric">
                                                        <option value="int" selected>int</option>
                                                        <option value="tinyint">tinyint</option>
                                                        <option value="smallint">smallint</option>
                                                        <option value="mediumint">mediumint</option>
                                                        <option value="bigint">bigint</option>
                                                        <option value="decimal">decimal</option>
                                                        <option value="float">float</option>
                                                        <option value="double">double</option>
                                                        <option value="boolean">boolean</option>
                                                    </optgroup>

                                                    <optgroup label="String">
                                                        <option value="char">char</option>
                                                        <option value="varchar">varchar</option>
                                                        <option value="tinytext">tinytext</option>
                                                        <option value="text">text</option>
                                                        <option value="mediumtext">mediumtext</option>
                                                        <option value="longtext">longtext</option>
                                                        <option value="tinyblob">tinyblob</option>
                                                        <option value="mediumblob">mediumblob</option>
                                                        <option value="blob">blob</option>
                                                        <option value="longblob">longblob</option>
                                                        <option value="enum">enum</option>
                                                    </optgroup>

                                                    <optgroup label="Date and Time">
                                                        <option value="date">date</option>
                                                        <option value="datetime">datetime</option>
                                                        <option value="timestamp">timestamp</option>
                                                        <option value="time">time</option>
                                                        <option value="year">year</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="<?php echo 'column_length_'.$i; ?>" form="database-form">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="<?php echo 'column_null_'.$i; ?>" form="database-form" value="not null" <?php echo $i == 0 ? "checked disabled" : "" ?>>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="<?php echo 'column_ai_'.$i; ?>" form="database-form" value="auto_increment" <?php echo $i == 0 ? "checked disabled" : "" ?>>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="<?php echo 'column_pk_'.$i; ?>" form="database-form" value="primary key" <?php echo $i == 0 ? "checked disabled" : "disabled" ?>>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="<?php echo 'column_unique_'.$i; ?>" form="database-form" value="unique" <?php echo $i == 0 ? "disabled" : "" ?>>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="<?php echo 'column_fk_'.$i; ?>" form="database-form" placeholder="references" <?php echo $i == 0 ? "disabled" : "" ?>>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>

                            </table>
                        </div>

                        <form action="<?php echo site_url('admin/database/table/'.$table); ?>" method="post" id="database-form">
                            <div class="text-right mt-3 pb-5">
                                <button type="submit" class="btn btn-primary save-btn spinner">Create Table</button>&nbsp;
                                <a href="<?php echo site_url('admin/database'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
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
    <script src="<?php echo site_url('assets/vendor/toastr/toastr.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/admin/toastr.js'); ?>" type="text/javascript"></script>

</body>
</html>
