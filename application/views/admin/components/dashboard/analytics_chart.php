<!-- Google Analytics Chart -->
<input type="hidden" id="site-url" value="<?php echo site_url('admin/users/dashboard/'); ?>" />

<div class="card">
    <div class="card-header mb-0 pb-0">
        <div class="card-title"><h6>Google Analytics</h6></div>
        <div class="form-group card-options">
            <select class="px-1" id="analytics-date" name="date" onchange="ajax_data(this.value, this.name)">
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="7daysAgo" selected>Last 7 Days</option>
                <option value="14daysAgo">Last 14 Days</option>
                <option value="30daysAgo">Last 30 Days</option>
                <option value="90daysAgo">Last 90 Days</option>
                <option value="365daysAgo">One Year</option>
            </select>
            <select class="px-1" id="analytics-metric" name="metrics" onchange="ajax_data(this.value, this.name)">
                <option value="ga:sessions" selected>Sessions</option>
                <option value="ga:users">Users</option>
                <option value="ga:organicSearches">Organic</option>
                <option value="ga:pageViews">Page Views</option>
                <option value="ga:bounceRate">Bounce Rate</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div id="ajax-ga-chart" style="width: auto; min-height: 330px; margin: -20px -65px -10px -40px;"></div>
    </div>
</div>
<!-- End Google Analytics Chart -->
