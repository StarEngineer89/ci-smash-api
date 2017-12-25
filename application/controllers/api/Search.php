<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/24/2017
 * Time: 10:14 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Search extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Orders_model');
        $this->load->model('Products_model');
    }

    public function product() {
        $name = $this->input->post('keyword');

        $products = $this->Products_model->get_products(array('product_name' => $name), 'like');
        if (is_array($products)) {
            $productIds = array();
            foreach ($products as $product) {
                $productIds[] = $product['id'];
            }
        }

        if ($products) {
            echo json_encode(array('status' => 'success', 'msg' => 'Success', 'products' => $products));
        }
    }
}