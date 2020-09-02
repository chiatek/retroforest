<?php
defined('SYSPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URL Routing
| -------------------------------------------------------------------------
*/

/* Admin Controller */
$route['admin'] = 'admin/users/dashboard';

/* Frontend Controller */
$route['posts/index'] = "posts/index";
$route['posts/filter'] = "posts/filter";
$route['posts/category'] = "posts/category";
$route['posts/(:any)'] = "posts/slug/$1";
