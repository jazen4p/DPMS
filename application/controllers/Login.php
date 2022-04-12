<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('Login_model');
    }

	public function index()
	{
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = $this->Login_model->checkUser($username, md5($password));

        $u_id = '';

        foreach ($query->result() as $row){
            $u_id = $row->id;
            $username = $row->username;
            $nama = $row->nama;
            $telp = $row->telp;
            $email = $row->email;
            $alamat = $row->alamat;
            $status = $row->status;
            $role = $row->role;
            $file_name = $row->file_name;
        }
        
        if($query->num_rows() == 0){
            $data['log_err'] = 'Invalid Username or Password';
            $this->load->view('login', $data);
        } 
        elseif($u_id == ''){
            $data['log_err'] = 'Invalid Username or Password';
            $this->load->view('login', $data);
        }
        elseif($status == "inactive"){
            $data['log_err'] = 'Account has been deactivated';
            $this->load->view('login', $data);
        }
        else {
            $sess_data = array(
                'u_id' => $u_id,
                'username' => $username,
                'nama' => $nama,
                'telp' => $telp,
                'email' => $email,
                'alamat' => $alamat,
                'status' => $status,
                'role' => $role,
                'logged' => TRUE,
                'file_name' => $file_name
            );

            $this->session->set_userdata($sess_data);
            // $this->load->view('dashboard');
            if($this->session->userdata('role')=="staff checker"){
                redirect('Kasir/check_air');
            } else if($this->session->userdata('role')=="staff kasir"){
                redirect('Kasir');
            } else {
                redirect('/Dashboard');
            }
        }
    }
    
    public function logout(){
        $array_items = array('username','email','u_id','nama','telp','alamat','status','role');
        $this->session->unset_userdata($array_items);
        session_destroy();
        // $this->load->view('index');
        redirect('/');
    }
}
