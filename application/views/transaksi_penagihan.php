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
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
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
            <h1>
                Daftar Tagihan Bulanan - 
                <?php if(isset($kode_perumahan)){?>
                    <?php echo $kode_perumahan?>
                <?php } else {?>
                    MS Kencana
                <?php }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <div class="breadcrumb float-sm-right">
                Bulan: <?php echo date("F Y", strtotime($bulan))?>
            </div>
          </div>
          <div class="col-sm-12">
            <div style="text-align: right">
              <a target="_blank" href="<?php echo base_url()?>Dashboard/print_penagihan?id=<?php echo $kode_perumahan?>&kd=<?php echo $bulan?>" class="btn btn-outline-primary btn-flat">PRINT</a>
            </div>
          </div> 
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <div style="text-align: center">
                  <!-- <form action="<?php echo base_url()?>Dashboard/filter_tipe_pembayaran_keuangan" method="post">
                    Filter:
                    <select name="tipe_pembayaran">
                      <option value="Semua">Semua</option>
                      <option value="KPR">KPR</option>
                      <option value="Cash">Cash</option>
                      <option value="Tempo">Tempo</option>
                    </select>
                    <input type="submit" value="ok">
                  </form>
                  <?php if(isset($tipe_pembayaran)){?>
                    <span>Menampilkan: <?php echo $tipe_pembayaran?></span>
                  <?php }?> -->
                </div>
                <button id="button" class="btn btn-info btn-flat">FILTER</button>
                <form action="<?php echo base_url()?>Dashboard/filter_daftar_penagihan" method="POST">
                  <div id="wrapper" class="row" style="">
                    <div class="form-group col-sm-6">
                      <label>Bulan:</label>
                      <input type="month" class="form-control" name="tanggal" value="<?php echo $bulan?>">
                    </div>
                    <div class="form-group col-sm-6">
                      <label>Perumahan:</label>
                      <select name="perumahan" class="form-control">
                        <option value="">Semua</option>
                        <?php foreach($this->db->get('perumahan')->result() as $prmhan){
                          echo "<option ";
                          if($kode_perumahan == $prmhan->kode_perumahan){
                            echo "selected";
                          }
                          echo " value='$prmhan->kode_perumahan'>$prmhan->nama_perumahan</option>";
                        }?>
                      </select>
                    </div>

                    <input type="submit" class="btn btn-info btn-sm" value="SEARCH">
                  </div>
                </form> <br>
                <form action="<?php echo base_url()?>Dashboard/tambah_keterangan_penagihan" method="POST">
                  <table id="example2" class="table table-bordered table-striped" style="font-size: 14px;">
                    <thead>
                      <tr>
                        <th colspan=10></th>
                        <th>
                          <input type="submit" class="btn btn-outline-info btn-sm btn-flat" value="Edit">
                        </th>
                      </tr>
                      <tr>
                        <th>No</th>
                        <th>Nama Konsumen</th>
                        <th>No HP</th>
                        <th>Perumahan</th>
                        <th>Unit</th>
                        <th>Lama Tempo</th>
                        <th>Tgl Jth Tempo</th>
                        <th>Angsuran Ke</th>
                        <th>Angs/Bulan</th>
                        <th>SMS penagihan</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <!-- <th>Aksi</th> -->
                      </tr>
                    </thead>
                    <tbody style=" white-space: nowrap;">
                      <?php $no=1; foreach($ppjb_dp as $row){?>
                      <?php
                          $tanggal_masuk = $row->tanggal_dana;

                          $joined = date("Y-m", strtotime($tanggal_masuk));

                          $monthyear = $bulan; 
                          // $finish = date("Y-m",strtotime($row->finish));
                          // $start = date("Y-m",strtotime($row->start));
                          // if ($joined <= $monthyear) {
                          // }

                          $query = $this->db->get_where('ppjb', array('no_psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan))->result();
                          if ($joined <= $monthyear) {
                              if($row->status=="belum lunas" && $row->cara_bayar != "KPR"){
                                  foreach($query as $row2) { 
                                    ?>
                                  <tr>
                                      <td><?php echo $no;?></td>
                                      <td style="white-space: nowrap;"><a href="<?php echo base_url()?>Dashboard/keuangan_bayar?id=<?php echo $row->id_psjb?>"><?php echo $row2->nama_pemesan?></a></td>
                                      <td style="white-space: nowrap;"><?php echo $row2->telp_hp?></td>
                                      <td>
                                        <?php 
                                        foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row2->kode_perumahan))->result() as $prmh){
                                          echo $prmh->nama_perumahan;
                                        }?>
                                      </td>
                                      <td>
                                        <?php echo $row2->no_kavling;
                                        foreach($this->db->get_where('rumah', array('no_psjb'=>$row2->psjb, 'kode_perumahan'=>$row2->kode_perumahan, 'tipe_produk'=>$row2->tipe_produk))->result() as $rmh){
                                          echo ", ".$rmh->kode_rumah;
                                        }
                                        ?>
                                      </td>
                                      <!--Lama Tempo-->
                                      <td>
                                        <?php 
                                          $ttls = 0;
                                          foreach($query as $ttl){
                                            // echo $ttl->jumlah_dp; echo $ttl->lama_cash;
                                            if($ttl->cara_dp == "cash"){
                                              if($ttl->sistem_pembayaran=="KPR"){
                                                echo $ttls = $ttls + 1;
                                              } else if($ttl->sistem_pembayaran=="Cash"){
                                                echo $ttls = $ttls + 1 +$ttl->lama_cash;
                                              } else {
                                                echo $ttls = $ttls + $ttl->lama_tempo + 1;
                                              }
                                            } else {
                                              if($ttl->sistem_pembayaran=="KPR"){
                                                echo $ttls = $ttls + $ttl->jumlah_dp;
                                              } else if($ttl->sistem_pembayaran=="Cash"){
                                                echo $ttls = $ttls + $ttl->jumlah_dp+$ttl->lama_cash;
                                              } else {
                                                echo $ttls = $ttls + $ttl->lama_tempo+$ttl->jumlah_dp;
                                              }
                                            }
                                          }
                                        ?>
                                      </td>
                                      <!--END OF LAMA TEMPO-->
                                      <td><?php echo date('d-m', strtotime($row->tanggal_dana))?></td>
                                      <td style="white-space: nowrap;">
                                        <?php echo $row->cara_bayar?>
                                      </td>
                                      <td><?php echo number_format($row->dana_masuk)?>,-</td>
                                      <td></td>
                                      <td>
                                        <?php 
                                          // $total
                                          $test = $this->db->get_where('keuangan_kas_kpr', array('id_ppjb'=>$row->id_psjb));
                                          // echo "<ul>";
                                          foreach($test->result() as $rows){
                                            echo "<li>".$rows->cara_pembayaran."-".$rows->nama_bank." ".$rows->tanggal_bayar." Rp. ".number_format($rows->pembayaran)."</li>";
                                          }
                                          // echo "</ul>";
                                        ?>
                                      </td>
                                      <td>
                                        <textarea style="height: 30px" name="ket[]"><?php echo $row->keterangan?></textarea> 
                                        <input type="hidden" value="<?php echo $row->id_psjb?>" name="id[]">
                                      </td>
                                  </tr>
                              <?php $no++;}}}
                        ?>
                      <?php }?>
                    </tbody>
                  </table>
                </form>
                <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog">
                  
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                      </div>
                      <div class="modal-body">
                        <p>Some text in the modal.</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                    
                  </div>
                </div>
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
</script>
<script>
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
      "responsive": false,
      "autoWidth": false,
      "scrollX": true,
      "scrollY": "300px",
      "sDom": '<"top"flp>rt<"bottom"i><"clear">'
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "scrollY": "300px",
      "sDom": '<"top"flp>rt<"bottom"i><"clear">'
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
