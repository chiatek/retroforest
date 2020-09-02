<?php

class Posts_model extends DB {

    protected $table = "posts";
    protected $primary_key = "post_id";
    public $config = array(
        'comment_name' => array(
            'field' => 'comment_name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        'comment_text' => array(
            'field' => 'comment_text',
            'label' => 'Comment',
            'rules' => 'trim|required'
        )
    );

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * Pagination Config
     *
     * @return	void
     */

    public function pagination_config() {
        $config = array(
            'base_url' => base_url('posts/index'),
            'per_page' => config('results_per_page'),
            'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close' => '<span class="sr-only">(current)</span></span></li>',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',
            'full_tag_open' => '<ul class="pagination justify-content-center">',
            'full_tag_close' => '</ul>',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',
            'next_link' => '&raquo',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',
            'prev_link' => '&laquo',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>'
        );

        return $config;
    }

    // --------------------------------------------------------------------

    /**
     * Get search query
     * Returns the database query or number of rows for the search string
     *
     * @param   string $string
     * @param   int $offset
     * @param   bool $total_rows
     * @return	mixed
     */

    public function get_search_query($string, $offset = NULL, $total_rows = FALSE) {
        $string = str_replace("%20", " ", $string);

        $category_id = $this->get_category_id($string);
        $post_sql = $this->post_sql();
        $search_sql = $this->search_sql($string, $category_id);
        $limit_offset_sql =  $this->limit_offset_sql($offset);

        if ($total_rows) {
            $query = $this->query($post_sql." ".$search_sql);
            return $query->rowCount();
        }

        $query = $this->query($post_sql." ".$search_sql." ".$limit_offset_sql);
        return $query;
    }

    // --------------------------------------------------------------------

    /**
     * Get Category query
     * Returns the database query or number of rows for the category string
     *
     * @param   string $string
     * @param   int $offset
     * @param   bool $total_rows
     * @return	mixed
     */

    public function get_category_query($string, $offset = NULL, $total_rows = FALSE) {

        $category_id = $this->get_category_id($string);
        $post_sql = $this->post_sql();
        $category_sql = $this->category_sql($category_id);
        $limit_offset_sql =  $this->limit_offset_sql($offset);

        if ($total_rows) {
            $query = $this->query($post_sql." ".$category_sql);
            return $query->rowCount();
        }

        $query = $this->query($post_sql." ".$category_sql." ".$limit_offset_sql);
        return $query;
    }

    // --------------------------------------------------------------------

    /**
     * Post SQL
     *
     * @return	string
     */

    public function post_sql() {
        $sql = "SELECT DISTINCT posts.post_id, posts.post_title, posts.post_slug, posts.post_author, posts.post_modified, posts.post_body, posts.post_image FROM posts
                LEFT JOIN post_category
                on post_category.post_id=posts.post_id
                WHERE posts.post_status = 'published'";

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Category SQL
     *
     * @param   int $category_id
     * @return	string
     */

    public function category_sql($category_id) {
        $sql = "AND post_category.category_id = '".$category_id."'
                ORDER BY posts.post_modified DESC";

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Search SQL
     *
     * @param   string $string
     * @param   int $category_id
     * @return	void
     */

     public function search_sql($string, $category_id) {
         $sql =  "AND (post_category.category_id = '".$category_id."'
                 OR posts.post_title LIKE '%".$string."%'
                 OR posts.post_slug LIKE '%".$string."%'
                 OR posts.post_author LIKE '%".$string."%'
                 OR posts.post_description LIKE '%".$string."%'
                 OR posts.post_body LIKE '%".$string."%')
                 ORDER BY posts.post_modified DESC";

         return $sql;
     }

    // --------------------------------------------------------------------

    /**
     * Limit Offset SQL
     *
     * @param   int $offset
     * @return	void
     */

    public function limit_offset_sql($offset) {

        if (!empty(segment(4)) && isset($offset)) {
            return "LIMIT ".config('results_per_page')." OFFSET ".$offset;
        }
        else {
            return "LIMIT ".config('results_per_page');
        }

    }

    // --------------------------------------------------------------------

    /**
     * Get category_id - Returns category_id on success, 0 on failure
     *
     * @param   string $string
     * @return	int
     */

    public function get_category_id($string) {
        $category_id = 0;

        $categories = $this->query('SELECT * FROM category');
        while ($category = $categories->fetch()) {
            if ($string == $category->category_name || $string == $category->category_slug) {
                $category_id = $category->category_id;
            }
        }

        return $category_id;
    }

}

?>
