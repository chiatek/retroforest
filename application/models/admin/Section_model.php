<?php

class Section_model extends File_Model {

    protected $file_type = "sections";
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
     * New Section
     *
     * @param   string $html
     * @param   string $file_name
     * @return	void
     */

    public function new_section($data, $file_name) {

        if (!empty($data['template'])) {
            // Use a template for the new page
            $html = file_get_contents($data['template']);
            $template_name = $this->get_section_file_name($html);

            // Replace starting and ending comment file name tags
            $html = str_replace($this->tag_open($template_name), $this->tag_open(basename($file_name, '.php')), $html);
            $html = str_replace($this->tag_close($template_name), $this->tag_close(basename($file_name, '.php')), $html);
        }
        else {
            // Use default section
            $html = file_get_contents(config('default_section'));
            $html = $this->tag_open(basename($file_name, '.php')) . $html . $this->tag_close(basename($file_name, '.php'));
        }

        // Create the new section.
        if (!file_put_contents(path('admin_sections').'/'.$file_name, $html)) {
            $_SESSION['toastr_error'] = 'Error - Unable to write file: ' . $file_name;
        }
        else {
            $_SESSION['toastr_success'] = $file_name . ' has been created!';
        }
    }

    // --------------------------------------------------------------------

    /**
     * Save Section
     *
     * @param   string $html
     * @param   string $file_name
     * @param   string $path
     * @return	void
     */

    public function save_section($html, $file_name, $path) {

        // Get section html, add php source code if any, and comment tags.
        $section = $this->get_section_html($html, basename($file_name, '.php'));
        $section = $this->replace_source_code($section, $file_name);
        $section = $this->tag_open(basename($file_name, '.php')).$section.$this->tag_close(basename($file_name, '.php'));

        $segment = explode('/', $path);
        // Section is a template, modify blocks
        if (count($segment) == 11) {
            $this->modify_blocks($section, basename($file_name, '.php'), $segment[10]);
        }

        // Save the section (write to drafts folder).
        if (!file_put_contents($path.'/'.$file_name, $section)) {
            $_SESSION['toastr_error'] = 'Error - Unable to write file: ' . $file_name;
        }
        else {
            $_SESSION['toastr_success'] = $file_name . ' has been saved!';
        }

    }

    // --------------------------------------------------------------------

    /**
     * Publish Section
     *
     * @param   string $html
     * @param   string $file_name
     * @return	void
     */

    public function publish_section($html, $file_name) {

        // Get section html, add php source code if any, and comment tags.
        $section = $this->get_section_html($html, basename($file_name, '.php'));
        $section = $this->replace_source_code($section, $file_name);
        $section = $this->tag_open(basename($file_name, '.php')) . $section . $this->tag_close(basename($file_name, '.php'));

        // Publish the section (write to views/components folder).
        if (!file_put_contents(path('sections').'/'.$file_name, $section)) {
            $_SESSION['toastr_error'] = 'Error - Unable to write file: ' . $file_name;
        }
        else {
            $_SESSION['toastr_success'] = $file_name . ' has been published!';
        }

        // Delete draft file if it exists
        if (file_exists(path('admin_sections').'/'.$file_name)) {
            unlink(path('admin_sections').'/'.$file_name);
        }
    }

}

?>
