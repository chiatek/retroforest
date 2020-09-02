<!-- carousel -->
<?php if (isset($carousel_posts)): ?>
    <?php if ($carousel_posts->rowCount() > 0): ?>
        <div class="carousel-content">
            <div id="owl-slide" class="owl-carousel">
                <?php while ($post = $carousel_posts->fetch()): ?>
                    <div class="item">
                        <a href="<?php echo site_url('posts/'.$post->post_slug); ?>">
                            <img src="<?php echo $post->post_image; ?>" />
                            <div class="carousel-caption">
                                <p class="carousel-caption-title"><?php echo $post->post_title; ?></p>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<!-- End carousel -->