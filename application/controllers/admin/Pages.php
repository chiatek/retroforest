<?php

class Pages extends Admin_Controller {

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
        $this->page = $this->model('admin/Page_model');

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
        // Get file info from pages and drafts folders
        $published = get_dir_file_info(path('pages'));
        $draft = get_dir_file_info(path('drafts'));

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Pages';
        $this->data['file_type'] = $this->page->get_file_type();
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

            $html = $this->page->update_header($_POST, $file_name, $this->data['config']);
            $html = $this->page->update_footer($html);

            if ($_POST['page_publish']) {
                // Publish the section / page
                $this->page->publish_page($html, $file_name);
            }
            else {
                // Save the section / page
                $this->page->save_page($html, $file_name);
            }
        }

        // Set file type to drafts or pages
        if (file_exists(path('drafts').'/'.$file_name)) {
            $this->page->set_file_type("drafts");
        }
        else {
            $this->page->set_file_type("pages");
        }

        // Update blocks
        if (empty($_POST)) {
            $this->page->sections_to_blocks();
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Page';
        $this->data['file_name'] = $file_name;
        $this->data['file_type'] = $this->page->get_file_type();
        $this->data['meta_tag'] = $this->page->get_meta_tags(NULL, $file_name, $this->data['file_type']);
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
            $file_name = $this->page->new_page($_POST, $_POST['page_filename'].'.php');
            redirect('admin/pages/edit/'.$file_name);
        }

        // Change the file type to drafts
        $this->page->set_file_type("drafts");
        $this->data['file_type'] = $this->page->get_file_type();

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'New Page';
        $this->data['templates'] = get_dir_file_info(path('templates'));
        $this->view('admin/pages/page_new', $this->data);
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
            // Delete the file
            delete_files($_POST['delete']);
            // Delete the controller
            $this->page->delete_controller($_POST['delete']);
            redirect('admin/pages');
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit page
     *
     * @param   string $file_type
     * @param   string $file_name
     * @return	void
     */

    public function edit_page($file_type = NULL, $file_name = NULL) {
        // Set page data
        $this->data['file_type'] = $file_type;
        $this->data['file_name'] = $file_name;

        // Verify page exists and load the view
        if (file_exists(path('admin').'/'.$file_type.'/'.$file_name.'.php') && $file_type == "drafts") {
            $this->view('admin/drafts/'.$file_name, $this->data);
        }
        else if (file_exists(path('views').'/'.$file_type.'/'.$file_name.'.php') && $file_type == "pages") {
            $this->view('pages/'.$file_name, $this->data);
        }
        else {
            show_error_404();
        }
    }

}

?>
