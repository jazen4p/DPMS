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
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">
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
            <h1>
                Rekap Tagihan Piutang    - 
                <?php if(isset($kode_perumahan)){?>
                    <?php echo $kode_perumahan?>
                <?php } else {?>
                    All
                <?php }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <div class="breadcrumb float-sm-right">
                Bulan: <?php echo date("F Y", strtotime($bulan));?>
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
            <div style="text-align: right">
              <a target="_blank" href="<?php echo base_url()?>Dashboard/kontrol_piutang_print?id=<?php echo $bulan?>&kode=<?php echo $kode?>" class="btn btn-outline-primary btn-flat">PRINT</a>
            </div>
            <hr/>

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
                <form action="<?php echo base_url()?>Dashboard/filter_kontrol_piutang" method="POST">
                  <div id="wrapper" class="row" style="">
                    <div class="col-md-6 form-group">
                      <label>Bulan:</label>
                      <input type="month" class="form-control" name="tanggal" value="<?php echo $bulan?>">
                    </div>
                    <div class="col-md-6 form-group">
                      <label>Perumahan:</label>
                      <select name="perumahan" class="form-control">
                        <option value="">Semua</option>
                        <?php foreach($this->db->get('perumahan')->result() as $perumahan){
                          echo "<option ";
                          if($kode == $perumahan->kode_perumahan){
                            echo "selected";
                          }
                          echo " value='$perumahan->kode_perumahan'>$perumahan->nama_perumahan</option>";
                        }?>
                      </select>
                    </div>

                    <input type="submit" class="btn btn-info btn-flat btn-sm" value="SEARCH">
                  </div> <br>
                </form> 
                <table id="example1" class="table table-bordered table-striped" style="font-size: 14px">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Konsumen</th>
                      <th>Unit</th>
                      <th>Tgl Bayar</th>
                      <th>Tahap Pembayaran</th>
                      <th>Tagihan Bulan Ini</th>
                      <th>Total Tagihan</th>
                      <th>Pembayaran diterima</th>
                      <th><?php echo "<30 hari";?></th>
                      <th>31-60 hari</th>
                      <th>61-90 hari</th>
                      <th>>90 hari</th>
                      <!-- <th>Total Piutang</th> -->
                      <th>Sisa</th>
                      <th>Persentase</th>
                    </tr>
                  </thead>
                  <tbody style="white-space: nowrap">
                    <?php $no=1; foreach($ppjb as $row){?>
                    <tr>
                        <td><?php echo $no?></td>
                        <td><a href="<?php echo base_url()?>Dashboard/view_transaksi?id=<?php echo $row->no_psjb?>&kode=<?php echo $row->kode_perumahan?>"><?php echo $row->nama_pemesan?></a></td>
                        <td>
                            <?php echo $row->no_kavling?>
                            <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $row2){
                                echo ", ".$row2->kode_rumah;
                            }?>
                        </td>
                        
                        <?php
                            $query = $this->db->query("SELECT * FROM `ppjb-dp` WHERE no_psjb = '$row->no_psjb' AND status='lunas' ORDER BY id_psjb DESC LIMIT 1")->result();
                            // print_r($query);
                            // $penerimaan_biaya = 0;
                            $query2 = $this->db->query("SELECT * FROM `ppjb-dp` WHERE no_psjb = '$row->no_psjb' AND status='lunas'")->result();
                            foreach($query2 as $ppjb){
                                // $penerimaan_biaya = $penerimaan_biaya + $ppjb->dana_masuk;
                            }

                            foreach($query as $psjb){

                            // if($row->status=="belum lunas"){
                            //     $no_ppjb = $row->no_psjb;
                            //     $id_ppjb = $row->id_psjb;
                
                            //     $interval = strtotime($tanggal_masuk) - strtotime($today);
                            //     $day = floor($interval / 86400); // 1 day
                            //     if($day >= 1 && $day <= 7) {
                            //         $data['mendekati']++;
                            //     } elseif($day < 0) {
                            //         $data['melewati']++;
                            //     } elseif($day == 0) {
                            //         $data['hari_ini']++;
                            //     }
                            // }
                            // $time=strtotime($row->tanggal_dana);
                            // $month=date("m",$time);
                            // $year=date("Y",$time);
                
                            // $todays = strtotime($today) - strtotime($tanggal_masuk);
                
                            // $data['melewati'] = array(
                            //     'today'=>strtotime($today),
                            //     'tanggal_masuk'=>strtotime($tanggal_masuk),
                            //     'todays'=>$todays
                            // );

                            // $query = $this->db->get_where('');
                            $query3 = $this->db->query("SELECT * FROM `keuangan_kas_kpr` WHERE no_ppjb = $row->no_psjb ORDER BY id_keuangan DESC LIMIT 1");
                            foreach($query3->result() as $kas){
                              $tgl_kas = $kas->tanggal_bayar;
                            }

                            // $test = $this->db->get_where('psjb-dp', array('no_psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'DATE_FORMAT(tanggal_dana, "%Y-%m")'=>date("Y-m", strtotime($bulan))));
                            
                            $test = $this->Dashboard_model->get_data($row->no_psjb, $row->kode_perumahan, "Uang Tanda Jadi", "KPR", $bulan);
                            // print_r($test->num_rows());
                            // echo $bulan;
                            
                            $ts = 0; $tls=0; $tls1 = 0;
                            $gets = $this->Dashboard_model->kontrol_piutang($row->no_psjb, $row->kode_perumahan, $bulan);
                            // print_r($gets->result());
                            foreach($gets->result() as $gts){
                              $tls = $tls + $gts->dana_masuk;
                            }

                            $var = $this->Dashboard_model->kontrol_piutang_bayar($row->no_psjb, $row->kode_perumahan, $bulan);
                            foreach($var->result() as $gts1){
                              $tls1 = $tls1 + $gts1->pembayaran;
                            }

                            $ts = $ts + ($tls-$tls1);
                            // print_r($tls);

                            $tl = 0;
                            foreach($this->db->get_where('keuangan_kas_kpr', array('no_ppjb'=>$row->no_psjb, 'tahap <>'=>"KPR", 'kode_perumahan'=>$row->kode_perumahan))->result() as $ks){
                              if(date('Y-m', strtotime($ks->tanggal_bayar)) == date('Y-m', strtotime($bulan))){
                                $tl = $tl + $ks->pembayaran;
                              }
                            }

                            if($test->num_rows() == 0){
                              // echo "<td></td>";
                              echo "<td>-</td><td>-</td><td>-</td><td>".number_format($ts)."</td><td>";
                              echo number_format($tl)."</td>";
                            }
                            else {

                              foreach($test->result() as $test1){
                              
                                $tanggal_masuk = $test1->tanggal_dana;
  
                                $joined = date("Y-m", strtotime($tanggal_masuk));
  
                                $monthyear = $bulan; 
  
                                
                                
                                // if($test1)
                                echo "<td>".$test1->tanggal_dana."</td>";
                                echo "<td>";
                                $query = $this->db->get_where('ppjb-dp', array('no_psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'status'=>"belum lunas"), 1, 0)->result();
                                // print_r($query);
                                foreach($query as $dp) {
                                  if($dp->cara_bayar != "Pembayaran DP (0%)" && $monthyear > date("Y-m", strtotime($dp->tanggal_dana))){
                                    echo $dp->cara_bayar." - ";
                                }}
                                echo $test1->cara_bayar;
                                echo "</td>";

                                echo "<td>".number_format($test1->dana_masuk)."</td>";
                                echo "<td>".number_format($test1->dana_masuk + $ts).",-"."</td>";

                                $tl = 0;
                                // $penerimaan_biaya = 0;
                                foreach($this->db->get_where('keuangan_kas_kpr', array('no_ppjb'=>$row->no_psjb, 'tahap <>'=>"KPR", 'kode_perumahan'=>$row->kode_perumahan))->result() as $ks){
                                  if(date('Y-m', strtotime($ks->tanggal_bayar)) == date('Y-m', strtotime($bulan))){
                                    $tl = $tl + $ks->pembayaran;
                                  }
                                  // $penerimaan_biaya = $penerimaan_biaya + $ks->pembayaran;
                                }
                                echo "<td>".number_format($tl).",-</td>";
                                // echo "<td>".number_format($test1->dana_bayar).",-"."</td>";
                                
                                // if($test1->cara_bayar!="Uang Tanda Jadi" && $test1->cara_bayar!="KPR") {
                                //   if ($joined == $monthyear) {
                                //     $query = $this->db->get_where('ppjb', array('no_psjb'=>$test1->no_ppjb))->result();
                                //     foreach($query as $row2) {
                                //       ?>
                                       <!-- <td><?php echo $test1->tanggal_dana?></td>
                                //       <td style="white-space: nowrap">
                                //         <?php 
                                //           foreach($this->db->get_where('ppjb-dp', array('no_ppjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'status'=>"belum lunas"), 1, 0)-> result() as $dp) {
                                //             if($monthyear > date("Y-m", strtotime($dp->tanggal_dana))){
                                //               echo $dp->cara_bayar." - ";
                                //           }}
                                //           echo $test1->cara_bayar;
                                //         ?>
                                //       </td>
                                //       <td><?php echo number_format($test1->dana_masuk).",-";?></td>
                                //       <td><?php echo number_format($test1->dana_bayar).",-";?></td> -->
                                   <?php 
                                //     } 
                                //   } 
                                // }
                                // print_r($test);
                                  // echo "<td></td><td></td><td></td><td></td>";
                              }
                            }
                            // print_r($tgl_kas);
                        ?>
                            <!-- <td>
                                <?php if($query3->num_rows() > 0){ 
                                    echo date('d', strtotime($kas->tanggal_bayar)); 
                                } else { 
                                    echo date('d', strtotime($psjb->tanggal_dana));
                                }?>
                            </td>
                            <td>
                                <?php if($query3->num_rows() > 0){ 
                                    echo $kas->tahap; 
                                } else { 
                                    echo $psjb->cara_bayar;
                                }?>
                            </td>
                            <td><?php echo number_format($row->total_jual)?>,-</td> -->
                            <!-- <td><?php echo number_format($penerimaan_biaya)?>,-</td> -->
                            <?php 
                                $query4 = $this->db->query("SELECT * FROM `ppjb-dp` WHERE no_psjb = '$row->no_psjb' AND kode_perumahan = '$row->kode_perumahan' AND cara_bayar <> 'KPR' AND cara_bayar <> 'Uang Tanda Jadi'")->result();
                                // print_r($query4);
                                $hari30 = 0;
                                $hari60 = 0;
                                $hari90 = 0;
                                $hari90lbh = 0;
                                $today = $bulan;
                                // print_r($query4);
                                foreach($query4 as $row3){

                                    $interval = strtotime($row3->tanggal_dana) - strtotime($today);
                                    $day = floor($interval / 86400); // 1 day
                                    // echo $day." ";
                                    if($day < 0 && $day >= -30) {
                                        // $data['mendekati']++;
                                        $hari30 = $hari30 + $row3->dana_masuk;
                                    } elseif($day < -30 && $day >= -60) {
                                        // $data['melewati']++;
                                        $hari60 = $hari60 + $row3->dana_masuk;
                                    } elseif($day < -60 && $day >= -89) {
                                        // $data['hari_ini']++;
                                        $hari90 = $hari90 + $row3->dana_masuk;
                                    } elseif($day <= -90){
                                        $hari90lbh = $hari90lbh + $row3->dana_masuk;
                                    }
                                }

                                // if($hari90lbh > 0){
                                //     $hari90lbh = $hari90lbh + $hari30 + $hari60 + $hari90;
                                //     $hari30 = 0;
                                //     $hari60 = 0;
                                //     $hari90 = 0;
                                // } else if($hari90 > 0){
                                //     $hari90 = $hari90 + $hari30 + $hari60;
                                //     $hari30 = 0;
                                //     $hari60 = 0;
                                //     $hari90lbh = 0;
                                // } else if($hari60 > 0){
                                //     $hari60 = $hari60 + $hari30;
                                //     $hari30 = 0;
                                //     $hari90 = 0;
                                //     $hari90lbh = 0;
                                // } else {
                                //     $hari30 = $hari30;
                                //     $hari60 = 0;
                                //     $hari90 = 0;
                                //     $hari90lbh = 0;
                                // }
                                // echo $hari30." ".$hari60." ".$hari90." ".$hari90lbh;
                                $total_piutang = $hari30+$hari60+$hari90+$hari90lbh;
                            ?>
                            <td><?php echo number_format($hari30)?>,-</td>
                            <td><?php echo number_format($hari60)?>,-</td>
                            <td><?php echo number_format($hari90)?>,-</td>
                            <td><?php echo number_format($hari90lbh)?>,-</td>
                            <!-- <td>Rp. <?php echo number_format($total_piutang)?>,-</td> -->
                            <?php $penerimaan = 0;
                                
                            $keuangan = $this->db->get_where('keuangan_kas_kpr', array('no_ppjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, "tahap <>"=>"KPR"));
                            foreach($keuangan->result() as $keuangan){
                              $penerimaan = $penerimaan + $keuangan->pembayaran;
                            } ?>

                            <td><?php echo number_format($row->total_jual-$row->uang_awal-$penerimaan)?>,-</td>
                            <td><?php echo number_format((($penerimaan)/($row->total_jual-$row->uang_awal))*100, 2)?> %</td>
                            <!-- <td></td><td></td><td></td><td></td> -->
                        <?php }?>
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
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js"></script>
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
      "scrollX": true,
      "scrollY": "500px",
      fixedColumns:   {
        leftColumns: 8,
      },
      fixedHeader: true
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
