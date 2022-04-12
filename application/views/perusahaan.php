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
            <h1>Data Perusahaan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Perusahaan</li>
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
            <div class="row">
            <!-- left column -->
              <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php if(isset($edit_perusahaan)) {
                        foreach($edit_perusahaan as $row){?>
                        <form role="form" action="<?php echo base_url()?>Dashboard/edit_perusahaan" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Kode Kota</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kode Kota" name="kode_kota" value="<?php echo $row->kode_kota?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Nama Kota</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Kota" name="nama_kota" value="<?php echo $row->nama_kota?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Kode Perusahaan</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Kode Perusahaan" name="kode_perusahaan" value="<?php echo $row->kode_perusahaan?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Nama Perusahaan</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Perusahaan" name="nama_perusahaan" value="<?php echo $row->nama_perusahaan?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">No NPWP</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="No NPWP" name="npwp" value="<?php echo $row->npwp?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <img src="<?php echo base_url()?>gambar/<?php echo $row->file_name?>" style="width: 180px; height: 200px" alt="Company Logo Picture">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Gambar Logo Perusahaan</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="berkas" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    <input type="hidden" name="id" value="<?php echo $id?>">
                                                    <input type="hidden" name="old" value="<?php echo $row->file_name?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <?php if(isset($succ_msg)){?><span style="color: green"><?php echo $succ_msg?></span><br><?php }?>
                                    <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><br><?php }?>
                                    <input type="submit" class="btn btn-primary" value="Update" />
                                    <a href="<?php echo base_url()?>Dashboard/perusahaan_management" class="btn btn-primary">Tambah Baru</a>
                                </div>
                        </form>
                    <?php }} else {?>
                        <form role="form" action="<?php echo base_url()?>Dashboard/add_perusahaan" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Kode Kota</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kode Kota" name="kode_kota" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Nama Kota</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Kota" name="nama_kota" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Kode Perusahaan</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Kode Perusahaan" name="kode_perusahaan" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Nama Perusahaan</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Perusahaan" name="nama_perusahaan" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">No NPWP</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="No NPWP" name="npwp" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Gambar Logo Perusahaan</label>
                                            <div>
                                              <img src="<?php echo base_url()?>asset/dist/img/default-150x150.png" style="width: 150px; height: 150px">
                                            </div>
                                            <div class="input-group">
                                              <div class="custom-file">
                                                  <input type="file" name="berkas" class="custom-file-input" id="exampleInputFile">
                                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                              </div>
                                              <div class="input-group-append">
                                                  <!-- <span class="input-group-text" id="">Upload</span> -->
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- /.card-body -->
                                <div class="card-footer">
                                    <?php if(isset($succ_msg)){?><span style="color: green"><?php echo $succ_msg?></span><?php }?>
                                    <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><?php }?>
                                    <input type="submit" class="btn btn-primary" value="Submit" />
                                    <a href="<?php echo base_url()?>Dashboard/perusahaan_management" class="btn btn-primary">Tambah Baru</a>
                                </div>
                        </form>
                        <?php }?>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Perusahaan Management</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped" style="font-size: 14px">
                                <thead>
                                    <tr>
                                        <th>Kode Kota</th>
                                        <th>Nama Kota</th>
                                        <th>Kode Perusahaan</th>
                                        <th>Nama Perusahaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($check_all as $row){?>
                                    <tr>
                                        <td><?php echo $row->kode_kota?></td>
                                        <td><?php echo $row->nama_kota?></td>
                                        <td><?php echo $row->kode_perusahaan?></td>
                                        <td><?php echo $row->nama_perusahaan?></td>
                                        <td>
                                            <a href="<?php echo base_url()?>Dashboard/edit_view_perusahaan?id=<?php echo $row->id_perusahaan?>" class="btn btn-default btn-sm">Edit</a>
                                            <a href="<?php echo base_url()?>Dashboard/hapus_perusahaan?id=<?php echo $row->id_perusahaan?>" class="btn btn-default btn-sm">Hapus</a>
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
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>
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
      "scrollX": true
    });
  });
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
