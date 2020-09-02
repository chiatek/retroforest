<?php

class Users extends Admin_Controller {

    protected $database;
    protected $form_validation;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        $this->form_validation = $this->library('Form_validation');

        if (config('saved_queries') != NULL) {
            $this->database = $this->model('admin/Database_model');
        }
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        $fields = $this->user->limit_fields();

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Users';
        $this->data['table'] = $this->user->get_table();
        $this->data['query'] = $this->user->get($fields);
        $this->view('admin/pages/content_results', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit
     *
     * @param   int $pkey_val
     * @return	void
     */

    public function edit($pkey_val = NULL) {
        // Set form validation rules
        $config = $this->user->config;
        $this->form_validation->set_rules($config);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            if (empty($_POST['user_birthday'])) {
                $_POST['user_birthday'] = NULL;
            }

            if ($this->user->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = 'User '.$_POST['user_username'].' has been saved!';
            }
            redirect('admin/users/edit/'.$pkey_val);
        }

        // Restrict access if user is not admin
        if ($this->data['user']->user_role != "administrator") {
            redirect('admin');
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit User';
        $this->data['error'] = -1;
        $this->data['validation_errors'] = $this->form_validation->validation_errors();
        $this->data['pkey_val'] = $pkey_val;
        $this->data['row'] = $this->user->get_first_row(NULL, $pkey_val);
        $this->view('admin/pages/edit_user', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Insert
     *
     * @return	void
     */

    public function insert() {
        // Set form validation rules
        $config = $this->user->config;
        $this->form_validation->set_rules($config);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $password = $this->user->set_user_password($_POST['user_name'], $_POST['user_email']);
            $_POST += array('user_password' => $password);

            if ($this->user->insert($_POST)) {
                $_SESSION['toastr_success'] = 'User '.$_POST['user_username'].' has been created!';
            }

            redirect('admin/users');
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'New User';
        $this->data['validation_errors'] = $this->form_validation->validation_errors();
        $this->view('admin/pages/user_new', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Delete
     *
     * @return	void
     */

    public function delete() {
        // Process the form or show 404
        if (!empty($_POST)) {
            foreach ($_POST['delete'] as $value) {
                $this->user->delete($value);
            }

            redirect('admin/users');
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Dashboard
     *
     * @param   string $date
     * @param   string $metric
     * @return	void
     */

    public function dashboard($date = NULL, $metric = NULL) {
        $this->helper('file');
        $this->helper('analytics');
        $post = $this->model('admin/Post_model');
        $comment = $this->model('admin/Comment_model');

        // AJAX: Google Analytics Charts
        if (isset($date) && isset($metric)) {
            $this->user->ajax_analytics_chart($date, $metric);
        }
        // AJAX: Google Analytics stats
        else if (isset($date)) {
            $this->user->ajax_analytics_stats($date);
        }
        // Load dashboard
        else {

            // Set Google Analytics (page views)
            $this->data['page_views'] = $this->user->analytics('today', '7daysAgo', 'ga:pageViews');

            // Get total posts
            if (!$this->data['config']->setting_dashboard_GA) {
                $this->data['total_posts'] = $post->get("*", array('post_status' => 'published'))->rowCount();
            }

            // Load posts
            $sql = $post->compile_left_join("t1.post_slug = t2.post_slug", "t1.post_modified < t2.post_modified", "t2.post_id IS NULL", "t1.post_modified DESC", config('dashboard_posts_limit'));
            $this->data['posts'] = $post->query($sql);

            // Set pages
            $this->data['pages'] = get_dir_file_info(path('pages'));

            // Load comments
            $this->data['comments'] = $comment->get_comments(config('dashboard_comments_limit'));
            $this->data['total_comments'] = $comment->get()->rowCount();

            // Load saved queries
            if (config('saved_queries') != NULL) {
                $this->db->table('queries');
                $this->data['saved_query_dashboard'] = $this->db->get(NULL, array('user_id' => $_SESSION['user_id'], 'add_to_dashboard' => 'yes'));
            }

            // Set additional page data and load the view
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Dashboard';
            $this->view('admin/pages/index', $this->data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Notifications
     *
     * @param   int $id
     * @return	void
     */

    public function notifications($id) {
        // Process the form
        if (!empty($id)) {
            $this->db->table('notification_user');
            $this->db->update(["nu_dismiss" => 1], ["nu_id" => $id]);
        }
        redirect('admin');
    }

    // --------------------------------------------------------------------

    /**
     * Profile
     *
     * @param   int $pkey_val
     * @return	void
     */

    public function profile($pkey_val = NULL) {
        // Set form validation rules
        $config = $this->user->config;
        $this->form_validation->set_rules($config);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            if (empty($_POST['user_birthday'])) {
                $_POST['user_birthday'] = NULL;
            }

            if ($this->user->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = 'Your profile has been saved!';
            }
            redirect('admin/users/profile');
        }

        // Get upload folder info for image modal
        $this->helper('file');
        $this->data['media_info'] = get_dir_file_info(path('uploads'));

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Profile';
        $this->data['validation_errors'] = $this->form_validation->validation_errors();
        $this->view('admin/pages/profile', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Login
     *
     * @return	void
     */

    public function login() {
        $this->data['error'] = 0;

        // Process the form
        if (!empty($_POST)) {

            // Get user login info
            $user = $this->user->get_first_row(NULL, array(
                'user_username' => $_POST['username'],
                'user_password' => hash_password($_POST['password'])
            ));

            if (!$user) {
                // Username or password not found
                $this->data['error'] = 1;
            }
            else {
                // Set user session to grant login and update activity
                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['user_username'] = $user->user_username;
                $this->user->update(array('user_activity' => date("Y-m-d h:i:s")), $user->user_id);
                redirect('admin');
            }
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Log In';
        $this->view('admin/pages/login', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Setup
     *
     * @return	void
     */

    public function setup() {
        if (!DB::check_connection() && !empty($_POST)) {
            // Process the form
            $database = $_POST['db_name'];
            $username = $_POST['db_username'];
            $password = $_POST['db_password'];
            $hostname = $_POST['db_hostname'];

            $this->user->create_database($database, $hostname, $username, $password);
            $this->user->restore_database($database, $hostname, $username, $password);
            $this->user->insert_data($_POST);
        }
        else if (!DB::check_connection()) {
            // Database connetion failed, load CMS setup
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Setup';
            $this->view('admin/pages/setup', $this->data);
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Change Password
     *
     * @return	void
     */

    public function change_password() {
        // Set form validation rules
        $config = $this->user->password_config;
        $this->form_validation->set_rules($config);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $password = $this->user->get_first_row('user_password', array('user_id' => $_SESSION['user_id']));
            $this->user->change_user_password($password->user_password, $_POST['current_password'], $_POST['new_password'], $_POST['repeat_password']);
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Profile';
        $this->data['change_password'] = TRUE;
        $this->view('admin/pages/profile', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Reset Password
     *
     * @return	void
     */

    public function reset_password($id = NULL) {

        // Reset password from users/edit
        if ($id) {
            // Process the form (get email from query)
            $user = $this->user->get_first_row('user_email', $id);
            $this->data['error'] = $this->user->reset_user_password($user->user_email);

            // Set page data and load the view
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit User';
            $this->data['pkey_val'] = $id;
            $this->data['row'] = $this->user->get_first_row(NULL, $id);
            $this->view('admin/pages/edit_user', $this->data);
        }
        // Reset password from login screen
        else {
            $this->data['error'] = -1;
            // Process the form (get email from $_POST)
            if (!empty($_POST)) {
                $this->data['error'] = $this->user->reset_user_password($_POST['email_address']);
            }

            // Set page data and load the view
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Reset Password';
            $this->view('admin/pages/reset_password', $this->data);
        }

    }

    // --------------------------------------------------------------------

    /**
     * logout
     *
     * @return	void
     */

    public function logout() {
        session_unset();
        session_destroy();
        redirect('admin/users/login');
    }

}

?>
