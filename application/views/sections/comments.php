<!-- comments --><!-- code -->
<?php if (isset($post) && isset($config) && isset($comments)): ?>
	<?php if ($config->setting_comments): ?>
		<div class="comments my-4">
			<h5 class="comments-header">Leave a Comment</h5>
			<div class="comments-body">
				<form action="<?php echo site_url('posts/comments/'.$post->post_id); ?>" method="post">
					<div class="form-group">
						<label class="form-label">Name</label>
			            <input type="text" class="form-control" name="comment_name">
			            <br />
			            <label class="form-label">Comment</label>
						<textarea class="form-control" name="comment_text" rows="3"></textarea>
						<br />
						<p class="text-danger"><?php echo $this->form_validation->validation_errors(); ?></p>
					</div>
					<button type="submit" class="btn btn-secondary">Submit</button>
				</form>
			</div>
		</div>
		<?php if ($total_comments > 0): ?>
			<?php while ($comment = $comments->fetch()): ?>
			<div class="media my-5">
				<img src="<?= site_url('assets/img/admin/user-av.jpg'); ?>" class="d-flex mr-3 rounded-circle" height="50" width="50" alt="Avatar">
				<div class="media-body">
					<?php $date = new DateTime($comment->comment_date); ?>
					<h6 class="mt-0"><?php echo $comment->comment_name; ?> &nbsp;<small><i><?php echo $date->format($config->setting_datetime); ?></i></small></h6>
						<?php echo $comment->comment_text; ?>
				</div>
			</div>
			<?php endwhile; ?>
		<?php endif; ?>
	<?php endif; ?>
	<br /><br />
<?php endif; ?>
<!-- End code -->
<!-- End comments -->
