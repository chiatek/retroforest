<?php

class Comment_model extends DB {

    protected $table = 'comments';
    protected $primary_key = 'comment_id';

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
     * Comments JOIN sql query
     *
     * @param   string $limit
     * @return	database result
     */

    public function get_comments($limit = NULL) {
        $this->primary_key('post_id');

        $table = 'posts';
        $select = array('comments.comment_id as "id"', 'posts.post_title as "post"', 'posts.post_slug as "slug"', 'comments.comment_date as "date"', 'comments.comment_name as "user"', 'comments.comment_text as "comment"');
        $where = NULL;
        $order_by = 'date DESC';

        $query = $this->inner_join($table, $select, $where, $order_by, $limit);
        return $query;
    }

}
