<?php

class Posts extends Admin_Controller {

    protected $post;
    protected $form_validation;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();

        $this->helper('file');
        $this->post = $this->model('admin/Post_model');

        // Set form validation rules
        $this->form_validation = $this->library('Form_validation');
        $config = $this->post->config;
        $this->form_validation->set_rules($config);
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        // Get SQL statement for all posts (drafts and published)
        $sql = $this->post->compile_left_join("t1.post_slug = t2.post_slug", "t1.post_modified < t2.post_modified", "t2.post_id IS NULL", "t1.post_modified DESC");

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Posts';
        $this->data['table'] = $this->post->get_table();
        $this->data['query'] = $this->post->query($sql);
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

            // Set categories
            $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : NULL;
            $prev_category = isset($_POST['prev_category']) ? $_POST['prev_category'] : NULL;

            if ($_POST['post_status'] == "published") {
                // Publish the post
                $id = $this->post->publish_post($_POST, $pkey_val);
                $_SESSION['toastr_success'] = $_POST['post_slug']. ' has been published!';
            }
            else {
                // Save the post
                $id = $this->post->save_post($_POST, $pkey_val);
                $_SESSION['toastr_success'] = $_POST['post_slug']. ' has been saved!';
            }

            // Update categories
            $category = $this->model('admin/Category_model');
            $category->update_categories($category_id, $prev_category, $id, $pkey_val);
            redirect('admin/posts/edit/'.$id);
        }

        // Get upload folder info for image modal
        $this->data['media_info'] = get_dir_file_info(path('uploads'));

        // Load and set categories
        $category = $this->model('admin/Category_model');
        $this->data['category_all'] = $category->get();
        $this->data['category_post'] = $category->inner_join('post_category', NULL, 'post_category.post_id = '.$pkey_val);

        // Load and set posts
        $this->data['row'] = $this->post->get_first_row(NULL, $pkey_val);

        // Set additional page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Post';
        $this->data['pkey_val'] = $pkey_val;
        $this->view('admin/pages/edit_post', $this->data);
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
            $_POST = $this->post->insert_post_array($_POST);
            $pkey_val = $this->post->insert($_POST);
            redirect('admin/posts/edit/'.$pkey_val);
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'New Post';
        $this->view('admin/pages/post_new', $this->data);
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
                $this->post->delete_foreign_key($value, 'post_category');
                $this->post->delete_foreign_key($value, 'comments');

                // Delete the post
                $this->post->table('posts');
                $this->post->delete($value);
            }

            redirect('admin/posts');
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Search
     *
     * @return	void
     */

    public function search() {

        // Get SQL statement for search query
        $sql = $this->post->search_sql($_POST['query']);

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Posts Search';
        $this->data['table'] = $this->post->get_table();
        $this->data['query'] = $this->post->query($sql);
        $this->view('admin/pages/content_results', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Drafts
     *
     * @param   string $slug
     * @return	void
     */

    public function drafts($slug = NULL) {
        // Get the post by slug name and draft status
        $this->data['posts'] = $this->post->get(NULL, array('post_slug' => $slug, 'post_status' => 'draft'));

        if (!empty($this->data['posts'])) {
            $this->data['post'] = $this->data['posts']->fetch();

            // Load categories
            // SELECT * FROM category INNER JOIN post_category ON post_category.category_id = category.category_id WHERE post_id = ?
            $this->db->table('category');
            $this->db->primary_key('category_id');
            $this->data['categories'] = $this->db->inner_join('post_category', NULL, ['post_id' => $this->data['post']->post_id]);

            // Load comments
            // SELECT * FROM comments WHERE post_id = :post_id
            $this->db->table('comments');
            $this->data['comments'] = $this->db->get(NULL, array('post_id' => $this->data['post']->post_id));
            $this->data['total_comments'] = $this->data['comments']->rowCount();

            $this->data['posts']->execute();
        }

        if (file_exists(path('pages').'/'.config('blog_post').'.php') && $slug != NULL) {
            $this->view('pages/'.config('blog_post'), $this->data);
        }
        else if (file_exists(path('pages').'/'.config('blog_home').'.php')) {
            $this->view('pages/'.config('blog_home'), $this->data);
        }
        else {
            show_error_404();
        }
    }

}

?>
