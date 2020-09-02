<?php
defined('SYSPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to root of your website.
|
*/
$config['base_url'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';

/*
|--------------------------------------------------------------------------
| Default Controller and Method
|--------------------------------------------------------------------------
|
| Set the default controller and method to route to if not specified by the user.
| You can set an alternate controller as well which is useful especially if
| a sub-folder is included in your controllers folder.
|
*/
$config['default_controller'] = 'home';
$config['alternate_controller'] = 'users';
$config['default_method'] = 'index';

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| Set an encryption key
|
*/
$config['encryption_key'] = '';

/*
|--------------------------------------------------------------------------
| CMS Admin
|--------------------------------------------------------------------------
|
| The title and version of the CMS Admin website.
|
*/
$config['cms_name'] = $_SERVER['HTTP_HOST'];
$config['cms_version'] = '2.0.1';

/*
|--------------------------------------------------------------------------
| Website title / page title separator
|--------------------------------------------------------------------------
|
| Format: Website title ['title_separator'] page title
| Example: My Website | Home
|
*/
$config['title_separator'] = ' | ';

/*
|--------------------------------------------------------------------------
| CMS Database Management System
|--------------------------------------------------------------------------
|
| This is the database to connect to for the CMS DBMS. This is not the main
| connection used by the website. To configure that connection go to
| application -> config -> database.php
|
| The database must be on the same host as the main database and accessable
| by the same user.
|
| If a database name is not set the it will default to the main database.
|
*/
$config['database'] = '';

/*
|--------------------------------------------------------------------------
| DBMS Saved Queries
|--------------------------------------------------------------------------
|
| Sidebar menu item name where your saved queries will appear.
| If a name is not set then the menu item will be removed.
|
*/
$config['saved_queries'] = 'Favorites';

/*
|--------------------------------------------------------------------------
| Main CSS File
|--------------------------------------------------------------------------
|
| Set the CSS file name with folder for the frontend.
|
*/
$config['css'] = 'assets/css/frontend.css';

/*
|--------------------------------------------------------------------------
| Google Analytics key file location
|--------------------------------------------------------------------------
|
\ Key file path loaction for Google Analytics
|
*/
$config['key_file_location'] = '';

/*
|--------------------------------------------------------------------------
| Page and Section Templates
|--------------------------------------------------------------------------
|
| Default page and section templates.
|
*/
$config['default_page'] = APPPATH . 'views/admin/layouts/page.php';
$config['default_section'] = APPPATH . 'views/admin/layouts/section.php';

/*
|--------------------------------------------------------------------------
| Blog Home and Blog Post
|--------------------------------------------------------------------------
|
| Default blog home and blog post page names.
|
*/
$config['blog_home'] = 'blog';
$config['blog_post'] = 'post';

/*
|--------------------------------------------------------------------------
| Table/Query Results Limit
|--------------------------------------------------------------------------
|
| 'field limit' is the number of columns to appear in all tables.
|
| 'dashboard_comments_limit', 'dashboard_posts_limit', and 'dashboard_pages_limit'
|  are the number of results to limit for each respective query on the dashboard.
|
| 'results_per_page' are the number of results to display per page for database
|  query's using pagination.
|
| 'summary_sentence_limit' is the number sentences that will display in the blog
|  homepage summary of each post.
|
*/
$config['field_limit'] = 6;
$config['dashboard_comments_limit'] = 4;
$config['dashboard_posts_limit'] = 4;
$config['dashboard_pages_limit'] = 4;
$config['results_per_page'] = 6;
$config['summary_sentence_limit'] = 3;
