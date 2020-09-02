<!-- blog_home --><!-- code -->
<?php if (isset($posts)): ?>

    <!-- Blog Post -->
    <?php if ($posts->rowCount() > 0): ?>
        <?php $count = 1; ?>

        <div class="blog-home">
        <?php while ($post = $posts->fetch()): ?>
            
            <?php if (($count % 2) == 1): ?>
            <div class="row">
            <?php endif; ?>

                <div class="post col-md-6 col-sm-6 mb-5">
                    <a href="<?php echo site_url('posts/'.$post->post_slug); ?>">
                        <img class="post-media" src="<?php echo $post->post_image; ?>" alt="post image">
                    </a>
                    <div class="post-body">
                        <?php $date = new DateTime($post->post_modified); ?>
                        <h6 class="post-author mt-3">by <strong><?php echo $post->post_author; ?></strong>, <?php echo $date->format($config->setting_datetime); ?></h6> 
                        <h5 class="post-title"><strong><?php echo $post->post_title; ?></strong></h5>
                        <?php if (class_exists('posts')): ?>
                        <p class="post-text"><?php echo get_summary($post->post_body, config('summary_sentence_limit')); ?></p>
                        <?php else: ?>
                        <p class="post-text"><?php echo $post->post_body; ?></p>
                        <?php endif; ?>
                        <div>
                            <a href="<?php echo site_url('posts/'.$post->post_slug); ?>" class="btn btn-secondary btn-sm float-right">read more...</a>
                        </div>
                    </div>
                </div>

            <?php if ((($count % 2) == 0) || $count == $posts->rowCount()): ?>
            </div>
            <?php endif; ?>  
            
            <?php $count++; ?>

        <?php endwhile; ?>
        </div>

        <div class="clearfix"></div>
        <br />

    <?php else: ?>
        <br />
        <div class="card mt-5 mb-4">
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