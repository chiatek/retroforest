<?php

class Frontend_Controller extends Controller {

    function __construct() {
        parent::__construct();

		/*
        // If the database connection fails run CMS setup.
        if (!DB::check_connection()) {
            redirect('admin/users/setup');
            exit;
        }
		*/

        // Load string helper
        $this->helper('string');

        // Load the menu
        $this->db->table('menus');
        $this->data['menu_item'] = $this->db->get(NULL, NULL, "menu_order ASC");
        $this->data['parent_id'] = $this->db->get(NULL, 'menu_parent_order IS NOT NULL', 'menu_parent_order ASC');

    }

}

?>
