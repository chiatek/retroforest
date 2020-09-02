<!-- blog_home --><!-- code -->
<?php if (isset($posts)): ?>
<h1 class="my-4">Blog
	<small>Home</small>
</h1>

<!-- Blog Post -->
<?php if ($posts->rowCount() > 0): ?>
	<?php while ($post = $posts->fetch()): ?>
	<div class="card mb-4">
		<img class="card-img-top" src="<?php echo $post->post_image; ?>" alt="Card image cap">
		<div class="card-body">
			<h2 class="card-title"><?php echo $post->post_title; ?></h2>
			<div class="text-justify">
				<?php if (class_exists('posts')): ?>
				<p class="card-text"><?php echo get_summary($post->post_body, config('summary_sentence_limit')); ?></p>
				<?php else: ?>
				<p class="card-text"><?php echo $post->post_body; ?></p>
				<?php endif; ?>
			</div>
			<a href="<?php echo site_url('posts/'.$post->post_slug); ?>" class="btn btn-primary">Read More →</a>
		</div>
		<div class="card-footer text-muted">
			<?php $date = new DateTime($post->post_modified); ?>
			Posted on <?php echo $date->format($config->setting_datetime); ?> by
			<?php echo $post->post_author; ?>
		</div>
	</div>
	<?php endwhile; ?>
	<br />
<?php else: ?>
	<div class="card mb-4">
		<div class="card-body">
			<p class="card-text">No posts found</p>
		</div>
	</div>
<?php endif; ?>

<!-- Pagination -->
<?php if (!empty($links)) { echo $links; } ?>

<br /><br />

<?php else: ?>
    <div class="jumbotron"><h6>blog_home.php</h6></div>
<?php endif; ?>
<!-- End code -->
<!-- End blog_home -->
