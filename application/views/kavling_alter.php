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
            <h1>Form Perpanjangan Pembayaran Konsumen</h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Form Perpanjangan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <?php foreach($ppjb->result() as $row){?>
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
                            <a class="btn btn-info btn-sm btn-flat" href="<?php echo base_url()?>Dashboard/kavling_management">Kembali</a>
                            <br>
                            <?php if(isset($succ_msg)){
                                echo "<span style='color: green'>$succ_msg</span>";
                            }?>
                        </div>

                        <?php echo form_open_multipart('Dashboard/generate_tempo_kavling');?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Penambahan Biaya (Rp.)</label>
                                        <input type="number" class="form-control" placeholder="0" name="tambah_biaya" value="<?php echo $row->penambahan_biaya?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Jumlah Penambahan Angsuran (x)</label>
                                        <input type="number" class="form-control" placeholder="0" name="jumlah_biaya" value="<?php echo $row->lama_penambahan?>">
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <label>Cara Pembayaran</label> -->
                                        
                                        <!-- <input type="submit" style="margin-top: 25px" class="btn btn-success btn-sm" value="OK"> -->
                                    </div>

                                    <div class="col-md-3">

                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        <?php 
                        // echo form_close();?>
                            
                        <?php 
                        // echo form_open_multipart('Dashboard/add_penambahan_tempo');?>

                            <div class="card-footer">
                                <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><?php }?>
                                <?php if(isset($succ_msg)){?>
                                    <span style="color: green"><?php echo $succ_msg?></span><br>
                                <?php }?>
                                <?php if(isset($err_msg)){?>
                                    <span style="color: red"><?php echo $err_msg?></span><br>
                                <?php }?>

                                <input type="hidden" name="id" value="<?php echo $id?>">
                                <input type="hidden" name="kode" value="<?php echo $kode?>">
                                <input type="submit" class="btn btn-primary" value="Submit" />
                                <!-- <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran" class="btn btn-primary">Tambah Baru</a> -->
                            </div>
                        <?php echo form_close();?>
                    </div>

                    <!-- form start -->
                    <div class="card">
                        <div class="col-md-12">
                            <h4 style="font-weight: bold;">Pembayaran Sebelumnya</h4>
                            <table class="table">
                                <thead style="color: blue">
                                    <td>Tahap Pembayaran</td>
                                    <td>Tanggal Pembayaran</td>
                                    <td>Jumlah Pembayaran</td>
                                </thead>
                            <tbody>
                            <form action="<?php echo base_url()?>Dashboard/edit_kavling_dp_alter" method="POST">
                                <?php if($row->status == "dom"){?>
                                    <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input type="hidden" value="<?php echo $id?>" name="id">
                                        <input type="hidden" value="<?php echo $kode?>" name="kode">
                                        <input type="submit" value="Edit">
                                    </td>
                                    </tr>
                                    <?php ?>
                                    <?php $total_terkini=0; foreach($this->db->get_where('ppjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$kode))->result() as $row2){?>
                                    <?php 
                                        $total_terkini = $total_terkini+$row2->dana_masuk;
                                        $gt_check = $this->db->get_where('keuangan_kas_kpr', array('id_ppjb'=>$row2->id_psjb)); 
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row2->cara_bayar?>
                                            <?php if($row2->cara_bayar != "Uang Tanda Jadi"){?>
                                                <input type="hidden" name="id_psjb[]" value="<?php echo $row2->id_psjb?>" <?php if($gt_check->num_rows() > 0){echo "disabled";}?>>
                                                <input type="hidden" name="cara_bayar[]" value="<?php echo $row2->cara_bayar?>" <?php if($gt_check->num_rows() > 0){echo "disabled";}?>>
                                            <?php }?>
                                        </td>
                                        <td>
                                            <?php echo $row2->tanggal_dana?>
                                            <?php if($row2->cara_bayar != "Uang Tanda Jadi"){?>
                                            <input type="date" name="tanggal_dana[]" class="form-control" value="<?php echo $row2->tanggal_dana?>" <?php if($gt_check->num_rows() > 0){echo "disabled";}?>>
                                            <?php }?>
                                        </td>
                                        <td>
                                            Rp. <?php echo number_format($row2->dana_masuk)?>,-
                                            <?php if($row->status == "dom" && $row2->cara_bayar != "Uang Tanda Jadi"){?>
                                            <input type="number" class="form-control qty1" value="<?php echo $row2->dana_masuk?>" id="dana_masuk" name="dana_masuk[]" <?php if($gt_check->num_rows() > 0){echo "disabled";}?>>
                                            <?php } ?>
                                            <?php if($row2->cara_bayar != "Uang Tanda Jadi"){?>
                                            <input type="hidden" value="<?php echo $row2->no_ppjb?>" name="no_ppjb[]" <?php if($gt_check->num_rows() > 0){echo "disabled";}?>>
                                            <input type="hidden" value="<?php echo $row2->persen?>" name="persen[]" <?php if($gt_check->num_rows() > 0){echo "disabled";}?>>
                                            <input type="hidden" value="<?php echo $row2->status?>" name="status[]" <?php if($gt_check->num_rows() > 0){echo "disabled";}?>>
                                            <?php }?>
                                        </td>
                                        <?php if($row2->status != "lunas"){?>
                                            <!-- <td><a class="btn btn-outline-success btn-flat btn-sm" href="<?php echo base_url()?>Dashboard/detail_custom_biaya_psjb?id=<?php echo $row2->id_psjb?>">Edit</a></td> -->
                                        <?php }?>
                                    </tr>
                                    <?php }?>
                                    <input type="hidden" id="total" class="totals" value="<?php echo $row->harga_jual?>" name="total">
                                    <input type="hidden" value="<?php echo $row->harga_jual?>" name="totals">
                                    </form> 
                                
                                    <tr style="background-color: lightgrey">
                                        <td colspan=2 style="text-align: center">Total Terkini</td>
                                        <td>Rp. <?php echo number_format($total_terkini)?>,-</td>
                                    </tr>
                                    <!-- <tr style="background-color: lightgrey">
                                        <td colspan=2 style="text-align: center">Total Jual</td>
                                        <td>Rp. <?php echo number_format($row->total_jual-$total_terkini)?>,-</td>
                                    </tr> -->
                                    <?php } else {?>
                                        <?php $total_terkini=0; foreach($this->db->get_where('ppjb-dp', array('no_psjb'=>$id, 'kode_perumahan'=>$row->kode_perumahan))->result() as $row2){?>
                                        <?php 
                                            $total_terkini = $total_terkini+$row2->dana_masuk;
                                        ?>
                                        <tr>
                                            <td><?php echo $row2->cara_bayar?></td>
                                            <td><?php echo $row2->tanggal_dana?></td>
                                            <td>Rp. <?php echo number_format($row2->dana_masuk)?>,-</td>
                                        </tr>
                                        <?php }?>
                                    <?php }?>
                                    <tr style="background-color: ">
                                        <td colspan=2 style="text-align: center">Total Pembayaran</td>
                                        <td>
                                        Rp. <?php echo number_format($row->total_jual)?>,-
                                        <?php if($row->status == "dom"){?>
                                            <input type="text" id="total" value="<?php echo number_format($row->total_jual)?>" readonly class="total form-control">
                                        <?php }?>
                                        </td>
                                    </tr>
                                    <tr style="background-color: lightgrey">
                                        <td colspan=2 style="text-align: center">Total Jual</td>
                                        <td>Rp. <?php echo number_format($row->total_jual-$total_terkini)?>,-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <h4 style="font-weight: bold;">Rincian Harga Terbayar</h4>
                            <table class="table">
                                <tbody>
                                    <tr style="background-color: lightpink">
                                    <td>Harga Sepakat</td>
                                    <td>Rp. <?php echo number_format($row->total_jual)?>,-</td>
                                    </tr>
                                    <tr>
                                    <td>Nilai Terbayar (Tanda Jadi)</td>
                                    <td>Rp. <?php echo number_format($row->uang_awal)?>,-</td>
                                    </tr>
                                    <hr>
                                    <tr style="background-color: lightpink">
                                    <td>Total Sisa Utang</td>
                                    <td>Rp. <?php echo number_format($row->total_jual-$row->uang_awal)?>,-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <form role="form" action="<?php echo base_url()?>Dashboard/add_pengeluaran" method="post" enctype="multipart/form-data"> -->
                        
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
</script>
</body>
</html>
