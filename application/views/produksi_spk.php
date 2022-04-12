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
          <div class="col-sm-6">
            <h1>
                Form SPK - PPJB No. <?php echo sprintf('%03d', $no_psjb)?>          
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">
                Form SPK
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
    <?php if(isset($edit_spk)){
      foreach($edit_spk->result() as $row){?>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                  <a class="btn btn-info btn-sm btn-flat" href="<?php echo base_url()?>Dashboard/spk_management?id=<?php echo $row->kode_perumahan?>">Kembali</a>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <form action="<?php echo base_url()?>Dashboard/revisi_spk" method="POST" enctype="multipart/form-data">
                        <div class="col-12 row">
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label>No. SPK</label>
                                  <input type="text" class="form-control" value="<?php echo sprintf('%03d', $row->no_spk)."/SPK/".$kode_perusahaan."/".$row->kode_perumahan;?>" readonly>
                                  <input type="hidden" value="<?php echo $row->no_spk?>" name="no_spk">
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Unit</label>
                                  <input type="text" class="form-control" name="no_unit" value="<?php echo $row->unit?>" readonly>
                                  <!-- <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_spk"> -->
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Harga Total Unit</label>
                                  <input type="text" class="form-control" value="<?php echo "Rp. ".number_format($row->harga_unit)?>" readonly>
                                  <input type="hidden" value="<?php echo $row->harga_unit?>" name="harga_jual">
                              </div>
                          </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Luas Bangunan</label>
                                    <input type="number" value="<?php echo $row->luas_bangunan?>" class="form-control" name="luas_bangunan" required required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Luas Tanah</label>
                                    <input type="number" value="<?php echo $row->luas_tanah?>" class="form-control" name="luas_tanah" required required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Upah</label>
                                    <input type="number" class="form-control" name="upah" value="<?php echo $row->upah?>" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kontrak Pekerjaan</label>
                                    <textarea class="form-control" name="kontrak_pekerjaan" required><?php echo $row->kontrak_pekerjaan?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Masa Pelaksanaan</label>
                                    <!-- <textarea class="form-control" name="masa_pelaksanaan" required><?php echo $row->masa_pelaksanaan?></textarea> -->
                                    <input type="number" class="form-control" name="masa_pelaksanaan" value="<?php echo $row->masa_pelaksanaan?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Tanggal BAST (Sub Kon ke Developer)</label>
                                  <input type="date" class="form-control" name="tgl_bast" value="<?php echo date('Y-m-d', strtotime($row->tgl_bast))?>" required>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <?php if($sistem_pembayaran == "KPR"){?>
                                <div class="form-group">
                                    <label>Tanggal Akad (Hanya KPR)</label>
                                    <input type="date" class="form-control" name="tgl_akad" value="<?php echo date('Y-m-d', strtotime($row->tgl_akad))?>">
                                </div>
                              <?php } else { ?>
                                <div class="form-group">
                                    <label>Tanggal Akad (Hanya KPR)</label>
                                    <input type="date" class="form-control" name="tgl_akad" value="<?php echo $row->tgl_akad?>" readonly>
                                </div>
                              <?php }?>
                                <!-- <div class="form-group">
                                  <label class="" for="">Signature</label>
                                  <br/>
                                  <div id="sig"></div>
                                  <br/>
                                  <button type="button" id="clear" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
                                  <textarea id="signature64" name="signed" style="display: none"></textarea>
                                </div> -->
                            </div>
                        </div>
                    </div>  
                  </div>
                </div>
                <div class="card-footer">
                  <!-- <input type="hidden" value="<?php echo $no?>" id="check"> -->
                  <!-- <input type="hidden" value="<?php echo $id?>" name="kode_perumahan"> -->
                  <input type="hidden" value="<?php echo $id?>" name="id">
                  <?php if(isset($succ_msg)){?>
                    <div style="color: green"><?php echo $succ_msg?></div>
                  <?php }?>
                  <input type="submit" value="Update" class="btn btn-success btn-flat">
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
    <?php }} else {
     foreach($check_all->result() as $row){?>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <a href="<?php echo base_url()?>Dashboard/view_add_spk_management?id=<?php echo $row->kode_perumahan?>" class="btn btn-info btn-flat btn-sm">Kembali</a>
                    <!-- <a href="#" class="btn btn-info btn-flat">Tambah Baru</a> -->
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <form action="<?php echo base_url()?>Dashboard/add_spk" method="POST" enctype="multipart/form-data">
                        <div class="col-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>No. SPK</label>
                                    <input type="text" class="form-control" value="<?php echo sprintf('%03d', $row->no_psjb)."/SPK/".$kode_perusahaan."/".$row->kode_perumahan;?>" readonly>
                                    <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_spk">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input type="text" class="form-control" name="no_unit" value="<?php echo $row->no_kavling; foreach($this->db->get_where('rumah', array('kode_perumahan'=>$row->kode_perumahan, 'no_psjb'=>$row->psjb, 'tipe_produk'=>$row->tipe_produk))->result() as $rmh){echo ", ".$rmh->kode_rumah;}?>" readonly>
                                    <!-- <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_spk"> -->
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Harga Total Unit</label>
                                    <input type="text" class="form-control" value="<?php echo "Rp. ".number_format($row->total_jual)?>" readonly>
                                    <input type="hidden" value="<?php echo $row->total_jual?>" name="harga_jual">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Luas Bangunan</label>
                                    <input type="number" value="<?php echo $row->luas_bangunan?>" class="form-control" name="luas_bangunan" required required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Luas Tanah</label>
                                    <input type="number" value="<?php echo $row->luas_tanah?>" class="form-control" name="luas_tanah" required required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Upah</label>
                                    <input type="number" value="" class="form-control" name="upah" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kontrak Pekerjaan</label>
                                    <textarea class="form-control" name="kontrak_pekerjaan" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Masa Pelaksanaan</label>
                                    <!-- <textarea class="form-control" name="masa_pelaksanaan" required></textarea> -->
                                    <input type="number" class="form-control" name="masa_pelaksanaan" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Tanggal BAST (Sub Kon ke Developer)</label>
                                  <input type="date" value="" class="form-control" name="tgl_bast" required>
                              </div>
                              <?php if($row->sistem_pembayaran == "KPR"){?>
                                <div class="form-group">
                                    <label>Tanggal Akad (Hanya KPR)</label>
                                    <input type="date" value="" class="form-control" name="tgl_akad" required>
                                </div>
                              <?php } else { ?>
                                <div class="form-group">
                                    <label>Tanggal Akad (Hanya KPR)</label>
                                    <input type="date" value="0000-00-00" class="form-control" name="tgl_akad" readonly required>
                                </div>
                              <?php }?>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                  <label class="" for="">Signature</label>
                                  <br/>
                                  <div id="sig"></div>
                                  <br/>
                                  <button type="button" id="clear" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
                                  <textarea id="signature64" name="signed" style="display: none"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>  
                  </div>
                </div>
                <div class="card-footer">
                  <!-- <input type="hidden" value="<?php echo $no?>" id="check"> -->
                  <!-- <input type="hidden" value="<?php echo $id?>" name="kode_perumahan"> -->
                  <?php if(isset($succ_msg)){?>
                      <div style="color: green"><?php echo $succ_msg?></div>
                  <?php }?>

                  <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode">
                  <input type="hidden" value="<?php echo $id?>" name="id_form">
                  <input type="hidden" value="<?php echo $row->id_psjb?>" name="id_ppjb">
                  <input type="submit" value="Tambah" class="btn btn-success btn-flat">
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail POS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div style="text-align: center">Debet</div>
          </div>
          <div class="col-md-6">
            <div style="text-align: center">Kredit</div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
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
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
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

  $(function () {
    var check = $('#check').val();

    for (var i = 1; i <= check; i++) {
        (function (i) {
            $('input[id$="volume' + i + '"]').on("input", function () {
              var volume = $(this).val();
              var satuan = $('#satuan'+i).val();
              var hargaSatuan = $('#hargaSatuan'+i).val();

              if(satuan == "%"){
                var total = (volume * hargaSatuan)/100;
              } else {
                var total = volume * hargaSatuan;
              }

              $('#subJumlah'+i).val(total);
            });
        })(i);
    }
  });

  $(function () {
    var check = $('#check').val();

    for (var i = 1; i <= check; i++) {
        (function (i) {
            $('input[id$="hargaSatuan' + i + '"]').on("input", function () {
              var volume = $('#volume'+i).val();
              var satuan = $('#satuan'+i).val();
              var hargaSatuan = $(this).val();

              if(satuan == "%"){
                var total = (volume * hargaSatuan)/100;
              } else {
                var total = volume * hargaSatuan;
              }

              $('#subJumlah'+i).val(total);
            });
        })(i);
    }
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
</script>
<script type="text/javascript">
  var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
      e.preventDefault();
      sig.signature('clear');
      $("#signature64").val('');
  });
  var sig1 = $('#sig1').signature({syncField: '#signature641', syncFormat: 'PNG'});
    $('#clear1').click(function(e1) {
      e1.preventDefault();
      sig1.signature('clear');
      $("#signature641").val('');
  });
  var sig2 = $('#sig2').signature({syncField: '#signature642', syncFormat: 'PNG'});
    $('#clear2').click(function(e2) {
      e2.preventDefault();
      sig2.signature('clear');
      $("#signature642").val('');
  });
  var sig3 = $('#sig3').signature({syncField: '#signature643', syncFormat: 'PNG'});
    $('#clear3').click(function(e3) {
      e3.preventDefault();
      sig3.signature('clear');
      $("#signature643").val('');
  });
</script>
</body>
</html>
