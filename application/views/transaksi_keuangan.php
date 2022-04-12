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
  <style>
    #wrapper {
      background: #ccc;
      overflow: hidden;
      transition: max-height 300ms;
      max-height: 0;
      padding-left: 50px;
      padding-right: 50px; /* <---hide by default */
    }
    #wrapper.open {
      max-height: 1000px; /* <---when open, allow content to expand to take up as much height as it needs, up to e.g. 100px */
    }
  </style>
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
            <h1>Transaksi Kas & KPR</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Keuangan</li>
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
            <div>

            </div>
            <hr/>

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <button class="btn btn-info btn-flat" id="button">FILTER</button>
                <form action="<?php echo base_url()?>Dashboard/filter_tipe_pembayaran_keuangan" method="post">
                  <div style="" id="wrapper" class="row">
                    <div class="form-group col-sm-6">
                      <label>Pembayaran</label>
                      <select name="tipe_pembayaran" class="form-control">
                        <?php if($tipe_pembayaran == "KPR"){?>
                          <option value="Semua">Semua</option>
                          <option value="KPR" selected>KPR</option>
                          <option value="Cash">Cash</option>
                          <option value="Tempo">Tempo</option>
                        <?php } else if($tipe_pembayaran == "Cash"){?>
                          <option value="Semua">Semua</option>
                          <option value="KPR">KPR</option>
                          <option value="Cash" selected>Cash</option>
                          <option value="Tempo">Tempo</option>
                        <?php } else if($tipe_pembayaran == "Tempo"){?>
                          <option value="Semua">Semua</option>
                          <option value="KPR">KPR</option>
                          <option value="Cash">Cash</option>
                          <option value="Tempo" selected>Tempo</option>
                        <?php } else {?>
                          <option value="Semua" selected>Semua</option>
                          <option value="KPR">KPR</option>
                          <option value="Cash">Cash</option>
                          <option value="Tempo">Tempo</option>
                        <?php }?>
                      </select>
                    </div>
                    <div class="form-group col-sm-6">
                      <label>Perumahan</label>
                      <select name="kode_perumahan" class="form-control">
                        <option value="Semua">Semua</option>
                        <?php foreach($this->db->get('perumahan')->result() as $prmh){ 
                          echo "<option ";
                          if($kode_perumahan == $prmh->kode_perumahan){
                            echo "selected";
                          }
                          echo " value='$prmh->kode_perumahan'>$prmh->nama_perumahan</option>";
                        }?>
                      </select>
                    </div>

                    <input type="submit" value="SEARCH" class="btn btn-info btn-flat btn-sm">
                  </div>
                </form> <br>
                <table id="example2" class="table table-bordered table-striped" style="font-size: 14px">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No PPJB</th>
                      <th>Tgl PPJB</th>
                      <th>Nama Konsumen</th>
                      <th>Marketing</th>
                      <th>Cara Bayar</th>
                      <th>Unit</th>
                      <th>Lama Tempo</th>
                      <th>Harga Standar (Rp)</th>
                      <th>Hadap Timur (Rp)</th>
                      <th>Diskon (Rp)</th>
                      <th>Total Harga Jual (Rp)</th>
                      <th>Angsuran yg sudah dibayar (Rp)</th>
                      <th>Sisa angsuran (Rp)</th>
                      <th>% Pembayaran</th>
                      <?php if($this->session->userdata('role') != "manager produksi"){?>
                        <th>Pilihan Proses</th>
                      <?php }?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($check_all->result() as $row){?>
                    <tr href="#">
                        <td><?php echo $no?></td>
                        <td><?php echo "1-".substr("000{$row->no_psjb}", -3);?></td>
                        <td style="white-space: nowrap;"><?php echo $row->tgl_psjb?></td>
                        <td style="white-space: nowrap;"><?php echo $row->nama_pemesan?></td>
                        <td style="white-space: nowrap;"><?php echo $row->nama_marketing?></td>
                        <td><?php echo $row->sistem_pembayaran?></td>
                        <td style="white-space: nowrap;">
                          <?php echo $row->no_kavling?>
                          <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rumah){?>
                            , <?php echo $rumah->no_unit?>
                          <?php }?>
                        </td>
                        
                        <!--Lama Tempo-->
                        <?php if($row->sistem_pembayaran=="KPR"){?>
                          <td><?php echo $row->jumlah_dp?></td>
                        <?php } else if($row->sistem_pembayaran=="Cash"&&$row->persen_dp==0) {
                          echo "<td>".$row->lama_cash."</td>";
                        }
                        else if($row->sistem_pembayaran=="Cash"){?>
                          <td><?php echo $row->jumlah_dp+$row->lama_cash?></td>
                        <?php } else {?>
                          <td><?php echo $row->lama_tempo?></td>
                        <?php }?>
                        <!--END OF LAMA TEMPO-->

                        <td><?php echo number_format($row->harga_jual)?>,-</td>
                        <td><?php echo number_format($row->hadap_timur)?>,-</td>
                        <td><?php echo number_format($row->disc_jual)?>,-</td>
                        <td><?php echo number_format($row->total_jual)?>,-</td>
                        
                        <?php $temp=0; foreach($this->db->get_where('ppjb-dp', array('no_psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as $dp){?>
                          <!-- <?php $temp=$temp+$dp->dana_bayar?> -->
                        <?php } $temp = $temp + $row->uang_awal;?>
                        
                        <td>Rp. <?php echo number_format($temp);?>,-</td>
                        <td>Rp. <?php echo number_format($row->total_jual-$temp);?>,-</td>
                        <td>
                          <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo number_format(($temp/$row->total_jual)*100, 1)?>" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                              <?php echo number_format(($temp/$row->total_jual)*100, 2)?> %
                            </div>
                          </div>
                        </td>

                        <?php if($this->session->userdata('role') != "manager produksi"){?>
                          <?php if($row->status == "dom"){?>
                              <td><a href="<?php echo base_url()?>Dashboard/view_transaksi?id=<?php echo $row->no_psjb?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-sm btn-primary">Transaksi</a></td>
                          <?php } else if($row->status=="menunggu"){?>
                              <td><span>Proses Pembatalan</span></td>
                          <?php } else {?>
                              <td><span><i>Dibatalkan</i></span></td>
                          <?php }
                        }?>
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
  var r = confirm("Anda akan menetapkan PPJB ini di approve?");
  if (r == true) {
    window.location.replace(base_url+"/ppjb_approve?id="+id);
  } else {
    window.location.replace(base_url+"/ppjb_management")
  }
  document.getElementById("demo").innerHTML = txt;
}

function myFunction1(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PPJB ini dibatalkan?");
  if (r == true) {
    window.location.replace(base_url+"/ppjb_pembatalan?id="+id);
  } else {
    window.location.replace(base_url+"/ppjb_management")
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
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true
    });
  });

  $(function() {
    var b = $("#button");
    var w = $("#wrapper");
    var l = $("#list");
    b.click(function() {
      w.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });
  });
</script>
</body>
</html>
