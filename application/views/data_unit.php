
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
          </div>
          <div class="col-sm-6">
            <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">PPJB</li>
            </ol> -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h5>Data Kepemilikan Unit Rumah</h5>
          <?php if(isset($succ_msg)){
            echo "<span style='color: green'>$succ_msg</span>";   
          }?>
        </div>

        <form role="form" method="POST" action="<?php echo base_url()?>Kasir/edit_data_unit" enctype="multipart/form-data">

          <div class="card-body">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered" id="ex1" style="font-size: 13px; white-space: nowrap">
                  <thead>
                    <tr>
                      <th>No Unit</th>
                      <th>Nama Pemilik</th>
                      <th>HP Pemilik</th>
                      <th>Status Tinggal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($check_all->result() as $row){
                        foreach($this->db->get_where('kbk', array('id_kbk'=>$row->id_kbk))->result() as $kbk){
                            $unit = explode(", ", $kbk->unit);
        
                            $count = count($unit);
        
                            for($i=0; $i < $count; $i++){
                                $check_unit_rumah = $this->db->get_where('rumah', array('kode_rumah'=>$unit[$i], 'kode_perumahan'=>$kbk->kode_perumahan, 'tipe_produk'=>"rumah"));
                                // echo "<option value='".$unit[$i]."'>".$unit[$i]."</option>";
                                foreach($check_unit_rumah->result() as $rws){?>
                                    <tr>
                                      <td>
                                        <?php echo $rws->kode_rumah?>
                                        <input type="hidden" name="kode_rumah[]" value="<?php echo $rws->kode_rumah?>">
                                        <input type="hidden" name="kode_perumahan[]" value="<?php echo $rws->kode_perumahan?>">
                                        <input type="hidden" name="id_rumah[]" value="<?php echo $rws->id_rumah?>">
                                      </td>
                                      <td>
                                        <?php echo $rws->nama_pemilik?>
                                        <input type="text" name="nama_pemilik[]" value="<?php echo $rws->nama_pemilik?>">
                                      </td>
                                      <td>
                                        <?php echo $rws->hp_pemilik?>
                                        <input type="text" name="hp_pemilik[]" value="<?php echo $rws->hp_pemilik?>">
                                      </td>
                                      <td>
                                        <?php echo $rws->status_tinggal?>
                                        <select name="status_tinggal[]" required>
                                            <option value="" disabled selected>-Pilih-</option>
                                            <option value="tinggal" <?php if($rws->status_tinggal == "tinggal"){echo "selected";}?>>Tinggal</option>
                                            <option value="belum tinggal" <?php if($rws->status_tinggal == "belum tinggal"){echo "selected";}?>>Belum Tinggal</option>
                                        </select>
                                      </td>
                                    </tr>
                                <?php }
                            }
                        }
                    }?>
                  </tbody>
                </table>
            </div>
          </div>

          <div class="card-footer" style="text-align: left">
            <input type="submit" class="btn btn-success btn-sm" value="Update Data Rumah/Unit">
          </div>

        </form>
      </div>
    </div>
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
  var r = confirm("Anda akan menetapkan PPJB ini di approve?");
  if (r == true) {
    window.location.replace(base_url+"/kavling_approve?id="+id);
  } else {
    window.location.replace(base_url+"/kavling_management")
  }
  document.getElementById("demo").innerHTML = txt;
}

function myFunction1(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PPJB ini dibatalkan?");
  if (r == true) {
    window.location.replace(base_url+"/kavling_pembatalan?id="+id);
  } else {
    window.location.replace(base_url+"/kavling_management")
  }
  document.getElementById("demo").innerHTML = txt;
}

function pembatalanPPJB(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PPJB ini dibatalkan?");
  if (r == true) {
    window.location.replace(base_url+"/kavling_pembatalan?id="+id);
  } else {
    window.location.replace(base_url+"/kavling_management")
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
    $('#ex1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
    //   "order": [[0, "desc"]],
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

    $(this).find('.idPSJB').val(myRoomNumber);
    // alert(myRoomNumber);
  });

  $('#exampleModal2').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-id');

    $(this).find('.idPSJB').val(myRoomNumber);
    // alert(myRoomNumber);
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

