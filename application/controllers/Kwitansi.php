<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Kwitansi extends CI_Controller {
        public function __construct(){
                parent::__construct();

                $this->load->model('Login_model');
                $this->load->model('Dashboard_model');

                // if($this->session->userdata("logged")==FALSE)
                // {
                //         redirect(base_url(),'refresh');
                // }
                
                date_default_timezone_set('Asia/Jakarta');
        }

	public function index()
	{
		$this->load->view('login');
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
        
                        $data['out'] = "Suciati Eva Yuda";
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
        
                    $data['out'] = "Suciati Eva Yuda";
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

        public function print_penerimaan_lain(){
                $id = $_GET['id'];
                // $kode = $_GET['kode'];
        
                $data['nama'] = $this->session->userdata('nama');
        
                $query = $this->db->get_where('keuangan_penerimaan_lain', array('id_keuangan' => $id))->result();
                
                // $data['psjb_detail_dp'] = $this->db->get_where('psjb-dp', array('no_psjb'=>$id))->result();
                // print_r($query);
                $data['penerimaan_lain'] = $query;
                
                // $data['ppjb'] = $this->db->get_where('ppjb', array('no_psjb'=>$row->no_ppjb,'kode_perumahan'=>$row->kode_perumahan))->result();
        
                $this->load->library('pdf');
            
                $this->pdf->setPaper('A4', 'landscape');
                $this->pdf->filename = "print-penerimaan-lain.pdf";
                ob_end_clean();
                $this->pdf->load_view('transaksi_print_penerimaan_lain', $data);
        }

        public function print_tanda_terima_pencairan_kontrak(){
                $id = $_GET['id'];
        
                $data['check_all'] = $this->db->get_where('kbk_pencairan_kontrak', array('id_pencairan'=>$id))->result();
        
                $this->load->library('pdf');
            
                $this->pdf->setPaper('A4', 'landscape');
                $this->pdf->filename = "print-tanda-terima-pencairan.pdf";
                ob_end_clean();
                $this->pdf->load_view('kontrak_kbk_pencairan_print', $data);
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
            $data['out'] = "Suciati Eva Yuda";
                
            $this->pdf->setPaper('A4', 'landscape');
            $this->pdf->filename = "print-bfee.pdf";
            ob_end_clean();
            $this->pdf->load_view('psjb_print_bfee', $data);
        }
}
