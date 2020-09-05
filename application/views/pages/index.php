<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Retro Forest</title>
	<meta name="description" content="retro forest">
	<meta name="keywords" content="">
	<meta name="author" content="Steve Chiarelli">
	<meta name="subject" content="">

	<!-- Favicon Icon -->
	<link rel="icon" type="image/png" href="<?php echo site_url("assets/img/admin/favicon.png"); ?>">
	<link rel="apple-touch-icon" href="<?php echo site_url("assets/img/admin/favicon.png"); ?>">

	<!-- CSS -->
    <link rel="stylesheet" href="<?php echo site_url("assets/vendor/bootstrap/css/bootstrap.css"); ?>">
    <link rel="stylesheet" href="<?php echo site_url("assets/vendor/owlcarousel/assets/owl.carousel.min.css"); ?>">
	<link rel="stylesheet" href="<?php echo site_url("assets/vendor/fontawesome/css/font-awesome.min.css"); ?>">
	<link rel="stylesheet" href="<?php echo site_url(config("css")); ?>">
</head>
<body>

    <div class="progress">
        <div class="progress-bar" id="progress"></div>
    </div>

	<!-- Wrapper -->
	<div class="wrapper">

		<!-- Main Content -->
		<main class="content">

            <?php $this->view("sections/menu", $data); ?>

            <?php $this->view("sections/parallax", $data); ?>

            <div class="page-content lax" data-lax-translate-y="0 0, 400 -600" data-lax-opacity="0 0, 150 1">

                <?php $this->view("sections/featured", $data); ?>

                <?php $this->view("sections/latest_posts", $data); ?>

                <?php $this->view("sections/carousel", $data); ?>

                <?php $this->view("sections/footer", $data); ?>

            </div>

		</main>
		<!-- End Main Content -->

    </div>
    <!-- End Wrapper -->

    <!-- Base Javascript -->
    <script src="https://code.createjs.com/1.0.0/preloadjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lax.js"></script>
	<script src="<?php echo site_url("assets/vendor/jquery/jquery-3.3.1.min.js"); ?>" type="text/javascript"></script>
	<script src="<?php echo site_url("assets/vendor/bootstrap/js/popper.min.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url("assets/vendor/bootstrap/js/bootstrap.min.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url("assets/vendor/owlcarousel/owl.carousel.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url("assets/js/frontend.js"); ?>" type="text/javascript"></script>

</body>
</html>
