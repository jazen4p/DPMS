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
          <div class="col-sm-8">
            <h1>
              Laporan Rekap Transaksi Pembayaran Air & Maintenance
              <?php if(isset($kode)){
                  echo " - ".$kode;
              }?>
            </h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Air & Maintenance</li>
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
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <a href="<?php echo base_url()?>Dashboard/air_maintenance_report_perumahan" class="btn btn-outline-success btn-flat">Kembali</a>
                <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
                <div id="wrapper">
                    <form action="<?php echo base_url()?>Dashboard/filter_air_maintenance_report" method="POST">
                        <div class="row">
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>Perumahan</label>
                                    <select name="perumahan" class="form-control">
                                        <option value="">Semua</option>
                                        <?php foreach($this->db->get('perumahan')->result() as $prmh){
                                            echo "<option ";
                                            if($kode == $prmh->kode_perumahan){
                                            echo "selected";
                                            }
                                            echo " value='$prmh->kode_perumahan'>$prmh->nama_perumahan</option>";
                                        }?>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bulan</label>
                                    <input type="month" value="<?php if(isset($bulan)){echo $bulan;}?>" name="bulan" class="form-control">
                                </div>
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
                </div> <br>

                <div class="col-sm-12">
                  <div style="text-align: center;">
                    <h5 style="font-weight: bold">Rekap Pembayaran Air & Maintenance - <?php echo $nama_perumahan?> Residence - Bulan <?php echo date('F Y', strtotime($bulan))?></h5>
                  </div>
                  <hr>

                  <?php $ttl_all = 0;?>
                  <div class="row">
                    <div class="col-sm-6">
                      <h6 style="text-align: center; font-weight: bold">Air</h6>
                      <table style="width: 100%">
                        <tr>
                          <?php 
                            // $query = $this->db->get('');
                            $this->db->where("DATE_FORMAT(date_by,'%Y-%m') =", date('Y-m', strtotime($bulan)));
                            $this->db->where('jenis_tagihan', "air");
                            $q = $this->db->get('konsumen_struk_item');

                            $ttl_air = 0;
                            foreach($q->result() as $row){
                              foreach($this->db->get_where('konsumen_air', array('id_air'=>$row->id_tagihan, 'kode_perumahan'=>$id))->result() as $air){
                                // echo "";
                                $ttl_air = $ttl_air + $air->total_harga;
                                $ttl_all = $ttl_all + $air->total_harga;
                              }
                            }
                          ?>
                          <td>Jumlah pembayaran konsumen bulan ini : </td>
                          <td style="background-color: lightgreen; text-align: center"><?php echo "Rp. ".number_format($ttl_air)?></td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-sm-6">
                      <h6 style="text-align: center; font-weight: bold">Maintenance</h6>
                      <table style="width: 100%">
                        <tr>
                          <?php 
                            // $query = $this->db->get('');
                            $this->db->where("DATE_FORMAT(date_by,'%Y-%m') =", date('Y-m', strtotime($bulan)));
                            $this->db->where('jenis_tagihan', "maintenance");
                            $q = $this->db->get('konsumen_struk_item');

                            $ttl_maintenance = 0;
                            foreach($q->result() as $row){
                              foreach($this->db->get_where('konsumen_maintenance', array('id_maintenance'=>$row->id_tagihan, 'kode_perumahan'=>$id))->result() as $mt){
                                // echo "";
                                $ttl_maintenance = $ttl_maintenance + $mt->nominal;
                                $ttl_all = $ttl_all + $mt->nominal;
                              }
                            }
                          ?>
                          <td>Jumlah pembayaran konsumen bulan ini : </td>
                          <td style="background-color: lightgreen; text-align: center"><?php echo "Rp. ".number_format($ttl_maintenance)?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div> 
                
                <hr>
                <div class="col-sm-12">
                  <table class="table">
                    <tr style="text-align: right; background-color: pink">
                      <td style="font-weight: bold">TOTAL KESELURUHAN PEMBAYARAN AIR & MAINTENANCE KONSUMEN : </td>
                      <td style="font-weight: bold"><?php echo "Rp. ".number_format($ttl_all)?></td>
                    </tr>
                  </table>
                </div>
                <hr>
                
                <div class="col-sm-12">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="card">
                        <div class="card-body">
                          <h6 style="text-align: center; font-weight: bold">Riwayat Transaksi Air</h6>
                          <table class="table table-bordered table-striped" id="ex1" style="font-size: 13px; white-space: nowrap">
                            <thead>
                              <tr>
                                <th>Tgl Transaksi</th>
                                <th>Bulan</th>
                                <th>Meteran</th>
                                <th>Pemakaian</th>
                                <!-- <th>Item</th> -->
                                <th>Nominal</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                // $query = $this->db->get('');
                                $this->db->where("DATE_FORMAT(date_by,'%Y-%m') =", date('Y-m', strtotime($bulan)));
                                $this->db->where('jenis_tagihan', "air");
                                // $this->db->order_by()
                                $q = $this->db->get('konsumen_struk_item');

                                // $ttl_air = 0;
                                foreach($q->result() as $row){
                                  foreach($this->db->get_where('konsumen_air', array('id_air'=>$row->id_tagihan, 'kode_perumahan'=>$id))->result() as $air){
                                    // echo "";
                                    // $ttl_air = $ttl_air + $air->total_harga;?>
                                    
                                    <tr>
                                      <td><?php echo date('d-m-Y H:i', strtotime($row->date_by))?></td>
                                      <td><?php echo date('M Y', strtotime($air->bulan_tagihan))?></td>
                                      <td><?php echo $air->meteran?> m<sup>3</sup></td>
                                      <td><?php echo $air->penggunaan_air?> m<sup>3</sup></td>
                                      <td><?php echo "Rp. ".number_format($row->nominal)?></td>
                                    </tr>
                                  <?php }
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="card">
                        <div class="card-body">
                          <h6 style="text-align: center; font-weight: bold">Riwayat Transaksi Maintenance</h6>
                          <table class="table table-bordered table-striped" id="ex2" style="font-size: 13px; white-space: nowrap">
                            <thead>
                              <tr>
                                <th>Tgl Transaksi</th>
                                <th>Bulan</th>
                                <!-- <th>Item</th> -->
                                <th>Nominal</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                // $query = $this->db->get('');
                                $this->db->where("DATE_FORMAT(date_by,'%Y-%m') =", date('Y-m', strtotime($bulan)));
                                $this->db->where('jenis_tagihan', "maintenance");
                                // $this->db->order_by()
                                $q = $this->db->get('konsumen_struk_item');

                                // $ttl_air = 0;
                                foreach($q->result() as $row){
                                  foreach($this->db->get_where('konsumen_maintenance', array('id_maintenance'=>$row->id_tagihan, 'kode_perumahan'=>$id))->result() as $air){
                                    // echo "";
                                    // $ttl_air = $ttl_air + $air->total_harga;?>
                                    
                                    <tr>
                                      <td><?php echo date('d-m-Y H:i', strtotime($row->date_by))?></td>
                                      <td><?php echo date('M Y', strtotime($air->bulan_tagihan))?></td>
                                      <td><?php echo "Rp. ".number_format($row->nominal)?></td>
                                    </tr>
                                  <?php }
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                  <hr>

                <div class="col-sm-12">
                  <div class="card">
                    <div class="card-body">
                      <h6 style="text-align: center; font-weight: bold">Riwayat Perstruk Tagihan</h6>

                      <table class="table table-striped table-bordered" id="ex3" style="font-size: 13px; white-space: nowrap">
                        <thead>
                          <tr>
                            <th>No Struk</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Nama Konsumen</th>
                            <th>HP Konsumen</th>
                            <th>Nominal Tagihan</th>
                            <th>Pembayaran</th>
                            <th>Jenis Pembayaran</th>
                            <!-- <th>Pembayaran</th> -->
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($this->db->get_where('konsumen_struk', array('kode_perumahan'=>$id))->result() as $rowz){?>
                              <tr>
                                  <td><?php echo sprintf('%09d', $rowz->id_struk)?></td>
                                  <td><?php echo date('d-m-Y H:i', strtotime($rowz->tgl_struk))?></td>
                                  <td><?php echo $rowz->nama_pemilik?></td>
                                  <td><?php echo $rowz->hp_pemilik?></td>
                                  <td><?php echo "Rp. ".number_format($rowz->grand_total)?></td>
                                  <td><?php echo "Rp. ".number_format($rowz->pembayaran)?></td>
                                  <td><?php echo ucfirst($rowz->jenis_pembayaran)." "?><?php foreach($this->db->get_where('bank', array('id_bank'=>$rowz->id_bank))->result() as $banks){echo $banks->nama_bank;}?></td>
                                  <td>
                                    <a href='<?php echo base_url()?>Kasir/print_struk?id=<?php echo $rowz->id_struk?>' target="_blank" class="btn btn-sm btn-success"><i class="fa fa-file"></i> Print</a>
                                    <button type="submit" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $rowz->id_struk?>"><i class="fa fa-list-alt"></i> Detail</button>
                                    <a href="<?php echo base_url()?>Kasir/hapus_struk?id=<?php echo $rowz->id_struk?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Batal</a>
                                  </td>
                              </tr>
                          <?php }?>
                        </tbody>
                      </table>

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

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Riwayat Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody id="getDatatableDetail">

                    </tbody>
                </table>
            </div>

            <div class="modal-footer">

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
      "scrollX": true
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
    });
    $('#ex1').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "order": [[0, "desc"]]
    });
    $('#ex2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "order": [[0, "desc"]]
    });
    $('#ex3').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "scrollY": "300px",
    });
  });

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

$('#exampleModal').on('show.bs.modal', function (e) {
  var myRoomNumber = $(e.relatedTarget).attr('data-id');

  // $(this).find('.idPSJB').val(myRoomNumber);
  // alert(myRoomNumber);

  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_riwayat_struk",
      data: { country : myRoomNumber } 
  }).done(function(data){
      $("#getDatatableDetail").html(data);
  });
});
</script>
</body>
</html>
