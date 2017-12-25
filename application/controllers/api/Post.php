<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/11/2017
 * Time: 2:26 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Post extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Orders_model');
        $this->load->model('Products_model');

        $this->load->library('facebook');
    }

    public function instagram_post() {
        //$postObj = new Instagram_post();

        $u_id = $this->input->post('u_id');
        $images = $this->input->post('image');
        $images = $_FILES['image'];
        $caption = $this->input->post('caption');

        if ($images && is_array($images)) {
            $imageObj = $images;
        } else {
            $imageObj[0] = $images;
        }

        echo json_encode(array('status' => 'success', 'msg' => "image upload", 'file' => $imageObj['name']));
    }

    public function facebook_post() {
        $u_id = $this->input->post('u_id');
        $caption = $this->input->post('caption');
        $access_token = $this->input->post('fb_token');

        if (isset($_FILES['image']) && !is_null($_FILES['image'])) {
            $config['upload_path']          = './uploads/posts/fb/';
            $config['allowed_types']        = '*';
            $config['max_size']             = 20480;
            $config['max_width']            = 20480;
            $config['max_height']           = 20480;

            $this->load->library('upload');

            $count = count($_FILES['image']['tmp_name']);

            $files = null;

            if ( count($_FILES['image']['tmp_name']) > 1 ) {
                for($s=0; $s<=$count-1; $s++) {
                    $_FILES['photo']['name'] = $_FILES['image']['name'][$s];
                    $_FILES['photo']['type'] = $_FILES['image']['type'][$s];
                    $_FILES['photo']['tmp_name'] = $_FILES['image']['tmp_name'][$s];
                    $_FILES['photo']['error'] = $_FILES['image']['error'][$s];
                    $_FILES['photo']['size'] = $_FILES['image']['size'][$s];

                    $this->upload->initialize($config);

                    if ( ! $this->upload->do_upload('photo'))
                    {
                        $error = array('error' => $this->upload->display_errors());

                        $response=array(
                            'status'=>'failed',
                            'message'=>'Image files was not uploaded.',
                            'error' => $error['error']
                        );

                        echo json_encode($response);
                    }
                    else
                    {
                        $data = array('upload_data' => $this->upload->data());

                        $files[] = $config['upload_path'] . $data['upload_data']['file_name'];
                    }
                }
            } else {

                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('image'))
                {
                    $error = array('error' => $this->upload->display_errors());

                    $response=array(
                        'status'=>'failed',
                        'message'=>'Image files was not uploaded.',
                        'error' => $error['error']
                    );

                    echo json_encode($response);
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());

                    $files = $config['upload_path'] . $data['upload_data']['file_name'];
                }
            }
        }

        if (isset($files) && is_array($files)) {
            $images = $files[0];
        } else {
            $images = $files;
        }

        $result = $this->facebook->user_upload_request($images, ['message' => $caption], 'image', $access_token);
//        $result = array (
//            'id' => '270215833506480',
//            'post_id' => '270207716840625_270215833506480',
//        );

        error_log(json_encode($result), 3, 'debug.log');

        if ($result) {
            //$result2 = $this->facebook->request('post', '/'.$result['id'].'/tags', array('tag_text' => "My Tag", 'tag_uid' => '100019680150803'));
            //error_log(json_encode($result2), 3, 'debug.log');
        }

        if ($result) {
            echo json_encode(array('status' => 'success', 'msg' => "Congratulations, you have posted successfully!", 'result' => $result));
        }
    }

    public function fbTag_post() {
        $u_id = $this->input->post('u_id');
        $caption = $this->input->post('caption');
        $access_token = $this->input->post('fb_token');

        $tag_text = $this->input->post('tag_text');
        $tag_uid = $this->input->post('tag_uid');
        $point_x = $this->input->post('tag_x');
        $point_y = $this->input->post('tag_y');
        $photo_id = $this->input->post('photo_id');

        $result2 = $this->facebook->request('post', "/$photo_id/tags",
            array('tag_text' => "$tag_text", 'tag_uid' => "$tag_uid", 'x' => $point_x, 'y' => $point_y),
            $access_token
        );
        error_log(json_encode($result2), 3, 'debug.log');

        echo json_encode($result2);
    }

    public function friends_post() {
        $fb_uid = $this->input->post('fb_uid');
        $access_token = $this->input->post('fb_token');

        $friends = $this->facebook->request('get', "/$fb_uid/permissions", $access_token);

        var_export($friends);
    }
}