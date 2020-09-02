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

class DB_init {

    protected static $instance = NULL;
    protected $conn = NULL;
    protected $database;
    private $hostname;
    private $username;
    private $password;

    public function __construct() {

        require APPLICATION . 'config/database.php';

        $this->hostname = $db[$active_group]['hostname'];
        $this->username = $db[$active_group]['username'];
        $this->password = $db[$active_group]['password'];
        $this->database = $db[$active_group]['database'];

        try {
            $this->conn = new PDO("mysql:host={$this->hostname};dbname={$this->database}", $this->username, $this->password, $options);
        }
        catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }

    }

}

?>
