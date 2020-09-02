<?php

class Category extends Admin_Controller {

    protected $category;
    protected $form_validation;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        // Create new category
        $this->category = $this->model('admin/Category_model');

        // Set form validation rules
        $this->form_validation = $this->library('Form_validation');
        $config = $this->category->config;
        $this->form_validation->set_rules($config);
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        $fields = $this->category->limit_fields();

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Category';
        $this->data['table'] = $this->category->get_table();
        $this->data['query'] = $this->category->get($fields);
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
        // Process the form
        if ($this->form_validation->run() == TRUE) {
            if ($this->category->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = $_POST['category_name']. ' has been saved!';
            }
            redirect('admin/category/edit/'.$pkey_val);
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Category';
        $this->data['category_all'] = $this->category->get();
        $this->data['row'] = $this->category->get_first_row(NULL, $pkey_val);
        $this->view('admin/pages/edit_category', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Insert
     *
     * @return	void
     */

    public function insert() {
        // Process the form
        if ($this->form_validation->run() == TRUE) {
            if ($this->category->insert($_POST)) {
                $_SESSION['toastr_success'] = $_POST['category_name']. ' has been created!';
            }
            redirect('admin/category');
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'New Category';
        $this->data['category_all'] = $this->category->get();
        $this->view('admin/pages/category_new', $this->data);
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
                // Delete any foreign key constraints
                $this->category->delete_foreign_key($value, 'post_category');
                // Delete the category
                $this->category->table('category');
                $this->category->delete($value);
            }

            redirect('admin/category');
        }
        else {
            show_error_404();
        }
    }

}

?>
