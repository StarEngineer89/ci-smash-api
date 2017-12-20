<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/6/2017
 * Time: 9:30 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

    public function get_order ( $where ) {
        if ( $where != FALSE ) {
            $query = $this->db->get_where('orders', $where);
            return $query->row_array();
        }
        else {
            return FALSE;
        }
    }

    public function get_orders ( $where, $limit = 10, $offset = 0 ) {
        if ( $where != FALSE ) {
            $query = $this->db->get_where('orders', $where, $limit, $offset);
            return $query->row_array();
        }
        else {
            return FALSE;
        }
    }

    public function check_order ( $where ) {
        if ( $where != FALSE ) {
            $query = $this->db->get_where('orders', $where);
            return $query->row_array();
        }
        else {
            return FALSE;
        }
    }

    public function save_order ( $data ) {
        $result = $this->db->insert('orders', $data);

        return $result;
    }

    public function update_order ($where, $order) {
        $this->db->where($where);
        $result = $this->db->update('orders', $order);

        return $result;
    }
}