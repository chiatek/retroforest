<?php

class Post_model extends DB {

    protected $table = 'posts';
    protected $primary_key = 'post_id';
    protected $exception_fields = array(
        'post_body',
        'post_slug'
    );
    protected $unset_fields = array(
        'prev_category',
        'category_id'
    );
    public $config = array(
        'post_title' => array(
            'field' => 'post_title',
            'label' => 'Title',
            'rules' => 'trim|required'
        ),
        'post_slug' => array(
            'field' => 'post_slug',
            'label' => 'Slug',
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
     * Returns an updated array for the post table
     *
     * @param   array $data
     * @return	array
     */

    public function insert_post_array($data) {
        $data += array(
            'user_id' => $_SESSION['user_id'],
            'post_status' => 'draft',
            'post_created' => date("Y-m-d h:i:s"),
            'post_modified' => date("Y-m-d h:i:s")
        );

        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Returns an updated array for the post table
     *
     * @param   array $data
     * @return	array
     */

    public function update_post_array($data) {
        if (!isset($data['post_featured'])) {
            $data += array(
                'post_modified' => date("Y-m-d h:i:s"),
                'post_featured' => 0
            );
        }
        else {
            $data += array('post_modified' => date("Y-m-d h:i:s"));
        }

        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Save post
     * Returns insert ID (new post), primary key (existing post)
     *
     * @param   array $data
     * @param   int $pkey_val
     * @return	int
     */

    public function save_post($data, $pkey_val) {

        // Remove 'prev_category' and 'category_id' from the array
        $data = $this->unset_data($data);

        // Select * from posts where 'post_slug' = $data['post_slug'] and 'post_status' = 'draft';
        $query = $this->get(NULL, array('post_slug' => $data['post_slug'], 'post_status' => 'draft'));

        // Create a new post as a draft.
        if ($query->rowCount() == 0) {
            $data = $this->insert_post_array($data);
            return $this->insert($data);
        }
        // Update an existing post as a draft.
        else {
            // Remove 'prev_category' and 'category_id' from the array and update post
            $data = $this->update_post_array($data);
            $this->update($data, $pkey_val);
            return $pkey_val;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Publish post
     * Returns Post ID
     *
     * @param   array $data
     * @param   int $pkey_val
     * @return	int
     */

    public function publish_post($data, $pkey_val) {

        // Update the $data array with additonal values to insert into table post
        $data = $this->update_post_array($data);

        // Select * from posts where 'post_slug' = $data['post_slug'] and 'post_status' = 'published';
        $query = $this->get(NULL, array('post_slug' => $data['post_slug'], 'post_status' => 'published'));

        // The post has already been published. Update it.
        if ($query->rowCount() > 0) {
            $row = $query->fetch();

            // Update categories with the correct post_id
            if (isset($data['prev_category'])) {
                $this->update_category($row->post_id, $pkey_val);
            }

            // Remove 'prev_category' and 'category_id' from the array and update post
            $data = $this->unset_data($data);
            $this->update($data, $row->post_id);

            // Select * from posts where 'post_slug' = $data['post_slug'] and 'post_status' = 'draft';
            $query = $this->get(NULL, array('post_slug' => $data['post_slug'], 'post_status' => 'draft'));
            // Delete the draft post.
            if ($query->rowCount() > 0) {
                $this->delete_foreign_key($pkey_val, 'post_category');
                $this->table('posts');
                $this->delete($pkey_val);
            }

            return $row->post_id;
        }
        // The post has not been published yet. Update the draft and change the status to published.
        else {
            // Remove 'prev_category' and 'category_id' from the array and update post
            $data = $this->unset_data($data);
            $this->update($data, $pkey_val);
            return $pkey_val;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Update category
     *
     * @param	string $set
     * @param	string $where
     * @return  void
     */

    public function update_category($set, $where) {
        $this->table('post_category');
        $this->update($set, $where,  FALSE);
        $this->table('posts');
    }

    // --------------------------------------------------------------------

    /**
     * Returns an array with 'unset_fields' unset.
     *
     * @param	array $data
     * @return	array
     */

    public function unset_data($data) {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->unset_fields) == TRUE) {
                if (isset($data[$key])) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Search SQL
     *
     * @param	string $query
     * @return	string
     */

    public function search_sql($query) {

        $sql = "SELECT DISTINCT posts.post_id as id, posts.post_title title, posts.post_author as author, 
            posts.post_created as created, posts.post_modified as modified, posts.post_status as status FROM posts
            LEFT JOIN post_category
            on post_category.post_id=posts.post_id
            WHERE posts.post_status = 'published'
            AND posts.post_title LIKE '%".$query."%'
            OR posts.post_slug LIKE '%".$query."%'
            OR posts.post_author LIKE '%".$query."%'
            OR posts.post_description LIKE '%".$query."%'
            OR posts.post_body LIKE '%".$query."%'
            ORDER BY posts.post_modified DESC";

        return $sql;
    }

}
