<?php

class Comments extends Admin_Controller {

    protected $comments;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        $this->comments = $this->model('admin/Comment_model');
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Comments';
        $this->data['table'] = $this->comments->get_table();
        $this->data['query'] = $this->comments->get_comments();
        $this->view('admin/pages/content_results', $this->data);
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
            // Delete the comment
            foreach ($_POST['delete'] as $_value) {
                $this->comments->delete($_value);
            }

            redirect('admin/comments');
        }
        else {
            show_error_404();
        }
    }

}

?>
