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
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">
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
            <h1>Master Data Daftar Barang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Daftar Barang</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    
    <!-- Main content -->
    <?php if(isset($edit_check_all)) {
        foreach($edit_check_all->result() as $row){?>
        
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Daftar Barang</h4>
                            </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                            <form role="form" action="<?php echo base_url()?>Dashboard/add_edit_daftar_barang" method="POST">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input type="text" class="form-control" name="nama_data" value="<?php echo $row->nama_data?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Satuan</label>
                                                <!-- <input type="text" class="form-control" name="nama_data" required> -->
                                                <select class="form-control" name="nama_satuan" required>
                                                  <option value="" disabled selected>-Pilih-</option>
                                                  <?php 
                                                    foreach($this->db->get_where('produksi_master_data', array('kategori'=>"satuan"))->result() as $row1){
                                                      echo "<option ";
                                                      if($row->nama_satuan == $row1->nama_data){
                                                        echo "selected";
                                                      }
                                                      echo " value='$row1->nama_data'>$row1->nama_data</option>";
                                                    }
                                                  ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                          <div class="form-group">
                                            <label>Harga Satuan</label>
                                            <input type="number" value="<?php echo $row->harga_satuan?>" class="form-control" name="harga_satuan">
                                          </div>
                                        </div> -->
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
                                    <!-- <input type="hidden"> -->

                                    <input type="hidden" name="id" value="<?php echo $id?>">
                                    <input type="submit" class="btn btn-success btn-flat btn-sm" value="Edit" />
                                    <a href="<?php echo base_url()?>Dashboard/produksi_daftar_barang" class="btn btn-primary btn-sm btn-flat">Tambah Baru</a>
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
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Daftar Barang</h4>
                            </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                            <form role="form" action="<?php echo base_url()?>Dashboard/add_produksi_daftar_barang" method="POST">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input type="text" class="form-control" name="nama_data" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Satuan</label>
                                                <!-- <input type="text" class="form-control" name="nama_data" required> -->
                                                <select class="form-control" name="nama_satuan" required>
                                                  <option value="" disabled selected>-Pilih-</option>
                                                  <?php foreach($this->db->get_where('produksi_master_data', array('kategori'=>"satuan"))->result() as $row){?>
                                                    <option value="<?php echo $row->nama_data?>"><?php echo $row->nama_data?></option>
                                                  <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                          <div class="form-group">
                                            <label>Harga Satuan</label>
                                            <input type="number" value="<?php echo $row->harga_satuan?>" class="form-control" name="harga_satuan">
                                          </div>
                                        </div> -->
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
                                    <!-- <input type="hidden"> -->
                                    <input type="submit" class="btn btn-success btn-flat btn-sm" value="Tambah" />
                                    <!-- <a href="<?php echo base_url()?>Dashboard/penerimaan_ground_tank" class="btn btn-primary">Tambah Baru</a> -->
                                    <!-- <a href="<?php echo base_url()?>Dashboard/produksi_daftar_barang" class="btn btn-primary btn-sm btn-flat">Tambah Baru</a> -->
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
                <h4>Daftar Barang</h4>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped" style="font-size: 14px">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Barang</th>
                      <th>Nama Satuan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;foreach($check_all->result() as $row){?>
                    <tr>
                      <td><?php echo $no?></td>
                      <td><?php echo $row->nama_data?></td>
                      <td><?php echo $row->nama_satuan?></td>
                      <td>
                        <a href="<?php echo base_url()?>Dashboard/edit_produksi_daftar_barang?id=<?php echo $row->id_data?>" class="btn btn-default btn-sm">Edit</a>
                        <a href="<?php echo base_url()?>Dashboard/hapus_produksi_daftar_barang?id=<?php echo $row->id_data?>" class="btn btn-default btn-sm">Hapus</a>
                      </td>
                    </tr>
                    <?php $no++;}?>
                  </tbody>
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
    $("#date").datepicker();
    $("#checkout").datepicker();
    $('.selectpicker').selectpicker();
  });
  // $(function() {
    
  // });
</script>
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
