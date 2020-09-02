<?php

class Menus extends Admin_Controller {

    protected $menu;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        $this->helper('file');
        $this->menu = $this->model('admin/Menu_model');
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Menus';
        $this->data['menu_json'] = $this->menu->menu_json();
        $this->data['menuitem'] = $this->menu->get(NULL, NULL, "menu_order ASC");
        $this->data['parentid'] = $this->menu->get(NULL, 'menu_parent_order IS NOT NULL', 'menu_parent_order ASC');
        $this->view('admin/pages/menus', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Insert
     *
     * @return	void
     */

    public function insert() {
        // Update menus table and redirect
        $this->menu->update_table();
        redirect('admin/menus');
    }

    // --------------------------------------------------------------------

    /**
     * Update
     *
     * @return	void
     */

    public function update() {
        // Process the form or show 404
        if (!empty($_POST)) {
            $this->menu->update_menu($_POST['menu_items']);
            redirect('admin/menus');
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Order
     *
     * @return	void
     */

    public function order() {
        // Process the form or show 404
        if (!empty($_POST)) {
            $this->menu->update_order($_POST['nestable_output']);
            redirect('admin/menus');
        }
        else {
            show_error_404();
        }
    }

}

?>
