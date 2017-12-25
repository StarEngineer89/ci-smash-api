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

    public function get_products ( $where = null, $conditionType = null, $limit = null, $offset = 0 ) {
        $query = $this->db;

        if ($conditionType == 'where') {
            $query = $query->where($where);
        }

        if ($conditionType == 'in') {
            $query = $query->where_in($where);
        }

        if ($conditionType == 'like') {
            $query = $query->like($where);
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