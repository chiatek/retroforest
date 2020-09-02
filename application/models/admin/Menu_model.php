<?php

class Menu_model extends DB {

    protected $table = "menus";
    protected $primary_key = "menu_id";

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
     * Decodes json string and inserts into table menus
     *
     * @param   string $json
     * @return	void
     */

    public function update_menu($json) {
        // Decode json
        $menu = json_decode($json);

        // Remove all menu items from the database
        $sql = 'DELETE FROM menus';
        $this->query($sql);

        // Insert menu items into table menus
        for ($i=0; $i < count($menu); $i++) {
            if ($menu[$i]->menu_item != "" && $menu[$i]->menu_href != "") {
                $this->insert(array('menu_item' => $menu[$i]->menu_item, 'menu_href' => $menu[$i]->menu_href, 'menu_order' => $i));
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Decodes json string and updates table menus with the correct order.
     *
     * @param   string $json
     * @return	void
     */

    public function update_order($json) {
        // Decode json
        $order = json_decode($json);

        // Update table menus with the correct order
        for ($i=0; $i < count($order); $i++) {
            if (isset($order[$i]->children)) {
                // The menu item has children (submenu)
                $this->update(array('menu_order' => $i, 'menu_parent_id' => $order[$i]->id, 'menu_parent_order' => NULL), $order[$i]->id);
                for ($j=0; $j < count($order[$i]->children); $j++) {
                    $this->update(array('menu_order' => NULL, 'menu_parent_id' => $order[$i]->id, 'menu_parent_order' => $j), $order[$i]->children[$j]->id);
                }
            }
            else {
                // The menu item has no children
                $this->update(array('menu_order' => $i, 'menu_parent_id' => NULL, 'menu_parent_order' => NULL), $order[$i]->id);
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Gets all published pages and inserts any missing ones into table menus.
     *
     * @return	void
     */

    public function update_table() {
        $count = 0;
        // Get an array of all published pages
        $page = get_filenames(path('pages'));

        // Get the total number of menu items and exclude children
        $sql = 'SELECT * from menus WHERE menu_order IS NOT NULL';
        $query = $this->query($sql);
        $total_menu_items = $query->rowCount();

        for ($i=0; $i < count($page); $i++) {
            $query = $this->get(NULL, array('menu_href' => site_url(basename($page[$i], '.php'))));
            if ($query->rowCount() == 0 && isset($page)) {
                // The menu item was not found. Insert it into table menus
                if (basename($page[$i], '.php') == 'index') {
                    // home
                    $this->insert(array('menu_item' => 'home', 'menu_href' => site_url(), 'menu_order' => $total_menu_items+$count++));
                }
                else if (basename($page[$i], '.php') == config('blog_home')) {
                    // blog home
                    $this->insert(array('menu_item' => basename($page[$i], '.php'), 'menu_href' => site_url('posts'), 'menu_order' => $total_menu_items+$count++));
                }
                else if (basename($page[$i], '.php') != config('blog_post')) {
                    // all other pages
                    $this->insert(array('menu_item' => basename($page[$i], '.php'), 'menu_href' => site_url(basename($page[$i], '.php')), 'menu_order' => $total_menu_items+$count++));
                }
                else {
                    continue;
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Returns the JSON representation of the menu array
     *
     * @return	string
     */

    public function menu_json() {
        $page_array = array();
        $sql = 'SELECT * from menus ORDER BY menu_order IS NULL, menu_order ASC';
        $query = $this->query($sql);

        // Add menu items to the array
        while ($menu = $query->fetch()) {
            $page_array[] = array(
                'menu_item' => $menu->menu_item,
                'menu_href' => $menu->menu_href
            );
        }

        return json_encode($page_array);
    }

}

?>
