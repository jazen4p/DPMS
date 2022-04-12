<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
  <link type="text/css" href="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/css/jquery.signature.css" rel="stylesheet"> 
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
    .kbw-signature { width: 400px; height: 200px;}
    #sig canvas{
        width: 100% !important;
        height: auto;
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

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-9">
            <h1>
                Pencairan Dana KBK No. <?php echo sprintf('%03d', $no_kbk)."/".$kode." - ".$tahap?> 
            </h1>
          </div>
          <div class="col-sm-3">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">
                Pencairan Dana KBK
              </li>
            </ol>
          </div>
        </div>
        <!-- <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button> -->
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_laporan_penerimaan_akuntansi" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Perumahan</label>
                  <select name="perumahan" class="form-control">
                      <option value="">Semua</option>
                      <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                      <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                      <?php }?>
                  </select>
                  <?php if(isset($kode)){?>
                    <span>Pilihan saat ini: <?php if($kode == ""){echo "Semua";} else {echo $kode;}?></span>
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select name="kategori" class="form-control">
                      <option value="">Semua</option>
                      <option value="booking fee">Booking Fee</option>
                      <option value="piutang kas">Piutang Kas</option>
                      <option value="ground tank">Ground Tank</option>
                      <option value="tambahan bangunan">Tambahan Bangunan</option>
                      <option value="penerimaan lain">Penerimaan Lain</option>
                  </select>
                  <?php if(isset($kategori)){
                    echo "Pilihan saat ini: ";
                    if($kategori == ""){ echo "Semua";} else { echo $kategori; }; 
                  }?>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                      <option value="A">Semua</option>
                      <option value="dom">Approved</option>
                      <option value="revisi">Revisi</option>
                      <option value="tutup">Menunggu</option>
                  </select>
                  <?php if(isset($kategori)){
                    echo "Pilihan saat ini: ";
                    if($kategori == ""){ echo "Semua";} else { echo $kategori; }; 
                  }?>
                </div>
              </div>
              <div class="col-md-6">
                <label>Date</label>
                <input placeholder="Tanggal Awal" value="<?php if(isset($tglmin)){echo $tglmin;}?>" name="tgl_awal" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
                <label>Sampai</label>
                <input placeholder="Tanggal Akhir" value="<?php if(isset($tglmax)){echo $tglmax;}?>" name="tgl_akhir" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
              </div>
              <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
              <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
              <div class="col-md-12">
                <input type="submit" class="btn btn-info btn-flat" value="SEARCH" />
                <button type="button" id="thisPrint" class="btn btn-info btn-flat" style="">CETAK</button>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php if(isset($edit_kbk)){
      foreach($edit_kbk->result() as $row){?>

    <?php }} else {
     foreach($check_all->result() as $row){?>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <a href="<?php echo base_url()?>Dashboard/qc_form?id=<?php echo $id_termin?>&ids=<?php echo $id_kbk?>&kode=<?php echo $kode?>" class="btn btn-info btn-flat btn-sm">Kembali</a>
                    <!-- <a href="#" class="btn btn-info btn-flat">Tambah Baru</a> -->
                    <a href="<?php echo base_url()?>Dashboard/qc_management?id=<?php echo $kode?>" class="btn btn-info btn-flat btn-sm">Kembali ke awal</a>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <form action="<?php echo base_url()?>Dashboard/add_pencairan" method="POST" enctype="multipart/form-data">

                        <div class="col-12" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">Data Progress</div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>No. KBK</label>
                                    <input type="text" class="form-control" value="<?php echo sprintf('%03d', $no_kbk)."/KBK/".$kode;?>" readonly>
                                    <input type="hidden" value="<?php echo $no_kbk?>" name="no_kbk">
                                </div>
                                <div class="form-group">
                                    <label>No Unit</label>
                                    <input type="text" class="form-control" value="<?php echo $no_unit?>" name="no_unit" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tipe Unit</label>
                                    <input type="text" class="form-control" value="<?php echo $tipe_unit?>" name="tipe_unit" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Perumahan</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_perumahan?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Perincian</label>
                                    <textarea name="keterangan" class="form-control">Type: <?php echo $tipe_unit?> unit: <?php echo $no_unit?> Bobot awal: <?php echo $row->opname?>% Bobot realisasi: <?php echo $row->realisasi_progress?>%</textarea>
                                    <!-- <input type="text" class="form-control" value="<?php echo $nama_perumahan?>" readonly> -->
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nama Kontraktor</label>
                                    <input type="text" class="form-control" name="nama_kontraktor" value="<?php echo $nama_kontraktor?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tahap</label>
                                    <input type="text" class="form-control" name="tahap" value="<?php echo $row->tahap?>" readonly>
                                    <!-- <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_spk"> -->
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pencairan</label>
                                    <input type="text" class="form-control" name="tgl" value="<?php echo date('Y-m-d')?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Progress Seharusnya (%)</label>
                                    <input type="text" class="form-control" name="progress" value="<?php echo $row->opname?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Realisasi Progress (%)</label>
                                    <input type="text" class="form-control" name="realisasi" value="<?php echo $row->realisasi_progress?>" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Pencairan Sesuai Kontrak</label>
                                    <input type="text" class="form-control" value="<?php echo "Rp. ".number_format($row->nilai_pembayaran)?>" readonly>
                                    <input type="hidden" value="<?php echo $row->nilai_pembayaran?>" id="totalPencairan" name="harga_jual">
                                </div>
                                <div class="form-group">
                                    <label>Pencairan Yang Telah Dicairkan</label>
                                    <input type="number" name="nominal_pencairan" class="form-control" id="akanPencairan" value="<?php echo $cair?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Sisa Akumulasi Pencairan</label>
                                    <input type="number" name="nominal_pencairan" class="form-control" id="sisaAkumulasiPencairan" value="<?php echo $row->nilai_pembayaran - $cair?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nominal Pencairan</label>
                                    <input type="number" name="nominal_pencairan" class="form-control" id="nominalPencairan" required>
                                </div>
                                <div class="form-group">
                                    <label>Sisa Pencairan</label>
                                    <input type="text" class="form-control" id="sisaPencairanShow" value="NaN" readonly>
                                    <input type="hidden" id="sisaPencairan" name="sisa_pencairan">
                                </div>
                            </div>
                        </div>
                    </div>  
                  </div>
                </div>
                <div class="card-footer">
                  <?php if(isset($succ_msg)){?>
                      <div style="color: green"><?php echo $succ_msg?></div>
                  <?php }?>

                  <input type="hidden" value="<?php echo $kode?>" name="kode">
                  <input type="hidden" value="<?php echo $id_termin?>" name="id_termin">
                  <input type="hidden" value="<?php echo $id_kbk?>" name="id_kbk">
                  <input type="submit" value="Ajukan" class="btn btn-success btn-flat">
                </div>
                </form>
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
    <?php }}?>
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
<!-- page script -->
<script>
function myFunction(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PSJB ini di approve?");
  if (r == true) {
    window.location.replace(base_url+"/psjb_approve?id="+id);
  } else {
    window.location.replace(base_url+"/psjb_management")
  }
  document.getElementById("demo").innerHTML = txt;
}

function myFunction1(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PSJB ini di batalkan?");
  if (r == true) {
    window.location.replace(base_url+"/psjb_pembatalan?id="+id);
  } else {
    window.location.replace(base_url+"/psjb_management")
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": false,
      // "scrollX": true
    });
    
    $("#example3").DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": false,
      // "scrollX": true
    });
  });

</script>
<script>
  $(function () {
    $("#date").datepicker();
    $("#checkout").datepicker();
  });

  $(document).ready(function(){
    $('#thisPrint').on('click', function(){
      window.print();
    })
  })

  $(function() {
    var b = $("#button");
    var w = $("#wrapper");
    var l = $("#list");
    b.click(function() {
      w.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });
  });

  $(document).ready(function(){
    $("select#outpost").change(function(){
        var selectedCountry = $("#outpost option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_unit",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response").html(data);
        });
    });

    $("select#namaBahan").change(function(){
        var selectedCountry = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_satuan",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response1").val(data);
        });
    });
  });

  function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }

  $('#nominalPencairan').on("input", function(){
    var gt = $(this).val();
    var ttl = $('#sisaAkumulasiPencairan').val();
    var sisa = $('#sisaPencairan').val();

    $('#sisaPencairan').val(ttl - gt);
    $('#sisaPencairanShow').val('Rp '+numberWithCommas(ttl - gt));
  })
</script>
</body>
</html>
