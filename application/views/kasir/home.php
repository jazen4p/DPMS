<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <?php include "include/title.php"?>
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
  <link type="text/css" href="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/css/jquery.signature.css" rel="stylesheet"> 

  <style>
    div.ex1 {
      background-color: lightblue;
      width: 100%;
      height: 300px;
      overflow: scroll;
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
              <h5>Kasir - Pembayaran Air & Maintenance</h5>
              <?php if(isset($succ_msg)){
                echo "<span style='color: green'>$succ_msg</span>";
              }?>
              <?php if(isset($err_msg)){
                echo "<span style='color: red'>$err_msg</span>";
              }?>
            </div>

            <form role="form" method="POST" action="<?php echo base_url()?>Kasir/pilih_pembayaran_kasir" enctype="multipart/form-data">
            <div class="card-body">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Kode Pelanggan (Gunakan - (strip) sebagai pemisah)</label>
                  <input type="text" id="kodePelanggan" class="form-control">
                </div>
              </div>

              <div class="col-sm-12 row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Perumahan / Proyek</label>
                    <select name="perumahan" class="form-control kodePerumahan" id="kodePerumahan" required>
                      <option value="" disabled selected>-Pilih-</option>
                      <?php 
                      $query = $this->db->get('perumahan');
                      foreach($query->result() as $row){?>
                        <option value="<?php echo $row->kode_perumahan?>"><?php echo $row->nama_perumahan?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Unit</label>
                    <select name="unit" class="form-control unit" id="response" required>
                      <option value="" disabled selected>-Pilih-</option>
                    </select>
                  </div>
                  <!-- <div class="form-group">
                    <input type="submit" value="Pilih Pembayaran" class="btn btn-flat btn-sm btn-success">
                  </div> -->
                </div>

                <div class="col-sm-5">
                  <div class="ex1" id="responseData">
                    <h5 style="text-align: center">List Penggunaan Air</h5>
                    <table style="text-align: center; white-space: nowrap; font-size: 13px" class="table table-bordered">
                      <thead>
                        <th>Aksi</th>
                        <th>Tgl/Bulan</th>
                        <th>Meteran</th>
                        <th>Pemakaian</th>
                        <th>Nominal</th>
                      </thead>
                      <tbody id="responseHistoryDatatable">

                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="col-sm-5">
                  <div class="ex1" id="responseData">
                    <h5 style="text-align: center">List Maintenance</h5>
                    <table style="text-align: center; white-space: nowrap; font-size: 13px" class="table table-bordered">
                      <thead>
                        <th>Aksi</th>
                        <th>Tgl/Bulan</th>
                        <th>Nominal</th>
                      </thead>
                      <tbody id="responseHistoryMaintenance">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer" style="text-align: right">
              <input type="submit" value="Pilih Pembayaran" class="btn btn-flat btn-sm btn-success">
            </div>
            </form>
        </div>
      </div>
    </section>

    <?php if(isset($confirm)){?>
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header" style="text-align: center">
            <h5>Konfirmasi Pembuatan Slip Tagihan</h5>
          </div>

          <form role="form" onsubmit="return validateForm()" method="POST" action="<?php echo base_url()?>Kasir/konfirmasi_pembayaran" enctype="multipart/form-data">
            <div class="card-body">
              <div class="col-sm-12 row">
                <div class="col-sm-9">
                  <h5>Perincian Item</h5>
                  <table class="table table-bordered" style="font-size: 14px">
                    <thead>
                      <tr style="background-color: lightyellow">
                        <th>No</th>
                        <th>Rincian Item</th>
                        <th>Qty</th>
                        <th>Harga Nominal</th>
                      </tr>
                    </thead>
                    <?php
                    $total_air = 0; $no = 1;
                    if(isset($id_air)){
                      for($i=0; $i < count($id_air); $i++){
                        foreach($this->db->get_where('konsumen_air', array('id_air'=>$id_air[$i]))->result() as $row){?>
                          <tr>
                            <td><?php echo $no;?></td>
                            <td>
                              <?php 
                                $datestring= date('Y-m-d', strtotime($row->bulan_tagihan)).' first day of last month';
                                $dt=date_create($datestring);
                                // echo $dt->format('F Y'); //2011-02

                                // exit;

                                $item = "Pembayaran Abodemen dan Air Bulan ".$dt->format('F Y');
                              ?>

                              Pembayaran Abodemen dan Air Bulan <?php echo $dt->format('F Y')?>
                              <input type="hidden" value="<?php echo $row->id_air?>" name="id_air[]">
                              <input type="hidden" value="air" name="jenis_tagihan[]">


                              <input type="hidden" value="<?php echo $item?>" name="list[]">
                            </td>
                            <td>1</td>
                            <td>
                              <?php echo "Rp. ".number_format($row->total_harga, 0, ",", ".")?>
                              <input type="hidden" name="nominal[]" value="<?php echo $row->total_harga?>">
                            </td>
                          </tr>
                      <?php $no++;}
                        $total_air = $total_air + $row->total_harga;
                      }
                    }
                    if(isset($id_maintenance)){
                    for($i=0; $i < count($id_maintenance); $i++){
                      foreach($this->db->get_where('konsumen_maintenance', array('id_maintenance'=>$id_maintenance[$i]))->result() as $row1){?>
                        <tr>
                          <td><?php echo $no;?></td>
                          <td>
                            <?php 
                              $datestring= date('Y-m-d', strtotime($row1->bulan_tagihan)).' first day of last month';
                              $dt=date_create($datestring);
                              // echo $dt->format('F Y'); //2011-02

                              $item = "Pembayaran Keamanan dan Kebersihan Bulan ".$dt->format('F Y');
                            ?>

                            Pembayaran Keamanan & Maintenance Bulan <?php echo $dt->format('F Y');?>
                            <input type="hidden" value="<?php echo $row1->id_maintenance?>" name="id_air[]">
                            <input type="hidden" value="maintenance" name="jenis_tagihan[]">

                            <input type="hidden" value='<?php echo $item?>' name="list[]">
                          </td>
                          <td>1</td>
                          <td><?php echo "Rp. ".number_format($row1->nominal, 0, ",", ".")?></td>
                            <input type="hidden" name="nominal[]" value="<?php echo $row1->nominal?>">
                        </tr>
                    <?php $no++;}
                      $total_air = $total_air + $row1->nominal;
                    }}?>
                    <tr style="background-color: lightyellow">
                      <td colspan=3 style="font-weight: bold">GRAND TOTAL</td>
                      <td style="font-weight: bold"><?php echo "Rp. ".number_format($total_air, 0, ",", ".");?></td>
                    </tr>
                  </table>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Nama Pemilik</label>
                    <input type='text' class="form-control" name="nama_pemilik" value="<?php echo $nama_pemilik?>" readonly>
                  </div>
                  <div class="form-group">
                    <label>HP Pemilik</label>
                    <input type='text' class="form-control" name="hp_pemilik" value="<?php echo $hp_pemilik?>" readonly>
                    <input type="hidden" id="totalTagihan" value="<?php echo $total_air?>" name="grand_total">
                  </div>
                </div>
                <!-- <div class="col-sm-3">
                  <div class="form-group">
                    <label>Cara Pembayaran</label>
                    <select class="form-control" id="caraPembayaran" name="cara_pembayaran" required>
                      <option value="" disabled selected>-Pilih-</option>
                      <option value="transfer">Transfer</option>
                      <option value="cash">Cash</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Bank</label>
                    <input type="hidden" id="bankOpt" name="bank" value="" disabled>
                    <select class="form-control" id="bank" name="bank" required>
                      <option value="" disabled selected>-Pilih-</option>
                      <?php foreach($this->db->get('bank')->result() as $bank){?>
                        <option value="<?php echo $bank->id_bank?>"><?php echo $bank->id_bank." - ".$bank->nama_bank?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Uang yang diterima</label>
                    <input type="number" class="form-control" value="<?php echo $total_air?>" id="PembayaranKonsumen" name="nominal_pembayaran" required>
                  </div>
                  <div class="form-group">
                    <label>Kembalian</label>
                    <input type="number" class="form-control" value="0" id="Kembalian" name="kembalian" readonly required>
                  </div>
                </div>
              </div> -->
            </div>

            <div class="card-footer">
              <input type="hidden" value="<?php echo $kode_perumahan?>" name="kode_perumahan">
              <input type="hidden" value="<?php echo $unit?>" name="unit">
              <input type="submit" value="Konfirmasi" class="btn btn-success btn-sm">
            </div>
          </form>
        </div>
      </div>
    </section>
    <?php }?>

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
$('#caraPembayaran').change(function(){
  if($(this).val() == "transfer"){
    $('#bank').removeAttr('disabled');
    $('#bank').attr('required', 'required');

    $('#bankOpt').attr('disabled', 'disabled');
    $('#bankOpt').removeAttr('required');
  } else {
    $('#bankOpt').removeAttr('disabled');
    $('#bankOpt').attr('required', 'required');

    $('#bank').val('');
    $('#bank').attr('disabled', 'disabled');
    $('#bank').removeAttr('required');
  }
})

$('#kodePelanggan').on("input", function(){
  var q = $(this).val();
  var res = q.split("-");

  var kodePerumahan = res[0];
  var selectedCountry = res[1];

  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_unit_kasir",
      data: { country : kodePerumahan } 
  }).done(function(data){
      $("#response").html(data);
  });
  
  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_riwayat_air_kasir",
      data: { country : selectedCountry, kodePerumahan : kodePerumahan } 
  }).done(function(data){
      $("#responseHistoryDatatable").html(data);
  });
  
  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_riwayat_maintenance",
      data: { country : selectedCountry, kodePerumahan : kodePerumahan } 
  }).done(function(data){
      $("#responseHistoryMaintenance").html(data);
  });

  $('.kodePerumahan').val(res[0]);
  $('.unit').val(res[1]);
})

$('#PembayaranKonsumen').on("input", function(){
  $('#Kembalian').val($('#totalTagihan').val() - $(this).val());
})

function validateForm() {
  var x = $('#Kembalian').val();
  if (x < 0) {
    alert("Kembalian tidak boleh minus!");
    return false;
  }
}

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
      url: "<?php echo base_url()?>Kasir/get_unit_kasir",
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
      url: "<?php echo base_url()?>Kasir/get_riwayat_air_kasir",
      data: { country : selectedCountry, kodePerumahan : kodePerumahan } 
  }).done(function(data){
      $("#responseHistoryDatatable").html(data);
  });
  
  $.ajax({
      type: "POST",
      url: "<?php echo base_url()?>Kasir/get_riwayat_maintenance",
      data: { country : selectedCountry, kodePerumahan : kodePerumahan } 
  }).done(function(data){
      $("#responseHistoryMaintenance").html(data);
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
    "scrollY": "200px"
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
