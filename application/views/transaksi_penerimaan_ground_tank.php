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
<body class="hold-transition sidebar-mini">
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
            <h1>Penerimaan Ground Tank</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Penerimaan Ground Tank</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php if(isset($edit_ground_tank)) {
        foreach($edit_ground_tank->result() as $row){?>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form role="form" action="<?php echo base_url()?>Dashboard/edit_update_ground_tank" method="post" enctype="multipart/form-data">
                                              <div class="form-group">
                                                  <label>No Kwitansi</label>
                                                  <input type="text" class="form-control" placeholder="No Kwitansi" name="no_kwitansi" value="<?php echo $row->no_kwitansi?>" readonly>
                                              </div>
                                              <div class="form-group">
                                                  <label>Kode Perumahan</label>
                                                  <input type="text" class="form-control" placeholder="" name="kode_perumahan" value="<?php echo $row->kode_perumahan?>" readonly>
                                              </div>
                                            <div class="form-group">
                                                <label>No Unit</label>
                                                <input type="text" class="form-control" name="no_unit" value="<?php echo $row->kode_rumah?>" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Terima dari</label>
                                                <input type="text" class="form-control" placeholder="Terima dari" name="terima_dari" value="<?php echo $row->terima_dari?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Keterangan Penerimaan</label>
                                                <textarea class="form-control" placeholder="Keterangan Penerimaan" name="keterangan_penerimaan" value="" required><?php echo $row->keterangan?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Nilai Penerimaan</label>
                                                <input type="number" class="form-control" placeholder="Nilai Penerimaan" name="nilai_penerimaan" value="<?php echo $row->dana_terima?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tanggal Penerimaan</label>
                                                <input type="date" class="form-control" placeholder="" name="tgl_penerimaan" value="<?php echo $row->tanggal_dana?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Cara Pembayaran</label>
                                                <select class="form-control" id="caraPembayaran" placeholder="" name="jenis_pembayaran" required>
                                                    <!-- <option disabled selected value="">-Pilih-</option> -->
                                                    <?php if($row->jenis_pembayaran == "transfer"){?>
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
                                                <select class="form-control" id="bank" placeholder="" name="bank" required>
                                                    <!-- <option disabled selected value="">-Pilih-</option> -->
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
                                    <input type="hidden" value="<?php echo $row->id_keuangan?>" name="id">
                                    <input type="submit" class="btn btn-primary" value="Submit" />
                                    <a href="<?php echo base_url()?>Dashboard/penerimaan_ground_tank" class="btn btn-primary">Tambah Baru</a>
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
                        <!-- general form elements -->
                        <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form role="form" action="<?php echo base_url()?>Dashboard/penerimaan_ground_tank_perumahan" method="POST">
                                                <div class="row">
                                                    <div class="form-group col-md-9">
                                                        <label>Perumahan</label>
                                                        <select class="form-control" name="kode_perumahan" required>
                                                            <option selected disabled value="">-Pilih-</option>
                                                            <?php foreach($this->db->get('perumahan')->result() as $perumahan){
                                                              echo "<option ";
                                                              if($kode_perumahan == $perumahan->kode_perumahan){
                                                                echo "selected";
                                                              }
                                                              echo " value='$perumahan->kode_perumahan'>$perumahan->nama_perumahan</option>";
                                                            }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <!-- <input> -->
                                                        <input style="margin-top: 35px" type="submit" class="btn btn-sm btn-flat btn-outline-primary">
                                                    </div>
                                                </div>
                                            </form>
                                            <form role="form" action="<?php echo base_url()?>Dashboard/add_penerimaan_ground_tank" method="post" enctype="multipart/form-data">
                                            
                                            <?php if(isset($penerimaan_lain_perumahan)){?>
                                                <div class="form-group">
                                                    <label>No Kwitansi</label>
                                                    <input type="text" class="form-control readonly" placeholder="No Kwitansi" name="no_kwitansi" value="<?php echo $no_kwitansi?>" readonly required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kode Perumahan</label>
                                                    <input type="text" class="form-control readonly" placeholder="" name="kode_perumahan" value="<?php echo $kode_perumahan?>" readonly required>
                                                </div>
                                            <?php } else {?>
                                                <div class="form-group">
                                                    <label>No Kwitansi</label>
                                                    <input type="text" class="form-control readonly" placeholder="No Kwitansi" name="no_kwitansi" value="" readonly required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kode Perumahan</label>
                                                    <input type="text" class="form-control readonly" placeholder="" name="kode_perumahan" value="" readonly required>
                                                </div>
                                            <?php }?>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php if(isset($penerimaan_lain_perumahan)){?>
                                                <label>No Unit</label>
                                                <select class="form-control" name="no_unit" required>
                                                    <option value="" disabled selected>-Pilih-</option>
                                                    <?php 
                                                        // $query = $this->db->get_where('rumah', array('status <>'=>"free"));
                                                        foreach($penerimaan_lain_perumahan as $rumah){?>
                                                            <option value="<?php echo $rumah->unit?>"><?php echo $rumah->unit."-".$rumah->kode_perumahan?></option>;
                                                        <?php }
                                                    ?>
                                                </select>
                                                <!-- <span>Pilihan saat ini: <?php echo $kode_perumahan?></span> -->
                                                <?php } else {?>
                                                    <label>No Unit</label>
                                                    <input class="form-control readonly" required>
                                                <?php }?>
                                                <!-- <select class="form-control" name="jenis_penerimaan" required>
                                                    <option selected disabled value="">-Pilih-</option>
                                                    <option value="interior">Interior</option>
                                                    <option value="maintenance">Maintenance</option>
                                                    <option value="bphtb">BPHTB</option>
                                                    <option value="bbn">BBN</option>
                                                    <option value="lainnya">Lainnya</option>
                                                </select> -->
                                            </div>
                                            <div class="form-group">
                                                <label>Terima dari</label>
                                                <input type="text" class="form-control" placeholder="Terima dari" name="terima_dari" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Keterangan Penerimaan</label>
                                                <textarea class="form-control" placeholder="Keterangan Penerimaan" name="keterangan_penerimaan" value="" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nilai Penerimaan</label>
                                                <input type="number" class="form-control" placeholder="Nilai Penerimaan" name="nilai_penerimaan" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Penerimaan</label>
                                                <input type="date" class="form-control" id="datepicker" placeholder="" name="tgl_penerimaan" value="<?php echo date('Y-m-d')?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Cara Pembayaran</label>
                                                <select class="form-control" id="caraPembayaran" placeholder="" name="jenis_pembayaran" required>
                                                    <option disabled selected value="">-Pilih-</option>
                                                    <option value="transfer">Transfer</option>
                                                    <option value="cash">Cash</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Bank</label>
                                                <div id="showBank"></div>
                                                <select class="form-control" id="bank" placeholder="" name="bank" required>
                                                    <option disabled selected value="">-Pilih-</option>
                                                    <?php foreach($bank as $bank){?>
                                                        <option value="<?php echo $bank->id_bank?>"><?php echo $bank->id_bank."-".$bank->nama_bank?></option>
                                                    <?php }?>
                                                </select>
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
                                    <input type="submit" class="btn btn-primary" value="Submit" />
                                    <a href="<?php echo base_url()?>Dashboard/penerimaan_ground_tank" class="btn btn-primary">Tambah Baru</a>
                                </div>
                            </form>
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
                <button type="button" id="button" class="btn btn-flat btn-info">FILTER</button>
                  <form action="<?php echo base_url()?>Dashboard/filter_ground_tank" method="POST">
                    <div style="text-align: center" class="row" id="wrapper">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Perumahan:</label>
                          <select name="perumahan" class="form-control">
                              <option value="">Semua</option>
                              <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                              <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">

                      </div>
                      <input type="submit" value="SEARCH" class="btn btn-info btn-flat btn-sm"> <br>
                      <?php if(isset($jenis_penerimaan)){?>
                          <span>Filter: <?php echo $jenis_penerimaan."-".$kode_perumahan;?></span>
                      <?php }?>
                  </form>
                </div> <br>
                <table id="example2" class="table table-bordered table-striped" style="font-size: 13px; white-space: nowrap">
                  <!-- <div style="text-align: center">
                    <form action="<?php echo base_url()?>Dashboard/filter_penerimaan_lain" method="POST">
                        Jenis:
                        <select name="jenis_penerimaan">
                            <option value="">Semua</option>
                            <option value="interior">Interior</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="bphtb">BPHTB</option>
                            <option value="bbn">BBN</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        Perumahan:
                        <select name="perumahan">
                            <option value="">Semua</option>
                            <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                            <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                            <?php }?>
                        </select>

                        <input type="submit" value="ok" class="btn btn-info btn-flat btn-sm"> <br>
                        <?php if(isset($jenis_penerimaan)){?>
                            <span>Filter: <?php echo $jenis_penerimaan."-".$kode_perumahan;?></span>
                        <?php }?>
                    </form>
                  </div> -->
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Terima dari</th>
                      <th>No Kwitansi</th>
                      <th>Perumahan</th>
                      <th>No Unit</th>
                      <th>Keterangan</th>
                      <th>Tipe Pembayaran</th>
                      <th>Tanggal Pembayaran</th>
                      <th>Jumlah Pembayaran</th>
                      <th>Terbilang</th>
                      <th>Dibuat oleh</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;foreach($penerimaan_lain as $row){?>
                    <tr>
                      <td><?php echo $no?></td>
                      <td><?php echo $row->terima_dari?></td>
                      <td><?php echo $row->no_kwitansi?></td>
                      <td><?php
                      foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $prmh){
                        echo $prmh->nama_perumahan;
                      }?></td>
                      <td><?php echo $row->kode_rumah?></td>
                      <td><?php echo $row->keterangan?></td>
                      <td><?php echo $row->jenis_pembayaran?></td>
                      <td><?php echo $row->tanggal_dana?></td>
                      <td><?php echo number_format($row->dana_terima)?></td>
                      <td style=""><?php echo terbilang($row->dana_terima)?> Rupiah</td>
                      <td><?php echo $row->created_by?></td>
                      <td>
                        <a href="<?php echo base_url()?>Dashboard/edit_ground_tank?id=<?php echo $row->id_keuangan?>" class="btn btn-default btn-sm">Edit</a>
                        <a href="<?php echo base_url()?>Dashboard/hapus_ground_tank?id=<?php echo $row->id_keuangan."&kode=".$row->kode_perumahan?>" class="btn btn-default btn-sm">Hapus</a>
                        <a href="<?php echo base_url()?>Dashboard/print_penerimaan_lain?id=<?php echo $row->id_keuangan?>" class="btn btn-default btn-sm" target="_blank">Cetak</a>
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
<script>
$(".readonly").on('keydown paste', function(e){
    e.preventDefault();
});
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
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
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true
    });
    $("#datepicker").datepicker();
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
