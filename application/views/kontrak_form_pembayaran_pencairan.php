<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <title>AdminLTE 3 | General Form Elements</title> -->
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

  <?php 
    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
          $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
          $temp = penyebut($nilai - 10). " Belas";
        } else if ($nilai < 100) {
          $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
          $temp = " Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
          $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
          $temp = " Seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
          $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
          $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
          $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
          $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
      }
    
      function terbilang($nilai) {
        if($nilai<0) {
          $hasil = "minus ". trim(penyebut($nilai));
        } else {
          $hasil = trim(penyebut($nilai));
        }     		
        return $hasil;
      }
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Form Pencairan Upah Borongan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Pencairan Upah Borongan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php if(isset($edit_pengeluaran)){
      foreach($edit_pengeluaran->result() as $row){?>
        <section class="content">
          <div class="container-fluid">
              <div class="row">
              <!-- left column -->
                  <div class="col-md-12">
                      <!-- general form elements -->
                      <div class="card card-primary">
                      <!-- /.card-header -->
                      <!-- form start -->
                          <!-- <form role="form" action="<?php echo base_url()?>Dashboard/add_pengeluaran" method="post" enctype="multipart/form-data"> -->
                          <?php echo form_open_multipart('Dashboard/edit_update_pengeluaran');?>
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label>No Kwitansi</label>
                                              <input type="text" class="form-control" placeholder="No Kwitansi" name="no_kwitansi" value="<?php echo $row->no_pengeluaran?>" readonly required>
                                          </div>
                                          <div class="form-group">
                                              <label>Perumahan</label>
                                              <input type="text" class="form-control" name="kode_perumahan" value="<?php echo $row->kode_perumahan?>" readonly required>
                                          </div>
                                          <div class="form-group">
                                              <label>Penerima</label>
                                              <input type="text" class="form-control" placeholder="Terima oleh" name="terima_oleh" value="<?php echo $row->terima_oleh?>" required>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label>Kategori Pengeluaran</label>
                                              <select class="form-control category" name="kategori_pengeluaran" required>
                                                  <!-- <option selected value="">-Pilih-</option> -->
                                                  <?php 
                                                    $query = $this->db->get('keuangan_kode_induk_pengeluaran');
                                                    foreach($query->result() as $kode){
                                                      echo "<option ";
                                                      if($row->kategori_pengeluaran == $kode->kode_induk){
                                                        echo "selected";
                                                      }
                                                      echo " value='$kode->kode_induk'>$kode->kode_induk-$kode->nama_induk</option>";
                                                    }?>
                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <!-- <div></div> -->
                                              <label>Jenis Pengeluaran</label>
                                              <select class="form-control" id="response" name="jenis_pengeluaran" required>
                                                  <!-- <option selected disabled value="">-Pilih-</option> -->
                                                  <?php 
                                                    foreach($this->db->get_where('keuangan_kode_pengeluaran', array('kode_induk'=>$row->kategori_pengeluaran))->result() as $subkode){
                                                      echo "<option ";
                                                      if($row->jenis_pengeluaran == $subkode->kode_pengeluaran){
                                                        echo "selected";
                                                      }
                                                      echo " value='$subkode->kode_pengeluaran'>$subkode->kode_pengeluaran-$subkode->nama_pengeluaran</option>";
                                                    }
                                                  ?>
                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <label>Keterangan Pembayaran</label>
                                              <textarea class="form-control" placeholder="Keterangan Pengeluaran" name="keterangan_pengeluaran" value="" required><?php echo $row->keterangan?></textarea>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label>Nilai Pengeluaran</label>
                                              <input type="number" class="form-control" placeholder="Nilai Pengeluaran" name="nilai_pengeluaran" value="<?php echo $row->nominal?>" required>
                                          </div>
                                          <div class="form-group">
                                              <label>Tanggal Pengeluaran</label>
                                              <input type="date" class="form-control" placeholder="" name="tgl_pengeluaran" value="<?php echo $row->tgl_pembayaran?>" required>
                                          </div>
                                      </div>

                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label>Jenis Pembayaran</label>
                                              <input type="text" value="<?php echo $row->jenis_pembayaran?>" name="jenis_pembayaran" class="form-control" readonly required>
                                              <!-- <select name="jenis_pembayaran" id="jenisPembayaran" class="form-control" required> -->
                                                  <!-- <option value="" disabled selected>-Pilih-</option> -->
                                              <!-- </select> -->
                                          </div>

                                          <!-- <div id="kredit" class="jenis" style="display: none">
                                              <div class="form-group">
                                                  <label>Periode Awal</label>
                                                  <input type="date" class="form-control" name="periode_awal" value="" id="periodeAwal">
                                              </div>
                                              <div class="form-group">
                                                  <label>Periode Akhir</label>
                                                  <input type="date" class="form-control" name="periode_akhir" value="" id="periodeAkhir">
                                              </div>
                                          </div> -->
                                          <div id="cash" class="jenis">
                                              <div class="form-group">
                                                  <label>Cara Pembayaran</label>
                                                  <select class="form-control" placeholder="" id="caraPembayaran" name="cara_pembayaran" required>
                                                      <option id="caraPembayaranOpt" disabled selected value="">-Pilih-</option>
                                                      <?php if($cara_pembayaran == "transfer"){?>
                                                        <option value="transfer" selected>Transfer</option>
                                                        <option value="cash">Cash</option>
                                                      <?php } else {?>
                                                        <option value="transfer">Transfer</option>
                                                        <option value="cash" selected>Cash</option>
                                                      <?php }?>
                                                  </select>
                                              </div>
                                              <div class="form-group">
                                                  <label>Bank</label>
                                                  <div id="showBank"></div>
                                                  <select class="form-control" placeholder="" id="bank" name="bank" required>
                                                      <option id="bankOpt" disabled selected value="">-Pilih-</option>
                                                      <?php foreach($bank as $bank){
                                                        echo "<option ";
                                                        if($row->id_bank == $bank->id_bank){
                                                          echo "selected";
                                                        } 
                                                        echo " value='$bank->id_bank'>$bank->id_bank-$bank->nama_bank</option>";
                                                      }?>
                                                  </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="exampleFormControlFile1">Bukti Pengeluaran (Jika Ada)</label> <br>
                                              <?php if($row->file_name != ""){?>
                                                <img src="<?php echo base_url()?>gambar/pengeluaran/<?php echo $row->file_name?>" style="width: 500px; height 250px">
                                              <?php }?>
                                              <input type="file" name="berkas" class="form-control-file" id="exampleFormControlFile1">
                                          </div>
                                      </div>
                                  <!-- </div>
                              <div class="form-check">
                                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
                              </div> -->
                                  </div>
                              </div>
                              <!-- /.card-body -->

                              <div class="card-footer">
                                  <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><?php }?>
                                  <?php if(isset($succ_msg)){?>
                                      <span style="color: green"><?php echo $succ_msg?></span><br>
                                  <?php }?>
                                  <?php if(isset($err_msg)){?>
                                      <span style="color: red"><?php echo $err_msg?></span><br>
                                  <?php }?>

                                  <input type="hidden" value="<?php echo $row->file_name?>" name="old">
                                  <input type="hidden" value="<?php echo $row->id_pengeluaran?>" name="id">
                                  <input type="submit" class="btn btn-primary" value="Update" />
                                  <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran" class="btn btn-primary">Tambah Baru</a>
                              </div>
                          <?php echo form_close();?>
                      </div>
                  </div>
                  <!-- /.card -->
              </div>
          <!-- /.row -->
          </div><!-- /.container-fluid -->
      </section>
    <?php }} else {?>
    <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <div class="row">
              <!-- left column -->
                  <div class="col-md-12">
                      <!-- general form elements -->
                      <div class="card">
                      <!-- /.card-header -->
                        <div class="card-header">
                            <?php if($st == "borongan"){?>
                                <a class="btn btn-info btn-sm btn-flat" href="<?php echo base_url()?>Dashboard/kbk_pencairan_dana_borongan_management">Kembali</a>
                            <?php } else { ?>
                                <a class="btn btn-info btn-sm btn-flat" href="<?php echo base_url()?>Dashboard/kbk_pencairan_dana_harian_management">Kembali</a>
                            <?php }?>
                            <br>
                            <?php if(isset($succ_msg)){
                                echo "<span style='color: green'>$succ_msg</span>";
                            }?>
                        </div>
                      <!-- form start -->
                          <!-- <form role="form" action="<?php echo base_url()?>Dashboard/add_pengeluaran" method="post" enctype="multipart/form-data"> -->
                          <?php echo form_open_multipart('Dashboard/add_pencairan_nominal_kontrak');?>
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label>Perumahan</label>
                                              <!-- <select class="form-control" name="kode_perumahan" id="kodePerumahan" required>
                                                  <option selected disabled value="">-Pilih-</option>
                                                  <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                                                      <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->kode_perumahan."-".$perumahan->nama_perumahan?></option>
                                                  <?php }?>
                                              </select> -->
                                              <input type="text" value="<?php echo $kode?>" name="kode_perumahan" class="form-control" readonly >
                                          </div>
                                          <div class="form-group">
                                              <label>No Kwitansi</label>
                                              <input type="text" class="form-control" placeholder="No Kwitansi" name="no_kwitansi" readonly value="<?php echo $no_kwitansi?>" id="kwitansi" required>
                                              <span id="resp"></span>
                                          </div>
                                          <div class="form-group">
                                              <label>Penerima</label>
                                              <input type="text" class="form-control" placeholder="Terima oleh" name="terima_oleh" value="<?php echo $penerima?>" required>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label>Kategori Pengeluaran</label>
                                              <select class="form-control category" name="kategori_pengeluaran" required>
                                                  <option selected disabled value="">-Pilih-</option>
                                                  <?php 
                                                      $query = $this->db->get('keuangan_kode_induk_pengeluaran');
                                                      foreach($query->result() as $kode){
                                                  ?>
                                                      <option value="<?php echo $kode->kode_induk?>"><?php echo $kode->kode_induk."-".$kode->nama_induk?></option>
                                                  <?php }?>
                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <!-- <div></div> -->
                                              <label>Jenis Pengeluaran</label>
                                              <select class="form-control" id="response" name="jenis_pengeluaran" required>
                                                  <option selected disabled value="">-Pilih-</option>
                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <label>Keterangan Pembayaran</label>
                                              <textarea class="form-control" placeholder="Keterangan Pengeluaran" name="keterangan_pengeluaran" value="" required><?php echo $keterangan?></textarea>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label>Nilai Pengeluaran</label>
                                              <input type="text" class="form-control" value="<?php echo "Rp. ".number_format($nilai_pengeluaran)?>" readonly>
                                              <input type="hidden" readonly class="form-control" placeholder="Nilai Pengeluaran" name="nilai_pengeluaran" value="<?php echo $nilai_pengeluaran?>" required>
                                          </div>
                                          <div class="form-group">
                                              <label>Tanggal Pengeluaran</label>
                                              <input type="date" class="form-control" placeholder="" name="tgl_pengeluaran" value="<?php echo date('Y-m-d')?>" required>
                                          </div>
                                      </div>

                                      <div class="col-md-3">
                                          <!-- <div class="form-group">
                                              <label>Jenis Pembayaran</label>
                                              <select name="jenis_pembayaran" id="jenisPembayaran" class="form-control" required>
                                                  <option value="" disabled selected>-Pilih-</option>
                                                  <option value="cash">Cash</option>
                                                  <option value="kredit">Kredit</option>
                                              </select>
                                          </div> -->

                                          <!-- <div id="kredit" class="jenis" style="display: none">
                                              <div class="form-group">
                                                  <label>Periode Awal</label>
                                                  <input type="date" class="form-control" name="periode_awal" id="periodeAwal" required>
                                              </div>
                                              <div class="form-group">
                                                  <label>Periode Akhir</label>
                                                  <input type="date" class="form-control" name="periode_akhir" id="periodeAkhir" required>
                                              </div>
                                          </div> -->
                                          <div id="cash" class="jenis" style="">
                                              <div class="form-group">
                                                  <label>Cara Pembayaran</label>
                                                  <select class="form-control" placeholder="" id="caraPembayaran" name="cara_pembayaran" required>
                                                      <option id="caraPembayaranOpt" disabled selected value="">-Pilih-</option>
                                                      <option value="transfer">Transfer</option>
                                                      <option value="cash">Cash</option>
                                                  </select>
                                              </div>
                                              <div class="form-group">
                                                  <label>Bank</label>
                                                  <div id="showBank"></div>
                                                  <select class="form-control" placeholder="" id="bank" name="bank" required>
                                                      <option id="bankOpt" disabled selected value="">-Pilih-</option>
                                                      <?php foreach($bank as $bank){?>
                                                          <option value="<?php echo $bank->id_bank?>"><?php echo $bank->id_bank."-".$bank->nama_bank?></option>
                                                      <?php }?>
                                                  </select>
                                              </div>
                                          </div>
                                      </div>

                                      <!-- <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="exampleFormControlFile1">Bukti Pengeluaran (Jika Ada)</label>
                                              <input type="file" name="berkas" class="form-control-file" id="exampleFormControlFile1">
                                          </div>
                                      </div> -->
                                  <!-- </div>
                              <div class="form-check">
                                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
                              </div> -->
                                  </div>
                              </div>
                              <!-- /.card-body -->

                              <div class="card-footer">
                                  <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><?php }?>
                                  <?php if(isset($succ_msg)){?>
                                      <span style="color: green"><?php echo $succ_msg?></span><br>
                                  <?php }?>
                                  <?php if(isset($err_msg)){?>
                                      <span style="color: red"><?php echo $err_msg?></span><br>
                                  <?php }?>

                                  <input type="hidden" value="<?php echo $st?>" name="st">
                                  <input type="submit" class="btn btn-primary" value="Submit" />
                                  <!-- <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran" class="btn btn-primary">Tambah Baru</a> -->
                              </div>
                          <?php echo form_close();?>
                      </div>
                  </div>
                  <!-- /.card -->
              </div>
          <!-- /.row -->
          </div><!-- /.container-fluid -->
      </section>
    <?php }?>
    <!-- /.content -->
    
    
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="buktiPengeluaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Bukti Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="img" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>
  
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
<!-- bs-custom-file-input -->
<script src="<?php echo base_url()?>asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});

$(document).ready(function(){
    $("select.category").change(function(){
        var selectedCountry = $(".category option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_jenis_pengeluaran",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response").html(data);
        });
    });
    $("select.category2").change(function(){
        var selectedCountry = $(".category2 option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_jenis_pengeluaran",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response2").html(data);
        });
    });

    $("#kwitansi").on("input", function(){
      var selectedCountry = $(this).val();
      var kode = $("#kodePerumahan").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/check_kwitansi_pengeluaran",
            data: { country : selectedCountry, kode : kode } 
        }).done(function(data){
            $("#resp").html(data);
        });
    })
});

$(document).ready(function () {
    $("#caraPembayaran").change(function(){
        var selectedCountry = $(this).val();

        if(selectedCountry=="transfer"){
            $("#bank").removeAttr('required');
            $("#bank").removeAttr('disabled');
            $("#showBank").empty();
            $("#bank").attr('required', 'required');
            // $("#bank").html('<option disabled selected value="">-Pilih-</option><option value="transfer">Transfer</option><option value="cash">Cash</option>');
        } else {
            $("#bank").attr('disabled', 'disabled');
            $("#bank").removeAttr('required');
            $("#bank").val("");
            $("#showBank").append('<input type="hidden" name="bank" value="">');
            // $("#bank").html('<option value="" disabled>-Pilih-</option>');
        }
    });

    $('#jenisPembayaran').on("change", function(){
        var jenis = $(this).val();

        if(jenis == "kredit"){
            $('#caraPembayaran').removeAttr('required');
            $('#bank').removeAttr('required');

            $('#periodeAwal').attr('required', 'required');
            $('#periodeAkhir').attr('required', 'required');
        } else {
            $('#periodeAwal').removeAttr('required');
            $('#periodeAkhir').removeAttr('required');

            $('#caraPembayaran').attr('required', 'required');
            $('#bank').attr('required', 'required');
        }
    })
});

$('#buktiPengeluaran').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-src');
    // var myRoomNumber1 = $(e.relatedTarget).attr('data-terimaOleh');
    $(this).find('#img').html('<img src="<?php echo base_url()?>/gambar/pengeluaran/'+myRoomNumber+'" style="width: 700px; height: 400px" alt="Bukti">');
    // $(this).find('.noSHM').value(myRoomNumber);
    // $(this).find('.terimaOleh').text(myRoomNumber1);
});

$('#jenisPembayaran').change(function(){
    // $('#showJenisPembayaran').empty();
    $('.jenis').hide();
    $('#' + $(this).val()).show();

    if($(this).val() == "kredit"){
      $('#caraPembayaranOpt').removeAttr('disabled');
      $('#bankOpt').removeAttr('disabled');

      // $('#caraPembayaran').val("");
      // $('#bank').val("");

      $('#periodeAwal').attr('required', 'required');
      $('#periodeAkhir').attr('required', 'required');

      $('#caraPembayaran').removeAttr("required");
      $('#bank').removeAttr("required");
    } else {
      $('#caraPembayaran').attr("required", "required");
      $('#bank').attr("required", "required");

      $('#periodeAwal').removeAttr('required');
      $('#periodeAkhir').removeAttr('required');

      // $('#periodeAwal').val('');
      // $('#periodeAkhir').val('');

      $('#caraPembayaranOpt').attr('disabled', 'disabled');
      $('#bankOpt').attr('disabled', 'disabled');
    }
});
</script>
<!-- jQuery -->
<!-- // <script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script> -->
<!-- Bootstrap 4 -->
<!-- <script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<!-- DataTables -->

<!-- AdminLTE App -->
<!-- <script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url()?>asset/dist/js/demo.js"></script> -->
<!-- page script -->
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
      "scrollX": true
    });
    $('#datepicker').datepicker();
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
