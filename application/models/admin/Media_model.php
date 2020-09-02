<?php

class Media_model extends File_Model {

    protected $file_type = "media";

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
     * Upload config
     *
     * @return	array
     */

    public function upload_config() {
        $config = array(
            'upload_path' => ASSETPATH . 'img/uploads',
            'input_name' => 'userfile',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => 500000
        );

        return $config;
    }

}
