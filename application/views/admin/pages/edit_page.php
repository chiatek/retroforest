<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <meta name="description" content="Dashboard Template">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url('assets/img/admin/favicon.ico'); ?>">
    <link rel="icon" type="image/png" href="<?php echo site_url('assets/img/admin/favicon.png'); ?>">
    <link rel="apple-touch-icon" href="<?= site_url('assets/img/admin/avicon.png'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/vvvebjs/css/editor.css'); ?>">

    <!-- CSS -->
    <?php if ($user->user_theme): ?>
    <link id="page-theme" rel="stylesheet" href="<?php echo site_url('assets/vendor/bootstrap/css/theme/'.$user->user_theme); ?>">
    <?php else: ?>
    <link id="page-theme" rel="stylesheet" href="<?php echo site_url('assets/vendor/bootstrap/css/theme/default.css'); ?>">
    <?php endif; ?>

    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/vvvebjs/css/line-awesome.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/css/admin/admin.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/vvvebjs/libs/codemirror/lib/codemirror.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/vvvebjs/libs/codemirror/theme/material.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/fontawesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/toastr/toastr.min.css'); ?>">

</head>

    <!-- Wrapper -->
	<div class="wrapper">

        <!-- Navbar -->
        <?php $this->view('admin/components/common/navbar', $data); ?>
        <?php if ($file_type == "drafts" || $file_type == "pages"): ?>
            <form action="<?php echo site_url('admin/pages/edit/'.$file_name); ?>" method="post" id="save-form">
        <?php elseif ($file_type == "templates" || segment(2) == 'templates'): ?>
            <form action="<?php echo site_url('admin/templates/edit/'.$file_type.'/'.$file_name); ?>" method="post" id="save-form">
        <?php else: ?>
            <form action="<?php echo site_url('admin/sections/edit/'.$file_name); ?>" method="post" id="save-form">
        <?php endif; ?>
            <input type="hidden" id="html" name="html" form="save-form" value="" />
            <input type="hidden" id="page_save" name="page_save" form="save-form" value="" />
            <input type="hidden" id="page_publish" name="page_publish" form="save-form" value="" />
        </form>
        <!-- End Navbar -->

        <!-- Main Content -->
        <div class="content my-3 my-md-5">

			<!-- VvvebbJS -->
            <div id="vvveb-builder">

        		<div id="left-panel">

                    <div class="">

                        <div class="editor-header">

                            <ul class="nav nav-tabs" id="elements-tabs" role="tablist">
                                <li class="nav-item component-tab">
                                    <a class="nav-link active px-3" id="components-tab" data-toggle="tab" href="#components" role="tab" aria-controls="components" aria-selected="true"><i class="la la-lg la-cube"></i> <div><small>Components</small></div></a>
                                </li>
                                <li class="nav-item blocks-tab">
                                    <a class="nav-link px-3" id="blocks-tab" data-toggle="tab" href="#blocks" role="tab" aria-controls="blocks" aria-selected="false"><i class="la la-lg la-image"></i> <div><small>Blocks</small></div></a>
                                </li>
                                <li class="nav-item component-properties-tab" style="display:none">
                                    <a class="nav-link px-3" id="properties-tab" data-toggle="tab" href="#properties" role="tab" aria-controls="blocks" aria-selected="false"><i class="la la-lg la-cog"></i> <div><small>Properties</small></div></a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="components" role="tabpanel" aria-labelledby="components-tab">

                                    <div class="search">
                                        <input class="form-control form-control-sm component-search" placeholder="Search components" type="text" data-vvveb-action="componentSearch" data-vvveb-on="keyup">
                                    </div>

                                    <div class="drag-elements-sidepane sidepane">
                                        <div>
                                            <ul class="components-list clearfix" data-type="leftpanel">
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="blocks" role="tabpanel" aria-labelledby="blocks-tab">

                                    <div class="search">
                                        <input class="form-control form-control-sm block-search" placeholder="Search blocks" type="text" data-vvveb-action="blockSearch" data-vvveb-on="keyup">
                                    </div>

                                    <div class="drag-elements-sidepane sidepane">
                                        <div>
                                            <ul class="blocks-list clearfix" data-type="leftpanel">
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="properties" role="tabpanel" aria-labelledby="blocks-tab">
                                    <div class="component-properties-sidepane">
                                        <div>
                                            <div class="component-properties">
                                                <ul class="nav nav-tabs nav-fill" id="properties-tabs" role="tablist">
                                                    <li class="nav-item content-tab">
                                                        <a class="nav-link active" data-toggle="tab" href="#content-left-panel-tab" role="tab" aria-controls="components" aria-selected="true">
                                                        <i class="la la-lg la-cube"></i> <div><span>Content</span></div></a>
                                                    </li>
                                                    <li class="nav-item style-tab">
                                                        <a class="nav-link" data-toggle="tab" href="#style-left-panel-tab" role="tab" aria-controls="blocks" aria-selected="false">
                                                        <i class="la la-lg la-image"></i> <div><span>Style</span></div></a>
                                                    </li>
                                                    <li class="nav-item advanced-tab">
                                                        <a class="nav-link" data-toggle="tab" href="#advanced-left-panel-tab" role="tab" aria-controls="blocks" aria-selected="false">
                                                        <i class="la la-lg la-cog"></i> <div><span>Page</span></div></a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="content-left-panel-tab" data-section="content" role="tabpanel" aria-labelledby="content-tab">
                                                        <div class="mt-4 text-center">Click on an element to edit.</div>
                                                    </div>

                                                    <div class="tab-pane fade show" id="style-left-panel-tab" data-section="style" role="tabpanel" aria-labelledby="style-tab">
                                                    </div>

                                                    <div class="tab-pane fade show" id="advanced-left-panel-tab" data-section="advanced"  role="tabpanel" aria-labelledby="advanced-tab">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

        		<div id="canvas">
                    <div id="iframe-wrapper">
                        <div id="iframe-layer">

                            <div id="highlight-box">
                                <div id="highlight-name"></div>

                                <div id="section-actions">
                                    <a id="add-section-btn" href="" title="Add element"><i class="la la-plus"></i></a>
                                </div>
                            </div>

                            <div id="select-box">

                                <div id="wysiwyg-editor">
                                    <a id="bold-btn" href="" title="Bold"><i><strong>B</strong></i></a>
                                    <a id="italic-btn" href="" title="Italic"><i>I</i></a>
                                    <a id="underline-btn" href="" title="Underline"><u>u</u></a>
                                    <a id="strike-btn" href="" title="Strikeout"><del>S</del></a>
                                    <a id="link-btn" href="" title="Create link"><strong>a</strong></a>
                                </div>

                                <div id="select-actions">
                                    <a id="drag-btn" href="" title="Drag element"><i class="la la-arrows"></i></a>
                                    <a id="parent-btn" href="" title="Select parent"><i class="la la-level-down la-rotate-180"></i></a>

                                    <a id="up-btn" href="" title="Move element up"><i class="la la-arrow-up"></i></a>
                                    <a id="down-btn" href="" title="Move element down"><i class="la la-arrow-down"></i></a>
                                    <a id="clone-btn" href="" title="Clone element"><i class="la la-copy"></i></a>
                                    <a id="delete-btn" href="" title="Remove element"><i class="la la-trash"></i></a>
                                </div>
                            </div>

                            <!-- add section box -->
                            <div id="add-section-box" class="drag-elements">

                                <div class="editor-header">
                                    <ul class="nav nav-tabs" id="box-elements-tabs" role="tablist">
                                        <li class="nav-item component-tab">
                                            <a class="nav-link active" id="box-components-tab" data-toggle="tab" href="#box-components" role="tab" aria-controls="components" aria-selected="true"><i class="la la-lg la-cube"></i> <div><small>Components</small></div></a>
                                        </li>
                                        <li class="nav-item blocks-tab">
                                            <a class="nav-link" id="box-blocks-tab" data-toggle="tab" href="#box-blocks" role="tab" aria-controls="blocks" aria-selected="false"><i class="la la-lg la-image"></i> <div><small>Blocks</small></div></a>
                                        </li>
                                        <li class="nav-item component-properties-tab" style="display:none">
                                            <a class="nav-link" id="box-properties-tab" data-toggle="tab" href="#box-properties" role="tab" aria-controls="blocks" aria-selected="false"><i class="la la-lg la-cog"></i> <div><small>Properties</small></div></a>
                                        </li>
                                    </ul>

                                    <div class="section-box-actions">

                                        <div id="close-section-btn" class="btn btn-light btn-sm bg-white btn-sm float-right"><i class="la la-close"></i></div>

                                        <div class="small mt-1 mr-3 float-right">

                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="add-section-insert-mode-after" value="after" checked="checked" name="add-section-insert-mode" class="custom-control-input">
                                                <label class="custom-control-label" for="add-section-insert-mode-after">After</label>
                                            </div>

                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="add-section-insert-mode-inside" value="inside" name="add-section-insert-mode" class="custom-control-input">
                                                <label class="custom-control-label" for="add-section-insert-mode-inside">Inside</label>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="box-components" role="tabpanel" aria-labelledby="components-tab">

                                            <div class="search">
                                                <input class="form-control form-control-sm component-search" placeholder="Search components" type="text" data-vvveb-action="addBoxComponentSearch" data-vvveb-on="keyup">
                                                <button class="clear-backspace"  data-vvveb-action="clearComponentSearch">
                                                    <i class="la la-close"></i>
                                                </button>
                                            </div>

                                            <div>
                                                <div>
                                                    <ul class="components-list clearfix" data-type="addbox">
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="box-blocks" role="tabpanel" aria-labelledby="blocks-tab">

                                            <div class="search">
                                                <input class="form-control form-control-sm block-search" placeholder="Search blocks" type="text" data-vvveb-action="addBoxBlockSearch" data-vvveb-on="keyup">
                                                <button class="clear-backspace"  data-vvveb-action="clearBlockSearch">
                                                    <i class="la la-close"></i>
                                                </button>
                                            </div>

                                            <div>
                                                <div>
                                                    <ul class="blocks-list clearfix"  data-type="addbox">
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- div class="tab-pane fade" id="box-properties" role="tabpanel" aria-labelledby="blocks-tab">
                                                <div class="component-properties-sidepane">
                                                <div>
                                                <div class="component-properties">
                    	                           <div class="mt-4 text-center">Click on an element to edit.</div>
                                                </div>
                                                </div>
                                            </div>
                                        </div -->
                                    </div>
                                </div>

                            </div>
                            <!-- //add section box -->
                        </div>
                        <iframe src="about:none" id="iframe1"></iframe>
                    </div>

        		</div>

                <div id="right-panel">
                    <div class="component-properties">

                        <ul class="nav nav-tabs nav-fill" id="properties-tabs" role="tablist">
                            <li class="nav-item advanced-tab">
                                <a class="nav-link active px-3" data-toggle="tab" href="#advanced-tab" role="tab" aria-controls="blocks" aria-selected="false">
                                <i class="la la-lg la-cog"></i> <div><span>Page</span></div></a>
                            </li>
                            <li class="nav-item content-tab">
                                <a class="nav-link px-3" data-toggle="tab" href="#content-tab" role="tab" aria-controls="components" aria-selected="true">
                                <i class="la la-lg la-cube"></i> <div><span>Content</span></div></a>
                            </li>
                            <li class="nav-item style-tab">
                                <a class="nav-link px-3" data-toggle="tab" href="#style-tab" role="tab" aria-controls="blocks" aria-selected="false">
                                <i class="la la-lg la-image"></i> <div><span>Style</span></div></a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane fade show active" id="advanced-tab" data-section="advanced"  role="tabpanel" aria-labelledby="advanced-tab">
                                <div id="accordion">
                                    <div class="mt-2">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#general" aria-expanded="true" aria-controls="general">
                                            <span class="float-left">General</span> <i class="fa fa-angle-down float-right"></i>
                                        </button>
                                        <hr class="mt-3 mb-3" />
                                    </div>
                                    <div id="general" class="collapse show ml-3 mr-4" aria-labelledby="general" data-parent="#accordion">
                                        <div class="form-group">
                                            <label class="form-label">File Name</label>
                                            <input type="text" class="form-control" name="page_filename" form="save-form" value="<?php echo $file_name; ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">File Type</label>
                                            <input type="text" class="form-control" name="page_filetype" form="save-form" value="<?php echo $file_type; ?>" disabled>
                                        </div>
                                        <?php if (!empty($meta_tag)): ?>
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" name="title" form="save-form" value="<?php echo $meta_tag['title']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Author</label>
                                            <input type="text" class="form-control" name="author" form="save-form" value="<?php echo $meta_tag['author']; ?>">
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!empty($meta_tag)): ?>
                                    <div class="mt-0">
                                        <button class="btn btn-link collapsed pb-0 pt-0" id="accordion-meta" data-toggle="collapse" data-target="#meta" aria-expanded="false" aria-controls="meta">
                                            <span class="float-left">Meta</span> <i class="fa fa-angle-down float-right"></i>
                                        </button>
                                        <hr class="mt-4" />
                                    </div>
                                    <div id="meta" class="collapse ml-3 mr-4" aria-labelledby="meta" data-parent="#accordion">
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" name="title" form="save-form" value="<?php echo $meta_tag['title']; ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Caption</label>
                                            <input type="text" class="form-control" name="subject" form="save-form" value="<?php echo $meta_tag['subject']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description" form="save-form" rows="3"><?php echo $meta_tag['description']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Keywords</label>
                                            <input type="text" class="form-control" name="keywords" form="save-form" value="<?php echo $meta_tag['keywords']; ?>">
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="content-tab" data-section="content" role="tabpanel" aria-labelledby="content-tab">
                            </div>

                            <div class="tab-pane fade show" id="style-tab" data-section="style" role="tabpanel" aria-labelledby="style-tab">
                            </div>

                        </div>

                    </div>
        		</div>

        		<div id="bottom-panel">

        			<div class="btn-group" role="group">

                        <button id="code-editor-btn" data-view="mobile" class="btn btn-sm btn-light btn-sm"  title="Code editor" data-vvveb-action="toggleEditor">
                            <i class="la la-code"></i> Code editor
                        </button>

        			</div>

        			<div id="vvveb-code-editor">
        				<textarea class="form-control"></textarea>
                        <div></div>
                    </div>
                </div>

                <!-- templates -->
                <script id="vvveb-input-textinput" type="text/html">
                    <div>
                        <input name="{%=key%}" type="text" class="form-control"/>
                    </div>
                </script>

                <script id="vvveb-input-textareainput" type="text/html">
                	<div>
                		<textarea name="{%=key%}" rows="3" class="form-control"/>
                	</div>
                </script>

                <script id="vvveb-input-checkboxinput" type="text/html">
                	<div class="custom-control custom-checkbox">
                        <input name="{%=key%}" class="custom-control-input" type="checkbox" id="{%=key%}_check">
                        <label class="custom-control-label" for="{%=key%}_check">{% if (typeof text !== 'undefined') { %} {%=text%} {% } %}</label>
                	</div>
                </script>

                <script id="vvveb-input-radioinput" type="text/html">
                	<div>
                		{% for ( var i = 0; i < options.length; i++ ) { %}

                		<label class="custom-control custom-radio  {% if (typeof inline !== 'undefined' && inline == true) { %}custom-control-inline{% } %}"  title="{%=options[i].title%}">
                            <input name="{%=key%}" class="custom-control-input" type="radio" value="{%=options[i].value%}" id="{%=key%}{%=i%}" {%if (options[i].checked) { %}checked="{%=options[i].checked%}"{% } %}>
                            <label class="custom-control-label" for="{%=key%}{%=i%}">{%=options[i].text%}</label>
                		</label>

                		{% } %}

                	</div>
                </script>

                <script id="vvveb-input-radiobuttoninput" type="text/html">
                	<div class="btn-group btn-group-toggle  {%if (extraclass) { %}{%=extraclass%}{% } %} clearfix" data-toggle="buttons">

                		{% for ( var i = 0; i < options.length; i++ ) { %}

                		<label class="btn  btn-outline-primary  {%if (options[i].checked) { %}active{% } %}  {%if (options[i].extraclass) { %}{%=options[i].extraclass%}{% } %}" for="{%=key%}{%=i%} " title="{%=options[i].title%}">
                            <input name="{%=key%}" class="custom-control-input" type="radio" value="{%=options[i].value%}" id="{%=key%}{%=i%}" {%if (options[i].checked) { %}checked="{%=options[i].checked%}"{% } %}>
                            {%if (options[i].icon) { %}<i class="{%=options[i].icon%}"></i>{% } %}
                            {%=options[i].text%}
                		</label>

                		{% } %}

                	</div>
                </script>

                <script id="vvveb-input-toggle" type="text/html">
                    <div class="toggle">
                        <input type="checkbox" name="{%=key%}" value="{%=on%}" data-value-off="{%=off%}" data-value-on="{%=on%}" class="toggle-checkbox" id="{%=key%}">
                        <label class="toggle-label" for="{%=key%}">
                            <span class="toggle-inner"></span>
                            <span class="toggle-switch"></span>
                        </label>
                    </div>
                </script>

                <script id="vvveb-input-header" type="text/html">
                    <h6 class="editor-header">{%=header%}</h6>
                </script>


                <script id="vvveb-input-select" type="text/html">
                	<div>

                		<select class="form-control custom-select">
                			{% for ( var i = 0; i < options.length; i++ ) { %}
                			<option value="{%=options[i].value%}">{%=options[i].text%}</option>
                			{% } %}
                		</select>

                	</div>
                </script>


                <script id="vvveb-input-listinput" type="text/html">
                	<div class="row">

                		{% for ( var i = 0; i < options.length; i++ ) { %}
                		<div class="col-6">
                			<div class="input-group">
                				<input name="{%=key%}_{%=i%}" type="text" class="form-control" value="{%=options[i].text%}"/>
                				<div class="input-group-append">
                					<button class="input-group-text btn btn-sm btn-danger">
                						<i class="la la-trash la-lg"></i>
                					</button>
                				</div>
                			  </div>
                			  <br/>
                		</div>
                		{% } %}

                		{% if (typeof hide_remove === 'undefined') { %}
                		<div class="col-12">

                			<button class="btn btn-sm btn-outline-primary">
                				<i class="la la-trash la-lg"></i> Add new
                			</button>

                		</div>
                		{% } %}

                	</div>
                </script>

                <script id="vvveb-input-grid" type="text/html">
                	<div class="row">
                		<div class="mb-1 col-12">

                			<label>Flexbox</label>
                			<select class="form-control custom-select" name="col">

                				<option value="">None</option>
                				{% for ( var i = 1; i <= 12; i++ ) { %}
                				<option value="{%=i%}" {% if ((typeof col !== 'undefined') && col == i) { %} selected {% } %}>{%=i%}</option>
                				{% } %}

                			</select>
                			<br/>
                		</div>

                		<div class="col-6">
                			<label>Extra small</label>
                			<select class="form-control custom-select" name="col-xs">

                				<option value="">None</option>
                				{% for ( var i = 1; i <= 12; i++ ) { %}
                				<option value="{%=i%}" {% if ((typeof col_xs !== 'undefined') && col_xs == i) { %} selected {% } %}>{%=i%}</option>
                				{% } %}

                			</select>
                			<br/>
                		</div>

                		<div class="col-6">
                			<label>Small</label>
                			<select class="form-control custom-select" name="col-sm">

                				<option value="">None</option>
                				{% for ( var i = 1; i <= 12; i++ ) { %}
                				<option value="{%=i%}" {% if ((typeof col_sm !== 'undefined') && col_sm == i) { %} selected {% } %}>{%=i%}</option>
                				{% } %}

                			</select>
                			<br/>
                		</div>

                		<div class="col-6">
                			<label>Medium</label>
                			<select class="form-control custom-select" name="col-md">

                				<option value="">None</option>
                				{% for ( var i = 1; i <= 12; i++ ) { %}
                				<option value="{%=i%}" {% if ((typeof col_md !== 'undefined') && col_md == i) { %} selected {% } %}>{%=i%}</option>
                				{% } %}

                			</select>
                			<br/>
                		</div>

                		<div class="col-6 mb-1">
                			<label>Large</label>
                			<select class="form-control custom-select" name="col-lg">

                				<option value="">None</option>
                				{% for ( var i = 1; i <= 12; i++ ) { %}
                				<option value="{%=i%}" {% if ((typeof col_lg !== 'undefined') && col_lg == i) { %} selected {% } %}>{%=i%}</option>
                				{% } %}

                			</select>
                			<br/>
                		</div>

                		{% if (typeof hide_remove === 'undefined') { %}
                		<div class="col-12">

                			<button class="btn btn-sm btn-outline-light text-danger">
                				<i class="la la-trash la-lg"></i> Remove
                			</button>

                		</div>
                		{% } %}

                	</div>
                </script>

                <script id="vvveb-input-textvalue" type="text/html">
                	<div class="row">
                		<div class="col-6 mb-1">
                			<label>Value</label>
                			<input name="value" type="text" value="{%=value%}" class="form-control"/>
                		</div>

                		<div class="col-6 mb-1">
                			<label>Text</label>
                			<input name="text" type="text" value="{%=text%}" class="form-control"/>
                		</div>

                		{% if (typeof hide_remove === 'undefined') { %}
                		<div class="col-12">

                			<button class="btn btn-sm btn-outline-light text-danger">
                				<i class="la la-trash la-lg"></i> Remove
                			</button>

                		</div>
                		{% } %}

                	</div>
                </script>

                <script id="vvveb-input-rangeinput" type="text/html">
                	<div>
                        <input name="{%=key%}" type="range" min="{%=min%}" max="{%=max%}" step="{%=step%}" class="form-control"/>
                	</div>
                </script>

                <script id="vvveb-input-imageinput" type="text/html">
                	<div>
                        <input name="{%=key%}" type="text" class="form-control"/>
                        <input name="file" type="file" class="form-control"/>
                	</div>
                </script>

                <script id="vvveb-input-colorinput" type="text/html">
                	<div>
                        <input name="{%=key%}" type="color" {% if (typeof value !== 'undefined' && value != false) { %} value="{%=value%}" {% } %}  pattern="#[a-f0-9]{6}" class="form-control"/>
                	</div>
                </script>

                <script id="vvveb-input-bootstrap-color-picker-input" type="text/html">
                	<div>
                		<div id="cp2" class="input-group" title="Using input value">
                            <input name="{%=key%}" type="text" {% if (typeof value !== 'undefined' && value != false) { %} value="{%=value%}" {% } %}	 class="form-control"/>
                            <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                            </span>
                		</div>
                	</div>
                </script>

                <script id="vvveb-input-numberinput" type="text/html">
                	<div>
                		<input name="{%=key%}" type="number" value="{%=value%}"
                            {% if (typeof min !== 'undefined' && min != false) { %}min="{%=min%}"{% } %}
                            {% if (typeof max !== 'undefined' && max != false) { %}max="{%=max%}"{% } %}
                            {% if (typeof step !== 'undefined' && step != false) { %}step="{%=step%}"{% } %}
                                class="form-control"/>
                	</div>
                </script>

                <script id="vvveb-input-button" type="text/html">
                	<div>
                		<button class="btn btn-sm btn-primary">
                			<i class="la  {% if (typeof icon !== 'undefined') { %} {%=icon%} {% } else { %} la-plus {% } %} la-lg"></i> {%=text%}
                		</button>
                	</div>
                </script>

                <script id="vvveb-input-cssunitinput" type="text/html">
                	<div class="input-group" id="cssunit-{%=key%}">
                		<input name="number" type="number"  {% if (typeof value !== 'undefined' && value != false) { %} value="{%=value%}" {% } %}
                			  {% if (typeof min !== 'undefined' && min != false) { %}min="{%=min%}"{% } %}
                			  {% if (typeof max !== 'undefined' && max != false) { %}max="{%=max%}"{% } %}
                			  {% if (typeof step !== 'undefined' && step != false) { %}step="{%=step%}"{% } %}
                		            class="form-control"/>
                        <div class="input-group-append">
                    		<select class="form-control custom-select small-arrow" name="unit">
                    			<option value="em">em</option>
                    			<option value="px">px</option>
                    			<option value="%">%</option>
                    			<option value="rem">rem</option>
                    			<option value="auto">auto</option>
                    		</select>
                		</div>
                	</div>
                </script>

                <script id="vvveb-filemanager-page" type="text/html">
                	<li data-url="{%=url%}" data-page="{%=name%}">
                		<label for="{%=name%}"><span>{%=title%}</span></label> <input type="checkbox" checked id="{%=name%}" />
                		<ol></ol>
                	</li>
                </script>

                <script id="vvveb-filemanager-component" type="text/html">
                	<li data-url="{%=url%}" data-component="{%=name%}" class="file">
                		<a href="{%=url%}"><span>{%=title%}</span></a>
                	</li>
                </script>

                <script id="vvveb-input-sectioninput" type="text/html">
                    <label class="editor-header" data-header="{%=key%}" for="header_{%=key%}"><span>&ensp;{%=header%}</span> <div class="header-arrow"></div></label>
                    <input class="header_check" type="checkbox" {% if (typeof expanded !== 'undefined' && expanded == false) { %} {% } else { %}checked="true"{% } %} id="header_{%=key%}">
                    <div class="section" data-section="{%=key%}"></div>
                </script>


                <script id="vvveb-property" type="text/html">
                	<div class="form-group {% if (typeof col !== 'undefined' && col != false) { %} col-sm-{%=col%} d-inline-block {% } else { %}row{% } %}" data-key="{%=key%}" {% if (typeof group !== 'undefined' && group != null) { %}data-group="{%=group%}" {% } %}>

                		{% if (typeof name !== 'undefined' && name != false) { %}<label class="{% if (typeof inline === 'undefined' ) { %}col-sm-4{% } %} control-label" for="input-model">{%=name%}</label>{% } %}

                		<div class="{% if (typeof inline === 'undefined') { %}col-sm-{% if (typeof name !== 'undefined' && name != false) { %}8{% } else { %}12{% } } %} input"></div>

                	</div>
                </script>

                <script id="vvveb-input-autocompletelist" type="text/html">
                	<div>
                		<input name="{%=key%}" type="text" class="form-control"/>

                		<div class="form-control autocomplete-list" style="min=height: 150px; overflow: auto;">
                            <div id="featured-product43"><i class="la la-close"></i> MacBook
                                <input name="product[]" value="43" type="hidden">
                            </div>
                            <div id="featured-product40"><i class="la la-close"></i> iPhone
                                <input name="product[]" value="40" type="hidden">
                            </div>
                            <div id="featured-product42"><i class="la la-close"></i> Apple Cinema 30"
                                <input name="product[]" value="42" type="hidden">
                            </div>
                            <div id="featured-product30"><i class="la la-close"></i> Canon EOS 5D
                                <input name="product[]" value="30" type="hidden">
                            </div>
                		</div>
                	</div>
                </script>
                <!-- End templates -->

                <!-- export html modal-->
                <div class="modal fade" id="textarea-modal" tabindex="-1" role="dialog" aria-labelledby="textarea-modal" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="modal-title text-primary"><i class="la la-lg la-save"></i> Export html</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><small><i class="la la-close"></i></small></span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <textarea rows="25" cols="150" class="form-control"></textarea>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal"><i class="la la-close"></i> Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End VvvebJS -->

		</div>
		<!-- End Main Content -->

        <!-- Toastr -->
        <?php $this->view('admin/components/common/toastr'); ?>
        <!-- End Toastr -->

    </div>
    <!-- End Wrapper -->

    <!-- Base Javascript -->
    <script src="<?php echo site_url('assets/vendor/jquery/jquery-3.3.1.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/jquery/jquery.hotkeys.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/bootstrap/js/popper.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/admin/admin.js'); ?>" type="text/javascript"></script>
    <!-- Additional JavaScript -->
    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/builder/builder.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/builder/undo.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/builder/inputs.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/builder/components-server.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/builder/components-bootstrap4.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/builder/components-widgets.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/builder/blocks-bootstrap4.js'); ?>" type="text/javascript"></script>

    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/codemirror/lib/codemirror.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/codemirror/lib/xml.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/codemirror/lib/formatting.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/vvvebjs/libs/builder/plugin-codemirror.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/vendor/toastr/toastr.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/admin/toastr.js'); ?>" type="text/javascript"></script>

    <script>
        $(document).ready(function() {

            <?php if ($file_type == "pages" || $file_type == "drafts"): ?>
                Vvveb.Builder.init('<?php echo site_url('admin/pages/edit_page/'.$file_type.'/'.basename($file_name, '.php')); ?>', function() {});
            <?php elseif ($file_type == "templates" && segment(2) == 'templates'): ?>
                Vvveb.Builder.init('<?php echo site_url('admin/templates/edit_template/'.$file_type.'/'.basename($file_name, '.php')); ?>', function() {});
            <?php elseif (segment(2) == 'templates'): ?>
                Vvveb.Builder.init('<?php echo site_url('admin/templates/edit_section/'.$file_type.'/'.basename($file_name, '.php')); ?>', function() {});
            <?php else: ?>
                Vvveb.Builder.init('<?php echo site_url('admin/sections/edit_section/'.basename($file_name, '.php')); ?>', function() {});
            <?php endif; ?>

            Vvveb.Gui.init();

            $("#btn-publish").click(function(){
                $("#html").val(Vvveb.Builder.getHtml());
                $("#page_publish").val("TRUE");
            });
            $("#btn-save").click(function(){
                $("#html").val(Vvveb.Builder.getHtml());
                $("#page_save").val("TRUE");
            });
        });
    </script>

</body>
</html>
