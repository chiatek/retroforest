<?php

class Page_model extends File_Model {

    protected $file_type = "pages";
    protected $exception_fields = array(
        'index.php',
        'default.php',
        'home.php'
    );
    public $config = array(
        'page_filename' => array(
            'field' => 'page_filename',
            'label' => 'Name',
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
     * New Page
     *
     * @param   string $html
     * @param   string $file_name
     * @return	void
     */

    public function new_page($data, $file_name) {

        if (!empty($data['template'])) {
            // Use a template for the new page
            $html = file_get_contents($data['template']);
        }
        else {
            // Use default page
            $html = file_get_contents(config('default_page'));
        }

        // Set file name and create controller based on page_type
        if (in_array($file_name, $this->exception_fields) == TRUE || $data['page_type'] == 'index') {
            $file_name = 'index.php';
        }
        else if ($data['page_type'] == config('blog_home') || $file_name == config('blog_home').'.php') {
            $file_name = config('blog_home').'.php';
        }
        else if ($data['page_type'] == config('blog_post') || $file_name == config('blog_post').'.php') {
            $file_name = config('blog_post').'.php';
        }
        else if ($file_name == 'posts.php') {
            $file_name = 'posts.php';
        }
        else {
            $this->new_controller(basename(ucfirst($file_name), '.php'));
        }

        // Create the new page.
        if (!file_put_contents(path('drafts').'/'.$file_name, $html)) {
            $_SESSION['toastr_error'] = 'Error - Unable to write file: ' . $file_name;
            return FALSE;
        }
        else {
            $_SESSION['toastr_success'] = $file_name . ' has been created!';
            return $file_name;
        }

    }

    // --------------------------------------------------------------------

    /**
     * Save Page
     *
     * @param   string $html
     * @param   string $file_name
     * @return	void
     */

    public function save_page($html, $file_name) {
        $tag_start = "<!-- ";
        $temp = $html;
        $section_file_name = $path = "";

        // Get section file folders and paths
        $published = get_dir_file_info(path('sections'));
        $draft = get_dir_file_info(path('admin_sections'));
        $template = $this->get_section_file_info('section_templates');
        $sections = array_merge($template, $published, $draft);

        // Loop through html and find all occurrances of comment opening tag '<!-- '.
        while (stripos($temp, $tag_start)) {

            // Find the first occurance of comment tags
            $tag_name = $this->get_section_file_name($temp);

            // Search for section name from admin/sections
            foreach($sections as $file => $file_array) {

                if ($tag_name == basename($file_array['name'], '.php')) {

                    // The section name was found, set file_name.
                    $section_file_name = basename($file_array['name'], '.php');

                    // Get the section html and replace the load view path.
                    $section = $this->get_section_html($html, $section_file_name);
                    $html = str_replace_first(trim($section), '<?php $this->view("admin/sections/'.$section_file_name.'", $data); ?>', $html);

                    // Add php source if any, insert comment tags, and write the file
                    $section = $this->replace_source_code($section, $section_file_name.'.php');
                    $section = $this->tag_open($tag_name) . $section . $this->tag_close($tag_name);
                    file_put_contents(path('admin_sections').'/'.$section_file_name.'.php', $section);

                    // Remove the section comment tag.
                    $html = str_replace_first($this->tag_open($tag_name), "", $html);
                    $html = str_replace_first($this->tag_close($tag_name), "", $html);
                }
            }

            // Remove the current comment tag and continue loop.
            $temp = str_replace_first($this->tag_open($tag_name), "", $temp);
            $temp = str_replace_first($this->tag_close($tag_name), "", $temp);
        }

        // Save the page (write to drafts folder).
        if (!file_put_contents(path('drafts').'/'.$file_name, $html)) {
            $_SESSION['toastr_error'] = 'Error - Unable to write file: ' . $file_name;
        }
        else {
            $_SESSION['toastr_success'] = $file_name . ' has been saved!';
        }
    }

    // --------------------------------------------------------------------

    /**
     * Publish Page
     *
     * @param   string $html
     * @param   string $file_name
     * @return	void
     */

    public function publish_page($html, $file_name) {
        $tag_start = "<!-- ";
        $temp = $html;
        $section_file_name = $path = "";

        // Get section file folders and paths
        $published = get_dir_file_info(path('sections'));
        $draft = get_dir_file_info(path('admin_sections'));
        $template = $this->get_section_file_info('section_templates');
        $sections = array_merge($template, $published, $draft);

        // Loop through html and find all occurrances of comment opening tag '<!-- '.
        while (stripos($temp, $tag_start)) {

            // Find the first occurance of comment tags
            $tag_name = $this->get_section_file_name($temp);

            // Search for section name from admin/sections
            foreach($sections as $file => $file_array) {

                if ($tag_name == basename($file_array['name'], '.php')) {

                    // The section name was found, set file_name.
                    $section_file_name = basename($file_array['name'], '.php');

                    // Get the section html, replace the load view path, and add php source.
                    $section = $this->get_section_html($html, $section_file_name);
                    $html = str_replace_first(trim($section), '<?php $this->view("sections/'.$section_file_name.'", $data); ?>', $html);
                    $section = $this->replace_source_code($section, $section_file_name.'.php');
                    $section = $this->tag_open($tag_name) . $section . $this->tag_close($tag_name);

                    // Delete section file from drafts if it exists.
                    if (file_exists(path('admin_sections').'/'.$section_file_name.'.php')) {
                        unlink(path('admin_sections').'/'.$section_file_name.'.php');
                    }

                    // Write the file
                    file_put_contents(path('sections').'/'.$section_file_name.'.php', $section);

                    // Remove the section comment tag.
                    $html = str_replace_first($this->tag_open($tag_name), "", $html);
                    $html = str_replace_first($this->tag_close($tag_name), "", $html);
                }
            }

            // Remove the current comment tag and continue loop.
            $temp = str_replace_first($this->tag_open($tag_name), "", $temp);
            $temp = str_replace_first($this->tag_close($tag_name), "", $temp);
        }

        // Save the page (write to drafts folder).
        if (!file_put_contents(path('pages').'/'.$file_name, $html)) {
            $_SESSION['toastr_error'] = 'Error - Unable to write file: ' . $file_name;
        }
        else {
            if (file_exists(path('drafts').'/'.$file_name)) {
                unlink(path('drafts').'/'.$file_name);
            }

            $_SESSION['toastr_success'] = $file_name . ' has been published!';
        }
    }

    // --------------------------------------------------------------------

    /**
     * New controller
     *
     * @param   string $file_name
     * @return	void
     */

    public function new_controller($file_name) {
        $config = file_get_contents('assets/tmp/default_controller.php');

        $config = str_replace('class_name', $file_name, $config);
        $config = str_replace('page_name', lcfirst($file_name), $config);

        // Create the controller
        if (!file_put_contents(APPPATH . 'controllers/'.$file_name.'.php', $config)) {
            $_SESSION['toastr_error'] = 'Error - Unable to create controller: ' . $file_name;
        }
    }

}

?>
