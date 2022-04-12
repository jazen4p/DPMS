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
            <h1>Informasi Pengajuan Pembayaran Bahan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Pengajuan Pembayaran</li>
            </ol>
          </div>
        </div>
        <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_informasi_pengajuan_pembayaran" method="POST">
            <div class="row">
              <div class="col-md-6">
                <label>Perumahan</label>
                <select name="perumahan" class="form-control">
                    <option value="">Semua</option>
                    <?php foreach($this->db->get('perumahan')->result() as $perumahan){
                      echo "<option ";
                      if(isset($kode_perumahan)){
                        if($kode_perumahan == $perumahan->kode_perumahan){
                          echo "selected";
                        }
                      }
                      echo " value='$perumahan->kode_perumahan'>$perumahan->nama_perumahan</option>";
                    }?>
                </select>
                <!-- <label>Kategori</label>
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
                </select> -->
              </div>
              <div class="col-md-6">
                <label>Tgl Jatuh Tempo Mulai</label>
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
              <div class="card-header">
                <a href="<?php echo base_url()?>Dashboard/pembayaran_pembelian_bahan" class="btn btn-flat btn-sm btn-success">Buat Pengajuan</a>
              </div>
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped" style="font-size: 14px; ">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Keterangan</th>
                      <th>Perumahan</th>
                      <th>Tanggal Pengajuan</th>
                      <th>Tanggal Jatuh Tempo</th>
                      <th>Diajukan Oleh</th>
                      <th>Status</th>
                      <th>Dibuat pada</th>
                      <!-- <th>Jatuh Tempo</th>
                      <th>Total Pembelian</th> -->
                      <th>Aksi</th>
                      <th>Sign Log</th>
                      <th>Log</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($check_all->result() as $row){?>
                        <tr>
                            <td><?php echo $no?></td>
                            <td style="white-space: nowrap"><?php echo $row->keterangan?></td>
                            <td style="white-space: nowrap"><?php echo $row->kode_perumahan?></td>
                            <td style="white-space: nowrap"><?php echo $row->tgl_aju?></td>
                            <td style="white-space: nowrap"><?php echo $row->tgl_jatuh_tempo?></td>
                            <td style="white-space: nowrap"><?php echo $row->created_by?></td>
                            <td style="white-space: nowrap"><?php echo $row->status?></td>
                            <td style="white-space: nowrap"><?php echo $row->date_by?></td>
                            <td style="white-space: nowrap">
                                <!-- <a href="<?php echo base_url()?>Dashboard/pembayaran_pembelian?id=<?php echo $row->id_transaksi?>" class="btn btn-outline-primary btn-sm btn-flat">Bayar</a> -->
                                <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manajer keuangan"){
                                    if($row->status == "menunggu"){?>
                                        <a href="<?php echo base_url()?>Dashboard/approve_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-sm btn-flat btn-outline-primary">Approve</a>
                                        <a href="<?php echo base_url()?>Dashboard/tolak_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-sm btn-flat btn-outline-primary">Tolak</a>
                                        <a href="<?php echo base_url()?>Dashboard/detail_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                                        <!-- <a href="<?php echo base_url()?>Dashboard/print_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-flat btn-sm btn-outline-primary" target="_blank">Cetak</a> -->
                                <?php } 
                                    else if($row->status == "disetujui"){
                                        $this->db->order_by('no_faktur', "ASC"); 
                                        $total = 0;
                                        foreach($this->db->get_where('produksi_transaksi', array('id_pengajuan'=>$row->id_pengajuan))->result() as $tr){
                                            $total = $total + ($tr->qty*$tr->harga_satuan);
                                        }
                                        $total_pgl = 0;
                                        foreach($this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$tr->no_faktur))->result() as $pgl){
                                            $total_pgl = $total_pgl + $pgl->nominal;
                                        }
                                        // echo $total." ".$total_pgl; ?>
                                          <!-- <button></button> -->
                                        <?php if($row->staff_sign == ""){?>
                                            <button type="button" class="btn btn-flat btn-sm btn-outline-primary" data-toggle="modal" data-target="#staffModal" data-id="<?php echo $row->id_pengajuan?>">Staff Sign</button>
                                        <?php } else {?>  
                                          <?php if($row->manager_sign == ""){?>
                                            <button type="button" class="btn btn-flat btn-sm btn-outline-primary" data-toggle="modal" data-target="#managerModal" data-id="<?php echo $row->id_pengajuan?>">Manager Sign</button>
                                          <?php } else if($row->owner_sign == ""){?>
                                            <button type="button" class="btn btn-flat btn-sm btn-outline-primary" data-toggle="modal" data-target="#ownerModal" data-id="<?php echo $row->id_pengajuan?>">Owner Sign</button>
                                          <?php }?>

                                          <?php 
                                          if($row->owner_sign != "" && $row->manager_sign != "" && $row->staff_sign != ""){
                                            if(($total - $total_pgl) == 0){?>
                                              <a href="<?php echo base_url()?>Dashboard/pelunasan_pengajuan?id=<?php echo $row->id_pengajuan?>" class="btn btn-outline-primary btn-sm btn-flat">Lunas</a>
                                            <?php } else {?>
                                              <a href="<?php echo base_url()?>Dashboard/pembayaran_pengajuan?id=<?php echo $row->id_pengajuan?>" class="btn btn-outline-primary btn-sm btn-flat">Bayar</a>
                                            <?php }
                                          }?>
                                      <?php }?>

                                        <a href="<?php echo base_url()?>Dashboard/detail_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                                        <a href="<?php echo base_url()?>Dashboard/print_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-flat btn-sm btn-outline-primary" target="_blank">Cetak</a>
                                <?php }
                                    else if($row->status == "tolak"){?>
                                        Ditolak 
                                <?php }
                                    else {?>
                                        <a href="<?php echo base_url()?>Dashboard/detail_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                                        <a href="<?php echo base_url()?>Dashboard/print_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-flat btn-sm btn-outline-primary" target="_blank">Cetak</a>
                                <?php }} else {
                                    if($row->status == "tolak"){?>
                                        Ditolak
                                    <?php } else if($row->status == "menunggu"){?>
                                        <a href="<?php echo base_url()?>Dashboard/detail_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                                        <!-- <a href="<?php echo base_url()?>Dashboard/print_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-flat btn-sm btn-outline-primary" target="_blank">Cetak</a> -->
                                    <?php } else if($row->status == "disetujui"){?>
                                      <button type="button" class="btn btn-flat btn-sm btn-outline-primary" data-toggle="modal" data-target="#staffModal" data-id="<?php echo $row->id_pengajuan?>">Staff Sign</button>
                                        <a href="<?php echo base_url()?>Dashboard/detail_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                                        <a href="<?php echo base_url()?>Dashboard/print_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-flat btn-sm btn-outline-primary" target="_blank">Cetak</a>
                                    <?php } else {?>
                                        <button></button>
                                        <a href="<?php echo base_url()?>Dashboard/detail_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                                        <!-- <a href="<?php echo base_url()?>Dashboard/print_pengajuan_pembayaran?id=<?php echo $row->id_pengajuan?>" class="btn btn-flat btn-sm btn-outline-primary" target="_blank">Cetak</a> -->
                                <?php }}?>
                            </td>
                            <td style="white-space: nowrap; font-size: 10px">
                              <?php if($row->staff_sign == ""){
                                echo "Staff sign required!"; 
                              } else if($row->manager_sign == ""){
                                echo "Manager sign required!"; 
                              } else if($row->owner_sign == "") {
                                echo "Owner sign required!"; 
                              } else {
                                echo "Pembayaran dapat dilakukan!"; 
                              }?>
                            </td>
                            <td style="white-space: nowrap; font-size: 10px">
                              Last printed: <?php echo $row->date_print?> <br>
                              Printed: <?php echo $row->count_print?> times
                            </td>
                        </tr>
                    <?php $no++;}?>
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

<div class="modal fade" id="staffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pengajuan Online Signature</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url()?>Dashboard/update_signature_staff_pengajuan" method="POST">
          <div class="col-md-12">
            <label class="" for="">Staff signature:</label>
            <br/>
            <div id="sig3"></div>
            <br/>
            <button type="button" id="clear3" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
            <textarea id="signature643" name="signed3" style="display: none"></textarea>
          </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="id" id="idStaff" class="idStaff">
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

<div class="modal fade" id="managerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pengajuan Online Signature</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url()?>Dashboard/update_signature_manager_pengajuan" method="POST">
          <div class="col-md-12">
            <label class="" for="">Manager signature:</label>
            <br/>
            <div id="sig2"></div>
            <br/>
            <button type="button" id="clear2" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
            <textarea id="signature642" name="signed2" style="display: none"></textarea>
          </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="id" id="idManager" class="idManager">
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

<div class="modal fade" id="ownerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pengajuan Online Signature</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url()?>Dashboard/update_signature_owner_pengajuan" method="POST">
          <div class="col-md-12">
            <label class="" for="">Owner signature:</label>
            <br/>
            <div id="sig1"></div>
            <br/>
            <button type="button" id="clear1" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
            <textarea id="signature641" name="signed1" style="display: none"></textarea>
          </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="id" id="idOwner" class="idOwner">
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
      "responsive": false,
      "scrollX": true
    });
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
  
  $('#staffModal').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-id');

    $(this).find('.idStaff').val(myRoomNumber);
    // alert(myRoomNumber);
  });

  $('#managerModal').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-id');

    $(this).find('.idManager').val(myRoomNumber);
    // alert(myRoomNumber);
  });

  $('#ownerModal').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-id');

    $(this).find('.idOwner').val(myRoomNumber);
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
