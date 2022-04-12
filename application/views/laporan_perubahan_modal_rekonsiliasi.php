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
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
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
<!-- <body class="hold-transition sidebar-mini"> -->
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
              Perubahan Modal
              <?php if(isset($nama_perusahaan)){
                  echo " - ".$nama_perusahaan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Perubahan Modal</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
            </div>
            <div class="col-sm-2">
                <!-- <button type="button" id="button" class="btn btn-flat btn-outline-info" data-toggle="modal" data-target="#exampleModal">Per Bangunan</button> -->
                <a href="<?php echo base_url()?>Dashboard/print_perubahan_modal_rekonsiliasi?id=<?php echo $kode_perumahan?>&min=<?php echo $tglmin?>&max=<?php echo $tglmax?>" class="btn btn-outline-primary btn-flat" target="_blank">PRINT</a>
            </div>
            <!-- <form action="<?php echo base_url()?>Dashboard/print_rekap_rincian" method="POST" class="col-sm-1">
              <input type="hidden" value="<?php echo $id?>" name="id">
              <input type="hidden" value="<?php echo $tgl?>" name="bln">

              <input type="submit" value="PRINT" class="btn btn-outline-primary btn-flat">
            </form> -->
        </div>
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_perubahan_modal_rekonsiliasi" method="POST">
            <div class="row">
              <div class="col-md-6">
                <!-- <label>Perumahan</label>
                <select name="perumahan" class="form-control">
                    <option value="">Semua</option>
                    <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                    <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                    <?php }?>
                </select> -->
                <!-- <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="">Semua</option>
                    <option value="booking fee">Booking Fee</option>
                    <option value="piutang kas">Piutang Kas</option>
                    <option value="ground tank">Ground Tank</option>
                    <option value="tambahan bangunan">Tambahan Bangunan</option>
                    <option value="penerimaan lain">Penerimaan Lain</option>
                </select> -->
                <!-- <label>Status</label>
                <select name="status" class="form-control">
                    <option value="A">Semua</option>
                    <option value="booking fee">Approved</option>
                    <option value="piutang kas">Revisi</option>
                    <option value="">Menunggu</option>
                </select> -->
                <label>Date</label>
                <input placeholder="Tanggal Awal" value="<?php if(isset($tglmin)){echo $tglmin;}?>" name="tgl_awal" class="textbox-n form-control" onfocus="(this.type='month')" type="text" id="date" required>
              </div>
              <div class="col-md-6">
                <label>Sampai</label>
                <input placeholder="Tanggal Akhir" value="<?php if(isset($tglmax)){echo $tglmax;}?>" name="tgl_akhir" class="textbox-n form-control" onfocus="(this.type='month')" type="text" id="date" required>
              </div>
              <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
              <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
              <div class="col-md-12">
                <input type="hidden" value="<?php echo $kode_perumahan?>" name="kode_perumahan">

                <input type="submit" class="btn btn-info btn-flat" value="SEARCH" />
                <button type="button" id="thisPrint" class="btn btn-info btn-flat" style="">CETAK</button>
              </div>
            </div>
          </form>
        </div>
        
        <?php if(isset($kode)){?>
          <span>Pilihan saat ini: <?php if($kode == ""){echo "Semua";} else {echo $kode;}?></span>
        <?php }
        if(isset($kategori)){
          echo ", ".$kategori; 
        }
        
        $debet = 0; $kredit = 0;?>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table">
                </table>
                <table id="example2" class="table table-bordered table-striped" style="font-size: 12px;">
                  <div style="text-align: center">
                    <h3><?php echo $nama_perusahaan?></h3>
                    <h3>Laporan Perubahan Modal</h3>
                    <h5>Per. <?php echo date('t F Y', strtotime($tgl));?></h5>
                  </div>
                  <thead>
                    <!-- <tr style="">
                      <th colspan=4></th>
                      <th colspan=2 style="font-size: 12px">SALDO MUTASI DEBET</th>
                      <th>NAMA AKUN</th>
                      <th style="white-space: nowrap"><?php 
                        //   echo "Rp. ".number_format($debet);
                        ?><div id="tdebet"></div></th>
                      <th colspan=2 style="font-size: 12px">SALDO MUTASI KREDIT</th>
                      <th>NAMA AKUN</th>
                      <th style="white-space: nowrap"><?php 
                        //   echo "Rp. ".number_format($kredit);
                        ?><div id="tkredit"></div></th>
                    </tr> -->
                    
                    <!-- <tr>
                        <th colspan=3></th>
                        <th>AWAL</th>
                        <th>BERJALAN</th>
                        <th>JURNAL KOREKSI</th>
                        <th>AKHIR</th>
                        <th>Status</th>
                        <th>Jmlh Diterima</th>
                    </tr> -->
                  </thead>
                  <tbody style="white-space: nowrap">
                    <?php 
                    $qus = $this->db->get_where('perumahan', array('kode_perusahaan'=>$id));
                    $p1=0; $p6=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"41000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $total=0; $db=0; $kr=0; $total_jr=0; $db1=0; $kr1=0; $db2=0; $db3=0; $kr2=0; $kr3=0;
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res){
                              $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res->kode_perumahan));
                              if($ts->num_rows() > 0){
                              foreach($ts->result() as $akun){?>
                                <?php
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res->kode_perumahan, $tglmin)->result() as $sld){
                                        if($sld->pos_akun == "kredit"){
                                            $kr_sld = $kr_sld + $sld->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                            $db_sld = $db_sld + $sld->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        $ttl_sld = 0;
                                        if($akun->pos == "Kredit"){ 
                                        $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                        } else if($akun->pos == "Debet") {
                                        $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                        }

                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                        if($sld->pos_akun == "kredit"){
                                            $kr_jrl = $kr_jrl + $sld->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                            $db_jrl = $db_jrl + $sld->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                        if($sld1->pos_akun == "kredit"){
                                            $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                        } else if($sld1->pos_akun == "debet") {
                                            $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                        if($sld2->pos_akun == "debet"){
                                            $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                        } else if($sld2->pos_akun == "kredit") {
                                            $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        if($akun->pos == "Kredit"){ 
                                        $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                        } else if($akun->pos == "Debet") {
                                        $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                        }
                                    
                                  }
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res->kode_perumahan, "", $tglmin)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, "", $tglmin, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                


                                <?php
                                // print_r($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penutup")->result());
                                foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, "", $tglmin, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                                

                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                            <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                            ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p1 = $p1 + $ttl_sld;
                            $p6 = $p6 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                        </tr> -->
                    <?php } else {
                            // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            
                            // </tr>";
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL PENDAPATAN</td>
                      <td><?php echo "Rp. ".number_format($p1);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6);?></td>
                    </tr> -->

                    <?php $p2=0; $p7=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"61000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                            <!-- <tr>
                                <td><?php echo $anak->no_akun?></td>
                                <td><?php echo $anak->nama_akun?></td>
                                <td><?php echo $anak->pos?></td> -->
                                <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2=0; $kr2=0; $db3=0; $kr3=0;
                                if($qus->num_rows() > 0){
                                foreach($qus->result() as $res1){
                                    $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res1->kode_perumahan));
                                    if($ts->num_rows() > 0){
                                    foreach($ts->result() as $akun){?>
                                        <?php
                                        if(isset($tgl_awal)){
                                        $ttl_sld = $akun->nominal;
                                        } else {
                                        if($tglmin != ""){
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res1->kode_perumahan, $tglmin)->result() as $sld){
                                            if($sld->pos_akun == "kredit"){
                                                $kr_sld = $kr_sld + $sld->nominal;
                                            } else if($sld->pos_akun == "debet") {
                                                $db_sld = $db_sld + $sld->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            $ttl_sld = 0;
                                            if($akun->pos == "Kredit"){ 
                                            $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                            } else if($akun->pos == "Debet") {
                                            $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                            }

                                            
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                            if($sld->pos_akun == "kredit"){
                                                $kr_jrl = $kr_jrl + $sld->nominal;
                                            } else if($sld->pos_akun == "debet") {
                                                $db_jrl = $db_jrl + $sld->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                            if($sld1->pos_akun == "kredit"){
                                                $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                            } else if($sld1->pos_akun == "debet") {
                                                $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                            if($sld2->pos_akun == "debet"){
                                                $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                            } else if($sld2->pos_akun == "kredit") {
                                                $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            if($akun->pos == "Kredit"){ 
                                            $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                            } else if($akun->pos == "Debet") {
                                            $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                            }
                                        }
                                        }?>
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res1->kode_perumahan, "", $tglmin)->result() as $pos){
                                          if($pos->pos_akun == "kredit"){
                                              $kr = $kr + $pos->nominal;
                                          } else if($pos->pos_akun == "debet") {
                                              $db = $db + $pos->nominal;
                                          }
                                        }
                                        $total = 0;
                                        if($akun->pos == "Kredit"){ 
                                        $total = $total + $kr - $db;
                                        } else if($akun->pos == "Debet") {
                                        $total = $total + $db - $kr;
                                        }?>
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, "", $tglmin, "koreksi")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr1 = $kr1 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db1 = $db1 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr=0;
                                        if($akun->pos == "Kredit"){ 
                                        $total_jr = $total_jr + $kr1 - $db1;
                                        } else if($akun->pos == "Debet") {
                                        $total_jr = $total_jr + $db1 - $kr1;
                                        }?>
                                        
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr2 = $kr2 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db2 = $db2 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr2=0;
                                        if($akun->pos == "Kredit"){ 
                                        $total_jr2 = $total_jr2 + $kr2 - $db2;
                                        } else if($akun->pos == "Debet") {
                                        $total_jr2 = $total_jr2 + $db2 - $kr2;
                                        }?>
                                        
                                        
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, "", $tglmin, "penutup")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr3 = $kr3 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db3 = $db3 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr1=0;
                                        
                                        if($akun->pos == "Debet"){ 
                                        $total_jr1 = $total_jr1 + $kr3;
                                        } else if($akun->pos == "Kredit") {
                                        $total_jr1 = $total_jr1 + $db3;
                                        }?>

                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                        <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                        ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p2 = $p2 + $ttl_sld;
                            $p7 = $p7 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                        </tr> -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL PEMBELIAN</td>
                      <td><?php echo "Rp. ".number_format($p2);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p7);?></td> 
                    </tr> -->

                    <!-- <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=7 style=" font-size: 16px">LABA KOTOR</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7);?></td>
                    </tr> -->

                    <?php $p3=0; $p8=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"52000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                            <!-- <tr>
                              <td><?php echo $anak->no_akun?></td>
                              <td><?php echo $anak->nama_akun?></td>
                              <td><?php echo $anak->pos?></td> -->
                              <?php $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $total_jr1=0; $db1=0; $kr1=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2 = 0; $kr2=0; $db3=0; $kr3=0;
                              if($qus->num_rows() > 0){
                              foreach($qus->result() as $res2){
                              $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res2->kode_perumahan));
                              if($ts->num_rows() > 0){
                              foreach($ts->result() as $akun){?>
                                <?php
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res2->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld = 0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res2->kode_perumahan, "", $tglmin)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                // echo $db;
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, "", $tglmin, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0; 
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0; 
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, "", $tglmin, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                        <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                        ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p3 = $p3 + $ttl_sld;
                            $p8 = $p8 + $ttl_sld+$total+$total_jr+$total_jr2+$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr-$total_jr1+$total_jr2);?>
                        </td>

                        </tr> -->
                    <?php } else {
                            // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            
                            // </tr>";
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL BIAYA KONSTRUKSI DAN FINISHING</td>
                      <td><?php echo "Rp. ".number_format($p3);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p8);?></td> 
                    </tr> -->

                    <?php $p4=0; $p9=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"51000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res3){
                            if($ts->num_rows() > 0){ 
                            foreach($ts->result() as $akun){?>
                                <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2=0; $kr2=0; $db3=0; $kr3=0;
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res3->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld=0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res3->kode_perumahan, "", $tglmin)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, "", $tglmin, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, "", $tglmin, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                        <?php }} else {
                        }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                        <td>
                          <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                          ?>
                        </td>

                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p4 = $p4 + $ttl_sld;
                            $p9 = $p9 + $ttl_sld+$total+$total_jr+$total_jr2+$total_jr1;
                          echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                      </tr>  -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                      }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL BIAYA OVERHEAD PERUSAHAAN</td>
                      <td><?php echo "Rp. ".number_format($p4);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p9);?></td> 
                    </tr> -->

                    <!-- <tr style="font-weight: bold; background-color: lightblue; ">
                      <td colspan=7 style="font-size: 16px">BIAYA BIAYA</td>
                      <td><?php echo "Rp. ".number_format($p3+$p4);?></td> 
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p8+$p9);?></td>
                    </tr> -->

                    <!-- <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=7 style=" font-size: 16px">LABA SEBELUM PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4));?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7-($p8+$p9));?></td>
                    </tr> -->

                    <?php $p5=0; $p10=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"53000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res4){
                            if($ts->num_rows() > 0){
                            foreach($ts->result() as $akun){?>
                                <?php $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db=0; $kr=0; $total_jr=0; $db1=0; $kr1=0; $db2=0;$kr2=0;$db3=0;$kr3=0;
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res4->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld = 0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res4->kode_perumahan, "", $tglmin)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total=0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, "", $tglmin ,"koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr=0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2=0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, "", $tglmin, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1=0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                            <?php }} else {
                            }?> 
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                        <td>
                          <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                          ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>

                        <td><?php 
                        $p5 = $p5 + $ttl_sld;
                        $p10 = $p10 + $ttl_sld+$total+$total_jr+$total_jr1+$total_jr2;
                        echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                      </tr>   -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                      }
                    }}?>
                    
                    <?php
                    $ttl_prive = 0; $kr=0; $db=0; 
                    if($tglmin != ""){?>
                    <?php 
                    foreach($qus->result() as $rep){
                        foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>"31003", 'kode_perumahan'=>$rep->kode_perumahan))->result() as $prive1){?>
                      <!-- <tr style="background-color: pink">
                        <td><?php echo $prive->no_akun?></td>
                        <td colspan=2><?php echo $prive->nama_akun?></td>
                        <td><?php echo $prive->pos?></td> -->
                        <?php
                        foreach($this->Dashboard_model->perubahan_modal($prive1->no_akun, $rep->kode_perumahan, "", $tglmin)->result() as $prb_prv){
                          if($prb_prv->pos_akun == "kredit"){
                            $kr = $kr + $prb_prv->nominal;
                          } else if($prb_prv->pos_akun == "debet"){
                            $db = $db + $prb_prv->nominal;
                          }
                        }
                        $ttl_prive = 0;
                        if($prive1->pos == "Kredit"){
                          $ttl_prive = $ttl_prive + $kr - $db;
                        } else if($prive1->pos == "Debet"){
                          $ttl_prive = $ttl_prive + $db - $kr;
                        }?>
                        <!-- <td>
                          <?php echo "Rp. ".number_format($ttl_prive);?>
                        </td>
                      </tr> -->
                    <?php }}}?>
                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=7>TOTAL BIAYA PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p5);?></td> 
                      <td><?php echo "Rp. ".number_format($p10);?></td>
                    </tr>

                    <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=8 style=" font-size: 16px">LABA / RUGI BERSIH SETELAH PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4)-$p5);?></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7-($p8+$p9)-$p10);?></td>
                    </tr> -->
                    <!-- <td><?php echo number_format($p4)?></td> -->

                    <?php 
                    $ttl_mdl_test=0; $total_jr=0; $db=0; $kr=0; $total_jr2=0; $db1=0; $kr1=0; $ttl_sld=0; $kr_jrl1 = 0; $db_jrl1 = 0; $kr_jrl=0; $db_jrl=0;
                    foreach($qus->result() as $rep_mdl){
                    foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>"31001", 'kode_perumahan'=>$rep_mdl->kode_perumahan))->result() as $modal){?>
                        
                        <?php 
                        
                        if($tglmin != ""){
                          ?>
                          <?php 
                          foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal->no_akun, $rep_mdl->kode_perumahan, "", $tglmin, "koreksi")->result() as $sld){
                            if($sld->pos_akun == "kredit"){
                              $kr_jrl = $kr_jrl + $sld->nominal;
                            } else if($sld->pos_akun == "debet") {
                              $db_jrl = $db_jrl + $sld->nominal;
                            }
                            // $ttl_sld = $ttl_sld + $sld->nominal;
                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                          }
                          foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal->no_akun, $rep_mdl->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $sld1){
                            if($sld1->pos_akun == "kredit"){
                              $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                            } else if($sld1->pos_akun == "debet") {
                              $db_jrl1 = $db_jrl1 + $sld1->nominal;
                            }
                            // $ttl_sld = $ttl_sld + $sld->nominal;
                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                          }
                          $ttl_sld = 0;
                          if($modal->pos == "Kredit"){ 
                            $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1);
                          } else if($modal->pos == "Debet") {
                            $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1);
                          }
                        }
                        ?> 
                        <!-- <td><?php echo $ttl_sld?></td> -->

                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal->no_akun, $rep_mdl->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                          if($jrnl->pos_akun == "kredit"){
                            $kr = $kr + $jrnl->nominal;
                          } else if($jrnl->pos_akun == "debet") {
                            $db = $db + $jrnl->nominal;
                          }
                        }
                        $total_jr=0;
                        if($modal->pos == "Kredit"){ 
                          $total_jr = $total_jr + $kr - $db;
                        } else if($modal->pos == "Debet") {
                          $total_jr = $total_jr + $db - $kr;
                        }?>
                        <!-- <td><?php echo "Rp. ".number_format($total_jr);?></td> -->
                        
                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal->no_akun, $rep_mdl->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                          if($jrnl->pos_akun == "kredit"){
                            $kr1 = $kr1 + $jrnl->nominal;
                          } else if($jrnl->pos_akun == "debet") {
                            $db1 = $db1 + $jrnl->nominal;
                          }
                        }
                        if($modal->pos == "Kredit"){ 
                          $total_jr2 = $total_jr2 + $kr1 - $db1;
                        } else if($modal->pos == "Debet") {
                          $total_jr2 = $total_jr2 + $db1 - $kr1;
                        }?>
                          <!-- <td><?php echo "Rp. ".number_format($total_jr2);?></td> -->

                        <?php $ttl_mdl_awal = 0; $kr=0; $db=0;
                        foreach($this->Dashboard_model->perubahan_modal($modal->no_akun, $rep_mdl->kode_perumahan, $tglmin, $tglmax)->result() as $prb_mdl){
                          if($prb_mdl->pos_akun == "kredit"){
                            $kr = $kr + $prb_mdl->nominal;
                          } else if($prb_mdl->pos_akun == "debet"){
                            $db = $db + $prb_mdl->nominal;
                          }
                        }
                        if($modal->pos == "Kredit"){
                          $ttl_mdl_awal = $ttl_mdl_awal + $kr - $db;
                        } else if($modal->pos == "Debet"){
                          $ttl_mdl_awal = $ttl_mdl_awal + $db - $kr;
                        }?>

                        <?php
                        // $ttl_mdl_awal = $ttl_mdl_awal+(($p1-$p2-($p3+$p4)-$p5)-$ttl_prive)+$modal->nominal + ($ttl_sld + $total_jr1 + $total_jr2);
                        $ttl_mdl_test = $ttl_mdl_test + $modal->nominal + ($ttl_sld + $total_jr1 + $total_jr2);
                        ?>
                    <?php }}
                        $ttl_mdl_test = $ttl_mdl_test + (($p1-$p2-($p3+$p4)-$p5)-$ttl_prive);
                    ?>
                    <tr style="background-color: lightblue">
                        <td><?php echo $modal->no_akun?></td>
                        <td><?php echo $modal->nama_akun?></td>
                        <td>AWAL</td>
                        <td><?php echo $modal->pos?></td>

                        <td>
                        <!-- <td><?php echo number_format($p1)?></td>   -->
                        <?php echo "Rp. ".number_format($ttl_mdl_test);?>
                        </td>
                    </tr>
                    
                    <?php 
                    $total_jr=0; $db=0; $kr=0; $total_jr2=0; $db1=0; $kr1=0; $ttl_sld=0; $kr_jrl1 = 0; $db_jrl1 = 0; $kr_jrl=0; $db_jrl=0; $ttl_prive = 0; $kr=0; $db=0;
                    foreach($qus->result() as $rep_prv){
                    foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>"31003", 'kode_perumahan'=>$rep_prv->kode_perumahan))->result() as $prive){?>

                        <?php 
                        
                        if($tglmin != ""){
                          ?>
                          <?php 
                          foreach($this->Dashboard_model->laba_rugi_pos_jurnal($prive->no_akun, $rep_prv->kode_perumahan, "", $tglmin, "koreksi")->result() as $sld){
                            if($sld->pos_akun == "kredit"){
                              $kr_jrl = $kr_jrl + $sld->nominal;
                            } else if($sld->pos_akun == "debet") {
                              $db_jrl = $db_jrl + $sld->nominal;
                            }
                            // $ttl_sld = $ttl_sld + $sld->nominal;
                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                          }
                          foreach($this->Dashboard_model->laba_rugi_pos_jurnal($prive->no_akun, $rep_prv->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $sld1){
                            if($sld1->pos_akun == "kredit"){
                              $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                            } else if($sld1->pos_akun == "debet") {
                              $db_jrl1 = $db_jrl1 + $sld1->nominal;
                            }
                            // $ttl_sld = $ttl_sld + $sld->nominal;
                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                          }
                          
                          if($prive->pos == "Kredit"){ 
                            $ttl_sld = $ttl_sld + $kr_jrl + $kr_jrl1;
                          } else if($prive->pos == "Debet") {
                            $ttl_sld = $ttl_sld + $db_jrl + $db_jrl1;
                          }
                        }
                        ?> 
                        <!-- <td><?php echo $ttl_sld?></td> -->

                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($prive->no_akun, $rep_prv->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                          if($jrnl->pos_akun == "kredit"){
                            $kr = $kr + $jrnl->nominal;
                          } else if($jrnl->pos_akun == "debet") {
                            $db = $db + $jrnl->nominal;
                          }
                        }
                        if($prive->pos == "Kredit"){ 
                          $total_jr = $total_jr + $kr - $db;
                        } else if($prive->pos == "Debet") {
                          $total_jr = $total_jr + $db - $kr;
                        }?>
                        <!-- <td><?php echo "Rp. ".number_format($total_jr);?></td> -->
                        
                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($prive->no_akun, $rep_prv->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                          if($jrnl->pos_akun == "kredit"){
                            $kr1 = $kr1 + $jrnl->nominal;
                          } else if($jrnl->pos_akun == "debet") {
                            $db1 = $db1 + $jrnl->nominal;
                          }
                        }
                        if($prive->pos == "Kredit"){ 
                          $total_jr2 = $total_jr2 + $kr1 - $db1;
                        } else if($prive->pos == "Debet") {
                          $total_jr2 = $total_jr2 + $db1 - $kr1;
                        }?>

                        <?php
                        foreach($this->Dashboard_model->perubahan_modal($prive->no_akun, $rep_prv->kode_perumahan, $tglmin, $tglmax)->result() as $prb_prv){
                          if($prb_prv->pos_akun == "kredit"){
                            $kr = $kr + $prb_prv->nominal;
                          } else if($prb_prv->pos_akun == "debet"){
                            $db = $db + $prb_prv->nominal;
                          }
                        }
                        $ttl_prive= 0;
                        if($prive->pos == "Kredit"){
                          $ttl_prive = $ttl_prive + $kr - $db;
                        } else if($prive->pos == "Debet"){
                          $ttl_prive = $ttl_prive + $db - $kr;
                        }
                        
                        $ttl_prive = $ttl_prive + $prive->nominal + ($ttl_sld + $total_jr1 + $total_jr2);
                        ?>
                    <?php }}?>
                      <tr style="background-color: pink">
                        <td><?php echo $prive->no_akun?></td>
                        <td colspan=2><?php echo $prive->nama_akun?></td>
                        <td><?php echo $prive->pos?></td>
                        <td>
                          <?php echo "Rp. ".number_format($ttl_prive);?>
                        </td>
                      </tr>

                    
                      <?php 
                    $qus = $this->db->get_where('perumahan', array('kode_perusahaan'=>$id));
                    $p1=0; $p6=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"41000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $total=0; $db=0; $kr=0; $total_jr=0; $db1=0; $kr1=0; $db2=0; $db3=0; $kr2=0; $kr3=0;
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res){
                              $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res->kode_perumahan));
                              if($ts->num_rows() > 0){
                              foreach($ts->result() as $akun){?>
                                <?php
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res->kode_perumahan, $tglmin)->result() as $sld){
                                        if($sld->pos_akun == "kredit"){
                                            $kr_sld = $kr_sld + $sld->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                            $db_sld = $db_sld + $sld->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        $ttl_sld = 0;
                                        if($akun->pos == "Kredit"){ 
                                        $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                        } else if($akun->pos == "Debet") {
                                        $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                        }

                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                        if($sld->pos_akun == "kredit"){
                                            $kr_jrl = $kr_jrl + $sld->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                            $db_jrl = $db_jrl + $sld->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                        if($sld1->pos_akun == "kredit"){
                                            $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                        } else if($sld1->pos_akun == "debet") {
                                            $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                        if($sld2->pos_akun == "debet"){
                                            $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                        } else if($sld2->pos_akun == "kredit") {
                                            $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        if($akun->pos == "Kredit"){ 
                                        $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                        } else if($akun->pos == "Debet") {
                                        $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                        }
                                    
                                  }
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res->kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                


                                <?php
                                // print_r($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penutup")->result());
                                foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                                

                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                            <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                            ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p1 = $p1 + $ttl_sld+$total+$total_jr+$total_jr2;
                            $p6 = $p6 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                        </tr> -->
                    <?php } else {
                            // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            
                            // </tr>";
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL PENDAPATAN</td>
                      <td><?php echo "Rp. ".number_format($p1);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6);?></td>
                    </tr> -->

                    <?php $p2=0; $p7=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"61000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                            <!-- <tr>
                                <td><?php echo $anak->no_akun?></td>
                                <td><?php echo $anak->nama_akun?></td>
                                <td><?php echo $anak->pos?></td> -->
                                <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2=0; $kr2=0; $db3=0; $kr3=0;
                                if($qus->num_rows() > 0){
                                foreach($qus->result() as $res1){
                                    $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res1->kode_perumahan));
                                    if($ts->num_rows() > 0){
                                    foreach($ts->result() as $akun){?>
                                        <?php
                                        if(isset($tgl_awal)){
                                        $ttl_sld = $akun->nominal;
                                        } else {
                                        if($tglmin != ""){
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res1->kode_perumahan, $tglmin)->result() as $sld){
                                            if($sld->pos_akun == "kredit"){
                                                $kr_sld = $kr_sld + $sld->nominal;
                                            } else if($sld->pos_akun == "debet") {
                                                $db_sld = $db_sld + $sld->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            $ttl_sld = 0;
                                            if($akun->pos == "Kredit"){ 
                                            $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                            } else if($akun->pos == "Debet") {
                                            $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                            }

                                            
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                            if($sld->pos_akun == "kredit"){
                                                $kr_jrl = $kr_jrl + $sld->nominal;
                                            } else if($sld->pos_akun == "debet") {
                                                $db_jrl = $db_jrl + $sld->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                            if($sld1->pos_akun == "kredit"){
                                                $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                            } else if($sld1->pos_akun == "debet") {
                                                $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                            if($sld2->pos_akun == "debet"){
                                                $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                            } else if($sld2->pos_akun == "kredit") {
                                                $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            if($akun->pos == "Kredit"){ 
                                            $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                            } else if($akun->pos == "Debet") {
                                            $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                            }
                                        }
                                        }?>
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res1->kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                          if($pos->pos_akun == "kredit"){
                                              $kr = $kr + $pos->nominal;
                                          } else if($pos->pos_akun == "debet") {
                                              $db = $db + $pos->nominal;
                                          }
                                        }
                                        $total = 0;
                                        if($akun->pos == "Kredit"){ 
                                        $total = $total + $kr - $db;
                                        } else if($akun->pos == "Debet") {
                                        $total = $total + $db - $kr;
                                        }?>
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr1 = $kr1 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db1 = $db1 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr=0;
                                        if($akun->pos == "Kredit"){ 
                                        $total_jr = $total_jr + $kr1 - $db1;
                                        } else if($akun->pos == "Debet") {
                                        $total_jr = $total_jr + $db1 - $kr1;
                                        }?>
                                        
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr2 = $kr2 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db2 = $db2 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr2=0;
                                        if($akun->pos == "Kredit"){ 
                                        $total_jr2 = $total_jr2 + $kr2 - $db2;
                                        } else if($akun->pos == "Debet") {
                                        $total_jr2 = $total_jr2 + $db2 - $kr2;
                                        }?>
                                        
                                        
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr3 = $kr3 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db3 = $db3 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr1=0;
                                        
                                        if($akun->pos == "Debet"){ 
                                        $total_jr1 = $total_jr1 + $kr3;
                                        } else if($akun->pos == "Kredit") {
                                        $total_jr1 = $total_jr1 + $db3;
                                        }?>

                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                        <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                        ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p2 = $p2 + $ttl_sld+$total+$total_jr+$total_jr2;
                            $p7 = $p7 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                        </tr> -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL PEMBELIAN</td>
                      <td><?php echo "Rp. ".number_format($p2);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p7);?></td> 
                    </tr> -->

                    <!-- <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=7 style=" font-size: 16px">LABA KOTOR</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7);?></td>
                    </tr> -->

                    <?php $p3=0; $p8=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"52000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                            <!-- <tr>
                              <td><?php echo $anak->no_akun?></td>
                              <td><?php echo $anak->nama_akun?></td>
                              <td><?php echo $anak->pos?></td> -->
                              <?php $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $total_jr1=0; $db1=0; $kr1=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2 = 0; $kr2=0; $db3=0; $kr3=0;
                              if($qus->num_rows() > 0){
                              foreach($qus->result() as $res2){
                              $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res2->kode_perumahan));
                              if($ts->num_rows() > 0){
                              foreach($ts->result() as $akun){?>
                                <?php
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res2->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld = 0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res2->kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                // echo $db;
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0; 
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0; 
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                        <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                        ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p3 = $p3 + $ttl_sld+$total+$total_jr+$total_jr2;
                            $p8 = $p8 + $ttl_sld+$total+$total_jr+$total_jr2+$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr-$total_jr1+$total_jr2);?>
                        </td>

                        </tr> -->
                    <?php } else {
                            // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            
                            // </tr>";
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL BIAYA KONSTRUKSI DAN FINISHING</td>
                      <td><?php echo "Rp. ".number_format($p3);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p8);?></td> 
                    </tr> -->

                    <?php $p4=0; $p9=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"51000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res3){
                            if($ts->num_rows() > 0){ 
                            foreach($ts->result() as $akun){?>
                                <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2=0; $kr2=0; $db3=0; $kr3=0;
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res3->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld=0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res3->kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                        <?php }} else {
                        }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                        <td>
                          <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                          ?>
                        </td>

                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                          $p4 = $p4 + $ttl_sld+$total+$total_jr+$total_jr2;
                          $p9 = $p9 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                          echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                      </tr>  -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                      }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL BIAYA OVERHEAD PERUSAHAAN</td>
                      <td><?php echo "Rp. ".number_format($p4);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p9);?></td> 
                    </tr> -->

                    <!-- <tr style="font-weight: bold; background-color: lightblue; ">
                      <td colspan=7 style="font-size: 16px">BIAYA BIAYA</td>
                      <td><?php echo "Rp. ".number_format($p3+$p4);?></td> 
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p8+$p9);?></td>
                    </tr> -->

                    <!-- <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=7 style=" font-size: 16px">LABA SEBELUM PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4));?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7-($p8+$p9));?></td>
                    </tr> -->

                    <?php $p5=0; $p10=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"53000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res4){
                            if($ts->num_rows() > 0){
                            foreach($ts->result() as $akun){?>
                                <?php $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db=0; $kr=0; $total_jr=0; $db1=0; $kr1=0; $db2=0;$kr2=0;$db3=0;$kr3=0;
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res4->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld = 0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res4->kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total=0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr=0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2=0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1=0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                            <?php }} else {
                            }?> 
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                        <td>
                          <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                          ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>

                        <td><?php 
                        $p5 = $p5 + $ttl_sld+$total+$total_jr+$total_jr2;
                        $p10 = $p10 + $ttl_sld+$total+$total_jr+$total_jr1+$total_jr2;
                        echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                      </tr>   -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                      }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=7>TOTAL BIAYA PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p5);?></td> 
                      <td><?php echo "Rp. ".number_format($p10);?></td>
                    </tr>

                    <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=8 style=" font-size: 16px">LABA / RUGI BERSIH SETELAH PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4)-$p5);?></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7-($p8+$p9)-$p10);?></td>
                    </tr> -->
                    <tr style="background-color: pink">
                      <td></td>
                      <td colspan=3>Laba/Rugi Bersih Tahun Berjalan</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4)-$p5);?></td>
                    </tr>
                    <tr style="background-color: pink">
                      <td style="background-color: pink" colspan=4></td>
                      <td style="background-color: pink"><?php echo "Rp. ".number_format(($p1-$p2-($p3+$p4)-$p5)-$ttl_prive);?></td>
                    </tr>

                    <?php 
                    foreach($qus->result() as $rep_end){
                        foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>"31001", 'kode_perumahan'=>$rep_end->kode_perumahan))->result() as $modal_s){?>
                    <?php }}?>
                      <tr style="background-color: lightblue">
                        <td><?php echo $modal_s->no_akun?></td>
                        <td><?php echo $modal_s->nama_akun?></td>
                        <td colspan=2>AKHIR</td>
                        <!-- <td><?php echo $modal_s->pos?></td> -->
                        <td>
                          <?php echo "Rp. ".number_format((($p1-$p2-($p3+$p4)-$p5)-$ttl_prive)+$ttl_mdl_test);?>
                        </td>
                      </tr>
                  </tfoot>
                </table>
                <input type="hidden" value="<?php echo number_format($debet)?>" id="Debet">
                <input type="hidden" value="<?php echo number_format($kredit)?>" id="Kredit">
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail POS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div style="text-align: center">Debet</div>
          </div>
          <div class="col-md-6">
            <div style="text-align: center">Kredit</div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>
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

function myFunction1(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PSJB ini di batalkan?");
  if (r == true) {
    window.location.replace(base_url+"/psjb_pembatalan?id="+id);
  } else {
    window.location.replace(base_url+"/psjb_management")
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "scrollX": true
    });
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true
    });
    
  });

</script>
<script type="text/javascript">
  $(function () {
    $("#date").datepicker();
    $("#checkout").datepicker();
  });

  $(document).ready(function(){
    $('#thisPrint').on('click', function(){
      window.print();
    })
  })

  $(function() {
    var b = $("#button");
    var w = $("#wrapper");
    var l = $("#list");
    b.click(function() {
      w.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });
  });

  $(document).ready(function(){ 
    var check = $('#Debet').val();
    // var i;
    $('#tdebet').html("Rp. "+check);
    // $('#volume1').val(check);
    var check2 = $('#Kredit').val();
    // var i;
    $('#tkredit').html("Rp. "+check2);
    // $('#volume1').val(check);
  })
</script>
</body>
</html>
