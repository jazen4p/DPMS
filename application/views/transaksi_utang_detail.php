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
   
    <?php foreach($detail as $row) {?>
      <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Rincian Utang</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                  <li class="breadcrumb-item active">Rincian Utang</li>
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
                      <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran_hutang" class="btn btn-success btn-sm">Kembali</a>
                    </div>
                    <!-- /.row -->
                  </div>
                  <div class="card-body">
                      <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No Kwitansi</label>
                                    <input type="text" class="form-control" value="<?php echo $row->no_pengeluaran?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" readonly><?php echo $row->keterangan?></textarea>
                                    <!-- <input type="text" class="form-control" value="<?php echo $row->keterangan?>" readonly> -->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Periode Awal</label>
                                    <!-- <textarea class="form-control" readonly><?php echo $row->keterangan?></textarea> -->
                                    <input type="text" class="form-control" value="<?php echo $row->periode_awal?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Periode Akhir</label>
                                    <!-- <textarea class="form-control" readonly><?php echo $row->keterangan?></textarea> -->
                                    <input type="text" class="form-control" value="<?php echo $row->periode_akhir?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nominal Utang</label>
                                    <input type="text" class="form-control" value="Rp. <?php echo number_format($row->nominal)?>" readonly>
                                </div>
                            </div>
                        </div>
                      </div>
                        <?php if($row->status=="lunas"){?>
                        <hr>
                            <div style="color: green">
                                <h3>UTANG INI DINYATAKAN TELAH LUNAS</h3>
                            </div>
                        <?php }?>
                        <hr>
                      <div class="col-md-12">
                        <table class="table table-bordered table-striped" id="example2" style="font-size: 14px">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th>Tgl Bayar</th>
                                    <th>Nilai Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; $pembayaran=0; foreach($detail_pembayaran as $row2){
                                    $pembayaran=$pembayaran+$row2->nominal?>
                                    <tr>
                                        <td><?php echo $no?></td>
                                        <td><?php echo $row2->tgl_pembayaran?></td>
                                        <td>Rp. <?php echo number_format($row2->nominal)?>,-</td>
                                    </tr>
                                <?php $no++;}?>
                                <tr>
                                    <td colspan=2 style="text-align: right; background-color: pink">Total Utang</td>
                                    <td style="background-color: pink">Rp. <?php echo number_format($row->nominal)?>,-</td>
                                </tr>
                                <tr>
                                    <td colspan=2 style="text-align: right">Total Terbayar</td>
                                    <td>Rp. <?php echo number_format($pembayaran)?>,-</td>
                                </tr>
                                <tr>
                                    <td colspan=2 style="text-align: right; background-color: pink">Sisa Utang</td>
                                    <td style="background-color: pink">Rp. <?php echo number_format($row->nominal-$pembayaran)?>,-</td>
                                </tr>
                            </tbody>
                        </table>
                      </div>
                    <!-- /.row -->
                  </div>
                  <!-- ./card-body -->
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

    <div class="modal fade" id="buktiPengeluaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Bukti Pengeluaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="img" class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  
  <!-- /.content-wrapper -->
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
    window.location.replace(base_url+"/add_psjb");
  } else {
    window.location.replace(base_url+"/psjb");
  }
//   document.getElementById("demo").innerHTML = txt;
}

$('#buktiPengeluaran').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-src');
    // var myRoomNumber1 = $(e.relatedTarget).attr('data-terimaOleh');
    $(this).find('#img').html('<img src="<?php echo base_url()?>/gambar/pengeluaran/'+myRoomNumber+'" alt="Bukti">');
    // $(this).find('.noSHM').value(myRoomNumber);
    // $(this).find('.terimaOleh').text(myRoomNumber1);
});
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
</body>
</html>
