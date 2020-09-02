<?php

require_once SYSPATH . 'helpers/file.php';

class File_Model {

    protected $file_type = NULL;
    protected $exception_fields = NULL;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {

    }

    // --------------------------------------------------------------------

    /**
     * Set file type
     *
     * @param   string $file_type
     * @return	void
     */

    public function set_file_type($file_type) {
        $this->file_type = $file_type;
    }

    // --------------------------------------------------------------------

    /**
     * Get file type
     *
     * @return	string
     */

    public function get_file_type() {
        return $this->file_type;
    }

    // --------------------------------------------------------------------

    /**
     * Delete controller
     *
     * @param   array $path
     * @return	void
     */

    public function delete_controller($path) {
        for ($i = 0; $i < count($path); $i++) {
            $file_name = ucfirst($this->get_section_name($path[$i], TRUE));

            if (!file_exists(path('pages').'/'.lcfirst($file_name)) && !file_exists(path('drafts').'/'.lcfirst($file_name))) {
                if (file_exists(APPPATH . 'controllers/' . $file_name) && $file_name != 'Home.php' && $file_name != 'Posts.php') {
                    if (!unlink(APPPATH . 'controllers/' . $file_name)) {
                        $_SESSION['toastr_error'] = 'Error - Unable to delete controller: ' . $file_name;
                    }
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Update header - Returns a modified HTML string
     *
     * @param   array $data
     * @param   string $file_name
     * @param   object $config
     * @return	string
     */

    public function update_header($data, $file_name, $config) {

        // Get current header html
        $current_header = get_string_between($data['html'], '<head>', '</head>');

        if ($file_name == config('blog_post').'.php') {
            $data['title'] = '<?= $post->post_title; ?>';
            $data['description'] = '<?= $post->post_meta_description; ?>';
            $data['keywords'] = '<?= $post->post_meta_keywords; ?>';
            $data['author'] = '<?= $post->post_author; ?>';
            $data['subject'] = '<?= $post->post_meta_caption; ?>';
        }

        // Set the page title
        if (!empty($config->setting_title) && !empty($config->setting_tagline) && empty($data['title'])) {
            $title = $config->setting_title . config('title_separator') . $config->setting_tagline;
        }
        else if (!empty($config->setting_title) && !empty($data['title'])) {
            $title = $config->setting_title . config('title_separator') . $data['title'];
        }
        else {
            $title = $data['title'];
        }

        $new_header = "\n\t" . '<meta charset="utf-8">' . "\n".
            "\t" . '<meta http-equiv="X-UA-Compatible" content="IE=edge">' . "\n".
            "\t" . '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";

        if ($file_name == config('blog_post').'.php') {
            $new_header .= "\t" . '<?php if (isset($post)): ?>' . "\n";
        }

        $new_header .= "\t" . '<title>'.$title.'</title>' . "\n".
            "\t" . '<meta name="description" content="'.$data['description'].'">' . "\n".
            "\t" . '<meta name="keywords" content="'.$data['keywords'].'">' . "\n".
            "\t" . '<meta name="author" content="'.$data['author'].'">' . "\n".
            "\t" . '<meta name="subject" content="'.$data['subject'].'">' . "\n";

        if ($file_name == config('blog_post').'.php') {
            $new_header .= "\t" . '<?php endif; ?>' . "\n";
        }

        $new_header .= "\n\t" . '<!-- Favicon Icon -->' . "\n".
            "\t" . '<link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url("assets/img/admin/favicon.ico"); ?>">' . "\n".
            "\t" . '<link rel="icon" type="image/png" href="<?php echo site_url("assets/img/admin/favicon.png"); ?>">' ."\n".
            "\t" . '<link rel="apple-touch-icon" href="<?php echo site_url("assets/img/admin/avicon.png"); ?>">' . "\n\n".

            "\t" . '<!-- CSS -->' . "\n".
            "\t" . '<?php $this->view("components/css", $data); ?>' . "\n\n";

        if (!empty($config->setting_GA_code) && !empty($config->setting_GA_trackingid)) {
            $lines = explode(PHP_EOL, $config->setting_GA_code);

            $new_header .= "\t" . '<!-- Global site tag (gtag.js) - Google Analytics -->' . "\n".
                "\t" . '<script async src="https://www.googletagmanager.com/gtag/js?id='.$config->setting_GA_trackingid.'"></script>' . "\n".
                "\t" . '<script>';

            foreach ($lines as $line) {
                $new_header .= "\n\t\t" . $line;
            }

            $new_header .= "\n\t" . '</script>' . "\n";
        }

        return str_replace($current_header, $new_header, $data['html']);
    }

    // --------------------------------------------------------------------

    /**
     * Update footer - Returns a modified HTML string
     *
     * @param   string $html
     * @return  string
     */

    public function update_footer($html) {

        // Get current header html
        $current_header = get_string_between($html, '<!-- Base Javascript -->', '</body>');

        $new_header = "\n\t" . '<?php $this->view("components/javascript", $data); ?>' . "\n\n";

        return str_replace($current_header, $new_header, $html);
    }

    // --------------------------------------------------------------------

    /**
     * Returns a modified HTML string, HTML replaced with php source code
     *
     * @param   string $html
     * @param   string $file_name
     * @return	string
     */

    public function replace_source_code($html, $file_name) {
        $code_start = '<!-- code -->';
        $code_end = '<!-- End code -->';

        if (file_exists(path('admin_sections').'/'.$file_name)) {
            $component_html = file_get_contents(path('admin_sections').'/'.$file_name);
        }
        else if (file_exists(path('sections').'/'.$file_name)) {
            $component_html = file_get_contents(path('sections').'/'.$file_name);
        }
        else if (file_exists(path('section_templates').'/'.$this->file_type.'/'.$file_name)) {
            $component_html = file_get_contents(path('section_templates').'/'.$this->file_type.'/'.$file_name);
        }
        else {
            $component_html = "";
        }

        $code = get_string_between($component_html, $code_start, $code_end);

        if (empty($code)) {
            return $html;
        }

        $string = get_string_between($html, $code_start, $code_end);
        return str_replace($string, $code, $html);
    }

    // --------------------------------------------------------------------

    /**
     * Returns a component array with html contents for each element
     *
     * @param   string $html
     * @param   string $file_name
     * @param   string $path
     * @return	array
     */

    public function get_meta_tags($html = "", $file_name = NULL, $path = 'admin') {
        $title_start = '<title>';
        $title_end = '</title>';
        $description_start = '<meta name="description" content="';
        $keywords_start = '<meta name="keywords" content="';
        $author_start = '<meta name="author" content="';
        $subject_start = '<meta name="subject" content="';
        $meta_end = '">';

        if ($file_name) {
            $html = file_get_contents(path($path).'/'.$file_name);
        }

        $title = get_string_between($html, $title_start, $title_end);

        if (strchr($title, config('title_separator'))) {
            $title = strchr($title, config('title_separator'));
            $title = trim($title, config('title_separator'));
        }

        $meta_tags = array(
            "description" => get_string_between($html, $description_start, $meta_end),
            "keywords" => get_string_between($html, $keywords_start, $meta_end),
            "author" => get_string_between($html, $author_start, $meta_end),
            "subject" => get_string_between($html, $subject_start, $meta_end),
            "title" => $title
        );

        return $meta_tags;
    }

    // --------------------------------------------------------------------

    /**
     * Returns an array of section names with file path.
     *
     * @param   string $path
     * @return	array
     */

    public function get_section_list($path = 'section_templates') {
        $section['basic'] = path($path).'/basic';
        $section['blog'] = path($path).'/blog';
        $section['contact'] = path($path).'/contact';
        $section['content'] = path($path).'/content';
        $section['divider'] = path($path).'/divider';
        $section['download'] = path($path).'/download';
        $section['footer'] = path($path).'/footer';
        $section['header'] = path($path).'/header';
        $section['intro'] = path($path).'/intro';
        $section['menu'] = path($path).'/menu';
        $section['other'] = path($path).'/other';
        $section['portfolio'] = path($path).'/portfolio';
        $section['price'] = path($path).'/price';
        $section['service'] = path($path).'/service';
        $section['skill'] = path($path).'/skill';
        $section['team'] = path($path).'/team';
        $section['title'] = path($path).'/title';

        return $section;
    }

    // --------------------------------------------------------------------

    /**
     * Returns a component array with directory file info
     *
     * @param   string $path
     * @return	array
     */

    public function get_section_file_info($path = 'section_templates') {
        $section = $this->get_section_list($path);
        $file_array = array();
        $merge_array = array();

        foreach ($section as $key => $value) {
            $file_array[$key] = get_dir_file_info($value);
            $merge_array = array_merge($file_array[$key], $merge_array);
        }

        return $merge_array;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the section file name from the $html string paramater
     *
     * @param   string $html
     * @return	string
     */

    public function get_section_file_name($html) {
        $file_name = get_string_between($html, "<!-- ", " -->");
        return $file_name;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the section html for the given $file_name paramater
     *
     * @param   string $html
     * @param   string $file_name
     * @return	string
     */

    public function get_section_html($html, $file_name) {
        $html = get_string_between($html, $this->tag_open($file_name), $this->tag_close($file_name));
        return $html;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the section name of the $path paramater
     *
     * @param   string $path
     * @param   bool $relative_path
     * @return  string
     */

    public function get_section_name($path, $relative_path = FALSE) {
        $str = explode("/", $path);

        if ($relative_path) {
            $segment = count($str) - 1;
        }
        else {
            $segment = count($str) - 2;
        }

        return $str[$segment];
    }

    // --------------------------------------------------------------------

    /**
     * Returns the opening html section tag given the $file_name paramater
     *
     * @param   string $file_name
     * @return	string
     */

    public function tag_open($file_name) {
        $tag_start = "<!-- ";
        $tag_close = " -->";

        return $tag_start.$file_name.$tag_close;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the closing html section tag given the $file_name paramater
     *
     * @param   string $file_name
     * @return	string
     */

    public function tag_close($file_name) {
        $tag_end = "<!-- End ";
        $tag_close = " -->";

        return $tag_end.$file_name.$tag_close;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the current status of the page based on the $path paramater
     *
     * @param   string $path
     * @return	string
     */

    public function get_status($path) {
        $str = explode("/", $path);

        if (in_array('admin', $str) == TRUE) {
            return "draft";
        }
        else if (in_array('uploads', $str) == TRUE) {
            return "active";
        }
        else {
            return "published";
        }
    }

    // --------------------------------------------------------------------

    /**
     * Read blocks
     *
     * @param   string $file_name
     * @return	array
     */

    public function read_blocks($file_name = 'blocks-bootstrap4.js') {
        $blocks = array();
        $html = $name = '';
        $parse_html = FALSE;

        $lines = file(path('page_builder') . '/' . $file_name);

        // Read each line
        for ($i = 0; $i < count($lines); $i++) {
            // Blocks group
            if (strpos($lines[$i], 'BlocksGroup')) {
                $name = get_string_between($lines[$i], "Vvveb.BlocksGroup['", "'] =");

                $lines[$i+1] = ltrim($lines[$i+1], "[");
                $lines[$i+1] = rtrim($lines[$i+1], "];
                ");

                $blocks['group'][$name] = str_getcsv($lines[$i+1], ",");
            }

            // Blocks add (name, dragHTML, image)
            if (strstr($lines[$i], 'Blocks.add')) {
                $name = get_string_between($lines[$i], 'Vvveb.Blocks.add("', '", {');

                for ($j = 1; $j < 4; $j++) {
                    $lines[$i+$j] = rtrim($lines[$i+$j], ',
                    ');

                    $value = explode(': ', $lines[$i+$j]);
                    $blocks['add'][$name][trim($value[0])] = str_replace("'", "", $value[1]);
                }
            }

            // Blocks add (html)
            if (strstr($lines[$i], '<!-- ' . $name . ' -->')) {
                $parse_html = TRUE;
                $html .= $lines[$i];
            }
            else if (strstr($lines[$i], '<!-- End ' . $name . ' -->')) {
                $html .= $lines[$i];
                $blocks['add'][$name]['html'] = $html;
                $parse_html = FALSE;
                $html = '';
            }
            else if ($parse_html) {
                $html .= $lines[$i];
            }
            else {
                continue;
            }
        }

        return $blocks;
    }

    // --------------------------------------------------------------------

    /**
     * Write blocks
     *
     * @param   array $data
     * @param   string $file_name
     * @return  void
     */

    public function write_blocks($data, $file_name = 'blocks-bootstrap4.js') {
        $output = '';

        // Blocks group
        if (isset($data['group'])) {
            foreach ($data['group'] as $key => $value) {
                $output .= "Vvveb.BlocksGroup['".$key."'] = \n";
                for ($i = 0; $i < count($data['group'][$key]); $i++) {
                    if (count($data['group'][$key]) == 1) {
                        $output .= '["' . $data['group'][$key][$i] . '"];' . "\n";
                    }
                    else if ($i == 0) {
                        $output .= '["' . $data['group'][$key][$i] . '", ';
                    }
                    else if ($i == count($data['group'][$key]) - 1) {
                        $output .= '"' . $data['group'][$key][$i] . '"];' . "\n";
                    }
                    else {
                        $output .= '"' . $data['group'][$key][$i] . '", ';
                    }
                }
            }

            $output .= "\n";
        }

        // Blocks add
        if (isset($data['add'])) {
            foreach ($data['add'] as $block => $params) {
                $output .= 'Vvveb.Blocks.add("'.$block.'", {' . "\n";
                foreach ($params as $key => $value) {
                    if ($key == 'html') {
                        $output .= "\t" . $key . ": `\n" . $value . "\n`,\n});\n\n";
                    }
                    else {
                        $output .= "\t" . $key . ": '" . $value . "',\n";
                    }
                }
            }
        }

        file_put_contents(path('page_builder').'/'.$file_name, $output);
    }

    // --------------------------------------------------------------------

    /**
     * Modify blocks
     *
     * @param   string $html
     * @param   string $file_name
     * @param   string $group
     * @return  mixed
     */

    public function modify_blocks($html, $file_name, $group) {
        $blocks = $this->read_blocks();

        // Blocks group
        // The group already exists, push file name to array
        if (isset($blocks['group'][$group]) && in_array($group, array_keys($blocks['group'][$group])) == TRUE) {
            if (in_array($file_name, $blocks['group'][$group]) == FALSE) {
                array_push($blocks['group'][$group], $file_name);
            }
        }
        // The group doesn't exist, add group and file name
        else {
            $blocks['group'][$group][0] = $file_name;
        }

        // Blocks add
        $blocks['add'][$file_name]['name'] = $file_name;
        $blocks['add'][$file_name]['dragHtml'] = '<img src=" + Vvveb.baseUrl + icons/product.png">';
        $blocks['add'][$file_name]['image'] = site_url('assets/img/admin/thumbnails/' . $file_name . '.jpg');
        $blocks['add'][$file_name]['html'] = $html;

        $this->write_blocks($blocks);
    }

    // --------------------------------------------------------------------

    /**
     * Delete blocks
     *
     * @param   string $file_name
     * @param   array $data
     * @return  array
     */

    public function delete_blocks($file_name, $data) {

        // Blocks group
        foreach ($data['group'] as $key => $value) {

            for ($i = 0; $i < count($data['group'][$key]); $i++) {
                // The file name was found, remove it
                if ($data['group'][$key][$i] == $file_name) {
                    unset($data['group'][$key][$i]);
                    $data['group'][$key] = array_values($data['group'][$key]);
                }
            }

            // The group is empty, remove it
            if (empty($data['group'][$key])) {
                unset($data['group'][$key]);
            }

        }

        // Blocks add
        // Remove the block
        if (!empty($data['add'][$file_name])) {
            unset($data['add'][$file_name]);
        }

        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Sections to Blocks
     * Add/removes template sections from blocks
     *
     * @return  void
     */

    public function sections_to_blocks() {
        $blocks = $this->read_blocks();
        $files = $this->get_section_file_info();
        $i = 0;

        // Add template section names to groups
        foreach ($files as $file => $file_info) {
            $file_name = basename($file, '.php');
            $group = $this->get_section_name($file_info['server_path']);

            // The group already exists, push file name to array
            if (isset($blocks['group'][$group]) && in_array($file_name, $blocks['group'][$group]) == FALSE) {
                $html = file_get_contents($file_info['server_path']);
                array_push($blocks['group'][$group], $file_name);

                // Blocks add
                $blocks['add'][$file_name]['name'] = $file_name;
                $blocks['add'][$file_name]['dragHtml'] = '<img src=" + Vvveb.baseUrl + icons/product.png">';
                $blocks['add'][$file_name]['image'] = site_url('assets/img/admin/thumbnails/' . $file_name . '.jpg');
                $blocks['add'][$file_name]['html'] = $html;
            }
            // The group doesn't exist, add group and file name
            else if (!isset($blocks['group'][$group])) {
                $html = file_get_contents($file_info['server_path']);
                $blocks['group'][$group][$i++] = $file_name;

                // Blocks add
                $blocks['add'][$file_name]['name'] = $file_name;
                $blocks['add'][$file_name]['dragHtml'] = '<img src=" + Vvveb.baseUrl + icons/product.png">';
                $blocks['add'][$file_name]['image'] = site_url('assets/img/admin/thumbnails/' . $file_name . '.jpg');
                $blocks['add'][$file_name]['html'] = $html;
            }

            // Set key index to start at zero
            $blocks['group'][$group] = array_values($blocks['group'][$group]);
        }

        // Remove blocks that are not found in template sections
        if (isset($blocks['add'])) {
            foreach ($blocks['add'] as $name => $array) {
                if (in_array($name.'.php', array_keys($files)) == FALSE) {
                    $blocks = $this->delete_blocks($name, $blocks);
                }
            }
        }

        $this->write_blocks($blocks);
    }

}

?>
