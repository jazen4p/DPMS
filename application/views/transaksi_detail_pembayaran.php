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

  <!-- Content Wrapper. Contains page content -->
    <?php if(isset($kpr)){
      foreach($kpr as $row){?>
      <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Rincian Penerimaan KPR</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                  <li class="breadcrumb-item active">Transaksi KPR</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <!-- /.card-header -->
                  <div class="card-body">
                      <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No Kwitansi</label>
                                    <?php if($row->status=="lunas"){?>
                                      <input type="text" class="form-control" value="<?php echo $row->no_kwitansi?>" readonly>
                                    <?php } else {?>
                                      <input type="text" class="form-control" value="" readonly>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Pemesan</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_konsumen?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tahap Pembayaran</label>
                                    <input type="text" class="form-control" value="<?php echo $row->cara_bayar?>" readonly>
                                </div>
                            </div>
                        </div>
                      </div>
                        <?php if($row->status=="lunas"){?>
                        <hr>
                            <div style="color: green">
                                <h3>PEMBAYARAN INI DINYATAKAN TELAH LUNAS</h3>
                            </div>
                        <?php }?>
                        <hr>
                      <div class="col-md-12">
                        <table class="table table-bordered table-striped" style="font-size: 14px">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th>Tgl Pencairan</th>
                                    <th>Tahap Pencairan</th>
                                    <th>% Pencairan</th>
                                    <th>Bank</th>
                                    <th>Nilai Pencairan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; $pembayaran=0; foreach($detail_pembayaran as $row2){
                                    $pembayaran=$pembayaran+$row2->pembayaran?>
                                    <tr>
                                        <td><?php echo $no?></td>
                                        <td><?php echo $row2->tanggal_bayar?></td>
                                        <td><?php echo $row2->tahap_pencairan?></td>
                                        <td><?php echo $row2->persen_pencairan." %"?></td>
                                        <td><?php echo $row2->nama_bank?></td>
                                        <td>
                                          <div class="row">
                                            <div class="col-9">
                                              Rp. <?php echo number_format($row2->pembayaran)?>,-
                                            </div>
                                            <?php 
                                            // if($row->status == "belum lunas"){
                                              if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager keuangan"){?>
                                                <div class="col-2">
                                                  <a class="btn btn-outline-primary btn-sm btn-flat" href="<?php echo base_url()?>Dashboard/hapus_pembayaran?id=<?php echo $row2->id_keuangan?>">Hapus</a>
                                                </div>
                                            <?php }?>
                                          </div>
                                        </td>
                                    </tr>
                                <?php $no++;}?>
                                <tr>
                                  <td colspan=5 style="text-align: center; background-color: pink">Total Pencairan Seharusnya</td>
                                  <td style="background-color: pink">Rp. <?php echo number_format($row->dana_masuk)?>,-</td>
                                </tr>
                                <tr>
                                  <td colspan=5 style="text-align: center">Total Pencairan</td>
                                  <td>Rp. <?php echo number_format($pembayaran)?>,-</td>
                                </tr>
                                <tr>
                                  <td colspan=5 style="text-align: center; background-color: pink">Sisa Pencairan</td>
                                  <td style="background-color: pink">Rp. <?php echo number_format($row->dana_masuk-$pembayaran)?>,-</td>
                                </tr>
                            </tbody>
                        </table>
                      </div>
                    <!-- /.row -->
                  </div>
                  <!-- ./card-body -->
                  <div class="card-footer">
                    <div class="row">
                      <a href="<?php echo base_url()?>Dashboard/view_transaksi?id=<?php echo $row->no_psjb?>&kode=<?php echo $row->kode_perumahan?>"/ class="btn btn-success btn-sm">Kembali</a>
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.card-footer -->
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
    <?php }} else {?>
    <?php foreach($ppjb as $row) {?>
      <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Rincian Pembayaran</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                  <li class="breadcrumb-item active">Transaksi Keuangan</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <!-- /.card-header -->
                  <div class="card-body">
                      <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No Kwitansi</label>
                                    <?php if($row->status=="lunas"){?>
                                      <input type="text" class="form-control" value="<?php echo $row->no_kwitansi?>" readonly>
                                    <?php } else {?>
                                      <input type="text" class="form-control" value="" readonly>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Pemesan</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_konsumen?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tahap Pembayaran</label>
                                    <input type="text" class="form-control" value="<?php echo $row->cara_bayar?>" readonly>
                                </div>
                            </div>
                        </div>
                      </div>
                        <?php if($row->status=="lunas"){?>
                        <hr>
                            <div style="color: green">
                                <h3>PEMBAYARAN INI DINYATAKAN TELAH LUNAS</h3>
                            </div>
                        <?php }?>
                        <hr>
                      <div class="col-md-12">
                        <table class="table table-bordered table-striped" style="font-size: 14px">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th>Tgl Bayar</th>
                                    <th>Cara Pembayaran</th>
                                    <th>Bank</th>
                                    <th>Nilai Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; $pembayaran=0; foreach($detail_pembayaran as $row2){
                                    $pembayaran=$pembayaran+$row2->pembayaran?>
                                    <tr>
                                        <td><?php echo $no?></td>
                                        <td><?php echo $row2->tanggal_bayar?></td>
                                        <td><?php echo $row2->cara_pembayaran?></td>
                                        <td><?php echo $row2->nama_bank?></td>
                                        <td>
                                          <div class="row">
                                            <div class="col-8">
                                              Rp. <?php echo number_format($row2->pembayaran)?>,-
                                            </div>
                                            <div class="col-4">
                                            <a href="<?php echo base_url()?>Dashboard/print_kwitansi_pembayaran_temp?id=<?php echo $row2->id_keuangan?>" class="btn btn-outline-success btn-sm btn-flat" target="_blank">Cetak</a>
                                            <?php 
                                            // if($row->status == "belum lunas"){
                                              if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager keuangan"){?>
                                                
                                                  <a class="btn btn-outline-primary btn-sm btn-flat" href="<?php echo base_url()?>Dashboard/hapus_pembayaran?id=<?php echo $row2->id_keuangan?>">Hapus</a>
                                                
                                            <?php }?>
                                            </div>
                                          </div>
                                        </td>
                                    </tr>
                                <?php $no++;}?>
                                <tr>
                                    <td colspan=4 style="text-align: center; background-color: pink">Total Seharusnya</td>
                                    <td style="background-color: pink">Rp. <?php echo number_format($row->dana_masuk)?>,-</td>
                                </tr>
                                <tr>
                                    <td colspan=4 style="text-align: center">Total Terbayar</td>
                                    <td>Rp. <?php echo number_format($pembayaran)?>,-</td>
                                </tr>
                                <tr>
                                    <td colspan=4 style="text-align: center; background-color: pink">Sisa Terbayar</td>
                                    <td style="background-color: pink">Rp. <?php echo number_format($row->dana_masuk-$pembayaran)?>,-</td>
                                </tr>
                            </tbody>
                        </table>
                      </div>
                    <!-- /.row -->
                  </div>
                  <!-- ./card-body -->
                  <div class="card-footer">
                    <div class="row">
                      <a href="<?php echo base_url()?>Dashboard/view_transaksi?id=<?php echo $row->no_psjb?>&kode=<?php echo $row->kode_perumahan?>"/ class="btn btn-success btn-sm">Kembali</a>
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.card-footer -->
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
    <?php }?>
  
  <!-- /.content-wrapper -->
<?php }?>
  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->

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

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>
<script type="text/javascript">
function myFunction() {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan pembayaran ini telah lunas?");
  if (r == true) {
    window.location.href(base_url+"/add_psjb");
  } else {
    window.location.replace(base_url+"/psjb");
  }
//   document.getElementById("demo").innerHTML = txt;
}
</script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url()?>asset/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo base_url()?>asset/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()?>asset/plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/pages/dashboard2.js"></script>
</body>
</html>
