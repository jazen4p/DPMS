<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include "include/title.php"?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/dropzone-5.7.0/dist/dropzone.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    #wrapper {
      background: #ccc;
      overflow: hidden;
      transition: max-height 300ms;
      max-height: 0;
      padding-left: 50px;
      padding-right: 50px; /* <---hide by default */
    }
    #wrapper.open {
      max-height: 1000px; /* <---when open, allow content to expand to take up as much height as it needs, up to e.g. 100px */
    }
  </style>
</head>
<?php include "include/fixedtop.php"?>
<div class="wrapper">
  <!-- Navbar -->
  <?php include "include/navbar.php"?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "include/sidebar.php"?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
                Daftar Balik Nama 
                <?php if(isset($nama_perumahan)){
                    echo " - ".$nama_perumahan;
                } ?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Daftar Balik Nama</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div>

            </div>
            <hr/>

            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <a href="<?php echo base_url()?>Dashboard/daftar_balik_nama" class="btn btn-success btn-sm">Kembali</a>
              </div>
              <div class="card-body">
                <table id="example2" style="font-size: 13px" class="table table-bordered table-striped">
                    <!-- <button class="btn btn-info btn-flat btn-sm" id="button">FILTER</button>
                    <form action="<?php echo base_url()?>Dashboard/filter_daftar_balik_nama" method="POST">
                        <div id="wrapper" class="" style="">
                            <div class="form-group">
                                <label>Perumahan:</label>
                                <select name="perumahan" class="form-control">
                                    <option value="">Semua</option>
                                    <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                                    <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                                    <?php }?>
                                </select>
                            </div>

                            <input type="submit" class="btn btn-info btn-sm" value="SEARCH">
                        </div>
                    </form> <br> -->
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Konsumen</th>
                        <th>Blok</th>
                        <th style="width: 10px">Jmlh Sertifikat</th>
                        <th>Pembayaran</th>
                        <th>Data</th>
                        <th>Notaris</th>
                        <th>Pajak</th>
                        <th>Penyerahan Sertifikat</th>
                        <th>Penyerahan IMB</th>
                        <!-- <th>Tanda Terima</th>
                        <th>Keterangan</th> -->
                        <th>Status</th>
                        <th>Upload Berkas</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $no = 1;
                        foreach($ppjb->result() as $row){
                        
                            ?>
                            <tr>
                                <td><?php echo $no?></td>
                                <td style="white-space: nowrap;"><?php echo $row->nama_pemesan?></td>
                                <td>
                                    <?php $jmlh_sertif=1; echo $row->no_kavling;
                                    foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rumah){
                                        // echo ", ". $rumah->kode_rumah;
                                    $jmlh_sertif=$jmlh_sertif;}?>
                                </td>
                                <td><?php echo $jmlh_sertif?></td>

                                <!-- PEMBAYARAN -->
                                <?php 
                                $query = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'jenis_penerimaan'=>"bphtb"));
                                $query2 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'jenis_penerimaan'=>"bbn"));
                                // print_r($query2->result());
                                if($query->num_rows() > 0 && $query2->num_rows() > 0){
                                    foreach($query->result() as $uang){
                                        foreach($query2->result() as $bbn) {?>
                                            <td style="white-space: nowrap"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" style="font-size: 13px" data-target="#pembayaran" data-bpthb="<?php echo $uang->dana_terima?>" data-tglbpthb="<?php echo $uang->tanggal_dana?>" data-bbn="<?php echo $bbn->dana_terima?>" data-tglbbn="<?php echo $bbn->tanggal_dana?>">Pembayaran</button></td>
                                <?php }}} else if($query->num_rows() > 0){
                                    foreach($query->result() as $uang){?>
                                        <td style="white-space: nowrap"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" style="font-size: 13px" data-target="#pembayaran" data-bpthb="<?php echo $uang->dana_terima?>" data-tglbpthb="<?php echo $uang->tanggal_dana?>" data-bbn="" data-tglbbn="">Pembayaran</button>
                                        <br><span>BBN Belum Ada</span></td>
                                <?php }} else if($query2->num_rows() > 0){
                                    foreach($query2->result() as $bbn){?>
                                        <td style="white-space: nowrap"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" style="font-size: 13px" data-target="#pembayaran" data-bpthb="" data-tglbpthb="" data-bbn="<?php echo $bbn->dana_terima?>" data-tglbbn="<?php echo $bbn->tanggal_dana?>">Pembayaran</button>
                                        <br><span>BPTHB Belum Ada</span></td>
                                <?php }} else {?>
                                    <td style="white-space: nowrap"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" style="font-size: 13px" data-target="#pembayaran" data-bpthb="" data-tglbpthb="" data-bbn="" data-tglbbn="">Pembayaran</button>
                                    <br><span>BPHTB & BBN Tidak Ada</span></td>
                                <?php }?>
                                <!-- END OF PEMBAYARAN -->

                                <!-- DATA -->
                                <td style="white-space: nowrap">
                                    <a href="<?php echo base_url()?>Dashboard/data_dbm?id=<?php echo $row->id_psjb?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">Data</a>
                                    <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#dataDBM" data-noajb="<?php echo $row->no_ajb?>" data-nosu="<?php echo $row->no_su?>" data-namasertif="<?php echo $row->nama_sertif?>" data-ktp="<?php echo $row->ktp_ada?>" data-kk="<?php echo $row->kk_ada?>" data-tglterima="<?php echo $row->tgl_terima?>">+</button>
                                </td>
                                <!-- END OF DATA -->
                                
                                <?php if($row->ktp_ada == "sudah" && $row->kk_ada == "sudah" && $row->tgl_terima != "0000-00-00"){?>
                                    <!-- NOTARIS -->
                                    <td style="white-space: nowrap">
                                        <a href="<?php echo base_url()?>Dashboard/notaris_dbm?id=<?php echo $row->id_psjb?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">Notaris</a>
                                        <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#notarisDBM" data-mskData="<?php echo $row->notaris_masukdata?>" data-keluarAJB="<?php echo $row->notaris_keluarajb?>" data-serahTTD="<?php echo $row->notaris_ttdajb?>" data-prosesAJB="<?php echo $row->notaris_prosesajb?>" data-ajbSelesai="<?php echo $row->notaris_ajbselesai?>">+</button>
                                    </td>
                                    <!-- END OF NOTARIS -->
                                    
                                    <!-- PAJAK -->
                                    <td style="white-space: nowrap">
                                        <a href="<?php echo base_url()?>Dashboard/pajak_dbm?id=<?php echo $row->id_psjb?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">Pajak</a>
                                        <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#pajakDBM" data-nilaiValidasi="<?php echo $row->nilai_validasi?>" data-bphtb="<?php echo $row->bphtb?>" data-pph="<?php echo $row->pph?>" data-kodeBilling="<?php echo $row->kode_billing?>" data-masaAktifKodeBilling="<?php echo $row->masa_aktif_kode_billing?>" data-masaPajak="<?php echo $row->masa_pajak?>" data-tglBayarPajak="<?php echo $row->tgl_bayar_pajak?>" data-ntpn="<?php echo $row->ntpn?>" data-ketPajak="<?php echo $row->ket_pajak?>">+</button>
                                    </td>
                                    <!-- END OF PAJAK -->
                                    
                                    <?php if($row->notaris_masukdata != "0000-00-00" && $row->notaris_keluarajb != "0000-00-00" && $row->notaris_ttdajb != "0000-00-00" && $row->notaris_prosesajb != "0000-00-00" && $row->notaris_ajbselesai != "0000-00-00"){?>
                                        
                                        <!-- PENYERAHAN SERTIFIKAT -->
                                        <td style="white-space: nowrap">
                                            <a href="<?php echo base_url()?>Dashboard/sertifikat_dbm?id=<?php echo $row->id_psjb?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">Sertif</a>
                                            <?php if($row->jenis_kota == "dalamkota"){?>
                                                <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#sertifikatDBM" data-jenisKota="<?php echo $row->jenis_kota?>" data-tglTerimaSertif="<?php echo $row->tgl_terima_sertif?>" data-terimaOleh="<?php echo $row->terima_oleh_sertif?>">+</button>
                                            <?php } else {?>
                                                <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#sertifikatDBM" data-jenisKota="<?php echo $row->jenis_kota?>" data-tglTerimaSertif="<?php echo $row->tgl_terima_sertif?>" data-terimaOleh="<?php echo $row->terima_oleh_sertif?>" data-tglKirimTTD="<?php echo $row->tgl_kirim_ttdterima?>" data-tglTerimaTTD="<?php echo $row->tgl_terima_ttdterima?>">+</button>
                                            <?php }?>
                                        </td>
                                        <!-- END OF PENYERAHAN SERTIFIKAT -->
                                        
                                        <!-- PENYERAHAN IMB -->
                                        <td style="white-space: nowrap">
                                            <a href="<?php echo base_url()?>Dashboard/imb_dbm?id=<?php echo $row->id_psjb?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">IMB</a>
                                            <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#imbDBM" data-tglTerimaSertif="<?php echo $row->notaris_masukdata?>" data-terimaOleh="<?php echo $row->notaris_keluarajb?>">+</button>
                                        </td>
                                        <!-- END OF PENYERAHAN IMB -->
                                        
                                        <!-- TANDA TERIMA -->
                                        <!-- <td style="white-space: nowrap">
                                            <a href="<?php echo base_url()?>Dashboard/sertifikat_dbm?id=<?php echo $row->id_psjb?>" class="btn btn-sm btn-info" style="font-size: 13px">Ttd Terima</a>
                                            <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#ttdterimaDBM" data-tglTerimaSertif="<?php echo $row->notaris_masukdata?>" data-terimaOleh="<?php echo $row->notaris_keluarajb?>">+</button>
                                        </td> -->
                                        <!-- END OF TANDA TERIMA -->
                                        <?php if($row->tgl_terima_sertif != "0000-00-00" && $row->terima_oleh_sertif != ""){?>
                                            <td style="white-space: nowrap"><a href="<?php echo base_url()?>Dashboard/print_sertifikat_terima?id=<?php echo $row->id_psjb?>" class="btn btn-info btn-sm" style="font-size: 13px" target="_blank">Cetak</a></td>
                                        <?php } else {?>
                                            <td style="color: red; white-space: nowrap">Data Sertifikat Belum Lengkap</td>
                                        <?php }?>
                                    <?php } else {?>
                                        <td></td>
                                        <td></td>
                                        <td style="color: red; white-space: nowrap">Data Notaris Belum Lengkap</td>
                                    <?php }?>
                                <?php } else {?>
                                    <td></td>
                                    <!-- PAJAK -->
                                    <td style="white-space: nowrap">
                                        <a href="<?php echo base_url()?>Dashboard/pajak_dbm?id=<?php echo $row->id_psjb?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">Pajak</a>
                                        <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#pajakDBM" data-nilaiValidasi="<?php echo $row->nilai_validasi?>" data-bphtb="<?php echo $row->bphtb?>" data-pph="<?php echo $row->pph?>" data-kodeBilling="<?php echo $row->kode_billing?>" data-masaAktifKodeBilling="<?php echo $row->masa_aktif_kode_billing?>" data-masaPajak="<?php echo $row->masa_pajak?>" data-tglBayarPajak="<?php echo $row->tgl_bayar_pajak?>" data-ntpn="<?php echo $row->ntpn?>" data-ketPajak="<?php echo $row->ket_pajak?>">+</button>
                                    </td>
                                    <!-- END OF PAJAK -->
                                    <td></td>
                                    <td></td>
                                    <td style="color: red; white-space: nowrap">KK & KTP Belum Lengkap</td>
                                <?php }?>
                                
                                <!-- KETERANGAN -->
                                <!-- <td style="white-space: nowrap">
                                    <a href="<?php echo base_url()?>Dashboard/keterangan_dbm?id=<?php echo $row->id_psjb?>" class="btn btn-sm btn-info" style="font-size: 13px">Ket</a>
                                    <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#ttdterimaDBM" data-tglTerimaSertif="<?php echo $row->notaris_masukdata?>" data-terimaOleh="<?php echo $row->notaris_keluarajb?>">+</button>
                                </td> -->
                                <!-- END OF KETERANGAN -->

                                <td style="white-space: nowrap">
                                    <input type="hidden" value="<?php echo $row->id_psjb?>" id="idPSJB">
                                    <button type="button" class="btn btn-flat btn-sm btn-outline-primary" data-toggle="modal" data-target="#uploadModal" data-id="<?php echo $row->id_psjb?>" data-kode="<?php echo $row->kode_perumahan?>">Upload Bukti</button>
                                </td>
                            </tr>

                            <!-- 2 ATAU LEBIH UNIT -->
                            <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rumah){ 
                                $no++;?>
                                <tr>
                                <td><?php echo $no?></td>
                                <td style="white-space: nowrap;"><?php echo $row->nama_pemesan?></td>
                                <td>
                                    <?php $jmlh_sertif=1; echo $rumah->kode_rumah;
                                    foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rumah){
                                        // echo ", ". $rumah->kode_rumah;
                                    $jmlh_sertif=$jmlh_sertif;}?>
                                </td>
                                <td><?php echo $jmlh_sertif?></td>

                                <!-- PEMBAYARAN -->
                                <?php 
                                $query = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'jenis_penerimaan'=>"bphtb"));
                                $query2 = $this->db->get_where('keuangan_penerimaan_lain', array('no_kwitansi'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'jenis_penerimaan'=>"bbn"));
                                // print_r($query2->result());
                                if($query->num_rows() > 0 && $query2->num_rows() > 0){
                                    foreach($query->result() as $uang){
                                        foreach($query2->result() as $bbn) {?>
                                            <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" style="font-size: 13px" data-target="#pembayaran" data-bpthb="<?php echo $uang->dana_terima?>" data-tglbpthb="<?php echo $uang->tanggal_dana?>" data-bbn="<?php echo $bbn->dana_terima?>" data-tglbbn="<?php echo $bbn->tanggal_dana?>">Pembayaran</button></td>
                                <?php }}} else if($query->num_rows() > 0){
                                    foreach($query->result() as $uang){?>
                                        <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" style="font-size: 13px" data-target="#pembayaran" data-bpthb="<?php echo $uang->dana_terima?>" data-tglbpthb="<?php echo $uang->tanggal_dana?>" data-bbn="" data-tglbbn="">Pembayaran</button>
                                        <br><span>BBN Belum Ada</span></td>
                                <?php }} else if($query2->num_rows() > 0){
                                    foreach($query2->result() as $bbn){?>
                                        <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" style="font-size: 13px" data-target="#pembayaran" data-bpthb="" data-tglbpthb="" data-bbn="<?php echo $bbn->dana_terima?>" data-tglbbn="<?php echo $bbn->tanggal_dana?>">Pembayaran</button>
                                        <br><span>BPTHB Belum Ada</span></td>
                                <?php }} else {?>
                                    <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" style="font-size: 13px" data-target="#pembayaran" data-bpthb="" data-tglbpthb="" data-bbn="" data-tglbbn="">Pembayaran</button>
                                    <br><span>BPHTB & BBN Tidak Ada</span></td>
                                <?php }?>
                                <!-- END OF PEMBAYARAN -->

                                <!-- DATA -->
                                <td style="white-space: nowrap">
                                    <a href="<?php echo base_url()?>Dashboard/data_dbm_unit2?id=<?php echo $rumah->id_rumah?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">Data</a>
                                    <?php if($rumah->nama_sertif == ""){?>
                                        <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#dataDBM" data-noajb="<?php echo $rumah->no_ajb?>" data-nosu="<?php echo $rumah->no_su?>" data-namasertif="<?php echo $row->nama_sertif?>" data-ktp="<?php echo $rumah->ktp_ada?>" data-kk="<?php echo $rumah->kk_ada?>" data-tglterima="<?php echo $rumah->tgl_terima?>">+</button>
                                    <?php } else {?>
                                        <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#dataDBM" data-noajb="<?php echo $rumah->no_ajb?>" data-nosu="<?php echo $rumah->no_su?>" data-namasertif="<?php echo $rumah->nama_sertif?>" data-ktp="<?php echo $rumah->ktp_ada?>" data-kk="<?php echo $rumah->kk_ada?>" data-tglterima="<?php echo $rumah->tgl_terima?>">+</button>
                                    <?php }?>
                                </td>
                                <!-- END OF DATA -->
                                
                                <?php if($rumah->ktp_ada == "sudah" && $rumah->kk_ada == "sudah" && $rumah->tgl_terima != "0000-00-00"){?>
                                    <!-- NOTARIS -->
                                    <td style="white-space: nowrap">
                                        <a href="<?php echo base_url()?>Dashboard/notaris_dbm_unit2?id=<?php echo $rumah->id_rumah?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">Notaris</a>
                                        <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#notarisDBM" data-mskData="<?php echo $rumah->notaris_masukdata?>" data-keluarAJB="<?php echo $rumah->notaris_keluarajb?>" data-serahTTD="<?php echo $rumah->notaris_ttdajb?>" data-prosesAJB="<?php echo $rumah->notaris_prosesajb?>" data-ajbSelesai="<?php echo $rumah->notaris_ajbselesai?>">+</button>
                                    </td>
                                    <!-- END OF NOTARIS -->
                                    
                                    <!-- PAJAK -->
                                    <td style="white-space: nowrap">
                                        <a href="<?php echo base_url()?>Dashboard/pajak_dbm_unit2?id=<?php echo $rumah->id_rumah?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">Pajak</a>
                                        <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#pajakDBM" data-nilaiValidasi="<?php echo $rumah->nilai_validasi?>" data-bphtb="<?php echo $rumah->bphtb?>" data-pph="<?php echo $rumah->pph?>" data-kodeBilling="<?php echo $rumah->kode_billing?>" data-masaAktifKodeBilling="<?php echo $rumah->masa_aktif_kode_billing?>" data-masaPajak="<?php echo $rumah->masa_pajak?>" data-tglBayarPajak="<?php echo $rumah->tgl_bayar_pajak?>" data-ntpn="<?php echo $rumah->ntpn?>" data-ketPajak="<?php echo $rumah->ket_pajak?>">+</button>
                                    </td>
                                    <!-- END OF PAJAK -->
                                    
                                    <?php if($rumah->notaris_masukdata != "0000-00-00" && $rumah->notaris_keluarajb != "0000-00-00" && $rumah->notaris_ttdajb != "0000-00-00" && $rumah->notaris_prosesajb != "0000-00-00" && $rumah->notaris_ajbselesai != "0000-00-00"){?>
                                        
                                        <!-- PENYERAHAN SERTIFIKAT -->
                                        <td style="white-space: nowrap">
                                            <a href="<?php echo base_url()?>Dashboard/sertifikat_dbm_unit2?id=<?php echo $rumah->id_rumah?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">Sertif</a>
                                            <?php if($row->jenis_kota == "dalamkota"){?>
                                                <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#sertifikatDBM" data-jenisKota="<?php echo $rumah->jenis_kota?>" data-tglTerimaSertif="<?php echo $rumah->tgl_terima_sertif?>" data-terimaOleh="<?php echo $rumah->terima_oleh_sertif?>">+</button>
                                            <?php } else {?>
                                                <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#sertifikatDBM" data-jenisKota="<?php echo $rumah->jenis_kota?>" data-tglTerimaSertif="<?php echo $rumah->tgl_terima_sertif?>" data-terimaOleh="<?php echo $rumah->terima_oleh_sertif?>" data-tglKirimTTD="<?php echo $rumah->tgl_kirim_ttdterima?>" data-tglTerimaTTD="<?php echo $rumah->tgl_terima_ttdterima?>">+</button>
                                            <?php }?>
                                        </td>
                                        <!-- END OF PENYERAHAN SERTIFIKAT -->
                                        
                                        <!-- PENYERAHAN IMB -->
                                        <td style="white-space: nowrap">
                                            <a href="<?php echo base_url()?>Dashboard/imb_dbm_unit2?id=<?php echo $rumah->id_rumah?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">IMB</a>
                                            <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#imbDBM" data-tglTerimaSertif="<?php echo $rumah->notaris_masukdata?>" data-terimaOleh="<?php echo $rumah->notaris_keluarajb?>">+</button>
                                        </td>
                                        <!-- END OF PENYERAHAN IMB -->
                                        
                                        <!-- TANDA TERIMA -->
                                        <!-- <td style="white-space: nowrap">
                                            <a href="<?php echo base_url()?>Dashboard/sertifikat_dbm?id=<?php echo $row->id_psjb?>" class="btn btn-sm btn-info" style="font-size: 13px">Ttd Terima</a>
                                            <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#ttdterimaDBM" data-tglTerimaSertif="<?php echo $row->notaris_masukdata?>" data-terimaOleh="<?php echo $row->notaris_keluarajb?>">+</button>
                                        </td> -->
                                        <!-- END OF TANDA TERIMA -->
                                        <?php if($rumah->tgl_terima_sertif != "0000-00-00" && $rumah->terima_oleh_sertif != ""){?>
                                            <?php foreach($this->db->get_where('ppjb', array('psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as  $ts){?>
                                                <td><a href="<?php echo base_url()?>Dashboard/print_sertifikat_terima?id=<?php echo $ts->id_psjb?>" class="btn btn-info btn-sm" style="font-size: 13px" target="_blank">Cetak</a></td>
                                            <?php }?>
                                        <?php } else {?>
                                            <td style="color: red">Data Sertifikat Belum Lengkap</td>
                                        <?php }?>
                                    <?php } else {?>
                                        <td></td>
                                        <td></td>
                                        <td style="color: red">Data Notaris Belum Lengkap</td>
                                    <?php }?>
                                <?php } else {?>
                                    <td></td>
                                    <!-- PAJAK -->
                                    <td style="white-space: nowrap">
                                        <a href="<?php echo base_url()?>Dashboard/pajak_dbm_unit2?id=<?php echo $rumah->id_rumah?>&kode=<?php echo $id?>" class="btn btn-sm btn-info" style="font-size: 13px">Pajak</a>
                                        <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#pajakDBM" data-nilaiValidasi="<?php echo $rumah->nilai_validasi?>" data-bphtb="<?php echo $rumah->bphtb?>" data-pph="<?php echo $rumah->pph?>" data-kodeBilling="<?php echo $rumah->kode_billing?>" data-masaAktifKodeBilling="<?php echo $rumah->masa_aktif_kode_billing?>" data-masaPajak="<?php echo $rumah->masa_pajak?>" data-tglBayarPajak="<?php echo $rumah->tgl_bayar_pajak?>" data-ntpn="<?php echo $rumah->ntpn?>" data-ketPajak="<?php echo $rumah->ket_pajak?>">+</button>
                                    </td>
                                    <!-- END OF PAJAK -->
                                    <td></td>
                                    <td></td>
                                    <td style="color: red">KK & KTP Belum Lengkap</td>
                                <?php }?>
                                
                                <!-- KETERANGAN -->
                                <!-- <td style="white-space: nowrap">
                                    <a href="<?php echo base_url()?>Dashboard/keterangan_dbm?id=<?php echo $row->id_psjb?>" class="btn btn-sm btn-info" style="font-size: 13px">Ket</a>
                                    <button class="btn btn-info btn-sm" style="font-size: 13px" data-toggle="modal" data-target="#ttdterimaDBM" data-tglTerimaSertif="<?php echo $row->notaris_masukdata?>" data-terimaOleh="<?php echo $row->notaris_keluarajb?>">+</button>
                                </td> -->
                                <!-- END OF KETERANGAN -->

                                <td style="color: red">Upload Bukti menggunakan button/tombol di atas!</td>
                            </tr>
                            <?php }?>
                            <!-- END OF 2 UNIT ATAU LEBIH -->
                        <?php $no++;}?>
                  </tfoot>
                </table>

                <!-- PEMBAYARAN -->
                <div class="modal fade" id="pembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <?php ?>
                                        <tr>
                                            <td>
                                                BPHTB
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                Rp. <span class="BPTHB"></span>,-
                                            </td>
                                            <td>
                                                Tanggal Lunas
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <span class="tglBPTHB"></span>
                                            </td>
                                        </tr>
                                    <?php ?>
                                <tr>
                                        <td>
                                            BBN
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            Rp. <span class="BBN"></span>,-
                                        </td>
                                        <td>
                                            Tanggal lunas
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <span class="tglBBN"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!-- <input type="submit" class="btn btn-success" value="Submit"> -->
                        </div>
                        </div>
                    </div>
                </div>
                <!-- END OF PEMBAYARAN -->

                <!-- DATA KK & KTP DAFTAR BALIK NAMA -->
                <div class="modal fade" id="dataDBM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <form action="<?php echo base_url()?>Dashboard/data_dbm" method="POST" enctype="multipart/form-data">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Data Konsumen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td>No AJB</td>
                                    <td>:</td>
                                    <td><span class="noAJB"></span></td>
                                </tr>
                                <tr>
                                    <td>No SU</td>
                                    <td>:</td>
                                    <td><span class="noSU"></span></td>
                                </tr>
                                <tr>
                                    <td>Nama Sertifikat</td>
                                    <td>:</td>
                                    <td><span class="namaSertif"></span></td>
                                </tr>
                                <tr>
                                    <td>KTP</td>
                                    <td>:</td>
                                    <td><span class="KTP"></span></td>
                                </tr>
                                <tr>
                                    <td>KK</td>
                                    <td>:</td>
                                    <td><span class="KK"></span></td>
                                </tr>
                                <tr>
                                    <td>Tgl Terima Berkas</td>
                                    <td>:</td>
                                    <td><span class="tglBerkas"></span></td>
                                </tr>
                            </table>
                            <?php 
                            // print_r($this->db->get_where('rumah', array('no_shm'=>$test))->result());
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                  </form>
                </div>
                <!-- END OF DATA KK & KTP DAFTAR BALIK NAMA -->

                <!-- NOTARIS DAFTAR BALIK NAMA -->
                <div class="modal fade" id="notarisDBM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Notaris</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td>Masuk data</td>
                                    <td>:</td>
                                    <td><span class="mskData"></span></td>
                                </tr>
                                <tr>
                                    <td>Keluar AJB</td>
                                    <td>:</td>
                                    <td><span class="keluarAJB"></span></td>
                                </tr>
                                <tr>
                                    <td>Penyerahan TTD Persetujuan AJB</td>
                                    <td>:</td>
                                    <td><span class="serahTTD"></span></td>
                                </tr>
                                <tr>
                                    <td>Proses AJB</td>
                                    <td>:</td>
                                    <td><span class="prosesAJB"></span></td>
                                </tr>
                                <tr>
                                    <td>AJB selesai</td>
                                    <td>:</td>
                                    <td><span class="ajbSelesai"></span></td>
                                </tr>
                            </table>
                            <?php 
                            // print_r($this->db->get_where('rumah', array('no_shm'=>$test))->result());
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                  </form>
                </div>
                <!-- END OF NOTARIS DAFTAR BALIK NAMA -->

                <!-- PAJAK DAFTAR BALIK NAMA -->
                <div class="modal fade" id="pajakDBM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pajak</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td>Nilai Validasi</td>
                                    <td>:</td>
                                    <td><span class="nilaiValidasi"></span></td>
                                </tr>
                                <tr>
                                    <td>BPHTB</td>
                                    <td>:</td>
                                    <td><span class="bphtb"></span></td>
                                </tr>
                                <tr>
                                    <td>PPh (2,5%)</td>
                                    <td>:</td>
                                    <td><span class="pph"></span></td>
                                </tr>
                                <tr>
                                    <td>Kode Billing</td>
                                    <td>:</td>
                                    <td><span class="kodeBilling"></span></td>
                                </tr>
                                <tr>
                                    <td>Masa Aktif Kode Billing</td>
                                    <td>:</td>
                                    <td><span class="masaAktifKodeBilling"></span></td>
                                </tr>
                                <tr>
                                    <td>Masa Pajak</td>
                                    <td>:</td>
                                    <td><span class="masaPajak"></span></td>
                                </tr>
                                <tr>
                                    <td>Tgl Bayar</td>
                                    <td>:</td>
                                    <td><span class="tglBayarPajak"></span></td>
                                </tr>
                                <tr>
                                    <td>NTPN</td>
                                    <td>:</td>
                                    <td><span class="ntpn"></span></td>
                                </tr>
                                <tr>
                                    <td>KET</td>
                                    <td>:</td>
                                    <td><span class="ketPajak"></span></td>
                                </tr>
                            </table>
                            <?php 
                            // print_r($this->db->get_where('rumah', array('no_shm'=>$test))->result());
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                  </form>
                </div>
                <!-- END OF PAJAK DAFTAR BALIK NAMA -->

                <!-- PENYERAHAN SERTIFIKAT DAFTAR BALIK NAMA -->
                <div class="modal fade" id="sertifikatDBM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Penyerahan Sertifikat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td>Jenis</td>
                                    <td>:</td>
                                    <td><span class="jenisKota"></span></td>
                                </tr>
                                <tr>
                                    <td>Tgl Terima</td>
                                    <td>:</td>
                                    <td><span class="tglTerimaSertif"></span></td>
                                </tr>
                                <tr>
                                    <td>Di Terima Oleh</td>
                                    <td>:</td>
                                    <td><span class="terimaOleh"></span></td>
                                </tr>
                                <tr>
                                    <td>Tgl Kirim TTD</td>
                                    <td>:</td>
                                    <td><span class="tglKirimTTD"></span></td>
                                </tr>
                                <tr>
                                    <td>Tgl Terima TTD</td>
                                    <td>:</td>
                                    <td><span class="tglTerimaTTD"></span></td>
                                </tr>
                            </table>
                            <?php 
                            // print_r($this->db->get_where('rumah', array('no_shm'=>$test))->result());
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                  </form>
                </div>
                <!-- END OF PENYERAHAN SERTIFIKAT DAFTAR BALIK NAMA -->

                <!-- PENYERAHAN IMB DAFTAR BALIK NAMA -->
                <div class="modal fade" id="imbDBM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Penyerahan IMB</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td>Tgl Terima</td>
                                    <td>:</td>
                                    <td><span class="tglTerimaSertif"></span></td>
                                </tr>
                                <tr>
                                    <td>Di Terima Oleh</td>
                                    <td>:</td>
                                    <td><span class="terimaOleh"></span></td>
                                </tr>
                            </table>
                            <?php 
                            // print_r($this->db->get_where('rumah', array('no_shm'=>$test))->result());
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                  </form>
                </div>
                <!-- END OF PENYERAHAN IMB DAFTAR BALIK NAMA -->

                <!-- TANDA TERIMA DAFTAR BALIK NAMA -->
                <div class="modal fade" id="ttdterimaDBM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tanda Terima</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td>Tgl Kirim</td>
                                    <td>:</td>
                                    <td><span class="tglTerimaSertif"></span></td>
                                </tr>
                                <tr>
                                    <td>Tgl Terima</td>
                                    <td>:</td>
                                    <td><span class="terimaOleh"></span></td>
                                </tr>
                            </table>
                            <?php 
                            // print_r($this->db->get_where('rumah', array('no_shm'=>$test))->result());
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                  </form>
                </div>
                <!-- END OF TANDA TERIMA DAFTAR BALIK NAMA -->

                <!-- KETERANGAN DAFTAR BALIK NAMA -->
                <div class="modal fade" id="ttdterimaDBM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tanda Terima</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td>Tgl Kirim</td>
                                    <td>:</td>
                                    <td><span class="tglTerimaSertif"></span></td>
                                </tr>
                                <tr>
                                    <td>Tgl Terima</td>
                                    <td>:</td>
                                    <td><span class="terimaOleh"></span></td>
                                </tr>
                            </table>
                            <?php 
                            // print_r($this->db->get_where('rumah', array('no_shm'=>$test))->result());
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                  </form>
                </div>
                <!-- END OF KETERANGAN DAFTAR BALIK NAMA -->

                <!-- START OF UPLOAD BERKAS -->
                <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upload Foto/Berkas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="responseUploadedFile" id="responseUploadedFile">

                            </div>
                            <br>
                            <!-- <div>Tarik atau pilih gambar yang akan di upload!</div> -->
                            <!-- <div class="dropzone" id="fileupload" method="POST">

                            </div>     -->
                            <div class="dropzone">
                                <div class="dz-message">
                                    <h3> Klik atau Drop gambar disini</h3>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <input type="text" id="idPSJB"> -->
                            <!-- <input type="hidden" value="<?php echo $id?>" name="id_termin" id="idTermin">
                            <input type="hidden" value="<?php echo $id_kbk?>" name="id_kbk" id="idKBK">
                            <input type="hidden" value="<?php echo $kode?>" name="kode_perumahan" id="kodePerumahan"> -->

                            <!-- <input type="submit" value="Upload" class="btn btn-success"> -->
                            <!-- </form> -->
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                        </div>
                        </div>
                    </div>
                </div>
                <!-- END OF UPLOAD BERKAS -->

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <?php include "include/footer.php"?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>
<script src="<?php echo base_url()?>assets/dropzone-5.7.0/dist/dropzone.js"></script>
<!-- page script -->
<script>
function myFunction(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PSJB ini di approve?");
  if (r == true) {
    window.location.replace(base_url+"/psjb_approve?id="+id);
  } else {
    window.location.replace(base_url+"/psjb_management")
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>
<script>
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$('#pembayaran').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-bpthb');
    var myRoomNumber1 = $(e.relatedTarget).attr('data-tglbpthb');
    var myRoomNumber2 = $(e.relatedTarget).attr('data-bbn');
    var myRoomNumber3 = $(e.relatedTarget).attr('data-tglbbn');
    $(this).find('.BPTHB').text(numberWithCommas(myRoomNumber));
    $(this).find('.tglBPTHB').text(myRoomNumber1);
    $(this).find('.BBN').text(numberWithCommas(myRoomNumber2));
    $(this).find('.tglBBN').text(myRoomNumber3);
});

$('#dataDBM').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-noajb');
    var myRoomNumber1 = $(e.relatedTarget).attr('data-namasertif');
    var myRoomNumber2 = $(e.relatedTarget).attr('data-ktp');
    var myRoomNumber3 = $(e.relatedTarget).attr('data-kk');
    var myRoomNumber4 = $(e.relatedTarget).attr('data-tglterima');
    var myRoomNumber5 = $(e.relatedTarget).attr('data-nosu');
    $(this).find('.noAJB').text(myRoomNumber);
    // $(this).find('.noSHM').value(myRoomNumber);
    $(this).find('.namaSertif').text(myRoomNumber1);
    $(this).find('.KTP').text(myRoomNumber2);
    $(this).find('.KK').text(myRoomNumber3);
    $(this).find('.tglBerkas').text(myRoomNumber4);
    $(this).find('.noSU').text(myRoomNumber5);
});

$('#notarisDBM').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-mskData');
    var myRoomNumber1 = $(e.relatedTarget).attr('data-keluarAJB');
    var myRoomNumber2 = $(e.relatedTarget).attr('data-serahTTD');
    var myRoomNumber3 = $(e.relatedTarget).attr('data-prosesAJB');
    var myRoomNumber4 = $(e.relatedTarget).attr('data-ajbSelesai');
    $(this).find('.mskData').text(myRoomNumber);
    // $(this).find('.noSHM').value(myRoomNumber);
    $(this).find('.keluarAJB').text(myRoomNumber1);
    $(this).find('.serahTTD').text(myRoomNumber2);
    $(this).find('.prosesAJB').text(myRoomNumber3);
    $(this).find('.ajbSelesai').text(myRoomNumber4);
});

$('#pajakDBM').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-nilaiValidasi');
    var myRoomNumber1 = $(e.relatedTarget).attr('data-bphtb');
    var myRoomNumber2 = $(e.relatedTarget).attr('data-pph');
    var myRoomNumber3 = $(e.relatedTarget).attr('data-kodeBilling');
    var myRoomNumber4 = $(e.relatedTarget).attr('data-masaAktifKodeBilling');
    var myRoomNumber5 = $(e.relatedTarget).attr('data-masaPajak');
    var myRoomNumber6 = $(e.relatedTarget).attr('data-tglBayarPajak');
    var myRoomNumber7 = $(e.relatedTarget).attr('data-ntpn');
    var myRoomNumber8 = $(e.relatedTarget).attr('data-ketPajak');
    $(this).find('.nilaiValidasi').text(numberWithCommas("Rp. "+myRoomNumber));
    // $(this).find('.noSHM').value(myRoomNumber);
    $(this).find('.bphtb').text(numberWithCommas("Rp. "+myRoomNumber1));
    $(this).find('.pph').text(numberWithCommas("Rp. "+myRoomNumber2));
    $(this).find('.kodeBilling').text(myRoomNumber3);
    $(this).find('.masaAktifKodeBilling').text(myRoomNumber4);
    $(this).find('.masaPajak').text(myRoomNumber5);
    $(this).find('.tglBayarPajak').text(myRoomNumber6);
    $(this).find('.ntpn').text(myRoomNumber7);
    $(this).find('.ketPajak').text(myRoomNumber8);
});

$('#sertifikatDBM').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-tglTerimaSertif');
    var myRoomNumber1 = $(e.relatedTarget).attr('data-terimaOleh');
    var myRoomNumber2 = $(e.relatedTarget).attr('data-tglKirimTTD');
    var myRoomNumber3 = $(e.relatedTarget).attr('data-tglTerimaTTD');
    var myRoomNumber4 = $(e.relatedTarget).attr('data-jenisKota');
    $(this).find('.tglTerimaSertif').text(myRoomNumber);
    // $(this).find('.noSHM').value(myRoomNumber);
    $(this).find('.terimaOleh').text(myRoomNumber1);
    $(this).find('.tglKirimTTD').text(myRoomNumber2);
    // $(this).find('.noSHM').value(myRoomNumber);
    $(this).find('.tglTerimaTTD').text(myRoomNumber3);
    $(this).find('.jenisKota').text(myRoomNumber4);
});

$('#uploadModal').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-id');
    var kodePerumahan = $(e.relatedTarget).attr('data-kode');

    // $(this).find('.idPSJB').val(myRoomNumber);
    // alert(myRoomNumber);
    
    // var selectedCountry = $("#outpost option:selected").val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>Dashboard/get_file_foto_pajak",
        data: { country : myRoomNumber, kode: kodePerumahan } 
    }).done(function(data){
        $("#responseUploadedFile").html(data);
    });

    // $('#idPSJB').val(myRoomNumber);
});
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": false,
      "autoWidth": false,
      "scrollX": true
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "scrollY": "300px",
      fixedColumns:   {
        leftColumns: 2,
      },
      fixedHeader: true
    });
  });

    $(function() {
    var b = $("#button");
    var w = $("#wrapper");
    var l = $("#list");
    b.click(function() {
        w.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });
    });
</script>
<script type="text/javascript">
    // Add restrictions
    Dropzone.autoDiscover = false;
    var id = $('#idPSJB').val();
    // alert(id);

    var foto_upload= new Dropzone(".dropzone",{
      url: "<?php echo base_url()?>Dashboard/upload_foto_pajak?id="+id,
      maxFilesize: 2,
      method:"post",
    //   acceptedFiles:"image/*",
      paramName:"userfile",
      dictInvalidFileType:"Type file ini tidak dizinkan",
      addRemoveLinks:true,
    });

    // var id = $('#idTermin').val();
    // var idKBK = $('#idKBK').val();
    // var kode = $('#kode').val();
    //Event ketika Memulai mengupload
    foto_upload.on("sending",function(a,b,c){
      a.token=Math.random();
      c.append("token_foto",a.token); //Menmpersiapkan token untuk masing masing foto
      // c.append("id_termin",id);
      // c.append("id_kbk", $idKBK);
      // c.append("kode", $kode);
    });


    //Event ketika foto dihapus
    foto_upload.on("removedfile",function(a){
      var token=a.token;
      $.ajax({
        type:"post",
        data:{token:token},
        url:"<?php echo base_url('Dashboard/remove_file_pajak') ?>",
        cache:false,
        dataType: 'json',
        success: function(){
          console.log("Foto terhapus");
        },
        error: function(){
          console.log("Error");

        }
      });
    });
</script>
</body>
</html>
