<?php
/**
 * Chiatek - MVC Framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 Chiatek
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
defined('SYSPATH') OR exit('No direct script access allowed');

/*
* -------------------------------------------------------------------
*  Load core files
* -------------------------------------------------------------------
*/

	require_once SYSPATH . 'core/Common.php';
	require_once SYSPATH . 'core/Application.php';
	require_once SYSPATH . 'core/Controller.php';
	require_once SYSPATH . 'database/DB.php';

/*
* -------------------------------------------------------------------
*  Autoload files from the application/core directory
* -------------------------------------------------------------------
*/

	$files = scandir(APPPATH . 'core');

	foreach ($files as $file) {
		if (!is_dir($file) && file_exists(APPPATH . 'core/' . $file)) {
			require_once APPPATH . 'core/' . $file;
		}
	}

/*
* -------------------------------------------------------------------
*  Set custom error and exception handlers
* -------------------------------------------------------------------
*/

	set_error_handler("php_error_handler");
	set_exception_handler("exception_handler");

/*
* -------------------------------------------------------------------
*  Start the application
* -------------------------------------------------------------------
*/

	$app = new application();
