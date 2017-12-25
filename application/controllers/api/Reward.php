<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/9/2017
 * Time: 11:53 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Reward extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('User_Reward_model');
    }

    public function donate_get() {
        $u_id = $this->input->get('u_id');
        $type = $this->input->get('donationType');

        $user = $this->getUser($u_id);

        $point = $user['point'];

        if ($type == 'good_karma') {

            if ($user['point'] > 25) {
                $point = $point - 25;
            } else {
                echo json_encode(array('status' => 'failed', 'msg' => "Your Point is not enough to proceed this donation."));
                die();
            }

        }

        $result = $this->updateUser($u_id, array('point' => $point));

        if ($result == false) {
            echo json_encode(array('status' => 'failed', 'msg' => 'db error', 'data' => $result));
            exit;
        }

        $user = $this->getUser($u_id);
        echo json_encode(array('status' => 'success', 'msg' => "Success", 'point' => $user['point']));
    }

    private function getUser($userId) {
        $where = array('id' => $userId);
        $result = $this->Users_model->get_user($where);

        if ($result == false) {
            return false;
        }

        return $result;
    }

    private function updateUser($userId, $data) {
        $where = array('id' => $userId);
        $result = $this->Users_model->update_user($where, $data);

        return $result;
    }
}