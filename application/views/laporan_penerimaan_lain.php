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
<!-- <body class="hold-transition sidebar-mini"> -->
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
            <h1>
              Rekap Penerimaan Piutang Kas/Transfer
              <?php if(isset($perumahan)){
                  echo " - ".$perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Rekap Piutang</li>
            </ol>
          </div>
        </div>
        <form action="<?php echo base_url()?>Dashboard/filter_laporan_transaksi_keuangan" method="POST">
          <div class="row">
            <label>Perumahan: </label><br>
            <select name="perumahan" class="form-control col-sm-2">
                <option value="">Semua</option>
                <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                <?php }?>
            </select>
          <?php if(isset($kode)){?>
          <span>Pilihan saat ini: <?php echo $kode?></span>
          <?php }?>
            <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
            <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
            <input placeholder="Tanggal Awal" name="tgl_awal" class="textbox-n form-control col-sm-2" type="text" onfocus="(this.type='date')" id="date">
            <input placeholder="Tanggal Akhir" name="tgl_akhir" class="textbox-n form-control col-sm-2" type="text" onfocus="(this.type='date')" id="date">
            <div>
            <input type="submit" class="btn btn-info btn-flat" value="FILTER" />
            <a href="#" class="btn btn-info btn-flat" style="">CETAK</a>
            </div>
          </div>
        </form>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div>

            </div>
            <hr/>

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="" class="table table-bordered table-striped" style="font-size: 14px">
                  <div style="text-align: center">
                  </div>
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Penerimaan</th>
                        <th>Jenis Penerimaan</th>
                        <th>Keterangan</th>
                        <th>Bank</th>
                        <th>No Kwitansi</th>
                        <th>Terima Dari</th>
                        <th>Nilai Penerimaan</th>
                        <th>Perumahan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($check_all->result() as $row){?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $row->tanggal_dana?></td>
                        <td><?php echo $row->jenis_penerimaan?></td>
                        <td><?php echo $row->keterangan?></td>
                        <td><?php echo $row->nama_bank?></td>
                        <td><?php echo $row->no_kwitansi;?></td>
                        <td><?php echo $row->terima_dari?></td>
                        <?php 
                          // foreach($this->db->get_where('ppjb-dp', array('id_psjb'=>$row->id_ppjb))->result() as $dp){
                          //   echo "<td>".number_format($dp->dana_masuk)."</td>";
                          // }
                        ?>
                        <td>Rp. <?php echo number_format($row->dana_terima)?></td>
                        <td><?php echo$row->kode_perumahan?></td>
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
function myFunction(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PSJB ini di approve?");
  if (r == true) {
    window.location.replace(base_url+"/psjb_approve?id="+id);
  } else {
    window.location.replace(base_url+"/psjb_management")
  }
  document.getElementById("demo").innerHTML = txt;
}

function myFunction1(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PSJB ini di batalkan?");
  if (r == true) {
    window.location.replace(base_url+"/psjb_pembatalan?id="+id);
  } else {
    window.location.replace(base_url+"/psjb_management")
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>
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
