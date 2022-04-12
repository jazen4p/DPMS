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
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">
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
              Kontrol Utang
              <?php if(isset($nama_perumahan)){
                  if($nama_perumahan == ""){
                    echo " - All";
                  } else {
                    echo " - ".$nama_perumahan;
                  }
                }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Kontrol Utang</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div>

            </div>
            <hr/>

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <button id="button" class="btn btn-flat btn-sm btn-info">FILTER</button>
                <div id="wrapper" style="text-align: center">
                  <form action="<?php echo base_url()?>Dashboard/filter_daftar_utang" method="POST">
                    <div class="row">  
                      <div class="col-sm-6">
                        <div class="form-group">
                          Perumahan:
                          <select name="perumahan" class="form-control">
                              <option value="">Semua</option>
                              <?php foreach($this->db->get('perumahan')->result() as $perumahan){
                                echo "<option ";
                                if(isset($k_perumahan)){
                                  if($k_perumahan == $perumahan->kode_perumahan){
                                    echo "selected";
                                  }
                                }
                                echo " value='$perumahan->kode_perumahan'>$perumahan->nama_perumahan</option>";
                              }?>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          Status:
                          <select name="status" class="form-control">
                            <?php if(isset($status)){ 
                            if($status == ""){?>
                              <option value="" selected>Semua</option>
                              <option value="lunas">Lunas</option>
                              <option value="belum lunas">Belum Lunas</option>
                            <?php } else if($status == "lunas"){?>
                              <option value="">Semua</option>
                              <option value="lunas" selected>Lunas</option>
                              <option value="belum lunas">Belum Lunas</option>
                            <?php } else {?>
                              <option value="">Semua</option>
                              <option value="lunas">Lunas</option>
                              <option value="belum lunas" selected>Belum Lunas</option>
                            <?php }} else {?>
                              <option value="">Semua</option>
                              <option value="lunas">Lunas</option>
                              <option value="belum lunas">Belum Lunas</option>
                            <?php }?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <input type="submit" class="btn btn-info btn-flat btn-sm" value="SEARCH">
                  </form>
                </div> <br>
                <table id="example2" class="table table-bordered table-striped" style="font-size: 13px">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>No Kwitansi</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                        <th>Jumlah Utang</th>
                        <th>Terbayar</th>
                        <th>Sisa Utang</th>
                        <th>Tgl Beli</th>
                        <th>Tgl Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody style="white-space: nowrap">
                    <?php $no=1; foreach($check_all->result() as $row){?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $row->no_pengeluaran?></td>
                        <?php foreach($this->db->get_where('keuangan_kode_induk_pengeluaran', array('kode_induk'=>$row->kategori_pengeluaran))->result() as $induk ) {?>
                          <td><?php echo $row->kategori_pengeluaran."-".$induk->nama_induk?></td>
                          <?php foreach($this->db->get_where('keuangan_kode_pengeluaran', array('kode_pengeluaran'=>$row->jenis_pengeluaran))->result() as $anak ) {?>
                          <td><?php echo $row->jenis_pengeluaran."-".$anak->nama_pengeluaran?></td>
                        <?php }}?>
                        <td><?php echo $row->keterangan?></td>
                        <td><?php echo "Rp. ".number_format($row->nominal)?></td>
                        <?php 
                        $query = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$row->no_pengeluaran));
                        $nominal_sementara = 0;
                        if($query->num_rows() == 0){?>
                          <td>-</td>
                          <td><?php echo number_format($row->nominal)?></td>
                        <?php } else {
                          foreach($query->result() as $uang){
                            $nominal_sementara = $nominal_sementara + $uang->nominal;
                          }
                        ?>
                          <td><?php echo "Rp. ".number_format($nominal_sementara)?></td>
                          <td><?php echo "Rp. ".number_format($row->nominal-$nominal_sementara);?></td>
                        <?php }?>
                        <td><?php echo $row->periode_awal?></td>
                        <td><?php echo $row->periode_akhir?></td>
                        <td><?php echo $row->status?></td>
                        <td>
                          <?php if($row->status == "lunas"){?>
                            <a href="<?php echo base_url()?>Dashboard/transaksi_detail_utang?id=<?php echo $row->id_pengeluaran?>" class="btn btn-flat btn-outline-primary btn-sm">Detail</a>
                          <?php } else if($row->nominal-$nominal_sementara == 0){?>
                            <button onclick="myFunction(<?php echo $row->id_pengeluaran?>)" class="btn btn-flat btn-outline-primary btn-sm">Lunas</button>
                            <a href="<?php echo base_url()?>Dashboard/transaksi_detail_utang?id=<?php echo $row->id_pengeluaran?>" class="btn btn-flat btn-outline-primary btn-sm">Detail</a>
                          <?php } else if($row->status == "batal"){?>
                            <a href="<?php echo base_url()?>Dashboard/transaksi_detail_utang?id=<?php echo $row->id_pengeluaran?>" class="btn btn-flat btn-outline-primary btn-sm">Detail</a>
                          <?php } else {?>
                            <a href="<?php echo base_url()?>Dashboard/transaksi_utang_form?id=<?php echo $row->id_pengeluaran?>" class="btn btn-flat btn-outline-primary btn-sm">Bayar</a>
                            <a href="<?php echo base_url()?>Dashboard/transaksi_detail_utang?id=<?php echo $row->id_pengeluaran?>" class="btn btn-flat btn-outline-primary btn-sm">Detail</a>
                            <a href="<?php echo base_url()?>Dashboard/hapus_utang?id=<?php echo $row->id_pengeluaran?>" class="btn btn-sm btn-outline-primary btn-flat">Batal</a>
                          <?php }?>
                        </td>
                        
                    </tr>
                    <?php $no++;}?>
                    <?php foreach($prod->result() as $pr){?>
                      <tr>
                        <td><?php echo $no?></td>
                        <td>
                          <?php
                          foreach($this->db->get_where('produksi_transaksi', array('nama_toko'=>$pr->nama_toko, 'tgl_deadline'=>$pr->tgl_deadline))->result() as $tl1){
                            echo $tl1->no_faktur." : ".$tl1->nama_barang."<br>";
                          }?>
                        </td>
                        <td></td>
                        <td></td>
                        <td><?php echo $pr->nama_toko." || Item: ".count($this->db->get_where('produksi_transaksi', array('nama_toko'=>$pr->nama_toko, 'tgl_deadline'=>$pr->tgl_deadline))->result())?></td>
                        <td>
                          <?php 
                          $ttl = 0;
                          foreach($this->db->get_where('produksi_transaksi', array('nama_toko'=>$pr->nama_toko, 'tgl_deadline'=>$pr->tgl_deadline))->result() as $tl){
                            $ttl = $ttl + ($tl->qty * $tl->harga_satuan);
                          }
                          
                          echo "Rp. ".number_format($ttl);
                          ?>
                        </td>
                        <td>
                          <?php 
                          foreach($this->db->get_where('produksi_transaksi', array('nama_toko'=>$pr->nama_toko, 'tgl_deadline'=>$pr->tgl_deadline))->result() as $tl1){
                            $query = $this->db->get_where('produksi_pengajuan', array('id_pengajuan'=>$tl1->id_pengajuan));

                            $no=1; $total_byr=0; foreach($this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$tl1->no_faktur))->result() as $byr){
                              $total_byr = $total_byr + $byr->nominal;
                            }
                          }
                          echo "Rp. ".number_format($total_byr);
                          ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($ttl-$total_byr)?></td>
                        <td>
                          <?php foreach($this->db->get_where('produksi_transaksi', array('nama_toko'=>$pr->nama_toko, 'tgl_deadline'=>$pr->tgl_deadline))->result() as $tl1){
                            echo $tl1->tgl_pesan."<br>";
                          }?>
                        </td>
                        <td><?php echo $pr->tgl_deadline?></td>
                        <td>
                          <?php
                          foreach($this->db->get_where('produksi_transaksi', array('nama_toko'=>$pr->nama_toko, 'tgl_deadline'=>$pr->tgl_deadline))->result() as $tl1){
                            if($tl1->status==""){
                              echo "<span style='color: red'>Belum</span>";
                            }
                            echo "<span style='color: green'>$tl1->status</span>"."<br>";
                          }?>
                        </td>
                        <td><a class="btn btn-outline-primary btn-flat btn-sm" href="<?php echo base_url()?>Dashboard/rincian_pembelian_utang?id=<?php echo $pr->kode_perumahan?>&bln=<?php echo date('Y-m-d', strtotime($pr->tgl_deadline))?>&tk=<?php echo $pr->nama_toko?>">Detail</a></td>
                      </tr>
                    <?php $no++;}?>
                  </tfoot>
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
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>
<!-- page script -->
<script>
function myFunction(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Apakah Anda yakin melunaskan Utang ini?");
  if (r == true) {
    window.location.replace(base_url+"/pelunasan_utang?id="+id);
  } else {
    window.location.replace(base_url+"/transaksi_pengeluaran_hutang")
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
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "scrollY": "350px",
      fixedColumns:   {
        leftColumns: 2,
      },
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
