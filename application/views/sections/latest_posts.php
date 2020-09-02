<!-- latest_posts -->
<?php if (isset($latest_posts)): ?>
<div class="latest-posts">

    <?php if ($latest_posts->rowCount() > 0): ?>
        <?php $count = 1; ?>

        <?php while ($post = $latest_posts->fetch()): ?>
            
            <?php if (($count % 2) == 1): ?>
            <div class="row">
            <?php endif; ?>

                <div class="post col-md-6 col-sm-6 mb-5">
                    <a href="<?php echo site_url('posts/'.$post->post_slug); ?>">
                        <img class="post-media" src="<?php echo $post->post_image; ?>" alt="post image">
                    </a>
                    <div class="post-body">
                        <?php $date = new DateTime($post->post_modified); ?>
                        <h6 class="post-author mt-3">by <strong><?php echo $post->post_author; ?></strong>, <?php echo $date->format("F d Y, h:i:s A"); ?></h6> 
                        <h5 class="post-title"><strong><?php echo $post->post_title; ?></strong></h5>
                        <p class="post-text"><?php echo get_summary($post->post_body, config('summary_sentence_limit')); ?></p>
                        <div>
                            <a href="<?php echo site_url('posts/'.$post->post_slug); ?>" class="btn btn-secondary btn-sm float-right">read more...</a>
                        </div>
                    </div>
                </div>

            <?php if ((($count % 2) == 0) || $count == $latest_posts->rowCount()): ?>
            </div>
            <?php endif; ?>  
            
            <?php $count++; ?>

        <?php endwhile; ?>
        <div class="post col-md-12 col-sm-12">
            <a href="<?php echo site_url('posts'); ?>" class="btn btn-secondary float-right mb-5">view all...</a>
        </div>
    <?php endif; ?>   
</div>

<div class="clearfix"></div>
<?php endif; ?>
<!-- End latest_posts -->