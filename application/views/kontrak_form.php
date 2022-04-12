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
          <div class="col-sm-8">
            <h1>Form Kontrak Kerja Borongan</h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Form Kontrak Kerja Borongan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <?php if(isset($edit_kontrak)){
      foreach($edit_kontrak->result() as $row){?>
      <section class="content">
          <div class="container-fluid">
              <div class="row">
              <!-- left column -->
                  <div class="col-md-12">
                      <!-- general form elements -->
                      <div class="card">
                      <!-- /.card-header -->
                          <div class="card-header">
                              <!-- <a class="btn btn-info btn-sm btn-flat" href="<?php echo base_url()?>Dashboard/ppjb_management">Kembali</a> -->
                            <a href="<?php echo base_url()?>Dashboard/kontrak_management" class="btn btn-success btn-flat btn-sm">Ke Kontrak Management</a>
                            <?php if(isset($succ_msg)){?>
                              <br>    
                              <span style='color: green'><?php echo $succ_msg?></span>
                            <?php }?>
                          </div>

                          <?php echo form_open_multipart('Dashboard/revisi_kontrak');?>
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              <label>Kategori Kontrak Kerja</label>
                                              <select class="form-control" name="kategori" required>
                                                  <!-- <option value="" disabled selected>-Pilih-</option> -->
                                                  <option value="cat" <?php if($row->kategori == "cat"){echo "selected";}?>>Cat</option>
                                                  <option value="atap" <?php if($row->kategori == "atap"){echo "selected";}?>>Atap</option>
                                                  <option value="plafond" <?php if($row->kategori == "plafond"){echo "selected";}?>>Plafond</option>
                                                  <option value="listrik" <?php if($row->kategori == "listrik"){echo "selected";}?>>Listrik</option>
                                                  <option value="groundtank" <?php if($row->kategori == "groundtank"){echo "selected";}?>>Ground Tank</option>
                                                  <option value="tambahanbangunan" <?php if($row->kategori == "tambahanbangunan"){echo "selected";}?>>Tambahan Bangunan</option>
                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <label>Proyek/Perumahan</label>
                                              <input type="text" class="form-control" name="kode_perumahan" value="<?php echo $row->kode_perumahan?>" readonly>
                                              <!-- <select name="kode_perumahan" id="perumahan" class="form-control" required>
                                                  <option value="" disabled selected>-Pilih-</option>
                                                  <?php foreach($this->db->get('perumahan')->result() as $prmh){
                                                    echo "<option ";
                                                    if($row->kode_perumahan == $prmh->kode_perumahan){
                                                      echo "selected";
                                                    }
                                                    echo " value='$prmh->kode_perumahan'>$prmh->nama_perumahan</option>";
                                                  }?>
                                              </select> -->
                                          </div>
                                          <div class="form-group">
                                              <label>No. Unit</label>
                                              <input type="text" class="form-control" name="unit" value="<?php echo $row->no_unit?>" readonly>
                                              <!-- <select id="unit" name="unit" class="form-control" required>
                                                  <option value="" disabled selected>-Pilih-</option>
                                                  <?php if(isset($row->no_unit)){?>
                                                    <option value="<?php echo $row->no_unit?>" selected><?php echo $row->no_unit?></option>
                                                  <?php }?>
                                              </select> -->
                                          </div>
                                          <div class="form-group">
                                              <label>Tipe Unit</label>
                                              <input type="text" id="tipeUnit" name="tipe_unit" class="form-control" value="<?php echo $row->type_unit?>" readonly required>
                                                  <!-- <option value="" disabled selected>-Pilih-</option>
                                              </select> -->
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Nama Tukang</label>
                                            <input type="text" class="form-control" value="<?php echo $row->nama_tukang?>" name="nama_tukang">
                                          </div>
                                          <div class="form-group">
                                            <label>Kontrak Pekerjaan</label>
                                            <textarea class="form-control" name="kontrak_pekerjaan"><?php echo $row->pekerjaan_ket?></textarea>
                                          </div>
                                          <div class="form-group">
                                            <label>Nilai Kontrak (Rp.)</label>
                                            <input type="number" class="form-control" name="nilai_pekerjaan" value="<?php echo $row->nilai_kontrak?>">
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Masa Kerja (Hari)</label>
                                          <input type="number" id="masaKerja" name="masa_kerja" class="form-control" value="<?php echo $row->masa_kerja?>">
                                        </div>
                                        <div class="form-group">
                                          <label>Tanggal Mulai</label>
                                          <input type="date" id="tglMulai" name="tgl_mulai" class="form-control" value="<?php echo $row->mulai_kerja?>">
                                        </div>
                                        <div class="form-group">
                                          <label>Tanggal Selesai</label>
                                          <input type="date" id="tglSelesai" name="tgl_selesai" class="form-control" value="<?php echo $row->selesai_kerja?>">
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              <!-- /.card-body -->
                          <?php 
                          // echo form_close();?>
                              
                          <?php 
                          // echo form_open_multipart('Dashboard/add_penambahan_tempo');?>
                              <?php if(isset($tempo)){?>

                              <?php }?>

                              <div class="card-footer">
                                  <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><?php }?>
                                  <?php if(isset($succ_msg)){?>
                                      <span style="color: green"><?php echo $succ_msg?></span><br>
                                  <?php }?>
                                  <?php if(isset($err_msg)){?>
                                      <span style="color: red"><?php echo $err_msg?></span><br>
                                  <?php }?>

                                  <input type="hidden" name="id" value="<?php echo $id?>">
                                  <!-- <input type="hidden" name="kode" value="<?php echo $kode?>"> -->
                                  <!-- <inp -->
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
    <?php }} else {?>
      <section class="content">
          <div class="container-fluid">
              <div class="row">
              <!-- left column -->
                  <div class="col-md-12">
                      <!-- general form elements -->
                      <div class="card">
                      <!-- /.card-header -->
                          <div class="card-header">
                              <!-- <a class="btn btn-info btn-sm btn-flat" href="<?php echo base_url()?>Dashboard/ppjb_management">Kembali</a> -->
                            <a href="<?php echo base_url()?>Dashboard/kontrak_management" class="btn btn-success btn-flat btn-sm">Ke Kontrak Management</a>
                            <?php if(isset($succ_msg)){?>
                              <br>    
                              <span style='color: green'><?php echo $succ_msg?></span>
                            <?php }?>
                          </div>

                          <?php echo form_open_multipart('Dashboard/add_kontrak_kerja');?>
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              <label>Kategori Kontrak Kerja</label>
                                              <select class="form-control" name="kategori" id="kategori" required>
                                                  <option value="" disabled selected>-Pilih-</option>
                                                  <option value="cat">Cat</option>
                                                  <option value="atap">Atap</option>
                                                  <option value="plafond">Plafond</option>
                                                  <option value="listrik">Listrik</option>
                                                  <option value="groundtank">Ground Tank</option>
                                                  <option value="tambahanbangunan">Tambahan Bangunan</option>
                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <label>Proyek/Perumahan</label>
                                              <select name="kode_perumahan" id="perumahan" class="form-control" required>
                                                  <option value="" disabled selected>-Pilih-</option>
                                                  <?php foreach($this->db->get('perumahan')->result() as $prmh){?>
                                                      <option value="<?php echo $prmh->kode_perumahan?>"><?php echo $prmh->nama_perumahan?></option>
                                                  <?php }?>
                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <label>No. Unit</label>
                                              <select id="unit" name="unit" class="form-control" required>
                                                  <option value="" disabled selected>-Pilih-</option>
                                              </select>
                                              <div class="resp" id="resp"></div>
                                          </div>
                                          <div class="form-group">
                                              <label>Tipe Unit</label>
                                              <input type="text" id="tipeUnit" name="tipe_unit" class="form-control" readonly required>
                                                  <!-- <option value="" disabled selected>-Pilih-</option>
                                              </select> -->
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Nama Tukang</label>
                                            <input type="text" class="form-control" name="nama_tukang" required>
                                          </div>
                                          <div class="form-group">
                                            <label>Kontrak Pekerjaan</label>
                                            <textarea class="form-control" name="kontrak_pekerjaan" required></textarea>
                                          </div>
                                          <div class="form-group">
                                            <label>Nilai/Harga Jual (Rp.) <span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="nilai_jual" required>
                                          </div>
                                          <div class="form-group">
                                            <label>Nilai Upah (Rp.)</label>
                                            <input type="number" class="form-control" name="nilai_pekerjaan" required>
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Masa Kerja (Hari)</label>
                                          <input type="number" id="masaKerja" name="masa_kerja" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                          <label>Tanggal Mulai</label>
                                          <input type="date" id="tglMulai" name="tgl_mulai" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                          <label>Tanggal Selesai</label>
                                          <input type="date" id="tglSelesai" name="tgl_selesai" class="form-control" required>
                                        </div>
                                      </div>
                                  </div>
                                <span style="color: red">* Selain tambahan bangunan, data di isi mengikuti nilai upah, Jika Kontrak Tambahan Bangunan, diisi sesuai kesepatakan konsumen.</span>
                              </div>
                              <!-- /.card-body -->
                          <?php 
                          // echo form_close();?>
                              
                          <?php 
                          // echo form_open_multipart('Dashboard/add_penambahan_tempo');?>
                              <?php if(isset($tempo)){?>

                              <?php }?>

                              <div class="card-footer">
                                  <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><?php }?>
                                  <?php if(isset($succ_msg)){?>
                                      <span style="color: green"><?php echo $succ_msg?></span><br>
                                  <?php }?>
                                  <?php if(isset($err_msg)){?>
                                      <span style="color: red"><?php echo $err_msg?></span><br>
                                  <?php }?>

                                  <!-- <input type="hidden" name="id" value="<?php echo $id?>">
                                  <input type="hidden" name="kode" value="<?php echo $kode?>"> -->
                                  <!-- <input type="hidden" name="id_kbk" value="<?php echo $id_kbk?>"> -->
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

    $("#perumahan").on("change", function(){
      var selectedCountry = $(this).val();
    //   var kode = $("#kodePerumahan").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_unit",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#unit").html(data);
        });
    })

    $("#unit").on("change", function(){
      var selectedCountry = $(this).val();
      var kode = $("#perumahan").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_tipe_unit",
            data: { country : selectedCountry, kode: kode } 
        }).done(function(data){
            $("#tipeUnit").val(data);
        });
    })
    $("#unit").on("blur", function(){
      var selectedCountry = $(this).val();
      var kode = $("#perumahan").val();
      var kat = $('#kategori').val()
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_check_unit",
            data: { country : selectedCountry, kode: kode, kat: kat } 
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

  function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).on("change", ".qty1", function() {
        var sum = 0;
        $(".qty1").each(function(){
            sum += +$(this).val();
        });
        $(".total").val(numberWithCommas(sum));
        $(".totals").val(sum);
    });

    $('#tglMulai').on("input", function(e){
    var gt = $(this).val();
    var string = $('#masaKerja').val();
    // var num = string.replace( /^\D+/g, '');

    var regex = /\d+/g;
    // var string = "you can enter maximum 500 choices";
    var matches = string.match(regex); 

    var date = new Date(gt);
    date.setDate(date.getDate() + parseInt(string));
    console.log(date);

    var day = ("0" + date.getDate()).slice(-2);
    var month = ("0" + (date.getMonth() + 1)).slice(-2);

    var today = date.getFullYear()+"-"+(month)+"-"+(day) ;

    $('#tglSelesai').val(today);
    // alert(matches);
  })
</script>
</body>
</html>
