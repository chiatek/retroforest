<!-- sidebar_widgets_column --><div class="sidebar-widgets-column">
	<!-- Search Widget -->
	<div class="card my-4">
		<h5 class="card-header">Search</h5>
		<div class="card-body">
			<form action="<?php echo site_url('posts/filter'); ?>" method="post">
				<div class="input-group">
					<input type="text" class="form-control" name="query" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-secondary" type="submit">Go!</button>
					</span>
				</div>
			</form>
		</div>
	</div>

	<!-- Categories Widget -->
	<div class="card my-4">
		<h5 class="card-header">Categories</h5>
		<div class="card-body">
		<!-- code -->
		<?php
			if (isset($widget_category)) {
				$column = 1;
				$count = 1;

				while ($category = $widget_category->fetch()) {
					if ($column == 1) {
						echo '<div class="row">';
					}

					echo '<div class="col-lg-6">
							<ul class="list-unstyled mb-0">
								<li>
									<a href="'.site_url('posts/category/'.$category->category_slug).'">'.$category->category_name.'</a>
								</li>
							</ul>
						</div>';

					if ($column == 2 || $count == $widget_category->rowCount()) {
						echo '</div>';
						$column = 1;
					}
					else {
						$column++;
					}

					$count++;
				}
			}
		 ?>
	 	<!-- End code -->
		</div>
	</div>

	<!-- Side Widget -->
	<div class="card my-4">
		<h5 class="card-header">Side Widget</h5>
		<div class="card-body">
			You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
		</div>
	</div>
</div>
<!-- End sidebar_widgets_column -->
