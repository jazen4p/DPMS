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
  <?php foreach($check_all->result() as $row){?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1>Detail Kontrak Kerja Borongan <?php echo strtoupper($row->kategori)?></h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Detail Kontrak Kerja Borongan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
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
                            <a href="<?php echo base_url()?>Dashboard/kontrak_management" class="btn btn-success btn-flat btn-sm">Kembali</a>
                        </div>

                        <div class="card-body">
                            <div class="col-md-12">
                                <h4 style="font-weight: bold">Informasi Kontrak</h4>  
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Nomor Kontrak</td>
                                            <td><?php echo $row->kode_perumahan."-".sprintf('%03d', $row->no_kontrak);?></td>
                                        </tr>
                                        <tr><td>Kategori</td><td><?php echo $row->kategori?></td></tr>
                                        <tr><td>Proyek/Perumahan</td><td><?php echo $nama_perumahan?></td></tr>
                                        <tr><td>Nama Tukang</td><td><?php echo $row->nama_tukang?></td></tr>
                                        <tr><td>Unit</td><td><?php echo $row->no_unit?></td></tr>
                                        <tr><td>Tipe Unit</td><td><?php echo $row->type_unit?> m<sup>2</sup></td></tr>
                                        <tr><td>Nilai Kontrak</td><td><?php echo "Rp. ".number_format($row->nilai_kontrak)?></td></tr>
                                        <tr><td>Keterangan Pekerjaan</td><td><?php echo $row->pekerjaan_ket?></td></tr>
                                        <tr><td>Masa Kerja</td><td><?php echo $row->masa_kerja?> Hari</td></tr>
                                        <tr><td>Tgl Mulai Kerja</td><td><?php echo date('D, d F Y', strtotime($row->mulai_kerja));?></td></tr>
                                        <tr><td>Tgl Selesai Kerja</td><td><?php echo date('D, d F Y', strtotime($row->selesai_kerja));?></td></tr>
                                    </tbody>
                                </table>
                                <!-- /.chart-responsive -->
                            </div>

                            <div class="col-md-12">
                                <h4 style="font-weight: bold">Detail Pembayaran</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <th>No</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Jumlah Pembayaran</th>
                                    </thead>
                                    <tbody>
                                        <?php $ttls=0; $no=1; foreach($detail_pembayaran->result() as $byr){?>
                                            <tr>
                                                <td><?php echo $no;?></td>
                                                <td><?php echo date('d F Y', strtotime($byr->tgl_pencairan))?></td>
                                                <td><?php echo "Rp. ".number_format($byr->nominal)?></td>
                                            </tr>
                                        <?php $no++; $ttls = $ttls + $byr->nominal;}?>
                                        <tr style="background-color: lightgrey">
                                            <td colspan=2>Total Nilai Kontrak</td>
                                            <td><?php echo "Rp. ".number_format($row->nilai_kontrak)?></td>
                                        </tr>
                                        <tr style="background-color: pink">
                                            <td colspan=2>Total Pembayaran</td>
                                            <td><?php echo "Rp. ".number_format($ttls)?></td>
                                        </tr>
                                        <tr style="background-color: lightgrey">
                                            <td colspan=2>Sisa Nilai Kontrak</td>
                                            <td><?php echo "Rp. ".number_format($row->nilai_kontrak - $ttls)?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php if(isset($kontrak_sendback)){?>
                      <form action="<?php echo base_url()?>Dashboard/sendback_kontrak_kerja" method="POST">
                        <div class="card">
                          <div class="card-body">
                            <div class="form-group row">
                              <label class="col-sm-2">Keterangan</label>
                              <textarea class="form-control col-sm-6" name="ket"></textarea>
                            </div>
                          </div>
                          <div class="card-footer">
                            <input type="hidden" value="<?php echo $id?>" name="id">

                            <input type="submit" class="btn btn-success btn-flat btn-sm">
                          </div>
                        </div>
                      </form>
                    <?php }?>
                </div>
                <!-- /.card -->
            </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <?php }?>
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
