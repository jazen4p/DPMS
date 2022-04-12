<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <title>AdminLTE 3 | General Form Elements</title> -->
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
</head>
<body class="hold-transition sidebar-mini">
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
            <h1>Data Perumahan/Proyek</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Perumahan/Proyek</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php if(isset($edit_perumahan)) {
        foreach($edit_perumahan as $row){?>
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="<?php echo base_url()?>Dashboard/edit_perumahan" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12" style="font-size: 13px; color: red">
                                <label>*Mengubah = data yang telah terdaftar tidak akan terbaca</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kode Perumahan <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kode Perumahan" name="kode_perumahan" value="<?php echo $row->kode_perumahan?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Perumahan</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Perumahan" name="nama_perumahan" value="<?php echo $row->nama_perumahan?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Perusahaan</label>
                                    <select class="form-control" name="nama_perusahaan">
                                        <?php foreach($this->db->get('perusahaan')->result() as $row2){
                                            echo "<option ";
                                            if($row->nama_perusahaan == $row2->nama_perusahaan){
                                                echo "selected";
                                            }
                                            echo ">$row2->nama_perusahaan</option>";
                                        }?>
                                    </select>
                                    <span>Pilihan saat ini: <?php echo $row->nama_perusahaan?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Desa/ Nama Jalan</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" value="<?php echo $row->nama_jalan?>" placeholder="Desa/ Nama Jalan" name="nama_jalan" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">RT</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" value="<?php echo $row->RT?>" placeholder="RT" name="RT" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">RW</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" value="<?php echo $row->RW?>" placeholder="RW" name="RW" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kecamatan</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row->kecamatan?>" placeholder="Kecamatan" name="kecamatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Kabupaten</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" value="<?php echo $row->kabupaten?>" placeholder="Kabupaten" name="kabupaten" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Provinsi</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" value="<?php echo $row->provinsi?>" placeholder="Provinsi" name="provinsi" required>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="exampleInputPassword1">Tipe Perusahaan</label>
                                    <select class="form-control" name="tipe_perusahaan">
                                        <option value="perumahan">Perumahan</option>
                                        <option value="kavling">Kavling</option>
                                    </select>
                                    <span>Pilihan saat ini: <?php echo $row->tipe_perusahaan?></span>
                                </div> -->
                                <div class="form-group">
                                    <label for="exampleInputPassword1">No. Telp</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" value="<?php echo $row->telp?>" placeholder="No Telp" name="telp">
                                </div>
                                <div class="form-group">
                                    <label>No SHM Induk</label>
                                    <input type="text" class="form-control" value="<?php echo $row->shm_induk?>" name="shm_induk">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Keterangan</label>
                                    <textarea class="form-control" name="keterangan"><?php echo $row->keterangan?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <img src="<?php echo base_url()?>gambar/<?php echo $row->siteplan?>" style="width: 350px; height: 500px" ALT="Siteplan">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Siteplan</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="berkas" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            <input type="hidden" name="old" value="<?php echo $row->siteplan?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            <span style="color: green"><?php echo $succ_msg?></span><br>
                        <?php }?>
                        <input type="hidden" value=<?php echo $id?> name="id">
                        <input type="submit" class="btn btn-primary" value="Submit" />
                        <a href="<?php echo base_url()?>Dashboard/perumahan_management" class="btn btn-primary">Tambah Baru</a>
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
                <form role="form" action="<?php echo base_url()?>Dashboard/add_perumahan" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kode Perumahan</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kode Perumahan" name="kode_perumahan" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Perumahan</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Perumahan" name="nama_perumahan" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Perusahaan</label>
                                    <select class="form-control" name="nama_perusahaan" required>
                                        <option value="" disabled selected>-Pilih-</option>
                                        <?php foreach($this->db->get('perusahaan')->result() as $row){?>
                                            <option value="<?php echo $row->nama_perusahaan?>"><?php echo $row->nama_perusahaan?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Desa/ Nama Jalan</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Desa/ Nama Jalan" name="nama_jalan" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">RT</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="RT" name="RT" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">RW</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="RW" name="RW" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kecamatan</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kecamatan" name="kecamatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Kabupaten</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Kabupaten" name="kabupaten" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Provinsi</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Provinsi" name="provinsi" required>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="exampleInputPassword1">Tipe Perusahaan</label>
                                    <select class="form-control" name="tipe_perusahaan">
                                        <option value="perumahan">Perumahan</option>
                                        <option value="kavling">Kavling</option>
                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label for="exampleInputPassword1">No. Telp</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="No Telp" name="telp">
                                </div>
                                <div class="form-group">
                                    <label>No SHM Induk</label>
                                    <input type="text" class="form-control" placeholder="No SHM Induk" name="shm_induk">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Keterangan</label>
                                    <textarea class="form-control" name="keterangan"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputFile">Siteplan</label>
                                    <div>
                                        <img src="<?php echo base_url()?>asset/dist/img/default-150x150.png" style="width: 150px; height: 150px">
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="berkas" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                    <!-- <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div> -->
                                    </div>
                                </div>
                            </div>
                        <!-- </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div> -->
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><?php }?>
                        <?php if(isset($succ_msg)){?>
                            <span style="color: green"><?php echo $succ_msg?></span><br>
                        <?php }?>
                        <input type="submit" class="btn btn-primary" value="Submit" />
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
    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <hr/>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Perumahan/Proyek Management</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped" style="font-size: 14px">
                  <thead>
                    <tr>
                      <th>Kode Perumahan</th>
                      <th>Nama Perumahan</th>
                      <th>Nama Perusahaan</th>
                      <th>Desa/Nama Jalan</th>
                      <!-- <th>Tipe Perumahan</th> -->
                      <th>No. Telp</th>
                      <th>Keterangan</th>
                      <th>Dibuat oleh</th>
                      <th>Pada</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($check_all as $row){?>
                    <tr>
                      <td><?php echo $row->kode_perumahan?></td>
                      <td><?php echo $row->nama_perumahan?></td>
                      <td><?php echo $row->nama_perusahaan?></td>
                      <td><?php echo $row->nama_jalan?></td>
                      <!-- <td><?php echo $row->tipe_perusahaan?></td> -->
                      <td><?php echo $row->telp?></td>
                      <td><?php echo $row->keterangan?></td>
                      <td><?php echo $row->created_by?></td>
                      <td><?php echo $row->date_by?></td>
                      <td>
                        <a href="<?php echo base_url()?>Dashboard/edit_view_perumahan?id=<?php echo $row->id_perumahan?>" class="btn btn-default btn-sm">Edit</a>
                        <a href="<?php echo base_url()?>Dashboard/hapus_perumahan?id=<?php echo $row->id_perumahan?>" class="btn btn-default btn-sm">Hapus</a>
                      </td>
                    </tr>
                    <?php }?>
                  </tfoot>
                </table>
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
<!-- bs-custom-file-input -->
<script src="<?php echo base_url()?>asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- jQuery -->
<!-- // <script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script> -->
<!-- Bootstrap 4 -->
<!-- <script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<!-- DataTables -->

<!-- AdminLTE App -->
<!-- <script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url()?>asset/dist/js/demo.js"></script> -->
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "scrollX": true
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
