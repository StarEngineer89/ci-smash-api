<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/6/2017
 * Time: 6:15 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('orders');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $this->load->helper('form');

        $this->load->view('Order/add');
    }

    public function save()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //Validating Name Field
        $this->form_validation->set_rules('dname', 'Username', 'required|min_length[5]|max_length[15]');

        //Validating Email Field
        $this->form_validation->set_rules('demail', 'Email', 'required|valid_email');

        //Validating Mobile no. Field
        $this->form_validation->set_rules('dmobile', 'Mobile No.', 'required|regex_match[/^[0-9]{10}$/]');

        //Validating Address Field
        $this->form_validation->set_rules('daddress', 'Address', 'required|min_length[10]|max_length[50]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('insert_view');
        } else {
            //Setting values for tabel columns
            $data = array(
                'Student_Name' => $this->input->post('dname'),
                'Student_Email' => $this->input->post('demail'),
                'Student_Mobile' => $this->input->post('dmobile'),
                'Student_Address' => $this->input->post('daddress')
            );
            //Transfering data to Model
            $this->orders->form_insert($data);
            $data['message'] = 'Data Inserted Successfully';
            //Loading View
            $this->load->view('insert_view', $data);

        }
    }
}
