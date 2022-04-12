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
              Rekap Semua Penerimaan
              <?php if(isset($kode)){
                  echo " - ".$kode;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Rekap Semua Penerimaan</li>
            </ol>
          </div>
        </div>
        <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_laporan_penerimaan_akuntansi" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Perumahan</label>
                  <select name="perumahan" class="form-control">
                      <option value="">Semua</option>
                      <?php foreach($this->db->get('perumahan')->result() as $prmh){
                        echo "<option ";
                        if($kode == $prmh->kode_perumahan){
                          echo "selected";
                        }
                        echo " value='$prmh->kode_perumahan'>$prmh->nama_perumahan</option>";
                      }?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select name="kategori" class="form-control">
                      <option value="">Semua</option>
                      <option value="booking fee" <?php if($kategori == "booking fee"){echo "selected";}?>>Booking Fee</option>
                      <option value="piutang kas" <?php if($kategori == "piutang kas"){echo "selected";}?>>Piutang Kas</option>
                      <option value="ground tank" <?php if($kategori == "ground tank"){echo "selected";}?>>Ground Tank</option>
                      <option value="tambahan bangunan" <?php if($kategori == "tambahan bangunan"){echo "selected";}?>>Tambahan Bangunan</option>
                      <option value="penerimaan lain" <?php if($kategori == "penerimaan lain"){echo "selected";}?>>Penerimaan Lain</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                      <option value="A" <?php if($status == "A"){echo "selected";}?>>Semua</option>
                      <option value="dom" <?php if($status == "dom"){echo "selected";}?>>Approved</option>
                      <option value="revisi" <?php if($status == "revisi"){echo "selected";}?>>Revisi</option>
                      <option value="tutup" <?php if($status == "tutup"){echo "selected";}?>>Menunggu</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Date</label>
                  <input placeholder="Tanggal Awal" value="<?php if(isset($tglmin)){echo $tglmin;}?>" name="tgl_awal" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
                </div>
                <div class="form-group">
                  <label>Sampai</label>
                  <input placeholder="Tanggal Akhir" value="<?php if(isset($tglmax)){echo $tglmax;}?>" name="tgl_akhir" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
                </div>
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
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped" style="font-size: 14px">
                  <div style="text-align: center">
                  </div>
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Bayar</th>
                        <th>Kategori</th>
                        <th>Jenis Terima</th>
                        <th>Terima Dari</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                        <th>Cara Bayar</th>
                        <th>Bank</th>
                        <!-- <th>Status</th> -->
                        <!-- <th>Jmlh Diterima</th> -->
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody style="white-space: nowrap">
                    <?php $no=1; foreach($check_all->result() as $row){ ?>
                      <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $row->tanggal_dana?></td>
                        <td style="white-space: nowrap"><?php echo $row->kategori?></td>
                        <td><?php echo $row->jenis_terima?></td>
                        <td><?php echo $row->terima_dari?></td>
                        <td><?php echo $row->keterangan?></td>
                        <td><?php echo number_format($row->nominal_bayar)?></td>
                        <td><?php echo $row->cara_pembayaran?></td>
                        <td><?php echo $row->nama_bank?></td>
                        <td>
                          <?php 
                            if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager keuangan" || $this->session->userdata('role') == "kepala admin"){
                              $query = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$row->id_keuangan, 'jenis_keuangan'=>"penerimaan"));
                              if($row->status == "dom"){ ?>
                                <?php if($this->session->userdata('role')=="superadmin"){?>
                                <a href="<?php echo base_url()?>Dashboard/revisi_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">REVISI(SUP)</a>
                                <?php }?>
                                <span>Approved</span>
                                <a href="<?php echo base_url()?>Dashboard/akuntansi_detail_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                              <?php } else if($row->status == "tutup"){ ?>
                                <a href="<?php echo base_url()?>Dashboard/akuntansi_approve_penerimaan?id=<?php echo $row->id_keuangan?>" class="btn btn-outline-primary btn-sm btn-flat">Approve</a>
                                <a href="<?php echo base_url()?>Dashboard/akuntansi_view_revisi_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">Revisi</a>
                                <a href="<?php echo base_url()?>Dashboard/akuntansi_detail_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                                <?php ?>
                                  <!-- <button type="button" class="btn btn-outline-primary btn-sm btn-flat" data-toggle="modal" data-target="#exampleModal">Detail</button> -->
                                <?php ?>
                              <?php } else if($row->status == "revisi"){ ?>
                                <a href="<?php echo base_url()?>Dashboard/revisi_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">POST</a>
                                <span>Revisi</span>
                                <!-- <a href="<?php echo base_url()?>Dashboard/akuntansi_penerimaan?id=<?php echo $row->id_keuangan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a> -->
                              <?php } else {?>
                                <a href="<?php echo base_url()?>Dashboard/akuntansi_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">POST</a>
                              <?php }
                            } else {
                              $query = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$row->id_keuangan, 'jenis_keuangan'=>"penerimaan"));
                              if($row->status == "dom"){ ?>
                                <?php if($this->session->userdata('role')=="superadmin"){?>
                                <a href="<?php echo base_url()?>Dashboard/revisi_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">REVISI(SUP)</a>
                                <?php }?>
                                <span>Approved</span>
                                <a href="<?php echo base_url()?>Dashboard/akuntansi_detail_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                              <?php } else if($row->status == "tutup"){ ?>
                                <!-- <a href="<?php echo base_url()?>Dashboard/akuntansi_approve_penerimaan?id=<?php echo $row->id_keuangan?>" class="btn btn-outline-primary btn-sm btn-flat">Approve</a>
                                <a href="<?php echo base_url()?>Dashboard/akuntansi_view_revisi_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">Revisi</a> -->
                                <span>Menunggu</span>
                                <a href="<?php echo base_url()?>Dashboard/akuntansi_detail_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a>
                                <?php ?>
                                  <!-- <button type="button" class="btn btn-outline-primary btn-sm btn-flat" data-toggle="modal" data-target="#exampleModal">Detail</button> -->
                                <?php ?>
                              <?php } else if($row->status == "revisi"){ ?>
                                <a href="<?php echo base_url()?>Dashboard/revisi_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">POST</a>
                                <span>Revisi</span>
                                <!-- <a href="<?php echo base_url()?>Dashboard/akuntansi_penerimaan?id=<?php echo $row->id_keuangan?>" class="btn btn-outline-primary btn-sm btn-flat">Detail</a> -->
                              <?php } else {?>
                                <a href="<?php echo base_url()?>Dashboard/akuntansi_penerimaan?id=<?php echo $row->id_keuangan?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-outline-primary btn-sm btn-flat">POST</a>
                              <?php }
                            }
                          ?>
                        </td>
                        <!-- <td></td> -->
                        <?php 
                        //   $query = $this->db->get_where('ppjb', array('no_psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan));
                        //   foreach($query->result() as $ppjb) {
                            // echo "<td>".$ppjb->tanggal_dana."</td>";
                            // echo "<td>".$ppjb->nama_pemesan."</td>";
                            // echo "<td>".$ppjb->no_kavling."</td>";
                        //   }
                        ?>
                        <!-- <td><?php echo "1-".$row->no_psjb;?></td> -->
                        <!-- <td>Rp. <?php echo number_format($row->dana_masuk)?></td> -->
                        <?php 
                          // foreach($this->db->get_where('ppjb-dp', array('id_psjb'=>$row->id_ppjb))->result() as $dp){
                          //   echo "<td>".number_format($dp->dana_masuk)."</td>";
                          // }
                        ?>
                        <!-- <td>Rp. <?php echo number_format($row->dana_bayar)?></td>
                        <td>Rp. <?php echo number_format($row->dana_sekarang)?></td> -->
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
      "scrollX": true,
      "scrollY": "300px",
      "sDom": '<"top"flp>rt<"bottom"i><"clear">'
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
