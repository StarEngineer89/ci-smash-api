<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/23/2017
 * Time: 9:19 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_post ( $where ) {
        if ( $where != FALSE ) {
            $query = $this->db->get_where('posts', $where);
            return $query->row_array();
        }
        else {
            return FALSE;
        }
    }

    public function get_posts ( $where, $in, $limit = null, $offset = 0 ) {
        $query = $this->db;

        if ($where != false) {
            $query = $query->where($where);
        }

        if ($in != false) {
            $query = $query->where_in($in);
        }

        if ($limit) {
            $query = $query->limit($limit, $offset);
        }

        $query = $query->get('posts');
        $result = $query->result_array();

        return $result;
    }

    public function save_post ( $data ) {
        $result = $this->db->insert('posts', $data);

        return $result;
    }
}