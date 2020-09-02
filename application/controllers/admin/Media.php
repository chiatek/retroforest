<?php

class Media extends Admin_Controller {

    protected $page;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();

        $this->app_library('File_Model');
        $this->page = $this->model('admin/Media_model');
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Media';
        $this->data['file_type'] = 'media';
        $this->data['file_info'] = get_dir_file_info(path('uploads'));
        $this->view('admin/pages/file_results', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit
     *
     * @param   string $file_name
     * @return	void
     */

    public function edit($file_name) {
        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Image';
        $this->data['file_name'] = $file_name;
        $this->view('admin/pages/edit_image', $this->data);
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
            if(!delete_files($_POST['delete'])) {
                $_SESSION['toastr_error'] = 'Error - Unable to delete file(s)';
            }
            redirect('admin/media');
        }
        else {
            show_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Upload
     *
     * @return	void
     */

    public function upload() {
        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Upload Image';
        $this->data['error'] = ' ';
        $this->data['success'] = FALSE;
        $this->view('admin/pages/media_new', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * AJAX Upoad
     *
     * @param   string $file_name
     * @return	void
     */

    public function ajax_upload($file_name) {
        // Set target directory to img/uploads
        $target_dir = path('uploads');
        $target_file = $target_dir."/".$file_name;

        // Get uploaded file and move to target directory
        $file_to_upload = $_FILES['croppedImage']['tmp_name'];
        move_uploaded_file($file_to_upload, $target_file);

        redirect('admin/media');
    }

    // --------------------------------------------------------------------

    /**
     * Do Upload
     *
     * @return	void
     */

    public function do_upload() {
        // Get upload configuration
        $upload = $this->library('Upload');
        $config = $this->page->upload_config();

        if (!$upload->do_upload($config)) {
            // Upload failed
            $this->data['success'] = FALSE;
            $this->data['error'] = $upload->display_errors();
        }
        else {
            // Upload success
            $this->data['success'] = TRUE;
            $this->data['error'] = ' ';
            $this->data['upload_data'] = $upload->data();
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Media Upload Success';
        $this->view('admin/pages/media_new', $this->data);
    }

}

?>
