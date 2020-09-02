<?php

class Home extends Frontend_Controller {

    protected $post;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();

        $this->post = $this->model('Posts_model');
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        // Verify page exists or show 404
        if (!file_exists(path('pages').'/index.php')) {
            show_error_404();
        }

        // Load posts
        $this->data['latest_posts'] = $this->post->get("*", array('post_status' => 'published'), "post_modified DESC", "LIMIT 6");
        $this->data['carousel_posts'] = $this->post->get("*", array('post_status' => 'published'), "post_modified DESC");

        // Load the view
        $this->view('pages/index', $this->data);
    }

}

?>
