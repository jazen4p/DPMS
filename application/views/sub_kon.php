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
            <h1>Data Sub Kontraktor</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Sub Kontraktor</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php if(isset($edit_sub_kon)) {
        foreach($edit_sub_kon as $row){?>
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                <!-- /.card-header -->
                <div class="card-header">
                    Data Sub Kontraktor
                </div>
                <!-- form start -->
                <form role="form" action="<?php echo base_url()?>Dashboard/edit_sub_kon" method="post" enctype="multipart/form-data">
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Notaris</label>
                                    <input type="text" class="form-control" value="<?php echo $row->nama_sub?>" id="exampleInputEmail1" placeholder="Nama Sub Kontraktor" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail2">Alamat</label>
                                    <textarea class="form-control" id="exampleInputEmail2" placeholder="Alamat" name="alamat" required><?php echo $row->alamat_sub?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Pekerjaan</label>
                                    <input type="text" class="form-control" value="<?php echo $row->pekerjaan_sub?>" id="exampleInputEmail3" placeholder="Pekerjaan" name="pekerjaan">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail4">No. KTP</label>
                                    <input type="number" class="form-control" value="<?php echo $row->ktp_sub?>" id="exampleInputEmail4" placeholder="No. KTP" name="ktp">
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
                        <a href="<?php echo base_url()?>Dashboard/sub_kon_management" class="btn btn-primary">Tambah Baru</a>
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
                <div class="card-header">
                    Data Sub Kontraktor
                </div>
                <!-- form start -->
                <form role="form" action="<?php echo base_url()?>Dashboard/add_sub_kon" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Notaris</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama Sub Kontraktor" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail2">Alamat</label>
                                    <textarea class="form-control" id="exampleInputEmail2" placeholder="Alamat" name="alamat" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Pekerjaan</label>
                                    <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Pekerjaan" name="pekerjaan">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail4">No. KTP</label>
                                    <input type="number" class="form-control" id="exampleInputEmail4" placeholder="No. KTP" name="ktp">
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
                        <a href="<?php echo base_url()?>Dashboard/sub_kon_management" class="btn btn-success">Tambah Baru</a>
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
                <h3 class="card-title">Sub Kontraktor Management</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped" style="font-size: 13px">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Sub Kontraktor</th>
                      <th>Alamat</th>
                      <th>Pekerjaan</th>
                      <th>No. KTP</th>
                      <th>Dibuat oleh</th>
                      <th>Pada</th>
                      <th>Diupdate Oleh</th>
                      <th>Pada</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($check_all as $row){?>
                    <tr>
                      <td><?php echo $no?></td>
                      <td><?php echo $row->nama_sub?></td>
                      <td><?php echo $row->alamat_sub?></td>
                      <td><?php echo $row->pekerjaan_sub?></td>
                      <!-- <td><?php echo $row->fax_notaris?></td> -->
                      <td><?php echo $row->ktp_sub?></td>
                      <!-- <td><?php echo $row->email_notaris?></td> -->
                      <td><?php echo $row->created_by?></td>
                      <td><?php echo $row->date_by?></td>
                      <td><?php echo $row->rev_by?></td>
                      <td><?php echo $row->rev_date?></td>
                      <td>
                        <a href="<?php echo base_url()?>Dashboard/edit_view_sub_kon?id=<?php echo $row->id_sub_kon?>" class="btn btn-default btn-sm">Edit</a>
                        <a href="<?php echo base_url()?>Dashboard/hapus_sub_kon?id=<?php echo $row->id_sub_kon?>" class="btn btn-default btn-sm">Hapus</a>
                      </td>
                    </tr>
                    <?php $no++;}?>
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
      "responsive": false,
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
