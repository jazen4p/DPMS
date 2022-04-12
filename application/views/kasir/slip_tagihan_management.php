
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
          <h5>Slip Tagihan</h5>
          <?php if(isset($succ_msg)){
            echo "<span style='color: green'>$succ_msg</span>";   
          }?>
          <?php if(isset($err_msg)){
            echo "<span style='color: red'>$err_msg</span>";   
          }?>
        </div>

        <!-- <form role="form" method="POST" action="<?php echo base_url()?>Kasir/edit_data_unit" enctype="multipart/form-data"> -->

          <div class="card-body">
            <form action="<?php echo base_url()?>Kasir/generate_slip_tagihan_auto" method="POST">
              <div class="row">
                <span style="padding-left: 20px; padding-right: 20px">Tgl</span>
                <input type="date" class="form-control col-sm-2" name="bln" value="<?php echo date('Y-m-d')?>" required>
                
                <span style="padding-left: 20px; padding-right: 20px">Perumahan</span>
                <select class="form-control col-sm-3" name="kode_perumahan" required>
                  <option value="" disabled selected>- Pilih - </option>
                  <?php foreach($this->db->get_where('perumahan')->result() as $prmh){?>
                    <option value="<?php echo $prmh->kode_perumahan?>"><?php echo $prmh->nama_perumahan?></option>
                  <?php }?>
                </select>
              </div>

              <br>
              <div class="row">
                <div class="col-sm-6">
                  <input class="btn btn-success btn-sm" type="submit" value="Buat Slip Tagihan Konsumen (Otomatis)">
                </div>
                <div class="col-sm-6" style="text-align: right">
                  <a href="<?php echo base_url()?>Kasir/batal_all_slip_tagihan" class="btn btn-danger btn-sm">Batalkan Semua</a>
                </div>
              </div>
            </form>

            <br>
            <div class="col-sm-12">
                <table class="table table-striped table-bordered" id="ex1" style="font-size: 13px; white-space: nowrap">
                  <thead>
                    <tr>
                      <th>No Struk</th>
                      <th>Tgl Tagihan Dibuat</th>
                      <th>Unit</th>
                      <th>Nama Konsumen</th>
                      <th>HP Konsumen</th>
                      <th>Nominal Tagihan</th>
                      <!-- <th>Pembayaran</th>
                      <th>Jenis Pembayaran</th> -->
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($check_all->result() as $row){?>
                        <tr>
                            <td><?php echo sprintf('%09d', $row->id_struk)?></td>
                            <td><?php echo date('d-m-Y H:i', strtotime($row->tgl_struk))?></td>
                            <td><?php echo $row->kode_rumah?></td>
                            <td><?php echo $row->nama_pemilik?></td>
                            <td><?php echo $row->hp_pemilik?></td>
                            <td><?php echo "Rp. ".number_format($row->grand_total)?></td>
                            <!-- <td><?php echo "Rp. ".number_format($row->pembayaran)?></td>
                            <td><?php echo ucfirst($row->jenis_pembayaran)." "?><?php foreach($this->db->get_where('bank', array('id_bank'=>$row->id_bank))->result() as $banks){echo $banks->nama_bank;}?></td> -->
                            <td><?php echo $row->status?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal1" data-nominal="<?php echo $row->grand_total?>" data-id="<?php echo $row->id_struk?>"><i class="fa fa-check-square"></i> Pelunasan</button>
                                <a href='<?php echo base_url()?>Kasir/print_struk?id=<?php echo $row->id_struk?>' target="_blank" class="btn btn-sm btn-success"><i class="fa fa-file"></i> Print</a>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $row->id_struk?>"><i class="fa fa-list-alt"></i> Detail</button>
                                <!-- <a href="<?php echo base_url()?>Kasir/hapus_slip?id=<?php echo $row->id_struk?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Batal</a> -->
                                <button onclick="myFunction1(<?php echo $row->id_struk?>)" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Batal</button>
                            </td>
                        </tr>
                    <?php }?>
                  </tbody>
                </table>
            </div>
          </div>

          <div class="card-footer" style="text-align: left">
            <!-- <input type="submit" class="btn btn-success btn-sm" value="Update Data Rumah/Unit"> -->
          </div>

        <!-- </form> -->
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

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody id="getDatatableDetail">

                    </tbody>
                </table>
            </div>

            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembayaran Konsumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="<?php echo base_url()?>Kasir/pelunasan_struk" method="POST">
                    <div class="form-group">
                        <label>Cara Pembayaran</label>
                        <select class="form-control" id="caraPembayaran" name="cara_pembayaran" required>
                        <option value="" disabled selected>-Pilih-</option>
                        <option value="transfer">Transfer</option>
                        <option value="cash">Cash</option>
                        <option value="cicilan">Cicilan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bank</label>
                        <input type="hidden" id="bankOpt" name="bank" value="" disabled>
                        <select class="form-control" id="bank" name="bank" required>
                        <option value="" disabled selected>-Pilih-</option>
                        <?php foreach($this->db->get('bank')->result() as $bank){?>
                            <option value="<?php echo $bank->id_bank?>"><?php echo $bank->id_bank." - ".$bank->nama_bank?></option>
                        <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Uang yang diterima</label>
                        <input type="number" class="form-control" value="" id="PembayaranKonsumen" name="nominal_pembayaran" required readonly>
                    </div>
                    <div class="form-group">
                      <label>Keterangan</label>   
                      <textarea class="form-control" name="keterangan"></textarea>
                    </div>
            </div>

            <div class="modal-footer">
                    <input type="hidden" id="idStruk" class="idStruk" name="id_struk">
                    <input type="submit" class="btn btn-success" value="Lunas">
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
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
<script type="text/javascript">
    $('#caraPembayaran').change(function(){
    if($(this).val() == "transfer"){
        $('#bank').removeAttr('disabled');
        $('#bank').attr('required', 'required');

        $('#bankOpt').attr('disabled', 'disabled');
        $('#bankOpt').removeAttr('required');
    } else {
        $('#bankOpt').removeAttr('disabled');
        $('#bankOpt').attr('required', 'required');

        $('#bank').val('');
        $('#bank').attr('disabled', 'disabled');
        $('#bank').removeAttr('required');
    }
    })

    
    function myFunction1(id) {
        var txt;
        var base_url = window.location.origin+"/DPMS/Kasir";
        
        var r = confirm("Anda akan membatalkan slip tagihan ini?");
        if (r == true) {
        window.location.replace(base_url+"/hapus_slip?id="+id);
        } else {
        window.location.replace(base_url+"/data_slip_tagihan");
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
      "order": [[1, "desc"]],
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true
    });
    $('#ex2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
    //   "ordering": true,
    //   "order": [[1, "desc"]],
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

    // $(this).find('.idPSJB').val(myRoomNumber);
    // alert(myRoomNumber);

    $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>Kasir/get_riwayat_struk",
        data: { country : myRoomNumber } 
    }).done(function(data){
        $("#getDatatableDetail").html(data);
    });
  });

  $('#exampleModal1').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-id');
    var nominal = $(e.relatedTarget).attr('data-nominal');

    $(this).find('.idStruk').val(myRoomNumber);
    $(this).find('#PembayaranKonsumen').val(nominal);
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

