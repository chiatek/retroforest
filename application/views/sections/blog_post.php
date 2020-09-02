<!-- blog_post --><!-- code -->
<?php if (isset($post) && isset($config) && isset($categories)): ?>
    <div class="blog-post">
        <!-- Title -->
        <h1 class="mt-4"><?php echo $post->post_title; ?></h1>
        <!-- Author -->
        <p class="lead">by <?php echo $post->post_author; ?></p>

        <hr>
        <!-- Date/Time -->
        <?php $date = new DateTime($post->post_modified); ?>
        <p>Posted on <?php echo $date->format($config->setting_datetime); ?></p>

        <h5>
            <?php while ($category = $categories->fetch()): ?>
                <div class="badge badge-secondary mt-1 mr-1"><?php echo $category->category_name; ?></div>
            <?php endwhile; ?>
        </h5>

        <!-- Preview Image -->
        <img class="img-fluid rounded mt-2" src="<?php echo $post->post_image; ?>" alt="">

        <!-- Post Content -->
        <div class="post-text text-justify">
            <p><?php echo $post->post_body; ?></p>
        </div>

        <hr class="mb-5 pb-3">
    </div>
<?php else: ?>
    <div class="jumbotron"><h6>blog_post.php</h6></div>
<?php endif; ?>
<!-- End code -->
<!-- End blog_post -->
