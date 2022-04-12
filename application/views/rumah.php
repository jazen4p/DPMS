<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | General Form Elements</title>
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
            <h1>Data Rumah</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Rumah</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php if(isset($edit_rumah)) {
        foreach($edit_rumah as $row2){?>
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="<?php echo base_url()?>Dashboard/edit_rumah" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 style="background-color: lightblue; padding-left: 20px; padding-top: 10px; padding-bottom: 10px">Proyek Kavling</h5>
                                <!-- <div class="form-group">
                                    <label for="exampleInputEmail1">Kota</label>
                                    <select class="form-control" name="kota" required>
                                        <?php foreach($this->db->get('perusahaan')->result() as $row){ ?>
                                            <option value="<?php echo $row->nama_kota?>"><?php echo $row->nama_kota?></option>
                                        <?php }?>
                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Perusahaan</label>
                                    <select class="form-control" name="nama_perusahaan" required>
                                        <?php foreach($this->db->get('perusahaan')->result() as $row3){
                                            echo "<option ";
                                            if($row2->kode_perusahaan == $row3->nama_perusahaan){
                                                echo "selected";
                                            }
                                            echo ">$row3->nama_perusahaan</option>";
                                        }?>
                                    </select>
                                    <span>Pilihan: <?php echo $row2->kode_perusahaan?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Perumahan</label>
                                    <select class="form-control" name="nama_perumahan" required>
                                        <?php foreach($this->db->get('perumahan')->result() as $row4){
                                            echo "<option ";
                                            if($row2->kode_perumahan == $row4->kode_perumahan){
                                                echo "selected";
                                            }
                                            echo ">$row4->nama_perumahan</option>";
                                        }?>
                                    </select>
                                    <span>Pilihan: <?php echo $row2->nama_perumahan?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Kavling</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Kavling" name="kode_rumah" value="<?php echo $row2->kode_rumah?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tipe Produk</label>
                                    <select class="form-control" id="tipe_produk" placeholder="" name="tipe_produk" required>
                                        <?php if($row2->tipe_produk == "rumah"){?>
                                            <option value="rumah" selected>Rumah</option>
                                            <option value="kavling">Kavling</option> 
                                        <?php } else{?>
                                            <option value="rumah">Rumah</option>
                                            <option value="kavling" selected>Kavling</option> 
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 style="background-color: lightblue; padding-left: 20px; padding-top: 10px; padding-bottom: 10px">Detail Kavling/ Rumah</h5>
                                <div id="curator">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Tipe Rumah</label>
                                        <?php if($row2->tipe_produk == "rumah"){?>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Tipe Rumah" name="tipe_rumah" value="<?php echo $row2->tipe_rumah?>">
                                        <?php } else {?>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Tipe Rumah" name="tipe_rumah" value="<?php echo $row2->tipe_rumah?>" readonly>
                                        <?php }?>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Luas Bangunan</label>
                                        <?php if($row2->tipe_produk == "rumah"){?>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Luas Bangunan" name="luas_bangunan" value="<?php echo $row2->luas_bangunan?>">
                                        <?php } else {?>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Luas Bangunan" name="luas_bangunan" value="<?php echo $row2->luas_bangunan?>" readonly>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Luas Tanah</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Luas Tanah" name="luas_tanah" value="<?php echo $row2->luas_tanah?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Harga Jual</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Harga Jual" name="harga_jual" value="<?php echo $row2->harga_jual?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="keterangan" placeholder="Keterangan, misal: free hook, free hadap timur, dll"><?php echo $row2->keterangan?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select class="form-control" name="status">
                                        <?php if($row2->status=="psjb" || $row2->status=="ppjb"){
                                            echo "<option value='$row2->status' selected>$row2->status</option>";    
                                        }?>
                                        <option value="free">Free</option>
                                        <option value="dipesan">Dipesan</option>
                                    </select>
                                    <input type="hidden" name="id_rumah" value="<?php echo $row2->id_rumah?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No SHM</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="No SHM" name="no_shm" value="<?php echo $row2->no_shm?>">
                                </div>
                                <div class="form-group" id="curator">
                                    <label for="exampleInputEmail1">No PBB</label>
                                    <?php if($row2->tipe_produk == "rumah"){?>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="No PBB" name="no_pbb" value="<?php echo $row2->no_pbb?>">
                                    <?php } else {?>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="No PBB" name="no_pbb" value="<?php echo $row2->no_pbb?>" readonly>
                                    <?php }?>
                                </div>
                                <div class="form-group">
                                    <label for="budgetBahan">Budget Awal Bahan</label>
                                    <input type="number" class="form-control" id="budgetBahan" value="<?php echo $row2->budget_bahan?>" placeholder="Budget Bahan" name="budget_bahan">
                                </div>
                                <div class="form-group" id="curator">
                                    <label for="budgetUpah">Budget Awal Upah</label>
                                    <input type="number" class="form-control" id="budgetUpah" value="<?php echo $row2->budget_upah?>" placeholder="Budget Upah" name="budget_upah">
                                </div>
                                <div class="form-group">
                                    <label for="namaPemilik">Nama Pemilik Rumah</label>
                                    <input type="text" class="form-control" id="namaPemilik" placeholder="Nama Pemilik Rumah" value="<?php echo $row2->nama_pemilik?>" name="nama_pemilik">
                                </div>
                                <div class="form-group">
                                    <label for="hpPemilik">No HP Pemilik Rumah</label>
                                    <input type="number" class="form-control" id="hpPemilik" placeholder="No. HP Pemilik Rumah" value="<?php echo $row2->hp_pemilik?>" name="hp_pemilik">
                                </div>
                                <div class="form-group">
                                    <label for="tinggalTidak">Status Tinggal</label>
                                    <select class="form-control" name="status_tinggal" id="tinggalTidak" required>
                                        <option value="" disabled selected>-Pilih-</option>
                                        <option value="tinggal" <?php if($row2->status_tinggal == "tinggal"){echo "selected";}?>>Tinggal</option>
                                        <option value="belum tinggal" <?php if($row2->status_tinggal == "belum tinggal"){echo "selected";}?>>Belum Tinggal</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputFile">Gambar Logo Perusahaan</label>
                                    <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                    </div>
                                </div>
                            </div> -->
                        <!-- </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div> -->
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <?php if(isset($succ_msg)){?>
                            <span style="color: green"><?php echo $succ_msg;?></span> <br/>
                        <?php }?>
                        <?php if(isset($err_msg)){?>
                            <span style="color: red"><?php echo $err_msg;?></span> <br/>
                        <?php }?>
                        <input type="submit" class="btn btn-primary" value="Update" />
                        <a href="<?php echo base_url()?>Dashboard/rumah_management" class="btn btn-primary">Tambah Baru</a>
                    </div>
                </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
    <?php }} else {?>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="<?php echo base_url()?>Dashboard/add_rumah" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 style="background-color: lightblue; padding-left: 20px; padding-top: 10px; padding-bottom: 10px">Proyek Kavling</h5>
                                    <!-- <div class="form-group">
                                        <label for="exampleInputEmail1">Kota</label>
                                        <select class="form-control" name="kota" required>
                                            <?php foreach($this->db->get('perusahaan')->result() as $row){ ?>
                                                <option value="<?php echo $row->nama_kota?>"><?php echo $row->nama_kota?></option>
                                            <?php }?>
                                        </select>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Nama Perusahaan</label>
                                        <select class="form-control category" name="nama_perusahaan" required>
                                            <option value="" disabled selected>-Pilih-</option>
                                            <?php foreach($this->db->get('perusahaan')->result() as $row){ ?>
                                                <option value="<?php echo $row->kode_perusahaan?>"><?php echo $row->nama_perusahaan?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Nama Perumahan</label>
                                        <select class="form-control" id="response" name="nama_perumahan" required>
                                            <option value="" disabled selected>-Pilih-</option>
                                            <?php 
                                                // foreach($this->db->get('perumahan')->result() as $row){
                                                // if($row->tipe_perusahaan == "perumahan"){
                                            ?>
                                                <!-- <option value="<?php echo $row->nama_perumahan?>"><?php echo $row->nama_perumahan?></option> -->
                                            <?php 
                                                // }}
                                            ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Blok (A, B, etc.)</label>
                                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Blok" name="kode_rumah" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Jumlah Unit</label>
                                                <input type="number" class="form-control" id="exampleInputPassword1" placeholder="NaN" name="jumlah_rumah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="exampleInputPassword1">No Unit</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="No Unit" name="no_unit" required>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Tipe Produk</label>
                                        <select class="form-control" id="tipe_produk" placeholder="" name="tipe_produk" required>
                                            <option value="rumah">Rumah</option>
                                            <option value="kavling">Kavling</option> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 style="background-color: lightblue; padding-left: 20px; padding-top: 10px; padding-bottom: 10px">Detail Kavling/Rumah</h5>
                                    <div id="curator">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Tipe Rumah</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Tipe Rumah" name="tipe_rumah">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Luas Bangunan</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Luas Bangunan" name="luas_bangunan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Luas Tanah</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Luas Tanah" name="luas_tanah">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Harga Jual</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Harga Jual" name="harga_jual">
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea class="form-control" name="keterangan" placeholder="Keterangan, misal: free hook, free hadap timur, dll"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="free">Free</option>
                                            <option value="dipesan">Dipesan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">No SHM</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="No SHM" name="no_shm">
                                    </div>
                                    <div class="form-group" id="curator">
                                        <label for="exampleInputEmail1">No PBB</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="No PBB" name="no_pbb">
                                    </div>
                                    <div class="form-group">
                                        <label for="budgetBahan">Budget Awal Bahan</label>
                                        <input type="number" class="form-control" id="budgetBahan" placeholder="Budget Bahan" name="budget_bahan">
                                    </div>
                                    <div class="form-group" id="curator">
                                        <label for="budgetUpah">Budget Awal Upah</label>
                                        <input type="number" class="form-control" id="budgetUpah" placeholder="Budget Upah" name="budget_upah">
                                    </div>
                                    <div class="form-group">
                                        <label for="namaPemilik">Nama Pemilik Rumah</label>
                                        <input type="text" class="form-control" id="namaPemilik" placeholder="Nama Pemilik Rumah" name="nama_pemilik">
                                    </div>
                                    <div class="form-group">
                                        <label for="hpPemilik">No HP Pemilik Rumah</label>
                                        <input type="number" class="form-control" id="hpPemilik" placeholder="No. HP Pemilik Rumah" name="hp_pemilik">
                                    </div>
                                    <div class="form-group">
                                        <label for="tinggalTidak">Status Tinggal</label>
                                        <select class="form-control" name="status_tinggal" id="tinggalTidak" required>
                                            <option value="" disabled selected>-Pilih-</option>
                                            <option value="tinggal">Tinggal</option>
                                            <option value="belum tinggal">Belum Tinggal</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Gambar Logo Perusahaan</label>
                                        <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">Upload</span>
                                        </div>
                                        </div>
                                    </div>
                                </div> -->
                            <!-- </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div> -->
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <?php if(isset($succ_msg)){?>
                                <span style="color: green"><?php echo $succ_msg;?></span> <br/>
                            <?php }?>
                            <?php if(isset($err_msg)){?>
                                <span style="color: red"><?php echo $err_msg;?></span> <br/>
                            <?php }?>
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <a href="<?php echo base_url()?>Dashboard/rumah_management" class="btn btn-primary">Tambah Baru</a>
                        </div>
                    </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    <?php }?>
    <!-- /.content -->
    </div>
  </div>

  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Rumah Management</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div style="text-align: center">
                    <form action="<?php echo base_url()?>Dashboard/filter_rumah_management" method="POST">
                    Perumahan:
                    <select name="perumahan">
                        <option value="">Semua</option>
                        <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                            <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                        <?php }?>
                    </select>
                    <input type="submit" class="btn btn-default btn-sm" value="OK">
                    <?php if(isset($kode)){?>
                    <br>
                    <span>Pilihan saat ini: <?php if($kode==""){echo "Semua";} else {echo $kode;}?></span>
                    <?php }?>
                    </form>
                </div>
                <form action="<?php echo base_url()?>Dashboard/edit_rumah_all" method="POST">
                    <table id="example2" class="table table-bordered table-striped" style="font-size: 14px; white-space: nowrap">
                    <thead>
                        <tr>
                            <th colspan=15 style="text-align: center">
                                <input type="submit" class="btn btn-info btn-sm" value="Edit" style="width: 100%">
                            </th>
                        </tr>
                        <tr>
                            <th>Nama Perumahan</th>
                            <th>No Kavling</th>
                            <!-- <th>No Unit</th> -->
                            <th>Tipe Rumah</th>
                            <th>Luas Tanah</th>
                            <th>Luas Bangunan</th>
                            <th>Harga Jual</th>
                            <th>Status</th>
                            <th>Tipe Produk</th>
                            <th>Keterangan</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Budget Bahan</th>
                            <th>Budget Upah</th>
                            <th>Nama Pemilik</th>
                            <th>HP Pemilik</th>
                            <th>Status Tinggal</th>
                            <th>Dibuat oleh</th>
                            <th>Pada</th>
                            <th>Revisi oleh</th>
                            <th>Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($check_all->result() as $row){?>
                        <tr>
                        <td><?php echo $row->nama_perumahan?></td>
                        <td>
                            <?php echo $row->kode_rumah?>
                            <?php if($row->status == "free"){?>
                                <input type="text" value="<?php echo $row->kode_rumah?>" name="kode_rumah[]">
                            <?php } else {?>
                                <input type="hidden" value="<?php echo $row->kode_rumah?>" name="kode_rumah[]">
                            <?php }?>
                        </td>
                        <!-- <td><?php echo $row->no_unit?></td> -->
                        <td>
                            <?php echo $row->tipe_rumah?>
                            <?php if($row->status == "free"){?>
                                <input type="number" value="<?php echo $row->tipe_rumah?>" name="tipe_rumah[]">

                                <input type="hidden" value="<?php echo $row->id_rumah?>" name="id_rumah[]">
                            <?php } else {?>
                                <input type="hidden" value="<?php echo $row->tipe_rumah?>" name="tipe_rumah[]">

                                <input type="hidden" value="<?php echo $row->id_rumah?>" name="id_rumah[]">
                            <?php }?>
                        </td>
                        <td>
                            <?php echo $row->luas_tanah?>
                            <?php if($row->status == "free"){?>
                                <input type="number" value="<?php echo $row->luas_tanah?>" name="luas_tanah[]">
                            <?php } else {?>
                                <input type="hidden" value="<?php echo $row->luas_tanah?>" name="luas_tanah[]">
                            <?php }?>
                        </td>
                        <td>
                            <?php echo $row->luas_bangunan?>
                            <?php if($row->status == "free"){?>
                                <input type="number" value="<?php echo $row->luas_bangunan?>" name="luas_bangunan[]">
                            <?php } else {?>
                                <input type="hidden" value="<?php echo $row->luas_bangunan?>" name="luas_bangunan[]">
                            <?php }?>
                        </td>
                        <td>
                            <?php echo number_format($row->harga_jual)?>
                            <?php if($row->status == "free"){?>
                                <input type="number" value="<?php echo $row->harga_jual?>" name="harga_jual[]">
                            <?php } else {?>
                                <input type="hidden" value="<?php echo $row->harga_jual?>" name="harga_jual[]">
                            <?php }?>
                        </td>
                        <td><?php echo $row->status?></td>
                        <td><?php echo $row->tipe_produk?></td>
                        <td>
                            <?php echo $row->keterangan?>
                            <?php if($row->status == "free"){?>
                                <textarea name="keterangan[]"><?php echo $row->keterangan?></textarea>
                            <?php } else {?>
                                <input type="hidden" value="<?php echo $row->keterangan?>" name="keterangan[]">
                            <?php }?>
                        </td>
                        <td>
                            <?php echo $row->mulai_proyek?>
                            <?php if($row->status == "free"){?>
                                <input type="date" value="<?php echo $row->mulai_proyek?>" name="mulai_proyek[]">
                            <?php } else {?>
                                <input type="hidden" value="<?php echo $row->mulai_proyek?>" name="mulai_proyek[]">
                            <?php }?>
                        </td>
                        <td>
                            <?php echo $row->selesai_proyek?>
                            <?php if($row->status == "free"){?>
                                <input type="date" value="<?php echo $row->selesai_proyek?>" name="selesai_proyek[]">
                            <?php } else {?>
                                <input type="hidden" value="<?php echo $row->selesai_proyek?>" name="selesai_proyek[]">
                            <?php }?>
                        </td>
                        <td>
                            <?php echo "Rp. ".number_format($row->budget_bahan)?>
                            <?php if($row->status == "free"){?>
                                <input type="number" value="<?php echo $row->budget_bahan?>" name="budget_bahan[]">
                            <?php } else {?>
                                <input type="hidden" value="<?php echo $row->budget_bahan?>" name="budget_bahan[]">
                            <?php }?>
                        </td>
                        <td>
                            <?php echo "Rp. ".number_format($row->budget_upah)?>
                            <?php if($row->status == "free"){?>
                                <input type="number" value="<?php echo $row->budget_upah?>" name="budget_upah[]">
                            <?php } else {?>
                                <input type="hidden" value="<?php echo $row->budget_upah?>" name="budget_upah[]">
                            <?php }?>
                        </td>
                        <td>
                            <?php echo $row->nama_pemilik?>

                            <input type="text" value="<?php echo $row->nama_pemilik?>" name="nama_pemilik[]">
                        </td>
                        <td>
                            <?php echo $row->hp_pemilik?>
                            <input type="text" value="<?php echo $row->hp_pemilik?>" name="hp_pemilik[]">
                        </td>
                        <td>
                            <?php echo $row->status_tinggal?>
                            <select class="form-control" name="status_tinggal[]">
                                <option value="">-Pilih-</option>
                                <option value="tinggal" <?php if($row->status_tinggal == "tinggal"){echo "selected";}?>>Tinggal</option>
                                <option value="belum tinggal" <?php if($row->status_tinggal == "belum tinggal"){echo "selected";}?>>Belum Tinggal</option>
                            </select>
                        </td>
                        <td><?php echo $row->created_by?></td>
                        <td><?php echo date('Y-m-d H:i:sa', strtotime($row->date_by))?></td>
                        <td><?php echo $row->rev_by?></td>
                        <td><?php echo date('Y-m-d H:i:sa', strtotime($row->rev_date))?></td>
                        <td>
                            <a href="<?php echo base_url()?>Dashboard/edit_view_rumah?id=<?php echo $row->id_rumah;?>" class="btn btn-default btn-sm">Edit</a>
                            <a href="<?php echo base_url()?>Dashboard/hapus_rumah?id=<?php echo $row->id_rumah;?>" class="btn btn-default btn-sm">Hapus</a>
                        </td>
                        </tr>
                        <?php }?>
                    </tbody>
                    </table>
                </form>
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
  </div>
  <!-- /.content-wrapper -->
  
  <?php include "include/footer.php"?>

  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo base_url()?>asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});

$(document).ready(function(){
    $("select.category").change(function(){
        var selectedCountry = $(".category option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_perumahan",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response").html(data);
        });
    });
    // $("select.category2").change(function(){
    //     var selectedCountry = $(".category2 option:selected").val();
    //     $.ajax({
    //         type: "POST",
    //         url: "<?php echo base_url()?>Dashboard/get_jenis_pengeluaran",
    //         data: { country : selectedCountry } 
    //     }).done(function(data){
    //         $("#response2").html(data);
    //     });
    // });
});
</script>
<!-- jQuery -->
<!-- // <script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script> -->
<!-- Bootstrap 4 -->
<!-- <script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<!-- DataTables -->
<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<!-- <script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url()?>asset/dist/js/demo.js"></script> -->
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": true,
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
      "scrollY": "300px"
    });
  });
</script>
<script>
$(document).ready(function(){

$('#tipe_produk').change(function(){

  var value = $(this).val();

  if(value == ''){
    // NONE
    $('#curator input[type="text"]').removeAttr('readonly');
  }
  else if(value == 'kavling'){
    // CURRENT
    $('#curator input[type="text"]').attr('readonly', true);
    $('#curator .current').removeAttr('readonly');
  }
  else if(value == 'rumah'){
    // FUTURE
    // $('#curator input[type="text"]').attr('readonly', true);
    $('#curator input[type="text"]').removeAttr('readonly');
  }

});

});
</script>
</body>
</html>
