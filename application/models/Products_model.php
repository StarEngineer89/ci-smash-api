<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/9/2017
 * Time: 2:34 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model
{
    public function __construct()	{
        $this->load->database();
    }

    public function get_product ( $where ) {
        if ( $where != FALSE ) {
            $query = $this->db->get_where('products', $where);
            return $query->row_array();
        }
        else {
            return FALSE;
        }
    }

    public function get_products ( $where, $in, $limit = null, $offset = 0 ) {
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

        $query = $query->get('products');
        $result = $query->result_array();

        return $result;
    }

    public function save_product ( $data ) {
        $result = $this->db->insert('products', $data);

        return $result;
    }
}