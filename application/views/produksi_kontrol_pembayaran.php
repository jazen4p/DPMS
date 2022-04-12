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
              Kontrol Pembayaran
              <?php if(isset($id)){
                  echo " - ".$id;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Kontrol Pembayaran</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col-sm-9">
                <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
            </div>
            <div class="col-sm-3">
                <button type="button" id="button" class="btn btn-flat btn-outline-info" data-toggle="modal" data-target="#exampleModal">Per Bangunan</button>
                <a href="#" class="btn btn-outline-primary btn-flat">PRINT</a>
            </div>
        </div>
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_kontrol_pembayaran_pembelian" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>Bulan</label>
                    <input type="month" class="form-control" value="<?php if(isset($tgl)){echo $tgl;} else { echo $tgl;}?>" name="bulan">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Toko Bangunan</label>
                    <select class="form-control" name="tk_bangunan">
                        <?php foreach($this->db->get_where('produksi_master_data', array('kategori'=>"toko"))->result() as $tk_b){
                            echo "<option ";
                            if(isset($tk_bangunan)){
                              if($tk_bangunan == $tk_b->nama_data){
                                  echo "selected";
                              }
                            }
                            echo " value='$tk_b->nama_data'>$tk_b->nama_data</option>";
                        }?>
                    </select>
                </div>
                <!-- <input placeholder="Tanggal Awal" value="<?php if(isset($tglmin)){echo $tglmin;}?>" name="tgl_awal" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date"> -->
              </div>
              <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
              <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
              <div class="col-md-12">
                <input type="hidden" value="<?php echo $id?>" name="id">
                <input type="submit" class="btn btn-info btn-flat" value="SEARCH" />
                <!-- <button type="button" id="thisPrint" class="btn btn-info btn-flat" style="">CETAK</button> -->
              </div>
            </div>
          </form>
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
                <div style="" class="row">
                    <div class="col-md-8">
                        TOKO BANGUNAN
                        <?php if(isset($tk_bangunan)){
                          
                          echo $tk_bangunan;
                        }?>
                    </div>
                    <div class="col-md-4">
                        BULAN
                        <?php if(isset($tgl)){
                          if($tgl == ""){
                            echo "ALL TIME";
                          } else {
                            echo date('F Y', strtotime($tgl));    
                          }
                        }?>
                    </div>
                </div>
                <form action="<?php echo base_url()?>Dashboard/edit_transaksi_perfaktur" method="POST">
                <table id="example2" class="table table-bordered" style="font-size: 12px">
                  <thead style="font-size: 11px">
                    <!-- <tr style="background-color: lightyellow; font-weight: bold">
                        <td colspan=14 style="text-align: center">TOTAL PEMBELIAN BAHAN BULAN <?php echo strtoupper(date('F Y', strtotime($tgl)))?> </td>
                        <td colspan=2><div id="total"></div></td>
                    </tr> -->
                    <tr>
                        <th rowspan=2>TANGGAL PEMBELIAN</th>
                        <th rowspan=2>JATUH TEMPO</th>
                        <th rowspan=2>NO FAKTUR</th>
                        <th rowspan=2>PEMBELIAN</th>
                        <th rowspan=2>QTY</th>
                        <th rowspan=2>SATUAN</th>
                        <th rowspan=2>HARGA SATUAN</th>
                        <th rowspan=2>TOTAL HARGA</th>
                        <th rowspan=2>JUMLAH/NOTA</th>
                        <th colspan=5 style="text-align: center">KONTROL PEMBAYARAN</th>
                        <!-- <th rowspan=2>KETERANGAN</th> -->
                        <th><input type="submit" value="Update" class="btn btn-sm btn-flat btn-success"></th>
                        <!-- <th>Status</th> -->
                        <!-- <th>Jmlh Diterima</th> -->
                        <!-- <th>Aksi</th> -->
                    </tr>
                    <tr>
                        <th>NOTA PINK/SURAT JALAN</th>
                        <th>NOTA PUTIH</th>
                        <th>NOTA PELUNASAN/TAGIHAN</th>
                        <th>TANGGAL PENGAJUAN</th>
                        <th>TANGGAL LUNAS</th>
                        <th>KETERANGAN</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // print_r($check_all->result());

                    $prev = null;
                    $count = 0;
                    foreach($check_all->result() as $row1){
                      $ts = $this->db->get_where('produksi_transaksi', array('no_faktur'=>$row1->no_faktur)); 
                      $total = 0;
                      foreach($ts->result() as $totals){
                        $total = $total + ($totals->qty*$totals->harga_satuan);
                      }
                      foreach($ts->result() as $row){
                      ?>
                      <tr>
                        <td><?php echo $row->tgl_pesan?></td>
                        <td><?php echo $row->tgl_deadline?></td>
                        <td><?php echo $row->no_faktur?></td>
                        <td><?php echo $row->nama_barang?></td>
                        <td><?php echo $row->qty?></td>
                        <td><?php echo $row->nama_satuan?></td>
                        <td><?php echo $row->harga_satuan?></td>
                        <td style="white-space: nowrap"><?php echo "Rp. ".number_format($row->qty*$row->harga_satuan)?></td>

                        <td><?php echo "Rp. ".number_format($total);?></td>

                        <!-- <form action="<?php echo base_url()?>Dashboard/edit_transaksi_perfaktur" method="POST"> -->
                          <td style="background-color: white">
                            <?php if($row->nota_putih != "0000-00-00"){
                              echo "<div>Sudah ada</div>"; 
                            }?>
                            <input type="date" name="notapink[]" value="<?php echo $row->nota_putih?>">
                          </td>
                          <td style="background-color: lightgreen">
                            <?php if($row->nota_pink != "0000-00-00"){
                              echo "<div>Sudah ada</div>"; 
                            }?>
                            <input type="date" name="notaputih[]" value="<?php echo $row->nota_pink?>">
                          </td>
                          <td style="background-color: lightgrey">
                            <?php if($row->nota_pelunasan != "0000-00-00"){
                              echo "<div>Sudah ada</div>"; 
                            }?>
                            <input type="date" name="notapelunasan[]" value="<?php echo $row->nota_pelunasan?>">
                          </td>
                          <td style="background-color: yellow">
                            <?php if($row->tgl_pengajuan != "0000-00-00"){
                              echo "<div>Sudah ada</div>"; 
                            }?>
                            <input type="date" name="tglpengajuan[]" value="<?php echo $row->tgl_pengajuan?>">
                          </td>
                          <td style="background-color: lightblue">
                            <?php if($row->tgl_lunas != "0000-00-00"){
                              echo "<div>LUNAS</div>"; 
                            }?>
                            <input type="date" name="tgllunas[]" value="<?php echo $row->tgl_lunas?>">
                          </td>
                          <td>
                            <textarea name="keterangan[]"><?php echo $row->keterangan?></textarea>
                            <input type="hidden" value="<?php echo $tgl?>" name="bulan">
                            <input type="hidden" value="<?php echo $tk_bangunan?>" name="tk_bangunan">
                            <input type="hidden" value="<?php echo $id?>" name="id">
                            <input type="hidden" value="<?php echo $row->id_prod?>" name="id_prod[]">
                          </td>
                          <!-- <td>
                            <input type="submit" value="Update" class="btn btn-success btn-sm btn-flat">
                          </td> -->
                      </tr>
                      <?php }}?>
                    </form>
                  </tfoot>
                </table>
                
                <!-- <input type="hidden" value="<?php echo number_format($total)?>" id="totalAll" > -->
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Per Toko Bangunan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="example2" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Toko Bangunan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $tl_tk = 0; $tl = 0;
                    foreach($this->db->get_where('produksi_master_data', array('kategori'=>"toko"))->result() as $tk){
                      $tst = $this->Dashboard_model->rincian_pembelian_tk($id, date('Y-m', strtotime($tgl)), $tk->nama_data);
                      // print_r($tst);
                      ?>
                      <?php if($tst->num_rows()>0){?>
                      <tr style="background-color: orange">
                          <td><?php echo $tk->nama_data?></td>
                          <?php 
                          if($tst->num_rows() > 0){
                            foreach($tst->result() as $rc){?>
                              <td style="background-color: orange"><?php echo "Rp. ".number_format($rc->total)?></td>
                          <?php $tl_tk = $tl_tk + $rc->total;}} else {
                            echo "<td>Rp. 0</td>"; 
                          }?>
                      </tr>
                    <?php } else {?>
                      <tr style="">
                        <td><?php echo $tk->nama_data?></td>
                        <?php 
                        if($tst->num_rows() > 0){
                          foreach($tst->result() as $rc){?>
                            <td style="background-color: orange"><?php echo "Rp. ".number_format($rc->total)?></td>
                        <?php $tl_tk = $tl_tk + $rc->total;}} else {
                          echo "<td>Rp. 0</td>"; 
                        }?>
                    </tr>
                    <?php }}?>
                <tr style="background-color: lightyellow; font-weight: bold">
                    <td><?php echo "TOTAL KESELURUHAN"?></td>
                    <td><?php echo "Rp. ".number_format($tl_tk)?></td>
                </tr>
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
<!-- ./wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
    });
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "scrollY": "500px",
      fixedColumns:   {
        leftColumns: 4,
      },
      fixedHeader: true
    });
    
  });

</script>
<script type="text/javascript">
  $(function () {
    $("#date").datepicker();
    $("#checkout").datepicker();
  });

  $(document).ready(function(){
    $('#thisPrint').on('click', function(){
      window.print();
    })
  })

  $(document).ready(function(){
    var check = $('#totalAll').val();

    $('#total').html("Rp. "+check);
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
