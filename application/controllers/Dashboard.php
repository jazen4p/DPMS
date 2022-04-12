<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('Login_model');
        $this->load->model('Dashboard_model');

        if($this->session->userdata("logged")==FALSE)
        {
            redirect(base_url(),'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
    }

	public function index()
	{
        $data['nama'] = $this->session->userdata('nama');

        $data['perumahan'] = $this->db->get('perumahan');
        $data['year'] = date('Y');
        $data['year_now'] = date('Y');

        // $data['graph'] = $this->db->get_where('rumah', array('status'=>"ppjb"));

        $this->load->view('dashboard-1', $data);
    }

    public function filter_tahun(){
        $year = $_POST['year'];

        $data['nama'] = $this->session->userdata('nama');

        $data['perumahan'] = $this->db->get('perumahan');
        $data['year'] = $year;
        $data['year_now'] = date('Y');

        // $data['graph'] = $this->db->get_where('rumah', array('status'=>"ppjb"));

        $this->load->view('dashboard-1', $data);
    }

    public function filter_keuangan_dashboard(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        if($id == "a"){
            foreach($this->db->get('ppjb')->result() as $row){
                $test = $this->Dashboard_model->bulletin_dashboard_mendekati($row->no_psjb, $kode);
            }
        } else if($id == "b"){
            foreach($this->db->get('ppjb')->result() as $row){
                $test = $this->Dashboard_model->bulletin_dashboard_hariini($row->no_psjb, $kode);
            }
        } else {
            foreach($this->db->get('ppjb')->result() as $row){
                $test = $this->Dashboard_model->bulletin_dashboard_melewati($row->no_psjb, $kode);
            }
        }

        $data['id'] = $id;
        $data['kode'] = $kode;
        $data['nama'] = $this->session->userdata('nama');

        // $data['test'] = $test;
        // print_r($data['test']->result());

        $this->load->view('transaksi_keuangan_filter', $data);
    }

    public function filter_perumahan_dashboard(){
        $perumahan = $_POST['perumahan'];

        if($perumahan == ""){
            $data['perumahan'] = $this->db->get('perumahan');
        }else {
            $data['perumahan'] = $this->db->get_where('perumahan', array('kode_perumahan'=>$perumahan));
        }

        
        $data['nama'] = $this->session->userdata('nama');

        // $data['perumahan'] = $this->db->get('perumahan');
        $data['year'] = date('Y');
        $data['year_now'] = date('Y');
        $data['kode_prmh'] = $perumahan;
        // $data['graph'] = $this->db->get_where('rumah', array('status'=>"ppjb"));

        $this->load->view('dashboard-1', $data);
    }
    
    public function user_management(){
        $query = $this->Dashboard_model->get_User();
        
        $data['user_all'] = $query->result();

        $data['nama'] = $this->session->userdata('nama');
        
        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['error_upload'] = $this->session->flashdata('error_upload');
        
        $this->load->view('user', $data);
    }

    public function add_user(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $nama_pribadi = $_POST['nama_pribadi'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $telp = $_POST['telp'];
        $email = $_POST['email'];
        $status = $_POST['status'];
        $role = $_POST['role'];
        $file_name = "";
        $alamat = $_POST['alamat'];

        $gt = $this->db->get_where('user', array('username'=>$username));
        // print_r($gt->num_rows());
        // exit;

        if($gt->num_rows() > 0){

            $data['nama'] = $this->session->userdata('nama');

            // $data['err_msg'] = "Data user sudah ada";
            $this->session->set_flashdata('err_msg', "Data sudah ada!");
            
            // $this->load->view('user', $data);
            redirect('Dashboard/user_management');
        } else {
            $config['upload_path']          = './gambar/';
            $config['allowed_types']        = 'gif|jpg|png';
            // $config['max_size']             = 100;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
     
            $this->load->library('upload', $config);
     
            if ( ! $this->upload->do_upload('berkas')){
                $data['error_upload'] = array('error' => $this->upload->display_errors());
    
                $data = array(
                    'username' => $username,
                    'password' => md5($password),
                    'nama' => $nama_pribadi,
                    'jenis_kelamin' => $jenis_kelamin,
                    'alamat' => $alamat,
                    'telp' => $telp,
                    'email' => $email,
                    'status' => $status,
                    'role' => $role,
                    // 'file_name' => $file_name
                );
    
                $this->db->insert('user', $data);

                $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));

                redirect('Dashboard/user_management');
                // $this->load->view('user', $data);
            }else{
                $upload = array('upload_data' => $this->upload->data());
                $file_name = $upload['upload_data']['file_name'];
                
                $data = array(
                    'username' => $username,
                    'password' => md5($password),
                    'nama' => $nama_pribadi,
                    'jenis_kelamin' => $jenis_kelamin,
                    'alamat' => $alamat,
                    'telp' => $telp,
                    'email' => $email,
                    'status' => $status,
                    'role' => $role,
                    'file_name' => $file_name
                );
    
                $this->db->insert('user', $data);
    
                $data['nama'] = $this->session->userdata('nama');

                $this->session->set_flashdata('succ_msg', "Data sukses ditambahkan!");

                redirect('Dashboard/user_management');
    
                // $data['succ_msg'] = "Data sukses ditambahkan";
                
                // $this->load->view('user', $data);
            }
        }
    }

    public function edit_view_user(){
        $id = $_GET['id'];

        $data['edit_user'] = $this->db->get_where('user', array('id'=>$id))->result();

        $query = $this->Dashboard_model->get_User();
        $data['user_all'] = $query->result();

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['pass_alert'] = $this->session->flashdata('password');
        
        $data['pass_succ_alert'] = $this->session->flashdata('passwordSuccess');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['error_upload'] = $this->session->flashdata('error_upload');

        $this->load->view('user', $data);
    }

    public function edit_user(){
        $id = $_POST['id'];
        $username = $_POST['username'];
        // $password = $_POST['password'];
        $nama_pribadi = $_POST['nama_pribadi'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $telp = $_POST['telp'];
        $email = $_POST['email'];
        $status = $_POST['status'];
        $role = $_POST['role'];
        $file_name = "";
        $alamat = $_POST['alamat'];
        $old = $_POST['old'];

        // print_r($_FILES['berkas']['name']);
        // exit;

        if($_FILES['berkas']['name']!=""){
            $config['upload_path']          = './gambar/';
            $config['allowed_types']        = 'gif|jpg|png';
            // $config['max_size']             = 100;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
    
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('berkas')) {
                // $data['error_upload'] = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));
                
                $data = array(
                    'username' => $username,
                    // 'password' => md5($password),
                    'nama' => $nama_pribadi,
                    'jenis_kelamin' => $jenis_kelamin,
                    'alamat' => $alamat,
                    'telp' => $telp,
                    'email' => $email,
                    'status' => $status,
                    'role' => $role,
                    'file_name' => $file_name
                );

                $this->db->update('user', $data, array('id'=>$id));

                // $this->load->view('user', $data);
                $this->session->set_flashdata('succ_msg', "Data sukses diubah!");
                redirect('Dashboard/edit_view_user?id='.$id);
            }
            else {
                $upload = array('upload_data' => $this->upload->data());
                
                if($old != ""){
                    unlink("gambar/".$old);
                }
                // foreach($upload['upload_data']['file_name'] as $item){
                //     $file_name = $item->file_name;
                // }
                // print_r($upload['upload_data']['file_name']);
                // print_r($file_name);
                // exit;
                $file_name = $upload['upload_data']['file_name'];
                
                $data = array(
                    'username' => $username,
                    // 'password' => md5($password),
                    'nama' => $nama_pribadi,
                    'jenis_kelamin' => $jenis_kelamin,
                    'alamat' => $alamat,
                    'telp' => $telp,
                    'email' => $email,
                    'status' => $status,
                    'role' => $role,
                    'file_name' => $file_name
                );

                $this->db->update('user', $data, array('id'=>$id));

                $data['edit_user'] = $this->db->get_where('user', array('id'=>$id))->result();

                $query = $this->Dashboard_model->get_User();
                $data['user_all'] = $query->result();

                $data['nama'] = $this->session->userdata('nama');
                $data['id'] = $id;

                // $this->load->view('user', $data);
                $this->session->set_flashdata('succ_msg', "Data sukses diubah!");
                redirect('Dashboard/edit_view_user?id='.$id);
            }
        } else {
            $data = array(
                'username' => $username,
                // 'password' => md5($password),
                'nama' => $nama_pribadi,
                'jenis_kelamin' => $jenis_kelamin,
                'alamat' => $alamat,
                'telp' => $telp,
                'email' => $email,
                'status' => $status,
                'role' => $role,
                'file_name' => $old
            );

            $this->db->update('user', $data, array('id'=>$id));
            
            $data['edit_user'] = $this->db->get_where('user', array('id'=>$id))->result();

            $query = $this->Dashboard_model->get_User();
            $data['user_all'] = $query->result();

            $data['nama'] = $this->session->userdata('nama');
            $data['id'] = $id;

            $this->session->set_flashdata('succ_msg', "Data sukses diubah!");
            redirect('Dashboard/edit_view_user?id='.$id);
        }
    }

    public function edit_password_user(){
        $id=$_POST['id'];
        $pass_lama=$_POST['pass_lama'];
        $pass_baru=$_POST['pass_baru'];

        $query = $this->db->get_where('user', array('id'=>$id, 'password'=>md5($pass_lama)));

        if($query->num_rows() > 0){
            $data = array(
                'password'=>md5($pass_baru)
            );

            $this->db->update('user', $data, array('id'=>$id));

            $this->session->set_flashdata('passwordSuccess', 'Ubah Password Berhasil!');

            redirect('Dashboard/edit_view_user?id='.$id);
        }else {
            $this->session->set_flashdata('password', 'Gagal Ubah Password!');

            redirect('Dashboard/edit_view_user?id='.$id);
        }
        // print_r($query->num_rows());
        // exit;
    }

    public function hapus_user(){
        $id = $_GET['id'];

        $this->db->delete('user', array('id'=>$id));

        $query = $this->Dashboard_model->get_User();
        
        $data['user_all'] = $query->result();

        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = "Data sukses dihapus";
        
        // $this->load->view('user', $data);

        redirect('Dashboard/user_management');
    }

    public function bank_management(){
        $query = $this->Dashboard_model->get_Bank();
        
        $data['bank_all'] = $query->result();

        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('bank', $data);
    }

    public function add_bank(){
        $kode_bank = $_POST['kode_bank'];
        $nama_bank = $_POST['nama_bank'];
        $atas_nama = $_POST['atas_nama'];
        $status = $_POST['status'];
        $created_by = $this->session->userdata('nama');
        $created_by_id = $this->session->userdata('u_id');
        $date_by = date("Y-m-d");

        $data = array(
            'kode_bank' => $kode_bank,
            'nama_bank' => $nama_bank,
            'status' => $status,
            'atas_nama' => $atas_nama,
            'created_by' => $created_by,
            'created_by_id' => $created_by_id,
            'date_create' => $date_by
        );

        $this->db->insert('bank', $data);

        $query = $this->Dashboard_model->get_Bank();
        
        $data['bank_all'] = $query->result();

        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = "Data sukses ditambahkan";

        $this->load->view('bank', $data);
    }

    public function edit_view_bank(){
        $id = $_GET['id'];

        $data['edit_bank'] = $this->db->get_where('bank', array('id_bank'=>$id))->result();

        $query = $this->Dashboard_model->get_Bank();
        $data['bank_all'] = $query->result();

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('bank', $data);
    }

    public function edit_bank(){
        $kode_bank = $_POST['kode_bank'];
        $nama_bank = $_POST['nama_bank'];
        $status = $_POST['status'];
        $atas_nama = $_POST['atas_nama'];
        $id = $_POST['id'];

        $data = array(
            'kode_bank' => $kode_bank,
            'nama_bank' => $nama_bank,
            'status' => $status,
            'atas_nama' => $atas_nama
        );
        
        $this->db->update('bank', $data, array('id_bank'=>$id));

        $query = $this->Dashboard_model->get_Bank();
        
        $data['bank_all'] = $query->result();

        $data['nama'] = $this->session->userdata('nama');

        $this->session->set_flashdata('succ_msg', 'Data sukses diubah');
        
        // $this->load->view('bank', $data);
        redirect('Dashboard/edit_view_bank?id='.$id);
    }

    public function hapus_bank(){
        $id=$_GET['id'];

        $this->db->delete('bank', array('id_bank'=>$id));

        redirect('Dashboard/bank_management');
    }

    public function perusahaan_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('perusahaan')->result();
        $data['succ_msg'] = "";

        $this->load->view('perusahaan', $data);
    }

    public function add_perusahaan(){
        $kode_kota = $_POST['kode_kota'];
        $nama_kota = $_POST['nama_kota'];
        $kode_perusahaan = $_POST['kode_perusahaan'];
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $npwp = $_POST['npwp'];
        $file_name = "";

        $config['upload_path']          = './gambar/';
		$config['allowed_types']        = 'gif|jpg|png';
		// $config['max_size']             = 1000;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
 
		$this->load->library('upload', $config);
 
		if ( ! $this->upload->do_upload('berkas')){
			$data['error_upload'] = array('error' => $this->upload->display_errors());
        
            $data['nama'] = $this->session->userdata('nama');

            $data['check_all'] = $this->db->get('perusahaan')->result();
            // $data['succ_msg'] = "Data sukses ditambahkan";

            $this->load->view('perusahaan', $data);
		}else{
            $upload = array('upload_data' => $this->upload->data());

            // foreach($upload['upload_data']['file_name'] as $item){
            //     $file_name = $item->file_name;
            // }
            // print_r($upload['upload_data']['file_name']);
            // print_r($file_name);
            // exit;
            $file_name = $upload['upload_data']['file_name'];
            
            $data = array(
                'kode_kota' => $kode_kota,
                'nama_kota' => $nama_kota,
                'kode_perusahaan' => $kode_perusahaan,
                'nama_perusahaan' => $nama_perusahaan,
                'npwp'=>$npwp,
                'file_name' => $file_name
            );

            $this->db->insert('perusahaan', $data);
        
            $data['nama'] = $this->session->userdata('nama');

            $data['check_all'] = $this->db->get('perusahaan')->result();
            $data['succ_msg'] = "Data sukses ditambahkan";

            $this->load->view('perusahaan', $data);
		}
    }

    public function edit_view_perusahaan(){
        $id = $_GET['id'];

        $data['edit_perusahaan'] = $this->db->get_where('perusahaan', array('id_perusahaan'=>$id))->result();

        $data['check_all'] = $this->db->get('perusahaan')->result();

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $data['error_upload'] = $this->session->flashdata('error_upload');

        $this->load->view('perusahaan', $data);
    }

    public function edit_perusahaan(){
        $kode_kota = $_POST['kode_kota'];
        $nama_kota = $_POST['nama_kota'];
        $kode_perusahaan = $_POST['kode_perusahaan'];
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $npwp = $_POST['npwp'];
        $id = $_POST['id'];
        $old = $_POST['old'];
        $file_name = "";

        if($_FILES['berkas']['name']!=""){
            $config['upload_path']          = './gambar/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            // $config['max_size']             = 1000;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
    
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('berkas')) {
                $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));
                // $data['error_upload'] = array('error' => $this->upload->display_errors());

                $data['nama'] = $this->session->userdata('nama');
    
                $data['check_all'] = $this->db->get('perusahaan')->result();
    
                // $this->load->view('perusahaan', $data);
                
                $this->session->set_flashdata('succ_msg', 'Data sukses diubah');
                redirect('Dashboard/edit_view_perusahaan?id='.$id);
            }
            else {
                $upload = array('upload_data' => $this->upload->data());
                
                if($old != ""){
                    unlink("gambar/".$old);
                }
                // foreach($upload['upload_data']['file_name'] as $item){
                //     $file_name = $item->file_name;
                // }
                // print_r($upload['upload_data']['file_name']);
                // print_r($file_name);
                // exit;
                $file_name = $upload['upload_data']['file_name'];
                
                $data = array(
                    'kode_kota' => $kode_kota,
                    'nama_kota' => $nama_kota,
                    'kode_perusahaan' => $kode_perusahaan,
                    'nama_perusahaan' => $nama_perusahaan,
                    'npwp'=>$npwp,
                    'file_name' => $file_name
                );
    
                $this->db->update('perusahaan', $data, array('id_perusahaan'=>$id));
    
                $data['nama'] = $this->session->userdata('nama');
    
                $data['check_all'] = $this->db->get('perusahaan')->result();
    
                $data['succ_msg'] = "Data sukses di ubah";
                
                $this->session->set_flashdata('succ_msg', 'Data sukses diubah');
    
                // $this->load->view('perusahaan', $data);
                redirect('Dashboard/edit_view_perusahaan?id='.$id);
            }
        } else {
            $data = array(
                'kode_kota' => $kode_kota,
                'nama_kota' => $nama_kota,
                'kode_perusahaan' => $kode_perusahaan,
                'nama_perusahaan' => $nama_perusahaan,
                'npwp'=>$npwp,
                'file_name' => $old
            );

            $this->db->update('perusahaan', $data, array('id_perusahaan'=>$id));

            $data['nama'] = $this->session->userdata('nama');

            $data['check_all'] = $this->db->get('perusahaan')->result();

            $data['succ_msg'] = "Data sukses di ubah";

            $this->session->set_flashdata('succ_msg', 'Data sukses diubah');

            // $this->load->view('perusahaan', $data);
            redirect('Dashboard/edit_view_perusahaan?id='.$id);
        }
    }

    public function hapus_perusahaan(){
        $id=$_GET['id'];

        $this->db->delete('perusahaan', array('id_perusahaan'=>$id));

        redirect('Dashboard/perusahaan_management');
    }

    public function perumahan_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('perumahan')->result();

        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['error_upload'] = $this->session->flashdata('error_upload');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('perumahan', $data);
    }

    public function add_perumahan(){
        // $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $nama_perumahan = $_POST['nama_perumahan'];
        $nama_perusahaan = $_POST['nama_perusahaan'];

        foreach($this->db->get_where('perusahaan', array('nama_perusahaan'=>$nama_perusahaan))->result() as $row) {
            $kode_perusahaan = $row->kode_perusahaan;
        }
        $nama_jalan = $_POST['nama_jalan'];
        $RT = $_POST['RT'];
        $RW = $_POST['RW'];
        $kecamatan = $_POST['kecamatan'];
        $kabupaten = $_POST['kabupaten'];
        $provinsi = $_POST['provinsi'];
        // $tipe_perusahaan = $_POST['tipe_perusahaan'];
        $telp = $_POST['telp'];
        $keterangan = $_POST['keterangan'];
        $shm_induk = $_POST['shm_induk'];
        $created_by = $this->session->userdata('nama');
        $created_by_id = $this->session->userdata('u_id');
        $date_by = date("Y-m-d H:i:sa am/pm");

        $file_name = "";

        $config['upload_path']          = './gambar/';
		$config['allowed_types']        = 'gif|jpg|png';
		// $config['max_size']             = 1000;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
 
		$this->load->library('upload', $config);
 
        $query = $this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan));
        if($query->num_rows() > 0){
            $this->session->set_flashdata('err_msg', "Data sudah ada");

            redirect('Dashboard/perumahan_management');
        } else {
            if ( ! $this->upload->do_upload('berkas')){
                $data['error_upload'] = array('error' => $this->upload->display_errors());

                $data['nama'] = $this->session->userdata('nama');

                $data['check_all'] = $this->db->get('perumahan')->result();

                $data = array(
                    'kode_perumahan' => $kode_perumahan,
                    'nama_perumahan' => $nama_perumahan,
                    'nama_perusahaan' => $nama_perusahaan,
                    'kode_perusahaan' => $kode_perusahaan,
                    'nama_jalan' => $nama_jalan,
                    'RT' => $RT,
                    'RW' => $RW,
                    'kecamatan' => $kecamatan,
                    'kabupaten' => $kabupaten,
                    'provinsi' => $provinsi,
                    // 'tipe_perusahaan' => $tipe_perusahaan,
                    'telp' => $telp,
                    'keterangan' => $keterangan,
                    'shm_induk' => $shm_induk,
                    'created_by' => $created_by,
                    'id_created_by' => $created_by_id,
                    'date_by' => $date_by,
                    // 'siteplan' => $file_name
                );

                $this->db->insert('perumahan', $data);

                // $this->load->view('perumahan', $data);
                $this->session->set_flashdata('succ_msg', "Data sukses di tambah");
                $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));
                redirect('Dashboard/perumahan_management');
            }else{
                $upload = array('upload_data' => $this->upload->data());

                // foreach($upload['upload_data']['file_name'] as $item){
                //     $file_name = $item->file_name;
                // }
                // print_r($upload['upload_data']['file_name']);
                // print_r($file_name);
                // exit;
                $file_name = $upload['upload_data']['file_name'];
            
                $data = array(
                    'kode_perumahan' => $kode_perumahan,
                    'nama_perumahan' => $nama_perumahan,
                    'nama_perusahaan' => $nama_perusahaan,
                    'kode_perusahaan' => $kode_perusahaan,
                    'nama_jalan' => $nama_jalan,
                    'RT' => $RT,
                    'RW' => $RW,
                    'kecamatan' => $kecamatan,
                    'kabupaten' => $kabupaten,
                    'provinsi' => $provinsi,
                    // 'tipe_perusahaan' => $tipe_perusahaan,
                    'telp' => $telp,
                    'keterangan' => $keterangan,
                    'shm_induk' => $shm_induk,
                    'created_by' => $created_by,
                    'id_created_by' => $created_by_id,
                    'date_by' => $date_by,
                    'siteplan' => $file_name
                );

                $this->db->insert('perumahan', $data);

                $data['nama'] = $this->session->userdata('nama');

                $data['check_all'] = $this->db->get('perumahan')->result();

                $data['succ_msg'] = "Data sukses di tambah";

                // $this->load->view('perumahan', $data);

                $this->session->set_flashdata('succ_msg', "Data sukses di tambah");
                redirect('Dashboard/perumahan_management');
            }
        }
    }
    
    public function edit_view_perumahan(){
        $id = $_GET['id'];

        $data['edit_perumahan'] = $this->db->get_where('perumahan', array('id_perumahan'=>$id))->result();

        $data['check_all'] = $this->db->get('perumahan')->result();

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $this->load->view('perumahan', $data);
    }

    public function edit_perumahan(){
        $id=$_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $nama_perumahan = $_POST['nama_perumahan'];
        $nama_perusahaan = $_POST['nama_perusahaan'];
        foreach($this->db->get_where('perusahaan', array('nama_perusahaan'=>$nama_perusahaan))->result() as $row) {
            $kode_perusahaan = $row->kode_perusahaan;
        }
        // echo $kode_perusahaan;
        // exit;
        $nama_jalan = $_POST['nama_jalan'];
        $RT = $_POST['RT'];
        $RW = $_POST['RW'];
        $kecamatan = $_POST['kecamatan'];
        $kabupaten = $_POST['kabupaten'];
        $provinsi = $_POST['provinsi'];
        // $tipe_perusahaan = $_POST['tipe_perusahaan'];
        $telp = $_POST['telp'];
        $keterangan = $_POST['keterangan'];
        $shm_induk = $_POST['shm_induk'];
        $created_by = $this->session->userdata('nama');
        $created_by_id = $this->session->userdata('u_id');
        $date_by = date("Y-m-d H:i:sa am/pm");

        $data['id'] = $id;
        
        $old = $_POST['old'];
        $file_name = "";

        if($_FILES['berkas']['name']!=""){
            $config['upload_path']          = './gambar/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            // $config['max_size']             = 1000;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
    
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('berkas')) {
                $data['error_upload'] = array('error' => $this->upload->display_errors());

                $data['nama'] = $this->session->userdata('nama');
    
                $data['check_all'] = $this->db->get('perumahan')->result();
                // $data['edit_perumahan'] = $this->db->get_where('perumahan', array('id_perumahan'=>$id))->result();
                $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));
    
                // $this->load->view('perumahan', $data);
                redirect('Dashboard/edit_view_perumahan?id='.$id);
            }
            else {
                $upload = array('upload_data' => $this->upload->data());
                
                if($old != ""){
                    unlink("gambar/".$old);
                }
                // foreach($upload['upload_data']['file_name'] as $item){
                //     $file_name = $item->file_name;
                // }
                // print_r($upload['upload_data']['file_name']);
                // print_r($file_name);
                // exit;
                $file_name = $upload['upload_data']['file_name'];
                
                $data = array(
                    'kode_perumahan' => $kode_perumahan,
                    'nama_perumahan' => $nama_perumahan,
                    'nama_perusahaan' => $nama_perusahaan,
                    'kode_perusahaan' => $kode_perusahaan,
                    'nama_jalan' => $nama_jalan,
                    'RT' => $RT,
                    'RW' => $RW,
                    'kecamatan' => $kecamatan,
                    'kabupaten' => $kabupaten,
                    'provinsi' => $provinsi,
                    // 'tipe_perusahaan' => $tipe_perusahaan,
                    'telp' => $telp,
                    'keterangan' => $keterangan,
                    'shm_induk' => $shm_induk,
                    'created_by' => $created_by,
                    'id_created_by' => $created_by_id,
                    'date_by' => $date_by,
                    'siteplan' => $file_name
                );
    
                $this->db->update('perumahan', $data, array('id_perumahan'=>$id));
    
                $data['nama'] = $this->session->userdata('nama');
                $data['edit_perumahan'] = $this->db->get_where('perumahan', array('id_perumahan'=>$id))->result();
    
                $data['check_all'] = $this->db->get('perumahan')->result();
    
                $data['succ_msg'] = "Data sukses di ubah";
                $this->session->set_flashdata('succ_msg', "Data sukses di ubah");
    
                redirect('Dashboard/edit_view_perumahan?id='.$id);
            }
        } else {
            $data = array(
                'kode_perumahan' => $kode_perumahan,
                'nama_perumahan' => $nama_perumahan,
                'nama_perusahaan' => $nama_perusahaan,
                'kode_perusahaan' => $kode_perusahaan,
                'nama_jalan' => $nama_jalan,
                'RT' => $RT,
                'RW' => $RW,
                'kecamatan' => $kecamatan,
                'kabupaten' => $kabupaten,
                'provinsi' => $provinsi,
                // 'tipe_perusahaan' => $tipe_perusahaan,
                'telp' => $telp,
                'keterangan' => $keterangan,
                'shm_induk' => $shm_induk,
                'created_by' => $created_by,
                'id_created_by' => $created_by_id,
                'date_by' => $date_by,
                'siteplan' => $old
            );

            $this->db->update('perumahan', $data, array('id_perumahan'=>$id));

            $data['nama'] = $this->session->userdata('nama');
            $data['edit_perumahan'] = $this->db->get_where('perumahan', array('id_perumahan'=>$id))->result();

            $data['check_all'] = $this->db->get('perumahan')->result();

            $data['succ_msg'] = "Data sukses di ubah";

            redirect('Dashboard/edit_view_perumahan?id='.$id);
        }

        // redirect('Dashboard/perumahan_management');
    }

    public function hapus_perumahan(){
        $id=$_GET['id'];

        $this->db->delete('perumahan', array('id_perumahan'=>$id));

        redirect('Dashboard/perumahan_management');
    }
    
    //START OF RUMAH

    public function rumah_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('rumah');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('rumah', $data);
    }

    public function filter_rumah_management(){
        $kode = $_POST['perumahan'];
        
        $data['nama'] = $this->session->userdata('nama');
        $data['kode'] = $kode;

        if($kode==""){
            $data['check_all'] = $this->db->get('rumah');
        } else {
            $data['check_all'] = $this->db->get_where('rumah', array('kode_perumahan'=>$kode));
        }

        $this->load->view('rumah', $data);
    }

    public function get_perumahan(){
        $category = $_POST["country"];
        // $id = $_GET['id'];

        // Define country and city array
        // $this->db->order_by('kode_rumah', 'ASC');
        $query = $this->db->get_where('perumahan', array('kode_perusahaan'=>$category))->result();
        // print_r($query);
        // exit;

        // Display city dropdown based on country name
        if($category !== 'Select'){
            // echo "<label>City:</label>";
            // echo "<select>";
            echo "<option value='' disabled selected>-Pilih-</option>";
            foreach($query as $value){
                echo "<option value='".$value->nama_perumahan."'>".$value->nama_perumahan."</option>";
            }
            // echo "</select>";
        } 
    }

    public function add_rumah(){
        // $kota = $_POST['kota'];
        // $kode_perusahaan = $_POST['kode_perusahaan'];
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $kode_perumahan = "";
        $nama_perumahan = $_POST['nama_perumahan'];
        $kode_rumah = $_POST['kode_rumah'];
        $no_unit = $_POST['kode_rumah'];
        $tipe_rumah = $_POST['tipe_rumah'];
        $harga_jual = $_POST['harga_jual'];
        $luas_tanah = $_POST['luas_tanah'];
        $luas_bangunan = $_POST['luas_bangunan'];
        $status = $_POST['status'];
        $created_by = $this->session->userdata('nama');
        $created_by_id = $this->session->userdata('u_id');
        $date_by = date('Y-m-d H:i:sa am/pm');
        $no_shm = $_POST['no_shm'];
        $no_pbb = $_POST['no_pbb'];
        $tipe_produk = $_POST['tipe_produk'];
        $jumlah_rumah = $_POST['jumlah_rumah'];
        $budget_bahan = $_POST['budget_bahan'];
        $budget_upah = $_POST['budget_upah'];
        $keterangan = $_POST['keterangan'];
        $nama_pemilik = $_POST['nama_pemilik'];
        $hp_pemilik = $_POST['hp_pemilik'];
        $status_tinggal = $_POST['status_tinggal'];

        // echo $nama_perusahaan;
        // exit;

        $query = $this->db->get_where('perumahan', array('nama_perumahan'=>$nama_perumahan))->result();
        foreach($query as $row){
            $kode_perumahan = $row->kode_perumahan;
        }
        $query2 = $this->db->get_where('perusahaan', array('kode_perusahaan'=>$nama_perusahaan))->result();
        foreach($query2 as $row2){
            $kota = $row2->nama_kota;
            $kode_perusahaan = $row2->nama_perusahaan;
        }

        $awal = 1;
        $this->db->like('kode_rumah', $kode_rumah);
        $this->db->order_by('kode_rumah', "DESC");
        $this->db->limit(1);
        $query3 = $this->db->get_where('rumah', array('kode_perumahan'=>$kode_perumahan, 'tipe_produk'=>$tipe_produk));
        foreach($query3->result() as $row3){
            preg_match_all('!\d+!', $row3->kode_rumah, $matches);
            $awal = $matches[0][0] + 1;
        }
        // $not = (int)$awal[0] + $jumlah_rumah;
        // echo $not; 
        // echo $awal[0]; exit;
        // print_r($query3->result());
        // exit;
        
        if($this->db->get_where('rumah', array('kode_rumah'=>$kode_rumah, 'kode_perumahan'=>$kode_perumahan))->num_rows() > 0){
            $data['nama'] = $this->session->userdata('nama');

            $data['check_all'] = $this->db->get('rumah');

            $data['err_msg'] = "Data sudah ada";

            $this->session->set_flashdata('err_msg', "Data sudah ada");
    
            // $this->load->view('rumah', $data);
            redirect('Dashboard/rumah_management');
        } else {
            for($i = (int)$awal; $i < ((int)$awal + $jumlah_rumah); $i++){
                $data = array(
                    'kota' => $kota,
                    'kode_perusahaan' => $kode_perusahaan,
                    'nama_perusahaan' => $nama_perusahaan,
                    'kode_perumahan' => $kode_perumahan,
                    'nama_perumahan' => $nama_perumahan,
                    'kode_rumah' => $kode_rumah.$i,
                    'no_unit' => $no_unit,
                    'tipe_rumah' => $tipe_rumah,
                    'harga_jual' => $harga_jual,
                    'luas_tanah' => $luas_tanah,
                    'luas_bangunan' => $luas_bangunan,
                    'status' => $status,
                    'created_by' => $created_by,
                    'id_created_by' => $created_by_id,
                    'date_by' => $date_by,
                    'no_shm' => $no_shm,
                    'no_pbb' => $no_pbb,
                    'tipe_produk' => $tipe_produk,
                    'budget_bahan' => $budget_bahan,
                    'budget_upah' => $budget_upah,
                    'keterangan' => $keterangan,
                    'nama_pemilik' => $nama_pemilik,
                    'hp_pemilik' => $hp_pemilik,
                    'status_tinggal' => $status_tinggal
                );
        
                $this->db->insert('rumah', $data);
            }
    
            $data['nama'] = $this->session->userdata('nama');
    
            $data['check_all'] = $this->db->get('rumah');
    
            $data['succ_msg'] = "Data sukses ditambahkan";
            
            $this->session->set_flashdata('succ_msg', "Data sukses ditambahkan");
    
            // $this->load->view('rumah', $data);
            redirect('Dashboard/rumah_management');
        }
    }

    public function edit_view_rumah(){
        $id = $_GET['id'];

        $data['edit_rumah'] = $this->db->get_where('rumah', array('id_rumah'=>$id))->result();

        // print_r($data['edit_rumah']);
        // exit;

        $data['check_all'] = $this->db->get('rumah');

        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('rumah', $data);
    }

    public function edit_rumah(){
        $id = $_POST['id_rumah'];
        // $kota = $_POST['kota'];
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $nama_perumahan = $_POST['nama_perumahan'];
        $kode_rumah = $_POST['kode_rumah'];
        $no_unit = $_POST['kode_rumah'];
        $tipe_rumah = $_POST['tipe_rumah'];
        $harga_jual = $_POST['harga_jual'];
        $luas_tanah = $_POST['luas_tanah'];
        $luas_bangunan = $_POST['luas_bangunan'];
        $status = $_POST['status'];
        $no_shm = $_POST['no_shm'];
        $no_pbb = $_POST['no_pbb'];
        $tipe_produk = $_POST['tipe_produk'];
        $budget_bahan = $_POST['budget_bahan'];
        $budget_upah = $_POST['budget_upah'];
        $keterangan = $_POST['keterangan'];
        $nama_pemilik = $_POST['nama_pemilik'];
        $hp_pemilik = $_POST['hp_pemilik'];
        $status_tinggal = $_POST['status_tinggal'];

        $query = $this->db->get_where('perumahan', array('nama_perumahan'=>$nama_perumahan))->result();
        foreach($query as $row){
            $kode_perumahan = $row->kode_perumahan;
        }
        $query2 = $this->db->get_where('perusahaan', array('nama_perusahaan'=>$nama_perusahaan))->result();
        foreach($query2 as $row2){
            $kota = $row2->nama_kota;
            $kode_perusahaan = $row2->kode_perusahaan;
        }
        // print_r($query2);
        // exit;

        $data = array(
            'kota' => $kota,
            'kode_perusahaan' => $nama_perusahaan,
            'nama_perusahaan' => $kode_perusahaan,
            'kode_perumahan' => $kode_perumahan,
            'nama_perumahan' => $nama_perumahan,
            'kode_rumah' => $kode_rumah,
            'no_unit' => $no_unit,
            'tipe_rumah' => $tipe_rumah,
            'harga_jual' => $harga_jual,
            'luas_tanah' => $luas_tanah,
            'luas_bangunan' => $luas_bangunan,
            'status' => $status,
            'no_shm' => $no_shm,
            'no_pbb' => $no_pbb,
            'tipe_produk' => $tipe_produk,
            'budget_bahan'=>$budget_bahan,
            'budget_upah'=>$budget_upah,
            'keterangan'=>$keterangan,
            'nama_pemilik' => $nama_pemilik,
            'hp_pemilik' => $hp_pemilik,
            'status_tinggal' => $status_tinggal
        );

        $this->db->update('rumah', $data, array('id_rumah'=>$id));

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('rumah');

        $data['succ_msg'] = "Data sukses diubah";

        // $this->load->view('rumah', $data);
        redirect('Dashboard/edit_view_rumah?id='.$id);
    }

    public function edit_rumah_all(){
        $id_rumah = $_POST['id_rumah'];
        $kode_rumah = $_POST['kode_rumah'];
        $tipe_rumah = $_POST['tipe_rumah'];
        $luas_tanah = $_POST['luas_tanah'];
        $luas_bangunan = $_POST['luas_bangunan'];
        $harga_jual = $_POST['harga_jual'];
        $mulai_proyek = $_POST['mulai_proyek'];
        $selesai_proyek = $_POST['selesai_proyek'];
        $budget_bahan = $_POST['budget_bahan'];
        $budget_upah = $_POST['budget_upah'];
        $keterangan = $_POST['keterangan'];
        $nama_pemilik = $_POST['nama_pemilik'];
        $hp_pemilik = $_POST['hp_pemilik'];
        $status_tinggal = $_POST['status_tinggal'];

        // print_r($status_tinggal);
        // exit;

        for($i = 0; $i < count($id_rumah); $i++){
            $data = array(
                'tipe_rumah'=>$tipe_rumah[$i],
                'kode_rumah'=>$kode_rumah[$i],
                'no_unit'=>$kode_rumah[$i],
                'luas_tanah'=>$luas_tanah[$i],
                'luas_bangunan'=>$luas_bangunan[$i],
                'harga_jual'=>$harga_jual[$i],
                'mulai_proyek'=>$mulai_proyek[$i],
                'selesai_proyek'=>$selesai_proyek[$i],
                'budget_bahan'=>$budget_bahan[$i],
                'budget_upah'=>$budget_upah[$i],
                'keterangan'=>$keterangan[$i],
                'nama_pemilik'=>$nama_pemilik[$i],
                'hp_pemilik'=>$hp_pemilik[$i],
                'status_tinggal' => $status_tinggal[$i],
                'rev_by'=>$this->session->userdata('nama'),
                'rev_date'=>date('Y-m-d H:i:sa am/pm')
            );

            $this->db->update('rumah', $data, array('id_rumah'=>$id_rumah[$i]));
        }

        redirect('Dashboard/rumah_management');
    }

    public function hapus_rumah(){
        $id=$_GET['id'];

        $this->db->delete('rumah', array('id_rumah'=>$id));

        redirect('Dashboard/rumah_management');
    }
    //END OF RUMAH

    //START OF SITEPLAN
    //
    //
    //
    //
    public function siteplan_view(){
        $data['perumahan'] = $this->db->get('perumahan')->result();

        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('siteplan', $data);
    }

    //END OF SITEPLAN

    //START OF NOTARIS
    public function notaris_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('notaris')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('notaris', $data);
    }

    public function add_notaris(){
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $telp = $_POST['telp'];
        $fax = $_POST['fax'];
        $hp = $_POST['hp'];
        $email = $_POST['email'];

        $data = array(
            'nama_notaris'=>$nama,
            'alamat_notaris'=>$alamat,
            'telp_notaris'=>$telp,
            'fax_notaris'=>$fax,
            'hp_notaris'=>$hp,
            'email_notaris'=>$email,
            'created_by'=>$this->session->userdata('nama'),
            'date_by'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->insert('notaris', $data);

        $this->session->set_flashdata('succ_msg', "Data berhasil dimasukkan!");

        redirect('Dashboard/notaris_management');
    }

    public function edit_view_notaris(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_notaris'] = $this->db->get_where('notaris', array('id_notaris'=>$id))->result();
        $data['check_all'] = $this->db->get('notaris')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $data['id'] = $id;

        $this->load->view('notaris', $data);
    }

    public function edit_notaris(){
        $id = $_POST['id'];

        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $telp = $_POST['telp'];
        $fax = $_POST['fax'];
        $hp = $_POST['hp'];
        $email = $_POST['email'];

        $data = array(
            'nama_notaris'=>$nama,
            'alamat_notaris'=>$alamat,
            'telp_notaris'=>$telp,
            'fax_notaris'=>$fax,
            'hp_notaris'=>$hp,
            'email_notaris'=>$email,
            'rev_by'=>$this->session->userdata('nama'),
            'rev_date'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('notaris', $data, array('id_notaris'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil diupdate!");

        redirect('Dashboard/edit_view_notaris?id='.$id);
    }

    public function hapus_notaris(){
        $id = $_GET['id'];

        $this->db->delete('notaris', array('id_notaris'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil dihapus!");

        redirect('Dashboard/notaris_management');
    }
    //END OF NOTARIS

    //START OF SUB KONTRAKTOR
    public function sub_kon_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('sub_kon')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('sub_kon', $data);
    }

    public function add_sub_kon(){
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $pekerjaan = $_POST['pekerjaan'];
        $ktp = $_POST['ktp'];

        $data = array(
            'nama_sub'=>$nama,
            'alamat_sub'=>$alamat,
            'pekerjaan_sub'=>$pekerjaan,
            'ktp_sub'=>$ktp,
            'created_by'=>$this->session->userdata('nama'),
            'date_by'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->insert('sub_kon', $data);

        $this->session->set_flashdata('succ_msg', "Data berhasil dimasukkan!");

        redirect('Dashboard/sub_kon_management');
    }

    public function edit_view_sub_kon(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_sub_kon'] = $this->db->get_where('sub_kon', array('id_sub_kon'=>$id))->result();
        $data['check_all'] = $this->db->get('sub_kon')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $data['id'] = $id;

        $this->load->view('sub_kon', $data);
    }

    public function edit_sub_kon(){
        $id = $_POST['id'];

        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $pekerjaan = $_POST['pekerjaan'];
        $ktp = $_POST['ktp'];

        $data = array(
            'nama_sub'=>$nama,
            'alamat_sub'=>$alamat,
            'pekerjaan_sub'=>$pekerjaan,
            'ktp_sub'=>$ktp,
            'rev_by'=>$this->session->userdata('nama'),
            'rev_date'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('sub_kon', $data, array('id_sub_kon'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil diupdate!");

        redirect('Dashboard/edit_view_sub_kon?id='.$id);
    }

    public function hapus_sub_kon(){
        $id = $_GET['id'];

        $this->db->delete('sub_kon', array('id_sub_kon'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil dihapus!");

        redirect('Dashboard/notaris_management');
    }
    //END OF SUB KONTRAKTOR
    
    //START OF PSJB
    //
    //
    //
    //

    public function psjb(){
        $data['nama'] = $this->session->userdata('nama');

        $data['u_id'] = $this->session->userdata('u_id');

        $data['role'] = $this->session->userdata('role');

        $data['check_all'] = $this->db->get('rumah');

        $this->load->view('psjb', $data);
    }

    public function get_psjb_rumah(){
        $category = $_POST["country"];

        // Define country and city array
        $this->db->order_by('kode_rumah', 'ASC');
        $query = $this->db->get_where('rumah', array('kode_perumahan'=>$category, 'tipe_produk'=>"rumah", 'status'=>"free"))->result();

        // Display city dropdown based on country name
        if($category !== 'Select'){
            // echo "<label>City:</label>";
            // echo "<select>";
            // echo "<option value='' disabled selected>-Pilih-</option>";
            foreach($query as $value){
                echo "<input type='checkbox' name='id_kavling[]' value=".$value->kode_rumah.">"." ".$value->kode_rumah."-".$value->nama_perumahan." <br>";
            }
            // echo "</select>";
        } 
    }

    public function daftar_kwitansi_bfee(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('psjb');

        $data['check_all2'] = $this->db->get_where('ppjb', array('tipe_produk'=>"kavling"));

        $this->load->view('marketing_kwitansi_bfee', $data);
    }

    public function filter_daftar_kwitansi_bfee(){
        $kode_perumahan = $_POST['perumahan'];
        
        $data['nama'] = $this->session->userdata('nama');

        if($kode_perumahan != ""){
            $this->db->where('kode_perumahan', $kode_perumahan);
        }
        $data['check_all'] = $this->db->get('psjb');

        if($kode_perumahan != ""){
            $this->db->where('kode_perumahan', $kode_perumahan);
        }
        $data['check_all2'] = $this->db->get_where('ppjb', array('tipe_produk'=>"kavling"));

        $data['k_perumahan'] = $kode_perumahan;

        $this->load->view('marketing_kwitansi_bfee', $data);
    }

    public function print_kwitansi_bfee(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $kav = $_GET['kav'];

        if($kav=="rumah"){
            $data['check_all'] = $this->db->get_where('psjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode));
            $data['out'] = $this->session->userdata('nama');
        }
        else {
            $data['check_all'] = $this->db->get_where('ppjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode));
            $data['out'] = $this->session->userdata('nama');
        }
        
        $this->load->library('pdf');
            
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-bfee.pdf";
        ob_end_clean();
        $this->pdf->load_view('psjb_print_bfee', $data);
    }

    // public function print_kwitansi_bfee

    public function add_psjb(){
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $sistem_pembayaran = $_POST['cara_pembayaran'];
        $nama_marketing = $_POST['nama_marketing'];
        $tgl_psjb = date("Y-m-d");
        $tgl_bfee = $_POST['tgl_bfee'];
        $nama_pemesan = $_POST['nama_pemesan'];
        $nama_sertif = $_POST['nama_sertif'];
        $alamat_lengkap = $_POST['alamat_lengkap'];
        $alamat_surat = $_POST['alamat_surat'];
        $telp_rumah = $_POST['no_telp'];
        $telp_hp = $_POST['no_hp'];
        $ktp = $_POST['ktp'];
        $uang_awal = $_POST['uang_awal'];
        $perumahan = $_POST['nama_perumahan'];
        $kavling = $_POST['id_kavling'];
        $tipe_rumah = $_POST['tipe_standart'];
        $harga_jual = $_POST['harga_jual_standart'];
        $disc_jual = $_POST['diskon_penjualan'];
        $total_jual = $_POST['total_penjualan'];
        $created_by = $this->session->userdata('nama');
        $created_by_id = $this->session->userdata('u_id');
        $role = $this->session->userdata('role');
        $date_by = date("Y-m-d H:i:sa am/pm");
        $pimpinan = "menunggu";
        $status = "tutup";
        $luas_tanah = $_POST['luas_tanah'];
        $luas_bangunan = $_POST['luas_bangunan'];

        $kode_perumahan = "";
        $query = $this->db->get_where('perumahan', array('nama_perumahan'=>$perumahan));

        foreach($query->result() as $row){
            $kode_perumahan = $row->kode_perumahan;
        }

        $persen_dp = $_POST['persenDP'];
        $tgl_dp = $_POST['tglDP'];
        $cara_dp = $_POST['caraDP'];
        $jumlah_dp = $_POST['lamaDP'];
        $total_dp = $_POST['totalDP'];
        $tgl_kpr = $_POST['tglKPR'];
        $total_kpr = $_POST['totalKPR'];
        $lama_tempo = $_POST['lama_tempo'];
        $catatan_pembayaran = $_POST['catatan'];
        $lama_cash = $_POST['lama_cash'];
        $bank_awal = $_POST['bank_awal'];
        $hadap_timur = $_POST['hadap_timur'];
        $pekerjaan = $_POST['pekerjaan'];

        $tipe_produk = $_POST['tipe_produk'];
        $cara_pembayaran = $_POST['jenis_pembayaran'];
        $persenDP_selector = $_POST['persenDP_selector'];
        $persen_bunga = $_POST['persen_bunga'];
        $npwp = $_POST['npwp'];
        $email = $_POST['email'];

        if($bank_awal != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank_awal))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $no_psjb = 1;
        $check_data = $this->Dashboard_model->check_last_record($kode_perumahan);
        foreach($check_data as $row){
            $no_psjb = $row->no_psjb + 1;
        }
        
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='booking_fee_'.$no_psjb.$kode_perumahan.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_kwitansi_bfee?id=".$no_psjb."&kav=".$tipe_produk."&kode=".$kode_perumahan; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        // echo $no_psjb;
        // exit;
        // echo $nama_perusahaan;
        // exit;
        
        $result = $kavling;
        // $result_explode = explode(',', $result);
        $tags = preg_split('/,/', $result, -1, PREG_SPLIT_NO_EMPTY);
        // print_r($tags);
        // print_r($result_explode);
        // exit;

        if($bank_awal != ""){
            $data = array(
                'no_psjb' => $no_psjb,
                'sistem_pembayaran' => $sistem_pembayaran,
                'nama_marketing' => $nama_marketing,
                'tgl_psjb' => $tgl_psjb,
                'nama_pemesan' => $nama_pemesan,
                'nama_sertif' => $nama_sertif,
                'alamat_lengkap' => $alamat_lengkap,
                'alamat_surat' => $alamat_surat,
                'telp_rumah' => $telp_rumah,
                'telp_hp' => $telp_hp,
                'ktp' => $ktp,
                'uang_awal' => $uang_awal,
                'kode_perumahan' => $kode_perumahan,
                'perumahan' => $perumahan,
                'no_kavling' => $tags[0],
                'tipe_rumah' => $tipe_rumah,
                'harga_jual' => $harga_jual,
                'disc_jual' => $disc_jual,
                'total_jual' => $total_jual,
                'created_by' => $created_by,
                'id_created_by' => $created_by_id,
                'date_by' => $date_by,
                'pimpinan' => $pimpinan,
                'status' => $status,
                'persen_dp' => $persen_dp,
                'tgl_dp' => $tgl_dp,
                'cara_dp' => $cara_dp,
                'jumlah_dp' => $jumlah_dp,
                'total_dp' => $total_dp,
                'tgl_kpr' => $tgl_kpr,
                'total_kpr' => $total_kpr,
                'kode_perusahaan' => $nama_perusahaan,
                'role' => $role,
                'luas_tanah' => $luas_tanah,
                'luas_bangunan' => $luas_bangunan,
                'lama_tempo' => $lama_tempo,
                'catatan' => $catatan_pembayaran,
                'lama_cash' => $lama_cash,
                'id_bank' => $bank_awal,
                'nama_bank' => $nama_bank,
                'hadap_timur' => $hadap_timur,
                'pekerjaan' => $pekerjaan,
                'tipe_produk' => $tipe_produk,
                'cara_pembayaran' => $cara_pembayaran,
                'persenDP_selector'=>$persenDP_selector,
                'persen_bunga'=>$persen_bunga,
                'npwp'=>$npwp,
                'email'=>$email,
                'qr_code'=>$image_name
            );
        } else {
            $data = array(
                'no_psjb' => $no_psjb,
                'sistem_pembayaran' => $sistem_pembayaran,
                'nama_marketing' => $nama_marketing,
                'tgl_psjb' => $tgl_psjb,
                'nama_pemesan' => $nama_pemesan,
                'nama_sertif' => $nama_sertif,
                'alamat_lengkap' => $alamat_lengkap,
                'alamat_surat' => $alamat_surat,
                'telp_rumah' => $telp_rumah,
                'telp_hp' => $telp_hp,
                'ktp' => $ktp,
                'uang_awal' => $uang_awal,
                'kode_perumahan' => $kode_perumahan,
                'perumahan' => $perumahan,
                'no_kavling' => $tags[0],
                'tipe_rumah' => $tipe_rumah,
                'harga_jual' => $harga_jual,
                'disc_jual' => $disc_jual,
                'total_jual' => $total_jual,
                'created_by' => $created_by,
                'id_created_by' => $created_by_id,
                'date_by' => $date_by,
                'pimpinan' => $pimpinan,
                'status' => $status,
                'persen_dp' => $persen_dp,
                'tgl_dp' => $tgl_dp,
                'cara_dp' => $cara_dp,
                'jumlah_dp' => $jumlah_dp,
                'total_dp' => $total_dp,
                'tgl_kpr' => $tgl_kpr,
                'total_kpr' => $total_kpr,
                'kode_perusahaan' => $nama_perusahaan,
                'role' => $role,
                'luas_tanah' => $luas_tanah,
                'luas_bangunan' => $luas_bangunan,
                'lama_tempo' => $lama_tempo,
                'catatan' => $catatan_pembayaran,
                'lama_cash' => $lama_cash,
                // 'id_bank' => $bank_awal,
                // 'nama_bank' => $nama_bank,
                'hadap_timur' => $hadap_timur,
                'pekerjaan' => $pekerjaan,
                'tipe_produk' => $tipe_produk,
                'cara_pembayaran' => $cara_pembayaran,
                'persenDP_selector'=>$persenDP_selector,
                'persen_bunga'=>$persen_bunga,
                'npwp'=>$npwp,
                'email'=>$email,
                'qr_code'=>$image_name
            );
        }

        $this->db->insert('psjb', $data);

        $data2 = array(
            'status' => "psjb",
            'nama_pemilik'=>$nama_pemesan,
            'hp_pemilik'=>$telp_hp
        );

        $this->db->update('rumah', $data2, array('kode_rumah' => $tags[0], 'kode_perumahan'=>$kode_perumahan));

        for($x=1; $x < count($tags); $x++){
            $data7 = array(
                'status' => "psjb",
                'no_psjb' => $no_psjb,
                'nama_pemilik'=>$nama_pemesan,
                'hp_pemilik'=>$telp_hp
            );
    
            $this->db->update('rumah', $data7, array('kode_rumah' => $tags[$x], 'kode_perumahan'=>$kode_perumahan));
        }

        if($uang_awal != 0){
            if($bank_awal != ""){
                $data3 = array(
                    'id_penerimaan'=>$no_psjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tgl_bfee,
                    'kategori'=>"booking fee",
                    'keterangan'=>"Booking Fee -".$nama_pemesan,
                    'terima_dari'=>$nama_pemesan,
                    'nominal_bayar'=>$uang_awal,
                    'cara_pembayaran'=>$cara_pembayaran,
                    'id_bank'=>$bank_awal,
                    'nama_bank'=>$nama_bank,
                    'date_created'=>$date_by,
                    'id_created_by'=>$created_by_id,
                    'created_by'=>$created_by
                );
            } else {
                $data3 = array(
                    'id_penerimaan'=>$no_psjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tgl_bfee,
                    'kategori'=>"booking fee",
                    'keterangan'=>"Booking Fee -".$nama_pemesan,
                    'terima_dari'=>$nama_pemesan,
                    'nominal_bayar'=>$uang_awal,
                    'cara_pembayaran'=>$cara_pembayaran,
                    // 'id_bank'=>$bank_awal,
                    // 'nama_bank'=>$nama_bank,
                    'date_created'=>$date_by,
                    'id_created_by'=>$created_by_id,
                    'created_by'=>$created_by
                );
            }

            $this->db->insert('keuangan_akuntansi', $data3);
        } else {
            if($bank_awal != ""){
                $data3 = array(
                    'id_penerimaan'=>$no_psjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tgl_bfee,
                    'kategori'=>"booking fee",
                    'keterangan'=>"Booking Fee -".$nama_pemesan,
                    'terima_dari'=>$nama_pemesan,
                    'nominal_bayar'=>$uang_awal,
                    'cara_pembayaran'=>$cara_pembayaran,
                    'id_bank'=>$bank_awal,
                    'nama_bank'=>$nama_bank,
                    'date_created'=>$date_by,
                    'id_created_by'=>$created_by_id,
                    'created_by'=>$created_by
                );
            } else {
                $data3 = array(
                    'id_penerimaan'=>$no_psjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tgl_bfee,
                    'kategori'=>"booking fee",
                    'keterangan'=>"Booking Fee -".$nama_pemesan,
                    'terima_dari'=>$nama_pemesan,
                    'nominal_bayar'=>$uang_awal,
                    'cara_pembayaran'=>$cara_pembayaran,
                    // 'id_bank'=>$bank_awal,
                    // 'nama_bank'=>$nama_bank,
                    'date_created'=>$date_by,
                    'id_created_by'=>$created_by_id,
                    'created_by'=>$created_by
                );
            }

            $this->db->insert('keuangan_akuntansi', $data3);
        }

        if($sistem_pembayaran == "KPR"){
            $data5 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_bfee,
                'dana_masuk' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('psjb-dp', $data5);

            if($cara_dp == "cicil"){
                $perbulan = $total_dp / $jumlah_dp;

                $time = strtotime($tgl_dp);

                for($x = 1; $x <= $jumlah_dp; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    if($persenDP_selector == "manual"){
                        $data2 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                            'persen' => $persen_dp,
                            'tanggal_dana' => $date,
                            'dana_masuk' => $perbulan,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );

                        $this->db->insert('psjb-dp', $data2);
                    } else {
                        $data2 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP ke-".$x,
                            'persen' => $persen_dp,
                            'tanggal_dana' => $date,
                            'dana_masuk' => $perbulan,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );

                        $this->db->insert('psjb-dp', $data2);
                    }
                }
            }else{
                if($persenDP_selector == "manual"){
                    $data4 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                        'persen' => $persen_dp,
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
                    $this->db->insert('psjb-dp', $data4);
                } else {
                    $data4 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP",
                        'persen' => $persen_dp,
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
                    $this->db->insert('psjb-dp', $data4);
                }
            }
            $data3 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => $sistem_pembayaran,
                'tanggal_dana' => $tgl_kpr,
                'dana_masuk' => $total_kpr,
                'status' => "belum lunas",
                'kode_perumahan' => $kode_perumahan
            );

            $this->db->insert('psjb-dp', $data3);
        }
        else if($sistem_pembayaran == "Tempo"){
            $data5 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_bfee,
                'dana_masuk' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('psjb-dp', $data5);

            if($persen_dp == 0){
                if($cara_dp == "cicil"){
                    $perbulan = $total_dp / $jumlah_dp;
    
                    $time = strtotime($tgl_dp);
    
                    for($x = 1; $x <= $jumlah_dp; $x++){
                        $date = date('Y-m-d', $time);
                        $due_dates[] = $date;
                        // move to next timestamp
                        $time = strtotime('+1 month', $time);
    
                        if($persenDP_selector == "manual"){
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        } else {
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x,
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        }
                    }
                } else {
                    if($persenDP_selector == "manual"){
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP (0%)",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    } else {
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    }
                }
            } else {
                if($cara_dp == "cicil"){
                    $perbulan = $total_dp / $jumlah_dp;
    
                    $time = strtotime($tgl_dp);
    
                    for($x = 1; $x <= $jumlah_dp; $x++){
                        $date = date('Y-m-d', $time);
                        $due_dates[] = $date;
                        // move to next timestamp
                        $time = strtotime('+1 month', $time);
    
                        if($persenDP_selector == "manual"){
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        } else {
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x,
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        }
                    }
                } else {
                    if($persenDP_selector == "manual"){
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    } else {
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    }
                }
            }

            if($lama_tempo == 24){
                $perbulan = $total_kpr / $lama_tempo;

                $perbulan1 = ($total_kpr+((($total_kpr*$persen_bunga)/100)*2))/24;

                $perbulan2 = (($total_kpr/24*12)+(($total_kpr/24*12*$persen_bunga)/100))/12;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= 12; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
                for($x = 13; $x <= 24; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan2,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            } else if($lama_tempo == 36){
                $perbulan = $total_kpr / $lama_tempo;

                $perbulan1 = ($total_kpr+((($total_kpr*$persen_bunga)/100)*3))/36;

                $perbulan2 = (($total_kpr/36*24)+(($total_kpr/36*24*($persen_bunga*2))/100))/24;

                $perbulan3 = (($total_kpr/36*12)+(($total_kpr/36*12*$persen_bunga)/100))/12;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= 12; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
                for($x = 13; $x <= 24; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan2,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
                for($x = 25; $x <= 36; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan3,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            } else {
                $perbulan = $total_kpr / $lama_tempo;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= $lama_tempo; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            }
        }
        else{
            $data5 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_bfee,
                'dana_masuk' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('psjb-dp', $data5);

            $perbulan1 = $total_kpr / $lama_cash;
            $perbulan = $total_dp / $jumlah_dp;

            $time = strtotime($tgl_kpr);
            $time2 = strtotime($tgl_kpr);

            if($cara_dp == "cash"){
                if($persenDP_selector == "manual"){
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                } else {
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP",
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            }else{
                for($x = 1; $x <= $jumlah_dp; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);
    
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
    
                    $this->db->insert('psjb-dp', $data2);
                }
            }

            if($lama_cash == 1){
                $date = date('Y-m-d', $time2);
                $due_dates[] = $date;
                // move to next timestamp
                $time2 = strtotime('+1 month', $time2);

                $data2 = array(
                    'no_psjb' => $no_psjb,
                    'cara_bayar' => "Pelunasan",
                    'tanggal_dana' => $tgl_kpr,
                    'dana_masuk' => $total_kpr,
                    'status' => "belum lunas",
                    'kode_perumahan' => $kode_perumahan
                );

                $this->db->insert('psjb-dp', $data2);
            } else {
                for($x = 1; $x <= $lama_cash; $x++){
                    $date = date('Y-m-d', $time2);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time2 = strtotime('+1 month', $time2);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pelunasan ke-".$x,
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            }
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('psjb');

        // $data['succ_msg'] = "Data sukses ditambahkan";

        // $this->load->view('psjb_management', $data);
        redirect('Dashboard/psjb_management');
    }

    public function get_kavling(){
        $category_id = $this->input->post('id_kavling',TRUE);
        $kode_perumahan = $this->input->post('kode_perumahan',TRUE);

        // print_r($category_id);
        // print_r($kode_perumahan);
        // exit;

        // $result = $_POST['id_kavling'];
        // $result_explode = explode('|', $result);
        $t_luas = 0; $t_tanah=0; $t_tipe=0; $t_harga=0;
        for($i=0; $i < count($category_id); $i++){
            $tes = $category_id[$i];

            $q1 = $this->Dashboard_model->get_kavling($category_id[$i], $kode_perumahan);
            foreach($q1 as $row1){
                $t_luas = $t_luas + $row1->luas_bangunan;
                $t_tanah = $t_tanah + $row1->luas_tanah;
                $t_tipe = $t_tipe + $row1->tipe_rumah;
                $t_harga = $t_harga + $row1->harga_jual;
            }
        }
        $data['luas_bangunan'] = $t_luas;
        $data['luas_tanah'] = $t_tanah;
        $data['tipe_rumah'] = $t_tipe;
        $data['harga_jual'] = $t_harga;

        // echo $data['kavling'];
        $no_kavling = $category_id;
        $kode_perumahan = $kode_perumahan;

        // print_r($category_id);
        // exit;

        $q = $this->Dashboard_model->get_kavling($tes, $kode_perumahan);
        foreach($q as $row){
            $data['kode_perusahaan'] = $row->nama_perusahaan;
            $data['tipe_produk'] = $row->tipe_produk;
            $data['nama_perumahan'] = $row->nama_perumahan;
        }
        $data['kavling'] = $no_kavling;

        // print_r($data['kavling']);
        // // echo $no_kavling;
        // exit;

        $data['nama'] = $this->session->userdata('nama');

        $data['u_id'] = $this->session->userdata('u_id');

        $data['role'] = $this->session->userdata('role');

        $data['check_all'] = $this->db->get('rumah');

        $data['no_kavling'] = $no_kavling;

        $data['kode_perumahan'] = $kode_perumahan;

        $this->load->view('psjb', $data);

        // echo json_encode($data);
    }

    public function tambah_unit_psjb(){
        $id = $_GET['id'];

        $data['psjbs'] = $this->db->get_where('psjb', array('id_psjb'=>$id))->result();
        // print_r($data['psjb']);
        // exit;

        foreach($data['psjbs'] as $row){
            $kode_perusahaan = $row->kode_perusahaan;
        }

        $data['psjb_perusahaan'] = $this->db->get_where('perusahaan', array('kode_perusahaan'=>$kode_perusahaan))->result();
        
        foreach($data['psjb_perusahaan'] as $row){
            $nama_perusahaan = $row->nama_perusahaan;
        }

        $data['nama_perusahaan'] = $nama_perusahaan;

        // print_r($data['nama_perusahaan']);

        // $data['kavling'] = $this->Dashboard_model->get_kavling($id_kavling)->result();
        // $data['no_psjb'] =$id;
        
        $data['nama'] = $this->session->userdata('nama');

        $data['u_id'] = $this->session->userdata('u_id');

        $data['role'] = $this->session->userdata('role');

        $this->load->view('psjb_tambah_unit', $data);
    }

    public function get_kavling_tambah_unit(){
        $category_id = $this->input->post('id_kavling',TRUE);
        $id=$_POST['id'];

        $data['psjbs'] = $this->db->get_where('psjb', array('id_psjb'=>$id))->result();

        foreach($data['psjbs'] as $row){
            $kode_perusahaan = $row->kode_perusahaan;
            $kode_perumahan = $row->kode_perumahan;
        }

        $data['psjb_perusahaan'] = $this->db->get_where('perusahaan', array('kode_perusahaan'=>$kode_perusahaan))->result();
        
        foreach($data['psjb_perusahaan'] as $row){
            $nama_perusahaan = $row->nama_perusahaan;
        }

        $data['nama_perusahaan'] = $nama_perusahaan;

        $data['kavling'] = $this->Dashboard_model->get_kavling($category_id, $kode_perumahan);

        $data['nama'] = $this->session->userdata('nama');

        $data['u_id'] = $this->session->userdata('u_id');

        $data['role'] = $this->session->userdata('role');

        $data['check_all'] = $this->db->get('rumah');

        $this->load->view('psjb_tambah_unit', $data);
    }

    public function add_tambah_unit_psjb(){
        $id_psjb = $_POST['id_psjb']; 
        $no_psjb = $_POST['no_psjb']; 
        // echo $id_psjb;
        // echo $no_psjb;
        // exit;
        
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $sistem_pembayaran = $_POST['cara_pembayaran'];
        $nama_marketing = $_POST['nama_marketing'];
        $tgl_psjb = date("Y-m-d");
        $nama_pemesan = $_POST['nama_pemesan'];
        $nama_sertif = $_POST['nama_sertif'];
        $alamat_lengkap = $_POST['alamat_lengkap'];
        $alamat_surat = $_POST['alamat_surat'];
        $telp_rumah = $_POST['no_telp'];
        $telp_hp = $_POST['no_hp'];
        $ktp = $_POST['ktp'];
        $uang_awal = $_POST['uang_awal'];
        $perumahan = $_POST['nama_perumahan'];
        $kavling = $_POST['id_kavling'];
        $tipe_rumah = $_POST['tipe_standart'];
        $harga_jual = $_POST['harga_jual_standart'];
        $disc_jual = $_POST['diskon_penjualan'];
        $total_jual = $_POST['total_penjualan'];
        $created_by = $this->session->userdata('nama');
        $created_by_id = $this->session->userdata('u_id');
        $role = $this->session->userdata('role');
        $date_by = date("Y-m-d H:i:sa am/pm");
        $pimpinan = "menunggu";
        $status = "tutup";
        $luas_tanah = $_POST['luas_tanah'];
        $luas_bangunan = $_POST['luas_bangunan'];

        $kode_perumahan = "";
        $query = $this->db->get_where('perumahan', array('nama_perumahan'=>$perumahan));

        foreach($query->result() as $row){
            $kode_perumahan = $row->kode_perumahan;
        }

        $persen_dp = $_POST['persenDP'];
        $tgl_dp = $_POST['tglDP'];
        $cara_dp = $_POST['caraDP'];
        $jumlah_dp = $_POST['lamaDP'];
        $total_dp = $_POST['totalDP'];
        $tgl_kpr = $_POST['tglKPR'];
        $total_kpr = $_POST['totalKPR'];
        $lama_tempo = $_POST['lama_tempo'];
        $catatan_pembayaran = $_POST['catatan'];
        $lama_cash = $_POST['lama_cash'];
        $persenDP_selector = $_POST['persenDP_selector'];
        $persen_bunga = $_POST['persen_bunga'];
        $npwp = $_POST['npwp'];
        $email = $_POST['email'];

        $data = array(
            // 'no_psjb' => $no_psjb,
            'sistem_pembayaran' => $sistem_pembayaran,
            'nama_marketing' => $nama_marketing,
            // 'tgl_psjb' => $tgl_psjb,
            'nama_pemesan' => $nama_pemesan,
            'nama_sertif' => $nama_sertif,
            'alamat_lengkap' => $alamat_lengkap,
            'alamat_surat' => $alamat_surat,
            'telp_rumah' => $telp_rumah,
            'telp_hp' => $telp_hp,
            'ktp' => $ktp,
            'uang_awal' => $uang_awal,
            // 'kode_perumahan' => $kode_perumahan,
            // 'perumahan' => $perumahan,
            // 'no_kavling' => $kavling,
            'tipe_rumah' => $tipe_rumah,
            'harga_jual' => $harga_jual,
            'disc_jual' => $disc_jual,
            'total_jual' => $total_jual,
            'created_by' => $created_by,
            'id_created_by' => $created_by_id,
            'date_by' => $date_by,
            'pimpinan' => $pimpinan,
            'status' => $status,
            'persen_dp' => $persen_dp,
            'tgl_dp' => $tgl_dp,
            'cara_dp' => $cara_dp,
            'jumlah_dp' => $jumlah_dp,
            'total_dp' => $total_dp,
            'tgl_kpr' => $tgl_kpr,
            'total_kpr' => $total_kpr,
            'kode_perusahaan' => $nama_perusahaan,
            'role' => $role,
            'luas_tanah' => $luas_tanah,
            'luas_bangunan' => $luas_bangunan,
            'lama_tempo' => $lama_tempo,
            'catatan' => $catatan_pembayaran,
            'lama_cash' => $lama_cash,
            'persenDP_selector'=>$persenDP_selector,
            'persen_bunga'=>$persen_bunga,
            'npwp'=>$npwp,
            'email'=>$email,
        );

        // $this->db->insert('psjb', $data);
        $this->db->update('psjb', $data, array('id_psjb'=>$id_psjb));

        $data2 = array(
            'status' => "psjb",
            'no_psjb' => $no_psjb
        );

        $this->db->update('rumah', $data2, array('kode_rumah' => $kavling, 'kode_perumahan'=>$kode_perumahan));

        $dt = array(
            // 'id_penerimaan'=>$no_psjb,
            // 'kode_perumahan'=>$kode_perumahan,
            'tanggal_dana'=>$tgl_psjb,
            'kategori'=>"booking fee",
            'keterangan'=>"Booking Fee -".$nama_pemesan,
            'terima_dari'=>$nama_pemesan,
            'nominal_bayar'=>$uang_awal,
            'cara_pembayaran'=>$sistem_pembayaran,
            // 'id_bank'=>$bank_awal,
            // 'nama_bank'=>$nama_bank,
            'date_created'=>$date_by,
            'id_created_by'=>$created_by_id,
            'created_by'=>$created_by
        );

        $this->db->update('keuangan_akuntansi', $dt, array('id_penerimaan'=>$no_psjb, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"booking fee"));


        $this->db->delete('psjb-dp', array('no_psjb'=>$no_psjb, 'kode_perumahan'=>$kode_perumahan));

        if($sistem_pembayaran == "KPR"){
            $data5 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('psjb-dp', $data5);

            if($cara_dp == "cicil"){
                $perbulan = $total_dp / $jumlah_dp;

                $time = strtotime($tgl_dp);

                for($x = 1; $x <= $jumlah_dp; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    if($persenDP_selector == "manual"){
                        $data2 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                            'persen' => $persen_dp,
                            'tanggal_dana' => $date,
                            'dana_masuk' => $perbulan,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );

                        $this->db->insert('psjb-dp', $data2);
                    } else {
                        $data2 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP ke-".$x,
                            'persen' => $persen_dp,
                            'tanggal_dana' => $date,
                            'dana_masuk' => $perbulan,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );

                        $this->db->insert('psjb-dp', $data2);
                    }
                }
            }else{
                if($persenDP_selector == "manual"){
                    $data4 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                        'persen' => $persen_dp,
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
                    $this->db->insert('psjb-dp', $data4);
                } else {
                    $data4 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP",
                        'persen' => $persen_dp,
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
                    $this->db->insert('psjb-dp', $data4);
                }
            }
            $data3 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => $sistem_pembayaran,
                'tanggal_dana' => $tgl_kpr,
                'dana_masuk' => $total_kpr,
                'status' => "belum lunas",
                'kode_perumahan' => $kode_perumahan
            );

            $this->db->insert('psjb-dp', $data3);
        }
        else if($sistem_pembayaran == "Tempo"){
            $data5 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('psjb-dp', $data5);

            if($persen_dp == 0){
                if($cara_dp == "cicil"){
                    $perbulan = $total_dp / $jumlah_dp;
    
                    $time = strtotime($tgl_dp);
    
                    for($x = 1; $x <= $jumlah_dp; $x++){
                        $date = date('Y-m-d', $time);
                        $due_dates[] = $date;
                        // move to next timestamp
                        $time = strtotime('+1 month', $time);
    
                        if($persenDP_selector == "manual"){
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        } else {
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x,
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        }
                    }
                } else {
                    if($persenDP_selector == "manual"){
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP (0%)",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    } else {
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    }
                }
            } else {
                if($cara_dp == "cicil"){
                    $perbulan = $total_dp / $jumlah_dp;
    
                    $time = strtotime($tgl_dp);
    
                    for($x = 1; $x <= $jumlah_dp; $x++){
                        $date = date('Y-m-d', $time);
                        $due_dates[] = $date;
                        // move to next timestamp
                        $time = strtotime('+1 month', $time);
    
                        if($persenDP_selector == "manual"){
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        } else {
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x,
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        }
                    }
                } else {
                    if($persenDP_selector == "manual"){
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    } else {
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    }
                }
            }

            if($lama_tempo == 24){
                $perbulan = $total_kpr / $lama_tempo;

                $perbulan1 = ($total_kpr+((($total_kpr*$persen_bunga)/100)*2))/24;

                $perbulan2 = (($total_kpr/24*12)+(($total_kpr/24*12*$persen_bunga)/100))/12;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= 12; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
                for($x = 13; $x <= 24; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan2,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            } else if($lama_tempo == 36){
                $perbulan = $total_kpr / $lama_tempo;

                $perbulan1 = ($total_kpr+((($total_kpr*$persen_bunga)/100)*3))/36;

                $perbulan2 = (($total_kpr/36*24)+(($total_kpr/36*24*($persen_bunga*2))/100))/24;

                $perbulan3 = (($total_kpr/36*12)+(($total_kpr/36*12*$persen_bunga)/100))/12;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= 12; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
                for($x = 13; $x <= 24; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan2,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
                for($x = 25; $x <= 36; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan3,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            } else {
                $perbulan = $total_kpr / $lama_tempo;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= $lama_tempo; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            }
        }
        else{
            $data5 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('psjb-dp', $data5);

            $perbulan1 = $total_kpr / $lama_cash;
            $perbulan = $total_dp / $jumlah_dp;

            $time = strtotime($tgl_kpr);
            $time2 = strtotime($tgl_kpr);

            if($cara_dp == "cash"){
                if($persenDP_selector == "manual"){
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                } else {
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP",
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            }else{
                for($x = 1; $x <= $jumlah_dp; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);
    
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
    
                    $this->db->insert('psjb-dp', $data2);
                }
            }

            if($lama_cash == 1){
                $date = date('Y-m-d', $time2);
                $due_dates[] = $date;
                // move to next timestamp
                $time2 = strtotime('+1 month', $time2);

                $data2 = array(
                    'no_psjb' => $no_psjb,
                    'cara_bayar' => "Pelunasan",
                    'tanggal_dana' => $tgl_kpr,
                    'dana_masuk' => $total_kpr,
                    'status' => "belum lunas",
                    'kode_perumahan' => $kode_perumahan
                );

                $this->db->insert('psjb-dp', $data2);
            } else {
                for($x = 1; $x <= $lama_cash; $x++){
                    $date = date('Y-m-d', $time2);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time2 = strtotime('+1 month', $time2);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pelunasan ke-".$x,
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            }
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('psjb');

        // $data['succ_msg'] = "Data sukses ditambahkan";

        // $this->load->view('psjb_management', $data);
        redirect('Dashboard/psjb_management');
    }

    public function psjb_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['role'] = $this->session->userdata('role');
        $data['u_id'] = $this->session->userdata('u_id');

        $data['k_perumahan'] = "";

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        
        $data['check_all'] = $this->db->get('psjb');
    
        // $data['succ_msg'] = "Data sukses ditambahkan";

        $this->load->view('psjb_management', $data);
    }

    public function app_psjb_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['role'] = $this->session->userdata('role');
        $data['u_id'] = $this->session->userdata('u_id');

        $data['k_perumahan'] = "";

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        
        $data['check_all'] = $this->db->get_where('psjb', array('status'=>"tutup"));
    
        // $data['succ_msg'] = "Data sukses ditambahkan";

        $this->load->view('psjb_management', $data);
    }

    public function f_psjb_management(){
        $data['check_all'] = $this->db->get_where('psjb', array('marketing_sign <>'=>"", 'konsumen_sign <>'=>""));

        $data['nama'] = $this->session->userdata('nama');
        $data['k_perumahan'] = "";

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('psjb_management', $data);
    }

    public function filter_psjb_management(){
        $kode = $_POST['perumahan'];
        $data['nama'] = $this->session->userdata('nama');

        $data['role'] = $this->session->userdata('role');
        $data['u_id'] = $this->session->userdata('u_id');

        if($kode == ""){
            $data['check_all'] = $this->db->get('psjb');
        } else {
            $data['check_all'] = $this->db->get_where('psjb', array('kode_perumahan'=>$kode));
        }
        $data['k_perumahan'] = $kode;
        // echo $data['k_perumahan'];
        // exit;

        $this->load->view('psjb_management', $data);
    }

    public function detail_psjb(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['id'] = $id;
        $data['kode'] = $kode;
        // print_r($kode);
        // exit;
        
        $data['psjb_detail'] = $this->db->get_where('psjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

        $this->db->order_by('id_psjb', 'ASC');
        $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

        $data['psjb_sb'] = $this->db->get_where('psjb_sendback', array('no_psjb'=>$id, 'kode_perumahan'=>$kode));

        if($data['psjb_sb']->num_rows() > 0){
            $data['psjb_sendback'] = $data['psjb_sb'];
        }

        // echo $data['psjb_sb']->num_rows();
        // exit;

        // print_r($data['psjb_detail']);
        // print_r($data['psjb_detail_dp']);
        // exit;

        $data['nama'] = $this->session->userdata('nama');

        foreach($data['psjb_detail'] as $row){
            if($row->status == "revisi"){
                echo "<script>
                    alert('PSJB tidak bisa di akses karena status masih di revisi!');
                    window.location.href='psjb_management';
                    </script>";
            } else {
                $this->load->view('psjb_detail', $data);
            }
        }

        // $data['psjb_detail'] = $this->db->get_where('psjb', array('no_psjb'=>$id))->result();

        // $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id))->result();

        // // print_r($data['psjb_detail']);
        // // print_r($data['psjb_detail_dp']);
        // // exit;

        // $data['nama'] = $this->session->userdata('nama');

        // $this->load->view('psjb_detail', $data);
    }

    public function detail_custom_biaya_psjb(){
        $id = $_GET['id'];
        $no_psjb = "";
        
        $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('id_psjb'=>$id))->result();
        foreach($data['psjb_detail_dp'] as $row){
            $no_psjb = $row->no_psjb;
        }

        $data['psjb_detail'] = $this->db->get_where('psjb', array('no_psjb'=>$no_psjb))->result();

        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('psjb_detail_biaya', $data);
    }

    public function update_detail_psjb(){
        $id = $_GET['id'];
        $no_psjb = "";
        
        $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('id_psjb'=>$id))->result();
        foreach($data['psjb_detail_dp'] as $row){
            $no_psjb = $row->no_psjb;
            $kode_perumahan = $row->kode_perumahan;
        }

        $data['psjb_detail'] = $this->db->get_where('psjb', array('no_psjb'=>$no_psjb,'kode_perumahan'=>$kode_perumahan))->result();

        $dana_sekarang = $_POST['dana_masuk'];

        $data = array(
            'dana_masuk'=>$dana_sekarang
        );

        $this->db->update('psjb-dp', $data, array('id_psjb'=>$id));
        
        $data['nama'] = $this->session->userdata('nama');

        // $this->load->view('psjb_detail_biaya', $data);
        redirect('Dashboard/detail_custom_biaya_psjb?id='.$id);
    }

    public function print_psjb(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $query = $this->db->get_where('psjb', array('no_psjb' => $id, 'kode_perumahan'=>$kode))->result();
        
        $this->db->order_by('id_psjb', "ASC");
        $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();
        // print_r($query);
        $data['check_all'] = $query;

        foreach($data['check_all'] as $row){
            if($row->status == "ppjb"){
                $this->load->library('pdf');
            
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "print-psjb.pdf";
                ob_end_clean();
                $this->pdf->load_view('psjb_print', $data);
            } else if($row->status == "dom"){
                $this->load->library('pdf');
            
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "print-psjb.pdf";
                ob_end_clean();
                $this->pdf->load_view('psjb_print', $data);
            } else{
                echo "<script>
                    alert('PSJB tidak bisa di akses karena belum di approve!');
                    window.location.href='psjb_management';
                    </script>";
            }
        }
        // $data = array(
        //     "dataku" => array(
        //         "nama" => "Petani Kode",
        //         "url" => "http://petanikode.com"
        //     )
        // );

        // print_r($data);
        // exit;
    
        // $dompdf->stream('my.pdf',array('Attachment'=>0));
    }

    public function psjb_approve(){
        if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager marketing"){
            $id = $_GET['id'];

            $data2 = array(
                'status' => "dom",
                'pimpinan' => $this->session->userdata('nama')
            );

            $this->db->update('psjb', $data2, array('id_psjb' => $id));

            // $data['nama'] = $this->session->userdata('nama');

            // $data['check_all'] = $this->db->get('psjb');

            // $data['succ_msg'] = "Data sukses ditambahkan";

            redirect('Dashboard/psjb_management');
        } else {
            echo "<script>
                alert('Anda tidak berhak untuk melakukan approve!');
                window.location.href='psjb_management';
                </script>";
        }
    }

    public function psjb_view_sendback(){
        if($this->session->userdata('role') != "superadmin"){
            echo "<script>
                alert('Anda tidak berhak untuk melakukan sendback!');
                window.location.href='psjb_management';
                </script>";
        }else{
            $id = $_GET['id'];
            $kode = $_GET['kode'];

            $data['psjb_detail'] = $this->db->get_where('psjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

            $this->db->order_by('id_psjb', "ASC");
            $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

            // print_r($data['psjb_detail']);
            // print_r($data['psjb_detail_dp']);
            // exit;

            $data['nama'] = $this->session->userdata('nama');

            $this->load->view('psjb_sendback', $data);
        }
    }

    public function psjb_sendback(){
        $id = $_GET['id'];
        $sendback = $_POST['sendback'];
        $created_by = $this->session->userdata('nama');
        $date_by = date("Y-m-d H:i:sa am/pm");
        // $no_psjb = $_POST['no_psjb'];
        $query = $this->db->get_where('psjb', array('id_psjb'=>$id));

        foreach($query->result() as $row){
            $no_psjb = $row->no_psjb;
            $kode_perumahan = $row->kode_perumahan;
        }

        $data2 = array(
            'catatan' => $sendback,
            'sendback_by' => $created_by,
            'sendback_date' => $date_by,
            'no_psjb' => $no_psjb,
            'kode_perumahan' => $kode_perumahan
        );

        $this->db->insert('psjb_sendback', $data2);

        $this->db->delete('psjb-dp', array('no_psjb'=>$no_psjb, 'kode_perumahan'=>$kode_perumahan));

        $data = array(
            'status' => "revisi"
        );

        $this->db->update('psjb', $data, array('no_psjb'=>$no_psjb, 'kode_perumahan'=>$kode_perumahan));

        redirect('Dashboard/psjb_management');
    }

    public function psjb_view_revisi(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');
        $data['role'] = $this->session->userdata('role');

        $data['psjb_revisi'] = $this->db->get_where('psjb', array('no_psjb'=>$id,'kode_perumahan'=>$kode))->result();
        
        foreach($data['psjb_revisi'] as $row){
            if($row->status == "revisi"){
                $this->load->view('psjb', $data);
            } else {
                echo "<script>
                alert('PSJB ini tidak berstatus untuk revisi!');
                window.location.href='psjb_management';
                </script>";
            }
        }
    }

    public function psjb_revisi(){
        $no_psjb = $_POST['no_psjb']; 
        
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $sistem_pembayaran = $_POST['cara_pembayaran'];
        $nama_marketing = $_POST['nama_marketing'];
        $tgl_psjb = date("Y-m-d");
        $nama_pemesan = $_POST['nama_pemesan'];
        $nama_sertif = $_POST['nama_sertif'];
        $alamat_lengkap = $_POST['alamat_lengkap'];
        $alamat_surat = $_POST['alamat_surat'];
        $telp_rumah = $_POST['no_telp'];
        $telp_hp = $_POST['no_hp'];
        $ktp = $_POST['ktp'];
        $uang_awal = $_POST['uang_awal'];
        $perumahan = $_POST['nama_perumahan'];
        $kavling = $_POST['id_kavling'];
        $tipe_rumah = $_POST['tipe_standart'];
        $harga_jual = $_POST['harga_jual_standart'];
        $disc_jual = $_POST['diskon_penjualan'];
        $total_jual = $_POST['total_penjualan'];
        $created_by = $this->session->userdata('nama');
        $created_by_id = $this->session->userdata('u_id');
        $role = $this->session->userdata('role');
        $date_by = date("Y-m-d H:i:sa am/pm");
        $pimpinan = "menunggu";
        $status = "tutup";
        $luas_tanah = $_POST['luas_tanah'];
        $luas_bangunan = $_POST['luas_bangunan'];

        $kode_perumahan = "";
        $query = $this->db->get_where('perumahan', array('nama_perumahan'=>$perumahan));

        foreach($query->result() as $row){
            $kode_perumahan = $row->kode_perumahan;
        }

        $persen_dp = $_POST['persenDP'];
        $tgl_dp = $_POST['tglDP'];
        $cara_dp = $_POST['caraDP'];
        $jumlah_dp = $_POST['lamaDP'];
        $total_dp = $_POST['totalDP'];
        $tgl_kpr = $_POST['tglKPR'];
        $total_kpr = $_POST['totalKPR'];
        $lama_tempo = $_POST['lama_tempo'];
        $catatan_pembayaran = $_POST['catatan'];
        $lama_cash = $_POST['lama_cash'];
        $persenDP_selector = $_POST['persenDP_selector'];
        $persen_bunga = $_POST['persen_bunga'];
        $npwp = $_POST['npwp'];
        $email = $_POST['email'];

        $data = array(
            // 'no_psjb' => $no_psjb,
            'sistem_pembayaran' => $sistem_pembayaran,
            'nama_marketing' => $nama_marketing,
            // 'tgl_psjb' => $tgl_psjb,
            'nama_pemesan' => $nama_pemesan,
            'nama_sertif' => $nama_sertif,
            'alamat_lengkap' => $alamat_lengkap,
            'alamat_surat' => $alamat_surat,
            'telp_rumah' => $telp_rumah,
            'telp_hp' => $telp_hp,
            'ktp' => $ktp,
            'uang_awal' => $uang_awal,
            // 'kode_perumahan' => $kode_perumahan,
            // 'perumahan' => $perumahan,
            // 'no_kavling' => $kavling,
            // 'tipe_rumah' => $tipe_rumah,
            // 'harga_jual' => $harga_jual,
            'disc_jual' => $disc_jual,
            'total_jual' => $total_jual,
            'created_by' => $created_by,
            'id_created_by' => $created_by_id,
            'date_by' => $date_by,
            'pimpinan' => $pimpinan,
            'status' => $status,
            'persen_dp' => $persen_dp,
            'tgl_dp' => $tgl_dp,
            'cara_dp' => $cara_dp,
            'jumlah_dp' => $jumlah_dp,
            'total_dp' => $total_dp,
            'tgl_kpr' => $tgl_kpr,
            'total_kpr' => $total_kpr,
            'kode_perusahaan' => $nama_perusahaan,
            'role' => $role,
            // 'luas_tanah' => $luas_tanah,
            // 'luas_bangunan' => $luas_bangunan,
            'lama_tempo' => $lama_tempo,
            'catatan' => $catatan_pembayaran,
            'lama_cash' => $lama_cash,
            'persenDP_selector'=>$persenDP_selector,
            'persen_bunga'=>$persen_bunga,
            'npwp'=>$npwp,
            'email'=>$email,
        );

        // $this->db->insert('psjb', $data);
        $this->db->update('psjb', $data, array('no_psjb'=>$no_psjb, 'kode_perumahan'=>$kode_perumahan));

        $data2 = array(
            'status' => "psjb"
        );

        $this->db->update('rumah', $data2, array('kode_rumah' => $kavling, 'kode_perumahan'=>$kode_perumahan));

        $dt = array(
            // 'id_penerimaan'=>$no_psjb,
            // 'kode_perumahan'=>$kode_perumahan,
            'tanggal_dana'=>$tgl_psjb,
            'kategori'=>"booking fee",
            'keterangan'=>"Booking Fee -".$nama_pemesan,
            'terima_dari'=>$nama_pemesan,
            'nominal_bayar'=>$uang_awal,
            'cara_pembayaran'=>$sistem_pembayaran,
            // 'id_bank'=>$bank_awal,
            // 'nama_bank'=>$nama_bank,
            'date_created'=>$date_by,
            'id_created_by'=>$created_by_id,
            'created_by'=>$created_by
        );

        $this->db->update('keuangan_akuntansi', $dt, array('id_penerimaan'=>$no_psjb, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"booking fee"));

        if($sistem_pembayaran == "KPR"){
            $data5 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('psjb-dp', $data5);

            if($cara_dp == "cicil"){
                $perbulan = $total_dp / $jumlah_dp;

                $time = strtotime($tgl_dp);

                for($x = 1; $x <= $jumlah_dp; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    if($persenDP_selector == "manual"){
                        $data2 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                            'persen' => $persen_dp,
                            'tanggal_dana' => $date,
                            'dana_masuk' => $perbulan,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );

                        $this->db->insert('psjb-dp', $data2);
                    } else {
                        $data2 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP ke-".$x,
                            'persen' => $persen_dp,
                            'tanggal_dana' => $date,
                            'dana_masuk' => $perbulan,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );

                        $this->db->insert('psjb-dp', $data2);
                    }
                }
            }else{
                if($persenDP_selector == "manual"){
                    $data4 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                        'persen' => $persen_dp,
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
                    $this->db->insert('psjb-dp', $data4);
                } else {
                    $data4 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP",
                        'persen' => $persen_dp,
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
                    $this->db->insert('psjb-dp', $data4);
                }
            }
            $data3 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => $sistem_pembayaran,
                'tanggal_dana' => $tgl_kpr,
                'dana_masuk' => $total_kpr,
                'status' => "belum lunas",
                'kode_perumahan' => $kode_perumahan
            );

            $this->db->insert('psjb-dp', $data3);
        }
        else if($sistem_pembayaran == "Tempo"){
            $data5 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('psjb-dp', $data5);

            if($persen_dp == 0){
                if($cara_dp == "cicil"){
                    $perbulan = $total_dp / $jumlah_dp;
    
                    $time = strtotime($tgl_dp);
    
                    for($x = 1; $x <= $jumlah_dp; $x++){
                        $date = date('Y-m-d', $time);
                        $due_dates[] = $date;
                        // move to next timestamp
                        $time = strtotime('+1 month', $time);
    
                        if($persenDP_selector == "manual"){
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        } else {
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x,
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        }
                    }
                } else {
                    if($persenDP_selector == "manual"){
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP (0%)",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    } else {
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    }
                }
            } else {
                if($cara_dp == "cicil"){
                    $perbulan = $total_dp / $jumlah_dp;
    
                    $time = strtotime($tgl_dp);
    
                    for($x = 1; $x <= $jumlah_dp; $x++){
                        $date = date('Y-m-d', $time);
                        $due_dates[] = $date;
                        // move to next timestamp
                        $time = strtotime('+1 month', $time);
    
                        if($persenDP_selector == "manual"){
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        } else {
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x,
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        }
                    }
                } else {
                    if($persenDP_selector == "manual"){
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    } else {
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    }
                }
            }

            if($lama_tempo == 24){
                $perbulan = $total_kpr / $lama_tempo;

                $perbulan1 = ($total_kpr+((($total_kpr*$persen_bunga)/100)*2))/24;

                $perbulan2 = (($total_kpr/24*12)+(($total_kpr/24*12*$persen_bunga)/100))/12;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= 12; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
                for($x = 13; $x <= 24; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan2,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            } else if($lama_tempo == 36){
                $perbulan = $total_kpr / $lama_tempo;

                $perbulan1 = ($total_kpr+((($total_kpr*$persen_bunga)/100)*3))/36;

                $perbulan2 = (($total_kpr/36*24)+(($total_kpr/36*24*($persen_bunga*2))/100))/24;

                $perbulan3 = (($total_kpr/36*12)+(($total_kpr/36*12*$persen_bunga)/100))/12;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= 12; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
                for($x = 13; $x <= 24; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan2,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
                for($x = 25; $x <= 36; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan3,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            } else {
                $perbulan = $total_kpr / $lama_tempo;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= $lama_tempo; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            }
        }
        else{
            $data5 = array(
                'no_psjb' => $no_psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('psjb-dp', $data5);

            $perbulan1 = $total_kpr / $lama_cash;
            $perbulan = $total_dp / $jumlah_dp;

            $time = strtotime($tgl_kpr);
            $time2 = strtotime($tgl_kpr);

            if($cara_dp == "cash"){
                if($persenDP_selector == "manual"){
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                } else {
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP",
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            }else{
                for($x = 1; $x <= $jumlah_dp; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);
    
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
    
                    $this->db->insert('psjb-dp', $data2);
                }
            }

            if($lama_cash == 1){
                $date = date('Y-m-d', $time2);
                $due_dates[] = $date;
                // move to next timestamp
                $time2 = strtotime('+1 month', $time2);

                $data2 = array(
                    'no_psjb' => $no_psjb,
                    'cara_bayar' => "Pelunasan",
                    'tanggal_dana' => $tgl_kpr,
                    'dana_masuk' => $total_kpr,
                    'status' => "belum lunas",
                    'kode_perumahan' => $kode_perumahan
                );

                $this->db->insert('psjb-dp', $data2);
            } else {
                for($x = 1; $x <= $lama_cash; $x++){
                    $date = date('Y-m-d', $time2);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time2 = strtotime('+1 month', $time2);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Pelunasan ke-".$x,
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('psjb-dp', $data2);
                }
            }
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('psjb');

        // $data['succ_msg'] = "Data sukses ditambahkan";

        // $this->load->view('psjb_management', $data);
        redirect('Dashboard/psjb_management');
    }

    public function psjb_batal(){
        $id=$_GET['id'];
        $kode=$_GET['kode'];

        $data = array(
            'status' => "menunggu"
        );

        $this->db->update('psjb', $data, array('no_psjb'=>$id,'kode_perumahan'=>$kode));

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('psjb');

        redirect('Dashboard/psjb_management');
    }

    public function psjb_pembatalan(){
        $id=$_GET['id'];
        // $kode=$_GET['kode'];

        $data = array(
            'status' => "batal",
            'pimpinan' => $this->session->userdata('nama')
        );

        $this->db->update('psjb', $data, array('id_psjb'=>$id));

        foreach($this->db->get_where('psjb', array('id_psjb'=>$id))->result() as $row){
            $no_kavling = $row->no_kavling;
            $psjb = $row->no_psjb;
            $kode_perumahan = $row->kode_perumahan;
            $tipe_produk = $row->tipe_produk;
        }

        $data2 = array(
            'status'=>"free"
        );

        $this->db->update('rumah', $data2, array('kode_rumah'=>$no_kavling, 'kode_perumahan'=>$kode_perumahan));
        
        $data4 = array(
            'status'=>"free",
            'no_psjb'=>""
        );

        $this->db->update('rumah', $data4, array('no_psjb'=>$psjb, 'kode_perumahan'=>$kode_perumahan, 'tipe_produk'=>$tipe_produk));

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('psjb');

        redirect('Dashboard/psjb_management');
    }

    public function undo_batal(){
        $id=$_GET['id'];
        $kode=$_GET['kode'];

        $data = array(
            'status' => "tutup",
            'pimpinan' => "menunggu"
        );

        $this->db->update('psjb', $data, array('no_psjb'=>$id,'kode_perumahan'=>$kode));

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('psjb');

        redirect('Dashboard/psjb_management');
    }

    public function edit_psjb_dp(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $cara_bayar = $_POST['cara_bayar'];
        $persen = $_POST['persen'];
        $tanggal_dana = $_POST['tanggal_dana'];
        $dana_masuk = $_POST['dana_masuk'];
        $status = $_POST['status'];

        $total1 = $_POST['total'];
        $total2 = $_POST['totals'];

        // print_r($tanggal_dana);
        // print_r($dana_masuk);
        // exit;

        // if($total1 != $total2){
        //     echo "<script>
        //             alert('Tidak cocok / Tidak 0');
        //             window.location.href='detail_psjb?id=$id&kode=$kode';
        //           </script>";
        // } else {
            $this->db->delete('psjb-dp', array('no_psjb'=>$id));

            for($i = 0; $i < count($cara_bayar); $i++){
                // if($cara_bayar[$i] == "Uang Tanda Jadi"){

                // }

                $data = array(
                    'no_psjb'=>$id,
                    'kode_perumahan'=>$kode,
                    'cara_bayar'=>$cara_bayar[$i],
                    'persen'=>$persen[$i],
                    'tanggal_dana'=>$tanggal_dana[$i],
                    'dana_masuk'=>$dana_masuk[$i],
                    'status'=>$status[$i]
                );

                $this->db->insert('psjb-dp', $data);
            };

            redirect('Dashboard/detail_psjb?id='.$id.'&kode='.$kode);
            // print_r($cara_bayar);
        // }
    }

    public function update_signature_psjb(){
        $id = $_POST['id'];

        $folderPath = "./gambar/signature/psjb/";
  
        $image_parts = explode(";base64,", $_POST['signed']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik=1;
        $this->db->order_by('konsumen_sign', "DESC");
        $this->db->limit(1);
        foreach($this->db->get('psjb')->result() as $row){
            $unik = $row->konsumen_sign + 1;
        }

        // $unik = uniqid();
        $file = $folderPath . $unik . '.'.$image_type;
        // TES
        $image_parts1 = explode(";base64,", $_POST['signed1']);
            
        $image_type_aux1 = explode("image/", $image_parts1[0]);
        
        $image_type1 = $image_type_aux1[1];
        
        $image_base641 = base64_decode($image_parts1[1]);
        
        // $unik1 = uniqid();
        $unik1 = $unik + 1;
        $file1 = $folderPath . $unik1 . '.'.$image_type1;
        // print_r(uniqid()); exit;
        
        if($image_parts[0] == "" || $image_parts1[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='psjb_management';
                  </script>";
        }
        else {
            file_put_contents($file, $image_base64);
            file_put_contents($file1, $image_base641);

            $data = array(
                'marketing_sign'=>$unik.'.'.$image_type,
                'konsumen_sign'=>$unik1.'.'.$image_type1,
                'id_signature_by'=>$this->session->userdata('u_id'),
                'signature_by'=>$this->session->userdata('nama'),
                'date_sign'=>date('Y-m-d H:i:sa am/pm')
            );
    
            $this->db->update('psjb', $data, array('id_psjb'=>$id));
    
            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan tanda tangan!");
    
            redirect('Dashboard/psjb_management');
        }
    }

    public function get_foto_ktp_psjb(){
        $id = $_POST['country'];

        if(isset($id)){
            foreach($this->db->get_where('psjb', array('id_psjb'=>$id))->result() as $row){
                echo "<a href='".base_url()."gambar/psjb/$row->ktp_img' download>";
                echo "<img src='".base_url()."gambar/psjb/$row->ktp_img' style='width: 200px; height: 200px' alt='Picture not found'>";
                echo "</a>";
            }
        }
    }

    public function upload_foto_ktp_psjb(){
        $id = $_POST['id'];
        $old = $_POST['berkas_old'];

        $config['upload_path']          = './gambar/psjb/';
        $config['allowed_types']        = 'gif|jpg|png';
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('berkas'))
        {
            // $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('succ_msg', $this->upload->display_errors());

            redirect('Dashboard/psjb_management');
        }
        else
        {
            if($old != ""){
                unlink('gambar/psjb/'.$old);
            }

            $upload = array('upload_data' => $this->upload->data());

            $file_name = $upload['upload_data']['file_name'];

            $data = array(
                'ktp_img' => $file_name,
                'ktp_img_date' => date('Y-m-d H:i:sa am/pm')
            );

            $this->db->update('psjb', $data, array('id_psjb'=>$id));

            $this->session->set_flashdata('succ_msg', "Foto KTP telah diupload");

            redirect('Dashboard/psjb_management');
        }
    }
    //END OF PSJB
    //
    //
    //
    //    

    //START OF PPJB
    //
    //
    //
    //

    public function ppjb(){
        $data['check_all'] = $this->db->get_where('psjb', array('status'=>"dom"));

        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('ppjb', $data);
    }

    public function ppjb_management(){
        $data['check_all'] = $this->db->get_where('ppjb', array('tipe_produk'=>"rumah"));

        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('ppjb_management', $data);
    }

    public function app_ppjb_management(){
        $data['check_all'] = $this->db->get_where('ppjb', array('tipe_produk'=>"rumah", 'status'=>"tutup"));

        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('ppjb_management', $data);
    }

    public function f_ppjb_management(){
        $data['check_all'] = $this->db->get_where('ppjb', array('tipe_produk'=>"rumah", 'marketing_sign <>'=>"", 'konsumen_sign <>'=>"", 'owner_sign'=>""));

        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('ppjb_management', $data);
    }

    public function filter_ppjb_management(){
        $kode = $_POST['perumahan'];

        if($kode == ""){
            $data['check_all'] = $this->db->get('ppjb');
        } else {
            $data['check_all'] = $this->db->get_where('ppjb', array('kode_perumahan'=>$kode, 'tipe_produk'=>"rumah"));
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $kode;

        $this->load->view('ppjb_management', $data);
    }

    public function add_ppjb(){
        $id=$_GET['id'];

        foreach($this->db->get_where('psjb', array('id_psjb'=>$id))->result() as $row){   
            $psjb = $row->no_psjb;     
            $nama_perusahaan = $row->kode_perusahaan;
            $sistem_pembayaran = $row->sistem_pembayaran;
            $nama_marketing = $row->nama_marketing;
            $tgl_psjb = date("Y-m-d");
            $nama_pemesan = $row->nama_pemesan;
            $nama_sertif = $row->nama_sertif;
            $alamat_lengkap = $row->alamat_lengkap;
            $alamat_surat = $row->alamat_surat;
            $telp_rumah = $row->telp_rumah;
            $telp_hp = $row->telp_hp;
            $ktp = $row->ktp;
            $uang_awal = $row->uang_awal;
            $perumahan = $row->perumahan;
            $kavling = $row->no_kavling;
            $tipe_rumah = $row->tipe_rumah;
            $harga_jual = $row->harga_jual;
            $disc_jual = $row->disc_jual;
            $total_jual = $row->total_jual;
            $created_by = $this->session->userdata('nama');
            $created_by_id = $this->session->userdata('u_id');
            $role = $this->session->userdata('role');
            $date_by = date("Y-m-d H:i:sa am/pm");
            $pimpinan = "menunggu";
            $status = "tutup";
            $luas_tanah = $row->luas_tanah;
            $luas_bangunan = $row->luas_bangunan;

            $kode_perumahan = "";
            $query = $this->db->get_where('perumahan', array('nama_perumahan'=>$perumahan));

            foreach($query->result() as $row2){
                $kode_perumahan = $row2->kode_perumahan;
            }

            $persen_dp = $row->persen_dp;
            $tgl_dp = $row->tgl_dp;
            $cara_dp = $row->cara_dp;
            $jumlah_dp = $row->jumlah_dp;
            $total_dp = $row->total_dp;
            $tgl_kpr = $row->tgl_kpr;
            $total_kpr = $row->total_kpr;
            $lama_tempo = $row->lama_tempo;
            $catatan_pembayaran = $row->catatan;
            $lama_cash = $row->lama_cash;

            $pekerjaan = $row->pekerjaan;
            $hadap_timur = $row->hadap_timur;
            $id_bank = $row->id_bank;
            $cara_pembayaran = $row->cara_pembayaran;

            $tipe_produk = $row->tipe_produk;

            $persenDP_selector = $row->persenDP_selector;
            $persen_bunga = $row->persen_bunga;
            $npwp = $row->npwp;
            $email = $row->email;

            if($id_bank != ""){
                foreach($this->db->get_where('bank', array('id_bank'=>$id_bank))->result() as $bank){
                    $nama_bank = $bank->nama_bank;
                }
            }
        }

        $no_psjb = 1; 
        $check_data = $this->Dashboard_model->check_last_record_ppjb($kode_perumahan);
        foreach($check_data as $row){
            $no_psjb = $row->no_psjb + 1;
        }
        
        // $this->db->order_by('id_psjb');
        // $querys = $this->db->get_where('psjb-dp', array('no_psjb'=>$psjb));
        // print_r($querys->result()); exit;

        if($id_bank != ""){
            $data = array(
                'no_psjb' => $no_psjb,
                'sistem_pembayaran' => $sistem_pembayaran,
                'nama_marketing' => $nama_marketing,
                'tgl_psjb' => $tgl_psjb,
                'nama_pemesan' => $nama_pemesan,
                'nama_sertif' => $nama_sertif,
                'alamat_lengkap' => $alamat_lengkap,
                'alamat_surat' => $alamat_surat,
                'telp_rumah' => $telp_rumah,
                'telp_hp' => $telp_hp,
                'ktp' => $ktp,
                'uang_awal' => $uang_awal,
                'kode_perumahan' => $kode_perumahan,
                'perumahan' => $perumahan,
                'no_kavling' => $kavling,
                'tipe_rumah' => $tipe_rumah,
                'harga_jual' => $harga_jual,
                'disc_jual' => $disc_jual,
                'total_jual' => $total_jual,
                'created_by' => $created_by,
                'id_created_by' => $created_by_id,
                'date_by' => $date_by,
                'pimpinan' => $pimpinan,
                'status' => $status,
                'persen_dp' => $persen_dp,
                'tgl_dp' => $tgl_dp,
                'cara_dp' => $cara_dp,
                'jumlah_dp' => $jumlah_dp,
                'total_dp' => $total_dp,
                'tgl_kpr' => $tgl_kpr,
                'total_kpr' => $total_kpr,
                'kode_perusahaan' => $nama_perusahaan,
                'role' => $role,
                'luas_tanah' => $luas_tanah,
                'luas_bangunan' => $luas_bangunan,
                'lama_tempo' => $lama_tempo,
                'catatan' => $catatan_pembayaran,
                'lama_cash' => $lama_cash,
                'pekerjaan' => $pekerjaan,
                'id_bank'=>$id_bank,
                'nama_bank'=>$nama_bank,
                'hadap_timur'=>$hadap_timur,
                'psjb'=>$psjb,
                'tipe_produk'=>$tipe_produk,
                'persenDP_selector'=>$persenDP_selector,
                'cara_pembayaran'=>$cara_pembayaran,
                'persen_bunga'=>$persen_bunga,
                'npwp'=>$npwp,
                'email'=>$email
            );
        } else {
            $data = array(
                'no_psjb' => $no_psjb,
                'sistem_pembayaran' => $sistem_pembayaran,
                'nama_marketing' => $nama_marketing,
                'tgl_psjb' => $tgl_psjb,
                'nama_pemesan' => $nama_pemesan,
                'nama_sertif' => $nama_sertif,
                'alamat_lengkap' => $alamat_lengkap,
                'alamat_surat' => $alamat_surat,
                'telp_rumah' => $telp_rumah,
                'telp_hp' => $telp_hp,
                'ktp' => $ktp,
                'uang_awal' => $uang_awal,
                'kode_perumahan' => $kode_perumahan,
                'perumahan' => $perumahan,
                'no_kavling' => $kavling,
                'tipe_rumah' => $tipe_rumah,
                'harga_jual' => $harga_jual,
                'disc_jual' => $disc_jual,
                'total_jual' => $total_jual,
                'created_by' => $created_by,
                'id_created_by' => $created_by_id,
                'date_by' => $date_by,
                'pimpinan' => $pimpinan,
                'status' => $status,
                'persen_dp' => $persen_dp,
                'tgl_dp' => $tgl_dp,
                'cara_dp' => $cara_dp,
                'jumlah_dp' => $jumlah_dp,
                'total_dp' => $total_dp,
                'tgl_kpr' => $tgl_kpr,
                'total_kpr' => $total_kpr,
                'kode_perusahaan' => $nama_perusahaan,
                'role' => $role,
                'luas_tanah' => $luas_tanah,
                'luas_bangunan' => $luas_bangunan,
                'lama_tempo' => $lama_tempo,
                'catatan' => $catatan_pembayaran,
                'lama_cash' => $lama_cash,
                'pekerjaan' => $pekerjaan,
                // 'id_bank'=>$id_bank,
                // 'nama_bank'=>$nama_bank,
                'hadap_timur'=>$hadap_timur,
                'psjb'=>$psjb,
                'tipe_produk'=>$tipe_produk,
                'persenDP_selector'=>$persenDP_selector,
                'cara_pembayaran'=>$cara_pembayaran,
                'persen_bunga'=>$persen_bunga,
                'npwp'=>$npwp,
                'email'=>$email
            );
        }

        $this->db->insert('ppjb', $data);

        $data2 = array(
            'status' => "ppjb"
        );

        $this->db->update('rumah', $data2, array('kode_rumah' => $kavling,'kode_perumahan'=>$kode_perumahan));

        $data6 = array(
            'status' => "ppjb"
        );

        $this->db->update('psjb', $data6, array('id_psjb'=>$id));

        $this->db->order_by('id_psjb');
        $querys = $this->db->get_where('psjb-dp', array('no_psjb'=>$psjb, 'kode_perumahan'=>$kode_perumahan));
        foreach($querys->result() as $rows){
            $data = array(
                // 'id_psjb'=>$rows->id_psjb,
                'no_psjb'=>$no_psjb,
                'no_ppjb'=>$psjb,
                'cara_bayar'=>$rows->cara_bayar,
                'kode_perumahan'=>$kode_perumahan,
                'persen'=>$rows->persen,
                'tanggal_dana'=>$rows->tanggal_dana,
                'dana_masuk'=>$rows->dana_masuk,
                'status'=>$rows->status,
                'dana_sekarang'=>$rows->dana_masuk
            );

            $this->db->insert('ppjb-dp', $data);
        }

        // $this->db->delete('psjb-dp', array('no_psjb'=>$psjb, 'kode_perumahan'=>$kode_perumahan));

        // if($sistem_pembayaran == "KPR"){
        //     $data5 = array(
        //         'no_psjb' => $no_psjb,
        //         'no_ppjb' => $psjb,
        //         'cara_bayar' => "Uang Tanda Jadi",
        //         'tanggal_dana' => $tgl_psjb,
        //         'dana_masuk' => $uang_awal,
        //         'dana_bayar' => $uang_awal,
        //         'status' => "lunas",
        //         'kode_perumahan' => $kode_perumahan
        //     );
        //     $this->db->insert('ppjb-dp', $data5);

        //     if($cara_dp == "cicil"){
        //         $perbulan = $total_dp / $jumlah_dp;

        //         $time = strtotime($tgl_dp);

        //         for($x = 1; $x <= $jumlah_dp; $x++){
        //             $date = date('Y-m-d', $time);
        //             $due_dates[] = $date;
        //             // move to next timestamp
        //             $time = strtotime('+1 month', $time);

        //             $data2 = array(
        //                 'no_psjb' => $no_psjb,
        //                 'no_ppjb' => $psjb,
        //                 'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
        //                 'persen' => $persen_dp,
        //                 'tanggal_dana' => $date,
        //                 'dana_masuk' => $perbulan,
        //                 'dana_sekarang' => $perbulan,
        //                 'status' => "belum lunas",
        //                 'kode_perumahan' => $kode_perumahan
        //             );

        //             $this->db->insert('ppjb-dp', $data2);
        //         }
        //     }else{
        //         $data4 = array(
        //             'no_psjb' => $no_psjb,
        //             'no_ppjb' => $psjb,
        //             'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
        //             'persen' => $persen_dp,
        //             'tanggal_dana' => $tgl_dp,
        //             'dana_masuk' => $total_dp,
        //             'dana_sekarang' => $total_dp,
        //             'status' => "belum lunas",
        //             'kode_perumahan' => $kode_perumahan
        //         );
        //         $this->db->insert('ppjb-dp', $data4);
        //     }
        //     $data3 = array(
        //         'no_psjb' => $no_psjb,
        //         'no_ppjb' => $psjb,
        //         'cara_bayar' => $sistem_pembayaran,
        //         'tanggal_dana' => $tgl_kpr,
        //         'dana_masuk' => $total_kpr,
        //         'dana_sekarang' => $total_kpr,
        //         'status' => "belum lunas",
        //         'kode_perumahan' => $kode_perumahan
        //     );

        //     $this->db->insert('ppjb-dp', $data3);
        // }
        // else if($sistem_pembayaran == "Tempo"){
        //     $data5 = array(
        //         'no_psjb' => $no_psjb,
        //         'no_ppjb' => $psjb,
        //         'cara_bayar' => "Uang Tanda Jadi",
        //         'tanggal_dana' => $tgl_psjb,
        //         'dana_masuk' => $uang_awal,
        //         'dana_bayar' => $uang_awal,
        //         'status' => "lunas",
        //         'kode_perumahan' => $kode_perumahan
        //     );
        //     $this->db->insert('ppjb-dp', $data5);

        //     $data3 = array(
        //         'no_psjb' => $no_psjb,
        //         'no_ppjb' => $psjb,
        //         'cara_bayar' => "DP (".$persen_dp."%)",
        //         'tanggal_dana' => $tgl_dp,
        //         'dana_masuk' => $total_dp,
        //         'dana_sekarang' => $total_dp,
        //         'status' => "belum lunas",
        //         'kode_perumahan' => $kode_perumahan
        //     );

        //     $this->db->insert('ppjb-dp', $data3);

        //     $perbulan = $total_kpr / $lama_tempo;

        //     $time = strtotime($tgl_kpr);

        //     for($x = 1; $x <= $lama_tempo; $x++){
        //         $date = date('Y-m-d', $time);
        //         $due_dates[] = $date;
        //         // move to next timestamp
        //         $time = strtotime('+1 month', $time);

        //         $data2 = array(
        //             'no_psjb' => $no_psjb,
        //             'no_ppjb' => $psjb,
        //             'cara_bayar' => "Angsuran ke-".($x),
        //             'tanggal_dana' => $date,
        //             'dana_masuk' => $perbulan,
        //             'dana_sekarang' => $perbulan,
        //             'status' => "belum lunas",
        //             'kode_perumahan' => $kode_perumahan
        //         );

        //         $this->db->insert('ppjb-dp', $data2);
        //     }
        // }
        // else{
        //     $data5 = array(
        //         'no_psjb' => $no_psjb,
        //         'no_ppjb' => $psjb,
        //         'cara_bayar' => "Uang Tanda Jadi",
        //         'tanggal_dana' => $tgl_psjb,
        //         'dana_masuk' => $uang_awal,
        //         'dana_bayar' => $uang_awal,
        //         'status' => "lunas",
        //         'kode_perumahan' => $kode_perumahan
        //     );
        //     $this->db->insert('ppjb-dp', $data5);

        //     $perbulan1 = $total_kpr / $lama_cash;
        //     $perbulan = $total_dp / $jumlah_dp;

        //     $time = strtotime($tgl_kpr);
        //     $time2 = strtotime($tgl_kpr);

        //     if($persen_dp == 0){
        //         $data2 = array(
        //             'no_psjb' => $no_psjb,
        //             'no_ppjb' => $psjb,
        //             'cara_bayar' => "Pembayaran DP (0%)",
        //             'tanggal_dana' => $tgl_dp,
        //             'dana_masuk' => $total_dp,
        //             'dana_sekarang' => $total_dp,
        //             'status' => "lunas",
        //             'kode_perumahan' => $kode_perumahan
        //         );

        //         $this->db->insert('ppjb-dp', $data2);
        //     }else if($cara_dp == "cash"){
        //         $data2 = array(
        //             'no_psjb' => $no_psjb,
        //             'no_ppjb' => $psjb,
        //             'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
        //             'tanggal_dana' => $tgl_dp,
        //             'dana_masuk' => $total_dp,
        //             'dana_sekarang' => $total_dp,
        //             'status' => "belum lunas",
        //             'kode_perumahan' => $kode_perumahan
        //         );

        //         $this->db->insert('ppjb-dp', $data2);
        //     }else{
        //         for($x = 1; $x <= $jumlah_dp; $x++){
        //             $date = date('Y-m-d', $time);
        //             $due_dates[] = $date;
        //             // move to next timestamp
        //             $time = strtotime('+1 month', $time);
    
        //             $data2 = array(
        //                 'no_psjb' => $no_psjb,
        //                 'no_ppjb' => $psjb,
        //                 'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
        //                 'tanggal_dana' => $date,
        //                 'dana_masuk' => $perbulan,
        //                 'dana_sekarang' => $perbulan,
        //                 'status' => "belum lunas",
        //                 'kode_perumahan' => $kode_perumahan
        //             );
    
        //             $this->db->insert('ppjb-dp', $data2);
        //         }
        //     }

        //     if($lama_cash == 1){
        //         $date = date('Y-m-d', $time2);
        //         $due_dates[] = $date;
        //         // move to next timestamp
        //         $time2 = strtotime('+1 month', $time2);

        //         $data2 = array(
        //             'no_psjb' => $no_psjb,
        //             'no_ppjb' => $psjb,
        //             'cara_bayar' => "Pelunasan",
        //             'tanggal_dana' => $tgl_kpr,
        //             'dana_masuk' => $total_kpr,
        //             'dana_sekarang' => $total_kpr,
        //             'status' => "belum lunas",
        //             'kode_perumahan' => $kode_perumahan
        //         );

        //         $this->db->insert('ppjb-dp', $data2);
        //     } else {
        //         for($x = 1; $x <= $lama_cash; $x++){
        //             $date = date('Y-m-d', $time2);
        //             $due_dates[] = $date;
        //             // move to next timestamp
        //             $time2 = strtotime('+1 month', $time2);

        //             $data2 = array(
        //                 'no_psjb' => $no_psjb,
        //                 'no_ppjb' => $psjb,
        //                 'cara_bayar' => "Pelunasan ke-".$x,
        //                 'tanggal_dana' => $date,
        //                 'dana_masuk' => $perbulan1,
        //                 'dana_sekarang' => $perbulan1,
        //                 'status' => "belum lunas",
        //                 'kode_perumahan' => $kode_perumahan
        //             );

        //             $this->db->insert('ppjb-dp', $data2);
        //         }
        //     }
        // }

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('ppjb');

        // $data['succ_msg'] = "Data sukses ditambahkan";

        // $this->load->view('psjb_management', $data);
        redirect('Dashboard/ppjb_management');
    }

    public function edit_ppjb_dp(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $no_ppjb = $_POST['no_ppjb'];
        $cara_bayar = $_POST['cara_bayar'];
        $persen = $_POST['persen'];
        $tanggal_dana = $_POST['tanggal_dana'];
        $dana_masuk = $_POST['dana_masuk'];
        $status = $_POST['status'];

        $total1 = $_POST['total'];
        $total2 = $_POST['totals'];

        // if($total1 != $total2){
        //     echo "<script>
        //             alert('Tidak cocok / Tidak 0');
        //             window.location.href='detail_ppjb?id=$id&kode=$kode';
        //           </script>";
        // } else {
            $this->db->delete('ppjb-dp', array('no_psjb'=>$id));

            for($i = 0; $i < count($cara_bayar); $i++){
                $data = array(
                    'no_psjb'=>$id,
                    'no_ppjb'=>$no_ppjb[$i],
                    'kode_perumahan'=>$kode,
                    'cara_bayar'=>$cara_bayar[$i],
                    'persen'=>$persen[$i],
                    'tanggal_dana'=>$tanggal_dana[$i],
                    'dana_masuk'=>$dana_masuk[$i],
                    'status'=>$status[$i],
                    'dana_sekarang'=>$dana_masuk[$i]
                );

                $this->db->insert('ppjb-dp', $data);
            };

            redirect('Dashboard/detail_ppjb?id='.$id.'&kode='.$kode);
            // print_r($cara_bayar);
        // }
    }

    public function detail_ppjb(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['id'] = $id;
        $data['kode'] = $kode;
        
        $data['ppjb_detail'] = $this->db->get_where('ppjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

        $this->db->order_by('id_psjb', "ASC");
        $data['psjb_detail_dp'] = $this->db->get_where('ppjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

        $data['ppjb_sb'] = $this->db->get_where('ppjb_sendback', array('no_psjb'=>$id, 'kode_perumahan'=>$kode));

        if($data['ppjb_sb']->num_rows() > 0){
            $data['ppjb_sendback'] = $data['ppjb_sb'];
        }

        // echo $data['psjb_sb']->num_rows();
        // exit;

        // print_r($data['psjb_detail']);
        // print_r($data['psjb_detail_dp']);
        // exit;

        $data['nama'] = $this->session->userdata('nama');

        foreach($data['ppjb_detail'] as $row){
            if($row->status == "revisi"){
                echo "<script>
                    alert('PSJB tidak bisa di akses karena status masih di revisi!');
                    window.location.href='psjb_management';
                    </script>";
            } else {
                $this->load->view('ppjb_detail', $data);
            }
        }

        // $data['psjb_detail'] = $this->db->get_where('psjb', array('no_psjb'=>$id))->result();

        // $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id))->result();

        // // print_r($data['psjb_detail']);
        // // print_r($data['psjb_detail_dp']);
        // // exit;

        // $data['nama'] = $this->session->userdata('nama');

        // $this->load->view('psjb_detail', $data);
    }

    public function detail_custom_biaya_ppjb(){
        $id = $_GET['id'];
        $no_psjb = "";
        
        $data['psjb_detail_dp'] = $this->db->get_where('ppjb-dp', array('id_psjb'=>$id))->result();
        foreach($data['psjb_detail_dp'] as $row){
            $no_psjb = $row->no_ppjb;
            $kode_perumahan = $row->kode_perumahan;
        }

        $data['psjb_detail'] = $this->db->get_where('ppjb', array('no_psjb'=>$no_psjb, 'kode_perumahan'=>$kode_perumahan))->result();

        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('ppjb_detail_biaya', $data);
    }

    public function update_detail_ppjb(){
        $id = $_GET['id'];
        $no_psjb = "";
        
        $data['psjb_detail_dp'] = $this->db->get_where('ppjb-dp', array('id_psjb'=>$id))->result();
        foreach($data['psjb_detail_dp'] as $row){
            $no_psjb = $row->no_psjb;
            $kode_perumahan = $row->kode_perumahan;
        }

        $data['psjb_detail'] = $this->db->get_where('ppjb', array('no_psjb'=>$no_psjb, 'kode_perumahan'=>$kode_perumahan))->result();

        $dana_sekarang = $_POST['dana_masuk'];

        $data = array(
            'dana_masuk'=>$dana_sekarang
        );

        $this->db->update('ppjb-dp', $data, array('id_psjb'=>$id));
        
        $data['nama'] = $this->session->userdata('nama');

        // $this->load->view('psjb_detail_biaya', $data);
        redirect('Dashboard/detail_custom_biaya_ppjb?id='.$id);
    }

    public function print_ppjb(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $query = $this->db->get_where('ppjb', array('no_psjb' => $id,'kode_perumahan'=>$kode))->result();
        
        $this->db->order_by('id_psjb', "ASC");
        $data['psjb_detail_dp'] = $this->db->get_where('ppjb-dp', array('no_psjb'=>$id,'kode_perumahan'=>$kode))->result();
        // print_r($query);
        $data['check_all'] = $query;

        $data['query'] = $this->Dashboard_model->skip_first_data($id, $kode);
        
        // print_r($data['test']);
        // exit;

        foreach($data['check_all'] as $row){
            if($row->status == "ppjb"){
                $this->load->library('pdf');
            
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "print-ppjb.pdf";
                ob_end_clean();
                $this->pdf->load_view('ppjb_print', $data);
            } else if($row->status == "dom"){
                $this->load->library('pdf');
            
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "print-ppjb.pdf";
                ob_end_clean();
                $this->pdf->load_view('ppjb_print', $data);
            } else{
                echo "<script>
                    alert('PPJB tidak bisa di akses karena belum di approve!');
                    window.location.href='ppjb_management';
                    </script>";
            }
        }
    }

    public function ppjb_approve(){
        if($this->session->userdata('role') != "superadmin"){
            echo "<script>
                alert('Anda tidak berhak untuk melakukan approve!');
                window.location.href='ppjb_management';
                </script>";
        }else{
            $id = $_GET['id'];

            $data2 = array(
                'status' => "dom",
                'pimpinan' => $this->session->userdata('nama')
            );

            $this->db->update('ppjb', $data2, array('id_psjb' => $id));

            // $data['nama'] = $this->session->userdata('nama');

            // $data['check_all'] = $this->db->get('psjb');

            // $data['succ_msg'] = "Data sukses ditambahkan";

            redirect('Dashboard/ppjb_management');
        }
    }

    public function ppjb_view_sendback(){
        if($this->session->userdata('role') != "superadmin"){
            echo "<script>
                alert('Anda tidak berhak untuk melakukan sendback!');
                window.location.href='psjb_management';
                </script>";
        }else{
            $id = $_GET['id'];
            $kode = $_GET['kode'];

            $data['psjb_detail'] = $this->db->get_where('ppjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

            $data['psjb_detail_dp'] = $this->db->get_where('ppjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

            // print_r($data['psjb_detail']);
            // print_r($data['psjb_detail_dp']);
            // exit;

            $data['nama'] = $this->session->userdata('nama');

            $this->load->view('ppjb_sendback', $data);
        }
    }

    public function ppjb_sendback(){
        $id = $_GET['id'];
        // $kode = $_POST['kode'];
        $sendback = $_POST['sendback'];
        $created_by = $this->session->userdata('nama');
        $date_by = date("Y-m-d H:i:sa am/pm");
        // $no_psjb = $_POST['no_psjb'];
        $query = $this->db->get_where('ppjb', array('id_psjb'=>$id))->result();
        // print_r($query); exit;
        foreach($query as $row){
            $no_psjb = $row->no_psjb;
            $kode_perumahan = $row->kode_perumahan;
        }
        // $no_psjb=$no_psjb;
        // $kode_perumahan=$kode_perumahan;

        $data2 = array(
            'catatan' => $sendback,
            'sendback_by' => $created_by,
            'sendback_date' => $date_by,
            'no_psjb' => $no_psjb,
            'kode_perumahan' => $kode_perumahan
        );

        $this->db->insert('ppjb_sendback', $data2);

        $this->db->delete('ppjb-dp', array('no_psjb'=>$no_psjb,'kode_perumahan'=>$kode_perumahan));

        $data = array(
            'status' => "revisi"
        );

        $this->db->update('ppjb', $data, array('no_psjb'=>$no_psjb,'kode_perumahan'=>$kode_perumahan));

        redirect('Dashboard/ppjb_management');
    }

    public function ppjb_view_revisi(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');
        $data['role'] = $this->session->userdata('role');

        $data['psjb_revisi'] = $this->db->get_where('ppjb', array('no_psjb'=>$id,'kode_perumahan'=>$kode))->result();
        
        foreach($data['psjb_revisi'] as $row){
            if($row->status == "revisi"){
                $this->load->view('ppjb_revisi', $data);
            } else {
                echo "<script>
                alert('PPJB ini tidak berstatus untuk revisi!');
                window.location.href='ppjb_management';
                </script>";
            }
        }
    }

    public function ppjb_revisi(){
        $no_ppjb = $_POST['psjb']; 
        $no_psjb = $_POST['no_psjb'];
        // echo $no_ppjb;
        // echo $no_psjb;
        // exit;
        
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $sistem_pembayaran = $_POST['cara_pembayaran'];
        $nama_marketing = $_POST['nama_marketing'];
        $tgl_psjb = date("Y-m-d");
        $nama_pemesan = $_POST['nama_pemesan'];
        $nama_sertif = $_POST['nama_sertif'];
        $alamat_lengkap = $_POST['alamat_lengkap'];
        $alamat_surat = $_POST['alamat_surat'];
        $telp_rumah = $_POST['no_telp'];
        $telp_hp = $_POST['no_hp'];
        $ktp = $_POST['ktp'];
        $uang_awal = $_POST['uang_awal'];
        $perumahan = $_POST['nama_perumahan'];
        $kavling = $_POST['id_kavling'];
        $tipe_rumah = $_POST['tipe_standart'];
        $harga_jual = $_POST['harga_jual_standart'];
        $disc_jual = $_POST['diskon_penjualan'];
        $total_jual = $_POST['total_penjualan'];
        $created_by = $this->session->userdata('nama');
        $created_by_id = $this->session->userdata('u_id');
        $role = $this->session->userdata('role');
        $date_by = date("Y-m-d H:i:sa am/pm");
        $pimpinan = "menunggu";
        $status = "tutup";
        $luas_tanah = $_POST['luas_tanah'];
        $luas_bangunan = $_POST['luas_bangunan'];

        $kode_perumahan = "";
        $query = $this->db->get_where('perumahan', array('nama_perumahan'=>$perumahan));

        foreach($query->result() as $row){
            $kode_perumahan = $row->kode_perumahan;
        }

        $persen_dp = $_POST['persenDP'];
        $tgl_dp = $_POST['tglDP'];
        $cara_dp = $_POST['caraDP'];
        $jumlah_dp = $_POST['lamaDP'];
        $total_dp = $_POST['totalDP'];
        $tgl_kpr = $_POST['tglKPR'];
        $total_kpr = $_POST['totalKPR'];
        $lama_tempo = $_POST['lama_tempo'];
        $catatan_pembayaran = $_POST['catatan'];
        $lama_cash = $_POST['lama_cash'];
        $pekerjaan = $_POST['pekerjaan'];
        $hadap_timur = $_POST['hadap_timur'];

        $persenDP_selector = $_POST['persenDP_selector'];
        $persen_bunga = $_POST['persen_bunga'];
        $npwp = $_POST['npwp'];
        $email = $_POST['email'];

        $data = array(
            // 'no_psjb' => $no_psjb,
            'sistem_pembayaran' => $sistem_pembayaran,
            'nama_marketing' => $nama_marketing,
            // 'tgl_psjb' => $tgl_psjb,
            'nama_pemesan' => $nama_pemesan,
            'nama_sertif' => $nama_sertif,
            'alamat_lengkap' => $alamat_lengkap,
            'alamat_surat' => $alamat_surat,
            'telp_rumah' => $telp_rumah,
            'telp_hp' => $telp_hp,
            'ktp' => $ktp,
            'uang_awal' => $uang_awal,
            // 'kode_perumahan' => $kode_perumahan,
            // 'perumahan' => $perumahan,
            'no_kavling' => $kavling,
            // 'tipe_rumah' => $tipe_rumah,
            // 'harga_jual' => $harga_jual,
            'disc_jual' => $disc_jual,
            'total_jual' => $total_jual,
            'created_by' => $created_by,
            'id_created_by' => $created_by_id,
            'date_by' => $date_by,
            'pimpinan' => $pimpinan,
            'status' => $status,
            'persen_dp' => $persen_dp,
            'tgl_dp' => $tgl_dp,
            'cara_dp' => $cara_dp,
            'jumlah_dp' => $jumlah_dp,
            'total_dp' => $total_dp,
            'tgl_kpr' => $tgl_kpr,
            'total_kpr' => $total_kpr,
            'kode_perusahaan' => $nama_perusahaan,
            'role' => $role,
            // 'luas_tanah' => $luas_tanah,
            // 'luas_bangunan' => $luas_bangunan,
            'lama_tempo' => $lama_tempo,
            'catatan' => $catatan_pembayaran,
            'lama_cash' => $lama_cash,
            'pekerjaan' => $pekerjaan,
            'hadap_timur' => $hadap_timur,
            'persen_bunga'=>$persen_bunga,
            'npwp'=>$npwp,
            'email'=>$email
        );

        // $this->db->insert('psjb', $data);
        $this->db->update('ppjb', $data, array('no_psjb'=>$no_psjb,'kode_perumahan'=>$kode_perumahan));

        $data2 = array(
            'status' => "ppjb"
        );

        $this->db->update('rumah', $data2, array('kode_rumah' => $kavling,'kode_perumahan'=>$kode_perumahan));

        // $this->db->delete('psjb-dp', array('no_ppjb'=>$no_psjb));

        if($sistem_pembayaran == "KPR"){
            $data5 = array(
                'no_psjb' => $no_psjb,
                'no_ppjb' => $no_ppjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'dana_sekarang' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('ppjb-dp', $data5);

            if($cara_dp == "cicil"){
                $perbulan = $total_dp / $jumlah_dp;

                $time = strtotime($tgl_dp);

                for($x = 1; $x <= $jumlah_dp; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    if($persenDP_selector == "manual"){
                        $data2 = array(
                            'no_psjb' => $no_psjb,
                            'no_ppjb' => $no_ppjb,
                            'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                            'persen' => $persen_dp,
                            'tanggal_dana' => $date,
                            'dana_masuk' => $perbulan,
                            'dana_sekarang' => $perbulan,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );

                        $this->db->insert('ppjb-dp', $data2);
                    } else {
                        $data2 = array(
                            'no_psjb' => $no_psjb,
                            'no_ppjb' => $no_ppjb,
                            'cara_bayar' => "Pembayaran DP ke-".$x,
                            'persen' => $persen_dp,
                            'tanggal_dana' => $date,
                            'dana_masuk' => $perbulan,
                            'dana_sekarang' => $perbulan,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );

                        $this->db->insert('ppjb-dp', $data2);
                    }
                }
            }else{
                if($persenDP_selector == "manual"){
                    $data4 = array(
                        'no_psjb' => $no_psjb,
                        'no_ppjb' => $no_ppjb,
                        'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                        'persen' => $persen_dp,
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'dana_sekarang' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
                    $this->db->insert('ppjb-dp', $data4);
                } else {
                    $data4 = array(
                        'no_psjb' => $no_psjb,
                        'no_ppjb' => $no_ppjb,
                        'cara_bayar' => "Pembayaran DP",
                        'persen' => $persen_dp,
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'dana_sekarang' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );
                    $this->db->insert('ppjb-dp', $data4);
                }
            }
            $data3 = array(
                'no_psjb' => $no_psjb,
                'no_ppjb' => $no_ppjb,
                'cara_bayar' => $sistem_pembayaran,
                'tanggal_dana' => $tgl_kpr,
                'dana_masuk' => $total_kpr,
                'dana_sekarang' => $total_kpr,
                'status' => "belum lunas",
                'kode_perumahan' => $kode_perumahan
            );

            $this->db->insert('ppjb-dp', $data3);
        }
        else if($sistem_pembayaran == "Tempo"){
            $data5 = array(
                'no_psjb' => $no_psjb,
                'no_ppjb' => $no_ppjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'dana_sekarang' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('ppjb-dp', $data5);

            if($persen_dp == 0){
                if($cara_dp == "cicil"){
                    $perbulan = $total_dp / $jumlah_dp;
    
                    $time = strtotime($tgl_dp);
    
                    for($x = 1; $x <= $jumlah_dp; $x++){
                        $date = date('Y-m-d', $time);
                        $due_dates[] = $date;
                        // move to next timestamp
                        $time = strtotime('+1 month', $time);
    
                        if($persenDP_selector == "manual"){
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        } else {
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x,
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        }
                    }
                } else {
                    if($persenDP_selector == "manual"){
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP (0%)",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    } else {
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    }
                }
            } else {
                if($cara_dp == "cicil"){
                    $perbulan = $total_dp / $jumlah_dp;
    
                    $time = strtotime($tgl_dp);
    
                    for($x = 1; $x <= $jumlah_dp; $x++){
                        $date = date('Y-m-d', $time);
                        $due_dates[] = $date;
                        // move to next timestamp
                        $time = strtotime('+1 month', $time);
    
                        if($persenDP_selector == "manual"){
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        } else {
                            $data2 = array(
                                'no_psjb' => $no_psjb,
                                'cara_bayar' => "Pembayaran DP ke-".$x,
                                'persen' => $persen_dp,
                                'tanggal_dana' => $date,
                                'dana_masuk' => $perbulan,
                                'status' => "belum lunas",
                                'kode_perumahan' => $kode_perumahan
                            );
    
                            $this->db->insert('psjb-dp', $data2);
                        }
                    }
                } else {
                    if($persenDP_selector == "manual"){
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    } else {
                        $data3 = array(
                            'no_psjb' => $no_psjb,
                            'cara_bayar' => "Pembayaran DP",
                            'tanggal_dana' => $tgl_dp,
                            'dana_masuk' => $total_dp,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
            
                        $this->db->insert('psjb-dp', $data3);
                    }
                }
            }

            if($lama_tempo == 24){
                $perbulan = $total_kpr / $lama_tempo;

                $perbulan1 = ($total_kpr+((($total_kpr*$persen_bunga)/100)*2))/24;

                $perbulan2 = (($total_kpr/24*12)+(($total_kpr/24*12*$persen_bunga)/100))/12;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= 12; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                }
                for($x = 13; $x <= 24; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan2,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                }
            } else if($lama_tempo == 36){
                $perbulan = $total_kpr / $lama_tempo;

                $perbulan1 = ($total_kpr+((($total_kpr*$persen_bunga)/100)*3))/36;

                $perbulan2 = (($total_kpr/36*24)+(($total_kpr/36*24*($persen_bunga*2))/100))/24;

                $perbulan3 = (($total_kpr/36*12)+(($total_kpr/36*12*$persen_bunga)/100))/12;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= 12; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                }
                for($x = 13; $x <= 24; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan2,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                }
                for($x = 25; $x <= 36; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan3,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                }
            } else {
                $perbulan = $total_kpr / $lama_tempo;

                $time = strtotime($tgl_kpr);

                for($x = 1; $x <= $lama_tempo; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'cara_bayar' => "Angsuran ke-".($x),
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                }
            }
        }
        else{
            $data5 = array(
                'no_psjb' => $no_psjb,
                'no_ppjb' => $no_ppjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'dana_sekarang' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('ppjb-dp', $data5);

            $perbulan1 = $total_kpr / $lama_cash;
            $perbulan = $total_dp / $jumlah_dp;

            $time = strtotime($tgl_kpr);
            $time2 = strtotime($tgl_kpr);

            if($persen_dp == 0){
                if($persenDP_selector == "manual"){
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'no_ppjb' => $no_ppjb,
                        'cara_bayar' => "Pembayaran DP (0%)",
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'dana_sekarang' => $total_dp,
                        'status' => "lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                } else {
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'no_ppjb' => $no_ppjb,
                        'cara_bayar' => "Pembayaran DP",
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'dana_sekarang' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                }
            }else if($cara_dp == "cash"){
                if($persenDP_selector == "manual"){
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'no_ppjb' => $no_ppjb,
                        'cara_bayar' => "Pembayaran DP (".$persen_dp."%)",
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'dana_sekarang' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                } else {
                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'no_ppjb' => $no_ppjb,
                        'cara_bayar' => "Pembayaran DP",
                        'tanggal_dana' => $tgl_dp,
                        'dana_masuk' => $total_dp,
                        'dana_sekarang' => $total_dp,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                }
            }else{
                for($x = 1; $x <= $jumlah_dp; $x++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);
    
                    if($persenDP_selector == "manual"){
                        $data2 = array(
                            'no_psjb' => $no_psjb,
                            'no_ppjb' => $no_ppjb,
                            'cara_bayar' => "Pembayaran DP ke-".$x." (".$persen_dp."%)",
                            'tanggal_dana' => $date,
                            'dana_masuk' => $perbulan,
                            'dana_sekarang' => $perbulan,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
        
                        $this->db->insert('ppjb-dp', $data2);
                    } else {
                        $data2 = array(
                            'no_psjb' => $no_psjb,
                            'no_ppjb' => $no_ppjb,
                            'cara_bayar' => "Pembayaran DP ke-".$x,
                            'tanggal_dana' => $date,
                            'dana_masuk' => $perbulan,
                            'dana_sekarang' => $perbulan,
                            'status' => "belum lunas",
                            'kode_perumahan' => $kode_perumahan
                        );
        
                        $this->db->insert('ppjb-dp', $data2);
                    }
                }
            }

            if($lama_cash == 1){
                $date = date('Y-m-d', $time2);
                $due_dates[] = $date;
                // move to next timestamp
                $time2 = strtotime('+1 month', $time2);

                $data2 = array(
                    'no_psjb' => $no_psjb,
                    'no_ppjb' => $no_ppjb,
                    'cara_bayar' => "Pelunasan",
                    'tanggal_dana' => $tgl_kpr,
                    'dana_masuk' => $total_kpr,
                    'dana_sekarang' => $total_kpr,
                    'status' => "belum lunas",
                    'kode_perumahan' => $kode_perumahan
                );

                $this->db->insert('ppjb-dp', $data2);
            } else {
                for($x = 1; $x <= $lama_cash; $x++){
                    $date = date('Y-m-d', $time2);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time2 = strtotime('+1 month', $time2);

                    $data2 = array(
                        'no_psjb' => $no_psjb,
                        'no_ppjb' => $no_ppjb,
                        'cara_bayar' => "Pelunasan ke-".$x,
                        'tanggal_dana' => $date,
                        'dana_masuk' => $perbulan1,
                        'dana_sekarang' => $perbulan1,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data2);
                }
            }
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('ppjb');

        // $data['succ_msg'] = "Data sukses ditambahkan";

        // $this->load->view('psjb_management', $data);
        redirect('Dashboard/ppjb_management');
    }

    public function ppjb_batal(){
        $id=$_GET['id'];
        $kode=$_GET['kode'];

        $data = array(
            'status' => "menunggu"
        );

        $this->db->update('ppjb', $data, array('no_psjb'=>$id,'kode_perumahan'=>$kode));

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('ppjb');

        redirect('Dashboard/ppjb_management');
    }

    public function ppjb_pembatalan(){
        $id=$_GET['id'];

        $data = array(
            'status' => "batal",
            'pimpinan' => $this->session->userdata('nama')
        );

        $this->db->update('ppjb', $data, array('id_psjb'=>$id));

        foreach($this->db->get_where('ppjb', array('id_psjb'=>$id))->result() as $row){
            $no_kavling = $row->no_kavling;
            $psjb = $row->psjb;
            $kode_perumahan = $row->kode_perumahan;
            $tipe_produk = $row->tipe_produk;
        }
        
        $data3 = array(
            'status' => "batal",
            'pimpinan' => $this->session->userdata('nama')
        );

        $this->db->update('psjb', $data3, array('no_psjb'=>$psjb,'kode_perumahan'=>$kode_perumahan));

        $data2 = array(
            'status'=>"free"
        );

        $this->db->update('rumah', $data2, array('kode_rumah'=>$no_kavling, 'kode_perumahan'=>$kode_perumahan));

        $data4 = array(
            'status'=>"free",
            'no_psjb'=>""
        );

        $this->db->update('rumah', $data4, array('no_psjb'=>$psjb, 'kode_perumahan'=>$kode_perumahan, 'tipe_produk'=>$row->tipe_produk));

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('ppjb');

        redirect('Dashboard/ppjb_management');
    }

    public function undo_batal_ppjb(){
        $id=$_GET['id'];
        $kode=$_GET['kode'];

        $data = array(
            'status' => "tutup",
            'pimpinan' => "menunggu"
        );

        $this->db->update('ppjb', $data, array('no_psjb'=>$id,'kode_perumahan'=>$kode));

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('ppjb');

        redirect('Dashboard/ppjb_management');
    }

    public function update_signature_ppjb(){
        $id = $_POST['id'];

        $folderPath = "./gambar/signature/ppjb/";
  
        $image_parts = explode(";base64,", $_POST['signed']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik=1;
        $this->db->order_by('konsumen_sign', "DESC");
        $this->db->limit(1);
        foreach($this->db->get('ppjb')->result() as $row){
            $unik = $row->konsumen_sign + 1;
        }

        // $unik = uniqid();
        $file = $folderPath . $unik . '.'.$image_type;

        // CUSTOMER
        $image_parts1 = explode(";base64,", $_POST['signed1']);
            
        $image_type_aux1 = explode("image/", $image_parts1[0]);
        
        $image_type1 = $image_type_aux1[1];
        
        $image_base641 = base64_decode($image_parts1[1]);
        
        $unik1 = $unik + 1;
        $file1 = $folderPath . $unik1 . '.'.$image_type1;
        // print_r(uniqid()); exit;

        //OWNER
        $image_parts2 = explode(";base64,", $_POST['signed2']);
            
        $image_type_aux2 = explode("image/", $image_parts2[0]);
        
        $image_type2 = $image_type_aux2[1];
        
        $image_base642 = base64_decode($image_parts2[1]);

        // print_r($image_type_aux2);
        // exit;
        
        $unik2 = 1;
        $this->db->order_by('owner_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get('ppjb')->result() as $row){
            $unik2 = $row->owner_sign;

            $str = $unik2;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik2 = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file2 = $folderPath .'a'. $unik2 . '.'.$image_type2;
        
        if($image_parts[0] == "" || $image_parts1[0] == ""){
            echo "<script>
                    alert('Tanda tangan marketing/konsumen tidak boleh kosong!');
                    window.location.href='ppjb_management';
                  </script>";
        } else {
            if($image_parts2[0] == ""){
                file_put_contents($file, $image_base64);
                file_put_contents($file1, $image_base641);

                $data = array(
                    'marketing_sign'=>$unik.'.'.$image_type,
                    'konsumen_sign'=>$unik1.'.'.$image_type1,
                    // 'owner_sign'=>'a'.$unik2.'.'.$image_type2
                    'id_signature_by'=>$this->session->userdata('u_id'),
                    'signature_by'=>$this->session->userdata('nama'),
                    'date_sign'=>date('Y-m-d H:i:sa am/pm'),
                );
            } else {
                file_put_contents($file, $image_base64);
                file_put_contents($file1, $image_base641);
                file_put_contents($file2, $image_base642);

                $data = array(
                    'marketing_sign'=>$unik.'.'.$image_type,
                    'konsumen_sign'=>$unik1.'.'.$image_type1,
                    'owner_sign'=>'a'.$unik2.'.'.$image_type2,
                    'id_signature_by'=>$this->session->userdata('u_id'),
                    'signature_by'=>$this->session->userdata('nama'),
                    'date_sign'=>date('Y-m-d H:i:sa am/pm'),
                    'id_signature_by_owner'=>$this->session->userdata('u_id'),
                    'signature_by_owner'=>$this->session->userdata('nama'),
                    'date_sign_owner'=>date('Y-m-d H:i:sa am/pm'),
                );
            }

            $this->db->update('ppjb', $data, array('id_psjb'=>$id));

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan tanda tangan!");

            redirect('Dashboard/ppjb_management');
        }
    }
    
    public function update_signature_ppjb2(){
        $id = $_POST['id'];

        $folderPath = "./gambar/signature/ppjb/";
  
        $image_parts = explode(";base64,", $_POST['signed3']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik = 1;
        $this->db->order_by('owner_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get('ppjb')->result() as $row){
            $unik = $row->owner_sign;
            
            $str = $unik;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file = $folderPath .'a'. $unik . '.'.$image_type;
        
        if($image_parts[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='ppjb_management';
                  </script>";
        } else {
            file_put_contents($file, $image_base64);
            // TES

            $data = array(
                'owner_sign'=>'a'.$unik.'.'.$image_type,
                'id_signature_by_owner'=>$this->session->userdata('u_id'),
                'signature_by_owner'=>$this->session->userdata('nama'),
                'date_sign_owner'=>date('Y-m-d H:i:sa am/pm'),
            );

            $this->db->update('ppjb', $data, array('id_psjb'=>$id));

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan tanda tangan!");

            redirect('Dashboard/ppjb_management');
        }
    }

    public function alter_ppjb(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['ppjb'] = $this->db->get_where('ppjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;
        $data['kode'] = $kode;

        $this->load->view('ppjb_alter', $data);
    }

    public function generate_tempo(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $penambahan_biaya = $_POST['tambah_biaya'];
        $jumlah = $_POST['jumlah_biaya'];

        foreach($this->db->get_where('ppjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result() as $row){
            $penambahan = $row->penambahan_biaya;
            $harga_jual = $row->total_jual;
            $ttl = $harga_jual - $penambahan;
            $no_psjb = $row->psjb;
            $nama_pemesan = $row->nama_pemesan;
            // $tgl_penambahan = 

            // echo $ttl;
            // exit;

            $data = array(
                'total_jual' => $ttl
            );

            $this->db->update('ppjb', $data, array('no_psjb'=>$id, 'kode_perumahan'=>$kode));
        }
        $hrg = $ttl;
        // echo $hrg;
        // exit;

        $data1 = array(
            'penambahan_biaya'=>$penambahan_biaya,
            'lama_penambahan'=>$jumlah,
            'total_jual'=>$ttl + $penambahan_biaya,
            'tgl_penambahan'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('ppjb', $data1, array('no_psjb'=>$id, 'kode_perumahan'=>$kode));

        // $gt = $this->db->get_where('ppjb-dp', array('stat_tambah'=>"true", 'no_psjb'=>$id, 'kode_perumahan'=>$kode));

        $this->db->delete('ppjb-dp', array('stat_tambah'=>"true", 'no_psjb'=>$id, 'kode_perumahan'=>$kode));

        $dana_msk = $penambahan_biaya / $jumlah;
        for($i = 1; $i <= $jumlah; $i++){
            $data2 = array(
                'cara_bayar'=>"Perpanjangan Tempo Angsuran Ke-".$i,
                'no_psjb'=>$id,
                'no_ppjb'=>$no_psjb,
                'kode_perumahan'=>$kode,
                'tanggal_dana'=>date('Y-m-d'),
                'dana_masuk'=>$dana_msk,
                'status'=>"belum lunas",
                'stat_tambah'=>"true",
                'dana_sekarang'=>$dana_msk
            );

            $this->db->insert('ppjb-dp', $data2);
        }

        foreach($this->db->get_where('keuangan_akuntansi', array('kategori'=>"penambahan biaya piutang konsumen", 'id_penerimaan'=>$id, 'kode_perumahan'=>$kode))->result() as $kat){
            $id_keuangan = $kat->id_keuangan;

            $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id_keuangan,'jenis_keuangan'=>"penerimaan",'kode_perumahan'=>$kode));
        }
        $this->db->delete('keuangan_akuntansi', array('kategori'=>"penambahan biaya piutang konsumen", 'id_penerimaan'=>$id, 'kode_perumahan'=>$kode));

        if($penambahan_biaya != 0){
            $data3 = array(
                'id_penerimaan'=>$id,
                'kode_perumahan'=>$kode,
                'tanggal_dana'=>date('Y-m-d H:i:sa am/pm'),
                'kategori'=>"penambahan biaya piutang konsumen",
                'terima_dari'=>$nama_pemesan,
                'keterangan'=>"Penambahan biaya piutang konsumen - ".$nama_pemesan." PPJB No. ".$id,
                'nominal_awal'=>$penambahan_biaya,
                'nominal_bayar'=>$penambahan_biaya,
                'cara_pembayaran'=>"cash",
                'date_created'=>date('Y-m-d H:i:sa am/pm'),
                'id_created_by'=>$this->session->userdata('u_id'),
                'created_by'=>$this->session->userdata('nama')
            );

            $this->db->insert('keuangan_akuntansi', $data3);
        }

        redirect('Dashboard/alter_ppjb?id='.$id.'&kode='.$kode);
    }

    public function edit_ppjb_dp_alter(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $no_ppjb = $_POST['no_ppjb'];
        $cara_bayar = $_POST['cara_bayar'];
        $persen = $_POST['persen'];
        $tanggal_dana = $_POST['tanggal_dana'];
        $dana_masuk = $_POST['dana_masuk'];
        $status = $_POST['status'];

        $total1 = $_POST['total'];
        $total2 = $_POST['totals'];
        $id_psjb = $_POST['id_psjb'];

        // print_r($id_psjb);
        // print_r($status);
        // exit;

        // if($total1 != $total2){
        //     echo "<script>
        //             alert('Tidak cocok / Tidak 0');
        //             window.location.href='detail_ppjb?id=$id&kode=$kode';
        //           </script>";
        // } else {
        // $this->db->delete('ppjb-dp', array('no_psjb'=>$id));

        for($i = 0; $i < count($cara_bayar); $i++){
            $data = array(
                'no_psjb'=>$id,
                'no_ppjb'=>$no_ppjb[$i],
                'kode_perumahan'=>$kode,
                'cara_bayar'=>$cara_bayar[$i],
                'persen'=>$persen[$i],
                'tanggal_dana'=>$tanggal_dana[$i],
                'dana_masuk'=>$dana_masuk[$i],
                'status'=>$status[$i],
                'dana_sekarang'=>$dana_masuk[$i]
            );

            $this->db->update('ppjb-dp', $data, array('id_psjb'=>$id_psjb[$i]));
        };

        redirect('Dashboard/alter_ppjb?id='.$id.'&kode='.$kode);
            // print_r($cara_bayar);
        // }
    }

    public function ppjb_revisi_data(){
        $id_psjb = $_POST['id_psjb'];
        $no_psjb = $_POST['no_psjb'];
        $kode_perumahan = $_POST['kode_perumahan'];

        $nama_pemesan = $_POST['nama_pemesan'];
        $nama_sertif = $_POST['nama_sertif'];
        $ktp = $_POST['ktp'];
        $alamat_rumah = $_POST['alamat_lengkap'];
        $alamat_surat = $_POST['alamat_surat'];
        $telp_rumah = $_POST['telp_rumah'];
        $telp_hp = $_POST['telp_hp'];
        $pekerjaan = $_POST['pekerjaan'];
        $npwp = $_POST['npwp'];
        $email = $_POST['email'];
        $catatan = $_POST['catatan'];

        $data = array(
            'nama_pemesan'=>$nama_pemesan,
            'nama_sertif'=>$nama_sertif,
            'ktp'=>$ktp,
            'alamat_lengkap'=>$alamat_rumah,
            'alamat_surat'=>$alamat_surat,
            'telp_rumah'=>$telp_rumah,
            'telp_hp'=>$telp_hp,
            'pekerjaan'=>$pekerjaan,
            'npwp'=>$npwp,
            'email'=>$email,
            'catatan'=>$catatan,
            'superadmin_date_rev'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('ppjb', $data, array('id_psjb'=>$id_psjb));

        redirect('Dashboard/detail_ppjb?id='.$no_psjb.'&kode='.$kode_perumahan);
    }

    public function ppjb_ubah_blok(){
        $id = $_POST['id'];
        $no_psjb = $_POST['no_psjb'];
        $psjb = $_POST['psjb'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $id_kavling = $_POST['id_kavling'];
        $no_blok = $_POST['no_blok'];

        if(count($id_kavling) == 0){
            echo "<script type='text/javascript'>
                    alert('Tidak ada unit yang dipilih! Perubahan tidak dapat dilakukan!');
                    window.location.href='detail_ppjb?id=$no_psjb&kode=$kode_perumahan';
                  </script>";
        } else {
            foreach($this->db->get_where('rumah', array('no_psjb'=>$psjb, 'kode_perumahan'=>$kode_perumahan, 'tipe_produk'=>"rumah"))->result() as $row){
                $data = array(
                    'status'=>"free",
                    'no_psjb'=>""
                );

                $this->db->update('rumah', $data, array('kode_rumah'=>$row->kode_rumah, 'kode_perumahan'=>$kode_perumahan));
            }

            $data1 = array(
                'status'=>"free"
            );

            $this->db->update('rumah', $data, array('kode_rumah'=>$no_blok, 'kode_perumahan'=>$kode_perumahan));

            $data2 = array(
                'status'=>"ppjb"
            );
            $this->db->update('rumah', $data2, array('kode_rumah'=>$id_kavling[0], 'kode_perumahan'=>$kode_perumahan));

            $data3 = array(
                'no_kavling'=>$id_kavling[0],
                'superadmin_date_blok_rev'=>date('Y-m-d H:i:sa am/pm')
            );
            $this->db->update('ppjb', $data3, array('id_psjb'=>$id));

            for($i = 1; $i < count($id_kavling); $i++){
                $data4 = array(
                    'status'=>"ppjb",
                    'no_psjb'=>$no_psjb
                );    
                $this->db->update('rumah', $data4, array('kode_rumah'=>$id_kavling[$i], 'kode_perumahan'=>$kode_perumahan));
            }

            redirect('Dashboard/detail_ppjb?id='.$no_psjb.'&kode='.$kode_perumahan);
        }
    }
    //END OF PPJB
    //
    //
    //
    //

    //KEUANGAN
    public function keuangan_transaksi(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('ppjb', array('status'=>"dom"));
        $data['tipe_pembayaran'] = "";
        $data['kode_perumahan'] = "";

        $this->load->view('transaksi_keuangan', $data);
    }

    public function filter_tipe_pembayaran_keuangan(){
        $tipe_pembayaran = $_POST['tipe_pembayaran'];
        $kode_perumahan = $_POST['kode_perumahan'];

        // echo $tipe_pembayaran.$kode_perumahan;
        // exit;

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->Dashboard_model->filter_tipe_pembayaran($tipe_pembayaran, $kode_perumahan);

        $data['tipe_pembayaran'] = $tipe_pembayaran;
        $data['kode_perumahan'] = $kode_perumahan;

        $this->load->view('transaksi_keuangan', $data);
    }

    public function view_transaksi(){
        $id=$_GET['id'];
        $kode=$_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');
        $data['ppjb'] = $this->db->get_where('ppjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();
        
        $this->db->order_by('id_psjb', "ASC");
        $data['ppjb_dp'] = $this->db->get_where('ppjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();
        foreach($data['ppjb_dp'] as $row){
            $no_ppjb = $row->no_ppjb;
        }

        // $data['bank'] = $this->db->get_where('')

        // foreach($this->db->get_where('keuangan_kas_kpr', array('id_ppjb'=>$row2->id_psjb))->result() as $uang){
                                          
        // } 

        $this->load->view('transaksi_detail', $data);
    }

    public function keuangan_bayar(){
        $id=$_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $query = $this->db->get_where('ppjb-dp', array('id_psjb'=>$id))->result();
        // print_r($data['query']);
        // eix
        foreach($query as $row){
            $no_ppjb = $row->no_psjb;
            $cara_bayar = $row->cara_bayar;
            $kode_perumahan = $row->kode_perumahan;

            if($cara_bayar == "KPR"){
                $data['kpr'] = $this->db->get_where('ppjb-dp', array('id_psjb'=>$id, 'cara_bayar'=>"KPR"))->result();
            } else {
                $data['test'] = $this->db->get_where('ppjb-dp', array('id_psjb'=>$id))->result();
            }
        }
        // print_r($data['query']);
        // exit;

        $ppjb = $this->db->get_where('ppjb', array('no_psjb'=>$no_ppjb, 'kode_perumahan'=>$kode_perumahan))->result();
        foreach($ppjb as $row){
            $nama_konsumen = $row->nama_pemesan;
        }
        $data['nama_konsumen'] = $nama_konsumen;
        $data['id']=$id;
        // print_r($data['nama_konsumen']);

        $this->load->view('transaksi_form_pembayaran', $data);
    }

    public function add_pembayaran(){
        $id = $_POST['id'];
        // echo $id;
        // exit;
        $id_keuangan = 0; 
        
        $check_data = $this->Dashboard_model->check_last_record_pembayaran();
        foreach($check_data as $row){
            $id_keuangan = $row->id_keuangan + 1;
        }

        $id_psjb = $_POST['id_psjb'];
        $no_ppjb = $_POST['no_ppjb'];
        $kode_perumahan = $_POST['kode_perumahan'];

        // $query = $this->db->get_where('ppjb', array('no_psjb'=>$no_ppjb));
        // foreach($query->result() as $row){
        //     $kode_perumahan = $row->kode_perumahan;
        // }
        $nama_konsumen = $_POST['nama_konsumen'];

        $tahap_bayar = $_POST['tahap_bayar'];
        $dana_bayar = $_POST['dana_bayar'];
        $dana_kurang = $_POST['dana_kurang'];
        $tanggal_bayar = $_POST['tanggal_bayar'];

        $total_patok = $_POST['total_patok'];

        $cara_pembayaran = $_POST['cara_pembayaran'];
        $id_bank = $_POST['bank'];

        $persen = 0;
        $persen = $_POST['persen_pencairan'];
        $tahap_pencairan = "";
        $tahap_pencairan = $_POST['tahap_pencairan'];

        if($id_bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$id_bank))->result() as $row2){
                $nama_bank = $row2->nama_bank;
            }
        }

        $dana_terkini = $_POST['dana_saat'];

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='piutang_konsumen_temp_'.$id_keuangan.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_kwitansi_pembayaran_temp?id=".$id_keuangan; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        // echo $kode_perumahan;
        if($dana_kurang < 0) {
            // $this->session->set_flashdata('err_msg', 'Nominal tidak pas!');

            // redirect('Dashboard/keuangan_bayar?id=');
            echo "<script>
                alert('Nominal tidak pas!');
                window.location.href='keuangan_bayar?id=$id';
                </script>";
        } else {

            if($id_bank != ""){
                $data = array(
                    'id_keuangan'=>$id_keuangan,
                    'id_ppjb'=>$id_psjb,
                    'no_ppjb'=>$no_ppjb,
                    'tanggal_bayar'=>$tanggal_bayar,
                    'tahap'=>$tahap_bayar,
                    'pembayaran'=>$dana_bayar,
                    'dana_terkini'=>$dana_terkini,
                    'sisa_dana'=>$dana_kurang,
                    'id_bank'=>$id_bank,
                    'nama_bank'=>$nama_bank,
                    'kode_perumahan'=>$kode_perumahan,
                    'persen_pencairan'=>$persen,
                    'tahap_pencairan'=>$tahap_pencairan,
                    'cara_pembayaran'=>$cara_pembayaran,
                    'qr_code'=>$image_name
                );
        
                $this->db->insert('keuangan_kas_kpr', $data);
        
                $data1 = array(
                    'id_penerimaan'=>$id_keuangan,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tanggal_bayar,
                    'kategori'=>"piutang kas",
                    // 'jenis_terima'=>"",
                    'keterangan'=>$tahap_bayar." - PPJB No. ".$no_ppjb." - Perumahan - ".$kode_perumahan,
                    'nominal_awal'=>$dana_terkini,
                    'nominal_bayar'=>$dana_bayar,
                    'nominal_sisa'=>$dana_kurang,
                    'id_bank'=>$id_bank,
                    'nama_bank'=>$nama_bank,
                    'date_created'=>date('Y-m-d'),
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'cara_pembayaran'=>$cara_pembayaran,
                    'terima_dari'=>$nama_konsumen
                );
        
                $this->db->insert('keuangan_akuntansi', $data1);
            } else {
                $data = array(
                    'id_keuangan'=>$id_keuangan,
                    'id_ppjb'=>$id_psjb,
                    'no_ppjb'=>$no_ppjb,
                    'tanggal_bayar'=>$tanggal_bayar,
                    'tahap'=>$tahap_bayar,
                    'pembayaran'=>$dana_bayar,
                    'dana_terkini'=>$dana_terkini,
                    'sisa_dana'=>$dana_kurang,
                    // 'id_bank'=>$id_bank,
                    // 'nama_bank'=>$nama_bank,
                    'kode_perumahan'=>$kode_perumahan,
                    'persen_pencairan'=>$persen,
                    'tahap_pencairan'=>$tahap_pencairan,
                    'cara_pembayaran'=>$cara_pembayaran,
                    'qr_code'=>$image_name
                );
        
                $this->db->insert('keuangan_kas_kpr', $data);
        
                $data1 = array(
                    'id_penerimaan'=>$id_keuangan,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tanggal_bayar,
                    'kategori'=>"piutang kas",
                    // 'jenis_terima'=>"",
                    'keterangan'=>$tahap_bayar." - PPJB No. ".$no_ppjb." - Perumahan - ".$kode_perumahan,
                    'nominal_awal'=>$dana_terkini,
                    'nominal_bayar'=>$dana_bayar,
                    'nominal_sisa'=>$dana_kurang,
                    // 'id_bank'=>$id_bank,
                    // 'nama_bank'=>$nama_bank,
                    'date_created'=>date('Y-m-d'),
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'cara_pembayaran'=>$cara_pembayaran,
                    'terima_dari'=>$nama_konsumen
                );
        
                $this->db->insert('keuangan_akuntansi', $data1);
            }
    
            $query = $this->db->get_where('ppjb-dp', array('id_psjb'=>$id_psjb))->result();
    
            foreach($query as $row3){
                $dana_saatini = $row3->dana_bayar+$dana_bayar;
            }
    
            $data2 = array(
                'dana_sekarang'=>$dana_kurang,
                'dana_bayar'=>$dana_saatini
            );
    
            $this->db->update('ppjb-dp', $data2, array('id_psjb'=>$id_psjb));
    
            redirect('Dashboard/view_transaksi?id='.$no_ppjb.'&kode='.$kode_perumahan);
        }
        // exit;
    }

    public function edit_pembayaran(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_pembayaran'] = $this->db->get_where('keuangan_kas_kpr', array('id_keuangan'=>$id));
        // print_r($data['edit_pembayaran']->result());
        // exit;
        foreach($data['edit_pembayaran']->result() as $rows){
            $gt1 = $rows->id_ppjb;
        }

        $query = $this->db->get_where('ppjb-dp', array('id_psjb'=>$gt1))->result();
        // print_r($data['query']);
        // eix
        foreach($query as $row){
            $no_ppjb = $row->no_psjb;
            $cara_bayar = $row->cara_bayar;
            $kode_perumahan = $row->kode_perumahan;

            if($cara_bayar == "KPR"){
                $data['kpr'] = $this->db->get_where('ppjb-dp', array('id_psjb'=>$gt1, 'cara_bayar'=>"KPR"))->result();
            } else {
                $data['test'] = $this->db->get_where('ppjb-dp', array('id_psjb'=>$gt1))->result();
            }
        }
        // print_r($data['query']);
        // exit;

        $ppjb = $this->db->get_where('ppjb', array('no_psjb'=>$no_ppjb, 'kode_perumahan'=>$kode_perumahan))->result();
        foreach($ppjb as $row){
            $nama_konsumen = $row->nama_pemesan;
        }
        $data['nama_konsumen'] = $nama_konsumen;
        $data['id']=$gt1;
        $data['gt1']=$id;
        // print_r($data['nama_konsumen']);

        $this->load->view('transaksi_form_pembayaran', $data);
    }

    public function hapus_pembayaran(){
        $id = $_GET['id'];

        foreach($this->db->get_where('keuangan_kas_kpr', array('id_keuangan'=>$id))->result() as $row){
            $id_ppjb = $row->id_ppjb;
            $nominal = $row->pembayaran;
            $kode_perumahan = $row->kode_perumahan;

            foreach($this->db->get_where('ppjb-dp', array('id_psjb'=>$id_ppjb))->result() as $row1){
                $dana_sekarang = $row1->dana_sekarang;
                $dana_bayar = $row1->dana_bayar;
            }
        }

        $tl1 = $dana_sekarang + $nominal;
        $tl2 = $dana_bayar - $nominal;

        $data = array(
            'status'=>"belum lunas",
            'dana_sekarang'=>$tl1,
            'dana_bayar'=>$tl2
        );
        $this->db->update('ppjb-dp', $data, array('id_psjb'=>$id_ppjb));

        foreach($this->db->get_where('keuangan_akuntansi', array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"piutang kas"))->result() as $row2){
            $id_keuangan = $row2->id_keuangan;
        }

        $this->db->delete('keuangan_kas_kpr', array('id_keuangan'=>$id));
        $this->db->delete('keuangan_akuntansi', array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"piutang kas"));
        $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id_keuangan, 'jenis_keuangan'=>"penerimaan", 'kode_perumahan'=>$kode_perumahan));

        redirect('Dashboard/detail_pembayaran?id='.$id_ppjb);
    }

    public function detail_pembayaran(){
        $id=$_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('id_psjb', "ASC");
        $data['ppjb'] = $this->db->get_where('ppjb-dp', array('id_psjb'=>$id))->result();
        // print_r($data['ppjb']);
        // exit;
        foreach($data['ppjb'] as $row){
            $no_ppjb = $row->no_psjb;
            $kode_perumahan = $row->kode_perumahan;
            
            if($row->cara_bayar == "KPR"){
                $this->db->order_by('id_psjb', "ASC");
                $data['kpr'] = $this->db->get_where('ppjb-dp', array('id_psjb'=>$id, 'cara_bayar'=>"KPR"))->result();
            }
        }

        $data['query'] = $this->db->get_where('ppjb', array('no_psjb'=>$no_ppjb,'kode_perumahan'=>$kode_perumahan))->result();
        foreach($data['query'] as $row){
            $nama_konsumen = $row->nama_pemesan;
        }
        $data['nama_konsumen'] = $nama_konsumen;
        $data['detail_pembayaran'] = $this->db->get_where('keuangan_kas_kpr', array('id_ppjb'=>$id))->result();

        $this->load->view('transaksi_detail_pembayaran', $data);
    }

    public function pelunasan_pembayaran(){
        $id=$_GET['id'];

        $query = $this->db->get_where('ppjb-dp', array('id_psjb'=>$id))->result();
        foreach($query as $row){
            $id_psjb = $row->id_psjb;
            $no_ppjb = $row->no_psjb;
            $kode_perumahan = $row->kode_perumahan;
        }

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='piutang_konsumen_'.$id_psjb.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_kwitansi_pembayaran?id=".$id_psjb; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $no_kwitansi = 0; 
        
        // $check_data = $this->Dashboard_model->check_last_record_kwitansi();
        $this->db->limit(1);
        $this->db->order_by('no_kwitansi', "DESC");
        $check_data = $this->db->get_where('ppjb-dp', array('id_psjb'=>$id, 'kode_perumahan'=>$kode_perumahan))->result();
        foreach($check_data as $row){
            $no_kwitansi = $row->no_kwitansi + 1;
            $cara_bayar = $row->cara_bayar;
        }

        if($cara_bayar != "KPR"){

        }

        $data = array(
            'status'=>"lunas",
            'no_kwitansi'=>$no_kwitansi,
            'qr_code'=>$image_name
        );

        $this->db->update('ppjb-dp', $data, array('id_psjb'=>$id));

        redirect('Dashboard/view_transaksi?id='.$no_ppjb.'&kode='.$kode_perumahan);
    }

    public function print_kwitansi_pembayaran(){
        $id = $_GET['id'];
        // $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');

        $query = $this->db->get_where('ppjb-dp', array('id_psjb' => $id))->result();
        
        // $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id))->result();
        // print_r($query);
        $data['check_all'] = $query;
        // print_r($data['check_all']);
        
        // exit;

        foreach($data['check_all'] as $row){
            if($row->status == "lunas"){
                $data['ppjb'] = $this->db->get_where('ppjb', array('no_psjb'=>$row->no_psjb,'kode_perumahan'=>$row->kode_perumahan))->result();

                $data['pencetak'] = $this->session->flashdata('nama');
                // print_r($data['ppjb']);
                // exit;
                $this->load->library('pdf');
            
                $this->pdf->setPaper('A4', 'landscape');
                $this->pdf->filename = "print-psjb.pdf";
                ob_end_clean();
                $this->pdf->load_view('transaksi_kwitansi_print', $data);
            } else{
                echo "<script>
                    alert('Pembayaran belum lunas');
                    window.location.href='view_transaksi?id=$row->no_ppjb';
                    </script>";
            }
        }
    }

    public function print_kwitansi_pembayaran_temp(){
        $id = $_GET['id'];
        // $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');

        $query = $this->db->get_where('keuangan_kas_kpr', array('id_keuangan' => $id))->result();
        
        // $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id))->result();
        // print_r($query);
        $data['check_all'] = $query;
        // print_r($data['check_all']);
        
        // exit;
        foreach($data['check_all'] as $row){
            $data['ppjb'] = $this->db->get_where('ppjb', array('no_psjb'=>$row->no_ppjb,'kode_perumahan'=>$row->kode_perumahan))->result();

            $data['pencetak'] = $this->session->flashdata('nama');
            // print_r($data['ppjb']);
            // exit;
            $this->load->library('pdf');
        
            $this->pdf->setPaper('A4', 'landscape');
            $this->pdf->filename = "print-psjb.pdf";
            ob_end_clean();
            $this->pdf->load_view('transaksi_kwitansi_print_temp', $data);
        }

        // foreach($data['check_all'] as $row){
        //     if($row->status == "lunas"){
        //         $data['ppjb'] = $this->db->get_where('ppjb', array('no_psjb'=>$row->no_psjb,'kode_perumahan'=>$row->kode_perumahan))->result();

        //         // print_r($data['ppjb']);
        //         // exit;
        //     } else{
        //         echo "<script>
        //             alert('Pembayaran belum lunas');
        //             window.location.href='view_transaksi?id=$row->no_ppjb';
        //             </script>";
        //     }
        // }
    }

    //PENERIMAAN GROUND TANK
    public function penerimaan_ground_tank(){
        $data['nama'] = $this->session->userdata('nama');

        // $data['penerimaan_lain'] = $this->db->get('keuangan_ground_tank')->result();
        $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"ground tank"))->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        // $data['no_kwitansi'] = 1;
        // $check_data = $this->Dashboard_model->check_last_record_ground_tank("MSK");
        // foreach($check_data as $row){
        //     $data['no_kwitansi'] = $row->no_kwitansi + 1;
        // }

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['kode_perumahan'] = "";

        // $data['err_msg'] = $this->session->flashdata

        $this->load->view('transaksi_penerimaan_ground_tank', $data);
    }

    public function penerimaan_ground_tank_perumahan(){
        $kode_perumahan = $_POST['kode_perumahan'];

        $data['nama'] = $this->session->userdata('nama');

        $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"ground tank", 'kode_perumahan'=>$kode_perumahan))->result();
        $data['penerimaan_lain_perumahan'] = $this->db->get_where('kbk', array('kode_perumahan'=>$kode_perumahan, 'status'=>"approved"))->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['no_kwitansi'] = 1;
        $check_data = $this->Dashboard_model->check_last_record_ground_tank($kode_perumahan)->result();
        // print_r($check_data->result());
        // exit;
        foreach($check_data as $row){
            $data['no_kwitansi'] = $row->no_kwitansi + 1;
        }
        // echo $data['no_kwitansi']; exit;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['kode_perumahan'] = $kode_perumahan;

        // $data['err_msg'] = $this->session->flashdata

        $this->load->view('transaksi_penerimaan_ground_tank', $data);
    }

    public function filter_ground_tank(){
        // $jenis_penerimaan = $_POST['jenis_penerimaan'];
        $kode_perumahan = $_POST['perumahan'];
        
        $data['nama'] = $this->session->userdata('nama');
        // $data['jenis_penerimaan'] = $jenis_penerimaan;
        $data['kode_perumahan'] = $kode_perumahan;

        // if($kode_perumahan == "" && $jenis_penerimaan == ""){
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"ground tank"))->result();
        // } else if($kode_perumahan == "") {
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"ground tank", 'jenis_penerimaan'=>$jenis_penerimaan))->result();
        // } else if($jenis_penerimaan == "") {
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"ground tank", 'kode_perumahan'=>$kode_perumahan))->result();
        // } else {
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"ground tank", 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>$jenis_penerimaan))->result();
        // }
        $data['penerimaan_lain'] = $this->Dashboard_model->filter_penerimaan_lain("", $kode_perumahan, "ground tank")->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $this->load->view('transaksi_penerimaan_ground_tank', $data);
    }

    public function add_penerimaan_ground_tank(){
        $no_kwitansi = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];

        // $jenis_penerimaan = $_POST['jenis_penerimaan'];
        $no_unit = $_POST['no_unit'];
        $terima_dari = $_POST['terima_dari'];
        $keterangan = $_POST['keterangan_penerimaan'];
        $nilai_penerimaan = $_POST['nilai_penerimaan'];
        $tanggal_penerimaan = $_POST['tgl_penerimaan'];
        $jenis_pembayaran = $_POST['jenis_pembayaran'];
        $bank = $_POST['bank'];

        $id_keuangan = 1;
        // $check_data = $this->Dashboard_model->check_last_record_ground_tank($kode_perumahan);
        $this->db->order_by('id_keuangan', "DESC");
        $this->db->limit(1);
        $check_data = $this->db->get('keuangan_penerimaan_lain');
        foreach($check_data->result() as $row){
            $id_keuangan = $row->id_keuangan + 1;
        }

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date("Y-m-d");
        $status = "tutup";

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='ground_tank_'.$id_keuangan.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_penerimaan_lain?id=".$id_keuangan; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        // $query = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>"bphtb"));
        // $query1 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>"bbn"));

        if($bank != ""){
            $data = array(
                'id_keuangan'=>$id_keuangan,
                'no_kwitansi'=>$no_kwitansi,
                'kode_perumahan'=>$kode_perumahan,
                'kode_rumah'=>$no_unit,
                // 'jenis_penerimaan'=>$jenis_penerimaan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'terima_dari'=>$terima_dari,
                'keterangan'=>$keterangan,
                'dana_terima'=>$nilai_penerimaan,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                'jenis_pembayaran'=>$jenis_pembayaran,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_created'=>$date_by,
                'status'=>$status,
                'kategori'=>"ground tank",
                'qr_code'=>$image_name
            );
    
            $this->db->insert('keuangan_penerimaan_lain', $data);
    
            $data1 = array(
                'id_penerimaan'=>$id_keuangan,
                'kode_perumahan'=>$kode_perumahan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'kategori'=>"ground tank",
                // 'jenis_terima'=>
                'keterangan'=>$keterangan,
                'nominal_bayar'=>$nilai_penerimaan,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                'date_created'=>$date_by,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'terima_dari'=>$terima_dari
            );
    
            $this->db->insert('keuangan_akuntansi', $data1);
        }else {
            $data = array(
                'id_keuangan'=>$id_keuangan,
                'no_kwitansi'=>$no_kwitansi,
                'kode_perumahan'=>$kode_perumahan,
                'kode_rumah'=>$no_unit,
                // 'jenis_penerimaan'=>$jenis_penerimaan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'terima_dari'=>$terima_dari,
                'keterangan'=>$keterangan,
                'dana_terima'=>$nilai_penerimaan,
                'jenis_pembayaran'=>$jenis_pembayaran,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_created'=>$date_by,
                'status'=>$status,
                'kategori'=>"ground tank",
                'qr_code'=>$image_name
            );
    
            $this->db->insert('keuangan_penerimaan_lain', $data);
    
            $data1 = array(
                'id_penerimaan'=>$id_keuangan,
                'kode_perumahan'=>$kode_perumahan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'kategori'=>"ground tank",
                // 'jenis_terima'=>
                'keterangan'=>$keterangan,
                'nominal_bayar'=>$nilai_penerimaan,
                'date_created'=>$date_by,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'terima_dari'=>$terima_dari
            );
    
            $this->db->insert('keuangan_akuntansi', $data1);
        }
    
        $data['nama'] = $this->session->userdata('nama');

        $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['succ_msg'] = "Data sudah ditambahkan";

        // $this->load->view('transaksi_penerimaan_ground_tank', $data);
        
        $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
        redirect('Dashboard/penerimaan_ground_tank');
    }

    public function edit_ground_tank(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_ground_tank'] = $this->db->get_where('keuangan_penerimaan_lain', array('id_keuangan'=>$id));

        $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"ground tank"))->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('transaksi_penerimaan_ground_tank', $data);
    }

    public function edit_update_ground_tank(){
        $id = $_POST['id'];

        $no_kwitansi = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $jenis_penerimaan = $_POST['jenis_penerimaan'];
        $terima_dari = $_POST['terima_dari'];
        $keterangan = $_POST['keterangan_penerimaan'];
        $nilai_penerimaan = $_POST['nilai_penerimaan'];
        $tanggal_penerimaan = $_POST['tgl_penerimaan'];
        $jenis_pembayaran = $_POST['jenis_pembayaran'];
        $bank = $_POST['bank'];

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $id_created_by = $this->session->userdata('u_id');
        // $created_by = $this->session->userdata('nama');
        // $date_by = date("Y-m-d");
        $status = "tutup";
        $no_unit = $_POST['no_unit'];

        foreach($this->db->get_where('keuangan_akuntansi', array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"ground tank"))->result() as $akt){
            $id_uang = $akt->id_keuangan;
        }

        $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id_uang, 'kode_perumahan'=>$kode_perumahan, 'jenis_keuangan'=>"penerimaan"));

        if($bank != ""){
            $data = array(
                // 'id_keuangan'=>$id_keuangan,
                'no_kwitansi'=>$no_kwitansi,
                'kode_perumahan'=>$kode_perumahan,
                // 'jenis_penerimaan'=>$jenis_penerimaan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'terima_dari'=>$terima_dari,
                'keterangan'=>$keterangan,
                'dana_terima'=>$nilai_penerimaan,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                'jenis_pembayaran'=>$jenis_pembayaran,
                // 'id_created_by'=>$id_created_by,
                // 'created_by'=>$created_by,
                // 'date_created'=>$date_by,
                'status'=>$status,
                'kategori'=>"ground tank",
                // 'kode_rumah'=>
            );

            $this->db->update('keuangan_penerimaan_lain', $data, array('id_keuangan'=>$id));
            
            $data1 = array(
                // 'id_penerimaan'=>$id_keuangan,
                'kode_perumahan'=>$kode_perumahan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'kategori'=>"ground tank",
                // 'jenis_terima'=>
                'keterangan'=>$keterangan,
                'nominal_bayar'=>$nilai_penerimaan,
                'cara_pembayaran'=>$jenis_pembayaran,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                // 'date_created'=>$date_by,
                // 'id_created_by'=>$id_created_by,
                // 'created_by'=>$created_by,
                'terima_dari'=>$terima_dari,
                'status'=>""
            );

            $this->db->update('keuangan_akuntansi', $data1, array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"ground tank"));
        } else {
            $data = array(
                // 'id_keuangan'=>$id_keuangan,
                // 'no_kwitansi'=>$no_kwitansi,
                'kode_perumahan'=>$kode_perumahan,
                // 'jenis_penerimaan'=>$jenis_penerimaan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'terima_dari'=>$terima_dari,
                'keterangan'=>$keterangan,
                'dana_terima'=>$nilai_penerimaan,
                'jenis_pembayaran'=>$jenis_pembayaran,
                // 'id_created_by'=>$id_created_by,
                // 'created_by'=>$created_by,
                // 'date_created'=>$date_by,
                'status'=>$status,
                'kategori'=>"ground tank",
                'kode_rumah'
            );

            $this->db->update('keuangan_penerimaan_lain', $data, array('id_keuangan'=>$id));
            
            $data1 = array(
                // 'id_penerimaan'=>$id_keuangan,
                'kode_perumahan'=>$kode_perumahan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'kategori'=>"ground tank",
                // 'jenis_terima'=>
                'keterangan'=>$keterangan,
                'cara_pembayaran'=>$jenis_pembayaran,
                'nominal_bayar'=>$nilai_penerimaan,
                // 'date_created'=>$date_by,
                // 'id_created_by'=>$id_created_by,
                // 'created_by'=>$created_by,
                'terima_dari'=>$terima_dari,
                'status'=>""
            );

            $this->db->update('keuangan_akuntansi', $data1, array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"ground tank"));
        }
    
        $data['nama'] = $this->session->userdata('nama');

        $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['succ_msg'] = "Data sudah ditambahkan";

        // $this->load->view('transaksi_penerimaan_lain', $data);
        $this->session->set_flashdata('succ_msg', 'Data sudah diperbarui');

        redirect('Dashboard/edit_ground_tank?id='.$id);
    }

    public function hapus_ground_tank(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        foreach($this->db->get_where('keuangan_akuntansi', array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode, 'kategori'=>"ground tank"))->result() as $row){
            $id_keuangan = $row->id_keuangan;
        }

        $this->db->delete('keuangan_penerimaan_lain', array('id_keuangan'=>$id));

        $this->db->delete('keuangan_akuntansi', array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode, 'kategori'=>"ground tank"));

        $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id_keuangan, 'kode_perumahan'=>$kode, 'jenis_keuangan'=>"penerimaan"));

        $this->session->set_flashdata('succ_msg', "Data sukses dihapus!");

        redirect('Dashboard/penerimaan_ground_tank');
    }
    //END OF PENERIMAAN GROUND TANK

    //PENERIMAAN TAMBAHAN BANGUNAN
    public function penerimaan_tambahan_bangunan(){
        $data['nama'] = $this->session->userdata('nama');

        // $data['penerimaan_lain'] = $this->db->get('keuangan_tambahan_bangunan')->result();
        $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"tambahan bangunan"))->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['kode_perumahan'] = "";

        $this->load->view('transaksi_penerimaan_tambahan_bangunan', $data);
    }

    public function penerimaan_tambahan_bangunan_perumahan(){
        $kode_perumahan = $_POST['kode_perumahan'];

        $data['nama'] = $this->session->userdata('nama');

        $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"tambahan bangunan", 'kode_perumahan'=>$kode_perumahan))->result();
        $data['penerimaan_lain_perumahan'] = $this->db->get_where('kbk', array('kode_perumahan'=>$kode_perumahan, 'status'=>"approved"))->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['no_kwitansi'] = 1;
        $check_data = $this->Dashboard_model->check_last_record_tambahan_bangunan($kode_perumahan)->result();
        foreach($check_data as $row){
            $data['no_kwitansi'] = $row->no_kwitansi + 1;
        }

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['kode_perumahan'] = $kode_perumahan;

        // $data['err_msg'] = $this->session->flashdata

        $this->load->view('transaksi_penerimaan_tambahan_bangunan', $data);
    }

    public function filter_tambahan_bangunan(){
        // $jenis_penerimaan = $_POST['jenis_penerimaan'];
        $kode_perumahan = $_POST['perumahan'];
        
        $data['nama'] = $this->session->userdata('nama');
        // $data['jenis_penerimaan'] = $jenis_penerimaan;
        $data['kode_perumahan'] = $kode_perumahan;

        // if($kode_perumahan == "" && $jenis_penerimaan == ""){
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"tambahan bangunan"))->result();
        // } else if($kode_perumahan == "") {
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"tambahan bangunan", 'jenis_penerimaan'=>$jenis_penerimaan))->result();
        // } else if($jenis_penerimaan == "") {
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"tambahan bangunan", 'kode_perumahan'=>$kode_perumahan))->result();
        // } else {
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"tambahan bangunan", 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>$jenis_penerimaan))->result();
        // }
        $data['penerimaan_lain'] = $this->Dashboard_model->filter_penerimaan_lain("", $kode_perumahan, "tambahan bangunan")->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $this->load->view('transaksi_penerimaan_tambahan_bangunan', $data);
    }

    public function add_tambahan_bangunan(){
        $no_kwitansi = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $jenis_penerimaan = $_POST['jenis_penerimaan'];
        $terima_dari = $_POST['terima_dari'];
        $keterangan = $_POST['keterangan_penerimaan'];
        $nilai_penerimaan = $_POST['nilai_penerimaan'];
        $tanggal_penerimaan = $_POST['tgl_penerimaan'];
        $jenis_pembayaran = $_POST['jenis_pembayaran'];
        $bank = $_POST['bank'];

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date("Y-m-d");
        $status = "tutup";
        $no_unit = $_POST['no_unit'];

        $id_keuangan = 1;
        $this->db->order_by('id_keuangan', "DESC");
        $this->db->limit(1);
        $check_data = $this->db->get('keuangan_penerimaan_lain');
        // $check_data = $this->Dashboard_model->check_last_record_tambahan_bangunan($kode_perumahan);
        foreach($check_data->result() as $row){
            $id_keuangan = $row->id_keuangan + 1;
        }

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='tambahan_bangunan_'.$id_keuangan.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_penerimaan_lain?id=".$id_keuangan; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        // $query = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>"bphtb"));
        // $query1 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>"bbn"));

        if($bank != ""){
            $data = array(
                'id_keuangan'=>$id_keuangan,
                'no_kwitansi'=>$no_kwitansi,
                'kode_perumahan'=>$kode_perumahan,
                // 'jenis_penerimaan'=>$jenis_penerimaan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'terima_dari'=>$terima_dari,
                'keterangan'=>$keterangan,
                'dana_terima'=>$nilai_penerimaan,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                'jenis_pembayaran'=>$jenis_pembayaran,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_created'=>$date_by,
                'status'=>$status,
                'kategori'=>"tambahan bangunan",
                'kode_rumah'=>$no_unit,
                'qr_code'=>$image_name
            );

            $this->db->insert('keuangan_penerimaan_lain', $data);
            
            $data1 = array(
                'id_penerimaan'=>$id_keuangan,
                'kode_perumahan'=>$kode_perumahan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'kategori'=>"tambahan bangunan",
                // 'jenis_terima'=>
                'keterangan'=>$keterangan,
                'nominal_bayar'=>$nilai_penerimaan,
                'cara_pembayaran'=>$jenis_pembayaran,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                'date_created'=>$date_by,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'terima_dari'=>$terima_dari
            );

            $this->db->insert('keuangan_akuntansi', $data1);
        } else {
            $data = array(
                'id_keuangan'=>$id_keuangan,
                'no_kwitansi'=>$no_kwitansi,
                'kode_perumahan'=>$kode_perumahan,
                // 'jenis_penerimaan'=>$jenis_penerimaan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'terima_dari'=>$terima_dari,
                'keterangan'=>$keterangan,
                'dana_terima'=>$nilai_penerimaan,
                'jenis_pembayaran'=>$jenis_pembayaran,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_created'=>$date_by,
                'status'=>$status,
                'kategori'=>"tambahan bangunan",
                'kode_rumah'=>$no_unit,
                'qr_code'=>$image_name
            );

            $this->db->insert('keuangan_penerimaan_lain', $data);
            
            $data1 = array(
                'id_penerimaan'=>$id_keuangan,
                'kode_perumahan'=>$kode_perumahan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'kategori'=>"tambahan bangunan",
                // 'jenis_terima'=>
                'keterangan'=>$keterangan,
                'cara_pembayaran'=>$jenis_pembayaran,
                'nominal_bayar'=>$nilai_penerimaan,
                'date_created'=>$date_by,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'terima_dari'=>$terima_dari
            );

            $this->db->insert('keuangan_akuntansi', $data1);
        }
    
        $data['nama'] = $this->session->userdata('nama');

        $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['succ_msg'] = "Data sudah ditambahkan";

        // $this->load->view('transaksi_penerimaan_lain', $data);
        $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
        redirect('Dashboard/penerimaan_tambahan_bangunan');
    }

    public function edit_tambahan_bangunan(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_tambahan_bangunan'] = $this->db->get_where('keuangan_penerimaan_lain', array('id_keuangan'=>$id));

        $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"tambahan bangunan"))->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('transaksi_penerimaan_tambahan_bangunan', $data);
    }

    public function edit_update_tambahan_bangunan(){
        $id = $_POST['id'];

        $no_kwitansi = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $jenis_penerimaan = $_POST['jenis_penerimaan'];
        $terima_dari = $_POST['terima_dari'];
        $keterangan = $_POST['keterangan_penerimaan'];
        $nilai_penerimaan = $_POST['nilai_penerimaan'];
        $tanggal_penerimaan = $_POST['tgl_penerimaan'];
        $jenis_pembayaran = $_POST['jenis_pembayaran'];
        $bank = $_POST['bank'];

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $id_created_by = $this->session->userdata('u_id');
        // $created_by = $this->session->userdata('nama');
        // $date_by = date("Y-m-d");
        $status = "tutup";
        $no_unit = $_POST['no_unit'];

        foreach($this->db->get_where('keuangan_akuntansi', array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"tambahan bangunan"))->result() as $akt){
            $id_uang = $akt->id_keuangan;
        }

        $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id_uang, 'kode_perumahan'=>$kode_perumahan, 'jenis_keuangan'=>"penerimaan"));

        if($bank != ""){
            $data = array(
                // 'id_keuangan'=>$id_keuangan,
                'no_kwitansi'=>$no_kwitansi,
                'kode_perumahan'=>$kode_perumahan,
                // 'jenis_penerimaan'=>$jenis_penerimaan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'terima_dari'=>$terima_dari,
                'keterangan'=>$keterangan,
                'dana_terima'=>$nilai_penerimaan,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                'jenis_pembayaran'=>$jenis_pembayaran,
                // 'id_created_by'=>$id_created_by,
                // 'created_by'=>$created_by,
                // 'date_created'=>$date_by,
                'status'=>$status,
                'kategori'=>"tambahan bangunan",
                // 'kode_rumah'=>
            );

            $this->db->update('keuangan_penerimaan_lain', $data, array('id_keuangan'=>$id));
            
            $data1 = array(
                // 'id_penerimaan'=>$id_keuangan,
                'kode_perumahan'=>$kode_perumahan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'kategori'=>"tambahan bangunan",
                // 'jenis_terima'=>
                'keterangan'=>$keterangan,
                'nominal_bayar'=>$nilai_penerimaan,
                'cara_pembayaran'=>$jenis_pembayaran,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                // 'date_created'=>$date_by,
                // 'id_created_by'=>$id_created_by,
                // 'created_by'=>$created_by,
                'terima_dari'=>$terima_dari,
                'status'=>""
            );

            $this->db->update('keuangan_akuntansi', $data1, array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"tambahan bangunan"));
        } else {
            $data = array(
                // 'id_keuangan'=>$id_keuangan,
                // 'no_kwitansi'=>$no_kwitansi,
                'kode_perumahan'=>$kode_perumahan,
                // 'jenis_penerimaan'=>$jenis_penerimaan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'terima_dari'=>$terima_dari,
                'keterangan'=>$keterangan,
                'dana_terima'=>$nilai_penerimaan,
                'jenis_pembayaran'=>$jenis_pembayaran,
                // 'id_created_by'=>$id_created_by,
                // 'created_by'=>$created_by,
                // 'date_created'=>$date_by,
                'status'=>$status,
                'kategori'=>"tambahan bangunan",
                'kode_rumah'
            );

            $this->db->update('keuangan_penerimaan_lain', $data, array('id_keuangan'=>$id));
            
            $data1 = array(
                // 'id_penerimaan'=>$id_keuangan,
                'kode_perumahan'=>$kode_perumahan,
                'tanggal_dana'=>$tanggal_penerimaan,
                'kategori'=>"tambahan bangunan",
                // 'jenis_terima'=>
                'keterangan'=>$keterangan,
                'cara_pembayaran'=>$jenis_pembayaran,
                'nominal_bayar'=>$nilai_penerimaan,
                // 'date_created'=>$date_by,
                // 'id_created_by'=>$id_created_by,
                // 'created_by'=>$created_by,
                'terima_dari'=>$terima_dari,
                'status'=>""
            );

            $this->db->update('keuangan_akuntansi', $data1, array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"tambahan bangunan"));
        }
    
        $data['nama'] = $this->session->userdata('nama');

        $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['succ_msg'] = "Data sudah ditambahkan";

        // $this->load->view('transaksi_penerimaan_lain', $data);
        $this->session->set_flashdata('succ_msg', 'Data sudah diperbarui');

        redirect('Dashboard/edit_tambahan_bangunan?id='.$id);
    }

    public function hapus_tambahan_bangunan(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        foreach($this->db->get_where('keuangan_akuntansi', array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode, 'kategori'=>"tambahan bangunan"))->result() as $row){
            $id_keuangan = $row->id_keuangan;
        }

        $this->db->delete('keuangan_penerimaan_lain', array('id_keuangan'=>$id));

        $this->db->delete('keuangan_akuntansi', array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode, 'kategori'=>"tambahan bangunan"));

        $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id_keuangan, 'kode_perumahan'=>$kode, 'jenis_keuangan'=>"penerimaan"));

        $this->session->set_flashdata('succ_msg', "Data sukses dihapus!");

        redirect('Dashboard/penerimaan_tambahan_bangunan');
    }
    //END OF PENERIMAAN TAMBAHAN BANGUNAN

    //PENERIMAAN LAIN-LAIN
    public function penerimaan_lain(){
        $data['nama'] = $this->session->userdata('nama');

        $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"penerimaan lain"))->result();
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('transaksi_penerimaan_lain', $data);
    }

    public function filter_penerimaan_lain(){
        $jenis_penerimaan = $_POST['jenis_penerimaan'];
        $kode_perumahan = $_POST['perumahan'];
        
        $data['nama'] = $this->session->userdata('nama');
        $data['jenis_penerimaan'] = $jenis_penerimaan;
        $data['kode_perumahan'] = $kode_perumahan;

        // if($kode_perumahan == "" && $jenis_penerimaan == ""){
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"penerimaan lain"))->result();
        // } else if($kode_perumahan == "") {
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"penerimaan lain", 'jenis_penerimaan'=>$jenis_penerimaan))->result();
        // } else if($jenis_penerimaan == "") {
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"penerimaan lain", 'kode_perumahan'=>$kode_perumahan))->result();
        // } else {
        //     $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"penerimaan lain", 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>$jenis_penerimaan))->result();
        // }

        $data['penerimaan_lain'] = $this->Dashboard_model->filter_penerimaan_lain($jenis_penerimaan, $kode_perumahan, "penerimaan lain")->result();

        // if($kode_perumahan == "") {
        //     if($jenis_penerimaan == ""){
        //         $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
        //     } else {
        //         $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('$jenis_penerimaan'=>$jenis_penerimaan))->result();
        //     }
        // } else {
        //     if($jenis_penerimaan == ""){
        //         $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kode_perumahan'=>$kode_perumahan))->result();
        //     } else {
        //         $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kode_perumahan'=>$kode_perumahan, '$jenis_penerimaan'=>$jenis_penerimaan))->result();
        //     }
        // }
        
        $data['bank'] = $this->db->get('bank')->result();

        $this->load->view('transaksi_penerimaan_lain', $data);
    }

    public function get_kwitansi_penerimaan_lain(){
        $no_kwitansi = $_POST['country'];
        $kode_perumahan = $_POST['kode'];

        if($kode_perumahan == ""){
            echo "<div style='color: red'>Silahkan pilih proyek perumahan dahulu!</div>";
        } else {
            if($no_kwitansi != ""){
                $this->db->like('no_kwitansi', $no_kwitansi);
                $this->db->order_by('no_kwitansi', "DESC");
                $gt = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"penerimaan lain", 'kode_perumahan'=>$kode_perumahan));
    
                if($gt->num_rows() > 0){
                    echo "<div style='color: red'>No Kwitansi telah ada!</div>";
                } else {
                    echo "<div style='color: green'>No Kwitansi dapat digunakan!</div>";
                }
    
                echo "<div style='background-color: lightgrey'><div>Daftar kwitansi yang terdaftar :</div>";
                echo "<ul>";
                foreach($gt->result() as $row){
                    echo "<li>$row->no_kwitansi</li>";
                }
                echo "</ul><div>";
            } else {
                echo "<div style='color: red'>Silahkan masukkan nomor kwitansi!</div>";
            }
        }
    }

    public function add_penerimaan_lain(){
        $no_kwitansi = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $jenis_penerimaan = $_POST['jenis_penerimaan'];
        $terima_dari = $_POST['terima_dari'];
        $keterangan = $_POST['keterangan_penerimaan'];
        $nilai_penerimaan = $_POST['nilai_penerimaan'];
        $tanggal_penerimaan = $_POST['tgl_penerimaan'];
        $jenis_pembayaran = $_POST['jenis_pembayaran'];
        $bank = $_POST['bank'];

        $no_ppjb = $_POST['ppjb'];
        $jenis_kwitansi = $_POST['kwitansi_ppjb'];
        // echo $no_ppjb."-".$jenis_kwitansi;
        // exit;

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date("Y-m-d");
        $status = "tutup";

        $id_keuangan = 1;
        $this->db->order_by('id_keuangan', "DESC");
        $this->db->limit(1);
        $check_data = $this->db->get('keuangan_penerimaan_lain');
        // $check_data = $this->Dashboard_model->check_last_record_ground_tank($kode_perumahan);
        foreach($check_data->result() as $row){
            $id_keuangan = $row->id_keuangan + 1;
        }
        // echo $id_keuangan;
        // exit;
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='penerimaan_lain_'.$id_keuangan.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_penerimaan_lain?id=".$id_keuangan; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        if($jenis_kwitansi == "ppjb"){
            $query = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_ppjb, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>$jenis_penerimaan));
            // $query1 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_ppjb, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>$jenis_penerimaan));
            // echo $query->num_rows();
            // echo $query1->num_rows();
            // exit;

            if($bank == ""){
                $data = array(
                    'id_keuangan'=>$id_keuangan,
                    'no_kwitansi'=>$no_ppjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'jenis_penerimaan'=>$jenis_penerimaan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'terima_dari'=>$terima_dari,
                    'keterangan'=>$keterangan,
                    'dana_terima'=>$nilai_penerimaan,
                    'jenis_pembayaran'=>$jenis_pembayaran,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'date_created'=>$date_by,
                    'status'=>$status,
                    'kategori'=>"penerimaan lain",
                    'jenis_kwitansi'=>$jenis_kwitansi,
                    'qr_code'=>$image_name
                );
            } else {
                $data = array(
                    'id_keuangan'=>$id_keuangan,
                    'no_kwitansi'=>$no_ppjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'jenis_penerimaan'=>$jenis_penerimaan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'terima_dari'=>$terima_dari,
                    'keterangan'=>$keterangan,
                    'dana_terima'=>$nilai_penerimaan,
                    'id_bank'=>$bank,
                    'nama_bank'=>$nama_bank,
                    'jenis_pembayaran'=>$jenis_pembayaran,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'date_created'=>$date_by,
                    'status'=>$status,
                    'kategori'=>"penerimaan lain",
                    'jenis_kwitansi'=>$jenis_kwitansi,
                    'qr_code'=>$image_name
                );
            }

            if($query->num_rows() > 0){ 
                $data['nama'] = $this->session->userdata('nama');
        
                $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
                
                $data['bank'] = $this->db->get('bank')->result();
        
                // $data['err_msg'] = "Data sudah ada";
        
                // $this->load->view('transaksi_penerimaan_lain', $data);
                $this->session->set_flashdata('err_msg', 'Data sudah ada');
                redirect('Dashboard/penerimaan_lain');
            } else {
                $this->db->insert('keuangan_penerimaan_lain', $data);

                if($bank != ""){
                    $data1 = array(
                        'id_penerimaan'=>$id_keuangan,
                        'kode_perumahan'=>$kode_perumahan,
                        'tanggal_dana'=>$tanggal_penerimaan,
                        'kategori'=>"penerimaan lain",
                        'jenis_terima'=>$jenis_penerimaan,
                        'keterangan'=>$keterangan,
                        'nominal_bayar'=>$nilai_penerimaan,
                        'id_bank'=>$bank,
                        'nama_bank'=>$nama_bank,
                        'date_created'=>$date_by,
                        'id_created_by'=>$id_created_by,
                        'created_by'=>$created_by,
                        'terima_dari'=>$terima_dari,
                        'jenis_kwitansi'=>$jenis_kwitansi,
                        'cara_pembayaran'=>$jenis_pembayaran
                    );
                } else {
                    $data1 = array(
                        'id_penerimaan'=>$id_keuangan,
                        'kode_perumahan'=>$kode_perumahan,
                        'tanggal_dana'=>$tanggal_penerimaan,
                        'kategori'=>"penerimaan lain",
                        'jenis_terima'=>$jenis_penerimaan,
                        'keterangan'=>$keterangan,
                        'nominal_bayar'=>$nilai_penerimaan,
                        'date_created'=>$date_by,
                        'id_created_by'=>$id_created_by,
                        'created_by'=>$created_by,
                        'terima_dari'=>$terima_dari,
                        'jenis_kwitansi'=>$jenis_kwitansi,
                        'cara_pembayaran'=>$jenis_pembayaran
                    );
                }
        
                $this->db->insert('keuangan_akuntansi', $data1);
        
                $data['nama'] = $this->session->userdata('nama');
        
                $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
                
                $data['bank'] = $this->db->get('bank')->result();
        
                // $data['succ_msg'] = "Data sudah ditambahkan";
        
                // $this->load->view('transaksi_penerimaan_lain', $data);
                $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
                redirect('Dashboard/penerimaan_lain');
            }
        } else {
            // $query = $this->db->get_where('keuangan_penerimaan_lain', array('kode_perumahan'=>$kode_perumahan));
            $query1 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));

            if($bank == ""){
                $data = array(
                    'id_keuangan'=>$id_keuangan,
                    'no_kwitansi'=>$no_kwitansi,
                    'kode_perumahan'=>$kode_perumahan,
                    'jenis_penerimaan'=>$jenis_penerimaan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'terima_dari'=>$terima_dari,
                    'keterangan'=>$keterangan,
                    'dana_terima'=>$nilai_penerimaan,
                    'jenis_pembayaran'=>$jenis_pembayaran,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'date_created'=>$date_by,
                    'status'=>$status,
                    'kategori'=>"penerimaan lain",
                    'jenis_kwitansi'=>$jenis_kwitansi,
                    'qr_code'=>$image_name
                );
            } else {
                $data = array(
                    'id_keuangan'=>$id_keuangan,
                    'no_kwitansi'=>$no_kwitansi,
                    'kode_perumahan'=>$kode_perumahan,
                    'jenis_penerimaan'=>$jenis_penerimaan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'terima_dari'=>$terima_dari,
                    'keterangan'=>$keterangan,
                    'dana_terima'=>$nilai_penerimaan,
                    'id_bank'=>$bank,
                    'nama_bank'=>$nama_bank,
                    'jenis_pembayaran'=>$jenis_pembayaran,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'date_created'=>$date_by,
                    'status'=>$status,
                    'kategori'=>"penerimaan lain",
                    'jenis_kwitansi'=>$jenis_kwitansi,
                    'qr_code'=>$image_name
                );
            }

            if($query1->num_rows() > 0){    
                $data['nama'] = $this->session->userdata('nama');
        
                $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
                
                $data['bank'] = $this->db->get('bank')->result();
        
                // $data['err_msg'] = "Data sudah ada";
        
                // $this->load->view('transaksi_penerimaan_lain', $data);
                $this->session->set_flashdata('err_msg', 'Data sudah ada');
                redirect('Dashboard/penerimaan_lain');
            } else {
                $this->db->insert('keuangan_penerimaan_lain', $data);

                if($bank != ""){
                    $data1 = array(
                        'id_penerimaan'=>$id_keuangan,
                        'kode_perumahan'=>$kode_perumahan,
                        'tanggal_dana'=>$tanggal_penerimaan,
                        'kategori'=>"penerimaan lain",
                        'jenis_terima'=>$jenis_penerimaan,
                        'keterangan'=>$keterangan,
                        'nominal_bayar'=>$nilai_penerimaan,
                        'id_bank'=>$bank,
                        'nama_bank'=>$nama_bank,
                        'date_created'=>$date_by,
                        'id_created_by'=>$id_created_by,
                        'created_by'=>$created_by,
                        'terima_dari'=>$terima_dari,
                        'jenis_kwitansi'=>$jenis_kwitansi,
                        'cara_pembayaran'=>$jenis_pembayaran
                    );
                } else {
                    $data1 = array(
                        'id_penerimaan'=>$id_keuangan,
                        'kode_perumahan'=>$kode_perumahan,
                        'tanggal_dana'=>$tanggal_penerimaan,
                        'kategori'=>"penerimaan lain",
                        'jenis_terima'=>$jenis_penerimaan,
                        'keterangan'=>$keterangan,
                        'nominal_bayar'=>$nilai_penerimaan,
                        'date_created'=>$date_by,
                        'id_created_by'=>$id_created_by,
                        'created_by'=>$created_by,
                        'terima_dari'=>$terima_dari,
                        'jenis_kwitansi'=>$jenis_kwitansi,
                        'cara_pembayaran'=>$jenis_pembayaran
                    );
                }
        
                $this->db->insert('keuangan_akuntansi', $data1);
        
                $data['nama'] = $this->session->userdata('nama');
        
                $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
                
                $data['bank'] = $this->db->get('bank')->result();
        
                // $data['succ_msg'] = "Data sudah ditambahkan";
        
                // $this->load->view('transaksi_penerimaan_lain', $data);
                $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
                redirect('Dashboard/penerimaan_lain');
            }
        }
    }

    public function edit_penerimaan_lain(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');
        $data['edit_penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('id_keuangan'=>$id));
        $data['penerimaan_lain'] = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"penerimaan lain"))->result();

        $data['bank'] = $this->db->get('bank')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('transaksi_penerimaan_lain', $data);
    }

    public function edit_ubah_penerimaan_lain(){
        $id_keuangan = $_POST['id'];

        $no_kwitansi = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $jenis_penerimaan = $_POST['jenis_penerimaan'];
        $terima_dari = $_POST['terima_dari'];
        $keterangan = $_POST['keterangan_penerimaan'];
        $nilai_penerimaan = $_POST['nilai_penerimaan'];
        $tanggal_penerimaan = $_POST['tgl_penerimaan'];
        $jenis_pembayaran = $_POST['jenis_pembayaran'];
        $bank = $_POST['bank'];

        $no_ppjb = $_POST['ppjb'];
        $jenis_kwitansi = $_POST['kwitansi_ppjb'];
        // echo $no_ppjb."-".$jenis_kwitansi;
        // exit;

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date("Y-m-d");
        $status = "tutup";

        // $id_keuangan = 1;
        // $check_data = $this->Dashboard_model->check_last_record_ground_tank($kode_perumahan);
        // foreach($check_data->result() as $row){
        //     $id_keuangan = $row->id_keuangan + 1;
        // }
        // echo $id_keuangan; exit;

        foreach($this->db->get_where('keuangan_akuntansi', array('id_penerimaan'=>$id_keuangan, 'kategori'=>"penerimaan lain", 'kode_perumahan'=>$kode_perumahan))->result() as $akt){
            $id_uang = $akt->id_keuangan;
        }
        // echo $id_uang;
        // exit;
        $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id_uang, 'kode_perumahan'=>$kode_perumahan, 'jenis_keuangan'=>"penerimaan"));

        if($jenis_kwitansi == "ppjb"){
            // $query = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_ppjb, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>$jenis_penerimaan));
            // $query1 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_ppjb, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>$jenis_penerimaan));
            // echo $query->num_rows();
            // echo $query1->num_rows();
            // exit;

            if($bank == ""){
                $data = array(
                    'no_kwitansi'=>$no_ppjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'jenis_penerimaan'=>$jenis_penerimaan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'terima_dari'=>$terima_dari,
                    'keterangan'=>$keterangan,
                    'dana_terima'=>$nilai_penerimaan,
                    'jenis_pembayaran'=>$jenis_pembayaran,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'date_created'=>$date_by,
                    'status'=>$status,
                    'kategori'=>"penerimaan lain",
                    'jenis_kwitansi'=>$jenis_kwitansi
                );
            } else {
                $data = array(
                    'no_kwitansi'=>$no_ppjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'jenis_penerimaan'=>$jenis_penerimaan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'terima_dari'=>$terima_dari,
                    'keterangan'=>$keterangan,
                    'dana_terima'=>$nilai_penerimaan,
                    'id_bank'=>$bank,
                    'nama_bank'=>$nama_bank,
                    'jenis_pembayaran'=>$jenis_pembayaran,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'date_created'=>$date_by,
                    'status'=>$status,
                    'kategori'=>"penerimaan lain",
                    'jenis_kwitansi'=>$jenis_kwitansi
                );
            }
            $this->db->update('keuangan_penerimaan_lain', $data, array('id_keuangan'=>$id_keuangan));

            if($bank != ""){
                $data1 = array(
                    'id_penerimaan'=>$id_keuangan,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'kategori'=>"penerimaan lain",
                    'jenis_terima'=>$jenis_penerimaan,
                    'keterangan'=>$keterangan,
                    'nominal_bayar'=>$nilai_penerimaan,
                    'id_bank'=>$bank,
                    'nama_bank'=>$nama_bank,
                    'date_created'=>$date_by,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'terima_dari'=>$terima_dari,
                    'jenis_kwitansi'=>$jenis_kwitansi,
                    'status'=>"",
                    'cara_pembayaran'=>$jenis_pembayaran
                );
            } else {
                $data1 = array(
                    'id_penerimaan'=>$id_keuangan,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'kategori'=>"penerimaan lain",
                    'jenis_terima'=>$jenis_penerimaan,
                    'keterangan'=>$keterangan,
                    'nominal_bayar'=>$nilai_penerimaan,
                    'date_created'=>$date_by,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'terima_dari'=>$terima_dari,
                    'jenis_kwitansi'=>$jenis_kwitansi,
                    'status'=>"",
                    'cara_pembayaran'=>$jenis_pembayaran
                );
            }
    
            $this->db->update('keuangan_akuntansi', $data1, array('id_penerimaan'=>$id_keuangan, 'kategori'=>"penerimaan lain", 'kode_perumahan'=>$kode_perumahan));
    
            $data['nama'] = $this->session->userdata('nama');
    
            $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
            
            $data['bank'] = $this->db->get('bank')->result();
    
            // $data['succ_msg'] = "Data sudah ditambahkan";
    
            // $this->load->view('transaksi_penerimaan_lain', $data);
            $this->session->set_flashdata('succ_msg', 'Data sudah diperbarui');
            redirect('Dashboard/edit_penerimaan_lain?id='.$id_keuangan);
        } else {
            // $query = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));
            // $query1 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));

            if($bank == ""){
                $data = array(
                    'no_kwitansi'=>$no_kwitansi,
                    'kode_perumahan'=>$kode_perumahan,
                    'jenis_penerimaan'=>$jenis_penerimaan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'terima_dari'=>$terima_dari,
                    'keterangan'=>$keterangan,
                    'dana_terima'=>$nilai_penerimaan,
                    'jenis_pembayaran'=>$jenis_pembayaran,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'date_created'=>$date_by,
                    'status'=>$status,
                    'kategori'=>"penerimaan lain",
                    'jenis_kwitansi'=>$jenis_kwitansi
                );
            } else {
                $data = array(
                    'no_kwitansi'=>$no_kwitansi,
                    'kode_perumahan'=>$kode_perumahan,
                    'jenis_penerimaan'=>$jenis_penerimaan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'terima_dari'=>$terima_dari,
                    'keterangan'=>$keterangan,
                    'dana_terima'=>$nilai_penerimaan,
                    'id_bank'=>$bank,
                    'nama_bank'=>$nama_bank,
                    'jenis_pembayaran'=>$jenis_pembayaran,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'date_created'=>$date_by,
                    'status'=>$status,
                    'kategori'=>"penerimaan lain",
                    'jenis_kwitansi'=>$jenis_kwitansi
                );
            }

            $this->db->update('keuangan_penerimaan_lain', $data, array('id_keuangan'=>$id_keuangan));

            if($bank != ""){
                $data1 = array(
                    'id_penerimaan'=>$id_keuangan,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'kategori'=>"penerimaan lain",
                    'jenis_terima'=>$jenis_penerimaan,
                    'keterangan'=>$keterangan,
                    'nominal_bayar'=>$nilai_penerimaan,
                    'id_bank'=>$bank,
                    'nama_bank'=>$nama_bank,
                    'date_created'=>$date_by,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'terima_dari'=>$terima_dari,
                    'jenis_kwitansi'=>$jenis_kwitansi,
                    'status'=>"",
                    'cara_pembayaran'=>$jenis_pembayaran
                );
            } else {
                $data1 = array(
                    'id_penerimaan'=>$id_keuangan,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tanggal_penerimaan,
                    'kategori'=>"penerimaan lain",
                    'jenis_terima'=>$jenis_penerimaan,
                    'keterangan'=>$keterangan,
                    'nominal_bayar'=>$nilai_penerimaan,
                    'date_created'=>$date_by,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'terima_dari'=>$terima_dari,
                    'jenis_kwitansi'=>$jenis_kwitansi,
                    'status'=>"",
                    'cara_pembayaran'=>$jenis_pembayaran
                );
            }
    
            $this->db->update('keuangan_akuntansi', $data1, array('id_penerimaan'=>$id_keuangan, 'kode_perumahan'=>$kode_perumahan, 'kategori'=>"penerimaan lain"));
    
            $data['nama'] = $this->session->userdata('nama');
    
            $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
            
            $data['bank'] = $this->db->get('bank')->result();
    
            // $data['succ_msg'] = "Data sudah ditambahkan";
    
            // $this->load->view('transaksi_penerimaan_lain', $data);
            $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
            redirect('Dashboard/edit_penerimaan_lain?id='.$id_keuangan);
        }
    }

    public function hapus_penerimaan_lain(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $this->db->delete('keuangan_penerimaan_lain', array('id_keuangan'=>$id));

        foreach($this->db->get_where('keuangan_akuntansi', array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode, 'kategori'=>"penerimaan lain"))->result() as $row){
            $id_uang = $row->id_keuangan;
        }

        $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id_uang, 'kode_perumahan'=>$kode, 'jenis_keuangan'=>"penerimaan"));

        $this->db->delete('keuangan_akuntansi', array('id_penerimaan'=>$id, 'kode_perumahan'=>$kode, 'kategori'=>"penerimaan lain"));

        $this->session->set_flashdata('succ_msg', "Data sudah di hapus");
        redirect('Dashboard/penerimaan_lain');
    }

    public function print_penerimaan_lain(){
        $id = $_GET['id'];
        // $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');

        $query = $this->db->get_where('keuangan_penerimaan_lain', array('id_keuangan' => $id))->result();
        
        // $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id))->result();
        // print_r($query);
        $data['penerimaan_lain'] = $query;
        $data['out'] = $this->session->userdata('nama');
        
        // $data['ppjb'] = $this->db->get_where('ppjb', array('no_psjb'=>$row->no_ppjb,'kode_perumahan'=>$row->kode_perumahan))->result();

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-penerimaan-lain.pdf";
        ob_end_clean();
        $this->pdf->load_view('transaksi_print_penerimaan_lain', $data);
    }

    public function get_penerimaan_lain(){
        $id = $_POST['kode'];

        if($id != "Select"){
            echo "<option value='' id='ppjb_t_opt' disabled selected>-Pilih-</option>";
            foreach($this->db->get_where('ppjb', array('kode_perumahan'=>$id, 'status <>'=>"batal"))->result() as $row){
                echo "<option value='".$row->no_psjb."'>".$row->no_psjb."-".$row->nama_pemesan."</option>";
            }
        }
    }
    //END OF PENERIMAAN LAIN-LAIN

    //KONTROL PIUTANG
    public function kontrol_piutang(){
        $data['nama'] = $this->session->userdata('nama');

        $data['ppjb'] = $this->db->get_where('ppjb', array('status'=>"dom"))->result();

        $data['bulan'] = date('Y-m');
        $data['kode'] = "";

        $this->load->view('transaksi_kontrol_piutang', $data);
    }

    public function kontrol_piutang_bulan_ini(){
        $data['ppjb_dp'] = $this->db->get('ppjb-dp')->result();

        $today = date('Y-m');
        $data['mendekati']=0;
        $data['hari_ini']=0;
        $data['melewati']=0;

        foreach($data['ppjb_dp'] as $row){
            if($row->status=="belum lunas"){
                $tanggal_masuk = date('Y-m',$row->tanggal_dana);
                $no_ppjb = $row->no_psjb;
                $id_ppjb = $row->id_ppjb;

                $interval = strtotime($tanggal_masuk) - strtotime($today);
                $day = floor($interval / 86400); // 1 day
                if($day >= 1 && $day <= 7) {
                    $data['mendekati']++;
                } elseif($day < 0) {
                    $data['melewati']++;
                } elseif($day == 0) {
                    $data['hari_ini']++;
                }
            }
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('ppjb', array('status'=>"dom"));

        $this->load->view('keuangan_transaksi', $data);
    }

    public function filter_kontrol_piutang(){
        $kode_perumahan = $_POST['perumahan'];
        $bulan = $_POST['tanggal'];

        if($kode_perumahan == ""){
            $data['ppjb'] = $this->db->get_where('ppjb', array('status'=>"dom"))->result();
        }else{
            $data['ppjb'] = $this->db->get_where('ppjb', array('kode_perumahan'=>$kode_perumahan, 'status'=>"dom"))->result();

            $query = $this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result();
            foreach($query as $row){
                $nama_perumahan = $row->nama_perumahan;
            }
            $data['kode_perumahan']=$nama_perumahan;
        }
        
        $data['nama'] = $this->session->userdata('nama');

        $data['bulan'] = $bulan;
        $data['kode'] = $kode_perumahan;

        $this->load->view('transaksi_kontrol_piutang', $data);
    }

    public function kontrol_piutang_print(){
        $kode_perumahan = $_GET['kode'];
        $bulan = $_GET['id'];

        if($kode_perumahan != ""){
            $this->db->where('kode_perumahan', $kode_perumahan);
        }
        $data['ppjb'] = $this->db->get_where('ppjb', array('status'=>"dom"))->result();

        $data['bulan'] = $bulan;
        
        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-kontrol-piutang.pdf";
        ob_end_clean();
        $this->pdf->load_view('transaksi_kontrol_piutang_print', $data);
    }

    public function daftar_penagihan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['ppjb_dp'] = $this->db->get('ppjb-dp')->result();

        foreach($data['ppjb_dp'] as $row){
            $tanggal_dana = $row->tanggal_dana;
        }

        $data['bulan'] = date("Y-m");

        $data['kode_perumahan'] = "";

        // $month="Jul";
        // $year="2019";
        // $mydate="2018-12-01 00:00:00";
        
        // $joined = date("Ym", strtotime($mydate));
        
        // $askedfor = $month." ".$year;
        // $askedfor = date("Ym", strtotime($askedfor));
        
        // if ($askedfor > $joined) {
        // echo "yes";
        // }
        // else {
        // echo "no";
        // }
        // exit;

        $this->load->view('transaksi_penagihan', $data);
    }

    public function filter_daftar_penagihan(){
        $kode_perumahan = $_POST['perumahan'];
        $bulan = $_POST['tanggal'];
        // print_r($kode_perumahan);

        // echo $bulan;
        // exit;

        $data['nama'] = $this->session->userdata('nama');

        if($kode_perumahan != ""){
            $this->db->where('kode_perumahan', $kode_perumahan);
            $data['ppjb_dp'] = $this->db->get('ppjb-dp')->result();
        }

        $query = $this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result();
        foreach($query as $row){
            $nama_perumahan = $row->nama_perumahan;
        }
        $data['kode_perumahan']=$nama_perumahan;

        foreach($data['ppjb_dp'] as $row){
            $tanggal_dana = $row->tanggal_dana;
        }

        $data['bulan'] = date("Y-m", strtotime($bulan));
        $data['kode_perumahan'] = $kode_perumahan;
        // $data['bulans'] = $bulan;

        $this->load->view('transaksi_penagihan', $data);
    }

    public function print_penagihan(){
        $kode_perumahan = $_GET['id'];
        $bulan = $_GET['kd'];
        // $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');

        if($kode_perumahan == ""){
            $data['ppjb_dp'] = $this->db->get('ppjb-dp')->result();
        } else {
            $data['ppjb_dp'] = $this->db->get_where('ppjb-dp', array('kode_perumahan'=>$kode_perumahan))->result();

            $query = $this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result();
            foreach($query as $row){
                $nama_perumahan = $row->nama_perumahan;
            }
            $data['kode_perumahan']=$nama_perumahan;
        }

        foreach($data['ppjb_dp'] as $row){
            $tanggal_dana = $row->tanggal_dana;
        }

        $data['bulan'] = date("Y-m", strtotime($bulan));
        $data['kode_perumahan'] = $kode_perumahan;
        
        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-penagihan.pdf";
        ob_end_clean();
        $this->pdf->load_view('transaksi_penagihan_print', $data);
    }

    public function tambah_keterangan_penagihan(){
        $keterangan = $_POST['ket'];
        $id = $_POST['id'];

        for($i = 0; $i < count($keterangan); $i++){
            $data = array(
                'keterangan'=>$keterangan[$i]
            );
    
            $this->db->update('ppjb-dp', $data, array('id_psjb'=>$id[$i]));
        }

        redirect('Dashboard/daftar_penagihan');
    }

    //DAFTAR BALIK NAMA
    public function daftar_balik_nama(){
        $query = $this->db->get_where('ppjb', array('kode_perumahan'=>"MSK"));

        $data['nama'] = $this->session->userdata('nama');
        // $data['check_all'] = $query2;
        $data['ppjb'] = $query;

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('operasional_daftar_balik_nama_perumahan', $data);
    }

    public function view_daftar_balik_nama(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['id'] = $id;

        $data['ppjb'] = $this->db->get_where('ppjb', array('kode_perumahan'=>$id, 'status <>'=>"batal"));

        foreach($data['ppjb']->result() as $row) {
            $data['nama_perumahan'] = $row->kode_perumahan;
        }

        // $data['files'] = $this->db->get_where('produksi_img', array('id_termin'=>$id));

        $this->load->view('operasional_daftar_balik_nama', $data);
    }

    public function filter_daftar_balik_nama(){
        $kode = $_POST['perumahan'];

        if($kode == ""){
            $query = $this->db->get_where('ppjb', array('status <>'=>"batal"));
        } else {
            $query = $this->db->get_where('ppjb', array('kode_perumahan'=>$kode, 'status <>'=>"batal"));
        }
        // foreach($query->result() as $row){
        //     $no_ppjb = $row->no_psjb;
        //     $kode_perumahan = $row->kode_perumahan;

        //     // $query2 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_ppjb, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>"bpthb"));
            
        //     // print_r($query2->num_rows());
        // }
        // exit;
        $data['nama'] = $this->session->userdata('nama');
        // $data['check_all'] = $query2;
        $data['ppjb'] = $query;

        // $data['files'] = $this->db->get_where('produksi_img', array('id_termin'=>$id));

        $this->load->view('operasional_daftar_balik_nama', $data);
    }

    public function upload_foto_pajak(){
        $id = $_GET['id'];
        // $ids = $_GET['ids'];
        // $kode = $_GET['kode'];

        $config['upload_path']   = FCPATH.'/gambar/pajak/';
        $config['allowed_types'] = 'gif|jpg|png|ico|pdf';
        $this->load->library('upload',$config);

        if($this->upload->do_upload('userfile')){
            $token=$this->input->post('token_foto');
            $nama=$this->upload->data('file_name');
            $this->db->insert('operasional_ppjb_img',array('id_ppjb'=>$id, 'file_name'=>$nama,'token'=>$token, 'created_by'=>$this->session->userdata('nama'), 'date_by'=>date('Y-m-d H:i:sa am/pm')));
        }
    }

    public function remove_file_pajak(){
        //Ambil token foto
		$token=$this->input->post('token');
		
		$foto=$this->db->get_where('operasional_ppjb_img',array('token'=>$token));

		if($foto->num_rows()>0){
			$hasil=$foto->row();
			$nama_foto=$hasil->nama_foto;
			if(file_exists($file=FCPATH.'/gambar/termin/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('operasional_ppjb_img',array('token'=>$token));

        }
        
		echo "{}";
    }

    

    public function remove_foto_pajak(){
        $id = $_GET['id'];
        // $ids = $_GET['ids'];
        $kode = $_GET['kode'];
        $file = $_GET['file'];
        $id_img = $_GET['img'];

        unlink(FCPATH.'/gambar/pajak/'.$file);
        $this->db->delete('operasional_ppjb_img', array('id_img'=>$id_img));

        redirect('Dashboard/view_daftar_balik_nama?id='.$kode);
    }

    public function remove_all_foto_pajak(){
        $id = $_GET['id'];
        // $ids = $_GET['ids'];
        $kode = $_GET['kode'];

        $query = $this->db->get_where('operasional_ppjb_img', array('id_ppjb'=>$id));
        foreach($query->result() as $row){
            unlink(FCPATH.'/gambar/pajak/'.$row->file_name);
        }

        $this->db->delete('operasional_ppjb_img', array('id_ppjb'=>$id));

        redirect('Dashboard/view_daftar_balik_nama?id='.$kode);
    }

    public function get_file_foto_pajak(){
        $id = $_POST['country'];
        $kode = $_POST['kode'];

        if(isset($id)){
            $files = $this->db->get_where('operasional_ppjb_img', array('id_ppjb'));

            // echo "TEST";
            echo '<div>Preview foto/file yang telah diupload! (Tipe file: .jpg, .png, .pdf) (Uploaded:';
            echo $files->num_rows().'pics)'; 
            echo '<a href="'.base_url('Dashboard/remove_all_foto_pajak?id='.$id.'&kode='.$kode).'"><u>Delete All</u></a></div>';
            echo '<div class="row">';
            foreach($files->result() as $row){
                echo '<div class="card">
                    <div class="card-body">
                        <a href="'.base_url().'gambar/pajak/'.$row->file_name.'" download>
                            <img src="'.base_url().'gambar/pajak/'.$row->file_name.'" style="width: 70px; height: 50px">
                        </a>
                    </div>
                    <div class="card-footer" style="text-align: center">
                        <u><a href="'.base_url().'Dashboard/remove_foto_pajak?img='.$row->id_img.'&file='.$row->file_name.'&id='.$id.'&kode='.$kode.'">Hapus</a></u>
                    </div>
                </div>';
            }
            echo '</div>';
        }  
    }

    public function data_dbm(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        // $kode_perumahan = $_GET['per'];

        $data['data_dbm'] = $this->db->get_where('ppjb', array('id_psjb'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;
        $data['kode'] = $kode;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('operasional_daftar_form', $data);
        // redirect('Dashboard/daftar_balik_nama');
    }
    
    public function data_dbm_unit2(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['kode'] = $kode;
        // $kode_perumahan = $_GET['per'];

        $data['data_dbm_unit2'] = $this->db->get_where('rumah', array('id_rumah'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('operasional_daftar_form', $data);
        // redirect('Dashboard/daftar_balik_nama');
    }

    public function update_data_dbm(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_psjb = $_POST['no_psjb'];
        $no_ajb = $_POST['no_ajb'];
        $no_su = $_POST['no_su'];
        $nama_sertif = $_POST['nama_sertif'];
        $ktp = $_POST['ktp'];
        $kk = $_POST['kk'];
        $tgl_berkas = $_POST['tgl_berkas'];

        $no_kavling = $_POST['no_kavling'];
        // $kode_perumahan = $_POST['kode_perumahan'];
        $no_shm = $_POST['no_shm'];
        $no_pbb = $_POST['no_pbb'];

        $data = array(
            'no_ajb'=>$no_ajb,
            'no_su'=>$no_su,
            'nama_sertif'=>$nama_sertif,
            'ktp_ada'=>$ktp,
            'kk_ada'=>$kk,
            'tgl_terima'=>$tgl_berkas
        );

        $this->db->update('ppjb', $data, array('id_psjb'=>$id));

        $data1 = array(
            'nama_sertif'=>$nama_sertif
        );

        $this->db->update('psjb', $data1, array('no_psjb'=>$no_psjb, 'kode_perumahan'=>$kode_perumahan));

        $data2 = array(
            'no_shm'=>$no_shm,
            'no_pbb'=>$no_pbb,
        );

        $this->db->update('rumah', $data2, array('kode_rumah'=>$no_kavling, 'kode_perumahan'=>$kode_perumahan));

        $this->session->set_flashdata('succ_msg', "Data berhasil diperbarui!");

        redirect('Dashboard/data_dbm?id='.$id.'&kode='.$kode_perumahan);
    }
    
    public function update_data_dbm_unit2(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_psjb = $_POST['no_psjb'];
        $no_ajb = $_POST['no_ajb'];
        $no_su = $_POST['no_su'];
        $nama_sertif = $_POST['nama_sertif'];
        $ktp = $_POST['ktp'];
        $kk = $_POST['kk'];
        $tgl_berkas = $_POST['tgl_berkas'];

        $no_kavling = $_POST['no_kavling'];
        // $kode_perumahan = $_POST['kode_perumahan'];
        $no_shm = $_POST['no_shm'];
        $no_pbb = $_POST['no_pbb'];

        $data = array(
            'no_ajb'=>$no_ajb,
            'no_su'=>$no_su,
            'nama_sertif'=>$nama_sertif,
            'ktp_ada'=>$ktp,
            'kk_ada'=>$kk,
            'tgl_terima'=>$tgl_berkas,
            'no_shm'=>$no_shm,
            'no_pbb'=>$no_pbb,
        );

        $this->db->update('rumah', $data, array('id_rumah'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil diperbarui!");

        redirect('Dashboard/data_dbm_unit2?id='.$id.'&kode='.$kode_perumahan);
    }

    public function notaris_dbm(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['kode'] = $kode;
        // $kode_perumahan = $_GET['per'];

        $data['notaris_dbm'] = $this->db->get_where('ppjb', array('id_psjb'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('operasional_daftar_form', $data);
        // redirect('Dashboard/daftar_balik_nama');
    }

    public function notaris_dbm_unit2(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['kode'] = $kode;
        // $kode_perumahan = $_GET['per'];

        $data['notaris_dbm_unit2'] = $this->db->get_where('rumah', array('id_rumah'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('operasional_daftar_form', $data);
    }

    public function update_notaris_dbm(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_psjb = $_POST['no_psjb'];

        $id_notaris = $_POST['notaris'];

        $notaris_masukdata = $_POST['notaris_masukdata'];
        $notaris_keluarajb = $_POST['notaris_keluarajb'];
        $notaris_ttdajb = $_POST['notaris_ttdajb'];
        $notaris_prosesajb = $_POST['notaris_prosesajb'];
        $notaris_ajbselesai = $_POST['notaris_ajbselesai'];

        $data = array(
            'id_notaris'=>$id_notaris,
            'notaris_masukdata'=>$notaris_masukdata,
            'notaris_keluarajb'=>$notaris_keluarajb,
            'notaris_ttdajb'=>$notaris_ttdajb,
            'notaris_prosesajb'=>$notaris_prosesajb,
            'notaris_ajbselesai'=>$notaris_ajbselesai
        );

        $this->db->update('ppjb', $data, array('id_psjb'=>$id));

        // foreach($this->db->get_where('ppjb', array('id_psjb'=>$id))->result() as $row){
        //     foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as $row1){

        //     }
        // }
        
        // $this->db->update('rumah', $data, array('id_rumah'=>$id_rumah));

        $this->session->set_flashdata('succ_msg', "Data berhasil diperbarui!");

        redirect('Dashboard/notaris_dbm?id='.$id.'&kode='.$kode_perumahan);
    }

    public function update_notaris_dbm_unit2(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_psjb = $_POST['no_psjb'];

        $id_notaris = $_POST['notaris'];

        $notaris_masukdata = $_POST['notaris_masukdata'];
        $notaris_keluarajb = $_POST['notaris_keluarajb'];
        $notaris_ttdajb = $_POST['notaris_ttdajb'];
        $notaris_prosesajb = $_POST['notaris_prosesajb'];
        $notaris_ajbselesai = $_POST['notaris_ajbselesai'];

        $data = array(
            'id_notaris'=>$id_notaris,
            'notaris_masukdata'=>$notaris_masukdata,
            'notaris_keluarajb'=>$notaris_keluarajb,
            'notaris_ttdajb'=>$notaris_ttdajb,
            'notaris_prosesajb'=>$notaris_prosesajb,
            'notaris_ajbselesai'=>$notaris_ajbselesai
        );

        $this->db->update('rumah', $data, array('id_rumah'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil diperbarui!");

        redirect('Dashboard/notaris_dbm_unit2?id='.$id.'&kode='.$kode_perumahan);
    }

    public function print_notaris(){
        $id = $_GET['id'];
        $ids = $_GET['ids'];

        $data['nama'] = $this->session->userdata('nama');

        $query = $this->db->get_where('ppjb', array('id_psjb' => $id))->result();
        
        // $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id))->result();
        // print_r($query);
        $data['check_all'] = $query;
        $data['notaris'] = $this->db->get_where('notaris', array('id_notaris'=>$ids))->result();

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "print_notaris.pdf";
        ob_end_clean();
        $this->pdf->load_view('operasional_serah_notaris', $data);
    }
    
    public function pajak_dbm(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['kode'] = $kode;
        // $kode_perumahan = $_GET['per'];

        $data['pajak_dbm'] = $this->db->get_where('ppjb', array('id_psjb'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('operasional_daftar_form', $data);
        // redirect('Dashboard/daftar_balik_nama');
    }
    
    public function pajak_dbm_unit2(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['kode'] = $kode;
        // $kode_perumahan = $_GET['per'];

        $data['pajak_dbm_unit2'] = $this->db->get_where('rumah', array('id_rumah'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('operasional_daftar_form', $data);
        // redirect('Dashboard/daftar_balik_nama');
    }

    public function update_pajak_dbm(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_psjb = $_POST['no_psjb'];

        $nilai_validasi = $_POST['nilai_validasi'];
        $bphtb = $_POST['bphtb'];
        $pph = $_POST['pph'];
        $kode_billing = $_POST['kode_billing'];
        $masa_aktif_kode_billing = $_POST['masa_aktif_kode_billing'];
        $masa_pajak = $_POST['masa_pajak'];
        $tgl_bayar_pajak = $_POST['tgl_bayar_pajak'];
        $bank_pajak = $_POST['bank_pajak'];
        $ntpn = $_POST['ntpn'];
        $ket_pajak = $_POST['ket_pajak'];

        $data = array(
            'nilai_validasi'=>$nilai_validasi,
            'bphtb'=>$bphtb,
            'pph'=>$pph,
            'kode_billing'=>$kode_billing,
            'masa_aktif_kode_billing'=>$masa_aktif_kode_billing,
            'masa_pajak'=>$masa_pajak,
            'tgl_bayar_pajak'=>$tgl_bayar_pajak,
            'id_bank_pajak'=>$bank_pajak,
            'ntpn'=>$ntpn,
            'ket_pajak'=>$ket_pajak
        );

        $this->db->update('ppjb', $data, array('id_psjb'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil diperbarui!");

        redirect('Dashboard/pajak_dbm?id='.$id.'&kode='.$kode_perumahan);
    }

    public function update_pajak_dbm_unit2(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_psjb = $_POST['no_psjb'];

        $nilai_validasi = $_POST['nilai_validasi'];
        $bphtb = $_POST['bphtb'];
        $pph = $_POST['pph'];
        $kode_billing = $_POST['kode_billing'];
        $masa_aktif_kode_billing = $_POST['masa_aktif_kode_billing'];
        $masa_pajak = $_POST['masa_pajak'];
        $tgl_bayar_pajak = $_POST['tgl_bayar_pajak'];
        $bank_pajak = $_POST['bank_pajak'];
        $ntpn = $_POST['ntpn'];
        $ket_pajak = $_POST['ket_pajak'];

        $data = array(
            'nilai_validasi'=>$nilai_validasi,
            'bphtb'=>$bphtb,
            'pph'=>$pph,
            'kode_billing'=>$kode_billing,
            'masa_aktif_kode_billing'=>$masa_aktif_kode_billing,
            'masa_pajak'=>$masa_pajak,
            'tgl_bayar_pajak'=>$tgl_bayar_pajak,
            'id_bank_pajak'=>$bank_pajak,
            'ntpn'=>$ntpn,
            'ket_pajak'=>$ket_pajak
        );

        $this->db->update('rumah', $data, array('id_rumah'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil diperbarui!");

        redirect('Dashboard/pajak_dbm_unit2?id='.$id.'&kode='.$kode_perumahan);
    }
    
    public function sertifikat_dbm(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['kode'] = $kode;
        // $kode_perumahan = $_GET['per'];

        $data['sertifikat_dbm'] = $this->db->get_where('ppjb', array('id_psjb'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('operasional_daftar_form', $data);
        // redirect('Dashboard/daftar_balik_nama');
    }
    
    public function sertifikat_dbm_unit2(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['kode'] = $kode;
        // $kode_perumahan = $_GET['per'];

        $data['sertifikat_dbm_unit2'] = $this->db->get_where('rumah', array('id_rumah'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('operasional_daftar_form', $data);
        // redirect('Dashboard/daftar_balik_nama');
    }

    public function update_sertifikat_dbm(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_psjb = $_POST['no_psjb'];
        $kota = $_POST['jenis_kota'];

        $tgl_kirim_sertif = $_POST['tgl_kirim_sertif'];
        $tgl_terima_ttd = $_POST['tgl_terima_ttd'];
        $tgl_terima_sertif = $_POST['tgl_terima_sertif'];
        $terima_oleh_sertif = $_POST['terima_oleh_sertif'];

        $data = array(
            'tgl_terima_sertif'=>$tgl_terima_sertif,
            'terima_oleh_sertif'=>$terima_oleh_sertif,
            'tgl_kirim_ttdterima'=>$tgl_kirim_sertif,
            'tgl_terima_ttdterima'=>$tgl_terima_ttd,
            'jenis_kota'=>$kota,
        );

        $this->db->update('ppjb', $data, array('id_psjb'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil diperbarui!");

        redirect('Dashboard/sertifikat_dbm?id='.$id.'&kode='.$kode_perumahan);
    }

    public function update_sertifikat_dbm_unit2(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_psjb = $_POST['no_psjb'];
        $kota = $_POST['jenis_kota'];

        $tgl_kirim_sertif = $_POST['tgl_kirim_sertif'];
        $tgl_terima_ttd = $_POST['tgl_terima_ttd'];
        $tgl_terima_sertif = $_POST['tgl_terima_sertif'];
        $terima_oleh_sertif = $_POST['terima_oleh_sertif'];

        $data = array(
            'tgl_terima_sertif'=>$tgl_terima_sertif,
            'terima_oleh_sertif'=>$terima_oleh_sertif,
            'tgl_kirim_ttdterima'=>$tgl_kirim_sertif,
            'tgl_terima_ttdterima'=>$tgl_terima_ttd,
            'jenis_kota'=>$kota,
        );

        $this->db->update('rumah', $data, array('id_rumah'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil diperbarui!");

        redirect('Dashboard/sertifikat_dbm_unit2?id='.$id.'&kode='.$kode_perumahan);
    }
    
    public function print_sertifikat_terima(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $query = $this->db->get_where('ppjb', array('id_psjb' => $id))->result();
        
        // $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id))->result();
        // print_r($query);
        $data['check_all'] = $query;

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "daftar-balik-nama-sertifikat.pdf";
        ob_end_clean();
        $this->pdf->load_view('operasional_serah_terima', $data);
        
    }

    public function imb_dbm(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['kode'] = $kode;
        // $kode_perumahan = $_GET['per'];

        $data['imb_dbm'] = $this->db->get_where('ppjb', array('id_psjb'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('operasional_daftar_form', $data);
    }

    public function imb_dbm_unit2(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['kode'] = $kode;
        // $kode_perumahan = $_GET['per'];

        $data['imb_dbm_unit2'] = $this->db->get_where('rumah', array('id_rumah'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('operasional_daftar_form', $data);
    }

    public function update_imb_dbm(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_psjb = $_POST['no_psjb'];
        // $kota = $_POST['jenis_kota'];

        // $tgl_kirim_sertif = $_POST['tgl_kirim_sertif'];
        // $tgl_terima_ttd = $_POST['tgl_terima_ttd'];
        $tgl_terima_sertif = $_POST['tgl_terima_sertif'];
        $terima_oleh_sertif = $_POST['terima_oleh_sertif'];

        $data = array(
            'tgl_terima_sertif'=>$tgl_terima_sertif,
            'terima_oleh_sertif'=>$terima_oleh_sertif,
            // 'tgl_kirim_ttdterima'=>$tgl_kirim_sertif,
            // 'tgl_terima_ttdterima'=>$tgl_terima_ttd,
            // 'jenis_kota'=>$kota,
        );

        $this->db->update('ppjb', $data, array('id_psjb'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil diperbarui!");

        redirect('Dashboard/imb_dbm?id='.$id.'&kode='.$kode_perumahan);
    }

    public function update_imb_dbm_unit2(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_psjb = $_POST['no_psjb'];
        // $kota = $_POST['jenis_kota'];

        // $tgl_kirim_sertif = $_POST['tgl_kirim_sertif'];
        // $tgl_terima_ttd = $_POST['tgl_terima_ttd'];
        $tgl_terima_sertif = $_POST['tgl_terima_sertif'];
        $terima_oleh_sertif = $_POST['terima_oleh_sertif'];

        $data = array(
            'tgl_terima_sertif'=>$tgl_terima_sertif,
            'terima_oleh_sertif'=>$terima_oleh_sertif,
            // 'tgl_kirim_ttdterima'=>$tgl_kirim_sertif,
            // 'tgl_terima_ttdterima'=>$tgl_terima_ttd,
            // 'jenis_kota'=>$kota,
        );

        $this->db->update('rumah', $data, array('id_rumah'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil diperbarui!");

        redirect('Dashboard/imb_dbm_unit2?id='.$id.'&kode='.$kode_perumahan);
    }
    //END OF DAFTAR BALIK NAMA

    //START OF PENGELUARAN

    public function transaksi_pengeluaran(){
        $data['nama'] = $this->session->userdata('nama');

        $data['bank'] = $this->db->get('bank')->result();

        $this->db->order_by('id_pengeluaran', "DESC");
        $data['pengeluaran'] = $this->db->get('keuangan_pengeluaran')->result();

        $data['error_upload'] = $this->session->flashdata('error_upload');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('transaksi_pengeluaran', $data);
    }

    public function check_kwitansi_pengeluaran(){
        $check = $_POST['country'];
        $kode = $_POST['kode'];
        
        $cek_kwitansi = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$check, 'kode_perumahan'=>$kode));
        $cek_kwitansi2 = $this->db->get_where('keuangan_pengeluaran_hutang', array('no_pengeluaran'=>$check, 'kode_perumahan'=>$kode));
        $cek_kwitansi3 = $this->db->get_where('produksi_master_transaksi', array('no_faktur'=>$check, 'kode_perumahan'=>$kode));
        
        if($kode == ""){
            echo "<span style='color: red'>Proyek perumahan belum dipilih</span>";
        } else {
            if($cek_kwitansi3->num_rows() > 0){
                echo "<span style='color: red'>No Kwitansi terdaftar sbg No Faktur Bahan!</span>";
            } else if($cek_kwitansi2->num_rows() > 0){
                echo "<span style='color: red'>No kwitansi terdaftar sbg Kwitansi Hutang!</span>";
            } else if($cek_kwitansi->num_rows() > 0){
                echo "<span style='color: red'>No kwitansi sudah ada!</span>";
            } else {
                echo "<span style='color: green'>No kwitansi tersedia</span>";
            }
        }
    }

    public function check_kwitansi_pengeluaran_list(){
        $check = $_POST['country'];
        $kode = $_POST['kode'];

        if(isset($check)){
            if($check == ""){

            } else {
                $this->db->like('no_pengeluaran', $check);
                $db = $this->db->get_where('keuangan_pengeluaran');

                echo "<div style='background-color: lightgreen'>No kwitansi yang terdaftar:</div>";
                echo "<ol style='background-color: lightgreen'>";
                foreach($db->result() as $row){
                    echo "<li>$row->no_pengeluaran</li>";
                }
                echo "</ol>";
            }
        }
    }    

    public function filter_transaksi_pengeluaran(){
        // echo $_POST['jenis_pengeluaran'];
        // exit;
        $kategori_pengeluaran = $_POST['kategori_pengeluaran'];
        $jenis_pengeluaran = $_POST['jenis_pengeluaran'];
        $jenis_pembayaran = $_POST['jenis_pembayaran'];
        $kode_perumahan = $_POST['kode_perumahan'];

        $data['nama'] = $this->session->userdata('nama');

        $data['bank'] = $this->db->get('bank')->result();

        $data['pengeluaran'] = $this->Dashboard_model->filter_transaksi_pengeluaran($kategori_pengeluaran, $jenis_pengeluaran, $jenis_pembayaran, $kode_perumahan);

        $data['error_upload'] = $this->session->flashdata('error_upload');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $data['kategori_pengeluaran'] = $kategori_pengeluaran;
        $data['jenis_pengeluaran'] = $jenis_pengeluaran;
        $data['jenis_pembayaran'] = $jenis_pembayaran;
        $data['kode_perumahan'] = $kode_perumahan;

        $this->load->view('transaksi_pengeluaran', $data);
    }

    public function get_jenis_pengeluaran(){
        $category = $_POST["country"];

        // Define country and city array
        $query = $this->db->get_where('keuangan_kode_pengeluaran', array('kode_induk'=>$category))->result();

        // Display city dropdown based on country name
        if($category !== 'Select'){
            // echo "<label>City:</label>";
            // echo "<select>";
            echo "<option value=''>Semua</option>";
            foreach($query as $value){
                echo "<option value=".$value->kode_pengeluaran.">".$value->kode_pengeluaran."-".$value->nama_pengeluaran."</option>";
            }
            // echo "</select>";
        } 
    }

    public function add_pengeluaran(){
        // $jenis_pengeluaran=$_POST['jenis_pengeluaran'];
        // $bank = $_POST['bank'];

        // echo $bank;

        // echo $jenis_pengeluaran;

        $no_kwitansi = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $terima_oleh = $_POST['terima_oleh'];
        $kategori_pengeluaran = $_POST['kategori_pengeluaran'];
        $jenis_pengeluaran = $_POST['jenis_pengeluaran'];
        $keterangan = $_POST['keterangan_pengeluaran'];
        $nilai_pengeluaran = $_POST['nilai_pengeluaran'];
        $tanggal_pengeluaran = $_POST['tgl_pengeluaran'];
        $cara_pembayaran = $_POST['cara_pembayaran'];
        $bank = $_POST['bank'];

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date("Y-m-d");
        // $status = "tutup";

        $jenis_pembayaran = $_POST['jenis_pembayaran'];
        $periode_awal = $_POST['periode_awal'];
        $periode_akhir = $_POST['periode_akhir'];

        $id_keuangan = 1;
        $this->db->order_by('id_pengeluaran', "DESC");
        $this->db->limit(1);
        $check_data = $this->db->get('keuangan_pengeluaran');
        // $check_data = $this->Dashboard_model->check_last_record_ground_tank();
        foreach($check_data->result() as $row){
            $id_keuangan = $row->id_pengeluaran + 1;
        }

        // echo $id_keuangan;
        // exit;

        // $query = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>"bphtb"));
        // $query1 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>"bbn"));

        $file_name = "";

        $config['upload_path']          = './gambar/pengeluaran/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		// $config['max_size']             = 1000;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
 
		$this->load->library('upload', $config);
 
        if($jenis_pembayaran == "cash"){
            $cek_kwitansi = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));
            $cek_kwitansi2 = $this->db->get_where('keuangan_pengeluaran_hutang', array('no_pengeluaran'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));

            $cek_kwitansi3 = $this->db->get_where('produksi_master_transaksi', array('no_faktur'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));
            // echo $cek_kwitansi->num_rows();
            // echo $cek_kwitansi2->num_rows();
            // exit;
            if($cek_kwitansi2->num_rows() > 0){
                $this->session->set_flashdata('err_msg', "No Kwitansi telah terdaftar sebagai transaksi Utang!");
                redirect('Dashboard/transaksi_pengeluaran');
            } else if($cek_kwitansi3->num_rows() > 0){
                $this->session->set_flashdata('err_msg', "No Kwitansi telah terdaftar sebagai nota faktur pembelian bahan!");
                redirect('Dashboard/transaksi_pengeluaran');
            } else if($cek_kwitansi->num_rows() > 0){
                $this->session->set_flashdata('err_msg', "Data sudah terdaftar!");
                redirect('Dashboard/transaksi_pengeluaran');
            } else {
            // foreach()
                if ( ! $this->upload->do_upload('berkas')){
                    // $data['error_upload'] = array('error' => $this->upload->display_errors());

                    // $data['nama'] = $this->session->userdata('nama');

                    // $data['check_all'] = $this->db->get('perumahan')->result();

                    $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));

                    if($bank != ""){
                        $data = array(
                            'id_pengeluaran'=>$id_keuangan,
                            'no_pengeluaran'=>$no_kwitansi,
                            'kategori_pengeluaran'=>$kategori_pengeluaran,
                            'jenis_pengeluaran'=>$jenis_pengeluaran,
                            'kode_perumahan'=>$kode_perumahan,
                            'terima_oleh'=>$terima_oleh,
                            'keterangan'=>$keterangan,
                            'jenis_pembayaran'=>$jenis_pembayaran,
                            'cara_pembayaran'=>$cara_pembayaran,
                            'nominal'=>$nilai_pengeluaran,
                            'tgl_pembayaran'=>$tanggal_pengeluaran,
                            'id_bank'=>$bank,
                            'nama_bank'=>$nama_bank,
                            'id_created_by'=>$id_created_by,
                            'created_by'=>$created_by,
                            'date_created'=>$date_by,
                            // 'file_name'=>$file_name
                            // 'status'=>$status,
                        );
            
                        $this->db->insert('keuangan_pengeluaran', $data);
                    } else {
                        $data = array(
                            'id_pengeluaran'=>$id_keuangan,
                            'no_pengeluaran'=>$no_kwitansi,
                            'kategori_pengeluaran'=>$kategori_pengeluaran,
                            'jenis_pengeluaran'=>$jenis_pengeluaran,
                            'kode_perumahan'=>$kode_perumahan,
                            'terima_oleh'=>$terima_oleh,
                            'keterangan'=>$keterangan,
                            'jenis_pembayaran'=>$jenis_pembayaran,
                            'cara_pembayaran'=>$cara_pembayaran,
                            'nominal'=>$nilai_pengeluaran,
                            'tgl_pembayaran'=>$tanggal_pengeluaran,
                            // 'id_bank'=>$bank,
                            // 'nama_bank'=>$nama_bank,
                            'id_created_by'=>$id_created_by,
                            'created_by'=>$created_by,
                            'date_created'=>$date_by,
                            // 'file_name'=>$file_name
                        );
            
                        $this->db->insert('keuangan_pengeluaran', $data);
                    }
                
                    $data['nama'] = $this->session->userdata('nama');
            
                    $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
                    
                    $data['bank'] = $this->db->get('bank')->result();
            
                    $data['succ_msg'] = "Data sudah ditambahkan";
            
                    
                    $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
                    redirect('Dashboard/transaksi_pengeluaran');
                    // $this->load->view('transaksi_penerimaan_lain', $data);
                    // $this->load->view('perumahan', $data);
                } else{
                    $upload = array('upload_data' => $this->upload->data());

                    // foreach($upload['upload_data']['file_name'] as $item){
                    //     $file_name = $item->file_name;
                    // }
                    // print_r($upload['upload_data']['file_name']);
                    // print_r($file_name);
                    // exit;
                    $file_name = $upload['upload_data']['file_name'];
                
                    if($bank != ""){
                        $data = array(
                            'id_pengeluaran'=>$id_keuangan,
                            'no_pengeluaran'=>$no_kwitansi,
                            'kategori_pengeluaran'=>$kategori_pengeluaran,
                            'jenis_pengeluaran'=>$jenis_pengeluaran,
                            'kode_perumahan'=>$kode_perumahan,
                            'terima_oleh'=>$terima_oleh,
                            'keterangan'=>$keterangan,
                            'jenis_pembayaran'=>$jenis_pembayaran,
                            'cara_pembayaran'=>$cara_pembayaran,
                            'nominal'=>$nilai_pengeluaran,
                            'tgl_pembayaran'=>$tanggal_pengeluaran,
                            'id_bank'=>$bank,
                            'nama_bank'=>$nama_bank,
                            'id_created_by'=>$id_created_by,
                            'created_by'=>$created_by,
                            'date_created'=>$date_by,
                            'file_name'=>$file_name
                            // 'status'=>$status,
                        );
            
                        $this->db->insert('keuangan_pengeluaran', $data);
                    } else {
                        $data = array(
                            'id_pengeluaran'=>$id_keuangan,
                            'no_pengeluaran'=>$no_kwitansi,
                            'kategori_pengeluaran'=>$kategori_pengeluaran,
                            'jenis_pengeluaran'=>$jenis_pengeluaran,
                            'kode_perumahan'=>$kode_perumahan,
                            'terima_oleh'=>$terima_oleh,
                            'keterangan'=>$keterangan,
                            'jenis_pembayaran'=>$jenis_pembayaran,
                            'cara_pembayaran'=>$cara_pembayaran,
                            'nominal'=>$nilai_pengeluaran,
                            'tgl_pembayaran'=>$tanggal_pengeluaran,
                            // 'id_bank'=>$bank,
                            // 'nama_bank'=>$nama_bank,
                            'id_created_by'=>$id_created_by,
                            'created_by'=>$created_by,
                            'date_created'=>$date_by,
                            'file_name'=>$file_name
                        );
            
                        $this->db->insert('keuangan_pengeluaran', $data);
                        
                    }
                
                    $data['nama'] = $this->session->userdata('nama');
            
                    $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
                    
                    $data['bank'] = $this->db->get('bank')->result();
            
                    $data['succ_msg'] = "Data sudah ditambahkan";
            
                    // $this->load->view('transaksi_penerimaan_lain', $data);
                    $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
                    redirect('Dashboard/transaksi_pengeluaran');
                }
            }
        } else { // KREDIT
            // $cek_kwitansi = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));
            // $cek_kwitansi2 = $this->db->get_where('keuangan_pengeluaran_hutang', array('no_pengeluaran'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));
            // $cek_kwitansi3 = $this->db->get_where('produksi_master_transaksi', array('no_faktur'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));

            $cek_kwitansi = $this->db->get_where('keuangan_pengeluaran_hutang', array('no_pengeluaran'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));
            $cek_kwitansi2 = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));
            $cek_kwitansi3 = $this->db->get_where('produksi_master_transaksi', array('no_faktur'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));
            
            if($cek_kwitansi->num_rows() > 0){
                $this->session->set_flashdata('err_msg', "Data sudah terdaftar sebagai Transaksi Utang!");
                redirect('Dashboard/transaksi_pengeluaran');
            } else if($cek_kwitansi3->num_rows() > 0){
                $this->session->set_flashdata('err_msg', "No Kwitansi telah terdaftar sebagai nota faktur pembelian bahan!");
                redirect('Dashboard/transaksi_pengeluaran');
            } else if($cek_kwitansi2->num_rows() > 0){
                $this->session->set_flashdata('err_msg', "Pengeluaran telah terdaftar!");
                redirect('Dashboard/transaksi_pengeluaran');
            } else {
                if ( ! $this->upload->do_upload('berkas')){
                    // $data['error_upload'] = array('error' => $this->upload->display_errors());

                    // $data['nama'] = $this->session->userdata('nama');

                    // $data['check_all'] = $this->db->get('perumahan')->result();

                    $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));

                    $data = array(
                        'no_pengeluaran'=>$no_kwitansi,
                        'kategori_pengeluaran'=>$kategori_pengeluaran,
                        'jenis_pengeluaran'=>$jenis_pengeluaran,
                        'kode_perumahan'=>$kode_perumahan,
                        'terima_oleh'=>$terima_oleh,
                        'keterangan'=>$keterangan,
                        'jenis_pembayaran'=>$jenis_pembayaran,
                        // 'cara_pembayaran'=>$cara_pembayaran,
                        'nominal'=>$nilai_pengeluaran,
                        'tgl_pembayaran'=>$tanggal_pengeluaran,
                        'periode_awal'=>$periode_awal,
                        'periode_akhir'=>$periode_akhir,
                        'status'=>"belum lunas",
                        // 'id_bank'=>$bank,
                        // 'nama_bank'=>$nama_bank,
                        'id_created_by'=>$id_created_by,
                        'created_by'=>$created_by,
                        'date_created'=>$date_by,
                        // 'file_name'=>$file_name
                    );
        
                    $this->db->insert('keuangan_pengeluaran_hutang', $data);
                    
                
                    $data['nama'] = $this->session->userdata('nama');
            
                    $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
                    
                    $data['bank'] = $this->db->get('bank')->result();
            
                    $data['succ_msg'] = "Data sudah ditambahkan";
            
                    // $this->load->view('transaksi_penerimaan_lain', $data);
                    $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
                    redirect('Dashboard/transaksi_pengeluaran_hutang');

                    // $this->load->view('perumahan', $data);
                }else{
                    $upload = array('upload_data' => $this->upload->data());

                    // foreach($upload['upload_data']['file_name'] as $item){
                    //     $file_name = $item->file_name;
                    // }
                    // print_r($upload['upload_data']['file_name']);
                    // print_r($file_name);
                    // exit;
                    $file_name = $upload['upload_data']['file_name'];
                    
                    $data = array(
                        'no_pengeluaran'=>$no_kwitansi,
                        'kategori_pengeluaran'=>$kategori_pengeluaran,
                        'jenis_pengeluaran'=>$jenis_pengeluaran,
                        'kode_perumahan'=>$kode_perumahan,
                        'terima_oleh'=>$terima_oleh,
                        'keterangan'=>$keterangan,
                        'jenis_pembayaran'=>$jenis_pembayaran,
                        // 'cara_pembayaran'=>$cara_pembayaran,
                        'nominal'=>$nilai_pengeluaran,
                        'tgl_pembayaran'=>$tanggal_pengeluaran,
                        'periode_awal'=>$periode_awal,
                        'periode_akhir'=>$periode_akhir,
                        'status'=>"belum lunas",
                        // 'id_bank'=>$bank,
                        // 'nama_bank'=>$nama_bank,
                        'id_created_by'=>$id_created_by,
                        'created_by'=>$created_by,
                        'date_created'=>$date_by,
                        'file_name'=>$file_name
                    );
        
                    $this->db->insert('keuangan_pengeluaran_hutang', $data);
                
                    $data['nama'] = $this->session->userdata('nama');
            
                    $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
                    
                    $data['bank'] = $this->db->get('bank')->result();
            
                    $data['succ_msg'] = "Data sudah ditambahkan";
            
                    // $this->load->view('transaksi_penerimaan_lain', $data);
                    $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
                    redirect('Dashboard/transaksi_pengeluaran_hutang');
                }
            }
        }
    }

    public function edit_pengeluaran(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_pengeluaran'] = $this->db->get_where('keuangan_pengeluaran', array('id_pengeluaran'=>$id));

        $data['bank'] = $this->db->get('bank')->result();

        $data['pengeluaran'] = $this->db->get('keuangan_pengeluaran')->result();

        $data['error_upload'] = $this->session->flashdata('error_upload');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('transaksi_pengeluaran', $data);
    }

    public function edit_update_pengeluaran(){
        $id = $_POST['id'];
        
        $no_kwitansi = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $terima_oleh = $_POST['terima_oleh'];
        $kategori_pengeluaran = $_POST['kategori_pengeluaran'];
        $jenis_pengeluaran = $_POST['jenis_pengeluaran'];
        $keterangan = $_POST['keterangan_pengeluaran'];
        $nilai_pengeluaran = $_POST['nilai_pengeluaran'];
        $tanggal_pengeluaran = $_POST['tgl_pengeluaran'];
        $cara_pembayaran = $_POST['cara_pembayaran'];
        $bank = $_POST['bank'];
        $jenis_pembayaran = $_POST['jenis_pembayaran'];

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date("Y-m-d");

        $old = $_POST['old'];
        $file_name = "";

        if($_FILES['berkas']['name']!=""){
            $config['upload_path']          = './gambar/pengeluaran';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            // $config['max_size']             = 1000;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
    
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('berkas')) {
                $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));

                if($bank != ""){
                    $data = array(
                        'kategori_pengeluaran'=>$kategori_pengeluaran,
                        'jenis_pengeluaran'=>$jenis_pengeluaran,
                        // 'no_pengeluaran'=>$no_kwitansi,
                        // 'kode_perumahan'=>$kode_perumahan,
                        'terima_oleh'=>$terima_oleh,
                        'keterangan'=>$keterangan,
                        // 'jenis_pembayaran'=>$jenis_pembayaran,
                        'cara_pembayaran'=>$cara_pembayaran,
                        'nominal'=>$nilai_pengeluaran,
                        'tgl_pembayaran'=>$tanggal_pengeluaran,
                        'id_bank'=>$bank,
                        'nama_bank'=>$nama_bank,
                        // 'filename'=>$file_name
                    );
                } else {
                    $data = array(
                        'kategori_pengeluaran'=>$kategori_pengeluaran,
                        'jenis_pengeluaran'=>$jenis_pengeluaran,
                        // 'no_pengeluaran'=>$no_kwitansi,
                        // 'kode_perumahan'=>$kode_perumahan,
                        'terima_oleh'=>$terima_oleh,
                        'keterangan'=>$keterangan,
                        // 'jenis_pembayaran'=>$jenis_pembayaran,
                        'cara_pembayaran'=>$cara_pembayaran,
                        'nominal'=>$nilai_pengeluaran,
                        'tgl_pembayaran'=>$tanggal_pengeluaran,
                        // 'id_bank'=>$bank,
                        // 'nama_bank'=>$nama_bank,
                        // 'filename'=>$file_name
                    );
                }

                $this->db->update('keuangan_pengeluaran', $data, array('id_pengeluaran'=>$id));

                $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'jenis_keuangan'=>"pengeluaran"));

                $this->session->set_flashdata('succ_msg', "Data sudah diperbarui");

                redirect('Dashboard/edit_pengeluaran?id='.$id);
            }
            else {
                $upload = array('upload_data' => $this->upload->data());
                
                if($old != ""){
                    unlink("gambar/".$old);
                }
                // foreach($upload['upload_data']['file_name'] as $item){
                //     $file_name = $item->file_name;
                // }
                // print_r($upload['upload_data']['file_name']);
                // print_r($file_name);
                // exit;
                $file_name = $upload['upload_data']['file_name'];

                if($bank != ""){
                    $data = array(
                        'kategori_pengeluaran'=>$kategori_pengeluaran,
                        'jenis_pengeluaran'=>$jenis_pengeluaran,
                        // 'no_pengeluaran'=>$no_kwitansi,
                        // 'kode_perumahan'=>$kode_perumahan,
                        'terima_oleh'=>$terima_oleh,
                        'keterangan'=>$keterangan,
                        // 'jenis_pembayaran'=>$jenis_pembayaran,
                        'cara_pembayaran'=>$cara_pembayaran,
                        'nominal'=>$nilai_pengeluaran,
                        'tgl_pembayaran'=>$tanggal_pengeluaran,
                        'id_bank'=>$bank,
                        'nama_bank'=>$nama_bank,
                        'file_name'=>$file_name
                    );
                } else {
                    $data = array(
                        'kategori_pengeluaran'=>$kategori_pengeluaran,
                        'jenis_pengeluaran'=>$jenis_pengeluaran,
                        // 'no_pengeluaran'=>$no_kwitansi,
                        // 'kode_perumahan'=>$kode_perumahan,
                        'terima_oleh'=>$terima_oleh,
                        'keterangan'=>$keterangan,
                        // 'jenis_pembayaran'=>$jenis_pembayaran,
                        'cara_pembayaran'=>$cara_pembayaran,
                        'nominal'=>$nilai_pengeluaran,
                        'tgl_pembayaran'=>$tanggal_pengeluaran,
                        // 'id_bank'=>$bank,
                        // 'nama_bank'=>$nama_bank,
                        'file_name'=>$file_name
                    );
                }

                $this->db->update('keuangan_pengeluaran', $data, array('id_pengeluaran'=>$id));

                $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'jenis_keuangan'=>"pengeluaran"));

                $this->session->set_flashdata('succ_msg', "Data sudah diperbarui");

                redirect('Dashboard/edit_pengeluaran?id='.$id);
            }
        } else {
            $upload = array('upload_data' => $this->upload->data());

            $file_name = $upload['upload_data']['file_name'];

            if($bank != ""){
                $data = array(
                    'kategori_pengeluaran'=>$kategori_pengeluaran,
                    'jenis_pengeluaran'=>$jenis_pengeluaran,
                    // 'no_pengeluaran'=>$no_kwitansi,
                    // 'kode_perumahan'=>$kode_perumahan,
                    'terima_oleh'=>$terima_oleh,
                    'keterangan'=>$keterangan,
                    // 'jenis_pembayaran'=>$jenis_pembayaran,
                    'cara_pembayaran'=>$cara_pembayaran,
                    'nominal'=>$nilai_pengeluaran,
                    'tgl_pembayaran'=>$tanggal_pengeluaran,
                    'id_bank'=>$bank,
                    'nama_bank'=>$nama_bank,
                    'file_name'=>$old
                );
            } else {
                $data = array(
                    'kategori_pengeluaran'=>$kategori_pengeluaran,
                    'jenis_pengeluaran'=>$jenis_pengeluaran,
                    // 'no_pengeluaran'=>$no_kwitansi,
                    // 'kode_perumahan'=>$kode_perumahan,
                    'terima_oleh'=>$terima_oleh,
                    'keterangan'=>$keterangan,
                    // 'jenis_pembayaran'=>$jenis_pembayaran,
                    'cara_pembayaran'=>$cara_pembayaran,
                    'nominal'=>$nilai_pengeluaran,
                    'tgl_pembayaran'=>$tanggal_pengeluaran,
                    // 'id_bank'=>$bank,
                    // 'nama_bank'=>$nama_bank,
                    'file_name'=>$old
                );
            }

            $this->db->update('keuangan_pengeluaran', $data, array('id_pengeluaran'=>$id));

            $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'jenis_keuangan'=>"pengeluaran"));

            $this->session->set_flashdata('succ_msg', "Data sudah diperbarui");

            redirect('Dashboard/edit_pengeluaran?id='.$id);
        }
    }

    public function hapus_pengeluaran(){
        $id = $_GET['id'];
        $kode_perumahan = "";
        foreach($this->db->get_where('keuangan_pengeluaran', array('id_pengeluaran'=>$id)) as $row){
            $kode_perumahan = $row->kode_perumahan;
        }

        $this->db->delete('keuangan_pengeluaran', array('id_pengeluaran'=>$id));

        $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id, 'kode_perumahan'=>$kode_perumahan, 'jenis_keuangan'=>"pengeluaran"));

        $this->session->set_flashdata('err_msg', "Data telah dihapus");

        redirect('Dashboard/transaksi_pengeluaran');
    }

    public function list_pph(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('id_psjb', "DESC");
        $data['check_all'] = $this->db->get_where('ppjb', array('pph <>'=>"0"));

        $this->load->view('operasional_list_pph', $data);
    }

    public function filter_list_pph(){
        $perumahan = $_POST['perumahan'];

        $data['nama'] = $this->session->userdata('nama');

        // $this->db->order_by('id_psjb', "DESC");
        // $data['check_all'] = $this->db->get_where('ppjb', array('pph <>'=>"0"));
        $data['check_all'] = $this->Dashboard_model->filter_pph($perumahan);

        $data['kode'] = $perumahan;

        $this->load->view('operasional_list_pph', $data);
    }

    public function view_add_pengeluaran_pph(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('ppjb', array('id_psjb'=>$id)); 
        foreach($data['check_all']->result() as $row){
            $data['no_kwitansi'] = "PPH-".$row->kode_perumahan.$row->no_psjb;
            $data['kode'] = $row->kode_perumahan;
            $data['keterangan'] = "Pembayaran nilai PPh PPJB No. ".$row->no_psjb." Unit ".$row->no_kavling;
            $data['nilai_pengeluaran'] = $row->pph;
            $data['tgl_bayar_pajak'] = $row->tgl_bayar_pajak;
        }
        
        $data['bank'] = $this->db->get('bank')->result();

        $data['id'] = $id;

        $this->load->view('operasional_pph_form', $data);
    }

    public function view_add_pengeluaran_pph_unit2(){
        $ids = $_GET['ids'];
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('rumah', array('id_rumah'=>$id)); 
        foreach($data['check_all']->result() as $row){
            foreach($this->db->get_where('ppjb', array('psjb'=>$row->no_psjb, 'tipe_produk'=>$row->tipe_produk))->result() as $row1){

            }

            $data['no_kwitansi'] = "PPH-".$row->kode_perumahan.$row->no_psjb."-".$ids;
            $data['kode'] = $row->kode_perumahan;
            $data['keterangan'] = "Pembayaran nilai PPh PPJB No. ".$row1->no_psjb." Unit ".$row->kode_rumah;
            $data['nilai_pengeluaran'] = $row->pph;
            $data['tgl_bayar_pajak'] = $row->tgl_bayar_pajak;
        }

        $data['id'] = $id;
        $data['ids'] = $ids;

        $data['bank'] = $this->db->get('bank')->result();

        $this->load->view('operasional_pph_form', $data);
    }

    public function add_pengeluaran_pph(){
        $id = $_POST['id'];

        $no_faktur = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $terima_oleh = $_POST['terima_oleh'];

        $kategori_pengeluaran = $_POST['kategori_pengeluaran'];
        $jenis_pengeluaran = $_POST['jenis_pengeluaran'];
        $keterangan = $_POST['keterangan_pengeluaran'];
        $jenis_pembayaran = "cash";
        $cara_pembayaran = $_POST['cara_pembayaran'];
        
        $tanggal_pengeluaran = $_POST['tgl_pengeluaran'];
        $nilai_pengeluaran = $_POST['nilai_pengeluaran'];
        // $sisa_pembayaran = $_POST['sisa_pembayaran'];

        $bank = $_POST['bank'];
        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date('Y-m-d');

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        // if($sisa_pembayaran < 0){
        //     echo "<script>
        //             alert('Nominal tidak boleh minus/<0!');
        //             window.location.href = 'pembayaran_pengajuan?id=$id';
        //           </script>";
        // } else {
        if($bank != ""){
            $data = array(
                'no_pengeluaran'=>$no_faktur,
                'kategori_pengeluaran'=>$kategori_pengeluaran,
                'jenis_pengeluaran'=>$jenis_pengeluaran,
                'kode_perumahan'=>$kode_perumahan,
                'terima_oleh'=>$terima_oleh,
                'keterangan'=>$keterangan,
                'jenis_pembayaran'=>$jenis_pembayaran,
                'cara_pembayaran'=>$cara_pembayaran,
                'nominal'=>$nilai_pengeluaran,
                'tgl_pembayaran'=>$tanggal_pengeluaran,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_created'=>$date_by,
                // 'file_name'=>$file_name
                // 'status'=>$status,
            );

            $this->db->insert('keuangan_pengeluaran', $data);
        } else {
            $data = array(
                'no_pengeluaran'=>$no_faktur,
                'kategori_pengeluaran'=>$kategori_pengeluaran,
                'jenis_pengeluaran'=>$jenis_pengeluaran,
                'kode_perumahan'=>$kode_perumahan,
                'terima_oleh'=>$terima_oleh,
                'keterangan'=>$keterangan,
                'jenis_pembayaran'=>$jenis_pembayaran,
                'cara_pembayaran'=>$cara_pembayaran,
                'nominal'=>$nilai_pengeluaran,
                'tgl_pembayaran'=>$tanggal_pengeluaran,
                // 'id_bank'=>$bank,
                // 'nama_bank'=>$nama_bank,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_created'=>$date_by,
                // 'file_name'=>$file_name
            );

            $this->db->insert('keuangan_pengeluaran', $data);
        }

        $this->session->set_flashdata('succ_msg', "Data telah ditambahkan!");
        redirect('Dashboard/list_pph');
        // }
    }

    public function transaksi_pengeluaran_hutang(){
        $data['nama'] = $this->session->userdata('nama');
        $kode_perumahan = "";

        $data['check_all'] = $this->db->get('keuangan_pengeluaran_hutang');
        $data['prod'] = $this->Dashboard_model->group_faktur("");
        // print_r($data['prod']->result());
        // $data['pengeluaran'] = $this->db->get_where('')

        $this->load->view('transaksi_utang', $data);
    }

    public function transaksi_pengeluaran_hutang_notif(){
        $data['nama'] = $this->session->userdata('nama');
        $kode_perumahan = "";

        $data['check_all'] = $this->db->get_where('keuangan_pengeluaran_hutang', array('status'=>"belum lunas"));
        $data['prod'] = $this->Dashboard_model->group_faktur($kode_perumahan);
        // $data['pengeluaran'] = $this->db->get_where('')

        $this->load->view('transaksi_utang', $data);
    }

    public function filter_daftar_utang(){
        $kode_perumahan = $_POST['perumahan'];
        $status = $_POST['status'];

        $data['nama'] = $this->session->userdata('nama');

        // if($kode_perumahan == ""){
        //     $data['check_all'] = $this->db->get('keuangan_pengeluaran_hutang');
        // } else {
        //     $data['check_all'] = $this->db->get_where('keuangan_pengeluaran_hutang', array('kode_perumahan'=>$kode_perumahan));
        // }
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['check_all'] = $this->Dashboard_model->filter_daftar_utang($kode_perumahan, $status);
        $data['prod'] = $this->Dashboard_model->group_faktur($kode_perumahan);

        $data['k_perumahan'] = $kode_perumahan;
        $data['status'] = $status;
        // $data['pengeluaran'] = $this->db->get_where('')

        $this->load->view('transaksi_utang', $data);
    }

    public function transaksi_detail_utang(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');
        $data['detail'] = $this->db->get_where('keuangan_pengeluaran_hutang', array('id_pengeluaran'=>$id))->result();

        foreach($data['detail'] as $row){
            $data['detail_pembayaran'] = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$row->no_pengeluaran))->result();
        }

        $this->load->view('transaksi_utang_detail', $data);
    }

    public function transaksi_utang_form(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['bank'] = $this->db->get('bank')->result();

        // $data['pengeluaran'] = $this->db->get('keuangan_pengeluaran')->result();

        $data['error_upload'] = $this->session->flashdata('error_upload');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        // $this->load->view('transaksi_utang_form', $data);

        // $data['nama'] = $this->session->userdata('nama');
        $data['pengeluaran'] = $this->db->get_where('keuangan_pengeluaran_hutang', array('id_pengeluaran'=>$id))->result();

        foreach($data['pengeluaran'] as $row){
            $data['detail_pembayaran'] = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$row->no_pengeluaran))->result();
        }

        $this->load->view('transaksi_utang_form', $data);
    }

    public function add_pembayaran_utang(){
        $id=$_POST['id'];

        $no_kwitansi = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $terima_oleh = $_POST['terima_oleh'];
        $kategori_pengeluaran = $_POST['kategori_pengeluaran'];
        $jenis_pengeluaran = $_POST['jenis_pengeluaran'];
        $keterangan = $_POST['keterangan_pengeluaran'];
        $nilai_pengeluaran = $_POST['nilai_pengeluaran'];
        $tanggal_pengeluaran = $_POST['tgl_pengeluaran'];
        $cara_pembayaran = $_POST['cara_pembayaran'];
        $bank = $_POST['bank'];

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date("Y-m-d");
        // $status = "tutup";

        $jenis_pembayaran = $_POST['jenis_pembayaran'];
        $sisa_utang = $_POST['sisa_utang'];
        // $periode_awal = $_POST['periode_awal'];
        // $periode_akhir = $_POST['periode_akhir'];

        // $id_keuangan = 1;
        // $check_data = $this->Dashboard_model->check_last_record_ground_tank();
        // foreach($check_data as $row){
        //     $id_keuangan = $row->id_keuangan + 1;
        // }


        // $query = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>"bphtb"));
        // $query1 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan, 'jenis_penerimaan'=>"bbn"));

        $file_name = "";

        $config['upload_path']          = './gambar/pengeluaran/';
		$config['allowed_types']        = 'gif|jpg|png';
		// $config['max_size']             = 1000;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
 
        $this->load->library('upload', $config);
        
        // $cek_kwitansi = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));
        // $cek_kwitansi2 = $this->db->get_where('keuangan_pengeluaran_hutang', array('no_pengeluaran'=>$no_kwitansi, 'kode_perumahan'=>$kode_perumahan));
        // echo $cek_kwitansi->num_rows();
        // echo $cek_kwitansi2->num_rows();
        // exit;
        // if($cek_kwitansi->num_rows() > 0 || $cek_kwitansi2->num_rows() > 0){
        //     $this->session->set_flashdata('err_msg', "Data sudah ada!");
        //     redirect('Dashboard/transaksi_pengeluaran');
        // } else {
        // foreach()
        if($sisa_utang < 0){
            echo "<script>
                    alert('Nominal tidak pas!');
                    window.location.href='transaksi_utang_form?id=$id'
                  </script>";
        } else {
            if ( ! $this->upload->do_upload('berkas')){
                // $data['error_upload'] = array('error' => $this->upload->display_errors());

                // $data['nama'] = $this->session->userdata('nama');

                // $data['check_all'] = $this->db->get('perumahan')->result();

                $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));

                if($bank != ""){
                    $data = array(
                        'no_pengeluaran'=>$no_kwitansi,
                        'kategori_pengeluaran'=>$kategori_pengeluaran,
                        'jenis_pengeluaran'=>$jenis_pengeluaran,
                        'kode_perumahan'=>$kode_perumahan,
                        'terima_oleh'=>$terima_oleh,
                        'keterangan'=>$keterangan,
                        'jenis_pembayaran'=>$jenis_pembayaran,
                        'cara_pembayaran'=>$cara_pembayaran,
                        'nominal'=>$nilai_pengeluaran,
                        'tgl_pembayaran'=>$tanggal_pengeluaran,
                        'id_bank'=>$bank,
                        'nama_bank'=>$nama_bank,
                        'id_created_by'=>$id_created_by,
                        'created_by'=>$created_by,
                        'date_created'=>$date_by,
                        // 'file_name'=>$file_name
                        // 'status'=>$status,
                    );
        
                    $this->db->insert('keuangan_pengeluaran', $data);
                } else {
                    $data = array(
                        'no_pengeluaran'=>$no_kwitansi,
                        'kategori_pengeluaran'=>$kategori_pengeluaran,
                        'jenis_pengeluaran'=>$jenis_pengeluaran,
                        'kode_perumahan'=>$kode_perumahan,
                        'terima_oleh'=>$terima_oleh,
                        'keterangan'=>$keterangan,
                        'jenis_pembayaran'=>$jenis_pembayaran,
                        'cara_pembayaran'=>$cara_pembayaran,
                        'nominal'=>$nilai_pengeluaran,
                        'tgl_pembayaran'=>$tanggal_pengeluaran,
                        // 'id_bank'=>$bank,
                        // 'nama_bank'=>$nama_bank,
                        'id_created_by'=>$id_created_by,
                        'created_by'=>$created_by,
                        'date_created'=>$date_by,
                        // 'file_name'=>$file_name
                    );
        
                    $this->db->insert('keuangan_pengeluaran', $data);
                }
            
                $data['nama'] = $this->session->userdata('nama');
        
                $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
                
                $data['bank'] = $this->db->get('bank')->result();
        
                $data['succ_msg'] = "Data sudah ditambahkan";
        
                // $this->load->view('transaksi_penerimaan_lain', $data);
                $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
                redirect('Dashboard/transaksi_detail_utang?id='.$id);
            // $this->load->view('perumahan', $data);
            } else{
                $upload = array('upload_data' => $this->upload->data());

                // foreach($upload['upload_data']['file_name'] as $item){
                //     $file_name = $item->file_name;
                // }
                // print_r($upload['upload_data']['file_name']);
                // print_r($file_name);
                // exit;
                $file_name = $upload['upload_data']['file_name'];
            
                if($bank != ""){
                    $data = array(
                        'no_pengeluaran'=>$no_kwitansi,
                        'kategori_pengeluaran'=>$kategori_pengeluaran,
                        'jenis_pengeluaran'=>$jenis_pengeluaran,
                        'kode_perumahan'=>$kode_perumahan,
                        'terima_oleh'=>$terima_oleh,
                        'keterangan'=>$keterangan,
                        'jenis_pembayaran'=>$jenis_pembayaran,
                        'cara_pembayaran'=>$cara_pembayaran,
                        'nominal'=>$nilai_pengeluaran,
                        'tgl_pembayaran'=>$tanggal_pengeluaran,
                        'id_bank'=>$bank,
                        'nama_bank'=>$nama_bank,
                        'id_created_by'=>$id_created_by,
                        'created_by'=>$created_by,
                        'date_created'=>$date_by,
                        'file_name'=>$file_name
                        // 'status'=>$status,
                    );
        
                    $this->db->insert('keuangan_pengeluaran', $data);
                } else {
                    $data = array(
                        'no_pengeluaran'=>$no_kwitansi,
                        'kategori_pengeluaran'=>$kategori_pengeluaran,
                        'jenis_pengeluaran'=>$jenis_pengeluaran,
                        'kode_perumahan'=>$kode_perumahan,
                        'terima_oleh'=>$terima_oleh,
                        'keterangan'=>$keterangan,
                        'jenis_pembayaran'=>$jenis_pembayaran,
                        'cara_pembayaran'=>$cara_pembayaran,
                        'nominal'=>$nilai_pengeluaran,
                        'tgl_pembayaran'=>$tanggal_pengeluaran,
                        // 'id_bank'=>$bank,
                        // 'nama_bank'=>$nama_bank,
                        'id_created_by'=>$id_created_by,
                        'created_by'=>$created_by,
                        'date_created'=>$date_by,
                        'file_name'=>$file_name
                    );
        
                    $this->db->insert('keuangan_pengeluaran', $data);
                    
                }
            
                $data['nama'] = $this->session->userdata('nama');
        
                $data['penerimaan_lain'] = $this->db->get('keuangan_penerimaan_lain')->result();
                
                $data['bank'] = $this->db->get('bank')->result();
        
                $data['succ_msg'] = "Data sudah ditambahkan";
        
                // $this->load->view('transaksi_penerimaan_lain', $data);
                $this->session->set_flashdata('succ_msg', 'Data sudah ditambahkan');
                redirect('Dashboard/transaksi_detail_utang?id='.$id);
                // }
            }
        }
    }

    public function pelunasan_utang(){
        $id = $_GET['id'];

        $data = array(
            'status'=>"lunas"
        );

        $this->db->update('keuangan_pengeluaran_hutang', $data, array('id_pengeluaran'=>$id));

        redirect('Dashboard/transaksi_detail_utang?id='.$id);
    }

    public function hapus_utang(){
        $id = $_GET['id'];

        $query = $this->db->get_where('keuangan_pengeluaran_hutang', array('id_pengeluaran'=>$id));

        foreach($query->result() as $row){
            $no_pengeluaran = $row->no_pengeluaran;
        }

        $data = array(
            'status'=>"batal"
        );

        $this->db->update('keuangan_pengeluaran_hutang', $data, array('id_pengeluaran'=>$id));

        redirect('Dashboard/transaksi_pengeluaran_hutang');
    }
    //END OF PENGELUARAN

    //START OF AKUNTANSI

    public function laporan_penerimaan_akuntansi(){
        $data['nama'] = $this->session->userdata('nama');

        $data['kode'] = "";
        $data['kategori'] = "";
        $data['status'] = "";
        $data['tglmin'] = "";
        $data['tglmax'] = "";

        // $this->db->order_by('tanggal_dana', "DESC");
        // $data['check_all'] = $this->db->get_where('keuangan_akuntansi', array('jenis_terima <>'=>"bphtb", 'jenis_terima <>'=>"bbn"));
        $data['check_all'] = $this->Dashboard_model->penerimaan_bpthb_bbn();

        $this->load->view('akuntansi_rekap_penerimaan', $data);
    }

    public function filter_laporan_penerimaan_akuntansi(){
        $kode = $_POST['perumahan'];
        $kategori = $_POST['kategori'];
        $status = $_POST['status'];
        $tglmin = $_POST['tgl_awal'];
        $tglmax = $_POST['tgl_akhir'];

        $data['nama'] = $this->session->userdata('nama');

        $data['kode'] = $kode;
        $data['kategori'] = $kategori;
        $data['status'] = $status;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        $this->db->order_by('tanggal_dana', "DESC");
        $data['check_all'] = $this->Dashboard_model->filter_laporan_penerimaan_akuntansi( $tglmin, $tglmax, $kode, $kategori, $status );
        // if($kode == "" || strtotime($tglmin) == "" || strtotime($tglmax) == "" || $kategori == "" || $status == ""){
        //     $this->db->order_by('tanggal_dana', "DESC");
        //     $data['check_all'] = $this->Dashboard_model->filter_laporan_penerimaan_akuntansi( $tglmin, $tglmax, $kode, $kategori, $status );
        // }else {
        //     $this->db->order_by('tanggal_dana', "DESC");
        //     $data['check_all'] = $this->Dashboard_model->filter_laporan_penerimaan_akuntansi( $tglmin, $tglmax, $kode, $kategori, $status );
        // }

        $this->load->view('akuntansi_rekap_penerimaan', $data);
    }

    public function akuntansi_penerimaan(){
        $id=$_GET['id'];
        $kode = $_GET['kode'];
        
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('no_akun','ASC');
        $data['nama_akun'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$kode));

        $this->db->order_by('no_induk','ASC');
        $data['induk_akun'] = $this->db->get('akuntansi_induk_akun');

        $data['akuntansi'] = $this->db->get_where('keuangan_akuntansi', array('id_keuangan'=>$id));

        foreach($data['akuntansi']->result() as $row){
            $data['ppjb_dp'] = $this->db->get_where('keuangan_kas_kpr', array('id_keuangan'=>$row->id_penerimaan));
        }

        $this->load->view('akuntansi_penerimaan', $data);
    }

    public function get_anak_akun(){
        // $category=$_GET['id'];
        $category = $_POST["country"];

        // Define country and city array
        $query = $this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$category))->result();


        // Display city dropdown based on country name
        if($category !== 'Select'){
            // echo "<label>City:</label>";
            // echo "<select>";
            echo "<option value='' disabled selected>-Pilih-</option>";
            foreach($query as $value){
                echo "<option value=".$value->no_akun.">".$value->no_akun."-".$value->nama_akun."</option>";
            }
            // echo "</select>";
        } 
    }

    public function add_akuntansi_penerimaan(){
        // $count = $_POST['total_chq'];

        // $input = $_POST['new_1'];
        // print_r($input);
        
        // $input2 = $_POST['new_2'];
        
        // $input3 = $_POST['new_3'];
        // $data = [];
        // for($x = 1; $x >= $count; $x++){
        //     $data[] = $_POST['new_$x'];
        // }
        $id=$_POST['id'];
        $jenis_keuangan = $_POST['jenis_keuangan'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $total_data_debet = $_POST['total_chq_debet'];
        $total_data_kredit = $_POST['total_chq_kredit'];

        $nama_akun_debet = $_POST['nama_akun_debet'];
        $nama_akun_kredit = $_POST['nama_akun_kredit'];
        $kode_akun_debet = $_POST['kode_akun_debet'];
        $kode_akun_kredit = $_POST['kode_akun_kredit'];
        $pos_debet = $_POST['pos_debet'];
        $pos_kredit = $_POST['pos_kredit'];
        $nominal_debet = $_POST['nominal_debet'];
        $nominal_kredit = $_POST['nominal_kredit'];

        $tanggal_dana = $_POST['tanggal_dana'];

        // echo count($nama_akun_debet);
        $temp_debet = 0;
        $temp_kredit = 0;
        foreach($nominal_debet as $row => $value){
            $temp_debet = $temp_debet + $value;
        }
        foreach($nominal_kredit as $row1 => $value){
            $temp_kredit = $temp_kredit + $value;
        }
        // echo $temp_debet."<br>".$temp_kredit;
        // exit;
        if($temp_debet - $temp_kredit != 0){
            echo "<script>
                    alert('Nominal tidak 0!');
                    window.location.href = 'akuntansi_penerimaan?id=$id&kode=$kode_perumahan';
                  </script>";
        } else {

            $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id, 'jenis_keuangan'=>"penerimaan"));

            for($x = 0; $x <= $total_data_debet; $x++){
                // print_r($nominal_debet[$x]);
                foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$nama_akun_debet[$x], 'kode_perumahan'=>$kode_perumahan))->result() as $row){
                    $id_akun = $row->id_anak_akun;
                    $id_induk = $row->id_induk;
                }

                $data1 = array(
                    'id_keuangan'=>$id,
                    'jenis_keuangan'=>$jenis_keuangan,
                    'id_induk'=>$id_induk,
                    'id_akun'=>$nama_akun_debet[$x],
                    'pos_akun'=>"debet",
                    'nominal'=>$nominal_debet[$x],
                    'kode_perumahan'=>$kode_perumahan,
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'date_created'=>$tanggal_dana,
                );

                $this->db->insert('akuntansi_pos', $data1);
            }

            for($x = 0; $x <= $total_data_kredit; $x++){
                // print_r($nominal_debet[$x]);
                foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$nama_akun_kredit[$x], 'kode_perumahan'=>$kode_perumahan))->result() as $row){
                    $id_akun = $row->id_anak_akun;
                    $id_induk = $row->id_induk;
                }

                $data1 = array(
                    'id_keuangan'=>$id,
                    'jenis_keuangan'=>$jenis_keuangan,
                    'id_induk'=>$id_induk,
                    'id_akun'=>$nama_akun_kredit[$x],
                    'pos_akun'=>"kredit",
                    'nominal'=>$nominal_kredit[$x],
                    'kode_perumahan'=>$kode_perumahan,
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'date_created'=>$tanggal_dana,
                );

                $this->db->insert('akuntansi_pos', $data1);
            }

            // print_r($nama_akun_debet);
            // foreach($nama_akun_debet as $index => $value){
            //     echo $value;
            // }

            $data = array(
                'status'=>"tutup"
            );

            $this->db->update('keuangan_akuntansi', $data, array('id_keuangan'=>$id));

            // print_r($data);

            redirect('Dashboard/laporan_penerimaan_akuntansi');
        }
    }

    public function akuntansi_detail_penerimaan(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;
        $data['kode'] = $kode;

        $data['akuntansi_debet'] = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$id, 'jenis_keuangan'=>"penerimaan",'pos_akun'=>"debet",'kode_perumahan'=>$kode));
        $data['akuntansi_kredit'] = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$id, 'jenis_keuangan'=>"penerimaan",'pos_akun'=>"kredit",'kode_perumahan'=>$kode));

        $data['sendback'] = $this->db->get_where('akuntansi_pos_sendback', array('id_keuangan'=>$id, 'jenis_keuangan'=>"penerimaan"));

        $this->load->view('akuntansi_detail_penerimaan', $data);
    }

    public function akuntansi_view_revisi_penerimaan(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;
        $data['kode'] = $kode;

        $data['akuntansi_debet'] = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$id, 'jenis_keuangan'=>"penerimaan", 'pos_akun'=>"debet", 'kode_perumahan'=>$kode));
        $data['akuntansi_kredit'] = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$id, 'jenis_keuangan'=>"penerimaan", 'pos_akun'=>"kredit", 'kode_perumahan'=>$kode));

        $data['id']=$id;

        $data['revisi'] = $this->db->get_where('keuangan_akuntansi', array('id_keuangan'=>$id));
        $data['sendback'] = $this->db->get_where('akuntansi_pos_sendback', array('id_keuangan'=>$id, 'jenis_keuangan'=>"penerimaan"));

        $this->load->view('akuntansi_detail_penerimaan', $data);
    }

    public function akuntansi_revisi_penerimaan(){
        $id = $_POST['id'];
        $keterangan = $_POST['keterangan'];

        $data = array(
            'catatan'=>$keterangan,
            'id_created_by'=>$this->session->userdata('u_id'),
            'created_by'=>$this->session->userdata('nama'),
            'date_created'=>date('Y-m-d'),
            'id_keuangan'=>$id,
            'jenis_keuangan'=>"penerimaan"
        );

        $this->db->insert('akuntansi_pos_sendback', $data);

        $data1 = array(
            'status'=>"revisi",
            'rev_by'=>$this->session->userdata('nama'),
            'rev_date'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('keuangan_akuntansi', $data1, array('id_keuangan'=>$id));

        $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id, 'jenis_keuangan'=>"penerimaan"));

        redirect('Dashboard/laporan_penerimaan_akuntansi');
    }

    public function revisi_penerimaan(){
        $id=$_GET['id'];
        $kode = $_GET['kode'];
        
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('no_akun','ASC');
        $data['nama_akun'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$kode));

        $this->db->order_by('no_induk','ASC');
        $data['induk_akun'] = $this->db->get('akuntansi_induk_akun');

        $data['akuntansi'] = $this->db->get_where('keuangan_akuntansi', array('id_keuangan'=>$id));

        foreach($data['akuntansi']->result() as $row){
            $data['ppjb_dp'] = $this->db->get_where('keuangan_kas_kpr', array('id_keuangan'=>$row->id_penerimaan));
        }

        $data['sendback'] = $this->db->get_where('akuntansi_pos_sendback', array('id_keuangan'=>$id, 'jenis_keuangan'=>"penerimaan"));

        $this->load->view('akuntansi_penerimaan', $data);
    }

    public function akuntansi_approve_penerimaan(){
        $id = $_GET['id'];

        $data = array(
            'status'=>"dom"
        );

        $this->db->update('keuangan_akuntansi', $data, array('id_keuangan'=>$id));

        redirect('Dashboard/laporan_penerimaan_akuntansi');
    }

    public function laporan_pengeluaran_akuntansi(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('tgl_pembayaran', "DESC");
        $data['check_all'] = $this->db->get_where('keuangan_pengeluaran', array('nominal <>'=>0));

        $this->load->view('akuntansi_rekap_pengeluaran', $data);
    }

    public function filter_laporan_pengeluaran_akuntansi(){
        $kode = $_POST['perumahan'];
        $tglmin = $_POST['tgl_awal'];
        $tglmax = $_POST['tgl_akhir'];
        $status = $_POST['status'];

        $data['nama'] = $this->session->userdata('nama');

        $data['kode'] = $kode;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;
        $data['status'] = $status;

        if($kode == "" || strtotime($tglmin) == "" || strtotime($tglmax) == "" || $status == ""){
            $this->db->order_by('tgl_pembayaran', "DESC");
            $data['check_all'] = $this->Dashboard_model->filter_laporan_pengeluaran_akuntansi( $tglmin, $tglmax, $kode, $status );
        }else {
            $this->db->order_by('tgl_pembayaran', "DESC");
            $data['check_all'] = $this->Dashboard_model->filter_laporan_pengeluaran_akuntansi( $tglmin, $tglmax, $kode, $status );
        }

        $this->load->view('akuntansi_rekap_pengeluaran', $data);
    }

    public function akuntansi_pengeluaran(){
        $id=$_GET['id'];
        $kode = $_GET['kode'];
        
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('no_akun','ASC');
        // $data['nama_akun'] = $this->db->get('akuntansi_anak_akun');
        $data['nama_akun'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$kode));

        $this->db->order_by('no_induk','ASC');
        $data['induk_akun'] = $this->db->get('akuntansi_induk_akun');

        $data['akuntansi'] = $this->db->get_where('keuangan_pengeluaran', array('id_pengeluaran'=>$id));

        // foreach($data['akuntansi']->result() as $row){
        //     $data['ppjb_dp'] = $this->db->get_where('keuangan_kas_kpr', array('id_keuangan'=>$row->id_penge));
        // }

        $this->load->view('akuntansi_pengeluaran', $data);
    }

    public function add_akuntansi_pengeluaran(){
        // $count = $_POST['total_chq'];

        // $input = $_POST['new_1'];
        // print_r($input);
        
        // $input2 = $_POST['new_2'];
        
        // $input3 = $_POST['new_3'];
        // $data = [];
        // for($x = 1; $x >= $count; $x++){
        //     $data[] = $_POST['new_$x'];
        // }
        $id=$_POST['id'];
        $jenis_keuangan = $_POST['jenis_keuangan'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $total_data_debet = $_POST['total_chq_debet'];
        $total_data_kredit = $_POST['total_chq_kredit'];

        $nama_akun_debet = $_POST['nama_akun_debet'];
        $nama_akun_kredit = $_POST['nama_akun_kredit'];
        $kode_akun_debet = $_POST['kode_akun_debet'];
        $kode_akun_kredit = $_POST['kode_akun_kredit'];
        $pos_debet = $_POST['pos_debet'];
        $pos_kredit = $_POST['pos_kredit'];
        $nominal_debet = $_POST['nominal_debet'];
        $nominal_kredit = $_POST['nominal_kredit'];

        $tanggal_dana = $_POST['tanggal_dana'];

        // echo count($nama_akun_debet);
        $temp_debet = 0;
        $temp_kredit = 0;
        foreach($nominal_debet as $row => $value){
            $temp_debet = $temp_debet + $value;
        }
        foreach($nominal_kredit as $row1 => $value){
            $temp_kredit = $temp_kredit + $value;
        }
        // echo $temp_debet."<br>".$temp_kredit;
        // exit;
        if($temp_debet - $temp_kredit != 0){
            echo "<script>
                    alert('Nominal tidak 0!');
                    window.location.href = 'akuntansi_pengeluaran?id=$id&kode=$kode_perumahan';
                  </script>";
        } else {

            $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id, 'jenis_keuangan'=>"pengeluaran"));

            for($x = 0; $x <= $total_data_debet; $x++){
                // print_r($nominal_debet[$x]);
                foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$nama_akun_debet[$x],'kode_perumahan'=>$kode_perumahan))->result() as $row){
                    $id_akun = $row->id_anak_akun;
                    $id_induk = $row->id_induk;
                }

                $data1 = array(
                    'id_keuangan'=>$id,
                    'jenis_keuangan'=>$jenis_keuangan,
                    'id_induk'=>$id_induk,
                    'id_akun'=>$nama_akun_debet[$x],
                    'pos_akun'=>"debet",
                    'nominal'=>$nominal_debet[$x],
                    'kode_perumahan'=>$kode_perumahan,
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'date_created'=>$tanggal_dana,
                );

                $this->db->insert('akuntansi_pos', $data1);
            }

            for($x = 0; $x <= $total_data_kredit; $x++){
                // print_r($nominal_debet[$x]);
                foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$nama_akun_kredit[$x],'kode_perumahan'=>$kode_perumahan))->result() as $row){
                    $id_akun = $row->id_anak_akun;
                    $id_induk = $row->id_induk;
                }

                $data1 = array(
                    'id_keuangan'=>$id,
                    'jenis_keuangan'=>$jenis_keuangan,
                    'id_induk'=>$id_induk,
                    'id_akun'=>$nama_akun_kredit[$x],
                    'pos_akun'=>"kredit",
                    'nominal'=>$nominal_kredit[$x],
                    'kode_perumahan'=>$kode_perumahan,
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'date_created'=>$tanggal_dana,
                );

                $this->db->insert('akuntansi_pos', $data1);
            }

            // print_r($nama_akun_debet);
            // foreach($nama_akun_debet as $index => $value){
            //     echo $value;
            // }

            $data = array(
                'status'=>"tutup"
            );

            $this->db->update('keuangan_pengeluaran', $data, array('id_pengeluaran'=>$id));

            // print_r($data);

            redirect('Dashboard/laporan_pengeluaran_akuntansi');
        }
    }

    public function akuntansi_detail_pengeluaran(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;
        $data['kode'] = $kode;

        $data['akuntansi_debet'] = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$id,'jenis_keuangan'=>"pengeluaran",'pos_akun'=>"debet", 'kode_perumahan'=>$kode));
        $data['akuntansi_kredit'] = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$id,'jenis_keuangan'=>"pengeluaran",'pos_akun'=>"kredit", 'kode_perumahan'=>$kode));

        $data['sendback'] = $this->db->get_where('akuntansi_pos_sendback', array('id_keuangan'=>$id, 'jenis_keuangan'=>"pengeluaran"));

        $this->load->view('akuntansi_detail_pengeluaran', $data);
    }

    public function akuntansi_view_revisi_pengeluaran(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;
        $data['kode'] = $kode;

        $data['akuntansi_debet'] = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$id, 'jenis_keuangan'=>"pengeluaran", 'pos_akun'=>"debet", 'kode_perumahan'=>$kode));
        $data['akuntansi_kredit'] = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$id, 'jenis_keuangan'=>"pengeluaran", 'pos_akun'=>"kredit", 'kode_perumahan'=>$kode));

        $data['id']=$id;

        $data['revisi'] = $this->db->get_where('keuangan_akuntansi', array('id_keuangan'=>$id));
        $data['sendback'] = $this->db->get_where('akuntansi_pos_sendback', array('id_keuangan'=>$id, 'jenis_keuangan'=>"penerimaan"));

        $this->load->view('akuntansi_detail_pengeluaran', $data);
    }

    public function akuntansi_revisi_pengeluaran(){
        $id = $_POST['id'];
        $keterangan = $_POST['keterangan'];

        $data = array(
            'catatan'=>$keterangan,
            'id_created_by'=>$this->session->userdata('u_id'),
            'created_by'=>$this->session->userdata('nama'),
            'date_created'=>date('Y-m-d'),
            'id_keuangan'=>$id,
            'jenis_keuangan'=>"pengeluaran"
        );

        $this->db->insert('akuntansi_pos_sendback', $data);

        $data1 = array(
            'status'=>"revisi",
            'rev_by'=>$this->session->userdata('nama'),
            'rev_date'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('keuangan_pengeluaran', $data1, array('id_pengeluaran'=>$id));

        $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id, 'jenis_keuangan'=>"pengeluaran"));

        redirect('Dashboard/laporan_pengeluaran_akuntansi');
    }

    public function revisi_pengeluaran(){
        $id=$_GET['id'];
        $kode = $_GET['kode'];
        
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('no_akun','ASC');
        $data['nama_akun'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$kode));

        $this->db->order_by('no_induk','ASC');
        $data['induk_akun'] = $this->db->get('akuntansi_induk_akun');

        $data['akuntansi'] = $this->db->get_where('keuangan_pengeluaran', array('id_pengeluaran'=>$id));

        // foreach($data['akuntansi']->result() as $row){
        //     $data['ppjb_dp'] = $this->db->get_where('keuangan_kas_kpr', array('id_keuangan'=>$row->id_pengeluaran));
        // }

        $data['sendback'] = $this->db->get_where('akuntansi_pos_sendback', array('id_keuangan'=>$id, 'jenis_keuangan'=>"pengeluaran"));

        $this->load->view('akuntansi_pengeluaran', $data);
    }

    public function akuntansi_approve_pengeluaran(){
        $id = $_GET['id'];

        $data = array(
            'status'=>"dom"
        );

        $this->db->update('keuangan_pengeluaran', $data, array('id_pengeluaran'=>$id));

        redirect('Dashboard/laporan_pengeluaran_akuntansi');
    }

    public function add_jurnal_akuntansi(){
        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('akuntansi_jurnal', $data);
    }

    public function add_insert_jurnal(){
        $kategori = $_POST['kategori'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $keterangan = $_POST['keterangan'];
        $tgl = $_POST['tgl'];
        $nominal = $_POST['nominal'];

        $data = array(
            'kategori'=>$kategori,
            'kode_perumahan'=>$kode_perumahan,
            'keterangan'=>$keterangan,
            'tgl_jurnal'=>$tgl,
            'nominal'=>$nominal,
            'id_created_by'=>$this->session->userdata('u_id'),
            'created_by'=>$this->session->userdata('nama'),
            'date_created'=>date('Y-m-d')
            // 'status'=>"menunggu"
        );

        $this->db->insert('akuntansi_jurnal', $data);

        redirect('Dashboard/informasi_jurnal_akuntansi');
    }

    public function informasi_jurnal_akuntansi(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('akuntansi_jurnal');

        $this->load->view('akuntansi_jurnal_management', $data);
    }

    public function hapus_jurnal(){
        $id = $_GET['id'];

        $this->db->delete('akuntansi_jurnal', array('id_jurnal'=>$id));
        $this->db->delete('akuntansi_pos_jurnal', array('id_keuangan'=>$id));
        // $this->db->delete('akuntansi_pos_sendback', array(''))

        redirect('Dashboard/informasi_jurnal_akuntansi');
    }

    public function pos_jurnal(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['akuntansi'] = $this->db->get_where('akuntansi_jurnal', array('id_jurnal'=>$id));
        $data['nama_akun'] = $this->db->get('akuntansi_anak_akun');

        $this->load->view('akuntansi_jurnal_pos', $data);
    }

    public function add_pos_jurnal(){
        $id=$_POST['id'];
        $jenis_keuangan = $_POST['jenis_keuangan'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $total_data_debet = $_POST['total_chq_debet'];
        $total_data_kredit = $_POST['total_chq_kredit'];

        $nama_akun_debet = $_POST['nama_akun_debet'];
        $nama_akun_kredit = $_POST['nama_akun_kredit'];
        $kode_akun_debet = $_POST['kode_akun_debet'];
        $kode_akun_kredit = $_POST['kode_akun_kredit'];
        $pos_debet = $_POST['pos_debet'];
        $pos_kredit = $_POST['pos_kredit'];
        $nominal_debet = $_POST['nominal_debet'];
        $nominal_kredit = $_POST['nominal_kredit'];

        $tanggal_dana = $_POST['tgl_jurnal'];

        // echo count($nama_akun_debet);
        $temp_debet = 0;
        $temp_kredit = 0;
        foreach($nominal_debet as $row => $value){
            $temp_debet = $temp_debet + $value;
        }
        foreach($nominal_kredit as $row1 => $value){
            $temp_kredit = $temp_kredit + $value;
        }
        // echo $temp_debet."<br>".$temp_kredit;
        // exit;

        // if($temp_debet - $temp_kredit != 0){
        //     echo "<script>
        //             alert('Nominal tidak 0!');
        //             window.location.href = 'pos_jurnal?id=$id';
        //           </script>";
        // } else {
            $this->db->delete('akuntansi_pos_jurnal', array('id_keuangan'=>$id));

            for($x = 0; $x <= $total_data_debet; $x++){
                // print_r($nominal_debet[$x]);
                foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$nama_akun_debet[$x], 'kode_perumahan'=>$kode_perumahan))->result() as $row){
                    $id_akun = $row->id_anak_akun;
                    $id_induk = $row->id_induk;
                }

                $data1 = array(
                    'id_keuangan'=>$id,
                    'jenis_keuangan'=>$jenis_keuangan,
                    'id_induk'=>$id_induk,
                    'id_akun'=>$nama_akun_debet[$x],
                    'pos_akun'=>"debet",
                    'nominal'=>$nominal_debet[$x],
                    'kode_perumahan'=>$kode_perumahan,
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'date_created'=>$tanggal_dana,
                );

                $this->db->insert('akuntansi_pos_jurnal', $data1);
            }

            for($x = 0; $x <= $total_data_kredit; $x++){
                // print_r($nominal_debet[$x]);
                foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$nama_akun_kredit[$x], 'kode_perumahan'=>$kode_perumahan))->result() as $row){
                    $id_akun = $row->id_anak_akun;
                    $id_induk = $row->id_induk;
                }

                $data1 = array(
                    'id_keuangan'=>$id,
                    'jenis_keuangan'=>$jenis_keuangan,
                    'id_induk'=>$id_induk,
                    'id_akun'=>$nama_akun_kredit[$x],
                    'pos_akun'=>"kredit",
                    'nominal'=>$nominal_kredit[$x],
                    'kode_perumahan'=>$kode_perumahan,
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'date_created'=>$tanggal_dana,
                );

                $this->db->insert('akuntansi_pos_jurnal', $data1);
            }

            // print_r($nama_akun_debet);
            // foreach($nama_akun_debet as $index => $value){
            //     echo $value;
            // }

            // $data = array(
            //     'status'=>"tutup"
            // );

            // $this->db->update('keuangan_akuntansi', $data, array('id_keuangan'=>$id));

            // print_r($data);

            redirect('Dashboard/informasi_jurnal_akuntansi');
        // }
    }

    public function detail_jurnal(){
        $id = $_GET['id'];
        // $kode = $_GET

        $data['nama'] = $this->session->userdata('nama');

        $data['akuntansi_debet'] = $this->db->get_where('akuntansi_pos_jurnal', array('id_keuangan'=>$id, 'pos_akun'=>"debet"));
        $data['akuntansi_kredit'] = $this->db->get_where('akuntansi_pos_jurnal', array('id_keuangan'=>$id, 'pos_akun'=>"kredit"));

        // // print_r($data['akuntansi_debet']->result());
        // print_r($data['akuntansi_kredit']->result());
        // exit;

        $this->load->view('akuntansi_jurnal_detail', $data);
    }
    //END OF AKUNTANSI

    //START OF MASTER DATA KEUANGAN
    public function kode_pengeluaran(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('kode_induk', 'ASC');
        $data['kode_induk'] = $this->db->get('keuangan_kode_induk_pengeluaran')->result();
        $this->db->order_by('kode_pengeluaran', 'ASC');
        $data['kode_pengeluaran'] = $this->db->get('keuangan_kode_pengeluaran')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');
        $this->load->view('transaksi_kode_pengeluaran', $data);
    }

    public function add_kode_induk_pengeluaran(){
        $kode_induk = $_POST['kode_induk'];
        $nama_induk = $_POST['nama_induk'];

        $query = $this->db->get_where('keuangan_kode_induk_pengeluaran', array('kode_induk'=>$kode_induk));
        if($query->num_rows() == 0){
            $data = array(
                'kode_induk'=>$kode_induk,
                'nama_induk'=>$nama_induk
            );
            $this->db->insert('keuangan_kode_induk_pengeluaran', $data);   

            $this->session->set_flashdata('succ_msg', "Data terdaftar!");           
        } else {
            $this->session->set_flashdata('err_msg', "Data sudah ada!");
        }

        redirect('Dashboard/kode_pengeluaran');
    }

    public function add_kode_pengeluaran(){
        $kode_induk = $_POST['kode_induk'];
        $kode_pengeluaran = $_POST['kode_pengeluaran'];
        $nama_pengeluaran = $_POST['nama_pengeluaran'];

        $query = $this->db->get_where('keuangan_kode_pengeluaran', array('kode_pengeluaran'=>$kode_pengeluaran));
        if($query->num_rows() == 0){
            $data = array(
                'kode_induk'=>$kode_induk,
                'kode_pengeluaran'=>$kode_pengeluaran,
                'nama_pengeluaran'=>$nama_pengeluaran
            );
            $this->db->insert('keuangan_kode_pengeluaran', $data);

            // $query3 = $this->db->get('perumahan');
            // foreach($query3->result() as $row){
            //     $data1 = array(
            //         // 'id_anak_akun'=>$id_akun,
            //         'kode_induk'=>$kode_induk,
            //         'kode_pengeluaran'=>$kode_pengeluaran,
            //         'nama_pengeluaran'=>$nama_pengeluaran,
            //         'kode_perumahan'=>$row->kode_perumahan
            //     );

            //     $this->db->insert('keuangan_kontrol_budget', $data1);
            // }

            $this->session->set_flashdata('succ_msg', "Data terdaftar!");            
        } else {
            $this->session->set_flashdata('err_msg', "Data sudah ada!");
        }

        redirect('Dashboard/kode_pengeluaran');
    }

    public function hapus_kode_pengeluaran(){
        $kode = $_GET['id'];

        $this->db->delete('keuangan_kode_pengeluaran', array('kode_pengeluaran'=>$kode));

        redirect('Dashboard/kode_pengeluaran');
    }

    public function kontrol_budget(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('keuangan_perumahan_kontrol_budget', $data);
    }

    public function view_add_kontrol_budget(){
        $id = $_GET['id'];

        foreach($this->db->get_where('perumahan', array('id_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['kode_perumahan'] = $row->kode_perumahan;
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('keuangan_kode_induk_pengeluaran');
        $data['id'] = $id;
        $this->load->view('keuangan_kontrol_budget', $data);
    }

    public function add_kontrol_budget(){
        $id = $_POST['id'];
        // $get = $_POST['pos'];
        $kode_pengeluaran = $_POST['kode_pengeluaran'];
        $kode_induk = $_POST['kode_induk'];
        $nama_pengeluaran = $_POST['nama_pengeluaran'];
        $volume = $_POST['volume'];
        $satuan = $_POST['satuan'];
        $harga_satuan = $_POST['harga_satuan'];
        $sub_jumlah = $_POST['sub_jumlah'];
        $kode_perumahan = $_POST['kode_perumahan'];
        
        // $nominal = $_POST['nominal'];
        // print_r($get);
        // print_r($kode_perumahan);

        for($x = 0; $x < count($kode_pengeluaran); $x++){
            $data = array(
                'kode_pengeluaran'=>$kode_pengeluaran[$x],
                'kode_induk'=>$kode_induk[$x],
                'nama_pengeluaran'=>$nama_pengeluaran[$x],
                'volume'=>$volume[$x],
                'satuan'=>$satuan[$x],
                'kode_perumahan'=>$kode_perumahan,
                'harga_satuan'=>$harga_satuan[$x],
                'sub_jumlah'=>$sub_jumlah[$x],
                'date_created'=>date('Y-m-d'),
                'id_created_by'=>$this->session->userdata('u_id')
            );

            $this->db->insert('keuangan_kontrol_budget', $data);
        }

        // print_r($data);
        // exit;

        redirect('Dashboard/view_edit_kontrol_budget?id='.$id);
    }

    public function view_edit_kontrol_budget(){
        $id = $_GET['id'];

        // foreach($this->db->get_where('perumahan', array('id_perumahan'=>$id))->result() as $row){
        //     $data['nama_perumahan'] = $row->nama_perumahan;
        //     $data['kode_perumahan'] = $row->kode_perumahan;
        // }

        // $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('keuangan_kode_induk_pengeluaran');

        // $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('id_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['kode_perumahan'] = $row->kode_perumahan;
        }

        // $data['check_all'] = $this->db->get('akuntansi_induk_akun');

        $data['id'] = $_GET['id'];
        $data['revisi'] = $this->db->get_where('keuangan_kontrol_budget', array('kode_perumahan'=>$data['kode_perumahan']));

        $this->load->view('keuangan_kontrol_budget', $data);
    }

    public function edit_kontrol_budget(){
        $id = $_POST['id'];
        // $get = $_POST['pos'];
        $kode_pengeluaran = $_POST['kode_pengeluaran'];
        $kode_induk = $_POST['kode_induk'];
        $nama_pengeluaran = $_POST['nama_pengeluaran'];
        $volume = $_POST['volume'];
        $satuan = $_POST['satuan'];
        $harga_satuan = $_POST['harga_satuan'];
        $sub_jumlah = $_POST['sub_jumlah'];
        $kode_perumahan = $_POST['kode_perumahan'];
        // print_r($get);
        // print_r($kode_perumahan);
        // print_r($kode_perumahan);
        // exit;
        $this->db->delete('keuangan_kontrol_budget', array('kode_perumahan'=>$kode_perumahan));

        for($x = 0; $x < count($kode_pengeluaran); $x++){
            $data = array(
                'kode_pengeluaran'=>$kode_pengeluaran[$x],
                'kode_induk'=>$kode_induk[$x],
                'nama_pengeluaran'=>$nama_pengeluaran[$x],
                'volume'=>$volume[$x],
                'satuan'=>$satuan[$x],
                'kode_perumahan'=>$kode_perumahan,
                'harga_satuan'=>$harga_satuan[$x],
                'sub_jumlah'=>$sub_jumlah[$x],
                'date_created'=>date('Y-m-d'),
                'id_created_by'=>$this->session->userdata('u_id')
            );

            $this->db->insert('keuangan_kontrol_budget', $data);
        }

        // print_r($data);
        // exit;

        redirect('Dashboard/view_edit_kontrol_budget?id='.$id);
    }

    public function cek_budget(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('id_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['kode_perumahan'] = $row->kode_perumahan;
        }

        $data['check_all'] = $this->db->get_where('keuangan_kode_induk_pengeluaran');

        $this->load->view('keuangan_cek_budget', $data);
    }

    public function akun_neraca_saldo(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('no_induk', "ASC");
        $data['kode_induk'] = $this->db->get('akuntansi_induk_akun')->result();
        $this->db->order_by('no_akun', "ASC");
        $data['kode_anak'] = $this->db->get('akuntansi_anak_akun')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('akuntansi_neraca_saldo', $data);
    }

    public function add_kode_induk_neraca(){
        $jenis = $_POST['jenis'];
        $kode_induk = $_POST['kode_induk'];
        $nama_induk = $_POST['nama_induk'];

        $query = $this->db->get_where('akuntansi_induk_akun', array('no_induk'=>$kode_induk));
        if($query->num_rows() == 0){
            $data = array(
                'no_induk'=>$kode_induk,
                'nama_induk'=>$nama_induk,
                'kategori_induk'=>$jenis
            );

            $this->db->insert('akuntansi_induk_akun', $data);

            $this->session->set_flashdata('succ_msg', "Data terdaftar!");
        } else {
            $this->session->set_flashdata('err_msg', "Data sudah ada!");
        }
        
        redirect('Dashboard/akun_neraca_saldo');
    }

    public function add_kode_neraca(){
        // $jenis = $_POST['jenis'];
        $id_induk = $_POST['id_induk'];
        foreach($this->db->get_where('akuntansi_induk_akun', array('id_induk'=>$id_induk))->result() as $row){
            $jenis = $row->kategori_induk;
        }

        // echo $jenis;
        // exit;
        $kode_akun = $_POST['kode_akun'];
        $nama_akun = $_POST['nama_akun'];
        $pos = $_POST['pos'];

        $query = $this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$kode_akun));
        if($query->num_rows() == 0){
            $data = array(
                'no_akun'=>$kode_akun,
                'nama_akun'=>$nama_akun,
                'kategori_induk'=>$jenis,
                'id_induk'=>$id_induk,
                'pos'=>$pos
            );

            $this->db->insert('akuntansi_anak_akun', $data);

            // $query3 = $this->db->get('perumahan');
            // foreach($query3->result() as $row){
            //     $data1 = array(
            //         // 'id_anak_akun'=>$id_akun,
            //         'no_akun'=>$kode_akun,
            //         'nama_akun'=>$nama_akun,
            //         'kategori_induk'=>$jenis,
            //         'id_induk'=>$id_induk,
            //         'pos'=>$pos,
            //         'kode_perumahan'=>$row->kode_perumahan
            //     );

            //     $this->db->insert('keuangan_neraca_saldo_awal', $data1);
            // }
            // $query2 = $this->db->get_where('keuangan_neraca_saldo_awal', array());

            // print_r($query3->result());
            // exit;

            $this->session->set_flashdata('succ_msg', "Data terdaftar!");
        } else {
            $this->session->set_flashdata('err_msg', "Data sudah ada!");
        }
        
        redirect('Dashboard/akun_neraca_saldo');
    }

    public function hapus_akun(){
        $id = $_GET['id'];

        $this->db->delete('akuntansi_anak_akun', array('id_akun'=>$id));

        redirect('Dashboard/akun_neraca_saldo');
    }

    public function view_neraca_saldo(){
        $data['nama'] = $this->session->userdata('nama');
        // $data['check_all'] = $this->db->get('keuangan_neraca_saldo')->result();

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('keuangan_neraca', $data);
    }

    // public function add_neraca_saldo(){
    //     $kode_perumahan = $kode_perumahan;

    //     $query = $this->db->get_where('keuangan_neraca_saldo', array('kode_perumahan'=>$kode_perumahan));
    //     if($query->num_rows() > 0){
    //         $this->session->set_flashdata('err_msg', "Data sudah ada");

    //         redirect('Dashboard/view_neraca_saldo');
    //     } else {
    //         $data = array(
    //             'kode_perumahan'=>$kode_perumahan
    //         );

    //         $this->db->insert('keuangan_neraca_saldo', $data);

    //         $this->session->set_flashdata('succ_msg', "Data sukses ditambahkan");

    //         redirect('Dashboard/view_neraca_saldo');
    //     }
    // }

    public function view_add_neraca_saldo_awal(){
        $id = $_GET['id'];

        foreach($this->db->get_where('perumahan', array('id_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['kode_perumahan'] = $row->kode_perumahan;
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['id'] = $id;

        $data['check_all'] = $this->db->get('akuntansi_induk_akun');

        $this->load->view('keuangan_neraca_saldo_awal', $data);
    }

    public function add_neraca_saldo_awal(){
        // $get = $_POST['pos'];
        $id = $_POST['id'];
        $id_akun = $_POST['id_akun'];
        $no_akun = $_POST['no_akun'];
        $nama_akun = $_POST['nama_akun'];
        $kategori = $_POST['kategori_induk'];
        $id_induk = $_POST['id_induk'];
        $pos = $_POST['pos'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $nominal = $_POST['nominal'];
        // print_r($get);
        // print_r($kode_perumahan);

        for($x = 0; $x < count($id_akun); $x++){
            $data = array(
                'id_anak_akun'=>$id_akun[$x],
                'no_akun'=>$no_akun[$x],
                'nama_akun'=>$nama_akun[$x],
                'kategori_induk'=>$kategori[$x],
                'id_induk'=>$id_induk[$x],
                'kode_perumahan'=>$kode_perumahan,
                'pos'=>$pos[$x],
                'nominal'=>$nominal[$x],
                'date_created'=>date('Y-m-d'),
                'id_created_by'=>$this->session->userdata('u_id')
            );

            $this->db->insert('keuangan_neraca_saldo_awal', $data);
        }

        // print_r($data);
        // exit;

        redirect('Dashboard/view_edit_neraca_saldo_awal?id='.$id);
    }

    public function view_edit_neraca_saldo_awal(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('id_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['kode_perumahan'] = $row->kode_perumahan;
        }

        $data['check_all'] = $this->db->get('akuntansi_induk_akun');

        $data['id'] = $id;

        $data['revisi'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$data['kode_perumahan']));

        $this->load->view('keuangan_neraca_saldo_awal', $data);
    }

    public function edit_neraca_saldo_awal(){
        $id = $_POST['id'];
        // $get = $_POST['pos'];
        $id_akun = $_POST['id_akun'];
        // print_r($id_akun);
        // exit;
        $no_akun = $_POST['no_akun'];
        $nama_akun = $_POST['nama_akun'];
        $kategori = $_POST['kategori_induk'];
        $id_induk = $_POST['id_induk'];
        $pos = $_POST['pos'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $nominal = $_POST['nominal'];
        // print_r($get);
        // print_r($kode_perumahan);
        // print_r($kode_perumahan);
        // exit;
        $this->db->delete('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$kode_perumahan));

        for($x = 0; $x < count($id_akun); $x++){
            $data = array(
                'id_anak_akun'=>$id_akun[$x],
                'no_akun'=>$no_akun[$x],
                'nama_akun'=>$nama_akun[$x],
                'kategori_induk'=>$kategori[$x],
                'id_induk'=>$id_induk[$x],
                'kode_perumahan'=>$kode_perumahan,
                'pos'=>$pos[$x],
                'nominal'=>$nominal[$x],
                'date_created'=>date('Y-m-d'),
                'id_created_by'=>$this->session->userdata('u_id')
            );

            $this->db->insert('keuangan_neraca_saldo_awal', $data);
        }

        // print_r($data);
        // exit;

        redirect('Dashboard/view_edit_neraca_saldo_awal?id='.$id);
    }
    //END OF MASTER DATA KEUANGAN

    //START OF PRODUKSI
    public function produksi_daftar_barang(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('nama_data', "ASC");
        $data['check_all'] = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"));

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('produksi_daftar_barang', $data);
    }

    public function add_produksi_daftar_barang(){
        $nama_barang = $_POST['nama_data'];
        $kategori = "barang";
        $nama_satuan = $_POST['nama_satuan'];
        // $harga_satuan = $_POST['harga_satuan'];

        $query = $this->db->get_where('produksi_master_data', array('nama_data'=>$nama_barang, 'kategori'=>$kategori));

        if($query->num_rows() > 0){
            $this->session->set_flashdata('err_msg', "Data telah ada!");
    
            redirect('Dashboard/produksi_daftar_barang');
        } else {
            $data = array(
                'kategori'=>$kategori,
                'nama_data'=>$nama_barang,
                'nama_satuan'=>$nama_satuan,
                // 'harga_satuan'=>$harga_satuan
            );
    
            $this->db->insert('produksi_master_data', $data);
    
            $this->session->set_flashdata('succ_msg', "Data telah ditambahkan");
    
            redirect('Dashboard/produksi_daftar_barang');
        }
    }

    public function edit_produksi_daftar_barang(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_check_all'] = $this->db->get_where('produksi_master_data', array('id_data'=>$id));
        
        $this->db->order_by('nama_data', "ASC");
        $data['check_all'] = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"));

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $data['id'] = $id;

        $this->load->view('produksi_daftar_barang', $data);
    }

    public function add_edit_daftar_barang(){
        $id = $_POST['id'];
        $nama_barang = $_POST['nama_data'];
        $kategori = "barang";
        $nama_satuan = $_POST['nama_satuan'];
        $harga_satuan = $_POST['harga_satuan'];
        
        $data = array(
            'kategori'=>$kategori,
            'nama_data'=>$nama_barang,
            'nama_satuan'=>$nama_satuan,
            'harga_satuan'=>$harga_satuan
        );

        $this->db->update('produksi_master_data', $data, array('id_data'=>$id));

        $this->session->set_flashdata('succ_msg', "Data telah diperbarui");

        redirect('Dashboard/edit_produksi_daftar_barang?id='.$id);
    }

    public function hapus_produksi_daftar_barang(){
        $id = $_GET['id'];
        
        $this->db->delete('produksi_master_data', array('id_data'=>$id));

        $this->session->set_flashdata('succ_msg', "Data telah dihapus");

        redirect('Dashboard/produksi_daftar_barang');
    }
    
    public function produksi_daftar_toko(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('produksi_master_data', array('kategori'=>"toko"));

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('produksi_daftar_toko', $data);
    }

    public function add_produksi_daftar_toko(){
        $nama_barang = $_POST['nama_data'];
        $kategori = "toko";

        $query = $this->db->get_where('produksi_master_data', array('nama_data'=>$nama_barang, 'kategori'=>$kategori));

        if($query->num_rows() > 0){
            $this->session->set_flashdata('err_msg', "Data telah ada!");
    
            redirect('Dashboard/produksi_daftar_toko');
        } else {
            $data = array(
                'kategori'=>$kategori,
                'nama_data'=>$nama_barang
            );

            $this->db->insert('produksi_master_data', $data);

            $this->session->set_flashdata('succ_msg', "Data telah ditambahkan");

            redirect('Dashboard/produksi_daftar_toko');
        }
    }

    public function edit_produksi_daftar_toko(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_check_all'] = $this->db->get_where('produksi_master_data', array('id_data'=>$id));
        
        $this->db->order_by('nama_data', "ASC");
        $data['check_all'] = $this->db->get_where('produksi_master_data', array('kategori'=>"toko"));

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $data['id'] = $id;

        $this->load->view('produksi_daftar_toko', $data);
    }

    public function add_edit_daftar_toko(){
        $id = $_POST['id'];
        $nama_barang = $_POST['nama_data'];
        $kategori = "toko";
        // $nama_satuan = $_POST['nama_satuan'];
        // $harga_satuan = $_POST['harga_satuan'];
        
        $data = array(
            'kategori'=>$kategori,
            'nama_data'=>$nama_barang,
            // 'nama_satuan'=>$nama_satuan,
            // 'harga_satuan'=>$harga_satuan
        );

        $this->db->update('produksi_master_data', $data, array('id_data'=>$id));

        $this->session->set_flashdata('succ_msg', "Data telah diperbarui");

        redirect('Dashboard/edit_produksi_daftar_toko?id='.$id);
    }

    public function hapus_produksi_daftar_toko(){
        $id = $_GET['id'];
        
        $this->db->delete('produksi_master_data', array('id_data'=>$id));

        $this->session->set_flashdata('succ_msg', "Data telah dihapus");

        redirect('Dashboard/produksi_daftar_toko');
    }
    
    public function produksi_daftar_satuan(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('nama_data', "ASC");
        $data['check_all'] = $this->db->get_where('produksi_master_data', array('kategori'=>"satuan"));

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('produksi_daftar_satuan', $data);
    }

    public function add_produksi_daftar_satuan(){
        $nama_barang = $_POST['nama_data'];
        $kategori = "satuan";

        $query = $this->db->get_where('produksi_master_data', array('nama_data'=>$nama_barang, 'kategori'=>$kategori));         

        if($query->num_rows() > 0){
            $this->session->set_flashdata('err_msg', "Data telah ada!");
    
            redirect('Dashboard/produksi_daftar_satuan');
        } else {
            $data = array(
                'kategori'=>$kategori,
                'nama_data'=>$nama_barang
            );

            $this->db->insert('produksi_master_data', $data);

            $this->session->set_flashdata('succ_msg', "Data telah ditambahkan");

            redirect('Dashboard/produksi_daftar_satuan');
        }
    }

    public function edit_produksi_daftar_satuan(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_check_all'] = $this->db->get_where('produksi_master_data', array('id_data'=>$id));
        
        $this->db->order_by('nama_data', "ASC");
        $data['check_all'] = $this->db->get_where('produksi_master_data', array('kategori'=>"satuan"));

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $data['id'] = $id;

        $this->load->view('produksi_daftar_satuan', $data);
    }

    public function add_edit_daftar_satuan(){
        $id = $_POST['id'];
        $nama_barang = $_POST['nama_data'];
        $kategori = "satuan";
        // $nama_satuan = $_POST['nama_satuan'];
        // $harga_satuan = $_POST['harga_satuan'];
        
        $data = array(
            'kategori'=>$kategori,
            'nama_data'=>$nama_barang,
            // 'nama_satuan'=>$nama_satuan,
            // 'harga_satuan'=>$harga_satuan
        );

        $this->db->update('produksi_master_data', $data, array('id_data'=>$id));

        $this->session->set_flashdata('succ_msg', "Data telah diperbarui");

        redirect('Dashboard/edit_produksi_daftar_satuan?id='.$id);
    }

    public function hapus_produksi_daftar_satuan(){
        $id = $_GET['id'];
        
        $this->db->delete('produksi_master_data', array('id_data'=>$id));

        $this->session->set_flashdata('succ_msg', "Data telah dihapus");

        redirect('Dashboard/produksi_daftar_satuan');
    }

    public function management_pembelian_bahan(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('id_transaksi', "DESC");
        $data['check_all'] = $this->db->get('produksi_master_transaksi');

        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('produksi_management_pembelian_bahan', $data);
    }
    
    public function filter_management_pembelian_bahan(){
        $kode_perumahan = $_POST['kode_perumahan'];
        $nama_toko = $_POST['nama_toko'];
        $tgl_pesan = $_POST['tgl_pesan'];
        $tgl_deadline = $_POST['tgl_deadline'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->Dashboard_model->filter_management_pembelian_bahan();

        $this->load->view('produksi_management_pembelian_bahan', $data);
    }

    public function pembelian_bahan(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('nama_data', "ASC");
        $data['barang'] = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"));
        $data['toko'] = $this->db->get_where('produksi_master_data', array('kategori'=>"toko"));
        $data['satuan'] = $this->db->get_where('produksi_master_data', array('kategori'=>"satuan"));
        
        $this->db->order_by('id_transaksi', "DESC");
        $data['check_all'] = $this->db->get('produksi_master_transaksi');

        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['error_upload'] = $this->session->flashdata('error_upload');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_pembelian_bahan', $data);
    }

    public function add_pembelian_bahan(){
        $no_faktur = $_POST['no_faktur'];
        $toko_bangunan = $_POST['toko_bangunan'];
        $tgl_pesan = $_POST['tanggal_pesan'];
        $tgl_deadline = $_POST['tanggal_tempo'];

        $nama_bahan = $_POST['nama_bahan'];
        $qty = $_POST['qty'];
        $satuan = $_POST['satuan'];
        $harga_satuan = $_POST['harga_satuan'];

        $kode_perumahan = $_POST['kode_perumahan'];

        // $berkas = $_POST['berkas'];
        // $upload_data = $this->upload->data('berkas');
        // $file_name = $upload_data['file_name'];
        // print_r($file_name);
        // exit;

        $patokan = date('Y-m-1', strtotime($tgl_pesan));

        $dates = new DateTime($patokan);
        $weeks = $dates->format("W");
        $w = $weeks-1;

        // $ddate = "2012-10-18";
        $date = new DateTime($tgl_pesan);
        $week = $date->format("W");

        $week_num = $week;
        // $firstOfMonth = strtotime(date('Y-m-d', $tgl_pesan));
        // echo "Weeknummer: $week_num";
        // echo strtotime(date('Y-m-d')) - intval(date("W", $firstOfMonth)) + 1;
        // exit;
        $config['upload_path']          = './gambar/produksi/';
        $config['allowed_types']        = 'gif|jpg|png';
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
    
        $this->load->library('upload', $config);
    
        if ($this->upload->do_upload()){
            $upload = array('upload_data' => $this->upload->data());

            // foreach($upload['upload_data']['file_name'] as $item){
            //     $file_name = $item->file_name;
            // }
            // print_r($upload['upload_data']['file_name']);
            // print_r($file_name);
            // exit;
            $file_name = $upload['upload_data']['file_name'];
            
            $query = $this->db->get_where('produksi_transaksi', array('no_faktur'=>$no_faktur));
            if($query->num_rows() > 0){
                $this->session->set_flashdata('err_msg', "Data telah terinput");

                redirect('Dashboard/pembelian_bahan');
            } else {
                $data1 = array(
                    'no_faktur'=>$no_faktur,
                    'nama_toko'=>$toko_bangunan,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_pesan'=>$tgl_pesan,
                    'tanggal_tempo'=>$tgl_deadline,
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'date_created'=>date('Y-m-d'),
                    'file_name'=>$file_name
                );

                $this->db->insert('produksi_master_transaksi', $data1);

                for($i = 0; $i < count($nama_bahan); $i++){
                    $data = array(
                        'nama_barang'=>$nama_bahan[$i],
                        'nama_toko'=>$toko_bangunan,
                        'no_faktur'=>$no_faktur,
                        'kode_perumahan'=>$kode_perumahan,
                        'qty'=>$qty[$i],
                        'nama_satuan'=>$satuan[$i],
                        'harga_satuan'=>$harga_satuan[$i],
                        'tgl_pesan'=>$tgl_pesan,
                        'tgl_deadline'=>$tgl_deadline,
                        'week_num'=>$week_num,
                        'id_created_by'=>$this->session->userdata('u_id'),
                        'created_by'=>$this->session->userdata('nama'),
                        'date_created'=>date('Y-m-d')
                    );

                    $this->db->insert('produksi_transaksi', $data);
                }
                
                $this->session->set_flashdata('succ_msg', "Data berhasil ditambahkan!");
                redirect('Dashboard/pembelian_bahan');
                // print_r($_POST['nama_bahan']);
            }
        } else {
            // $data['error_upload'] = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));

            // $this->load->view('user', $data);
            $upload = array('upload_data' => $this->upload->data());

            $file_name = $upload['upload_data']['file_name'];
            
            $query = $this->db->get_where('produksi_transaksi', array('no_faktur'=>$no_faktur));
            if($query->num_rows() > 0){
                $this->session->set_flashdata('err_msg', "Data telah terinput");

                redirect('Dashboard/pembelian_bahan');
            } else {
                $data1 = array(
                    'no_faktur'=>$no_faktur,
                    'nama_toko'=>$toko_bangunan,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_pesan'=>$tgl_pesan,
                    'tanggal_tempo'=>$tgl_deadline,
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'date_created'=>date('Y-m-d'),
                    'file_name'=>$file_name
                );

                $this->db->insert('produksi_master_transaksi', $data1);

                for($i = 0; $i < count($nama_bahan); $i++){
                    $data = array(
                        'nama_barang'=>$nama_bahan[$i],
                        'nama_toko'=>$toko_bangunan,
                        'no_faktur'=>$no_faktur,
                        'kode_perumahan'=>$kode_perumahan,
                        'qty'=>$qty[$i],
                        'nama_satuan'=>$satuan[$i],
                        'harga_satuan'=>$harga_satuan[$i],
                        'tgl_pesan'=>$tgl_pesan,
                        'tgl_deadline'=>$tgl_deadline,
                        'week_num'=>$week_num,
                        'id_created_by'=>$this->session->userdata('u_id'),
                        'created_by'=>$this->session->userdata('nama'),
                        'date_created'=>date('Y-m-d')
                    );

                    $this->db->insert('produksi_transaksi', $data);
                }
                
                $this->session->set_flashdata('succ_msg', "Data berhasil ditambahkan!");
                redirect('Dashboard/pembelian_bahan');
                // print_r($_POST['nama_bahan']);
            }
            // redirect('Dashboard/pembelian_bahan');
        }
    }

    public function pembelian_bahan_stok(){
        $kode_perumahan = $_POST['kode_perumahan'];
        $id_brg = $_POST['id_arus'];
        // $harga_satuan = $_POST['harga_satuan'];

        if(count($id_brg) == 0){
            echo "<script>
                    alert('Tidak ada yang dipilih!');
                    window.location.href='rekap_arus_stok?id=$kode_perumahan';
                  </script>";
        } else {
            $arr = array();
            foreach($id_brg as $row){
                foreach($this->db->get_where('logistik_arus_stok', array('id_arus'=>$row))->result() as $row1){
                    array_push($arr, $row1->nama_toko);
                }
            }

            // $stat = null;
            // print_r($arr);

            if(count(array_unique($arr)) != 1){
                echo "<script>
                        alert('Toko bangunan tidak sama!');
                        window.location.href='rekap_arus_stok?id=$kode_perumahan';
                      </script>";
            } else {
                $data['nama'] = $this->session->userdata('nama');
        
                $this->db->order_by('nama_data', "ASC");
                $data['barang'] = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"));
                $data['toko'] = $this->db->get_where('produksi_master_data', array('kategori'=>"toko"));
                $data['satuan'] = $this->db->get_where('produksi_master_data', array('kategori'=>"satuan"));
                
                $this->db->order_by('id_transaksi', "DESC");
                $data['check_all'] = $this->db->get('produksi_master_transaksi');

                $data['id_brg'] = $id_brg;
                $data['nama_toko'] = $arr[0];
                $data['kode_perumahan'] = $kode_perumahan;
        
                $data['err_msg'] = $this->session->flashdata('err_msg');
                $data['error_upload'] = $this->session->flashdata('error_upload');
                $data['succ_msg'] = $this->session->flashdata('succ_msg');
        
                $this->load->view('produksi_pembelian_bahan_stok', $data);
            }

        }
        
        // print_r($id_brg);        
        // for($i = 0; $i < count($id_brg); $i++){
        //     $data = array(
        //         'status'=>"diajukan"
        //     );

        //     $this->db->update('logistik_arus_stok', $data, array('id_arus'=>$id_brg[$i]));
        // }
    }

    public function add_pembelian_bahan_stok(){
        $no_faktur = $_POST['no_faktur'];
        $toko_bangunan = $_POST['toko_bangunan'];
        $tgl_pesan = $_POST['tanggal_pesan'];
        $tgl_deadline = $_POST['tanggal_tempo'];

        $nama_bahan = $_POST['nama_bahan'];
        $qty = $_POST['qty'];
        $satuan = $_POST['satuan'];
        $harga_satuan = $_POST['harga_satuan'];

        $kode_perumahan = $_POST['kode_perumahan'];
        $id_arus = $_POST['id_arus'];
        $harga_satuan1 = $_POST['harga_satuan1'];

        // print_r($harga_satuan1);
        // print_r($id_arus);
        // exit;

        // $berkas = $_POST['berkas'];
        // $upload_data = $this->upload->data('berkas');
        // $file_name = $upload_data['file_name'];
        // print_r($file_name);
        // exit;

        $patokan = date('Y-m-1', strtotime($tgl_pesan));

        $dates = new DateTime($patokan);
        $weeks = $dates->format("W");
        $w = $weeks-1;

        // $ddate = "2012-10-18";
        $date = new DateTime($tgl_pesan);
        $week = $date->format("W");

        $week_num = $week;
        // $firstOfMonth = strtotime(date('Y-m-d', $tgl_pesan));
        // echo "Weeknummer: $week_num";
        // echo strtotime(date('Y-m-d')) - intval(date("W", $firstOfMonth)) + 1;
        // exit;
        $config['upload_path']          = './gambar/produksi/';
        $config['allowed_types']        = 'gif|jpg|png';
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
    
        $this->load->library('upload', $config);
    
        if ($this->upload->do_upload()){
            $upload = array('upload_data' => $this->upload->data());

            // foreach($upload['upload_data']['file_name'] as $item){
            //     $file_name = $item->file_name;
            // }
            // print_r($upload['upload_data']['file_name']);
            // print_r($file_name);
            // exit;
            $file_name = $upload['upload_data']['file_name'];
            
            $query = $this->db->get_where('produksi_transaksi', array('no_faktur'=>$no_faktur));
            if($query->num_rows() > 0){
                // $this->session->set_flashdata('err_msg', "Data telah terinput");

                // redirect('Dashboard/rekap_arus_stok?id='.$kode_perumahan);
                echo "<script type='text/javascript'>
                        alert('No faktur sudah ada!');
                        window.location.href='rekap_arus_stok?id=$kode_perumahan';
                      </script>";
            } else {
                $data1 = array(
                    'no_faktur'=>$no_faktur,
                    'nama_toko'=>$toko_bangunan,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_pesan'=>$tgl_pesan,
                    'tanggal_tempo'=>$tgl_deadline,
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'date_created'=>date('Y-m-d'),
                    'file_name'=>$file_name
                );

                $this->db->insert('produksi_master_transaksi', $data1);

                for($i = 0; $i < count($nama_bahan); $i++){
                    $data = array(
                        'nama_barang'=>$nama_bahan[$i],
                        'nama_toko'=>$toko_bangunan,
                        'no_faktur'=>$no_faktur,
                        'kode_perumahan'=>$kode_perumahan,
                        'qty'=>$qty[$i],
                        'nama_satuan'=>$satuan[$i],
                        'harga_satuan'=>$harga_satuan[$i],
                        'tgl_pesan'=>$tgl_pesan,
                        'tgl_deadline'=>$tgl_deadline,
                        'week_num'=>$week_num,
                        'id_created_by'=>$this->session->userdata('u_id'),
                        'created_by'=>$this->session->userdata('nama'),
                        'date_created'=>date('Y-m-d'),
                        'id_arus'=>$id_arus[$i]
                    );

                    $this->db->insert('produksi_transaksi', $data);

                    $data1 = array(
                        'status'=>"diajukan"
                    );

                    $this->db->update('logistik_arus_stok', $data1, array('id_arus'=>$id_arus[$i]));
                }
                
                $this->session->set_flashdata('succ_msg', "Data berhasil ditambahkan!");
                redirect('Dashboard/rekap_arus_stok?id='.$kode_perumahan);
                // print_r($_POST['nama_bahan']);
            }
        } else {
            // $data['error_upload'] = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error_upload', array('error' => $this->upload->display_errors()));

            // $this->load->view('user', $data);
            $upload = array('upload_data' => $this->upload->data());

            $file_name = $upload['upload_data']['file_name'];
            
            $query = $this->db->get_where('produksi_transaksi', array('no_faktur'=>$no_faktur));
            if($query->num_rows() > 0){
                // $this->session->set_flashdata('err_msg', "Data telah terinput");

                // redirect('Dashboard/pembelian_bahan');
                echo "<script type='text/javascript'>
                        alert('No faktur sudah ada!');
                        window.location.href='rekap_arus_stok?id=$kode_perumahan';
                      </script>";
            } else {
                $data1 = array(
                    'no_faktur'=>$no_faktur,
                    'nama_toko'=>$toko_bangunan,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_pesan'=>$tgl_pesan,
                    'tanggal_tempo'=>$tgl_deadline,
                    'id_created_by'=>$this->session->userdata('u_id'),
                    'created_by'=>$this->session->userdata('nama'),
                    'date_created'=>date('Y-m-d'),
                    'file_name'=>$file_name
                );

                $this->db->insert('produksi_master_transaksi', $data1);

                for($i = 0; $i < count($nama_bahan); $i++){
                    $data = array(
                        'nama_barang'=>$nama_bahan[$i],
                        'nama_toko'=>$toko_bangunan,
                        'no_faktur'=>$no_faktur,
                        'kode_perumahan'=>$kode_perumahan,
                        'qty'=>$qty[$i],
                        'nama_satuan'=>$satuan[$i],
                        'harga_satuan'=>$harga_satuan[$i],
                        'tgl_pesan'=>$tgl_pesan,
                        'tgl_deadline'=>$tgl_deadline,
                        'week_num'=>$week_num,
                        'id_created_by'=>$this->session->userdata('u_id'),
                        'created_by'=>$this->session->userdata('nama'),
                        'date_created'=>date('Y-m-d'),
                        'id_arus'=>$id_arus[$i]
                    );

                    $this->db->insert('produksi_transaksi', $data);

                    $data1 = array(
                        'status'=>"diajukan",
                        'harga_satuan'=>$harga_satuan1[$i]
                    );

                    $this->db->update('logistik_arus_stok', $data1, array('id_arus'=>$id_arus[$i]));

                    // $data2 = array(
                    // );
                }
                
                $this->session->set_flashdata('succ_msg', "Data berhasil ditambahkan!");
                redirect('Dashboard/rekap_arus_stok?id='.$kode_perumahan);
                // print_r($_POST['nama_bahan']);
            }
            // redirect('Dashboard/pembelian_bahan');
        }
    }

    public function get_nofaktur(){
        $faktur = $_POST['faktur'];

        if(isset($faktur)){
            $db = $this->db->get_where('produksi_master_transaksi', array('no_faktur'=>$faktur));

            if($db->num_rows() > 0){
                echo "<span style='color: red'>No faktur telah terdaftar!</span>";
            } else {
                echo "<span style='color: green'>No faktur dapat digunakan!</span>";
            }
        }
    }

    public function get_nofaktur_list(){
        $faktur = $_POST['faktur'];

        if(isset($faktur)){
            if($faktur == ""){

            } else {
                $this->db->like('no_faktur', $faktur);
                $db = $this->db->get_where('produksi_master_transaksi');

                echo "<div style='background-color: lightgreen'>Daftar Faktur yang Terdaftar:</div>";
                echo "<ol style='background-color: lightgreen'>";
                foreach($db->result() as $row){
                    echo "<li>$row->no_faktur</li>";
                }
                echo "</ol>";
            }
        }
    }

    public function detail_pembelian_bahan(){
        $id = $_GET['id'];

        $data['prod'] = $this->db->get_where('produksi_master_transaksi', array('id_transaksi'=>$id))->result();
        foreach($data['prod'] as $row){
            $no_faktur = $row->no_faktur;
            $kode_perumahan = $row->kode_perumahan;
        }

        $data['no_faktur'] = $no_faktur;
        $data['kode_perumahan'] = $kode_perumahan;

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('produksi_transaksi', array('no_faktur'=>$no_faktur));

        $this->load->view('produksi_pembelian_bahan_detail', $data);
    }

    public function hapus_pembelian_bahan(){
        $no_faktur = $_GET['id'];
        $id_tr = $_GET['ids'];

        foreach($this->db->get_where('produksi_transaksi', array('no_faktur'=>$no_faktur))->result() as $row){
            $id_arus = $row->id_arus;

            $data = array(
                'status'=>""
            );

            $this->db->update('logistik_arus_stok', $data, array('id_arus'=>$id_arus));
        }

        $this->db->delete('produksi_master_transaksi', array('id_transaksi'=>$id_tr));
        $this->db->delete('produksi_transaksi', array('no_faktur'=>$no_faktur));

        $this->session->set_flashdata('err_msg', "Data sukses dihapus!");

        redirect('Dashboard/management_pembelian_bahan');
    }

    // public function pembayaran_pembelian(){
    //     $id = $_GET['id'];

    //     $data['prod'] = $this->db->get_where('produksi_master_transaksi', array('id_transaksi'=>$id))->result();
    //     foreach($data['prod'] as $row){
    //         $no_faktur = $row->no_faktur;
    //         $kode_perumahan = $row->kode_perumahan;
    //     }

    //     $data['nama'] = $this->session->userdata('nama');
    //     $data['id'] = $id;

    //     $data['no_faktur'] = $no_faktur;

    //     $data['bank'] = $this->db->get('bank')->result();

    //     $data['totalUtang'] = $this->db->get_where('produksi_transaksi', array('no_faktur'=>$no_faktur, 'kode_perumahan'=>$kode_perumahan));

    //     $this->load->view('produksi_pembayaran', $data);
    // }

    // public function get_faktur_pembayaran(){
    //     $data['nama'] = $this->session->userdata('nama');

    //     $data['prod'] = $this->Dashboard_model->get_faktur();

    //     $this->load->view('produksi_pembayaran_bahan', $data);
    // }

    // public function add_pembayaran_pembelian_bahan(){
    //     $id=$_POST['id'];

    //     $no_faktur = $_POST['no_faktur'];

    //     redirect('Dashboard/detail_pembelian_bahan?id='.$id);
    // }

    public function rincian_pembelian_perumahan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('produksi_rincian_pembelian_perumahan', $data);
    }

    public function rincian_pembelian(){
        $id=$_GET['id'];
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = date('Y-m');

        $data['check_all'] = $this->Dashboard_model->rincian_pembelian($id, $data['tgl']);

        $this->load->view('produksi_rincian_pembelian', $data);
    }

    public function filter_rincian_pembelian(){
        $id=$_POST['id'];
        $bln = $_POST['bulan'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = $bln;

        $data['check_all'] = $this->Dashboard_model->rincian_pembelian($id, $data['tgl']);

        $this->load->view('produksi_rincian_pembelian', $data);
    }

    public function open_akses_edit_pembelian(){
        $id = $_GET['id'];
        $bln = $_GET['bln'];

        $data = array(
            'status_rev'=>"true",
            'date_rev'=>date('Y-m-d H:i:sa am/pm'),
            'count_rev'=>"1"
        );

        $this->db->update('produksi_transaksi', $data, array('status <>'=>"lunas"));

        // $data1 = array(
        //     'date_rev'=>date('Y-m-d H:i:sa am/pm')
        // );

        // $this->db->update('produksi_transaksi', $data1, array('status'=>"lunas"));

        redirect('Dashboard/rincian_pembelian?id='.$id);
    }

    public function edit_rincian_pembelian(){
        $id = $_POST['id'];
        $bln = $_POST['bln'];

        $id_prod = $_POST['id_prod'];
        $qty = $_POST['qty'];
        $harga_satuan = $_POST['harga_satuan'];
        $tgl_pesan = $_POST['tgl_pesan'];
        $tgl_deadline = $_POST['tgl_deadline'];

        for($i = 0; $i <= count($id_prod); $i++){
            $data = array(
                'qty'=>$qty[$i],
                'harga_satuan'=>$harga_satuan[$i],
                'tgl_pesan'=>$tgl_pesan[$i],
                'tgl_deadline'=>$tgl_deadline[$i]
            );

            $this->db->update('produksi_transaksi', $data, array('id_prod'=>$id_prod[$i]));
        }

        $data1 = array(
            'status_rev'=>"",
            'count_rev'=>"0"
        );

        $this->db->update('produksi_transaksi', $data1, array('status <>'=>"lunas"));

        $this->session->set_flashdata('succ_msg', "Data berhasil diubah!");

        redirect('Dashboard/v_edit_rincian_pembelian?id='.$id."&bln=".$bln);
    }

    public function r_filter_rincian_pembelian(){
        $id = $_GET['id'];
        $bln = $_GET['bln'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = $bln;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $data['check_all'] = $this->Dashboard_model->rincian_pembelian($id, $data['tgl']);

        $this->load->view('produksi_rincian_pembelian', $data);
    }

    public function rincian_pembelian_utang(){
        $id = $_GET['id'];
        $bln = $_GET['bln'];
        $tk = $_GET['tk'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = $bln;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $data['check_all'] = $this->Dashboard_model->rincian_pembelian_tk($id, $bln, $tk);
        $data['varUtang'] = "";

        $this->load->view('produksi_rincian_pembelian', $data);
    }

    public function v_edit_rincian_pembelian(){
        $id = $_GET['id'];
        $bln = $_GET['bln'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = $bln;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $data['check_all'] = $this->Dashboard_model->rincian_pembelian($id, $data['tgl']);

        $data['edit_prod'] = "";

        $this->load->view('produksi_rincian_pembelian', $data);
    }

    public function sv_edit_rincian_pembelian(){
        $id = $_POST['id'];
        $bln = $_POST['bln'];

        $password = $_POST['password'];

        $gets = $this->db->get_where('kodeotp', array('kode'=>$password));
        // print_r($gets->num_rows());
        // exit;

        if($gets->num_rows() == 0){
            $this->session->set_flashdata('err_msg', "Kode Akses Salah!");

            redirect('Dashboard/r_filter_rincian_pembelian?id='.$id."&bln=".$bln);
        } else {
            foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
            }

            $data['id'] = $id;

            $data['nama'] = $this->session->userdata('nama');

            $data['tgl'] = $bln;

            $data['succ_msg'] = $this->session->flashdata('succ_msg');

            $data['check_all'] = $this->Dashboard_model->rincian_pembelian($id, $data['tgl']);

            $data['edit_prod'] = "";

            $this->db->delete('kodeotp', array('kode'=>$password));

            $this->load->view('produksi_rincian_pembelian', $data);
        }
    }

    public function daftar_kode_akses_edit_rincian_pembelian(){
        $otp = $_POST['otp'];
        $id = $_POST['id'];
        $bln = $_POST['bln'];

        $user = $this->session->userdata('nama');
        $tgl_buat = date('Y-m-d');

        $check = $this->db->get_where('kodeotp', array('kode'=>$otp));

        if($check->num_rows() > 0){
            $this->session->set_flashdata('err_msg', "Kode akses terdaftar!");

            redirect('Dashboard/r_filter_rincian_pembelian?id='.$id."&bln=".$bln);
        } else {
            $data = array(
                'tanggal_buat'=>$tgl_buat,
                'email'=>$user,
                'kode'=>$otp
            );

            $this->db->insert('kodeotp', $data);

            $this->session->set_flashdata('succ_msg', "Kode Akses telah didaftarkan");

            redirect('Dashboard/r_filter_rincian_pembelian?id='.$id."&bln=".$bln);
        }
    }

    public function rekap_rincian_pembelian_perumahan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('produksi_rekap_rincian_pembelian_perumahan', $data);
    }

    public function rekap_rincian_pembelian(){
        $id=$_GET['id'];
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = date('Y-m');

        $patokan = date('Y-m-1', strtotime($data['tgl']));

        $dates = new DateTime($patokan);
        $weeks = $dates->format("W");
        // $w = $weeks-1;

        // $ddate = "2012-10-18";
        // $date = new DateTime($tgl_pesan);
        // $week = $date->format("W");

        $data['week'] = $weeks;

        $data['querys'] = $this->Dashboard_model->get_rekap_rincian_pembelian($data['tgl'], $id);

        // print_r($data['querys']->result_array());
        // exit;
        // $data['check_all'] = $this->db->get_where('', array('kode_perumahan'=>$id));

        $this->load->view('produksi_rekap_rincian_pembelian', $data);
    }

    public function filter_rekap_rincian_pembelian(){
        $id = $_POST['id'];
        $tgl = $_POST['bulan'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = $tgl;

        $patokan = date('Y-m-1', strtotime($data['tgl']));

        $dates = new DateTime($patokan);
        $weeks = $dates->format("W");
        // $w = $weeks-1;

        // $ddate = "2012-10-18";
        // $date = new DateTime($tgl_pesan);
        // $week = $date->format("W");

        $data['week'] = $weeks;

        $data['querys'] = $this->Dashboard_model->get_rekap_rincian_pembelian($data['tgl'], $id);

        // print_r($data['querys']->result_array());
        // exit;
        // $data['check_all'] = $this->db->get_where('', array('kode_perumahan'=>$id));

        $this->load->view('produksi_rekap_rincian_pembelian', $data);
    }

    public function print_rekap_rincian(){
        $id = $_GET['id'];
        // $tk_bangunan = $_GET['tk'];
        $bulan = $_GET['bln'];

        // echo $id.$bulan;
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;
        $data['tgl'] = $bulan;

        $patokan = date('Y-m-1', strtotime($data['tgl']));

        $dates = new DateTime($patokan);
        $weeks = $dates->format("W");
        // $w = $weeks-1;

        // $ddate = "2012-10-18";
        // $date = new DateTime($tgl_pesan);
        // $week = $date->format("W");

        $data['week'] = $weeks;

        $data['querys'] = $this->Dashboard_model->get_rekap_rincian_pembelian($data['tgl'], $id);

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-psjb.pdf";
        ob_end_clean();
        $this->pdf->load_view('produksi_print_rekap', $data);
    }
    
    public function rincian_jatuh_tempo_perumahan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('produksi_rincian_jatuh_tempo_perumahan', $data);
    }

    public function rincian_jatuh_tempo(){
        $id=$_GET['id'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = date('Y-m');

        $patokan = date('Y-m-1', strtotime($data['tgl']));

        $dates = new DateTime($patokan);
        $weeks = $dates->format("W");
        // $w = $weeks-1;

        // $ddate = "2012-10-18";
        // $date = new DateTime($tgl_pesan);
        // $week = $date->format("W");

        $data['week'] = $weeks;

        $data['check_all'] = $this->Dashboard_model->get_rincian_jatuh_tempo($data['tgl'], $id);

        // print_r($data['querys']->result_array());
        // exit;
        // $data['check_all'] = $this->db->get_where('', array('kode_perumahan'=>$id));

        $this->load->view('produksi_rincian_jatuh_tempo', $data);
    }

    public function filter_rincian_jatuh_tempo(){
        $id = $_POST['id'];
        $tgl = $_POST['bulan'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = $tgl;

        $patokan = date('Y-m-1', strtotime($data['tgl']));

        $dates = new DateTime($patokan);
        $weeks = $dates->format("W");
        // $w = $weeks-1;

        // $ddate = "2012-10-18";
        // $date = new DateTime($tgl_pesan);
        // $week = $date->format("W");

        $data['week'] = $weeks;

        // $data['querys'] = $this->Dashboard_model->get_rekap_rincian_pembelian($data['tgl'], $id, $weeks);
        $data['check_all'] = $this->Dashboard_model->get_rincian_jatuh_tempo($data['tgl'], $id);

        // print_r($data['querys']->result_array());
        // exit;
        // $data['check_all'] = $this->db->get_where('', array('kode_perumahan'=>$id));

        $this->load->view('produksi_rincian_jatuh_tempo', $data);
    }

    public function pembayaran_pembelian_bahan(){
        $id = 1;
        $data['nama'] = $this->session->userdata('nama');

        // $data['prod'] = $this->db->get_where('produksi_master_transaksi', array('id_transaksi'=>$id))->result();
        // foreach($data['prod'] as $row){
        //     $no_faktur = $row->no_faktur;
        //     $kode_perumahan = $row->kode_perumahan;
        $tgl_awal = date('Y-m-d');
        $tgl_akhir = date('Y-m-d');
        $this->db->order_by('id_perumahan', "DESC");
        foreach($this->db->get('perumahan', 1, 1)->result() as $row){
            $kode_perumahan = $row->kode_perumahan;
        }
        // $kode_perumahan = ;
        $this->db->order_by('id_data', "DESC");
        foreach($this->db->get_where('produksi_master_data', array('kategori'=>"toko"), 1, 1)->result() as $row1){
            // $tk_bangunan = $row1->nama_data;
        }
        // $tk_bangunan = $_POST['tk_bangunan'];
        // }
        // $data['prod'] = $this->Dashboard_model->filter_pembayaran_pembelian_bahan($tgl_awal, $tgl_akhir, $kode_perumahan, $tk_bangunan);
        // print_r($data['prod']->result());
        // exit;
        
        $data['nama'] = $this->session->userdata('nama');

        // $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['kode_perumahan'] = $kode_perumahan;
        // $data['tk_bangunan'] = $tk_bangunan;

        // $this->load->view('produksi_pembayaran_bahan', $data);

        $this->load->view('produksi_pembayaran_bahan', $data);
    }

    public function filter_pembayaran_pembelian_bahan(){
        // $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];
        $kode_perumahan = $_POST['perumahan'];
        $tk_bangunan = $_POST['tk_bangunan'];

        $data['prod'] = $this->Dashboard_model->filter_pembayaran_pembelian_bahan( $tgl_akhir, $kode_perumahan, $tk_bangunan);
        
        $data['nama'] = $this->session->userdata('nama');

        // $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['kode_perumahan'] = $kode_perumahan;
        $data['tk_bangunan'] = $tk_bangunan;

        $this->load->view('produksi_pembayaran_bahan', $data);
    }

    public function add_pembayaran_pembelian_bahan(){
        $id_prod = $_POST['id_prod'];

        $keterangan = $_POST['keterangan'];
        $tgl_aju = $_POST['tgl_aju'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $tgl_jatuh_tempo = $_POST['tgl_jatuh_tempo'];

        $data['nama'] = $this->session->userdata('nama');

        $id_pengajuan = 1;
        $this->db->order_by('id_pengajuan', "DESC");
        foreach($this->db->get('produksi_pengajuan', 1)->result() as $row){
            $id_pengajuan = $row->id_pengajuan + 1;
        }

        $data = array(
            'id_pengajuan'=>$id_pengajuan,
            'keterangan'=>$keterangan,
            'tgl_aju'=>$tgl_aju,
            'tgl_jatuh_tempo'=>$tgl_jatuh_tempo,
            'kode_perumahan'=>$kode_perumahan,
            'created_by'=>$data['nama'],
            'id_created_by'=>$this->session->userdata('u_id'),
            'status'=>"menunggu",
            'date_by'=>date('Y-m-d H:i:sa am/pm')
            // 'tgl_pengajuan'=>$tgl_aju
        );

        $this->db->insert('produksi_pengajuan', $data);

        for($i = 0; $i < count($id_prod); $i++){
            $data1 = array(
                'id_pengajuan'=>$id_pengajuan,
                'status'=>"diajukan"
            );

            $this->db->update('produksi_transaksi', $data1, array('id_prod'=>$id_prod[$i]));
        }

        $this->session->set_flashdata('succ_msg', "Data berhasil ditambahkan!");

        redirect('Dashboard/informasi_pengajuan_pembayaran');
        // $this->load->view('produksi_pengajuan_management', $data);
    }

    public function informasi_pengajuan_pembayaran(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('produksi_pengajuan');
        
        $this->load->view('produksi_pengajuan_management', $data);
    }

    public function app_informasi_pengajuan_pembayaran(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('produksi_pengajuan', array('status'=>"menunggu"));
        
        $this->load->view('produksi_pengajuan_management', $data);
    }

    public function byr_informasi_pengajuan_pembayaran(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('produksi_pengajuan', array('status'=>"disetujui"));
        
        $this->load->view('produksi_pengajuan_management', $data);
    }

    public function filter_informasi_pengajuan_pembayaran(){
        $perumahan = $_POST['perumahan'];
        $tglmin = $_POST['tgl_awal'];
        $tglmax = $_POST['tgl_akhir'];

        $data['nama'] = $this->session->userdata('nama');
        $data['kode_perumahan'] = $perumahan;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        $data['check_all'] = $this->Dashboard_model->filter_informasi_pengajuan_pembayaran($perumahan, $tglmin, $tglmax);
        
        $this->load->view('produksi_pengajuan_management', $data);
    }

    public function detail_pengajuan_pembayaran(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['check_all'] = $this->db->get_where('produksi_transaksi', array('id_pengajuan'=>$id));

        $this->load->view('produksi_pengajuan_detail', $data);
    }

    public function approve_pengajuan_pembayaran(){
        $id = $_GET['id'];

        $data = array(
            'status'=>"disetujui"
        );

        $this->db->update('produksi_pengajuan', $data, array('id_pengajuan'=>$id));

        // $data1 = array(
        //     'status'=>"disetujui",
        //     // 'id_pengajuan'=>""
        // );

        // $this->db->update('produksi_transaksi', $data1, array('id_pengajuan'=>$id));

        redirect('Dashboard/informasi_pengajuan_pembayaran');
    }

    public function tolak_pengajuan_pembayaran(){
        $id = $_GET['id'];

        $data = array(
            'status'=>"tolak"
        );

        $this->db->update('produksi_pengajuan', $data, array('id_pengajuan'=>$id));

        $data1 = array(
            'status'=>"",
            'id_pengajuan'=>""
        );

        $this->db->update('produksi_transaksi', $data1, array('id_pengajuan'=>$id));

        redirect('Dashboard/informasi_pengajuan_pembayaran');
    }

    public function pelunasan_pengajuan(){
        $id = $_GET['id'];

        $data = array(
            'status'=>"lunas"
        );
        
        $this->db->update('produksi_pengajuan', $data, array('id_pengajuan'=>$id));

        $data1 = array(
            'tgl_lunas'=>date('Y-m-d'),
            'status'=>"lunas"
        );

        $this->db->update('produksi_transaksi', $data1, array('id_pengajuan'=>$id));

        redirect('Dashboard/informasi_pengajuan_pembayaran');
    }

    public function print_pengajuan_pembayaran(){
        $id = $_GET['id'];

        $query = $this->db->get_where('produksi_pengajuan', array('id_pengajuan'=>$id));
        foreach($query->result() as $row){
            $count = $row->count_print;
        }

        $datas = array(
            'date_print'=>date('Y-m-d H:i:sa am/pm'),
            'count_print'=>$count+1
        );
        $this->db->update('produksi_pengajuan', $datas, array('id_pengajuan'=>$id));

        $data['check_all'] = $query;
        $data['prods'] = $this->db->get_where('produksi_transaksi', array('id_pengajuan'=>$id));

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-pengajuan.pdf";
        ob_end_clean();
        $this->pdf->load_view('produksi_print_pengajuan', $data);
    }

    public function pembayaran_pengajuan(){
        $id = $_GET['id'];

        $data['id'] = $id;
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('produksi_pengajuan', array('id_pengajuan'=>$id));
        $data['bank'] = $this->db->get('bank')->result();

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('produksi_bayar_pengajuan', $data);
    }

    public function add_pembayaran_pengajuan(){
        $id = $_POST['id'];

        $no_faktur = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $terima_oleh = $_POST['terima_oleh'];

        $kategori_pengeluaran = $_POST['kategori_pengeluaran'];
        $jenis_pengeluaran = $_POST['jenis_pengeluaran'];
        $keterangan = $_POST['keterangan_pengeluaran'];
        $jenis_pembayaran = "cash";
        $cara_pembayaran = $_POST['cara_pembayaran'];
        
        $tanggal_pengeluaran = $_POST['tgl_pengeluaran'];
        $nilai_pengeluaran = $_POST['nilai_pengeluaran'];
        $sisa_pembayaran = $_POST['sisa_pembayaran'];

        $bank = $_POST['bank'];
        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date('Y-m-d');

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        if($sisa_pembayaran < 0){
            echo "<script>
                    alert('Nominal tidak boleh minus/<0!');
                    window.location.href = 'pembayaran_pengajuan?id=$id';
                  </script>";
        } else {
            if($bank != ""){
                $data = array(
                    'no_pengeluaran'=>$no_faktur,
                    'kategori_pengeluaran'=>$kategori_pengeluaran,
                    'jenis_pengeluaran'=>$jenis_pengeluaran,
                    'kode_perumahan'=>$kode_perumahan,
                    'terima_oleh'=>$terima_oleh,
                    'keterangan'=>$keterangan,
                    'jenis_pembayaran'=>$jenis_pembayaran,
                    'cara_pembayaran'=>$cara_pembayaran,
                    'nominal'=>$nilai_pengeluaran,
                    'tgl_pembayaran'=>$tanggal_pengeluaran,
                    'id_bank'=>$bank,
                    'nama_bank'=>$nama_bank,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'date_created'=>$date_by,
                    // 'file_name'=>$file_name
                    // 'status'=>$status,
                );

                $this->db->insert('keuangan_pengeluaran', $data);
            } else {
                $data = array(
                    'no_pengeluaran'=>$no_faktur,
                    'kategori_pengeluaran'=>$kategori_pengeluaran,
                    'jenis_pengeluaran'=>$jenis_pengeluaran,
                    'kode_perumahan'=>$kode_perumahan,
                    'terima_oleh'=>$terima_oleh,
                    'keterangan'=>$keterangan,
                    'jenis_pembayaran'=>$jenis_pembayaran,
                    'cara_pembayaran'=>$cara_pembayaran,
                    'nominal'=>$nilai_pengeluaran,
                    'tgl_pembayaran'=>$tanggal_pengeluaran,
                    // 'id_bank'=>$bank,
                    // 'nama_bank'=>$nama_bank,
                    'id_created_by'=>$id_created_by,
                    'created_by'=>$created_by,
                    'date_created'=>$date_by,
                    // 'file_name'=>$file_name
                );

                $this->db->insert('keuangan_pengeluaran', $data);
            }

            $this->session->set_flashdata('succ_msg', "Data telah ditambahkan!");
            redirect('Dashboard/informasi_pengajuan_pembayaran');
        }
    }

    public function update_signature_staff_pengajuan(){
        $id = $_POST['id'];
        // $kode = $_POST['kode'];

        $folderPath = "./gambar/signature/pengajuan/";
  
        $image_parts = explode(";base64,", $_POST['signed3']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik = 1;
        $this->db->order_by('staff_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get('produksi_pengajuan')->result() as $row){
            $unik = $row->staff_sign;
            
            $str = $unik;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file = $folderPath .'s'. $unik . '.'.$image_type;
        
        if($image_parts[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='informasi_pengajuan_pembayaran';
                  </script>";
        } else {
            file_put_contents($file, $image_base64);
            // TES

            $data = array(
                'staff_sign'=>'s'.$unik.'.'.$image_type,
                'staff_sign_by'=>$this->session->userdata('nama'),
                'staff_sign_date'=>date('Y-m-d H:i:sa am/pm')
            );

            $this->db->update('produksi_pengajuan', $data, array('id_pengajuan'=>$id));

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses memperbarui data!");

            redirect('Dashboard/informasi_pengajuan_pembayaran');
        }
    }

    public function update_signature_manager_pengajuan(){
        $id = $_POST['id'];
        // $kode = $_POST['kode'];

        $folderPath = "./gambar/signature/pengajuan/";
  
        $image_parts = explode(";base64,", $_POST['signed2']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik = 1;
        $this->db->order_by('manager_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get('produksi_pengajuan')->result() as $row){
            $unik = $row->manager_sign;
            
            $str = $unik;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file = $folderPath .'m'. $unik . '.'.$image_type;
        
        if($image_parts[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='informasi_pengajuan_pembayaran';
                  </script>";
        } else {
            file_put_contents($file, $image_base64);
            // TES

            $data = array(
                'manager_sign'=>'m'.$unik.'.'.$image_type,
                'manager_sign_by'=>$this->session->userdata('nama'),
                'manager_sign_date'=>date('Y-m-d H:i:sa am/pm')
            );

            $this->db->update('produksi_pengajuan', $data, array('id_pengajuan'=>$id));

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses memperbarui data!");

            redirect('Dashboard/informasi_pengajuan_pembayaran');
        }
    }

    public function update_signature_owner_pengajuan(){
        $id = $_POST['id'];
        // $kode = $_POST['kode'];

        $folderPath = "./gambar/signature/pengajuan/";
  
        $image_parts = explode(";base64,", $_POST['signed1']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik = 1;
        $this->db->order_by('owner_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get('produksi_pengajuan')->result() as $row){
            $unik = $row->owner_sign;
            
            $str = $unik;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file = $folderPath .'o'. $unik . '.'.$image_type;
        
        if($image_parts[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='informasi_pengajuan_pembayaran';
                  </script>";
        } else {
            file_put_contents($file, $image_base64);
            // TES

            $data = array(
                'owner_sign'=>'o'.$unik.'.'.$image_type,
                'owner_sign_by'=>$this->session->userdata('nama'),
                'owner_sign_date'=>date('Y-m-d H:i:sa am/pm')
            );

            $this->db->update('produksi_pengajuan', $data, array('id_pengajuan'=>$id));

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses memperbarui data!");

            redirect('Dashboard/informasi_pengajuan_pembayaran');
        }
    }

    public function kontrol_pembayaran_pembelian_perumahan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('produksi_kontrol_pembayaran_perumahan', $data);
    }

    public function kontrol_pembayaran_pembelian(){
        $id = $_GET['id'];
        $tk_bangunan = $_GET['tk'];
        $bulan = $_GET['bln'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        // $this->db->order_by('tgl_pesan', 'ASC');
        // $this->db->group_by('')
        $data['check_all'] = $this->Dashboard_model->filter_kontrol_pembayaran_pembelian($bulan, $tk_bangunan, $id);

        if($bulan == ""){
            $data['tgl'] = "";
        } else {
            $data['tgl'] = $bulan;
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['id'] = $id;
        $data['tk_bangunan'] = $tk_bangunan;
        // $data['bulan'] = $bulan;

        $this->load->view('produksi_kontrol_pembayaran', $data);
    }

    public function filter_kontrol_pembayaran_pembelian(){
        $bulan = $_POST['bulan'];
        $tk_bangunan = $_POST['tk_bangunan'];
        $id = $_POST['id'];

        $data['nama'] = $this->session->userdata('nama');
        
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;
        $data['tgl'] = $bulan;
        $data['tk_bangunan'] = $tk_bangunan;

        $data['check_all'] = $this->Dashboard_model->filter_kontrol_pembayaran_pembelian($bulan, $tk_bangunan, $id);

        $this->load->view('produksi_kontrol_pembayaran', $data);
    }

    public function edit_transaksi_perfaktur(){
        $id_prod = $_POST['id_prod'];
        $notapink = $_POST['notapink'];
        $notaputih = $_POST['notaputih'];
        $notapelunasan = $_POST['notapelunasan'];
        $tglpengajuan = $_POST['tglpengajuan'];
        $tgllunas = $_POST['tgllunas'];
        $keterangan = $_POST['keterangan'];

        $tk_bangunan = $_POST['tk_bangunan'];
        $id = $_POST['id'];
        $bulan = $_POST['bulan'];

        for($i = 0; $i <= count($id_prod); $i++){
            $data = array(
                'nota_pink'=>$notapink[$i],
                'nota_putih'=>$notaputih[$i],
                'nota_pelunasan'=>$notapelunasan[$i],
                'tgl_pengajuan'=>$tglpengajuan[$i],
                'tgl_lunas'=>$tgllunas[$i],
                'keterangan'=>$keterangan[$i]
            );
    
            $this->db->update('produksi_transaksi', $data, array('id_prod'=>$id_prod[$i]));
        }

        redirect('Dashboard/kontrol_pembayaran_pembelian?id='.$id.'&tk='.$tk_bangunan.'&bln='.$bulan);
    }
    //END OF PRODUKSI
    
    //START OF LAPORAN
    public function view_jurnal_umum(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('laporan_jurnal_umum_perumahan', $data);
    }

    public function view_jurnal_umum_rekonsiliasi(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perusahaan')->result();

        $this->load->view('laporan_jurnal_umum_perumahan_rekonsiliasi', $data);
    }

    public function jurnal_umum(){
        $id=$_GET['id'];
        $data['nama'] = $this->session->userdata('nama');

        // $query = $this->Dashboard_model->get_transaksi_jurnal();
        // print_r($query->result());
        // exit;
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['kode_perumahan'] = $row->kode_perumahan;
        }

        $start = "";
        $end = "";
        $data['end'] = date('Y-m-d');

        $data['debet'] = 0;
        $data['kredit'] = 0;
        $data['id'] = $id;

        $data['query'] = $this->Dashboard_model->total_nominal_debet_jurnal_umum($start, $end);
        foreach($data['query'] as $row){
            $data['debet'] = $data['debet'] + $row->nominal;
        }
        // print_r($data['debet']);
        // exit;
        $data['query2'] = $this->Dashboard_model->total_nominal_kredit_jurnal_umum($start, $end);
        foreach($data['query2'] as $row1){
            $data['kredit'] = $data['kredit'] + $row1->nominal;
        }

        $data['check_all'] = $this->Dashboard_model->get_jurnal_umum($start, $end, $id);
        // print_r($data['check_all']->result());
        // exit;
        // echo $data['debet'];
        // exit;
        // print_r($data['kredit']);
        // exit;

        $this->load->view('laporan_jurnal_umum', $data);
    }

    public function jurnal_umum_rekonsiliasi(){
        $id=$_GET['id'];
        $data['nama'] = $this->session->userdata('nama');

        // $query = $this->Dashboard_model->get_transaksi_jurnal();
        // print_r($query->result());
        // exit;
        foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['kode_perumahan'] = $row->kode_perumahan;

            $data['nama_perusahaan'] = $row->nama_perusahaan;
            $data['kode_perusahaan'] = $row->kode_perusahaan;
        }

        $start = "";
        $end = "";
        $data['end'] = date('Y-m-d');

        $data['debet'] = 0;
        $data['kredit'] = 0;
        $data['id'] = $id;
        $data['start'] = $start;

        $data['query'] = $this->Dashboard_model->total_nominal_debet_jurnal_umum($start, $end);
        foreach($data['query'] as $row){
            $data['debet'] = $data['debet'] + $row->nominal;
        }
        // print_r($data['debet']);
        // exit;
        $data['query2'] = $this->Dashboard_model->total_nominal_kredit_jurnal_umum($start, $end);
        foreach($data['query2'] as $row1){
            $data['kredit'] = $data['kredit'] + $row1->nominal;
        }

        // $data['check_all'] = $this->Dashboard_model->get_jurnal_umum($start, $end, $data['kode_perumahan']);

        $this->load->view('laporan_jurnal_umum_rekonsiliasi', $data);
    }

    public function filter_jurnal_umum(){
        $id = $_POST['id'];
        $start = $_POST['tgl_awal'];
        $end = $_POST['tgl_akhir'];

        $data['nama'] = $this->session->userdata('nama');

        if($start > $end){
            echo "<script>
                    alert('Tgl min tidak bisa lebih besar dari Tgl Max!');
                    window.location.href = 'jurnal_umum?id=$id';
                  </script>";
        } else {
            foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
                $data['kode_perumahan'] = $row->kode_perumahan;
            }

            // $query = $this->Dashboard_model->get_transaksi_jurnal();
            // print_r($query->result());
            // exit;

            $data['check_all'] = $this->Dashboard_model->get_jurnal_umum($start, $end, $id);
            // print_r($data['check_all']->result());
            // exit;
            $data['tgl'] = date('Y-m');

            $data['id'] = $id;
            $data['start'] = $start;
            $data['end'] = $end;

            $this->load->view('laporan_jurnal_umum', $data);
        }
    }

    public function filter_jurnal_umum_rekonsiliasi(){
        $id = $_POST['id'];
        $start = $_POST['tgl_awal'];
        $end = $_POST['tgl_akhir'];

        $data['nama'] = $this->session->userdata('nama');

        if($start > $end){
            echo "<script>
                    alert('Tgl min tidak bisa lebih besar dari Tgl Max!');
                    window.location.href = 'jurnal_umum_rekonsiliasi?id=$id';
                  </script>";
        } else {
            foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$id))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
                $data['kode_perumahan'] = $row->kode_perumahan;
    
                $data['nama_perusahaan'] = $row->nama_perusahaan;
                $data['kode_perusahaan'] = $row->kode_perusahaan;
            }

            // $query = $this->Dashboard_model->get_transaksi_jurnal();
            // print_r($query->result());
            // exit;

            // $data['check_all'] = $this->Dashboard_model->get_jurnal_umum($start, $end, $data['kode_perumahan']);
            // print_r($data['check_all']->result());
            // exit;
            $data['tgl'] = date('Y-m');

            $data['id'] = $id;
            $data['start'] = $start;
            $data['end'] = $end;

            $this->load->view('laporan_jurnal_umum_rekonsiliasi', $data);
        }
    }

    public function view_buku_besar(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('laporan_buku_besar_perumahan', $data);
    }

    public function view_buku_besar_rekonsiliasi(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perusahaan')->result();

        $this->load->view('laporan_buku_besar_perumahan_rekonsiliasi', $data);
    }
    
    public function buku_besar(){
        $id=$_GET['id'];
        
        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['kode_perumahan'] = $row->kode_perumahan;
        }

        $data['start'] = "";
        $data['end'] = "";

        $data['debet'] = 0;
        $data['kredit'] = 0;
        $data['id'] = $id;

        $data['check_all'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$id));
        
        $this->load->view('laporan_buku_besar', $data);
    }
    
    public function buku_besar_rekonsiliasi(){
        $id=$_GET['id'];
        
        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['kode_perumahan'] = $row->kode_perumahan;

            $data['nama_perusahaan'] = $row->nama_perusahaan;
            $data['kode_perusahaan'] = $row->kode_perusahaan;

            // $data['check_all'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$data['kode_perumahan']));
        }

        $data['start'] = "";
        $data['end'] = "";

        $data['debet'] = 0;
        $data['kredit'] = 0;
        $data['id'] = $id;

        // $data['check_all'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$data['kode_perumahan']));
        
        $this->load->view('laporan_buku_besar_rekonsiliasi', $data);
    }

    public function get_buku_besar(){
        $category = $_POST["country"];
        $kode_perumahan = $_POST["kodePerumahan"];
        // $tahun = $_POST['tahun'];
        $start = $_POST['start'];
        $end = $_POST['end'];

        // echo $category;

        // Define country and city array
        $query = $this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$category))->result();
        foreach($query as $row){
            $id_akun = $row->id_akun;
            $pos = $row->pos;
        }

        // Display city dropdown based on country name
        if($category !== 'Select'){
            // echo "<label>City:</label>";
            // echo "<select>";
            // echo "<option value='' disabled selected>-Pilih-</option>";
            // foreach($query as $value){
            //     echo "<option value=".$value->no_akun.">".$value->no_akun."-".$value->nama_akun."</option>";
            // }
            // echo "</select>";
            $total = 0;

            if($start != ""){
                $this->db->order_by('date_created', "ASC");
                // $query1 = $this->db->get_where('akuntansi_pos', array('id_akun'=>$category, 'kode_perumahan'=>$kode_perumahan));
                $query1 = $this->Dashboard_model->get_buku_besar($category, $kode_perumahan, "", $start);
                foreach($query1->result() as $row1){
                    // echo "<tr>";
                    // echo "<td>".date('d F Y', strtotime($row1->date_created))."</td>";
                    if($row1->jenis_keuangan == "penerimaan"){
                        foreach($this->db->get_where('keuangan_akuntansi', array('id_keuangan'=>$row1->id_keuangan, 'kode_perumahan'=>$kode_perumahan))->result() as $penerimaan){
                            // echo "<td>".$penerimaan->keterangan."</td>";
                        }
                    } else {
                        foreach($this->db->get_where('keuangan_pengeluaran', array('id_pengeluaran'=>$row1->id_keuangan, 'kode_perumahan'=>$kode_perumahan))->result() as $pengeluaran){
                            // echo "<td>".$pengeluaran->keterangan."</td>";
                        }
                    }

                    if($row1->pos_akun=="debet"){
                        // echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                        if($pos=="Debet"){
                            $total = $total + $row1->nominal;
                            // echo "<td>-</td>";
                            // echo "<td>Rp. ".number_format($total)."</td>";
                        }
                        else if($pos=="Kredit"){
                            $total = $total - $row1->nominal;
                            // echo "<td>-</td>";
                            // echo "<td>Rp. ".number_format($total)."</td>";
                        } 
                    } else {
                        // echo "<td>-</td>";
                    } 

                    if($row1->pos_akun=="kredit"){
                        // echo "<td>-</td>";  
                        // echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                        if($pos=="Debet"){
                            $total = $total - $row1->nominal;
                            // echo "<td>Rp. ".number_format($total)."</td>";
                        }
                        else if($pos=="Kredit"){
                            $total = $total + $row1->nominal;
                            // echo "<td>Rp. ".number_format($total)."</td>";
                        } 
                    } else {
                        // echo "<td>-</td>";   
                    }
                    // echo "</tr>";
                }

                foreach($this->Dashboard_model->get_buku_besar_jurnal($category, $kode_perumahan, "", $start)->result() as $jrnl){
                    foreach($this->db->get_where('akuntansi_jurnal', array('id_jurnal'=>$jrnl->id_keuangan))->result() as $jrnl1){
                        // echo "<tr>";
                        // echo "<td>".date('d F Y', strtotime($jrnl1->tgl_jurnal))."</td>";
                        // echo "<td>".ucfirst($jrnl1->kategori)." - ".$jrnl1->keterangan."</td>";

                        if($jrnl->pos_akun=="debet"){
                            // echo "<td>Rp. ".number_format($jrnl->nominal)."</td>";
                            if($pos=="Debet"){
                                $total = $total + $jrnl->nominal;
                                // echo "<td>-</td>";
                                // echo "<td>Rp. ".number_format($total)."</td>";
                            }
                            else if($pos=="Kredit"){
                                $total = $total - $jrnl->nominal;
                                // echo "<td>-</td>";
                                // echo "<td>Rp. ".number_format($total)."</td>";
                            } 
                        } else {
                            // echo "<td>-</td>";
                        } 
        
                        if($jrnl->pos_akun=="kredit"){
                            // echo "<td>-</td>";  
                            // echo "<td>Rp. ".number_format($jrnl->nominal)."</td>";
                            if($pos=="Debet"){
                                $total = $total - $jrnl->nominal;
                                // echo "<td>Rp. ".number_format($total)."</td>";
                            }
                            else if($pos=="Kredit"){
                                $total = $total + $jrnl->nominal;
                                // echo "<td>Rp. ".number_format($total)."</td>";
                            } 
                        } else {
                            // echo "<td>-</td>";   
                        }

                        // echo "</tr>";
                    }
                }
            }

            $test = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$category, 'kode_perumahan'=>$kode_perumahan));
            // echo "<script>alert($test);</script>";
            // print_r($test->result());
            foreach($test->result() as $tests){
                // if()
                echo "<tr style='background-color: lightyellow'>";
                echo "<td>".date('d F Y', strtotime($tests->date_created))."</td>";
                echo "<td>SALDO AWAL</td>";
                // echo "<td>".$pos."</td>;

                $total = $total + $tests->nominal;

                if($pos=="Debet"){
                    echo "<td>Rp. ".number_format($total)."</td>";
                } else {
                    echo "<td>-</td>";
                } 
                if($pos=="Kredit"){
                    echo "<td>Rp. ".number_format($total)."</td>";
                } else {
                    echo "<td>-</td>";   
                }
                echo "<td>Rp. ".number_format($total);
                
                echo "</td>";
                echo "</tr>";
            }

            // $saldoLanjutan = $this->Dashboard_model->saldoLanjutan($tahun, $kode_perumahan);
            // print_r($saldoLanjutan->result());
            
            echo "<input type='hidden' value='".$total."' id='totalAwal'>";

            $this->db->order_by('date_created', "ASC");
            // $query1 = $this->db->get_where('akuntansi_pos', array('id_akun'=>$category, 'kode_perumahan'=>$kode_perumahan));
            $query1 = $this->Dashboard_model->get_buku_besar($category, $kode_perumahan, $start, $end);
            foreach($query1->result() as $row1){
                echo "<tr>";
                echo "<td>".date('d F Y', strtotime($row1->date_created))."</td>";
                if($row1->jenis_keuangan == "penerimaan"){
                    foreach($this->db->get_where('keuangan_akuntansi', array('id_keuangan'=>$row1->id_keuangan, 'kode_perumahan'=>$kode_perumahan))->result() as $penerimaan){
                        echo "<td>".$penerimaan->keterangan."</td>";
                    }
                } else {
                    foreach($this->db->get_where('keuangan_pengeluaran', array('id_pengeluaran'=>$row1->id_keuangan, 'kode_perumahan'=>$kode_perumahan))->result() as $pengeluaran){
                        echo "<td>".$pengeluaran->keterangan."</td>";
                    }
                }

                if($row1->pos_akun=="debet"){
                    echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                    if($pos=="Debet"){
                        $total = $total + $row1->nominal;
                        echo "<td>-</td>";
                        echo "<td>Rp. ".number_format($total)."</td>";
                    }
                    else if($pos=="Kredit"){
                        $total = $total - $row1->nominal;
                        echo "<td>-</td>";
                        echo "<td>Rp. ".number_format($total)."</td>";
                    } 
                } else {
                    // echo "<td>-</td>";
                } 

                if($row1->pos_akun=="kredit"){
                    echo "<td>-</td>";  
                    echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                    if($pos=="Debet"){
                        $total = $total - $row1->nominal;
                        echo "<td>Rp. ".number_format($total)."</td>";
                    }
                    else if($pos=="Kredit"){
                        $total = $total + $row1->nominal;
                        echo "<td>Rp. ".number_format($total)."</td>";
                    } 
                } else {
                    // echo "<td>-</td>";   
                }

                // if($pos=="debet"){
                //     $total = $total + $row1->nominal;
                //     echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                // }
                // else if($pos=="kredit"){
                //     echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                // } 
                // echo "<td>"."</td>";
                echo "</tr>";
            }

            foreach($this->Dashboard_model->get_buku_besar_jurnal($category, $kode_perumahan, $start, $end)->result() as $jrnl){
                foreach($this->db->get_where('akuntansi_jurnal', array('id_jurnal'=>$jrnl->id_keuangan))->result() as $jrnl1){
                    echo "<tr>";
                    echo "<td>".date('d F Y', strtotime($jrnl1->tgl_jurnal))."</td>";
                    echo "<td>".ucfirst($jrnl1->kategori)." - ".$jrnl1->keterangan."</td>";

                    if($jrnl->pos_akun=="debet"){
                        echo "<td>Rp. ".number_format($jrnl->nominal)."</td>";
                        if($pos=="Debet"){
                            $total = $total + $jrnl->nominal;
                            echo "<td>-</td>";
                            echo "<td>Rp. ".number_format($total)."</td>";
                        }
                        else if($pos=="Kredit"){
                            $total = $total - $jrnl->nominal;
                            echo "<td>-</td>";
                            echo "<td>Rp. ".number_format($total)."</td>";
                        } 
                    } else {
                        // echo "<td>-</td>";
                    } 
    
                    if($jrnl->pos_akun=="kredit"){
                        echo "<td>-</td>";  
                        echo "<td>Rp. ".number_format($jrnl->nominal)."</td>";
                        if($pos=="Debet"){
                            $total = $total - $jrnl->nominal;
                            echo "<td>Rp. ".number_format($total)."</td>";
                        }
                        else if($pos=="Kredit"){
                            $total = $total + $jrnl->nominal;
                            echo "<td>Rp. ".number_format($total)."</td>";
                        } 
                    } else {
                        // echo "<td>-</td>";   
                    }

                    echo "</tr>";
                }
            }
            echo "<input type='hidden' value='".$total."' id='totalAkhir'>";

            echo "<script type='text/javascript'>
                    function numberWithCommas(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    }

                    var totalAwal = $('#totalAwal').val();
                    var totalAkhir = $('#totalAkhir').val();
                
                    $('#saldoAwal').val('Rp. '+numberWithCommas(totalAwal));
                    $('#saldoAkhir').val('Rp. '+numberWithCommas(totalAkhir));
                  </script>";
        } 
    }

    public function get_buku_besar_rekonsiliasi(){
        $category = $_POST["country"];
        $kode_perusahaan = $_POST["kodePerusahaan"];
        // $tahun = $_POST['tahun'];
        $start = $_POST['start'];
        $end = $_POST['end'];

        // echo $category;

        // Define country and city array
        $query = $this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$category))->result();
        foreach($query as $row){
            $id_akun = $row->id_akun;
            $pos = $row->pos;
        }

        // Display city dropdown based on country name
        if($category !== 'Select'){
            // echo "<label>City:</label>";
            // echo "<select>";
            // echo "<option value='' disabled selected>-Pilih-</option>";
            // foreach($query as $value){
            //     echo "<option value=".$value->no_akun.">".$value->no_akun."-".$value->nama_akun."</option>";
            // }
            // echo "</select>";
            $total = 0;

            $qus = $this->db->get_where('perumahan', array('kode_perusahaan'=>$kode_perusahaan));
            foreach($qus->result() as $res){
                $totalA = 0;
                if($start != ""){
                    $this->db->order_by('date_created', "ASC");
                    // $query1 = $this->db->get_where('akuntansi_pos', array('id_akun'=>$category, 'kode_perumahan'=>$kode_perumahan));
                    $query1 = $this->Dashboard_model->get_buku_besar($category, $res->kode_perumahan, "", $start);
                    foreach($query1->result() as $row1){
                        // echo "<tr>";
                        // echo "<td>".date('d F Y', strtotime($row1->date_created))."</td>";
                        if($row1->jenis_keuangan == "penerimaan"){
                            foreach($this->db->get_where('keuangan_akuntansi', array('id_keuangan'=>$row1->id_keuangan, 'kode_perumahan'=>$res->kode_perumahan))->result() as $penerimaan){
                                // echo "<td>".$penerimaan->keterangan."</td>";
                            }
                        } else {
                            foreach($this->db->get_where('keuangan_pengeluaran', array('id_pengeluaran'=>$row1->id_keuangan, 'kode_perumahan'=>$res->kode_perumahan))->result() as $pengeluaran){
                                // echo "<td>".$pengeluaran->keterangan."</td>";
                            }
                        }
    
                        if($row1->pos_akun=="debet"){
                            // echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                            if($pos=="Debet"){
                                $total = $total + $row1->nominal;
                                $totalA = $totalA + $row1->nominal;
                                // echo "<td>-</td>";
                                // echo "<td>Rp. ".number_format($total)."</td>";
                            }
                            else if($pos=="Kredit"){
                                $total = $total - $row1->nominal;
                                $totalA = $totalA - $row1->nominal;
                                // echo "<td>-</td>";
                                // echo "<td>Rp. ".number_format($total)."</td>";
                            } 
                        } else {
                            // echo "<td>-</td>";
                        } 
    
                        if($row1->pos_akun=="kredit"){
                            // echo "<td>-</td>";  
                            // echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                            if($pos=="Debet"){
                                $total = $total - $row1->nominal;
                                $totalA = $totalA - $row1->nominal;
                                // echo "<td>Rp. ".number_format($total)."</td>";
                            }
                            else if($pos=="Kredit"){
                                $total = $total + $row1->nominal;
                                $totalA = $totalA + $row1->nominal;
                                // echo "<td>Rp. ".number_format($total)."</td>";
                            } 
                        } else {
                            // echo "<td>-</td>";   
                        }
    
                        // if($pos=="debet"){
                        //     $total = $total + $row1->nominal;
                        //     echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                        // }
                        // else if($pos=="kredit"){
                        //     echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                        // } 
                        // echo "<td>"."</td>";
                        // echo "</tr>";
                    }
    
                    foreach($this->Dashboard_model->get_buku_besar_jurnal($category, $res->kode_perumahan, "", $start)->result() as $jrnl){
                        foreach($this->db->get_where('akuntansi_jurnal', array('id_jurnal'=>$jrnl->id_keuangan))->result() as $jrnl1){
                            // echo "<tr>";
                            // echo "<td>".date('d F Y', strtotime($jrnl1->tgl_jurnal))."</td>";
                            // echo "<td>".ucfirst($jrnl1->kategori)." - ".$jrnl1->keterangan."</td>";
    
                            if($jrnl->pos_akun=="debet"){
                                // echo "<td>Rp. ".number_format($jrnl->nominal)."</td>";
                                if($pos=="Debet"){
                                    $total = $total + $jrnl->nominal;
                                    $totalA = $totalA + $jrnl->nominal;
                                    // echo "<td>-</td>";
                                    // echo "<td>Rp. ".number_format($total)."</td>";
                                }
                                else if($pos=="Kredit"){
                                    $total = $total - $jrnl->nominal;
                                    $totalA = $totalA - $jrnl->nominal;
                                    // echo "<td>-</td>";
                                    // echo "<td>Rp. ".number_format($total)."</td>";
                                } 
                            } else {
                                // echo "<td>-</td>";
                            } 
            
                            if($jrnl->pos_akun=="kredit"){
                                // echo "<td>-</td>";  
                                // echo "<td>Rp. ".number_format($jrnl->nominal)."</td>";
                                if($pos=="Debet"){
                                    $total = $total - $jrnl->nominal;
                                    $totalA = $totalA - $jrnl->nominal;
                                    // echo "<td>Rp. ".number_format($total)."</td>";
                                }
                                else if($pos=="Kredit"){
                                    $total = $total + $jrnl->nominal;
                                    $totalA = $totalA + $jrnl->nominal;
                                    // echo "<td>Rp. ".number_format($total)."</td>";
                                } 
                            } else {
                                // echo "<td>-</td>";   
                            }
    
                            // echo "</tr>";
                        }
                    }
                }

                $test = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$category, 'kode_perumahan'=>$res->kode_perumahan));
                // echo "<script>alert($test);</script>";
                // print_r($test->result());
                foreach($test->result() as $tests){
                    echo "<tr style='background-color: lightyellow'>";
                    echo "<td>".date('d F Y', strtotime($tests->date_created))."</td>";
                    echo "<td>SALDO AWAL ($res->nama_perumahan)</td>";
                    // echo "<td>".$pos."</td>;

                    $total = $total + $tests->nominal;
                    $totalA = $totalA + $tests->nominal;
                    if($pos=="Debet"){
                        echo "<td>Rp. ".number_format($totalA)."</td>";
                    } else {
                        echo "<td>-</td>";
                    } 
                    if($pos=="Kredit"){
                        echo "<td>Rp. ".number_format($totalA)."</td>";
                    } else {
                        echo "<td>-</td>";   
                    }
                    echo "<td>Rp. ".number_format($total);
                    
                    echo "</td>";
                    echo "</tr>";
                }

                // $saldoLanjutan = $this->Dashboard_model->saldoLanjutan($tahun, $kode_perumahan);
                // print_r($saldoLanjutan->result());
            }
                
            echo "<input type='hidden' value='".$total."' id='totalAwal'>";

            foreach($qus->result() as $res1){

                $this->db->order_by('date_created', "ASC");
                // $query1 = $this->db->get_where('akuntansi_pos', array('id_akun'=>$category, 'kode_perumahan'=>$kode_perumahan));
                $query1 = $this->Dashboard_model->get_buku_besar($category, $res1->kode_perumahan, $start, $end);
                foreach($query1->result() as $row1){
                    echo "<tr>";
                    echo "<td>".date('d F Y', strtotime($row1->date_created))."</td>";
                    if($row1->jenis_keuangan == "penerimaan"){
                        foreach($this->db->get_where('keuangan_akuntansi', array('id_keuangan'=>$row1->id_keuangan, 'kode_perumahan'=>$res1->kode_perumahan))->result() as $penerimaan){
                            echo "<td>".$penerimaan->keterangan."</td>";
                        }
                    } else {
                        foreach($this->db->get_where('keuangan_pengeluaran', array('id_pengeluaran'=>$row1->id_keuangan, 'kode_perumahan'=>$res1->kode_perumahan))->result() as $pengeluaran){
                            echo "<td>".$pengeluaran->keterangan."</td>";
                        }
                    }

                    if($row1->pos_akun=="debet"){
                        echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                        if($pos=="Debet"){
                            $total = $total + $row1->nominal;
                            echo "<td>-</td>";
                            echo "<td>Rp. ".number_format($total)."</td>";
                        }
                        else if($pos=="Kredit"){
                            $total = $total - $row1->nominal;
                            echo "<td>-</td>";
                            echo "<td>Rp. ".number_format($total)."</td>";
                        } 
                    } else {
                        // echo "<td>-</td>";
                    } 

                    if($row1->pos_akun=="kredit"){
                        echo "<td>-</td>";  
                        echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                        if($pos=="Debet"){
                            $total = $total - $row1->nominal;
                            echo "<td>Rp. ".number_format($total)."</td>";
                        }
                        else if($pos=="Kredit"){
                            $total = $total + $row1->nominal;
                            echo "<td>Rp. ".number_format($total)."</td>";
                        } 
                    } else {
                        // echo "<td>-</td>";   
                    }

                    // if($pos=="debet"){
                    //     $total = $total + $row1->nominal;
                    //     echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                    // }
                    // else if($pos=="kredit"){
                    //     echo "<td>Rp. ".number_format($row1->nominal)."</td>";
                    // } 
                    // echo "<td>"."</td>";
                    echo "</tr>";
                }

                foreach($this->Dashboard_model->get_buku_besar_jurnal($category, $res1->kode_perumahan, $start, $end)->result() as $jrnl){
                    foreach($this->db->get_where('akuntansi_jurnal', array('id_jurnal'=>$jrnl->id_keuangan))->result() as $jrnl1){
                        echo "<tr>";
                        echo "<td>".date('d F Y', strtotime($jrnl1->tgl_jurnal))."</td>";
                        echo "<td>".ucfirst($jrnl1->kategori)." - ".$jrnl1->keterangan."</td>";

                        if($jrnl->pos_akun=="debet"){
                            echo "<td>Rp. ".number_format($jrnl->nominal)."</td>";
                            if($pos=="Debet"){
                                $total = $total + $jrnl->nominal;
                                echo "<td>-</td>";
                                echo "<td>Rp. ".number_format($total)."</td>";
                            }
                            else if($pos=="Kredit"){
                                $total = $total - $jrnl->nominal;
                                echo "<td>-</td>";
                                echo "<td>Rp. ".number_format($total)."</td>";
                            } 
                        } else {
                            // echo "<td>-</td>";
                        } 
        
                        if($jrnl->pos_akun=="kredit"){
                            echo "<td>-</td>";  
                            echo "<td>Rp. ".number_format($jrnl->nominal)."</td>";
                            if($pos=="Debet"){
                                $total = $total - $jrnl->nominal;
                                echo "<td>Rp. ".number_format($total)."</td>";
                            }
                            else if($pos=="Kredit"){
                                $total = $total + $jrnl->nominal;
                                echo "<td>Rp. ".number_format($total)."</td>";
                            } 
                        } else {
                            // echo "<td>-</td>";   
                        }

                        echo "</tr>";
                    }
                }

                echo "<script type='text/javascript'>
                        function numberWithCommas(x) {
                            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        }

                        var totalAwal = $('#totalAwal').val();
                        var totalAkhir = $('#totalAkhir').val();
                    
                        $('#saldoAwal').val('Rp. '+numberWithCommas(totalAwal));
                        $('#saldoAkhir').val('Rp. '+numberWithCommas(totalAkhir));
                    </script>";
            }
            echo "<input type='hidden' value='".$total."' id='totalAkhir'>";
        } 
    }

    public function filter_laporan_buku_besar(){
        $id=$_POST['id'];
        // $tahun = $_POST['tahun'];
        $tglmin = $_POST['tgl_awal'];
        $tglmax = $_POST['tgl_akhir'];
        $kode_perumahan = $_POST['kode_perumahan'];

        $data['nama'] = $this->session->userdata('nama');

        if($tglmax < $tglmin){
            echo "<script>
                    alert('Tanggal Max tidak bisa lebih besar dari Tanggal Min!');
                    window.location.href = 'buku_besar?id=$kode_perumahan';
                  </script>";
        } else {
            foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
                $data['kode_perumahan'] = $row->kode_perumahan;
            }
    
            // $data['tgl'] = date('Y-12-31');
            $data['start'] = $tglmin;
            $data['end'] = $tglmax;
            $data['tgl_awal'] = $tglmin;
            $data['tgl_akhir'] = $tglmax;
            $data['kode_perumahan'] = $id;
            // $data['debet'] = 0;
            // $data['kredit'] = 0;
            $data['id'] = $id;
    
            $data['check_all'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$id));
    
            // print_r($this->Dashboard_model->saldoLanjutan($tahun, $id)->result());
            // exit;
    
            $this->load->view('laporan_buku_besar', $data);
        }
    }

    public function filter_laporan_buku_besar_rekonsiliasi(){
        $id=$_POST['id'];
        // $tahun = $_POST['tahun'];
        $tglmin = $_POST['tgl_awal'];
        $tglmax = $_POST['tgl_akhir'];
        $kode_perumahan = $_POST['kode_perumahan'];

        $data['nama'] = $this->session->userdata('nama');

        if($tglmax < $tglmin){
            echo "<script>
                    alert('Tanggal Max tidak bisa lebih besar dari Tanggal Min!');
                    window.location.href = 'buku_besar_rekonsiliasi?id=$kode_perumahan';
                  </script>";
        } else {
            foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$id))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
                $data['kode_perumahan'] = $row->kode_perumahan;

                $data['nama_perusahaan'] = $row->nama_perusahaan;
                $data['kode_perusahaan'] = $row->kode_perusahaan;

                // $data['check_all'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$data['kode_perumahan']));
            }

            // $data['tgl'] = date('Y-12-31');
            $data['start'] = $tglmin;
            $data['end'] = $tglmax;
            // $data['debet'] = 0;
            // $data['kredit'] = 0;
            $data['id'] = $id;
            $data['kode_perusahaan'] = $id;

            // $data['check_all'] = $this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$id));

            // print_r($this->Dashboard_model->saldoLanjutan($tahun, $id)->result());
            // exit;

            $this->load->view('laporan_buku_besar_rekonsiliasi', $data);
        }
    }

    public function laporan_keuangan_transaksi(){
        $data['nama'] = $this->session->userdata('nama');
        // $data['kode'] = "";
        // $data['tglmin'] = "";
        // $data['tglmax'] = "";
        $this->db->order_by('tanggal_bayar', 'desc');
        $data['check_all'] = $this->db->get('keuangan_kas_kpr');

        $this->load->view('laporan_keuangan_transaksi', $data);
    }

    public function filter_laporan_keuangan_transaksi(){
        $kode = $_POST['perumahan'];
        $tglmin = $_POST['tgl_awal'];
        $tglmax = $_POST['tgl_akhir'];

        $data['nama'] = $this->session->userdata('nama');

        $data['kode'] = $kode;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        if($kode == "" && $tglmin == "" & $tglmax == ""){
            $data['check_all'] = $this->db->get('keuangan_kas_kpr');
        }else {
            $data['check_all'] = $this->Dashboard_model->filter_laporan_keuangan_transaksi( $tglmin, $tglmax, $kode );
        }

        $this->load->view('laporan_keuangan_transaksi', $data);
    }

    public function laporan_rekap_kas(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('ppjb');

        $this->load->view('laporan_rekap_kas', $data);
    }

    public function filter_laporan_rekap_kas(){
        $kode = $_POST['perumahan'];
        $tglmin = $_POST['tgl_awal'];
        $tglmax = $_POST['tgl_akhir'];

        $data['nama'] = $this->session->userdata('nama');

        $data['kode'] = $kode;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        if($kode == "" || strtotime($tglmin) == "" || strtotime($tglmax) == ""){
            $data['check_all'] = $this->Dashboard_model->filter_laporan_rekap_kas( $tglmin, $tglmax, $kode );
        }else {
            $data['check_all'] = $this->Dashboard_model->filter_laporan_rekap_kas( $tglmin, $tglmax, $kode );
        }

        $this->load->view('laporan_rekap_kas', $data);
    }

    public function get_rekap_kas(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];

        if(isset($_POST['id'])){

            // echo $id;
            echo '<link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
                  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">';

            $test = $this->db->get_where('ppjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$kode));
                
            $no=1; 
            echo "<table id='example3' class='table table-bordered' style='white-space: nowrap;'>";
            echo "<thead>
                    <tr>
                        <th>No</th>
                        <th>Jadwal Bayar</th>
                        <th>Nama Konsumen</th>
                        <th>Kavling</th>
                        <th>Tahap</th>
                        <th>PPJB</th>
                        <th>Tgl Bayar</th>
                        <th>Jmlh Tanggungan</th>
                        <th>Jmlh Diterima</th>
                        <th>Sisa</th>
                        <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>";
            foreach($test->result() as $rows){
                $q = $this->db->get_where('keuangan_kas_kpr', array('id_ppjb'=>$rows->id_psjb));
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$rows->tanggal_dana."</td>";
                    foreach($this->db->get_where('ppjb', array('no_psjb'=>$rows->no_psjb, 'kode_perumahan'=>$rows->kode_perumahan))->result() as $ppjb){
                        echo "<td>".$ppjb->nama_pemesan."</td>";
                        echo "<td>".$ppjb->no_kavling;
                        foreach($this->db->get_where('rumah', array('no_psjb'=>$ppjb->psjb, 'kode_perumahan'=>$ppjb->kode_perumahan, 'tipe_produk'=>$ppjb->tipe_produk))->result() as $rmh){
                            echo ", ".$rmh->kode_rumah;
                        }
                        echo "</td>";
                    }
                    echo "<td>".$rows->cara_bayar."</td>";
                    echo "<td>1-".$rows->no_ppjb."</td>";
                    echo "<td>".$rows->tanggal_dana."</td>";
                    echo "<td>Rp. ".number_format($rows->dana_masuk)."</td>";
                    echo "<td>";
                    if($rows->cara_bayar == "Uang Tanda Jadi"){
                        echo "Rp. ".number_format($rows->dana_masuk);
                    } else {
                        foreach($q->result() as $row1){
                            echo "Rp. ".number_format($row1->pembayaran)."<br>";
                        }
                    }
                    echo "</td>";
                    echo "<td>";
                    if($rows->cara_bayar == "Uang Tanda Jadi"){
                        echo "Rp. ".number_format($rows->dana_masuk - $rows->dana_masuk);
                    } else {
                        foreach($q->result() as $row2){
                            echo "Rp. ".number_format($row2->sisa_dana)."<br>";
                        }
                    }
                    echo "</td>";
                    echo "<td style='white-space: nowrap'>";
                    if($rows->cara_bayar == "Uang Tanda Jadi"){
                        foreach($this->db->get_where('ppjb', array('no_psjb'=>$rows->no_psjb, 'kode_perumahan'=>$rows->kode_perumahan))->result() as $td){
                            echo date('d-m-y', strtotime($td->date_by))." ".$td->cara_pembayaran."-".$td->nama_bank;
                        }
                    } else {
                        foreach($q->result() as $row){
                            echo date('d-m-y', strtotime($row->tanggal_bayar))." ".$row->cara_pembayaran."-".$row->nama_bank."<br>";
                        }
                    }
                    echo "</td>";
                echo "</tr>";
                $no++;
            }
            echo "</tbody>
                  </table>";

            echo "<script type='text/javascript'>
                    $('#example3').DataTable({
                        paging: true,
                        lengthChange: true,
                        searching: false,
                        ordering: true,
                        info: true,
                        autoWidth: false,
                        responsive: false,
                        scrollX: true,
                        scrollY: '300px',
                        scrollCollapse: true
                    });
                  </script>";
        }
    }

    public function laporan_keuangan_bfee(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('psjb');

        $this->load->view('laporan_keuangan_bfree', $data);
    }
    
    public function laporan_penerimaan_lain(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('keuangan_penerimaan_lain');

        $this->load->view('laporan_penerimaan_lain', $data);
    }

    public function view_laba_rugi(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('laporan_laba_rugi_perumahan', $data);
    }

    public function view_laba_rugi_rekonsiliasi(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perusahaan')->result();

        $this->load->view('laporan_laba_rugi_perumahan_rekonsiliasi', $data);
    }

    public function laba_rugi(){
        $id = $_GET['id'];

        $tgl_awal = "";
        $tgl_akhir = "";

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['tgl'] = date('Y-12-31');
        $data['kode_perumahan'] = $id;
        $data['tglmin'] = $tgl_awal;
        $data['tglmax'] = $tgl_akhir;

        $data['tgl_awal'] = $tgl_awal;

        // $data['check_all'] = $this->db->get('akuntansi_anak_akun');

        $this->load->view('laporan_laba_rugi', $data);
    }

    public function laba_rugi_rekonsiliasi(){
        $id = $_GET['id'];

        $tgl_awal = "";
        $tgl_akhir = "";

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;

            $data['nama_perusahaan'] = $row->nama_perusahaan;
        }

        $data['tgl'] = date('Y-12-31');
        $data['kode_perumahan'] = $id;
        $data['tglmin'] = $tgl_awal;
        $data['tglmax'] = $tgl_akhir;

        $data['tgl_awal'] = $tgl_awal;

        $data['id'] = $id;

        // $data['check_all'] = $this->db->get('akuntansi_anak_akun');

        $this->load->view('laporan_laba_rugi_rekonsiliasi', $data);
    }

    public function filter_laba_rugi(){
        $kode_perumahan = $_POST['kode_perumahan'];

        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];

        // echo $tgl_awal;
        // exit;

        if($tgl_akhir < $tgl_awal){
            echo "<script>
                    alert('Tanggal Max tidak bisa lebih besar dari Tanggal Min!');
                    window.location.href = 'laba_rugi?id=$kode_perumahan';
                  </script>";
        } else {
            foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
            }

            $data['nama'] = $this->session->userdata('nama');

            $data['kode_perumahan'] = $kode_perumahan;

            $data['tglmin'] = $tgl_awal;
            $data['tglmax'] = $tgl_akhir;
            $data['tgl'] = date('Y-m-d', strtotime($tgl_akhir));

            $this->load->view('laporan_laba_rugi', $data);
        }
    }

    public function filter_laba_rugi_rekonsiliasi(){
        $kode_perumahan = $_POST['kode_perumahan'];

        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];

        // echo $tgl_awal;
        // exit;

        if($tgl_akhir < $tgl_awal){
            echo "<script>
                    alert('Tanggal Max tidak bisa lebih besar dari Tanggal Min!');
                    window.location.href = 'laba_rugi?id=$kode_perumahan';
                  </script>";
        } else {
            foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$kode_perumahan))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
                $data['nama_perusahaan'] = $row->nama_perusahaan;
            }

            $data['nama'] = $this->session->userdata('nama');

            $data['kode_perumahan'] = $kode_perumahan;
            $data['id'] = $kode_perumahan;

            $data['tglmin'] = $tgl_awal;
            $data['tglmax'] = $tgl_akhir;
            $data['tgl'] = date('Y-m-d', strtotime($tgl_akhir));

            $this->load->view('laporan_laba_rugi_rekonsiliasi', $data);
        }
    }

    public function print_laba_rugi(){
        $kode_perumahan = $_GET['id'];
        $tglmin = $_GET['min'];
        $tglmax = $_GET['max'];

        $data['kode_perumahan'] = $kode_perumahan;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-laba-rugi.pdf";
        ob_end_clean();
        $this->pdf->load_view('laporan_print_laba_rugi', $data);
    }

    public function print_laba_rugi_rekonsiliasi(){
        $kode_perumahan = $_GET['id'];
        $tglmin = $_GET['min'];
        $tglmax = $_GET['max'];

        $data['kode_perumahan'] = $kode_perumahan;
        $data['id'] = $kode_perumahan;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$kode_perumahan))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['nama_perusahaan'] = $row->nama_perusahaan;
        }

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-laba-rugi.pdf";
        ob_end_clean();
        $this->pdf->load_view('laporan_print_laba_rugi_rekonsiliasi', $data);
    }

    public function view_perubahan_modal(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('laporan_perubahan_modal_perumahan', $data);
    }

    public function view_perubahan_modal_rekonsiliasi(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perusahaan')->result();

        $this->load->view('laporan_perubahan_modal_perumahan_rekonsiliasi', $data);
    }

    public function perubahan_modal(){
        $id = $_GET['id'];

        $tgl_awal = "";
        $tgl_akhir = "";

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['tgl'] = date('Y-12-31');
        $data['kode_perumahan'] = $id;
        $data['tglmin'] = $tgl_awal;
        $data['tglmax'] = $tgl_akhir;

        $this->load->view('laporan_perubahan_modal', $data);
    }

    public function perubahan_modal_rekonsiliasi(){
        $id = $_GET['id'];

        $tgl_awal = "";
        $tgl_akhir = "";

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['nama_perusahaan'] = $row->nama_perusahaan;
        }

        $data['tgl'] = date('Y-12-31');
        $data['kode_perumahan'] = $id;
        $data['id'] = $id;
        $data['tglmin'] = $tgl_awal;
        $data['tglmax'] = $tgl_akhir;

        $this->load->view('laporan_perubahan_modal_rekonsiliasi', $data);
    }

    public function filter_perubahan_modal(){
        $kode_perumahan = $_POST['kode_perumahan'];

        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];

        // echo $tgl_awal;
        // exit;

        if($tgl_akhir < $tgl_awal){
            echo "<script>
                    alert('Tanggal Max tidak bisa lebih besar dari Tanggal Min!');
                    window.location.href = 'perubahan_modal?id=$kode_perumahan';
                  </script>";
        } else {

            foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
            }

            $data['nama'] = $this->session->userdata('nama');

            $data['kode_perumahan'] = $kode_perumahan;

            $data['tglmin'] = $tgl_awal;
            $data['tglmax'] = $tgl_akhir;
            $data['tgl'] = date('Y-m-d', strtotime($tgl_akhir));

            $this->load->view('laporan_perubahan_modal', $data);
        }
    }

    public function filter_perubahan_modal_rekonsiliasi(){
        $kode_perumahan = $_POST['kode_perumahan'];

        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];

        // echo $tgl_awal;
        // exit;

        if($tgl_akhir < $tgl_awal){
            echo "<script>
                    alert('Tanggal Max tidak bisa lebih besar dari Tanggal Min!');
                    window.location.href = 'perubahan_modal_rekonsiliasi?id=$kode_perumahan';
                  </script>";
        } else {

            foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$kode_perumahan))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
                $data['nama_perusahaan'] = $row->nama_perusahaan;
            }

            $data['nama'] = $this->session->userdata('nama');

            $data['kode_perumahan'] = $kode_perumahan;
            $data['id'] = $kode_perumahan;

            $data['tglmin'] = $tgl_awal;
            $data['tglmax'] = $tgl_akhir;
            $data['tgl'] = date('Y-m-d', strtotime($tgl_akhir));

            $this->load->view('laporan_perubahan_modal_rekonsiliasi', $data);
        }
    }

    public function print_perubahan_modal(){
        $kode_perumahan = $_GET['id'];
        $tglmin = $_GET['min'];
        $tglmax = $_GET['max'];

        $data['kode_perumahan'] = $kode_perumahan;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-perubahan-modal.pdf";
        ob_end_clean();
        $this->pdf->load_view('laporan_print_perubahan_modal', $data);
    }

    public function print_perubahan_modal_rekonsiliasi(){
        $kode_perumahan = $_GET['id'];
        $tglmin = $_GET['min'];
        $tglmax = $_GET['max'];

        $data['kode_perumahan'] = $kode_perumahan;
        $data['id'] = $kode_perumahan;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$kode_perumahan))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['nama_perusahaan'] = $row->nama_perusahaan;
        }
        // print_r($data['nama_perusahaan']);
        // exit;

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-perubahan-modal.pdf";
        ob_end_clean();
        $this->pdf->load_view('laporan_print_perubahan_modal_rekonsiliasi', $data);
    }

    public function view_neraca(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('laporan_neraca_saldo_perumahan', $data);
    }

    public function view_neraca_rekonsiliasi(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perusahaan')->result();

        $this->load->view('laporan_neraca_saldo_perumahan_rekonsiliasi', $data);
    }

    public function neraca(){
        $id = $_GET['id'];

        $tgl_awal = "";
        $tgl_akhir = "";

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['tgl'] = date('Y-12-31');
        $data['kode_perumahan'] = $id;
        $data['tglmin'] = $tgl_awal;
        $data['tglmax'] = $tgl_akhir;

        $data['tgl_awal'] = $tgl_awal;

        $this->load->view('laporan_neraca_saldo', $data);
    }

    public function neraca_rekonsiliasi(){
        $id = $_GET['id'];

        $tgl_awal = "";
        $tgl_akhir = "";

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['nama_perusahaan'] = $row->nama_perusahaan;
        }

        $data['tgl'] = date('Y-12-31');
        $data['kode_perumahan'] = $id;
        $data['id'] = $id;
        $data['tglmin'] = $tgl_awal;
        $data['tglmax'] = $tgl_akhir;

        $data['tgl_awal'] = $tgl_awal;

        $this->load->view('laporan_neraca_saldo_rekonsiliasi', $data);
    }

    public function filter_neraca(){
        $kode_perumahan = $_POST['kode_perumahan'];

        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];

        // echo $tgl_awal;
        // exit;

        if($tgl_akhir < $tgl_awal){
            echo "<script>
                    alert('Tanggal Max tidak bisa lebih besar dari Tanggal Min!');
                    window.location.href = 'neraca?id=$kode_perumahan';
                  </script>";
        } else {

            foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
            }

            $data['nama'] = $this->session->userdata('nama');

            $data['kode_perumahan'] = $kode_perumahan;

            $data['tglmin'] = $tgl_awal;
            $data['tglmax'] = $tgl_akhir;
            $data['tgl'] = date('Y-m-d', strtotime($tgl_akhir));

            $this->load->view('laporan_neraca_saldo', $data);
        }
    }

    public function filter_neraca_rekonsiliasi(){
        $kode_perumahan = $_POST['kode_perumahan'];

        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];

        // echo $tgl_awal;
        // exit;

        if($tgl_akhir < $tgl_awal){
            echo "<script>
                    alert('Tanggal Max tidak bisa lebih besar dari Tanggal Min!');
                    window.location.href = 'neraca_rekonsiliasi?id=$kode_perumahan';
                  </script>";
        } else {

            foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$kode_perumahan))->result() as $row){
                $data['nama_perumahan'] = $row->nama_perumahan;
                $data['nama_perusahaan'] = $row->nama_perusahaan;
            }

            $data['nama'] = $this->session->userdata('nama');

            $data['kode_perumahan'] = $kode_perumahan;
            $data['id'] = $kode_perumahan;

            $data['tglmin'] = $tgl_awal;
            $data['tglmax'] = $tgl_akhir;
            $data['tgl'] = date('Y-m-d', strtotime($tgl_akhir));

            $this->load->view('laporan_neraca_saldo_rekonsiliasi', $data);
        }
    }

    public function print_neraca(){
        $kode_perumahan = $_GET['id'];
        $tglmin = $_GET['min'];
        $tglmax = $_GET['max'];
        // $data['tgl_awal'] = $tglmin;

        $data['kode_perumahan'] = $kode_perumahan;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-neraca-saldo.pdf";
        ob_end_clean();
        $this->pdf->load_view('laporan_print_neraca_saldo', $data);
    }

    public function print_neraca_rekonsiliasi(){
        $kode_perumahan = $_GET['id'];
        $tglmin = $_GET['min'];
        $tglmax = $_GET['max'];
        // $data['tgl_awal'] = $tglmin;

        $data['kode_perumahan'] = $kode_perumahan;
        $data['id'] = $kode_perumahan;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        foreach($this->db->get_where('perumahan', array('kode_perusahaan'=>$kode_perumahan))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            $data['nama_perusahaan'] = $row->nama_perusahaan;
        }

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-neraca-saldo.pdf";
        ob_end_clean();
        $this->pdf->load_view('laporan_print_neraca_saldo_rekonsiliasi', $data);
    }

    public function marketing_rekap_penjualan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('marketing_rekap_penjualan_perumahan', $data);
    }

    public function rekap_penjualan(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;
        $data['tglmin'] = "";
        $data['tglmax'] = "";

        // $this->db->group_by('nama_marketing');
        $data['check_all'] = $this->db->get_where('ppjb', array('kode_perumahan'=>$id))->result();

        // print_r($data['check_all']);
        // exit;

        $this->load->view('marketing_rekap_penjualan', $data);
    }

    public function filter_rekap_penjualan(){
        $id = $_POST['id'];
        $tglmin = $_POST['tglmin'];
        $tglmax = $_POST['tglmax'];

        $data['nama'] = $this->session->userdata('nama');

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;
        $data['filter'] = "";

        $data['check_all'] = $this->Dashboard_model->marketing_rekap_penjualan($id, $tglmin, $tglmax)->result();

        $this->load->view('marketing_rekap_penjualan', $data);
    }

    public function print_laporan_marketing(){
        $id = $_GET['id'];
        $tglmin = $_GET['min'];
        $tglmax = $_GET['max'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['id'] = $id;
        $data['tglmin'] = $tglmin;
        $data['tglmax'] = $tglmax;

        $data['check_all'] = $this->Dashboard_model->marketing_rekap_penjualan($id, $tglmin, $tglmax)->result();

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-marketing.pdf";
        ob_end_clean();
        $this->pdf->load_view('marketing_laporan', $data);
    }
    //END OF LAPORAN

    //START OF LOGISTIK
    public function view_stok(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('logistik_stok_perumahan', $data);
    }

    public function stok_bahan(){
        $id = $_GET['id'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = date('Y-m-d');
        
        $gt = $data['tgl'].' first day of last month';

        $data['kode_perumahan'] = $id;

        $dt = date_create($gt);
        $data['dt'] = $dt->format('Y-m-d');
        // echo $data['dt'];
        // exit;

        // $data['check_all'] = $this->Dashboard_model->stock_bulan($id, $dt);

        $this->db->order_by('nama_data', "ASC");
        $data['brg'] = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"));

        $this->load->view('logistik_stok', $data);
    }

    public function filter_stok(){
        $tgl = $_POST['bulan'];
        $id = $_POST['id'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['tgl'] = $tgl;
        
        $gt = $data['tgl'].' first day of last month';

        $data['kode_perumahan'] = $id;

        $dt = date_create($gt);
        $data['dt'] = $dt->format('Y-m-d');

        // $data['check_all'] = $this->Dashboard_model->stock_bulan($id, $dt);

        $this->db->order_by('nama_data', "ASC");
        $data['brg'] = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"));

        $this->load->view('logistik_stok', $data);
    }

    public function print_stok_bahan(){
        $tgl = $_GET['bln'];
        $id = $_GET['id'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['tgl'] = $tgl;
        
        $gt = $data['tgl'].' first day of last month';

        $data['kode_perumahan'] = $id;

        $dt = date_create($gt);
        $data['dt'] = $dt->format('Y-m-d');

        // $data['check_all'] = $this->Dashboard_model->stock_bulan($id, $dt);

        $this->db->order_by('nama_data', "ASC");
        $data['brg'] = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"));
        
        $this->load->library('pdf');
            
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "print-stok.pdf";
        ob_end_clean();
        $this->pdf->load_view('logistik_stok_print', $data);
    }

    public function view_check_stock_akhir_bulan(){
        $data['id'] = $_GET['id'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$data['id']))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->Dashboard_model->stock_group_bulan($data['id']);
        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        // print_r($data['check_all']->result());
        // exit;

        $this->load->view('logistik_stok_grup_akhir_bulan', $data);
    }

    public function view_add_check_stok_baru(){
        $id = $_GET['id'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['nama'] = $this->session->userdata('nama');
        
        $this->db->order_by('nama_data', "ASC");
        $data['check_all'] = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"))->result();
        $data['id'] = $id;

        $this->load->view('logistik_stok_akhir_bulan', $data);
    }

    public function add_stok_akhir_bulan(){
        $kode_perumahan = $_POST['kode_perumahan'];
        $nama_bahan = $_POST['nama_bahan'];
        $nama_satuan = $_POST['nama_satuan'];
        $qty = $_POST['qty'];
        $bulan = $_POST['bulan'];

        $cek = $this->Dashboard_model->cek_stok($kode_perumahan, $bulan)->num_rows();
        if($cek > 0){
            echo "<script>
                    alert('Data sudah ada!');
                    window.location.href = 'view_add_check_stok_baru?id=$kode_perumahan';
                  </script>";
        } else {
            for($i = 0; $i < count($nama_bahan); $i++){
                $data = array(
                    'kode_perumahan'=>$kode_perumahan,
                    'nama_barang'=>$nama_bahan[$i],
                    'nama_satuan'=>$nama_satuan[$i],
                    'stok'=>$qty[$i],
                    'bulan_cek'=>$bulan
                );

                $this->db->insert('logistik_stok', $data);
            }

            // print_r($nama_bahan);
            // exit;

            redirect('Dashboard/view_check_stock_akhir_bulan?id='.$kode_perumahan);
        }
    }

    public function view_edit_check_stok_baru(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }
        
        $this->db->order_by('nama_data', "ASC");
        $data['revisi'] = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"))->result();

        $data['nama'] = $this->session->userdata('nama');

        $data['id'] = $id;
        $data['tgl'] = $kode;

        $this->load->view('logistik_stok_akhir_bulan', $data);
    }

    public function edit_stok_akhir_bulan(){
        $kode_perumahan = $_POST['kode_perumahan'];
        $nama_bahan = $_POST['nama_bahan'];
        $nama_satuan = $_POST['nama_satuan'];
        $qty = $_POST['qty'];
        $bulan = $_POST['bulan'];

        // $cek = $this->Dashboard_model->cek_stok($kode_perumahan, $bulan)->num_rows();
        // if($cek > 0){
        //     echo "<script>
        //             alert('Data sudah ada!');
        //             window.location.href = 'view_add_check_stok_baru?id=$kode_perumahan';
        //           </script>";
        // } else {
        $this->Dashboard_model->delete_stok($kode_perumahan, $bulan);

        for($i = 0; $i < count($nama_bahan); $i++){
            $data = array(
                'kode_perumahan'=>$kode_perumahan,
                'nama_barang'=>$nama_bahan[$i],
                'nama_satuan'=>$nama_satuan[$i],
                'stok'=>$qty[$i],
                'bulan_cek'=>$bulan
            );

            $this->db->insert('logistik_stok', $data);
        }

        redirect('Dashboard/view_edit_check_stok_baru?id='.$kode_perumahan.'&kode='.$bulan);
    }

    public function hapus_check_stok_baru(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        // $this->db->delete('logistik_stok');
        $this->Dashboard_model->delete_stok($id, $kode);

        $this->session->set_flashdata('succ_msg', "Data berhasil dihapus!");

        redirect('Dashboard/view_check_stock_akhir_bulan?id='.$id);
    }

    public function print_check_stok_bahan(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
    }

    public function get_satuan(){
        $ch = $_POST['country'];

        foreach($this->db->get_where('produksi_master_data', array('kategori'=>"barang", 'nama_data'=>$ch))->result() as $row){
            echo $row->nama_satuan;
        }
    }

    public function stok_masuk(){
        $data['in_stok'] = "";

        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('logistik_stok_inout', $data);
    }

    public function add_stok_masuk(){
        $tgl = $_POST['tgl'];
        $kode_perumahan = $_POST['perumahan'];
        $nama_bahan = $_POST['nama_bahan'];
        $qty = $_POST['qty'];
        $jenis = "masuk";
        $nama_toko = $_POST['nama_toko'];
        $nama_satuan = $_POST['nama_satuan'];

        $data = array(
            'nama_barang'=>$nama_bahan,
            'jenis_arus'=>$jenis,
            'qty'=>$qty,
            'tgl_arus'=>date('Y-m-d H:i:sa am/pm'),
            'kode_perumahan'=>$kode_perumahan,
            'nama_toko'=>$nama_toko,
            'nama_satuan'=>$nama_satuan,
        );

        $this->db->insert('logistik_arus_stok', $data);

        $this->session->set_flashdata('succ_msg', "Data berhasil ditambahkan!");

        redirect('Dashboard/stok_masuk');
    }

    public function stok_keluar(){
        $data['out_stok'] = "";

        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('logistik_stok_inout', $data);
    }

    public function get_unit(){
        $id = $_POST['country'];
        // $category = $_POST['kat'];

        // $this->db->order_by('no_psjb', 'ASC');
        $query = $this->db->get_where('kbk', array('kode_perumahan'=>$id, 'status'=>"approved"))->result();

        // Display city dropdown based on country name
        if($id !== 'Select'){
            // echo "<label>City:</label>";
            // echo "<select>";
            echo "<option value='' selected>-Pilih-</option>";
            foreach($query as $value){
                echo "<option value='";
                echo $value->unit;
                // foreach($this->db->get_where('rumah', array('no_psjb'=>$value->psjb))->result() as $rmh){
                //     echo ", ".$rmh->kode_rumah;
                // }
                echo "'>";
                echo $value->unit;
                // foreach($this->db->get_where('rumah', array('no_psjb'=>$value->psjb))->result() as $rmh){
                //     echo ", ".$rmh->kode_rumah;
                // }
                echo "</option>";
            }
            // echo "</select>";
        } 
    }
    
    public function get_unit_tambahan_bangunan(){
        $id = $_POST['kontrak'];
        $kode = $_POST['kodePerumahan'];

        $query = $this->db->get_where('kbk_kontrak_kerja', array('kode_perumahan'=>$kode, 'no_unit'=>$id, 'kategori'=>"tambahanbangunan", 'status'=>"approved"));

        if($id !== 'Select'){
            echo "<option value=''>-Pilih-</option>";
            foreach($query->result() as $value){
                echo "<option value='";
                echo $value->id_kontrak;
                // foreach($this->db->get_where('rumah', array('no_psjb'=>$value->psjb))->result() as $rmh){
                //     echo ", ".$rmh->kode_rumah;
                // }
                echo "'>";
                echo $value->pekerjaan_ket;
                // foreach($this->db->get_where('rumah', array('no_psjb'=>$value->psjb))->result() as $rmh){
                //     echo ", ".$rmh->kode_rumah;
                // }
                echo "</option>";
            }
        }
    }

    public function get_sarana(){
        $id = $_POST['country'];

        // $this->db->order_by('kode_rumah', 'ASC');
        $query = $this->db->get_where('kawasan', array('kode_perumahan'=>$id))->result();

        // Display city dropdown based on country name
        if($id !== 'Select'){
            // echo "<label>City:</label>";
            // echo "<select>";
            echo "<option value='' selected>-Pilih-</option>";
            foreach($query as $value){
                echo "<option value=".$value->id_kawasan.">".$value->nama."</option>";
            }
            // echo "</select>";
        } 
    }

    public function get_tambahan_bangunan_unit(){
        $id = $_POST['country'];

        $query = $this->db->get_where('kbk_kontrak_kerja', array(''));
    }

    public function add_stok_keluar(){
        // $tgl = $_POST['tgl'];
        $tgl = date('Y-m-d H:i:sa am/pm');
        $kode_perumahan = $_POST['perumahan'];
        $nama_bahan = $_POST['nama_bahan'];
        $qty = $_POST['qty'];
        $jenis = "keluar";
        $no_unit = $_POST['no_unit'];
        $kategori = $_POST['kategori'];
        $nama_penerima = $_POST['nama_penerima'];
        $nama_satuan = $_POST['nama_satuan'];
        $keterangan = $_POST['keterangan'];

        $kode_perumahan2 = $_POST['perumahan2'];
        $sarana = $_POST['no_unit2'];

        $id_kontrak = $_POST['id_kontrak'];
        $kode_perumahan_borongan = $_POST['perumahan_borongan'];
        $no_unit_borongan = $_POST['no_unit_borongan'];

        $perumahan_lainnya = $_POST['perumahan_lainnya'];

        if($kategori == "prasarana"){
            $data = array(
                'nama_barang'=>$nama_bahan,
                'jenis_arus'=>$jenis,
                'qty'=>$qty,
                'tgl_arus'=>$tgl,
                'kode_perumahan'=>$kode_perumahan2,
                'no_unit'=>$sarana,
                'nama_pengambil'=>$nama_penerima,
                'keterangan'=>$keterangan,
                'nama_satuan'=>$nama_satuan,
                'kategori'=>$kategori
            );
    
            $this->db->insert('logistik_arus_stok', $data);
        } else if($kategori == "tambahanbangunan"){
            $data = array(
                'nama_barang'=>$nama_bahan,
                'jenis_arus'=>$jenis,
                'qty'=>$qty,
                'tgl_arus'=>$tgl,
                'kode_perumahan'=>$kode_perumahan_borongan,
                'no_unit'=>$no_unit_borongan,
                'nama_pengambil'=>$nama_penerima,
                'keterangan'=>$keterangan,
                'nama_satuan'=>$nama_satuan,
                'kategori'=>$kategori,
                'id_kontrak_tb'=>$id_kontrak
            );
    
            $this->db->insert('logistik_arus_stok', $data);
        } else if($kategori == "lainnya"){
            $data = array(
                'nama_barang'=>$nama_bahan,
                'jenis_arus'=>$jenis,
                'qty'=>$qty,
                'tgl_arus'=>$tgl,
                'kode_perumahan'=>$perumahan_lainnya,
                // 'no_unit'=>$sarana,
                'nama_pengambil'=>$nama_penerima,
                'keterangan'=>$keterangan,
                'nama_satuan'=>$nama_satuan,
                'kategori'=>$kategori
            );
    
            $this->db->insert('logistik_arus_stok', $data);
        } else {
            $data = array(
                'nama_barang'=>$nama_bahan,
                'jenis_arus'=>$jenis,
                'qty'=>$qty,
                'tgl_arus'=>$tgl,
                'kode_perumahan'=>$kode_perumahan,
                'no_unit'=>$no_unit,
                'nama_pengambil'=>$nama_penerima,
                'keterangan'=>$keterangan,
                'nama_satuan'=>$nama_satuan,
                'kategori'=>$kategori
            );
    
            $this->db->insert('logistik_arus_stok', $data);
        }

        $this->session->set_flashdata('succ_msg', "Data berhasil ditambahkan!");

        redirect('Dashboard/stok_keluar');
    }

    public function view_rekap_arus_stok(){
        // $data['id'] = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('logistik_rekap_arus_stok_perumahan', $data);
    }

    public function rekap_arus_stok(){
        $id = $_GET['id'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $this->db->order_by('id_arus', "DESC");
        $data['check_all'] = $this->db->get_where('logistik_arus_stok', array('kode_perumahan'=>$id, 'jenis_arus'=>"masuk"));

        $this->db->order_by('id_arus', "DESC");
        $data['check_all1'] = $this->db->get_where('logistik_arus_stok', array('kode_perumahan'=>$id, 'jenis_arus'=>"keluar"));

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('logistik_rekap_arus_stok', $data);
    }

    public function open_akses_edit_stok(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $count = 1;
        foreach($this->db->get_where('logistik_arus_stok', array('id_arus'=>"id"))->result() as $row){
            $count = $row->count_rev + 1;
        }

        $data = array(
            'status_rev'=>"true",
            'date_rev'=>date('Y-m-d H:i:sa am/pm'),
            'count_rev'=>$count
        );

        $this->db->update('logistik_arus_stok', $data, array('id_arus'=>$id));

        redirect('Dashboard/rekap_arus_stok?id='.$kode);
    }

    public function view_edit_arus_stok(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['id'] = $id;
        $data['kode'] = $kode;

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $data['edit_flow'] = $this->db->get_where('logistik_arus_stok', array('id_arus'=>$id));

        if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager produksi"){
            $this->load->view('logistik_stok_inout', $data);
        } else {
            foreach($this->db->get_where('logistik_arus_stok', array('id_arus'=>$id))->result() as $row1){
                if($row1->status_rev != "true"){
                    echo "<script>
                            alert('Anda telah melakukan edit stok, harap minta akses kembali ke Manager/Administor!');
                            window.location.href='rekap_arus_stok?id=$kode';
                          </script>";
                } else {
                    $this->load->view('logistik_stok_inout', $data);
                }
                // redirect('Dashboard/re');
            }
        }
    }

    public function edit_arus_stok(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $jenis_arus = $_POST['jenis_arus'];

        // echo $jenis_arus;
        // exit;

        if($jenis_arus == "masuk"){
            $tgl = $_POST['tgl'];
            $kode_perumahan = $_POST['perumahan'];
            $nama_bahan = $_POST['nama_bahan'];
            $qty = $_POST['qty'];
            $jenis = "masuk";
            $nama_toko = $_POST['nama_toko'];
            $nama_satuan = $_POST['nama_satuan'];
    
            $data = array(
                'nama_barang'=>$nama_bahan,
                'jenis_arus'=>$jenis,
                'qty'=>$qty,
                'tgl_arus'=>$tgl,
                'kode_perumahan'=>$kode_perumahan,
                'nama_toko'=>$nama_toko,
                'nama_satuan'=>$nama_satuan,
                'tgl_update'=>date('Y-m-d H:i:sa am/pm')
            );
    
            $this->db->update('logistik_arus_stok', $data, array('id_arus'=>$id));
        } else {
            $tgl = $_POST['tgl'];
            $nama_bahan = $_POST['nama_bahan'];
            $qty = $_POST['qty'];
            $jenis = "keluar";
            $nama_penerima = $_POST['nama_penerima'];
            $nama_satuan = $_POST['nama_satuan'];
            $keterangan = $_POST['keterangan'];
            $kategori=$_POST['kategori'];
            $no_unit = $_POST['no_unit'];
            $kode_perumahan = $_POST['perumahan'];
            // $nama_toko = $_POST['nama_toko'];
            // echo $no_unit;
            // exit;
    
            $kode_perumahan2 = $_POST['perumahan2'];
            $sarana = $_POST['no_unit2'];

            $id_kontrak = $_POST['id_kontrak'];
            $kode_perumahan_borongan = $_POST['perumahan_borongan'];
            $no_unit_borongan = $_POST['no_unit_borongan'];

            $perumahan_lainnya = $_POST['perumahan_lainnya'];

            if($kategori == "prasarana"){
                $data = array(
                    'nama_barang'=>$nama_bahan,
                    'jenis_arus'=>$jenis,
                    'qty'=>$qty,
                    'tgl_arus'=>$tgl,
                    'kode_perumahan'=>$kode_perumahan2,
                    'no_unit'=>$sarana,
                    'nama_pengambil'=>$nama_penerima,
                    'keterangan'=>$keterangan,
                    'nama_satuan'=>$nama_satuan,
                    'kategori'=>$kategori
                );
        
                $this->db->update('logistik_arus_stok', $data, array('id_arus'=>$id));
            } else if($kategori == "tambahanbangunan"){
                $data = array(
                    'nama_barang'=>$nama_bahan,
                    'jenis_arus'=>$jenis,
                    'qty'=>$qty,
                    'tgl_arus'=>$tgl,
                    'kode_perumahan'=>$kode_perumahan_borongan,
                    'no_unit'=>$no_unit_borongan,
                    'nama_pengambil'=>$nama_penerima,
                    'keterangan'=>$keterangan,
                    'nama_satuan'=>$nama_satuan,
                    'kategori'=>$kategori,
                    'id_kontrak_tb'=>$id_kontrak
                );
        
                $this->db->update('logistik_arus_stok', $data, array('id_arus'=>$id));
            } else if($kategori == "lainnya"){
                $data = array(
                    'nama_barang'=>$nama_bahan,
                    'jenis_arus'=>$jenis,
                    'qty'=>$qty,
                    'tgl_arus'=>$tgl,
                    'kode_perumahan'=>$perumahan_lainnya,
                    // 'no_unit'=>$sarana,
                    'nama_pengambil'=>$nama_penerima,
                    'keterangan'=>$keterangan,
                    'nama_satuan'=>$nama_satuan,
                    'kategori'=>$kategori
                );
        
                $this->db->update('logistik_arus_stok', $data, array('id_arus'=>$id));
            } else {
                $data = array(
                    'nama_barang'=>$nama_bahan,
                    'jenis_arus'=>$jenis,
                    'qty'=>$qty,
                    'tgl_arus'=>$tgl,
                    'kode_perumahan'=>$kode_perumahan,
                    'no_unit'=>$no_unit,
                    'nama_pengambil'=>$nama_penerima,
                    'keterangan'=>$keterangan,
                    'nama_satuan'=>$nama_satuan,
                    'kategori'=>$kategori
                );
        
                $this->db->update('logistik_arus_stok', $data, array('id_arus'=>$id));
            }
        }

        $data1 = array(
            'status_rev'=>""
        );

        $this->db->update('logistik_arus_stok', $data1, array('id_arus'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil di update");

        if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager produksi"){
            redirect('Dashboard/view_edit_arus_stok?id='.$id.'&kode='.$kode);
        } else {
            redirect('Dashboard/rekap_arus_stok?id='.$kode);
        }
    }

    public function hapus_arus_stok(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $this->db->delete('logistik_arus_stok', array('id_arus'=>$id));

        redirect('Dashboard/rekap_arus_stok?id='.$kode);
    }
    
    public function view_rekap_pemakaian_bahan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('logistik_rekap_pemakaian_bahan_perumahan', $data); 
    }

    public function rekap_pemakaian_bahan(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get_where('kbk', array('kode_perumahan'=>$id, 'status'=>"approved"))->result();
        $data['id'] = $id;
        
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['k_kawasan'] = $this->db->get_where('kawasan', array('kode_perumahan'=>$id))->result();

        // print_r($data['k_kawasan']);
        // exit;

        $this->load->view('logistik_rekap_pemakaian_bahan', $data);
    }

    public function rekap_pemakaian_perunit(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }
        $data['kode_perumahan'] = $kode;

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('kbk', array('id_kbk'=>$id));

        // $data['check_alls'] = $this->db->get_where('rumah', array('id_rumah'=>$id));
        foreach($data['check_all']->result() as $row1){
            $data['no_unit'] = $row1->unit;
            $data['kategori'] = "unit";
            $data['awal'] = $row1->tgl_mulai;
            $data['akhir'] = $row1->tgl_selesai;
        }

        $data['id'] = $id;
        $data['kode'] = $kode;

        $this->load->view('logistik_rekap_pemakaian', $data);
    }

    public function rekap_pemakaian_perkawasan(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }
        $data['kode_perumahan'] = $kode;

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('kawasan', array('id_kawasan'=>$id));

        // $data['check_alls'] = $this->db->get_where('rumah', array('id_rumah'=>$id));
        foreach($data['check_all']->result() as $row1){
            $data['no_unit'] = $row1->id_kawasan;
            $data['kategori'] = "prasarana";
            $data['awal'] = $row1->tgl_mulai;
            $data['akhir'] = $row1->tgl_selesai;
        }

        $data['id'] = $id;
        $data['kode'] = $kode;

        $this->load->view('logistik_rekap_pemakaian', $data);
    }

    public function rekap_pemakaian_tambahanbangunan(){
        $id = $_GET['id'];
        $id_unit = $_GET['ids'];
        $kode_perumahan = $_GET['kode'];

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $data['ids'] = $id;
        $data['id'] = $id_unit;
        $data['kode_perumahan'] = $kode_perumahan;

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$id));

        foreach($data['check_all']->result() as $row1){
            $data['no_unit'] = $row1->no_unit;
            $data['awal_kerja'] = $row1->mulai_kerja;
            $data['selesai_kerja'] = $row1->selesai_kerja;
        }

        $this->load->view('logistik_rekap_arus_stok_tambahanbangunan', $data);
    }

    public function update_pengerjaan(){
        $awal = $_POST['awal'];
        $akhir = $_POST['akhir'];
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $kategori = $_POST['kategori'];
        $harga_satuan = $_POST['harga_satuan'];
        $id_data = $_POST['id_data'];

        // print_r($id_data);
        // exit;

        for($i = 0; $i < count($harga_satuan); $i++){
            $data1 = array(
                'harga_satuan'=>$harga_satuan[$i]
            );

            $this->db->update('produksi_master_data', $data1, array('id_data'=>$id_data[$i], 'kategori'=>"barang"));
        }

        if($kategori == "prasarana"){
            $data = array(
                'tgl_mulai'=>$awal,
                'tgl_selesai'=>$akhir
            );
            $this->db->update('kawasan', $data, array('id_kawasan'=>$id));

            redirect('Dashboard/rekap_pemakaian_perkawasan?id='.$id.'&kode='.$kode);
        } else {
            $data = array(
                'tgl_mulai'=>$awal,
                'tgl_selesai'=>$akhir
            );
            $this->db->update('kbk', $data, array('id_kbk'=>$id));

            redirect('Dashboard/rekap_pemakaian_perunit?id='.$id.'&kode='.$kode);
        }
    }

    public function update_pengerjaan2(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $kategori = $_POST['kategori'];
        $harga_satuan = $_POST['harga_satuan'];
        $id_data = $_POST['id_data'];

        for($i = 0; $i < count($harga_satuan); $i++){
            $data1 = array(
                'harga_satuan'=>$harga_satuan[$i]
            );

            $this->db->update('produksi_master_data', $data1, array('id_data'=>$id_data[$i], 'kategori'=>"barang"));
        }
        
        if($kategori == "prasarana"){
            redirect('Dashboard/rekap_pemakaian_perkawasan?id='.$id.'&kode='.$kode);
        } else {
            redirect('Dashboard/rekap_pemakaian_perunit?id='.$id.'&kode='.$kode);
        }
    }
    //END OF LOGISTIK

    //START OF KAWASAN
    public function kawasan_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('kawasan');

        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('kawasan', $data);
    }

    public function add_kawasan(){
        $jenis = $_POST['jenis_kawasan'];
        $luas = $_POST['luas'];
        // $ukuran = $_POST['ukuran'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $pjg = $_POST['pjg'];
        $lbr = $_POST['lbr'];
        $budget = $_POST['budget'];

        $check = $this->db->get_where('kawasan', array('nama'=>$jenis));

        if($check->num_rows() > 0){
            $this->session->set_flashdata('err_msg', "Data telah ada!");

            redirect('Dashboard/kawasan_management');
        } else {
            $data = array(
                'nama'=>$jenis,
                'luas'=>$luas,
                // 'ukuran'=>$ukuran
                'kode_perumahan'=>$kode_perumahan,
                'panjang'=>$pjg,
                'lebar'=>$lbr,
                'budget'=>$budget
            );

            $this->db->insert('kawasan', $data);

            $this->session->set_flashdata('succ_msg', "Data telah dimasukkan!");

            redirect('Dashboard/kawasan_management');
        }
    }

    public function view_edit_kawasan(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['check_all'] = $this->db->get('kawasan');
        $data['edit_kawasan'] = $this->db->get_where('kawasan', array('id_kawasan'=>$id));

        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('kawasan', $data);
    }

    public function edit_kawasan(){
        $id = $_POST['id'];
        $jenis = $_POST['jenis_kawasan'];
        $luas = $_POST['luas'];
        // $ukuran = $_POST['ukuran'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $pjg = $_POST['pjg'];
        $lbr = $_POST['lbr'];
        $budget = $_POST['budget'];

        $data = array(
            'nama'=>$jenis,
            'luas'=>$luas,
            // 'ukuran'=>$ukuran
            'kode_perumahan'=>$kode_perumahan,
            'panjang'=>$pjg,
            'lebar'=>$lbr,
            'budget'=>$budget
        );

        $this->db->update('kawasan', $data, array('id_kawasan'=>$id));

        $this->session->set_flashdata('succ_msg', "Data telah diperbarui!");

        redirect('Dashboard/view_edit_kawasan?id='.$id);
        
    }

    public function hapus_kawasan(){
        $id = $_GET['id'];

        $this->db->delete('kawasan', array('id_kawasan'=>$id));
        $this->session->set_flashdata('err_msg', "Data telah dihapus!");

        redirect('Dashboard/kawasan_management');
    }
    //END OF KAWASAN

    //START OF SPK
    public function view_spk_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();
        
        $this->load->view('produksi_spk_management_perumahan', $data);
    }

    public function spk_management(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('spk', array('kode_perumahan'=>$id));
        
        $check = $this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result();
        foreach($check as $row1){
            $data['k_perumahan'] = $row1->nama_perumahan;
        }

        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_spk_management', $data);
    }

    public function sign_spk_management(){
        // $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('spk', array('staff_sign'=>""));
        
        // $check = $this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result();
        // foreach($check as $row1){
        // }

        $data['k_perumahan'] = "";
        $data['id'] = "";

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_spk_management', $data);
    }

    public function view_add_spk_management(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('ppjb', array('kode_perumahan'=>$id, 'status'=>"dom", 'tipe_produk'=>"rumah"));

        $data['id'] = $id;

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['k_perumahan'] = $row->nama_perumahan;
        }

        $this->load->view('produksi_spk_add', $data);
    }

    public function spk_form(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('ppjb', array('id_psjb'=>$id));
        foreach($data['check_all']->result() as $row){
            $data['no_psjb'] = $row->no_psjb;
            $k_perumahan = $row->kode_perumahan;

            foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$k_perumahan))->result() as $rmh){
                $data['nama_perumahan'] = $rmh->nama_perumahan;
                $data['kode_perusahaan'] = $rmh->kode_perusahaan;
            }
        }

        $data['id'] = $id;

        $this->load->view('produksi_spk', $data);
    }

    public function add_spk(){
        $kode_perumahan = $_POST['kode'];
        $id_form = $_POST['id_form'];
        $id_ppjb = $_POST['id_ppjb'];

        $no_spk = $_POST['no_spk'];
        $no_unit = $_POST['no_unit'];
        $harga_jual = $_POST['harga_jual'];
        $luas_bangunan = $_POST['luas_bangunan'];
        $luas_tanah = $_POST['luas_tanah'];
        $upah = $_POST['upah'];
        $kontrak_pekerjaan = $_POST['kontrak_pekerjaan'];
        $masa_pelaksanaan = $_POST['masa_pelaksanaan'];
        $tgl_bast = $_POST['tgl_bast'];
        $tgl_akad = $_POST['tgl_akad'];

        $folderPath = "./gambar/signature/spk/";
  
        $image_parts = explode(";base64,", $_POST['signed']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik = 1;
        $this->db->order_by('owner_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get('spk')->result() as $row){
            $unik = $row->owner_sign;
            
            $str = $unik;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file = $folderPath .'a'. $unik . '.'.$image_type;
        
        if($image_parts[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='spk_form?id=$id_form';
                  </script>";
        } else {
            file_put_contents($file, $image_base64);
            // TES

            $data = array(
                'no_spk'=>$no_spk,
                'id_ppjb'=>$id_ppjb,
                'kode_perumahan'=>$kode_perumahan,
                'unit'=>$no_unit,
                'harga_unit'=>$harga_jual,
                'luas_bangunan'=>$luas_bangunan,
                'luas_tanah'=>$luas_tanah,
                'upah'=>$upah,
                'kontrak_pekerjaan'=>$kontrak_pekerjaan,
                'masa_pelaksanaan'=>$masa_pelaksanaan,
                'tgl_bast'=>$tgl_bast,
                'tgl_akad'=>$tgl_akad,
                'owner_sign'=>'a'.$unik.'.'.$image_type,
                'id_created_by'=>$this->session->userdata('u_id'),
                'created_by'=>$this->session->userdata('nama'),
                'date_by'=>date('Y-m-d H:i:sa am/pm')
            );

            $this->db->insert('spk', $data);

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan data!");

            redirect('Dashboard/spk_management?id='.$kode_perumahan);
        }
    }

    public function update_signature_spk(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];

        $folderPath = "./gambar/signature/spk/";
  
        $image_parts = explode(";base64,", $_POST['signed']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik = 1;
        $this->db->order_by('staff_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get('spk')->result() as $row){
            $unik = $row->owner_sign;
            
            $str = $unik;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file = $folderPath .'b'. $unik . '.'.$image_type;
        
        if($image_parts[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='spk_management?id=$kode';
                  </script>";
        } else {
            file_put_contents($file, $image_base64);
            // TES

            $data = array(
                'staff_sign'=>'b'.$unik.'.'.$image_type,
            );

            $this->db->update('spk', $data, array('id_spk'=>$id));

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses memperbarui data!");

            redirect('Dashboard/spk_management?id='.$kode);
        }
    }

    public function spk_detail(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['spk_detail'] = $this->db->get_where('spk', array('id_spk'=>$id));
        foreach($data['spk_detail']->result() as $row){
            foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $row1){
                $data['kode_perusahaan'] = $row1->kode_perusahaan;
            }
        }

        $data['id'] = $id;

        $this->load->view('produksi_spk_detail', $data);
    }

    public function view_revisi_spk(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_spk'] = $this->db->get_where('spk', array('id_spk'=>$id));
        foreach($data['edit_spk']->result() as $as){
            $data['check_all'] = $this->db->get_where('ppjb', array('id_psjb'=>$as->id_ppjb));
            foreach($data['check_all']->result() as $row){
                $data['no_psjb'] = $row->no_psjb;
                $k_perumahan = $row->kode_perumahan;
                $data['sistem_pembayaran'] = $row->sistem_pembayaran;

                foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$k_perumahan))->result() as $rmh){
                    $data['nama_perumahan'] = $rmh->nama_perumahan;
                    $data['kode_perusahaan'] = $rmh->kode_perusahaan;
                }
            }
        }

        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        
        $this->load->view('produksi_spk', $data);
    }

    public function revisi_spk(){
        $id = $_POST['id'];
        $no_spk = $_POST['no_spk'];
        $no_unit = $_POST['no_unit'];
        $harga_jual = $_POST['harga_jual'];
        $luas_bangunan = $_POST['luas_bangunan'];
        $luas_tanah = $_POST['luas_tanah'];
        $upah = $_POST['upah'];
        $kontrak_pekerjaan = $_POST['kontrak_pekerjaan'];
        $masa_pelaksanaan = $_POST['masa_pelaksanaan'];
        $tgl_bast = $_POST['tgl_bast'];
        $tgl_akad = $_POST['tgl_akad'];

        $data = array(
            // 'no_spk'=>$no_spk,
            // 'id_ppjb'=>$id_ppjb,
            // 'kode_perumahan'=>$kode_perumahan,
            // 'unit'=>$no_unit,
            // 'harga_unit'=>$harga_jual,
            'luas_bangunan'=>$luas_bangunan,
            'luas_tanah'=>$luas_tanah,
            'upah'=>$upah,
            'kontrak_pekerjaan'=>$kontrak_pekerjaan,
            'masa_pelaksanaan'=>$masa_pelaksanaan,
            'tgl_bast'=>$tgl_bast,
            'tgl_akad'=>$tgl_akad,
        );

        $this->db->update('spk', $data, array('id_spk'=>$id));

        $this->session->set_flashdata('succ_msg', "Data telah diperbarui!");

        redirect('Dashboard/view_revisi_spk?id='.$id);
    }

    public function print_spk(){
        $id = $_GET['id'];

        $data['check_all'] = $this->db->get_where('spk', array('id_spk'=>$id))->result();

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "print-spk.pdf";
        ob_end_clean();
        $this->pdf->load_view('produksi_spk_print', $data);
    }
    //END OF SPK

    //START OF KBK
    public function view_kbk_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();
        
        $this->load->view('produksi_kbk_management_perumahan', $data);
    }

    public function kbk_management(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('kbk', array('kode_perumahan'=>$id));
        
        $check = $this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result();
        foreach($check as $row1){
            $data['k_perumahan'] = $row1->nama_perumahan;
        }

        $data['id'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_kbk_management', $data);
    }

    public function f_kbk_management(){
        // $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('kbk', array('status'=>"menunggu"));
        
        // $check = $this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result();
        // foreach($check as $row1){
            $data['k_perumahan'] = "";
        // }

        $data['id'] = "";

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_kbk_management', $data);
    }

    public function view_add_kbk_management(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('spk', array('kode_perumahan'=>$id));

        $data['id'] = $id;

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['k_perumahan'] = $row->nama_perumahan;
        }

        $this->load->view('produksi_kbk_add', $data);
    }

    public function f_view_add_kbk_management(){
        // $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        // $query = $this->db->get('spk');
        $data['check_all'] = $this->db->get('spk');

        $data['id'] = "";
        $data['k_perumahan'] = "";

        // foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
        //     $data['k_perumahan'] = $row->nama_perumahan;
        // }

        $this->load->view('produksi_kbk_add', $data);
    }

    public function kbk_form(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('spk', array('id_spk'=>$id));
        foreach($data['check_all']->result() as $row){
            $data['no_spk'] = $row->no_spk;
            $k_perumahan = $row->kode_perumahan;

            foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$k_perumahan))->result() as $rmh){
                $data['nama_perumahan'] = $rmh->nama_perumahan;
                $data['kode_perusahaan'] = $rmh->kode_perusahaan;
            }

            foreach($this->db->get_where('ppjb', array('id_psjb'=>$row->id_ppjb))->result() as $ppjb){
                $data['sistem_pembayaran'] = $ppjb->sistem_pembayaran;
            }
        }

        $data['id'] = $id;

        $this->load->view('produksi_kbk_form', $data);
    }

    public function get_sub_kon(){
        $id = $_POST['country'];

        if(isset($_POST['country'])){
            foreach($this->db->get_where('sub_kon', array('id_sub_kon'=>$id))->result() as $row){
                echo '<div class="col-12 row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="'.$row->nama_sub.'" id="namaSub" placeholder="Nama Sub Kontraktor" name="sub_nama" required readonly>
                            </div>
                            <div class="form-group">
                                <label>KTP</label>
                                <input type="number" class="form-control" value="'.$row->ktp_sub.'" id="ktpSub" placeholder="No KTP" name="sub_ktp" required readonly>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="sub_alamat" id="alamatSub" placeholder="Alamat Sub Kontraktor" required readonly>'.$row->alamat_sub.'</textarea>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <input type="text" class="form-control" value="'.$row->pekerjaan_sub.'" id="pekerjaanSub" name="sub_pekerjaan" placeholder="Pekerjaan Sub Kontraktor" readonly required>
                            </div>
                        </div>
                    </div>';
            }
        }
        
    }

    public function add_kbk(){
        $kode_perumahan = $_POST['kode'];
        $id_form = $_POST['id_form'];
        $id_ppjb = $_POST['id_ppjb'];

        // $no_spk = $_POST['no_spk'];
        $dev_nama = $_POST['dev_nama'];
        $dev_ktp = $_POST['dev_ktp'];
        $dev_alamat = $_POST['dev_alamat'];
        $dev_pekerjaan = $_POST['dev_pekerjaan'];

        $sub_nama = $_POST['sub_nama'];
        $sub_ktp = $_POST['sub_ktp'];
        $sub_alamat = $_POST['sub_alamat'];
        $sub_pekerjaan = $_POST['sub_pekerjaan'];

        $tgl_mulai = $_POST['tgl_mulai'];
        $tgl_selesai = $_POST['tgl_selesai'];

        $no_unit = $_POST['no_unit'];
        $harga_jual = $_POST['harga_jual'];
        $luas_bangunan = $_POST['luas_bangunan'];
        $luas_tanah = $_POST['luas_tanah'];
        $upah = $_POST['upah'];
        $kontrak_pekerjaan = $_POST['kontrak_pekerjaan'];
        $masa_pelaksanaan = $_POST['masa_pelaksanaan'];
        $tgl_bast = $_POST['tgl_bast'];
        $tgl_akad = $_POST['tgl_akad'];

        $termin = $_POST['termin'];
        $opname = $_POST['opname'];
        $nilai_termin = $_POST['nilaitermin'];
        $total_termin = $_POST['total_termin'];

        $id_kbk = 1;
        $this->db->order_by('id_kbk', "DESC");
        $this->db->limit(1);
        foreach($this->db->get('kbk')->result() as $row){
            $id_kbk = $row->id_kbk + 1;
        }

        $no_kbk = 0;
        $this->db->order_by('no_kbk', "DESC");
        $this->db->limit(1);
        $this->db->where('kode_perumahan', $kode_perumahan);
        foreach($this->db->get('kbk')->result() as $row1){
            $no_kbk = $row1->no_kbk + 1;
        }

        if($total_termin != 0){
            echo "<script>
                    alert('Total pembayaran tidak 0!');
                    window.location.href='kbk_form?id=$id_form';
                  </script>";
        } else {
            $data = array(
                'id_kbk'=>$id_kbk,
                'no_kbk'=>$no_kbk,
                'id_spk'=>$id_form,
                'id_ppjb'=>$id_ppjb,
                'kode_perumahan'=>$kode_perumahan,
                'unit'=>$no_unit,
                'harga_unit'=>$harga_jual,
                'luas_bangunan'=>$luas_bangunan,
                'luas_tanah'=>$luas_tanah,
                'upah'=>$upah,
                'kontrak_pekerjaan'=>$kontrak_pekerjaan,
                'masa_pelaksanaan'=>$masa_pelaksanaan,
                'tgl_bast'=>$tgl_bast,
                'tgl_akad'=>$tgl_akad,
                'tgl_mulai'=>$tgl_mulai,
                'tgl_selesai'=>$tgl_selesai,
                'id_created_by'=>$this->session->userdata('u_id'),
                'created_by'=>$this->session->userdata('nama'),
                'date_by'=>date('Y-m-d H:i:sa am/pm'),
                'dev_nama'=>$dev_nama,
                'dev_ktp'=>$dev_ktp,
                'dev_alamat'=>$dev_alamat,
                'dev_pekerjaan'=>$dev_pekerjaan,
                'sub_nama'=>$sub_nama,
                'sub_ktp'=>$sub_ktp,
                'sub_alamat'=>$sub_alamat,
                'sub_pekerjaan'=>$sub_pekerjaan,
                'status'=>"menunggu"
            );

            $this->db->insert('kbk', $data);

            for($i = 0; $i < count($termin); $i++){
                $data1 = array(
                    'id_kbk'=>$id_kbk,
                    'tahap'=>$termin[$i],
                    'opname'=>$opname[$i],
                    'nilai_pembayaran'=>$nilai_termin[$i]
                );

                $this->db->insert('kbk_termin', $data1);
            }

            for($x = 0; $x < count(explode(",", $no_unit)); $x++){
                $data2 = array(
                    'mulai_proyek'=>$tgl_mulai,
                    'selesai_proyek'=>$tgl_selesai
                );

                // echo explode(",", $no_unit)[$x];
                // echo $kode_perumahan;
                $this->db->update('rumah', $data2, array('kode_rumah'=>explode(",", $no_unit)[$x], 'kode_perumahan'=>$kode_perumahan));
            }
            
            // exit;

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan data!");

            redirect('Dashboard/kbk_management?id='.$kode_perumahan);
        }
    }

    public function kbk_detail(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['spk_detail'] = $this->db->get_where('kbk', array('id_kbk'=>$id));
        foreach($data['spk_detail']->result() as $row){
            foreach($this->db->get_where('spk', array('id_spk'=>$row->id_spk, 'kode_perumahan'=>$row->kode_perumahan))->result() as $spk){
                $data['no_spk'] = $spk->no_spk;
            }
            foreach($this->db->get_where('ppjb', array('id_psjb'=>$row->id_ppjb))->result() as $row1){
                $data['kode_perusahaan'] = $row1->kode_perusahaan;
            }
        }

        $data['id'] = $id;

        $this->load->view('produksi_kbk_detail', $data);
    }

    public function kbk_approve(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data = array(
            'status'=>"approved",
            'owner_sign'=>"owner_sign.jpg",
            'id_signature_by_owner'=>$this->session->userdata('u_id'),
            'signature_by_owner'=>$this->session->userdata('nama'),
            'date_sign_owner'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('kbk', $data, array('id_kbk'=>$id));

        redirect('Dashboard/kbk_management?id='.$kode);
    }

    public function view_kbk_revisi(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['spk_detail'] = $this->db->get_where('kbk', array('id_kbk'=>$id));
        foreach($data['spk_detail']->result() as $row){
            foreach($this->db->get_where('spk', array('id_spk'=>$row->id_spk, 'kode_perumahan'=>$row->kode_perumahan))->result() as $spk){
                $data['no_spk'] = $spk->no_spk;
            }
            foreach($this->db->get_where('ppjb', array('id_psjb'=>$row->id_ppjb))->result() as $row1){
                $data['kode_perusahaan'] = $row1->kode_perusahaan;
            }
        }

        $data['id'] = $id;
        $data['edit_kbk'] = "";

        $this->load->view('produksi_kbk_detail', $data);
    }

    public function kbk_sendback(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $keterangan = $_POST['ket'];

        $data = array(
            'id_kbk'=>$id,
            'keterangan'=>$keterangan,
            'created_by'=>$this->session->userdata('nama'),
            'id_created_by'=>$this->session->userdata('u_id'),
            'date_by'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->insert('kbk_sendback', $data);

        $data1 = array(
            'status'=>"revisi"
        );
        
        $this->db->update('kbk', $data1, array('id_kbk'=>$id));

        // $this->db->delete('kbk_termin', array('id_kbk'=>$id));

        redirect('Dashboard/kbk_management?id='.$kode);
    }

    public function view_edit_revisi_kbk(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['edit_kbk'] = $this->db->get_where('kbk', array('id_kbk'=>$id));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;
        $data['kode'] = $kode;
        $data['no_spk'] = $id;

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
            foreach($this->db->get_where('perusahaan', array('kode_perusahaan'=>$row->kode_perusahaan))->result() as $row1){
                $data['kode_perusahaan'] = $row1->kode_perusahaan;
            }
        }

        foreach($data['edit_kbk']->result() as $ts){
            foreach($this->db->get_where('ppjb', array('id_psjb'=>$ts->id_ppjb))->result() as $row2){
                $data['sistem_pembayaran'] = $row2->sistem_pembayaran;
            }
        }

        $this->load->view('produksi_kbk_form', $data);
    }

    public function edit_kbk(){
        $id = $_POST['id_form'];
        $kode_perumahan = $_POST['kode'];

        // $no_spk = $_POST['no_spk'];
        $dev_nama = $_POST['dev_nama'];
        $dev_ktp = $_POST['dev_ktp'];
        $dev_alamat = $_POST['dev_alamat'];
        $dev_pekerjaan = $_POST['dev_pekerjaan'];

        $sub_nama = $_POST['sub_nama'];
        $sub_ktp = $_POST['sub_ktp'];
        $sub_alamat = $_POST['sub_alamat'];
        $sub_pekerjaan = $_POST['sub_pekerjaan'];

        $tgl_mulai = $_POST['tgl_mulai'];
        $tgl_selesai = $_POST['tgl_selesai'];

        $no_unit = $_POST['no_unit'];
        $harga_jual = $_POST['harga_jual'];
        $luas_bangunan = $_POST['luas_bangunan'];
        $luas_tanah = $_POST['luas_tanah'];
        $upah = $_POST['upah'];
        $kontrak_pekerjaan = $_POST['kontrak_pekerjaan'];
        $masa_pelaksanaan = $_POST['masa_pelaksanaan'];
        $tgl_bast = $_POST['tgl_bast'];
        $tgl_akad = $_POST['tgl_akad'];

        $termin = $_POST['termin'];
        $opname = $_POST['opname'];
        $nilai_termin = $_POST['nilaitermin'];
        $total_termin = $_POST['total_termin'];


        // print_r(array_filter($nilai_termin));
        // print_r(array_filter($termin, function($value) { return !is_null($value) && $value !== ''; })[0]);
        // echo count(array_filter($termin, function($value) { return !is_null($value) && $value !== ''; }));
        // exit;

        if($total_termin != 0){
            echo "<script>
                    alert('Total pembayaran tidak 0!');
                    window.location.href='view_edit_revisi_kbk?id=$id&kode=$kode_perumahan';
                  </script>";
        } else {
            $this->db->delete('kbk_termin', array('id_kbk'=>$id));

            $data = array(
                // 'id_kbk'=>$id_kbk,
                // 'no_kbk'=>$no_kbk,
                // 'id_spk'=>$id_form,
                // 'id_ppjb'=>$id_ppjb,
                // 'kode_perumahan'=>$kode_perumahan,
                'unit'=>$no_unit,
                'harga_unit'=>$harga_jual,
                'luas_bangunan'=>$luas_bangunan,
                'luas_tanah'=>$luas_tanah,
                'upah'=>$upah,
                'kontrak_pekerjaan'=>$kontrak_pekerjaan,
                'masa_pelaksanaan'=>$masa_pelaksanaan,
                'tgl_bast'=>$tgl_bast,
                'tgl_akad'=>$tgl_akad,
                'tgl_mulai'=>$tgl_mulai,
                'tgl_selesai'=>$tgl_selesai,
                'id_created_by'=>$this->session->userdata('u_id'),
                'created_by'=>$this->session->userdata('nama'),
                'date_by'=>date('Y-m-d H:i:sa am/pm'),
                'dev_nama'=>$dev_nama,
                'dev_ktp'=>$dev_ktp,
                'dev_alamat'=>$dev_alamat,
                'dev_pekerjaan'=>$dev_pekerjaan,
                'sub_nama'=>$sub_nama,
                'sub_ktp'=>$sub_ktp,
                'sub_alamat'=>$sub_alamat,
                'sub_pekerjaan'=>$sub_pekerjaan,
                'status'=>"menunggu"
            );

            $this->db->update('kbk', $data, array('id_kbk'=>$id));

            for($i = 0; $i < count(array_filter($termin, function($value) { return !is_null($value) && $value !== ''; })); $i++){
                $data1 = array(
                    'id_kbk'=>$id,
                    'tahap'=>array_filter($termin, function($value) { return !is_null($value) && $value !== ''; })[$i],
                    'opname'=>array_filter($opname, function($value) { return !is_null($value) && $value !== ''; })[$i],
                    'nilai_pembayaran'=>array_filter($nilai_termin, function($value) { return !is_null($value) && $value !== ''; })[$i]
                );

                $this->db->insert('kbk_termin', $data1);
            }

            for($x = 0; $x < count(explode(",", $no_unit)); $x++){
                $data2 = array(
                    'mulai_proyek'=>$tgl_mulai,
                    'selesai_proyek'=>$tgl_selesai
                );

                // echo explode(",", $no_unit)[$x];
                // echo $kode_perumahan;
                $this->db->update('rumah', $data2, array('kode_rumah'=>explode(",", $no_unit)[$x], 'kode_perumahan'=>$kode_perumahan));
            }

            $this->session->set_flashdata('succ_msg', "Data berhasil di perbarui!");
            redirect('Dashboard/kbk_management?id='.$kode_perumahan);

            // echo "Signature Uploaded Successfully.";
            // $this->session->set_flashdata('succ_msg', "Sukses menambahkan data!");

            // redirect('Dashboard/kbk_management?id='.$kode_perumahan);
        }
    }

    public function update_signature_kbk(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];

        $folderPath = "./gambar/signature/kbk/";
  
        $image_parts = explode(";base64,", $_POST['signed']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik=1;
        $this->db->order_by('sub_sign', "DESC");
        $this->db->limit(1);
        foreach($this->db->get('kbk')->result() as $row){
            $unik = $row->sub_sign + 1;
        }

        // $unik = uniqid();
        $file = $folderPath . $unik . '.'.$image_type;
        // TES
        $image_parts1 = explode(";base64,", $_POST['signed1']);
            
        $image_type_aux1 = explode("image/", $image_parts1[0]);
        
        $image_type1 = $image_type_aux1[1];
        
        $image_base641 = base64_decode($image_parts1[1]);
        
        // $unik1 = uniqid();
        $unik1 = $unik + 1;
        $file1 = $folderPath . $unik1 . '.'.$image_type1;
        // print_r(uniqid()); exit;
        
        if($image_parts[0] == "" || $image_parts1[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='kbk_management?id=$kode';
                  </script>";
        }
        else {
            file_put_contents($file, $image_base64);
            file_put_contents($file1, $image_base641);

            $data = array(
                'staff_sign'=>$unik.'.'.$image_type,
                'sub_sign'=>$unik1.'.'.$image_type1,
                'id_signature_by'=>$this->session->userdata('u_id'),
                'signature_by'=>$this->session->userdata('nama'),
                'date_sign'=>date('Y-m-d H:i:sa am/pm')
            );
    
            $this->db->update('kbk', $data, array('id_kbk'=>$id));
    
            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan tanda tangan!");
    
            redirect('Dashboard/kbk_management?id='.$kode);
        }
    }

    public function kbk_pencairan(){
        $id_termin = $_GET['id'];
        $id_kbk = $_GET['ids'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('kbk_termin', array('id_termin'=>$id_termin));
        foreach($data['check_all']->result() as $row){
            $data['tahap'] = $row->tahap;
            // $data['no_kbk'] = $row->no_kbk;
        }
        foreach($this->db->get_where('kbk', array('id_kbk'=>$id_kbk))->result() as $rows){
            $data['no_kbk'] = $rows->no_kbk;
            $data['no_unit'] = $rows->unit;
            $data['tipe_unit'] = $rows->luas_bangunan;
            $data['nama_kontraktor'] = $rows->sub_nama;
            // $data['luas']
        }
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode))->result() as $row1){
            $data['nama_perumahan'] = $row1->nama_perumahan;
        }

        $cair=0; $persen = 0;
        foreach($this->db->get_where('kbk_pencairan', array('id_termin'=>$id_termin))->result() as $row2){
            $cair = $cair + $row2->nominal;
            $persen = $persen + $row2->realisasi;
        }
        $data['cair'] = $cair;
        $data['persen'] = $persen;

        $data['id_termin'] = $id_termin;
        $data['id_kbk'] = $id_kbk;
        $data['kode'] = $kode;

        $this->load->view('produksi_kbk_pencairan', $data);
    }

    public function add_pencairan(){
        $id_termin = $_POST['id_termin'];
        $id_kbk = $_POST['id_kbk'];
        $kode_perumahan = $_POST['kode'];

        $sisa_pencairan = $_POST['sisa_pencairan'];
        $no_kbk = $_POST['no_kbk'];
        $no_unit = $_POST['no_unit'];
        $tipe_unit = $_POST['tipe_unit'];
        $tahap = $_POST['tahap'];
        $tgl = date('Y-m-d H:i:sa am/pm');
        $progress = $_POST['progress'];
        $realisasi = $_POST['realisasi'];
        $nominal = $_POST['nominal_pencairan'];
        $nama_kontraktor = $_POST['nama_kontraktor'];
        $keterangan = $_POST['keterangan'];
        
        $no_pencairan = 1;
        $this->db->order_by('no_pencairan', "DESC");
        $this->db->limit(1);
        foreach($this->db->get_where('kbk_pencairan', array('kode_perumahan'=>$kode_perumahan))->result() as $row){
            $no_pencairan = $row->no_pencairan + 1;
        }

        $awal = 0;
        foreach($this->db->get_where('kbk_termin', array('id_termin'=>$id_termin))->result() as $ters){
            $awal = $ters->nilai_pembayaran;
        }

        $akhir = 0; $ttl = 0; $ttl_awal = 0;
        $gt = $this->db->get_where('kbk_pencairan', array('id_termin'=>$id_termin));
        if($gt->num_rows() > 0){
            foreach($this->db->get_where('kbk_pencairan', array('id_termin'=>$id_termin))->result() as $row1){
                $ttl = $ttl + $row->nominal;
            }
            $ttl_awal = $awal - $ttl;
            $akhir = $ttl_awal - $ttl; 
        }
        else {
            $ttl_awal = $awal;
            $akhir = $awal - $nominal;
        }

        // echo $akhir;
        // exit;

        if($sisa_pencairan < 0){
            echo "<script>
                    alert('Tidak boleh melebihi nominal pencairan yang sesuai kontrak!');
                    window.location.href='kbk_pencairan?id=$id_termin&ids=$id_kbk&kode=$kode_perumahan';
                  </script>";
        } else {
            $data = array(
                'id_termin'=>$id_termin,
                'no_pencairan'=>$no_pencairan,
                'id_kbk'=>$id_kbk,
                'kode_perumahan'=>$kode_perumahan,
                'tgl_pencairan'=>$tgl,
                'kategori'=>"Upah borongan KBK",
                'no_kbk'=>$no_kbk,
                'tahap'=>$tahap,
                'no_unit'=>$no_unit,
                'tipe_unit'=>$tipe_unit,
                'progress'=>$progress,
                'realisasi'=>$realisasi,
                'nominal'=>$nominal,
                'status'=>"menunggu",
                'created_by'=>$this->session->userdata('nama'),
                'date_by'=>$tgl,
                'nama_kontraktor'=>$nama_kontraktor,
                'keterangan'=>$keterangan,
                'awal_nominal'=>$ttl_awal,
                'sisa_nominal'=>$akhir
            );  

            $this->db->insert('kbk_pencairan', $data);

            $this->session->set_flashdata('succ_msg', "Data sukses dimasukkan!");
            redirect('Dashboard/qc_form?id='.$id_termin.'&ids='.$id_kbk.'&kode='.$kode_perumahan);
        }
    }

    public function view_kbk_pencairan_dana_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('produksi_kbk_rekap_pencairan_perumahan', $data);
    }

    public function kbk_pencairan_dana_management(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata("nama");

        $data['check_all'] = $this->db->get_where('kbk_pencairan', array('kode_perumahan'=>$id));

        $data['kode'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_kbk_rekap_pencairan', $data);
    }

    public function f_kbk_pencairan_dana_management(){
        // $id = $_GET['id'];

        $data['nama'] = $this->session->userdata("nama");

        $data['check_all'] = $this->db->get_where('kbk_pencairan', array('status'=>"menunggu"));

        $data['kode'] = "";

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_kbk_rekap_pencairan', $data);
    }

    public function pelunasan_pencairan_kbk(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');

        //QR CODE
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='pencairan_kbk_'.$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_tanda_terima_pencairan?id=".$id; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
 
        // $data = array(
        //     'nim'       => $nim,
        //     'nama'      => $nama,
        //     'prodi'     => $prodi, 
        //     'qr_code'   => $image_name
        // );
        // $this->db->insert('mahasiswa',$data);

        $data = array(
            'status'=>"approved",
            'qr_code'=>$image_name
        );

        $this->db->update('kbk_pencairan', $data, array('id_pencairan'=>$id));

        redirect('Dashboard/kbk_pencairan_dana_management?id='.$kode);
    }

    public function hapus_pencairan_kbk(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $this->db->delete('kbk_pencairan', array('id_pencairan'=>$id));

        redirect('Dashboard/kbk_pencairan_dana_management?id='.$kode);
    }

    public function form_pembayaran_pencairan_kbk(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');

        $data['id'] = $id;
        $data['kode'] = $kode;

        $data['check_all'] = $this->db->get_where('kbk_pencairan', array('id_pencairan'=>$id));
        $data['bank'] = $this->db->get('bank')->result();
        
        foreach($data['check_all']->result() as $row){
            $data['no_kwitansi'] = "KBK-".$kode.$row->no_pencairan; 
            $data['penerima'] = $row->nama_kontraktor;
            $data['nilai_pengeluaran'] = $row->nominal;
            $data['keterangan'] = "Pencairan Upah borongan KBK No. ".$row->no_pencairan.", Rincian: ".$row->keterangan;
        }

        $this->load->view('produksi_kbk_form_pembayaran_pencairan', $data);
    }

    public function add_pencairan_nominal(){
        $id = $_POST['id'];

        $no_faktur = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $terima_oleh = $_POST['terima_oleh'];

        $kategori_pengeluaran = $_POST['kategori_pengeluaran'];
        $jenis_pengeluaran = $_POST['jenis_pengeluaran'];
        $keterangan = $_POST['keterangan_pengeluaran'];
        $jenis_pembayaran = "cash";
        $cara_pembayaran = $_POST['cara_pembayaran'];
        
        $tanggal_pengeluaran = $_POST['tgl_pengeluaran'];
        $nilai_pengeluaran = $_POST['nilai_pengeluaran'];
        // $sisa_pembayaran = $_POST['sisa_pembayaran'];

        $bank = $_POST['bank'];
        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date('Y-m-d');

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        // if($sisa_pembayaran < 0){
        //     echo "<script>
        //             alert('Nominal tidak boleh minus/<0!');
        //             window.location.href = 'pembayaran_pengajuan?id=$id';
        //           </script>";
        // } else {
        if($bank != ""){
            $data = array(
                'no_pengeluaran'=>$no_faktur,
                'kategori_pengeluaran'=>$kategori_pengeluaran,
                'jenis_pengeluaran'=>$jenis_pengeluaran,
                'kode_perumahan'=>$kode_perumahan,
                'terima_oleh'=>$terima_oleh,
                'keterangan'=>$keterangan,
                'jenis_pembayaran'=>$jenis_pembayaran,
                'cara_pembayaran'=>$cara_pembayaran,
                'nominal'=>$nilai_pengeluaran,
                'tgl_pembayaran'=>$tanggal_pengeluaran,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_created'=>$date_by,
                // 'file_name'=>$file_name
                // 'status'=>$status,
            );

            $this->db->insert('keuangan_pengeluaran', $data);
        } else {
            $data = array(
                'no_pengeluaran'=>$no_faktur,
                'kategori_pengeluaran'=>$kategori_pengeluaran,
                'jenis_pengeluaran'=>$jenis_pengeluaran,
                'kode_perumahan'=>$kode_perumahan,
                'terima_oleh'=>$terima_oleh,
                'keterangan'=>$keterangan,
                'jenis_pembayaran'=>$jenis_pembayaran,
                'cara_pembayaran'=>$cara_pembayaran,
                'nominal'=>$nilai_pengeluaran,
                'tgl_pembayaran'=>$tanggal_pengeluaran,
                // 'id_bank'=>$bank,
                // 'nama_bank'=>$nama_bank,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_created'=>$date_by,
                // 'file_name'=>$file_name
            );

            $this->db->insert('keuangan_pengeluaran', $data);
        }

        $this->session->set_flashdata('succ_msg', "Data telah ditambahkan!");
        redirect('Dashboard/kbk_pencairan_dana_management?id='.$kode_perumahan);
        // }
    }

    public function update_signature_tanda_terima_pencairan(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];

        $folderPath = "./gambar/signature/pencairan/";
  
        $image_parts = explode(";base64,", $_POST['signed']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik = 1;
        $this->db->order_by('tukang_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get('kbk_pencairan')->result() as $row){
            $unik = $row->tukang_sign;
            
            $str = $unik;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file = $folderPath . 'a'. $unik . '.'.$image_type;
        
        if($image_parts[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='kbk_pencairan_dana_management?id=$kode';
                  </script>";
        } else {
            file_put_contents($file, $image_base64);
            // TES

            $data = array(
                'tukang_sign'=>'a'.$unik.'.'.$image_type,
                // 'id_signature_by_owner'=>$this->session->userdata('u_id'),
                // 'signature_by_owner'=>$this->session->userdata('nama'),
                'tukang_sign_date'=>date('Y-m-d H:i:sa am/pm'),
            );

            $this->db->update('kbk_pencairan', $data, array('id_pencairan'=>$id));

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan tanda tangan!");

            redirect('Dashboard/kbk_pencairan_dana_management?id='.$kode);
        }
    }

    public function update_signature_tanda_terima_pencairan_borongan(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];

        $folderPath = "./gambar/signature/pencairan/";
  
        $image_parts = explode(";base64,", $_POST['signed1']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik = 1;
        $this->db->order_by('tukang_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get_where('kbk_pencairan_kontrak', array('jenis_kontrak'=>"borongan"))->result() as $row){
            $unik = $row->tukang_sign;
            
            $str = $unik;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file = $folderPath . 'b'. $unik . '.'.$image_type;
        
        if($image_parts[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='kbk_pencairan_dana_borongan_management';
                  </script>";
        } else {
            file_put_contents($file, $image_base64);
            // TES

            $data = array(
                'tukang_sign'=>'b'.$unik.'.'.$image_type,
                // 'id_signature_by_owner'=>$this->session->userdata('u_id'),
                // 'signature_by_owner'=>$this->session->userdata('nama'),
                'tukang_sign_date'=>date('Y-m-d H:i:sa am/pm'),
            );

            $this->db->update('kbk_pencairan_kontrak', $data, array('id_pencairan'=>$id));

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan tanda tangan!");

            redirect('Dashboard/kbk_pencairan_dana_borongan_management');
        }
    }

    public function update_signature_tanda_terima_pencairan_harian(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];

        $folderPath = "./gambar/signature/pencairan/";
  
        $image_parts = explode(";base64,", $_POST['signed1']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik = 1;
        $this->db->order_by('tukang_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get_where('kbk_pencairan_kontrak', array('jenis_kontrak'=>"harian"))->result() as $row){
            $unik = $row->tukang_sign;
            
            $str = $unik;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file = $folderPath . 'c'. $unik . '.'.$image_type;
        
        if($image_parts[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='kbk_pencairan_dana_harian_management';
                  </script>";
        } else {
            file_put_contents($file, $image_base64);
            // TES

            $data = array(
                'tukang_sign'=>'c'.$unik.'.'.$image_type,
                // 'id_signature_by_owner'=>$this->session->userdata('u_id'),
                // 'signature_by_owner'=>$this->session->userdata('nama'),
                'tukang_sign_date'=>date('Y-m-d H:i:sa am/pm'),
            );

            $this->db->update('kbk_pencairan_kontrak', $data, array('id_pencairan'=>$id));

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan tanda tangan!");

            redirect('Dashboard/kbk_pencairan_dana_harian_management');
        }
    }

    public function print_tanda_terima_pencairan(){
        $id = $_GET['id'];

        $data['check_all'] = $this->db->get_where('kbk_pencairan', array('id_pencairan'=>$id))->result();

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-tanda-terima-pencairan.pdf";
        ob_end_clean();
        $this->pdf->load_view('produksi_kbk_pencairan_print', $data);
    }

    public function print_kbk(){
        $id = $_GET['id'];

        $data['check_all'] = $this->db->get_where('kbk', array('id_kbk'=>$id))->result();

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "print-kbk.pdf";
        ob_end_clean();
        $this->pdf->load_view('produksi_kbk_print', $data);
    }
    //END OF KBK

    //START OF QC
    public function view_qc_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('produksi_qc_management_perumahan', $data);
    }

    public function qc_management(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');
        
        $data['check_all'] = $this->db->get_where('kbk', array('kode_perumahan'=>$id, 'status'=>"approved"));

        $data['id'] = $id;
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['k_perumahan'] = $row->nama_perumahan;
        }

        $this->load->view('produksi_qc_management', $data);
    }

    public function qc_detail(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');

        $data['qc_detail'] = $this->db->get_where('kbk', array('id_kbk'=>$id));

        foreach($data['qc_detail']->result() as $row){
            foreach($this->db->get_where('ppjb', array('id_psjb'=>$row->id_ppjb))->result() as $row1){
                $data['nama_konsumen'] = $row1->nama_pemesan;
            }
        }

        $data['id'] = $id;
        $data['kode'] = $kode;
        
        $this->load->view('produksi_qc_detail', $data);
    }

    public function qc_form(){
        $id = $_GET['id'];
        $id_kbk = $_GET['ids'];
        $kode = $_GET['kode'];

        $this->db->order_by('id_termin', "ASC");
        $data['check_all'] = $this->db->get_where('kbk_termin', array('id_termin'=>$id));
        
        foreach($this->db->get_where('kbk', array('id_kbk'=>$id_kbk))->result() as $row){
            $data['no_spk'] = $row->no_kbk;

            $data['no_unit'] = $row->unit;
            foreach($this->db->get_where('ppjb', array('id_psjb'=>$row->id_ppjb))->result() as $row1){
                $data['nama_konsumen'] = $row1->nama_pemesan;
            }
            $data['tgl_mulai'] = date('Y-m-d', strtotime($row->tgl_mulai));
            $data['tgl_selesai'] = date('Y-m-d', strtotime($row->tgl_selesai));
        }

        $data['id'] = $id;
        $data['id_kbk'] = $id_kbk;
        $data['kode'] = $kode;

        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $data['files'] = $this->db->get_where('kbk_qc_img', array('id_termin'=>$id));

        $this->load->view('produksi_qc_form', $data);
    }

    public function upload_foto_termin(){
        $id = $_GET['id'];
        // $ids = $_GET['ids'];
        // $kode = $_GET['kode'];

        $config['upload_path']   = FCPATH.'/gambar/termin/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
        $this->load->library('upload',$config);

        if($this->upload->do_upload('userfile')){
            $token=$this->input->post('token_foto');
            $nama=$this->upload->data('file_name');
            $this->db->insert('kbk_qc_img',array('id_termin'=>$id, 'file_name'=>$nama,'token'=>$token, 'created_by'=>$this->session->userdata('nama'), 'date_by'=>date('Y-m-d H:i:sa am/pm')));
        }
    }

    public function remove_file_termin(){
        //Ambil token foto
		$token=$this->input->post('token');
		
		$foto=$this->db->get_where('kbk_qc_img',array('token'=>$token));

		if($foto->num_rows()>0){
			$hasil=$foto->row();
			$nama_foto=$hasil->nama_foto;
			if(file_exists($file=FCPATH.'/gambar/termin/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('kbk_qc_img',array('token'=>$token));

        }
        
		echo "{}";
    }

    public function remove_foto_termin(){
        $id = $_GET['id'];
        $ids = $_GET['ids'];
        $kode = $_GET['kode'];
        $file = $_GET['file'];
        $id_img = $_GET['img'];

        unlink(FCPATH.'/gambar/termin/'.$file);
        $this->db->delete('kbk_qc_img', array('id_img'=>$id_img));

        redirect('Dashboard/qc_form?id='.$id.'&ids='.$ids.'&kode='.$kode);
    }

    public function remove_all_foto_termin(){
        $id = $_GET['id'];
        $ids = $_GET['ids'];
        $kode = $_GET['kode'];

        $query = $this->db->get_where('kbk_qc_img', array('id_termin'=>$id));
        foreach($query->result() as $row){
            unlink(FCPATH.'/gambar/termin/'.$row->file_name);
        }

        $this->db->delete('kbk_qc_img', array('id_termin'=>$id));

        redirect('Dashboard/qc_form?id='.$id.'&ids='.$ids.'&kode='.$kode);
    }

    public function progress_unit_marketing(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('kbk');

        $this->load->view('marketing_progress_unit', $data);
    }

    public function get_progress_unit(){
        $id = $_POST['country'];

        // print_r($id);
        if(isset($id)){
            echo '<link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
                  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
                  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">';
            echo "<style>
                    .row::after {
                        content: '';
                        clear: both;
                        display: table;
                    }
                  </style>";
            
            $query = $this->db->get_where('kbk_termin', array('id_kbk'=>$id));

            foreach($this->db->get_where('kbk', array('id_kbk'=>$id))->result() as $kbk){
                echo "<div>Unit: $kbk->unit</div>";
                echo "<div>Masa Kerja: $kbk->masa_pelaksanaan</div>";
                echo "<div>Mulai Kerja: $kbk->tgl_mulai</div>";
                echo "<div>Selesai Kerja: $kbk->tgl_selesai</div>";
            }
            $no=1;
            foreach($query->result() as $row){
                // echo "<div style='overflow-wrap: break-word'>";
                echo "<hr><span style='background-color: lightblue'>Progress ke-".$no."</span>";
                echo " (";
                if($row->tgl_mulai != "0000-00-00"){
                    echo date('d F Y', strtotime($row->tgl_mulai));
                }
                echo " - ";
                if($row->tgl_selesai != "0000-00-00"){
                    echo date('d F Y', strtotime($row->tgl_selesai));
                }
                echo ") Realisasi Progress: ".$row->realisasi_progress." %";
                echo "<br>";

                $query1 = $this->db->get_where('kbk_qc_img', array('id_termin'=>$row->id_termin));
                if($query1->num_rows() > 0){
                    echo "<span style='background-color: pink'>Foto progress di lapangan: (Klik foto untuk mengunduh)</span> <br>"; 
                }
                // echo "<table class='table'><td>";
                echo "<div class='row'>";
                foreach($query1->result() as $row1){
                    echo "<div style='float: left; width: 33.33%; padding: 5px'>";
                    // echo "<div class='row'>";
                    // echo "<div>";
                    echo "<a href='".base_url()."gambar/termin/".$row1->file_name."' download>";
                    echo "<img src='".base_url()."gambar/termin/".$row1->file_name."' style='width: 200px; height: 150px'>";
                    echo "</a>";
                    echo "</div>";
                }
                // echo "</td></table>";
                echo "</div> <hr>";
                // echo "</div>";
                // echo "<br><br>";
                $no++;
            }
        }
    }

    public function add_qc(){
        $termin = $_POST['termin'];
        $hasil = $_POST['hasil'];

        $opname = $_POST['opname'];
        $realisasi = $_POST['realisasi_progress'];
        $tgl_mulai = $_POST['tgl_mulai'];
        $tgl_selesai = $_POST['tgl_selesai'];

        $id_termin = $_POST['id_termin'];
        $id_kbk = $_POST['id_kbk'];
        $kode_perumahan = $_POST['kode'];

        // print_r(array_filter($termin));
        if($realisasi > $opname){
            echo "<script>
                    alert('Persen realisasi progress tidak boleh lebih besar dari yang ditentukan!');
                    window.location.href='qc_form?id=$id_termin&ids=$id_kbk&kode=$kode_perumahan';
                  </script>";
        } else {
            $data = array(
                'realisasi_progress'=>$realisasi,
                'tgl_mulai'=>$tgl_mulai,
                'tgl_selesai'=>$tgl_selesai
            );

            $this->db->update('kbk_termin', $data, array('id_termin'=>$id_termin));

            for($i = 0; $i <= count(array_filter($termin)); $i++){
                $temp = "";
                $temp2 = "";

                if(isset(array_filter($termin)[$i])){
                    $temp = array_filter($termin)[$i];
                    if(isset($hasil[$i])){
                        $temp2 = $hasil[$i];
                    }
                    echo $temp."-".$temp2;
                    
                    $data1 = array(
                        'id_termin'=>$id_termin,
                        'id_kbk'=>$id_kbk,
                        'jenis_pekerjaan'=>$temp,
                        'hasil_sesuai'=>$temp2,
                        'created_by'=>$this->session->userdata('nama'),
                        'date_by'=>date('Y-m-d H:i:sa am/pm')
                    );

                    $this->db->insert('kbk_qc', $data1);
                }
            }

            $this->session->set_flashdata('succ_msg', "Data telah sukses masuk!");

            redirect('Dashboard/qc_form?id='.$id_termin.'&ids='.$id_kbk.'&kode='.$kode_perumahan);
        }
    }

    public function edit_all_qc(){
        $id_termin = $_POST['id_termin'];
        $id_kbk = $_POST['id_kbk'];
        $kode_perumahan = $_POST['kode'];

        // $id_qc = $_POST['id_qc'];
        // $status = $_POST['status'];
        $termin = $_POST['termin'];
        $hasil = $_POST['hasil'];
        if(isset($_POST['app'])){
            $app = $_POST['app'];
        }

        // $opname = $_POST['opname'];
        // $realisasi = $_POST['realisasi_progress'];
        // $tgl_mulai = $_POST['tgl_mulai'];
        // $tgl_selesai = $_POST['tgl_selesai'];

        // if($realisasi > $opname){
        //     echo "<script>
        //             alert('Persen realisasi progress tidak boleh lebih besar dari yang ditentukan!');
        //             window.location.href='qc_management?id=$id_termin&ids=$id_kbk&kode=$kode_perumahan';
        //           </script>";
        // } else {
            // $data = array(
            //     'realisasi_progress'=>$realisasi,
            //     'tgl_mulai'=>$tgl_mulai,
            //     'tgl_selesai'=>$tgl_selesai
            // );

            // $this->db->update('kbk_termin', $data, array('id_termin'=>$id_termin));

            $this->db->delete('kbk_qc', array('id_kbk'=>$id_kbk[0]));

            for($i = 0; $i <= count(array_filter($termin)); $i++){
                $temp = "";
                $temp2 = "";
                $temp3 = "";

                if(isset(array_filter($termin)[$i])){
                    $temp = array_filter($termin)[$i];
                    if(isset($hasil[$i])){
                        $temp2 = $hasil[$i];
                        // $temp2 = isset($hasil[$i]) ? $hasil[$i] : 0 ;
                    }
                    if(isset($app[$i])){
                        $temp3 = $app[$i];
                    }
                    // if()
                    // echo $temp."-".$temp2;
                    // exit;
                    
                    $data1 = array(
                        'id_termin'=>$id_termin[$i],
                        'id_kbk'=>$id_kbk[$i],
                        'jenis_pekerjaan'=>$temp,
                        'hasil_sesuai'=>$temp2,
                        'status_approved'=>$temp3,
                        'created_by'=>$this->session->userdata('nama'),
                        'date_by'=>date('Y-m-d H:i:sa am/pm')
                    );

                    $this->db->insert('kbk_qc', $data1);
                }
            }
            // print_r($hasil);
            // exit;
            $this->session->set_flashdata('succ_msg', "Data telah diperbarui!");

            redirect('Dashboard/qc_management?id='.$kode_perumahan);
        // }
    }

    public function get_qc(){
        $id = $_POST['country'];
        $kode_perumahan = $_POST['kode'];

        if(isset($id)){
            $gt = $this->db->get_where('kbk_termin', array('id_kbk'=>$id));
            foreach($this->db->get_where('kbk', array('id_kbk'=>$id))->result() as $kbk){
                $id_kbk = $kbk->id_kbk;
                $kode_perumahan = $kbk->kode_perumahan;
            }

            echo "<table class='table table-bordered'>";
            echo "<thead>
                    <tr>
                        <th>Progress</th>
                        <th>QC</th>
                        <th>Approval</th>
                    </tr>
                  </thead>
                    ";
            $as = 0;
            $no = 1; 
            $this->db->order_by('id_termin', "ASC");
            foreach($gt->result() as $row){
                echo "<tr>";
                echo "<td style='background-color: lightblue'>$row->tahap</td><td>";
                echo "<a class='btn btn-outline-primary btn-flat btn-sm' href='".base_url()."Dashboard/kbk_pencairan?id=$row->id_termin&ids=$id_kbk&kode=$kode_perumahan'>Form Pencairan</a></td>";
                echo "<td><a class='btn btn-outline-primary btn-flat btn-sm' href='".base_url()."Dashboard/qc_form?id=$row->id_termin&ids=$id_kbk&kode=$kode_perumahan''>Detail Pencairan</a>";
                echo "Sisa Pencairan: ";
                $ttl = 0; foreach($this->db->get_where('kbk_pencairan', array('id_termin'=>$row->id_termin))->result() as $ters){
                    $ttl = $ttl + $ters->nominal;
                }
                echo "Rp. ".number_format($row->nilai_pembayaran - $ttl);
                echo "</td>";
                echo "</tr>";
                
                $this->db->order_by('id_qc', "ASC");
                foreach($this->db->get_where('kbk_qc', array('id_termin'=>$row->id_termin))->result() as $row1){
                    echo "<tr>";
                    echo "<td><input type='text' class='form-control' name='termin[]' value='$row1->jenis_pekerjaan'></td>";
                    echo "<td>
                            <input type='hidden' name='hasil[]' id='hasilOpnameHidden$no' class='form-control' value='";
                            if($row1->status_approved == "true"){echo "true";} else {echo "false";}
                            echo "' ";
                            if($row1->hasil_sesuai == 'true'){ echo 'disabled';}
                            echo ">";

                            echo "<input type='hidden' name='hasil[]' id='hasilOpnameHidden2$no' class='form-control' value='true' ";
                            if($row1->status_approved != "true"){ echo 'disabled';};
                            echo ">";

                            echo "<input type='checkbox' name='hasil[]' id='hasilOpname$no' class='form-control' value='true' ";
                            if($row1->status_approved == 'true'){echo 'disabled';} if($row1->hasil_sesuai == 'true'){ echo ' checked="true"';}
                            echo ">";

                            echo "<input type='hidden' name='id_termin[]' value='$row1->id_termin'>
                                  <input type='hidden' name='id_kbk[]' value='$row1->id_kbk'>
                                  <input type='hidden' name='kode' value='$kode_perumahan'";
                          echo "</td>";
                    
                    echo "<td>";
                    // echo "<input type='checkbox'";
                    echo "<input type='hidden' name='app[]' class='form-control' value='false' id='appOpnameHidden$no' ";
                    if($row1->status_approved == "true"){ echo "disabled";}
                    echo ">";

                    echo "<input type='checkbox' name='app[]' value='true' id='appOpname$no' class='form-control'";
                    if($row1->status_approved == "true"){echo "checked='true'";}
                    if($row1->hasil_sesuai == "false"){echo "disabled";}
                    echo ">";
                    echo "</td>";
                    
                    echo "</tr>";
                $no++; $as = $no;}
            }
            echo "</table>";
            echo "<input type='hidden' value='$no' id='hasil_chq'>";

            echo "<script type='text/javascript'>
                    $(function () {
                        var check = $('#hasil_chq').val();
                
                        for (var x = 1; x <= check; x++) {
                        (function (x) {
                            $('#hasilOpname'+x).on('click', function(){
                                if($('#hasilOpname'+x).prop('checked') == true){
                                    $('#hasilOpnameHidden'+x).attr('disabled', 'disabled');
                                } else {
                                    $('#hasilOpnameHidden'+x).removeAttr('disabled');
                                }
                            });
                            $('#appOpname'+x).on('click', function(){
                                if($('#appOpname'+x).prop('checked') == true){
                                    $('#appOpnameHidden'+x).attr('disabled', 'disabled');
                                    $('#hasilOpname'+x).attr('disabled', 'disabled');
                                    $('#hasilOpnameHidden2'+x).removeAttr('disabled');
                                } else {
                                    $('#appOpnameHidden'+x).removeAttr('disabled');
                                    $('#hasilOpname'+x).removeAttr('disabled');
                                    $('#hasilOpnameHidden2'+x).attr('disabled', 'disabled');
                                }
                            });
                        })(x);
                        }
                    });
                  </script>";
        }
    }

    public function edit_qc(){
        $id_termin = $_POST['id_termin'];
        $id_kbk = $_POST['id_kbk'];
        $kode_perumahan = $_POST['kode'];

        $id_qc = $_POST['id_qc'];
        // $status = $_POST['status'];
        $termin = $_POST['termin'];
        $hasil = $_POST['hasil'];
        if(isset($_POST['app'])){
            $app = $_POST['app'];
        }

        $opname = $_POST['opname'];
        $realisasi = $_POST['realisasi_progress'];
        $tgl_mulai = $_POST['tgl_mulai'];
        $tgl_selesai = $_POST['tgl_selesai'];

        if($realisasi > $opname){
            echo "<script>
                    alert('Persen realisasi progress tidak boleh lebih besar dari yang ditentukan!');
                    window.location.href='qc_form?id=$id_termin&ids=$id_kbk&kode=$kode_perumahan';
                  </script>";
        } else {
            $data = array(
                'realisasi_progress'=>$realisasi,
                'tgl_mulai'=>$tgl_mulai,
                'tgl_selesai'=>$tgl_selesai
            );

            $this->db->update('kbk_termin', $data, array('id_termin'=>$id_termin));

            $this->db->delete('kbk_qc', array('id_termin'=>$id_termin));

            for($i = 0; $i <= count(array_filter($termin)); $i++){
                $temp = "";
                $temp2 = "";
                $temp3 = "";

                if(isset(array_filter($termin)[$i])){
                    $temp = array_filter($termin)[$i];
                    if(isset($hasil[$i])){
                        $temp2 = $hasil[$i];
                        // $temp2 = isset($hasil[$i]) ? $hasil[$i] : 0 ;
                    }
                    if(isset($app[$i])){
                        $temp3 = $app[$i];
                    }
                    // if()
                    // echo $temp."-".$temp2;
                    // exit;
                    
                    $data1 = array(
                        'id_termin'=>$id_termin,
                        'id_kbk'=>$id_kbk,
                        'jenis_pekerjaan'=>$temp,
                        'hasil_sesuai'=>$temp2,
                        'status_approved'=>$temp3,
                        'created_by'=>$this->session->userdata('nama'),
                        'date_by'=>date('Y-m-d H:i:sa am/pm')
                    );

                    $this->db->insert('kbk_qc', $data1);
                }
            }
            // print_r($hasil);
            // exit;
            $this->session->set_flashdata('succ_msg', "Data telah diperbarui!");

            redirect('Dashboard/qc_form?id='.$id_termin.'&ids='.$id_kbk.'&kode='.$kode_perumahan);
        }
    }
    //END OF QC

    //START OF BAST SUBKONTRAKTOR KE DEVELOPER
    public function bast_sub_dev_management_perumahan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('produksi_bast_sub_dev_management_perumahan', $data);
    }

    public function bast_sub_dev_management(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('bast', array('kode_perumahan'=>$id, 'kategori'=>"SubDev"));

        $data['id'] = $id;
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $prmh){
            $data['k_perumahan']=$prmh->nama_perumahan;
        }

        $this->load->view('produksi_bast_sub_dev_management', $data);
    }

    public function view_add_bast_sub_dev(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['check_all'] = $this->db->get_where('kbk', array('kode_perumahan'=>$id));

        $this->load->view('produksi_bast_add_sub_dev', $data);
    }

    public function add_bast_sub_dev(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        // $query = $this->db->get_where('kbk', )
        $no_bast = 1;
        $this->db->order_by('no_bast', "DESC");
        $this->db->limit(1);
        foreach($this->db->get_where('bast', array('kode_perumahan'=>$kode))->result() as $row){
            $no_bast = $row->no_bast + 1;
        }

        foreach($this->db->get_where('kbk', array('id_kbk'=>$id))->result() as $row1){
            $no_kbk = $row1->no_kbk;
        }

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='bast_sub_dev_'.$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_bast_sub_dev?id=".$id; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $data = array(
            'id_kbk'=>$id,
            'no_bast'=>$no_bast,
            'no_kbk'=>$no_kbk,
            'kode_perumahan'=>$kode,
            'kategori'=>"SubDev",
            'created_by'=>$this->session->userdata('nama'),
            'date_by'=>date('Y-m-d H:i:sa am/pm'),
            'qr_code'=>$image_name
        );

        $this->db->insert('bast', $data);

        redirect('Dashboard/bast_sub_dev_management?id='.$kode);
    }

    public function hapus_bast_sub_dev(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        foreach($this->db->get_where('bast', array('id_bast'=>$id))->result() as $row){
            unlink("gambar/qr_code/".$row->qr_code);
        }

        $this->db->delete('bast', array('id_bast'=>$id));

        redirect('Dashboard/bast_sub_dev_management?id='.$kode);
    }

    public function print_bast_sub_dev(){
        $id = $_GET['id'];
        // $kode = $_GET['kode'];

        $data['check_all'] = $this->db->get_where('bast', array('id_bast'=>$id))->result();

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "print-bast-sub-dev.pdf";
        ob_end_clean();
        $this->pdf->load_view('produksi_bast_sub_dev_print', $data);
    }
    //END OF BAST

    //START OF BAST DEVELOPER KE KONSUMEN
    public function bast_dev_kon_management_perumahan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('produksi_bast_dev_kon_management_perumahan', $data);
    }

    public function bast_dev_kon_management(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('bast_konsumen', array('kode_perumahan'=>$id));
        // print_r($data['check_all']->result());
        // exit;

        $data['id'] = $id;
        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $prmh){
            $data['k_perumahan']=$prmh->nama_perumahan;
        }

        $this->load->view('produksi_bast_dev_kon_management', $data);
    }

    public function view_add_bast_dev_kon(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;

        $data['check_all'] = $this->db->get_where('bast', array('kode_perumahan'=>$id, 'kategori'=>"SubDev"));
        // print_r($data['check_all']->result());
        // exit;

        $this->load->view('produksi_bast_add_dev_kon', $data);
    }

    public function add_bast_dev_kon(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        // $query = $this->db->get_where('kbk', )
        $no_bast = 1;
        $this->db->order_by('no_bast', "DESC");
        $this->db->limit(1);
        foreach($this->db->get_where('bast_konsumen', array('kode_perumahan'=>$kode))->result() as $row){
            $no_bast = $row->no_bast + 1;
            // $no_kbk = $row->no_kbk;
        }

        foreach($this->db->get_where('bast', array('id_bast'=>$id))->result() as $row1){
            $no_kbk = $row1->no_kbk;
            $id_kbk = $row1->id_kbk;
        }

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='bast_dev_kon_'.$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_bast_sub_dev?id=".$id; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $data = array(
            'id_kbk'=>$id_kbk,
            'no_bast'=>$no_bast,
            'no_kbk'=>$no_kbk,
            'kode_perumahan'=>$kode,
            'kategori'=>"DevKon",
            'created_by'=>$this->session->userdata('nama'),
            'date_by'=>date('Y-m-d H:i:sa am/pm'),
            'qr_code'=>$image_name
        );

        $this->db->insert('bast_konsumen', $data);

        redirect('Dashboard/bast_dev_kon_management?id='.$kode);
    }

    public function hapus_bast_dev_kon(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        foreach($this->db->get_where('bast_konsumen', array('id_bast'=>$id))->result() as $row){
            unlink("gambar/qr_code/".$row->qr_code);
        }

        $this->db->delete('bast_konsumen', array('id_bast'=>$id));

        redirect('Dashboard/bast_dev_kon_management?id='.$kode);
    }

    public function print_bast_dev_kon(){
        $id = $_GET['id'];
        // $kode = $_GET['kode'];

        $data['check_all'] = $this->db->get_where('bast_konsumen', array('id_bast'=>$id))->result();

        foreach($data['check_all'] as $row){
            foreach($this->db->get_where('kbk', array('id_kbk'=>$row->id_kbk))->result() as $row1){
                foreach($this->db->get_where('ppjb', array('id_psjb'=>$row1->id_ppjb))->result() as $row2){
                    $data['nama_pemesan'] = $row2->nama_pemesan;
                    $data['pekerjaan'] = $row2->pekerjaan;
                    $data['alamat_rumah'] = $row2->alamat_lengkap;
                }
            }
        }

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "print-bast-dev-kon.pdf";
        ob_end_clean();
        $this->pdf->load_view('produksi_bast_dev_kon_print', $data);
    }
    //END OF BAST

    //START OF KONTRAK KERJA LAIN
    public function kontrak_management(){
        $data['nama'] = $this->session->userdata('nama');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $data['check_all'] = $this->db->get('kbk_kontrak_kerja');

        $this->load->view('kontrak_management', $data);
    }

    public function f_kontrak_management(){
        $data['nama'] = $this->session->userdata('nama');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $data['check_all'] = $this->db->get_where('kbk_kontrak_kerja', array('status'=>"menunggu"));

        $this->load->view('kontrak_management', $data);
    }

    public function filter_kontrak_management(){
        $kode_perumahan = $_POST['perumahan'];

        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        if($kode_perumahan != ""){
            $this->db->where('kode_perumahan', $kode_perumahan);
        }
        $data['check_all'] = $this->db->get('kbk_kontrak_kerja');

        $data['k_perumahan'] = $kode_perumahan;

        $this->load->view('kontrak_management', $data);
    }

    public function kontrak_form(){
        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('kontrak_form', $data);
    }

    public function get_tipe_unit(){
        $id = $_POST['country'];
        $kode = $_POST['kode'];

        foreach($this->db->get_where('kbk', array('unit'=>$id, 'kode_perumahan'=>$kode))->result() as $row){
            echo $row->luas_bangunan;
        }
    }

    public function get_check_unit(){
        $kat = $_POST['kat'];
        $id = $_POST['country'];
        $kode = $_POST['kode'];

        $query = $this->db->get_where('kbk_kontrak_kerja', array('no_unit'=>$id, 'kode_perumahan'=>$kode, 'kategori'=>$kat));

        if($kat == ""){
            echo "<span style='color: red'>Silahkan pilih kategori pekerjaan!</span>";
        } else if($id == ""){
            echo "<span style='color: red'>Silahkan pilih no unit!</span>";
        } else if($kode == ""){
            echo "<span style='color: red'>Silahkan pilih proyek!</span>";
        } else {
            if($query->num_rows() > 0){
                echo "<span style='color: red'>Unit ini telah didaftarkan!</span>";
            } else {
                echo "<span style='color: green'>Unit ini dapat didaftarkan!</span>";
            }
        }
    }

    public function add_kontrak_kerja(){
        $kategori = $_POST['kategori'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $unit = $_POST['unit'];
        $tipe_unit = $_POST['tipe_unit'];
        $nama_tukang = $_POST['nama_tukang'];
        $kontrak_pekerjaan = $_POST['kontrak_pekerjaan'];
        $nilai_jual = $_POST['nilai_jual'];
        $nilai_kontrak = $_POST['nilai_pekerjaan'];
        $masa_kerja = $_POST['masa_kerja'];
        $tgl_mulai = $_POST['tgl_mulai'];
        $tgl_selesai = $_POST['tgl_selesai'];

        $gt = $this->db->get_where('kbk_kontrak_kerja', array('kategori'=>$kategori, 'no_unit'=>$unit, 'kode_perumahan'=>$kode_perumahan, 'status <>'=>"batal"));
        // echo $gt->num_rows();
        // exit;

        $no_kontrak=1;
        $this->db->order_by('no_kontrak', "DESC");
        $this->db->limit(1);
        foreach($this->db->get_where('kbk_kontrak_kerja', array('kode_perumahan'=>$kode_perumahan))->result() as $row){
            $no_kontrak = $row->no_kontrak + 1;
        }

        // if($gt->num_rows() > 0){
        //     echo "<script>
        //             alert('Kategori & unit telah terdaftar');
        //             window.location.href='kontrak_form';
        //           </script>";
        // } else {
        $data = array(
            'no_kontrak'=>$no_kontrak,
            'kategori'=>$kategori,
            'kode_perumahan'=>$kode_perumahan,
            'no_unit'=>$unit,
            'type_unit'=>$tipe_unit,
            'nama_tukang'=>$nama_tukang,
            'harga_jual'=>$nilai_jual,
            'nilai_kontrak'=>$nilai_kontrak,
            'pekerjaan_ket'=>$kontrak_pekerjaan,
            'masa_kerja'=>$masa_kerja,
            'mulai_kerja'=>$tgl_mulai,
            'selesai_kerja'=>$tgl_selesai,
            'status'=>"menunggu",
            'created_by'=>$this->session->userdata('nama'),
            'date_by'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->insert('kbk_kontrak_kerja', $data);

        $this->session->set_flashdata('succ_msg', "Data berhasil ditambahkan!");

        redirect('Dashboard/kontrak_management');
        // }
    }

    public function detail_kontrak(){
        $id = $_GET['id'];
        
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$id));
        foreach($data['check_all']->result() as $row){
            $gt = $this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan));

            foreach($gt->result() as $row1){
                $data['nama_perumahan'] = $row1->nama_perumahan;
            }
        }

        $data['detail_pembayaran'] = $this->db->get_where('kbk_pencairan_kontrak', array('id_kontrak'=>$id));

        $this->load->view('kontrak_detail', $data);
    }

    public function approve_kontrak(){
        $id = $_GET['id'];

        $data = array(
            'status'=>"approved",
            'dev_sign'=>"owner_sign.jpg",
            'dev_sign_date'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('kbk_kontrak_kerja', $data, array('id_kontrak'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil disetujui!");
        
        redirect('Dashboard/kontrak_management');
    }

    public function view_sendback_kontrak(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['kontrak_sendback'] = $this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$id));

        $data['check_all'] = $this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$id));
        foreach($data['check_all']->result() as $row){
            $gt = $this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan));

            foreach($gt->result() as $row1){
                $data['nama_perumahan'] = $row1->nama_perumahan;
            }
        }

        $data['detail_pembayaran'] = $this->db->get_where('kbk_pencairan_kontrak', array('id_kontrak'=>$id));
        $data['id'] = $id;

        $this->load->view('kontrak_detail', $data);
    }

    public function sendback_kontrak_kerja(){
        $id = $_POST['id'];
        $ket = $_POST['ket'];

        $data = array(
            'id_kontrak'=>$id,
            'catatan'=>$ket,
            'created_by'=>$this->session->userdata('nama'),
            'date_by'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->insert('kbk_kontrak_kerja_sendback', $data);

        $data1 = array(
            'status'=>"revisi"
        );

        $this->db->update('kbk_kontrak_kerja', $data1, array('id_kontrak'=>$id));

        redirect('Dashboard/kontrak_management');
    }

    public function view_revisi_kontrak(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $data['edit_kontrak'] = $this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$id));

        $data['check_all'] = $this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$id));
        foreach($data['check_all']->result() as $row){
            $gt = $this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan));

            foreach($gt->result() as $row1){
                $data['nama_perumahan'] = $row1->nama_perumahan;
            }
        }

        $data['detail_pembayaran'] = $this->db->get_where('kbk_pencairan_kontrak', array('id_kontrak'=>$id));
        $data['id'] = $id;

        $this->load->view('kontrak_form', $data);
    }

    public function revisi_kontrak(){
        $id = $_POST['id'];
        $kategori = $_POST['kategori'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $unit = $_POST['unit'];
        $tipe_unit = $_POST['tipe_unit'];
        $nama_tukang = $_POST['nama_tukang'];
        $kontrak_pekerjaan = $_POST['kontrak_pekerjaan'];
        $nilai_kontrak = $_POST['nilai_pekerjaan'];
        $masa_kerja = $_POST['masa_kerja'];
        $tgl_mulai = $_POST['tgl_mulai'];
        $tgl_selesai = $_POST['tgl_selesai'];

        $gt = $this->db->get_where('kbk_kontrak_kerja', array('kategori'=>$kategori, 'no_unit'=>$unit, 'kode_perumahan'=>$kode_perumahan, 'status <>'=>"batal"));

        $no_kontrak=1;
        $this->db->order_by('no_kontrak', "DESC");
        $this->db->limit(1);
        foreach($this->db->get_where('kbk_kontrak_kerja', array('kategori'=>$kategori, 'kode_perumahan'=>$kode_perumahan, 'status <>'=>"batal"))->result() as $row){
            $no_kontrak = $row->no_kontrak + 1;
        }

        // if($gt->num_rows() > 0){
        //     echo "<script>
        //             alert('Kategori & unit telah terdaftar');
        //             window.location.href='kontrak_form';
        //           </script>";
        // } else {
        $data = array(
            // 'no_kontrak'=>$no_kontrak,
            // 'id_kbk'
            'kategori'=>$kategori,
            'kode_perumahan'=>$kode_perumahan,
            'no_unit'=>$unit,
            'type_unit'=>$tipe_unit,
            'nama_tukang'=>$nama_tukang,
            'nilai_kontrak'=>$nilai_kontrak,
            'pekerjaan_ket'=>$kontrak_pekerjaan,
            'masa_kerja'=>$masa_kerja,
            'mulai_kerja'=>$tgl_mulai,
            'selesai_kerja'=>$tgl_selesai,
            'status'=>"menunggu",
            // 'created_by'=>$this->session->userdata('nama'),
            // 'date_by'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('kbk_kontrak_kerja', $data);

        $this->session->set_flashdata('succ_msg', "Data berhasil direvisi!");

        redirect('Dashboard/kontrak_management');
        // }
    }

    public function batal_kontrak(){
        $id = $_GET['id'];

        $data = array(
            'status'=>"batal",
        );

        $this->db->update('kbk_kontrak_kerja', $data, array('id_kontrak'=>$id));

        $this->session->set_flashdata('succ_msg', "Data berhasil dibatalkan!");
        
        redirect('Dashboard/kontrak_management');
    }

    public function update_signature_kontrak(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];

        $folderPath = "./gambar/signature/kontrak_kerja/";
  
        $image_parts = explode(";base64,", $_POST['signed']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik=1;
        $this->db->order_by('manager_sign', "DESC");
        $this->db->limit(1);
        foreach($this->db->get('kbk_kontrak_kerja')->result() as $row){
            $unik = $row->manager_sign + 1;
        }

        // $unik = uniqid();
        $file = $folderPath . $unik . '.'.$image_type;
        // TES
        $image_parts1 = explode(";base64,", $_POST['signed1']);
            
        $image_type_aux1 = explode("image/", $image_parts1[0]);
        
        $image_type1 = $image_type_aux1[1];
        
        $image_base641 = base64_decode($image_parts1[1]);
        
        // $unik1 = uniqid();
        $unik1 = $unik + 1;
        $file1 = $folderPath . $unik1 . '.'.$image_type1;
        // print_r(uniqid()); exit;
        
        if($image_parts[0] == "" || $image_parts1[0] == ""){
            echo "<script>
                    alert('Tanda tangan tidak boleh kosong!');
                    window.location.href='kbk_management?id=$kode';
                  </script>";
        }
        else {
            file_put_contents($file, $image_base64);
            file_put_contents($file1, $image_base641);

            $data = array(
                'tukang_sign'=>$unik.'.'.$image_type,
                'manager_sign'=>$unik1.'.'.$image_type1,
                // 'id_signature_by'=>$this->session->userdata('u_id'),
                // 'signature_by'=>$this->session->userdata('nama'),
                'tukang_sign_date'=>date('Y-m-d H:i:sa am/pm'),
                'manager_sign_date'=>date('Y-m-d H:i:sa am/pm')
            );
    
            $this->db->update('kbk_kontrak_kerja', $data, array('id_kontrak'=>$id));
    
            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan tanda tangan!");
    
            redirect('Dashboard/kontrak_management');
        }
    }

    public function pengajuan_pembayaran_kontrak(){
        $id = $_GET['id'];

        $data['id'] = $id;
        $data['nama'] = $this->session->flashdata('nama');

        $data['check_all'] = $this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$id));

        $this->load->view('kontrak_pengajuan', $data);
    }

    public function add_pengajuan_borongan(){
        $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $no_unit = $_POST['no_unit'];
        $tipe_unit = $_POST['tipe_unit'];
        $nama_tukang = $_POST['nama_tukang'];
        $kategori = $_POST['kategori'];
        $keterangan = $_POST['keterangan'];
        $tgl_pencairan = $_POST['tgl'];
        $nominal_seharusnya = $_POST['harga_jual'];
        $nominal = $_POST['nominal'];
        $nominal_awal = $_POST['nominal_awal'];
        $nominal_akhir = $_POST['nominal_akhir'];
        $status = "menunggu";
        $created_by = $this->session->userdata('nama');
        $date_by = date('Y-m-d H:i:sa am/pm');
        $jenis = "borongan";
        $keterangan_utama = $_POST['tahap'];

        $no_pencairan = 1;
        $this->db->order_by('no_pencairan', "DESC");
        $this->db->limit(1);
        foreach($this->db->get_where('kbk_pencairan_kontrak', array('kode_perumahan'=>$kode_perumahan, 'jenis_kontrak'=>$jenis))->result() as $row){
            $no_pencairan = $row->no_pencairan + 1;
        }

        $data = array(
            'id_kontrak'=>$id,
            'no_pencairan'=>$no_pencairan,
            'kode_perumahan'=>$kode_perumahan,
            'tgl_pencairan'=>$tgl_pencairan,
            'kategori'=>$kategori,
            'keterangan'=>$keterangan,
            'nominal_seharusnya'=>$nominal_seharusnya,
            'nominal'=>$nominal,
            'awal_nominal'=>$nominal_awal,
            'akhir_nominal'=>$nominal_akhir,
            'status'=>$status,
            'created_by'=>$created_by,
            'date_by'=>$date_by,
            'jenis_kontrak'=>$jenis,
            'keterangan_utama'=>$keterangan_utama
        );

        $this->db->insert('kbk_pencairan_kontrak', $data);

        redirect('Dashboard/kontrak_management');
    }

    public function approve_pencairan_kontrak(){
        $id = $_GET['id'];
        $st = $_GET['st'];
        // $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');

        //QR CODE
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='pencairan_kbk_kontrak_'.$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_tanda_terima_pencairan_borongan?id=".$id; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
 
        // $data = array(
        //     'nim'       => $nim,
        //     'nama'      => $nama,
        //     'prodi'     => $prodi, 
        //     'qr_code'   => $image_name
        // );
        // $this->db->insert('mahasiswa',$data);

        $data = array(
            'status'=>"approved",
            'qr_code'=>$image_name
        );

        $this->db->update('kbk_pencairan_kontrak', $data, array('id_pencairan'=>$id));

        if($st == "borongan"){
            redirect('Dashboard/kbk_pencairan_dana_borongan_management');
        } else {
            redirect('Dashboard/kbk_pencairan_dana_harian_management');
        }
    }

    public function hapus_pencairan_kbk_kontrak(){
        $id = $_GET['id'];
        $st = $_GET['st'];
        // $kode = $_GET['kode'];

        $this->db->delete('kbk_pencairan_kontrak', array('id_pencairan'=>$id));

        if($st == "borongan"){
            redirect('Dashboard/kbk_pencairan_dana_borongan_management');
        } else {
            redirect('Dashboard/kbk_pencairan_dana_harian_management');
        }
    }

    public function form_pembayaran_pencairan_kbk_kontrak(){
        $id = $_GET['id'];
        $st = $_GET['st'];
        // $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');

        $data['id'] = $id;
        $data['st'] = $st;
        // $data['kode'] = $kode;

        $data['check_all'] = $this->db->get_where('kbk_pencairan_kontrak', array('id_pencairan'=>$id));
        $data['bank'] = $this->db->get('bank')->result();
        
        if($st == "borongan"){
            foreach($data['check_all']->result() as $row){
                $data['no_kwitansi'] = "KBK-KK-".$row->kode_perumahan.$row->no_pencairan; 
                $data['nilai_pengeluaran'] = $row->nominal;
                $data['keterangan'] = "Pencairan Upah borongan ".$row->kategori." No. ".$row->no_pencairan.", Rincian: ".$row->keterangan;
                $data['kode'] = $row->kode_perumahan;
    
                foreach($this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$row->id_kontrak))->result() as $row1){
                    $data['penerima'] = $row1->nama_tukang;
                }
            }
        } else {
            foreach($data['check_all']->result() as $row){
                $data['no_kwitansi'] = "KBK-H-".$row->kode_perumahan.$row->no_pencairan; 
                $data['nilai_pengeluaran'] = $row->total;
                $data['keterangan'] = "Pencairan Upah borongan ".$row->kategori." No. ".$row->no_pencairan.", Rincian: ".$row->keterangan;
                $data['kode'] = $row->kode_perumahan;
                $data['penerima'] = $row->nama_tukang;
            }
        }

        $this->load->view('kontrak_form_pembayaran_pencairan', $data);
    }

    public function add_pencairan_nominal_kontrak(){
        // $id = $_POST['id'];
        $st = $_POST['st'];
        $no_faktur = $_POST['no_kwitansi'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $terima_oleh = $_POST['terima_oleh'];

        $kategori_pengeluaran = $_POST['kategori_pengeluaran'];
        $jenis_pengeluaran = $_POST['jenis_pengeluaran'];
        $keterangan = $_POST['keterangan_pengeluaran'];
        $jenis_pembayaran = "cash";
        $cara_pembayaran = $_POST['cara_pembayaran'];
        
        $tanggal_pengeluaran = $_POST['tgl_pengeluaran'];
        $nilai_pengeluaran = $_POST['nilai_pengeluaran'];
        // $sisa_pembayaran = $_POST['sisa_pembayaran'];

        $bank = $_POST['bank'];
        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date('Y-m-d');

        if($bank != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        // if($sisa_pembayaran < 0){
        //     echo "<script>
        //             alert('Nominal tidak boleh minus/<0!');
        //             window.location.href = 'pembayaran_pengajuan?id=$id';
        //           </script>";
        // } else {
        if($bank != ""){
            $data = array(
                'no_pengeluaran'=>$no_faktur,
                'kategori_pengeluaran'=>$kategori_pengeluaran,
                'jenis_pengeluaran'=>$jenis_pengeluaran,
                'kode_perumahan'=>$kode_perumahan,
                'terima_oleh'=>$terima_oleh,
                'keterangan'=>$keterangan,
                'jenis_pembayaran'=>$jenis_pembayaran,
                'cara_pembayaran'=>$cara_pembayaran,
                'nominal'=>$nilai_pengeluaran,
                'tgl_pembayaran'=>$tanggal_pengeluaran,
                'id_bank'=>$bank,
                'nama_bank'=>$nama_bank,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_created'=>$date_by,
                // 'file_name'=>$file_name
                // 'status'=>$status,
            );

            $this->db->insert('keuangan_pengeluaran', $data);
        } else {
            $data = array(
                'no_pengeluaran'=>$no_faktur,
                'kategori_pengeluaran'=>$kategori_pengeluaran,
                'jenis_pengeluaran'=>$jenis_pengeluaran,
                'kode_perumahan'=>$kode_perumahan,
                'terima_oleh'=>$terima_oleh,
                'keterangan'=>$keterangan,
                'jenis_pembayaran'=>$jenis_pembayaran,
                'cara_pembayaran'=>$cara_pembayaran,
                'nominal'=>$nilai_pengeluaran,
                'tgl_pembayaran'=>$tanggal_pengeluaran,
                // 'id_bank'=>$bank,
                // 'nama_bank'=>$nama_bank,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_created'=>$date_by,
                // 'file_name'=>$file_name
            );

            $this->db->insert('keuangan_pengeluaran', $data);
        }

        $this->session->set_flashdata('succ_msg', "Data telah ditambahkan!");

        if($st == "borongan"){
            redirect('Dashboard/kbk_pencairan_dana_borongan_management');
        } else {
            redirect('Dashboard/kbk_pencairan_dana_harian_management');
        }
        // }
    }

    public function kbk_pencairan_dana_borongan_management(){
        // $id = $_GET['id'];

        $data['nama'] = $this->session->userdata("nama");

        $data['check_all'] = $this->db->get_where('kbk_pencairan_kontrak', array('jenis_kontrak'=>"borongan"));

        $data['st'] = "Borongan";

        // $data['kode'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_kbk_rekap_pencairan_borongan', $data);
    }

    public function f_kbk_pencairan_dana_borongan_management(){
        // $id = $_GET['id'];

        $data['nama'] = $this->session->userdata("nama");

        $data['check_all'] = $this->db->get_where('kbk_pencairan_kontrak', array('jenis_kontrak'=>"borongan", 'status'=>"menunggu"));

        $data['st'] = "Borongan";

        // $data['kode'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_kbk_rekap_pencairan_borongan', $data);
    }

    public function filter_kbk_pencairan_dana_management_borongan(){
        $kode_perumahan = $_POST['perumahan'];
        $kategori = $_POST['kategori'];
        // $tgl_awal = 
        $data['st'] = "Borongan";

        $data['nama'] = $this->session->userdata('nama');

        if($kode_perumahan != ""){
            $this->db->where('kode_perumahan', $kode_perumahan);
        }
        if($kategori != ""){
            $this->db->where('kategori', $kategori);
        }
        $this->db->where('jenis_kontrak', "borongan");
        $data['check_all'] = $this->db->get('kbk_pencairan_kontrak');
        // $data['check_all'] = $this->Dashboard_model->filter_kbk_pencairan_dana_management_borongan($kode_perumahan, $kategori, $data['st']);

        $data['kode_perumahan'] = $kode_perumahan;
        $data['kategori'] = $kategori;

        $this->load->view('produksi_kbk_rekap_pencairan_borongan', $data);
    }

    public function kbk_pencairan_dana_harian_management(){
        // $id = $_GET['id'];

        $data['nama'] = $this->session->userdata("nama");

        $data['check_all'] = $this->db->get_where('kbk_pencairan_kontrak', array('jenis_kontrak'=>"harian"));
        $data['st'] = "Harian";

        // $data['kode'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_kbk_rekap_pencairan_borongan', $data);
    }

    public function f_kbk_pencairan_dana_harian_management(){
        // $id = $_GET['id'];

        $data['nama'] = $this->session->userdata("nama");

        $data['check_all'] = $this->db->get_where('kbk_pencairan_kontrak', array('jenis_kontrak'=>"harian", 'status'=>"menunggu"));

        $data['st'] = "Harian";

        // $data['kode'] = $id;

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('produksi_kbk_rekap_pencairan_borongan', $data);
    }

    public function filter_kbk_pencairan_dana_management_harian(){
        $kode_perumahan = $_POST['perumahan'];
        $kategori = $_POST['kategori'];
        // $tgl_awal = 
        $data['st'] = "Harian";

        $data['nama'] = $this->session->userdata('nama');

        if($kode_perumahan != ""){
            $this->db->where('kode_perumahan', $kode_perumahan);
        }
        if($kategori != ""){
            $this->db->where('kategori', $kategori);
        }
        $this->db->where('jenis_kontrak', "harian");
        $data['check_all'] = $this->db->get('kbk_pencairan_kontrak');
        // $data['check_all'] = $this->Dashboard_model->filter_kbk_pencairan_dana_management_borongan($kode_perumahan, $kategori, $data['st']);

        $data['kode_perumahan'] = $kode_perumahan;
        $data['kategori'] = $kategori;

        $this->load->view('produksi_kbk_rekap_pencairan_borongan', $data);
    }

    public function form_kontrak_harian(){
        $data['nama'] = $this->session->userdata('nama');

        $data['date'] = date('Y-m-d');

        $this->load->view('kontrak_form_harian', $data);
    }

    public function add_kontrak_kerja_harian(){
        // $id = $_POST['id'];
        $kode_perumahan = $_POST['kode_perumahan'];
        // $no_unit = $_POST['no_unit'];
        // $tipe_unit = $_POST['tipe_unit'];
        $nama_tukang = $_POST['nama_tukang'];
        // $kategori = $_POST['kategori'];
        $keterangan = $_POST['kontrak_pekerjaan'];
        $tgl_pencairan = $_POST['tgl'];
        // $nominal_seharusnya = $_POST['harga_jual'];
        // $nominal = $_POST['nominal'];
        // $nominal_awal = $_POST['nominal_awal'];
        // $nominal_akhir = $_POST['nominal_akhir'];
        $upah = $_POST['upah'];
        $masa_kerja = $_POST['masa_kerja'];
        $lembur = $_POST['lembur'];
        $total = $_POST['total'];
        $status = "menunggu";
        $created_by = $this->session->userdata('nama');
        $date_by = date('Y-m-d H:i:sa am/pm');
        $jenis = "harian";
        $kategori = $_POST['kategori'];
        $unit = $_POST['unit'];

        // echo $lembur;
        // exit;

        $no_pencairan = 1;
        $this->db->order_by('no_pencairan', "DESC");
        $this->db->limit(1);
        foreach($this->db->get_where('kbk_pencairan_kontrak', array('kode_perumahan'=>$kode_perumahan, 'jenis_kontrak'=>$jenis))->result() as $row){
            $no_pencairan = $row->no_pencairan + 1;
        }

        $data = array(
            // 'id_kontrak'=>$id,/
            'no_pencairan'=>$no_pencairan,
            'kode_perumahan'=>$kode_perumahan,
            'nama_tukang'=>$nama_tukang,
            'tgl_pencairan'=>$tgl_pencairan,
            'keterangan_utama'=>$keterangan,
            'status'=>$status,
            'created_by'=>$created_by,
            'date_by'=>$date_by,
            'jenis_kontrak'=>$jenis,
            'upah'=>$upah,
            'masa_kerja'=>$masa_kerja,
            'lembur'=>$lembur,
            'total'=>$total,
            'kategori'=>$kategori,
            'keterangan'=>$unit
        );

        $this->db->insert('kbk_pencairan_kontrak', $data);

        redirect('Dashboard/kbk_pencairan_dana_harian_management');
    }

    // public function form_pencairan_dana_harian(){
    //     $data['nama'] = $this->session->userdata('nama');

    //     $this->load->view('kontrak_form_pembayaran_pencairan_harian', $data);
    // }

    // public function add_pencairan_nominal_kontrak_harian(){
    //     $data['nama'] = $this->session->userdata('nama');

    //     $this->session->set_flashdata('succ_msg', "Data telah ditambahkan!");

    //     redirect('Dashboard/kbk_pencairan_dana_harian_management');
    // }

    public function print_tanda_terima_pencairan_kontrak(){
        $id = $_GET['id'];
        $st = $_GET['st'];

        // echo $st;
        // exit;
        $data['st'] = $st;

        $data['check_all'] = $this->db->get_where('kbk_pencairan_kontrak', array('id_pencairan'=>$id))->result();

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "print-tanda-terima-pencairan.pdf";
        ob_end_clean();
        $this->pdf->load_view('kontrak_kbk_pencairan_print', $data);
    }

    public function print_kontrak_kerja(){
        $id = $_GET['id'];

        $data['check_all'] = $this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$id))->result();

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "print-kontrak.pdf";
        ob_end_clean();
        $this->pdf->load_view('kontrak_print', $data);
    }
    //END OF KONTRAK KERJA LAIN

    public function tambahan_bangunan_management(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->group_by('no_unit');
        $this->db->group_by('kode_perumahan');
        $data['check_all'] = $this->db->get_where('kbk_kontrak_kerja', array('kategori'=>"tambahanbangunan", 'status <>'=>"batal"));

        $this->load->view('kontrak_tambahan_bangunan', $data);
    }

    public function filter_tambahan_bangunan_management(){
        $perumahan = $_POST['perumahan'];
        
        $data['nama'] = $this->session->userdata('nama');

        $this->db->group_by('no_unit');
        $this->db->group_by('kode_perumahan');
        if($perumahan != ""){
            $this->db->where('kode_perumahan', $perumahan);
        }
        $data['check_all'] = $this->db->get_where('kbk_kontrak_kerja', array('kategori'=>"tambahanbangunan", 'status <>'=>"batal"));

        $data['k_perumahan'] = $perumahan;

        $this->load->view('kontrak_tambahan_bangunan', $data);
    }

    public function print_kontrak_tambahan_bangunan(){
        $unit = $_GET['id'];
        $kode_perumahan = $_GET['kode'];
        
        $this->db->group_by('no_unit');
        $this->db->group_by('kode_perumahan');
        $data['check_all'] = $this->db->get_where('kbk_kontrak_kerja', array('kategori'=>"tambahanbangunan", 'status <>'=>"batal", 'kode_perumahan'=>$kode_perumahan, 'no_unit'=>$unit))->result();
        // print_r($data['check_all']);
        // exit;

        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "print-kontrak-tambahan-bangunan.pdf";
        ob_end_clean();
        $this->pdf->load_view('kontrak_tambahan_bangunan_print', $data);
    }

    //START OF KAVLING
    public function kavling_management(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('ppjb', array('tipe_produk'=>"kavling"));

        $this->load->view('kavling_management', $data);
    }

    public function filter_kavling_management(){
        $kode = $_POST['perumahan'];

        if($kode == ""){
            $data['check_all'] = $this->db->get('ppjb');
        } else {
            $data['check_all'] = $this->db->get_where('ppjb', array('kode_perumahan'=>$kode, 'tipe_produk'=>"kavling"));
        }

        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $kode;

        $this->load->view('kavling_management', $data);
    }
    
    public function kavling(){
        $data['nama'] = $this->session->userdata('nama');

        $data['role'] = $this->session->userdata('role');

        $this->load->view('kavling', $data);
    }

    public function get_psjb_kavling(){
        $category = $_POST["country"];

        // Define country and city array
        $this->db->order_by('kode_rumah', 'ASC');
        $query = $this->db->get_where('rumah', array('kode_perumahan'=>$category, 'tipe_produk'=>"kavling", 'status'=>"free"))->result();

        // Display city dropdown based on country name
        if($category !== 'Select'){
            // echo "<label>City:</label>";
            // echo "<select>";
            // echo "<option value='' disabled selected>-Pilih-</option>";
            foreach($query as $value){
                echo "<input type='checkbox' name='id_kavling[]' value=".$value->kode_rumah.">"." ".$value->kode_rumah."-".$value->nama_perumahan." <br>";
            }
            // echo "</select>";
        } 
    }
    
    public function get_kavling_kav(){
        $category_id = $this->input->post('id_kavling',TRUE);
        $kode_perumahan = $this->input->post('kode_perumahan',TRUE);

        // print_r($category_id);
        // print_r($kode_perumahan);
        // exit;

        // $result = $_POST['id_kavling'];
        // $result_explode = explode('|', $result);
        $t_luas = 0; $t_tanah=0; $t_tipe=0; $t_harga=0;
        for($i=0; $i < count($category_id); $i++){
            $tes = $category_id[$i];

            $q1 = $this->Dashboard_model->get_kavling($category_id[$i], $kode_perumahan);
            foreach($q1 as $row1){
                // $t_luas = $t_luas + $row1->luas_bangunan;
                $t_tanah = $t_tanah + $row1->luas_tanah;
                // $t_tipe = $t_tipe + $row1->tipe_rumah;
                $t_harga = $t_harga + $row1->harga_jual;
            }
        }
        $data['luas_bangunan'] = $t_luas;
        $data['luas_tanah'] = $t_tanah;
        $data['tipe_rumah'] = $t_tipe;
        $data['harga_jual'] = $t_harga;

        // echo $data['kavling'];
        $no_kavling = $category_id;
        $kode_perumahan = $kode_perumahan;

        // print_r($category_id);
        // exit;

        $q = $this->Dashboard_model->get_kavling($tes, $kode_perumahan);
        foreach($q as $row){
            $data['kode_perusahaan'] = $row->nama_perusahaan;
            $data['tipe_produk'] = $row->tipe_produk;
            $data['nama_perumahan'] = $row->nama_perumahan;
        }
        $data['kavling'] = $no_kavling;

        // print_r($data['kavling']);
        // // echo $no_kavling;
        // exit;

        $data['nama'] = $this->session->userdata('nama');

        $data['u_id'] = $this->session->userdata('u_id');

        $data['role'] = $this->session->userdata('role');

        $data['check_all'] = $this->db->get('rumah');

        $data['no_kavling'] = $no_kavling;

        $data['kode_perumahan'] = $kode_perumahan;

        $this->load->view('kavling', $data);

        // echo json_encode($data);
    }

    public function generate_form_angsuran_kavling(){
        $count = $_POST['country'];

        if(isset($count)){
            $no = 2; $ct = 1;

            for($i = 0; $i < $count; $i++){
                echo "<tr>";
                echo "<td>$no</td>";
                echo "<td><input type='text' class='form-control' value='Angsuran ke-$ct' name='tahap[]' required/></td>";
                echo "<td><input type='date' class='form-control' id='tglPembayaran' value='' name='tgl_pembayaran[]' required/></td>";
                echo "<td></td>";
                echo "<td><input type='number' class='form-control' id='nominalPembayaran$i' value='0' name='nominal_pembayaran[]' required/></td>";
                echo "</tr>";

                $no++; $ct++;
            }
                
            echo "<td><input type='hidden' id='chq_all' value='$count'></td>";

            echo "<script type='text/javascript'>
                    $('input[id^='nominalPembayaran']').on('blur', function(){
                        alert('A');
                    })
                </script>";
        }
    }

    public function add_kavling(){
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $sistem_pembayaran = $_POST['cara_pembayaran'];
        $nama_marketing = $_POST['nama_marketing'];
        $tgl_psjb = date("Y-m-d");
        $nama_pemesan = $_POST['nama_pemesan'];
        $nama_sertif = $_POST['nama_sertif'];
        $alamat_lengkap = $_POST['alamat_lengkap'];
        $alamat_surat = $_POST['alamat_surat'];
        $telp_rumah = $_POST['no_telp'];
        $telp_hp = $_POST['no_hp'];
        $ktp = $_POST['ktp'];
        $uang_awal = $_POST['uang_awal'];
        $perumahan = $_POST['nama_perumahan'];
        $kavling = $_POST['id_kavling'];
        // $tipe_rumah = $_POST['tipe_standart'];
        $harga_jual = $_POST['harga_jual_standart'];
        $disc_jual = $_POST['diskon_penjualan'];
        $total_jual = $_POST['total_penjualan'];
        $created_by = $this->session->userdata('nama');
        $created_by_id = $this->session->userdata('u_id');
        $role = $this->session->userdata('role');
        $date_by = date("Y-m-d H:i:sa am/pm");
        $pimpinan = "menunggu";
        $status = "tutup";
        $luas_tanah = $_POST['luas_tanah'];
        // $luas_bangunan = $_POST['luas_bangunan'];

        $kode_perumahan = "";
        $query = $this->db->get_where('perumahan', array('nama_perumahan'=>$perumahan));

        foreach($query->result() as $row){
            $kode_perumahan = $row->kode_perumahan;
        }

        // $persen_dp = $_POST['persenDP'];
        // $tgl_dp = $_POST['tglDP'];
        // $cara_dp = $_POST['caraDP'];
        // $jumlah_dp = $_POST['lamaDP'];
        // $total_dp = $_POST['totalDP'];
        // $tgl_kpr = $_POST['tglKPR'];
        // $total_kpr = $_POST['totalKPR'];
        // $lama_tempo = $_POST['lama_tempo'];
        $catatan_pembayaran = $_POST['catatan'];
        // $lama_cash = $_POST['lama_cash'];
        $bank_awal = $_POST['bank_awal'];
        // $hadap_timur = $_POST['hadap_timur'];
        $pekerjaan = $_POST['pekerjaan'];

        $tipe_produk = $_POST['tipe_produk'];
        $cara_pembayaran = $_POST['jenis_pembayaran'];
        // $persenDP_selector = $_POST['persenDP_selector'];
        // $persen_bunga = $_POST['persen_bunga'];
        $npwp = $_POST['npwp'];
        $email = $_POST['email'];

        $biaya_pembersihan = $_POST['biaya_pembersihan'];
        $biaya_balik_nama = $_POST['biaya_balik_nama'];

        $tempo1 = $_POST['tahaptempo1'];
        $tempo2 = $_POST['tahaptempo2'];
        $nominaltempo1 = $_POST['nominal_tempo1'];
        $nominaltempo2 = $_POST['nominal_tempo2'];

        $tgl_tempo1 = $_POST['tgl_pembayarantempo1'];
        $tgl_tempo2 = $_POST['tgl_pembayarantempo2'];
        $tgl_cash = $_POST['tgl_pembayarancash'];
        
        $tgl_lahir = $_POST['tgl_lahir'];

        $cash = $_POST['tahapcash'];
        $nominalcash = $_POST['nominal_cash'];

        if($bank_awal != ""){
            foreach($this->db->get_where('bank', array('id_bank'=>$bank_awal))->result() as $row){
                $nama_bank = $row->nama_bank;
            }
        }

        $no_psjb = 1; 
        $check_data = $this->Dashboard_model->check_last_record_ppjb($kode_perumahan);
        foreach($check_data as $row){
            $no_psjb = $row->no_psjb + 1;
        }

        $psjb = 1;
        $this->db->order_by('psjb');
        $this->db->limit(1);
        $this->db->where('kode_perumahan', $kode_perumahan);
        $this->db->where('tipe_produk', "kavling");
        $check_data_psjb = $this->db->get('ppjb');
        foreach($check_data_psjb->result() as $row1){
            $psjb = $row1->psjb;
            // $unik = $row->staff_sign;
            
            $str = $psjb;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $psjb = $matches[0][0] + 1;
        }
        
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './gambar/'; //string, the default is application/cache/
        $config['errorlog']     = './gambar/'; //string, the default is application/logs/
        $config['imagedir']     = './gambar/qr_code/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='booking_fee_kavling_'.$no_psjb.$kode_perumahan.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kwitansi/print_kwitansi_bfee_kavling?id=".$no_psjb."&kav=".$tipe_produk."&kode=".$kode_perumahan; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        // echo $no_psjb;
        // exit;
        // echo $nama_perusahaan;
        // exit;
        
        $result = $kavling;
        // $result_explode = explode(',', $result);
        $tags = preg_split('/,/', $result, -1, PREG_SPLIT_NO_EMPTY);
        // print_r($tags);
        // print_r($result_explode);
        // exit;

        // $tahap = $_POST['tahap'];
        // $tgl_pembayaran = $_POST['tgl_pembayaran'];
        // $nominal_pembayaran = $_POST['nominal_pembayaran'];
        // print_r($nominal_pembayaran);

        // $bank_test = $_POST['bank_test'];
        // print_r($bank_awal);
        // exit;

        if($bank_awal != ""){
            $data = array(
                'no_psjb' => $no_psjb,
                'psjb' =>'a'.$psjb,
                'sistem_pembayaran' => $sistem_pembayaran,
                'nama_marketing' => $nama_marketing,
                'tgl_psjb' => $tgl_psjb,
                'nama_pemesan' => $nama_pemesan,
                'nama_sertif' => $nama_sertif,
                'alamat_lengkap' => $alamat_lengkap,
                'alamat_surat' => $alamat_surat,
                'telp_rumah' => $telp_rumah,
                'telp_hp' => $telp_hp,
                'ktp' => $ktp,
                'uang_awal' => $uang_awal,
                'kode_perumahan' => $kode_perumahan,
                'perumahan' => $perumahan,
                'no_kavling' => $tags[0],
                // 'tipe_rumah' => $tipe_rumah,
                'harga_jual' => $harga_jual,
                'disc_jual' => $disc_jual,
                'total_jual' => $total_jual,
                'created_by' => $created_by,
                'id_created_by' => $created_by_id,
                'date_by' => $date_by,
                'pimpinan' => $pimpinan,
                'status' => $status,
                // 'persen_dp' => $persen_dp,
                // 'tgl_dp' => $tgl_dp,
                // 'cara_dp' => $cara_dp,
                // 'jumlah_dp' => $jumlah_dp,
                // 'total_dp' => $tempo1,
                // 'tgl_kpr' => $tgl_kpr,
                // 'total_kpr' => $total_kpr,
                'kode_perusahaan' => $nama_perusahaan,
                'role' => $role,
                'luas_tanah' => $luas_tanah,
                // 'luas_bangunan' => $luas_bangunan,
                // 'lama_tempo' => $tempo2,
                'catatan' => $catatan_pembayaran,
                // 'lama_cash' => $cash,
                'id_bank' => $bank_awal,
                'nama_bank' => $nama_bank,
                // 'hadap_timur' => $hadap_timur,
                'pekerjaan' => $pekerjaan,
                'tipe_produk' => $tipe_produk,
                'cara_pembayaran' => $cara_pembayaran,
                // 'persenDP_selector'=>$persenDP_selector,
                // 'persen_bunga'=>$persen_bunga,
                'npwp'=>$npwp,
                'email'=>$email,
                'qr_code'=>$image_name,
                'biaya_pembersihan'=>$biaya_pembersihan,
                'biaya_balik_nama'=>$biaya_balik_nama,
                'jumlah_dp'=>$tempo1,
                'total_dp'=>$nominaltempo1,
                'jumlah_dp2'=>$tempo2,
                'total_kpr'=>$nominaltempo2,
                'lama_cash'=>$cash,
                'jumlah_cash'=>$nominalcash,
                'tgl_dp'=>$tgl_tempo1,
                'tgl_kpr'=>$tgl_tempo2,
                'tgl_cash'=>$tgl_cash,
                'tgl_lahir'=>$tgl_lahir
            );
        } else {
            $data = array(
                'no_psjb' => $no_psjb,
                'psjb' =>'a'.$psjb,
                'sistem_pembayaran' => $sistem_pembayaran,
                'nama_marketing' => $nama_marketing,
                'tgl_psjb' => $tgl_psjb,
                'nama_pemesan' => $nama_pemesan,
                'nama_sertif' => $nama_sertif,
                'alamat_lengkap' => $alamat_lengkap,
                'alamat_surat' => $alamat_surat,
                'telp_rumah' => $telp_rumah,
                'telp_hp' => $telp_hp,
                'ktp' => $ktp,
                'uang_awal' => $uang_awal,
                'kode_perumahan' => $kode_perumahan,
                'perumahan' => $perumahan,
                'no_kavling' => $tags[0],
                // 'tipe_rumah' => $tipe_rumah,
                'harga_jual' => $harga_jual,
                'disc_jual' => $disc_jual,
                'total_jual' => $total_jual,
                'created_by' => $created_by,
                'id_created_by' => $created_by_id,
                'date_by' => $date_by,
                'pimpinan' => $pimpinan,
                'status' => $status,
                // 'persen_dp' => $persen_dp,
                // 'tgl_dp' => $tgl_dp,
                // 'cara_dp' => $cara_dp,
                // 'jumlah_dp' => $jumlah_dp,
                // 'total_dp' => $tempo1,
                // 'tgl_kpr' => $tgl_kpr,
                // 'total_kpr' => $total_kpr,
                'kode_perusahaan' => $nama_perusahaan,
                'role' => $role,
                'luas_tanah' => $luas_tanah,
                // 'luas_bangunan' => $luas_bangunan,
                // 'lama_tempo' => $tempo2,
                'catatan' => $catatan_pembayaran,
                // 'lama_cash' => $cash,
                // 'id_bank' => $bank_awal,
                // 'nama_bank' => $nama_bank,
                // 'hadap_timur' => $hadap_timur,
                'pekerjaan' => $pekerjaan,
                'tipe_produk' => $tipe_produk,
                'cara_pembayaran' => $cara_pembayaran,
                // 'persenDP_selector'=>$persenDP_selector,
                // 'persen_bunga'=>$persen_bunga,
                'npwp'=>$npwp,
                'email'=>$email,
                'qr_code'=>$image_name,
                'biaya_pembersihan'=>$biaya_pembersihan,
                'biaya_balik_nama'=>$biaya_balik_nama,
                'jumlah_dp'=>$tempo1,
                'total_dp'=>$nominaltempo1,
                'jumlah_dp2'=>$tempo2,
                'total_kpr'=>$nominaltempo2,
                'lama_cash'=>$cash,
                'jumlah_cash'=>$nominalcash,
                'tgl_dp'=>$tgl_tempo1,
                'tgl_kpr'=>$tgl_tempo2,
                'tgl_cash'=>$tgl_cash,
                'tgl_lahir'=>$tgl_lahir
            );
        }

        $this->db->insert('ppjb', $data);

        $data2 = array(
            'status' => "ppjb",
            'nama_pemilik'=>$nama_pemesan,
            'hp_pemilik'=>$telp_hp
        );

        $this->db->update('rumah', $data2, array('kode_rumah' => $tags[0], 'kode_perumahan'=>$kode_perumahan));

        for($x=1; $x < count($tags); $x++){
            $data7 = array(
                'status' => "ppjb",
                'no_psjb' => 'a'.$psjb,
                'nama_pemilik'=>$nama_pemesan,
                'hp_pemilik'=>$telp_hp
            );
    
            $this->db->update('rumah', $data7, array('kode_rumah' => $tags[$x], 'kode_perumahan'=>$kode_perumahan));
        }

        if($uang_awal != 0){
            if($bank_awal != ""){
                $data3 = array(
                    'id_penerimaan'=>$no_psjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tgl_psjb,
                    'kategori'=>"booking fee",
                    'keterangan'=>"Booking Fee Kavling -".$nama_pemesan,
                    'terima_dari'=>$nama_pemesan,
                    'nominal_bayar'=>$uang_awal,
                    'cara_pembayaran'=>$cara_pembayaran,
                    'id_bank'=>$bank_awal,
                    'nama_bank'=>$nama_bank,
                    'date_created'=>$date_by,
                    'id_created_by'=>$created_by_id,
                    'created_by'=>$created_by
                );
            } else {
                $data3 = array(
                    'id_penerimaan'=>$no_psjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tgl_psjb,
                    'kategori'=>"booking fee",
                    'keterangan'=>"Booking Fee Kavling -".$nama_pemesan,
                    'terima_dari'=>$nama_pemesan,
                    'nominal_bayar'=>$uang_awal,
                    'cara_pembayaran'=>$cara_pembayaran,
                    // 'id_bank'=>$bank_awal,
                    // 'nama_bank'=>$nama_bank,
                    'date_created'=>$date_by,
                    'id_created_by'=>$created_by_id,
                    'created_by'=>$created_by
                );
            }

            $this->db->insert('keuangan_akuntansi', $data3);
        } else {
            if($bank_awal != ""){
                $data3 = array(
                    'id_penerimaan'=>$no_psjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tgl_psjb,
                    'kategori'=>"booking fee",
                    'keterangan'=>"Booking Fee Kavling -".$nama_pemesan,
                    'terima_dari'=>$nama_pemesan,
                    'nominal_bayar'=>$uang_awal,
                    'cara_pembayaran'=>$cara_pembayaran,
                    'id_bank'=>$bank_awal,
                    'nama_bank'=>$nama_bank,
                    'date_created'=>$date_by,
                    'id_created_by'=>$created_by_id,
                    'created_by'=>$created_by
                );
            } else {
                $data3 = array(
                    'id_penerimaan'=>$no_psjb,
                    'kode_perumahan'=>$kode_perumahan,
                    'tanggal_dana'=>$tgl_psjb,
                    'kategori'=>"booking fee",
                    'keterangan'=>"Booking Fee Kavling -".$nama_pemesan,
                    'terima_dari'=>$nama_pemesan,
                    'nominal_bayar'=>$uang_awal,
                    'cara_pembayaran'=>$cara_pembayaran,
                    // 'id_bank'=>$bank_awal,
                    // 'nama_bank'=>$nama_bank,
                    'date_created'=>$date_by,
                    'id_created_by'=>$created_by_id,
                    'created_by'=>$created_by
                );
            }

            $this->db->insert('keuangan_akuntansi', $data3);
        }

        if($sistem_pembayaran == "Cash"){
            $data5 = array(
                'no_psjb' => $no_psjb,
                'no_ppjb' => "a".$psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'dana_sekarang' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('ppjb-dp', $data5);

            if($cash == 1){
                $data_cash = array(
                    'no_psjb' => $no_psjb,
                    'no_ppjb' => "a".$psjb,
                    'cara_bayar' => "Pelunasan",
                    'tanggal_dana' => $tgl_cash,
                    'dana_masuk' => $nominalcash,
                    'dana_sekarang' => $nominalcash,
                    'status' => "belum lunas",
                    'kode_perumahan' => $kode_perumahan
                );

                $this->db->insert('ppjb-dp', $data_cash);
            } else {
                $time = strtotime($tgl_cash);

                for($i = 1; $i <= $cash; $i++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data_cash = array(
                        'no_psjb' => $no_psjb,
                        'no_ppjb' => "a".$psjb,
                        'cara_bayar' => "Pelunasan ke-".$i,
                        'tanggal_dana' => $date,
                        'dana_masuk' => $nominalcash,
                        'dana_sekarang' => $nominalcash,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data_cash);
                }
            }
        } else {
            $data5 = array(
                'no_psjb' => $no_psjb,
                'no_ppjb' => "a".$psjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'dana_sekarang' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('ppjb-dp', $data5);

            $time = strtotime($tgl_tempo1);

            for($i = 0; $i < $tempo1; $i++){
                $date = date('Y-m-d', $time);
                $due_dates[] = $date;
                // move to next timestamp
                $time = strtotime('+1 month', $time);

                $data_2 = array(
                    'no_psjb' => $no_psjb,
                    'no_ppjb' => "a".$psjb,
                    'cara_bayar' => "Angsuran ke-".$i,
                    'tanggal_dana' => $date,
                    'dana_masuk' => $nominaltempo1,
                    'dana_sekarang' => $nominaltempo1,
                    'status' => "belum lunas",
                    'kode_perumahan' => $kode_perumahan
                );

                $this->db->insert('ppjb-dp', $data_2);
            }

            for($x = $tempo1 + 1; $x < ($tempo2 + $tempo1 + 1); $x++){
                $date = date('Y-m-d', $time);
                $due_dates[] = $date;
                // move to next timestamp
                $time = strtotime('+1 month', $time);

                $data_3 = array(
                    'no_psjb' => $no_psjb,
                    'no_ppjb' => "a".$psjb,
                    'cara_bayar' => "Angsuran ke-".$x,
                    'tanggal_dana' => $date,
                    'dana_masuk' => $nominaltempo2,
                    'dana_sekarang' => $nominaltempo2,
                    'status' => "belum lunas",
                    'kode_perumahan' => $kode_perumahan
                );

                $this->db->insert('ppjb-dp', $data_3);
            }
        }
        
        // $data['nama'] = $this->session->userdata('nama');

        // $data['check_all'] = $this->db->get('psjb');

        redirect('Dashboard/kavling_management');
    }

    public function detail_kavling(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];
        $data['id'] = $id;
        $data['kode'] = $kode;
        
        $data['ppjb_detail'] = $this->db->get_where('ppjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

        $this->db->order_by('id_psjb', "ASC");
        $data['psjb_detail_dp'] = $this->db->get_where('ppjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

        $data['ppjb_sb'] = $this->db->get_where('ppjb_sendback', array('no_psjb'=>$id, 'kode_perumahan'=>$kode));

        if($data['ppjb_sb']->num_rows() > 0){
            $data['ppjb_sendback'] = $data['ppjb_sb'];
        }

        // echo $data['psjb_sb']->num_rows();
        // exit;

        // print_r($data['psjb_detail']);
        // print_r($data['psjb_detail_dp']);
        // exit;

        $data['nama'] = $this->session->userdata('nama');

        foreach($data['ppjb_detail'] as $row){
            if($row->status == "revisi"){
                echo "<script>
                    alert('PSJB tidak bisa di akses karena status masih di revisi!');
                    window.location.href='psjb_management';
                    </script>";
            } else {
                $this->load->view('kavling_detail', $data);
            }
        }
    }

    public function kavling_revisi_data(){
        $id_psjb = $_POST['id_psjb'];
        $no_psjb = $_POST['no_psjb'];
        $kode_perumahan = $_POST['kode_perumahan'];

        $nama_pemesan = $_POST['nama_pemesan'];
        $nama_sertif = $_POST['nama_sertif'];
        $ktp = $_POST['ktp'];
        $alamat_rumah = $_POST['alamat_lengkap'];
        $alamat_surat = $_POST['alamat_surat'];
        $telp_rumah = $_POST['telp_rumah'];
        $telp_hp = $_POST['telp_hp'];
        $pekerjaan = $_POST['pekerjaan'];
        $npwp = $_POST['npwp'];
        $email = $_POST['email'];
        $catatan = $_POST['catatan'];

        $data = array(
            'nama_pemesan'=>$nama_pemesan,
            'nama_sertif'=>$nama_sertif,
            'ktp'=>$ktp,
            'alamat_lengkap'=>$alamat_rumah,
            'alamat_surat'=>$alamat_surat,
            'telp_rumah'=>$telp_rumah,
            'telp_hp'=>$telp_hp,
            'pekerjaan'=>$pekerjaan,
            'npwp'=>$npwp,
            'email'=>$email,
            'catatan'=>$catatan,
            'superadmin_date_rev'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('ppjb', $data, array('id_psjb'=>$id_psjb));

        redirect('Dashboard/detail_kavling?id='.$no_psjb.'&kode='.$kode_perumahan);
    }

    public function edit_kavling_dp(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $no_ppjb = $_POST['no_ppjb'];
        $cara_bayar = $_POST['cara_bayar'];
        $persen = $_POST['persen'];
        $tanggal_dana = $_POST['tanggal_dana'];
        $dana_masuk = $_POST['dana_masuk'];
        $status = $_POST['status'];

        $total1 = $_POST['total'];
        $total2 = $_POST['totals'];

        // if($total1 != $total2){
        //     echo "<script>
        //             alert('Tidak cocok / Tidak 0');
        //             window.location.href='detail_ppjb?id=$id&kode=$kode';
        //           </script>";
        // } else {
            $this->db->delete('ppjb-dp', array('no_psjb'=>$id));

            for($i = 0; $i < count($cara_bayar); $i++){
                $data = array(
                    'no_psjb'=>$id,
                    'no_ppjb'=>$no_ppjb[$i],
                    'kode_perumahan'=>$kode,
                    'cara_bayar'=>$cara_bayar[$i],
                    'persen'=>$persen[$i],
                    'tanggal_dana'=>$tanggal_dana[$i],
                    'dana_masuk'=>$dana_masuk[$i],
                    'status'=>$status[$i],
                    'dana_sekarang'=>$dana_masuk[$i]
                );

                $this->db->insert('ppjb-dp', $data);
            };

            redirect('Dashboard/detail_kavling?id='.$id.'&kode='.$kode);
            // print_r($cara_bayar);
        // }
    }

    public function kavling_view_sendback(){
        if($this->session->userdata('role') != "superadmin"){
            echo "<script>
                alert('Anda tidak berhak untuk melakukan sendback!');
                window.location.href='psjb_management';
                </script>";
        }else{
            $id = $_GET['id'];
            $kode = $_GET['kode'];

            $data['psjb_detail'] = $this->db->get_where('ppjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

            $data['psjb_detail_dp'] = $this->db->get_where('ppjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result();

            // print_r($data['psjb_detail']);
            // print_r($data['psjb_detail_dp']);
            // exit;

            $data['nama'] = $this->session->userdata('nama');

            $this->load->view('kavling_sendback', $data);
        }
    }

    public function kavling_sendback(){
        $id = $_GET['id'];
        // $kode = $_POST['kode'];
        $sendback = $_POST['sendback'];
        $created_by = $this->session->userdata('nama');
        $date_by = date("Y-m-d H:i:sa am/pm");
        // $no_psjb = $_POST['no_psjb'];
        $query = $this->db->get_where('ppjb', array('id_psjb'=>$id))->result();
        // print_r($query); exit;
        foreach($query as $row){
            $no_psjb = $row->no_psjb;
            $kode_perumahan = $row->kode_perumahan;
        }
        // $no_psjb=$no_psjb;
        // $kode_perumahan=$kode_perumahan;

        $data2 = array(
            'catatan' => $sendback,
            'sendback_by' => $created_by,
            'sendback_date' => $date_by,
            'no_psjb' => $no_psjb,
            'kode_perumahan' => $kode_perumahan
        );

        $this->db->insert('ppjb_sendback', $data2);

        $this->db->delete('ppjb-dp', array('no_psjb'=>$no_psjb,'kode_perumahan'=>$kode_perumahan));

        $data = array(
            'status' => "revisi"
        );

        $this->db->update('ppjb', $data, array('no_psjb'=>$no_psjb,'kode_perumahan'=>$kode_perumahan));

        redirect('Dashboard/kavling_management');
    }

    public function kavling_view_revisi(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['nama'] = $this->session->userdata('nama');
        $data['role'] = $this->session->userdata('role');

        $data['psjb_revisi'] = $this->db->get_where('ppjb', array('no_psjb'=>$id,'kode_perumahan'=>$kode))->result();
        
        foreach($data['psjb_revisi'] as $row){
            if($row->status == "revisi"){
                $this->load->view('kavling', $data);
            } else {
                echo "<script>
                alert('PPJB ini tidak berstatus untuk revisi!');
                window.location.href='kavling_management';
                </script>";
            }
        }
    }

    public function kavling_revisi(){
        $no_ppjb = $_POST['psjb']; 
        $no_psjb = $_POST['no_psjb'];
        // echo $no_ppjb;
        // echo $no_psjb;
        // exit;
        
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $sistem_pembayaran = $_POST['cara_pembayaran'];
        $nama_marketing = $_POST['nama_marketing'];
        $tgl_psjb = date("Y-m-d");
        $nama_pemesan = $_POST['nama_pemesan'];
        $nama_sertif = $_POST['nama_sertif'];
        $alamat_lengkap = $_POST['alamat_lengkap'];
        $alamat_surat = $_POST['alamat_surat'];
        $telp_rumah = $_POST['no_telp'];
        $telp_hp = $_POST['no_hp'];
        $ktp = $_POST['ktp'];
        $uang_awal = $_POST['uang_awal'];
        $perumahan = $_POST['nama_perumahan'];
        $kavling = $_POST['id_kavling'];
        // $tipe_rumah = $_POST['tipe_standart'];
        $harga_jual = $_POST['harga_jual_standart'];
        $disc_jual = $_POST['diskon_penjualan'];
        $total_jual = $_POST['total_penjualan'];
        $created_by = $this->session->userdata('nama');
        $created_by_id = $this->session->userdata('u_id');
        $role = $this->session->userdata('role');
        $date_by = date("Y-m-d H:i:sa am/pm");
        $pimpinan = "menunggu";
        $status = "tutup";
        $luas_tanah = $_POST['luas_tanah'];
        // $luas_bangunan = $_POST['luas_bangunan'];

        $kode_perumahan = "";
        $query = $this->db->get_where('perumahan', array('nama_perumahan'=>$perumahan));

        foreach($query->result() as $row){
            $kode_perumahan = $row->kode_perumahan;
        }

        // $persen_dp = $_POST['persenDP'];
        // $tgl_dp = $_POST['tglDP'];
        // $cara_dp = $_POST['caraDP'];
        // $jumlah_dp = $_POST['lamaDP'];
        // $total_dp = $_POST['totalDP'];
        // $tgl_kpr = $_POST['tglKPR'];
        // $total_kpr = $_POST['totalKPR'];
        // $lama_tempo = $_POST['lama_tempo'];
        $catatan_pembayaran = $_POST['catatan'];
        // $lama_cash = $_POST['lama_cash'];
        // $bank_awal = $_POST['bank_awal'];
        // $hadap_timur = $_POST['hadap_timur'];
        $pekerjaan = $_POST['pekerjaan'];

        $tipe_produk = $_POST['tipe_produk'];
        // $cara_pembayaran = $_POST['jenis_pembayaran'];
        // $persenDP_selector = $_POST['persenDP_selector'];
        // $persen_bunga = $_POST['persen_bunga'];
        $npwp = $_POST['npwp'];
        $email = $_POST['email'];

        $biaya_pembersihan = $_POST['biaya_pembersihan'];
        $biaya_balik_nama = $_POST['biaya_balik_nama'];

        $tempo1 = $_POST['tahaptempo1'];
        $tempo2 = $_POST['tahaptempo2'];
        $nominaltempo1 = $_POST['nominal_tempo1'];
        $nominaltempo2 = $_POST['nominal_tempo2'];

        $tgl_tempo1 = $_POST['tgl_pembayarantempo1'];
        $tgl_tempo2 = $_POST['tgl_pembayarantempo2'];
        $tgl_cash = $_POST['tgl_pembayarancash'];

        $cash = $_POST['tahapcash'];
        $nominalcash = $_POST['nominal_cash'];
        $tgl_lahir = $_POST['tgl_lahir'];
        
        $data = array(
            // 'no_psjb' => $no_psjb,
            'sistem_pembayaran' => $sistem_pembayaran,
            'nama_marketing' => $nama_marketing,
            // 'tgl_psjb' => $tgl_psjb,
            'nama_pemesan' => $nama_pemesan,
            'nama_sertif' => $nama_sertif,
            'alamat_lengkap' => $alamat_lengkap,
            'alamat_surat' => $alamat_surat,
            'telp_rumah' => $telp_rumah,
            'telp_hp' => $telp_hp,
            'ktp' => $ktp,
            'uang_awal' => $uang_awal,
            'kode_perumahan' => $kode_perumahan,
            'perumahan' => $perumahan,
            // 'no_kavling' => $tags[0],
            // 'tipe_rumah' => $tipe_rumah,
            'harga_jual' => $harga_jual,
            'disc_jual' => $disc_jual,
            'total_jual' => $total_jual,
            'created_by' => $created_by,
            'id_created_by' => $created_by_id,
            'date_by' => $date_by,
            'pimpinan' => $pimpinan,
            'status' => $status,
            // 'persen_dp' => $persen_dp,
            // 'tgl_dp' => $tgl_dp,
            // 'cara_dp' => $cara_dp,
            // 'jumlah_dp' => $jumlah_dp,
            // 'total_dp' => $tempo1,
            // 'tgl_kpr' => $tgl_kpr,
            // 'total_kpr' => $total_kpr,
            'kode_perusahaan' => $nama_perusahaan,
            'role' => $role,
            'luas_tanah' => $luas_tanah,
            // 'luas_bangunan' => $luas_bangunan,
            // 'lama_tempo' => $tempo2,
            'catatan' => $catatan_pembayaran,
            // 'lama_cash' => $cash,
            // 'id_bank' => $bank_awal,
            // 'nama_bank' => $nama_bank,
            // 'hadap_timur' => $hadap_timur,
            'pekerjaan' => $pekerjaan,
            // 'tipe_produk' => $tipe_produk,
            // 'cara_pembayaran' => $cara_pembayaran,
            // 'persenDP_selector'=>$persenDP_selector,
            // 'persen_bunga'=>$persen_bunga,
            'npwp'=>$npwp,
            'email'=>$email,
            // 'qr_code'=>$image_name,
            'biaya_pembersihan'=>$biaya_pembersihan,
            'biaya_balik_nama'=>$biaya_balik_nama,
            'jumlah_dp'=>$tempo1,
            'total_dp'=>$nominaltempo1,
            'jumlah_dp2'=>$tempo2,
            'total_kpr'=>$nominaltempo2,
            'lama_cash'=>$cash,
            'jumlah_cash'=>$nominalcash,
            'tgl_dp'=>$tgl_tempo1,
            'tgl_kpr'=>$tgl_tempo2,
            'tgl_cash'=>$tgl_cash,
            'tgl_lahir'=>$tgl_lahir
        );

        // $this->db->insert('psjb', $data);
        $this->db->update('ppjb', $data, array('no_psjb'=>$no_psjb,'kode_perumahan'=>$kode_perumahan));

        // $data2 = array(
        //     'status' => "ppjb"
        // );

        // $this->db->update('rumah', $data2, array('kode_rumah' => $kavling,'kode_perumahan'=>$kode_perumahan));

        $this->db->delete('ppjb-dp', array('no_ppjb'=>$no_psjb, 'kode_perumahan'=>$kode_perumahan));

        if($sistem_pembayaran == "Cash"){
            $data5 = array(
                'no_psjb' => $no_psjb,
                'no_ppjb' => "a".$no_ppjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'dana_sekarang' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('ppjb-dp', $data5);

            if($cash == 1){
                $data_cash = array(
                    'no_psjb' => $no_psjb,
                    'no_ppjb' => "a".$no_ppjb,
                    'cara_bayar' => "Pelunasan",
                    'tanggal_dana' => $tgl_cash,
                    'dana_masuk' => $nominalcash,
                    'dana_sekarang' => $nominalcash,
                    'status' => "belum lunas",
                    'kode_perumahan' => $kode_perumahan
                );

                $this->db->insert('ppjb-dp', $data_cash);
            } else {
                $time = strtotime($tgl_cash);

                for($i = 1; $i <= $cash; $i++){
                    $date = date('Y-m-d', $time);
                    $due_dates[] = $date;
                    // move to next timestamp
                    $time = strtotime('+1 month', $time);

                    $data_cash = array(
                        'no_psjb' => $no_psjb,
                        'no_ppjb' => "a".$no_ppjb,
                        'cara_bayar' => "Pelunasan ke-".$i,
                        'tanggal_dana' => $date,
                        'dana_masuk' => $nominalcash,
                        'dana_sekarang' => $nominalcash,
                        'status' => "belum lunas",
                        'kode_perumahan' => $kode_perumahan
                    );

                    $this->db->insert('ppjb-dp', $data_cash);
                }
            }
        } else {
            $data5 = array(
                'no_psjb' => $no_psjb,
                'no_ppjb' => "a".$no_ppjb,
                'cara_bayar' => "Uang Tanda Jadi",
                'tanggal_dana' => $tgl_psjb,
                'dana_masuk' => $uang_awal,
                'dana_sekarang' => $uang_awal,
                'status' => "lunas",
                'kode_perumahan' => $kode_perumahan
            );
            $this->db->insert('ppjb-dp', $data5);

            $time = strtotime($tgl_tempo1);

            for($i = 0; $i < $tempo1; $i++){
                $date = date('Y-m-d', $time);
                $due_dates[] = $date;
                // move to next timestamp
                $time = strtotime('+1 month', $time);

                $data_2 = array(
                    'no_psjb' => $no_psjb,
                    'no_ppjb' => "a".$no_ppjb,
                    'cara_bayar' => "Angsuran ke-".$i,
                    'tanggal_dana' => $date,
                    'dana_masuk' => $nominaltempo1,
                    'dana_sekarang' => $nominaltempo1,
                    'status' => "belum lunas",
                    'kode_perumahan' => $kode_perumahan
                );

                $this->db->insert('ppjb-dp', $data_2);
            }

            for($x = $tempo1 + 1; $x < ($tempo2 + $tempo1 + 1); $x++){
                $date = date('Y-m-d', $time);
                $due_dates[] = $date;
                // move to next timestamp
                $time = strtotime('+1 month', $time);

                $data_3 = array(
                    'no_psjb' => $no_psjb,
                    'no_ppjb' => "a".$no_ppjb,
                    'cara_bayar' => "Angsuran ke-".$x,
                    'tanggal_dana' => $date,
                    'dana_masuk' => $nominaltempo2,
                    'dana_sekarang' => $nominaltempo2,
                    'status' => "belum lunas",
                    'kode_perumahan' => $kode_perumahan
                );

                $this->db->insert('ppjb-dp', $data_3);
            }
        }
        
        // $data['nama'] = $this->session->userdata('nama');

        // $data['check_all'] = $this->db->get('psjb');

        redirect('Dashboard/kavling_management');
    }

    public function kavling_batal(){
        $id=$_GET['id'];
        $kode=$_GET['kode'];

        $data = array(
            'status' => "menunggu"
        );

        $this->db->update('ppjb', $data, array('no_psjb'=>$id,'kode_perumahan'=>$kode));

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('ppjb');

        redirect('Dashboard/kavling_management');
    }

    public function undo_batal_kavling(){
        $id=$_GET['id'];
        $kode=$_GET['kode'];

        $data = array(
            'status' => "tutup",
            'pimpinan' => "menunggu"
        );

        $this->db->update('ppjb', $data, array('no_psjb'=>$id,'kode_perumahan'=>$kode));

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('ppjb');

        redirect('Dashboard/kavling_management');
    }

    public function kavling_pembatalan(){
        $id=$_GET['id'];

        $data = array(
            'status' => "batal",
            'pimpinan' => $this->session->userdata('nama')
        );

        $this->db->update('ppjb', $data, array('id_psjb'=>$id));

        foreach($this->db->get_where('ppjb', array('id_psjb'=>$id))->result() as $row){
            $no_kavling = $row->no_kavling;
            $psjb = $row->psjb;
            $kode_perumahan = $row->kode_perumahan;
            $tipe_produk = $row->tipe_produk;
        }
        
        $data3 = array(
            'status' => "batal",
            'pimpinan' => $this->session->userdata('nama')
        );

        $this->db->update('psjb', $data3, array('no_psjb'=>$psjb,'kode_perumahan'=>$kode_perumahan));

        $data2 = array(
            'status'=>"free"
        );

        $this->db->update('rumah', $data2, array('kode_rumah'=>$no_kavling, 'kode_perumahan'=>$kode_perumahan));

        $data4 = array(
            'status'=>"free",
            'no_psjb'=>""
        );

        $this->db->update('rumah', $data4, array('no_psjb'=>$psjb, 'kode_perumahan'=>$kode_perumahan, 'tipe_produk'=>$row->tipe_produk));

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get('ppjb');

        redirect('Dashboard/kavling_management');
    }

    public function alter_kavling(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $data['ppjb'] = $this->db->get_where('ppjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode));

        $data['nama'] = $this->session->userdata('nama');
        $data['id'] = $id;
        $data['kode'] = $kode;

        $this->load->view('kavling_alter', $data);
    }

    public function generate_tempo_kavling(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $penambahan_biaya = $_POST['tambah_biaya'];
        $jumlah = $_POST['jumlah_biaya'];

        foreach($this->db->get_where('ppjb', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result() as $row){
            $penambahan = $row->penambahan_biaya;
            $harga_jual = $row->total_jual;
            $ttl = $harga_jual - $penambahan;
            $no_psjb = $row->psjb;
            $nama_pemesan = $row->nama_pemesan;
            // $tgl_penambahan = 

            // echo $ttl;
            // exit;

            $data = array(
                'total_jual' => $ttl
            );

            $this->db->update('ppjb', $data, array('no_psjb'=>$id, 'kode_perumahan'=>$kode));
        }
        $hrg = $ttl;
        // echo $hrg;
        // exit;

        $data1 = array(
            'penambahan_biaya'=>$penambahan_biaya,
            'lama_penambahan'=>$jumlah,
            'total_jual'=>$ttl + $penambahan_biaya,
            'tgl_penambahan'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('ppjb', $data1, array('no_psjb'=>$id, 'kode_perumahan'=>$kode));

        // $gt = $this->db->get_where('ppjb-dp', array('stat_tambah'=>"true", 'no_psjb'=>$id, 'kode_perumahan'=>$kode));

        $this->db->delete('ppjb-dp', array('stat_tambah'=>"true", 'no_psjb'=>$id, 'kode_perumahan'=>$kode));

        $dana_msk = $penambahan_biaya / $jumlah;
        for($i = 1; $i <= $jumlah; $i++){
            $data2 = array(
                'cara_bayar'=>"Perpanjangan Tempo Angsuran Ke-".$i,
                'no_psjb'=>$id,
                'no_ppjb'=>$no_psjb,
                'kode_perumahan'=>$kode,
                'tanggal_dana'=>date('Y-m-d'),
                'dana_masuk'=>$dana_msk,
                'status'=>"belum lunas",
                'stat_tambah'=>"true",
                'dana_sekarang'=>$dana_msk
            );

            $this->db->insert('ppjb-dp', $data2);
        }

        foreach($this->db->get_where('keuangan_akuntansi', array('kategori'=>"penambahan biaya piutang konsumen", 'id_penerimaan'=>$id, 'kode_perumahan'=>$kode))->result() as $kat){
            $id_keuangan = $kat->id_keuangan;

            $this->db->delete('akuntansi_pos', array('id_keuangan'=>$id_keuangan,'jenis_keuangan'=>"penerimaan",'kode_perumahan'=>$kode));
        }
        $this->db->delete('keuangan_akuntansi', array('kategori'=>"penambahan biaya piutang konsumen", 'id_penerimaan'=>$id, 'kode_perumahan'=>$kode));

        if($penambahan_biaya != 0){
            $data3 = array(
                'id_penerimaan'=>$id,
                'kode_perumahan'=>$kode,
                'tanggal_dana'=>date('Y-m-d H:i:sa am/pm'),
                'kategori'=>"penambahan biaya piutang konsumen",
                'terima_dari'=>$nama_pemesan,
                'keterangan'=>"Penambahan biaya piutang konsumen - ".$nama_pemesan." PPJB No. ".$id,
                'nominal_awal'=>$penambahan_biaya,
                'nominal_bayar'=>$penambahan_biaya,
                'cara_pembayaran'=>"cash",
                'date_created'=>date('Y-m-d H:i:sa am/pm'),
                'id_created_by'=>$this->session->userdata('u_id'),
                'created_by'=>$this->session->userdata('nama')
            );

            $this->db->insert('keuangan_akuntansi', $data3);
        }

        redirect('Dashboard/alter_kavling?id='.$id.'&kode='.$kode);
    }

    public function edit_kavling_dp_alter(){
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $no_ppjb = $_POST['no_ppjb'];
        $cara_bayar = $_POST['cara_bayar'];
        $persen = $_POST['persen'];
        $tanggal_dana = $_POST['tanggal_dana'];
        $dana_masuk = $_POST['dana_masuk'];
        $status = $_POST['status'];

        $total1 = $_POST['total'];
        $total2 = $_POST['totals'];
        $id_psjb = $_POST['id_psjb'];

        // print_r($id_psjb);
        // print_r($status);
        // exit;

        // if($total1 != $total2){
        //     echo "<script>
        //             alert('Tidak cocok / Tidak 0');
        //             window.location.href='detail_ppjb?id=$id&kode=$kode';
        //           </script>";
        // } else {
        // $this->db->delete('ppjb-dp', array('no_psjb'=>$id));

        for($i = 0; $i < count($cara_bayar); $i++){
            $data = array(
                'no_psjb'=>$id,
                'no_ppjb'=>$no_ppjb[$i],
                'kode_perumahan'=>$kode,
                'cara_bayar'=>$cara_bayar[$i],
                'persen'=>$persen[$i],
                'tanggal_dana'=>$tanggal_dana[$i],
                'dana_masuk'=>$dana_masuk[$i],
                'status'=>$status[$i],
                'dana_sekarang'=>$dana_masuk[$i]
            );

            $this->db->update('ppjb-dp', $data, array('id_psjb'=>$id_psjb[$i]));
        };

        redirect('Dashboard/alter_kavling?id='.$id.'&kode='.$kode);
            // print_r($cara_bayar);
        // }
    }

    public function kavling_ubah_blok(){
        $id = $_POST['id'];
        $no_psjb = $_POST['no_psjb'];
        $psjb = $_POST['psjb'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $id_kavling = $_POST['id_kavling'];
        $no_blok = $_POST['no_blok'];

        if(count($id_kavling) == 0){
            echo "<script type='text/javascript'>
                    alert('Tidak ada unit yang dipilih! Perubahan tidak dapat dilakukan!');
                    window.location.href='detail_kavling?id=$no_psjb&kode=$kode_perumahan';
                  </script>";
        } else {
            foreach($this->db->get_where('rumah', array('no_psjb'=>$psjb, 'kode_perumahan'=>$kode_perumahan, 'tipe_produk'=>"kavling"))->result() as $row){
                $data = array(
                    'status'=>"free",
                    'no_psjb'=>""
                );

                $this->db->update('rumah', $data, array('kode_rumah'=>$row->kode_rumah, 'kode_perumahan'=>$kode_perumahan));
            }

            $data1 = array(
                'status'=>"free"
            );

            $this->db->update('rumah', $data, array('kode_rumah'=>$no_blok, 'kode_perumahan'=>$kode_perumahan));

            $data2 = array(
                'status'=>"ppjb"
            );
            $this->db->update('rumah', $data2, array('kode_rumah'=>$id_kavling[0], 'kode_perumahan'=>$kode_perumahan));

            $data3 = array(
                'no_kavling'=>$id_kavling[0],
                'superadmin_date_blok_rev'=>date('Y-m-d H:i:sa am/pm')
            );
            $this->db->update('ppjb', $data3, array('id_psjb'=>$id));

            for($i = 1; $i < count($id_kavling); $i++){
                $data4 = array(
                    'status'=>"ppjb",
                    'no_psjb'=>$no_psjb
                );    
                $this->db->update('rumah', $data4, array('kode_rumah'=>$id_kavling[$i], 'kode_perumahan'=>$kode_perumahan));
            }

            redirect('Dashboard/detail_kavling?id='.$no_psjb.'&kode='.$kode_perumahan);
        }
    }

    public function update_signature_kavling(){
        $id = $_POST['id'];

        $folderPath = "./gambar/signature/ppjb/";
  
        $image_parts = explode(";base64,", $_POST['signed']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
        
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        
        $unik=1;
        $this->db->order_by('konsumen_sign', "DESC");
        $this->db->limit(1);
        foreach($this->db->get('ppjb')->result() as $row){
            $unik = $row->konsumen_sign + 1;
        }

        // $unik = uniqid();
        $file = $folderPath . $unik . '.'.$image_type;

        // CUSTOMER
        $image_parts1 = explode(";base64,", $_POST['signed1']);
            
        $image_type_aux1 = explode("image/", $image_parts1[0]);
        
        $image_type1 = $image_type_aux1[1];
        
        $image_base641 = base64_decode($image_parts1[1]);
        
        $unik1 = $unik + 1;
        $file1 = $folderPath . $unik1 . '.'.$image_type1;
        // print_r(uniqid()); exit;

        //OWNER
        $image_parts2 = explode(";base64,", $_POST['signed2']);
            
        $image_type_aux2 = explode("image/", $image_parts2[0]);
        
        $image_type2 = $image_type_aux2[1];
        
        $image_base642 = base64_decode($image_parts2[1]);

        // print_r($image_type_aux2);
        // exit;
        
        $unik2 = 1;
        $this->db->order_by('owner_sign', "DESC");
        $this->db->limit(1);
        // print_r($this->db->get('ppjb')->result());
        foreach($this->db->get('ppjb')->result() as $row){
            $unik2 = $row->owner_sign;

            $str = $unik2;
            preg_match_all('!\d+!', $str, $matches);
            // $var = implode(' ', $matches[0]);
            // print_r($matches[0][0]); 
            $unik2 = $matches[0][0] + 1;
        }
        // $unik = "A1 11 12";

        // exit;

        // $unik = uniqid();
        $file2 = $folderPath .'a'. $unik2 . '.'.$image_type2;
        
        if($image_parts[0] == "" || $image_parts1[0] == ""){
            echo "<script>
                    alert('Tanda tangan marketing/konsumen tidak boleh kosong!');
                    window.location.href='kavling_management';
                  </script>";
        } else {
            if($image_parts2[0] == ""){
                file_put_contents($file, $image_base64);
                file_put_contents($file1, $image_base641);

                $data = array(
                    'marketing_sign'=>$unik.'.'.$image_type,
                    'konsumen_sign'=>$unik1.'.'.$image_type1,
                    // 'owner_sign'=>'a'.$unik2.'.'.$image_type2
                    'id_signature_by'=>$this->session->userdata('u_id'),
                    'signature_by'=>$this->session->userdata('nama'),
                    'date_sign'=>date('Y-m-d H:i:sa am/pm'),
                );
            } else {
                file_put_contents($file, $image_base64);
                file_put_contents($file1, $image_base641);
                file_put_contents($file2, $image_base642);

                $data = array(
                    'marketing_sign'=>$unik.'.'.$image_type,
                    'konsumen_sign'=>$unik1.'.'.$image_type1,
                    'owner_sign'=>'a'.$unik2.'.'.$image_type2,
                    'id_signature_by'=>$this->session->userdata('u_id'),
                    'signature_by'=>$this->session->userdata('nama'),
                    'date_sign'=>date('Y-m-d H:i:sa am/pm'),
                    'id_signature_by_owner'=>$this->session->userdata('u_id'),
                    'signature_by_owner'=>$this->session->userdata('nama'),
                    'date_sign_owner'=>date('Y-m-d H:i:sa am/pm'),
                );
            }

            $this->db->update('ppjb', $data, array('id_psjb'=>$id));

            // echo "Signature Uploaded Successfully.";
            $this->session->set_flashdata('succ_msg', "Sukses menambahkan tanda tangan!");

            redirect('Dashboard/kavling_management');
        }
    }

    public function print_kavling(){
        $id = $_GET['id'];
        $kode = $_GET['kode'];

        $query = $this->db->get_where('ppjb', array('no_psjb' => $id,'kode_perumahan'=>$kode))->result();
        
        $this->db->order_by('id_psjb', "ASC");
        $data['psjb_detail_dp'] = $this->db->get_where('ppjb-dp', array('no_psjb'=>$id,'kode_perumahan'=>$kode))->result();
        // print_r($query);
        $data['check_all'] = $query;

        $data['query'] = $this->Dashboard_model->skip_first_data($id, $kode);
        
        // print_r($data['test']);
        // exit;

        foreach($data['check_all'] as $row){
            if($row->status == "ppjb"){
                $this->load->library('pdf');
            
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "print-ppjb-kavling.pdf";
                ob_end_clean();
                $this->pdf->load_view('kavling_print', $data);
            } else if($row->status == "dom"){
                $this->load->library('pdf');
            
                $this->pdf->setPaper('A4', 'potrait');
                $this->pdf->filename = "print-ppjb-kavling.pdf";
                ob_end_clean();
                $this->pdf->load_view('kavling_print', $data);
            } else{
                echo "<script>
                    alert('PPJB tidak bisa di akses karena belum di approve!');
                    window.location.href='kavling_management';
                    </script>";
            }
        }
    }

    public function kavling_approve(){
        if($this->session->userdata('role') != "superadmin"){
            echo "<script>
                alert('Anda tidak berhak untuk melakukan approve!');
                window.location.href='kavling_management';
                </script>";
        }else{
            $id = $_GET['id'];

            $data2 = array(
                'status' => "dom",
                'pimpinan' => $this->session->userdata('nama')
            );

            $this->db->update('ppjb', $data2, array('id_psjb' => $id));

            // $data['nama'] = $this->session->userdata('nama');

            // $data['check_all'] = $this->db->get('psjb');

            // $data['succ_msg'] = "Data sukses ditambahkan";

            redirect('Dashboard/kavling_management');
        }
    }
    //END OF KAVLING

    public function air_maintenance_report_perumahan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['k_perumahan'] = $this->db->get('perumahan')->result();

        $this->load->view('air_maintenance_management_perumahan', $data);
    }

    public function air_maintenance_report(){
        $id = $_GET['id'];

        $data['nama'] = $this->session->userdata('nama');

        $this->db->where("DATE_FORMAT(date_by,'%Y-%m') =", date('Y-m'));
        // $this->db->where('kode_perumahan', $id);
        $data['check_all'] = $this->db->get('konsumen_struk_item');

        $data['bulan'] = date('Y-m');
        $data['id'] = $id;

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $this->load->view('air_maintenance_management', $data);
    }

    public function filter_air_maintenance_report(){
        $id = $_POST['id'];
        $bulan = $_POST['bulan'];

        $data['nama'] = $this->session->userdata('nama');

        $this->db->where("DATE_FORMAT(date_by,'%Y-%m') =", date('Y-m', strtotime($bulan)));
        // $this->db->where('kode_perumahan', $id);
        $data['check_all'] = $this->db->get('konsumen_struk_item');

        $data['bulan'] = $bulan;
        $data['id'] = $id;

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$id))->result() as $row){
            $data['nama_perumahan'] = $row->nama_perumahan;
        }

        $this->load->view('air_maintenance_management', $data);
    }

    public function view_input_kbk(){
        $this->db->limit(1);
        $this->db->order_by('id_kbk', "DESC");
        $q = $this->db->get('kbk');

        foreach($q->result() as $row){
            $data['id_kbk'] = $row->id_kbk + 1;
            $data['no_kbk'] = $row->no_kbk + 1;
        }

        $this->load->view('input_kbk', $data);
    }

    public function add_input_kbk(){
        $idpsjb = $_POST['idpsjb'];
        $nopsjb = $_POST['nopsjb'];
        $kodeperumahan = $_POST['kodeperumahan'];
        $nounit = $_POST['nounit'];

        $data = array(
            'id_kbk'=>$idpsjb,
            'no_kbk'=>$nopsjb,
            'kode_perumahan'=>$kodeperumahan,
            'unit'=>$nounit
        );

        $this->db->insert('kbk', $data);

        redirect('Dashboard/view_input_kbk');
    }

    public function view_input_bast(){
        $this->load->view('input_bast');
    }

    public function add_input_bast(){
        $this->db->limit(1);
        $this->db->order_by('id_bast', "DESC");
        $q = $this->db->get('bast_konsumen');

        foreach($q->result() as $row){
            $id_bast = $row->id_bast + 1;

            for($i = $id_bast; $i <= 121; $i++){
                $data = array(
                    'id_bast'=>$i,
                    'id_kbk'=>$i,
                    'no_bast'=>$i,
                    'no_kbk'=>$i,
                    'kode_perumahan'=>"MSK",
                    'kategori'=>"DevKon"
                );

                $this->db->insert('bast_konsumen', $data);
            }
        }

        redirect('Dashboard/view_input_bast');
    }

    public function help(){
        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('help', $data);
    }
}
