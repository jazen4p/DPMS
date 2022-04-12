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
              Skema Neraca Saldo Awal
              <?php if(isset($perumahan)){
                  echo " - ".$perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Skema Neraca Saldo Awal</li>
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
            <div>

            </div>
            <hr/>

            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                  <a href="<?php echo base_url()?>Dashboard/view_neraca_saldo" class="btn btn-outline-success btn-sm btn-flat">Kembali</a>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <?php if(isset($revisi)){?>
                        <form action="<?php echo base_url()?>Dashboard/edit_neraca_saldo_awal" method="POST">
                        <!-- <div class="form-group row">
                            <label class="col-sm-2">Perumahan</label>
                            <select name="kode_perumahan" class="form-control col-sm-10" required>
                                <option value="" disabled selected>-Pilih-</option>
                                <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                                    <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                                <?php }?>
                            </select>
                        </div> -->
                        <table id="" class="table table-bordered table-striped" style="font-size: 14px">
                        <div style="text-align: center">
                            <h2>Skema - <?php echo $nama_perumahan?></h2>
                        </div>
                        <thead>
                            <tr>
                                <!-- <th>No</th> -->
                                <th>Nama Akun</th>
                                <th>No Akun</th>
                                <th>POS</th>
                                <th>Saldo Awal</th>
                                <!-- <th>Status</th> -->
                                <!-- <th>Jmlh Diterima</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($check_all->result() as $row){ ?>
                            <tr style="background-color: yellow">
                                <!-- <td><?php echo $no;?></td> -->
                                <td style="white-space: nowrap"><?php echo $row->nama_induk?></td>
                                <td><?php echo $row->no_induk?></td>
                                <td><?php echo $row->kategori_induk?></td>
                                <td></td>
                                <!-- <a href="#demo" class="btn btn-outline-primary btn-sm btn-flat" date-toggle="collapse">Expand/Collapse</a> -->
                            </tr>
                            <?php 
                            // $get = $this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk));

                            $this->db->order_by('no_akun', "ASC");
                            $query = $this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result();
                            // $query = $this->db->get_where('keuangan_neraca_saldo_awal', array('id_induk'=>$row->id_induk,'kode_perumahan'=>$kode_perumahan))->result();
                            // print_r($query);
                            foreach($query as $row1){?>
                                <tr>
                                    <td style="white-space: nowrap"><?php echo $row1->nama_akun?>
                                        <input type="hidden" name="id_akun[]" value="<?php echo $row1->id_akun?>">
                                        <input type="hidden" name="nama_akun[]" value="<?php echo $row1->nama_akun?>">
                                        <input type="hidden" name="id_induk[]" value="<?php echo $row1->id_induk?>">
                                        <input type="hidden" name="pos[]" value="<?php echo $row1->pos?>">
                                    </td>
                                    <td><?php echo $row1->no_akun?><input type="hidden" name="no_akun[]" value="<?php echo $row1->no_akun?>"></td>
                                    <td><?php echo $row1->kategori_induk?><input type="hidden" name="kategori_induk[]" value="<?php echo $row1->kategori_induk?>"></td>
                                    <?php 
                                    $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$row1->no_akun, 'kode_perumahan'=>$kode_perumahan));
                                    if($ts->num_rows() > 0){
                                      foreach($ts->result() as $tst){?>
                                        <td><input type="number" name="nominal[]" class="form-control" value="<?php echo $tst->nominal?>"></td>
                                    <?php }} else {?>
                                      <td><input type="number" name="nominal[]" class="form-control" value=""></td>
                                    <?php }?>
                                </tr>
                            <?php } $no++;}?>
                        </tfoot>
                        </table>
                    <?php }else {?>
                    <form action="<?php echo base_url()?>Dashboard/add_neraca_saldo_awal" method="POST">
                        <!-- <div class="form-group row">
                            <label class="col-sm-2">Perumahan</label>
                            <select name="kode_perumahan" class="form-control col-sm-10" required>
                                <option value="" disabled selected>-Pilih-</option>
                                <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                                    <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                                <?php }?>
                            </select>
                        </div> -->
                        <table id="" class="table table-bordered table-striped" style="font-size: 14px">
                        <div style="text-align: center">
                            <h2>Skema - <?php echo $nama_perumahan?></h2>
                        </div>
                        <thead>
                            <tr>
                                <!-- <th>No</th> -->
                                <th>Nama Akun</th>
                                <th>No Akun</th>
                                <th>POS</th>
                                <th>Saldo Awal</th>
                                <!-- <th>Status</th> -->
                                <!-- <th>Jmlh Diterima</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($check_all->result() as $row){ ?>
                            <tr style="background-color: yellow">
                                <!-- <td><?php echo $no;?></td> -->
                                <td style="white-space: nowrap"><?php echo $row->nama_induk?></td>
                                <td><?php echo $row->no_induk?></td>
                                <td><?php echo $row->kategori_induk?></td>
                                <td></td>
                                <!-- <a href="#demo" class="btn btn-outline-primary btn-sm btn-flat" date-toggle="collapse">Expand/Collapse</a> -->
                            </tr>
                            <?php 
                            $this->db->order_by('no_akun', "ASC");
                            $query = $this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result();
                            foreach($query as $row1){?>
                                <tr>
                                    <td style="white-space: nowrap"><?php echo $row1->nama_akun?>
                                        <input type="hidden" name="id_akun[]" value="<?php echo $row1->id_akun?>">
                                        <input type="hidden" name="nama_akun[]" value="<?php echo $row1->nama_akun?>">
                                        <input type="hidden" name="id_induk[]" value="<?php echo $row1->id_induk?>">
                                        <input type="hidden" name="pos[]" value="<?php echo $row1->pos?>">
                                    </td>
                                    <td><?php echo $row1->no_akun?><input type="hidden" name="no_akun[]" value="<?php echo $row1->no_akun?>"></td>
                                    <td><?php echo $row1->kategori_induk?><input type="hidden" name="kategori_induk[]" value="<?php echo $row1->kategori_induk?>"></td>
                                    <td><input type="number" name="nominal[]" class="form-control"></td>
                                </tr>
                            <?php } $no++;}?>
                        </tfoot>
                        </table>
                      <?php }?>
                  </div>  
                </div>
              </div>
              <div class="card-footer">
                <input type="hidden" value="<?php echo $kode_perumahan?>" name="kode_perumahan">
                <input type="hidden" value="<?php echo $id?>" name="id">
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
</script>
</body>
</html>
