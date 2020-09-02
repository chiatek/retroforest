<?php

class Template_model extends File_Model {

    protected $file_type = "templates";
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
     * New Template
     *
     * @param   string $html
     * @param   string $file_name
     * @return	void
     */

    public function new_template($data, $file_name) {

        if ($data['page_type'] == 'sections') {
            // Sections
            $html = file_get_contents(config('default_section'));
            $html = $this->tag_open(basename($file_name, '.php')).$html.$this->tag_close(basename($file_name, '.php'));
            $this->set_file_type($data['section']);
            $path = path('section_templates').'/'.$this->file_type;
        }
        else {
            // Pages
            $html = file_get_contents(config('default_page'));
            $path = path('templates');
        }

        // Create the new template.
        if (!file_put_contents($path.'/'.$file_name, $html)) {
            $_SESSION['toastr_error'] = 'Error - Unable to write file: ' . $file_name;
        }
        else {
            $_SESSION['toastr_success'] = $file_name . ' has been created!';
        }
    }

    // --------------------------------------------------------------------

    /**
     * Save Template
     *
     * @param   string $html
     * @param   string $file_name
     * @return	void
     */

    public function save_template($html, $file_name) {
        $tag_start = "<!-- ";
        $temp = $html;
        $section_file_name = $section_type = $path = "";

        // Get section file folders and paths
        $drafts = $this->get_section_file_info('section_templates');

        // Loop through html and find all occurrances of comment opening tag '<!-- '.
        while (stripos($temp, $tag_start)) {

            // Find the first occurance of comment tags
            $tag_name = $this->get_section_file_name($temp);

            // Search for section name from admin/sections
            foreach($drafts as $file => $file_array) {

                if ($tag_name == basename($file_array['name'], '.php')) {

                    // The section name was found, set file_name and file type.
                    $section_file_name = basename($file_array['name'], '.php');
                    $section_type = $this->get_section_name($file_array['server_path']);
                    $this->set_file_type($section_type);

                    // Get the section html and replace the load view path.
                    $section = $this->get_section_html($html, $section_file_name);
                    $html = str_replace_first(trim($section), '<?php $this->view("admin/templates/sections/'.$section_type.'/'.$section_file_name.'", $data); ?>', $html);
                    
                    // Add php source if any, insert comment tags, and write the file
                    $section = $this->replace_source_code($section, $section_file_name.'.php');
                    $section = $this->tag_open($tag_name) . $section . $this->tag_close($tag_name);
                    file_put_contents(path('section_templates').'/'.$section_type.'/'.$section_file_name.'.php', $section);

                    // Remove the starting and ending section comment tag.
                    $html = str_replace_first($this->tag_open($tag_name), "", $html);
                    $html = str_replace_first($this->tag_close($tag_name), "", $html);
                }
            }

            // Remove the current starting and ending comment tag and continue loop.
            $temp = str_replace_first($this->tag_open($tag_name), "", $temp);
            $temp = str_replace_first($this->tag_close($tag_name), "", $temp);
        }

        // Save the page (write to drafts folder).
        if (!file_put_contents(path('templates').'/'.$file_name, $html)) {
            $_SESSION['toastr_error'] = 'Error - Unable to write file: ' . $file_name;
        }
        else {
            $_SESSION['toastr_success'] = $file_name . ' has been saved!';
        }
    }

}

?>
