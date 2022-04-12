<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | General Form Elements</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="<?php echo base_url()?>assets/dist/dropzone.css" type="text/css" rel="stylesheet" />
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
            <h1>Pembelian Bahan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Pembelian Bahan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    
    <!-- Main content -->
    <?php if(isset($edit_perumahan)) {
        foreach($edit_perumahan as $row){?>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
            <!-- left column -->
                    <div class="col-md-12">
                <!-- general form elements -->
                        <div class="card card-primary">
                <!-- /.card-header -->
                <!-- form start -->
                            <form role="form" action="<?php echo base_url()?>Dashboard/edit_perumahan" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>No Kwitansi</label>
                                                <input type="text" class="form-control" placeholder="No Kwitansi" name="no_kwitansi" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Terima dari</label>
                                                <input type="text" class="form-control" placeholder="Terima dari" name="terima_dari" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Keterangan Penerimaan</label>
                                                <textarea class="form-control" placeholder="Keterangan Penerimaan" name="keterangan_penerimaan" value="" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Nilai Penerimaan</label>
                                                <input type="number" class="form-control" placeholder="Nilai Penerimaan" name="nilai_penerimaan" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tanggal Penerimaan</label>
                                                <input type="date" class="form-control" placeholder="" name="tgl_penerimaan" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Pembayaran</label>
                                                <select class="form-control" placeholder="" name="jenis_pembayaran" required>
                                                    <option disabled selected value="">-Pilih-</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Bank</label>
                                                <select class="form-control" placeholder="" name="bank" required>
                                                    <option disabled selected value="">-Pilih-</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <?php if(isset($succ_msg)){?>
                                        <span style="color: green"><?php echo $succ_msg?></span><br>
                                    <?php }?>
                                    <?php if(isset($err_msg)){?>
                                        <span style="color: red"><?php echo $err_msg?></span><br>
                                    <?php }?>
                                    <input type="hidden" value=<?php echo $id?> name="id">
                                    <input type="submit" class="btn btn-primary" value="Submit" />
                                    <a href="<?php echo base_url()?>Dashboard/penerimaan_lain" class="btn btn-primary">Tambah Baru</a>
                                </div>
                            </form>
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
                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        <h4>Data Pembelian</h4>
                                    </div>
                                    <div class="col-6" style="text-align: right">
                                        <a href="<?php echo base_url()?>Dashboard/view_rekap_arus_stok" class="btn btn-flat btn-sm btn-success">Rekap Stok (Pendaftaran Barang)</a>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_open_multipart('Dashboard/add_pembelian_bahan');?>
                            <!-- <form role="form" method="POST" action="<?php echo base_url()?>Dashboard/add_pembelian_bahan" enctype="multipart/form-data"> -->
                            <div class="card-body">
                                <div class="col-md-12">
                                    
                                    <div class="row">
                                            <!-- <div class="row"> -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No Faktur</label>
                                                <input type="text" class="form-control" name="no_faktur" id="noFaktur" required>
                                                <div id="response" class="response"></div>
                                                <div id="responded"></div>
                                            </div>
                                            <div class="form-group">
                                                <label>Toko Bangunan</label>
                                                <select class="form-control" name="toko_bangunan" required>
                                                    <option value="" disabled selected>-Pilih-</option>
                                                    <?php foreach($toko->result() as $tokos) {?>
                                                        <option value="<?php echo $tokos->nama_data?>"><?php echo $tokos->nama_data?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Perumahan</label>
                                                <select class="form-control" name="kode_perumahan" required>
                                                    <option value="" disabled selected>-Pilih-</option>
                                                    <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                                                        <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Pesan</label>
                                                <input type="date" class="form-control" name="tanggal_pesan" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Jatuh Tempo</label>
                                                <input type="date" class="form-control" name="tanggal_tempo" required>
                                            </div>
                                            <!-- <div class="form-group">
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
                                                <label>Jenis Pengeluaran</label>
                                                <select class="form-control" id="response" name="jenis_pengeluaran" required>
                                                    <option selected disabled value="">-Pilih-</option>
                                                </select>
                                            </div> -->
                                        </div>
                                            <!-- </div> -->
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Upload Faktur (Opsional)</label>
                                    <input type="file" class="form-control" name="berkas">
                                </div>

                                    <hr>
                                <div class="col-md-12">
                                    <div style="text-align: right; background-color: lightyellow; padding-top: 10px; padding-bottom: 10px; padding-right: 10px">
                                        <button type="button" class="btn btn-sm btn-default add" id="add">+</button>
                                        <button type="button" class="btn btn-sm btn-default remove" id="remove">-</button>
                                    </div>
                                </div>
                                <div id="mainKredit">
                                    <hr>
                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-3">
                                            <label>Nama Bahan</label>
                                            <select class="form-control" id="namaBahan" name="nama_bahan[]" required>
                                                <option value="" disabled selected>-Pilih-</option>
                                                <?php foreach($barang->result() as $barangs) {?>
                                                    <option value='<?php echo $barangs->nama_data?>'><?php echo $barangs->nama_data?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Qty</label>
                                            <input type="number" name="qty[]" class="form-control" id="qty" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Satuan</label>
                                            <input type="text" class="form-control" id="response" name="satuan[]" readonly required>
                                            <!-- <select name="satuan[]" class="form-control" required>
                                                <option value="" disabled selected>-Pilih-</option>
                                                <?php foreach($satuan->result() as $satuans){?>
                                                    <option value="<?php echo $satuans->nama_data?>"><?php echo $satuans->nama_data?></option>
                                                <?php }?>
                                            </select> -->
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Harga Satuan</label>
                                            <input type="number" class="form-control" name="harga_satuan[]" id="hargaSatuan" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Total</label>
                                            <input type="number" class="form-control" id="total" value="0" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="buttonbox"></div>
                                <div class="col-md-12 row">
                                    <div class="col-md-8">

                                    </div>
                                    <div class="col-md-1">
                                        <label>Sub Total</label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="text" id="totalAll" class="form-control" readonly>
                                    </div>
                                </div>
                                <input type="hidden" id="total_chq_kredit" class="total_chq_kredit">
                            </div>
                            <div class="card-footer">
                                <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><?php }?>
                                <?php if(isset($succ_msg)){?>
                                    <span style="color: green"><?php echo $succ_msg?></span><br>
                                <?php }?>
                                <?php if(isset($err_msg)){?>
                                    <span style="color: red"><?php echo $err_msg?></span><br>
                                <?php }?>
                                <input type="submit" class="btn btn-flat btn-success btn-sm" value="Tambah">
                            </div>
                            
                            </form>
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example3" class="table table-bordered table-striped" style="font-size: 13px">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Perumahan</th>
                      <th>No Faktur</th>
                      <th>Nama Toko</th>
                      <th>Tgl Pesan</th>
                      <th>Jatuh Tempo</th>
                      <th>Total Pembelian</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($check_all->result() as $row){?>
                        <tr>
                            <td><?php echo $no?></td>
                            <td><?php echo $row->kode_perumahan?></td>
                            <td><?php echo $row->no_faktur?></td>
                            <td><?php echo $row->nama_toko?></td>
                            <td><?php echo $row->tanggal_pesan?></td>
                            <td><?php echo $row->tanggal_tempo?></td>
                            <?php $total = 0; $nominal = 0;
                                foreach($this->db->get_where('produksi_transaksi', array('no_faktur'=>$row->no_faktur, 'kode_perumahan'=>$row->kode_perumahan))->result() as $prod){
                                    $nominal = $prod->qty * $prod->harga_satuan;
                                    $total = $total + $nominal;
                            }?>
                            <td>
                                <?php echo "Rp. ".number_format($total);?>
                            </td>
                            <td>
                                <!-- <a href="<?php echo base_url()?>Dashboard/pembayaran_pembelian?id=<?php echo $row->id_transaksi?>" class="btn btn-outline-primary btn-sm btn-flat">Bayar</a> -->
                                <a href="<?php echo base_url()?>Dashboard/detail_pembelian_bahan?id=<?php echo $row->id_transaksi?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                            </td>
                        </tr>
                    <?php $no++;}?>
                  </tbody>
                </table>
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

<script src="<?php echo base_url()?>assets/dropzone-5.7.0/dist/dropzone.js"></script>

<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
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
<script type="text/javascript">
  $(function () {
    $("#date").datepicker();
    $("#checkout").datepicker();
    $('.selectpicker').selectpicker();
  });
  // $(function() {

      
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    
  // });
  $(document).ready(function() {
    var i = 0;
    var last1 = $('.buttonbox').last();
    $(document).on('click', '.add', function() {
      var clone = $('#mainKredit').clone().find("input").val("").end().find("textarea").val("").end().find('select option:first-child()').attr('selected','selected').end().attr("id", "mainKredit" + ++i).insertBefore(last1);
          
      // $('#main'+i++).attr('id', 'nominalDebet'+i++);
        // clone.id = "main" + i;
    //   $('#mainKredit input[id="total"]').val(i);
      $('#total_chq_kredit').val(i);
      $('#mainKredit'+i+' #total').val(0);
      
    //   var x = 1;
        $(function () {
            // var check = $('#check').val();

            for (var x = 1; x <= i; x++) {
            (function (x) {
                $('#mainKredit'+x+' input[id="qty"]').on("input", function () {
                    var qty = $(this).val();
                    var hargaSatuan = $('#mainKredit'+x+' input[id="hargaSatuan"').val();

                    $('#mainKredit'+x+' input[id="total"').val(qty*hargaSatuan);

                    var sum = 0;
                    $("input[id='total']").each(function(){
                        sum += +$(this).val();
                    });
                    $("#totalAll").val(numberWithCommas(sum));
                });
            })(x);
            }
        });

        $(function () {
            // var check = $('#check').val();

            for (var y = 1; y <= i; y++) {
            (function (y) {
                $("#mainKredit"+y+ " select#namaBahan").change(function(){
                    var selectedCountry = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url()?>Dashboard/get_satuan",
                        data: { country : selectedCountry } 
                    }).done(function(data){
                        $("#mainKredit"+y+ " input[id='response']").val(data);
                    });
                });
            })(y);
            }
        });

        $(function () {
            // var check = $('#check').val();

            for (var z = 1; z <= i; z++) {
            (function (z) {
                $('#mainKredit'+z+' input[id="hargaSatuan"]').on("input", function () {
                  var qty = $(this).val();
                  var hargaSatuan = $('#mainKredit'+z+' input[id="qty"]').val();

                  $('#mainKredit'+z+' input[id="total"]').val(qty*hargaSatuan);

                  var sum = 0;
                    $("input[id='total']").each(function(){
                        sum += +$(this).val();
                    });
                    $("#totalAll").val(numberWithCommas(sum));
                });
            })(z);
            }
        });
    });

    
      $(".remove").click(function(){
        if(i > 0) {
          var ch = $('div[id^="mainKredit"]:last #total').val();
          var ttl = $('#totalAll').val()

          $('#totalAll').val(numberWithCommas(parseInt(ch) - parseInt(ttl)));

          $('div[id^="mainKredit"]:last').remove();
          $('#total_chq_kredit').val(--i);
        } 
      });
  });

  $('#qty').on('input', function(){
      var qty = $(this).val();
      var hargaSatuan = $('#hargaSatuan').val();

      $('#total').val(qty*hargaSatuan);
    //   $('#totalAll').

        var sum = 0;
        $("input[id='total']").each(function(){
            sum += +$(this).val();
        });
        $("#totalAll").val(numberWithCommas(sum));
  });

  $('#hargaSatuan').on('input', function(){
      var qty = $(this).val();
      var hargaSatuan = $('#qty').val();

      $('#total').val(qty*hargaSatuan);

      var sum = 0;
        $("input[id='total']").each(function(){
            sum += +$(this).val();
        });
        $("#totalAll").val(numberWithCommas(sum));
  });

    $("select#namaBahan").change(function(){
        var selectedCountry = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_satuan",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("input[id='response']").val(data);
        });
    });

  $(function () {
      var check = $('#total_chq_kredit').val();
      
      // alert(check);

      for (var x = 1; x <= check; x++) {
        (function (i) {
            $('#mainKredit'+x+' input[id="qty"]').on("input", function () {
                var qty = $(this).val();
                var hargaSatuan = $('#mainKredit'+x+' input[id="hargaSatuan"]').val();

                $('#mainKredit'+x+' input[id="total"').val(qty*hargaSatuan);
            });
        })(i);
      }
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
    $("#noFaktur").on("input", function(){
        var faktur = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_nofaktur",
            data: { faktur : faktur }
        }).done(function(data){
            $('#response').html(data);
        })
    })

    $("#noFaktur").on("input", function(){
        var faktur = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_nofaktur_list",
            data: { faktur : faktur }
        }).done(function(data){
            $('#responded').html(data);
        })
    })
  });
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": false,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $("#example3").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      'scrollX': true
    });
  });
</script>
</body>
</html>
