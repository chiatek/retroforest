<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('admin/components/common/meta_css', $data); ?>
    <!-- Additional CSS / Morrisjs.css-->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/datatables/datatables.css'); ?>">
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
            <div class="container">
                    <h1 class="page-title"><?php echo "Welcome, ".$user->user_name; ?></h1>
                    <h3 class="page-subtitle pb-3"><small><?php echo "Today is ".date("l, F j, Y"); ?></small></h3>

                <div class="row">
                    <div class="col-md-6 col-lg-6 col-xl-6">

                    <?php

                    if ($config->setting_dashboard_widgets) {
                        $this->view('admin/components/dashboard/widgets', $data);
                    }

                    if ($config->setting_dashboard_GA && $config->setting_dashboard_posts && $config->setting_dashboard_pages) {
                        $this->view('admin/components/dashboard/analytics_chart', $data);
                        $this->view('admin/components/dashboard/analytics_stats', $data);
                    }
                    else if ($config->setting_dashboard_GA) {
                        $this->view('admin/components/dashboard/analytics_chart', $data);
                    }

                    if ($config->setting_dashboard_posts && !$config->setting_dashboard_widgets) {
                        $this->view('admin/components/dashboard/recent_posts', $data);
                    }

                    if ($config->setting_dashboard_pages && !$config->setting_dashboard_GA && !$config->setting_dashboard_comments) {
                        $this->view('admin/components/dashboard/recent_pages', $data);
                    }

                    if ($config->setting_dashboard_comments && (!$config->setting_dashboard_GA || !$config->setting_dashboard_posts || !$config->setting_dashboard_pages)) {
                        $this->view('admin/components/dashboard/latest_comments', $data);
                    }

                    ?>

                    </div>
                    <div class="col">

                    <?php

                    if ($config->setting_dashboard_GA && (!$config->setting_dashboard_posts || !$config->setting_dashboard_pages)) {
                        $this->view('admin/components/dashboard/analytics_stats', $data);
                    }

                    if ($config->setting_dashboard_posts && $config->setting_dashboard_widgets) {
                        $this->view('admin/components/dashboard/recent_posts', $data);
                    }

                    if ($config->setting_dashboard_pages && ($config->setting_dashboard_GA || $config->setting_dashboard_comments)) {
                        $this->view('admin/components/dashboard/recent_pages', $data);
                    }

                    if ($config->setting_dashboard_comments && ($config->setting_dashboard_GA && $config->setting_dashboard_posts && $config->setting_dashboard_pages)) {
                        $this->view('admin/components/dashboard/latest_comments', $data);
                    }

                    ?>

                    </div>

                </div>

                <?php echo $this->view('admin/components/dashboard/saved_queries', $data); ?>

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
    <!-- Additional Javascript / Morris.js -->
    <script src="<?php echo site_url('assets/vendor/datatables/datatables.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/admin/datatables.js'); ?>" type="text/javascript"></script>
    <?php if ($config->setting_dashboard_GA): ?>
    <script src="<?php echo site_url('assets/js/admin/analytics.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <?php endif; ?>

</body>
</html>
