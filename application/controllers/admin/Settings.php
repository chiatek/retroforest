<?php
class Settings extends Admin_Controller {

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();

        // Set default table and primary key
        $this->db->table('settings');
        $this->db->primary_key('setting_id');
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        $this->helper('file');

        // Process the form
        if (!empty($_POST)) {

            if (!isset($_POST['setting_comments'])) {
                $_POST += array('setting_comments' => 0);
            }

            if (!isset($_POST['setting_dashboard_widgets'])) {
                $_POST += array('setting_dashboard_widgets' => 0);
            }

            if (!isset($_POST['setting_dashboard_posts'])) {
                $_POST += array('setting_dashboard_posts' => 0);
            }

            if (!isset($_POST['setting_dashboard_pages'])) {
                $_POST += array('setting_dashboard_pages' => 0);
            }

            if (!isset($_POST['setting_dashboard_comments'])) {
                $_POST += array('setting_dashboard_comments' => 0);
            }

            if (!isset($_POST['setting_dashboard_GA'])) {
                $_POST += array('setting_dashboard_GA' => 0);
            }

            if ($this->db->update($_POST, 1)) {
                if (!empty($_POST['setting_siteicon'])) {
                    // Set site icon and move to folder img/admin
                    copy($_POST['setting_siteicon'], path('admin_images').'/favicon.png');
                }
                $_SESSION['toastr_success'] = 'Your settings have been saved!';
            }
            redirect('admin/settings');

        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Settings';
        $this->data['media_info'] = get_dir_file_info(path('uploads'));
        $this->data['option'] = $this->db->get_first_row(NULL, 1);
        $this->view('admin/pages/settings', $this->data);

    }

    // --------------------------------------------------------------------

    /**
     * Download
     *
     * @return	void
     */

    public function download() {
        // Process the form
        if (!empty($_POST['download'])) {
            if ($_POST['download'] == "sql") {
                // Export .sql file
                $this->db->backup();
            }
            else {
                // Export component in a .zip file
                $zip = $this->library('Zip');
                $path = path($_POST['download'])."/";
                $zip->read_dir($path, FALSE);
                $zip->download($_POST['download'].'_'.date('mdy').'.zip');
            }
        }
        redirect('admin/settings');
    }

    // --------------------------------------------------------------------

    /**
     * CSS Editor
     *
     * @return	void
     */

    public function css_editor() {
        // Process the form
        if (!empty($_POST)) {
            file_put_contents(config('css'), $_POST['css_textarea']);
            redirect('admin/settings/css_editor');
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'CSS Editor';
        $this->data['css'] = file_get_contents(config('css'));
        $this->view('admin/pages/css_editor', $this->data);
    }

}

?>
