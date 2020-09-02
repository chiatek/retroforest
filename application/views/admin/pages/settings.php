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
                    <div class="col-md-3 pt-0">
                        <h3 class="page-title mb-2 mt-4">Settings</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="#settings-general" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-info-circle"></i></span>General
                                </a>
                                <a href="#settings-analytics" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-share-alt"></i></span>Analytics
                                </a>
                                <a href="#settings-backup" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-download"></i></span>Export
                                </a>
                                <a href="#settings-about" data-toggle="list" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-info-circle"></i></span>About
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-35">
                        <div class="card tab-content">

                            <div class="tab-pane fade show active" id="settings-general">

                                <div class="card-body">
                                    <h6 class="mb-4">General</h6><br />
                                    <div class="form-group">
                                        <label class="form-label">Site Address (URL)</label>
                                        <input type="text" class="form-control mb-1" value="<?php echo site_url(); ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Site Title</label>
                                        <input type="text" class="form-control mb-1" name="setting_title" form="settings-form" value="<?php echo $option->setting_title; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tagline</label>
                                        <input type="text" class="form-control" name="setting_tagline" form="settings-form" value="<?php echo $option->setting_tagline; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Site Icon</label>
										<div class="row">
											<div class="col-9">
												<input type="text" class="form-control" id="site-icon" name="setting_siteicon" form="settings-form" value="<?php echo $option->setting_siteicon; ?>" readonly>
											</div>
	                                        <div class="col-3">
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#icon-modal">Select</button>
											</div>
										</div>
                                        <div class="alert alert-warning mt-3">
                                            The format for the site icon must be 16x16 pixels or 32x32 pixels, using either 8-bit or 24-bit colors. The format of the image must be a PNG.
                                        </div>
                                    </div>

                                    <br />

                                </div>

                                <hr class="border-light m-0">

                                <div class="card-body">
                                    <h6 class="mb-4">Style</h6><br />
                                    <div class="form-group">
                                        <label class="form-label">Main CSS File</label>
                                        <input type="text" class="form-control mb-1" name="setting_css" form="settings-form" value="<?php echo config('css'); ?>" disabled>
                                    </div>
									<div class="form-group">
										<label class="form-label">Date/Time Format</label>
										<select class="custom-select" name="setting_datetime" form="settings-form">
											<option value="F d Y, h:i:s A" <?php echo ($option->setting_datetime == 'F d Y, h:i:s A') ? "selected" : ""; ?>>October 12 2018, 09:58:00 PM (F d Y, h:i:s A)</option>
											<option value="Y-m-d h:i:sa" <?php echo ($option->setting_datetime == 'Y-m-d h:i:sa') ? "selected" : ""; ?>>2014-08-12 11:14:54am (Y-m-d h:i:sa)</option>
                                            <option value="m/d/Y h:i:sa" <?php echo ($option->setting_datetime == 'm/d/Y h:i:sa') ? "selected" : ""; ?>>08/12/2018 11:14:54am (m/d/Y h:i:sa)</option>
                                            <option value="m.d.Y h:i:sa" <?php echo ($option->setting_datetime == 'm.d.Y h:i:sa') ? "selected" : ""; ?>>08.12.2018 11:14:54am (m.d.Y h:i:sa)</option>
                                            <option value="F d Y" <?php echo ($option->setting_datetime == 'F d Y') ? "selected" : ""; ?>>October 12 2018 (F d Y)</option>
										</select>
									</div>
                                </div>

                                <hr class="border-light m-0">

                                <div class="card-body">
                                    <h6 class="mb-4">Dashboard</h6><br />
                                    <div class="d-flex flex-wrap">
                                        <div class="form-check pr-4">
                                            <label class="form-check-label mb-2">
                                                <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_widgets" form="settings-form" value="1" <?php echo ($option->setting_dashboard_widgets == '1') ? "checked" : ""; ?>>
                                                Widgets
                                            </label>
                                        </div>
                                        <div class="form-check pr-4">
                                            <label class="form-check-label mb-2">
                                                <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_posts" form="settings-form" value="1" <?php echo ($option->setting_dashboard_posts == '1') ? "checked" : ""; ?>>
                                                Recent Posts
                                            </label>
                                        </div>
                                        <div class="form-check pr-4">
                                            <label class="form-check-label mb-2">
                                                <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_pages" form="settings-form" value="1" <?php echo ($option->setting_dashboard_pages == '1') ? "checked" : ""; ?>>
                                                Recent Pages
                                            </label>
                                        </div>
                                        <div class="form-check pr-4">
                                            <label class="form-check-label mb-2">
                                                <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_comments" form="settings-form" value="1" <?php echo ($option->setting_dashboard_comments == '1') ? "checked" : ""; ?>>
                                                Latest Comments
                                            </label>
                                        </div>
                                        <div class="form-check pr-4">
                                            <label class="form-check-label mb-2">
                                                <?php if (config('key_file_location') != NULL): ?>
                                                    <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_GA" form="settings-form" value="1" <?php echo ($option->setting_dashboard_GA == '1') ? "checked" : ""; ?>>
                                                <?php else: ?>
                                                    <input type="checkbox" class="form-check-input mb-2" name="setting_dashboard_GA" form="settings-form" value="1" disabled>
                                                <?php endif; ?>
                                                Google Analytics
                                            </label>
                                        </div>
                                        <div class="alert alert-warning mt-3">
                                            To display Google Analytics on the dashboard the key file location and tracking code must be set. The key file must be .json and can be set in config.php.
                                            The tracking code can be set in the analytics tab. For information about obtaining this code check out the
                                            <i><a href="https://developers.google.com/analytics/devguides/config/mgmt/v3/quickstart/service-php" target="_blank">Hello Analytics API</a></i> documentation.
                                        </div>
                                    </div>
                                </div>

								<hr class="border-light m-0">

								<div class="card-body">
									<h6 class="mb-4">Comments</h6><br />
									<div class="form-check">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="setting_comments" form="settings-form" value="1" <?php echo ($option->setting_comments == '1') ? "checked" : ""; ?>>
											Enable Comments
										</label>
									</div>
								</div>

                            </div>

                            <div class="tab-pane fade" id="settings-analytics">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Tracking ID</label>
                                        <input type="text" class="form-control mb-1" name="setting_GA_trackingid" form="settings-form" value="<?php echo $option->setting_GA_trackingid; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tracking Code</label>
                                        <textarea class="form-control" name="setting_GA_code" form="settings-form" rows="8"><?php echo $option->setting_GA_code; ?></textarea>
                                    </div>
                                    <div class="alert alert-warning mt-3">
                                        *Do not include the <code>&lt;script&gt;</code> tags or <i>async src</i> in the tracking code.
                                    </div>
                                    <br />
                                </div>
                            </div>

							<div class="tab-pane fade" id="settings-backup">
								<div class="card-body">
									<div class="form-group">
										<fieldset class="form-group">
										  	<legend>Choose what to export</legend>
										  	<div class="form-check m-3">
										  		<label class="form-check-label">
											  	<input type="radio" class="form-check-input" name="download" form="download-form" value="sql" checked>
											  		Database
												</label>
										  	</div>
										  	<div class="form-check m-3">
										  		<label class="form-check-label">
										  		<input type="radio" class="form-check-input" name="download" form="download-form" value="pages">
											  		Pages
												</label>
										 	</div>
                                            <div class="form-check m-3">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="download" form="download-form" value="templates">
                                                    Templates
                                                </label>
                                            </div>
                                            <div class="form-check m-3">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="download" form="download-form" value="sections">
                                                    Sections (pages)
                                                </label>
                                            </div>
                                            <div class="form-check m-3">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="download" form="download-form" value="section_templates">
                                                    Sections (templates)
                                                </label>
                                            </div>
                                            <div class="form-check m-3">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="download" form="download-form" value="logs">
                                                    Error Log
                                                </label>
                                            </div>
										</fieldset>

                                        <form action="<?php echo site_url('admin/settings/download'); ?>" method="post" id="download-form">
                                            <button type="submit" class="btn btn-outline-primary btn-sm">Download Export FIle</button>
                                        </form>
									</div>
								</div>
							</div>

                            <div class="tab-pane fade" id="settings-about">
                                <div class="card-body">
                                    <div class="form-group">
										<label class="form-label">CMS Version:
											<span class="text-muted"><?php echo config('cms_version'); ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Database name:
											<span class="text-muted"><?php echo $this->db->database(); ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">PHP Version:
											<span class="text-muted"><?php echo phpversion(); ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Client library version:
											<span class="text-muted"><?php echo $this->db->client_version(); ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Server version:
											<span class="text-muted"><?php echo $this->db->server_version(); ?></span>
										</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Server Info:
											<span class="text-muted"><?php echo $this->db->server_info(); ?></span>
										</label>
                                    </div>
                                    <hr />
                                    <label class="form-label"><strong>Copyright</strong> &copy; chiatek 2019</label>
                                </div>
                            </div>

                            <br />

                            <form action="<?php echo site_url('admin/settings'); ?>" method="post" id="settings-form">
                                <div class="card-body text-right mt-3">
                                    <button type="submit" class="btn btn-primary save-btn spinner">Save changes</button>&nbsp;
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

        <!-- Image Modal -->
        <?php $this->view('admin/components/modals/icon_modal', $data); ?>
        <!-- End Image Modal -->

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
    <script src="<?php echo site_url('assets/js/admin/theme.js'); ?>" type="text/javascript"></script>

</body>
</html>
