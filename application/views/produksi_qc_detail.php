<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <?php include "include/title.php"?>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php include "include/navbar.php"?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "include/sidebar.php"?>

  <!-- Content Wrapper. Contains page content -->
  <?php foreach($qc_detail->result() as $row) {?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail QC</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
              <li class="breadcrumb-item active">Detail QC</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <div class="row">
                  <div class="col-12">
                    <a href="<?php echo base_url()?>Dashboard/qc_management?id=<?php echo $kode?>" class="btn btn-success btn-sm">Kembali</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <!-- <div class="row">
                  <div class="col-md-12">
                    <h4 style="background-color: lightgreen; padding-left: 5px; padding-bottom: 5px; padding-top: 5px">Detail Revisi</h4>
                    <table class="table table-bordered table-stripped">
                      <thead>
                        <tr>
                          <td>No</td>
                          <td>Keterangan</td>
                          <td>Oleh</td>
                          <td>Pada</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; foreach($this->db->get_where('kbk_sendback', array('id_kbk'=>$row->id_kbk))->result() as $sb){?>
                          <tr>
                            <td><?php echo $no;?></td>
                            <td><?php echo $sb->keterangan?></td>
                            <td><?php echo $sb->created_by?></td>
                            <td><?php echo $sb->date_by?></td>
                          </tr>
                        <?php $no++;}?>
                      </tbody>
                    </table>
                  </div> -->
                  <div class="col-md-12">
                    <div class="col-12 row">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>No KBK</td>
                                    <td>:</td>
                                    <td><?php echo "1-".sprintf("%03d", $row->no_kbk)."/KBK/".$row->kode_perumahan;?></td>
                                </tr>
                                <tr>
                                    <td>Nama Konsumen</td>
                                    <td>:</td>
                                    <td><?php echo $nama_konsumen;?></td>
                                </tr>
                                <tr>
                                    <td>No Unit</td>
                                    <td>:</td>
                                    <td><?php echo $row->unit?></td>
                                </tr>
                                <tr>
                                    <td>Tgl Mulai</td>
                                    <td>:</td>
                                    <td><?php echo date('d F Y', strtotime($row->tgl_mulai))?></td>
                                </tr>
                                <tr>
                                    <td>Tgl Selesai</td>
                                    <td>:</td>
                                    <td><?php echo date('d F Y', strtotime($row->tgl_selesai))?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                        <br>
                    <div class="col-12 row">
                        <div class="col-sm-6">
                            <div style="background-color: lightblue; padding-bottom: 5px; padding-top: 5px; text-align: center">Pihak 1 - Developer</div>
                            <table>
                                <tr>
                                    <td>Nama</td><td>:</td><td><?php echo $row->dev_nama?></td>
                                </tr>
                                <tr>
                                    <td>No. KTP</td><td>:</td><td><?php echo $row->dev_ktp?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td><td>:</td><td><?php echo $row->dev_alamat?></td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td><td>:</td><td><?php echo $row->dev_pekerjaan?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <div style="background-color: lightblue; padding-bottom: 5px; padding-top: 5px; text-align: center">Pihak 2 - Sub Kontraktor</div>
                            <table>
                                <tr>
                                    <td>Nama</td><td>:</td><td><?php echo $row->sub_nama?></td>
                                </tr>
                                <tr>
                                    <td>No. KTP</td><td>:</td><td><?php echo $row->sub_ktp?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td><td>:</td><td><?php echo $row->sub_alamat?></td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td><td>:</td><td><?php echo $row->sub_pekerjaan?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="col-12 row">
                        <div class="col-12" style="background-color: lightblue; padding-bottom: 5px; padding-top: 5px; text-align: center">Ketentuan Pembayaran</div>
                        <table class="table table-bordered" style="font-size: 14px">
                            <thead>
                                <tr>
                                    <th>TERMIN</th>
                                    <th>PROGRESS (%)</th>
                                    <th>REALISASI PROGRESS (%)</th>
                                    <!-- <th>NILAI PEMBAYARAN</th> -->
                                    <th>TANGGAL MULAI</th>
                                    <th>TANGGAL SELESAI</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $tl =0 ;
                                $this->db->order_by('id_termin', "ASC");
                                $previousValue = null;
                                foreach($this->db->get_where('kbk_termin', array('id_kbk'=>$row->id_kbk))->result() as $termin){?>
                                    <tr>
                                        <td><?php echo $termin->tahap?></td>
                                        <td><?php echo $termin->opname?></td>
                                        <td><?php echo $termin->realisasi_progress?></td>
                                        <!-- <td><?php echo "Rp. ".number_format($termin->nilai_pembayaran)?></td> -->
                                        <td>
                                          <?php 
                                          if($termin->tgl_mulai == "0000-00-00"){
                                            echo "-";
                                          } else {
                                            echo date('Y-m-d', strtotime($termin->tgl_mulai));
                                          }?>
                                        </td>
                                        <td>
                                          <?php 
                                          if($termin->tgl_selesai == "0000-00-00"){
                                            echo "-";
                                          } else {
                                            echo date('Y-m-d', strtotime($termin->tgl_selesai));
                                          }?>
                                        </td>
                                        <td>
                                        <?php 
                                        $this->db->order_by('id_qc', "ASC");
                                        $gt = $this->db->get_where('kbk_qc', array('id_termin'=>$termin->id_termin));
                                        $arr = array();
                                        foreach($gt->result() as $gts){
                                            $str = $gts->status_approved;

                                            array_push($arr, $str);
                                        }
                                        $ttl = 0; $ttl_cair = 0;
                                        foreach($this->db->get_where('kbk_pencairan', array('id_termin'=>$termin->id_termin))->result() as $ters){
                                          $ttl = $ttl + $ters->nominal;
                                        }
                                        $ttl_cair = $termin->nilai_pembayaran - $ttl;
                                        // echo $ar;
                                        if($previousValue) {
                                          if($previousValue == "true") {?>
                                            <a href="<?php echo base_url()?>Dashboard/qc_form?id=<?php echo $termin->id_termin?>&ids=<?php echo $termin->id_kbk?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-flat btn-sm btn-outline-primary">Form</a>
                                        <?php } else {
                                          echo "<span style='font-size: 11px; color: red'>Pencairan sebelumnya belum selesai</span>";
                                          }
                                        } else {?>
                                          <a href="<?php echo base_url()?>Dashboard/qc_form?id=<?php echo $termin->id_termin?>&ids=<?php echo $termin->id_kbk?>&kode=<?php echo $row->kode_perumahan?>" class="btn btn-flat btn-sm btn-outline-primary">Form</a>
                                        <?php }
                                        if($ttl_cair == 0){
                                          $previousValue = "true";
                                        } else {
                                          $previousValue = "false";
                                        }?>
                                        
                                        </td>
                                    </tr>
                                <?php $tl = $tl + $termin->nilai_pembayaran;}?>
                                <!-- <tr>
                                    <td colspan=2 style="text-align: center; font-weight: bold">TOTAL</td>
                                    <td><?php echo "Rp. ".number_format($tl)?></td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            
            <?php if(isset($edit_kbk)){?>
                <div class="col-12 card">
                    <div class="card-body">
                        <form action="<?php echo base_url()?>Dashboard/kbk_sendback" method="POST">
                            <div class="row">
                                <div class="col-sm-3">
                                    Keterangan Revisi
                                </div>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="ket"></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                            <input type="hidden" value="<?php echo $id?>" name="id">
                            <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode">
                            <input type="submit" class="btn btn-sm btn-flat btn-success">
                        </form>
                    </div>
                </div>
            <?php }?>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php }?>
  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  
  <?php include "include/footer.php"?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()?>asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url()?>asset/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo base_url()?>asset/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()?>asset/plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/pages/dashboard2.js"></script>
<script type="text/javascript">
function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).on("change", ".qty1", function() {
  var sum = 0;
  $(".qty1").each(function(){
    sum += +$(this).val();
  });
  $(".total").val(numberWithCommas(sum));
  $(".totals").val(sum);
});
</script>
</body>
</html>
