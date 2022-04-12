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
            <h1>Daftar Bank</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Bank</li>
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
                <?php if(isset($edit_bank)){
                  foreach($edit_bank as $row){?>
                  <form role="form" action="<?php echo base_url()?>Dashboard/edit_bank" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">No Rekening</label>
                                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kode Bank" name="kode_bank" value="<?php echo $row->kode_bank?>" required>
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Nama Bank</label>
                                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Bank" name="nama_bank" value="<?php echo $row->nama_bank?>" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Atas Nama</label>
                                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Atas Nama" name="atas_nama" value="<?php echo $row->atas_nama?>" required>
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Status</label>
                                  <!-- <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Status" name="status" required> -->
                                  <select class="form-control" id="exampleInputEmail1" placeholder="Status" name="status" required>
                                    <?php if($row->status=="aktif"){?>
                                      <option value="aktif" selected>Aktif</option>
                                      <option value="diblokir">Diblokir</option>
                                    <?php } else {?>
                                      <option value="aktif">Aktif</option>
                                      <option value="diblokir" selected>Diblokir</option>
                                    <?php }?>
                                  </select>
                                  <input type="hidden" name="id" value="<?php echo $id?>">
                              </div>
                            </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <?php if(isset($succ_msg)){?>
                          <span style="color: green"><?php echo $succ_msg;?></span> <br/>
                      <?php }?>
                      <input type="submit" class="btn btn-primary" value="Update" />
                      <a href="<?php echo base_url()?>Dashboard/bank_management" class="btn btn-primary">Tambah Baru</a>
                    </div>
                  </form>
                <?php }} else {?>
                <form role="form" action="<?php echo base_url()?>Dashboard/add_bank" method="post">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">No Rekening</label>
                              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kode Bank" name="kode_bank" required>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputPassword1">Nama Bank</label>
                              <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Bank" name="nama_bank" required>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Atas Nama</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Atas Nama" name="atas_nama" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <!-- <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Status" name="status" required> -->
                            <select class="form-control" id="exampleInputEmail1" placeholder="Status" name="status" required>
                              <option value="aktif">Aktif</option>
                              <option value="diblokir">Diblokir</option>
                            </select>
                        </div>
                      </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <?php if(isset($succ_msg)){?>
                        <span style="color: green"><?php echo $succ_msg;?></span> <br/>
                    <?php }?>
                    <input type="submit" class="btn btn-primary" value="Submit" />
                    <a href="<?php echo base_url()?>Dashboard/bank_management" class="btn btn-primary">Tambah Baru</a>
                  </div>
                </form>
                <?php }?>
                </div>
                <!-- /.card -->
            </div>
                <!-- /.row -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Bank Management</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped" style="font-size: 14px">
                  <thead>
                    <tr>
                      <th>No Rekening</th>
                      <th>Nama Bank</th>
                      <th>Atas Nama</th>
                      <th>Status</th>
                      <th>Dibuat oleh</th>
                      <th>Pada</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($bank_all as $row){?>
                    <tr>
                      <td><?php echo $row->kode_bank?></td>
                      <td><?php echo $row->nama_bank?></td>
                      <td><?php echo $row->atas_nama?></td>
                      <td><?php echo $row->status?></td>
                      <td><?php echo $row->created_by?></td>
                      <td><?php echo $row->date_create?></td>
                      <td>
                        <a href="<?php echo base_url()?>Dashboard/edit_view_bank?id=<?php echo $row->id_bank?>" class="btn btn-default btn-sm">Edit</a>
                        <a href="<?php echo base_url()?>Dashboard/hapus_bank?id=<?php echo $row->id_bank?> ?>" class="btn btn-default btn-sm">Hapus</a>
                        <!-- <button></button> -->
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
