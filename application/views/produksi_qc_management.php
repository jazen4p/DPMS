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
              QC Management 
              <?php if(isset($k_perumahan)){
                  echo " - ".$k_perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">QC</li>
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
                <a href="<?php echo base_url()?>Dashboard/view_qc_management" class="btn btn-outline-success btn-flat btn-sm">Kembali</a>
                <!-- <a href="<?php echo base_url()?>Dashboard/view_add_kbk_management?id=<?php echo $id?>" class="btn btn-outline-info btn-flat btn-sm">Tambah Baru</a> -->
                <?php if(isset($succ_msg)){?> 
                  <br>
                  <span style="color: green"><?php echo $succ_msg?></span>
                <?php }?>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped" style="font-size: 14px">
                  <thead>
                    <tr>
                        <th>No KBK</th>
                        <!-- <th>Perumahan</th> -->
                        <th>Unit</th>
                        <!-- <th>Harga Unit</th> -->
                        <th>Nama Konsumen</th>
                        <th>Luas Tanah (m<sup>2</sup>)</th>
                        <th>Luas Bangunan (m<sup>2</sup>)</th>
                        <!-- <th>Upah</th> -->
                        <th>Nama Kontraktor</th>
                        <th>Tgl Mulai</th>
                        <th>Tgl Selesai</th>
                        <!-- <th>Pada</th>
                        <th>Dibuat oleh</th> -->
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody style="white-space: nowrap">
                    <?php foreach($check_all->result() as $row){?>
                        <tr>
                          <td><?php echo sprintf('%03d', $row->no_kbk)."/KBK/".$row->kode_perumahan;?></td>
                          <!-- <td><?php echo $k_perumahan?></td> -->
                          <td><?php echo $row->unit?></td>
                          <td>
                            <?php foreach($this->db->get_where('ppjb', array('id_psjb'=>$row->id_ppjb))->result() as $ppjb){
                              echo $ppjb->nama_pemesan;
                            }?>
                          </td>
                          <td><?php echo $row->luas_tanah?></td>
                          <td><?php echo $row->luas_bangunan?></td>
                          <!-- <td><?php echo "Rp. ".number_format($row->upah)?></td> -->
                          <td><?php echo $row->sub_nama?></td>
                          <td><?php echo date('Y-m-d', strtotime($row->tgl_mulai))?></td>
                          <td><?php echo date('Y-m-d', strtotime($row->tgl_selesai))?></td>
                          <!-- <td><?php echo $row->date_by?></td>
                          <td><?php echo $row->created_by?></td> -->
                          <td>
                            <a href="<?php echo base_url()?>Dashboard/qc_detail?id=<?php echo $row->id_kbk?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-flat btn-sm btn-outline-primary">Detail</a>
                            <?php if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager produksi"){?>
                              <button type="button" class="btn btn-outline-primary btn-flat btn-sm" data-target="#exampleModal" data-toggle="modal" data-id="<?php echo $row->id_kbk?>" data-kode="<?php echo $row->kode_perumahan?>">Approval</button>
                            <?php }?>
                          </td>
                        </tr>
                    <?php }?>
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
        <h5 class="modal-title" id="exampleModalLabel">QC Checking Approval</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url()?>Dashboard/edit_all_qc" method="POST">
          <div id="response">

          </div>
      </div>
      <div class="modal-footer">
          <!-- <input type="hidden" name="id" id="idPSJB" class="idPSJB">
          <input type="hidden" name="kode" value="<?php echo $row->kode_perumahan?>"> -->
          <!-- <input type="hidden" name="id" value="<?php echo $id?>">
          <input type="hidden" name="bln" value="<?php echo $tgl?>"> -->

          <input type="submit" class="btn btn-success" value="Submit">
        </form>
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
    var kodePerumahan = $(e.relatedTarget).attr('data-kode');

    // $(this).find('.idPSJB').val(myRoomNumber);
    // alert(myRoomNumber);
    
    // var selectedCountry = $("#outpost option:selected").val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>Dashboard/get_qc",
        data: { country : myRoomNumber, kode : kodePerumahan } 
    }).done(function(data){
        $("#response").html(data);
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
<script type='text/javascript'>
  $(function () {
      var check = $('#hasil_chq').val();

      for (var x = 1; x <= check; x++) {
      (function (x) {
          $('#hasilOpname'+x).on('click', function(){
              if($('#hasilOpname'+x).prop('checked') == true){
                  $('#hasilOpnameHidden'+x).attr('disabled', 'disabled');
              } else {
                  $('#hasilOpnameHidden'+x).removeAttr('disabled');
              }
              
          });
          $('#appOpname'+x).on('click', function(){
              if($('#appOpname'+x).prop('checked') == true){
                  alert('true');

                  $('#appOpnameHidden'+x).attr('disabled', 'disabled');
                  $('#hasilOpname'+x).attr('disabled', 'disabled');
                  $('#hasilOpnameHidden2'+x).removeAttr('disabled');
              } else {
                  $('#appOpnameHidden'+x).removeAttr('disabled');
                  $('#hasilOpname'+x).removeAttr('disabled');
                  $('#hasilOpnameHidden2'+x).attr('disabled', 'disabled');
              }
          });
      })(x);
      }
  });
</script>
</body>
</html>
