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
            <h1>Pembayaran
            <?php if(isset($tk_bangunan)){
                echo " - ".$tk_bangunan." - ".$kode_perumahan;
            }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Pembayaran</li>
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
                        <div class="card-header">
                            <a href="<?php echo base_url()?>Dashboard/informasi_pengajuan_pembayaran" class="btn btn-success btn-sm">Menuju Daftar Pengajuan</a>
                        </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                        <!-- <form role="form" action="<?php echo base_url()?>Dashboard/add_pengeluaran" method="post" enctype="multipart/form-data"> -->
                        <form role="form" action="<?php echo base_url()?>Dashboard/filter_pembayaran_pembelian_bahan" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <!-- <div class="form-group col-sm-2">
                                        <label>Tanggal Awal</label>
                                        <input type="date" class="form-control" name="tgl_awal" value="<?php if(isset($tgl_awal)){echo $tgl_awal;} else {echo date('Y-m-d');}?>">
                                    </div> -->
                                    <div class="form-group col-sm-3">
                                        <label>Tanggal Jatuh Tempo</label>
                                        <input type="date" class="form-control" name="tgl_akhir" value="<?php if(isset($tgl_akhir)){echo $tgl_akhir;} else {echo date('Y-m-d');}?>">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Perumahan</label>
                                        <select class="form-control" name="perumahan">
                                            <?php foreach($this->db->get('perumahan')->result() as $prmh){
                                                echo "<option ";
                                                if(isset($kode_perumahan)){
                                                    if($kode_perumahan == $prmh->kode_perumahan){
                                                        echo "selected";
                                                    }
                                                }
                                                echo " value='$prmh->kode_perumahan'>$prmh->nama_perumahan</option>";
                                            }?>
                                                <!-- <option value="<?php echo $prmh->kode_perumahan?>"><?php echo $prmh->nama_perumahan?></option> -->
                                            <?php ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Toko Bangunan</label>
                                        <select class="form-control" name="tk_bangunan">
                                            <?php foreach($this->db->get_where('produksi_master_data', array('kategori'=>"toko"))->result() as $tk){
                                                echo "<option ";
                                                if(isset($tk_bangunan)){
                                                    if($tk_bangunan == $tk->nama_data){
                                                        echo "selected";
                                                    }
                                                }
                                                echo ">$tk->nama_data</option>";
                                            }?>
                                                <!-- <option value="<?php echo $tk->nama_data?>"><?php echo $tk->nama_data?></option> -->
                                            
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <br>
                                        <input type="submit" class="btn btn-info" value="SEARCH">
                                    </div>
                                </div>
                        </form>
                        
                        <?php echo form_open_multipart('Dashboard/add_pembayaran_pembelian_bahan');
                            if(isset($prod)){?>
                                <!-- <div class="container-fluid card"> -->
                                <!-- <hr> 
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tes</label>
                                                <input type="text" class="form-control">
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
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div></div>
                                                <label>Jenis Pengeluaran</label>
                                                <select class="form-control" id="response" name="jenis_pengeluaran" required>
                                                    <option selected disabled value="">-Pilih-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Keterangan Pembayaran</label>
                                                <textarea class="form-control" placeholder="Keterangan Pengeluaran" name="keterangan_pengeluaran" value="" required>Pembayaran tagihan pembelian bahan No. Faktur <?php echo $row->no_faktur?></textarea>
                                            </div>
                                        </div>
                                    </div> -->
                                <!-- </div> -->
                                <?php if($prod->num_rows() > 0){?>
                                <hr>
                                <div class="row">
                                    <label class="col-sm-2">Keterangan</label>
                                    <textarea class="form-control col-sm-4" name="keterangan"><?php echo "Pembelian bahan toko ".$tk_bangunan." untuk Jatuh Tempo ".date('d F Y', strtotime($tgl_akhir));?></textarea>

                                    <label class="col-sm-2">Tanggal Pengajuan</label>
                                    <input type="date" class="form-control col-sm-4" name="tgl_aju" value="<?php echo date('Y-m-d');?>">

                                    <input type="hidden" class="form-control" name="tgl_jatuh_tempo" value="<?php echo $tgl_akhir?>">
                                </div>
                                <hr>

                                <table class="table table-striped table-bordered" style="font-size: 14px">
                                    <thead>
                                        <tr>
                                            <th>Aksi</th>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Qty</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Tanggal Beli</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; $total=0; foreach($prod->result() as $row){?>
                                        <tr>
                                            <td><input type="checkbox" class="form-control form-control-sm" value="<?php echo $row->id_prod?>" name="id_prod[]"></td>
                                            <td><?php echo $no?></td>
                                            <td><?php echo $row->nama_barang?></td>
                                            <td><?php echo $row->qty?></td>
                                            <td><?php echo $row->nama_satuan?></td>
                                            <td><?php echo "Rp. ".number_format($row->harga_satuan)?></td>
                                            <td><?php echo date('d F Y', strtotime($row->tgl_pesan))?></td>
                                            <td>
                                                <?php echo "Rp. ".number_format($row->qty*$row->harga_satuan)?>
                                                <!-- <input type="hidden" value="<?php echo $row->id_prod?>" name="id_prod[]"> -->
                                            </td>
                                        </tr>
                                    <!-- <div class="container-fluid card"> -->
                                        <!-- <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>No Faktur</label>
                                                    <input type="text" class="form-control" placeholder="No Kwitansi" name="no_faktur" value="<?php echo $row->no_faktur?>" readonly required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-3">  
                                                <div class="form-group">
                                                    <label>Total/Faktur</label>
                                                    <input type="number" class="form-control" value="<?php echo $row->total?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Tanggal Pembayaran</label>
                                                    <input type="date" class="form-control" placeholder="" name="tgl_pengeluaran" value="<?php echo $row->tgl_deadline?>" required>
                                                </div>
                                            </div>
                                        </div> -->
                                        <?php $no++; $total= $total + ($row->qty*$row->harga_satuan);}?>
                                        <tr>
                                            <td colspan=7 style="text-align:center; font-weight: bold"><?php echo "PEMBELIAN BULAN ".strtoupper(date('F Y', strtotime($row->tgl_pesan)));?></td>
                                            <td><?php echo "Rp. ".number_format($total);?></td>
                                        </tr>
                                    </tbody>
                                </table>

                            <hr>
                            <!-- <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Total</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" value="<?php echo $total;?>" class="form-control" readonly>
                                </div>
                            </div>-->

                            <div class="card-footer">
                                <?php if(isset($error_upload)){?><span style="color: green"><?php echo $error_upload['error']?></span><?php }?>
                                <?php if(isset($succ_msg)){?>
                                    <span style="color: green"><?php echo $succ_msg?></span><br>
                                <?php }?>
                                <?php if(isset($err_msg)){?>
                                    <span style="color: red"><?php echo $err_msg?></span><br>
                                <?php }?>

                                <?php ?>
                                <!-- <input type="hidden" value="<?php ?>" name="total_utang"> -->
                                <!-- <input type="hidden" value="<?php echo $id?>" name="id"> -->
                                <input type="hidden" value=<?php echo $kode_perumahan?> name="kode_perumahan">
                                <input type="submit" class="btn btn-primary" value="Ajukan" />
                                <!-- <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran" class="btn btn-primary">Tambah Baru</a> -->
                            </div>
                        <?php echo form_close();
                        } else {?>
                            <div class="card-body">Tidak ada</div>
                        <?php }}?>
                        
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    <?php if(isset($tgl_akhir)){
        if(isset($kode_perumahan)){
            if(isset($tk_bangunan)){?>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <div style="text-align: center">
                    Bulan <?php echo date('F Y', strtotime($tgl_akhir))?> <br><br>
                </div>
                <table id="example3" class="table table-bordered table-striped" style="font-size: 13px">
                  <thead>
                    <tr style="background-color: lightyellow; font-weight: bold">
                        <td colspan=9 style="text-align: center">TOTAL PEMBELIAN BAHAN BULAN <?php echo strtoupper(date('F Y', strtotime($tgl_akhir)))?> </td>
                        <td colspan=2><div id="total"></div></td>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Toko Bangunan</th>
                        <th>Nomor Faktur</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Tgl Pesan</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Total</th>
                        <!-- <th>Status</th> -->
                        <!-- <th>Jmlh Diterima</th> -->
                        <!-- <th>Aksi</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; $total=0; 
                    $check_all = $this->Dashboard_model->get_rincian_jatuh_tempo2($tgl_akhir, $kode_perumahan, $tk_bangunan);
                    // print_r($check_all->result());
                    // echo $tgl_akhir.$kode_perumahan.$tk_bangunan;
                    foreach($check_all->result() as $row){ 
                      if($row->status == "lunas"){?>
                        <tr style='background-color: lightgreen'>
                      <?php } else if($row->status == "diajukan"){
                        echo "<tr style='background-color: pink'>";
                      } else {
                        echo "<tr>";
                      }?>
                        <td><?php echo $no;?></td>
                        <td style="white-space: nowrap"><?php echo $row->nama_barang?></td>
                        <td style="white-space: nowrap"><?php echo $row->nama_toko?></td>
                        <td><?php echo $row->no_faktur?></td>
                        <td><?php echo $row->qty?></td>
                        <td><?php echo $row->nama_satuan?></td>
                        <td><?php echo "Rp. ".number_format($row->harga_satuan)?></td>
                        <td><?php echo $row->tgl_pesan?></td>
                        <td><?php echo $row->tgl_deadline?></td>
                        <td><?php echo $row->status?></td>
                        <td style="white-space: nowrap"><?php echo "Rp. ".number_format($row->qty*$row->harga_satuan)?></td>
                        <!-- <td></td> -->
                        <?php $total = $total + ($row->qty*$row->harga_satuan)?>
                      </tr>
                    <?php $no++;}?>
                  </tfoot>
                </table>
                
                <input type="hidden" value="<?php echo number_format($total)?>" id="totalAll" >
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
    <?php }}}?>
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

$('#nilaiPengeluaran').on("input", function (){
    var ch = $(this).val();

    var che = $('#totalPembelian').val();
    var che1 = $('#totalByr').val();

    var ttl = che - che1;

    $('#sisaUtang').val(ttl-ch);
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
