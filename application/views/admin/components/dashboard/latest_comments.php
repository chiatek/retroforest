<!-- Comments -->
<div class="card mb-4">
    <h6 class="card-header">Latest Comments</h6>
    <div class="card-body">

        <?php if ($total_comments == 0): ?>
            <div class="text-muted mt-3 mb-3">No comments have been posted</div>
        <?php else: ?>
            <?php while ($comment = $comments->fetch()): ?>
                <div class="media pb-1 mb-3">
                    <img src="" class="d-block rounded-circle" alt>
                    <div class="media-body ml-3">
                        <i class="text-dark"><?php echo $comment->user; ?></i>
                        <span class="text-muted">commented on</span>
                        <a href="<?php echo site_url('posts/'.$comment->slug); ?>" target="_blank"><?php echo $comment->post; ?></a>
                        <p class="my-1"><?php echo get_summary($comment->comment, 2); ?></p>
                        <div class="clearfix">
                            <span class="float-left text-muted small"><?php echo $comment->date; ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

    </div>
    <a href="<?php echo site_url('admin/comments'); ?>" class="card-footer d-block text-center text-muted small">SHOW MORE</a>
</div>
<!-- End Comments -->
