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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
  <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script> -->
  
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

    .ui-datepicker-calendar {
      display: none;
    }
    .ui-datepicker-month {
      display: none;
    }
    .ui-datepicker-next,.ui-datepicker-prev {
      display:none;
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
              Buku Besar
              <?php if(isset($perumahan)){
                  echo " - ".$perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Buku Besar</li>
            </ol>
          </div>
        </div>
        <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_laporan_buku_besar" method="POST">
            <div class="row">
              <div class="col-md-6">
                <!-- <label>Perumahan</label>
                <select name="perumahan" class="form-control">
                    <option value="">Semua</option>
                    <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                    <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                    <?php }?>
                </select>
                <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="">Semua</option>
                    <option value="booking fee">Booking Fee</option>
                    <option value="piutang kas">Piutang Kas</option>
                    <option value="ground tank">Ground Tank</option>
                    <option value="tambahan bangunan">Tambahan Bangunan</option>
                    <option value="penerimaan lain">Penerimaan Lain</option>
                </select>
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="A">Semua</option>
                    <option value="booking fee">Approved</option>
                    <option value="piutang kas">Revisi</option>
                    <option value="">Menunggu</option>
                </select> -->
                <label>Date</label>
                <input placeholder="Tanggal Awal" value="<?php if(isset($start)){echo $start;}?>" name="tgl_awal" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
              </div>
              <div class="col-md-6">
                <label>Sampai</label>
                <input placeholder="Tanggal Akhir" value="<?php if(isset($end)){echo $end;}?>" name="tgl_akhir" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
              </div>
              <!-- <div class="col-md-12">
                <div class="form-group">
                  <label>Tahun</label>
                  <input type="month" id="datepicker" class="form-control" value="<?php if(isset($tahun)){echo date('Y-12', strtotime($tahun)); } else { echo date('Y-12'); }?>" name="tahun"/>
                </div>
              </div> -->
              <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
              <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
              <div class="col-md-12">
                <input type="hidden" value="<?php echo $id?>" name="id">
                <input type="submit" class="btn btn-info btn-flat" value="SEARCH" />
                <button type="button" id="thisPrint" class="btn btn-info btn-flat" style="">CETAK</button>
              </div>
            </div>
          </form>
        </div>
        
        <?php if(isset($kode)){?>
          <span>Pilihan saat ini: <?php if($kode == ""){echo "Semua";} else {echo $kode;}?></span>
        <?php }
        if(isset($kategori)){
          echo ", ".$kategori; 
        }
        
        $debet = 0; $kredit = 0;?>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- <hr/> -->

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table">
                </table>
                <table id="example2" class="table table-bordered table-striped" style="font-size: 13px;">
                  <div style="text-align: center">
                    <h3><?php echo $nama_perumahan?> Residence</h3>
                    <h5>Buku Besar</h5>
                    <?php if($end == ""){?>
                      <h5>Per. <?php echo date('d F Y')?></h5>
                    <?php } else {?>
                      <h5>Per. <?php echo date('d F Y', strtotime($end))?></h5>
                    <?php }?>
                  </div>
                  <div class="form-group row">
                    <label class="col-2">No Akun: </label>
                    <input type="text" class="form-control col-md-2" id="kodeAkun" readonly>
                  </div>
                  <div class="form-group row">
                    <label class="col-2">Nama Akun: </label>
                    <select class="form-control col-md-5 namaAkun" id="namaAkun">
                      <option value="" disabled selected>-Pilih-</option>
                      <?php foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('kode_perumahan'=>$kode_perumahan))->result() as $akun){?>
                        <option value="<?php echo $akun->no_akun?>"><?php echo $akun->nama_akun?></option>
                      <?php }?>
                    </select>

                    <input type="hidden" value="<?php echo $start?>" id="start">
                    <input type="hidden" value="<?php echo $end?>" id="end">
                    <input type="hidden" value="<?php echo $kode_perumahan?>" id="kodePerumahan">
                  </div>
                  <div class="row">
                    <div class="form-group row col-md-6">
                      <label class="col-4">SALDO AWAL: </label>
                      <input type="text" class="form-control col-md-8" id="saldoAwal" readonly>
                    </div>
                    <div class="form-group row col-md-6">
                      <label class="col-4">SALDO AKHIR: </label>
                      <input type="text" class="form-control col-md-8" id="saldoAkhir" readonly>
                    </div>
                  </div>
                  <thead>
                    <tr>
                        <th>TANGGAL</th>
                        <th>KETERANGAN</th>
                        <th>DEBET</th>
                        <th>KREDIT</th>
                        <th>SALDO AKHIR</th>
                        <!-- <th>Status</th> -->
                        <!-- <th>Jmlh Diterima</th> -->
                    </tr>
                  </thead>
                  <tbody style="white-space: nowrap" class="response" id="response">

                  </tbody>
                </table>
                <input type="hidden" value="<?php echo number_format($debet)?>" id="Debet">
                <input type="hidden" value="<?php echo number_format($kredit)?>" id="Kredit">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- jQuery -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>
<!-- page script -->
<script type="text/javascript">
$("#datepicker").datepicker( {
    format: " yyyy", // Notice the Extra space at the beginning
    viewMode: "years", 
    minViewMode: "years"
});
</script>
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
      "scrollX": true,
      "scrollY": "200px"
    });
    
  });

  $("select.namaAkun").change(function(){
    var selectedCountry = $(this).val();
    var kodePerumahan = $('#kodePerumahan').val();
    var start = $('#start').val();
    var end = $('#end').val();
    // var tahun = $('#tahun').val();
    // alert(selectedCountry);
    // alert(kodePerumahan);
    // alert(start);
    // alert(end);

    // window.location.href="<?php echo base_url()?>Dashboard/get_anak_akun?id="+selectedCountry;
    // document.getElementById('kodeAkunDebet').value = selectedCountry;
    $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>Dashboard/get_buku_besar",
        data: { country : selectedCountry, kodePerumahan: kodePerumahan, start: start, end: end } 
    }).done(function(data){
        $("#response").html(data);
    });
  });
</script>
<script type="text/javascript">
  // $(function () {
  //   $("#date").datepicker();
  //   $("#checkout").datepicker();
  // });


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
    var check = $('#Debet').val();
    // var i;
    $('#tdebet').html("Rp. "+check);
    // $('#volume1').val(check);
    var check2 = $('#Kredit').val();
    // var i;
    $('#tkredit').html("Rp. "+check2);
    // $('#volume1').val(check);

    
  })

  $('#namaAkun').change(function(){
    $('#kodeAkun').val($(this).val());
    
  })
</script>
</body>
</html>
