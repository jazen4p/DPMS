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
              In-Out Flow Bahan
              <?php if(isset($nama_perumahan)){
                  echo " - ".$nama_perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">In-Out Flow Bahan</li>
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <form action="<?php echo base_url()?>Dashboard/pembelian_bahan_stok" method="POST" enctype="multipart/form-data">
              <div class="card-header">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="hidden" value="<?php echo $id?>" name="kode_perumahan">
                    <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager produksi" || $this->session->userdata('role')=="staff purchasing"){?>
                      <input type="submit" class="btn btn-flat btn-sm btn-success" value="Daftarkan Barang">
                    <?php }?>
                    <?php 
                      if(isset($succ_msg)){
                        echo "<br> <span style='color: green'>$succ_msg</span>";
                      }
                    ?>
                  </div>
                  <div class="col-sm-6" style="text-align: right">
                    <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager produksi" || $this->session->userdata('role')=="admin inventory"){?>
                      <a href="<?php echo base_url()?>Dashboard/stok_masuk" class="btn btn-success btn-flat btn-sm">+ Add Stok Masuk</a>
                    <?php }?>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table id="example2" class="table table-striped table-bordered" style="font-size: 14px">
                        <div style="font-size: 16px; font-weight: bold; text-align: center">IN BAHAN</div>
                        <thead>
                            <tr>
                              <?php if($this->session->userdata('role')=="superadmin" ||  $this->session->userdata('role')=="manager produksi" || $this->session->userdata('role')=="manager keuangan" || $this->session->userdata('role')=="staff purchasing"){?>
                              <th>Check</th>
                              <?php }?>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Masuk/Keluar</th>
                              <th>Nama Bahan</th>
                              <th>Nama Toko</th>
                              <th>Satuan</th>
                              <th>Qty</th>
                              <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager produksi" ){?>
                                <th>Aksi</th>
                                <th>Log</th>
                              <?php } else if($this->session->userdata('role')=="admin inventory") {?>
                                <th>Aksi</th>
                              <?php }?>
                            </tr>
                        </thead>
                        <tbody style="white-space: nowrap">
                            <?php $no=1; foreach($check_all->result() as $row){?>
                              <tr>
                              <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager produksi" || $this->session->userdata('role')=="staff purchasing"){?>
                                <td>
                                  <!-- <input type="hidden" value="<?php echo $id?>" name="kode_perumahan"> -->
                                  <?php
                                    if($row->status != "diajukan"){?>

                                    <input type="checkbox" class="form-control" name="id_arus[]" value="<?php echo $row->id_arus?>"> 
                                  <?php } else {
                                    echo "<span style='color: red'>Terdaftar</span>"; 
                                  }?>
                                </td>
                                <?php }?>
                                <td>
                                  <?php echo $no?>
                                </td>
                                <td><?php echo date('Y-m-d H:i:sa', strtotime($row->tgl_arus));?></td>
                                <td><?php echo $row->jenis_arus?></td>
                                <td><?php echo $row->nama_barang?></td>
                                <td><?php echo $row->nama_toko?></td>
                                <td>
                                    <?php foreach($this->db->get_where('produksi_master_data', array('nama_data'=>$row->nama_barang, 'kategori'=>"barang"))->result() as $sat){
                                        echo $sat->nama_satuan;
                                    }?>
                                </td>
                                <td><?php echo $row->qty?></td>
                                <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager produksi"){?>
                                  <td>
                                    <?php if($row->status_rev != "true"){?>
                                      <a href="<?php echo base_url()?>Dashboard/open_akses_edit_stok?id=<?php echo $row->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Akses Edit</a>
                                    <?php } else {
                                      echo "Terbuka"; 
                                    }?>
                                    <a href="<?php echo base_url()?>Dashboard/view_edit_arus_stok?id=<?php echo $row->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Edit</a>
                                    <a href="<?php echo base_url()?>Dashboard/hapus_arus_stok?id=<?php echo $row->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Hapus</a>
                                  </td>
                                  <td><?php 
                                    if($row->tgl_update != "0000-00-00 00:00:00"){
                                      echo date('Y-m-d h:i:sa', strtotime($row->tgl_update));
                                      echo "<br>";
                                      // if($row->status_rev != "true"){
                                        echo "Last revised : ".date('Y-m-d h:i:sa', strtotime($row->date_rev));
                                      // }
                                    } else {
                                      echo "-Null-";
                                      echo "<br>";
                                      // if($row->status_rev != "true"){
                                        echo "Last revised : ".date('Y-m-d h:i:sa', strtotime($row->date_rev));
                                      // }
                                    }?>
                                  </td>
                                <?php } else {
                                  if($this->session->userdata('role')=="admin inventory"){
                                    if($row->status_rev == "true"){?>
                                    <td>
                                      <a href="<?php echo base_url()?>Dashboard/view_edit_arus_stok?id=<?php echo $row->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Edit</a>
                                      <a href="<?php echo base_url()?>Dashboard/hapus_arus_stok?id=<?php echo $row->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Hapus</a>
                                    </td>
                                <?php } else {?>
                                  <td>
                                    <a href="<?php echo base_url()?>Dashboard/hapus_arus_stok?id=<?php echo $row->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Hapus</a>
                                  </td>
                                <?php }}}?>
                              </tr>
                            <?php $no++;}?>
                        </tbody>
                    </table>
                    </form>
                  </div>  
                </div>
              </div>
              <div class="card-footer">
                <!-- <input type="hidden" value="<?php echo $no?>" id="check">
                <input type="hidden" value="<?php echo $id?>" name="kode_perumahan">
                <input type="submit" value="Tambah" class="btn btn-success btn-flat"> -->
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header" style="text-align: right">
                <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager produksi" || $this->session->userdata('role')=="admin inventory"){?>
                  <a href="<?php echo base_url()?>Dashboard/stok_keluar" class="btn btn-success btn-flat btn-sm">+ Add Stok Keluar</a>
                <?php }?>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table id="example3" class="table table-striped table-bordered" style="font-size: 14px">
                        <div style="font-size: 16px; font-weight: bold; text-align: center">OUT BAHAN</div>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Masuk/Keluar</th>
                                <th>Penerima Barang</th>
                                <th>Kategori</th>
                                <th>No Unit</th>
                                <th>Keterangan</th>
                                <th>Nama Bahan</th>
                                <th>Satuan</th>
                                <th>Qty</th>
                                <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager produksi" ){?>
                                  <th>Aksi</th>
                                  <th>Log</th>
                                <?php } else if($this->session->userdata('role')=="admin inventory") {?>
                                  <th>Aksi</th>
                                <?php }?>
                            </tr>
                        </thead>
                        <tbody style="white-space: nowrap">
                            <?php $no1=1; foreach($check_all1->result() as $row1){?>
                              <tr>
                                <td><?php echo $no1?></td>
                                <td><?php echo date('d F Y H:i:sa', strtotime($row1->tgl_arus));?></td>
                                <td><?php echo $row1->jenis_arus?></td>
                                <td><?php echo $row1->nama_pengambil?></td>
                                <td><?php echo $row1->kategori?></td>
                                <td>
                                  <?php 
                                    if($row1->kategori == "prasarana"){
                                      // echo $row1->no_unit;
                                      foreach($this->db->get_where('kawasan', array('id_kawasan'=>$row1->no_unit))->result() as $kws){
                                        echo $kws->nama;
                                      }
                                    } else {
                                      echo $row1->no_unit;
                                    }
                                  ?>
                                </td>
                                <td><?php echo $row1->keterangan?></td>
                                <td><?php echo $row1->nama_barang?></td>
                                <td>
                                    <?php foreach($this->db->get_where('produksi_master_data', array('nama_data'=>$row1->nama_barang, 'kategori'=>"barang"))->result() as $sat1){
                                        echo $sat1->nama_satuan;
                                    }?>
                                </td>
                                <td><?php echo $row1->qty?></td>
                                <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager produksi"){?>
                                  <td>
                                    <?php if($row1->status_rev != "true"){?>
                                      <a href="<?php echo base_url()?>Dashboard/open_akses_edit_stok?id=<?php echo $row1->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Akses Edit</a>
                                    <?php } else {
                                      echo "Terbuka"; 
                                    }?>
                                    <a href="<?php echo base_url()?>Dashboard/view_edit_arus_stok?id=<?php echo $row1->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Edit</a>
                                    <a href="<?php echo base_url()?>Dashboard/hapus_arus_stok?id=<?php echo $row1->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Hapus</a>
                                  </td>
                                  <td><?php 
                                    if($row1->tgl_update != "0000-00-00 00:00:00"){
                                      echo date('Y-m-d h:i:sa', strtotime($row1->tgl_update));
                                      echo "<br>";
                                      // if($row1->status_rev != "true"){
                                        echo "Last revised : ".date('Y-m-d h:i:sa', strtotime($row1->date_rev));
                                      // }
                                    } else {
                                      echo "-Null-";
                                      echo "<br>";
                                      // if($row1->status_rev != "true"){
                                        echo "Last revised : ".date('Y-m-d h:i:sa', strtotime($row1->date_rev));
                                      // }
                                    }?>
                                  </td>
                                <?php } else {
                                  if($this->session->userdata('role')=="admin inventory"){
                                    if($row1->status_rev == "true"){?>
                                    <td>
                                      <a href="<?php echo base_url()?>Dashboard/view_edit_arus_stok?id=<?php echo $row1->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Edit</a>
                                      <a href="<?php echo base_url()?>Dashboard/hapus_arus_stok?id=<?php echo $row1->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Hapus</a>
                                    </td>
                                <?php } else {?>
                                  <td>
                                    <a href="<?php echo base_url()?>Dashboard/hapus_arus_stok?id=<?php echo $row1->id_arus?>&kode=<?php echo $id?>" class="btn btn-outline-primary btn-flat btn-sm">Hapus</a>
                                  </td>
                                <?php }}}?>
                              </tr>
                            <?php $no1++;}?>
                        </tbody>
                    </table>
                  </div>    
                </div>
              </div>
              <div class="card-footer">
                <!-- <input type="hidden" value="<?php echo $no?>" id="check">
                <input type="hidden" value="<?php echo $id?>" name="kode_perumahan">
                <input type="submit" value="Tambah" class="btn btn-success btn-flat"> -->
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
      "scrollX": true,
      "scrollY": "400px"
    });true
    $('#example3').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "scrollY": "400px"
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

  // $(document).ready(function(){ 
  //   var check = $('#check').val();
  //   var i;
  //   // alert(check);
  //   // $('#volume1').val(check);

  //   for(i = 1; i < check; i++){
  //       $('#volume'+i).on("input", function(){
  //       var volume = $(this).val();
  //       var hargaSatuan = $('#hargaSatuan'+i).val();

  //       var total = volume * hargaSatuan;

  //       $('#subJumlah'+i).val(total);
  //       })

  //       $('#hargaSatuan'+i).on("input", function(){
  //       var volume = $('#volume'+i).val();
  //       var hargaSatuan = $(this).val();

  //       var total = volume * hargaSatuan;

  //       $('#subJumlah'+i).val(total);
  //       })
  //   }
  // })

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
</script>
</body>
</html>
<!-- In-Out Flow Bahan -->