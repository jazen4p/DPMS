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
      height: 350px;
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
    <?php if(isset($revisi)){
      foreach($revisi->result() as $row){?>
      <section class="content">
        <div class="container-fluid">
          <!-- <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Perhatian!</strong> Demi kelancaran penggunaan, harap gunakan Google Chrome atau Mozzila Firefox! Terima kasih.
          </div> -->
          <div class="card">
              <div class="card-header">
                <h5>Form Pengeditan Pemakaian Air Konsumen - Unit <?php echo $row->kode_rumah?></h5>
                <?php if(isset($succ_msg)){
                  echo "<span style='color: green'>$succ_msg</span>";
                }?>
                <?php if(isset($err_msg)){
                  echo "<span style='color: red'>$err_msg</span>";
                }?>
              </div>

              <form role="form" method="POST" action="<?php echo base_url()?>Kasir/edit_pengecekan_air" enctype="multipart/form-data">

                <div class="card-body">
                  <div class="col-sm-12 row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Perumahan / Proyek</label>
                        <select name="perumahan" class="form-control kodePerumahan" id="kodePerumahan" required readonly>
                          <!-- <option value="" disabled selected>-Pilih-</option> -->
                          <?php 
                          $query = $this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan));
                          foreach($query->result() as $row1){?>
                            <option value="<?php echo $row1->kode_perumahan?>"><?php echo $row1->nama_perumahan?></option>
                          <?php }?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Unit</label>
                        <input type="text" name="unit" class="form-control unit" value="<?php echo $row->kode_rumah?>" id="response" required readonly>
                      </div>
                        <hr>
                      <div class="form-group">
                        <label>Bln Pengecekan</label>
                        <input type="date" class="form-control" id="bulanPengecekan" value="<?php echo date('Y-m-d', strtotime($row->bulan_tagihan))?>" name="bulan_pengecekan" readonly required>
                      </div>  
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" class="form-control" id="namaPemilik" value="<?php echo $row->nama_konsumen?>" required readonly>
                      </div>
                      <div class="form-group">
                        <label>No. HP Pemilik</label>
                        <input type="text" name="hp_pemilik" class="form-control" id="hpPemilik" value="<?php echo $row->hp_konsumen?>" required readonly>
                      </div>
                        <hr>
                      <div class="form-group">
                        <label>Meteran Bulan Ini (m<sup>3</sup>)</label>
                        <input type="number" step="0.01" class="form-control" id="meteranRev" name="meteran" value="<?php echo $row->meteran?>" required>
                      </div> 
                      <div class="form-group">
                        <label>Pemakaian Bulan Ini (m<sup>3</sup>)</label>
                        <input type="number" step="0.01" class="form-control penggunaanAir" id="penggunaanAirRev" name="pemakaian_air" value="<?php echo $row->penggunaan_air?>" readonly required>
                      </div>  
                      <div class="form-group">
                        <!-- <label>Harga Standart (Rp)</label> -->
                        <input type="hidden" step="0.01" class="form-control" id="" value="80000" name="harga_standart" required>
                      </div>  
                      <div class="form-group">
                        <!-- <label>Harga Overuse (Rp)</label> -->
                        <input type="hidden" step="0.01" class="form-control" id="" value="5000" name="harga_overuse" required>
                      </div>  
                    </div>

                    <div class="col-sm-6">
                      <div class="ex1" id="responseData">
                        <h5 style="text-align: center">Riwayat Penggunaan Air</h5>
                        <hr>
                        <table style="text-align: center; white-space: nowrap" class="table table-bordered table-striped" id="ex1">
                          <thead>
                            <th>Bulan</th>
                            <th>Meteran</th>
                            <th>Pemakaian</th>
                            <th>Aksi</th>
                            <th>Log</th>
                          </thead>
                          <tbody id="responseHistoryDatatable">
                            <?php 
                            $this->db->order_by('bulan_tagihan', "DESC");
                            foreach($this->db->get_where('konsumen_air', array('kode_rumah'=>$row->kode_rumah, 'kode_perumahan'=>$row->kode_perumahan))->result() as $datas){?>
                              <tr>
                                <td><?php echo date('d-m-Y', strtotime($row->bulan_tagihan))?></td>
                                <td><?php echo $datas->meteran?> <sup>3</sup></td>
                                <td><?php echo $datas->penggunaan_air?> <sup>3</sup></td>
                                <td>
                                  <?php if(date('Y-m', strtotime($datas->bulan_tagihan)) == date('Y-m') && $row->status == "belum lunas"){
                                      echo "<a href='".base_url()."Kasir/view_edit_check_air?id=$row->id_air' class='btn btn-outline-info btn-flat btn-sm'>Edit</a>";
                                  }?>
                                </td>
                                <td style='font-size: 12px'>
                                    Created: <?php echo $datas->created_by?> - <?php echo date('Y-m-d H:i:sa', strtotime($datas->date_by))?><br>
                                    Revised: <?php echo $datas->rev_by?> - <?php echo date('Y-m-d H:i:sa', strtotime($datas->rev_date))?>
                                </td>
                              </tr>
                            <?php }?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <!-- <div class="col-sm-12 row">
                    <div class="col-sm-6">
                      
                    </div>
                    <div class="col-sm-3"> 
                    </div>
                    <div class="col-sm-3">
                    </div>
                  </div> -->
                </div>

                <div class="card-footer" style="text-align: right">
                  <input type="hidden" id="idPPJB" name="id_ppjb" value="<?php echo $row->id_ppjb?>">
                  <input type="hidden" id="idBAST" name="id_bast" value="<?php echo $row->id_bast?>">
                  <input type="hidden" id="kodePerusahaan" name="kodePerusahaan" value="<?php echo $row->kode_perusahaan?>">

                  <!-- <input type="hidden" name="harga_standart" value="80000">
                  <input type="hidden" name="harga_overuse" value="5000"> -->

                  <input type="hidden" id="id_air" value="<?php echo $row->id_air?>" name="id_air">

                  <a class="btn btn-danger btn-sm" href="<?php echo base_url()?>Kasir/check_air">Kembali</a>
                  <input type="submit" class="btn btn-success btn-sm">
                </div>

              </form>
          </div>
        </div>
      </section>
    <?php }} else {?>
      <section class="content">
        <div class="container-fluid">
          <!-- <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Perhatian!</strong> Demi kelancaran penggunaan, harap gunakan Google Chrome atau Mozzila Firefox! Terima kasih.
          </div> -->
          <div class="card">
              <div class="card-header">
                <h5>Form Pengisian Data Pemakaian Air Konsumen</h5>
                <?php if(isset($succ_msg)){
                  echo "<span style='color: green'>$succ_msg</span>";
                }?>
                <?php if(isset($err_msg)){
                  echo "<span style='color: red'>$err_msg</span>";
                }?>
              </div>

              <form role="form" method="POST" action="<?php echo base_url()?>Kasir/add_pengecekan_air" enctype="multipart/form-data">

                <div class="card-body">
                  <div class="col-sm-12 row">
                    <div class="col-sm-3">
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
                        <hr>
                      <div class="form-group">
                        <label>Bln Pengecekan</label>
                        <input type="date" class="form-control" id="bulanPengecekan" value="<?php echo date('Y-m-d')?>" name="bulan_pengecekan" required>
                      </div>  
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" class="form-control" id="namaPemilik" required readonly>
                      </div>
                      <div class="form-group">
                        <label>No. HP Pemilik</label>
                        <input type="text" name="hp_pemilik" class="form-control" id="hpPemilik" required readonly>
                      </div>
                        <hr>
                      <div class="form-group">
                        <label>Meteran Bulan Ini (m<sup>3</sup>)</label>
                        <input type="number" step="0.01" class="form-control" id="meteran" name="meteran" required>
                      </div> 
                      <div class="form-group">
                        <label>Pemakaian Bulan Ini (m<sup>3</sup>)</label>
                        <input type="number" step="0.01" class="form-control penggunaanAir" id="penggunaanAir" name="pemakaian_air" readonly required>
                      </div>  
                      <div class="form-group">
                        <!-- <label>Harga Standart (Rp)</label> -->
                        <input type="hidden" step="0.01" class="form-control" id="" value="80000" name="harga_standart" required>
                      </div>  
                      <div class="form-group">
                        <!-- <label>Harga Overuse (Rp)</label> -->
                        <input type="hidden" step="0.01" class="form-control" id="" value="5000" name="harga_overuse" required>
                      </div>  
                    </div>

                    <div class="col-sm-6">
                      <div class="ex1" id="responseData">
                        <h5 style="text-align: center">Riwayat Penggunaan Air</h5>
                        <hr>
                        <table style="text-align: center; white-space: nowrap" class="table table-bordered table-striped" id="ex1">
                          <thead>
                            <th>Bulan</th>
                            <th>Meteran</th>
                            <th>Pemakaian</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                            <th>Log</th>
                          </thead>
                          <tbody id="responseHistoryDatatable">

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <!-- <div class="col-sm-12 row">
                    <div class="col-sm-6">
                      
                    </div>
                    <div class="col-sm-3"> 
                    </div>
                    <div class="col-sm-3">
                    </div>
                  </div> -->
                </div>

                <div class="card-footer" style="text-align: right">
                  <input type="hidden" id="idPPJB" name="id_ppjb">
                  <input type="hidden" id="idBAST" name="id_bast">
                  <input type="hidden" id="kodePerusahaan" name="kodePerusahaan">

                  <!-- <input type="text" name="harga_standart" value="80000">
                  <input type="text" name="harga_overuse" value="5000"> -->

                  <input type="submit" class="btn btn-success btn-sm">
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

  $('#meteranRev').on("input", function(){
    var selectedCountry = $(this).val();
    var unitRumah = $('.unit').val();
    var kodePerumahan = $('#kodePerumahan').val();
    var bulanPengecekan = $('#bulanPengecekan').val();
    // alert(bulanPengecekan);
    // $('#penggunaanAirRev').val(selectedCountry);
    
    $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>Kasir/get_edit_pemakaian_meteran_bulan_ini",
        data: { country : selectedCountry, unit : unitRumah, bulan : bulanPengecekan, kodePerumahan : kodePerumahan } 
    }).done(function(data){
        $("#penggunaanAirRev").val(data);
    });
  });
})
</script>
</body>
</html>
