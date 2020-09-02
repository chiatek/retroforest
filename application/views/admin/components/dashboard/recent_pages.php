<!-- Recent Pages -->
<div class="card mb-5">
    <div class="card-header mb-0 pb-0">
        <div class="card-title"><h6>Recent Pages</h6></div>
        <div class="card-options">
            <a href="<?php echo site_url('admin/pages/insert'); ?>" class="btn btn-outline-primary btn-sm">New Page</a>
        </div>
    </div>
    <div class="card-body">
        <?php $count = 0; ?>

        <?php foreach ($pages as $page): ?>
            <div class="pb-1 mb-3">
                <div class="text-primary badge float-right">published</div>
                <a href="<?php echo site_url('admin/pages/edit/'.$page['name']) ?>"><?php echo $page['name']; ?></a>&nbsp;
                <br>
                <small class="text-muted">Created on
                    <span class="text-muted"><?php echo format_timestamp($page['date']); ?></span> &nbsp;·&nbsp; <?php echo $page['size'].' bytes'; ?>
                </small>
            </div>

            <?php
                if ($count == config('dashboard_pages_limit')+1) {
                    $count++;
                    break;
                }
                else {
                    $count++;
                }
            ?>
        <?php endforeach; ?>

        <?php if ($count == 0): ?>
            <div class="text-muted mt-3 mb-3">No Pages found</div>
        <?php endif; ?>
    </div>
    <a href="<?php echo site_url('admin/pages'); ?>" class="card-footer d-block text-center text-muted small">SHOW MORE</a>
</div>
<!-- End Recent Pages -->
