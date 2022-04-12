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
          <div class="col-sm-8">
            <h1>
              Kontrak Kerja Tambahan Bangunan (Konsumen)
              <?php if(isset($k_perumahan)){
                  echo " - ".$k_perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Rekap Tambahan Bangunan</li>
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
              <?php if(isset($succ_msg)){?>
                <div class="card-header">
                  <span style="color: green"><?php echo $succ_msg?></span>
                </div>
              <?php }?>
              <!-- /.card-header -->
              <div class="card-body">
                <button id="button" class="btn btn-info btn-flat">FILTER</button>
                <div id="wrapper" style="">
                  <form action="<?php echo base_url()?>Dashboard/filter_tambahan_bangunan_management" method="POST">
                    Perumahan:
                    <select name="perumahan" class="form-control col-sm-6">
                        <option value="">Semua</option>
                        <?php foreach($this->db->get('perumahan')->result() as $prmh){
                            echo "<option ";
                            if(isset($k_perumahan)){
                                if($k_perumahan == $prmh->kode_perumahan){
                                    echo "selected";
                                }
                            }
                            echo " value='$prmh->kode_perumahan'>$prmh->nama_perumahan</option>";
                        }?>
                    </select>
                    <?php if(isset($kode)){?>
                    <br>
                    <span>Pilihan saat ini: <?php echo $kode?></span>
                    <?php }?>
                    <input type="submit" class="btn btn-info btn-flat btn-sm" value="SEARCH">
                  </form>
                </div> <br>
                <table id="example2" class="table table-bordered table-striped" style="font-size: 14px">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Perumahan</th>
                        <th>Nama Pemesan</th>
                        <th>Unit</th>
                        <th>Total Kontrak (Jual)</th>
                        <th>Pembayaran Konsumen</th>
                        <th>Sisa Kontrak</th>
                        <th>Total Upah (Tukang)</th>
                        <th>Pencairan Upah</th>
                        <th>Sisa Upah</th>
                        <th>Pilihan Proses</th>
                        <!-- <th>Log Signature</th> -->
                    </tr>
                  </thead>
                  <tbody style="white-space: nowrap">
                    <?php $no=1; foreach($check_all->result() as $row){?>
                    <tr>
                        <td><?php echo $no?></td>
                        <td>
                          <?php 
                            foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $prmh){
                              echo $prmh->nama_perumahan;
                            }
                          ?>
                        </td>
                        <td>
                            <?php 
                                foreach($this->db->get_where('kbk', array('unit'=>$row->no_unit,'kode_perumahan'=>$row->kode_perumahan))->result() as $kbk){
                                    foreach($this->db->get_where('ppjb', array('id_psjb'=>$kbk->id_ppjb))->result() as $ppjb){
                                        echo $ppjb->nama_pemesan;
                                    }
                                }
                            ?>
                        </td>
                        <!-- <td><?php echo $row->created_by?></td> -->
                        <td><?php echo $row->no_unit?></td>
                        <td>
                          <?php
                            $ttl = 0; 
                            foreach($this->db->get_where('kbk_kontrak_kerja', array('kategori'=>"tambahanbangunan", "status <>"=>"batal", 'kode_perumahan'=>$row->kode_perumahan, 'no_unit'=>$row->no_unit))->result() as $kk){
                              $ttl = $ttl + $kk->harga_jual;
                            }

                            echo "Rp. ".number_format($ttl);
                          ?>
                        </td>
                        <td>
                          <?php
                            $ttl_penerimaan = 0; 
                            $query = $this->db->get_where('keuangan_penerimaan_lain', array('kategori'=>"tambahan bangunan", 'kode_rumah'=>$row->no_unit, 'kode_perumahan'=>$row->kode_perumahan));
                            foreach($query->result() as $trm){
                              $ttl_penerimaan = $ttl_penerimaan + $trm->dana_terima;
                            }

                            echo "Rp. ".number_format($ttl_penerimaan);
                          ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($ttl - $ttl_penerimaan)?></td>
                        <td>
                          <?php
                            $ttl1 = 0; 
                            $ttl_pencairan = 0; 
                            foreach($this->db->get_where('kbk_kontrak_kerja', array('kategori'=>"tambahanbangunan", "status <>"=>"batal", 'kode_perumahan'=>$row->kode_perumahan, 'no_unit'=>$row->no_unit))->result() as $kk){
                              $ttl1 = $ttl1 + $kk->nilai_kontrak;

                              foreach($this->db->get_where('kbk_pencairan_kontrak', array('id_kontrak'=>$kk->id_kontrak))->result() as $pcr){
                                $ttl_pencairan = $ttl_pencairan + $pcr->nominal;
                              }
                            }

                            echo "Rp. ".number_format($ttl1);
                          ?>
                        </td>
                        <td>
                          <?php
                            // $query = $this->db->get_where('kbk_pencairan_kontrak', array('kategori'=>"tambahanbangunan", 'kode_rumah'=>$row->no_unit, 'kode_perumahan'=>$row->kode_perumahan));
                            // foreach($query->result() as $trm){
                            //   $ttl_penerimaan = $ttl_penerimaan + $trm->dana_terima;
                            // }

                            echo "Rp. ".number_format($ttl_pencairan);
                          ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($ttl1 - $ttl_pencairan)?></td>
                        <td>
                          <a class="btn btn-outline-primary btn-flat btn-sm" target="_blank" href="<?php echo base_url()?>Dashboard/print_kontrak_tambahan_bangunan?id=<?php echo $row->no_unit?>&kode=<?php echo $row->kode_perumahan?>">Cetak</a>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PSJB Online Signature</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url()?>Dashboard/update_signature_psjb" method="POST">
          <div class="col-md-12">
            <label class="" for="">Marketing signature:</label>
            <br/>
            <div id="sig"></div>
            <br/>
            <button type="button" id="clear" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
            <textarea id="signature64" name="signed" style="display: none"></textarea>
          </div> <br>
          <div class="col-md-12">
            <label class="" for="">Customer signature:</label>
            <br/>
            <div id="sig1"></div>
            <br/>
            <button type="button" id="clear1" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
            <textarea id="signature641" name="signed1" style="display: none"></textarea>
          </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="id" id="idPSJB" class="idPSJB">
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
</script>
</body>
</html>
