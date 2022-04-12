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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
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
              Stok Bahan
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Stok Bahan</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
            <div id="wrapper">
              <form action="<?php echo base_url()?>Dashboard/filter_stok" method="POST">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Bulan</label>
                      <input type="month" class="form-control" name="bulan" value="<?php if(isset($tgl)){echo $tgl;}?>"> 
                    </div>
                  </div>
                  <div class="col-md-6">

                  </div>
                  <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
                  <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
                  <div class="col-md-12">
                    <input type="hidden" value="<?php echo $kode_perumahan?>" name="id">
                    <input type="submit" class="btn btn-info btn-flat" value="SEARCH" />
                    <button type="button" id="thisPrint" class="btn btn-info btn-flat" style="">CETAK</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a class="btn btn-flat btn-outline-primary" href="<?php echo base_url()?>Dashboard/print_stok_bahan?id=<?php echo $kode_perumahan?>&bln=<?php echo date('Y-m-d', strtotime($tgl))?>" target="_blank">PRINT</a>
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

            <!-- <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <form action="<?php echo base_url()?>Dashboard/add_neraca_saldo" method="POST">
                        <div class="form-group row">
                            <label class="col-sm-2">Perumahan</label>
                            <select name="kode_perumahan" class="form-control col-sm-10" required>
                                <option value="" disabled selected>-Pilih-</option>
                                <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                                    <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                                <?php }?>
                            </select>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <?php if(isset($succ_msg)){
                    echo "<span style='color: green'>".$succ_msg."</span>";
                } if(isset($err_msg)){
                    echo "<span style='color: red'>".$err_msg."</span>";   
                }?>
                <input type="submit" class="btn btn-success btn-sm" value="Tambah">
              </div>
            </div> -->
            <div class="card">
                <div class="card-header row">
                    <!-- <a href="<?php echo base_url()?>Dashboard/kode_pengeluaran" class="btn btn-outline-success btn-sm btn-flat">Kembali</a> -->
                    <div class="col-md-9">
                      <a href="<?php echo base_url()?>Dashboard/view_check_stock_akhir_bulan?id=<?php echo $kode_perumahan?>" class="btn btn-outline-info btn-flat">Cek Stok Akhir Bulan</a>
                    </div>
                    <div class="col-md-3">
                      <!-- <button type="button"  class="btn btn-outline-primary btn-flat" data-toggle="modal" data-target="#exampleModal">Masuk</button>
                      <button type="button"  class="btn btn-outline-primary btn-flat" data-toggle="modal" data-target="#exampleModal1">Keluar</button> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12">
                    </div>
                    <div class="col-12">
                        <div style="text-align: center; font-size: 12px">
                            <h6><b>REKAP PERSEDIAAN BAHAN DI LAPANGAN</b></h6>
                            <h6>PEMBANGUNAN UNIT <?php echo strtoupper($nama_perumahan)?> RESIDENCE</h6>
                            <h6>PERIODE <?php echo date('1 F', strtotime($tgl))." - ".date('t F Y', strtotime($tgl))?> </h6>
                        </div>
                        <?php $ttl_date = date('t', strtotime($tgl));?>
                        <table id="example2" class="table" border=1 style="font-size: 12px">
                            <thead>
                                <tr style="background-color: lightblue">
                                  <th rowspan=2>No</th>
                                  <th rowspan=2>Nama Bahan</th>
                                  <th colspan=2>Persediaan Bahan Per <?php echo date('1 F', strtotime($tgl))?></th>
                                  <th colspan=2>Sisa Bahan Dari Sistem</th>
                                  <th colspan=2>Cek Bahan Per <?php echo date('t F', strtotime($tgl))?></th>
                                  <th rowspan=2>Selisih</th>
                                  <th style="text-align: center; background-color: lightgreen" colspan=<?php echo (int)$ttl_date?>>BAHAN MASUK</th>
                                  <th style="text-align: center; background-color: pink" colspan=<?php echo (int)$ttl_date?>>BAHAN KELUAR</th>
                                  <th rowspan=2>Total Bahan Masuk</th>
                                  <th rowspan=2>Total Bahan Keluar</th>
                                </tr>
                                <tr style="background-color: lightblue">
                                  <th>QTY</th>
                                  <th>SAT</th>
                                  <th>QTY</th>
                                  <th>SAT</th>
                                  <th>QTY</th>
                                  <th>SAT</th>
                                  <?php for($i = 1; $i <= (int)$ttl_date; $i++){?>
                                    <th style="background-color: lightgreen"><?php echo $i;?></th>
                                  <?php }?>
                                  <?php for($i = 1; $i <= (int)$ttl_date; $i++){?>
                                    <th style="background-color: pink"><?php echo $i;?></th>
                                  <?php }?>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $no=1; foreach($brg->result() as $row){?>
                                <tr>
                                  <td><?php echo $no?></td>
                                  <td style="white-space: nowrap"><?php echo $row->nama_data?></td>
                                  <?php $stss = 0;
                                  // echo $dt;
                                  // print_r($this->Dashboard_model->cek_stok_akhir_bulan($row->nama_data, $kode_perumahan, $dt)->result());
                                  if($this->Dashboard_model->cek_stok_akhir_bulan($row->nama_data, $kode_perumahan, $dt)->num_rows() > 0){
                                  foreach($this->Dashboard_model->cek_stok_akhir_bulan($row->nama_data, $kode_perumahan, $dt)->result() as $sts){?>
                                    <td><?php echo $sts->stok;
                                      $stss = $stss + $sts->stok;
                                    ?></td>
                                    <td><?php echo $sts->nama_satuan?></td>
                                  <?php }} else {?>
                                    <td>0</td>
                                    <td><?php echo $row->nama_satuan?></td>
                                  <?php }?>

                                  <?php $sisa = 0; $s_msk = 0; $s_keluar = 0;
                                  $sisa = $sisa + $stss;
                                  // print_r($this->Dashboard_model->get_arus_stok($row->nama_data, $kode_perumahan, $tgl, "keluar")->result());
                                  foreach($this->Dashboard_model->get_arus_stok($row->nama_data, $kode_perumahan, $tgl, "masuk")->result() as $arus){
                                    $sisa = $sisa + $arus->qty;
                                  }
                                  // echo "<td>".$sisa."</td>";
                                  foreach($this->Dashboard_model->get_arus_stok($row->nama_data, $kode_perumahan, $tgl, "keluar")->result() as $arus1){
                                    $sisa = $sisa - $arus1->qty;
                                  }?>
                                  <td><?php echo $sisa;?></td>
                                  <td><?php echo $row->nama_satuan?></td>
                                  <?php $str = 0;
                                  if($this->Dashboard_model->cek_stok_akhir_bulan($row->nama_data, $kode_perumahan, $tgl)->num_rows() > 0){
                                  foreach($this->Dashboard_model->cek_stok_akhir_bulan($row->nama_data, $kode_perumahan, $tgl)->result() as $st){?>
                                    <td><?php echo $st->stok;
                                      $str = $str + $st->stok;
                                    ?></td>
                                    <td><?php echo $st->nama_satuan?></td>
                                  <?php }} else {?>
                                    <td>0</td>
                                    <td><?php echo $row->nama_satuan?></td>
                                  <?php }?>
                                  <td><?php echo $str - $sisa?></td>

                                  <?php $total_all = 0; 
                                  for($i = 1; $i <= (int)$ttl_date; $i++){
                                    $ht = date("Y-m-".sprintf('%02d', $i), strtotime($tgl)); $total_msk = 0;
                                    // print_r($this->db->get_where('logistik_arus_stok', array('nama_barang'=>$row->nama_data, 'kode_perumahan'=>$kode_perumahan, 'jenis_arus'=>"masuk"))->result());
                                    foreach($this->db->get_where('logistik_arus_stok', array('nama_barang'=>$row->nama_data, 'kode_perumahan'=>$kode_perumahan, 'jenis_arus'=>"masuk"))->result() as $ar){
                                      // echo $ar->tgl_arus."<br>";
                                      if(date('Y-m-d', strtotime($ar->tgl_arus)) == $ht){
                                        $total_msk = $total_msk + $ar->qty;
                                      }
                                    }
                                    $total_all = $total_all + $total_msk;
                                    ?>
                                    <?php if($total_msk > 0){?>
                                      <td style="background-color: yellow"><?php echo $total_msk;?></td>
                                    <?php } else {?>
                                      <td style="background-color: lightgreen"></td>
                                    <?php }?>
                                  <?php }?>

                                  <?php $total_all1 = 0;
                                  for($i = 1; $i <= (int)$ttl_date; $i++){
                                    $ht = date("Y-m-".sprintf('%02d', $i), strtotime($tgl)); $total_msk = 0;
                                    foreach($this->db->get_where('logistik_arus_stok', array('nama_barang'=>$row->nama_data, 'kode_perumahan'=>$kode_perumahan, 'jenis_arus'=>"keluar"))->result() as $ar1){
                                      if(date('Y-m-d', strtotime($ar1->tgl_arus)) == $ht){
                                        $total_msk = $total_msk + $ar1->qty;
                                      }
                                    }
                                    $total_all1 = $total_all1 + $total_msk;
                                    ?>
                                    <?php if($total_msk > 0){?>
                                      <td style="background-color: yellow"><?php echo $total_msk;?></td>
                                    <?php } else {?>
                                      <td style="background-color: pink"></td>
                                    <?php }?>
                                  <?php }?>
                                  <td><?php echo $total_all?></td>
                                  <td><?php echo $total_all1?></td>
                                </tr>
                              <?php $no++;}?>
                            </tbody>
                        </table> 
                    </div>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail POS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $ttl_date = date('t', strtotime($tgl));?>
        <table class="" border=1 style="font-size: 14px; width: 100%">
          <thead>
            <tr style="text-align: center">
              <th colspan=<?php echo (int)$ttl_date;?>>BAHAN MASUK</th>
            </tr>
            <tr>
              <?php for($i = 1; $i <= (int)$ttl_date; $i++){?>
                <th><?php echo $i;?></th>
              <?php }?>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail POS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div style="text-align: center">Debet</div>
          </div>
          <div class="col-md-6">
            <div style="text-align: center">Kredit</div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

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
      "scrollX": true
    });
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollCollapse": true,
      "scrollX": true,
      "scrollY": "500px",
      fixedColumns:   {
        leftColumns: 8,
      },
      fixedHeader: true
    });
  });

  // $(document).ready(function() {
  //   var table = $('#example2').DataTable( {
  //       ordering: true,
  //       // info: true,
  //       // scrollY:        "300px",
  //       scrollX:        true,
  //       // scrollCollapse: true,
  //       paging:         false,
  //       fixedColumns:   {
  //         leftColumns: 2,
  //       }
  //   } );
  // } );
</script>
<script>
  $(function () {
    $("#date").datepicker();
    $("#checkout").datepicker();
  });

  $(document).ready(function(){
    $('#thisPrint').on('click', function(){
      window.print();
    })
  })

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
