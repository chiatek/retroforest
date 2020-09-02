<!-- Widgets -->
<div class="d-flex p-0 m-0">
    <?php if (isset($total_comments)): ?>
    <div class="border-primary flex-fill">
        <div class="card">
            <div class="card-body bg-primary">
                <div class="row">
                    <div class="col-3 text-light">
                        <i class="fa fa-comments widget-icon"></i>
                    </div>
                    <div class="col-9 text-light text-right">
                        <h2 class="text-light"><?php echo $total_comments; ?></h2>
                        <div class="widget-heading">Comments</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo site_url('admin/comments'); ?>">
                <div class="card-footer text-primary">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>
    <?php if (isset($total_posts) && (config('key_file_location') == NULL || !$config->setting_dashboard_GA)): ?>
    <div class="border-success flex-fill pl-3">
        <div class="card">
            <div class="card-body bg-success">
                <div class="row">
                    <div class="col-3 text-light">
                        <i class="fa fa-tasks widget-icon"></i>
                    </div>
                    <div class="col-9 text-light text-right">
                        <h2 class="text-light"><?php echo $total_posts; ?></h2>
                        <div class="widget-heading">Posts</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo site_url('admin/posts'); ?>">
                <div class="card-footer text-success">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>
    <?php if (isset($page_views) && config('key_file_location') != NULL && $config->setting_dashboard_GA): ?>
    <div class="border-danger flex-fill pl-3">
        <div class="card">
            <div class="card-body bg-danger">
                <div class="row">
                    <div class="col-3 text-light">
                        <i class="fa fa-desktop widget-icon"></i>
                    </div>
                    <div class="col-9 text-light text-right">
                        <?php
                            if ($page_views) {
                                echo '<h2 class="text-light">' . $page_views[0][0] . '</h2>';
                            }
                            else {
                                echo '<h2 class="text-light">0</h2>';
                            }
                        ?>
                        <div class="widget-heading">Views this Week</div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-danger">
                <span class="pull-left"></span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<!-- End Widgets -->
