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
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
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
            <h1>Pembayaran Pembelian Bahan No. <?php echo $id?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Pembayaran Pembelian Bahan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php foreach($check_all->result() as $prods){?>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card">
                            <div class="card-header">
                                <a href="<?php echo base_url()?>Dashboard/informasi_pengajuan_pembayaran" class="btn btn-sm btn-success">Kembali</a>
                            </div>
                            <div class="card-body">
                                <table id="" class="table table-bordered table-striped" style="font-size: 14px">
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Nama Bahan</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                        <!-- <th>Total Pembelian</th> -->
                                        <!-- <th>Aksi</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; $total=0; 
                                        $this->db->order_by('no_faktur', "ASC");
                                        foreach($this->db->get_where('produksi_transaksi', array('id_pengajuan'=>$prods->id_pengajuan))->result() as $row){?>
                                            <tr>
                                                <td><?php echo $no?></td>
                                                <td><?php echo $row->nama_barang?></td>
                                                <td><?php echo number_format($row->qty)?></td>
                                                <td><?php echo $row->nama_satuan?></td>
                                                <td><?php echo "Rp. ".number_format($row->harga_satuan)?></td>
                                                <td>
                                                    <?php echo "Rp. ".number_format($row->qty*$row->harga_satuan);?>
                                                </td>
                                            </tr>
                                        <?php $no++; $total = $total + ($row->qty*$row->harga_satuan);}?>
                                        
                                        <tr style="background-color: cyan">
                                            <td colspan=5 style="text-align: center">TOTAL PEMBELIAN</td>
                                            <td><?php echo "Rp. ".number_format($total)?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                Riwayat Pembayaran
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered" style="font-size: 14px">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl Pembayaran</th>
                                            <th>Keterangan</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; $total_byr=0; foreach($this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$row->no_faktur))->result() as $byr){?>
                                            <tr>
                                                <td><?php echo $no?></td>
                                                <td><?php echo $byr->tgl_pembayaran?>
                                                <td><?php echo $byr->keterangan?></td>
                                                <td><?php echo "Rp. ".number_format($byr->nominal)?>
                                            </tr>
                                        <?php $no++; $total_byr = $total_byr + $byr->nominal;}?>
                                        <tr>
                                            <td colspan=3 style="text-align: center; font-weight: bold">TOTAL TERBAYAR</td>
                                            <td><b><?php echo "Rp. ".number_format($total_byr);?></b></td>
                                        </tr>
                                        <tr>
                                            <td colspan=3 style="text-align: center; font-weight: bold">SISA PEMBAYARAN</td>
                                            <td>
                                                <b><?php echo "Rp. ".number_format($total-$total_byr);?></b>
                                                <input type="hidden" id="sisaBayar" value="<?php echo $total-$total_byr?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                        <!-- /.card-header -->
                        <!-- form start -->
                            <!-- <form role="form" action="<?php echo base_url()?>Dashboard/add_pengeluaran" method="post" enctype="multipart/form-data"> -->
                            <?php echo form_open_multipart('Dashboard/add_pembayaran_pengajuan');?>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>No Faktur</label>
                                                <input type="text" class="form-control" placeholder="No Kwitansi" name="no_kwitansi" value="<?php echo $row->no_faktur?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Perumahan</label>
                                                <input type="text" class="form-control" name="kode_perumahan" value="<?php echo $prods->kode_perumahan?>" readonly required>
                                            </div>
                                            <div class="form-group">
                                                <label>Penerima</label>
                                                <input type="text" class="form-control" placeholder="Terima oleh" name="terima_oleh" value="<?php echo $row->nama_toko?>" required readonly>
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
                                                <textarea class="form-control" placeholder="Keterangan Pengeluaran" name="keterangan_pengeluaran" value="" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Sisa Pembayaran</label>
                                                <input type="number" class="form-control" id="sisaPembayaran" name="sisa_pembayaran" value="<?php echo $total-$total_byr?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Nilai Pembayaran</label>
                                                <input type="number" class="form-control" id="nilaiPembayaran" placeholder="Nilai Pengeluaran" name="nilai_pengeluaran" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Pembayaran</label>
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
                                                    <input type="date" class="form-control" name="periode_awal" id="periodeAwal">
                                                </div>
                                                <div class="form-group">
                                                    <label>Periode Akhir</label>
                                                    <input type="date" class="form-control" name="periode_akhir" id="periodeAkhir">
                                                </div>
                                            </div> -->
                                            <div id="cash" class="jenis" style="">
                                                <div class="form-group">
                                                    <label>Cara Pembayaran</label>
                                                    <select class="form-control" placeholder="" id="caraPembayaran" name="cara_pembayaran">
                                                        <option disabled selected value="">-Pilih-</option>
                                                        <option value="transfer">Transfer</option>
                                                        <option value="cash">Cash</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Bank</label>
                                                    <div id="showBank"></div>
                                                    <select class="form-control" placeholder="" id="bank" name="bank">
                                                        <option disabled selected value="">-Pilih-</option>
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

                                    <!-- <input type="hidden" value="<?php echo $total;?>" name="total"> -->
                                    <input type="hidden" value="<?php echo $id?>" name="id">
                                    <input type="submit" class="btn btn-primary" value="Bayar" />
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
    <div class="modal-dialog modal-dialog-centered" role="document">
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
    $(this).find('#img').html('<img src="<?php echo base_url()?>/gambar/pengeluaran/'+myRoomNumber+'" style="width: 470px; height: 300px" alt="Bukti">');
    // $(this).find('.noSHM').value(myRoomNumber);
    // $(this).find('.terimaOleh').text(myRoomNumber1);
});

$('#jenisPembayaran').change(function(){
    // $('#showJenisPembayaran').empty();
    $('.jenis').hide();
    $('#' + $(this).val()).show();
});

$('#nilaiPembayaran').on("input", function(){
    check = $('#sisaBayar').val();

    $('#sisaPembayaran').val(check-$(this).val());
})
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
    $('#datepicker').datepicker();
  });
</script>
</body>
</html>
