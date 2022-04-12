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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail No Faktur <?php echo $no_faktur?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Detail</li>
            </ol>
          </div>
        </div>
        <!-- <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button> -->
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_laporan_penerimaan_akuntansi" method="POST">
            <div class="row">
              <div class="col-md-6">
                <label>Perumahan</label>
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
                </select>
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">  
            <div class="card">
                <div class="card-header">
                    <a href="<?php echo base_url()?>Dashboard/management_pembelian_bahan" class="btn btn-success btn-sm">Kembali</a>
                    <button type="button" class="btn btn-flat btn-info btn-sm" data-toggle="modal" data-target="#exampleModal">Foto Faktur</button>
                </div>
                <div class="card-body row">
                    <?php foreach($prod as $prods){?> 
                        <div class="col-md-4 form-group">
                            <label>Toko Bangunan</label>
                            <input type="text" class="form-control" value="<?php echo $prods->nama_toko?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Tanggal Pesan</label>
                            <input type="text" class="form-control" value="<?php echo $prods->tanggal_pesan?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Jatuh Tempo</label>
                            <input type="text" class="form-control" value="<?php echo $prods->tanggal_tempo?>" readonly>
                        </div>
                    <?php }?>
                </div>
            </div>
            <div class="card">
              <!-- /.card-header -->
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
                    <?php $total = 0; $nominal = 0;
                        foreach($check_all->result() as $prod){
                            $nominal = $prod->qty * $prod->harga_satuan;
                            $total = $total + $nominal;
                        }
                        $tl_byr = 0;
                        foreach($this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$no_faktur, 'kode_perumahan'=>$kode_perumahan))->result() as $klr){
                            $tl_byr = $tl_byr + $klr->nominal;
                        }
                    ?>
                    <?php $no=1; foreach($check_all->result() as $row){?>
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
                    <?php $no++;}?>
                    
                    <tr style="background-color: orange">
                        <td colspan=5 style="text-align: center">TOTAL PEMBELIAN</td>
                        <td><?php echo "Rp. ".number_format($total)?></td>
                    </tr>
                    <tr style="background-color: lightyellow">
                        <td colspan=5 style="text-align: center">TOTAL PEMBAYARAN</td>
                        <td><?php echo "Rp. ".number_format($tl_byr)?></td>
                    </tr>
                    <tr style="background-color: orange">
                        <td colspan=5 style="text-align: center">SISA UTANG</td>
                        <td><?php echo "Rp. ".number_format($total - $tl_byr)?></td>
                    </tr>
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
        <h5 class="modal-title" id="exampleModalLabel">Foto Faktur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="<?php echo base_url()?>gambar/produksi/<?php echo $prods->file_name?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->

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
  var r = confirm("Anda akan menetapkan PPJB ini di approve?");
  if (r == true) {
    window.location.replace(base_url+"/ppjb_approve?id="+id);
  } else {
    window.location.replace(base_url+"/ppjb_management")
  }
  document.getElementById("demo").innerHTML = txt;
}

function myFunction1(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PPJB ini dibatalkan?");
  if (r == true) {
    window.location.replace(base_url+"/ppjb_pembatalan?id="+id);
  } else {
    window.location.replace(base_url+"/ppjb_management")
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
