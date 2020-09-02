<?php

class Database extends Admin_Controller {

    protected $database;
    protected $form_validation;

    // These URL's can be accessed by anyone.
    private $not_admin_urls = array(
        'insert_saved_query',
        'edit_saved_query',
        'saved_query',
        'edit_query',
        'insert_query',
        'query',
        'delete'
    );

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        $this->database = $this->model('admin/Database_model');
        $this->data['database'] = $this->database->database();

        // Restrict access if user is not admin
        if ($this->data['user']->user_role != "administrator" && in_array(segment(3), $this->not_admin_urls) == FALSE) {
            redirect('admin');
        }
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {

        // Set page data and load the view (show all database table names)
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Database';
        $this->data['table'] = '';
        $this->data['query'] = $this->database->show_tables();
        $this->view('admin/pages/table_results', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Query
     *
     * @param   string $table
     * @return	void
     */

    public function query($table = '') {
        // Load database_results (show all records for the table)
        if (!empty($table)) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Browse Table';
            $this->database->db_table($table);
            $this->data['table'] = $table;
            $this->data['query'] = $this->database->get();
            $this->view('admin/pages/database_results', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit query
     *
     * @param   string $table
     * @param   string $primary_key
     * @param   int $pkey_val
     * @return	void
     */

    public function edit_query($table = '', $primary_key = NULL, $pkey_val = NULL) {
        // Set page data
        $this->data['table'] = $table;
        $this->database->db_table($table);

        // Process form and update the table
        if (!empty($_POST)) {
            // set the primary key
            $this->database->primary_key($primary_key);
            // Update the table
            if ($this->database->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = 'Table ' . $table . ' has been saved!';
            }
            redirect('admin/database/query/'.$table);
        }
        // Load edit_table (form to edit the selected table record)
        else if (!empty($table) && isset($primary_key) && isset($pkey_val)) {
            $this->database->primary_key($primary_key);
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Table';
            $this->data['primary_key'] = $primary_key;
            $this->data['pkey_val'] = $pkey_val;
            $this->data['query'] = $this->database->get(NULL, $pkey_val);
            $this->view('admin/pages/edit_table', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Insert query
     *
     * @param   string $table
     * @return	void
     */

    public function insert_query($table = '') {
        // Set page data
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Insert into table';
        $this->data['table'] = $table;
        $this->database->db_table($table);

        // Process form and insert data for the table
        if (!empty($_POST)) {
            if ($id = $this->database->insert($_POST)) {
                $_SESSION['toastr_success'] = $table.' id '.$id.' has been created!';
            }
            redirect('admin/database/query/'.$table);
        }
        // Set additional page data and load the view (new record for the table)
        else {
            $this->data['auto_increment'] = $this->database->auto_increment($table);
            $this->data['query'] = $this->database->get();
            $this->view('admin/pages/record_new', $this->data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Column
     *
     * @param   string $table
     * @return	void
     */

    public function column($table = '') {
        // Load column_results (Show all colums for the table)
        if (!empty($table)) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Table Structure';
            $this->data['table'] = $table;
            $this->data['query'] = $this->database->table_structure($table);
            $this->view('admin/pages/column_results', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit column
     *
     * @param   string $table
     * @param   string $column
     * @param   string $key
     * @return	void
     */

    public function edit_column($table = '', $column = '', $key = NULL) {
        // Set page data
        $this->data['table'] = $table;

        // Process form and modify the column
        if (!empty($_POST)) {
            // Use current database
            $this->database->execute('USE ' . $this->data['database']);
            // Format an array using $_POST data needed to modify column
            $data = $this->database->modify_column_array($_POST, $column, $key);

            // Modify the column
            if ($this->database->modify_column($data, $table)) {
                $_SESSION['toastr_success'] = 'Column has been modified for table ' .$table. '!';
            }
            else {
                $_SESSION['toastr_error'] = 'Error: Unable to modify column';
            }
            redirect('admin/database/column/'.$table);
        }
        // Load edit_column (form to edit the selected table column)
        else if (!empty($table) && !empty($column)) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Column';
            $this->data['column_name'] = $column;
            $this->data['query'] = $this->database->table_structure($table, $column);
            $this->view('admin/pages/edit_column', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Insert column
     *
     * @param   string $table
     * @return	void
     */

    public function insert_column($table = '') {
        // Set page data
        $this->data['table'] = $table;
        $this->database->db_table($table);

        // Process form and add the column
        if (!empty($_POST) && !empty($table)) {
            // Use the current database
            $this->database->execute('USE ' . $this->data['database']);
            // Format an array using $_POST data needed to add column to table
            $data = $this->database->create_table_array($_POST);

            // Add the column
            if ($this->database->add_column($data, $table)) {
                $_SESSION['toastr_success'] = 'Column has been added to table ' .$table. '!';
            }
            else {
                $_SESSION['toastr_error'] = 'Error: Unable to add column';
            }
            redirect('admin/database/column/'.$table);
        }
        // Load add_column (new column for the table)
        else if (!empty($table)) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Add Column';
            $this->view('admin/pages/add_column', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Table
     *
     * @param   string $table
     * @return	void
     */

    public function table($table = '') {
        // Set form validation rules
        $this->form_validation = $this->library('Form_validation');
        $config = $this->database->config;
        $this->form_validation->set_rules($config);

        // Set page data
        $this->data['table'] = $table;
        $this->database->db_table($table);

        // Process form and create the table
        if (!empty($_POST) && !empty($table)) {
            // Use the current database
            $this->database->execute('USE ' . $this->data['database']);
            // Format an array using $_POST data needed to create table
            $data = $this->database->create_table_array($_POST);

            // Create the table
            if ($this->database->create_table($data, $table)) {
                $_SESSION['toastr_success'] = 'Table ' . $table . ' has been created!';
            }
            else {
                $_SESSION['toastr_error'] = 'Error: Unable to create table ' . $table;
            }
            redirect('admin/database');
        }
        // Load create_table
        else if (!empty($_POST) && $this->form_validation->run() == TRUE) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'New Table';
            $this->data['table'] = $_POST['table_name'];
            $this->data['columns'] = $_POST['num_columns'];
            $this->view('admin/pages/create_table', $this->data);
        }
        // Load table_new
        else {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'New Table';
            $this->view('admin/pages/table_new', $this->data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Saved Query
     * Display saved queries, view and edit the results table for that query
     *
     * @param   int $id
     * @param   int $pkey_val
     * @return	void
     */

    public function saved_query($id = NULL, $pkey_val = NULL) {
        // Process and update saved query tables
        if (!empty($_POST)) {
            $this->database->process_saved_query($_POST, $id, $pkey_val);
            redirect('admin/database/saved_query/'.$id);
        }
        // Load saved query edit form or results table
        else if (isset($id)) {
            $table = $this->database->ref_table_data($id);
            $this->data['title'] = config('cms_name') . config('title_separator') . $table['name'];

            // Set saved query page data
            $this->data['table'] = $table['table_name'];
            $this->data['ref_table'] = $table['referenced_table_name'];
            $this->data['primary_key'] = $table['primary_key'];
            $this->data['name'] = $table['name'];
            $this->data['id'] = $id;

            // Load edit_table
            if (isset($pkey_val)) {

                // Get the primary key if it is not set
                if (empty($table['primary_key'])) {
                    $this->data['primary_key'] = $this->database->get_table_primary_key($table['table_name']);
                }

                // Get query for table
                $this->database->db_table($this->data['table']);
                $this->data['pkey_val'] = $pkey_val;
                $this->data['query'] = $this->database->get(NULL, array($this->data['primary_key'] => $pkey_val));

                // Get query for referenced table
                if ($this->data['ref_table']) {
                    $this->data['ref_query'] = $this->database->ref_table_query($table, $this->data['primary_key'], $pkey_val);
                }

                // Load the view (form to edit the selected table record(s))
                $this->view('admin/pages/edit_table', $this->data);
            }
            // Load query_results (show all records for the selected table)
            else {
                // Load saved queries
                if (config('saved_queries') != NULL) {
                    $this->database->table('queries');
                    $this->data['saved_query_list'] = $this->database->get(NULL, array('user_id' => $_SESSION['user_id'], 'add_to_menu' => 'yes'));
                }

                $this->data['query'] = $this->database->get_saved_query($id);
                $this->view('admin/pages/query_results', $this->data);
            }
        }
        // Load saved_query_results (show all saved queries)
        else {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Saved Queries';
            $this->data['table'] = 'queries';
            $this->data['query'] = $this->database->saved_queries();
            $this->view('admin/pages/saved_query_results', $this->data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit saved query
     *
     * @param   string $table
     * @param   string $primary_key
     * @param   int $pkey_val
     * @return	void
     */

    public function edit_saved_query($table = '', $primary_key = NULL, $pkey_val = NULL) {
        // Chnage the database to default and set table
        $this->database->change_database();
        $this->database->table($table);

        // Process form and update saved queries
        if (!empty($_POST)) {
            // set the primary key
            $this->database->primary_key($primary_key);

            if (empty($_POST['limit_stmt'])) {
                $_POST['limit_stmt'] = NULL;
            }

            // Update the table
            if ($this->database->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = 'Saved query has been updated!';
            }
            redirect('admin/database/saved_query');
        }
        // Load edit_table
        else if (!empty($table) && isset($primary_key) && isset($pkey_val)) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Saved Query';

            // Set primary key
            $this->database->primary_key($primary_key);

            // Set page data
            $this->data['database'] = $this->database->get_prev_database();
            $this->data['table'] = $table;
            $this->data['primary_key'] = $primary_key;
            $this->data['pkey_val'] = $pkey_val;

            // SELECT * FROM queries WHERE id = $pkey_val
            // Generate query and load the view (form to edit saved query)
            $this->data['query'] = $this->database->get(NULL, $pkey_val);

            $this->view('admin/pages/edit_table', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Insert saved query
     * Loads wizard and saves the new query
     *
     * @param   string $table
     * @return	void
     */

    public function insert_saved_query($table = NULL) {
        // Display table column checkboxes in the saved query wizard using AJAX
        if (isset($table)) {
            $this->database->display_table_columns($table);
        }
        // Process the form and save the saved query
        else if (!empty($_POST)) {
            $this->database->save_saved_query($_POST);
            redirect('admin/database/saved_query');
        }
        // Load query_new (new saved query wizard)
        else {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'New Saved Query';

            $this->data['tables'] = $this->database->show_tables(TRUE);
            $this->data['ref_tables'] = $this->database->show_ref_tables();
            $this->view('admin/pages/query_new', $this->data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Delete
     *
     * @param   string $table
     * @param   bool $saved_query
     * @return	void
     */

    public function delete($table = NULL, $saved_query = FALSE) {
        $redirect_path = 'admin/database';

        // Process the form
        if (!empty($_POST)) {

            foreach ($_POST['delete'] as $value) {

                if (isset($table)) {
                    $data = explode('/', $value);

                    // Delete saved query
                    if ($saved_query && !empty($data[1])) {
                        $this->database->table('queries');
                        $this->database->delete(array($data[0] => $data[1]));
                        $redirect_path = 'admin/database/saved_query';
                    }
                    // Delete record
                    else if (!empty($data[1])) {
                        $this->database->db_table($table);
                        $this->database->delete(array($data[0] => $data[1]));
                        $redirect_path = 'admin/database/query/'.$table;
                    }
                    // Delete column
                    else {
                        $this->database->db_table($table);
                        $this->database->drop_column($value);
                        $redirect_path = 'admin/database/column/'.$table;
                    }
                }
                // Delete table
                else {
                    $this->database->db_table($value);
                    $this->database->drop_table();
                }
            }

            redirect($redirect_path);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * SQL Query
     *
     * @return	void
     */

    public function sql() {

        // Set page data
        $this->data['title'] = config('cms_name') . config('title_separator') . 'SQL Qquery';

        // Process the form
        if (!empty($_POST)) {

            // Verify sql statement and get table name
            $this->data['table'] = $this->database->process_sql($_POST['sql_textarea']);

            // Only execute the query if the table name is returned
            if ($this->data['table']) {
                $this->database->execute('USE ' . $this->data['database']);
                $this->data['query'] = $this->database->query($_POST['sql_textarea']);

                // SELECT queries
                if ($this->data['query']->columnCount() > 0) {
                    $_SESSION['toastr_success'] = $_POST['sql_textarea'] . '<br />Row count: ' . $this->data['query']->rowCount();
                    $this->view('admin/pages/database_results', $this->data);
                }
                // ALl other queries with row count > 0
                else if ($this->data['query']->rowCount() > 0) {
                    $_SESSION['toastr_success'] = $_POST['sql_textarea'] . '<br />Row count: ' . $this->data['query']->rowCount();
                    $this->view('admin/pages/sql_query', $this->data);
                }
                // All other queries with row count == 0
                else {
                    $_SESSION['toastr_info'] = 'MySQL returned an empty result set (i.e. zero rows)';
                    $this->view('admin/pages/sql_query', $this->data);
                }

            }
            // The query did not run, load sql_query and show error
            else {
                $_SESSION['toastr_error'] = 'Unable to execute query: <br />' . $_POST['sql_textarea'];
                $this->view('admin/pages/sql_query', $this->data);
            }
        }
        // Load sql_query
        else {
            $this->view('admin/pages/sql_query', $this->data);
        }

    }

    // --------------------------------------------------------------------

    /**
     * Backup / Restore
     *
     * @return	void
     */

    public function archive() {

        // Set page data
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Backup/Restore';

        // Export .sql file
        if (!empty($_POST['backup']) && $this->data['database'] == $_POST['backup']) {
            $this->database->backup();
        }

        // Get upload configuration
        $upload = $this->library('Upload');
        $config = $this->database->upload_config();

        // Upload the file
        if (!$upload->do_upload($config)) {
            // Upload failed
            $this->data['success'] = FALSE;
            $this->data['error'] = $upload->display_errors();
        }
        else {
            // Upload success
            $this->data['upload_data'] = $upload->data();

            if ($this->database->restore(ASSETPATH . 'tmp/' . $this->data['upload_data']['File Name'])) {
                // Database restore success
                $this->data['success'] = TRUE;
                $this->data['error'] = ' ';
            }
            else {
                // Databse restore failure
                $this->data['success'] = FALSE;
                $this->data['error'] = 'An error has occured restoring database file: ' . $this->data['upload_data']['File Name'];
            }

            // Delete the temporary .sql file
            unlink(ASSETPATH . 'tmp/' . $this->data['upload_data']['File Name']);
        }
        // Load the view
        $this->view('admin/pages/archive', $this->data);
    }

}
