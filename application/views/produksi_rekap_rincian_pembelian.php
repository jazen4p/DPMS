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
              Rekap Rincian Pembelian
              <?php if(isset($perumahan)){
                  echo " - ".$perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Rekap Rincian Pembelian</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col-sm-9">
                <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
            </div>
            <div class="col-sm-3">
                <button type="button" id="button" class="btn btn-flat btn-outline-info" data-toggle="modal" data-target="#exampleModal">Per Bangunan</button>
                <a href="<?php echo base_url()?>Dashboard/print_rekap_rincian?id=<?php echo $id?>&bln=<?php echo $tgl?>" class="btn btn-outline-primary btn-flat" target="_blank">PRINT</a>
            </div>
            <!-- <form action="<?php echo base_url()?>Dashboard/print_rekap_rincian" method="POST" class="col-sm-1">
              <input type="hidden" value="<?php echo $id?>" name="id">
              <input type="hidden" value="<?php echo $tgl?>" name="bln">

              <input type="submit" value="PRINT" class="btn btn-outline-primary btn-flat">
            </form> -->
        </div>
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_rekap_rincian_pembelian" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>Date</label>
                    <input type="month" class="form-control" value="<?php if(isset($tgl)){echo $tgl;}?>" name="bulan">
                </div>
              </div>
              <div class="col-md-6">
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
                <div style="text-align: center">
                  <span style="font-weight: bold">Proyek <?php echo $nama_perumahan?> Residence</span><br>
                  Rekap Pembelian Bahan
                  Bulan <?php echo date('F Y', strtotime($tgl))?> <br><br>
                </div>
                <table id="example2" class="table table-bordered table-striped" style="font-size: 13px">
                  <thead>
                    <tr style="background-color: lightyellow; font-weight: bold">
                        <td colspan=10 style="text-align: center">TOTAL PEMBELIAN BAHAN BULAN <?php echo strtoupper(date('F Y', strtotime($tgl)))?> </td>
                        <td colspan=2><div id="total"></div></td>
                    </tr>
                    <tr>
                        <th rowspan=2>No</th>
                        <th rowspan=2>Nama Bahan</th>
                        <th colspan=5>Pembelian Minggu Ke</th>
                        <th rowspan=2>Total Pembelian</th>
                        <th rowspan=2>Satuan</th>
                        <th rowspan=2>Harga Satuan</th>
                        <th rowspan=2>Total Harga</th>
                        <th rowspan=2>Toko Bangunan</th>
                        <!-- <th>Status</th> -->
                        <!-- <th>Jmlh Diterima</th> -->
                        <!-- <th>Aksi</th> -->
                    </tr>
                    <tr>
                      <th><?php echo $week?></th>
                      <th><?php echo $week+1?></th>
                      <th><?php echo $week+2?></th>
                      <th><?php echo $week+3?></th>
                      <th><?php echo $week+4?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; $total = 0;
                      // $query = $this->db->get('produksi_transaksi');
                      // $query = $this->Dashboard_model->
                    //   $test = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"));
                    //   foreach($test->result() as $tests){
                    //     foreach($this->db->get_where('produksi_master_data', array('kategori'=>"toko"))->result() as $tst_tk){
                    //       foreach($this->Dashboard_model->get_rekap_rincian_pembelian($tgl, $id)->result() as $row1){
                    //         if($row1->nama_barang == $tests->nama_data && $row1->nama_toko == $tst_tk->nama_data){?>
                            <!-- <tr>
                    //           <td><?php echo $no;?></td>
                    //           <td><?php echo $row1->nama_barang?></td>
                    //         </tr> -->
                    <?php 
                    // }}}$no++;}

                      foreach($querys->result() as $row){
                        
                    ?>
                      <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $row->nama_barang;?></td>
                        <?php 
                        $w_qty1 = 0;$w_qty2 = 0;$w_qty3 = 0;$w_qty4 = 0;$w_qty5 = 0;
                        foreach($this->db->get_where('produksi_transaksi', array('nama_barang'=>$row->nama_barang, 'nama_toko'=>$row->nama_toko, 'kode_perumahan'=>$row->kode_perumahan))->result() as $w_ttl){
                          if($w_ttl->week_num == $week){
                            $w_qty1 = $w_qty1 + $w_ttl->qty;
                          } else if($w_ttl->week_num == $week+1){
                            $w_qty2 = $w_qty2 + $w_ttl->qty;                  
                          } else if($w_ttl->week_num == $week+2){
                            $w_qty3 = $w_qty3 + $w_ttl->qty;
                          } else if($w_ttl->week_num == $week+3){
                            $w_qty4 = $w_qty4 + $w_ttl->qty;
                          } else if($w_ttl->week_num == $week+4) {
                            $w_qty5 = $w_qty5 + $w_ttl->qty;
                          }
                          
                        }
                        // echo "<td>$w_qty4</td>";
                        // if($querys->num_rows() > 0){

                        // } else {
                        //   "<td></td><td></td><td></td><td></td><td></td>";
                        // }
                        if($w_qty1 == 0){
                          echo "<td></td>";
                        }else {
                          echo "<td>$w_qty1</td>";
                        }

                        if($w_qty2 == 0){
                          echo "<td></td>";
                        }else {
                          echo "<td>$w_qty2</td>";
                        }

                        if($w_qty3 == 0){
                          echo "<td></td>";
                        }else {
                          echo "<td>$w_qty3</td>";
                        }

                        if($w_qty4 == 0){
                          echo "<td></td>";
                        }else {
                          echo "<td>$w_qty4</td>";
                        }

                        if($w_qty5 == 0){
                          echo "<td></td>";
                        }else {
                          echo "<td>$w_qty5</td>";
                        }
                          // if($row->week_num == $week){
                          //   echo "<td>".$w_qty1."</td>";
                          //   echo "<td></td><td></td><td></td><td></td>";
                          // } else if($row->week_num == $week+1){
                          //   echo "<td></td>";
                          //   echo "<td>".$w_qty2."</td>";       
                          //   echo "<td></td><td></td><td></td>";                   
                          // } else if($row->week_num == $week+2){
                          //   echo "<td></td><td></td>";
                          //   echo "<td>".$w_qty3."</td>"; 
                          //   echo "<td></td><td></td>";
                          // } else if($row->week_num == $week+3){
                          //   echo "<td></td><td></td><td></td>";
                          //   echo "<td>".$w_qty4."</td>";
                          //   echo "<td></td>";
                          // } else if($row->week_num == $week+4) {
                          //   echo "<td></td><td></td><td></td><td></td>";
                          //   echo "<td>".$w_qty5."</td>";
                          //   // echo "";
                          // }
                        ?>
                        <td><?php echo $row->totalqty;?></td>
                        <td><?php echo $row->nama_satuan;?></td>
                        <td><?php echo "Rp. ".number_format($row->harga_satuan);?></td>
                        <td><?php echo "Rp. ".number_format($row->total);?></td>
                        <td><?php echo $row->nama_toko;?></td>
                      </tr>
                    <?php $no++;
                    $total = $total + $row->total;
                  }?>
                  </tfoot>
                </table>
                
                <input type="hidden" value="<?php echo number_format($total)?>" id="totalAll" >
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
      "responsive": true,
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
