<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <?php include "include/title.php"?>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?php echo base_url()?>assets/dropzone-5.7.0/dist/dropzone.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php include "include/navbar.php"?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "include/sidebar.php"?>

  <!-- START OF DATA PRIBADI -->
  <?php 
  if(isset($data_dbm)){
    foreach($data_dbm->result() as $row) {?>
        <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Balik Nama - Data Pribadi</h1>
                <!-- <h5>Pembayaran Piutang</h5> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Data Pribadi</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?php echo base_url()?>Dashboard/view_daftar_balik_nama?id=<?php echo $kode;?>" class="btn btn-success btn-sm">Kembali</a>
                                </div>
                <!-- /.card-header -->
                
                                <form action="<?php echo base_url()?>Dashboard/update_data_dbm" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <table>
                                                        <tr>
                                                            <td>Unit</td><td>:</td><td><?php echo $row->no_kavling?></td>
                                                        </tr>
                                                            <?php $jmlh_sertif=0;
                                                            $query = $this->db->get_where('rumah', array('kode_rumah'=>$row->no_kavling, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                                                            foreach($query->result() as $rumah) {?>
                                                                <tr>
                                                                    <td>No SHM</td><td>:</td><td>
                                                                    <input type="hidden" name="no_kavling" value="<?php echo $row->no_kavling?>">
                                                                    <!-- <input type="hidden" name="kode_perumahan" value="<?php echo $row->kode_perumahan?>"> -->
                                                                    <input type="text" name="no_shm" value="<?php echo $rumah->no_shm?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No PBB</td><td>:</td><td><input type="text" name="no_pbb" value="<?php echo $rumah->no_pbb?>"></td>
                                                                </tr>
                                                            <?php $jmlh_sertif = $jmlh_sertif+1;}?>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            Jumlah sertifikat: <?php echo $jmlh_sertif;?> buah
                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <!-- <form action="<?php echo base_url()?>Dashboard/update_data_dbm" method="POST" enctype="multipart/form-data"> -->
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                                        <input type="hidden" value="<?php echo $row->psjb?>" name="no_psjb">
                                                        <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">

                                                        <div class="form-group">
                                                            <label>No AJB</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->no_ajb?>" name="no_ajb">
                                                            </div>

                                                        <div class="form-group">
                                                            <label>No SU</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->no_su?>" name="no_su">
                                                            </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Nama Sertifikat</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->nama_sertif?>" name="nama_sertif">
                                                            </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>KTP</label>
                                                            <select class="form-control" name="ktp">
                                                                <?php if($row->ktp_ada == "sudah"){?>
                                                                    <option value="sudah" selected>sudah</option>
                                                                    <option value="belum">belum</option>
                                                                <?php } else if($row->ktp_ada == "belum") { ?>
                                                                    <option value="sudah">sudah</option>
                                                                    <option value="belum" selected>belum</option>
                                                                <?php } else { ?>
                                                                    <option selected disabled value="">-Pilih-</option>
                                                                    <option value="sudah">sudah</option>
                                                                    <option value="belum">belum</option>
                                                                <?php }?>
                                                            </select>
                                                            <span>Pilihan sekarang: 
                                                                <?php if($row->ktp_ada == "" || $row->ktp_ada == "belum"){
                                                                    echo "belum";
                                                                } else {
                                                                    echo "sudah";   
                                                                }?>
                                                            </span>
                                                            </div>

                                                        <div class="form-group">
                                                            <label>KK</label>
                                                            <select class="form-control" name="kk">
                                                                <?php if($row->kk_ada == "sudah"){?>
                                                                    <option value="sudah" selected>sudah</option>
                                                                    <option value="belum">belum</option>
                                                                <?php } else if($row->kk_ada == "belum") { ?>
                                                                    <option value="sudah">sudah</option>
                                                                    <option value="belum" selected>belum</option>
                                                                <?php } else { ?>
                                                                    <option selected disabled value="">-Pilih-</option>
                                                                    <option value="sudah">sudah</option>
                                                                    <option value="belum">belum</option>
                                                                <?php }?>
                                                            </select>
                                                            <span>Pilihan sekarang: 
                                                                <?php if($row->kk_ada == "" || $row->kk_ada == "belum"){
                                                                    echo "belum";
                                                                } else {
                                                                    echo "sudah";   
                                                                }?>
                                                            </span>
                                                            </div>

                                                        <div class="form-group">
                                                            <label>Tgl Terima Berkas</label>
                                                            <input type="date" name="tgl_berkas" class="form-control" value="<?php echo $row->tgl_terima?>">
                                                            </div>
                                                        
                                                        <!-- <input type="submit" class="btn btn-success btn-sm" value="Update"> -->
                                                    </div>
                                                    <div class="col-md-12">
                                                        <?php if(isset($succ_msg)){
                                                            echo "<span style='color: green'>$succ_msg</span><br>";
                                                        }?>
                                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                <!-- /.card -->
                        </div>
            <!-- /.col -->
                    </div>
            <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
  </div>

  <?php }} else if(isset($data_dbm_unit2)){
    foreach($data_dbm_unit2->result() as $row) {?>
        <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Balik Nama - Data Pribadi</h1>
                <!-- <h5>Pembayaran Piutang</h5> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Data Pribadi</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?php echo base_url()?>Dashboard/view_daftar_balik_nama?id=<?php echo $kode;?>" class="btn btn-success btn-sm">Kembali</a>
                                </div>
                <!-- /.card-header -->
                
                                <form action="<?php echo base_url()?>Dashboard/update_data_dbm_unit2" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <table>
                                                        <tr>
                                                            <td>Unit</td><td>:</td><td><?php echo $row->kode_rumah?></td>
                                                        </tr>
                                                            <?php $jmlh_sertif=0;
                                                            $query = $this->db->get_where('rumah', array('kode_rumah'=>$id, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                                                            foreach($query->result() as $rumah) {?>
                                                            <?php $jmlh_sertif = $jmlh_sertif+1;}?>
                                                            
                                                        <tr>
                                                            <td>No SHM</td><td>:</td><td>
                                                            <input type="hidden" name="no_kavling" value="<?php echo $row->kode_rumah?>">
                                                            <!-- <input type="hidden" name="kode_perumahan" value="<?php echo $row->kode_perumahan?>"> -->
                                                            <input type="text" name="no_shm" value="<?php echo $row->no_shm?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>No PBB</td><td>:</td><td><input type="text" name="no_pbb" value="<?php echo $row->no_pbb?>"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            Jumlah sertifikat: <?php echo $jmlh_sertif;?> buah
                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <!-- <form action="<?php echo base_url()?>Dashboard/update_data_dbm" method="POST" enctype="multipart/form-data"> -->
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                                        <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_psjb">
                                                        <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">

                                                        <div class="form-group">
                                                            <label>No AJB</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->no_ajb?>" name="no_ajb">
                                                            </div>

                                                        <div class="form-group">
                                                            <label>No SU</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->no_su?>" name="no_su">
                                                            </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Nama Sertifikat</label>
                                                            <?php 
                                                                if($row->nama_sertif == ""){
                                                                    foreach($this->db->get_where('psjb', array('no_psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as $nama){?>
                                                                        <input type="text" class="form-control" value="<?php echo $nama->nama_sertif?>" name="nama_sertif">
                                                            <?php }} else { ?>
                                                                <input type="text" class="form-control" value="<?php echo $row->nama_sertif?>" name="nama_sertif">
                                                            <?php }?>
                                                            </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>KTP</label>
                                                            <select class="form-control" name="ktp">
                                                                <?php if($row->ktp_ada == "sudah"){?>
                                                                    <option value="sudah" selected>sudah</option>
                                                                    <option value="belum">belum</option>
                                                                <?php } else if($row->ktp_ada == "belum") { ?>
                                                                    <option value="sudah">sudah</option>
                                                                    <option value="belum" selected>belum</option>
                                                                <?php } else { ?>
                                                                    <option selected disabled value="">-Pilih-</option>
                                                                    <option value="sudah">sudah</option>
                                                                    <option value="belum">belum</option>
                                                                <?php }?>
                                                            </select>
                                                            <span>Pilihan sekarang: 
                                                                <?php if($row->ktp_ada == "" || $row->ktp_ada == "belum"){
                                                                    echo "belum";
                                                                } else {
                                                                    echo "sudah";   
                                                                }?>
                                                            </span>
                                                            </div>

                                                        <div class="form-group">
                                                            <label>KK</label>
                                                            <select class="form-control" name="kk">
                                                                <?php if($row->kk_ada == "sudah"){?>
                                                                    <option value="sudah" selected>sudah</option>
                                                                    <option value="belum">belum</option>
                                                                <?php } else if($row->kk_ada == "belum") { ?>
                                                                    <option value="sudah">sudah</option>
                                                                    <option value="belum" selected>belum</option>
                                                                <?php } else { ?>
                                                                    <option selected disabled value="">-Pilih-</option>
                                                                    <option value="sudah">sudah</option>
                                                                    <option value="belum">belum</option>
                                                                <?php }?>
                                                            </select>
                                                            <span>Pilihan sekarang: 
                                                                <?php if($row->kk_ada == "" || $row->kk_ada == "belum"){
                                                                    echo "belum";
                                                                } else {
                                                                    echo "sudah";   
                                                                }?>
                                                            </span>
                                                            </div>

                                                        <div class="form-group">
                                                            <label>Tgl Terima Berkas</label>
                                                            <input type="date" name="tgl_berkas" class="form-control" value="<?php echo $row->tgl_terima?>">
                                                            </div>
                                                        
                                                        <!-- <input type="submit" class="btn btn-success btn-sm" value="Update"> -->
                                                    </div>
                                                    <div class="col-md-12">
                                                        <?php if(isset($succ_msg)){
                                                            echo "<span style='color: green'>$succ_msg</span><br>";
                                                        }?>
                                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                <!-- /.card -->
                        </div>
            <!-- /.col -->
                    </div>
            <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
  </div>
  <!-- END OF DATA PRIBADI -->

  <!-- NOTARIS -->
  <?php }} else if(isset($notaris_dbm)){
    foreach($notaris_dbm->result() as $row) {?>
        <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Balik Nama - Notaris</h1>
                <!-- <h5>Pembayaran Piutang</h5> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Notaris</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?php echo base_url()?>Dashboard/view_daftar_balik_nama?id=<?php echo $kode;?>" class="btn btn-success btn-sm">Kembali</a>
                                </div>
                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <table>
                                                        <tr>
                                                            <td>Unit</td><td>:</td><td><?php echo $row->no_kavling?></td>
                                                        </tr>
                                                            <?php $jmlh_sertif=0;
                                                            $query = $this->db->get_where('rumah', array('kode_rumah'=>$row->no_kavling, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                                                            foreach($query->result() as $rumah) {?>
                                                                <tr>
                                                                    <td>No SHM</td><td>:</td><td><?php echo $rumah->no_shm?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No PBB</td><td>:</td><td><?php echo $rumah->no_pbb?></td>
                                                                </tr>
                                                            <?php $jmlh_sertif = $jmlh_sertif+1;}?>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    Jumlah sertifikat: <?php echo $jmlh_sertif;?> buah
                                                </div>
                                                <div class="col-md-2">
                                                    <?php if($row->notaris_masukdata != "0000-00-00"){?>
                                                        <a href="<?php echo base_url()?>Dashboard/print_notaris?id=<?php echo $row->id_psjb?>&ids=<?php echo $row->id_notaris?>" class="btn btn-flat btn-sm btn-outline-primary" target="_blank">CETAK</a>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <form action="<?php echo base_url()?>Dashboard/update_notaris_dbm" method="POST" enctype="multipart/form-data">
                                                <div class="col-sm-6">
                                                    <label>Pilih Notaris</label>
                                                    <select name="notaris" class="form-control">
                                                        <option value="" disabled selected>-Pilih-</option>
                                                        <?php foreach($this->db->get('notaris')->result() as $not){
                                                            echo "<option ";
                                                            if($row->id_notaris == $not->id_notaris){
                                                                echo "selected";
                                                            }
                                                            echo " value='$not->id_notaris'>$not->nama_notaris</option>";
                                                        }?>
                                                    </select>
                                                </div> <hr>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                                        <input type="hidden" value="<?php echo $row->psjb?>" name="no_psjb">
                                                        <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">

                                                        <div class="form-group">
                                                            <label>1. Masuk Data</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->notaris_masukdata?>" name="notaris_masukdata">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>2. Keluar AJB</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->notaris_keluarajb?>" name="notaris_keluarajb">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>3. Penyerahan TTD Persetujuan AJB</label>
                                                            <input type="date" value="<?php echo $row->notaris_ttdajb?>" name="notaris_ttdajb" class="form-control">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>4. Proses AJB</label>
                                                            <input type="date"  value="<?php echo $row->notaris_prosesajb?>" name="notaris_prosesajb" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>5. Balik Nama Selesai</label>
                                                            <input type="date" value="<?php echo $row->notaris_ajbselesai?>" name="notaris_ajbselesai" class="form-control">
                                                        </div>
                                                        
                                                        <!-- <input type="submit" class="btn btn-success btn-sm" value="Update"> -->
                                                    </div>
                                                    <div class="col-md-12">
                                                        <?php if(isset($succ_msg)){
                                                            echo "<span style='color: green'>$succ_msg</span><br>";
                                                        }?>
                                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                <!-- /.card -->
                        </div>
            <!-- /.col -->
                    </div>
            <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
  </div>
  
  <?php }} else if(isset($notaris_dbm_unit2)){
    foreach($notaris_dbm_unit2->result() as $row) {?>
        <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Balik Nama - Notaris</h1>
                <!-- <h5>Pembayaran Piutang</h5> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Notaris</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?php echo base_url()?>Dashboard/view_daftar_balik_nama?id=<?php echo $kode;?>" class="btn btn-success btn-sm">Kembali</a>
                                </div>
                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <table>
                                                        <tr>
                                                            <td>Unit</td><td>:</td><td><?php echo $row->kode_rumah?></td>
                                                        </tr>
                                                            <?php $jmlh_sertif=0;
                                                            $query = $this->db->get_where('rumah', array('kode_rumah'=>$row->kode_rumah, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                                                            foreach($query->result() as $rumah) {?>
                                                                <tr>
                                                                    <td>No SHM</td><td>:</td><td><?php echo $rumah->no_shm?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No PBB</td><td>:</td><td><?php echo $rumah->no_pbb?></td>
                                                                </tr>
                                                            <?php $jmlh_sertif = $jmlh_sertif+1;}?>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    Jumlah sertifikat: <?php echo $jmlh_sertif;?> buah
                                                </div>
                                                <div class="col-md-2">
                                                    <?php foreach($this->db->get_where('ppjb', array('psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as  $ts){?>
                                                        <?php if($row->notaris_masukdata != "0000-00-00"){?>
                                                            <a href="<?php echo base_url()?>Dashboard/print_notaris?id=<?php echo $ts->id_psjb?>&ids=<?php echo $ts->id_notaris?>" class="btn btn-flat btn-sm btn-outline-primary" target="_blank">CETAK</a>
                                                        <?php }?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <form action="<?php echo base_url()?>Dashboard/update_notaris_dbm_unit2" method="POST" enctype="multipart/form-data">
                                                <div class="col-sm-6">
                                                    <label>Pilih Notaris</label>
                                                    <select name="notaris" class="form-control">
                                                        <option value="" disabled selected>-Pilih-</option>
                                                        <?php foreach($this->db->get('notaris')->result() as $not){
                                                            echo "<option ";
                                                            if($row->id_notaris == $not->id_notaris){
                                                                echo "selected";
                                                            }
                                                            echo " value='$not->id_notaris'>$not->nama_notaris</option>";
                                                        }?>
                                                    </select>
                                                </div> <hr>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                                        <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_psjb">
                                                        <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">

                                                        <div class="form-group">
                                                            <label>1. Masuk Data</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->notaris_masukdata?>" name="notaris_masukdata">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>2. Keluar AJB</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->notaris_keluarajb?>" name="notaris_keluarajb">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>3. Penyerahan TTD Persetujuan AJB</label>
                                                            <input type="date" value="<?php echo $row->notaris_ttdajb?>" name="notaris_ttdajb" class="form-control">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>4. Proses AJB</label>
                                                            <input type="date"  value="<?php echo $row->notaris_prosesajb?>" name="notaris_prosesajb" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>5. Balik Nama Selesai</label>
                                                            <input type="date" value="<?php echo $row->notaris_ajbselesai?>" name="notaris_ajbselesai" class="form-control">
                                                        </div>
                                                        <!-- <input type="submit" class="btn btn-success btn-sm" value="Update"> -->
                                                    </div>
                                                    <div class="col-md-12">
                                                        <?php if(isset($succ_msg)){
                                                            echo "<span style='color: green'>$succ_msg</span><br>";
                                                        }?>
                                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                <!-- /.card -->
                        </div>
            <!-- /.col -->
                    </div>
            <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
  </div>
  <!-- END OF NOTARIS -->

  <!-- PAJAK -->
  <?php }} else if(isset($pajak_dbm)){
    foreach($pajak_dbm->result() as $row){?>
        <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Balik Nama - Pajak</h1>
                <!-- <h5>Pembayaran Piutang</h5> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Pajak</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?php echo base_url()?>Dashboard/view_daftar_balik_nama?id=<?php echo $kode;?>" class="btn btn-success btn-sm">Kembali</a>
                                </div>
                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <table>
                                                        <tr>
                                                            <td>Unit</td><td>:</td><td><?php echo $row->no_kavling?></td>
                                                        </tr>
                                                            <?php $jmlh_sertif=0;
                                                            $query = $this->db->get_where('rumah', array('kode_rumah'=>$row->no_kavling, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                                                            foreach($query->result() as $rumah) {?>
                                                                <tr>
                                                                    <td>No SHM</td><td>:</td><td><?php echo $rumah->no_shm?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No PBB</td><td>:</td><td><?php echo $rumah->no_pbb?></td>
                                                                </tr>
                                                            <?php $jmlh_sertif = $jmlh_sertif+1;}?>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    Jumlah sertifikat: <?php echo $jmlh_sertif;?> buah
                                                </div>
                                                <div class="col-sm-6" style="text-align: right">
                                                    <!-- <button type="button" class="btn btn-flat btn-sm btn-outline-primary" data-toggle="modal" data-target="#exampleModal">Upload Bukti</button> -->
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <form action="<?php echo base_url()?>Dashboard/update_pajak_dbm" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                                        <input type="hidden" value="<?php echo $row->psjb?>" name="no_psjb">
                                                        <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                                        
                                                        <div class="form-group">
                                                            <label>1. Nilai Validasi</label>
                                                            <input type="number" class="form-control" value="<?php echo $row->nilai_validasi?>" id="nilaiValidasi" name="nilai_validasi">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>2. BPHTB</label>
                                                            <input type="number" class="form-control" value="<?php echo $row->bphtb?>" name="bphtb">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>3. PPh (2,5%)</label>
                                                            <input type="number" class="form-control" value="<?php echo $row->pph?>" name="pph" id="pph">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>4. Kode Billing</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->kode_billing?>" name="kode_billing">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>5. Masa Aktif Kode Billing</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->masa_aktif_kode_billing?>" name="masa_aktif_kode_billing">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>6. Masa Pajak</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->masa_pajak?>" name="masa_pajak">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>7. Tgl Bayar</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->tgl_bayar_pajak?>" name="tgl_bayar_pajak">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>8. Bank</label>
                                                            <select class="form-control" name="bank_pajak">
                                                                <option value="" disabled selected>-Pilih-</option>
                                                                <?php foreach($this->db->get('bank')->result() as $row2){
                                                                    echo "<option ";
                                                                    if($row->id_bank_pajak == $row2->id_bank){
                                                                        echo "selected";
                                                                    }
                                                                    echo " value='$row2->id_bank'>$row2->nama_bank</option>";
                                                                }?>
                                                                <!-- <option value="<?php echo $row2->id_bank?>"><?php echo $row2->id_bank.". ".$row2->nama_bank?></option> -->
                                                            </select>
                                                            <?php foreach($this->db->get_where('bank', array('id_bank'=>$row->id_bank_pajak))->result() as $row1){?>
                                                                <span>Pilihan sekarang: <?php echo $row1->nama_bank?></span>
                                                            <?php }?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>9. NTPN</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->ntpn?>" name="ntpn">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>10. Keterangan</label>
                                                            <textarea class="form-control" value="" name="ket_pajak"><?php echo $row->ket_pajak?></textarea>
                                                        </div>
                                                        
                                                        <!-- <input type="submit" class="btn btn-success btn-sm" value="Update"> -->
                                                    </div>
                                                    <div class="col-md-12">
                                                        <?php if(isset($succ_msg)){
                                                            echo "<span style='color: green'>$succ_msg</span><br>";
                                                        }?>
                                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                <!-- /.card -->
                        </div>
            <!-- /.col -->
                    </div>
            <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
  </div>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tanda Terima Online Signature</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="<?php echo base_url()?>Dashboard/upload_foto_pajak" class="dropzone" id="fileupload">
        </div>
        <div class="modal-footer">
            <input type="hidden" name="id" value="<?php echo $row->id_psjb?>">
            <input type="hidden" name="kode" value="<?php echo $row->kode_perumahan?>">
            <!-- <input type="hidden" name="id" value="<?php echo $id?>">
            <input type="hidden" name="bln" value="<?php echo $tgl?>"> -->

            <input type="submit" class="btn btn-success" value="Submit">
            </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
  </div>    

  <?php }} else if(isset($pajak_dbm_unit2)){
    foreach($pajak_dbm_unit2->result() as $row){?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Daftar Balik Nama - Pajak</h1>
                    <!-- <h5>Pembayaran Piutang</h5> -->
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                        <li class="breadcrumb-item active">Pajak</li>
                    </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?php echo base_url()?>Dashboard/view_daftar_balik_nama?id=<?php echo $kode;?>" class="btn btn-success btn-sm">Kembali</a>
                                </div>
                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <table>
                                                        <tr>
                                                            <td>Unit</td><td>:</td><td><?php echo $row->kode_rumah?></td>
                                                        </tr>
                                                            <?php $jmlh_sertif=0;
                                                            $query = $this->db->get_where('rumah', array('kode_rumah'=>$row->kode_rumah, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                                                            foreach($query->result() as $rumah) {?>
                                                                <tr>
                                                                    <td>No SHM</td><td>:</td><td><?php echo $rumah->no_shm?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No PBB</td><td>:</td><td><?php echo $rumah->no_pbb?></td>
                                                                </tr>
                                                            <?php $jmlh_sertif = $jmlh_sertif+1;}?>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            Jumlah sertifikat: <?php echo $jmlh_sertif;?> buah
                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <form action="<?php echo base_url()?>Dashboard/update_pajak_dbm_unit2" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                                        <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_psjb">
                                                        <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                                        
                                                        <div class="form-group">
                                                            <label>1. Nilai Validasi</label>
                                                            <input type="number" class="form-control" value="<?php echo $row->nilai_validasi?>" id="nilaiValidasi" name="nilai_validasi">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>2. BPHTB</label>
                                                            <input type="number" class="form-control" value="<?php echo $row->bphtb?>" name="bphtb">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>3. PPh (2,5%)</label>
                                                            <input type="number" class="form-control" value="<?php echo $row->pph?>" name="pph" id="pph">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>4. Kode Billing</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->kode_billing?>" name="kode_billing">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>5. Masa Aktif Kode Billing</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->masa_aktif_kode_billing?>" name="masa_aktif_kode_billing">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>6. Masa Pajak</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->masa_pajak?>" name="masa_pajak">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>7. Tgl Bayar</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->tgl_bayar_pajak?>" name="tgl_bayar_pajak">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>8. Bank</label>
                                                            <select class="form-control" name="bank_pajak">
                                                                <option value="" disabled selected>-Pilih-</option>
                                                                <?php foreach($this->db->get('bank')->result() as $row2){
                                                                    echo "<option ";
                                                                    if($row->id_bank_pajak == $row2->id_bank){
                                                                        echo "selected";
                                                                    }
                                                                    echo " value='$row2->id_bank'>$row2->nama_bank</option>";
                                                                }?>
                                                                <!-- <option value="<?php echo $row2->id_bank?>"><?php echo $row2->id_bank.". ".$row2->nama_bank?></option> -->
                                                            </select>
                                                            <?php foreach($this->db->get_where('bank', array('id_bank'=>$row->id_bank_pajak))->result() as $row1){?>
                                                                <span>Pilihan sekarang: <?php echo $row1->nama_bank?></span>
                                                            <?php }?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>9. NTPN</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->ntpn?>" name="ntpn">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>10. Keterangan</label>
                                                            <textarea class="form-control" value="" name="ket_pajak"><?php echo $row->ket_pajak?></textarea>
                                                        </div>
                                                        
                                                        <!-- <input type="submit" class="btn btn-success btn-sm" value="Update"> -->
                                                    </div>
                                                    <div class="col-md-12">
                                                        <?php if(isset($succ_msg)){
                                                            echo "<span style='color: green'>$succ_msg</span><br>";
                                                        }?>
                                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                <!-- /.card -->
                        </div>
            <!-- /.col -->
                    </div>
            <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
  </div>
  <!-- END OF PAJAK -->

  <!-- SERTIFIKAT -->
  <?php }} else if(isset($sertifikat_dbm)){
    foreach($sertifikat_dbm->result() as $row){?>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Daftar Balik Nama - Sertifikat</h1>
                    <!-- <h5>Pembayaran Piutang</h5> -->
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                        <li class="breadcrumb-item active">Sertifikat</li>
                    </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?php echo base_url()?>Dashboard/view_daftar_balik_nama?id=<?php echo $kode;?>" class="btn btn-success btn-sm">Kembali</a>
                                </div>
                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <table>
                                                        <tr>
                                                            <td>Unit</td><td>:</td><td><?php echo $row->no_kavling?></td>
                                                        </tr>
                                                            <?php $jmlh_sertif=0;
                                                            $query = $this->db->get_where('rumah', array('kode_rumah'=>$row->no_kavling, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                                                            foreach($query->result() as $rumah) {?>
                                                                <tr>
                                                                    <td>No SHM</td><td>:</td><td><?php echo $rumah->no_shm?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No PBB</td><td>:</td><td><?php echo $rumah->no_pbb?></td>
                                                                </tr>
                                                            <?php $jmlh_sertif = $jmlh_sertif+1;}?>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            Jumlah sertifikat: <?php echo $jmlh_sertif;?> buah
                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <form action="<?php echo base_url()?>Dashboard/update_sertifikat_dbm" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <?php if($row->jenis_kota == "luarkota"){?>
                                                            <div class="form-group">
                                                                <label>Jenis Serah</label>
                                                                <select id="colorselector" class="form-control" name="jenis_kota">
                                                                    <!-- <option value="" disabled selected>-Pilih-</option> -->
                                                                    <option value="luarkota" selected>Luar Kota</option>
                                                                    <option value="dalamkota">Dalam Kota</option>
                                                                </select>
                                                            </div>
                                                        <?php } else if($row->jenis_kota == "dalamkota"){?>
                                                            <div class="form-group">
                                                                <label>Jenis Serah</label>
                                                                <select id="colorselector" class="form-control" name="jenis_kota">
                                                                    <!-- <option value="" disabled selected>-Pilih-</option> -->
                                                                    <option value="luarkota">Luar Kota</option>
                                                                    <option value="dalamkota" selected>Dalam Kota</option>
                                                                </select>
                                                            </div>
                                                        <?php } else {?>
                                                            <div class="form-group">
                                                                <label>Jenis Serah</label>
                                                                <select id="colorselector" class="form-control" name="jenis_kota">
                                                                    <option value="" disabled selected>-Pilih-</option>
                                                                    <option value="luarkota">Luar Kota</option>
                                                                    <option value="dalamkota">Dalam Kota</option>
                                                                </select>
                                                            </div>
                                                        <?php }?>
                                                    </div>

                                                    <div id="curator" class="col-md-4">
                                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                                        <input type="hidden" value="<?php echo $row->psjb?>" name="no_psjb">
                                                        <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                                        
                                                        <?php 
                                                        // if($row->jenis_kota == "luarkota") {?>
                                                            <!-- <div class="form-group">
                                                                <label>Tgl Kirim Sertif & Tanda Terima</label>
                                                                <input type="date" class="form-control" value="<?php echo $row->tgl_kirim_ttdterima?>" id="tgl_kirim_sertif" name="tgl_kirim_sertif">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tgl Terima Tanda Terima</label>
                                                                <input type="date" class="form-control" value="<?php echo $row->tgl_terima_ttdterima?>" id="tgl_kirim_sertif" name="tgl_terima_ttd">
                                                            </div> -->
                                                        <?php 
                                                        // } else if($row->jenis_kota == "dalamkota") {?>
                                                            <!-- <div class="form-group">
                                                                <label>Tgl Kirim Sertif & Tanda Terima</label>
                                                                <input type="date" readonly class="form-control" value="<?php echo $row->tgl_kirim_ttdterima?>" id="tgl_kirim_sertif" name="tgl_kirim_sertif">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tgl Terima Tanda Terima</label>
                                                                <input type="date" readonly class="form-control" value="<?php echo $row->tgl_terima_ttdterima?>" id="tgl_kirim_sertif" name="tgl_terima_ttd">
                                                            </div> -->
                                                        <?php 
                                                        // }?>
                                                        
                                                        <div class="form-group">
                                                            <label>Tgl Kirim Sertif & Tanda Terima</label>
                                                            <input type="date" <?php if($row->jenis_kota == "dalamkota") { echo "readonly"; }?> class="form-control" value="<?php echo $row->tgl_kirim_ttdterima?>" id="tgl_kirim_sertif" name="tgl_kirim_sertif">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tgl Terima Tanda Terima</label>
                                                            <input type="date" <?php if($row->jenis_kota == "dalamkota") { echo "readonly"; }?> class="form-control" value="<?php echo $row->tgl_terima_ttdterima?>" id="tgl_kirim_sertif" name="tgl_terima_ttd">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tgl Diterima</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->tgl_terima_sertif?>" id="tgl_terima_sertif" name="tgl_terima_sertif">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Di terima oleh</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->terima_oleh_sertif?>" id="terima_oleh_sertif" name="terima_oleh_sertif">
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- <div id="dalamkota" class="colors col-md-8" style="display: none">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="hidden" value="<?php echo $id?>" name="id">
                                                                <input type="hidden" value="<?php echo $row->psjb?>" name="no_psjb">
                                                                <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                                                
                                                                <div class="form-group">
                                                                    <label>Tgl Terima</label>
                                                                    <input type="date" class="form-control" value="<?php echo $row->tgl_terima_sertif?>" id="" name="tgl_terima_sertif">
                                                                    <input type="hidden" value="<?php echo date("Y-m-d")?>" name="tgl_kirim_sertif">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Di terima oleh</label>
                                                                    <input type="text" class="form-control" value="<?php echo $row->terima_oleh_sertif?>" name="terima_oleh_sertif">
                                                                    <input type="hidden" value="<?php echo date("Y-m-d")?>" name="tgl terima_ttd">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="luarkota" class="colors col-md-8" style="display: none">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="hidden" value="<?php echo $id?>" name="id">
                                                                <input type="hidden" value="<?php echo $row->psjb?>" name="no_psjb">
                                                                <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                                                
                                                                <div class="form-group">
                                                                    <label>Tgl Kirim Sertif & Tanda Terima</label>
                                                                    <input type="date" class="form-control" value="<?php echo $row->tgl_kirim_ttdterima?>" id="" name="tgl_kirim_sertif">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Tgl Terima Tanda Terima</label>
                                                                    <input type="date" class="form-control" value="<?php echo $row->tgl_terima_ttdterima?>" id="" name="tgl_terima_ttd">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Tgl Diterima</label>
                                                                    <input type="date" class="form-control" value="<?php echo $row->tgl_terima_sertif?>" name="tgl_terima_sertif">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Di terima oleh</label>
                                                                    <input type="text" class="form-control" value="<?php echo $row->terima_oleh_sertif?>" name="terima_oleh_sertif">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-12">
                                                        <?php if(isset($succ_msg)){
                                                            echo "<span style='color: green'>$succ_msg</span><br>";
                                                        }?>
                                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                <!-- /.card -->
                        </div>
            <!-- /.col -->
                    </div>
            <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
  </div>

  <?php }} else if(isset($sertifikat_dbm_unit2)){
    foreach($sertifikat_dbm_unit2->result() as $row){?>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Daftar Balik Nama - Sertifikat</h1>
                    <!-- <h5>Pembayaran Piutang</h5> -->
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                        <li class="breadcrumb-item active">Sertifikat</li>
                    </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?php echo base_url()?>Dashboard/view_daftar_balik_nama?id=<?php echo $kode;?>" class="btn btn-success btn-sm">Kembali</a>
                                </div>
                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <table>
                                                        <tr>
                                                            <td>Unit</td><td>:</td><td><?php echo $row->kode_rumah?></td>
                                                        </tr>
                                                            <?php $jmlh_sertif=0;
                                                            $query = $this->db->get_where('rumah', array('kode_rumah'=>$row->kode_rumah, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                                                            foreach($query->result() as $rumah) {?>
                                                                <tr>
                                                                    <td>No SHM</td><td>:</td><td><?php echo $rumah->no_shm?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No PBB</td><td>:</td><td><?php echo $rumah->no_pbb?></td>
                                                                </tr>
                                                            <?php $jmlh_sertif = $jmlh_sertif+1;}?>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            Jumlah sertifikat: <?php echo $jmlh_sertif;?> buah
                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <form action="<?php echo base_url()?>Dashboard/update_sertifikat_dbm_unit2" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <?php if($row->jenis_kota == "luarkota"){?>
                                                            <div class="form-group">
                                                                <label>Jenis Serah</label>
                                                                <select id="colorselector" class="form-control" name="jenis_kota">
                                                                    <!-- <option value="" disabled selected>-Pilih-</option> -->
                                                                    <option value="luarkota" selected>Luar Kota</option>
                                                                    <option value="dalamkota">Dalam Kota</option>
                                                                </select>
                                                            </div>
                                                        <?php } else if($row->jenis_kota == "dalamkota"){?>
                                                            <div class="form-group">
                                                                <label>Jenis Serah</label>
                                                                <select id="colorselector" class="form-control" name="jenis_kota">
                                                                    <!-- <option value="" disabled selected>-Pilih-</option> -->
                                                                    <option value="luarkota">Luar Kota</option>
                                                                    <option value="dalamkota" selected>Dalam Kota</option>
                                                                </select>
                                                            </div>
                                                        <?php } else {?>
                                                            <div class="form-group">
                                                                <label>Jenis Serah</label>
                                                                <select id="colorselector" class="form-control" name="jenis_kota">
                                                                    <option value="" disabled selected>-Pilih-</option>
                                                                    <option value="luarkota">Luar Kota</option>
                                                                    <option value="dalamkota">Dalam Kota</option>
                                                                </select>
                                                            </div>
                                                        <?php }?>
                                                    </div>

                                                    <div id="curator" class="col-md-4">
                                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                                        <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_psjb">
                                                        <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                                        
                                                        <?php if($row->jenis_kota == "luarkota") {?>
                                                            <div class="form-group">
                                                                <label>Tgl Kirim Sertif & Tanda Terima</label>
                                                                <input type="date" class="form-control" value="<?php echo $row->tgl_kirim_ttdterima?>" id="tgl_kirim_sertif" name="tgl_kirim_sertif">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tgl Terima Tanda Terima</label>
                                                                <input type="date" class="form-control" value="<?php echo $row->tgl_terima_ttdterima?>" id="tgl_kirim_sertif" name="tgl_terima_ttd">
                                                            </div>
                                                        <?php } else if($row->jenis_kota == "dalamkota") {?>
                                                            <div class="form-group">
                                                                <label>Tgl Kirim Sertif & Tanda Terima</label>
                                                                <input type="date" readonly class="form-control" value="<?php echo $row->tgl_kirim_ttdterima?>" id="tgl_kirim_sertif" name="tgl_kirim_sertif">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tgl Terima Tanda Terima</label>
                                                                <input type="date" readonly class="form-control" value="<?php echo $row->tgl_terima_ttdterima?>" id="tgl_kirim_sertif" name="tgl_terima_ttd">
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tgl Diterima</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->tgl_terima_sertif?>" id="tgl_terima_sertif" name="tgl_terima_sertif">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Di terima oleh</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->terima_oleh_sertif?>" id="terima_oleh_sertif" name="terima_oleh_sertif">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                <!-- /.card -->
                        </div>
            <!-- /.col -->
                    </div>
            <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
  </div>
  <!-- END OF SERTIFIKAT -->
  <?php }} else if(isset($imb_dbm)){
    foreach($imb_dbm->result() as $row){?>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Daftar Balik Nama - IMB</h1>
                    <!-- <h5>Pembayaran Piutang</h5> -->
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                        <li class="breadcrumb-item active">IMB</li>
                    </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?php echo base_url()?>Dashboard/view_daftar_balik_nama?id=<?php echo $kode;?>" class="btn btn-success btn-sm">Kembali</a>
                                </div>
                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <table>
                                                        <tr>
                                                            <td>Unit</td><td>:</td><td><?php echo $row->no_kavling?></td>
                                                        </tr>
                                                            <?php $jmlh_sertif=0;
                                                            $query = $this->db->get_where('rumah', array('kode_rumah'=>$row->no_kavling, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                                                            foreach($query->result() as $rumah) {?>
                                                                <tr>
                                                                    <td>No SHM</td><td>:</td><td><?php echo $rumah->no_shm?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No PBB</td><td>:</td><td><?php echo $rumah->no_pbb?></td>
                                                                </tr>
                                                            <?php $jmlh_sertif = $jmlh_sertif+1;}?>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            Jumlah sertifikat: <?php echo $jmlh_sertif;?> buah
                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <form action="<?php echo base_url()?>Dashboard/update_imb_dbm" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div id="curator" class="col-md-6">
                                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                                        <input type="hidden" value="<?php echo $row->psjb?>" name="no_psjb">
                                                        <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                                        
                                                        <div class="form-group">
                                                            <label>Tgl Diterima</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->tgl_terima_sertif?>" id="tgl_terima_sertif" name="tgl_terima_sertif">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Di terima oleh</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->terima_oleh_sertif?>" id="terima_oleh_sertif" name="terima_oleh_sertif">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                <!-- /.card -->
                        </div>
            <!-- /.col -->
                    </div>
            <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
  </div>

  <?php }} else if(isset($imb_dbm_unit2)){
    foreach($imb_dbm_unit2->result() as $row){?>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Daftar Balik Nama - IMB</h1>
                    <!-- <h5>Pembayaran Piutang</h5> -->
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                        <li class="breadcrumb-item active">IMB</li>
                    </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?php echo base_url()?>Dashboard/view_daftar_balik_nama?id=<?php echo $kode;?>" class="btn btn-success btn-sm">Kembali</a>
                                </div>
                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <table>
                                                        <tr>
                                                            <td>Unit</td><td>:</td><td><?php echo $row->kode_rumah?></td>
                                                        </tr>
                                                            <?php $jmlh_sertif=0;
                                                            $query = $this->db->get_where('rumah', array('kode_rumah'=>$row->kode_rumah, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                                                            foreach($query->result() as $rumah) {?>
                                                                <tr>
                                                                    <td>No SHM</td><td>:</td><td><?php echo $rumah->no_shm?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No PBB</td><td>:</td><td><?php echo $rumah->no_pbb?></td>
                                                                </tr>
                                                            <?php $jmlh_sertif = $jmlh_sertif+1;}?>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            Jumlah sertifikat: <?php echo $jmlh_sertif;?> buah
                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <form action="<?php echo base_url()?>Dashboard/update_imb_dbm_unit2" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div id="curator" class="col-md-6">
                                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                                        <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_psjb">
                                                        <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                                        
                                                        <div class="form-group">
                                                            <label>Tgl Diterima</label>
                                                            <input type="date" class="form-control" value="<?php echo $row->tgl_terima_sertif?>" id="tgl_terima_sertif" name="tgl_terima_sertif">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Di terima oleh</label>
                                                            <input type="text" class="form-control" value="<?php echo $row->terima_oleh_sertif?>" id="terima_oleh_sertif" name="terima_oleh_sertif">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                <!-- /.card -->
                        </div>
            <!-- /.col -->
                    </div>
            <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
  </div>
  <?php }}?>

  <!-- Main Footer -->
  
  <?php include "include/footer.php"?>
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()?>asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.js"></script>

<script src="<?php echo base_url()?>assets/dropzone-5.7.0/dist/dropzone.js"></script>

<script>
    // Add restrictions
    Dropzone.options.fileupload = {
      acceptedFiles: 'image/*',
    //   maxFilesize: 1 // MB
    };
</script>
<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

<script type="text/javascript">

var nilaiValidasi = document.getElementById('nilaiValidasi');
var pph = document.getElementById('pph');

// nilaiValidasi.addEventListener('change', function() {
//   pph.value = (nilaiValidasi.value * 25)/1000;
// });
$('#nilaiValidasi').on("input", function(){
    $('#pph').val(($(this).val() * 25) / 1000);
})

persenPencairan.addEventListener('change', function () {
  danaBayar.value = (totalPencairan.value * persenPencairan.value) / 100;
  danaKurang.value = danaKekurangan.value - danaBayar.value;
});
</script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url()?>asset/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo base_url()?>asset/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS --> 
<script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
<script>
// $(function() {    
    // Makes sure the code contained doesn't run until
                  //     all the DOM elements have loaded

// $('#colorselector').change(function(){
//     $('.colors').hide();
//     $('#' + $(this).val()).show();
// });

// });
</script>
<script src="<?php echo base_url()?>asset/plugins/chart.js/Chart.min.js"></script>
<script>
$(document).ready(function(){

$('#colorselector').change(function(){

  var value = $(this).val();

  if(value == ''){
    // NONE
    $('#curator input[type="text"]').removeAttr('readonly');
    $('#curator input[type="date"]').removeAttr('readonly');
  }
  else if(value == 'dalamkota'){
    // CURRENT
    $('#curator input[type="text"]').attr('readonly', true);
    $('#curator input[type="date"]').attr('readonly', true);
    $('#curator .current').removeAttr('readonly');
  }
  else if(value == 'luarkota'){
    // FUTURE
    // $('#curator input[type="text"]').attr('readonly', true);
    $('#curator input[type="text"]').removeAttr('readonly');
    $('#curator input[type="date"]').removeAttr('readonly');
  }

});

});
</script>

<!-- PAGE SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/pages/dashboard2.js"></script>
</body>
</html>
