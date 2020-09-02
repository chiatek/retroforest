<?php

class Posts extends Frontend_Controller {

    protected $post;
    protected $category;
    protected $pagination;
    protected $form_validation;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        $this->post = $this->model('Posts_model');
        $this->pagination = $this->library('Pagination');

        // Set form validation rules
        $this->form_validation = $this->library('Form_validation');
        $config = $this->post->config;
        $this->form_validation->set_rules($config);

        // Load categories
        $this->category = $this->model('admin/Category_model');
        $this->data['widget_category'] = $this->category->get("*", NULL, NULL, 6);

        // Load settings
        $this->db->table('settings');
        $this->data['config'] = $this->db->get_first_row(['setting_datetime', 'setting_comments'], ['setting_id' => 1]);
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        // Verify page exists or show 404
        if (!file_exists(path('pages').'/'.config('blog_home').'.php')) {
            show_error_404();
        }

        // Load pagination and set config
        $config = $this->post->pagination_config();

        // Load posts
        $total = $this->post->get("*", array('post_status' => 'published'));
        $offset = $this->pagination->initialize($config, segment(3), $total->rowCount());
        $this->data['posts'] = $this->post->get("*", array('post_status' => 'published'), "post_modified DESC", "LIMIT ".$config['per_page']." OFFSET ".$offset);

        // Initialize settings and load the view
        $this->data['links'] = $this->pagination->create_links();
        $this->view('pages/'.config('blog_home'), $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * slug
     *
     * @param   string $slug
     * @return	void
     */

    public function slug($slug) {

        // Load posts
        $this->data['posts'] = $this->post->get(NULL, array('post_slug' => $slug, 'post_status' => 'published'));

        // Verify page exists or show 404
        if (!file_exists(path('pages').'/'.config('blog_post').'.php') || $this->data['posts']->rowCount() == 0) {
            show_error_404();
        }

        // Load categories
        $this->data['post'] = $this->data['posts']->fetch();
        $this->data['categories'] = $this->category->inner_join('post_category', NULL, ['post_id' => $this->data['post']->post_id]);

        // Load comments
        $this->db->table('comments');
        $this->data['comments'] = $this->db->get(NULL, array('post_id' => $this->data['post']->post_id));
        $this->data['total_comments'] = $this->data['comments']->rowCount();

        // Load the view
        $this->view('pages/'.config('blog_post'), $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Comments
     *
     * @param   int $post_id
     * @return	void
     */

    public function comments($post_id = NULL) {
        // Get slug
        $query = $this->post->get_first_row(NULL, $post_id);
        $slug = $query->post_slug;

        // Process the form or show 404
        if ($this->form_validation->run() == TRUE) {
            $_POST += array(
                'post_id' => $post_id,
                'comment_date' => date("Y-m-d h:i:s")
            );

            $this->db->table('comments');
            $this->db->insert($_POST);
            redirect('posts/'.$slug);
        }
        else if (isset($post_id) && isset($slug)) {
            $this->slug($slug);
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Filter
     *
     * @param   string $query
     * @param   bool $category
     * @return	void
     */

    public function filter($query = NULL, $category = FALSE) {
        // Verify page exists or show 404
        if (!file_exists(path('pages').'/'.config('blog_home').'.php')) {
            show_error_404();
        }
        
        // Load pagination and set config
        $config = $this->post->pagination_config();

        // Set the pagination url and search query
        if (!empty($_POST)) {
            $config['base_url'] = base_url('posts/filter/'.$_POST['query']);
            $param = $_POST['query'];
        }
        else if (!empty($query)) {
            $config['base_url'] = base_url('posts/filter/'.$query);
            $param = $query;
        }
        else {
            redirect('posts');
        }

        // load posts
        $row_count = $this->post->get_search_query($param, NULL, TRUE);
        $offset = $this->pagination->initialize($config, segment(4), $row_count);
        $this->data['posts'] = $this->post->get_search_query($param, $offset);

        // Initialize links and load the view
        $this->data['links'] = $this->pagination->create_links();
        $this->view('pages/'.config('blog_home'), $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Category
     *
     * @param   string $category
     * @return	void
     */

    public function category($category = NULL) {
        // Verify page exists or show 404
        if (!file_exists(path('pages').'/'.config('blog_home').'.php')) {
            show_error_404();
        }

        // Load pagination and set config
        $config = $this->post->pagination_config();

        // Set the pagination url and load posts for the selected category
        if (isset($category)) {
            $config['base_url'] = base_url('posts/category/'.$category.'/');
            $row_count = $this->post->get_category_query($category, NULL, TRUE);
            $offset = $this->pagination->initialize($config, segment(4), $row_count);
            $this->data['posts'] = $this->post->get_category_query($category, $offset);
        }
        else {
            redirect('posts');
        }

        // Initialize links and load the view
        $this->data['links'] = $this->pagination->create_links();
        $this->view('pages/'.config('blog_home'), $this->data);
    }

}

?>
