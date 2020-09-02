<!-- sidebar_widgets_column -->
<div class="sidebar-widgets-column">
	<!-- Search Widget -->
	<div class="widget-search">
        <h5 class="widget-header">Search</h5>
		<div class="widget-body">
			<form action="<?php echo site_url('posts/filter'); ?>" method="post">
				<div class="input-group">
					<input type="text" class="form-control" name="query" placeholder="Search Here">
					<span class="input-group-btn">
						<button class="btn btn-secondary" type="submit">Go!</button>
					</span>
				</div>
			</form>
		</div>
	</div>

	<!-- Categories Widget -->
	<div class="widget-categories">
        <h5 class="widget-header">Categories</h5>
        <hr>
		<div class="widget-body">
		<!-- code -->
		<?php
			if (isset($widget_category)) {
				while ($category = $widget_category->fetch()) {
                    echo '<div class="row">
                        <div class="col-lg-6">
							<ul class="list-unstyled mb-0">
								<li>
									<a href="'.site_url('posts/category/'.$category->category_slug).'">'.$category->category_name.'</a>
								</li>
							</ul>
                        </div>
                    </div>';
				}
			}
		 ?>
	 	<!-- End code -->
		</div>
	</div>

	<!-- Side Widget -->
	<div class="widget-tags">
        <h5 class="widget-header">Popular Tags</h5>
        <hr>
		<div class="widget-body">
			<ul>
                <a href="<?php echo site_url('posts/filter/html'); ?>"><li>HTML</li></a>
                <a href="<?php echo site_url('posts/filter/css'); ?>"><li>CSS</li></a>
                <a href="<?php echo site_url('posts/filter/javascript'); ?>"><li>Javascript</li></a>
                <a href="<?php echo site_url('posts/filter/react'); ?>"><li>React</li></a>
                <a href="<?php echo site_url('posts/filter/python'); ?>"><li>Python</li></a>
                <a href="<?php echo site_url('posts/filter/php'); ?>"><li>PHP</li></a>
                <a href="<?php echo site_url('posts/filter/c#'); ?>"><li>C#</li></a>
            </ul>
        </div>
        <br />
	</div>
</div>
<!-- End sidebar_widgets_column -->
