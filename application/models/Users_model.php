<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/9/2017
 * Time: 4:08 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model
{
    public function __construct()	{
        $this->load->database();
    }

    public function get_user ( $where ) {
        if ( $where != FALSE ) {
            $query = $this->db->get_where('users', $where);
            return $query->row_array();
        }
        else {
            return FALSE;
        }
    }

    public function get_users ( $where, $limit = 10, $offset = 0 ) {
        if ( $where != FALSE ) {
            $query = $this->db->get_where('users', $where, $limit, $offset);
            return $query->row_array();
        }
        else {
            return FALSE;
        }
    }

    public function save_user ( $data ) {
        $result = $this->db->insert('users', $data);

        return $result;
    }

    public function update_user ( $where, $data ) {
        $this->db->where($where);
        $result = $this->db->update('users', $data);

        return $result;
    }
}