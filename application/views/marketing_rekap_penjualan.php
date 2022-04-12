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

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              Rekap Penjualan
              <?php if(isset($nama_perumahan)){
                  echo " - ".$nama_perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Rekap Penjualan</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
            </div>
            <div class="col-sm-2">
                <!-- <button type="button" id="button" class="btn btn-flat btn-outline-info" data-toggle="modal" data-target="#exampleModal">Per Bangunan</button> -->
                <a href="<?php echo base_url()?>Dashboard/print_laporan_marketing?id=<?php echo $id?>&min=<?php echo $tglmin?>&max=<?php echo $tglmax?>" class="btn btn-outline-primary btn-flat" target="_blank">PRINT</a>
            </div>
            <!-- <form action="<?php echo base_url()?>Dashboard/print_rekap_rincian" method="POST" class="col-sm-1">
              <input type="hidden" value="<?php echo $id?>" name="id">
              <input type="hidden" value="<?php echo $tgl?>" name="bln">

              <input type="submit" value="PRINT" class="btn btn-outline-primary btn-flat">
            </form> -->
        </div>
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_rekap_penjualan" method="POST">
            <div class="row">
              <div class="col-md-6">
                <!-- <label>Perumahan</label>
                <select name="perumahan" class="form-control">
                    <option value="">Semua</option>
                    <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                    <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                    <?php }?>
                </select> -->
                <!-- <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="">Semua</option>
                    <option value="booking fee">Booking Fee</option>
                    <option value="piutang kas">Piutang Kas</option>
                    <option value="ground tank">Ground Tank</option>
                    <option value="tambahan bangunan">Tambahan Bangunan</option>
                    <option value="penerimaan lain">Penerimaan Lain</option>
                </select> -->
                <!-- <label>Status</label>
                <select name="status" class="form-control">
                    <option value="A">Semua</option>
                    <option value="booking fee">Approved</option>
                    <option value="piutang kas">Revisi</option>
                    <option value="">Menunggu</option>
                </select> -->
                <label>Date</label>
                <input placeholder="Tanggal Awal" value="<?php if(isset($tglmin)){echo $tglmin;}?>" name="tglmin" class="textbox-n form-control" onfocus="(this.type='month')" type="text" id="date" required>
              </div>
              <div class="col-md-6">
                <label>Sampai</label>
                <input placeholder="Tanggal Akhir" value="<?php if(isset($tglmax)){echo $tglmax;}?>" name="tglmax" class="textbox-n form-control" onfocus="(this.type='month')" type="text" id="date" required>
              </div>
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
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped" style="font-size: 12px;">
                  <div style="text-align: center">
                    <?php if(isset($filter)){?>
                      Rentang Data: <?php echo date('F Y', strtotime($tglmin))." - ".date('F Y', strtotime($tglmax))?>
                    <?php }?>
                  </div>
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Marketing</th>
                        <th>Closing</th>
                        <th>Tipe</th>
                        <th>Blok</th>
                        <th>Harga Jual</th>
                        <!-- <th>Status</th> -->
                        <!-- <th>Jmlh Diterima</th> -->
                    </tr>
                  </thead>
                  <tbody style="white-space: nowrap">
                    <?php $no=1; foreach($check_all as $row){?>
                      <tr>
                        <td><?php echo $no?></td>
                        <td><?php echo date("d F Y", strtotime($row->date_by))?></td>
                        <td><?php echo $row->nama_marketing?></td>
                        <td><?php echo $row->sistem_pembayaran?></td>
                        <td>
                        <?php foreach($this->db->get_where('rumah', array('kode_rumah'=>$row->no_kavling, 'kode_perumahan'=>$row->kode_perumahan))->result() as $rmh){
                          echo $rmh->tipe_rumah;
                        }?>
                        </td>
                        <td><?php echo $row->no_kavling?></td>
                        <td><?php echo "Rp. ".number_format($rmh->harga_jual)?></td>
                      </tr>
                      <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $row1){
                        $no = $no + 1;?>
                        <tr>
                          <td><?php echo $no?></td>
                          <td><?php echo date("d F Y", strtotime($row->date_by))?></td>
                          <td><?php echo $row->nama_marketing?></td>
                          <td><?php echo $row->sistem_pembayaran?></td>
                          <td>
                          <?php echo $row1->tipe_rumah;?>
                          </td>
                          <td><?php echo $row1->kode_rumah?></td>
                          <td><?php echo "Rp. ".number_format($row1->harga_jual)?></td>
                        </tr>
                      <?php }?>
                    <?php $no++;}?>
                  </tfoot>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true
    });
    
  });

</script>
<script type="text/javascript">
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
    var check = $('#aktiva').val();
    // var i;
    $('#totalAktiva').html("Rp. "+check);
    // $('#volume1').val(check);
    var check2 = $('#passiva').val();
    // var i;
    $('#totalPassiva').html("Rp. "+check2);
    // $('#volume1').val(check);
  })
</script>
</body>
</html>
