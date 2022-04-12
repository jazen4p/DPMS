<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function get_User(){
        $query = $this->db->get('user');
        return $query;
    }

    public function get_Bank(){
        $query = $this->db->get('bank');
        return $query;
    }

    public function check_last_record($kode_perumahan){
        $query = $this->db->query("SELECT * FROM psjb WHERE kode_perumahan = '$kode_perumahan' ORDER BY no_psjb DESC LIMIT 1");
        $result = $query->result();
        return $result;
    }

    public function check_last_record_ppjb($kode_perumahan){
        $query = $this->db->query("SELECT * FROM ppjb WHERE kode_perumahan = '$kode_perumahan' ORDER BY no_psjb DESC LIMIT 1");
        $result = $query->result();
        return $result;
    }

    public function check_last_record_pembayaran(){
        $query = $this->db->query("SELECT * FROM keuangan_kas_kpr ORDER BY id_keuangan DESC LIMIT 1");
        $result = $query->result();
        return $result;
    }

    public function get_kavling($no_kavling, $kode_perumahan){
        $query = $this->db->get_where('rumah', array('kode_rumah'=>$no_kavling, 'kode_perumahan'=>$kode_perumahan))->result();
        return $query;
    }

    public function skip_first_data($id, $kode){
        $query = $this->db->get_where('ppjb-dp', array('no_psjb'=>$id,'kode_perumahan'=>$kode));
        $result = $query->result();
        return $result;
    }

    public function check_last_record_kwitansi(){
        $query = $this->db->query("SELECT * FROM `psjb-dp` ORDER BY no_kwitansi DESC LIMIT 1");
        $result = $query->result();
        return $result;
    }

    public function get_data($nomor,$kode,$carabayar,$kpr,$bulan) {
        $this->db->select('*');
        $this->db->from('ppjb-dp');
        // $this->db->join('tb_produk as pro', 'pel.id_barcode  = pro.id_barcode');    
        // $this->db->select_sum('jumlah');
        $this->db->where("DATE_FORMAT(tanggal_dana,'%Y-%m') =", $bulan);
        $this->db->where("no_psjb", $nomor);
        $this->db->where("kode_perumahan", $kode);

        $this->db->where("cara_bayar <>", $carabayar);
        $this->db->where("cara_bayar <>", $kpr);
        
        $this->db->where("cara_bayar <>", "Pembayaran DP (0%)");
        // $this->db->where("status", "lunas");
        $this->db->order_by('tanggal_dana', "DESC");
        $this->db->limit(1);
        // $this->db->group_by('pel.id_barcode');
        $query = $this->db->get();
        // if ($query->num_rows() > 0) {
        //     return $query->result();
        //     } else {
        //     return false;
        // }
        return $query;
    }  

    public function filter_laporan_keuangan_transaksi($start, $end, $kode){
        $this->db->select('*');
        $this->db->from('keuangan_kas_kpr');
        if(strtotime($start) != ""){
            $this->db->where('tanggal_bayar >=', $start);
        }
        if(strtotime($end) != ""){
            $this->db->where('tanggal_bayar <=', $end);
        }
        // $this->db->where('tanggal_dana BETWEEN $start AND $end');
        if($kode!=""){
            $this->db->where('kode_perumahan', $kode );
        } # updated
        $query = $this->db->get();
        // $result = $query->result();
        return $query;
    }

    public function filter_laporan_rekap_kas($start, $end, $kode){
        $this->db->select('*');
        $this->db->from('ppjb-dp');
        if(strtotime($start) != ""){
            $this->db->where('tanggal_dana >=', $start);
        }
        if(strtotime($end) != ""){
            $this->db->where('tanggal_dana <=', $end);
        }
        // $this->db->where('tanggal_dana BETWEEN $start AND $end');
        if($kode!=""){
            $this->db->where('kode_perumahan', $kode );
        }
        $query = $this->db->get();
        // $result = $query->result();
        return $query;
    }

    public function filter_laporan_penerimaan_akuntansi($start, $end, $kode, $kategori, $status){
        $this->db->select('*');
        $this->db->from('keuangan_akuntansi');
        if($start != ""){
            $this->db->where('tanggal_dana >=', $start);
        }
        if($end != ""){
            $this->db->where('tanggal_dana <=', $end);
        }
        // $this->db->where('tanggal_dana BETWEEN $start AND $end');
        if($kode!=""){
            $this->db->where('kode_perumahan', $kode );
        }
        if($kategori!=""){
            $this->db->where('kategori', $kategori );
        }
        if($status != "A"){
            $this->db->where('status', $status);
        }
        $this->db->where('jenis_terima <>', "bphtb");
        $this->db->where('jenis_terima <>', "bbn");
        $this->db->where('nominal_bayar >', 0);
        $query = $this->db->get();
        // $result = $query->result();
        return $query;
    }

    public function filter_laporan_pengeluaran_akuntansi($start, $end, $kode, $status){
        $this->db->select('*');
        $this->db->from('keuangan_pengeluaran');
        if(strtotime($start) != ""){
            $this->db->where('tanggal_dana >=', $start);
        }
        if(strtotime($end) != ""){
            $this->db->where('tanggal_dana <=', $end);
        }
        // $this->db->where('tanggal_dana BETWEEN $start AND $end');
        if($kode!=""){
            $this->db->where('kode_perumahan', $kode );
        }
        if($status!="A"){
            $this->db->where('status', $status );
        }
        // $this->db->where('jenis_terima <>', "bphtb");
        // $this->db->where('jenis_terima <>', "bbn");
        $query = $this->db->get();
        // $result = $query->result();
        return $query;
    }

    public function dashboard_keuangan($id, $kode){
        $this->db->select('*');
        $this->db->from('ppjb');

        
    }

    public function bulletin_dashboard_mendekati($no_psjb, $kode){
        $this->db->select('*');
        $this->db->from('ppjb-dp');

        $this->db->where('no_psjb', $no_psjb);
        $this->db->where('kode_perumahan', $kode);
        $this->db->where('tanggal_dana >', date('Y-m-d'));
        $this->db->where('tanggal_dana <=', date('Y-m-d', strtotime('+7 days')));
        $this->db->where('status', "belum lunas");
        $this->db->where('cara_bayar <>', "KPR");
        $this->db->order_by('tanggal_dana', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
    }

    public function bulletin_dashboard_hariini($no_psjb, $kode){
        $this->db->select('*');
        $this->db->from('ppjb-dp');

        $this->db->where('no_psjb', $no_psjb);
        $this->db->where('kode_perumahan', $kode);
        // $this->db->where('tanggal_dana >=', date('Y-m-d', strtotime('-7 days')));
        $this->db->where('tanggal_dana', date('Y-m-d'));
        $this->db->where('status', "belum lunas");
        $this->db->where('cara_bayar <>', "KPR");
        $this->db->order_by('tanggal_dana', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
    }

    public function bulletin_dashboard_melewati($no_psjb, $kode){
        $this->db->select('*');
        $this->db->from('ppjb-dp');

        $this->db->where('no_psjb', $no_psjb);
        $this->db->where('kode_perumahan', $kode);
        // $this->db->where('tanggal_dana >=', date('Y-m-d', strtotime('-7 days')));
        $this->db->where('tanggal_dana <', date('Y-m-d'));
        $this->db->where('status', "belum lunas");
        $this->db->where('cara_bayar <>', "KPR");
        $this->db->order_by('tanggal_dana', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
    }

    public function check_last_record_ground_tank($kode){
        $this->db->select('*');
        $this->db->from('keuangan_penerimaan_lain');

        $this->db->where('kategori', "ground tank");
        $this->db->where('kode_perumahan', $kode);

        $this->db->order_by('no_kwitansi', "DESC");
        $this->db->limit(1);

        // $query = $this->db->query("SELECT * FROM keuangan_penerimaan_lain WHERE 'kategori' = 'ground tank' ORDER BY id_keuangan DESC LIMIT 1");
        $result = $this->db->get();
        return $result;
    }

    public function check_last_record_tambahan_bangunan($kode){
        $this->db->select('*');
        $this->db->from('keuangan_penerimaan_lain');

        $this->db->where('kategori', "tambahan bangunan");
        $this->db->where('kode_perumahan', $kode);

        $this->db->order_by('no_kwitansi', "DESC");
        $this->db->limit(1);

        // $query = $this->db->query("SELECT * FROM keuangan_penerimaan_lain WHERE 'kategori' = 'ground tank' ORDER BY id_keuangan DESC LIMIT 1");
        $result = $this->db->get();
        return $result;
    }

    public function filter_tipe_pembayaran($tipe, $kode){
        $this->db->select('*');
        $this->db->from('ppjb');
        
        if($tipe != "Semua"){
            $this->db->where('sistem_pembayaran', $tipe);
        }

        if($kode != "Semua"){
            $this->db->where('kode_perumahan', $kode);
        }
        $this->db->where('status', "dom");
        
        $query = $this->db->get();
        return $query;
    }

    public function get_psjb_melewati(){
        $this->db->select('*');
        $this->db->from('psjb');

        $this->db->where('status', "dom");

        $query = $this->db->get();
        return $query;
    }

    public function filter_transaksi_pengeluaran($kategori, $jenis, $jenisbayar, $kode){
        $this->db->select('*');
        $this->db->from('keuangan_pengeluaran');

        if($kategori != ""){
            $this->db->where('kategori_pengeluaran', $kategori);
        }
        if($jenis != ""){
            $this->db->where('jenis_pengeluaran', $jenis);
        }
        if($jenisbayar != ""){
            $this->db->where('jenis_pembayaran', $jenisbayar);
        }
        if($kode != ""){
            $this->db->where('kode_perumahan', $kode);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function filter_daftar_utang($kode, $status){
        $this->db->select('*');
        $this->db->from('keuangan_pengeluaran_hutang');

        if($status != ""){
            $this->db->where('status', $status);
        }
        if($kode != ""){
            $this->db->where('kode_perumahan', $kode);
        }

        $query = $this->db->get();
        return $query;
    }

    // public function get_transaksi_jurnal(){
    //     // $this->db->select('*');
    //     $query = $this->db->query('SELECT id_keuangan FROM keuangan_akuntansi UNION SELECT id_pengeluaran FROM keuangan_pengeluaran');
    //     // $this->db->from('akuntansi_pos a');
    //     // $this->db->join('keuangan_akuntansi b', 'b.id_keuangan=a.id_keuangan', 'a.jenis_keuangan = "penerimaan"', 'left');
    //     // $this->db->join('keuangan_pengeluaran c', 'c.id_pengeluaran=a.id_keuangan', 'a.jenis_keuangan = "pengeluaran"', 'left');

    //     // $this->db->where("DATE_FORMAT(b.tanggal_dana,'%Y-%m')", date('Y-m'));
    //     // $this->db->where("DATE_FORMAT(c.tgl_pembayaran,'%Y-%m')", date('Y-m'));

    //     // $query = $this->db->get();
    //     return $query;
    // }

    public function get_jurnal_umum($start, $end, $id){
        $this->db->select('*');
        $this->db->from('akuntansi_pos');

        if($start != ""){
            $this->db->where('date_created >=', $start);
        }
        if($end != ""){
            $this->db->where('date_created <=', $end);
        }

        $this->db->where('kode_perumahan', $id);
        // $this->db->where("DATE_FORMAT(tanggal_dana,'%Y-%m')", date('Y-m'));
        $this->db->order_by('date_created', "DESC");
        $this->db->order_by('id_pos', "ASC");

        $this->db->group_by('id_keuangan');
        $this->db->group_by('jenis_keuangan');

        $query = $this->db->get();
        return $query;
    }

    public function total_nominal_debet_jurnal_umum($start, $end){
        $this->db->select('*');
        // $this->db->select_sum('nominal');
        $this->db->from('akuntansi_pos');

        // $this->db->where("DATE_FORMAT(tanggal_dana,'%Y-%m')", date('Y-m'))
        if(strtotime($start) != ""){
            $this->db->where('tanggal_dana >=', $start);
        }
        if(strtotime($end) != ""){
            $this->db->where('tanggal_dana <=', $end);
        }

        $this->db->where('pos_akun', "debet");
        // $this->db->select_sum('nominal');

        $query = $this->db->get();
        return $query->result();
    }

    public function total_nominal_kredit_jurnal_umum($start, $end){
        $this->db->select('*');
        // $this->db->select_sum('nominal');
        $this->db->from('akuntansi_pos');

        // $this->db->where("DATE_FORMAT(tanggal_dana,'%Y-%m')", date('Y-m'))
        if(strtotime($start) != ""){
            $this->db->where('tanggal_dana >=', $start);
        }
        if(strtotime($end) != ""){
            $this->db->where('tanggal_dana <=', $end);
        }

        $this->db->where('pos_akun', "kredit");

        $query = $this->db->get();
        return $query->result();
    }

    public function penerimaan_bpthb_bbn(){
        $this->db->select('*');
        $this->db->from('keuangan_akuntansi');

        $this->db->where('jenis_terima <>', "bphtb");
        $this->db->where('jenis_terima <>', "bbn");
        // $this->db->where('nominal_bayar <>', 0);
        $this->db->where('nominal_bayar >', 0);
        $this->db->order_by('tanggal_dana', "DESC");

        // $this->db->where("DATE_FORMAT(tanggal_dana,'%Y-%m')", date('Y-m'));

        $query = $this->db->get();
        return $query;
    }

    public function rincian_pembelian($kode, $tgl){
        $this->db->select('*');
        $this->db->from('produksi_transaksi');
        
        $this->db->where("DATE_FORMAT(tgl_pesan,'%Y-%m') =", $tgl);
        $this->db->where('kode_perumahan', $kode);

        $query = $this->db->get();
        return $query;
    }

    public function rincian_pembelian_tk($kode, $tgl, $tk){
        $this->db->select('*');
        $this->db->from('produksi_transaksi');
        
        $this->db->where("DATE_FORMAT(tgl_deadline,'%Y-%m-%d') =", $tgl);
        $this->db->where('kode_perumahan', $kode);
        $this->db->where('nama_toko', $tk);

        // $this->db->group_by('nama_toko');

        $query = $this->db->get();
        return $query;
    }

    public function get_rekap_rincian_pembelian($date, $kode){
        $this->db->select('*, sum(`qty`*`harga_satuan`) as total, sum(qty) as totalqty', FALSE);
        // $this->db->select("IF(`week_num` = ".$weeks.", sum(qty), '') as qty1, IF(`week_num` = ".($weeks+1).",sum(qty), '') as qty2, IF(`week_num` = ".($weeks+2).", sum(qty), '') as qty3, IF(`week_num` = ".($weeks+3).", sum(qty), '') as qty4, IF(`week_num` = ".($weeks+4).", sum(qty), '') as qty5", FALSE);
        $this->db->from('produksi_transaksi');

        $this->db->where("DATE_FORMAT(tgl_pesan,'%Y-%m') =", $date);
        $this->db->where('kode_perumahan', $kode);
        // $this->db->where("IF(`week_num` = 1, sum(qty), '') as qty1, IF(`week_num` = 2,sum(qty), '') as qty2, IF(`week_num` = 3, sum(qty), '') as qty3, IF(`week_num` = 4, sum(qty), '') as qty4, IF(`week_num` = 5, sum(qty), '') as qty5");

        $this->db->group_by('nama_barang');
        $this->db->group_by('nama_toko');

        $query = $this->db->get();
        return $query;
    }

    public function filter_pembayaran_pembelian_bahan($end, $kode, $tk){
        $this->db->select('*');
        $this->db->from('produksi_transaksi');

        // $this->db->where('tgl_deadline', $start);
        $this->db->where('tgl_deadline', $end);
        $this->db->where('kode_perumahan', $kode);
        $this->db->where('nama_toko', $tk);
        $this->db->where('status <>', "diajukan");

        // $this->db->group_by('no_faktur');

        $query = $this->db->get();
        return $query;
    }

    public function filter_kontrol_pembayaran_pembelian($bulan, $tk, $kode){
        $this->db->select('*');
        $this->db->from('produksi_transaksi');

        if($bulan != ""){
            $this->db->where("DATE_FORMAT(tgl_pesan,'%Y-%m') =", $bulan);
        }
        if($tk != ""){
            $this->db->where('nama_toko', $tk);
        }
        $this->db->where('kode_perumahan', $kode);

        $this->db->group_by('no_faktur');
        // $this->db->order_by('no_faktur', "ASC");
        // $this->db->order_by('tgl_pesan', "DESC");

        $query = $this->db->get();
        return $query;
    }

    public function get_rincian_jatuh_tempo($tgl, $kode){
        $this->db->select('*');
        $this->db->from('produksi_transaksi');

        if($tgl != ""){
            $this->db->where("DATE_FORMAT(tgl_deadline,'%Y-%m') =", $tgl);
        }
        $this->db->where('kode_perumahan', $kode);

        $query = $this->db->get();
        return $query;
    }
    
    public function get_rincian_jatuh_tempo2($tgl, $kode, $tk){
        $this->db->select('*');
        $this->db->from('produksi_transaksi');

        if($tgl != ""){
            $this->db->where("DATE_FORMAT(tgl_deadline,'%Y-%m') =", date('Y-m', strtotime($tgl)));
        }
        $this->db->where('kode_perumahan', $kode);
        $this->db->where('nama_toko', $tk);

        $query = $this->db->get();
        return $query;
    }

    public function laba_rugi_pos($id, $kode, $start, $end){
        $this->db->select('*');
        $this->db->from('akuntansi_pos');

        $this->db->where('kode_perumahan', $kode);
        $this->db->where('id_akun', $id);

        if($start != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') >=", $start);
        }
        if($end != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') <=", $end);
        }

        $query = $this->db->get();
        return $query;
    }

    public function laba_rugi_pos_jurnal($id, $kode, $start, $end, $jrl){
        $this->db->select('*');
        $this->db->from('akuntansi_pos_jurnal');

        $this->db->where('kode_perumahan', $kode);
        $this->db->where('id_akun', $id);

        if($start != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') >=", $start);
        }
        if($end != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') <=", $end);
        }

        $this->db->where('jenis_keuangan', $jrl);

        $query = $this->db->get();
        return $query;
    }

    public function laba_rugi_saldo_awal($id, $kode, $start){
        $this->db->select('*');
        $this->db->from('akuntansi_pos');

        $this->db->where('kode_perumahan', $kode);
        $this->db->where('id_akun', $id);

        // if($start != ""){
        $this->db->where("DATE_FORMAT(date_created,'%Y-%m') <", $start);
        // }
        // }else {
        //     if($end != ""){
        //         $this->db->where("DATE_FORMAT(date_created,'%Y-%m') <", $end);
        //     }
        // }

        $query = $this->db->get();
        return $query;
    }

    public function laba_rugi_saldo_awal_jurnal($id, $kode, $start, $jenis){
        $this->db->select('*');
        $this->db->from('akuntansi_pos_jurnal');

        $this->db->where('kode_perumahan', $kode);
        $this->db->where('id_akun', $id);
        $this->db->where('jenis_keuangan', $jenis);

        if($start != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') <", $start);
        }
        // }else {
        //     if($end != ""){
        //         $this->db->where("DATE_FORMAT(date_created,'%Y-%m') <", $end);
        //     }
        // }

        $query = $this->db->get();
        return $query;
    }

    public function perubahan_modal($id, $kode, $start, $end){
        $this->db->select('*');
        $this->db->from('akuntansi_pos');

        $this->db->where('kode_perumahan', $kode);
        $this->db->where('id_akun', $id);

        if($start != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') >=", $start);
        }
        if($end != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') <=", $end);
        }

        $query = $this->db->get();
        return $query;
    }

    public function neraca_saldo($id, $kode, $start, $end){
        $this->db->select('*');
        $this->db->from('akuntansi_pos');

        $this->db->where('kode_perumahan', $kode);
        $this->db->where('id_akun', $id);

        if($start != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') >=", $start);
        }
        if($end != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') <=", $end);
        }

        $query = $this->db->get();
        return $query;
    }

    public function stock_group_bulan($kode){
        $this->db->select('*');
        $this->db->from('logistik_stok');

        $this->db->where('kode_perumahan', $kode);

        $this->db->group_by('MONTH(bulan_cek), YEAR(bulan_cek)');

        $query = $this->db->get();
        return $query;
    }

    public function stock_bulan($kode, $bulan){
        $this->db->select('*');
        $this->db->from('logistik_stok');

        $this->db->where('kode_perumahan', $kode);
        $this->db->where("DATE_FORMAT(bulan_cek,'%Y-%m') =", date('Y-m', strtotime($bulan)));

        // $this->db->group_by('MONTH(bulan_cek), YEAR(bulan_cek)');

        $query = $this->db->get();
        return $query;
    }

    public function cek_stok($kode, $bulan){
        $this->db->select('*');
        $this->db->from('logistik_stok');

        $this->db->where('kode_perumahan', $kode);
        $this->db->where("DATE_FORMAT(bulan_cek,'%Y-%m') =", date('Y-m', strtotime($bulan)));

        $query = $this->db->get();
        return $query;
    }

    public function cek_stok_akhir_bulan($brg, $kode, $bulan){
        $this->db->select('*');
        $this->db->from('logistik_stok');

        $this->db->where('nama_barang', $brg);
        $this->db->where('kode_perumahan', $kode);
        $this->db->where("DATE_FORMAT(bulan_cek,'%Y-%m') =", date('Y-m', strtotime($bulan)));

        // $this->db->group_by('MONTH(bulan_cek), YEAR(bulan_cek)');
        // $this->db->order_by('nama_barang', "ASC");

        $query = $this->db->get();
        return $query;
    }

    public function delete_stok($kode, $tgl){
        $this->db->select('*');
        // $this->db->from('logistik_stok');
        
        $this->db->where('kode_perumahan', $kode);
        $this->db->where("DATE_FORMAT(bulan_cek,'%Y-%m') =", date('Y-m', strtotime($tgl)));

        $this->db->delete('logistik_stok');
    }

    public function get_arus_stok($brg, $kode, $tgl, $arus){
        $this->db->select('*');
        $this->db->from('logistik_arus_stok');
        
        $this->db->where('nama_barang', $brg);
        $this->db->where('kode_perumahan', $kode);
        $this->db->where("DATE_FORMAT(tgl_arus,'%Y-%m') =", date('Y-m', strtotime($tgl)));
        $this->db->where('jenis_arus', $arus);

        $query = $this->db->get();
        return $query;
    }

    public function get_buku_besar($id, $kode, $start, $end){
        $this->db->select('*');
        $this->db->from('akuntansi_pos');

        // if($tahun )
        $this->db->where('id_akun', $id);
        $this->db->where('kode_perumahan', $kode);
        if($start != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') >=", $start);
        }
        if($end != ""){
            $this->db->where("DATE_FORMAT(date_created,'%Y-%m') <=", $end);
        }

        $query = $this->db->get();
        return $query;
    }

    public function saldoLanjutan($id, $kode, $start){
        $this->db->select('*');
        $this->db->from('akuntansi_pos');

        // if($tahun )
        $this->db->where("DATE_FORMAT(date_created,'%Y-%m') <=", $start);

        $query = $this->db->get();
        return $query;
    }

    public function marketing_rekap_penjualan($kode, $min, $max){
        $this->db->select('*');
        $this->db->from('ppjb');

        $this->db->where('kode_perumahan', $kode);

        if($min != ""){
            $this->db->where('DATE_FORMAT(date_by, "%Y-%m") >=', $min);
        }
        if($max != ""){
            $this->db->where('DATE_FORMAT(date_by, "%Y-%m") <=', $max);
        }

        $query = $this->db->get();
        return $query;
    }

    public function graph_ppjb($kode){
        $this->db->select('*');
        $this->db->from('ppjb');

        $this->db->where('kode_perumahan', $kode);
        $this->db->where('status', "dom");

        $query = $this->db->get();
        return $query;
    }

    public function graph_piutang($no, $kode, $bulan){
        $this->db->select('*');
        $this->db->from('ppjb-dp');

        $this->db->where('no_psjb', $no);
        $this->db->where('kode_perumahan', $kode);

        if($bulan != ""){
            $this->db->where('DATE_FORMAT(tanggal_dana, "%Y") <', $bulan);
        }

        $this->db->where('cara_bayar <>', "Uang Tanda Jadi");
        $this->db->where('cara_bayar <>', "KPR");

        $query = $this->db->get();
        return $query;
    }

    public function graph_piutang_byr($kode, $id, $bulan){
        $this->db->select('*');
        $this->db->from('keuangan_kas_kpr');

        $this->db->where('kode_perumahan', $kode);
        $this->db->where('id_ppjb', $id);

        if($bulan != ""){
            $this->db->where('DATE_FORMAT(tanggal_bayar, "%Y") <', $bulan);
        }

        $this->db->where('tahap <>', "KPR");

        $query = $this->db->get();
        return $query;
    }

    public function graph1($no, $kode){
        $this->db->select('*');
        $this->db->from('ppjb-dp');

        $this->db->where('no_psjb', $no);
        $this->db->where('kode_perumahan', $kode);

        $this->db->where('cara_bayar <>', "Uang Tanda Jadi");
        $this->db->where('cara_bayar <>', "KPR");

        $query = $this->db->get();
        return $query;
    }

    public function kontrol_piutang($no, $kode, $bln){
        $this->db->select('*');
        $this->db->from('ppjb-dp');
        
        $this->db->where('no_psjb', $no);
        $this->db->where('kode_perumahan', $kode);
        $this->db->where('cara_bayar <>', "Uang Tanda Jadi");
        $this->db->where('cara_bayar <>', "KPR");

        if($bln != ""){
            $this->db->where('DATE_FORMAT(tanggal_dana, "%Y-%m") <', $bln);
        }

        $query = $this->db->get();
        return $query;
    }

    public function kontrol_piutang_bayar($no, $kode, $bln){
        $this->db->select('*');
        $this->db->from('keuangan_kas_kpr');
        
        // $this->db->where('id_ppjb', $no);
        $this->db->where('no_ppjb', $no);
        $this->db->where('kode_perumahan', $kode);

        $this->db->where("DATE_FORMAT(tanggal_bayar,'%Y-%m') <", $bln);

        $this->db->where('tahap <>', "KPR");

        $query = $this->db->get();
        return $query;
    }

    public function psjb_sign(){
        $this->db->select('*');
        $this->db->from('psjb');

        // $this->db->where("DATE_FORMAT(date_sign,'%Y-%m') <", date('Y-m-d', strtotime('-3 days')));

        $query = $this->db->get();
        return $query;
    }

    public function group_faktur($kode){
        $this->db->select('*');
        $this->db->from('produksi_transaksi');

        $this->db->group_by('nama_toko');
        $this->db->group_by('tgl_deadline');

        if($kode != ""){
            $this->db->where('kode_perumahan', $kode);
        }

        $query = $this->db->get();
        return $query;
    }

    public function filter_pph($kode){
        $this->db->select('*');
        $this->db->from('ppjb');

        if($kode != ""){
            $this->db->where('kode_perumahan', $kode);
        }
        
        $this->db->order_by('id_psjb', "DESC");
        $this->db->where('pph <>', 0);

        $query = $this->db->get();
        return $query;
    }

    public function filter_penerimaan_lain($jenis, $kode, $kategori){
        $this->db->select('*');
        $this->db->from('keuangan_penerimaan_lain');

        if($jenis != ""){
            $this->db->where('jenis_penerimaan', $jenis);
        }
        if($kode != ""){
            $this->db->where('kode_perumahan', $kode);
        }

        $this->db->where('kategori', $kategori);

        $query = $this->db->get();
        return $query;
    }

    public function filter_kbk_pencairan_dana_management_borongan($kode, $st){
        $this->db->select('*');
        $this->db->from('kbk_pencairan_kontrak');

        $this->db->where('jenis_kontrak', $st);

        if($kode != ""){
            $this->db->where('kode_perumahan', $kode);
        }

        $query = $this->db->get();
        return $query;
    }

    public function dashboard_group_utang($date, $kode){
        $this->db->select('*');
        $this->db->from('keuangan_pengeluaran_hutang');

        $this->db->where("DATE_FORMAT(periode_akhir,'%Y-%m') =", $date);
        $this->db->where('kode_perumahan', $kode);

        $this->db->where('status <>', "batal");

        $query = $this->db->get();
        return $query;
    }

    public function dashboard_group_utang_bahan($date, $kode){
        $this->db->select('*');
        $this->db->from('produksi_transaksi');

        // $this->db->group_by('nama_toko');
        // $this->db->group_by('tgl_deadline');

        $this->db->where("DATE_FORMAT(tgl_deadline,'%Y-%m') =", $date);
        $this->db->where('kode_perumahan', $kode);

        $query = $this->db->get();
        return $query;
    }

    public function filter_informasi_pengajuan_pembayaran($kode, $awal, $akhir){
        $this->db->select('*');
        $this->db->from('produksi_pengajuan');

        if($kode != ""){
            $this->db->where('kode_perumahan', $kode);
        }
        if($awal != ""){
            $this->db->where("DATE_FORMAT(tgl_jatuh_tempo,'%Y-%m') >", $awal);
        }
        if($akhir != ""){
            $this->db->where("DATE_FORMAT(tgl_jatuh_tempo,'%Y-%m') <", $akhir);
        }

        $query = $this->db->get();
        return $query;
    }

    public function get_buku_besar_jurnal($cat, $kode, $start, $end){
        $this->db->select('*');
        $this->db->from('akuntansi_pos_jurnal');

        $this->db->where('id_akun', $cat);
        $this->db->where('kode_perumahan', $kode);

        if($start != ""){
            $this->db->where("date_created >=", $start);
        }
        if($end != ""){
            $this->db->where("date_created <=", $end);
        }

        $query = $this->db->get();
        return $query;
    }

    public function get_rekap_pemakaian($data, $jenis, $unit, $kode, $tgl){
        $this->db->select('*');
        $this->db->from('logistik_arus_stok');

        // $this->db->where("DATE_FORMAT(tgl_deadline,'%Y-%m')", $date);
        $this->db->where("DATE_FORMAT(tgl_arus, '%Y-%m-%d') =", date('Y-m-d', strtotime($tgl)));
        $this->db->where('nama_barang', $data);
        $this->db->where('no_unit', $unit);
        $this->db->where('kode_perumahan', $kode);
        $this->db->where('jenis_arus', $jenis);

        $query = $this->db->get();
        return $query;
    }

    
    public function getRows($id = ''){ 
        $this->db->select('id_img,file_name,date_by'); 
        $this->db->from('kbk_qc_img'); 
        if($id){ 
            $this->db->where('id_img',$id); 
            $query = $this->db->get(); 
            $result = $query->row_array(); 
        }else{ 
            $this->db->order_by('date_by','desc'); 
            $query = $this->db->get(); 
            $result = $query->result_array(); 
        } 
         
        return !empty($result)?$result:false; 
    } 
}