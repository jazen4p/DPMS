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
            <h1>
              Progress Unit
              <?php if(isset($k_perumahan)){
                  echo " - ".$k_perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Progress Unit</li>
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
            <div class="card">
              <div class="card-header">
                <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
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
                        </div>
                    </form>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped" style="font-size: 13px">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Perumahan</th>
                        <th>Unit</th>
                        <th>Konsumen</th>
                        <!-- <th>Harga Unit</th> -->
                        <th>Luas Tanah (m<sup>2</sup>)</th>
                        <th>Luas Bangunan (m<sup>2</sup>)</th>
                        <!-- <th>Upah</th> -->
                        <th>Proyek Mulai</th>
                        <th>Proyek Selesai</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody style="white-space: nowrap">
                    <?php $no=1; foreach($check_all->result() as $row){?>
                        <tr>
                          <td><?php echo $no;?></td>
                          <td>
                            <?php foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $prmh){
                              echo $prmh->nama_perumahan; 
                            }?>
                          </td>
                          <td><?php echo $row->unit?></td>
                          <td>
                            <?php 
                            // foreach($this->db->get_where('ppjb', array('id_psjb'=>$row->id_ppjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as $ppjbs){
                            //   echo $ppjbs->nama_pemesan;
                            // }
                            $str = explode(", ", $row->unit);
                            // print_r($str);

                            foreach($this->db->get_where('rumah', array('kode_rumah'=>$str[0]))->result() as $rows){
                              echo $rows->nama_pemilik;
                            }
                            ?>
                          </td>
                          <!-- <td>
                            <?php foreach($this->db->get_where('ppjb', array('id_psjb'=>$row->id_ppjb))->result() as $ppjb){
                              echo "Rp. ".number_format($ppjb->total_jual);
                            }?>
                          </td> -->
                          <td><?php echo $row->luas_tanah?></td>
                          <td><?php echo $row->luas_bangunan?></td>
                          <!-- <td><?php echo "Rp. ".number_format($row->upah)?></td> -->
                          <td><?php echo date('d F Y', strtotime($row->tgl_mulai))?></td>
                          <td><?php echo date('d F Y', strtotime($row->tgl_selesai))?></td>
                          <td>
                            <button type="button" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $row->id_kbk?>">Cek Progress</button>
                          </td>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Progress Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="response">

        </div>
      </div>
      <div class="modal-footer">
          <!-- <input type="text" name="id" id="idPSJB" class="idPSJB">
          <input type="hidden" name="kode" value="<?php echo $row->kode_perumahan?>"> -->
          <!-- <input type="hidden" name="id" value="<?php echo $id?>">
          <input type="hidden" name="bln" value="<?php echo $tgl?>"> -->

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
      "scrollX": true
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
  
  $(function() {
    var b = $("#button");
    var w = $("#wrapper");
    var l = $("#list");
    b.click(function() {
      w.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });
  });

  $('#exampleModal').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-id');
    // var kodePerumahan = $(e.relatedTarget).attr('data-kode');

    // $(this).find('.idPSJB').val(myRoomNumber);
    // alert(myRoomNumber);
    
    // var selectedCountry = $("#outpost option:selected").val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>Dashboard/get_progress_unit",
        data: { country : myRoomNumber } 
    }).done(function(data){
        $("#response").html(data);
    });
  });
  
  // $(document).ready(function(){
  //   $("select#outpost").change(function(){
  //       var selectedCountry = $("#outpost option:selected").val();
  //       $.ajax({
  //           type: "POST",
  //           url: "<?php echo base_url()?>Dashboard/get_unit",
  //           data: { country : selectedCountry } 
  //       }).done(function(data){
  //           $("#response").html(data);
  //       });
  //   });

  //   $("select#namaBahan").change(function(){
  //       var selectedCountry = $(this).val();
  //       $.ajax({
  //           type: "POST",
  //           url: "<?php echo base_url()?>Dashboard/get_satuan",
  //           data: { country : selectedCountry } 
  //       }).done(function(data){
  //           $("#response1").val(data);
  //       });
  //   });
  // });
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
</script>
</body>
</html>
