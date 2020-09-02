<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo site_url("assets/vendor/bootstrap/css/bootstrap.css"); ?>">
    <link rel="stylesheet" href="<?php echo site_url("assets/vendor/fontawesome/css/font-awesome.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo site_url(config('css')); ?>">
</head>
<body>

    <?php $this->view("admin/sections/".$file_name, $data); ?>

    <!-- Base Javascript -->
    <script src="<?php echo site_url("assets/vendor/jquery/jquery-3.3.1.min.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url("assets/vendor/bootstrap/js/popper.min.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url("assets/vendor/bootstrap/js/bootstrap.min.js"); ?>" type="text/javascript"></script>
    
</body>
</html>
