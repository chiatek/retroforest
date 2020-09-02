<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (isset($post)): ?>
    <title><?php echo $post->post_title; ?></title>
    <meta name="description" content="<?php echo $post->post_meta_description; ?>">
    <meta name="keywords" content="<?php echo $post->post_meta_keywords; ?>">
    <meta name="author" content="<?php echo $post->post_author; ?>">
    <meta name="subject" content="<?php echo $post->post_meta_caption; ?>">
    <?php endif; ?>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="<?php echo site_url('assets/img/admin/favicon.png'); ?>">
    <link rel="apple-touch-icon" href="<?php echo site_url('assets/img/admin/avicon.png'); ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo site_url("assets/vendor/bootstrap/css/bootstrap.css"); ?>">
    <link rel="stylesheet" href="<?php echo site_url("assets/vendor/fontawesome/css/font-awesome.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo site_url(config('css')); ?>">
</head>
<body>

	<!-- Wrapper -->
	<div class="wrapper">

		<!-- Main Content -->
		<main class="content">

            <div class="header">
                <?php $this->view("sections/menu", $data); ?>
            </div>

			<!-- Page Content -->
			<div class="blog-container">

                <div class="row">
                    <div class="col-lg-8">

                        <?php $this->view("sections/blog_post", $data); ?>

                        <?php $this->view("sections/comments", $data); ?>

                    </div>
                    <div class="col-md-4 pl-5">

                        <?php $this->view("sections/sidebar_widgets_column", $data); ?>

                    </div>
                </div>

			</div>
			<!-- End Page Content -->

            <?php $this->view("sections/footer"); ?>

		</main>
		<!-- End Main Content -->

    </div>
    <!-- End Wrapper -->

    <!-- Base Javascript -->
    <script src="<?php echo site_url("assets/vendor/jquery/jquery-3.3.1.min.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url("assets/vendor/bootstrap/js/popper.min.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url("assets/vendor/bootstrap/js/bootstrap.min.js"); ?>" type="text/javascript"></script>

</body>
</html>
