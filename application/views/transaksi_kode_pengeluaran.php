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
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<!-- <body class="hold-transition sidebar-mini"> -->
<?php include "include/fixedtop.php"?>
<div class="wrapper">
  <!-- Navbar -->
  <?php include "include/navbar.php"?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "include/sidebar.php"?>

  <?php 
    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
          $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
          $temp = penyebut($nilai - 10). " Belas";
        } else if ($nilai < 100) {
          $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
          $temp = " Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
          $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
          $temp = " Seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
          $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
          $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
          $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
          $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
      }
    
      function terbilang($nilai) {
        if($nilai<0) {
          $hasil = "minus ". trim(penyebut($nilai));
        } else {
          $hasil = trim(penyebut($nilai));
        }     		
        return $hasil;
      }
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master Data Kode Pengeluaran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Kode Pengeluaran</li>
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>No Kwitansi</label>
                                                <input type="text" class="form-control" placeholder="No Kwitansi" name="no_kwitansi" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Terima dari</label>
                                                <input type="text" class="form-control" placeholder="Terima dari" name="terima_dari" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Keterangan Penerimaan</label>
                                                <textarea class="form-control" placeholder="Keterangan Penerimaan" name="keterangan_penerimaan" value="" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Nilai Penerimaan</label>
                                                <input type="number" class="form-control" placeholder="Nilai Penerimaan" name="nilai_penerimaan" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tanggal Penerimaan</label>
                                                <input type="date" class="form-control" placeholder="" name="tgl_penerimaan" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Pembayaran</label>
                                                <select class="form-control" placeholder="" name="jenis_pembayaran" required>
                                                    <option disabled selected value="">-Pilih-</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Bank</label>
                                                <select class="form-control" placeholder="" name="bank" required>
                                                    <option disabled selected value="">-Pilih-</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <?php if(isset($succ_msg)){?>
                                        <span style="color: green"><?php echo $succ_msg?></span><br>
                                    <?php }?>
                                    <?php if(isset($err_msg)){?>
                                        <span style="color: red"><?php echo $err_msg?></span><br>
                                    <?php }?>
                                    <input type="hidden" value=<?php echo $id?> name="id">
                                    <input type="submit" class="btn btn-primary" value="Submit" />
                                    <a href="<?php echo base_url()?>Dashboard/penerimaan_lain" class="btn btn-primary">Tambah Baru</a>
                                </div>
                            </form>
                        </div>
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
                    <?php if($this->session->userdata('role') == "superadmin"){?>
                      <div class="col-md-12 card">
                        <div class="card-body">
                            <a href="<?php echo base_url()?>Dashboard/kontrol_budget" class="btn btn-outline-primary btn-flat">Kontrol Budget</a>
                        </div>
                      </div>
                    <?php }?>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Kode Induk Pengeluaran</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="POST" action="<?php echo base_url()?>Dashboard/add_kode_induk_pengeluaran">
                                            <!-- <div class="row"> -->
                                            <div class="form-group">
                                                <label>Kode Induk</label>
                                                <input type="text"  class="form-control" name="kode_induk" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Induk</label>
                                                <input type="text" class="form-control" name="nama_induk" required>
                                            </div>
                                            <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="submit" class="btn btn-flat btn-success btn-sm" value="Tambah">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Kode Pengeluaran</h4>
                            </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form role="form" action="<?php echo base_url()?>Dashboard/add_kode_pengeluaran" method="POST">
                                                <div class="form-group">
                                                    <label>Kode Induk</label>
                                                    <select name="kode_induk" class="form-control" required>
                                                        <option value="" disabled selected>-Pilih-</option>
                                                        <?php foreach($kode_induk as $induk){?>
                                                            <option value="<?php echo $induk->kode_induk?>"><?php echo $induk->kode_induk?>-<?php echo $induk->nama_induk?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kode Pengeluaran</label>
                                                    <input type="text"  class="form-control" name="kode_pengeluaran" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Pengeluaran</label>
                                                    <input type="text" class="form-control" name="nama_pengeluaran" required>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><?php }?>
                                    <?php if(isset($succ_msg)){?>
                                        <span style="color: green"><?php echo $succ_msg?></span><br>
                                    <?php }?>
                                    <?php if(isset($err_msg)){?>
                                        <span style="color: red"><?php echo $err_msg?></span><br>
                                    <?php }?>
                                    <input type="submit" class="btn btn-success btn-flat btn-sm" value="Tambah" />
                                    <!-- <a href="<?php echo base_url()?>Dashboard/penerimaan_ground_tank" class="btn btn-primary">Tambah Baru</a> -->
                                </div>
                            </form>
                        </div>
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
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <h4>Kode Induk</h4>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped" style="font-size: 14px">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Induk</th>
                      <th>Nama Induk</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;foreach($kode_induk as $row){?>
                    <tr>
                      <td><?php echo $no?></td>
                      <td><?php echo $row->kode_induk?></td>
                      <td><?php echo $row->nama_induk?></td>
                      <td>
                        <!-- <a href="<?php echo base_url()?>Dashboard/edit_view_perumahan?id=<?php ?>" class="btn btn-default btn-sm">Edit</a> -->
                        <!-- <a href="<?php echo base_url()?>Dashboard/hapus_perumahan?id=<?php ?>" class="btn btn-default btn-sm">Hapus</a> -->
                      </td>
                    </tr>
                    <?php $no++;}?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card">
              <div class="card-header">
                <h4>Kode Pengeluaran</h4>
              </div>
              <div class="card-body">
                <table id="example3" class="table table-bordered table-striped" style="font-size: 14px">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Terima dari</th>
                      <th>No Kwitansi/PPJB</th>
                      <th>Jenis Penerimaan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;foreach($kode_pengeluaran as $row2){?>
                    <tr>
                      <td><?php echo $no?></td>
                      <td><?php echo $row2->kode_induk?></td>
                      <td><?php echo $row2->kode_pengeluaran?></td>
                      <td><?php echo $row2->nama_pengeluaran?></td>
                      <td>
                        <!-- <a href="<?php echo base_url()?>Dashboard/edit_view_perumahan?id=<?php ?>" class="btn btn-default btn-sm">Edit</a> -->
                        <a href="<?php echo base_url()?>Dashboard/hapus_kode_pengeluaran?id=<?php echo $row2->kode_pengeluaran?>" class="btn btn-default btn-sm">Hapus</a>
                      </td>
                    </tr>
                    <?php $no++;}?>
                  </tbody>
                </table>
              </div>
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
    $("#example3").DataTable({
      "responsive": false,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>
