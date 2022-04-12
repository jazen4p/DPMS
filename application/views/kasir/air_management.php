
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
              Water Management
              <?php if(isset($k_perumahan)){
                    echo " - ".$k_perumahan;
                }?>
            </h1>
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
        <!-- <div class="card-header">
          <h5>Form Pembuatan Tagihan Air (Belum Tinggal)</h5>
        </div> -->

        <form role="form" method="POST" action="<?php echo base_url()?>Kasir/add_air_belum_tinggal" enctype="multipart/form-data">

          <div class="card-body">
            <div class="col-sm-12 row">
              <!-- <div class="col-sm-3">
                <div class="form-group">
                  <label>Tgl/Bulan Maintenance</label>
                  <input type="date" class="form-control" name="bulan" value="<?php echo date('Y-m-d')?>">
                </div>
                <div class="form-group">
                  <label>Nominal Air (Rp.)</label>
                  <input type="number" class="form-control" name="nominal" value="40000">
                </div>
              </div> -->
              <div class="col-sm-12">
                <h5>Penagihan Air Bulan Ini (<?php echo date('F Y')?>) Beserta Tagihan Sebelumnya yang belum lunas</h5>
                <table class="table table-striped table-bordered" id="ex1" style="font-size: 13px; white-space: nowrap">
                  <thead>
                    <tr>
                      <th>Bulan</th>
                      <th>No Unit</th>
                      <th>Nama Pemilik</th>
                      <th>HP Pemilik</th>
                      <th>Meteran</th>
                      <th>Pemakaian</th>
                      <th>Nominal</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($check_all2->result() as $row){?>
                      <tr>
                        <td><?php echo date('d-m-Y', strtotime($row->bulan_tagihan))?></td>
                        <td><?php echo $row->kode_rumah?></td>
                        <td><?php echo $row->nama_konsumen?></td>
                        <td><?php echo $row->hp_konsumen?></td>
                        <td><?php echo $row->meteran?> m<sup>2</sup></td>
                        <td><?php echo $row->penggunaan_air?> m<sup>2</sup></td>
                        <td><?php echo "Rp. ".number_format($row->total_harga)?></td>
                        <td><?php echo $row->status?></td>
                      </tr>
                    <?php }?>
                    <?php foreach($check_all3->result() as $row1){?>
                      <tr>
                        <td><?php echo date('d-m-Y', strtotime($row1->bulan_tagihan))?></td>
                        <td><?php echo $row1->kode_rumah?></td>
                        <td><?php echo $row1->nama_konsumen?></td>
                        <td><?php echo $row1->hp_konsumen?></td>
                        <td><?php echo $row1->meteran?> m<sup>2</sup></td>
                        <td><?php echo $row1->penggunaan_air?> m<sup>2</sup></td>
                        <td><?php echo "Rp. ".number_format($row1->total_harga)?></td>
                        <td><?php echo $row1->status?></td>
                      </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card-footer" style="text-align: left">
            <!-- <input type="submit" class="btn btn-success btn-sm" value="Buat Tagihan Air Bulan Ini (Konsumen Belum Tinggal)"> -->
          </div>

        </form>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <h5>List Seluruh Tagihan Air Konsumen</h5>
              </div>

              <div class="card-body">
                <!-- <button id="button" class="btn btn-flat btn-info">FILTER</button> -->
                <div id="wrapper" style="">
                  <form action="<?php echo base_url()?>Dashboard/filter_kavling_management" method="POST">
                  Perumahan:
                  <select name="perumahan" class="form-control col-sm-6">
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

                  <input type="submit" class="btn btn-default btn-sm" value="OK">
                  </form>
                </div> <br>

                <form action="<?php echo base_url()?>Kasir/hapus_air" method="POST" enctype="multipart/form-data">
                  <input type="submit" value="Hapus" class="btn btn-success btn-sm">
                  <br><br>

                  <table id="example2" class="table table-bordered table-striped" style="font-size: 13px">
                    <thead>
                      <tr>
                          <th>Aksi</th>
                          <th>No Unit</th>
                          <th>Bulan</th>
                          <th>Nama Pemilik</th>
                          <th>HP Pemilik</th>
                          <th>Meteran</th>
                          <th>Pemakaian</th>
                          <th>Nominal</th>
                          <th>Status</th>
                      </tr>
                    </thead>
                    <tbody style="white-space: nowrap">
                      <?php foreach($check_all->result() as $row2){?>
                          <tr <?php if($row2->status == "lunas"){echo "style='background-color: lightgreen'";} else {echo "style='background-color: pink'";}?>>
                              <td><input type="checkbox" style="width: 20px; height: 20px" name="id_air[]" value="<?php echo $row2->id_air?>"></td>
                              <td><?php echo $row2->kode_rumah?></td>
                              <td><?php echo date('d-m-Y', strtotime($row2->bulan_tagihan))?></td>
                              <td><?php echo $row2->nama_konsumen?></td>
                              <td><?php echo $row2->hp_konsumen?></td>
                              <td><?php echo $row2->meteran?> m<sup>3</sup></td>
                              <td><?php echo $row2->penggunaan_air?> m<sup>3</sup></td>
                              <td>
                                <?php echo "Rp. ".number_format($row2->total_harga)?> m<sup>3</sup>

                                <?php if($row2->status == "belum lunas"){?>
                                  <!-- <input type="number" value="<?php echo $row2->total_harga?>" name="nominal[]">

                                  <input type="hidden" value="<?php echo $row2->id_air?>" name="id_air[]"> -->
                                <?php }?>
                              </td>
                              <td><?php echo $row2->status?></td>
                          </tr>
                      <?php }?>
                    </tfoot>
                  </table>
                </form>
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
      "scrollX": true,
      "scrollY": "300px",
      "order": [[1, "desc"]],
    });
    $('#ex1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "order": [[0, "desc"]],
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "scrollY": "300px"
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

