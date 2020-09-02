<div class="header <?php echo $user->user_theme_header; ?> py-4">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand" href="<?php echo base_url(); ?>" target="_blank">
                <i class="fa fa-external-link-square"></i> <?= $_SERVER['HTTP_HOST']; ?>
            </a>
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown d-none d-md-flex">
                    <li class="nav-item dropdown mt-3 p-0 mx-2">
                        <a class="header-link top-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-home" style="font-size:18px"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="navbarDropdownMenuLink">
                            <?php
                            $list = '';
                            if ($menu_item->rowCount() > 0) {

                                while ($menu = $menu_item->fetch()) {
                                    if (isset($menu->menu_parent_id)) {
                                        if (!isset($menu->menu_parent_order)) {
                                            $list .= '<li class="dropdown-submenu"><a data-toggle="dropdown" class="dropdown-item dropdown-toggle sub-menu" href="#">'.$menu->menu_item.'</a>'.
                                                      '<ul class="dropdown-menu">';

                                            while ($child = $parent_id->fetch()) {
                                                if ($menu->menu_id == $child->menu_parent_id) {
                                                    $list .= '<li><a class="dropdown-item" href="'.$child->menu_href.'" target="_blank">'.$child->menu_item.'</a></li>';
                                                }
                                            }

                                            $list .= '</ul></li>';
                                        }
                                    }
                                    else {
                                        $list .= '<li><a class="dropdown-item" href="'.$menu->menu_href.'" target="_blank">'.$menu->menu_item.'</a></li>';
                                    }
                                }
                            }
                            else {
                                $list .= '<li><a class="dropdown-item" href="'.site_url("admin/menus").'"><span class="icon mr-3"><i class="fa fa-th-list"></i></span>Add pages to menu...</a></li>';
                            }
                            echo $list;
                            ?>
                        </ul>
                    </li>
                </div>
                <div class="dropdown d-none d-md-flex">
                    <a class="nav-link header-link top-link icon mt-3" href="#" data-toggle="dropdown">
                        <i class="fa fa-bell mr-1"></i>
                        <span class="badge badge-pill badge-warning"><?php echo $total_notifications; ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <?php if ($total_notifications == 0): ?>
                            <div class="dropdown-item d-flex">
                                <span class="avatar mr-3 align-self-center" style="background-image: url('<?php echo site_url('assets/img/admin/alert.png'); ?>');"></span>
                                <div>
                                    <strong>No new notifications!</strong> Please check back later.
                                    <div class="small text-muted"></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php while ($notification = $notifications->fetch()): ?>
                            <div class="dropdown-item d-flex">
                                <?php if (!empty($notification->notification_image)): ?>
                                    <span class="avatar mr-3 align-self-center" style="background-image: url('<?php echo site_url($notification->notification_image); ?>');"></span>
                                <?php else: ?>
                                    <span class="avatar mr-3 align-self-center" style="background-image: url('<?php echo site_url('assets/img/admin/alert.png'); ?>');"></span>
                                <?php endif; ?>
                                <div>
                                    <?php echo '<strong>' . $notification->notification_title . '</strong><br />' . $notification->notification_text . '<br />'; ?>
                                    <div class="small text-muted">
                                        <?php echo $notification->notification_startdate; ?> &nbsp; | &nbsp;<a href="<?php echo site_url('admin/users/notifications/'.$notification->nu_id); ?>">Dismiss</a>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php endif; ?>

                        <div class="dropdown-divider"></div>
                        <div class="text-center text-muted">Notifications (<?php echo $total_notifications; ?>)</div>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" class="nav-link pr-0 leading-none ml-4" data-toggle="dropdown">
                        <?php if (!empty($user->user_avatar)): ?>
                            <img class="img-responsive rounded-circle user-image" id="user-image" src="<?php echo $user->user_avatar; ?>" alt="User picture">
                        <?php endif; ?>
                        <span class="ml-2 d-none d-lg-block">
                            <span class="header-link top-link"><?php echo $user->user_name; ?></span>
                            <small class="text-muted d-block mt-1"><?php echo ucfirst($user->user_role); ?></small>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a class="dropdown-item" href="<?php echo site_url('admin/users/dashboard'); ?>"><span class="icon mr-3"><i class="fa fa-dashboard"></i></span>Dashboard</a>
                        <a class="dropdown-item" href="<?php echo site_url('admin/users/profile'); ?>"><span class="icon mr-3"><i class="fa fa-user"></i></span>My Profile</a>
                        <a class="dropdown-item" href="<?php echo site_url('admin/settings'); ?>"><span class="icon mr-3"><i class="fa fa-gear"></i></span>Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('admin/users/logout'); ?>"><span class="icon mr-3"><i class="fa fa-sign-out"></i></span>Logout</a>
                    </div>
                </div>
            </div>
            <?php if (!((segment(2) == 'pages' || segment(2) == 'templates' || segment(2) == 'sections' || segment(2) == 'posts') && (total_segments() >= 4))): ?>
                <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                    <span class="header-toggler-icon"></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if ((segment(2) == 'pages' || segment(2) == 'templates' || segment(2) == 'sections' || segment(2) == 'posts') && (total_segments() >= 4)): ?>
<div class="header subheader <?php echo $user->user_theme_subheader; ?> d-lg-flex p-0" id="headerMenuCollapse">
<?php else: ?>
<div class="header subheader <?php echo $user->user_theme_subheader; ?> collapse d-lg-flex p-0" id="headerMenuCollapse">
<?php endif; ?>
    <div class="container">
        <div class="row align-items-center">

            <?php if (segment(2) == 'posts' && total_segments() == 4 && isset($row)): ?>

                <div class="col-lg-3 ml-auto btn-options">
                    <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                        <li class="nav-item">
                            <a href="<?php echo site_url('admin/posts'); ?>" class="btn btn-light btn-sm">All Posts</a>
                            <a href="<?php echo site_url('admin'); ?>" class="btn btn-light btn-sm">Dashboard</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg order-lg-first btn-panel">
                    <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                        <li class="nav-item">
                            <div class="summernote-toolbar"></div>
                        </li>
                        <li class="nav-item mb-1">
                            <button type="button" class="btn btn-light p-0 mt-2 px-2" title="Insert Image" data-toggle="modal" data-target="#editor-modal"><i class="fa fa-image"></i></button>
                            <button class="btn btn-light p-0 mt-2 px-2 spinner-fa" title="Save" id="btn-save" form="post-form" type="submit"><i class="fa fa-save"></i></button>
                            <?php if ($row->post_status == "published"): ?>
                            <a href="<?php echo site_url('posts/'.$row->post_slug); ?>" target="_blank" class="btn btn-light btn-sm btn-publish">Preview</a>
                            <?php else: ?>
                            <a href="<?php echo site_url('admin/posts/drafts/'.$row->post_slug); ?>" target="_blank" class="btn btn-light btn-sm btn-publish">Preview</a>
                            <?php endif; ?>
                            <button class="btn btn-light btn-sm btn-publish spinner" id="btn-publish" form="post-form" type="submit">Publish</button>
                        </li>
                    </ul>
                </div>

            <?php elseif ((segment(2) == 'pages' || segment(2) == 'templates' || segment(2) == 'sections') && (total_segments() >= 4)): ?>

                <div class="col-lg-3 ml-auto btn-page-options mt-2">
                    <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                        <li class="nav-item">
                            <a href="<?php echo site_url('admin/pages'); ?>" class="btn btn-light btn-sm">All Pages</a>
                            <a href="<?php echo site_url('admin'); ?>" class="btn btn-light btn-sm">Dashboard</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg order-lg-first vvveb-panel mt-2">
                    <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                        <li class="nav-item">
                            <button class="btn btn-light" title="Toggle left column" id="toggle-left-column-btn" data-vvveb-action="toggleLeftColumn" data-toggle="button" aria-pressed="false">
                                <i class="fa fa-chevron-left"></i>
                            </button>
                            <button class="btn btn-light" title="Toggle right column" id="toggle-right-column-btn" data-vvveb-action="toggleRightColumn" data-toggle="button" aria-pressed="false">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                            <button class="btn btn-light" title="Undo (Ctrl/Cmd + Z)" id="undo-btn" data-vvveb-action="undo" data-vvveb-shortcut="ctrl+z">
                                <i class="fa fa-undo"></i>
                            </button>
                            <button class="btn btn-light"  title="Redo (Ctrl/Cmd + Shift + Z)" id="redo-btn" data-vvveb-action="redo" data-vvveb-shortcut="ctrl+shift+z">
                                <i class="fa fa-repeat"></i>
                            </button>
                            <button class="btn btn-light" title="Fullscreen (F11)" id="fullscreen-btn" data-toggle="button" aria-pressed="false" data-vvveb-action="fullscreen">
                                <i class="fa fa-arrows-alt"></i>
                            </button>
                            <button class="btn btn-light" title="Preview" id="preview-btn" type="button" data-toggle="button" aria-pressed="false" data-vvveb-action="preview">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button class="btn btn-light" title="Download" id="save-btn" data-vvveb-action="download" download="index.html">
                                <i class="fa fa-download"></i>
                            </button>
                            <button id="mobile-view" data-view="mobile" class="btn btn-light"  title="Mobile view" data-vvveb-action="viewport">
                                <i class="fa fa-mobile"></i>
                            </button>
                            <button id="tablet-view"  data-view="tablet" class="btn btn-light"  title="Tablet view" data-vvveb-action="viewport">
                                <i class="fa fa-tablet"></i>
                            </button>
                            <button id="desktop-view"  data-view="" class="btn btn-light"  title="Desktop view" data-vvveb-action="viewport">
                                <i class="fa fa-desktop"></i>
                            </button>
                            <button class="btn btn-light spinner-fa" title="Save" id="btn-save" form="save-form" type="submit" data-vvveb-shortcut="ctrl+s">
                                <i class="fa fa-save"></i>
                            </button>
                            <?php if (segment(2) == 'templates' && total_segments() == 5): ?>
                            <button class="btn btn-light btn-sm my-2 my-sm-0 spinner p-2" title="Publish to Website" id="btn-publish" form="save-form" type="submit" disabled>Publish</button>
                            <?php else: ?>
                            <button class="btn btn-light btn-sm my-2 my-sm-0 spinner p-2" title="Publish to Website" id="btn-publish" form="save-form" type="submit">Publish</button>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>

            <?php else: ?>

                <div class="col-lg-3 ml-auto subheader-content navbar-search">
                    <form class="input-icon my-3 my-lg-0" action="<?php echo site_url('admin/posts/search'); ?>" method="post">
                        <input type="text" class="form-control header-search" name="query" placeholder="Search..." tabindex="1">
                        <div class="input-icon-addon">
                            <i class="fa fa-search"></i>
                        </div>
                    </form>
                </div>
                <div class="col-lg order-lg-first">
                    <ul class="nav nav-tabs border-0 flex-column flex-lg-row subheader-content">

                        <li class="nav-item">
                            <?php if (url_string() == 'admin/users/dashboard' || url_string() == 'admin'): ?>
                                <a href="<?php echo site_url('admin'); ?>" class="header-link active"><i class="fa fa-dashboard"></i> Dashboard</a>
                            <?php else: ?>
                                <a href="<?php echo site_url('admin'); ?>" class="header-link"><i class="fa fa-dashboard"></i> Dashboard</a>
                            <?php endif; ?>
                        </li>

                        <?php

                            if (config('saved_queries') != NULL && $saved_query_menu->rowCount() > 0) {

                                if (segment(3) == 'saved_query' && is_numeric(segment(4))) {
                                    echo '<li class="nav-item dropdown">
                                        <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-star"></i>'.config('saved_queries').'</a>
                                        <div class="dropdown-menu dropdown-menu-arrow">';
                                }
                                else {
                                    echo '<li class="nav-item dropdown">
                                        <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-star"></i>'.config('saved_queries').'</a>
                                        <div class="dropdown-menu dropdown-menu-arrow">';
                                }

                                for ($i = 0; $i < $saved_query_menu->rowCount(); $i++) {
                                    $row = $saved_query_menu->fetch();

                                    echo '<a href="'.site_url("admin/database/saved_query/".$row->id).'" class="dropdown-item "><span class="icon mr-3"><i class="'.$row->icon.'"></i></span>'.$row->name.'</a>';
                                }

                                echo '</div></li>';

                            }
                            else if (config('saved_queries') != NULL) {
                                echo '<li class="nav-item dropdown">';

                                if (url_string() == 'admin/database/insert_saved_query') {
                                    echo '<a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-star"></i>'.config('saved_queries').'</a>';
                                }
                                else {
                                    echo '<a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-star"></i>'.config('saved_queries').'</a>';
                                }

                                echo '<div class="dropdown-menu dropdown-menu-arrow">
                                    <a href="'.site_url('admin/database/insert_saved_query').'" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-chain"></i></span>Save a Query</a>
                                    </div></li>';
                            }

                        ?>

                        <li class="nav-item">
                            <?php if (segment(2) == 'posts' || segment(2) == 'category' || segment(2) == 'comments'): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-thumb-tack"></i> Posts</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-thumb-tack"></i> Posts</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <a href="<?php echo site_url('admin/posts'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-pencil-square-o"></i></span>All Posts</a>
                                <a href="<?php echo site_url('admin/posts/insert'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-plus"></i></span>Add New</a>
                                <a href="<?php echo site_url('admin/category'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-tags"></i></span>Categories</a>
                                <a href="<?php echo site_url('admin/comments'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-comments"></i></span>Comments</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <?php if (url_string() == 'admin/media' || url_string() == 'admin/media/upload'): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-photo"></i> Media</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-photo"></i> Media</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <a href="<?php echo site_url('admin/media'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-book"></i></span>Library</a>
                                <a href="<?php echo site_url('admin/media/upload'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-plus-circle"></i></span>Add New</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <?php if (segment(2) == 'pages' || segment(2) == 'templates' || segment(2) =='sections'): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-files-o"></i> Pages</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-files-o"></i> Pages</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <a href="<?php echo site_url('admin/pages'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-pencil-square"></i></span>All Pages</a>
                                <a href="<?php echo site_url('admin/pages/insert'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-plus"></i></span>Add New</a>
                                <a href="<?php echo site_url('admin/templates'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-address-card"></i></span>Templates</a>
                                <a href="<?php echo site_url('admin/sections'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-puzzle-piece"></i></span>Sections</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <?php if (url_string() == "admin/menus" || url_string() == "admin/settings/css_editor"): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-paint-brush"></i> Appearance</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-paint-brush"></i> Appearance</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <a href="<?php echo site_url('admin/menus'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-th-list"></i></span>Menus</a>
                                <a href="<?php echo site_url('admin/settings/css_editor'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-file-code-o"></i></span>CSS Editor</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <?php if (segment(2) == 'database' && segment(3) != 'insert_saved_query' && !is_numeric(segment(4))): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-database"></i> Database</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-database"></i> Database</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <?php if ($user->user_role == "administrator"): ?>
                                <a href="<?php echo site_url('admin/database'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-sitemap"></i></span>All Tables</a>
                                <?php endif; ?>
                                <a href="<?php echo site_url('admin/database/saved_query'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-hdd-o"></i></span>Saved Queries</a>
                                <?php if ($user->user_role == "administrator"): ?>
                                <a href="<?php echo site_url('admin/database/sql'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-terminal"></i></span>SQL Query</a>
                                <a href="<?php echo site_url('admin/database/archive'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-archive"></i></span>Backup/Restore</a>
                                <?php endif; ?>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <?php if (url_string() == "admin/users" || url_string() == "admin/users/insert" || url_string() == "admin/users/profile"): ?>
                                <a href="javascript:void(0)" class="header-link active" data-toggle="dropdown"><i class="fa fa-user"></i> Users</a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="header-link" data-toggle="dropdown"><i class="fa fa-user"></i> Users</a>
                            <?php endif; ?>
                            <div class="dropdown-menu dropdown-menu-arrow">
                                <?php if ($user->user_role == "administrator"): ?>
                                    <a href="<?php echo site_url('admin/users'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-users"></i></span>All Users</a>
                                    <a href="<?php echo site_url('admin/users/insert'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-user-plus"></i></span>Add New</a>
                                <?php endif; ?>
                                <a href="<?= site_url('admin/users/profile'); ?>" class="dropdown-item "><span class="icon mr-3"><i class="fa fa-user"></i></span>My Profile</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <?php if (url_string() == 'admin/settings'): ?>
                                <a href="<?php echo site_url('admin/settings'); ?>" class="header-link active"><i class="fa fa-gears"></i> Settings</a>
                            <?php else: ?>
                                <a href="<?php echo site_url('admin/settings'); ?>" class="header-link"><i class="fa fa-gears"></i> Settings</a>
                            <?php endif; ?>
                        </li>

                    </ul>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>
