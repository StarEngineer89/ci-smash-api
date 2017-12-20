<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/10/2017
 * Time: 1:59 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Reward_model extends CI_Model
{
    public function __construct()	{
        $this->load->database();
    }

}