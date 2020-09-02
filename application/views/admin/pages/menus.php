<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('admin/components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/nestable/jquery.nestable.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('assets/css/admin/admin.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/multiinput/jq.multiinput.min.css'); ?>">
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
                        <h3 class="page-title mb-2 mt-4">Appearance</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="<?php echo site_url('admin/menus'); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-th-list"></i></span>Menus
                                </a>
                                <a href="<?php echo site_url('admin/settings/css_editor'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-file-code-o"></i></span>CSS Editor
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mt-35">

                        <div class="form-row mb-5 pb-5">
                            <div class="col-md-12">
                                <textarea class="form-control" id="menu_items" name="menu_items" form="update-form">
                                    <?php echo $menu_json ?>
                                </textarea>

                                <form action="<?php echo site_url('admin/menus/insert'); ?>" class="list-inline-item" method="post">
                                    <button type="submit" class="btn btn-outline-primary btn-sm">Search for Pages</button>
                                </form>

                                <form action="<?php echo site_url('admin/menus/update'); ?>" class="list-inline-item" method="post" id="update-form">
                                    <button type="submit" class="btn btn-outline-primary btn-sm" form="update-form">Update Menu</button>
                                </form>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12">

                                <?php if ($menu_item->rowCount() > 0): ?>
                                    <p>Drag each menu item in the order you prefer.</p>
                                <?php else: ?>
                                    <p>Add menu items above or click 'Search for Pages' to begin.</p>
                                <?php endif; ?>

                                <div class="dd" id="nestable">
                                    <ol class="dd-list">
                                    <?php
                                        $list = "";

                                        while ($menu = $menuitem->fetch()) {
                                            if (!isset($menu->menu_parent_order)) {
                                                $list .= '<li class="dd-item dd3-item" data-id="'.$menu->menu_id.'">
                                                          <div class="dd-handle dd3-handle"></div><div class="dd3-content">'.$menu->menu_item.'</div>';

                                                if ($parent_id->rowCount() > 0 && isset($menu->menu_parent_id)) {

                                                    $list .= '<ol class="dd-list">';
                                                    while ($child = $parentid->fetch()) {
                                                        if ($menu->menu_id == $child->menu_parent_id) {
                                                            $list .= '<li class="dd-item dd3-item" data-id="'.$child->menu_id.'">
                                                                <div class="dd-handle dd3-handle"></div><div class="dd3-content">'.$child->menu_item.'</div>
                                                                </li>';
                                                        }
                                                    }
                                                    $list .= '</ol></li>';
                                                }
                                                else {
                                                    $list .= '</li>';
                                                }
                                            }
                                        }

                                        echo $list;
                                    ?>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <br /><br /><br /><br />

                        <input type="hidden" id="nestable-output" name="nestable_output" form="menu-form" />

                        <form action="<?php echo site_url('admin/menus/order'); ?>" method="post" id="menu-form">
                            <div class="text-right mt-5">
                                <button type="submit" class="btn btn-primary spinner">Save Menu</button>&nbsp;
                                <a href="<?php echo site_url('admin'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>

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
    <!-- Additional JavaScript / Nestable JS -->
    <script src="<?php echo site_url('assets/vendor/nestable/jquery.nestable.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/multiinput/jq.multiinput.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/admin/nestable.js'); ?>" type="text/javascript"></script>

    <script>
    $(document).ready(function () {
        $('#menu_items').multiInput({
            json: true,
            input: $('<div class="form-row inputElement">\n' +
                '<div class="form-group col-md-4">\n' +
                '<div class="form-label">Menu Item <span class="number">1</span></div>\n' +
                '<input class="form-control" name="menu_item" placeholder="name" type="text">\n' +
                '</div>\n' +
                '<div class="form-group col-md-8">\n' +
                '<div class="form-label"><span>&nbsp;</span></div>\n' +
                '<input class="form-control" name="menu_href" placeholder="url" type="text">\n' +
                '</div>\n' +
                '</div>\n'),
            limit: 10,
            onElementAdd: function (el, plugin) {
                console.log(plugin.elementCount);
            },
            onElementRemove: function (el, plugin) {
                console.log(plugin.elementCount);
            }
        });
    });
    </script>

</body>
</html>
