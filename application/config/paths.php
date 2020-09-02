<?php
defined('SYSPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Path
|--------------------------------------------------------------------------
*/
$path['base'] = $_SERVER['DOCUMENT_ROOT'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';

/*
|--------------------------------------------------------------------------
| Log File Path
|--------------------------------------------------------------------------
*/
$path['logs'] = APPPATH . 'logs';

/*
|--------------------------------------------------------------------------
| Application File Paths
|--------------------------------------------------------------------------
*/
$path['views'] = APPPATH . 'views';
$path['pages'] = APPPATH . 'views/pages';
$path['admin'] = APPPATH . 'views/admin';
$path['sections'] = APPPATH . 'views/sections';
$path['drafts'] = APPPATH . 'views/admin/drafts';
$path['layouts'] = APPPATH . 'views/admin/layouts';
$path['admin_sections'] = APPPATH . 'views/admin/sections';
$path['templates'] = APPPATH . 'views/admin/templates/pages';
$path['section_templates'] = APPPATH . 'views/admin/templates/sections';

/*
|--------------------------------------------------------------------------
| Asset File Paths
|--------------------------------------------------------------------------
*/
$path['images'] = ASSETPATH . 'img';
$path['uploads'] = ASSETPATH . 'img/uploads';
$path['admin_images'] = ASSETPATH . 'img/admin';
$path['admin_thumbnails'] = ASSETPATH . 'img/admin/thumbnails';
$path['page_builder'] = ASSETPATH . 'vendor/vvvebjs/libs/builder';
