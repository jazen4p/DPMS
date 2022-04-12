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
            <h1>Transaksi Kas & KPR - 
            <?php echo $kode;?>
            </h1>
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
                <!-- <div style="text-align: center">
                  <form action="<?php echo base_url()?>Dashboard/filter_tipe_pembayaran_keuangan" method="post">
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
                  <?php }?>
                </div> -->
                <table id="example1" class="table table-bordered table-striped" style="font-size: 14px">
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
                      <th>Pilihan Proses</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // echo date('Y-m-d', strtotime('+7 days')); 
                    $no=1; 
                    if($id == "a"){
                        foreach($this->db->get('ppjb')->result() as $row){
                            $test = $this->Dashboard_model->bulletin_dashboard_mendekati($row->no_psjb, $kode);
                            // print_r($test->result());
                            foreach($test->result() as $row2){
                                foreach($this->db->get_where('ppjb', array('no_psjb'=>$row2->no_psjb, 'kode_perumahan'=>$row2->kode_perumahan))->result() as $row){?>
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
                                    
                                    <?php $temp=0; foreach($this->db->get_where('ppjb-dp', array('no_ppjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as $dp){?>
                                    <!-- <?php $temp=$temp+$dp->dana_bayar?> -->
                                    <?php }?>
                                    
                                    <td>Rp. <?php echo number_format($temp);?>,-</td>
                                    <td>Rp. <?php echo number_format($row->total_jual-$temp);?>,-</td>
                                    <td><?php echo number_format(($temp/$row->total_jual)*100, 1)?> %</td>
        
                                    <?php if($row->status == "dom"){?>
                                        <td><a href="<?php echo base_url()?>Dashboard/view_transaksi?id=<?php echo $row->no_psjb?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-sm btn-primary">Transaksi</a></td>
                                    <?php } else if($row->status=="menunggu"){?>
                                        <td><span>Proses Pembatalan</span></td>
                                    <?php } else {?>
                                        <td><span><i>Dibatalkan</i></span></td>
                                    <?php }?>
                                </tr>
                            <?php
                            }$no++;}
                        }
                    } else if($id == "b"){
                        foreach($this->db->get('ppjb')->result() as $row){
                            $test = $this->Dashboard_model->bulletin_dashboard_hariini($row->no_psjb, $kode);
                            // print_r($test->result());
                            foreach($test->result() as $row2){
                                foreach($this->db->get_where('ppjb', array('no_psjb'=>$row2->no_psjb, 'kode_perumahan'=>$row2->kode_perumahan))->result() as $row){?>
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
                                    
                                    <?php $temp=0; foreach($this->db->get_where('ppjb-dp', array('no_ppjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as $dp){?>
                                    <!-- <?php $temp=$temp+$dp->dana_bayar?> -->
                                    <?php }?>
                                    
                                    <td>Rp. <?php echo number_format($temp);?>,-</td>
                                    <td>Rp. <?php echo number_format($row->total_jual-$temp);?>,-</td>
                                    <td><?php echo number_format(($temp/$row->total_jual)*100, 1)?> %</td>
        
                                    <?php if($row->status == "dom"){?>
                                        <td><a href="<?php echo base_url()?>Dashboard/view_transaksi?id=<?php echo $row->no_psjb?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-sm btn-primary">Transaksi</a></td>
                                    <?php } else if($row->status=="menunggu"){?>
                                        <td><span>Proses Pembatalan</span></td>
                                    <?php } else {?>
                                        <td><span><i>Dibatalkan</i></span></td>
                                    <?php }?>
                                </tr>
                            <?php
                            }$no++;}
                        }
                    } else {
                        foreach($this->db->get('ppjb')->result() as $row){
                            $test = $this->Dashboard_model->bulletin_dashboard_melewati($row->no_psjb, $kode);
                            // print_r($test->num_rows());
                            foreach($test->result() as $row2){
                                foreach($this->db->get_where('ppjb', array('no_psjb'=>$row2->no_psjb, 'kode_perumahan'=>$row2->kode_perumahan))->result() as $row){?>
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
                                    
                                    <?php $temp=0; foreach($this->db->get_where('ppjb-dp', array('no_ppjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as $dp){?>
                                    <!-- <?php $temp=$temp+$dp->dana_bayar?> -->
                                    <?php }?>
                                    
                                    <td>Rp. <?php echo number_format($temp);?>,-</td>
                                    <td>Rp. <?php echo number_format($row->total_jual-$temp);?>,-</td>
                                    <td><?php echo number_format(($temp/$row->total_jual)*100, 1)?> %</td>
        
                                    <?php if($row->status == "dom"){?>
                                        <td><a href="<?php echo base_url()?>Dashboard/view_transaksi?id=<?php echo $row->no_psjb?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-sm btn-primary">Transaksi</a></td>
                                    <?php } else if($row->status=="menunggu"){?>
                                        <td><span>Proses Pembatalan</span></td>
                                    <?php } else {?>
                                        <td><span><i>Dibatalkan</i></span></td>
                                    <?php }?>
                                </tr>
                            <?php
                            }$no++;}
                        }
                    }
                    ?>
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
