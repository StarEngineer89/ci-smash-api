<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/5/2017
 * Time: 11:32 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Instagram_api.php';

class User extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
    }

    public function instagram_get() {

        // Make sure that there is a GET variable of code
        if(!is_null($this->get('code')) & $this->get('code') != '') {

            $auth_response = $this->instagram_api->authorize($_GET['code']);

            // Set up session variables containing some useful Instagram data
            $this->session->set_userdata('instagram-token', $auth_response->access_token);
            $this->session->set_userdata('instagram-username', $auth_response->user->username);
            $this->session->set_userdata('instagram-profile-picture', $auth_response->user->profile_picture);
            $this->session->set_userdata('instagram-user-id', $auth_response->user->id);
            $this->session->set_userdata('instagram-full-name', $auth_response->user->full_name);

            $this->response($auth_response);
        } else {

            // There was no GET variable so redirect back to the homepage
            $this->response($this->get('code'));
        }
    }

    public function login_get() {
        $user = array();

        if ($this->input->get('username') && !is_null($this->input->get('username'))) {
            $user['username'] = $this->input->get('username');
        }

        if ($this->input->get('password') && !is_null($this->input->get('password'))) {
            $user['password'] = $this->input->get('password');
        }

        if ($this->input->get('firstname') && !is_null($this->input->get('firstname'))) {
            $user['firstname'] = $this->input->get('firstname');
        }

        if ($this->input->get('lastname') && !is_null($this->input->get('lastname'))) {
            $user['lastname'] = $this->input->get('lastname');
        }

        /*
         * Instagram Login or Register
         */
        if ($this->input->get('i_id') && !is_null($this->input->get('i_id'))) {
            $user['inst_id'] = $this->input->get('i_id');
        }

        if ($this->input->get('i_username') && !is_null($this->input->get('i_username'))) {
            $user['inst_username'] = $this->input->get('i_username');
        }

        if (isset($user['inst_id']) && isset($user['inst_username'])) {
            $where = array('inst_id' => $user['inst_id'], 'inst_username' => $user['inst_username']);
            $registered = $this->Users_model->get_user($where);

            if (count($registered) == 0) {
                $result = $this->register($user);

                if ($result) {
                    $user = $this->Users_model->get_user(array('inst_id' => $user['inst_id'], 'inst_username' => $user['inst_username']));
                    echo json_encode(array('status' => 'success', 'msg' => 'instagram was registered', 'user' => $user));
                } else {
                    echo json_encode(array('status' => 'failed', 'msg' => 'db error'));
                }
            } else {
                $user = $this->Users_model->get_user(array('inst_id' => $user['inst_id'], 'inst_username' => $user['inst_username']));
                echo json_encode(array('status' => 'success', 'msg' => 'Login Success', 'user' => $user));
            }

            exit();
        }
        /* End Instagram Login or Register */

        /*
         * Facebook Login or Register
         */
        if ($this->input->get('fb_id') && !is_null($this->input->get('fb_id'))) {
            $user['fb_id'] = $this->input->get('fb_id');
        }

        if ($this->input->get('fb_username') && !is_null($this->input->get('fb_username'))) {
            $user['fb_username'] = $this->input->get('fb_username');
        }

        if (isset($user['fb_id']) && isset($user['fb_username'])) {
            $where = array('fb_id' => $user['fb_id'], 'fb_username' => $user['fb_username']);
            $registered = $this->Users_model->get_user($where);

            if (count($registered) == 0) {
                $result = $this->register($user);

                if ($result) {
                    $user = $this->Users_model->get_user(array('fb_id' => $user['fb_id'], 'fb_username' => $user['fb_username']));
                    echo json_encode(array('status' => 'success', 'msg' => 'instagram was registered', 'user' => $user));
                } else {
                    echo json_encode(array('status' => 'failed', 'msg' => 'db error'));
                }
            } else {
                $user = $this->Users_model->get_user(array('fb_id' => $user['fb_id'], 'fb_username' => $user['fb_username']));
                echo json_encode(array('status' => 'success', 'msg' => 'Login Success', 'user' => $user));
            }

            exit();
        }
        /* End Facebook Login or Register */

        $result = $this->login($user);
    }

    private function login($user) {

    }

    private function register($user) {

        if (count($user) == 0) {
            echo json_encode(array('status' => 'failed', 'msg' => "empty value"));
            exit;
        }

        $user['point'] = 500;
        $user['created_at'] = date('Y-m-d H:i:s');
        $user['updated_at'] = date('Y-m-d H:i:s');
        $result = $this->Users_model->save_user($user);

        return $result;
    }
}