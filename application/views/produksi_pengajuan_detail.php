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
            <h1>Detail Pengajuan No. <?php echo $id?></h1>
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
                <div class="card-header row">
                    <div class="col-md-9">
                        <a href="<?php echo base_url()?>Dashboard/informasi_pengajuan_pembayaran" class="btn btn-success btn-sm">Kembali</a>
                    </div>
                    <div class="col-md-3">
                        <?php foreach($this->db->get_where('produksi_pengajuan', array('id_pengajuan'=>$id))->result() as $prods){
                            if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manajer keuangan"){
                                if($prods->status == "menunggu"){?> 
                                    <a href="<?php echo base_url()?>Dashboard/approve_pengajuan_pembayaran?id=<?php echo $prods->id_pengajuan?>" class="btn btn-sm btn-success">Approve</a>
                                    <a href="<?php echo base_url()?>Dashboard/tolak_pengajuan_pembayaran?id=<?php echo $prods->id_pengajuan?>" class="btn btn-sm btn-danger">Tolak</a>
                            <?php } else if($prods->status == "disetujui"){
                                $this->db->order_by('no_faktur', "ASC"); 
                                $total = 0;
                                foreach($this->db->get_where('produksi_transaksi', array('id_pengajuan'=>$prods->id_pengajuan))->result() as $tr){
                                    $total = $total + ($tr->qty*$tr->harga_satuan);
                                }
                                $total_pgl = 0;
                                foreach($this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$tr->no_faktur))->result() as $pgl){
                                    $total_pgl = $total_pgl + $pgl->nominal;
                                } 
                                // echo $total." ".$total_pgl;
                                if(($total - $total_pgl) == 0){?>
                                    <a href="<?php echo base_url()?>Dashboard/pelunasan_pengajuan?id=<?php echo $prods->id_pengajuan?>" class="btn btn-outline-primary btn-sm btn-flat">Lunas</a>
                                <?php }else {?>
                                    <a href="<?php echo base_url()?>Dashboard/pembayaran_pengajuan?id=<?php echo $prods->id_pengajuan?>" class="btn btn-outline-primary btn-sm btn-flat">Bayar</a>
                                <?php }?>
                            <?php }}?>
                    </div>
                </div>
                <div class="card-body row">
                        <div class="col-md-4 form-group">
                            <label>No Pengajuan</label>
                            <input type="text" class="form-control" value="<?php echo $prods->id_pengajuan?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Keterangan</label>
                            <textarea class="form-control" value="" readonly><?php echo $prods->keterangan?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label>Jatuh Tempo</label>
                            <input type="text" class="form-control" value="<?php echo $prods->tgl_jatuh_tempo?>" readonly>
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
                    <?php $no=1; $total=0; foreach($check_all->result() as $row){?>
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
              <!-- /.card-body -->
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
