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
  <?php foreach($ppjb as $row) {?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Histori Transaksi <?php echo $row->sistem_pembayaran?> <?php echo $row->nama_pemesan?></h1>
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
              <div class="card-header">
                <div class="row">
                  <a href="<?php echo base_url()?>Dashboard/keuangan_transaksi" class="btn btn-success btn-sm">Kembali</a>
                </div>
              </div>
              <div class="card-body">
                  <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No PPJB</label>
                                <input type="text" class="form-control" value="1-<?php echo $row->no_psjb?>/PPJB/KBR/<?php echo $row->kode_perusahaan?>/<?php echo $row->kode_perumahan?>/<?php echo date("m", strtotime($row->tgl_psjb))?>/<?php echo date("Y", strtotime($row->tgl_psjb))?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Pemesan</label>
                                <input type="text" class="form-control" value="<?php echo $row->nama_pemesan?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Marketing</label>
                                <input type="text" class="form-control" value="<?php echo $row->nama_marketing?>" readonly>
                            </div>
                        </div>
                    </div>
                  </div>
                    <hr>
                  <div class="col-md-12">
                    <table class="table table-bordered table-striped" style="font-size: 14px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Bayar</th>
                                <th>Besarnya</th>
                                <th>Tanggal Rencana Bayar</th>
                                <th>Status</th>
                                <th>Bayar</th>
                                <th>Notifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($ppjb_dp as $row2){?>
                                <tr>
                                    <td><?php echo $no?></td>
                                    <td><?php echo $row2->cara_bayar?></td>
                                    <td>Rp. <?php echo number_format($row2->dana_masuk)?>,-</td>
                                    <td><?php echo $row2->tanggal_dana?></td>
                                      <?php if($row2->status == "lunas"){?>
                                        <td style="background-color: lightgreen">
                                            <span><?php echo $row2->status?></span>
                                        </td>
                                      <?php } else if($row2->persen==0 && $row2->cara_bayar=="Pembayaran DP (0%)" && $row2->dana_masuk==0){?>
                                        <td style="background-color: lightgreen">
                                            <span>tidak ada biaya</span>
                                        </td>
                                      <?php } else {?>
                                        <td>
                                          <span style=""><?php echo $row2->status?></span>
                                        </td>
                                      <?php }?>
                                    <td>
                                      <?php if($row2->persen==0 && $row2->cara_bayar=="Pembayaran DP (0%)" && $row2->dana_masuk==0){
                                        
                                        }
                                        else if($row2->status=="belum lunas"){
                                          if($row2->dana_sekarang != 0){?>
                                            <a href="<?php echo base_url()?>Dashboard/keuangan_bayar?id=<?php echo $row2->id_psjb?>" class="btn btn-sm btn-default">Bayar</a>
                                          <?php }?>
                                        <a href="<?php echo base_url()?>Dashboard/detail_pembayaran?id=<?php echo $row2->id_psjb?>" class="btn btn-sm btn-default">Detail</a>
                                        <?php if($row2->dana_sekarang == 0){?>
                                        <button onclick="myFunction(<?php echo $row2->id_psjb?>, <?php echo $row2->no_psjb?>, '<?php echo $row2->kode_perumahan?>')" class="btn btn-sm btn-default">Lunas</button>
                                      <?php }} else if($row2->status=="lunas"&&$row2->cara_bayar!="Uang Tanda Jadi") {?>
                                        <a href="<?php echo base_url()?>Dashboard/detail_pembayaran?id=<?php echo $row2->id_psjb?>" class="btn btn-sm btn-default">Detail</a>
                                      <?php }
                                       ?>
                                    </td>
                                    <td>
                                        <?php if($row2->status == "lunas" && $row2->cara_bayar!="Uang Tanda Jadi" && $row2->cara_bayar!="KPR"){?>
                                            <a href="<?php echo base_url()?>Dashboard/print_kwitansi_pembayaran?id=<?php echo $row2->id_psjb?>" class="btn btn-success btn-sm" target="_blank">Cetak Kwitansi</a>
                                        <?php } else if ($row2->cara_bayar=="KPR" && $row2->status=="lunas") {?>
                                            <span><?php echo $row->nama_bank." ".$row2->tanggal_dana?></span>
                                        <?php } else if ($row2->cara_bayar=="Uang Tanda Jadi") {?>
                                            <span><?php echo $row->nama_bank." ".$row2->tanggal_dana?></span>
                                        <?php } else if ($row2->dana_sekarang <= 0){?>
                                            <span style="color:green">Pembayaran telah lunas</span>
                                        <?php } else {?>
                                            <span>Sisa: Rp. <?php echo number_format($row2->dana_sekarang)?>,-</span>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php $no++;}?>
                        </tbody>
                    </table>
                  </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
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
<script>
function myFunction(id, id2, id3) {
  var txt;
  var base_url = window.location.origin+"/Dashboard";
  var r = confirm("Apakah Anda Yakin?");
  if (r == true) {
    window.location.replace(base_url+"/pelunasan_pembayaran?id="+id);
  } else {
    window.location.replace(base_url+"/view_transaksi?id="+id2+"&kode="+id3);
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()?>asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

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
