<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Kasir extends CI_Controller {
        public function __construct(){
                parent::__construct();

                $this->load->model('Login_model');
                $this->load->model('Dashboard_model');

                if($this->session->userdata("logged")==FALSE)
                {
                    redirect(base_url('Login'), 'refresh');
                }
                
                date_default_timezone_set('Asia/Jakarta');
        }

	public function index()
	{
        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $data['err_msg'] = $this->session->flashdata('err_msg');

		$this->load->view('kasir/home', $data);
	}

    public function check_air(){
        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

		$this->load->view('kasir/form_check_air', $data);
    }

    public function get_unit_bast(){
        $id = $_POST['country'];

        if(isset($id)){
            echo "<option value='' disabled selected>-Pilih-</option>";
            $query = $this->db->get_where('bast_konsumen', array('kode_perumahan'=>$id));
            
            $arr_unit = array();
            foreach($query->result() as $row){
                foreach($this->db->get_where('kbk', array('id_kbk'=>$row->id_kbk))->result() as $kbk){
                    $unit = explode(", ", $kbk->unit);

                    for($x = 0; $x < count($unit); $x++){
                        array_push($arr_unit, $unit[$x]);
                    }
                }
            }

            sort($arr_unit);
            $count = count($arr_unit);
            print_r($arr_unit);
            for($i=0; $i < $count; $i++){
                $check_unit_rumah = $this->db->get_where('rumah', array('kode_rumah'=>$arr_unit[$i], 'kode_perumahan'=>$id, 'tipe_produk'=>"rumah", 'status_tinggal'=>"tinggal"));
                // echo "<option value='".$unit[$i]."'>".$unit[$i]."</option>";
                foreach($check_unit_rumah->result() as $rws){
                    echo "<option value='".$rws->kode_rumah."'>".$rws->kode_rumah."</option>";
                }
            }
        }
    }

    public function get_nama_pemilik(){
        $kodePerumahan = $_POST['kodePerumahan'];
        $unit = $_POST['country'];

        // echo "A";

        $query = $this->db->get_where('rumah', array('kode_rumah'=>$unit, 'kode_perumahan'=>$kodePerumahan, 'tipe_produk'=>"rumah"));
        // echo $query->num_rows();

        foreach($query->result() as $row){
            echo $row->nama_pemilik;
        }
    }

    public function get_hp_pemilik(){
        $kodePerumahan = $_POST['kodePerumahan'];
        $unit = $_POST['country'];

        $query = $this->db->get_where('rumah', array('kode_perumahan'=>$kodePerumahan, 'kode_rumah'=>$unit, 'tipe_produk'=>"rumah"));

        foreach($query->result() as $row){
            echo $row->hp_pemilik;
        }
    }

    public function get_riwayat_air_unit(){
        $kodePerumahan = $_POST['kodePerumahan'];
        $unit = $_POST['country'];

        $this->db->order_by('bulan_tagihan', "DESC");
        $query = $this->db->get_where('konsumen_air', array('kode_perumahan'=>$kodePerumahan, 'kode_rumah'=>$unit));

        foreach($query->result() as $row){
            echo "<tr>
                    <td>".date('d-m-Y', strtotime($row->bulan_tagihan))."</td>
                    <td>$row->meteran m<sup>3</sup></td>
                    <td>$row->penggunaan_air m<sup>3</sup></td>
                    <td>".number_format($row->total_harga)." m<sup>3</sup></td>
                    <td>";
                    if(date('Y-m', strtotime($row->bulan_tagihan)) == date('Y-m') && $row->status == "belum lunas"){
                        echo "<a href='".base_url()."Kasir/view_edit_check_air?id=$row->id_air' class='btn btn-outline-info btn-flat btn-sm'>Edit</a>";
                    }
            echo "
                    </td>
                    <td style='font-size: 12px'>
                        Created: $row->created_by - ".date('Y-m-d H:i:sa', strtotime($row->date_by))."<br>
                        Revised: $row->rev_by - ".date('Y-m-d H:i:sa', strtotime($row->rev_date))."
                    </td>
                  </tr>";
        }
    }

    public function get_id_ppjb(){
        $kodePerumahan = $_POST['kodePerumahan'];
        $unit = $_POST['country'];

        $this->db->like('unit', $unit);
        $query = $this->db->get_where('kbk', array('kode_perumahan'=>$kodePerumahan));

        foreach($query->result() as $row){
            echo $row->id_ppjb;
        }
    }

    public function get_id_bast(){
        $kodePerumahan = $_POST['kodePerumahan'];
        $unit = $_POST['country'];

        $this->db->like('unit', $unit);
        $query = $this->db->get_where('kbk', array('kode_perumahan'=>$kodePerumahan));

        foreach($query->result() as $row){
            $query1 = $this->db->get_where('bast_konsumen', array('id_kbk'=>$row->id_kbk, 'kode_perumahan'=>$row->kode_perumahan));
            foreach($query1->result() as $row1){
                echo $row1->id_bast;
            }
        }
    }

    public function get_kode_perusahaan(){
        $kode_perumahan = $_POST['country'];

        $query = $this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan));
        foreach($query->result() as $row){
            echo $row->kode_perusahaan;
        }
    }

    public function get_pemakaian_meteran_bulan_ini(){
        $meteran = $_POST['country'];
        $unit = $_POST['unit'];
        $kode_perumahan = $_POST['kodePerumahan'];
        $bulan = $_POST['bulan'];
        // echo $bulan;

        // echo "asek";

        // $this->db->order_by('bulan_tagihan' );
        $this->db->select_max('meteran');
        $query = $this->db->get_where('konsumen_air', array('kode_rumah'=>$unit, 'kode_perumahan'=>$kode_perumahan));

        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                echo $meteran - $row->meteran;
            }
        } else {
            echo $meteran;
        }
    }

    public function get_edit_pemakaian_meteran_bulan_ini(){
        $meteran = $_POST['country'];
        $unit = $_POST['unit'];
        $kode_perumahan = $_POST['kodePerumahan'];
        $bulan = $_POST['bulan'];
        // echo $bulan;

        // echo "asek";

        // $this->db->order_by('bulan_tagihan' );
        // $this->db->select_max('meteran');
        $this->db->order_by('bulan_tagihan', "DESC");
        $this->db->limit(1);
        $this->db->where("DATE_FORMAT(bulan_tagihan,'%Y-%m') <", date('Y-m', strtotime($bulan)));
        $query = $this->db->get_where('konsumen_air', array('kode_rumah'=>$unit, 'kode_perumahan'=>$kode_perumahan));

        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                echo $meteran - $row->meteran;
            }
        } else {
            echo $meteran;
        }
    }

    public function add_pengecekan_air(){
        $kode_perumahan = $_POST['perumahan'];
        $kode_rumah = $_POST['unit'];
        $kode_perusahaan = $_POST['kodePerusahaan'];
        $id_ppjb = $_POST['id_ppjb'];
        $id_bast = $_POST['id_bast'];
        $nama_pemilik = $_POST['nama_pemilik'];
        $hp_pemilik = $_POST['hp_pemilik'];
        $bulan_pengecekan = $_POST['bulan_pengecekan'];
        $meteran = $_POST['meteran'];
        $pemakaian_air = $_POST['pemakaian_air'];

        $harga_standart = $_POST['harga_standart'];
        $harga_overuse = $_POST['harga_overuse'];
        $status = "belum lunas";

        if($pemakaian_air > 20){
            $total_harga = $harga_standart + (ceil($pemakaian_air-20) * 5000);
        } else {
            $total_harga = $harga_standart;
        }

        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date('Y-m-d H:i:sa am/pm');

        // $bln =
        $this->db->where("DATE_FORMAT(bulan_tagihan,'%Y-%m') =", date('Y-m', strtotime($bulan_pengecekan)));
        $this->db->where('kode_perumahan', $kode_perumahan);
        $this->db->where('kode_rumah', $kode_rumah);
        $query = $this->db->get('konsumen_air');
        
        // print_r($query->num_rows());
        // exit;

        if($query->num_rows() > 0){
            // $this->session->set_flashdata('err_msg', "Data bulan tersebut telah ada!");
            $data['err_msg'] = "Data bulan tersebut telah ada!";
        } else {
            $data = array(
                'kode_rumah'=>$kode_rumah,
                'kode_perumahan'=>$kode_perumahan,
                'kode_perusahaan'=>$kode_perusahaan,
                'id_ppjb'=>$id_ppjb,
                'id_bast'=>$id_bast,
                'nama_konsumen'=>$nama_pemilik,
                'hp_konsumen'=>$hp_pemilik,
                'bulan_tagihan'=>$bulan_pengecekan,
                'meteran'=>$meteran,
                'penggunaan_air'=>$pemakaian_air,
                'status'=>$status,
                'harga_standart'=>$harga_standart,
                'harga_overuse'=>$harga_overuse,
                'total_harga'=>$total_harga,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_by'=>$date_by
            );
    
            $this->db->insert('konsumen_air', $data);
            // exit;
            
            // $this->session->set_flashdata('succ_msg', "Data berhasil ditambahkan!");
            $data['succ_msg'] = "Data berhasil ditambahkan!";
        }

        // redirect('Kasir/');

        // redirect('Kasir/check_air');
        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('kasir/form_check_air', $data);
    }

    public function view_edit_check_air(){
        $id = $_GET['id'];

        $data['id'] = $id;
        $data['revisi'] = $this->db->get_where('konsumen_air', array('id_air'=>$id)); 
        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('kasir/form_check_air', $data);
    }

    public function edit_pengecekan_air(){
        $id_air = $_POST['id_air'];

        $kode_perumahan = $_POST['perumahan'];
        $kode_rumah = $_POST['unit'];
        $kode_perusahaan = $_POST['kodePerusahaan'];
        $id_ppjb = $_POST['id_ppjb'];
        $id_bast = $_POST['id_bast'];
        $nama_pemilik = $_POST['nama_pemilik'];
        $hp_pemilik = $_POST['hp_pemilik'];
        $bulan_pengecekan = $_POST['bulan_pengecekan'];
        $meteran = $_POST['meteran'];
        $pemakaian_air = $_POST['pemakaian_air'];

        $harga_standart = $_POST['harga_standart'];
        $harga_overuse = $_POST['harga_overuse'];
        $status = "belum lunas";

        if($pemakaian_air > 20){
            $total_harga = $harga_standart + (ceil($pemakaian_air-20) * 5000);
        } else {
            $total_harga = $harga_standart;
        }

        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date('Y-m-d H:i:sa am/pm');

        // $bln =
        // $this->db->where("DATE_FORMAT(bulan_tagihan,'%Y-%m') =", date('Y-m', strtotime($bulan_pengecekan)));
        // $this->db->where('kode_perumahan', $kode_perumahan);
        // $this->db->where('kode_rumah', $kode_rumah);
        // $query = $this->db->get('konsumen_air');
        
        // print_r($query->num_rows());
        // exit;

        // if($query->num_rows() > 0){
        //     $this->session->set_flashdata('err_msg', "Data bulan tersebut telah ada!");
        // } else {
        $data = array(
            'kode_rumah'=>$kode_rumah,
            'kode_perumahan'=>$kode_perumahan,
            'kode_perusahaan'=>$kode_perusahaan,
            'id_ppjb'=>$id_ppjb,
            'id_bast'=>$id_bast,
            'nama_konsumen'=>$nama_pemilik,
            'hp_konsumen'=>$hp_pemilik,
            'bulan_tagihan'=>$bulan_pengecekan,
            'meteran'=>$meteran,
            'penggunaan_air'=>$pemakaian_air,
            'status'=>$status,
            'harga_standart'=>$harga_standart,
            'harga_overuse'=>$harga_overuse,
            'total_harga'=>$total_harga,
            'id_created_by'=>$id_created_by,
            'created_by'=>$created_by,
            'date_by'=>$date_by
        );

        $this->db->update('konsumen_air', $data, array('id_air'=>$id_air));
        // exit;
        
        $this->session->set_flashdata('succ_msg', "Data berhasil ditambahkan!");
        // }

        redirect('Kasir/view_edit_check_air?id='.$id_air);
    }

    //START OF KASIR
    public function get_unit_kasir(){
        $id = $_POST['country'];

        if(isset($id)){
            echo "<option value='' disabled selected>-Pilih-</option>";
            $query = $this->db->get_where('bast_konsumen', array('kode_perumahan'=>$id));

            $arr_unit = array();
            foreach($query->result() as $row){
                foreach($this->db->get_where('kbk', array('id_kbk'=>$row->id_kbk))->result() as $kbk){
                    $unit = explode(", ", $kbk->unit);

                    for($x = 0; $x < count($unit); $x++){
                        array_push($arr_unit, $unit[$x]);
                    }
                }
            }

            sort($arr_unit);
            $count = count($arr_unit);
            // print_r($arr_unit);

            for($i=0; $i < $count; $i++){
                // $check_unit_rumah = $this->db->get_where('rumah', array('kode_rumah'=>$unit[$i], 'kode_perumahan'=>$id, 'tipe_produk'=>"rumah", 'status_tinggal'=>"tinggal"));
                echo "<option value='".$arr_unit[$i]."'>".$arr_unit[$i]."</option>";
                // foreach($check_unit_rumah->result() as $rws){
                //     echo "<option value='".$rws->kode_rumah."'>".$rws->kode_rumah."</option>";
                // }
            }
        }
    }

    public function get_riwayat_air_kasir(){
        $kodePerumahan = $_POST['kodePerumahan'];
        $unit = $_POST['country'];

        $this->db->order_by('bulan_tagihan', "DESC");
        $query = $this->db->get_where('konsumen_air', array('kode_perumahan'=>$kodePerumahan, 'kode_rumah'=>$unit, 'status'=>"belum lunas"));

        foreach($query->result() as $row){
            echo "<tr>
                    <td><input type='checkbox' class='form-control' name='click[]' value='$row->id_air'></td>
                    <td>".date('d-m-Y', strtotime($row->bulan_tagihan))."</td>
                    <td>$row->meteran m<sup>3</sup></td>
                    <td>$row->penggunaan_air m<sup>3</sup></td>
                    <td>Rp. ".number_format($row->total_harga)."</td>
                    </td>
                    </tr>";
        }
    }

    public function get_riwayat_maintenance(){
        $kodePerumahan = $_POST['kodePerumahan'];
        $unit = $_POST['country'];

        $this->db->order_by('bulan_tagihan', "DESC");
        $query = $this->db->get_where('konsumen_maintenance', array('kode_perumahan'=>$kodePerumahan, 'kode_rumah'=>$unit, 'status'=>"belum lunas"));

        foreach($query->result() as $row){
            echo "<tr>
                    <td><input type='checkbox' class='form-control' name='click1[]' value='$row->id_maintenance'></td>
                    <td>".date('d-m-Y', strtotime($row->bulan_tagihan))."</td>
                    <td>Rp. ".number_format($row->nominal)."</td>
                    </td>
                    </tr>";
        }
    }

    public function view_add_maintenance(){
        $data['nama'] = $this->session->userdata('nama');

        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->db->where("DATE_FORMAT(bulan_tagihan,'%Y-%m') =", date('Y-m'));
        $data['check_all'] = $this->db->get_where('konsumen_maintenance');

        $this->db->where("DATE_FORMAT(bulan_tagihan,'%Y-%m') <", date('Y-m'));
        $this->db->where('status', "belum lunas");
        $data['check_all2'] = $this->db->get_where('konsumen_maintenance');

        $data['get_all'] = $this->db->get_where('konsumen_maintenance');

        $this->load->view('kasir/form_maintenance', $data);
    }

    public function add_maintenance(){
        $bulan = $_POST['bulan'];
        $nominal = $_POST['nominal'];

        $query = $this->db->get('bast_konsumen');
        // print_r($query->result());
        // exit;
        foreach($query->result() as $row){
            foreach($this->db->get_where('kbk', array('id_kbk'=>$row->id_kbk))->result() as $kbk){
                $unit = explode(", ", $kbk->unit);

                $count = count($unit);

                for($i=0; $i < $count; $i++){
                    $check_unit_rumah = $this->db->get_where('rumah', array('kode_rumah'=>$unit[$i], 'kode_perumahan'=>$kbk->kode_perumahan, 'tipe_produk'=>"rumah"));
                    // echo "<option value='".$unit[$i]."'>".$unit[$i]."</option>";
                    // print_r($check_unit_rumah->result());
                    // exit;

                    foreach($check_unit_rumah->result() as $rws){
                        $this->db->where("DATE_FORMAT(bulan_tagihan,'%Y-%m') =", date('Y-m', strtotime($bulan)));
                        $q = $this->db->get_where('konsumen_maintenance', array('kode_rumah'=>$rws->kode_rumah, 'kode_perumahan'=>$rws->kode_perumahan));

                        // print_r($q->num_rows());
                        // exit;
                        if($q->num_rows() == 0){
                            $data = array(
                                'kode_rumah'=>$rws->kode_rumah,
                                'kode_perumahan'=>$rws->kode_perumahan,
                                'kode_perusahaan'=>$rws->kode_perusahaan,
                                'nama_konsumen'=>$rws->nama_pemilik,
                                'hp_konsumen'=>$rws->hp_pemilik,
                                'bulan_tagihan'=>$bulan,
                                'id_bast'=>$row->id_bast,
                                'id_ppjb'=>$kbk->id_ppjb,
                                'nominal'=>$nominal,
                                'status'=>"belum lunas",
                                'id_created_by'=>$this->session->userdata('u_id'),
                                'created_by'=>$this->session->userdata('nama'),
                                'date_by'=>date('Y-m-d H:i:sa am/pm')
                            );

                            $this->db->insert('konsumen_maintenance', $data);
                        }
                    }
                }
            }
        }

        $this->session->set_flashdata('succ_msg', "Berhasil menambahkan tagihan!");

        redirect('Kasir/view_add_maintenance');
    }

    public function edit_all_maintenance(){
        $id_maintenance = $_POST['id_maintenance'];
        $nominal = $_POST['nominal'];

        for($i = 0; $i < count($id_maintenance); $i++){
            $data = array(
                'nominal'=>$nominal[$i]
            );

            $this->db->update('konsumen_maintenance', $data, array('id_maintenance'=>$id_maintenance[$i]));
        }

        $this->session->set_flashdata('succ_msg', "Berhasil di-update");

        redirect('Kasir/view_add_maintenance');
    }

    public function air_management(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('kode_rumah', "ASC");
        $this->db->order_by('bulan_tagihan', "DESC");
        $data['check_all'] = $this->db->get('konsumen_air');

        $this->db->where("DATE_FORMAT(bulan_tagihan,'%Y-%m') =", date('Y-m'));
        // $this->db->
        $data['check_all2'] = $this->db->get_where('konsumen_air');

        $this->db->where("DATE_FORMAT(bulan_tagihan,'%Y-%m') <", date('Y-m'));
        $this->db->where('status', "belum lunas");
        $data['check_all3'] = $this->db->get_where('konsumen_air');

        $this->load->view('kasir/air_management', $data);
    }
    
    public function add_air_belum_tinggal(){
        $bulan = $_POST['bulan'];
        $nominal = $_POST['nominal'];

        $query = $this->db->get('bast_konsumen');
        // print_r($query->result());
        // exit;
        foreach($query->result() as $row){
            foreach($this->db->get_where('kbk', array('id_kbk'=>$row->id_kbk))->result() as $kbk){
                $unit = explode(", ", $kbk->unit);

                $count = count($unit);

                for($i=0; $i < $count; $i++){
                    $check_unit_rumah = $this->db->get_where('rumah', array('kode_rumah'=>$unit[$i], 'kode_perumahan'=>$kbk->kode_perumahan, 'tipe_produk'=>"rumah", 'status_tinggal'=>"belum tinggal"));
                    // echo "<option value='".$unit[$i]."'>".$unit[$i]."</option>";
                    // print_r($check_unit_rumah->result());
                    // exit;

                    foreach($check_unit_rumah->result() as $rws){
                        $this->db->where("DATE_FORMAT(bulan_tagihan,'%Y-%m') =", date('Y-m', strtotime($bulan)));
                        $q = $this->db->get_where('konsumen_air', array('kode_rumah'=>$rws->kode_rumah, 'kode_perumahan'=>$rws->kode_perumahan));

                        // print_r($q->num_rows());
                        // exit;
                        if($q->num_rows() == 0){
                            $data = array(
                                'kode_rumah'=>$rws->kode_rumah,
                                'kode_perumahan'=>$rws->kode_perumahan,
                                'kode_perusahaan'=>$rws->kode_perusahaan,
                                'nama_konsumen'=>$rws->nama_pemilik,
                                'hp_konsumen'=>$rws->hp_pemilik,
                                'bulan_tagihan'=>$bulan,
                                'id_bast'=>$row->id_bast,
                                'id_ppjb'=>$kbk->id_ppjb,
                                'total_harga'=>$nominal,
                                'status'=>"belum lunas",
                                'id_created_by'=>$this->session->userdata('u_id'),
                                'created_by'=>$this->session->userdata('nama'),
                                'date_by'=>date('Y-m-d H:i:sa am/pm')
                            );

                            $this->db->insert('konsumen_air', $data);
                        }
                    }
                }
            }
        }

        $this->session->set_flashdata('succ_msg', "Berhasil menambahkan tagihan!");

        redirect('Kasir/air_management');
    }

    public function edit_all_air(){
        $id_air = $_POST['id_air'];
        $nominal = $_POST['nominal'];

        for($i = 0; $i < count($id_air); $i++){
            $data = array(
                'total_harga'=>$nominal[$i]
            );

            $this->db->update('konsumen_air', $data, array('id_air'=>$id_air[$i]));
        }

        $this->session->set_flashdata('succ_msg', "Berhasil di-update");

        redirect('Kasir/air_management');
    }

    public function hapus_air(){
        $id_air = $_POST['id_air'];

        // print_r($id_air);
        for($i = 0; $i < count($id_air); $i++){
            $this->db->delete('konsumen_air', array('id_air'=>$id_air[$i]));
        }

        $this->session->set_flashdata('succ_msg', "Berhasil di-hapus");

        redirect('Kasir/air_management');
    }

    public function data_unit_rumah(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('bast_konsumen');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');

        $this->load->view('kasir/data_unit', $data);
    }

    public function edit_data_unit(){
        $id_rumah = $_POST['id_rumah'];
        $nama_pemilik = $_POST['nama_pemilik'];
        $hp_pemilik = $_POST['hp_pemilik'];
        $status_tinggal = $_POST['status_tinggal'];

        for($i=0; $i<count($id_rumah); $i++){
            $data = array(
                'nama_pemilik'=>$nama_pemilik[$i],
                'hp_pemilik'=>$hp_pemilik[$i],
                'status_tinggal'=>$status_tinggal[$i]
            );

            $this->db->update('rumah', $data, array('id_rumah'=>$id_rumah[$i]));
        }

        $this->session->set_flashdata('succ_msg', "Data berhasil diupdate!");

        redirect('Kasir/data_unit_rumah');
    }

    public function pilih_pembayaran_kasir(){
        $kode_perumahan = $_POST['perumahan'];
        $unit = $_POST['unit'];

        // print_r($id_air);
        // $expression =  ;
        if(! isset($_POST['click']) && ! isset($_POST['click1'])){
            $this->session->set_flashdata('err_msg', "Tidak ada yang dipilih!");
            redirect('Kasir/');
        } else if(! isset($_POST['click1'])){
            $id_air = $_POST['click'];
            // $id_maintenance = $_POST['click1'];

            $data['confirm'] = "confirm";
            $data['nama'] = $this->session->userdata('nama');

            $data['kode_perumahan'] = $kode_perumahan;
            $data['unit'] = $unit;
            $data['id_air'] = $id_air;
            // $data['id_maintenance'] = $id_maintenance;

            foreach($this->db->get_where('rumah', array('kode_rumah'=>$unit, 'kode_perumahan'=>$kode_perumahan))->result() as $row){
                $data['nama_pemilik'] = $row->nama_pemilik;
                $data['hp_pemilik'] = $row->hp_pemilik;
                // $data['']
            }

            $data['succ_msg'] = $this->session->flashdata('succ_msg');

            $this->load->view('kasir/home', $data);
            // redirect('Kasir/');
        }
        else if(! isset($_POST['click'])){
            // $id_air = $_POST['click'];
            $id_maintenance = $_POST['click1'];

            $data['confirm'] = "confirm";
            $data['nama'] = $this->session->userdata('nama');

            $data['kode_perumahan'] = $kode_perumahan;
            $data['unit'] = $unit;
            // $data['id_air'] = $id_air;
            $data['id_maintenance'] = $id_maintenance;

            foreach($this->db->get_where('rumah', array('kode_rumah'=>$unit, 'kode_perumahan'=>$kode_perumahan))->result() as $row){
                $data['nama_pemilik'] = $row->nama_pemilik;
                $data['hp_pemilik'] = $row->hp_pemilik;
                // $data['']
            }

            $data['succ_msg'] = $this->session->flashdata('succ_msg');

            $this->load->view('kasir/home', $data);
            // redirect('Kasir/');
        } else {
            $id_air = $_POST['click'];
            $id_maintenance = $_POST['click1'];

            $data['confirm'] = "confirm";
            $data['nama'] = $this->session->userdata('nama');

            $data['kode_perumahan'] = $kode_perumahan;
            $data['unit'] = $unit;
            $data['id_air'] = $id_air;
            $data['id_maintenance'] = $id_maintenance;

            foreach($this->db->get_where('rumah', array('kode_rumah'=>$unit, 'kode_perumahan'=>$kode_perumahan))->result() as $row){
                $data['nama_pemilik'] = $row->nama_pemilik;
                $data['hp_pemilik'] = $row->hp_pemilik;
                // $data['']
            }

            $data['succ_msg'] = $this->session->flashdata('succ_msg');

            $this->load->view('kasir/home', $data);
        }
    }

    public function konfirmasi_pembayaran(){
        $id_struk = 1;
        
        $this->db->order_by("id_struk", "DESC");
        $this->db->limit(1);
        $query = $this->db->get_where('konsumen_struk');
        foreach($query->result() as $row){
            $id_struk = $row->id_struk + 1;
        }

        $id_air = $_POST['id_air'];
        $jenis_tagihan = $_POST['jenis_tagihan'];
        $item = $_POST['list'];
        $nominal = $_POST['nominal'];

        $nama_pemilik = $_POST['nama_pemilik'];
        $hp_pemilik = $_POST['hp_pemilik'];
        $grand_total = $_POST['grand_total'];
        // $pembayaran = $_POST['nominal_pembayaran'];
        // $jenis_pembayaran = $_POST['cara_pembayaran'];
        // $bank = $_POST['bank'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $unit = $_POST['unit'];

        $id_created_by = $this->session->userdata('u_id');
        $created_by = $this->session->userdata('nama');
        $date_by = date('Y-m-d H:i:sa am/pm');
        
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
 
        $image_name='struk_byr_air_mt_'.$id_struk.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = base_url()."Kasir/print_struk?id=".$id_struk; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $data = array(
            'id_struk'=>$id_struk,
            'tgl_struk'=>$date_by,
            'pembuat_struk'=>$created_by,
            'grand_total'=>$grand_total,
            // 'pembayaran'=>$pembayaran,
            'nama_pemilik'=>$nama_pemilik,
            'hp_pemilik'=>$hp_pemilik,
            // 'jenis_pembayaran'=>$jenis_pembayaran,
            // 'id_bank'=>$bank,
            'kode_perumahan'=>$kode_perumahan,
            'kode_rumah'=>$unit,
            'qr_code'=>$image_name,
            'status'=>"diajukan"
        );

        $this->db->insert('konsumen_struk', $data);
        
        for($i = 0; $i < count($id_air); $i++){
            $data1 = array(
                'id_struk'=>$id_struk,
                'id_tagihan'=>$id_air[$i],
                'jenis_tagihan'=>$jenis_tagihan[$i],
                'nama_pemilik'=>$nama_pemilik,
                'hp_pemilik'=>$hp_pemilik,
                'item'=>$item[$i],
                'nominal'=>$nominal[$i],
                // 'cara_pembayaran'=>$jenis_pembayaran,
                // 'id_bank'=>$bank,
                'id_created_by'=>$id_created_by,
                'created_by'=>$created_by,
                'date_by'=>$date_by,
                'kode_perumahan'=>$kode_perumahan,
                'kode_rumah'=>$unit
            );

            $this->db->insert('konsumen_struk_item', $data1);

            if($jenis_tagihan[$i] == "air"){
                $data2 = array(
                    'status'=>"diajukan"
                );
    
                $this->db->update('konsumen_air', $data2, array('id_air'=>$id_air[$i]));
            } else {
                $data2 = array(
                    'status'=>"diajukan"
                );

                $this->db->update('konsumen_maintenance', $data2, array('id_maintenance'=>$id_air[$i]));
            }
        }
        
        $this->session->set_flashdata('succ_msg', "Pembayaran Berhasil!");

        redirect('Kasir/');
    }

    public function riwayat_pembayaran(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('konsumen_struk', array('status'=>"lunas"));
        $data['check_all2'] = $this->db->get_where('konsumen_struk', array('status'=>"dibatalkan"));

        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['succ_msg1'] = $this->session->flashdata('succ_msg1');
        
        $this->load->view('kasir/riwayat_pembayaran', $data);
    }

    public function filter_riwayat_pembayaran(){
        $cara_pembayaran = $_POST['cara_pembayaran'];
        

        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('konsumen_struk', array('status'=>"lunas"));
        $data['check_all2'] = $this->db->get_where('konsumen_struk', array('status'=>"dibatalkan"));

        $data['err_msg'] = $this->session->flashdata('err_msg');
        $data['succ_msg'] = $this->session->flashdata('succ_msg');
        $data['succ_msg1'] = $this->session->flashdata('succ_msg1');
        
        $this->load->view('kasir/riwayat_pembayaran', $data);
    }

    public function get_riwayat_struk(){
        $id = $_POST['country'];

        $ttl=0;
        foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$id))->result() as $row){
            echo "
                <tr>
                    <td>$row->item</td>
                    <td>Rp. ".number_format($row->nominal)."</td>
                </tr>
            ";
        $ttl = $ttl+$row->nominal;}
        echo "
            <tr style='background-color: pink'>
                <td>Total</td>
                <td>Rp. ".number_format($ttl)."</td>
            </tr>
        ";
    }

    public function hapus_struk(){
        $id = $_GET['id'];

        foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$id))->result() as $row){
            if($row->jenis_tagihan == "air"){
                $data = array(
                  'status'=>"belum lunas"
                );
        
                $this->db->update('konsumen_air', $data, array('id_air'=>$row->id_tagihan));
            } else {
                $data = array(
                  'status'=>"belum lunas"
                );
        
                $this->db->update('konsumen_maintenance', $data, array('id_maintenance'=>$row->id_tagihan));
            }
        }

        $data1 = array(
            'status'=>"dibatalkan",
            'status_date'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('konsumen_struk', $data1, array('id_struk'=>$id));

        // $this->db->delete('konsumen_struk', array('id_struk'=>$id));

        // $this->db->delete('konsumen_struk_item', array('id_struk'=>$id));

        $this->session->set_flashdata('err_msg', "Pembayaran dibatalkan!");

        redirect('Kasir/riwayat_pembayaran');
    }

    public function hapus_slip(){
        $id = $_GET['id'];

        foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$id))->result() as $row){
            if($row->jenis_tagihan == "air"){
                $data = array(
                  'status'=>"belum lunas"
                );
        
                $this->db->update('konsumen_air', $data, array('id_air'=>$row->id_tagihan));
            } else {
                $data = array(
                  'status'=>"belum lunas"
                );
        
                $this->db->update('konsumen_maintenance', $data, array('id_maintenance'=>$row->id_tagihan));
            }
        }

        $data1 = array(
            'status'=>"dibatalkan",
            'status_date'=>date('Y-m-d H:i:sa am/pm')
        );

        $this->db->update('konsumen_struk', $data1, array('id_struk'=>$id));

        // $this->db->delete('konsumen_struk', array('id_struk'=>$id));

        // $this->db->delete('konsumen_struk_item', array('id_struk'=>$id));

        $this->session->set_flashdata('err_msg', "Pembayaran dibatalkan!");

        redirect('Kasir/data_slip_tagihan');
    }

    public function print_struk(){
        $id = $_GET['id'];

        $data['check_all'] = $this->db->get_where('konsumen_struk', array('id_struk'=>$id));
        foreach($data['check_all']->result() as $row){
            $nama = $row->nama_pemilik;
            $tgl_struk = $row->tgl_struk;
        }
        $data['check_all_item'] = $this->db->get_where('konsumen_struk_item', array('id_struk'=>$id));

        $data['id'] = $id;
        
        $this->load->library('pdf');
            
        $this->pdf->setPaper('A5', 'portrait');
        $this->pdf->filename = "Print Struk No ".$id." ".$nama." ".$tgl_struk;
        ob_end_clean();
        $this->pdf->load_view('kasir/print_struk', $data);
    }
    //END OF KASIR


    //START OF SURAT PEMBERITAHUAN
    public function data_surat_pemberitahuan(){
        $data['nama'] = $this->session->userdata('nama');

        $this->db->order_by('id_slip', "DESC");
        $data['check_all'] = $this->db->get_where('konsumen_slip_tagihan');
        $data['err_msg'] = $this->session->flashdata('err_msg');

        $this->load->view('kasir/surat_pemberitahuan_management', $data);
    }

    public function generate_surat_pemberitahuan(){
        $bln = $_POST['bln'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $keterangan = $_POST['keterangan'];

        $this->db->where("DATE_FORMAT(tgl_slip,'%Y-%m') =", date('Y-m', strtotime($bln)));
        $this->db->where('kode_perumahan', $kode_perumahan);
        $check_exist = $this->db->get('konsumen_slip_tagihan');

        $config['upload_path']          = './asset/surat_pemberitahuan/';
        $config['allowed_types']        = 'pdf';
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('berkas'))
        {
            // $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('err_msg', $this->upload->display_errors());

            redirect('Kasir/data_surat_pemberitahuan');
        }
        else
        {
            if($check_exist->num_rows() > 0){
                $this->session->set_flashdata('err_msg', "Data telah ada!");
    
                redirect('Kasir/data_surat_pemberitahuan');
            } else {
                foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $prmh){
                    foreach($this->db->get_where('perusahaan', array('kode_perusahaan'=>$prmh->kode_perusahaan))->result() as $prsh){
                        $kop_surat = $prsh->file_name;
                        $nama_perusahaan = $prsh->nama_perusahaan;
                        $nama_perumahan = $prmh->nama_perumahan;
                    }
                }
    
                $hari = date('M', strtotime($bln));
                $d = date('d', strtotime($bln));
                $m = date('m', strtotime($bln));
                $y = date('Y', strtotime($bln));
    
                if($hari == "Jan") {
                    $hasil = "Januari";
                }elseif($hari == "Feb") {
                    $hasil = "Febuari";
                }elseif($hari == "Mar") {
                    $hasil = "Maret";
                }elseif($hari == "Apr") {
                    $hasil = "April";
                }elseif($hari == "May") {
                    $hasil = "Mei";
                }elseif($hari == "Jun") {
                    $hasil = "Juni";
                }elseif($hari == "Jul") {
                    $hasil = "Juli";
                }elseif($hari == "Aug") {
                    $hasil = "Agustus";
                }elseif($hari == "Sep") {
                    $hasil = "September";
                }elseif($hari == "Oct") {
                    $hasil = "Oktober";
                }elseif($hari == "Nov") {
                    $hasil = "November";
                }else{
                    $hasil = "Desember";
                }
    
                $pdf_name = "Slip_Tagihan_Bulan_".date("m-Y", strtotime($bln));
                $tgl_berkas = date('d', strtotime($bln))." ".$hasil." ".date('Y', strtotime($bln));
    
                $html = "
                    <html><head>
                        <meta charset='utf-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1'>
                        <style>
                        @page { margin: 180px 50px 90px; }
                        #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px;}
                        #header img { position: fixed; left: 50px; top: -150px; right: 0px; height: 25px; text-align: center}
                        #header p { position: fixed; left: 300px; top: -115px; right: 0px}
                        #header h1 { position: fixed; left: 300px; top: -160px; right: 0px; font-size: large}
                        #header hr { position: fixed; top: -50px; right: 0px; font-size: large; border-top: 1px solid}
                        #footer { position: fixed; left: 0px; bottom: -130px; right: 0px; height: 150px; }
                        #footer .page:after { content: counter(page); }
                        /* @font-face {
                            font-family: 'Elegance';
                            font-weight: normal;
                            font-style: normal;
                            font-variant: normal;
                            src: url('http://eclecticgeek.com/dompdf/fonts/Elegance.ttf') format('truetype');
                            }
                            body {
                            font-family: Elegance, sans-serif;
                            } */
                        </style>
                        <link rel='stylesheet' href='<?php echo base_url()?>/assets/css/bootstrap.min.css' />
                        <script src='<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>
                        <script src='<?php echo base_url()?>asset/plugins/jquery/jquery.min.js'></script>
                    </head><body>
                        <div id='header'>
                                <img src='./gambar/$kop_surat?>' style='height: 100px; width: 225px'>
                                <div style='position: fixed; left: 300px; top: -140px; right: 0px; font-size: large; font-weight: bold'>$nama_perusahaan</div>
                            <?php }}?>
                                <p>
                                    MSGroup Business Center<br/>
                                    Jl. Perdana No. 168 - Pontianak<br/>
                                    HP: 0813.2793.5678<br/>
                                </p>
                            <hr>
                        </div>
                        <div id='footer'>
                            <hr style='border-top: 1px solid'>
                            <p class='page'><span style='font-weight: bold'><i>Surat Pemberitahuan Pembayaran - $nama_perumahan Residence</i></span> <span style='padding-left:200px'> Halaman </span></p>
                        </div>
                        <div id='content' style='font-size: 12px'>
                            <div style='text-align: right'>
                                Pontianak, $tgl_berkas
                            </div>
                            <div style='font-size: 13px'>
                                <table>
                                    <tr>
                                        <td>Nomor</td>
                                        <td style='padding-left: 20px'>:</td>
                                        <td style='padding-left: 5px'>001/$kode_perumahan/$d/$m/$y</td>
                                    </tr>
                                    <tr>
                                        <td>Perihal</td>
                                        <td style='padding-left: 20px'>:</td>
                                        <td style='padding-left: 5px'>Surat Pemberitahuan</td>
                                    </tr>
                                    <tr>
                                        <td>Lampiran</td>
                                        <td style='padding-left: 20px'>:</td>
                                        <td style='padding-left: 5px'>1 Lembar</td>
                                    </tr>
                                </table>
                            </div>
                            <br>
                            <div style='font-size: 13px'>
                                Kepada Yth, <br>
                                Bapak/Ibu/Saudara/i <br>
                                di Tempat,
                            </div>
                            <br>
                            <div style='font-size: 13px'>
                                Dengan hormat,
                            </div>
                            <br>
                            <div style='text-align: justify; font-size: 13px'>
                                Bersama dengan surat ini, kami selaku managemen $nama_perumahan Residence ingin memberitahukan kepada Bapak/Ibu/Saudara/i untuk melakukan pembayaran dengan ketentuan sebagai berikut terhitung sejak diterbitkannya surat pemberitahuan ini :
                            </div>
                            <div style='text-align: justify; font-size: 12px'>
                                <ol type='1'>
                                    <li>
                                        Bagi konsumen yang tinggal dan tidak tinggal didalam komplek $nama_perumahan Residence dan memiliki meteran serta menggunakan air mandiri maka akan dikenakan biaya abodemen sebesar Rp 150.000,- (seratus lima puluh ribu rupiah) termasuk biaya keamanan dan kebersihan lingkungan.
                                    </li>
                                    <li>
                                        Bagi konsumen yang tinggal atau tidak tinggal didalam kompelk $nama_perumahan Residence dan tidak menggunakan air mandiri cukup membayar biaya keamanan dan kebersihan lingkungan sebesar Rp 70.000,- (tujuh puluh ribu rupiah) dan meteran air yang sudah terpasang akan dicabut.
                                    </li>
                                    <li>
                                        Penggunaan air mandiri setiap bulannya tidak melebihi dari 20 kubik (m3). Jika melebihi dari pemakaian yang ditentukan maka akan dikenakan biaya tambahan sebesar Rp. 5.000,- (lima ribu rupiah)/kubik.
                                    </li>
                                    <li>
                                        Bagi konsumen yang merasa keberatan dengan jumlah yang disebutkan diatas maka meteran air yang sudah terpasang akan dicabut.
                                    </li>
                                    <li>
                                        Jika konsumen ingin memasang ulang meteran air akan dikenakan biaya sebesar Rp 1.500.000,- (satu juta lima ratus ribu rupiah).
                                    </li>
                                <ol>
                            </div>
                            <br>
                            <div style='text-align: justify; font-size: 13px'>
                                Penggunaan air mandiri sejak Tahun 2020 hingga bulan April 2021 diputihkan, oleh sebab itu surat ini diterbitkan sebagaimana mestinya dan terhitung dari tanggal Mei 2021 dimulainya pembayaran dari pemakaian hal tersebut. Sehingga Bapak/Ibu/Saudara/i bisa melakukan pembayaran ke kantor pemasaran MS Gardenia Residence atau transfer melakui bank <b>BCA 0292607839</b> an <b>Ediyanto</b>
                            </div>
                            <br>
                            <div style='text-align: justify; font-size: 13px'>
                                Demikian surat pemberitahuan ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.
                            </div>
                            <br> <br> <br>
                            <div style='font-size: 13px'>
                                <table style='padding-left: 450px; text-align: center'>
                                    <tr>
                                        <td>Hormat kami,</td>
                                    </tr>
                                    <tr>
                                        <td><img src='./gambar/produksi/manager_sign.png' style='height: 100px; width: 100px'></td>
                                    </tr>
                                    <tr>
                                        <td>Hendra Hartady</td>
                                    </tr>
                                    <tr>
                                        <td>Manager Produksi $nama_perumahan</td>
                                    </tr>
                                </table>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div style='color: grey; font-size: 10px'>
                                *  <i>pembayaran dilakukan tanggal 5 setiap bulannya</i> <br>
                                ** <i>pembayaran paling lambat tanggal 8 setiap bulannya</i>
                            </div>
                        </div>
                    </body></html>
                ";
                
                // $this->load->library('pdf');
    
                // $this->pdf->load_html($html);    
                // $this->pdf->render();
                // $pdf = $this->pdf->output();
                // $file_location = $_SERVER['DOCUMENT_ROOT']."/DPMS/asset/surat_pemberitahuan/".$pdf_name.".pdf";
                // file_put_contents($file_location,$pdf); 
                $upload = array('upload_data' => $this->upload->data());

                $file_name = $upload['upload_data']['file_name'];
    
                $data = array(
                    'tgl_slip'=>$bln,
                    'pembuat_slip'=>$this->session->userdata('nama'),
                    'file_name'=>$file_name,
                    'keterangan'=>$keterangan,
                    'kode_perumahan'=>$kode_perumahan,
                    'created_by'=>$this->session->userdata('nama'),
                    'date_by'=>date('Y-m-d H:i:sa am/pm')
                );
    
                $this->db->insert('konsumen_slip_tagihan', $data);
    
                redirect('Kasir/data_surat_pemberitahuan');
            }
        }
    }

    public function hapus_surat_pemberitahuan(){
        $id = $_GET['id'];
        $file = $_GET['file'];

        unlink('asset/surat_pemberitahuan/'.$file);

        $this->db->delete('konsumen_slip_tagihan', array('id_slip'=>$id));

        $this->session->set_flashdata('err_msg', "Berkas telah dihapus!");

        redirect('Kasir/data_surat_pemberitahuan');
    }

    //START OF SLIP TAGIHAN
    public function data_slip_tagihan(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('konsumen_struk', array('status'=>"diajukan"));
    
        $this->load->view('kasir/slip_tagihan_management', $data);
    }

    public function pelunasan_struk(){
        $id_struk = $_POST['id_struk'];
        $cara_pembayaran = $_POST['cara_pembayaran'];
        $bank = $_POST['bank'];
        $nominal_pembayaran = $_POST['nominal_pembayaran'];
        $keterangan = $_POST['keterangan'];

        if($cara_pembayaran == "cicilan"){
            $data = array(
                'jenis_pembayaran' => $cara_pembayaran,
                'pembayaran' => $nominal_pembayaran,
                'id_bank' => $bank,
                'keterangan' => $keterangan,
                'status' => "cicilan",
                'status_date'=>date('Y-m-d H:i:sa am/pm')
            );

            $this->db->update('konsumen_struk', $data, array('id_struk'=>$id_struk));

            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$id_struk))->result() as $row){
                $jns_tgh = $row->jenis_tagihan;
                $id_air = $row->id_tagihan;

                if($jns_tgh == "air"){
                    $data1 = array(
                        'status'=>"cicilan"
                    );

                    $this->db->update('konsumen_air', $data1, array('id_air'=>$id_air));
                } else {
                    $data1 = array(
                        'status'=>"cicilan"
                    );
                    
                    $this->db->update('konsumen_maintenance', $data1, array('id_maintenance'=>$id_air));
                }
            }

            // $this->session->set_flashdata('succ_msg1', "Tagihan telah dilunaskan/dibayarkan!");

            redirect('Kasir/cicilan_pembayaran');
        } else {
            $data = array(
                'jenis_pembayaran' => $cara_pembayaran,
                'pembayaran' => $nominal_pembayaran,
                'id_bank' => $bank,
                'keterangan' => $keterangan,
                'status' => "lunas",
                'status_date'=>date('Y-m-d H:i:sa am/pm')
            );

            $this->db->update('konsumen_struk', $data, array('id_struk'=>$id_struk));

            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$id_struk))->result() as $row){
                $jns_tgh = $row->jenis_tagihan;
                $id_air = $row->id_tagihan;

                if($jns_tgh == "air"){
                    $data1 = array(
                        'status'=>"lunas"
                    );

                    $this->db->update('konsumen_air', $data1, array('id_air'=>$id_air));
                } else {
                    $data1 = array(
                        'status'=>"lunas"
                    );
                    
                    $this->db->update('konsumen_maintenance', $data1, array('id_maintenance'=>$id_air));
                }
            }

            $this->session->set_flashdata('succ_msg1', "Tagihan telah dilunaskan/dibayarkan!");

            redirect('Kasir/riwayat_pembayaran');
        }
    }

    public function print_slip(){
        $id = $_GET['id'];

        $data['check_all'] = $this->db->get_where('konsumen_struk', array('id_struk'=>$id));
        $data['check_all_item'] = $this->db->get_where('konsumen_struk_item', array('id_struk'=>$id));

        $data['id'] = $id;
        
        $this->load->library('pdf');
            
        $this->pdf->setPaper('A5', 'portrait');
        $this->pdf->filename = "Print Slip Tagihan No ".$id."pdf";
        ob_end_clean();
        $this->pdf->load_view('kasir/print_slip_tagihan', $data);
    }

    public function generate_slip_tagihan_auto(){
        $bln = $_POST['bln'];
        $kode_perumahan = $_POST['kode_perumahan'];

        $query = $this->db->get_where('rumah', array('kode_perumahan'=>$kode_perumahan));

        foreach($query->result() as $row){
            $unit = $row->kode_rumah;
            $kode_perumahan = $row->kode_perumahan;

            $unit_arr = explode(", ", $unit);

            for($i = 0; $i < count($unit_arr); $i++){
                $this->db->where("DATE_FORMAT(tgl_struk,'%Y-%m') =", date('Y-m', strtotime($bln)));
                $this->db->where('kode_rumah', $unit_arr[$i]);
                $this->db->where('kode_perumahan', $kode_perumahan);
                $this->db->where('status <>', "dibatalkan");
                // $this->db->where("(status='diajukan' OR status='lunas'", NULL, FALSE);
                $check_exist = $this->db->get('konsumen_struk');

                // print_r($check_exist->num_rows());
                // exit;

                if($check_exist->num_rows() == 0){
                    $query1 = $this->db->get_where('konsumen_struk', array('kode_rumah'=>$unit_arr[$i], 'kode_perumahan'=>$kode_perumahan, 'status'=>"diajukan"));

                    // $query2 = $this->db->get_where('konsumen_air', array(''));
                    // $query3 = $this->db->get_where('konsumen_maintenance', array(''));
                    foreach($query1->result() as $row1){
                        $query2 = $this->db->get_where('konsumen_struk_item', array('id_struk'=>$row1->id_struk, 'jenis_tagihan'=>"air"));

                        foreach($query2->result() as $row2){
                            $kons_air = $this->db->get_where('konsumen_air', array('id_air'=>$row2->id_tagihan));

                            foreach($kons_air->result() as $kons_air_row){
                                $data_air = array(
                                    'status'=>"belum lunas"
                                );

                                $this->db->update('konsumen_air', $data_air, array('id_air'=>$kons_air_row->id_air));
                            }
                        }

                        $query3 = $this->db->get_where('konsumen_struk_item', array('id_struk'=>$row1->id_struk, 'jenis_tagihan'=>"maintenance"));

                        foreach($query3->result() as $row3){
                            $kons_main = $this->db->get_where('konsumen_maintenance', array('id_maintenance'=>$row3->id_tagihan));
                            
                            foreach($kons_main->result() as $kons_main_row){
                                $data_main = array(
                                    'status'=>"belum lunas"
                                );

                                $this->db->update('konsumen_maintenance', $data_main, array('id_maintenance'=>$kons_main_row->id_maintenance));
                            }
                        }

                        // print_r($query2->result());

                        $data = array(
                            'status'=>"dibatalkan"
                        );
        
                        $this->db->update('konsumen_struk', $data, array('id_struk'=>$row1->id_struk));
                    }

                    $id_struk = 1;
            
                    $this->db->order_by("id_struk", "DESC");
                    $this->db->limit(1);
                    $querys = $this->db->get_where('konsumen_struk');
                    foreach($querys->result() as $rows){
                        $id_struk = $rows->id_struk + 1;
                    }

                    foreach($this->db->get_where('rumah', array('kode_rumah'=>$unit_arr[$i], 'kode_perumahan'=>$kode_perumahan))->result() as $rows1){
                        $nama_pemilik = $rows1->nama_pemilik;
                        $hp_pemilik = $rows1->hp_pemilik;
                    }
                    $unit = $unit_arr[$i];
                    $grand_total = 0;
                    $id_created_by = $this->session->userdata('u_id');
                    $created_by = $this->session->userdata('nama');
                    $date_by = date('Y-m-d H:i:sa am/pm');

                    // $id_air = $_POST['id_air'];
                    // $jenis_tagihan = $_POST['jenis_tagihan'];
                    // $item = $_POST['list'];
                    // $nominal = $_POST['nominal'];
                    $querys1 = $this->db->get_where('konsumen_air', array('kode_rumah'=>$unit_arr[$i], 'kode_perumahan'=>$kode_perumahan, 'status'=>"belum lunas"));
                    $querys2 = $this->db->get_where('konsumen_maintenance', array('kode_rumah'=>$unit_arr[$i], 'kode_perumahan'=>$kode_perumahan, 'status'=>"belum lunas"));

                    foreach($querys1->result() as $rows_air){
                        $id_air = $rows_air->id_air;
                        $jenis_tagihan = "air";
                        
                        // echo $rows->bulan_tagihan;

                        $datestring= date('Y-m-d', strtotime($rows_air->bulan_tagihan)).' first day of last month';
                        $dt=date_create($datestring);
                        echo $dt->format('F Y'); //2011-02

                        // exit;
                        
                        $item = "Pembayaran Abodemen dan Air Bulan ".$dt->format('F Y');

                        // echo $item;
                        // exit;
                        $nominal = $rows_air->total_harga;

                        $data1 = array(
                            'id_struk'=>$id_struk,
                            'id_tagihan'=>$id_air,
                            'jenis_tagihan'=>$jenis_tagihan,
                            'nama_pemilik'=>$nama_pemilik,
                            'hp_pemilik'=>$hp_pemilik,
                            'item'=>$item,
                            'nominal'=>$nominal,
                            // 'cara_pembayaran'=>$jenis_pembayaran,
                            // 'id_bank'=>$bank,
                            'id_created_by'=>$id_created_by,
                            'created_by'=>$created_by,
                            'date_by'=>$date_by,
                            'kode_perumahan'=>$kode_perumahan,
                            'kode_rumah'=>$unit
                        );

                        $this->db->insert('konsumen_struk_item', $data1);

                        $data2 = array(
                            'status'=>"diajukan"
                        );
            
                        $this->db->update('konsumen_air', $data2, array('id_air'=>$id_air));

                        // if($jenis_tagihan[$i] == "air"){
                        // } else {
                        //     $data2 = array(
                        //         'status'=>"diajukan"
                        //     );

                        //     $this->db->update('konsumen_maintenance', $data2, array('id_maintenance'=>$id_air[$i]));
                        // }
                        $grand_total = $grand_total + $rows_air->total_harga;
                    }

                    foreach($querys2->result() as $rows_main){
                        $id_air = $rows_main->id_maintenance;
                        $jenis_tagihan = "maintenance";
                        
                        $datestring= date('Y-m-d', strtotime($rows_main->bulan_tagihan)).' first day of last month';
                        $dt=date_create($datestring);
                        echo $dt->format('F Y'); //2011-02

                        $item = "Pembayaran Keamanan dan Kebersihan Bulan ".$dt->format('F Y');
                        $nominal = $rows_main->nominal;

                        $data1 = array(
                            'id_struk'=>$id_struk,
                            'id_tagihan'=>$id_air,
                            'jenis_tagihan'=>$jenis_tagihan,
                            'nama_pemilik'=>$nama_pemilik,
                            'hp_pemilik'=>$hp_pemilik,
                            'item'=>$item,
                            'nominal'=>$nominal,
                            // 'cara_pembayaran'=>$jenis_pembayaran,
                            // 'id_bank'=>$bank,
                            'id_created_by'=>$id_created_by,
                            'created_by'=>$created_by,
                            'date_by'=>$date_by,
                            'kode_perumahan'=>$kode_perumahan,
                            'kode_rumah'=>$unit
                        );

                        $this->db->insert('konsumen_struk_item', $data1);

                        $data2 = array(
                            'status'=>"diajukan"
                        );

                        $this->db->update('konsumen_maintenance', $data2, array('id_maintenance'=>$id_air));

                        // if($jenis_tagihan[$i] == "air"){
                        //     $data2 = array(
                        //         'status'=>"diajukan"
                        //     );
                
                        //     $this->db->update('konsumen_air', $data2, array('id_air'=>$id_air[$i]));
                        // } else {
                        // }
                        $grand_total = $grand_total + $rows_main->nominal;
                    }
                    // $nama_pemilik = $_POST['nama_pemilik'];
                    // $hp_pemilik = $_POST['hp_pemilik'];
                    // $grand_total = $_POST['grand_total']
                    // $pembayaran = $_POST['nominal_pembayaran'];
                    // $jenis_pembayaran = $_POST['cara_pembayaran'];
                    // $bank = $_POST['bank'];
                    // $kode_perumahan = ;

                    $id_created_by = $this->session->userdata('u_id');
                    $created_by = $this->session->userdata('nama');
                    $date_by = date('Y-m-d H:i:sa am/pm');
                    
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
            
                    $image_name='struk_byr_air_mt_'.$id_struk.'.png'; //buat name dari qr code sesuai dengan nim
            
                    $params['data'] = base_url()."Kasir/print_struk?id=".$id_struk; //data yang akan di jadikan QR CODE
                    $params['level'] = 'H'; //H=High
                    $params['size'] = 10;
                    $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
                    $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

                    $data = array(
                        'id_struk'=>$id_struk,
                        'tgl_struk'=>$bln,
                        'pembuat_struk'=>$created_by,
                        'grand_total'=>$grand_total,
                        // 'pembayaran'=>$pembayaran,
                        'nama_pemilik'=>$nama_pemilik,
                        'hp_pemilik'=>$hp_pemilik,
                        // 'jenis_pembayaran'=>$jenis_pembayaran,
                        // 'id_bank'=>$bank,
                        'kode_perumahan'=>$kode_perumahan,
                        'kode_rumah'=>$unit,
                        'qr_code'=>$image_name,
                        'status'=>"diajukan"
                    );

                    $this->db->insert('konsumen_struk', $data);
                } 
            }
        }
        $this->session->set_flashdata('succ_msg', "Pembuatan Slip Tagihan Berhasil!");

        redirect('Kasir/data_slip_tagihan');
    }

    public function batal_all_slip_tagihan(){
        $query = $this->db->get_where('konsumen_struk', array('status'=>"diajukan"))->result();
        // $id = $_GET['id'];
        foreach($query as $res){
            $id = $res->id_struk;

            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$id))->result() as $row){
                if($row->jenis_tagihan == "air"){
                    $data = array(
                    'status'=>"belum lunas"
                    );
            
                    $this->db->update('konsumen_air', $data, array('id_air'=>$row->id_tagihan));
                } else {
                    $data = array(
                    'status'=>"belum lunas"
                    );
            
                    $this->db->update('konsumen_maintenance', $data, array('id_maintenance'=>$row->id_tagihan));
                }
            }

            $data1 = array(
                'status'=>"dibatalkan",
                'status_date'=>date('Y-m-d H:i:sa am/pm')
            );

            $this->db->update('konsumen_struk', $data1, array('id_struk'=>$id));
        }

        $this->session->set_flashdata('succ_msg', "Data berhasil dihapus semua!");

        redirect('Kasir/data_slip_tagihan');
    }

    public function edit_keterangan_struk(){
        $id_struk = $_POST['id_struk'];
        $keterangan = $_POST['keterangan'];

        for($i = 0; $i < count($id_struk); $i++){
            $data = array(
                'keterangan'=>$keterangan[$i],
            );

            $this->db->update('konsumen_struk', $data, array('id_struk'=>$id_struk[$i]));
        }

        redirect('Kasir/riwayat_pembayaran');
    }

    //START OF REKAP LAPORAN PEMBAYARAN
    public function rekap_laporan_pembayaran(){
        $data['nama'] = $this->session->userdata('nama');

        $this->load->view('kasir/rekap_laporan_pembayaran', $data);
    }

    public function preview_export_tagihan(){
        $data['nama'] = $this->session->userdata('nama');

        $bln = $_POST['bln'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $data['bln'] = $bln;
        $data['kode_perumahan'] = $kode_perumahan;

        $this->db->where("DATE_FORMAT(tgl_struk,'%Y-%m') =", date('Y-m', strtotime($bln)));
        $this->db->where('status <>', "dibatalkan");
        $this->db->where('kode_perumahan', $kode_perumahan);
        $this->db->order_by('kode_rumah', "ASC");
        $data['check_all'] = $this->db->get('konsumen_struk');

        $this->load->view('kasir/pre_export_tagihan', $data);
    }

    public function export_tagihan(){
        $bln = $_GET['bln'];
        $kode_perumahan = $_GET['kode'];

        $this->db->where("DATE_FORMAT(tgl_struk,'%Y-%m') =", date('Y-m', strtotime($bln)));
        $this->db->where('status <>', "dibatalkan");
        $this->db->where('kode_perumahan', $kode_perumahan);
        $this->db->order_by('kode_rumah', "ASC");
        $semua_pengguna = $this->db->get('konsumen_struk');

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $prmh){
            $nama_perumahan = $prmh->nama_perumahan;
        }

        $spreadsheet = new Spreadsheet;

        $spreadsheet->getActiveSheet()->mergeCells("A1:M1")
                    ->setCellValue('A1', 'List Pembayaran Abodemen Air Serta Keamanan dan Kebersihan Lingkungan');

        $spreadsheet->getActiveSheet()->mergeCells("A2:M2")
                    ->setCellValue('A2', $nama_perumahan);

        $spreadsheet->getActiveSheet()->mergeCells("A5:A6")
                    ->setCellValue('A5', 'No');
        $spreadsheet->getActiveSheet()->mergeCells("B5:B6")
                    ->setCellValue('B5', 'Unit');
        $spreadsheet->getActiveSheet()->mergeCells("C5:C6")
                    ->setCellValue('C5', 'Nama Konsumen/Pemakai');

        $spreadsheet->getActiveSheet()->mergeCells("D5:G5")
                    ->setCellValue('D5', 'Pemakaian');
        $spreadsheet->getActiveSheet()->mergeCells("H5:K5")
                    ->setCellValue('H5', 'Pembayaran');

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A3', 'Periode')
                    ->setCellValue('M3', date('F Y', strtotime($bln)))
                    ->setCellValue('D6', 'Abodemen')
                    ->setCellValue('E6', 'Keamanan dan Ketertiban')
                    ->setCellValue('F6', 'Charge')
                    ->setCellValue('G6', 'Kubikasi')
                    ->setCellValue('H6', 'Total Charge')
                    ->setCellValue('I6', 'Tunai')
                    ->setCellValue('J6', 'Transfer')
                    ->setCellValue('K6', 'Total Harga');

        $spreadsheet->getActiveSheet()->mergeCells("L5:L6")
                    ->setCellValue('L5', 'Tanggal Bayar');
        $spreadsheet->getActiveSheet()->mergeCells("M5:M6")
                    ->setCellValue('M5', 'Keterangan');

        foreach(range('A','M') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        // $spreadsheet->getStyle('A1:M6')->getAlignment->setHorizontal('center');
        $spreadsheet->getActiveSheet()
                    ->getStyle('A1:M6')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
                    ->getStyle('A5:M6')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE)
                    ->getStartColor()
                    ->setARGB('add8e6');

        $kolom = 7;
        $nomor = 1;
        foreach($semua_pengguna->result() as $pengguna) {
             
            $ttl_abod = 0;
            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"air"))->result() as $abod){
                $ttl_abod = $ttl_abod + $abod->nominal;
            }
            $ttl_main = 0;
            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"maintenance"))->result() as $main){
                $ttl_main = $ttl_main + $main->nominal;
            }
            $overuse_ttl = 0;
            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"air"))->result() as $row){
                foreach($this->db->get_where('konsumen_air', array('id_air'=>$row->id_tagihan))->result() as $air){
                    if($air->meteran > 20){
                        $overuse_ttl = $overuse_ttl + (ceil($air->meteran) - 20);
                    }
                }
            }

            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $pengguna->kode_rumah)
                        ->setCellValue('C' . $kolom, $pengguna->nama_pemilik)
                        ->setCellValue('D' . $kolom, $ttl_abod)
                        ->setCellValue('E' . $kolom, $ttl_main);

            if($overuse_ttl > 0){
                $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('F' . $kolom, "5000")
                        ->setCellValue('G' . $kolom, $overuse_ttl)
                        ->setCellValue('H' . $kolom, $overuse_ttl * 5000);
            }

            if($pengguna->status == "lunas" && $pengguna->jenis_pembayaran == "cash"){
                $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('I' . $kolom, "Tunai");
            }
            if($pengguna->status == "lunas" && $pengguna->jenis_pembayaran == "transfer"){
                foreach($this->db->get_where('bank', array('id_bank'=>$pengguna->id_bank))->result() as $bank){
                    $spreadsheet->setActiveSheetIndex(0)
                                ->setCellValue('J' . $kolom, "Transfer - ".$bank->nama_bank);
                }
            }

            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $kolom, $ttl_abod + $ttl_main + ($overuse_ttl * 5000))
                        ->setCellValue('L' . $kolom, $pengguna->status_date)
                        ->setCellValue('M' . $kolom, $pengguna->keterangan);

            $kolom++;
            $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Rincian Penagihan Air - Lunas.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function preview_export_tagihan_lunas(){
        $data['nama'] = $this->session->userdata('nama');

        $bln = $_POST['bln'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $data['bln'] = $bln;
        $data['kode_perumahan'] = $kode_perumahan;

        $this->db->where("DATE_FORMAT(tgl_struk,'%Y-%m') =", date('Y-m', strtotime($bln)));
        $this->db->where('status', "lunas");
        $this->db->order_by('kode_rumah', "ASC");
        $data['check_all'] = $this->db->get('konsumen_struk');

        $this->load->view('kasir/pre_export_tagihan_lunas', $data);
    }

    public function export_tagihan_lunas(){
        $bln = $_GET['bln'];
        $kode_perumahan = $_GET['kode'];

        $this->db->where("DATE_FORMAT(tgl_struk,'%Y-%m') =", date('Y-m', strtotime($bln)));
        $this->db->where('status', "lunas");
        $this->db->where('kode_perumahan', $kode_perumahan);
        $this->db->order_by('kode_rumah', "ASC");
        $semua_pengguna = $this->db->get('konsumen_struk');

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $prmh){
            $nama_perumahan = $prmh->nama_perumahan;
        }

        $spreadsheet = new Spreadsheet;

        $spreadsheet->getActiveSheet()->mergeCells("A1:M1")
                    ->setCellValue('A1', 'List Pembayaran Abodemen Air Serta Keamanan dan Kebersihan Lingkungan');

        $spreadsheet->getActiveSheet()->mergeCells("A2:M2")
                    ->setCellValue('A2', $nama_perumahan);

        $spreadsheet->getActiveSheet()->mergeCells("A5:A6")
                    ->setCellValue('A5', 'No');
        $spreadsheet->getActiveSheet()->mergeCells("B5:B6")
                    ->setCellValue('B5', 'Unit');
        $spreadsheet->getActiveSheet()->mergeCells("C5:C6")
                    ->setCellValue('C5', 'Nama Konsumen/Pemakai');

        $spreadsheet->getActiveSheet()->mergeCells("D5:G5")
                    ->setCellValue('D5', 'Pemakaian');
        $spreadsheet->getActiveSheet()->mergeCells("H5:K5")
                    ->setCellValue('H5', 'Pembayaran');

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A3', 'Periode')
                    ->setCellValue('M3', date('F Y', strtotime($bln)))
                    ->setCellValue('D6', 'Abodemen')
                    ->setCellValue('E6', 'Keamanan dan Ketertiban')
                    ->setCellValue('F6', 'Charge')
                    ->setCellValue('G6', 'Kubikasi')
                    ->setCellValue('H6', 'Total Charge')
                    ->setCellValue('I6', 'Tunai')
                    ->setCellValue('J6', 'Transfer')
                    ->setCellValue('K6', 'Total Harga');

        $spreadsheet->getActiveSheet()->mergeCells("L5:L6")
                    ->setCellValue('L5', 'Tanggal Bayar');
        $spreadsheet->getActiveSheet()->mergeCells("M5:M6")
                    ->setCellValue('M5', 'Keterangan');

        foreach(range('A','M') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        // $spreadsheet->getStyle('A1:M6')->getAlignment->setHorizontal('center');
        $spreadsheet->getActiveSheet()
                    ->getStyle('A1:M6')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
                    ->getStyle('A5:M6')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE)
                    ->getStartColor()
                    ->setARGB('add8e6');

        $kolom = 7;
        $nomor = 1;
        foreach($semua_pengguna->result() as $pengguna) {
             
            $ttl_abod = 0;
            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"air"))->result() as $abod){
                $ttl_abod = $ttl_abod + $abod->nominal;
            }
            $ttl_main = 0;
            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"maintenance"))->result() as $main){
                $ttl_main = $ttl_main + $main->nominal;
            }
            $overuse_ttl = 0;
            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"air"))->result() as $row){
                foreach($this->db->get_where('konsumen_air', array('id_air'=>$row->id_tagihan))->result() as $air){
                    if($air->meteran > 20){
                        $overuse_ttl = $overuse_ttl + (ceil($air->meteran) - 20);
                    }
                }
            }

            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $pengguna->kode_rumah)
                        ->setCellValue('C' . $kolom, $pengguna->nama_pemilik)
                        ->setCellValue('D' . $kolom, $ttl_abod)
                        ->setCellValue('E' . $kolom, $ttl_main);

            if($overuse_ttl > 0){
                $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('F' . $kolom, "5000")
                        ->setCellValue('G' . $kolom, $overuse_ttl)
                        ->setCellValue('H' . $kolom, $overuse_ttl * 5000);
            }

            if($pengguna->status == "lunas" && $pengguna->jenis_pembayaran == "cash"){
                $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('I' . $kolom, "Tunai");
            }
            if($pengguna->status == "lunas" && $pengguna->jenis_pembayaran == "transfer"){
                foreach($this->db->get_where('bank', array('id_bank'=>$pengguna->id_bank))->result() as $bank){
                    $spreadsheet->setActiveSheetIndex(0)
                                ->setCellValue('J' . $kolom, "Transfer - ".$bank->nama_bank);
                }
            }

            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $kolom, $ttl_abod + $ttl_main + ($overuse_ttl * 5000))
                        ->setCellValue('L' . $kolom, $pengguna->status_date)
                        ->setCellValue('M' . $kolom, $pengguna->keterangan);

            $kolom++;
            $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Rincian Penagihan Air.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function preview_export_tagihan_diajukan(){
        $data['nama'] = $this->session->userdata('nama');

        $bln = $_POST['bln'];
        $kode_perumahan = $_POST['kode_perumahan'];
        $data['bln'] = $bln;
        $data['kode_perumahan'] = $kode_perumahan;

        $this->db->where("DATE_FORMAT(tgl_struk,'%Y-%m') =", date('Y-m', strtotime($bln)));
        $this->db->where('status', "diajukan");
        $this->db->order_by('kode_rumah', "ASC");
        $data['check_all'] = $this->db->get('konsumen_struk');

        $this->load->view('kasir/pre_export_tagihan_diajukan', $data);
    }

    public function export_tagihan_diajukan(){
        $bln = $_GET['bln'];
        $kode_perumahan = $_GET['kode'];

        $this->db->where("DATE_FORMAT(tgl_struk,'%Y-%m') =", date('Y-m', strtotime($bln)));
        $this->db->where('status', "diajukan");
        $this->db->where('kode_perumahan', $kode_perumahan);
        $this->db->order_by('kode_rumah', "ASC");
        $semua_pengguna = $this->db->get('konsumen_struk');

        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$kode_perumahan))->result() as $prmh){
            $nama_perumahan = $prmh->nama_perumahan;
        }

        $spreadsheet = new Spreadsheet;

        $spreadsheet->getActiveSheet()->mergeCells("A1:M1")
                    ->setCellValue('A1', 'List Pembayaran Abodemen Air Serta Keamanan dan Kebersihan Lingkungan');

        $spreadsheet->getActiveSheet()->mergeCells("A2:M2")
                    ->setCellValue('A2', $nama_perumahan);

        $spreadsheet->getActiveSheet()->mergeCells("A5:A6")
                    ->setCellValue('A5', 'No');
        $spreadsheet->getActiveSheet()->mergeCells("B5:B6")
                    ->setCellValue('B5', 'Unit');
        $spreadsheet->getActiveSheet()->mergeCells("C5:C6")
                    ->setCellValue('C5', 'Nama Konsumen/Pemakai');

        $spreadsheet->getActiveSheet()->mergeCells("D5:G5")
                    ->setCellValue('D5', 'Pemakaian');
        $spreadsheet->getActiveSheet()->mergeCells("H5:K5")
                    ->setCellValue('H5', 'Pembayaran');

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A3', 'Periode')
                    ->setCellValue('M3', date('F Y', strtotime($bln)))
                    ->setCellValue('D6', 'Abodemen')
                    ->setCellValue('E6', 'Keamanan dan Ketertiban')
                    ->setCellValue('F6', 'Charge')
                    ->setCellValue('G6', 'Kubikasi')
                    ->setCellValue('H6', 'Total Charge')
                    ->setCellValue('I6', 'Tunai')
                    ->setCellValue('J6', 'Transfer')
                    ->setCellValue('K6', 'Total Harga');

        $spreadsheet->getActiveSheet()->mergeCells("L5:L6")
                    ->setCellValue('L5', 'Tanggal Bayar');
        $spreadsheet->getActiveSheet()->mergeCells("M5:M6")
                    ->setCellValue('M5', 'Keterangan');

        foreach(range('A','M') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        // $spreadsheet->getStyle('A1:M6')->getAlignment->setHorizontal('center');
        $spreadsheet->getActiveSheet()
                    ->getStyle('A1:M6')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
                    ->getStyle('A5:M6')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE)
                    ->getStartColor()
                    ->setARGB('add8e6');

        $kolom = 7;
        $nomor = 1;
        foreach($semua_pengguna->result() as $pengguna) {
             
            $ttl_abod = 0;
            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"air"))->result() as $abod){
                $ttl_abod = $ttl_abod + $abod->nominal;
            }
            $ttl_main = 0;
            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"maintenance"))->result() as $main){
                $ttl_main = $ttl_main + $main->nominal;
            }
            $overuse_ttl = 0;
            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"air"))->result() as $row){
                foreach($this->db->get_where('konsumen_air', array('id_air'=>$row->id_tagihan))->result() as $air){
                    if($air->meteran > 20){
                        $overuse_ttl = $overuse_ttl + (ceil($air->meteran) - 20);
                    }
                }
            }

            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $pengguna->kode_rumah)
                        ->setCellValue('C' . $kolom, $pengguna->nama_pemilik)
                        ->setCellValue('D' . $kolom, $ttl_abod)
                        ->setCellValue('E' . $kolom, $ttl_main);

            if($overuse_ttl > 0){
                $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('F' . $kolom, "5000")
                        ->setCellValue('G' . $kolom, $overuse_ttl)
                        ->setCellValue('H' . $kolom, $overuse_ttl * 5000);
            }

            if($pengguna->status == "lunas" && $pengguna->jenis_pembayaran == "cash"){
                $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('I' . $kolom, "Tunai");
            }
            if($pengguna->status == "lunas" && $pengguna->jenis_pembayaran == "transfer"){
                foreach($this->db->get_where('bank', array('id_bank'=>$pengguna->id_bank))->result() as $bank){
                    $spreadsheet->setActiveSheetIndex(0)
                                ->setCellValue('J' . $kolom, "Transfer - ".$bank->nama_bank);
                }
            }

            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $kolom, $ttl_abod + $ttl_main + ($overuse_ttl * 5000))
                        ->setCellValue('L' . $kolom, $pengguna->status_date)
                        ->setCellValue('M' . $kolom, $pengguna->keterangan);

            $kolom++;
            $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Rincian Penagihan Air - Diajukan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function cicilan_pembayaran(){
        $data['nama'] = $this->session->userdata('nama');

        $data['check_all'] = $this->db->get_where('konsumen_struk', array('jenis_pembayaran'=>"cicilan"));

        $this->load->view('kasir/cicilan_pembayaran_management', $data);
    }

    public function pembayaran_struk_cicilan(){
        $id_struk = $_POST['id_struk'];
        $cara_pembayaran = $_POST['cara_pembayaran'];
        $bank = $_POST['bank'];
        $nominal_pembayaran = $_POST['nominal_pembayaran'];
        $keterangan = $_POST['keterangan'];
        $tgl_bayar = $_POST['tgl_bayar'];

        $lunas_pembayaran = $_POST['lunas_pembayaran'];
        $terima_pembayaran = $_POST['terima_pembayaran'];

        if(($terima_pembayaran + $nominal_pembayaran) > $lunas_pembayaran){
        echo "<script>
                alert('Pembayaran melebihi nominal seharusnya!');
                window.location.href='cicilan_pembayaran';
              </script>";
        } else {
            $data = array(
                'no_struk'=>$id_struk,
                'tgl_bayar'=>$tgl_bayar,
                'cara_pembayaran' => $cara_pembayaran,
                'nominal' => $nominal_pembayaran,
                'id_bank' => $bank,
                'keterangan' => $keterangan,
                // 'status' => "cicilan",
                'date_created'=>date('Y-m-d H:i:sa am/pm')
            );

            $this->db->insert('konsumen_struk_cicil', $data);

            // foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$id_struk))->result() as $row){
            //     $jns_tgh = $row->jenis_tagihan;
            //     $id_air = $row->id_tagihan;

            //     if($jns_tgh == "air"){
            //         $data1 = array(
            //             'status'=>"cicilan"
            //         );

            //         $this->db->update('konsumen_air', $data1, array('id_air'=>$id_air));
            //     } else {
            //         $data1 = array(
            //             'status'=>"cicilan"
            //         );
                    
            //         $this->db->update('konsumen_maintenance', $data1, array('id_maintenance'=>$id_air));
            //     }
            // }

            // $this->session->set_flashdata('succ_msg1', "Tagihan telah dilunaskan/dibayarkan!");

            redirect('Kasir/cicilan_pembayaran');
        }
    }

    public function get_riwayat_struk_cicil(){
        $id = $_POST['country'];

        $ttl=0;

        $this->db->order_by('id_cicil', "ASC");
        $qs = $this->db->get_where('konsumen_struk_cicil', array('no_struk'=>$id))->result();

        foreach($qs as $row){
            // foreach($this->db->get_where('bank', array())->result() as $bank){

            // }
            echo "
                <tr>
                    <td>$row->tgl_bayar</td>
                    <td>$row->keterangan</td>
                    <td>$row->cara_pembayaran</td>
                    <td>$row->id_bank</td>
                    <td>
                        <a href='hapus_cicilan?id=$row->id_cicil' class='btn btn-sm btn-primary'>Hapus</a>
                    </td>
                    <td>Rp. ".number_format($row->nominal)."</td>
                </tr>
            ";
        $ttl = $ttl+$row->nominal;}
        echo "
            <tr style='background-color: pink'>
                <td colspan=5>Total</td>
                <td>Rp. ".number_format($ttl)."</td>
            </tr>
        ";
    }

    public function get_riwayat_struk_cicil_lunas(){
        $id = $_POST['country'];

        $ttl=0;

        $this->db->order_by('id_cicil', "ASC");
        $qs = $this->db->get_where('konsumen_struk_cicil', array('no_struk'=>$id))->result();

        foreach($qs as $row){
            // foreach($this->db->get_where('bank', array())->result() as $bank){

            // }
            echo "
                <tr>
                    <td>$row->tgl_bayar</td>
                    <td>$row->keterangan</td>
                    <td>$row->cara_pembayaran</td>
                    <td>$row->id_bank</td>
                    <td>Rp. ".number_format($row->nominal)."</td>
                </tr>
            ";
        $ttl = $ttl+$row->nominal;}
        echo "
            <tr style='background-color: pink'>
                <td colspan=4>Total</td>
                <td>Rp. ".number_format($ttl)."</td>
            </tr>
        ";
    }

    public function hapus_cicilan(){
        $id = $_GET['id'];

        $this->db->delete('konsumen_struk_cicil', array('id_cicil'=>$id));

        $this->session->flashdata('succ_msg', "Data berhasil dihapus");

        redirect('Kasir/cicilan_pembayaran');
    }

    public function pelunasan_struk_cicilan(){
        $id = $_GET['id'];

        foreach($this->db->get_where('konsumen_struk', array('id_struk'=>$id))->result() as $row){
            $total = $row->grand_total;
        }

        $data = array(
            'jenis_pembayaran'=>"cicilan (lunas)",
            'status'=>"lunas",
            'status_date'=>date('Y-m-d H:i:sa am/pm'),
            'pembayaran'=>$total
        );

        $this->db->update('konsumen_struk', $data, array('id_struk'=>$id));

        redirect('Kasir/riwayat_pembayaran');
    }
}
