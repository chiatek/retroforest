<?php

class Templates extends Admin_Controller {

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
        $this->page = $this->model('admin/Template_model');

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
        // Get file info from page and section template folders
        $page = get_dir_file_info(path('templates'));
        $section = $this->page->get_section_file_info('section_templates');

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Templates';
        $this->data['file_type'] = $this->page->get_file_type();
        $this->data['file_info'] = array_merge($page, $section);
        $this->view('admin/pages/file_results', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit
     *
     * @param   string $file_type
     * @param   string $file_name
     * @return	void
     */

    public function edit($file_type = NULL, $file_name = NULL) {

        // Process the form
        if (!empty($_POST)) {

            if (file_exists(path('templates').'/'.$file_name)) {
                // Tempplates
                $html = $this->page->update_header($_POST, $file_name, $this->data['config']);
                $html = $this->page->update_footer($html);
                $this->page->save_template($html, $file_name);
            }
            else {
                // Sections
                $section = $this->model('admin/Section_model');
                $section->set_file_type($file_type);
                $section->save_section($_POST['html'], $file_name, path('section_templates').'/'.$file_type);
            }
        }

        // Get Meta tags
        if ($file_type == "templates") {
            $this->data['meta_tag'] = $this->page->get_meta_tags(NULL, $file_name, $file_type);
        }

        // Update blocks
        if (empty($_POST)) {
            $this->page->sections_to_blocks();
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Template';
        $this->data['file_name'] = $file_name;
        $this->data['file_type'] = $file_type;
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
            $this->page->new_template($_POST, $_POST['page_filename'].'.php');

            if (isset($_POST['section'])) {
                redirect('admin/templates/edit/'.$_POST['section'].'/'.$_POST['page_filename'].'.php');
            }
            else {
                redirect('admin/templates/edit/'.$_POST['page_type'].'/'.$_POST['page_filename'].'.php');
            }
        }

        // Set page data and load the view
        $this->data['file_type'] = $this->page->get_file_type();
        $this->data['title'] = config('cms_name') . config('title_separator') . 'New Page';
        $this->data['sections'] = $this->page->get_section_list();
        $this->data['templates'] = get_dir_file_info(path('templates'));
        $this->view('admin/pages/template_new', $this->data);

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
            redirect('admin/templates');
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit tepmplate
     *
     * @param   string $file_type
     * @param   string $file_name
     * @return	void
     */

    public function edit_template($file_type = NULL, $file_name = NULL) {
        // Set page data
        $this->data['file_type'] = $file_type;
        $this->data['file_name'] = $file_name;

        // Verify page exists and load the view
        if (file_exists(path('templates').'/'.$file_name.'.php')) {
            $this->view('admin/templates/pages/'.$file_name, $this->data);
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit section
     *
     * @param   string $file_type
     * @param   string $file_name
     * @return	void
     */

    public function edit_section($file_type = NULL, $file_name = NULL) {
        // Set page data
        $this->data['title'] = ucfirst($file_name);
        $this->data['file_type'] = $file_type;
        $this->data['file_name'] = $file_name;

        // Verify page exists and load the view
        if (file_exists(path('section_templates').'/'.$file_type.'/'.$file_name.'.php')) {
            $this->view('admin/layouts/template', $this->data);
        }
        else {
            show_error_404();
        }
    }

}

?>
