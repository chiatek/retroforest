<?php

class Admin_Controller extends Controller {

    protected $user;
    protected $notification;

    // These admin URL's can be accessed without logging in.
    private $exception_urls = array(
        'admin/users/login',
        'admin/users/logout',
        'admin/users/reset_password',
        'admin/users/setup'
    );

    // These admin URL's can only be accessed by administrators.
    private $admin_urls = array(
        'admin/users',
        'admin/users/edit',
        'admin/users/new'
    );

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    function __construct() {
        parent::__construct();

        // Start the session
        session_start();
        // Load string helper
        $this->helper('string');
        // Create a new user
        $this->user = $this->model('admin/User_model');

        // The user has not yet logged in and is trying to access a restricted page.
        if (in_array(url_string(), $this->exception_urls) == FALSE) {

			/*
            // If the database connection fails run CMS setup.
            if (!DB::check_connection()) {
                redirect('admin/users/setup');
                exit;
            }
			*/

            // The user is not logged in, redirect to login page.
            if (!isset($_SESSION['user_username'])) {
                redirect('admin/users/login');
                exit;
            }
        }

        // The user is logged in. Load database and get user info.
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_username'])) {

            // Load the user
            $this->data['user'] = $this->user->get_user_info();

            // Load the menu
            $this->db->table('menus');
            $this->data['menu_item'] = $this->db->get(NULL, NULL, "menu_order ASC");
            $this->data['parent_id'] = $this->db->get(NULL, 'menu_parent_order IS NOT NULL', 'menu_parent_order ASC');

            // Load settings
            $this->db->table('settings');
            $this->data['config'] = $this->db->get_first_row(NULL, array('setting_id' => 1));

            // Load saved queries
            if (config('saved_queries') != NULL) {
                $this->db->table('queries');
                $this->data['saved_query_menu'] = $this->db->get(NULL, array('user_id' => $_SESSION['user_id'], 'add_to_menu' => 'yes'));
            }

            // Load notifications
            $this->notification = $this->model('admin/Notification_model');
            $this->data['notifications'] = $this->notification->get_notifications($_SESSION['user_id']);
            $this->data['total_notifications'] = $this->data['notifications']->rowCount();

            // If the user is not administrator restrict access from $admin_urls list.
            if ($this->data['user']->user_role != "administrator") {
                if (in_array(url_string(), $this->admin_urls) == TRUE) {
                    redirect('admin');
                }
            }
        }
    }

}

?>
