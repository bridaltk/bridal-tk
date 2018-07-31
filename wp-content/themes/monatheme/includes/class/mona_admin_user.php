<?php

class Mona_admin_user {

    protected $table = 'wp_users';
    protected $_db;

    public function __construct() {
        global $wpdb;
        $this->_db = $wpdb;
    }

    public function get_khach_hang($page = '') {
        $page = max(1, (int) $page);
        $offset = ($page - 1) * 10;
        $sql = "SELECT SQL_CALC_FOUND_ROWS {$this->table}.ID FROM wp_users INNER JOIN wp_usermeta ON ( wp_users.ID = wp_usermeta.user_id ) WHERE 1=1 AND ( ( ( wp_usermeta.meta_key = 'wp_capabilities' AND wp_usermeta.meta_value LIKE '%mona_khac_hang%' ) ) ) ORDER BY `user_registered` DESC LIMIT {$offset},10";
        $query = $this->_db->get_results($sql);
        if (count($query) > 0) {
            return $query;
        }
        return false;
    }

}
