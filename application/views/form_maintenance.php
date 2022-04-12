<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <?php include "include/title.php"?>
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->

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
  <link type="text/css" href="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/css/jquery.signature.css" rel="stylesheet"> 

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
    .kbw-signature { width: 400px; height: 200px;}
    #sig canvas{
        width: 100% !important;
        height: auto;
    }
  </style>
</head>
<!-- body -->
<?php include "include/fixedtop.php"?>
<div class="wrapper">
  <!-- Navbar -->
  <?php include "include/navbar.php"?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "include/sidebar.php"?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: white">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div> -->
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Perhatian!</strong> Demi kelancaran penggunaan, harap gunakan Google Chrome atau Mozzila Firefox! Terima kasih.
        </div> -->
        <div class="card">
            <div class="card-header">
              <h5>Form Pembuatan Tagihan Keamanan & Maintenance Konsumen</h5>
              <?php if(isset($succ_msg)){
                echo "<span style='color: green'>$succ_msg</span>";
              }?>
              <?php if(isset($err_msg)){
                echo "<span style='color: red'>$err_msg</span>";
              }?>
            </div>

            <form role="form" method="POST" action="<?php echo base_url()?>Kasir/add_maintenance" enctype="multipart/form-data">

              <div class="card-body">
                <div class="col-sm-12 row">
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Tgl/Bulan Maintenance</label>
                      <input type="date" class="form-control" value="<?php echo date('Y-m-d')?>" name="bulan">
                    </div>
                    <div class="form-group">
                      <label>Nominal Maintenance (Rp.)</label>
                      <input type="number" class="form-control" value="70000" name="nominal">
                    </div>
                  </div>
                  <div class="col-sm-9">
                    <h5>Penagihan Maintenance Bulan Ini (<?php echo date('F Y')?>)</h5>
                    <table class="table table-striped table-bordered" id="ex1" style="font-size: 13px">
                      <thead>
                        <tr>
                          <th>Bulan</th>
                          <th>No Unit</th>
                          <th>Nama Pemilik</th>
                          <th>HP Pemilik</th>
                          <th>Nominal</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($check_all->result() as $row){?>
                          <tr>
                            <td><?php echo date('d-m-Y', strtotime($row->bulan_tagihan))?></td>
                            <td><?php echo $row->kode_rumah?></td>
                            <td><?php echo $row->nama_konsumen?></td>
                            <td><?php echo $row->hp_konsumen?></td>
                            <td><?php echo "Rp. ".number_format($row->nominal)?></td>
                            <td><?php echo $row->status?></td>
                          </tr>
                        <?php }?>
                        <?php foreach($check_all2->result() as $row1){?>
                          <tr>
                            <td><?php echo date('d-m-Y', strtotime($row1->bulan_tagihan))?></td>
                            <td><?php echo $row1->kode_rumah?></td>
                            <td><?php echo $row1->nama_konsumen?></td>
                            <td><?php echo $row1->hp_konsumen?></td>
                            <td><?php echo "Rp. ".number_format($row1->nominal)?></td>
                            <td><?php echo $row1->status?></td>
                          </tr>
                        <?php }?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="card-footer" style="text-align: left">
                <input type="submit" class="btn btn-success btn-sm" value="Buat Tagihan Maintenance">
              </div>

            </form>
        </div>

        <div class="card">
            <div class="card-header">
              <h5>Maintenance List</h5>
            </div>

            <div class="card-body">
                <!-- <button id="button" class="btn btn-flat btn-info">FILTER</button> -->
              <div id="wrapper" style="">
                <form action="<?php echo base_url()?>Dashboard/filter_kavling_management" method="POST">
                Perumahan:
                <select name="perumahan" class="form-control col-sm-6">
                    <option value="">Semua</option>
                    <?php foreach($this->db->get('perumahan')->result() as $perumahan){
                      echo "<option ";
                      if(isset($k_perumahan)){
                        if($k_perumahan == $perumahan->kode_perumahan){
                          echo "selected";
                        }
                      }
                      echo " value='$perumahan->kode_perumahan'>$perumahan->nama_perumahan</option>";
                    }?>
                </select>

                <input type="submit" class="btn btn-default btn-sm" value="OK">
                </form>
              </div> <br>
              <table id="example2" class="table table-bordered table-striped" style="font-size: 13px">
                <thead>
                  <tr>
                      <th>No Unit</th>
                      <th>Bulan</th>
                      <th>Nama Pemilik</th>
                      <th>HP Pemilik</th>
                      <th>Nominal</th>
                      <th>Status</th>
                  </tr>
                </thead>
                <tbody style="white-space: nowrap">
                  <?php foreach($get_all->result() as $row2){?>
                      <tr <?php if($row2->status == "lunas"){echo "style='background-color: lightgreen'";} else {echo "style='background-color: pink'";}?>>
                          <td><?php echo $row2->kode_rumah?></td>
                          <td><?php echo date('d-m-Y', strtotime($row2->bulan_tagihan))?></td>
                          <td><?php echo $row2->nama_konsumen?></td>
                          <td><?php echo $row2->hp_konsumen?></td>
                          <td><?php echo "Rp. ".number_format($row2->nominal)?></td>
                          <td><?php echo $row2->status?></td>
                      </tr>
                  <?php }?>
                </tfoot>
              </table>
            </div>

            <div class="card-footer">

            </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  
  <?php include "include/footer.php"?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/js/jquery.signature.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/js/jquery.signature.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery-ui-touch-punch-master/jquery.ui.touch-punch.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery-ui-touch-punch-master/jquery.ui.touch-punch.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

<script type="text/javascript">
$("select.kodePerumahan").change(function(){
  var selectedCountry = $(this).val();

  $('.unit').val('');
  $('#namaPemilik').val('');
  $('#hpPemilik').val('');
  $('#responseHistoryDatatable').html('');

  // window.location.href="<?php echo base_url()?>Dashboard/get_anak_akun?id="+selectedCountry;
  // document.getElementById('kodeAkunDebet').value = selectedCountry;
  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_unit_bast",
      data: { country : selectedCountry } 
  }).done(function(data){
      $("#response").html(data);
  });

  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_kode_perusahaan",
      data: { country : selectedCountry } 
  }).done(function(data){
      $("#kodePerusahaan").val(data);
  });
});

$(".unit").change(function(){
  var selectedCountry = $(this).val();
  var kodePerumahan = $('#kodePerumahan').val();

  // alert(selectedCountry);

  // window.location.href="<?php echo base_url()?>Dashboard/get_anak_akun?id="+selectedCountry;
  // document.getElementById('kodeAkunDebet').value = selectedCountry;
  
  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_nama_pemilik",
      data: { country : selectedCountry, kodePerumahan : kodePerumahan } 
  }).done(function(data){
      $("#namaPemilik").val(data);
  });
  
  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_hp_pemilik",
      data: { country : selectedCountry, kodePerumahan : kodePerumahan } 
  }).done(function(data){
      $("#hpPemilik").val(data);
  });
  
  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_riwayat_air_unit",
      data: { country : selectedCountry, kodePerumahan : kodePerumahan } 
  }).done(function(data){
      $("#responseHistoryDatatable").html(data);
  });
  
  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_id_ppjb",
      data: { country : selectedCountry, kodePerumahan : kodePerumahan } 
  }).done(function(data){
      $("#idPPJB").val(data);
  });
  
  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_id_bast",
      data: { country : selectedCountry, kodePerumahan : kodePerumahan } 
  }).done(function(data){
      $("#idBAST").val(data);
  });
});
</script>
<script>
$(function () {
  $("#ex21").DataTable({
    "responsive": false,
    "autoWidth": false,
    "scrollX": true
  });
  $('#ex1').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": false,
    "scrollX": true,
    "scrollY": "200px",
    "order": [[0, "desc"]]
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
    "order": [[1, "desc"]]
  });
});

$(document).ready(function(){
  $('#meteran').on("input", function(){
    var selectedCountry = $(this).val();
    var unitRumah = $('.unit').val();
    var kodePerumahan = $('#kodePerumahan').val();
    var bulanPengecekan = $('#bulanPengecekan').val();
    // alert(bulan);
    // $('#penggunaanAir').val(selectedCountry);
    
    $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>Kasir/get_pemakaian_meteran_bulan_ini",
        data: { country : selectedCountry, unit : unitRumah, bulan : bulanPengecekan, kodePerumahan : kodePerumahan } 
    }).done(function(data){
        $("#penggunaanAir").val(data);
    });
  });
})
</script>
</body>
</html>
