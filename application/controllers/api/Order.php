<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/8/2017
 * Time: 11:25 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Order extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Orders_model');
        $this->load->model('Products_model');
    }

    public function order_get() {

    }

    public function list_get() {
        $u_id = $this->input->get('u_id');

        $orders = $this->getOrders($u_id);

        if ($orders) {
            echo json_encode(array('status' => 'success', 'msg' => "Success", 'orders'  => $orders));
        }
        else {
            echo json_encode(array('status' => 'failed', 'msg' => "Empty or Error", 'orders' => null));
        }
    }

    public function identify_get() {
        $u_id = $this->input->get('u_id');
        $i_id = $this->input->get('i_id');
        $client_id = $this->input->get('clientId');
        $order_num = $this->input->get('orderNumber');

        $where = array('client_id' => $client_id, 'order_number' => $order_num);

        $result = $this->checkOrder($where);

        if (!$result) {
            echo json_encode(array('status' => 'failed', 'msg' => 'Order number not recognized.'));
            exit();
        }

        $order = $result;

        if (is_null($order['user_id']) || $order['user_id'] == '') {
            $result = $this->Orders_model->update_order(array('id' => $order['id']), array('user_id' => $u_id));

            if ($result == false) {
                echo json_encode(array('status' => 'failed', 'msg' => 'update error', 'result' => $result));
                exit;
            }
        }

        $order = $this->getOrderDetail($where);

        echo json_encode(array('status' => 'success', 'msg' => 'success', 'order' => $order));
    }

    public function save_post() {
        $client_id = $this->input->post('client_id');
        $order_num = $this->input->post('orderNumber');
        $product = $this->input->post('client_id');
        $client_id = $this->input->post('client_id');
        $client_id = $this->input->post('client_id');
        $client_id = $this->input->post('client_id');
    }

    private function checkOrder ($where) {
        $result = $this->Orders_model->check_order($where);

        if ($result == false) {
            return false;
        }

        return $result;
    }

    private function getOrders ($user) {
        $where = array('user_id' => $user);
        $orders = $this->Orders_model->get_orders($where, 'where');

        return $orders;

    }

    private function getOrderDetail ($where) {
        $order = $this->Orders_model->get_order($where);

        if (count($order) == 0) {
            return false;
        }

        $products = $order['product_ids'];
        $products = $this->Products_model->get_products(array('id' => $products), 'in');

        if (count($products) == 0) {
            return false;
        }

        $order['products'] = $products;

        return $order;
    }
}