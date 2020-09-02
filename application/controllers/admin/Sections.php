<?php

class Sections extends Admin_Controller {

    protected $page;
    protected $form_validation;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        $this->app_library('File_Model');
        $this->page = $this->model('admin/Section_model');
        $this->data['file_type'] = 'sections';

        // Set form validation rules
        $this->form_validation = $this->library('Form_validation');
        $config = $this->page->config;
        $this->form_validation->set_rules($config);
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        // Get file info from admin/components and views/components
        $published = get_dir_file_info(path('sections'));
        $draft = get_dir_file_info(path('admin_sections'));

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Sections';
        $this->data['file_info'] = array_merge($published, $draft);
        $this->view('admin/pages/file_results', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit
     *
     * @param   string $file_name
     * @return	void
     */

    public function edit($file_name = NULL) {

        // Process the form
        if (!empty($_POST)) {
            if ($_POST['page_publish']) {
                // Publish the section
                $this->page->publish_section($_POST['html'], $file_name);
            }
            else {
                // Save the section
                $this->page->save_section($_POST['html'], $file_name, path('admin_sections'));
            }
        }

        // Update blocks
        if (empty($_POST)) {
            $this->page->sections_to_blocks();
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Section';
        $this->data['file_name'] = $file_name;
        $this->view('admin/pages/edit_page', $this->data);
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
            $this->page->new_section($_POST, $_POST['page_filename'].'.php');
            redirect('admin/sections/edit/'.$_POST['page_filename'].'.php');
        }

        // Set the page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'New Page';
        $this->data['templates'] = $this->page->get_section_file_info('section_templates');
        $this->view('admin/pages/section_new', $this->data);
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
            delete_files($_POST['delete']);
            redirect('admin/sections');
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit section
     *
     * @param   string $file_name
     * @return	void
     */

    public function edit_section($file_name = NULL) {
        // Set page data
        $this->data['title'] = ucfirst($file_name);
        $this->data['file_name'] = $file_name;

        // Verify page exists and load the view
        if (file_exists(path('admin_sections').'/'.$file_name.'.php')) {
            $this->view('admin/layouts/draft', $this->data);
        }
        else if (file_exists(path('sections').'/'.$file_name.'.php')) {
            $this->view('admin/layouts/publish', $this->data);
        }
        else {
            show_error_404();
        }
    }

}

?>
