<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function checkUser($username,$password){
        $query = $this->db->get_where('user',array('username'=> $username , 'password'=> $password));
        return $query;
    }
}